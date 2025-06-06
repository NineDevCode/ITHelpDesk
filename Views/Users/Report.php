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

authMiddlewareUser();

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
    <link href="../../Assets/plugins/bootstrap-datepicker/dist/css/bootstrap-datepicker.css" rel="stylesheet" />
    <link href="../../Assets/css/vendor.min.css" rel="stylesheet" />
    <link href="../../Assets/css/google/app.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="../../Assets/css/mystyle.css">
    <link href="../../Assets/plugins/select2/dist/css/select2.min.css" rel="stylesheet" />
    <!-- ================== END core-css ================== -->
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
                        <img src="<?= $_SESSION['user']['picture'] ?>" alt="" />
                        <span class="d-none d-md-inline"><?= $_SESSION['user']['name'] ?></span> <b
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
                                        <?= $_SESSION['user']['name'] ?>
                                    </div>
                                </div>
                                <small><?= $_SESSION['user']['email'] ?></small>
                            </div>
                        </a>
                    </div>
                    <div class="menu-header">แถบนำทาง</div>
                    <div class="menu-item">
                        <a href="./index.php" class="menu-link">
                            <div class="menu-icon">
                                <i class="material-icons">description</i>
                            </div>

                            <div class="menu-text">รายการ</div>
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
            <form action="../../Routes/routes.php?route_name=report_create" method="POST" enctype="multipart/form-data">
                <div class="card">
                    <div class="card-header">
                        <h6>ข้อมูลทั่วไป</h6>
                    </div>
                    <div class="card-body">
                        <div class="container">
                            <div class="row my-3">
                                <div class="col-2">
                                    <select name="titlename" id="titlename" class="form-select" required>
                                        <option value="" disabled selected>โปรดเลือกคำนำหน้าชื่อ</option>
                                        <option value="นาย">นาย</option>
                                        <option value="นางสาว">นางสาว</option>
                                        <option value="นาง">นาง</option>
                                    </select>
                                </div>
                                <div class="col-5">
                                    <input type="text" name="firstname" id="firstname" class="form-control"
                                        placeholder="ชื่อ" required>
                                </div>
                                <div class="col-5">
                                    <input type="text" name="lastname" id="lastname" class="form-control"
                                        placeholder="นามสกุล" required>
                                </div>
                            </div>
                            <div class="row my-3">
                                <div class="col-6">
                                    <select name="hoscode_id" id="hoscode_id" class="form-select hoscode_select"
                                        required>
                                        <option value=""></option>
                                        <?php
                                        $hoscode = new Hoscode();
                                        $hoscode_select = $hoscode->get_hoscode();
                                        foreach ($hoscode_select as $item) {
                                            ?>
                                            <option value="<?= $item['hoscode_id'] ?>">
                                                <?= $item['hoscode_id'] . ' ' . $item['name'] ?>
                                            </option>
                                            <?php
                                        }
                                        ?>
                                    </select>
                                </div>
                                <div class="col-6">
                                    <select name="department_id" id="department_id"
                                        class="form-select department_select" required>
                                        <option value=""></option>
                                        <?php
                                        $department = new Department();
                                        $department_select = $department->get_departments();
                                        foreach ($department_select as $item) {
                                            ?>
                                            <option value="<?= $item['department_id'] ?>"><?= $item['department_name'] ?>
                                            </option>
                                            <?php
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <div class="row my-3">
                                <div class="col-6">
                                    <input type="email" name="email" id="email" class="form-control" placeholder="อีเมล"
                                        required>
                                </div>
                                <div class="col-6">
                                    <input type="text" name="tel" id="tel" class="form-control"
                                        placeholder="เบอร์โทรศัพท์" required>
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
                                        placeholder="ชื่อหรือประเภทของรายงานที่ต้องการ" required>
                                </div>
                                <div class="col-6">
                                    <select name="reporttypedate" id="reporttypedate" class="form-select" required>
                                        <option value="" disabled selected>โปรดเลือกช่วงเวลาของข้อมูลที่ต้องการ</option>
                                        <option value="รายวัน">รายวัน</option>
                                        <option value="รายปี พศ.">รายปี พศ.</option>
                                        <option value="รายปีงบประมาณ">รายปีงบประมาณ</option>
                                        <option value="อื่น ๆ">อื่น ๆ</option>
                                    </select>
                                </div>
                            </div>
                            <div class="row my-3">
                                <div class="col-6">
                                    <input type="text" name="reportdatedetail" id="reportdatedetail"
                                        class="form-control" placeholder="รายละเอียดช่วงเวลาที่คุณ (ถ้ามี)">
                                    <div>
                                        <label for="filetype" class="mt-3">รูปแบบของรายงานที่ต้องการ</label>
                                    </div>
                                    <div class="form-check form-check-inline mt-2">
                                        <input class="form-check-input" type="checkbox" id="PDF" name="PDF"
                                            value="true" />
                                        <label class="form-check-label" for="PDF">ไฟล์ PDF</label>
                                    </div>
                                    <div class="form-check form-check-inline mt-2">
                                        <input class="form-check-input" type="checkbox" id="Excel" name="Excel"
                                            value="true" />
                                        <label class="form-check-label" for="Excel">ไฟล์ Excel</label>
                                    </div>
                                    <div class="form-check form-check-inline mt-2">
                                        <input class="form-check-input" type="checkbox" id="CSV" name="CSV"
                                            value="true" />
                                        <label class="form-check-label" for="CSV">ไฟล์ CSV</label>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div>
                                        <label for="reporttype">ประเภทรายงาน</label>
                                    </div>
                                    <div class="form-check form-check-inline my-2">
                                        <input class="form-check-input" type="radio" id="reporttype" name="reporttype"
                                            value="summary" onchange="handleReportTypeDetail()" />
                                        <label class="form-check-label" for="reporttype">Summary</label>
                                    </div>
                                    <div class="form-check form-check-inline my-2">
                                        <input class="form-check-input" type="radio" id="reporttype" value="personal"
                                            name="reporttype" onchange="handleReportTypeDetail()" />
                                        <label class="form-check-label" for="reporttype">ข้อมูลส่วนบุคคล โปรดระบุ
                                            เนื้อหาข้อมูลที่ต้องการ (ชื่อ ที่อยู่ อายุ เพศ)</label>
                                    </div>
                                    <div id="reporttypedetailcontainer"></div>
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
                                        placeholder="วันที่ต้องการรับรายงาน" required>
                                </div>
                                <div class="col-6">
                                    <input type="email" name="emailback" id="emailback" class="form-control"
                                        placeholder="อีเมลที่ต้องการให้ส่งรายงาน" required>
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
                                        <label for="image">แนบภาพหน้าจอรายงานที่ต้องการ (ถ้ามี)</label>
                                        <input type="file" name="image" id="image" class="form-control mt-2"
                                            placeholder="แนบภาพหน้าจอ (ถ้ามี)">
                                    </div>
                                    <div class="col-6">
                                        <textarea name="reportdetail" id="reportdetail"
                                            placeholder="ข้อเสนอแนะหรือรายละเอียดเพิ่มเติมเกี่ยวกับรายงาน"
                                            class="form-control mt-2"></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="container">
                    <div class="row my-3">
                        <div class="col-12 d-flex justify-content-end">
                            <button type="submit" class="btn btn-primary">ส่งข้อมูล</button>
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
    <script src="../../Assets/plugins/select2/dist/js/select2.min.js"></script>
    <script>
        $("#reportdate").datepicker({
            language: 'th', // Set language to Thai
            format: 'dd/mm/yyyy', // Date format
            todayHighlight: true, // Highlight today's date
            autoclose: true, // Close the datepicker after selecting a date
            thaiyear: true // Enable Buddhist calendar year (พ.ศ.)
        });
    </script>
    <script>
        $(".hoscode_select").select2({ placeholder: "โปรดเลือกหน่วยบริการ" });
        $(".department_select").select2({ placeholder: "โปรดเลือกแผนก / กลุ่มงาน" });
    </script>
    <!-- ================== END core-js ================== -->
</body>

</html>