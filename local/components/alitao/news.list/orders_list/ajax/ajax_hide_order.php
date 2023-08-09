<?php
define('STOP_STATISTICS', true);
require_once($_SERVER['DOCUMENT_ROOT'].'/bitrix/modules/main/include/prolog_before.php');
use \Bitrix\Main\Localization\Loc;

Loc::loadMessages(__FILE__);

$APPLICATION->RestartBuffer();

session_start();

// echo json_encode($_POST);

if (CModule::IncludeModule("iblock")) {
  $el = new CIBlockElement;
  $arLoadProductArray = Array(
    "ACTIVE" => "N",
  );
  $res = $el->Update($_POST['id'], $arLoadProductArray);

  // отсылаем администратору письмо об отмене заказа на почту
  $arEventFields = array(
      "ORDER_ID" => $_POST['id']
  );

  CEvent::SendImmediate('ORDER_WAS_CANCELLED', 's1', $arEventFields, 'N', 54);
}


die();