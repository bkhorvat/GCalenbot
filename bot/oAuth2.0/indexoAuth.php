<?php
switch ($text)
{
  case '/start':
    require_once 'bot/commands/startCommand.php';
    break;
  case '/menu':
    require_once 'bot/commands/startCommand.php';
    break;
  case 'Menu':
    require_once 'bot/commands/startCommand.php';
    break;
  case 'Logout':
    require_once 'bot/oAuth2.0/logoutCommand.php';
    break;
}
