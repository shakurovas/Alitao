<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();?>
<?php
// приязываем метод создания логина из введённой пользователем почты к событиям регистрации и обновления данных пользователя
AddEventHandler("main", "OnBeforeUserRegister", Array('Handlers', "OnBeforeUserUpdateHandler"));
AddEventHandler("main", "OnBeforeUserUpdate", Array('Handlers', "OnBeforeUserUpdateHandler"));

// привязываем метод переадресации пользователя на страницу профиля к событию успешной авторизации 
AddEventHandler("main", "OnAfterUserAuthorize", Array('Handlers', "OnAfterUserAuthorizeHandler"));

// привязываем метод для отсылки сообщений на почту пользователю после изменения статуса заказа
AddEventHandler("iblock", "OnBeforeIBlockElementUpdate", Array("Handlers", "InformAboutStatusChange"));


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
            LocalRedirect('/auth/personal.php?login=yes');
        }
    }

    // метод для отсылки письма на почту пользователю после изменения статуса заказа
    public static function InformAboutStatusChange(&$arFields)
    {
        CModule::IncludeModule('iblock');

        // определяем id свойства STATUS
        $arFilter = array(
            'IBLOCK_ID' => $arFields['IBLOCK_ID'],
            'CODE' => 'STATUS'
        );

        $res = CIBlockProperty::GetList(array(), $arFilter);
        while ($field = $res->Fetch()) {
            $propStatusId = $field['ID'];
        };

        // ищем id значений свойства STATUS типа список
        $orderEnumFields = [];
        $propertyEnums = CIBlockPropertyEnum::GetList(Array("DEF" => "DESC", "SORT" => "ASC"), Array("IBLOCK_ID" => $arFields['IBLOCK_ID'], "CODE" => 'STATUS'));
        while($enumFields = $propertyEnums->GetNext())
        {
            $orderEnumFields[$propStatusId][$enumFields["ID"]] = $enumFields["VALUE"];
        }

        // найдём текущее значение свойства STATUS
        $arSelect = Array("ID", "IBLOCK_ID", "PROPERTY_STATUS");
        $arFilter = Array("IBLOCK_ID" => $arFields['IBLOCK_ID'], "ID" => $arFields['ID'], "ACTIVE" => "Y");
        $res = CIBlockElement::GetList(Array(), $arFilter, false, Array(), $arSelect);
        while($ob = $res->fetch()) {
            $currentStatusId = $ob['PROPERTY_STATUS_ENUM_ID'];
        }

        // проверяем, было ли изменено свойство STATUS у заказа
        if ($currentStatusId != $arFields['PROPERTY_VALUES'][$propStatusId][0]['VALUE']) {
           // ищем значение свойства Email, чтобы отправить клиенту письмо об изменении статуса заказа
            $arFilter = array(
                'IBLOCK_ID' => $arFields['IBLOCK_ID'],
                'CODE' => 'EMAIL'
            );
    
            $res = CIBlockProperty::GetList(array(), $arFilter);
            while ($field = $res->Fetch()) {
                $propEmailId = $field['ID'];
            };
            $emailPropArray = $arFields['PROPERTY_VALUES'][$propEmailId];
            foreach ($emailPropArray as $key => $value) {
                $email = $value['VALUE'];
            }
         
            // собираем все нужные поля для отправки письма клиенту
            $arEventFields = array(
                "EMAIL_TO" => $email,
                "ORDER_ID" => $arFields['ID'],
                "STATUS" => $orderEnumFields[$propStatusId][$arFields['PROPERTY_VALUES'][$propStatusId][0]['VALUE']]
            );
    
            // отправляем клиенту письмо о смене статуса заказа
            CEvent::SendImmediate('ORDER_STATUS_WAS_CHANGED', 's1', $arEventFields, 'N', 56);  // письмо про обновление статуса заказа
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