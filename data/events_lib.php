<?php
// Events for the public Events page, classified as upcoming or past from their date and time (IST).
require_once __DIR__ . '/../config/database.php';

const NM_EVENTS_TZ = 'Asia/Kolkata';

/**
 * @return array{upcoming: array, past: array} upcoming soonest first, past most recent first.
 * Each event gets 'starts' (DateTimeImmutable), 'speakers' (string[]) and 'image' (URL or null).
 */
function nm_events(PDO $conn) {
    $tz = new DateTimeZone(NM_EVENTS_TZ);
    $now = new DateTimeImmutable('now', $tz);

    $speakers = [];
    foreach ($conn->query('SELECT event_id, speaker_name FROM event_speakers ORDER BY speaker_id')->fetchAll(PDO::FETCH_ASSOC) as $s) {
        $speakers[$s['event_id']][] = $s['speaker_name'];
    }

    $upcoming = $past = [];
    foreach ($conn->query('SELECT * FROM events')->fetchAll(PDO::FETCH_ASSOC) as $event) {
        $event['starts'] = new DateTimeImmutable($event['event_date'] . ' ' . ($event['event_time'] ?: '00:00:00'), $tz);
        $event['speakers'] = $speakers[$event['event_id']] ?? [];
        $event['title'] = trim($event['event_title'] ?: (string) $event['event_name']);
        $event['image'] = $event['event_img']
            ? (preg_match('#^https?://#', $event['event_img']) ? $event['event_img'] : 'uploads/events/' . basename($event['event_img']))
            : null;
        $event['register'] = preg_match('#^https?://#i', (string) $event['event_link']) ? $event['event_link'] : null;
        // An event counts as upcoming until the end of its start day, so same-day events stay listed.
        if ($event['starts']->setTime(23, 59, 59) >= $now) {
            $upcoming[] = $event;
        } else {
            $past[] = $event;
        }
    }
    usort($upcoming, fn ($a, $b) => $a['starts'] <=> $b['starts']);
    usort($past, fn ($a, $b) => $b['starts'] <=> $a['starts']);
    return ['upcoming' => $upcoming, 'past' => $past, 'now' => $now];
}
