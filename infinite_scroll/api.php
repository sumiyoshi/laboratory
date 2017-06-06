<?php

$id = (isset($_GET['id'])) ? $_GET['id'] : null;

if (!$id) {
    json(true, '', '', false);
}

$title = 'page' . $id;

$content = get_content($title);

if ($content === false) {
    json(true, '', '', false);
}

$next_id = ($id + 1 > 3) ? false : $id + 1;

json(true, $id, $content, $next_id);

function get_content($id)
{
    $html = 'page/' . $id . '.html';

    if (!file_exists($html)) {
        return false;
    }

    return file_get_contents($html);
}

function json($status, $title, $content, $next_id)
{
    header("Content-Type: application/json; charset=utf-8");
    echo json_encode([
        'status' => $status,
        'title' => $title,
        'content' => $content,
        'next_id' => $next_id
    ]);
    exit();
}