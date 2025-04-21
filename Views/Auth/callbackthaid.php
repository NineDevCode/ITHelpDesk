<?php
session_start();
require_once 'vendor/autoload.php';

use Dotenv\Dotenv;
$dotenv = Dotenv::createImmutable(__DIR__);
$dotenv->load();

if (!isset($_GET['code'], $_GET['state']) || $_GET['state'] !== $_SESSION['oauth2state']) {
    exit('Invalid state or missing code.');
}

$token_url = 'https://imauth.bora.dopa.go.th/api/v2/oauth2/token/';
$client_id = $_ENV['CLIENT_ID'];
$client_secret = $_ENV['CLIENT_SECRET'];
$redirect_uri = $_ENV['REDIRECT_URI'];

$headers = [
    'Authorization: Basic ' . base64_encode("$client_id:$client_secret"),
    'Content-Type: application/x-www-form-urlencoded'
];

$data = http_build_query([
    'grant_type' => 'authorization_code',
    'code' => $_GET['code'],
    'redirect_uri' => $redirect_uri,
]);

$options = [
    'http' => [
        'method' => 'POST',
        'header' => implode("\r\n", $headers),
        'content' => $data,
    ],
];

$response = file_get_contents($token_url, false, stream_context_create($options));
$result = json_decode($response, true);

if (!isset($result['id_token'])) {
    exit('Failed to retrieve id_token');
}

$jwt_parts = explode('.', $result['id_token']);
$payload = json_decode(base64_decode($jwt_parts[1]), true);

$_SESSION['user'] = $payload;
header('Location: ../Users/index.php');
exit;
?>