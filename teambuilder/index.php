<?php
session_start();
$access = isset($_SESSION["userid"]);

if (!$access) {
    header("Location: ../signin.php");
    exit;
} else {
?>
    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Team Layout</title>
        <link rel="stylesheet" href="../teambuilder/css/style.css">
        <script src="../teambuilder/js/functions.js" defer></script>
    </head>

    <body>
        <div class="top-links">
            <a class="link" href="../menu">Back to Menu</a>
            <a class="link" href="../accounts/logout.php">Sign Out</a>
        </div>
        <div class="container">
            <div class="section" id="team-section">
                <button id="add_team_button" class="add-team-button">Add Team</button>
            </div>
            <div class="section">
                <img id="player_photo" class="player-photo" alt="Player Photo">
                <h3 id="player_name" class="player-name">Name</h3>
                <div class="player-stats">
                    <h3 class="player-statname">:Player Stats:</h3>
                    <br>
                    <p id="player_stats"></p>
                </div>
            </div>
            <div class="section">
                <div class="input-container">
                    <input id="name_search" type="text" class="input-field" placeholder="Player Name">
                    <input id="team_search" type="text" class="input-field" placeholder="Player Team">
                </div>
                <div id="player_list" class="player-list"></div>
                <div id="none_found" class="footer" style="display:none">No Results</div>
            </div>
        </div>
    </body>

    </html>
<?php
}
