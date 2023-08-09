<?php
define('STOP_STATISTICS', true);

require_once($_SERVER['DOCUMENT_ROOT'].'/bitrix/modules/main/include/prolog_before.php');
global $APPLICATION;

$APPLICATION->RestartBuffer();

$order = array('sort' => 'asc');
$tmp = 'sort';
$filter = Array
(
    "ACTIVE" => "Y",
    "LOGIN_EQUAL" => $_POST['login'] // используем LOGIN_EQUAL, т. к. просто LOGIN ищет подстроку, а не точное совпадение с введённым логином
);
$select = ['FIELDS' => ['PASSWORD', 'ID']];
$rsUsers = CUser::GetList($order, $tmp, $filter, $select); // выбираем пользователей

if ($arUsers = $rsUsers->fetch()) {
    // если нашёлся пользователь с таким логином
    if (!empty($arUsers)) {
        // если пароль введён правильно, то авторизуем пользователя
        if (\Bitrix\Main\Security\Password::equals($arUsers['PASSWORD'], $_POST['password'])) {
            if ($USER->Login($_POST['login'], $_POST['password'], 'Y')) {
                echo json_encode(
                    [
                        'login' => [
                            'state' => 'success',
                            'message' => "Авторизация прошла успешно!",
                            'id' => $arUsers['ID']
                        ],
                    ]
                );
            };
            
        // если такой логин есть, но пароль введён неправильно
        } else {
            echo json_encode(
                [
                    'password' => [
                        'state' => 'error',
                        'message' => "Неверный пароль"
                    ]
                ]
            );
            
        }
    } 
// если пользователя с таким логином не зарегистрировано
} else {
    echo json_encode(
        [
            'login' => [
                'state' => 'error',
                'message' => "Неверный Email"
            ]
        ]
    );
}


die();
