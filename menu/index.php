<?php

/**
 * A simple example of logging in.
 * 
 * Sam Scott, McMaster University, 2025
 */
include "../connect.php";

session_start();

if (!isset($_SESSION["userid"])) {
    $userid = filter_input(INPUT_POST, "userid", FILTER_SANITIZE_SPECIAL_CHARS);
    $password = filter_input(INPUT_POST, "password");

    if ($userid !== null and $password !== null) {
        $cmd = "SELECT password, firstname, lastname, accesslevel FROM hoopsdynastyusers WHERE username=?";
        $stmt = $dbh->prepare($cmd);
        $stmt->execute([$userid]);

        if ($row = $stmt->fetch()) {
            if (password_verify($password, $row["password"])) {
                $_SESSION["userid"] = $userid;
                $_SESSION["firstname"] = $row["firstname"];
                $_SESSION["lastname"] = $row["lastname"];
                $_SESSION["accesslevel"] = $row["accesslevel"];
            } else {
                session_unset();
                session_destroy();
            }
        } else {
            // bad login attempt. kick them out.
            session_unset();
            session_destroy();
        }
    }
}
?>
<!DOCTYPE html>
<html>

<head>
    <title>Menu</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>

<body>
    <?php
    if (isset($_SESSION["userid"])) {
    ?>
        <h1>Welcome <?= $_SESSION["userid"] ?>!</h1>
        <p>Navigate</p>
        <ul>
            <li><a href="../teambuilder">teambuilder</a></li>
            <li><a href="../game">game</a></li>
            <li><a href="../accounts/logout.php">logout</a></li>
        </ul>
    <?php
    } else {
    ?>
        <h1>Login Error! Access denied.</h1>
        <a href="../accounts/signin.php">Try again.</a>
    <?php
    }
    ?>
</body>

</html>