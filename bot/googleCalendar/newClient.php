<?php
global $access_token;
$client = new Google\Client;
$path = $_SERVER['DOCUMENT_ROOT'].'/bot/oAuth2.0/client_secret_577470576859-cr1ili98sk47a0n5ct0vs0gh2b7jkb9c.apps.googleusercontent.com.json';
$client->setAuthConfig($path);
$client->setScopes(Google_Service_Calendar::CALENDAR);
$client->setAccessType('offline');
$client->setAccessToken($access_token);
