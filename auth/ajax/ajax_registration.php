<?php
define('STOP_STATISTICS', true);
require_once($_SERVER['DOCUMENT_ROOT'].'/bitrix/modules/main/include/prolog_before.php');
$APPLICATION->RestartBuffer();

// echo (json_encode($_POST));

$rsUser = CUser::GetByID($USER->GetID());
$usersPassword = $rsUser->Fetch()['PASSWORD'];

// узнаем, какая минимальная длина пароля выставлена в настройках для этой группы пользователей 
$securityPolicy = \CUser::GetGroupPolicy(2);  // 2 - группа всех пользователей, в т. ч. неавторизованных
$passwordLength = $securityPolicy['PASSWORD_LENGTH'];

// проверим пароль на соответствие требованиям к паролю этой группы пользователей
$errors = (new \CUser)->CheckPasswordAgainstPolicy($_POST['password'], $securityPolicy);


$order = array('sort' => 'asc');
$tmp = 'sort';
$filter = Array
(
    "ACTIVE" => "Y",
    "LOGIN_EQUAL" => $_POST['login'] // используем LOGIN_EQUAL, т. к. просто LOGIN ищет подстроку, а не точное совпадение с введённым логином
);
$select = ['FIELDS' => ['PASSWORD']];
$rsUsers = CUser::GetList($order, $tmp, $filter, $select); // выбираем пользователей

if ($arUsers = $rsUsers->fetch()) {
    // если нашёлся пользователь с таким логином
    echo json_encode(
        [
            'register_login' => [
                'state' => 'error',
                'message' => "Такой email уже зарегистрирован в системе"
            ]
        ]
    );
// если пользователя с таким логином не зарегистрировано, но пароль не соответствует требованиям безопасности
} else if (!empty($errors)) {
    echo json_encode(
        [
            'register_password' => [
                'state' => 'error',
                'message' => 'Пароль должен быть длиной от ' . $passwordLength . ' символов и более'
            ]
        ]
      );
} else {
    echo json_encode(
        [
            'register_login' => [
                'state' => 'success',
                'message' => "Вы успешно зарегистрированы"
            ]
        ]
    );
}

die();