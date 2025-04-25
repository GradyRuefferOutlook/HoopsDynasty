<!-- 
 This is responsible for the user being able to sign in to the system given taht thier id is verified
  -->
<?php
session_start();
if (isset($_SESSION["userid"])) {
    header("Location: ../menu");
    exit;
}
?>
<!DOCTYPE html>
<html>

<head>
    <title>User Sign In</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>

<body>
    <h1>Sign In</h1>
    <form method='post' action='../menu/index.php'>
        <input type='text' name='userid' placeholder='username' required><br>
        <input type='password' name='password' placeholder='password' required><br>
        <input type='submit' value='Log In'>
    </form>
    <a href="createaccount.php">Create an account</a>
</body>

</html>