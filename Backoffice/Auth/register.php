<?php
require '../../vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../../');
$dotenv->load();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <title>Color Admin | Backoffice</title>
    <meta content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" name="viewport" />
    <meta content="" name="description" />
    <meta content="" name="author" />

    <!-- ================== BEGIN core-css ================== -->
    <link href="https://fonts.googleapis.com/css?family=Roboto:100,300,400,500,700,900" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet" />
    <link href="../../Assets/css/vendor.min.css" rel="stylesheet" />
    <link href="../../Assets/css/google/app.min.css" rel="stylesheet" />
    <!-- ================== END core-css ================== -->
</head>

<body class='pace-top'>
    <!-- BEGIN #loader -->
    <div id="loader" class="app-loader">
        <span class="spinner"></span>
    </div>
    <!-- END #loader -->


    <!-- BEGIN #app -->
    <div id="app" class="app">
        <!-- BEGIN login -->

        <div class="login login-v1"
            style="background-image: url(../../Assets/img/bg/hospital_background.png); backdrop-filter: blur(20px);">
            <!-- BEGIN login-container -->
            <div class="login-container">
                <!-- BEGIN login-header -->
                <div class="login-header">
                    <div class="brand text-white">
                        <div>
                            <span class="logo">
                            </span> <b>IT</b> Helpdesk <b class="text-danger">Back Office</b>
                        </div>
                    </div>
                    <div class="icon">
                        <i class="fa fa-lock"></i>
                    </div>
                </div>
                <!-- END login-header -->

                <!-- BEGIN login-body -->
                <div class="login-body">
                    <!-- BEGIN login-content -->
                    <div class="login-content fs-13px">
                        <form action="../../Routes/routes.php?route_name=register" method="POST">
                            <div class="form-floating mb-20px">
                                <input type="text" class="form-control fs-13px h-45px" id="username"
                                    placeholder="ชื่อผู้ใช้" name="username" />
                                <label for="username" class="d-flex align-items-center py-0">ชื่อผู้ใช้</label>
                            </div>
                            <div class="form-floating mb-20px">
                                <input type="password" class="form-control fs-13px h-45px" id="password"
                                    placeholder="รหัสผ่าน" name="password" />
                                <label for="password" class="d-flex align-items-center py-0">รหัสผ่าน</label>
                            </div>
                            <select name="titlename" id="titlename" class="form-control my-3" require>
                                <option value="" disabled selected>โปรดเลือกคำนำหน้าชื่อ</option>
                                <option value="นาย">นาย</option>
                                <option value="นางสาว">นางสาว</option>
                                <option value="นาง">นาง</option>
                            </select>
                            <div class="form-floating mb-20px">
                                <input type="text" class="form-control fs-13px h-45px" id="firstname"
                                    placeholder="ชื่อจริง" name="firstname" />
                                <label for="firstname" class="d-flex align-items-center py-0">ชื่อจริง</label>
                            </div>
                            <div class="form-floating mb-20px">
                                <input type="text" class="form-control fs-13px h-45px" id="lastname"
                                    placeholder="นามสกุล" name="lastname" />
                                <label for="lastname" class="d-flex align-items-center py-0">นามสกุล</label>
                            </div>
                            <div class="form-floating mb-20px">
                                <input type="email" class="form-control fs-13px h-45px" id="email"
                                    placeholder="อีเมล" name="email" />
                                <label for="email" class="d-flex align-items-center py-0">อีเมล</label>
                            </div>
                            <div class="login-buttons">
                                <button type="submit"
                                    class="btn h-45px btn-primary d-block w-100 btn-lg">สมัครสมาชิก</button>
                            </div>
                        </form>
                    </div>
                    <!-- END login-content -->
                </div>
                <!-- END login-body -->
            </div>
            <!-- END login-container -->
        </div>
        <!-- END login -->

        <!-- BEGIN scroll-top-btn -->
        <a href="javascript:;" class="btn btn-icon btn-circle btn-success btn-scroll-to-top"
            data-toggle="scroll-to-top"><i class="fa fa-angle-up"></i></a>
        <!-- END scroll-top-btn -->
    </div>
    <!-- END #app -->

    <!-- ================== BEGIN core-js ================== -->
    <script src="../../Assets/js/vendor.min.js"></script>
    <script src="../../Assets/js/app.min.js"></script>
    <!-- ================== END core-js ================== -->
</body>

</html>