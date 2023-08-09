<?php
define('STOP_STATISTICS', true);
require_once($_SERVER['DOCUMENT_ROOT'].'/bitrix/modules/main/include/prolog_before.php');
use \Bitrix\Main\Localization\Loc;

Loc::loadMessages(__FILE__);

$APPLICATION->RestartBuffer();

session_start();


if (isset($_POST['order_content']) && isset($_POST['order_id'])) {
    $_SESSION['editable_order'] = unserialize(base64_decode($_POST['order_content']));
    $_SESSION['editable_order_id'] = $_POST['order_id'];
    $_SESSION['comment'] = $_POST['comment'];
    $_SESSION['delivery_method'] = $_POST['delivery'];
    $_SESSION['is_insured'] = $_POST['is_insured'];
}
echo json_encode($_SESSION['editable_order']);


die();