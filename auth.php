<?php

define("DB_NAME", "u257489035_thto");
define("DBT_USERS", "users");
define("DB_USER", "u257489035_bport");
define("DB_PASSWORD", "qweytrasdhgf");

function login() {
    $db = new mysqli("localhost", DB_USER, DB_PASSWORD, DB_NAME);
    if (!$db -> connect_errno) {
        if ($result = $db -> query('SELECT * FROM users WHERE login="'.$_GET["login"].'" AND password_md5="'.md5($_GET["pass"]).'"')) {
            $_SESSION["login"] = $_GET["login"];
            $result -> close();
        }
        $db -> close();
    }
}

session_start();

if ($_GET["q"] == "login") {
    if (isset($_GET["login"]) && isset($_GET["pass"])) login();
} else if ($_GET["q"] == "logout") unset($_SESSION["login"]);
header("Location: index.php");