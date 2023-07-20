<?php
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Политика конфиденциальности");

use \Bitrix\Main\Localization\Loc;
Loc::loadMessages(__FILE__);
?>
<main>
    <article class="container pt-7 mt-1 pb-10 mb-4">
        <h1 class="fs-lg-1 fs-3 fw-bold mb-lg-6 mb-4 text-break"><?=Loc::getMessage('PRIVACY_POLOTIC_TITLE');?></h1>

        <h3 class="fs-lg-2 fs-4 fw-bold mb-6 mb-lg-7">1. <?=Loc::getMessage('GENERAL_TERMS');?></h3>
        <?$APPLICATION->IncludeComponent(
            "bitrix:main.include", 
            ".default", 
            array(
                "AREA_FILE_SHOW" => "file",
                "AREA_FILE_SUFFIX" => "inc",
                "AREA_FILE_RECURSIVE" => "Y",
                "EDIT_TEMPLATE" => "",
                "COMPONENT_TEMPLATE" => ".default",
                "PATH" => "/include/privacy_policy.php"
            ),
            false
        );?>
    </article>
    
    
</main>

<?php require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");?>