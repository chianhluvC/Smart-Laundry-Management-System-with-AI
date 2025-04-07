<?php
session_start();
session_destroy();
header("Location: registerLogin.php");
exit();
?>
