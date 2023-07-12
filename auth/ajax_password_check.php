<?php
define('STOP_STATISTICS', true);
require_once($_SERVER['DOCUMENT_ROOT'].'/bitrix/modules/main/include/prolog_before.php');
$APPLICATION->RestartBuffer();

print_r($_POST);
// очистим от возможных тегов
// $_POST['old_password'] = strip_tags($_POST['old_password']);
// $_POST['new_password'] = strip_tags($_POST['new_password']);

$rsUser = CUser::GetByID($USER->GetID());
$usersPassword = $rsUser->Fetch()['PASSWORD'];

// если старый пароль введён верно, изменяем пароль на новый
if (\Bitrix\Main\Security\Password::equals($usersPassword, $_POST['old_password'])) {
    $userId = $USER->GetID();

    $user = new CUser;
    $fields = Array(
      "PASSWORD" => $_POST['new_password'],
      "LID" => "ru",
      "ACTIVE" => "Y"
      );
    $user->Update($userId, $fields);
}

var_dump(\Bitrix\Main\Security\Password::equals($usersPassword, $_POST['old_password']));

die();
