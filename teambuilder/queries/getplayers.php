<?php
include "../../connect.php";

$player_name = filter_input(INPUT_POST, "name", FILTER_SANITIZE_SPECIAL_CHARS);
$player_team = filter_input(INPUT_POST, "team", FILTER_SANITIZE_SPECIAL_CHARS);
$stmt;
$success;

if ($player_name !== null) {
    if ($player_team !== null) {
        $command = "SELECT player_name, player_team FROM hoopsdynastyplayers WHERE LOWER(player_name) LIKE LOWER(?) AND LOWER(player_team) LIKE LOWER(?) ORDER BY player_id LIMIT 50";
        $stmt = $dbh->prepare($command);
        $success = $stmt->execute(["%$player_name%", "%$player_team%"]);
    } else {
        $command = "SELECT player_name, player_team FROM hoopsdynastyplayers WHERE LOWER(player_name) LIKE LOWER(?) ORDER BY player_id LIMIT 50";
        $stmt = $dbh->prepare($command);
        $success = $stmt->execute(["%$player_name%"]);
    }
} else if ($player_team !== null) {
    $command = "SELECT player_name, player_team FROM hoopsdynastyplayers WHERE LOWER(player_team) LIKE LOWER(?) ORDER BY player_id LIMIT 50";
    $stmt = $dbh-> prepare($command);
    $success = $stmt->execute(["%$player_team%"]);
} else {
    $command = "SELECT player_name, player_team FROM hoopsdynastyplayers ORDER BY player_id LIMIT 50";
    $stmt = $dbh->prepare($command);
    $success = $stmt->execute();
}

if ($success) {
    $return = [];

    while ($player = $stmt->fetch()) {
        $return[] = [
            "player_name" => $player["player_name"],
            "player_team" => $player["player_team"]
        ];
    }

    echo json_encode($return);
} else {
    echo json_encode(["status" => "NONE"]);
}
