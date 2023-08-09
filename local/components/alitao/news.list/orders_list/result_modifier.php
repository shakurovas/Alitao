<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<?php
global $USER;
// echo '<pre>';
// print_r(unserialize(base64_decode($arResult['ITEMS'][0]['PROPERTIES']['ORDER_CONTENT']['VALUE']['TEXT'])));
// echo '</pre>';
// $arResult['ITEMS'] = [];

// if ($this->StartResultCache(false, $GLOBALS['USER']->GetGroups())) {
// $obCache = new CPHPCache;
// $obCache->CleanDir("/s1/bitrix/news.list", "cache");
// CBitrixComponent::clearComponentCache('bitrix:news.list');

    $arSort = array('SORT' => 'DESC', 'ID' => 'DESC');
    $arFilter = array('ACTIVE' => 'Y', 'IBLOCK_CODE' => 'orders', 'PROPERTY_CUSTOMER' => $USER->GetID());
    $arSelect = array('ID');
    // $arSelect = array('PROPERTY_PICTURES');

    $count = 0;
    $res = CIBlockElement::getList($arSort, $arFilter, false, false, $arSelect);
    while ($row = $res->fetch()) {
        $arResult['COUNTER'] += 1;
    //    $arResult['ITEMS'][] = $row;
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
//     $this->EndResultCache();
// }
// $obCache = new CPHPCache;
// $obCache->CleanDir("/s1/bitrix/news.list", "cache");