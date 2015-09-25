<?php

include_once "globals.php";

function login_unsafe($login, $pass)
{
    global $db;
    $query = $db->prepare("SELECT EXISTS (SELECT 0 FROM users WHERE login=? AND password_md5=?)");
    $query->bind_param("ss", $login, md5($pass));
    $query->execute();
    $query->bind_result($is_exists);
    $query->fetch();
    if ($is_exists) {
        $_SESSION["login"] = $login;
        return true;
    } else return false;
}

function login($login, $pass)
{
    if (login_unsafe($login, $pass)) return true; else return "Не удалось войти. Логин или пароль неверен.";
}

function do_login()
{
    if (isset($_POST["login"]) && isset($_POST["pass"])) login($_POST["login"], $_POST["pass"]);
}

function do_logout()
{
    unset($_SESSION["login"]);
}

function signup_unsafe($login, $pass, $email=null)
{
    global $db;
    $query = $db->prepare("INSERT INTO users (login, email, password_md5) VALUES (?, ?, ?)");
    $query->bind_param("sss", $login, $email, md5($pass));
    $query->execute();
    $query->bind_result($result);
    $query->fetch();
    if ($result) return true; else return false;
}

function signup($login, $pass, $email=null)
{
    if (signup_unsafe($login, $pass, $email)) return true; else return "Не удалось произвести регистрацию.";
}

function do_signup()
{
    if (isset($_POST["login"]) && isset($_POST["pass"])) signup($_POST["login"], $_POST["pass"]);
}

session_start();
$query = $_POST["q"];
$db = new mysqli("localhost", DB_USER, DB_PASSWORD, DB_NAME);
if (!$db->connect_errno) {
    if ($query == "login") do_login();
    else if ($query == "logout") do_logout();
    else if ($query == "signup") do_signup();
}
header("Location: /");
