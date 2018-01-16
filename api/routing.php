<?php
/**
 * Copyright (c) 2018 ayatk. licensed under the MIT License.
 *
 * Created by PhpStorm.
 * User: ayatk
 * Date: 2018/01/03
 * Time: 1:27
 */

require 'database.php';
require 'http.php';

preg_match('|' . dirname($_SERVER['SCRIPT_NAME']) . '/([\w%/]*)|', $_SERVER['REQUEST_URI'], $matches);
$paths = explode('/', $matches[1]);
$raw_id = isset($paths[1]) ? htmlspecialchars($paths[1]) : null;

// bookmark id バリデーション
$id = filter_var($raw_id, FILTER_VALIDATE_INT);
if ($raw_id != null && !$id) {
    http_response_code(StatusCodes::HTTP_BAD_REQUEST);
    return;
}

switch (strtolower($_SERVER['REQUEST_METHOD']) . ':' . $paths[0]) {
    case 'get:bookmark':
        jsonResponse(getBookmark($id), StatusCodes::HTTP_OK);
        break;
    case 'post:bookmark':
        // Request Body 取得
        $body = json_decode(file_get_contents('php://input'));
        insertBookmark($body->name, $body->url, $body->tags);

        break;
    case 'put:bookmark':
        $body = json_decode(file_get_contents('php://input'));
        updateBookmark($id, $body->name, $body->url, $body->tags);

        break;
    case 'delete:bookmark':
        $code = deleteBookamrk($id);
        jsonResponse(array("message" => StatusCodes::getMessageForCode($code)), $code);
        break;
    case 'get:count':
        $calc = (int)execSQL("SELECT count(*) FROM bookmark")[0]['count(*)'] + (int)execSQL("SELECT count(*) FROM tag")[0]['count(*)'];
        jsonResponse(array("count" => $calc), StatusCodes::HTTP_OK);
}

function jsonResponse($obj, $code)
{
    http_response_code($code);
    header("Content-Type: application/json; charset=utf-8");
    header("X-Content-Type-Options: nosniff");
    echo json_encode($obj);
}
