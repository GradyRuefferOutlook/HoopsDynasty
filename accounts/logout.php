
<!-- 
 this  File is responsible for destroying the user's current data 
  -->
<?php
session_start();
session_unset();
session_destroy();

header("Location: ./signin.php");
exit;
?>