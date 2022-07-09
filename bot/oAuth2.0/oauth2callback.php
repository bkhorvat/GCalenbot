<?php
session_start();
require $_SERVER['DOCUMENT_ROOT'].'/vendor/autoload.php';
require_once $_SERVER['DOCUMENT_ROOT'].'/bot/databaseconnect.php';

$chat_id = $_SESSION['chat_id'];
$access_token = $_SESSION['access_token']['access_token'];

$sql = "INSERT INTO Users (chat_id, access_token) VALUES ('$chat_id', '$access_token')";
$conn->exec($sql);

$stmt = $conn->prepare("SELECT access_token FROM Users WHERE chat_id=?");
$stmt->execute([$chat_id]);
$user = $stmt->fetch();

if($access_token != $user['access_token']){
  $sql = "UPDATE Users SET access_token=? WHERE chat_id=?";
  $conn->prepare($sql)->execute([$access_token, $chat_id]);
}

$client = new Google\Client;
$client->setAuthConfig('client_secret_577470576859-cr1ili98sk47a0n5ct0vs0gh2b7jkb9c.apps.googleusercontent.com.json');
$client->setScopes(Google_Service_Calendar::CALENDAR);
$client->setRedirectUri('https://' . $_SERVER['HTTP_HOST'] . '/bot/oAuth2.0/oauth2callback.php');
$client->setAccessType('offline');

if (! isset($_GET['code'])) {
  $auth_url = $client->createAuthUrl();
  header('Location: ' . filter_var($auth_url, FILTER_SANITIZE_URL));
} else {
  $client->authenticate($_GET['code']);
  $_SESSION['access_token'] = $client->getAccessToken();
  $newToken = $_SESSION['access_token']['access_token'];

  if($newToken != $user['access_token']){
    $sql = "UPDATE Users SET access_token=? WHERE chat_id=?";
    $conn->prepare($sql)->execute([$newToken, $chat_id]);
  }
  $redirect_uri = 'tg://resolve?domain=GCalenbot';
  header('Location: ' . filter_var($redirect_uri, FILTER_SANITIZE_URL));
}
