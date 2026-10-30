<?php
/**
 * Lead edits shared by the admin Leads page and the sales manager's Sales Data page.
 * The calling endpoint checks access first, then calls crm_lead_update('status' | 'response' | 'assign' | 'remarks' | 'lead').
 */
require_once __DIR__ . '/../config/auth.php';

const CRM_LEAD_STATUSES = ['new', 'connected', 'not connected', 'confused', 'closed'];
const CRM_LEAD_RESPONSES = ['positive', 'negative'];

function crm_lead_reply($ok, $message, $code = 200) {
    http_response_code($code);
    echo json_encode(['success' => $ok, 'message' => $message]);
    exit;
}

function crm_lead_update($kind) {
    header('Content-Type: application/json');
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        crm_lead_reply(false, 'Method not allowed', 405);
    }
    $leadId = (int) ltrim((string) ($_POST['lead_id'] ?? ''), 'Ll');
    if ($leadId <= 0) {
        crm_lead_reply(false, 'Missing lead', 400);
    }
    try {
        $conn = (new Database())->getConnection();
        $exists = $conn->prepare('SELECT COUNT(*) FROM leads WHERE lead_id = ?');
        $exists->execute([$leadId]);
        if (!$exists->fetchColumn()) {
            crm_lead_reply(false, 'Lead not found', 404);
        }
        switch ($kind) {
            case 'status':
                $status = strtolower(trim((string) ($_POST['status'] ?? '')));
                if (!in_array($status, CRM_LEAD_STATUSES, true)) {
                    crm_lead_reply(false, 'Unknown status', 422);
                }
                $conn->prepare('UPDATE leads SET status = ?, modified = NOW() WHERE lead_id = ?')->execute([$status, $leadId]);
                crm_lead_reply(true, 'Status updated successfully');
            case 'response':
                $response = strtolower(trim((string) ($_POST['response'] ?? '')));
                if ($response !== '' && !in_array($response, CRM_LEAD_RESPONSES, true)) {
                    crm_lead_reply(false, 'Unknown response', 422);
                }
                $conn->prepare('UPDATE leads SET response = ?, modified = NOW() WHERE lead_id = ?')->execute([$response ?: null, $leadId]);
                crm_lead_reply(true, 'Response updated successfully');
            case 'assign':
                // Leads go to active sales employees only.
                $to = (int) ($_POST['assigned_to'] ?? 0);
                $ok = $conn->prepare("SELECT COUNT(*) FROM users WHERE id = ? AND role = 'Employee' AND sub_role = 'sales' AND (status = 'active' OR status IS NULL)");
                $ok->execute([$to]);
                if (!$ok->fetchColumn()) {
                    crm_lead_reply(false, 'Choose an active sales employee', 422);
                }
                $conn->prepare('UPDATE leads SET assigned_to = ?, modified = NOW() WHERE lead_id = ?')->execute([$to, $leadId]);
                crm_lead_reply(true, 'Lead assigned successfully');
            case 'remarks':
                $remarks = mb_substr(trim((string) ($_POST['remarks'] ?? '')), 0, 500);
                $conn->prepare('UPDATE leads SET remarks = ?, modified = NOW() WHERE lead_id = ?')->execute([$remarks, $leadId]);
                crm_lead_reply(true, 'Remarks updated successfully');
            case 'lead':
                $name = trim((string) ($_POST['name'] ?? ''));
                $contact = trim((string) ($_POST['contact'] ?? ''));
                $email = trim((string) ($_POST['email'] ?? ''));
                $product = trim((string) ($_POST['product'] ?? ''));
                $quantity = max(1, (int) ($_POST['quantity'] ?? 1));
                if ($name === '' || $contact === '' || $product === '') {
                    crm_lead_reply(false, 'Name, contact and product are required', 422);
                }
                if ($email !== '' && !filter_var($email, FILTER_VALIDATE_EMAIL)) {
                    crm_lead_reply(false, 'Invalid email address', 422);
                }
                $conn->prepare('UPDATE leads SET name = ?, contact = ?, email = ?, product = ?, quantity = ?, modified = NOW() WHERE lead_id = ?')
                     ->execute([mb_substr($name, 0, 120), mb_substr($contact, 0, 30), $email, mb_substr($product, 0, 120), $quantity, $leadId]);
                crm_lead_reply(true, 'Lead updated successfully');
        }
        crm_lead_reply(false, 'Unknown action', 400);
    } catch (Exception $e) {
        crm_lead_reply(false, crm_public_error($e), 500);
    }
}
