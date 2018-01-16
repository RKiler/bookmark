<?php
/**
 * Copyright (c) 2018 ayatk. licensed under the MIT License.
 *
 * Created by PhpStorm.
 * User: ayatk
 * Date: 2018/01/03
 * Time: 1:27
 */

$db = new PDO('mysql:host=database;dbname=default;charset=utf8', 'default', 'secret');

/**
 * 生SQLを実行
 * @param $query string SQLのクエリ
 * @return array
 */
function execSQL($query)
{
    global $db;

    return $db->query($query)->fetchAll(PDO::FETCH_ASSOC);
}

/**
 * ブックマークを登録
 * @param $name [string] bookmark name
 * @param $url [string] Bookmark url
 * @param $tags ArrayObject[string] Bookmark tags
 */
function insertBookmark($name, $url, $tags)
{
    global $db;

    $stmt = $db->prepare('INSERT INTO bookmark VALUES (NULL ,:name ,:url)');
    // 名前とURLのエスケープ処理
    $name = htmlspecialchars($name, ENT_QUOTES, 'UTF-8');
    $url = htmlspecialchars($url, ENT_QUOTES, 'UTF-8');
    $stmt->execute(array(':name' => $name, ':url' => $url));

    $id = execSQL('SELECT id FROM bookmark ORDER BY id DESC LIMIT 1');
    $insert_tags = $db->prepare('INSERT INTO tag VALUES (NULL ,:id ,:tag)');

    foreach ($tags as $tag) {
        $insert_tags->execute(array(':id' => $id[0]['id'], ':tag' => $tag));
    }
}

/**
 * ブックマークのアップデートするSQLを実行
 * @param $id
 * @param $name
 * @param $url
 * @param $tags
 */
function updateBookmark($id, $name, $url, $tags)
{
    global $db;

    $name = htmlspecialchars($name, ENT_QUOTES, 'UTF-8');
    $url = htmlspecialchars($url, ENT_QUOTES, 'UTF-8');

    execSQL("UPDATE bookmark SET name = $name, url = $url WHERE id = $id");
    
    $update_tags = $db->prepare('UPDATE tag SET name = :name WHERE id = :id');
    foreach ($tags as $tag) {
        $bookmark_db->execute(array(':name' => htmlspecialchars($tag, ENT_QUOTES, 'UTF-8')));
    }
}

/**
 * ブックマーク一覧を取得
 * @param $id int ブックマークid
 * @return array すべてのブックマークもしくは指定したidのブックマーク
 */
function getBookmark($id)
{
    $q = "SELECT * FROM bookmark";

    $data = execSQL($q);

    if ($id) {
        $data = execSQL($q . " WHERE bookmark.id = $id");
    }

    $resp = [];

    foreach ($data as $row) {
        $tags = array_column(execSQL("SELECT name FROM tag WHERE bid = " . $row['id']), 'name');
        $resp[] = $row + array("tags" => $tags);
    }

    return $resp;
}

function deleteBookamrk(int $id)
{
    if (empty(execSQL("SELECT * FROM bookmark WHERE id = $id"))) {
        return StatusCodes::HTTP_NOT_FOUND;
    } else {
        execSQL("DELETE FROM bookmark WHERE id = $id");
        execSQL("DELETE FROM tag WHERE id = $id");   
        return StatusCodes::HTTP_OK;
    }
}
