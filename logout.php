<?php
session_start();
$_SESSION = array();
session_destroy();
if (isset($_COOKIE['user'])) {
    setcookie('user', '', time() - 3600, '/');
}

header("Location: home_before.php");
exit();

?>
