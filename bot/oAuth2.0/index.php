<?php
session_start();

require $_SERVER['DOCUMENT_ROOT'].'/vendor/autoload.php';

if(isset($_GET['chat_id'])){
  $_SESSION['chat_id'] = $_GET['chat_id'];
}

$a = 'https://' . $_SERVER['HTTP_HOST'] . '/oauth2callback.php';

  $client = new Google\Client;
  $client->setAuthConfig('client_secret_577470576859-cr1ili98sk47a0n5ct0vs0gh2b7jkb9c.apps.googleusercontent.com.json');
  $client->setScopes(Google_Service_Calendar::CALENDAR);
  $client->setRedirectUri('https://' . $_SERVER['HTTP_HOST'] . '/bot/oAuth2.0/oauth2callback.php');
  $client->setAccessType('offline');
  $auth_url = $client->createAuthUrl();
  header('Location:' . filter_var($auth_url, FILTER_SANITIZE_URL));
