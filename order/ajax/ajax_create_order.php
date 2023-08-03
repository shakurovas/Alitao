<?php
define('STOP_STATISTICS', true);
require_once($_SERVER['DOCUMENT_ROOT'].'/bitrix/modules/main/include/prolog_before.php');
use \Bitrix\Main\Localization\Loc;

Loc::loadMessages(__FILE__);

$APPLICATION->RestartBuffer();

session_start();

$_POST['order_comment'] = strip_tags($_POST['order_comment']);

// записываем комментарий в сессию
if ($_POST['order_comment'])
    $_SESSION['order_comment'] = $_POST['order_comment'];
else
    $_SESSION['order_comment'] = 'нет комментария';


// определим, заказ создавали или редактировали
if (isset($_SESSION['editable_order']) && !empty($_SESSION['editable_order'])) {
    $order = $_SESSION['editable_order'];
} else {
    $order = $_SESSION['cart'];
}


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


// формируем строчку с описанием заказанных товаров для письма и сумму заказа
$orderContentString = '';
$totalSum = 0;

// добавим вложения (картинки товаров) в письмо
$files = [];


foreach ($order as $link => $props) {
    // строчка с характеристиками товаров
    $orderContentString .= '<a href="' . $link . '">' . $props['name'] . '</a><br>';
    $orderContentString .= Loc::getMessage('PRICE') . ': ' . $props['price'] . ' ¥<br>';
    $orderContentString .= Loc::getMessage('QUANTITY') . ': ' . $props['quantity'] . '<br>';
    $orderContentString .= Loc::getMessage('COLOUR') . ': ' . $props['colour'] . '<br>';
    $orderContentString .= Loc::getMessage('SIZE') . ': ' . $props['size'] . '<br>';
    $orderContentString .= Loc::getMessage('DELIVERY_THROUGH_CHINA') . '</b>: ' . $props['delivery_through_china'] . ' ¥<br>';
    if ($props['photo_report_is_needed']) {
        $needed = Loc::getMessage('YES');
        $servicesCost = 5 * $props['quantity'];
    } else {
        $needed = Loc::getMessage('NO');
        $servicesCost = 0;
    }
    $orderContentString .= Loc::getMessage('PHOTO_REPORT_IS_NEEDED') . ': ' . $needed . '<br><br>';

    // стоимость всех товаров с доставкой по Китаю
    $totalSum += $props['price'] * $props['quantity'] + $props['delivery_through_china'] + $servicesCost;

    // файлы для заполнения поля с картинками в инфоблоке и отправки в письме, используется последним аргументов в CEvent::SendImmediate()
    $arrPhotoFields = [];
    foreach ($props['photo'] as $file){
        if (!empty($file['tmp_name'])) {
            // $arrPhotoFields[] = $file;
            $files[] = CFile::SaveFile($file, 'users_pics');
        }
    }
}


// если заказ застрахован, прибавим к стоимости заказа 1% от стоимости
if ($_SESSION['users_info']['insurance_included']) {
    $isInsured = $orderEnumFields['IS_INSURED'][Loc::getMessage('YES')];
    $totalSum *= 1.01;
} else {
    $isInsured = $orderEnumFields['IS_INSURED'][Loc::getMessage('NO')];
}


// определяем комиссию (до 5000 включительно - 5%, свыше - 3%)
if ($totalSum <= 5000) {
    $comission = 5;
} else {
    $comission = 3;
}

// списки полей для создания/обновления элемента инофблока с заказами
$elemProps = array(
    "CUSTOMER" => $USER->GetID(),
    "ORDER_CONTENT" => base64_encode(serialize($order)),
    "IS_INSURED" => $isInsured,
    "DELIVERY_METHOD" => $orderEnumFields['DELIVERY_METHOD'][$_SESSION['users_info']['delivery_type']],
    "NOTES" => $_SESSION['order_comment'],
    "ADDRESS" => $_SESSION['users_info']['zipindex'] . ', ' . $_SESSION['users_info']['region'] . ', ' . $_SESSION['users_info']['city'] . ', ' . $_SESSION['users_info']['address'],
    "PHONE" => $_SESSION['users_info']['phone'],
    "EMAIL" => $_SESSION['users_info']['email'],
    "STATUS" => $orderEnumFields['STATUS'][Loc::getMessage('NOT_PAID')],
    "GOODS_AND_DELIVERY_THROUGH_CHINA_COST_YUAN" => $totalSum,
    "GOODS_AND_DELIVERY_THROUGH_CHINA_COST_RUB" => $totalSum * $_SESSION['cnyRate'],
    "COMISSION" => $comission,
    "PICTURES" => $files
);

if (isset($_SESSION['editable_order']) && !empty($_SESSION['editable_order'])) { 
    $elArray = Array(
        "TIMESTAMP_X" => date('d.m.Y H:i:s'),
        // "IBLOCK_ID" => $ordersIblockId,
        "PROPERTY_VALUES" => $elemProps,
        "NAME" => 'Новый заказ',
        "ACTIVE" => "Y"
    );
} else {
    $elArray = Array(
        "ACTIVE_FROM" => date('d.m.Y H:i:s'),
        "IBLOCK_ID" => $ordersIblockId,
        "PROPERTY_VALUES" => $elemProps,
        "NAME" => 'Новый заказ',
        "ACTIVE" => "Y"
    );
}



if (isset($_SESSION['editable_order']) && !empty($_SESSION['editable_order']) && isset($_SESSION['editable_order_id']) && !empty($_SESSION['editable_order_id'])) {  // если изменяли существующий заказ, обновим данные об этом элементе в инфоблоке
    if ($res = $el->Update($_SESSION['editable_order_id'], $elArray)) {  // если всё прошло успешно
        $arEventFields = array(
            "EMAIL_TO" => COption::GetOptionString('main', 'email_from', 'alitaobao00@mail.ru'),  // дефолтный email из настроек
            "CUSTOMER" => $_SESSION['users_info']['full_name'],
            "CUSTOMER_ID" => $USER->GetID(),
            "ORDER_ID" => $_SESSION['editable_order_id'],
            "ORDER_CONTENT" => $orderContentString,
            "IS_INSURED" => $isInsured,
            "DELIVERY_METHOD" => $_SESSION['users_info']['delivery_type'],
            "NOTES" => $_SESSION['order_comment'],
            'LINK_TO_ORDER' => $_SERVER['SERVER_NAME'] . '/bitrix/admin/iblock_element_edit.php?IBLOCK_ID=' . $ordersIblockId . '&type=products&lang=ru&ID=' . $elemId,
            "ADDRESS" => $_SESSION['users_info']['zipindex'] . ', ' . $_SESSION['users_info']['region'] . ', ' . $_SESSION['users_info']['city'] . ', ' . $_SESSION['users_info']['address'],
            "PHONE" => $_SESSION['users_info']['phone'],
            "EMAIL" => $_SESSION['users_info']['email'],
            "TOTAL_SUM_YUAN" => $totalSum,
            "TOTAL_SUM_RUB" => $totalSum * $_SESSION['cnyRate']
        );

        CEvent::SendImmediate('ORDER_WAS_CHANGED', 's1', $arEventFields, 'N', 55, $files);  // письмо про изменение существующего заказа
    }
} else if (isset($_SESSION['cart']) && !empty($_SESSION['cart'])) {  // если создавали новый заказ, то добавим новый элемент в инфоблок
    if ($elemId = $el->Add($elArray)) {  // если всё прошло успешно
        $arEventFields = array(
            "EMAIL_TO" => COption::GetOptionString('main', 'email_from', 'alitaobao00@mail.ru'),  // дефолтный email из настроек
            "CUSTOMER" => $_SESSION['users_info']['full_name'],
            "CUSTOMER_ID" => $USER->GetID(),
            "ORDER_ID" => $elemId,
            "ORDER_CONTENT" => $orderContentString,
            "IS_INSURED" => $isInsured,
            "DELIVERY_METHOD" => $_SESSION['users_info']['delivery_type'],
            "NOTES" => $_SESSION['order_comment'],
            'LINK_TO_ORDER' => $_SERVER['SERVER_NAME'] . '/bitrix/admin/iblock_element_edit.php?IBLOCK_ID=' . $ordersIblockId . '&type=products&lang=ru&ID=' . $elemId,
            "ADDRESS" => $_SESSION['users_info']['zipindex'] . ', ' . $_SESSION['users_info']['region'] . ', ' . $_SESSION['users_info']['city'] . ', ' . $_SESSION['users_info']['address'],
            "PHONE" => $_SESSION['users_info']['phone'],
            "EMAIL" => $_SESSION['users_info']['email'],
            "TOTAL_SUM_YUAN" => $totalSum,
            "TOTAL_SUM_RUB" => $totalSum * $_SESSION['cnyRate']
        );

        CEvent::SendImmediate('NEW_ORDER_WAS_CREATED', 's1', $arEventFields, 'N', 53, $files);  // письмо про создание нового заказа
    }
} else {
    echo '<script>Error occured.</script>';
}


// удаляем картинки из временного хранилища
foreach ($order as $key => $props) {
    foreach ($props['photo'] as $file){
        unlink('/upload/users_pics/' . $file['name']);  // когда сохранили фото, удаляем из временного хранилища
    }
}


// очищаем сохранённые для создания/редактирования заказа данные в сессии
if (isset($_SESSION['cart']))  // создаваемый заказ
    unset($_SESSION['cart']);
if (isset($_SESSION['editable_order']))  // редактируемый заказ
    unset($_SESSION['editable_order']);
if (isset($_SESSION['users_info']))  // информация о пользователе
    unset($_SESSION['users_info']);
if (isset($_SESSION['order_comment']))  // комментарий к заказу
    unset($_SESSION['order_comment']);
if (isset($_SESSION['editable_order_id']))  // id отредактированного заказа
    unset($_SESSION['editable_order_id']);
if (isset($_SESSION['comment']))  // комментарий отредактированного заказа
    unset($_SESSION['comment']);
if (isset($_SESSION['delivery_method']))  // способ доставки отредактированного заказа
    unset($_SESSION['delivery_method']);
if (isset($_SESSION['is_insured']))  // застрахован ли отредактированный заказ
    unset($_SESSION['is_insured']);


die();
