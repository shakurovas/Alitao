<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<?php
global $USER;

$arSort = array('SORT' => 'DESC', 'ID' => 'DESC');
$arFilter = array('ACTIVE' => 'Y', 'IBLOCK_CODE' => 'orders', 'PROPERTY_CUSTOMER' => $USER->GetID());
$arSelect = array('ID');

$count = 0;
$res = CIBlockElement::getList($arSort, $arFilter, false, false, $arSelect);
while ($row = $res->fetch()) {
    $arResult['COUNTER'] += 1;
}

foreach ($arResult['ITEMS'] as $key => $order) {
    if ($order['PROPERTIES']['CUSTOMER']['VALUE'] != $USER->GetID()) {
        unset($arResult['ITEMS'][$key]);
    } else {
        $contentArray = unserialize(base64_decode($order['PROPERTIES']['ORDER_CONTENT']['VALUE']['TEXT']));
        if (is_array($contentArray)) {
            $arResult['ITEMS'][$key]['POSITIONS_QUANTITY'] = count($contentArray);
            $arResult['ITEMS'][$key]['GOODS_QUANTITY'] = 0;
            $arResult['ITEMS'][$key]['TOTAL_SUM_YUAN'] = 0;
            $arResult['ITEMS'][$key]['TOTAL_SUM_RUB'] = 0;
            foreach ($contentArray as $link => $props) {
                $arResult['ITEMS'][$key]['GOODS_QUANTITY'] += $props['quantity'];
                if ($props['photo_report_is_needed']) $servicesCost = 5;
                else $servicesCost = 0;
                $arResult['ITEMS'][$key]['TOTAL_SUM_YUAN'] += ($props['quantity'] * $props['price'] + $props['delivery_through_china'] + $servicesCost);
            }
            $arResult['ITEMS'][$key]['TOTAL_SUM_YUAN'] = $arResult['ITEMS'][$key]['TOTAL_SUM_YUAN'];
            $arResult['ITEMS'][$key]['TOTAL_SUM_RUB'] = $arResult['ITEMS'][$key]['TOTAL_SUM_YUAN'] * $_SESSION['cnyRate'];
        }
    }
}
