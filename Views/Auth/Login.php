<?php
require '../../vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../../');
$dotenv->load();

try {
	$client = new Google_Client();
	$client->setClientId($_ENV['GOOGLE_CLIENT_ID']);
	$client->setClientSecret($_ENV['GOOGLE_CLIENT_SECRET']);
	$client->setRedirectUri($_ENV['GOOGLE_REDIRECT_URI']);
	$client->addScope('email');
	$client->addScope('profile');
	$loginUrl = $client->createAuthUrl();
} catch (Exception $e) {
	echo 'Google Client Error: ' . $e->getMessage();
	exit;
}

$client_id = $_ENV['CLIENT_ID'];
$redirect_uri = $_ENV['REDIRECT_URI'];
$scope = 'pid name birthdate openid';
$state = bin2hex(random_bytes(8));

$_SESSION['oauth2state'] = $state;

$url = "https://imauth.bora.dopa.go.th/api/v2/oauth2/auth?"
	. http_build_query([
		'response_type' => 'code',
		'client_id' => $client_id,
		'redirect_uri' => $redirect_uri,
		'scope' => $scope,
		'state' => $state,
	]);
?>
<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="utf-8" />
	<title>Color Admin | Login</title>
	<meta content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" name="viewport" />
	<meta content="" name="description" />
	<meta content="" name="author" />

	<!-- ================== BEGIN core-css ================== -->
	<link href="https://fonts.googleapis.com/css?family=Roboto:100,300,400,500,700,900" rel="stylesheet" />
	<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet" />
	<link href="../../Assets/css/vendor.min.css" rel="stylesheet" />
	<link href="../../Assets/css/google/app.min.css" rel="stylesheet" />
	<!-- ================== END core-css ================== -->
	<style>
		.btn-thaid {
			background-color: #0C0E57;
			color: white;
		}
		.btn-thaid:hover{
			background-color:rgb(58, 60, 141);
			color: white;
		}
	</style>
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
		<div class="login login-v1" style="background-image: url(../../Assets/img/login-bg/bg_hospital.png);">
			<!-- BEGIN login-container -->
			<div class="login-container">
				<!-- BEGIN login-header -->
				<div class="login-header">
					<div class="brand">
						<div class="text-white">
							<b>IT </b>HelpDesk
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
						<form action="index.html" method="GET">
							<div class="login-buttons">
								<a href="<?php echo htmlspecialchars($loginUrl); ?>"
									class="btn h-45px btn-danger d-block w-100 btn-lg"><i class="fab fa-google"></i>
									เข้าสู่ระบบด้วย Google</a>
								<a href="<?= $url ?>" class="btn btn-thaid d-block w-100 btn-lg h-45px my-2"><img
										src="../../Assets/img/logo/logo-thaid.jpeg" alt="" style="height: 100%;"
										class="rounded">&nbsp;เข้าสู่ระบบด้วย ThaID</a>
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