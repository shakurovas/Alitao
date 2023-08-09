<?php
define('STOP_STATISTICS', true);
require_once($_SERVER['DOCUMENT_ROOT'].'/bitrix/modules/main/include/prolog_before.php');

$APPLICATION->RestartBuffer();

session_start();


if (isset ($_POST['quantity']) && !empty($_POST['quantity']) && isset ($_POST['link']) && !empty($_POST['link'])) {  // будем добавлять в корзину новые данные, только если указали хотя бы ссылку на товар 
    
    // очищаем от возможных тегов
    foreach ($_POST as $key) {
        $_POST[$key] = strip_tags($_POST[$key]);
    }

    if ((int)$_POST['is_edit_mode']) {
        if (!isset($_SESSION['editable_order'][$_POST['link']])) {
            $_POST['link'] = substr($_POST['link'], 0, -1);
        }
        // изменяем количество товара в коризне
        $_SESSION['editable_order'][$_POST['link']]['quantity'] = $_POST['quantity'];
        echo json_encode(['cart' => $_SESSION['editable_order'][$_POST['link']]]);
    } else {
        if (!isset($_SESSION['cart'][$_POST['link']])) {
            $_POST['link'] = substr($_POST['link'], 0, -1);
        }
        // изменяем количество товара в коризне
        $_SESSION['cart'][$_POST['link']]['quantity'] = $_POST['quantity'];
        echo json_encode(['cart' => $_SESSION['cart'][$_POST['link']]]);
    } 
}


die();
