<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
// Include Composer's autoloader
require_once __DIR__ . '/../../vendor/autoload.php';
include '../../Class/Class.php';
include '../../Routes/middleware.php';

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
        @media (min-width: 1200px) {
            .gallery .image {
                width: 100%;
            }
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
            $hdc = new HDC();
            $hdc_info = $hdc->get_hdc_byid($_GET['hdc_id']);
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
                                    <option value="" <?php if ($hdc_info['titlename'] == '') {
                                        echo 'selected';
                                    } ?>>โปรดเลือกคำนำหน้าชื่อ
                                    </option>
                                    <option value="นาย" <?php if ($hdc_info['titlename'] == 'นาย') {
                                        echo 'selected';
                                    } ?>>นาย</option>
                                    <option value="นางสาว" <?php if ($hdc_info['titlename'] == 'นางสาว') {
                                        echo 'selected';
                                    } ?>>นางสาว
                                    </option>
                                    <option value="นาง" <?php if ($hdc_info['titlename'] == 'นาง') {
                                        echo 'selected';
                                    } ?>>นาง</option>
                                </select>
                            </div>
                            <div class="col-5">
                                <input type="text" name="firstname" id="firstname" class="form-control"
                                    placeholder="ชื่อ" value="<?= $hdc_info['firstname'] ?>" readonly>
                            </div>
                            <div class="col-5">
                                <input type="text" name="lastname" id="lastname" class="form-control"
                                    placeholder="นามสกุล" required value="<?= $hdc_info['lastname'] ?>" readonly>
                            </div>
                        </div>
                        <div class="row my-3">
                            <div class="col-6">
                                <select name="hoscode_id" id="hoscode_id" class="form-select hoscode_slelct" disabled>
                                    <option value="<?= $hdc_info['hoscode_id'] ?>"><?= $hdc_info['name'] ?></option>
                                </select>
                            </div>
                            <div class="col-6">
                                <select name="department_id" id="department_id" class="form-select" disabled>
                                    <option value="<?= $hdc_info['department_id'] ?>">
                                        <?= $hdc_info['department_name'] ?>
                                    </option>
                                </select>
                            </div>
                        </div>
                        <div class="row my-3">
                            <div class="col-6">
                                <input type="email" name="email" id="email" class="form-control" placeholder="อีเมล"
                                    value="<?= $hdc_info['email'] ?>" readonly>
                            </div>
                            <div class="col-6">
                                <input type="text" name="tel" id="tel" class="form-control" placeholder="เบอร์โทรศัพท์"
                                    value="<?= $hdc_info['tel'] ?>" readonly>
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
                                    placeholder="URL ของหน้าเว็บที่ต้องการให้ปรับปรุง" required="required"
                                    value="<?= $hdc_info['urlpage'] ?>" readonly>
                                <textarea name="promblemdetail" id="promblemdetail" class="form-control mt-2"
                                    placeholder="รายละเอียดของปัญหาที่พบ" rows="8"
                                    readonly><?= $hdc_info['promblemdetail'] ?></textarea>
                            </div>
                            <div class="col-6">
                                <label for="problemtype" class="my-2">ประเภทของปัญหาที่พบ
                                    (เลือกได้มากกว่าหนึ่งข้อ)</label>
                                <div class="form-check my-2">
                                    <input class="form-check-input" type="checkbox" id="checkbox1" name="promlem1"
                                        value="เว็บไซต์โหลดช้า" <?php if ($hdc_info['promlem1'] != NULL) {
                                            echo 'checked';
                                        } ?> disabled />
                                    <label class="form-check-label" for="promlem1">เว็บไซต์โหลดช้า</label>
                                </div>
                                <div class="form-check my-2">
                                    <input class="form-check-input" type="checkbox" id="checkbox2" name="promlem2"
                                        value="เว็บไซต์ไม่สามารถเข้าใช้งานได้" <?php if ($hdc_info['promlem2'] != NULL) {
                                            echo 'checked';
                                        } ?> disabled />
                                    <label class="form-check-label"
                                        for="promlem2">เว็บไซต์ไม่สามารถเข้าใช้งานได้</label>
                                </div>
                                <div class="form-check my-2">
                                    <input class="form-check-input" type="checkbox" id="promlem3" name="promlem3"
                                        value="ลิงก์ไม่ทำงาน" <?php if ($hdc_info['promlem3'] != NULL) {
                                            echo 'checked';
                                        } ?> disabled />
                                    <label class="form-check-label" for="promlem3">ลิงก์ไม่ทำงาน</label>
                                </div>
                                <div class="form-check my-2">
                                    <input class="form-check-input" type="checkbox" id="checkbox4" name="promlem4"
                                        value="ข้อความแสดงข้อผิดพลาด (Error
                                            Message)" <?php if ($hdc_info['promlem4'] != NULL) {
                                                echo 'checked';
                                            } ?>
                                        disabled />
                                    <label class="form-check-label" for="promlem4">ข้อความแสดงข้อผิดพลาด (Error
                                        Message)</label>
                                </div>
                                <div class="form-check my-2">
                                    <input class="form-check-input" type="checkbox" id="promlem5" name="promlem5"
                                        value="ปัญหาการเข้าสู่ระบบ/สมัครสมาชิก" <?php if ($hdc_info['promlem5'] != NULL) {
                                            echo 'checked';
                                        } ?> disabled />
                                    <label class="form-check-label"
                                        for="promlem5">ปัญหาการเข้าสู่ระบบ/สมัครสมาชิก</label>
                                </div>
                                <div class="form-check my-2 d-flex align-items-center">
                                    <input class="form-check-input me-2" type="checkbox" id="promlem6" name="promlem6"
                                        onclick="handleOther(event)" value="อื่น ๆ" <?php if ($hdc_info['promlem6'] != NULL) {
                                            echo 'checked';
                                        } ?> disabled />
                                    <label class="form-check-label" for="promlem6" class="me-2">อื่น ๆ
                                    </label>
                                    <div id="otherProblem" class="mt-2">
                                        <input type="text" name="otherProblem" class="form-control ms-2" value="<?php if ($hdc_info['promlem6'] != NULL) {
                                            echo $hdc_info['otherProblem'];
                                        } ?>" readonly>
                                    </div>
                                </div>

                            </div>
                        </div>
                        <div class="row my-3">
                            <div class="col-6">
                                <?php if ($hdc_info['image'] != NULL) { ?>
                                    <div id="gallery" class="gallery w-100">
                                        <div class="image gallery-group-1">
                                            <div class="image-inner">
                                                <a href="../<?= $hdc_info['image'] ?>" data-lightbox="gallery-group-1"
                                                    class="w-100">
                                                    <div class="img w-100"
                                                        style="background-image: url('../<?= $hdc_info['image'] ?>')">
                                                    </div>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                <?php } ?>
                            </div>
                            <div class="col-6">
                                <input type="text" name="detail" id="detail" class="form-control"
                                    placeholder="รายละเอียดเพิ่มเติ่ม" value="<?= $hdc_info['detail'] ?>" readonly>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="container">
                <div class="row my-3">
                    <div class="col-12 d-flex justify-content-end">
                        <a href="../../Routes/routes.php?route_name=accept_work_hdc&hdc_id=<?= $_GET['hdc_id'] ?>"
                            class="btn btn-success">รับงาน</a>
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