<?php
define('STOP_STATISTICS', true);
require_once($_SERVER['DOCUMENT_ROOT'].'/bitrix/modules/main/include/prolog_before.php');
$APPLICATION->RestartBuffer();

$order = array('sort' => 'asc');
$tmp = 'sort';
$filter = Array
(
    "ACTIVE" => "Y",
    "LOGIN_EQUAL" => $_POST['login'] // используем LOGIN_EQUAL, т. к. просто LOGIN ищет подстроку, а не точное совпадение с введённым логином
);
$select = ['FIELDS' => ['LOGIN', 'EMAIL']];
$rsUsers = CUser::GetList($order, $tmp, $filter, $select); // выбираем пользователей

if ($arUsers = $rsUsers->fetch()) {
    // если нашёлся пользователь с таким логином
    $USER->SendPassword($arUsers['LOGIN'], $arUsers['EMAIL']);

    echo json_encode(
        [
            'login' => [
                'state' => 'success',
                'message' => "На вашу почту было отправлено письмо с инструкциями для восстановления пароля!"
            ]
        ]
    );
} else {
    echo json_encode(
        [
            'login' => [
                'state' => 'error',
                'message' => "Пользователя с указанной почтой не существует"
            ]
        ]
    );
}


die();