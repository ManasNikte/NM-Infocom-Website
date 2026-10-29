<?php
/**
 * Outgoing email over SMTP (PHPMailer), configured through config/app.php:
 * SMTP_HOST, SMTP_PORT, SMTP_SECURE, SMTP_USER, SMTP_PASS, MAIL_FROM, MAIL_FROM_NAME.
 */
require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/app.php';

use PHPMailer\PHPMailer\Exception as MailException;
use PHPMailer\PHPMailer\PHPMailer;

/**
 * @return true|string true when sent, otherwise an error message (logged, safe to show to an admin).
 */
function nm_send_mail($toEmail, $toName, $subject, $html, $text) {
    $host = nm_config('SMTP_HOST');
    if (!$host) {
        return 'Email is not configured on the server (SMTP_HOST is missing).';
    }
    $mail = new PHPMailer(true);
    try {
        $mail->isSMTP();
        $mail->Host = $host;
        $mail->Port = (int) nm_config('SMTP_PORT', 587);
        $secure = strtolower((string) nm_config('SMTP_SECURE', 'tls'));
        $mail->SMTPSecure = $secure === 'ssl' ? PHPMailer::ENCRYPTION_SMTPS : ($secure === 'tls' ? PHPMailer::ENCRYPTION_STARTTLS : '');
        $mail->SMTPAutoTLS = $secure !== '';
        $user = nm_config('SMTP_USER');
        if ($user) {
            $mail->SMTPAuth = true;
            $mail->Username = $user;
            $mail->Password = (string) nm_config('SMTP_PASS', '');
        }
        $mail->Timeout = 15;
        $mail->CharSet = PHPMailer::CHARSET_UTF8;
        $from = nm_config('MAIL_FROM', $user ?: 'mcnikte@nminfocom.com');
        $mail->setFrom($from, nm_config('MAIL_FROM_NAME', 'NM INFOCOM'));
        $mail->addReplyTo('mcnikte@nminfocom.com', 'NM INFOCOM');
        $mail->addAddress($toEmail, $toName);
        $mail->isHTML(true);
        $mail->Subject = $subject;
        $mail->Body = $html;
        $mail->AltBody = $text;
        $mail->send();
        return true;
    } catch (MailException $e) {
        error_log('nm_send_mail to ' . $toEmail . ' failed: ' . $mail->ErrorInfo);
        return 'The email could not be sent (' . $mail->ErrorInfo . ').';
    }
}

/** Wraps notification content in the NM INFOCOM email frame. $bodyHtml must already be escaped. */
function nm_mail_template($heading, $bodyHtml) {
    $crmUrl = rtrim((string) nm_config('APP_URL', ''), '/') . '/CRM/index.html';
    $e = fn ($v) => htmlspecialchars((string) $v, ENT_QUOTES);
    return '<div style="font-family:Arial,Helvetica,sans-serif;max-width:560px;margin:0 auto;color:#1f2937">'
        . '<div style="background:#0b1430;color:#fff;padding:16px 20px;border-radius:10px 10px 0 0;font-weight:bold;font-size:16px">NM <span style="color:#60a5fa">INFOCOM</span> CRM</div>'
        . '<div style="border:1px solid #e5e9f2;border-top:0;padding:20px;border-radius:0 0 10px 10px">'
        . '<h2 style="color:#0b1430;margin:0 0 12px;font-size:19px">' . $e($heading) . '</h2>' . $bodyHtml
        . (preg_match('#^https?://#', $crmUrl) ? '<p style="margin:20px 0 0"><a href="' . $e($crmUrl) . '" style="background:#2563eb;color:#fff;padding:10px 16px;border-radius:8px;text-decoration:none;font-weight:bold">Open the CRM</a></p>' : '')
        . '<p style="color:#94a3b8;font-size:12px;margin:20px 0 0">Automatic message from the NM INFOCOM CRM.</p></div></div>';
}

/**
 * Best-effort email to CRM users by id: a failed send is logged and never blocks the action that triggered it.
 * @return int number of emails sent
 */
function nm_notify_users(PDO $conn, array $userIds, $subject, $heading, $bodyHtml, $text) {
    $userIds = array_values(array_unique(array_filter(array_map('intval', $userIds))));
    if (!$userIds) {
        return 0;
    }
    $stmt = $conn->prepare('SELECT name, email FROM users WHERE id IN (' . implode(',', array_fill(0, count($userIds), '?')) . ")
                            AND email <> '' AND (status = 'active' OR status IS NULL)");
    $stmt->execute($userIds);
    $sent = 0;
    foreach ($stmt->fetchAll(PDO::FETCH_ASSOC) as $u) {
        if (nm_send_mail($u['email'], $u['name'], $subject, nm_mail_template($heading, $bodyHtml), $text) === true) {
            $sent++;
        }
    }
    return $sent;
}
