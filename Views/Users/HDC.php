<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Include Composer's autoloader
require_once __DIR__ . '/../../vendor/autoload.php';
include "../../Class/Connect.php";
include "../../Class/Class.php";
include "../../Routes/middleware.php";

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

authMiddlewareUser();

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../../');
$dotenv->load();

$hoscode = new Hoscode;
$department = new Department;

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
            <form action="../../Routes/routes.php?route_name=hdc_create" method="POST" enctype="multipart/form-data">
                <!-- END page-header -->
                <!-- BEGIN panel -->
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
                                    <select name="hoscode_id" id="hoscode_id" class="form-select hoscode_slelct"
                                        required>
                                        <option value="" disabled selected></option>
                                        <?php
                                        $result = $hoscode->get_hoscode();
                                        foreach ($result as $item) {
                                            ?>
                                            <option value="<?= $item['hoscode_id'] ?>">
                                                <?= $item['hoscode_id'] . " " . $item['name'] ?>
                                            </option>
                                        <?php } ?>
                                    </select>
                                </div>
                                <div class="col-6">
                                    <select name="department_id" id="department_id" class="form-select department"
                                        required>
                                        <option value="">
                                        </option>
                                        <?php
                                        $departments = $department->get_departments();
                                        foreach ($departments as $item) {
                                            ?>
                                            <option value="<?= $item['department_id'] ?>"><?= $item['department_name'] ?>
                                            </option>
                                        <?php } ?>
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
                        <h6>รายละเอียดปัญหา</h6>
                    </div>
                    <div class="card-body">
                        <div class="container">
                            <div class="row my-3">
                                <div class="col-6">
                                    <input type="text" name="urlpage" id="urlpage" class="form-control"
                                        placeholder="URL ของหน้าเว็บที่ต้องการให้ปรับปรุง" required>
                                    <textarea name="promblemdetail" id="promblemdetail" class="form-control mt-2"
                                        placeholder="รายละเอียดของปัญหาที่พบ" rows="8" required></textarea>
                                </div>
                                <div class="col-6">
                                    <label for="problemtype" class="my-2">ประเภทของปัญหาที่พบ
                                        (เลือกได้มากกว่าหนึ่งข้อ)</label>
                                    <div class="form-check my-2">
                                        <input class="form-check-input" type="checkbox" id="checkbox1" name="promlem1"
                                            value="เว็บไซต์โหลดช้า" />
                                        <label class="form-check-label" for="promlem1">เว็บไซต์โหลดช้า</label>
                                    </div>
                                    <div class="form-check my-2">
                                        <input class="form-check-input" type="checkbox" id="checkbox2" name="promlem2"
                                            value="เว็บไซต์ไม่สามารถเข้าใช้งานได้" />
                                        <label class="form-check-label"
                                            for="promlem2">เว็บไซต์ไม่สามารถเข้าใช้งานได้</label>
                                    </div>
                                    <div class="form-check my-2">
                                        <input class="form-check-input" type="checkbox" id="promlem3" name="promlem3"
                                            value="ลิงก์ไม่ทำงาน" />
                                        <label class="form-check-label" for="promlem3">ลิงก์ไม่ทำงาน</label>
                                    </div>
                                    <div class="form-check my-2">
                                        <input class="form-check-input" type="checkbox" id="checkbox4" name="promlem4"
                                            value="ข้อความแสดงข้อผิดพลาด (Error
                                            Message)" />
                                        <label class="form-check-label" for="promlem4">ข้อความแสดงข้อผิดพลาด (Error
                                            Message)</label>
                                    </div>
                                    <div class="form-check my-2">
                                        <input class="form-check-input" type="checkbox" id="promlem5" name="promlem5"
                                            value="ปัญหาการเข้าสู่ระบบ/สมัครสมาชิก" />
                                        <label class="form-check-label"
                                            for="promlem5">ปัญหาการเข้าสู่ระบบ/สมัครสมาชิก</label>
                                    </div>
                                    <div class="form-check my-2 d-flex align-items-center">
                                        <input class="form-check-input me-2" type="checkbox" id="promlem6"
                                            name="promlem6" onclick="handleOther(event)" value="อื่น ๆ" />
                                        <label class="form-check-label" for="promlem6" class="me-2">อื่น ๆ
                                        </label>
                                        <div id="otherProblem" class="mt-2">
                                        </div>
                                    </div>

                                </div>
                            </div>
                            <div class="row my-3">
                                <div class="col-6">
                                    <input type="file" name="image" id="image" class="form-control"
                                        placeholder="แนบไฟล์ภาพหน้าจอ (ถ้ามี)">
                                </div>
                                <div class="col-6">
                                    <input type="text" name="detail" id="detail" class="form-control"
                                        placeholder="รายละเอียดเพิ่มเติ่ม">
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
    <script src="../../Assets/plugins/select2/dist/js/select2.min.js"></script>
    <script>
        $(".hoscode_slelct").select2({ placeholder: "โปรดเลือกหน่วยบริการ" });
        $(".department").select2({ placeholder: "โปรดเลือกแผนก / กลุ่มงาน" });
    </script>
    <!-- ================== END core-js ================== -->
</body>

</html>