<?php
include "../../connect.php";

header("Content-Type: application/json");

$team_name = filter_input(INPUT_POST, "team_name", FILTER_SANITIZE_SPECIAL_CHARS);

if (!$team_name) {
    echo json_encode(["status" => "error", "message" => "Invalid team name."]);
    exit;
}

// Prepare and execute the delete query
$command = "DELETE FROM hoopsdynastyteams WHERE team_name = ?";
$stmt = $dbh->prepare($command);
$success = $stmt->execute([$team_name]);

if ($success) {
    echo json_encode(["status" => "success"]);
} else {
    echo json_encode(["status" => "error", "message" => "Failed to delete team."]);
}
?>
