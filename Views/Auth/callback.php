<?php
session_start();
require_once '../../vendor/autoload.php';

// Ensure Google API Client classes are loaded
use Google\Client as Google_Client;
use Google\Service\Oauth2 as Google_Service_Oauth2;

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../../');
$dotenv->load();

$client = new Google_Client();
$client->setClientId($_ENV['GOOGLE_CLIENT_ID']);
$client->setClientSecret($_ENV['GOOGLE_CLIENT_SECRET']);
$client->setRedirectUri($_ENV['GOOGLE_REDIRECT_URI']);

if (isset($_GET['code'])) {
    $token = $client->fetchAccessTokenWithAuthCode($_GET['code']);
    $client->setAccessToken($token);

    $oauth2 = new Google_Service_Oauth2($client);
    $userInfo = $oauth2->userinfo->get();

    // Save user info in session
    $_SESSION['user'] = [
        'id' => $userInfo->id,
        'email' => $userInfo->email,
        'name' => $userInfo->name,
        'picture' => $userInfo->picture,
    ];

    // Redirect to the Users page
    header('Location: ../Users/index.php');
    exit;
}else{
    header('Location: ./login.php');
}
?>