<?php
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Регистрация");
$APPLICATION->AddHeadString('<link rel="canonical" href="' . ((!empty($_SERVER['HTTPS'])) ? 'https' : 'http') . '://' . $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'] . '"/>');

use \Bitrix\Main\Localization\Loc;
Loc::loadMessages(__FILE__);
?>

<main>
    <section class="container mobile-form-container pt-7 mt-1 pb-10  mb-4">
        <h1 class="h1 text-center mb-6" ><?=Loc::getMessage('REGISTRATION_TITLE');?></h1>
        <p class="fs-5 text-center mb-6"><?=Loc::getMessage('ENTER_EMAIL_AND_PASSWORD');?></p>
        
        <?$APPLICATION->IncludeComponent("alitao:main.register", "alitao_registration_mobile", Array(
            "USER_PROPERTY_NAME" => "", 
            "SEF_MODE" => "Y", 
            "SHOW_FIELDS" => Array(), 
            "REQUIRED_FIELDS" => Array(), 
            "AUTH" => "Y", 
            "USE_BACKURL" => "Y", 
            "SUCCESS_PAGE" => "/auth/personal.php", 
            "SET_TITLE" => "Y", 
            "USER_PROPERTY" => Array(), 
            "SEF_FOLDER" => "/", 
            "VARIABLE_ALIASES" => Array()
        ));?>
        
    </section>
</main>

<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>
