<?php
include "../../connect.php";

header("Content-Type: application/json");

$creator = filter_input(INPUT_POST, "creator", FILTER_SANITIZE_SPECIAL_CHARS);
$team_name = filter_input(INPUT_POST, "team_name", FILTER_SANITIZE_SPECIAL_CHARS);
$center = filter_input(INPUT_POST, "center", FILTER_SANITIZE_SPECIAL_CHARS);
$power_forward = filter_input(INPUT_POST, "power_forward", FILTER_SANITIZE_SPECIAL_CHARS);
$small_forward = filter_input(INPUT_POST, "small_forward", FILTER_SANITIZE_SPECIAL_CHARS);
$point_guard = filter_input(INPUT_POST, "point_guard", FILTER_SANITIZE_SPECIAL_CHARS);
$shooting_guard = filter_input(INPUT_POST, "shooting_guard", FILTER_SANITIZE_SPECIAL_CHARS);

// Validate input
if (!$team_name) {
    echo json_encode(["status" => "error", "message" => "Invalid team name."]);
    exit;
}

// Check if the team already exists
$checkCommand = "SELECT team_name FROM hoopsdynastyteams WHERE team_name = ?";
$checkStmt = $dbh->prepare($checkCommand);
$checkStmt->execute([$team_name]);

if ($checkStmt->fetch()) {
    // Update existing team
    $command = "UPDATE hoopsdynastyteams SET center = ?, power_forward = ?, small_forward = ?, point_guard = ?, shooting_guard = ? WHERE team_name = ?";
    $stmt = $dbh->prepare($command);
    $success = $stmt->execute([$center, $power_forward, $small_forward, $point_guard, $shooting_guard, $team_name]);

    if ($success) {
        echo json_encode(["status" => "success", "message" => "Team updated successfully."]);
    } else {
        echo json_encode(["status" => "error", "message" => "Failed to update team."]);
    }
} else {
    $access = 0;
    if ($creator == "dmgg") {
        $access = 1;
    }
    $command = "INSERT INTO hoopsdynastyteams (creator, team_name, access, center, power_forward, small_forward, point_guard, shooting_guard) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = $dbh->prepare($command);
    $success = $stmt->execute([$creator, $team_name, $access, $center, $power_forward, $small_forward, $point_guard, $shooting_guard]);

    if ($success) {
        echo json_encode(["status" => "success", "message" => "Team saved successfully."]);
    } else {
        echo json_encode(["status" => "error", "message" => "Failed to save team."]);
    }
}
?>
