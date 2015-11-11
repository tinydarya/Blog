<?php
session_start();
$authorized = false;
// store session data
if (isset($_SESSION['username'])){
    $authorized = true;
} else {
    session_destroy();
    header('location:index.php');
}

if (isset($_GET['logout'])){
    session_destroy();
    header('location:index.php');
}
?>