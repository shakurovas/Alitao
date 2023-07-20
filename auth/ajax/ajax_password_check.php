<?php
define('STOP_STATISTICS', true);
require_once($_SERVER['DOCUMENT_ROOT'].'/bitrix/modules/main/include/prolog_before.php');
$APPLICATION->RestartBuffer();

// echo (json_encode($_POST));

// очистим от возможных тегов
$_POST['old_password'] = strip_tags($_POST['old_password']);
$_POST['new_password'] = strip_tags($_POST['new_password']);

$rsUser = CUser::GetByID($USER->GetID());
$usersPassword = $rsUser->Fetch()['PASSWORD'];

// узнаем, какая минимальная длина пароля выставлена в настройках для этой группы пользователей 
$securityPolicy = \CUser::GetGroupPolicy(CUser::GetUserGroup($userId = $USER->GetID()));
$passwordLength = $securityPolicy['PASSWORD_LENGTH'];

// проверим пароль на соответствие требованиям к паролю этой группы пользователей
$errors = (new \CUser)->CheckPasswordAgainstPolicy($_POST['new_password'], $securityPolicy);
// echo(json_encode($errors));

// меняем пароль на новый при соблюдении следующих условий:
// - старый пароль введён верно
// - новый пароль отличается от старого
// - новый пароль длиной от 3 символов
if (\Bitrix\Main\Security\Password::equals($usersPassword, $_POST['old_password']) && $_POST['old_password'] != $_POST['new_password'] && mb_strlen($_POST['new_password'], "UTF-8") >= $passwordLength) {
    $userId = $USER->GetID();

    if (empty($errors)) {
      $user = new CUser;
      $fields = Array(
        "PASSWORD" => $_POST['new_password'],
        "LID" => "ru",
        "ACTIVE" => "Y"
        );
      $user->Update($userId, $fields);

      
      echo json_encode(
        [
          'old_password' => [
            'state' => 'success',
            'message' => 'Пароль успешно изменён'
            ]
        ]
      );
    } else {
      echo json_encode(
        [
          'new_password' => [
            'state' => 'error',
            'message' => $errors[0]
            ]
        ]
      );
    }
   
// если старый пароль введён верно, новый от 3 символов, но новый совпадает со старым
} elseif (\Bitrix\Main\Security\Password::equals($usersPassword, $_POST['old_password']) && $_POST['old_password'] == $_POST['new_password'] && mb_strlen($_POST['new_password'], "UTF-8") >= $passwordLength) {
  echo json_encode(
    [
      'new_password' => [
        'state' => 'error',
        'message' => 'Новый пароль совпадает с текущим'
        ]
    ]
  );
// если старый пароль введён верно, новый отличен от старого, но меньше 3 символов
} elseif (\Bitrix\Main\Security\Password::equals($usersPassword, $_POST['old_password']) && $_POST['old_password'] != $_POST['new_password'] && mb_strlen($_POST['new_password'], "UTF-8") < $passwordLength) {
  echo json_encode(
    [
      'new_password' => [
        'state' => 'error',
        'message' => 'Пароль должен быть длиной от ' . $passwordLength . ' символов и более'
        ]
    ]
  );
// если старый пароль введён неверно
} else {
  echo json_encode(
    [
      'old_password' => [
        'state' => 'error',
        'message' => 'Неверный пароль'
        ]
    ]
  );
}


die();
