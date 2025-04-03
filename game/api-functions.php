<?php

/**
 * Validates required parameters
 * @param array $params - Array of parameter names to validate
 * @param string $source - Source of parameters ('GET' or 'POST')
 * @return array - Array with 'valid' boolean and 'missing' array of missing params
 */
function validateParams($params, $source = 'GET') {
    $missing = [];
    $source = $source === 'POST' ? $_POST : $_GET;
    
    foreach ($params as $param) {
        if (!isset($source[$param]) || empty($source[$param])) {
            $missing[] = $param;
        }
    }
    
    return [
        'valid' => empty($missing),
        'missing' => $missing
    ];
}

/**
 * Sends a JSON response
 * @param mixed $data - Data to send
 * @param int $status - HTTP status code
 */
function sendJsonResponse($data, $status = 200) {
    http_response_code($status);
    header('Content-Type: application/json');
    echo json_encode($data);
    exit;
}

/**
 * Handles database errors
 * @param Exception $e - Exception object
 */
function handleDbError($e) {
    $errorResponse = [
        'status' => 'error',
        'message' => 'Database error occurred',
        'dev_message' => $e->getMessage()
    ];
    
    sendJsonResponse($errorResponse, 500);
}

/**
 * Calculates player action probabilities based on stats
 * @param array $player - Player data
 * @return array - Action probabilities
 */
function calculateActionProbabilities($player) {
    $position = strtolower($player['player_position']);
    $probabilities = [];
    
    // Offensive probabilities
    $probabilities['three_pointer'] = $player['three_point_percentage'];
    $probabilities['layup'] = $player['two_point_percentage'];
    $probabilities['pass'] = min(95, $player['two_point_percentage'] + 10);
    
    // Adjusts dunk probability based on position
    if ($position === 'center' || $position === 'power forward') {
        $probabilities['dunk'] = $player['two_point_percentage'] - 5;
    } else {
        $probabilities['dunk'] = $player['two_point_percentage'] - 15;
    }
    
    // Defensive probabilities
    $probabilities['block'] = $player['blocks_per_game'] * 10;
    $probabilities['steal'] = $player['steals_per_game'] * 10;
    $probabilities['tackle'] = $player['steals_per_game'] * 8;
    $probabilities['pressure'] = 50 + ($player['steals_per_game'] * 5);
    
    // Keeps the values between 5 and 95
    foreach ($probabilities as $key => $value) {
        $probabilities[$key] = max(5, min(95, $value));
    }
    
    return $probabilities;
}