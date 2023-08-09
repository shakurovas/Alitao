<?php
define('STOP_STATISTICS', true);
define("AUTH", true);
require_once($_SERVER['DOCUMENT_ROOT'].'/bitrix/modules/main/include/prolog_before.php');
$APPLICATION->RestartBuffer();

// т. к. данные передаются через get-запрос, то на всякий случай проверим их на возможное наличие тегов (б-безопасность)
$_POST['login'] = strip_tags($_POST['login']);
$_POST['password'] = strip_tags($_POST['password']);
$_POST['checkword'] = strip_tags($_POST['checkword']);

// меняем пароль
$result = $USER->ChangePassword($_POST['login'], $_POST['checkword'], $_POST['password'], $_POST['password']);

if ($result['TYPE'] == 'OK') {
    echo json_encode(
        [
            'password' => [
                'state' => 'success',
                'message' => 'Пароль будет изменён в течение нескольких минут'
            ]
        ]
    );
} else {
    echo json_encode(
        [
            'password' => [
                'state' => 'error',
                'message' => $result['MESSAGE']
            ]
        ]
    );
}


die();
