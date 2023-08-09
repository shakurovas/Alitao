<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();?>
<?php
use Bitrix\Main\Type\DateTime;
use Bitrix\Highloadblock as HL;

// приязываем метод создания логина из введённой пользователем почты к событиям регистрации и обновления данных пользователя
AddEventHandler("main", "OnBeforeUserRegister", Array('Handlers', "OnBeforeUserUpdateHandler"));
AddEventHandler("main", "OnBeforeUserUpdate", Array('Handlers', "OnBeforeUserUpdateHandler"));

// привязываем метод для отсылки сообщений на почту пользователю после изменения статуса заказа
AddEventHandler("iblock", "OnBeforeIBlockElementUpdate", Array("Handlers", "InformAboutStatusChange"));


class Handlers
{
    // метод для создания логина из почты
    public static function OnBeforeUserUpdateHandler(&$arFields)
    {
        $arFields["LOGIN"] = $arFields["EMAIL"];
        return $arFields;
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


class Agents
{
    // метод-агент для обновления курса валют (выводится в хэдере в десктопной версии и бургер-меню в мобильной версии)
    public static function AgentGetCurrencyRate()
    {
        CModule::IncludeModule('highloadblock');
        $entity = HL\HighloadBlockTable::compileEntity('ExchangeRate');
        $curClass = $entity->getDataClass();

        $url = "https://openexchangerates.org/api/latest.json?app_id=85ba9498220f484b8aaac70f9b5fc516";
        $curl = curl_init($url);
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($curl);
        curl_close($curl);
        $decodedRates = json_decode($response)->rates;
    
        // создаём и заполняем массивы данных для обновления записей в highload-блоке
        $arFieldUSD = array();
        $arFieldCNY = array();
    
        $arFieldUSD['UF_CUR_DATE'] = DateTime::createFromTimestamp(time())->toString();
        // т. к. в бесплатной версии api курса валют в качестве базовой валюты доступен только USD, другие валюты считаем через него
        $arFieldUSD['UF_MAIN_VALUE'] = round($decodedRates->RUB, 1);
    
        $arFieldCNY['UF_CUR_DATE'] = DateTime::createFromTimestamp(time())->toString();
        // т. к. в бесплатной версии api курса валют в качестве базовой валюты доступен только USD, другие валюты считаем через него 
        $arFieldCNY['UF_MAIN_VALUE'] = round($decodedRates->RUB / $decodedRates->CNY, 1);
        
        // обновляем данные в highload-блоке
        $curClass::update(1, $arFieldUSD);
        $curClass::update(2, $arFieldCNY);
    
        $_SESSION['usdRate'] = round($decodedRates->RUB, 1);
        $_SESSION['cnyRate'] = round($decodedRates->RUB / $decodedRates->CNY, 1);
        
        return "Agents::AgentGetCurrencyRate();";
    }


    public static function AgentClearUsersPicsDir()
    {
        $files = glob('/upload/users_pics/*');  // получаем имена всех файлов внутри папки
        foreach ($files as $file) {  // итерируемся по файлам
          if (is_file($file)) {
            unlink($file);  // удаляем файл
          }
        }

        return "Agents::AgentClearUsersPicsDir();";
    }
}