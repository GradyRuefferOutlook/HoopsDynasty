<?php
include "../../connect.php";

$creator_name = filter_input(INPUT_POST, "username", FILTER_SANITIZE_SPECIAL_CHARS);

$command = "SELECT team_name, center, power_forward, small_forward, point_guard, shooting_guard 
            FROM hoopsdynastyteams WHERE creator = ?";
$stmt = $dbh->prepare($command);
$success = $stmt->execute([$creator_name]);

if ($success) {
    $teams = [];

    while ($team = $stmt->fetch()) {
        $teams[] = $team;
    }

    if (!empty($teams)) {
        echo json_encode($teams);
    } else {
        echo json_encode(["status" => "NONE"]);
    }
} else {
    echo json_encode(["status" => "ERROR"]);
}
?>