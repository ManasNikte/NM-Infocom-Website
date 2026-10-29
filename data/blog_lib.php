<?php
/**
 * Blog helpers shared by Blogs.php, blog-details.php and the website manager's blog editor.
 *
 * Article bodies are stored as plain text with light formatting:
 *   ## Heading / ### Sub-heading      - bullet / 1. numbered item
 *   **bold**   [link text](https://example.com)   blank line = new paragraph
 * Everything is HTML-escaped before formatting, so authors cannot inject markup.
 */
require_once __DIR__ . '/../config/database.php';

/** Published posts, newest first (featured first when $featuredFirst). */
function nm_blog_posts(PDO $conn, $featuredFirst = true) {
    $order = $featuredFirst ? 'is_featured DESC, created_at DESC' : 'created_at DESC';
    return $conn->query("SELECT * FROM blogs WHERE blog_status = 'Approved' ORDER BY $order")->fetchAll(PDO::FETCH_ASSOC);
}

function nm_blog_post(PDO $conn, $id) {
    $stmt = $conn->prepare("SELECT * FROM blogs WHERE blog_id = ? AND blog_status = 'Approved'");
    $stmt->execute([(int) $id]);
    return $stmt->fetch(PDO::FETCH_ASSOC) ?: null;
}

/** Up to $limit other published posts, same category first. */
function nm_blog_related(PDO $conn, array $post, $limit = 3) {
    $stmt = $conn->prepare("SELECT * FROM blogs WHERE blog_status = 'Approved' AND blog_id <> ?
                            ORDER BY (blog_category = ?) DESC, created_at DESC LIMIT " . (int) $limit);
    $stmt->execute([$post['blog_id'], $post['blog_category']]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

/** "5 min read" from the article length (200 words per minute, at least 1). */
function nm_read_time($text) {
    $words = str_word_count(strip_tags((string) $text));
    return max(1, (int) ceil($words / 200)) . ' min read';
}

/** Category slug from a label: "Cloud Computing" -> "cloud-computing". */
function nm_blog_slug($label) {
    return trim(preg_replace('/[^a-z0-9]+/', '-', strtolower((string) $label)), '-') ?: 'general';
}

function nm_blog_inline($text) {
    $html = htmlspecialchars($text, ENT_QUOTES);
    $html = preg_replace('/\*\*(.+?)\*\*/', '<strong>$1</strong>', $html);
    // Only http(s) links; the URL has already been escaped above.
    return preg_replace('/\[([^\]]+)\]\((https?:\/\/[^\s)]+)\)/', '<a href="$2" target="_blank" rel="noopener nofollow">$1</a>', $html);
}

/** Plain-text article body -> safe HTML. */
function nm_blog_render($text) {
    $html = '';
    $list = null; // 'ul' or 'ol' while inside a list
    $paragraph = [];
    $flush = function () use (&$paragraph, &$html) {
        if ($paragraph) {
            $html .= '<p>' . implode('<br>', array_map('nm_blog_inline', $paragraph)) . "</p>\n";
            $paragraph = [];
        }
    };
    $closeList = function () use (&$list, &$html) {
        if ($list) {
            $html .= "</$list>\n";
            $list = null;
        }
    };
    foreach (preg_split('/\R/', (string) $text) as $line) {
        $trim = trim($line);
        if ($trim === '') {
            $flush();
            $closeList();
        } elseif (preg_match('/^(#{2,3})\s+(.+)$/', $trim, $m)) {
            $flush();
            $closeList();
            $tag = strlen($m[1]) === 2 ? 'h2' : 'h3';
            $html .= "<$tag>" . nm_blog_inline($m[2]) . "</$tag>\n";
        } elseif (preg_match('/^(?:[-*]|(\d+)\.)\s+(.+)$/', $trim, $m)) {
            $flush();
            $type = $m[1] !== '' ? 'ol' : 'ul';
            if ($list !== $type) {
                $closeList();
                $html .= "<$type>\n";
                $list = $type;
            }
            $html .= '<li>' . nm_blog_inline($m[2]) . "</li>\n";
        } else {
            $closeList();
            $paragraph[] = $trim;
        }
    }
    $flush();
    $closeList();
    return $html;
}
