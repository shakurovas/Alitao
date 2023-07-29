<?php
define('STOP_STATISTICS', true);
require_once($_SERVER['DOCUMENT_ROOT'].'/bitrix/modules/main/include/prolog_before.php');

$APPLICATION->RestartBuffer();

session_start();

if (isset($_POST['link']) && !empty($_POST['link'])) {
    $_POST['link'] = strip_tags($_POST['link']);
    echo (int)$_SESSION['cart'][$_POST['link']]['photo_report_is_needed'];
}


die();