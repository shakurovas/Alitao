<?php
define('STOP_STATISTICS', true);
require_once($_SERVER['DOCUMENT_ROOT'].'/bitrix/modules/main/include/prolog_before.php');
use \Bitrix\Main\Localization\Loc;

$APPLICATION->RestartBuffer();

session_start();

foreach ($_POST as $key) {
    $_POST[$key] = strip_tags($_POST[$key]);
}
// echo json_encode($_POST);

if ($_POST['full_name'] && $_POST['region'] && $_POST['city'] && $_POST['address'] && $_POST['zipindex'] && $_POST['phone'] && $_POST['email'] && $_POST['delivery_type']) {
    $_SESSION['users_info'] = [
        'full_name' => $_POST['full_name'],
        'region' => $_POST['region'],
        'city' => $_POST['city'],
        'address' => $_POST['address'],
        'zipindex' => $_POST['zipindex'],
        'phone' => $_POST['phone'],
        'email' => $_POST['email'],
        'delivery_type' => $_POST['delivery_type'],
        'insurance_included' => (int)$_POST['insurance_included']
    ];
}

echo json_encode($_SESSION['users_info']);


die();