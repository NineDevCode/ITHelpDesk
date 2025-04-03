<?php
// filepath: c:\xampp\htdocs\ITHelpdesk\callback.php
require_once 'vendor/autoload.php';

use Dotenv\Dotenv;

session_start();

// Load environment variables
$dotenv = Dotenv::createImmutable('./');
$dotenv->load();

// Configure Google Client
$client = new Google_Client();
$client->setClientId($_ENV['GOOGLE_CLIENT_ID']);
$client->setClientSecret($_ENV['GOOGLE_CLIENT_SECRET']);
$client->setRedirectUri($_ENV['GOOGLE_REDIRECT_URI']);
$client->addScope('email');
$client->addScope('profile');

if (isset($_GET['code'])) {
    $token = $client->fetchAccessTokenWithAuthCode($_GET['code']);
    $client->setAccessToken($token);

    // Get user profile information
    $googleService = new Google_Service_Oauth2($client);
    $userInfo = $googleService->userinfo->get();

    // Store user information in session or database
    $_SESSION['user'] = [
        'id' => $userInfo->id,
        'email' => $userInfo->email,
        'name' => $userInfo->name,
        'picture' => $userInfo->picture,
    ];

    // Redirect to dashboard or home page
    header('Location: ./Views/Users/Home.php');
    exit();
} else {
    echo 'Authentication failed.';
}
?>