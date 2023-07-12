<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Оформление заказа");

use \Bitrix\Main\Localization\Loc;
Loc::loadMessages(__FILE__);
?>
<main>
    <article class="container pt-7 mt-1 pb-10 mb-4  text">
        <section>
            <h1 class="h1 mb-6"><?=Loc::getMessage('HOW_TO_PLACE_ORDER_TITLE');?></h1>
            <h3 class="h2 mb-lg-6 mb-5"><?=Loc::getMessage('STEP_1');?></h3>
            <p><?=Loc::getMessage('COPY_LINK');?></p>


            <div class="py-lg-6 py-4 mb-lg-6 d-flex justify-content-center">
                <picture>
                    <source srcset="<?=SITE_TEMPLATE_PATH;?>/img/how-place-order/1.jpg" media="(min-width: 576px)" />
                    <img src="<?=SITE_TEMPLATE_PATH;?>/img/how-place-order/1-mob.jpg" alt=""  class="img"/>
                </picture>
                
            </div>
            <p><?=Loc::getMessage('PRESS_BUTTONS');?></p>

            <div class="py-lg-6 py-4 mb-lg-6 d-flex justify-content-center">
                <picture>
                    <source srcset="<?=SITE_TEMPLATE_PATH;?>/img/how-place-order/2.jpg" media="(min-width: 576px)" />
                    <img src="<?=SITE_TEMPLATE_PATH;?>/img/how-place-order/2-mob.jpg" alt=""  class="img"/>
                </picture>                  
            </div>
        
            <ul class="list-style-disc mb-lg-6 mb-4">
                <li><span class="text"><?=Loc::getMessage('ITEM_1');?></span></li>
                <li><span class="text"><?=Loc::getMessage('ITEM_2');?></span></li>
                <li><span class="text"><?=Loc::getMessage('ITEM_3');?></span></li>
                <li><span class="text"><?=Loc::getMessage('ITEM_4');?></span></li>
                <li><span class="text"><?=Loc::getMessage('ITEM_5');?></span></li>                
            </ul>
            <p><?=Loc::getMessage('PRESS_ADD_GOOD_BTN');?></p>


            <div class="py-lg-6 py-4 mb-lg-6 d-flex justify-content-center">
                <picture>
                    <source srcset="<?=SITE_TEMPLATE_PATH;?>/img/how-place-order/3.jpg" media="(min-width: 576px)" />
                    <img src="<?=SITE_TEMPLATE_PATH;?>/img/how-place-order/3-mob.jpg" alt=""  class="img"/>
                </picture>                  
            </div>
            <p class="mb-sm-0 mb-7"><?=Loc::getMessage('ADD_ALL_GOODS');?></p>

            <div class="py-lg-6 py-4 mb-lg-6 d-none d-sm-flex justify-content-center">
                <picture>                    
                    <img src="<?=SITE_TEMPLATE_PATH;?>/img/how-place-order/4.jpg" alt=""  class="img"/>
                </picture>                  
            </div>
        </section>
        
        <section>
            <h3 class="h2 mb-lg-6 mb-4"><?=Loc::getMessage('STEP_2');?></h3>
            <ul class="mb-lg-7 mb-4">
                <li><?=Loc::getMessage('SPECIFY_ADDRESS');?></li>
                <li><?=Loc::getMessage('SPECIFY_NAME_AND_CONTACTS');?></li>
                <li><?=Loc::getMessage('SPECIFY_DELIVERY_AND_INSURANCE');?></li>
            </ul>
            <p><?=Loc::getMessage('PRESS_CONTINUE_BTN');?></p>
            <div class="py-lg-6 py-4 mb-lg-6 d-flex justify-content-center">
                <picture>
                    <source srcset="<?=SITE_TEMPLATE_PATH;?>/img/how-place-order/5.jpg" media="(min-width: 576px)" />
                    <img src="<?=SITE_TEMPLATE_PATH;?>/img/how-place-order/5-mob.jpg" alt=""  class="img"/>
                </picture>                  
            </div>
        </section>

        <section>
            <h3 class="h2 mb-lg-6 mb-4"><?=Loc::getMessage('STEP_3');?></h3>
            <div class="py-lg-6 py-4 mb-4 mb-lg-6 d-flex justify-content-center">
                <picture>
                    <source srcset="<?=SITE_TEMPLATE_PATH;?>/img/how-place-order/6.jpg" media="(min-width: 576px)" />
                    <img src="<?=SITE_TEMPLATE_PATH;?>/img/how-place-order/6-mob.jpg" alt=""  class="img"/>
                </picture>                  
            </div>
        </section>
        
        <section>
            <h3 class="h2 mb-lg-6 mb-4"><?=Loc::getMessage('STEP_4');?></h3>
            <p><?=Loc::getMessage('REQUEST_AN_INVOICE');?></p>
            <div class="py-lg-6 py-4 mb-4 mb-lg-6 d-flex justify-content-center">
                <picture>
                    <source srcset="<?=SITE_TEMPLATE_PATH;?>/img/how-place-order/7.jpg" media="(min-width: 576px)" />
                    <img src="<?=SITE_TEMPLATE_PATH;?>/img/how-place-order/7-mob.jpg" alt=""  class="img"/>
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
                    "PATH" => "/include/bottom_text_sizes.php"
                ),
                false
            );?>
        </section>
        
    </article>
    
    
</main>

<?require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/footer.php");?>