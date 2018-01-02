<?php

$db = new PDO('mysql:host=database;dbname=default;charset=utf8', 'default', 'secret');

function execSQL($query)
{
    global $db;

    return $db->query($query)->fetchAll(PDO::FETCH_ASSOC);
}

function insertBookmark($name, $url, $tag)
{
    global $db;

    $stmt = $db->prepare('INSERT INTO bookmark VALUES (NULL ,:name ,:url)');
    $stmt->execute(array(':name' => $name, ':url' => $url));

    $id = $db->query('SELECT id FROM bookmark ORDER BY id DESC LIMIT 1')->fetchAll(PDO::FETCH_ASSOC);
    $insert_tags = $db->prepare('INSERT INTO tag VALUES (NULL ,:id ,:tag)');
    $insert_tags->execute(array(':id' => $id[0]['id'], ':tag' => $tag));
}

function updateBookmark($id, $name, $url, $tag)
{
    global $db;

    $bookmark_db = $db->prepare('UPDATE bookmark SET name = :name, url = :url WHERE id = :id');
    $bookmark_db->execute(array(':id' => $id, ':name' => $name, ':url' => $url));
    $tag_db = $db->prepare('UPDATE bookmark SET name = :name, url = :url WHERE id = :id');

}