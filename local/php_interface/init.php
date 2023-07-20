<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();?>
<?php
// приязываем метод создания логина из введённой пользователем почты к событиям регистрации и обновления данных пользователя
AddEventHandler("main", "OnBeforeUserRegister", Array('Handlers', "OnBeforeUserUpdateHandler"));
AddEventHandler("main", "OnBeforeUserUpdate", Array('Handlers', "OnBeforeUserUpdateHandler"));

// привязываем метод переадресации пользователя на страницу профиля к событию успешной авторизации 
AddEventHandler("main", "OnAfterUserAuthorize", Array('Handlers', "OnAfterUserAuthorizeHandler"));


class Handlers
{
    // функция для создания логина из почты
    public static function OnBeforeUserUpdateHandler(&$arFields)
    {
        $arFields["LOGIN"] = $arFields["EMAIL"];
        return $arFields;
    }

    // функция для переадресации пользователя на страницу профиля после успешной авторизации
    public static function OnAfterUserAuthorizeHandler($arUser)
    {
        if (strpos($_SERVER['REQUEST_URI'], '/bitrix/admin/') === false) {
            LocalRedirect('/auth/personal.php');
        }
    }
}


// функция для приведения номера телефона в профиле пользователя к нужному формату
function phoneFormat($phone)
{
    return preg_replace(
        array(
            '/[\+]?([7|8])[-|\s]?\([-|\s]?(\d{3})[-|\s]?\)[-|\s]?(\d{3})[-|\s]?(\d{2})[-|\s]?(\d{2})/',
            '/[\+]?([7|8])[-|\s]?(\d{3})[-|\s]?(\d{3})[-|\s]?(\d{2})[-|\s]?(\d{2})/',
            '/[\+]?([7|8])[-|\s]?\([-|\s]?(\d{4})[-|\s]?\)[-|\s]?(\d{2})[-|\s]?(\d{2})[-|\s]?(\d{2})/',
            '/[\+]?([7|8])[-|\s]?(\d{4})[-|\s]?(\d{2})[-|\s]?(\d{2})[-|\s]?(\d{2})/',	
            '/[\+]?([7|8])[-|\s]?\([-|\s]?(\d{4})[-|\s]?\)[-|\s]?(\d{3})[-|\s]?(\d{3})/',
            '/[\+]?([7|8])[-|\s]?(\d{4})[-|\s]?(\d{3})[-|\s]?(\d{3})/',					
        ), 
        array(
            '+7 $2 $3-$4-$5', 
            '+7 $2 $3-$4-$5', 
            '+7 $2 $3-$4-$5', 
            '+7 $2 $3-$4-$5', 	
            '+7 $2 $3-$4', 
            '+7 $2 $3-$4', 
        ), 
        $phone
    );
}