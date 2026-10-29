<?php
// Blog editor endpoint for the website manager (CRM/manager/website/blogs.php).
//   GET  ?id=N                          -> one post (for the edit form)
//   POST action=save   (id optional)    -> create / update; multipart "image" for the cover
//   POST action=status id, status       -> Approved | Pending | Rejected
//   POST action=delete id
require_once __DIR__ . '/../../../config/auth.php';
require_once __DIR__ . '/../../../config/uploads.php';
require_once __DIR__ . '/../../../../data/blog_lib.php';
$auth = crm_require_api(['Admin', 'Manager'], 'website');
header('Content-Type: application/json');

function blog_reply($ok, $message, array $extra = []) {
    echo json_encode(['success' => $ok, 'message' => $message] + $extra);
    exit;
}

$conn = (new Database())->getConnection();
$statuses = ['Approved', 'Pending', 'Rejected'];

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $stmt = $conn->prepare('SELECT blog_id, blog_title, blog_excerpt, blog_content, blog_author, blog_img, blog_category_label, blog_status, is_featured FROM blogs WHERE blog_id = ?');
    $stmt->execute([(int) ($_GET['id'] ?? 0)]);
    $post = $stmt->fetch(PDO::FETCH_ASSOC);
    $post ? blog_reply(true, 'ok', ['post' => $post]) : blog_reply(false, 'Post not found.');
}

$action = $_POST['action'] ?? '';
$id = (int) ($_POST['id'] ?? 0);

try {
    if ($action === 'status') {
        $status = $_POST['status'] ?? '';
        if (!in_array($status, $statuses, true)) {
            blog_reply(false, 'Invalid status.');
        }
        $conn->prepare('UPDATE blogs SET blog_status = ? WHERE blog_id = ?')->execute([$status, $id]);
        blog_reply(true, 'Status updated.');
    }

    if ($action === 'delete') {
        $stmt = $conn->prepare('SELECT blog_img FROM blogs WHERE blog_id = ?');
        $stmt->execute([$id]);
        $img = $stmt->fetchColumn();
        $conn->prepare('DELETE FROM blog_comments WHERE blog_id = ?')->execute([$id]);
        $conn->prepare('DELETE FROM blogs WHERE blog_id = ?')->execute([$id]);
        if ($img && str_starts_with($img, 'uploads/blog/')) {
            crm_delete_upload($img, 'blog');
        }
        blog_reply(true, 'Post deleted.');
    }

    if ($action !== 'save') {
        blog_reply(false, 'Unknown action.');
    }

    $title = trim($_POST['title'] ?? '');
    $author = trim($_POST['author'] ?? '');
    $category = trim($_POST['category'] ?? '');
    $excerpt = trim($_POST['excerpt'] ?? '');
    $content = trim($_POST['content'] ?? '');
    $status = $_POST['status'] ?? 'Pending';
    $featured = !empty($_POST['featured']) ? 1 : 0;
    if ($title === '' || $author === '' || $category === '' || $excerpt === '') {
        blog_reply(false, 'Title, author, topic and summary are required.');
    }
    if (mb_strlen($title) > 255 || mb_strlen($author) > 100 || mb_strlen($category) > 50) {
        blog_reply(false, 'Title, author or topic is too long.');
    }
    if (!in_array($status, $statuses, true)) {
        $status = 'Pending';
    }

    $image = null;
    if (isset($_FILES['image']) && $_FILES['image']['error'] !== UPLOAD_ERR_NO_FILE) {
        try {
            $image = 'uploads/blog/' . crm_store_upload($_FILES['image'], 'blog', 'blog_', CRM_IMAGE_TYPES, 5 * 1024 * 1024);
        } catch (RuntimeException $e) {
            blog_reply(false, 'Cover image: ' . $e->getMessage());
        }
    }

    $readTime = nm_read_time($content !== '' ? $content : $excerpt);
    if ($featured) {
        $conn->exec('UPDATE blogs SET is_featured = 0'); // a single featured post at a time
    }

    if ($id) {
        $old = $conn->prepare('SELECT blog_img FROM blogs WHERE blog_id = ?');
        $old->execute([$id]);
        $oldImage = $old->fetchColumn();
        if ($oldImage === false) {
            blog_reply(false, 'Post not found.');
        }
        $conn->prepare('UPDATE blogs SET blog_title = ?, blog_author = ?, blog_category = ?, blog_category_label = ?, blog_excerpt = ?,
                        blog_content = ?, blog_status = ?, is_featured = ?, read_time = ?' . ($image ? ', blog_img = ?' : '') . ' WHERE blog_id = ?')
             ->execute(array_merge([$title, $author, nm_blog_slug($category), $category, $excerpt, $content, $status, $featured, $readTime],
                                   $image ? [$image] : [], [$id]));
        if ($image && $oldImage && str_starts_with($oldImage, 'uploads/blog/')) {
            crm_delete_upload($oldImage, 'blog');
        }
        blog_reply(true, 'Post updated.', ['id' => $id]);
    }

    if (!$image) {
        blog_reply(false, 'Please add a cover image.');
    }
    $conn->prepare('INSERT INTO blogs (blog_title, blog_author, blog_category, blog_category_label, blog_excerpt, blog_content, blog_img, blog_status, is_featured, read_time)
                    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)')
         ->execute([$title, $author, nm_blog_slug($category), $category, $excerpt, $content, $image, $status, $featured, $readTime]);
    blog_reply(true, 'Post created.', ['id' => (int) $conn->lastInsertId()]);
} catch (Exception $e) {
    error_log('blogs_admin: ' . $e->getMessage());
    blog_reply(false, 'Could not save the post.');
}
