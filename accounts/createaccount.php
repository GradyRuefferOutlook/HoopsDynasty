<!-- 
 This file is responsible for collecting the identification information from the user and using post parameter in onepage format to create the acount
  -->
<?php
include "../connect.php";

// Variables to store user inouted id values
$username = filter_input(INPUT_POST, "username", FILTER_SANITIZE_SPECIAL_CHARS);
$password = filter_input(INPUT_POST, "password");
$firstname = filter_input(INPUT_POST, "firstname", FILTER_SANITIZE_SPECIAL_CHARS);
$lastname = filter_input(INPUT_POST, "lastname", FILTER_SANITIZE_SPECIAL_CHARS);
$email = filter_input(INPUT_POST, "email", FILTER_SANITIZE_EMAIL);

// validating user input and giving feedback
if ($username !== null && $password !== null && $firstname !== null && $lastname !== null && $email !== null) {
    $cmd = "INSERT INTO `hoopsdynastyusers`(`username`, `password`, `firstname`, `lastname`, `accesslevel`, `email`) VALUES (?,?,?,?,0,?)";
    $stmt = $dbh->prepare($cmd);
    $stmt->execute([$username, password_hash($password, PASSWORD_BCRYPT), $firstname, $lastname, $email]);

    header("Location: ./signin.php");
    exit;
}
?>
<!DOCTYPE html>
<html>

<head>
    <title>User Account Creation</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="/hoopsdynasty/accounts/js/passwordvalidation.js" defer></script>
</head>

<body>
    <h1>Create Account</h1>
    <!-- Using forms to with different elements to effectively collect user inputed values -->
    <form method='post' action='/hoopsdynasty/accounts/createaccount.php' id="accountform">
        <input type='text' name='username' placeholder='username' required><br>
        <input type='password' id="password" name='password' placeholder='password' required><br>
        <input type='password' id="password2" name='password2' placeholder='confirm password' required><br>
        <input type='text' name='firstname' placeholder='firstname' required><br>
        <input type='text' name='lastname' placeholder='lastname' required><br>
        <input type='text' name='email' placeholder='email' required><br>
        <input type='submit' value='Log In'>
        <h1 id="errorMessage" style="display: none">Passwords Do Not Match</h1>
    </form>
</body>

</html>