<?php
define('STOP_STATISTICS', true);
require_once($_SERVER['DOCUMENT_ROOT'].'/bitrix/modules/main/include/prolog_before.php');
$APPLICATION->RestartBuffer();

// очистим от возможных
foreach ($_POST as $key) {
    $_POST[$key] = strip_tags($_POST[$key]);
}

// получим фамилию, имя, отчество из поля "полное фио"
$nameParts = explode(' ', $_POST['fullname']);

$userId = $USER->GetID();

$user = new CUser;
$fields = Array(
  "NAME" => $nameParts[1],
  "LAST_NAME" => $nameParts[0],
  "SECOND_NAME" => $nameParts[2],
  "EMAIL" => $_POST['email'],
  "PERSONAL_PHONE" => $_POST['phone'],
  "PERSONAL_STATE"  => $_POST['region'], 
  "PERSONAL_STREET" => $_POST['address'],
  "PERSONAL_CITY" => $_POST['city'],
  "PERSONAL_ZIP" => $_POST['zipindex'],
  "UF_MOSCOW_TIME_DIFFERENCE" => $_POST['time_difference'],
  "UF_NOTIFY_ABOUT_ORDERS" => (bool)$_POST['notification'],
  "UF_NICKNAME" => $_POST['nickname'],
  "LID" => "ru",
  "ACTIVE" => "Y"
  );
$user->Update($userId, $fields);

print_r($_POST);	
die();