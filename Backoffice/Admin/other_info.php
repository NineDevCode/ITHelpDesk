<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Include Composer's autoloader
require_once __DIR__ . '/../../vendor/autoload.php';
include '../../Class/Class.php';
include "../../Routes/middleware.php";

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

authMiddlewareAdmin();

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../../');
$dotenv->load();

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
    <link href="../../Assets/plugins/lightbox2/dist/css/lightbox.css" rel="stylesheet" />
    <link href="../../Assets/css/vendor.min.css" rel="stylesheet" />
    <link href="../../Assets/css/google/app.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="../../Assets/css/mystyle.css">
    <!-- ================== END core-css ================== -->
    <style>
        .gallery .image {
            width: 100%;
        }
    </style>
</head>

<body>
    <!-- BEGIN #loader -->
    <div id="loader" class="app-loader">
        <span class="spinner"></span>
    </div>
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
                <a href="index.php" class="navbar-brand">
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
                        <a href="../Auth/logout.php" class="dropdown-item">ออกจากระบบ</a>
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
                    <div class="menu-item">
                        <a href="./index.php" class="menu-link">
                            <div class="menu-icon">
                                <i class="material-icons">donut_small</i>
                            </div>
                            <div class="menu-text">ภาพรวมระบบ</div>
                        </a>
                    </div>
                    <div class="menu-item has-sub active">
                        <a href="javascript:;" class="menu-link">
                            <div class="menu-icon">
                                <i class="material-icons">report</i>
                            </div>
                            <div class="menu-text">ระบบแจ้งปรับปรุง</div>
                            <div class="menu-caret"></div>
                        </a>
                        <div class="menu-submenu">
                            <div class="menu-item active">
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
            <h1 class="page-header">รายละเอียดข้อมูล <?php if ($_SERVER['PHP_SELF'] == "/ITHelpdesk/Backoffice/Admin/hdc.php") {
                echo "การใช้งานระบบเว็บไซต์ HDC ";
            } else if ($_SERVER['PHP_SELF'] == "/ITHelpdesk/Backoffice/Admin/web.php") {
                echo "การใช้งานระบบเว็บไซต์ สสจ.อุทัยธานี";
            } else if ($_SERVER["PHP_SELF"] == "/ITHelpdesk/Backoffice/Admin/report.php") {
                echo "การขอรายงาน จากกลุ่มงานสุขภาพดิจิทัล";
            } else if ($_SERVER["PHP_SELF"] == "/ITHelpdesk/Backoffice/Admin/orther.php") {
                echo "อื่น ๆ";
            } else {
                echo "ระบบ IT Helpdesk ";
            }
            ?><small>กลุ่มงานสุขภาพดิจิทัล สสจ.อุทัยธานี</small></h1>
            <?php
            $other = new Other();
            $other_info = $other->get_other_byid($_GET['other_id']);
            ?>
            <div class="card">
                <div class="card-header">
                    <h6>ข้อมูลทั่วไป</h6>
                </div>
                <div class="card-body">
                    <div class="container">
                        <div class="row my-3">
                            <div class="col-2">
                                <select name="titlename" id="titlename" class="form-select" disabled>
                                    <option value="" <?php if ($other_info['titlename'] == '') {
                                        echo 'selected';
                                    } ?>>โปรดเลือกคำนำหน้าชื่อ
                                    </option>
                                    <option value="นาย" <?php if ($other_info['titlename'] == 'นาย') {
                                        echo 'selected';
                                    } ?>>นาย</option>
                                    <option value="นางสาว" <?php if ($other_info['titlename'] == 'นางสาว') {
                                        echo 'selected';
                                    } ?>>นางสาว
                                    </option>
                                    <option value="นาง" <?php if ($other_info['titlename'] == 'นาง') {
                                        echo 'selected';
                                    } ?>>นาง</option>
                                </select>
                            </div>
                            <div class="col-5">
                                <input type="text" name="firstname" id="firstname" class="form-control"
                                    placeholder="ชื่อ" value="<?= $other_info['firstname'] ?>" readonly>
                            </div>
                            <div class="col-5">
                                <input type="text" name="lastname" id="lastname" class="form-control"
                                    placeholder="นามสกุล" required value="<?= $other_info['lastname'] ?>" readonly>
                            </div>
                        </div>
                        <div class="row my-3">
                            <div class="col-6">
                                <select name="hoscode_id" id="hoscode_id" class="form-select hoscode_slelct" disabled>
                                    <option value="<?= $other_info['hoscode_id'] ?>"><?= $other_info['name'] ?></option>
                                </select>
                            </div>
                            <div class="col-6">
                                <select name="department_id" id="department_id" class="form-select" disabled>
                                    <option value="<?= $other_info['department_id'] ?>">
                                        <?= $other_info['department_name'] ?>
                                    </option>
                                </select>
                            </div>
                        </div>
                        <div class="row my-3">
                            <div class="col-6">
                                <input type="email" name="email" id="email" class="form-control" placeholder="อีเมล"
                                    value="<?= $other_info['email'] ?>" readonly>
                            </div>
                            <div class="col-6">
                                <input type="text" name="tel" id="tel" class="form-control" placeholder="เบอร์โทรศัพท์"
                                    value="<?= $other_info['tel'] ?>" readonly>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card mt-3">
                <div class="card-header">
                    <h6>รายละเอียดปัญหา</h6>
                </div>
                <div class="card-body">
                    <div class="container">
                        <div class="row">
                            <div class="col-12">
                                <textarea type="text" name="question" id="question" class="form-control" rows="5"
                                    readonly><?= $other_info['question'] ?></textarea>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <?php if ($other_info['status'] == 'finished') { ?>
                <div class="card mt-3">
                    <div class="card-header">
                        รายระเอียดการจบงาน
                    </div>
                    <div class="card-body">
                        <div class="container">
                            <div class="row">
                                <div class="col-12">
                                    <textarea name="finish_detail" id="finish_detail" class="form-control" rows="5"
                                        readonly><?= $other_info['finish_detail'] ?></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <?php } ?>
            <div class="container">
                <div class="row my-3">
                    <div class="col-12 d-flex justify-content-end">
                        <button type="button" class="btn btn-danger" onclick="redirectToPreviousPage()">กลับ</button>
                        <script>
                            function redirectToPreviousPage() {
                                window.history.back();
                            }
                        </script>
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

    <script>
        function handleOther() {
            var checkbox = document.getElementById("promlem6");
            var otherProblemContainer = document.getElementById("otherProblem");

            if (checkbox.checked) {
                // Check if the input already exists to avoid duplicates
                if (!document.getElementById("otherProblemInput")) {
                    var otherInput = document.createElement("input");
                    otherInput.type = "text";
                    otherInput.name = "otherProblem";
                    otherInput.id = "otherProblemInput"; // Unique ID for the input
                    otherInput.className = "form-control ms-2";
                    otherInput.placeholder = "กรุณาระบุปัญหาอื่น ๆ";
                    otherProblemContainer.appendChild(otherInput);
                }
            } else {
                // Remove the input if it exists
                var otherInput = document.getElementById("otherProblemInput");
                if (otherInput) {
                    otherInput.remove();
                }
            }
        }
    </script>
    <!-- ================== BEGIN core-js ================== -->
    <script src="../../Assets/js/vendor.min.js"></script>
    <script src="../../Assets/js/app.min.js"></script>
    <script src="../../Assets/plugins/bootstrap-datepicker/dist/js/bootstrap-datepicker.js"></script>
    <script src="../../Assets/plugins/isotope-layout/dist/isotope.pkgd.min.js"></script>
    <script src="../../Assets/plugins/lightbox2/dist/js/lightbox.min.js"></script>
    <script src="../../Assets/js/demo/gallery.demo.js"></script>
    <!-- ================== END core-js ================== -->
</body>

</html>