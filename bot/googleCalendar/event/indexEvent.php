<?php

if(str_starts_with($text, '/event '))
{
  require_once 'addEventCommand.php';
}
if($text == '/event')
{
  require_once 'instructionToAddEventCommand.php';
}

switch ($text)
{
  case 'Next 10 events':
    require_once 'listEventsCommand.php';
    break;
}
