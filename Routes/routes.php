<?php

use Google\Service\Adsense\Header;

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
session_start(); // Start the session
include_once '../Class/Class.php';

$hdc = new HDC;
$web = new Web;
$report = new Report;
$other = new Other;
$admin = new Admin;

if ($_REQUEST['route_name'] == 'hdc_create') {
    $result = $hdc->create_hdc($_POST, $_FILES, path: "hdc");

    if ($result) {
        // Set a session variable for success message
        $_SESSION['status'] = "success";
        Header("Location: ../Views/Users/index.php");
    } else {
        // Set a session variable for error message
        $_SESSION['status'] = "false";
        Header("Location: ../Views/Users/index.php");
    }
}

if ($_REQUEST['route_name'] == "web_create") {
    $result = $web->create_web($_POST, $_FILES, path: "web");
    if ($result) {
        // Set a session variable for success message
        $_SESSION['status'] = "success";
        Header("Location: ../Views/Users/index.php");
    } else {
        // Set a session variable for error message
        $_SESSION['status'] = "false";
        Header("Location: ../Views/Users/index.php");
    }
}

if ($_REQUEST["route_name"] == "report_create") {
    $result = $report->create_report($_POST, $_FILES, path: "report");
    if ($result) {
        // Set a session variable for success message
        $_SESSION['status'] = "success";
        Header("Location: ../Views/Users/index.php");
    } else {
        // Set a session variable for error message
        $_SESSION['status'] = "false";
        Header("Location: ../Views/Users/index.php");
    }
}

if ($_REQUEST["route_name"] == "other_create") {
    $result = $other->create_other($_POST);
    if ($result) {
        // Set a session variable for success message
        $_SESSION['status'] = "success";
        Header("Location: ../Views/Users/index.php");
    } else {
        // Set a session variable for error message
        $_SESSION['status'] = "false";
        Header("Location: ../Views/Users/index.php");
    }
}

if ($_REQUEST["route_name"] == "register") {
    $result = $admin->register($_POST);
    if ($result == "username_already") {
        $_SESSION["status"] = "username_already";
        Header("Location: ../Backoffice/Auth/register.php");
    } elseif ($result == "success") {
        // Set a session variable for success message
        $_SESSION['status'] = "success_register";
        Header("Location: ../Backoffice/Auth/login.php");
    } else {
        // Set a session variable for error message
        $_SESSION['status'] = "false_register";
        Header("Location: ../Backoffice/Auth/register.php");
    }
}

if ($_REQUEST["route_name"] == "login"){
    $result = $admin->login($_POST);
    if ($result) {
        foreach ($result as $item){
            $_SESSION['admin_username'] = $item['admin_username'];
            $_SESSION['admin_name'] = $item['admin_name'];
            $_SESSION['admin_email'] = $item['admin_email'];
        }
        Header("Location: ../Backoffice/Admin/index.php");
    }else{
        Header("Location: ../Backoffice/Auth/login.php");
    }
}
?>