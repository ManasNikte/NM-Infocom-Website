<?php
// Open roles for the public Careers page (jobs whose application deadline hasn't passed).
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../config/format.php';

function nm_open_jobs(PDO $conn) {
    $jobs = $conn->query('SELECT * FROM careers WHERE deadline >= CURDATE() ORDER BY date_posted DESC, id DESC')->fetchAll(PDO::FETCH_ASSOC);
    foreach ($jobs as &$job) {
        // Rupees only; a salary saved in another currency before this check is hidden rather than shown wrong.
        $job['salary'] = nm_salary_inr($job['salary']) ?? '';
        foreach (['skills', 'responsibilities', 'requirements'] as $field) {
            $list = json_decode((string) $job[$field], true);
            // Drop the "Skill 1" style placeholders the old job form inserted.
            $job[$field] = array_values(array_filter(is_array($list) ? $list : [], fn ($v) => is_string($v) && trim($v) !== '' && !preg_match('/^(skill|item)\s*\d+$/i', trim($v))));
        }
    }
    return $jobs;
}

/** category_id => display name */
function nm_job_categories(PDO $conn) {
    return $conn->query('SELECT category_id, name FROM career_categories ORDER BY name')->fetchAll(PDO::FETCH_KEY_PAIR);
}
