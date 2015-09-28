<?php

include_once "globals.php";

function save_gamestats_unsafe($score, $gm, $dt, $id_player)
{
    global $db;
    $query = $db->prepare("INSERT INTO gamestats (score, gamemode, id_player, dt) VALUES (?, ?, ?, ?)");
    $query->bind_param("isis", $score, ["toastbox"][$gm], $id_player, $dt);
    if ($query->execute()) return true; else return false;
}

function save_gamestats($score, $gm)
{
    if (save_gamestats_unsafe($score, $gm, date("Y-m-d H:i:s"), isset($_SESSION["id"]) ? $_SESSION["id"] : null)) return true; else return "Ошибка соединения с базой данных.";
}

function do_save_gamestats()
{
    if (isset($_GET["score"]) && isset($_GET["gamemode"])) save_gamestats($_GET["score"], $_GET["gamemode"]);
}

session_start();
$query = $_GET["q"];
$db = new mysqli("localhost", DB_USER, DB_PASSWORD, DB_NAME);
if (!$db->connect_errno) {
    if ($query == "endgame") do_save_gamestats();
}
