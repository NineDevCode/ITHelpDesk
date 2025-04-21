<?php

use Google\Service\Adsense\Header;

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
include_once '../Class/Class.php';
include "./middleware.php";
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$hdc = new HDC;
$web = new Web;
$report = new Report;
$other = new Other;
$admin = new Admin;

//nonAuthen
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

if ($_REQUEST["route_name"] == "login") {
    $result = $admin->login($_POST);
    if ($result) {
        foreach ($result as $item) {
            $_SESSION['admin_username'] = $item['admin_username'];
            $_SESSION['admin_name'] = $item['admin_name'];
            $_SESSION['admin_email'] = $item['admin_email'];
        }
        Header("Location: ../Backoffice/Admin/index.php");
    } else {
        Header("Location: ../Backoffice/Auth/login.php");
    }
}

//Users
if (isset($_SESSION["user"])) {
    authMiddlewareUser();
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
}

if (isset($_SESSION["admin_username"])) {
    //Admin
    if ($_REQUEST["route_name"] == "accept_work_hdc") {
        $hdc_id = $_GET['hdc_id'];
        $result = $hdc->change_status("accepted", $hdc_id);
        if ($result) {
            $_SESSION["accept_hdc"] = "success";
            Header("Location: ../Backoffice/Admin/hdc.php");
        } else {
            $_SESSION["accept_hdc"] = "false";
            Header("Location: ../Backoffice/Admin/hdc.php");
        }
    }

    if ($_REQUEST["route_name"] == "finished_work_hdc") {
        $hdc_id = $_GET['hdc_id'];
        $result = $hdc->change_status("finished", $hdc_id);
        $result_add = $hdc->add_finish_detail($_POST, $hdc_id);
        if ($result && $result_add) {
            $_SESSION["finish_hdc"] = "success";
            Header("Location: ../Backoffice/Admin/hdc.php");
        } else {
            $_SESSION["finish_hdc"] = "false";
            Header("Location: ../Backoffice/Admin/hdc.php");
        }
    }

    if ($_REQUEST["route_name"] == "accept_work_web") {
        $web_id = $_GET["web_id"];
        $result = $web->change_status("accepted", $web_id);
        if ($result) {
            $_SESSION["accept_web"] = "success";
            Header("Location: ../Backoffice/Admin/web.php");
        } else {
            $_SESSION["accept_web"] = "false";
            Header("Location: ../Backoffice/Admin/web.php");
        }
    }

    if ($_REQUEST["route_name"] == "finished_work_web") {
        $web_id = $_GET["web_id"];
        $result = $web->change_status("finished", $web_id);
        $result_add = $web->add_finish_detail($_POST, $web_id);
        if ($result && $result_add) {
            $_SESSION["finish_web"] = "success";
            Header("Location: ../Backoffice/Admin/web.php");
        } else {
            $_SESSION["finish_web"] = "false";
            Header("Location: ../Backoffice/Admin/web.php");
        }
    }

    if ($_REQUEST['route_name'] == 'accept_work_report') {
        $report_id = $_GET['report_id'];
        $result = $report->change_status('accepted', $report_id);
        if ($result) {
            $_SESSION['accept_report'] = 'success';
            Header("Location: ../Backoffice/Admin/report.php");
        } else {
            $_SESSION["accept_report"] = "false";
            Header("Location: ../Backoffice/Admin/report.php");
        }
    }

    if ($_REQUEST['route_name'] == 'finished_work_report') {
        $report_id = $_GET['report_id'];
        $result = $report->change_status('finished', $report_id);
        $result_add = $report->add_finish_detail($report_id, $_POST);
        if ($result && $result_add) {
            $_SESSION["finish_report"] = "success";
            Header("Location: ../Backoffice/Admin/report.php");
        } else {
            $_SESSION["finish_report"] = "false";
            Header("Location: ../Backoffice/Admin/report.php");
        }
    }

    if ($_REQUEST["route_name"] == "cancel_work_report") {
        $report_id = $_GET["report_id"];
        $result = $report->change_status("cancel", $report_id);
        if ($result) {
            $_SESSION["cancel_report"] = "success";
            Header("Location: ../Backoffice/Admin/report.php");
        } else {
            $_SESSION["cancel_report"] = "false";
            Header("Location: ../Backoffice/Admin/report.php");
        }
    }

    if ($_REQUEST["route_name"] == "cancel_work_hdc") {
        $hdc_id = $_GET["hdc_id"];
        $result = $hdc->change_status("cancel", $hdc_id);
        if ($result) {
            $_SESSION["cancel_hdc"] = "success";
            Header("Location: ../Backoffice/Admin/hdc.php");
        } else {
            $_SESSION["cancel_hdc"] = "false";
            Header(header: "Location: ../Backoffice/Admin/hdc.php");
        }
    }

    if ($_REQUEST["route_name"] == "cancel_work_web") {
        $web_id = $_GET['web_id'];
        $result = $web->change_status('cancel', $web_id);
        if ($result) {
            $_SESSION['cancel_web'] = 'success';
            Header('Location: ../Backoffice/Admin/web.php');
        } else {
            $_SESSION['cancel_web'] = 'false';
            Header('Location: ../Backoffice/Admin/web.php');
        }
    }

    if ($_REQUEST['route_name'] == 'accept_work_other') {
        $other_id = $_GET['other_id'];
        $result = $other->change_status('accepted', $other_id);
        if ($result) {
            $_SESSION['accept_other'] = 'success';
            Header('Location: ../Backoffice/Admin/other.php');
        } else {
            $_SESSION['accept_other'] = 'false';
            Header('Location: ../Backoffice/Admin/other.php');
        }
    }

    if ($_REQUEST['route_name'] == 'cancel_work_other') {
        $other_id = $_GET['other_id'];
        $result = $other->change_status('cancel', $other_id);
        if ($result) {
            $_SESSION['cancel_other'] = 'success';
            Header("Location: ../Backoffice/Admin/other.php");
        } else {
            $_SESSION["cancel_other"] = "false";
            Header("Location: ../Backoffice/Admin/other.php");
        }
    }

    if ($_REQUEST["route_name"] == "finished_work_other") {
        $other_id = $_GET["other_id"];
        $result = $other->change_status("finished", $other_id);
        $result_add = $other->add_finish_detail($_POST, $other_id);
        if ($result && $result_add) {
            $_SESSION["finish_other"] = "success";
            Header("Location: ../Backoffice/Admin/other.php");
        } else {
            $_SESSION["finish_other"] = "false";
            Header("Location: ../Backoffice/Admin/other.php");
        }
    }
}
?>