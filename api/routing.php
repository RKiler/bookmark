<?php
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
        if ($id) {
            json_response(execSQL("SELECT * FROM bookmark WHERE id=$id"), StatusCodes::HTTP_OK);
        } else {
            json_response(execSQL('SELECT * FROM bookmark'), StatusCodes::HTTP_OK);
        }
        break;
    case 'post:bookmark':
        // Request Body 取得
        insertBookmark(json_decode(file_get_contents('php://input')));

        break;
    case 'put:bookmark':
        updateBookmark($id, json_decode(file_get_contents('php://input')));
        break;
    case 'delete:bookmark':
        if (empty(execSQL("SELECT * FROM bookmark WHERE id=$id"))) {
            $code = StatusCodes::HTTP_NOT_FOUND;
            json_response(array("message" => StatusCodes::getMessageForCode($code)), $code);
        } else {
            execSQL("DELETE FROM bookmark WHERE id=$id");
            $code = StatusCodes::HTTP_OK;
            json_response(array("message" => "Delete successful"), $code);
        }
        break;
}

function json_response($obj, $code)
{
    http_response_code($code);
    header("Content-Type: application/json; charset=utf-8");
    header("X-Content-Type-Options: nosniff");
    echo json_encode($obj);
}
