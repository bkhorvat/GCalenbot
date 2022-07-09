<?php

switch ($text)
{
  case 'Language':
    require_once 'languageCommand.php';
    break;
  case 'Change language':
    require_once 'changeLanguageMenuCommand.php';
    break;
  case 'Back to Language':
    require_once 'languageCommand.php';
    break;
}

if($text == 'English' || $text == 'Ukrainian')
{
  require_once 'changeLanguageCommand.php';
}
