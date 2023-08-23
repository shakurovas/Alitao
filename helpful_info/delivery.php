<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetPageProperty("title", "Условия доставки товаров из Китая в Россию с Alitao.shop");
$APPLICATION->SetPageProperty("description", "Обеспечьте себе удобство и надежность с доставкой товаров из Китая в Россию через Alitao.shop. Оптимизированная логистика с несколькими вариантами маршрутов на выбор");
$APPLICATION->SetTitle("Доставка");
$APPLICATION->AddHeadString('<link rel="canonical" href="' . ((!empty($_SERVER['HTTPS'])) ? 'https' : 'http') . '://' . $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'] . '"/>');

use \Bitrix\Main\Localization\Loc;
Loc::loadMessages(__FILE__);
?>
<main>
    <article class="container pt-7 mt-1 pb-10 mb-4  text">
        <section>
            <h1 class="h1 mb-4 mb-lg-6"><?=Loc::getMessage('DELIVERY_TITLE');?></h1>
            <p class="mb-5 mb-lg-7"><?=Loc::getMessage('DELIVERY_DESCRIPTION_1');?></p>
            <p><?=Loc::getMessage('DELIVERY_DESCRIPTION_2');?></p>
            <div class="delivery-grid py-6">
                <div >
                    <div class="delivery-img">
                        <div class="delivery-img__inner">
                            <img src="<?=SITE_TEMPLATE_PATH;?>/img/delivery/1.jpg" alt="">
                            <div class="delivery-img__text-block p-4 d-flex align-items-end text-white fs-3">
                                <?$APPLICATION->IncludeComponent(
                                    "bitrix:main.include", 
                                    ".default", 
                                    array(
                                        "AREA_FILE_SHOW" => "file",
                                        "AREA_FILE_SUFFIX" => "inc",
                                        "AREA_FILE_RECURSIVE" => "Y",
                                        "EDIT_TEMPLATE" => "",
                                        "COMPONENT_TEMPLATE" => ".default",
                                        "PATH" => "/include/delivery_method_1.php"
                                    ),
                                    false
                                );?>
                            </div>
                        </div>
                    </div>
                </div>
                <div >
                    <div class="delivery-img">
                        <div class="delivery-img__inner">
                            <img src="<?=SITE_TEMPLATE_PATH;?>/img/delivery/2.jpg" alt="">
                            <div class="delivery-img__text-block p-4 d-flex align-items-end text-white fs-3">
                                <?$APPLICATION->IncludeComponent(
                                    "bitrix:main.include", 
                                    ".default", 
                                    array(
                                        "AREA_FILE_SHOW" => "file",
                                        "AREA_FILE_SUFFIX" => "inc",
                                        "AREA_FILE_RECURSIVE" => "Y",
                                        "EDIT_TEMPLATE" => "",
                                        "COMPONENT_TEMPLATE" => ".default",
                                        "PATH" => "/include/delivery_method_2.php"
                                    ),
                                    false
                                );?>
                            </div>
                        </div>
                    </div>
                </div>
                <div >
                    <div class="delivery-img">
                        <div class="delivery-img__inner">
                            <img src="<?=SITE_TEMPLATE_PATH;?>/img/delivery/3.jpg" alt="">
                            <div class="delivery-img__text-block p-4 d-flex align-items-end text-white fs-3">
                                <?$APPLICATION->IncludeComponent(
                                    "bitrix:main.include", 
                                    ".default", 
                                    array(
                                        "AREA_FILE_SHOW" => "file",
                                        "AREA_FILE_SUFFIX" => "inc",
                                        "AREA_FILE_RECURSIVE" => "Y",
                                        "EDIT_TEMPLATE" => "",
                                        "COMPONENT_TEMPLATE" => ".default",
                                        "PATH" => "/include/delivery_method_3.php"
                                    ),
                                    false
                                );?>
                            </div>
                        </div>
                    </div>
                    
                </div>
            </div>
        </section>    
        
        <section class="py-lg-6 py-4">
            <h2 class="h1 mb-6"><?=Loc::getMessage('DELIVERY_DETAILS');?></h2>
            <?$APPLICATION->IncludeComponent(
                "bitrix:main.include", 
                ".default", 
                array(
                    "AREA_FILE_SHOW" => "file",
                    "AREA_FILE_SUFFIX" => "inc",
                    "AREA_FILE_RECURSIVE" => "Y",
                    "EDIT_TEMPLATE" => "",
                    "COMPONENT_TEMPLATE" => ".default",
                    "PATH" => "/include/delivery_details.php"
                ),
                false
            );?>
        </section>

        <section class="py-lg-6 py-4">
            <h2 class="h1 mb-6"><?=Loc::getMessage('PROHIBITED_FOR_TRANSPORTATION');?></h2>
            <?$APPLICATION->IncludeComponent(
                "bitrix:main.include", 
                ".default", 
                array(
                    "AREA_FILE_SHOW" => "file",
                    "AREA_FILE_SUFFIX" => "inc",
                    "AREA_FILE_RECURSIVE" => "Y",
                    "EDIT_TEMPLATE" => "",
                    "COMPONENT_TEMPLATE" => ".default",
                    "PATH" => "/include/prohibited_for_transportation.php"
                ),
                false
            );?>
        </section>

        <section class="py-lg-6 py-4">
            <h2 class="h1 mb-6"><?=Loc::getMessage('ADDITIONAL_FEES');?> </h2>
            <?$APPLICATION->IncludeComponent(
                "bitrix:main.include", 
                ".default", 
                array(
                    "AREA_FILE_SHOW" => "file",
                    "AREA_FILE_SUFFIX" => "inc",
                    "AREA_FILE_RECURSIVE" => "Y",
                    "EDIT_TEMPLATE" => "",
                    "COMPONENT_TEMPLATE" => ".default",
                    "PATH" => "/include/additional_fees.php"
                ),
                false
            );?>
        </section>

        <section class="py-lg-6 py-4">
            <h2 class="h1 mb-6"><?=Loc::getMessage('CARGO_PACKING');?></h2>
            <?$APPLICATION->IncludeComponent(
                "bitrix:main.include", 
                ".default", 
                array(
                    "AREA_FILE_SHOW" => "file",
                    "AREA_FILE_SUFFIX" => "inc",
                    "AREA_FILE_RECURSIVE" => "Y",
                    "EDIT_TEMPLATE" => "",
                    "COMPONENT_TEMPLATE" => ".default",
                    "PATH" => "/include/cargo_packing.php"
                ),
                false
            );?>
        </section>

        <section class="py-lg-6 py-4" id="timedelivery">
            <h2 class="h1 mb-6"><?=Loc::getMessage('DELIVERY_TERM');?></h2>
            <?$APPLICATION->IncludeComponent(
                "bitrix:main.include", 
                ".default", 
                array(
                    "AREA_FILE_SHOW" => "file",
                    "AREA_FILE_SUFFIX" => "inc",
                    "AREA_FILE_RECURSIVE" => "Y",
                    "EDIT_TEMPLATE" => "",
                    "COMPONENT_TEMPLATE" => ".default",
                    "PATH" => "/include/delivery_terms.php"
                ),
                false
            );?>
        </section>

        <section class="py-lg-6 py-4">
            <h2 class="h1 mb-6"><?=Loc::getMessage('SHIPPING_BY_RUSSIA');?></h2>
            <?$APPLICATION->IncludeComponent(
                "bitrix:main.include", 
                ".default", 
                array(
                    "AREA_FILE_SHOW" => "file",
                    "AREA_FILE_SUFFIX" => "inc",
                    "AREA_FILE_RECURSIVE" => "Y",
                    "EDIT_TEMPLATE" => "",
                    "COMPONENT_TEMPLATE" => ".default",
                    "PATH" => "/include/shipping_by_russia.php"
                ),
                false
            );?>
        </section>
    </article>
    
</main>

<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>
