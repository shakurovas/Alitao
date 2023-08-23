<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetPageProperty("title", "Условия работы с Alitao.shop");
$APPLICATION->SetPageProperty("description", "Узнайте подробности о выгодных условиях работы с Alitao.shop. Низкая комиссия от 3%, эффективная логистика с 3 складами в Китае");
$APPLICATION->SetTitle("Условия работы");
$APPLICATION->AddHeadString('<link rel="canonical" href="' . ((!empty($_SERVER['HTTPS'])) ? 'https' : 'http') . '://' . $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'] . '"/>');

use \Bitrix\Main\Localization\Loc;
Loc::loadMessages(__FILE__);
?>
<main>        
    <article class="container text">
        <section class=" pt-7 mt-1 mb-8  ">
            <h1 class="h1 mb-5"><?=Loc::getMessage('TERMS');?></h1>
            <?$APPLICATION->IncludeComponent(
                "bitrix:main.include", 
                ".default", 
                array(
                    "AREA_FILE_SHOW" => "file",
                    "AREA_FILE_SUFFIX" => "inc",
                    "AREA_FILE_RECURSIVE" => "Y",
                    "EDIT_TEMPLATE" => "",
                    "COMPONENT_TEMPLATE" => ".default",
                    "PATH" => "/include/terms.php"
                ),
                false
            );?>
            
        </section>

        <section class=" pt-2 mt-1 mb-8 ">
            <h2 class="h1 mb-5"><?=Loc::getMessage('INSURANCE');?></h2>
            <?$APPLICATION->IncludeComponent(
                "bitrix:main.include", 
                ".default", 
                array(
                    "AREA_FILE_SHOW" => "file",
                    "AREA_FILE_SUFFIX" => "inc",
                    "AREA_FILE_RECURSIVE" => "Y",
                    "EDIT_TEMPLATE" => "",
                    "COMPONENT_TEMPLATE" => ".default",
                    "PATH" => "/include/insurance.php"
                ),
                false
            );?>
            
        </section>

        <section class=" pt-2 mt-1 mb-8  ">
            <h2 class="h1 mb-5"><?=Loc::getMessage('WORK_ORDER');?></h2>
            <?$APPLICATION->IncludeComponent(
                "bitrix:main.include", 
                ".default", 
                array(
                    "AREA_FILE_SHOW" => "file",
                    "AREA_FILE_SUFFIX" => "inc",
                    "AREA_FILE_RECURSIVE" => "Y",
                    "EDIT_TEMPLATE" => "",
                    "COMPONENT_TEMPLATE" => ".default",
                    "PATH" => "/include/work_order.php"
                ),
                false
            );?>
        </section>


        <section class=" pt-lg-2  mt-1 pb-10 mb-4 ">
            <h2 class="h1 mb-5"><?=Loc::getMessage('STATEMENT_TO_CUSTOMERS');?>!</h2>
            <?$APPLICATION->IncludeComponent(
                "bitrix:main.include", 
                ".default", 
                array(
                    "AREA_FILE_SHOW" => "file",
                    "AREA_FILE_SUFFIX" => "inc",
                    "AREA_FILE_RECURSIVE" => "Y",
                    "EDIT_TEMPLATE" => "",
                    "COMPONENT_TEMPLATE" => ".default",
                    "PATH" => "/include/statement_to_customers_terms.php"
                ),
                false
            );?>
            
          </section>
    </article>
</main>

<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>
