<?php
const DB_URL = "db.mkalmo.eu";
const USER_NAME = "armarh";
const PASS = "1c3aa9"; // vabandage mind

function getConnection(): PDO
{
    $address = sprintf("mysql:host=%s;port=3306;dbname=%s", DB_URL, USER_NAME);
    return new PDO($address, USER_NAME, PASS);
}