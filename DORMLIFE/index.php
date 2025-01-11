<?php
include '../connection/db.php';
header("Location: students/login.php");  // Corrected header syntax
exit();  // It's good practice to include exit() after a redirect to ensure the script stops executing
?>