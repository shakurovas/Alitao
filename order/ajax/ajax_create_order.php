<?php
define('STOP_STATISTICS', true);
require_once($_SERVER['DOCUMENT_ROOT'].'/bitrix/modules/main/include/prolog_before.php');
use \Bitrix\Main\Localization\Loc;

Loc::loadMessages(__FILE__);

$APPLICATION->RestartBuffer();

session_start();

$_POST['order_comment'] = strip_tags($_POST['order_comment']);
// echo json_encode($_POST);

// записываем комментарий в сессию
if ($_POST['order_comment'])
    $_SESSION['order_comment'] = $_POST['order_comment'];
else
    $_SESSION['order_comment'] = 'нет комментария';
// echo json_encode($_SESSION['order_comment']);

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


// ищем id значений свойства STATUS типа список
$propertyEnums = CIBlockPropertyEnum::GetList(Array("DEF" => "DESC", "SORT" => "ASC"), Array("IBLOCK_ID" => $ordersIblockId, "CODE" => 'STATUS'));
while($enumFields = $propertyEnums->GetNext())
{
    $orderEnumFields['STATUS'][$enumFields["VALUE"]] = $enumFields["ID"];
}

// ищем id значений свойства IS_INSURED типа список
$propertyEnums = CIBlockPropertyEnum::GetList(Array("DEF" => "DESC", "SORT" => "ASC"), Array("IBLOCK_ID" => $ordersIblockId, "CODE" => 'IS_INSURED'));
while($enumFields = $propertyEnums->GetNext())
{
    $orderEnumFields['IS_INSURED'][$enumFields["VALUE"]] = $enumFields["ID"];
}

// ищем id значений свойства DELIVERY_METHOD типа список
$propertyEnums = CIBlockPropertyEnum::GetList(Array("DEF" => "DESC", "SORT" => "ASC"), Array("IBLOCK_ID" => $ordersIblockId, "CODE" => 'DELIVERY_METHOD'));
while($enumFields = $propertyEnums->GetNext())
{
    $orderEnumFields['DELIVERY_METHOD'][$enumFields["VALUE"]] = $enumFields["ID"];
}


if ($_SESSION['users_info']['insurance_included']) {
    $isInsured = $orderEnumFields['IS_INSURED'][Loc::getMessage('YES')];
} else {
    $isInsured = $orderEnumFields['IS_INSURED'][Loc::getMessage('NO')];
}


// формируем строчку с описанием заказанных товаров для письма и сумму заказа
$orderContentString = '';
$totalSum = 0;

// добавим вложения (картинки товаров) в письмо
$files = [];

foreach ($_SESSION['cart'] as $link => $props) {
    // строчка с характеристиками товаров
    $orderContentString .= '<a href="' . $link . '">' . $props['name'] . '</a><br>';
    $orderContentString .= Loc::getMessage('PRICE') . ': ' . $props['price'] . ' ¥<br>';
    $orderContentString .= Loc::getMessage('QUANTITY') . ': ' . $props['quantity'] . '<br>';
    $orderContentString .= Loc::getMessage('COLOUR') . ': ' . $props['colour'] . '<br>';
    $orderContentString .= Loc::getMessage('SIZE') . ': ' . $props['size'] . '<br>';
    $orderContentString .= Loc::getMessage('DELIVERY_THROUGH_CHINA') . '</b>: ' . $props['delivery_through_china'] . ' ¥<br>';
    if ($props['photo_report_is_needed']) $needed = Loc::getMessage('YES');
    else $needed = Loc::getMessage('NO');
    $orderContentString .= Loc::getMessage('PHOTO_REPORT_IS_NEEDED') . ': ' . $needed . '<br><br>';

    // стоимость всех товаров с доставкой по Китаю
    $totalSum += $props['price'] * $props['quantity'] + $props['delivery_through_china'];

    // файлы для заполнения поля с картинками в инфоблоке и отправки в письме, используется последним аргументов в CEvent::SendImmediate()
    $arrPhotoFields = [];
    foreach ($props['photo'] as $file){
        if (!empty($file['tmp_name'])) {
            $arrPhotoFields[] = $file;
            $files[] = CFile::SaveFile($file, 'users_pics');
        }
    }
}


// добавляем новый элемент в инфоблок с заказами
$elemProps = array(
    "CUSTOMER" => $USER->GetID(),
    "ORDER_CONTENT" => base64_encode(serialize($_SESSION['cart'])),
    "IS_INSURED" => $isInsured,
    "DELIVERY_METHOD" => $orderEnumFields['DELIVERY_METHOD'][$_SESSION['users_info']['delivery_type']],
    "NOTES" => $_SESSION['order_comment'],
    // "DELIVERY_COST" => '',
    "ADDRESS" => $_SESSION['users_info']['zipindex'] . ', ' . $_SESSION['users_info']['region'] . ', ' . $_SESSION['users_info']['city'] . ', ' . $_SESSION['users_info']['address'],
    "PHONE" => $_SESSION['users_info']['phone'],
    "EMAIL" => $_SESSION['users_info']['email'],
    "STATUS" => $orderEnumFields['STATUS'][Loc::getMessage('NOT_PAID')],
    "GOODS_AND_DELIVERY_THROUGH_CHINA_COST" => $totalSum,
    "PICTURES" => $arrPhotoFields
);

// поля для отправки письма о создании заказа
$elArray = Array(
    "ACTIVE_FROM" => date('d.m.Y H:i:s'),
    "IBLOCK_ID" => $ordersIblockId,
    "PROPERTY_VALUES" => $elemProps,
    "NAME" => 'Новый заказ',
    "ACTIVE" => "Y",
    // "MODIFIED_BY" => 1,
);


// отсылаем администратору письмо на почту
if ($elemId = $el->Add($elArray)) {
    $arEventFields = array(
        "EMAIL_TO" => COption::GetOptionString('main', 'email_from', 'shakurovas@bk.ru'),  // дефолтный email из настроек
        "CUSTOMER" => $_SESSION['users_info']['full_name'],
        "CUSTOMER_ID" => $USER->GetID(),
        "ORDER_ID" => $elemId,
        "ORDER_CONTENT" => $orderContentString,
        "IS_INSURED" => $isInsured,
        "DELIVERY_METHOD" => $_SESSION['users_info']['delivery_type'],
        "NOTES" => $_SESSION['order_comment'],
        'LINK_TO_ORDER' => $_SERVER['SERVER_NAME'] . '/bitrix/admin/iblock_element_edit.php?IBLOCK_ID=' . $ordersIblockId . '&type=products&lang=ru&ID=' . $elemId,
        // "DELIVERY_COST" => '',
        "ADDRESS" => $_SESSION['users_info']['zipindex'] . ', ' . $_SESSION['users_info']['region'] . ', ' . $_SESSION['users_info']['city'] . ', ' . $_SESSION['users_info']['address'],
        "PHONE" => $_SESSION['users_info']['phone'],
        "EMAIL" => $_SESSION['users_info']['email'],
        "TOTAL_SUM" => $totalSum
    );

    // \CEvent::Send('NEW_ORDER_WAS_CREATED', 's1', $arEventFields, 'N');
    CEvent::SendImmediate('NEW_ORDER_WAS_CREATED', 's1', $arEventFields, 'N', 53, $files);
}

// echo json_encode($_SESSION['order_comment']);
unset($_SESSION['cart']);
unset($_SESSION['users_info']);
unset($_SESSION['order_comment']);


die();