<?php
define('STOP_STATISTICS', true);
require_once($_SERVER['DOCUMENT_ROOT'].'/bitrix/modules/main/include/prolog_before.php');
use \Bitrix\Main\Localization\Loc;

$APPLICATION->RestartBuffer();

session_start();

$_POST['order_comment'] = strip_tags($_POST['order_comment']);
// echo json_encode($_POST);

// записываем комментарий в сессию
if ($_POST['order_comment'])
    $_SESSION['order_comment'] = $_POST['order_comment'];
else
    $_SESSION['order_comment'] = 'Нет комментария';


// добавляем элемент в инфоблок заказов
CModule::IncludeModule('iblock');
$el = new \CIBlockElement;

// ищем id инфоблока с заказами
$arrFilter = array(
'ACTIVE' => 'Y',
'CODE' => 'orders',
'SITE_ID' => "s1",
);

$res = CIBlock::GetList(Array("SORT" => "ASC"), $arrFilter, false);

if ($arRes = $res->Fetch()) {
    $ordersIblockId = $arRes["ID"];
}

// добавляем новый элемент в инфоблок с заказами
$elemProps = array(
    "CUSTOMER" => $USER->GetID(),
    "ORDER_CONTENT" => $_POST['cart'],
    "IS_INSURED" => $_SESSION['users_info']['insurance_included'],
    "DELIVERY_METHOD" => $_SESSION['users_info']['delivery_type'],
    "NOTES" => $_SESSION['order_comment'],
    // "DELIVERY_COST" => '',
    "ADDRESS" => $_SESSION['users_info']['zipindex'] . ', ' . $_SESSION['users_info']['region'] . ', ' . $_SESSION['users_info']['city'] . ', ' . $_SESSION['users_info']['address'],
    "PHONE" => $_SESSION['users_info']['phone'],
    "EMAIL" => $_SESSION['users_info']['email']
);

$elArray = Array(
// "ACTIVE_FROM" => date('d.m.Y H:i:s'),
"IBLOCK_ID" => $ordersIblockId,
"PROPERTY_VALUES" => $elemProps,
"NAME" => 'Новый заказ',
"ACTIVE" => "Y",
// "MODIFIED_BY" => 1,
);

// отсылаем администратору письмо на почту
if ($elemId = $el->Add($elArray)) {
    $arEventFields = array(
        'EMAIL_TO' => COption::GetOptionString('main', 'email_from', 'shakurovas@bk.ru'),  // дефолтный email из настроек
        "CUSTOMER" => $_SESSION['users_info']['full_name'],
        "CUSTOMER_ID" => $USER->GetID(),
        "ORDER_ID" => $elemId,
        "ORDER_CONTENT" => $_SESSION['cart'],
        "IS_INSURED" => $_SESSION['users_info']['insurance_included'],
        "DELIVERY_METHOD" => $_SESSION['users_info']['delivery_type'],
        "NOTES" => $_SESSION['order_comment'],
        // "DELIVERY_COST" => '',
        "ADDRESS" => $_SESSION['users_info']['zipindex'] . ', ' . $_SESSION['users_info']['region'] . ', ' . $_SESSION['users_info']['city'] . ', ' . $_SESSION['users_info']['address'],
        "PHONE" => $_SESSION['users_info']['phone'],
        "EMAIL" => $_SESSION['users_info']['email']
    );
    \CEvent::Send('NEW_ORDER_WAS_CREATED', 's1', $arEventFields, 'N');
}

// echo json_encode($_SESSION['order_comment']);


die();