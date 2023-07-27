<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Поиск на Taobao");

use \Bitrix\Main\Localization\Loc;
Loc::loadMessages(__FILE__);
?>
<main>
    <article class="container pt-7 mt-1 pb-10 mb-4  text">
        <section class="mb-6">
            <h1 class="h1 mb-4"><?=Loc::getMessage('RUSSIAN_TAOBAO_TITLE');?></h1>
            <p class="mb-6 text-dark fw-bold"><a class="link-secondary" href="https://taobao.com" target="_blank">Taobao.com</a><?=Loc::getMessage('TAOBAO_QUESTION');?></p>

            <?$APPLICATION->IncludeComponent(
                "bitrix:main.include", 
                ".default", 
                array(
                    "AREA_FILE_SHOW" => "file",
                    "AREA_FILE_SUFFIX" => "inc",
                    "AREA_FILE_RECURSIVE" => "Y",
                    "EDIT_TEMPLATE" => "",
                    "COMPONENT_TEMPLATE" => ".default",
                    "PATH" => "/include/taobao_translate_way_1.php"
                ),
                false
            );?>
            
            <div class="py-lg-6 py-4 pb-lg-9 mb-lg-9 mb-3  d-flex justify-content-center">
                <picture>
                    <source srcset="<?=SITE_TEMPLATE_PATH;?>/img/search-taobao/1.jpg" media="(min-width: 576px)" />
                    <img src="<?=SITE_TEMPLATE_PATH;?>/img/search-taobao/1-mob.jpg" alt=""  class="img"/>
                </picture>                  
            </div>

            <?$APPLICATION->IncludeComponent(
                "bitrix:main.include", 
                ".default", 
                array(
                    "AREA_FILE_SHOW" => "file",
                    "AREA_FILE_SUFFIX" => "inc",
                    "AREA_FILE_RECURSIVE" => "Y",
                    "EDIT_TEMPLATE" => "",
                    "COMPONENT_TEMPLATE" => ".default",
                    "PATH" => "/include/taobao_translate_way_2.php"
                ),
                false
            );?>

            <div class="py-lg-6 py-4   d-flex justify-content-center">
                <picture>
                    <source srcset="<?=SITE_TEMPLATE_PATH;?>/img/search-taobao/2.jpg" media="(min-width: 576px)" />
                    <img src="<?=SITE_TEMPLATE_PATH;?>/img/search-taobao/2-mob.jpg" alt=""  class="img"/>
                </picture>                  
            </div>
        </section>
        <section class="mb-6">
            <h2 class="h1 mb-4"><?=Loc::getMessage('SEARCH_ON_TAOBAO_TITLE');?></h2>
            <p class="mb-lg-8 mb-5 text-dark fw-bold"><?=Loc::getMessage('SEARCH_WAY_1');?>:</p>
            <?$APPLICATION->IncludeComponent(
                "bitrix:main.include", 
                ".default", 
                array(
                    "AREA_FILE_SHOW" => "file",
                    "AREA_FILE_SUFFIX" => "inc",
                    "AREA_FILE_RECURSIVE" => "Y",
                    "EDIT_TEMPLATE" => "",
                    "COMPONENT_TEMPLATE" => ".default",
                    "PATH" => "/include/taobao_search_way_1_step_1.php"
                ),
                false
            );?>
           
            <div class="py-lg-6 py-4   d-flex justify-content-center">
                <picture>
                    <source srcset="<?=SITE_TEMPLATE_PATH;?>/img/search-taobao/3.jpg" media="(min-width: 576px)" />
                    <img src="<?=SITE_TEMPLATE_PATH;?>/img/search-taobao/3-mob.jpg" alt=""  class="img"/>
                </picture>                  
            </div>
            <?$APPLICATION->IncludeComponent(
                "bitrix:main.include", 
                ".default", 
                array(
                    "AREA_FILE_SHOW" => "file",
                    "AREA_FILE_SUFFIX" => "inc",
                    "AREA_FILE_RECURSIVE" => "Y",
                    "EDIT_TEMPLATE" => "",
                    "COMPONENT_TEMPLATE" => ".default",
                    "PATH" => "/include/taobao_search_way_1_step_2.php"
                ),
                false
            );?>
            
            <div class="py-lg-6 py-4   d-flex justify-content-center">
                <picture>
                    <source srcset="<?=SITE_TEMPLATE_PATH;?>/img/search-taobao/4.jpg" media="(min-width: 576px)" />
                    <img src="<?=SITE_TEMPLATE_PATH;?>/img/search-taobao/4-mob.jpg" alt=""  class="img"/>
                </picture>                  
            </div>
            <?$APPLICATION->IncludeComponent(
                "bitrix:main.include", 
                ".default", 
                array(
                    "AREA_FILE_SHOW" => "file",
                    "AREA_FILE_SUFFIX" => "inc",
                    "AREA_FILE_RECURSIVE" => "Y",
                    "EDIT_TEMPLATE" => "",
                    "COMPONENT_TEMPLATE" => ".default",
                    "PATH" => "/include/taobao_search_way_1_step_3.php"
                ),
                false
            );?>

            <p class="mb-lg-8 mb-5 text-dark fw-bold"><?=Loc::getMessage('SEARCH_WAY_2');?>:</p>
            <?$APPLICATION->IncludeComponent(
                "bitrix:main.include", 
                ".default", 
                array(
                    "AREA_FILE_SHOW" => "file",
                    "AREA_FILE_SUFFIX" => "inc",
                    "AREA_FILE_RECURSIVE" => "Y",
                    "EDIT_TEMPLATE" => "",
                    "COMPONENT_TEMPLATE" => ".default",
                    "PATH" => "/include/taobao_search_way_2_step_1.php"
                ),
                false
            );?>
            
            <div class="py-lg-6 py-4   d-flex justify-content-center">
                <picture>
                    <source srcset="<?=SITE_TEMPLATE_PATH;?>/img/search-taobao/5.jpg" media="(min-width: 576px)" />
                    <img src="<?=SITE_TEMPLATE_PATH;?>/img/search-taobao/5-mob.jpg" alt=""  class="img"/>
                </picture>                  
            </div>
            <?$APPLICATION->IncludeComponent(
                "bitrix:main.include", 
                ".default", 
                array(
                    "AREA_FILE_SHOW" => "file",
                    "AREA_FILE_SUFFIX" => "inc",
                    "AREA_FILE_RECURSIVE" => "Y",
                    "EDIT_TEMPLATE" => "",
                    "COMPONENT_TEMPLATE" => ".default",
                    "PATH" => "/include/taobao_search_way_2_step_2.php"
                ),
                false
            );?>
           
            <div class="py-lg-6 py-4   d-flex justify-content-center">
                <picture>
                    <source srcset="<?=SITE_TEMPLATE_PATH;?>/img/search-taobao/6.jpg" media="(min-width: 576px)" />
                    <img src="<?=SITE_TEMPLATE_PATH;?>/img/search-taobao/6-mob.jpg" alt=""  class="img"/>
                </picture>                  
            </div>
        </section>
        <section>
            <h2 class="h1 mb-4"><?=Loc::getMessage('SELLER_RATING');?></h2>
            <?$APPLICATION->IncludeComponent(
                "bitrix:main.include", 
                ".default", 
                array(
                    "AREA_FILE_SHOW" => "file",
                    "AREA_FILE_SUFFIX" => "inc",
                    "AREA_FILE_RECURSIVE" => "Y",
                    "EDIT_TEMPLATE" => "",
                    "COMPONENT_TEMPLATE" => ".default",
                    "PATH" => "/include/taobao_sellers_rating_description.php"
                ),
                false
            );?>
            <p><?=Loc::getMessage('SELLERS_RATING_TABLE');?> :</p>
            <div class="py-lg-6 py-4   d-flex justify-content-center">
                <picture>                        
                    <img src="<?=SITE_TEMPLATE_PATH;?>/img/search-taobao/7.jpg" alt=""  class="img"/>
                </picture>                  
            </div>
            <?$APPLICATION->IncludeComponent(
                "bitrix:main.include", 
                ".default", 
                array(
                    "AREA_FILE_SHOW" => "file",
                    "AREA_FILE_SUFFIX" => "inc",
                    "AREA_FILE_RECURSIVE" => "Y",
                    "EDIT_TEMPLATE" => "",
                    "COMPONENT_TEMPLATE" => ".default",
                    "PATH" => "/include/taobao_sellers_important_info.php"
                ),
                false
            );?>
            <?$APPLICATION->IncludeComponent(
                "bitrix:main.include", 
                ".default", 
                array(
                    "AREA_FILE_SHOW" => "file",
                    "AREA_FILE_SUFFIX" => "inc",
                    "AREA_FILE_RECURSIVE" => "Y",
                    "EDIT_TEMPLATE" => "",
                    "COMPONENT_TEMPLATE" => ".default",
                    "PATH" => "/include/bottom_text_taobao_search.php"
                ),
                false
            );?>
        </section>
    </article>
</main>

<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>