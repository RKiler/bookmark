<?php

$db = new PDO('mysql:host=database;dbname=default;charset=utf8', 'default', 'secret');

function execSQL($query)
{
    global $db;

    return $db->query($query)->fetchAll(PDO::FETCH_ASSOC);
}

function insertBookmark($bookmark)
{
    global $db;

    $stmt = $db->prepare('INSERT INTO bookmark VALUES (NULL ,:name ,:url)');
    $stmt->execute(array(':name' => $bookmark->name, ':url' => $bookmark->url));
}

function updateBookmark($id, $bookmark)
{
    global $db;

    $stmt = $db->prepare('UPDATE bookmark SET name = :name, url = :url WHERE id = :id');
    $stmt->execute(array(':id' => $id, ':name' => $bookmark->name, ':url' => $bookmark->url));

}