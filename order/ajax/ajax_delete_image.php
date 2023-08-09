<?php
define('STOP_STATISTICS', true);
require_once($_SERVER['DOCUMENT_ROOT'].'/bitrix/modules/main/include/prolog_before.php');

$APPLICATION->RestartBuffer();

session_start();


if (isset($_POST['link']) && !empty($_POST['link'])) {
    $_POST['link'] = strip_tags($_POST['link']);

    $imageName = explode('/', $_POST['image_src'])[5];

    if (isset($_SESSION['editable_order']) && !empty($_SESSION['editable_order'])) {
        foreach ($_SESSION['editable_order'][$_POST['link']]['photo'] as $key => $photo) {
            echo json_encode(['name_1' => $photo['name'], 'name_2' => $imageName]);
            if ($photo['name'] == $imageName) {
                unset($_SESSION['editable_order'][$_POST['link']]['photo'][$key]);
            }
        }
    } else {
        foreach ($_SESSION['cart'][$_POST['link']]['photo'] as $key => $photo) {
            echo json_encode(['name_1' => $photo['name'], 'name_2' => $imageName]);
            if ($photo['name'] == $imageName) {
                unset($_SESSION['cart'][$_POST['link']]['photo'][$key]);
            }
        }
    }
}


die();
