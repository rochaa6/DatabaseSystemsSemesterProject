<?php
session_start();
if (empty($_SESSION['user'])) {
    // The username session key does not exist or it's empty.
    header('Location: login.php');
    exit;
}