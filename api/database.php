<?php

$db = new PDO('mysql:host=database;dbname=default;charset=utf8', 'default', 'secret');

function execSQL($query)
{
    global $db;

    return $db->query($query)->fetchAll(PDO::FETCH_ASSOC);
}