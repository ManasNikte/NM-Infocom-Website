<?php
// Formatting helpers shared by the public site and the CRM.

/** 1234567 -> "12,34,567" (Indian digit grouping). */
function nm_inr_number($digits) {
    $digits = ltrim((string) $digits, '0') ?: '0';
    if (strlen($digits) <= 3) {
        return $digits;
    }
    $last3 = substr($digits, -3);
    $rest = substr($digits, 0, -3);
    return preg_replace('/\B(?=(\d{2})+(?!\d))/', ',', $rest) . ',' . $last3;
}

/**
 * Normalises a salary to Indian rupees: "Rs. 25000 - Rs. 40000 per month" -> "₹25,000 - ₹40,000 per month".
 * Text without amounts ("Negotiable", "As per industry standards") is kept as written.
 *
 * @return string|null null when the salary is in another currency (USD, EUR, ...).
 */
function nm_salary_inr($salary) {
    $text = trim(preg_replace('/\s+/u', ' ', (string) $salary));
    if ($text === '') {
        return '';
    }
    if (preg_match('/[$€£¥]|\b(usd|us\s*dollars?|dollars?|eur|euros?|gbp|pounds?|aed|sgd|cad|aud)\b/iu', $text)) {
        return null;
    }
    // Drop existing rupee markers, then put one ₹ in front of every amount.
    $text = preg_replace('/(₹|\bINR\b|\bRs\.?)\s*/iu', '', $text);
    $text = preg_replace_callback('/(?<![\w.])(\d[\d,]*)(\.\d+)?(\s*(?:k|lpa|lakh|lakhs|l|cr|crore)\b)?/iu', function ($m) {
        $whole = str_replace(',', '', $m[1]);
        $unit = isset($m[3]) ? $m[3] : '';
        return '₹' . ($unit === '' ? nm_inr_number($whole) : $whole) . ($m[2] ?? '') . $unit;
    }, $text);
    return $text;
}

/** 125000 -> "₹1,25,000", 699.5 -> "₹699.50" (paise only when present). */
function nm_inr_amount($amount) {
    $amount = round((float) $amount, 2);
    $whole = nm_inr_number((string) (int) floor($amount));
    $paise = (int) round(($amount - floor($amount)) * 100);
    return '₹' . $whole . ($paise ? sprintf('.%02d', $paise) : '');
}

/**
 * Job list fields (skills, responsibilities, requirements) are stored as a JSON array.
 * Accepts that JSON or plain text with one item per line; returns the JSON ('' when empty).
 */
function nm_list_json($raw) {
    $raw = trim((string) $raw);
    $list = json_decode($raw, true);
    if (!is_array($list)) {
        $list = preg_split('/\R/u', $raw);
    }
    $list = array_values(array_filter(array_map(fn ($v) => trim(preg_replace('/^\s*[-•*]\s*/u', '', (string) $v)), $list), fn ($v) => $v !== ''));
    return $list ? json_encode($list, JSON_UNESCAPED_UNICODE) : '';
}
