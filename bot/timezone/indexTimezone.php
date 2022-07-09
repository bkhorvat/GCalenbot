<?php
switch ($text)
{
  case 'Timezone':
    require_once 'timezoneCommand.php';
    break;
  case 'Set timezone':
    require_once 'setTimezoneCommand.php';
    break;
  case 'Back to timezone':
    require_once 'bot/timezone/timezoneCommand.php';
    break;
  case 'Back to regions':
    require_once 'bot/timezone/setTimezoneCommand.php';
    break;
}
require_once 'bot/timezone/regionOfTimezoneCommand.php'; //Regions of timzone
require_once 'bot/timezone/selectTimezoneCommand.php'; //Select Timezone
