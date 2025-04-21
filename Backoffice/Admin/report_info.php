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

$report = new Report();

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
    <link href="../../Assets/plugins/bootstrap-datepicker/dist/css/bootstrap-datepicker.css" rel="stylesheet" />
    <link href="../../Assets/css/vendor.min.css" rel="stylesheet" />
    <link href="../../Assets/css/google/app.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="../../Assets/css/mystyle.css">

    <link href="../../Assets/plugins/lightbox2/dist/css/lightbox.css" rel="stylesheet" />
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
                        <img src="../../Assets/img/user/profile.png" alt="" />
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
                            <div class="menu-item active">
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
                echo "การใช้งานระบบเว็บไซต์ สสจ.อุทัยธานี ";
            } else if ($_SERVER["PHP_SELF"] == "/ITHelpdesk/Views/Users/report.php") {
                echo "การขอรายงาน จากกลุ่มงานสุขภาพดิจิทัล ";
            } else if ($_SERVER["PHP_SELF"] == "/ITHelpdesk/Views/Users/other.php") {
                echo "อื่น ๆ ";
            } else {
                echo "ระบบ IT Helpdesk ";
            }
            ?><small>กลุ่มงานสุขภาพดิจิทัล สสจ.อุทัยธานี</small></h1>
            <!-- END page-header -->
            <!-- BEGIN panel -->
            <?php $report_info = $report->get_report_byid($_GET['report_id']) ?>
            <form action="../../Routes/routes.php?route_name=report_create" method="POST" enctype="multipart/form-data">
                <div class="card">
                    <div class="card-header">
                        <h6>ข้อมูลทั่วไป</h6>
                    </div>
                    <div class="card-body">
                        <div class="container">
                            <div class="row my-3">
                                <div class="col-2">
                                    <select name="titlename" id="titlename" class="form-select" disabled>
                                        <option value="" <?php if ($report_info['titlename'] == '') {
                                            echo 'selected';
                                        } ?>>โปรดเลือกคำนำหน้าชื่อ
                                        </option>
                                        <option value="นาย" <?php if ($report_info['titlename'] == 'นาย') {
                                            echo 'selected';
                                        } ?>>นาย</option>
                                        <option value="นางสาว" <?php if ($report_info['titlename'] == 'นางสาว') {
                                            echo 'selected';
                                        } ?>>นางสาว
                                        </option>
                                        <option value="นาง" <?php if ($report_info['titlename'] == 'นาง') {
                                            echo 'selected';
                                        } ?>>นาง</option>
                                    </select>
                                </div>
                                <div class="col-5">
                                    <input type="text" name="firstname" id="firstname" class="form-control"
                                        placeholder="ชื่อ" value="<?= $report_info['firstname'] ?>" readonly>
                                </div>
                                <div class="col-5">
                                    <input type="text" name="lastname" id="lastname" class="form-control"
                                        placeholder="นามสกุล" value="<?= $report_info['lastname'] ?>" readonly>
                                </div>
                            </div>
                            <div class="row my-3">
                                <div class="col-6">
                                    <select name="hoscode_id" id="hoscode_id" class="form-select" disabled>
                                        <option value="">โปรดเลือกหน่วยงาน</option>
                                        <option value="<?= $report_info['hoscode_id'] ?>" selected>
                                            <?= $report_info['name'] ?>
                                        </option>
                                    </select>
                                </div>
                                <div class="col-6">
                                    <select name="department_id" id="department_id" class="form-select" disabled>
                                        <option value="">โปรดเลือกหน่วยงาน (ถ้าไม่มีไม่ต้องเลือก)
                                        </option>
                                        <option value="<?= $report_info['department_id'] ?>" selected>
                                            <?= $report_info['department_name'] ?>
                                        </option>
                                    </select>
                                </div>
                            </div>
                            <div class="row my-3">
                                <div class="col-6">
                                    <input type="email" name="email" id="email" class="form-control" placeholder="อีเมล"
                                        value="<?= $report_info['email'] ?>" readonly>
                                </div>
                                <div class="col-6">
                                    <input type="text" name="tel" id="tel" class="form-control"
                                        placeholder="เบอร์โทรศัพท์" value="<?= $report_info['tel'] ?>" readonly>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card mt-3">
                    <div class="card-header">
                        <h6>รายละเอียดรายงาน</h6>
                    </div>
                    <div class="card-body">
                        <div class="container">
                            <div class="row my-3">
                                <div class="col-6">
                                    <input type="text" name="reportname" id="reportname" class="form-control"
                                        placeholder="ชื่อหรือประเภทของรายงานที่ต้องการ" required="required"
                                        value="<?= $report_info['reportname'] ?>" readonly>
                                </div>
                                <div class="col-6">
                                    <select name="reporttypedate" id="reporttypedate" class="form-select" disabled>
                                        <option value="<?= $report_info['reporttypedate'] ?>" selected>
                                            <?= $report_info['reporttypedate'] ?>
                                        </option>
                                    </select>
                                </div>
                            </div>
                            <div class="row my-3">
                                <div class="col-6">
                                    <input type="text" name="reportdatedetail" id="reportdatedetail"
                                        class="form-control" placeholder="รายละเอียดช่วงเวลาที่คุณ (ถ้ามี)"
                                        value="<?= $report_info['reportdatedetail'] ?>" readonly>
                                    <div>
                                        <label for="filetype" class="mt-3">รูปแบบของรายงานที่ต้องการ</label>
                                    </div>
                                    <div class="form-check form-check-inline mt-2">
                                        <input class="form-check-input" type="checkbox" id="PDF" name="PDF" value="true"
                                            <?php if ($report_info['PDF'] == true) {
                                                echo "checked";
                                            } ?> disabled />
                                        <label class="form-check-label" for="PDF">ไฟล์ PDF</label>
                                    </div>
                                    <div class="form-check form-check-inline mt-2">
                                        <input class="form-check-input" type="checkbox" id="Excel" name="Excel"
                                            value="true" <?php if ($report_info['Excel'] == true) {
                                                echo "checked";
                                            } ?> disabled />
                                        <label class="form-check-label" for="Excel">ไฟล์ Excel</label>
                                    </div>
                                    <div class="form-check form-check-inline mt-2">
                                        <input class="form-check-input" type="checkbox" id="CSV" name="CSV" value="true"
                                            <?php if ($report_info['CSV'] == true) {
                                                echo "checked";
                                            } ?> disabled />
                                        <label class="form-check-label" for="CSV">ไฟล์ CSV</label>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div>
                                        <label for="reporttype">ประเภทรายงาน</label>
                                    </div>
                                    <div class="form-check form-check-inline my-2">
                                        <input class="form-check-input" type="radio" id="reporttype" name="reporttype"
                                            value="summary" onchange="handleReportTypeDetail()" <?php if ($report_info['reporttype'] == 'summary') {
                                                echo "checked";
                                            } ?> disabled />
                                        <label class="form-check-label" for="reporttype">Summary</label>
                                    </div>
                                    <div class="form-check form-check-inline my-2">
                                        <input class="form-check-input" type="radio" id="reporttype" value="personal"
                                            name="reporttype" onchange="handleReportTypeDetail()" <?php if ($report_info['reporttype'] == 'personal') {
                                                echo "checked";
                                            } ?> disabled />
                                        <label class="form-check-label" for="reporttype">ข้อมูลส่วนบุคคล โปรดระบุ
                                            เนื้อหาข้อมูลที่ต้องการ (ชื่อ ที่อยู่ อายุ เพศ)</label>
                                    </div>
                                    <div id="reporttypedetailcontainer">
                                        <?php if ($report_info['reporttypedetail']) { ?>
                                            <textarea name="reporttypedetail" id="reporttypedetail" class="form-control"
                                                readonly><?= $report_info['reporttypedetail'] ?></textarea>
                                        <?php } ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card mt-3">
                    <div class="card-header">ความเร่งด่วน</div>
                    <div class="card-body">
                        <div class="container">
                            <div class="row">
                                <div class="col-6">
                                    <input type="text" name="reportdate" id="reportdate" class="form-control"
                                        placeholder="วันที่ต้องการรับรายงาน" required
                                        value="<?= $report_info['reportdate'] ?>" readonly>
                                </div>
                                <div class="col-6">
                                    <input type="email" name="emailback" id="emailback" class="form-control"
                                        placeholder="อีเมลที่ต้องการให้ส่งรายงาน"
                                        value="<?= $report_info['emailback'] ?>" readonly>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card mt-3">
                    <div class="card">
                        <div class="card-header">รายละเอียดเพิ่มเติม</div>
                        <div class="card-body">
                            <div class="container">
                                <div class="row">
                                    <div class="col-6">
                                        <label for="image">แนบภาพหน้าจอที่ต้องการ (ถ้ามี)</label>
                                        <?php if ($report_info['image'] != NULL) { ?>
                                            <div id="gallery" class="gallery w-100">
                                                <div class="image gallery-group-1">
                                                    <div class="image-inner">
                                                        <a href="../<?= $report_info['image'] ?>"
                                                            data-lightbox="gallery-group-1" class="w-100">
                                                            <div class="img w-100"
                                                                style="background-image: url('../<?= $report_info['image'] ?>')">
                                                            </div>
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                        <?php } ?>
                                    </div>
                                    <div class="col-6">
                                        <textarea name="reportdetail" id="reportdetail"
                                            placeholder="มีข้อเสนอแนะหรือรายละเอียดเพิ่มเติมเกี่ยวกับรายงาน"
                                            class="form-control mt-2"
                                            readonly><?= $report_info['reportdetail'] ?></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <?php if ($report_info['status'] == 'finished') { ?>
                    <div class="card mt-3">
                        <div class="card-header">
                            รายระเอียดการจบงาน
                        </div>
                        <div class="card-body">
                            <div class="container">
                                <div class="row">
                                    <div class="col-12">
                                        <textarea name="finish_detail" id="finish_detail" class="form-control" rows="5"
                                            readonly><?= $report_info['finish_detail'] ?></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php } ?>
                <div class="container">
                    <div class="row my-3">
                        <div class="col-12 d-flex justify-content-end">
                            <button type="button" class="btn btn-danger"
                                onclick="redirectToPreviousPage()">กลับ</button>
                            <script>
                                function redirectToPreviousPage() {
                                    window.history.back();
                                }
                            </script>
                        </div>
                    </div>
                </div>
            </form>
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
        function handleReportTypeDetail() {
            var radioboxes = document.getElementsByName("reporttype");
            var reportTypeDetailContainer = document.getElementById("reporttypedetailcontainer");

            // Check if the "personal" radio button is selected
            if (radioboxes[1].checked) {
                // Check if the input already exists to avoid duplicates
                if (!document.getElementById("reportTypeDetail")) {
                    var reportTypeDetailInput = document.createElement("input");
                    reportTypeDetailInput.type = "text";
                    reportTypeDetailInput.name = "reporttypedetail";
                    reportTypeDetailInput.id = "reportTypeDetail";
                    reportTypeDetailInput.className = "form-control mt-2";
                    reportTypeDetailInput.placeholder = "กรุณาระบุเนื้อหาข้อมูลที่ต้องการ";
                    reportTypeDetailContainer.appendChild(reportTypeDetailInput);
                }
            } else if (radioboxes[0].checked) {
                var reportTypeDetailInput = document.getElementById("reportTypeDetail");
                if (reportTypeDetailInput) {
                    reportTypeDetailInput.remove();
                }
            }
        }

        function handleOther() {
            var checkbox = document.getElementById("checkbox5");
            var otherProblemContainer = document.getElementById("otherProblem");

            if (checkbox.checked) {
                // Check if the input already exists to avoid duplicates
                if (!document.getElementById("otherProblemInput")) {
                    var otherInput = document.createElement("input");
                    otherInput.type = "text";
                    otherInput.name = "otherProblem";
                    otherInput.id = "otherProblemInput"; // Unique ID for the input
                    otherInput.className = "form-control mt-2";
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
    <script src="../../Assets/plugins/bootstrap-datepicker/dist/locales/bootstrap-datepicker.th.min.js"></script>
    <script src="../../Assets/plugins/isotope-layout/dist/isotope.pkgd.min.js"></script>
    <script src="../../Assets/plugins/lightbox2/dist/js/lightbox.min.js"></script>
    <script src="../../Assets/js/demo/gallery.demo.js"></script>
    <script>
        $("#reportdate").datepicker({
            language: 'th', // Set language to Thai
            format: 'dd/mm/yyyy', // Date format
            todayHighlight: true, // Highlight today's date
            autoclose: true, // Close the datepicker after selecting a date
            thaiyear: true // Enable Buddhist calendar year (พ.ศ.)
        });
    </script>
    <!-- ================== END core-js ================== -->
</body>

</html>