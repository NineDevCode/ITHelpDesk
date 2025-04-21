<?php
session_start();
function authMiddlewareAdmin()
{
    if (!isset($_SESSION['admin_username'])) {
        header('Location: ../Backoffice/Auth/login.php');
        exit;
    }
}
function authMiddlewareUser()
{
    if (!isset($_SESSION['user'])) {
        header('Location: ../Views/Auth/login.php');
        exit;
    }
}
?>