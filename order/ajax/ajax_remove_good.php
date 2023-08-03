<?php
define('STOP_STATISTICS', true);
require_once($_SERVER['DOCUMENT_ROOT'].'/bitrix/modules/main/include/prolog_before.php');
$APPLICATION->RestartBuffer();

// echo json_encode($_POST);
session_start();

$_POST['link'] = strip_tags($_POST['link']);

if (isset($_SESSION['cart'][$_POST['link']]))
    unset($_SESSION['cart'][$_POST['link']]);
if (isset($_SESSION['editable_order'][$_POST['link']]))
    unset($_SESSION['editable_order'][$_POST['link']]);
// json_encode($_SESSION['cart']);
// echo json_encode($_SESSION['cart']);

die();