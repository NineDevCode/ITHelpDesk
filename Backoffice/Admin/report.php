<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Include Composer's autoloader
require_once __DIR__ . '/../../vendor/autoload.php';
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
    <link href="../../Assets/plugins/bootstrap-datepicker/dist/css/bootstrap-datepicker.css" rel="stylesheet" />
    <link href="../../Assets/plugins/datatables.net-bs5/css/dataTables.bootstrap5.min.css" rel="stylesheet" />
    <link href="../../Assets/plugins/datatables.net-responsive-bs5/css/responsive.bootstrap5.min.css"
        rel="stylesheet" />
    <link href="../../Assets/css/vendor.min.css" rel="stylesheet" />
    <link href="../../Assets/css/google/app.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="../../Assets/css/mystyle.css">
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
                            <div class="menu-item ">
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
            <h1 class="page-header"><?php if ($_SERVER['PHP_SELF'] == "/ITHelpdesk/Backoffice/Admin/hdc.php") {
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
            <div class="card">
                <div class="card-body">
                    <table id="data-table-default" class="table table-striped table-bordered align-middle w-100">
                        <thead>
                            <tr>
                                <th class="text-nowrap">ID</th>
                                <th class="text-nowrap">ชื่อ - นามสกุล</th>
                                <th class="text-nowrap">หน่วยบริการ</th>
                                <th class="text-nowrap">แผนก / กลุ่มงาน</th>
                                <th class="text-nowrap">อีเมล</th>
                                <th class="text-nowrap">เบอร์โทรศัพท์</th>
                                <th class="text-nowrap">สถานะ</th>
                                <th class="text-nowrap">เครื่องมือ</th>
                            </tr>
                        </thead>
                        <tbody>

                        </tbody>
                    </table>
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
    <script src="../../Assets/plugins/datatables.net/js/jquery.dataTables.min.js"></script>
    <script src="../../Assets/plugins/datatables.net-bs5/js/dataTables.bootstrap5.min.js"></script>
    <script src="../../Assets/plugins/datatables.net-responsive/js/dataTables.responsive.min.js"></script>
    <script src="../../Assets/plugins/datatables.net-responsive-bs5/js/responsive.bootstrap5.min.js"></script>
    <!-- ================== END core-js ================== -->
    <script src="../../Assets/plugins/sweetalert/dist/sweetalert.min.js"></script>
    <script>
        <?php
        if (isset($_SESSION['accept_report'])) {
            if ($_SESSION['accept_report'] == 'success') { ?>
                swal({
                    title: 'รับงานสำเร็จ!',
                    text: 'โปรดดำเนินการและติดต่อกลับผู้ใช้ทางอีเมล',
                    icon: 'success',
                    buttons: {
                        confirm: {
                            text: 'รับทราบ',
                            value: true,
                            visible: true,
                            className: 'btn btn-success',
                            closeModal: true
                        }
                    }
                });
                <?php
                $_SESSION['accept_report'] = '';
            }
            if ($_SESSION['accept_report'] == 'false') {
                ?>
                swal({
                    title: 'รับงานไม่สำเร็จ!',
                    text: 'โปรดติดต่อผู้ผัฒนาระบบ',
                    icon: 'error',
                    buttons: {
                        confirm: {
                            text: 'รับทราบ',
                            value: true,
                            visible: true,
                            className: 'btn btn-success',
                            closeModal: true
                        }
                    }
                });
                <?php
                $_SESSION['accept_report'] = '';
            }
        }
        ?>
        <?php
        if (isset($_SESSION['cancel_report'])) {
            if ($_SESSION['cancel_report'] == 'success') { ?>
                swal({
                    title: 'ยกเลิกงานสำเร็จ!',
                    text: 'โปรดดำเนินการและติดต่อกลับผู้ใช้ทางอีเมล',
                    icon: 'success',
                    buttons: {
                        confirm: {
                            text: 'รับทราบ',
                            value: true,
                            visible: true,
                            className: 'btn btn-success',
                            closeModal: true
                        }
                    }
                });
                <?php
                $_SESSION['cancel_report'] = '';
            }
            if ($_SESSION['cancel_report'] == 'false') {
                ?>
                swal({
                    title: 'ยกเลิกงานไม่สำเร็จ!',
                    text: 'โปรดติดต่อผู้ผัฒนาระบบ',
                    icon: 'error',
                    buttons: {
                        confirm: {
                            text: 'รับทราบ',
                            value: true,
                            visible: true,
                            className: 'btn btn-success',
                            closeModal: true
                        }
                    }
                });
                <?php
                $_SESSION['cancel_report'] = '';
            }
        }
        ?>
        <?php
        if (isset($_SESSION['finish_report'])) {
            if ($_SESSION['finish_report'] == 'success') {
                ?>
                swal({
                    title: 'ปิดงานสำเร็จ!',
                    icon: 'success',
                    buttons: {
                        confirm: {
                            text: 'รับทราบ',
                            value: true,
                            visible: true,
                            className: 'btn btn-success',
                            closeModal: true
                        }
                    }
                });
                <?php
                $_SESSION['finish_report'] = '';
            } else if ($_SESSION['finish_report'] == 'false') {
                ?>
                    swal({
                        title: 'ปิดงานไม่สำเร็จ!',
                        icon: 'success',
                        buttons: {
                            confirm: {
                                text: 'รับทราบ',
                                value: true,
                                visible: true,
                                className: 'btn btn-success',
                                closeModal: true
                            }
                        }
                    });
                    <?php
                    $_SESSION['finish_report'] = '';
            }
        }
        ?>
    </script>
    <script>
        $('#data-table-default').DataTable({
            responsive: true,
            ajax: {
                url: '../../Routes/ajax.php?ajax_name=report',
                type: 'GET',
            },
            columns: [
                { data: "report_id" },
                { data: "name" },
                { data: "hoscode_name" },
                { data: "department_name" },
                { data: "email" },
                { data: "tel" },
                { data: "status" },
                { data: "tool" },
            ],
            order: [[0, 'desc']],
        });
    </script>
</body>

</html>