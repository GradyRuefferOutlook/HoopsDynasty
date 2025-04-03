<?php
include "connect.php";

/**
 * Initialize the game with both teams' data
 * @return array - combined game data
 */
function initGame() {
	global $dbh;
	
	try {
		// Get team players
		$teamSql = "SELECT player_ID, player_name, player_position, player_team, 
					three_point_percentage, two_point_percentage, free_throw_percentage, 
					blocks_per_game, steals_per_game, personal_fouls_per_game 
					FROM getTeam";
		$teamStmt = $dbh->prepare($teamSql);
		$teamStmt->execute();
		$teamPlayers = $teamStmt->fetchAll(PDO::FETCH_ASSOC);
		
		// Get opponent players
		$opponentSql = "SELECT player_ID, player_name, player_position, player_team, 
						three_point_percentage, two_point_percentage, free_throw_percentage, 
						blocks_per_game, steals_per_game, personal_fouls_per_game 
						FROM getOpponent";
		$opponentStmt = $dbh->prepare($opponentSql);
		$opponentStmt->execute();
		$opponentPlayers = $opponentStmt->fetchAll(PDO::FETCH_ASSOC);
		
		// Ensure we have all positions for each team
		$teamPositions = array_column($teamPlayers, 'player_position');
		$opponentPositions = array_column($opponentPlayers, 'player_position');
		
		$requiredPositions = ['center', 'power forward', 'small forward', 'point guard', 'shooting guard'];
		$missingTeamPositions = array_diff($requiredPositions, $teamPositions);
		$missingOpponentPositions = array_diff($requiredPositions, $opponentPositions);
		
		$gameData = [
			'team' => $teamPlayers,
			'opponent' => $opponentPlayers,
			'teamName' => count($teamPlayers) > 0 ? $teamPlayers[0]['player_team'] : 'Home Team',
			'opponentName' => count($opponentPlayers) > 0 ? $opponentPlayers[0]['player_team'] : 'Away Team',
			'missingTeamPositions' => $missingTeamPositions,
			'missingOpponentPositions' => $missingOpponentPositions,
			'status' => 'success'
		];
		
		return $gameData;
	} catch (PDOException $e) {
		return ['status' => 'error', 'message' => 'Database error: ' . $e->getMessage()];
	}
}

// Process HTTP request
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
	$gameData = initGame();
	
	// Returns game data as JSON
	header('Content-Type: application/json');
	echo json_encode($gameData);
}
?>