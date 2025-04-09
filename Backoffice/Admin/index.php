<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Include Composer's autoloader
require_once __DIR__ . '/../../vendor/autoload.php';
include "../../Class/Connect.php";
include "../../Class/Class.php";
$hdc = new HDC;
$web = new Web;
$report = new Report;
$other = new Other;

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../../');
$dotenv->load();

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Function to check login
function checkLogin()
{
    if (!isset($_SESSION['admin_username'])) {
        header('Location: ../Auth/login.php');
        exit;
    }
}

// Call the function to check login
checkLogin();


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <title>ITHelpdesk | <?php echo $_ENV['TITLE_HOS'] ?></title>
    <meta content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" name="viewport" />
    <meta content="" name="description" />
    <meta content="" name="author" />

    <!-- ================== BEGIN core-css ================== -->
    <link href="https://fonts.googleapis.com/css?family=Roboto:100,300,400,500,700,900" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet" />
    <link href="../../Assets/css/vendor.min.css" rel="stylesheet" />
    <link href="../../Assets/css/google/app.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="../../Assets/css/mystyle.css">
    <link href="../../Assets/plugins/nvd3/build/nv.d3.css" rel="stylesheet" />
    <!-- ================== END core-css ================== -->
</head>

<body>
    <!-- BEGIN #loader -->
    <!-- <div id="loader" class="app-loader">
        <span class="spinner"></span>
    </div> -->
    <!-- END #loader -->

    <!-- BEGIN #app -->
    <div id="app" class="app app-header-fixed app-sidebar-fixed app-with-wide-sidebar app-with-light-sidebar">
        <!-- BEGIN #header -->
        <div id="header" class="app-header">
            <!-- BEGIN navbar-header -->
            <div class="navbar-header">
                <button type="button" class="navbar-desktop-toggler" data-toggle="app-sidebar-minify">
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a href="index.html" class="navbar-brand">
                    <b class="me-1">IT</b> HelpDesk

                </a>
                <button type="button" class="navbar-mobile-toggler" data-toggle="app-sidebar-mobile">
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
            </div>
            <!-- END navbar-header -->
            <!-- BEGIN header-nav -->
            <div class="navbar-nav justify-content-end">
                <div class="navbar-item navbar-user dropdown">
                    <a href="#" class="navbar-link dropdown-toggle d-flex align-items-center" data-bs-toggle="dropdown">
                        <img src="../../Assets/img/user/profile.png" alt="">
                        <span class="d-none d-md-inline"><?= $_SESSION['admin_name'] ?></span> <b
                            class="caret ms-lg-2"></b>
                    </a>
                    <div class="dropdown-menu dropdown-menu-end me-1">
                        <a href="../Auth/logout.php" class="dropdown-item">Log Out</a>
                    </div>
                </div>
            </div>
            <!-- END header-nav -->
        </div>
        <!-- END #header -->

        <!-- BEGIN #sidebar -->
        <div id="sidebar" class="app-sidebar">
            <!-- BEGIN scrollbar -->
            <div class="app-sidebar-content" data-scrollbar="true" data-height="100%">
                <!-- BEGIN menu -->
                <div class="menu">
                    <div class="menu-profile">
                        <a href="javascript:;" class="menu-profile-link" data-toggle="app-sidebar-profile"
                            data-target="#appSidebarProfileMenu">
                            <div class="menu-profile-cover with-shadow"></div>
                            <div class="menu-profile-info">
                                <div class="d-flex align-items-center">
                                    <div class="flex-grow-1">
                                        <?= $_SESSION['admin_name'] ?>
                                    </div>
                                </div>
                                <small><?= $_SESSION['admin_email'] ?></small>
                            </div>
                        </a>
                    </div>
                    <div class="menu-header">แถบนำทาง</div>
                    <div class="menu-item has-sub active">
                        <a href="javascript:;" class="menu-link">
                            <div class="menu-icon">
                                <i class="material-icons">report</i>
                            </div>
                            <div class="menu-text">ระบบแจ้งปรับปรุง</div>
                            <div class="menu-caret"></div>
                        </a>
                        <div class="menu-submenu">
                            <div class="menu-item">
                                <a href="./hdc.php" class="menu-link">
                                    <div class="menu-text">การใช้งานระบบเว็บไซต์ HDC</div>
                                </a>
                            </div>
                            <div class="menu-item">
                                <a href="./web.php" class="menu-link">
                                    <div class="menu-text">การใช้งานระบบเว็บไซต์ สสจ.อุทัยธานี</div>
                                </a>
                            </div>
                            <div class="menu-item">
                                <a href="./report.php" class="menu-link">
                                    <div class="menu-text">การขอรายงาน จากกลุ่มงานสุขภาพดิจิทัล</div>
                                </a>
                            </div>
                            <div class="menu-item">
                                <a href="./other.php" class="menu-link">
                                    <div class="menu-text">อื่น ๆ</div>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- END menu -->
            </div>
            <!-- END scrollbar -->
        </div>
        <div class="app-sidebar-bg"></div>
        <div class="app-sidebar-mobile-backdrop"><a href="#" data-dismiss="app-sidebar-mobile"
                class="stretched-link"></a></div>
        <!-- END #sidebar -->

        <!-- BEGIN #content -->
        <div id="content" class="app-content">
            <!-- BEGIN page-header -->
            <h1 class="page-header"><?php if ($_SERVER['PHP_SELF'] == "/ITHelpdesk/Views/Users/hdc.php") {
                echo "การใช้งานระบบเว็บไซต์ HDC ";
            } else if ($_SERVER['PHP_SELF'] == "/ITHelpdesk/Views/Users/web.php") {
                echo "การใช้งานระบบเว็บไซต์ สสจ.อุทัยธานี";
            } else if ($_SERVER["PHP_SELF"] == "/ITHelpdesk/Views/Users/report.php") {
                echo "การขอรายงาน จากกลุ่มงานสุขภาพดิจิทัล";
            } else if ($_SERVER["PHP_SELF"] == "/ITHelpdesk/Views/Users/other.php") {
                echo "อื่น ๆ";
            } else {
                echo "ระบบ IT Helpdesk ";
            }
            ?><small>กลุ่มงานสุขภาพดิจิทัล สสจ.อุทัยธานี</small></h1>
            <!-- END page-header -->
            <!-- BEGIN panel -->
            <div class="card">
                <div class="card-body">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-3">
                                <?php
                                $result_hdc = $hdc->get_hdc_count();
                                $result_web = $web->get_web_count();
                                $result_report = $report->get_report_count();
                                $result_other = $other->get_other_count();
                                ?>
                                <!-- begin widget-stats -->
                                <div class="widget widget-stats bg-teal mb-10px">
                                    <div class="stats-icon stats-icon-lg"><i class="fa fa-book fa-fw"></i></div>
                                    <div class="stats-content">
                                        <div class="stats-title">การใช้งานระบบเว็บไซต์ HDC</div>
                                        <div class="stats-number"><?= $result_hdc ?></div>
                                        <div class="stats-desc"></div>
                                    </div>
                                </div>
                                <!-- end widget-stats -->

                            </div>
                            <div class="col-3"> <!-- begin widget-stats -->
                                <div class="widget widget-stats bg-blue mb-10px">
                                    <div class="stats-icon stats-icon-lg"><i class="fa fa-globe fa-fw"></i></div>
                                    <div class="stats-content">
                                        <div class="stats-title">การใช้งานระบบเว็บไซต์ สสจ.อุทัยธานี </div>
                                        <div class="stats-number"><?= $result_web ?></div>
                                        <div class="stats-desc"></div>
                                    </div>
                                </div>
                                <!-- end widget-stats -->
                            </div>
                            <div class="col-3"> <!-- begin widget-stats -->
                                <div class="widget widget-stats bg-warning mb-10px">
                                    <div class="stats-icon stats-icon-lg"><i class="fa fa-file fa-fw"></i></div>
                                    <div class="stats-content">
                                        <div class="stats-title">การขอรายงาน จากกลุ่มงานสุขภาพดิจิทัล</div>
                                        <div class="stats-number"><?= $result_report ?></div>
                                        <div class="stats-desc"></div>
                                    </div>
                                </div>
                                <!-- end widget-stats -->
                            </div>
                            <div class="col-3"> <!-- begin widget-stats -->
                                <div class="widget widget-stats bg-gray mb-10px">
                                    <div class="stats-icon stats-icon-lg"><i class="fa fa-comment fa-fw"></i></div>
                                    <div class="stats-content">
                                        <div class="stats-title">อื่น ๆ</div>
                                        <div class="stats-number"><?= $result_other ?></div>
                                        <div class="stats-desc"></div>
                                    </div>
                                </div>
                                <!-- end widget-stats -->
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <div id="nv-donut-chart" class="h-500px d-flex justify-content-center" style="width: 100%;">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- END panel -->
        </div>
        <!-- END #content -->

        <!-- BEGIN scroll-top-btn -->
        <a href="javascript:;" class="btn btn-icon btn-circle btn-success btn-scroll-to-top"
            data-toggle="scroll-to-top"><i class="fa fa-angle-up"></i></a>
        <!-- END scroll-top-btn -->
    </div>
    <!-- END #app -->

    <!-- ================== BEGIN core-js ================== -->
    <script src="../../Assets/js/vendor.min.js"></script>
    <script src="../../Assets/js/app.min.js"></script>
    <script src="../../Assets/plugins/d3/d3.min.js"></script>
    <script src="../../Assets/plugins/nvd3/build/nv.d3.min.js"></script>
    <!-- ================== END core-js ================== -->
    <script>
        var pieChartData = [
            { 'label': 'HDC', 'value': <?= $result_hdc ?>, 'color': "#009688" },
            { 'label': 'WEB', 'value': <?= $result_web ?>, 'color': "#4284F3" },
            { 'label': 'Report', 'value': <?= $result_report ?>, 'color': "#FF9800" },
            { 'label': 'Other', 'value': <?= $result_other ?>, 'color': "#7A7A7A" },
        ];

        nv.addGraph(function () {
            var chart = nv.models.pieChart()
                .x(function (d) { return d.label })
                .y(function (d) { return d.value })
                .showLabels(true)
                .labelThreshold(.05)
                .labelType("percent")
                .donut(true)
                .donutRatio(0.35);

            d3.select('#nv-donut-chart').append('svg')
                .datum(pieChartData)
                .transition().duration(350)
                .call(chart);
            return chart;
        });
    </script>
</body>

</html>