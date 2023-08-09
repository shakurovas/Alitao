<?php
define('STOP_STATISTICS', true);
require_once($_SERVER['DOCUMENT_ROOT'].'/bitrix/modules/main/include/prolog_before.php');
$APPLICATION->RestartBuffer();

// echo json_encode($_POST);
session_start();

$_POST['link'] = strip_tags($_POST['link']);
$totalSumYuan = 0;

if (isset($_SESSION['cart'][$_POST['link']])) {
    unset($_SESSION['cart'][$_POST['link']]);

    foreach ($_SESSION['cart'] as $link => $props) {
        if ($props['photo_report_is_needed']) {
            $servicesCost = $props['quantity'] * 5;
        } else {
            $servicesCost = 0;
        }
        $totalSumYuan += $props['quantity'] * $props['price'] + $props['delivery_through_china'] + $servicesCost;
        if ($totalSumYuan <= 5000) {
            $totalSumYuan *= 1.05;
        } else {
            $totalSumYuan *= 1.03;
        }
    }
}
if (isset($_SESSION['editable_order'][$_POST['link']])) {
    unset($_SESSION['editable_order'][$_POST['link']]);

    foreach ($_SESSION['editable_order'] as $link => $props) {
        if ($props['photo_report_is_needed']) {
            $servicesCost = $props['quantity'] * 5;
        } else {
            $servicesCost = 0;
        }
        $totalSumYuan += $props['quantity'] * $props['price'] + $props['delivery_through_china'] + $servicesCost;
        if ($totalSumYuan <= 5000) {
            $totalSumYuan *= 1.05;
        } else {
            $totalSumYuan *= 1.03;
        }
    }
}

// if ((int)($_POST['is_edit_mode'])) {  // если это редактирование уже существующего заказа
//     $arrayOfGoods = $_SESSION['editable_order'];
// } else {
//     $arrayOfGoods = $_SESSION['cart'];  // если это создание нового заказа
// }

echo json_encode(['total_sum' => number_format($totalSumYuan * $_SESSION['cnyRate'], 2, '.', ' ')]);

die();