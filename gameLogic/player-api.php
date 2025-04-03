<?php

include "connect.php";
include "api-functions.php";

/**
 * Get player details by ID
 * @param int $playerId - Player ID to retrieve
 * @param string $source - Database table to query ('getTeam' or 'getOpponent')
 * @return array - Player data
 */
function getPlayerById($playerId, $source = 'getTeam') {
    global $dbh;
    
    try {
        $validSources = ['getTeam', 'getOpponent'];
        if (!in_array($source, $validSources)) {
            $source = 'getTeam';
        }
        
        $sql = "SELECT player_ID, player_name, player_position, player_team, 
                three_point_percentage, two_point_percentage, free_throw_percentage, 
                blocks_per_game, steals_per_game, personal_fouls_per_game 
                FROM $source WHERE player_ID = :player_id";
        
        $stmt = $dbh->prepare($sql);
        $stmt->bindParam(':player_id', $playerId, PDO::PARAM_INT);
        $stmt->execute();
        
        $player = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if ($player) {
            // Calculate action probabilities
            $player['probabilities'] = calculateActionProbabilities($player);
        }
        
        return $player;
    } catch (PDOException $e) {
        handleDbError($e);
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    // Validate required parameters
    $validation = validateParams(['player_id']);
    
    if (!$validation['valid']) {
        sendJsonResponse([
            'status' => 'error',
            'message' => 'Missing required parameters: ' . implode(', ', $validation['missing'])
        ], 400);
    }
    
    $playerId = $_GET['player_id'];
    $source = isset($_GET['source']) ? $_GET['source'] : 'getTeam';
    
    $player = getPlayerById($playerId, $source);
    
    if (!$player) {
        sendJsonResponse([
            'status' => 'error',
            'message' => 'Player not found'
        ], 404);
    }
    
    sendJsonResponse([
        'status' => 'success',
        'player' => $player
    ]);
}