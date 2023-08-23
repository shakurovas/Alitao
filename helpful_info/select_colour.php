<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetPageProperty("title", "Помощь в выборе цвета на Табао | Alitao.shop");
$APPLICATION->SetPageProperty("description", "Узнайте, как сделать точный выбор цвета одежды при покупках на Таобао");
$APPLICATION->SetTitle("Выбор цвета");
$APPLICATION->AddHeadString('<link rel="canonical" href="' . ((!empty($_SERVER['HTTPS'])) ? 'https' : 'http') . '://' . $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'] . '"/>');

use \Bitrix\Main\Localization\Loc;
Loc::loadMessages(__FILE__);
?>
<main>
        
        <article class="container pt-7 mt-1 pb-10 mb-4  text">
            <h1 class="h1 mb-4"><?=Loc::getMessage('CHOOSING_COLOUR_TITLE');?></h1>
            <?$APPLICATION->IncludeComponent(
                "bitrix:main.include", 
                ".default", 
                array(
                    "AREA_FILE_SHOW" => "file",
                    "AREA_FILE_SUFFIX" => "inc",
                    "AREA_FILE_RECURSIVE" => "Y",
                    "EDIT_TEMPLATE" => "",
                    "COMPONENT_TEMPLATE" => ".default",
                    "PATH" => "/include/stage_1_choosing_colour.php"
                ),
                false
            );?>
            
            <div class="py-lg-6 py-4 d-flex justify-content-center">
                <picture>
                    <source srcset="<?=SITE_TEMPLATE_PATH;?>/img/select-color/1.jpg" media="(min-width: 576px)" />
                    <img src="<?=SITE_TEMPLATE_PATH;?>/img/select-color/1-mob.jpg" alt=""  class="img"/>
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
                    "PATH" => "/include/stage_2_choosing_colour.php"
                ),
                false
            );?>
           
            <div class="py-lg-6 py-4 d-none d-sm-flex justify-content-center">
                <picture>
                    <img src="<?=SITE_TEMPLATE_PATH;?>/img/select-color/2.jpg" alt=""  class="img"/>
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
                    "PATH" => "/include/stage_3_choosing_colour.php"
                ),
                false
            );?>
            
            <div class="py-lg-6 py-4 d-none d-sm-flex justify-content-center">
                <picture>
                    <img src="<?=SITE_TEMPLATE_PATH;?>/img/select-color/3.jpg" alt=""  class="img"/>
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
                    "PATH" => "/include/stage_4_choosing_colour.php"
                ),
                false
            );?>

            <div class="py-lg-6 py-4 d-flex justify-content-center">
                <picture>
                    <source srcset="<?=SITE_TEMPLATE_PATH;?>/img/select-color/4.jpg" media="(min-width: 576px)" />
                    <img src="<?=SITE_TEMPLATE_PATH;?>/img/select-color/4-mob.jpg" alt=""  class="img"/>
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
                    "PATH" => "/include/stage_5_choosing_colour.php"
                ),
                false
            );?>
            
            <div class="py-lg-6 py-4 d-none d-sm-flex justify-content-center">
                <picture>
                    <img src="<?=SITE_TEMPLATE_PATH;?>/img/select-color/5.jpg" alt=""  class="img"/>
                </picture>                
            </div>
        </article>
        
    </main>
        

<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>
