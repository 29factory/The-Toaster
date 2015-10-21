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

function get_locked_achievements_unsafe($id_player)
{
    global $db;
    $query = $db->prepare("SELECT ID FROM achievements WHERE id_player=?");
    $query->bind_param("i", $id_player);
    $query->execute();
    $achievements = json_decode(file_get_contents("achievements.json"), true);
    $query->bind_result($id);
    while ($query->fetch()) unset($achievements[$id]);
    echo json_encode($achievements);
    return true;
}

function get_locked_achievements()
{
    if (get_locked_achievements_unsafe($_SESSION["id"])) return true; else return "Ошибка соединения с базой данных.";
}

function do_get_locked_achievements()
{
    if (isset($_SESSION["id"])) get_locked_achievements();
	else echo "{}";
}

function set_locked_achievements_unsafe($id, $id_player)
{
    global $db;
    $query = $db->prepare("INSERT INTO achievements (ID, id_player) VALUES (?, ?)");
    $query->bind_param("ii", $id, $id_player);
    if ($query->execute()) return true; else return false;
}

function set_locked_achievements($id)
{
    if (set_locked_achievements_unsafe($id, $_SESSION["id"])) return true; else return "Ошибка соединения с базой данных.";
}

function do_set_locked_achievements()
{
    if (isset($_SESSION["id"]) && isset($_GET["id"])) set_locked_achievements($_GET["id"]);
}

session_start();
$query = $_GET["q"];
$db = new mysqli("localhost", DB_USER, DB_PASSWORD, DB_NAME);
if (!$db->connect_errno) {
    if ($query == "endgame") do_save_gamestats();
    else if ($query == "achievements.get") do_get_locked_achievements();
    else if ($query == "achievements.set") do_set_locked_achievements();
}
