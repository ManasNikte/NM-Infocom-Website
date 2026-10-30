<?php
/**
 * Create / update / delete for the website content editors (team, stats, why-us cards, FAQs, client logos,
 * hero slides, site details). Each resource lists exactly which table and columns may be written; nothing else can.
 *
 * POST resource=<name> action=save   [id] + field values (+ optional image file)
 * POST resource=<name> action=delete id
 */
require_once __DIR__ . '/../../../config/auth.php';
$auth = crm_require_api(['Admin', 'Manager'], 'website');
require_once __DIR__ . '/../../../config/uploads.php';
header('Content-Type: application/json');

// field => [type, required, max length / options]
const CONTENT_RESOURCES = [
    'team' => ['table' => 'team_members', 'pk' => 'emp_id', 'pk_prefix' => 'EMP', 'image' => ['emp_img', 'team'], 'image_required' => true,
               'fields' => ['emp_name' => ['text', true, 120], 'emp_post' => ['text', true, 120], 'status' => ['enum', true, ['active', 'inactive']],
                            'linkedin_link' => ['url', false, 255], 'x_link' => ['url', false, 255], 'insta_link' => ['url', false, 255],
                            'github_link' => ['url', false, 255], 'web_link' => ['url', false, 255]],
               'created' => ['date_added' => 'CURDATE()']],
    'stats' => ['table' => 'stats_total', 'pk' => 'stats_id',
                'fields' => ['stat' => ['text', true, 50], 'counts' => ['int', true, 100000000]],
                'created' => ['date_added' => 'NOW()'], 'updated' => ['last_modified' => 'NOW()']],
    'why_us' => ['table' => 'why_us', 'pk' => 'whyus_id',
                 'fields' => ['whyus_card_number' => ['text', true, 10], 'whyus_title' => ['text', true, 120], 'whyus_description' => ['textarea', true, 1000]]],
    'faqs' => ['table' => 'faqs', 'pk' => 'faq_id',
               'fields' => ['faq_title' => ['text', true, 255], 'faq_description' => ['textarea', true, 3000], 'category' => ['text', false, 50],
                            'display_order' => ['int', false, 10000], 'status' => ['enum', true, ['active', 'inactive']]],
               'created' => ['date_added' => 'CURDATE()']],
    'clients' => ['table' => 'clients', 'pk' => 'client_id', 'image' => ['client_img', 'clients'], 'image_required' => true,
                  'fields' => ['client_name' => ['text', true, 120]]],
    'hero_slides' => ['table' => 'hero_slides', 'pk' => 'slide_id', 'image' => ['slide_img', 'hero'], 'image_required' => true,
                      'fields' => ['slide_title' => ['text', true, 255], 'slide_description' => ['textarea', false, 1000], 'link' => ['url', false, 255],
                                   'display_order' => ['int', false, 10000]],
                      'created' => ['date_added' => 'NOW()'], 'updated' => ['last_modified' => 'NOW()']],
    'web_data' => ['table' => 'web_data', 'pk' => 'web_id', 'no_create' => true, 'no_delete' => true,
                   'fields' => ['site_name' => ['text', true, 255], 'whyus_introline' => ['textarea', false, 1000], 'team_introline' => ['textarea', false, 1000],
                                'address' => ['textarea', false, 500], 'contact_no' => ['text', false, 20], 'email' => ['email', false, 255],
                                'map_link' => ['url', false, 2000], 'twitter_link' => ['url', false, 255], 'facebook_link' => ['url', false, 255],
                                'instagram_link' => ['url', false, 255], 'linkedin_link' => ['url', false, 255]]],
];

function content_reply($ok, $message, array $extra = [], $code = 200) {
    http_response_code($code);
    echo json_encode(['success' => $ok, 'message' => $message] + $extra);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    content_reply(false, 'POST only', [], 405);
}
$cfg = CONTENT_RESOURCES[$_POST['resource'] ?? ''] ?? null;
if (!$cfg) {
    content_reply(false, 'Unknown section', [], 400);
}
$action = $_POST['action'] ?? '';
$id = trim((string) ($_POST['id'] ?? ''));
$table = $cfg['table'];
$pk = $cfg['pk'];

try {
    $conn = (new Database())->getConnection();
    $current = null;
    if ($id !== '') {
        $stmt = $conn->prepare("SELECT * FROM `$table` WHERE `$pk` = ?");
        $stmt->execute([$id]);
        $current = $stmt->fetch(PDO::FETCH_ASSOC) ?: null;
        if (!$current) {
            content_reply(false, 'This item no longer exists. Refresh the page.', [], 404);
        }
    }

    if ($action === 'delete') {
        if (!empty($cfg['no_delete']) || !$current) {
            content_reply(false, 'This item cannot be deleted', [], 400);
        }
        $conn->prepare("DELETE FROM `$table` WHERE `$pk` = ?")->execute([$id]);
        if (!empty($cfg['image']) && str_starts_with((string) $current[$cfg['image'][0]], 'uploads/')) {
            crm_delete_upload($current[$cfg['image'][0]], $cfg['image'][1]);
        }
        content_reply(true, 'Deleted');
    }
    if ($action !== 'save') {
        content_reply(false, 'Unknown action', [], 400);
    }
    if (!$current && !empty($cfg['no_create'])) {
        content_reply(false, 'Only editing is possible here', [], 400);
    }

    // Validate every allowed field; ignore anything else that was posted.
    $values = [];
    foreach ($cfg['fields'] as $field => [$type, $required, $rule]) {
        $raw = trim((string) ($_POST[$field] ?? ''));
        if ($raw === '') {
            if ($required) {
                content_reply(false, 'Please fill in: ' . str_replace('_', ' ', $field), [], 422);
            }
            $values[$field] = $type === 'int' ? 0 : ''; // several columns are NOT NULL without a default
            continue;
        }
        switch ($type) {
            case 'int':
                if (!preg_match('/^\d+$/', $raw) || (int) $raw > $rule) {
                    content_reply(false, ucfirst(str_replace('_', ' ', $field)) . ' must be a whole number', [], 422);
                }
                $values[$field] = (int) $raw;
                break;
            case 'enum':
                if (!in_array($raw, $rule, true)) {
                    content_reply(false, 'Invalid ' . str_replace('_', ' ', $field), [], 422);
                }
                $values[$field] = $raw;
                break;
            case 'url':
                if (!preg_match('#^https?://#i', $raw) || !filter_var($raw, FILTER_VALIDATE_URL)) {
                    content_reply(false, ucfirst(str_replace('_', ' ', $field)) . ' must be a full link starting with https://', [], 422);
                }
                $values[$field] = mb_substr($raw, 0, $rule);
                break;
            case 'email':
                if (!filter_var($raw, FILTER_VALIDATE_EMAIL)) {
                    content_reply(false, 'Invalid email address', [], 422);
                }
                $values[$field] = $raw;
                break;
            default:
                $values[$field] = mb_substr($raw, 0, $rule);
        }
    }

    // Optional image: stored first, the old file is removed only after the database update succeeds.
    $newImage = null;
    if (!empty($cfg['image'])) {
        [$imgField, $imgDir] = $cfg['image'];
        if (!empty($_FILES['image']) && $_FILES['image']['error'] !== UPLOAD_ERR_NO_FILE) {
            try {
                $newImage = 'uploads/' . $imgDir . '/' . crm_store_upload($_FILES['image'], $imgDir, strtoupper($imgDir) . '_', CRM_IMAGE_TYPES, 5 * 1024 * 1024);
            } catch (RuntimeException $e) {
                content_reply(false, 'Image: ' . $e->getMessage(), [], 422);
            }
            $values[$imgField] = $newImage;
        } elseif (!$current && !empty($cfg['image_required'])) {
            content_reply(false, 'Please choose an image', [], 422);
        }
    }

    $cols = array_keys($values);
    if ($current) {
        $set = implode(', ', array_map(fn ($c) => "`$c` = ?", $cols));
        foreach ($cfg['updated'] ?? [] as $c => $expr) {
            $set .= ", `$c` = $expr";
        }
        $conn->prepare("UPDATE `$table` SET $set WHERE `$pk` = ?")->execute([...array_values($values), $id]);
        $savedId = $id;
    } else {
        $extraCols = $cfg['created'] ?? [];
        if (!empty($cfg['pk_prefix'])) {
            // Text keys like EMP003: next number after the highest existing one.
            $max = $conn->query("SELECT MAX(CAST(SUBSTRING(`$pk`, " . (strlen($cfg['pk_prefix']) + 1) . ") AS UNSIGNED)) FROM `$table`")->fetchColumn();
            $values = [$pk => $cfg['pk_prefix'] . str_pad((string) ((int) $max + 1), 3, '0', STR_PAD_LEFT)] + $values;
            $cols = array_keys($values);
        }
        $sql = "INSERT INTO `$table` (" . implode(', ', array_map(fn ($c) => "`$c`", array_merge($cols, array_keys($extraCols)))) . ') VALUES ('
             . implode(', ', array_merge(array_fill(0, count($cols), '?'), array_values($extraCols))) . ')';
        $conn->prepare($sql)->execute(array_values($values));
        $savedId = $values[$pk] ?? $conn->lastInsertId();
    }
    if ($newImage && $current && str_starts_with((string) $current[$cfg['image'][0]], 'uploads/')) {
        crm_delete_upload($current[$cfg['image'][0]], $cfg['image'][1]);
    }
    content_reply(true, $current ? 'Saved' : 'Added', ['id' => $savedId]);
} catch (Exception $e) {
    if (!empty($newImage)) {
        crm_delete_upload($newImage, $cfg['image'][1]);
    }
    content_reply(false, crm_public_error($e), [], 500);
}
