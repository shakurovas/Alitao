<?php
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Оплата");

use \Bitrix\Main\Localization\Loc;
Loc::loadMessages(__FILE__);
?>

<main>
    <article class="container pt-7 mt-1 pb-10 mb-4 text">
        <section class="mb-lg-9 mb-7 ">
            <h1 class="h1  mb-5"><?=Loc::getMessage('PAYMENT_TITLE');?></h1>
            <h3 class="fs-lg-2 fs-3 fs-lg-2 mb-2 mb-lg-4 text-dark">1. <?=Loc::getMessage('PAYMENT_WAY_1');?></h3>
            <?$APPLICATION->IncludeComponent(
                "bitrix:main.include", 
                ".default", 
                array(
                    "AREA_FILE_SHOW" => "file",
                    "AREA_FILE_SUFFIX" => "inc",
                    "AREA_FILE_RECURSIVE" => "Y",
                    "EDIT_TEMPLATE" => "",
                    "COMPONENT_TEMPLATE" => ".default",
                    "PATH" => "/include/payment_way_1.php"
                ),
                false
            );?>

            <h3 class="fs-lg-2 fs-3 fs-lg-2 mb-2 mb-lg-4 text-dark">2.  <?=Loc::getMessage('PAYMENT_WAY_2');?>.</h3>
            <?$APPLICATION->IncludeComponent(
                "bitrix:main.include", 
                ".default", 
                array(
                    "AREA_FILE_SHOW" => "file",
                    "AREA_FILE_SUFFIX" => "inc",
                    "AREA_FILE_RECURSIVE" => "Y",
                    "EDIT_TEMPLATE" => "",
                    "COMPONENT_TEMPLATE" => ".default",
                    "PATH" => "/include/payment_way_2.php"
                ),
                false
            );?>
        </section>  
        
        
        <section class="mb-lg-10 mb-7 pb-lg-2 fs-lg-3 fs-5 text-dark-gray">
            <h2 class="h1 mb-5"><?=Loc::getMessage('PAYMENT_PROCEDURE_TITLE');?></h2>
            <?$APPLICATION->IncludeComponent(
                "bitrix:main.include", 
                ".default", 
                array(
                    "AREA_FILE_SHOW" => "file",
                    "AREA_FILE_SUFFIX" => "inc",
                    "AREA_FILE_RECURSIVE" => "Y",
                    "EDIT_TEMPLATE" => "",
                    "COMPONENT_TEMPLATE" => ".default",
                    "PATH" => "/include/payment_procedure.php"
                ),
                false
            );?>
        </section>

        <section class="fs-lg-3 fs-5 text-dark-gray">
            <h2 class="h1 mb-5 "><?=Loc::getMessage('PAYMENT_TERMS_TITLE');?></h2>
            <?$APPLICATION->IncludeComponent(
                "bitrix:main.include", 
                ".default", 
                array(
                    "AREA_FILE_SHOW" => "file",
                    "AREA_FILE_SUFFIX" => "inc",
                    "AREA_FILE_RECURSIVE" => "Y",
                    "EDIT_TEMPLATE" => "",
                    "COMPONENT_TEMPLATE" => ".default",
                    "PATH" => "/include/payment_terms.php"
                ),
                false
            );?>
        </section>
    </article>
    
    
    
</main>

<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>
