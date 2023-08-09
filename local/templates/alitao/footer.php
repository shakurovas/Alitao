<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<?php
use \Bitrix\Main\Localization\Loc;
Loc::loadLanguageFile(__FILE__);
?>
<footer class="footer bg-dark ">

        <div class="footer__top py-7 mb-2">
            <div class="container px-xxl-10">
                <div class="d-flex justify-content-sm-between justify-content-center text-sm-start text-center flex-column flex-sm-row">
                    <div class="footer__col d-none d-lg-block">
                        <h3 class="h5 text-white fw-bold mb-3"><?=Loc::getMessage('MENU');?></h3>
                        <?$APPLICATION->IncludeComponent("bitrix:menu", "footer_menu", Array(
                            "ROOT_MENU_TYPE" => "top", 
                            "MAX_LEVEL" => "1", 
                            "CHILD_MENU_TYPE" => "top", 
                            "USE_EXT" => "Y",
                            "DELAY" => "N",
                            "ALLOW_MULTI_SELECT" => "Y",
                            "MENU_CACHE_TYPE" => "N", 
                            "MENU_CACHE_TIME" => "3600", 
                            "MENU_CACHE_USE_GROUPS" => "Y", 
                            "MENU_CACHE_GET_VARS" => "" 
                        ));?>
                    </div>

                    <div class="footer__col d-none d-lg-block">
                        <h3 class="h5 text-white fw-bold mb-3"><?=Loc::getMessage('USEFUL_LINKS');?></h3>
                        <?$APPLICATION->IncludeComponent("bitrix:menu", "footer_menu", Array(
                            "ROOT_MENU_TYPE" => "bottom", 
                            "MAX_LEVEL" => "1", 
                            "CHILD_MENU_TYPE" => "bottom", 
                            "USE_EXT" => "Y",
                            "DELAY" => "N",
                            "ALLOW_MULTI_SELECT" => "Y",
                            "MENU_CACHE_TYPE" => "N", 
                            "MENU_CACHE_TIME" => "3600", 
                            "MENU_CACHE_USE_GROUPS" => "Y", 
                            "MENU_CACHE_GET_VARS" => "" 
                        ));?>
                    </div>



                    <div class="footer__col mb-3 mb-sm-0">
                        <h3 class="h5 text-white fw-bold mb-3"><?=Loc::getMessage('WORKING_HOURS');?></h3>
                        <ul>
                            <li class="mb-2">
                                <?php
                                    $moscowTimeZone = 'Europe/Moscow';
                                    $pekingTimeZone = 'Asia/Hong_Kong'; // для Пекина отдельно нет
                                    $timestamp = time();
                                    $dtMoscow = new DateTime("now", new DateTimeZone($moscowTimeZone)); 
                                    $dtPeking = new DateTime("now", new DateTimeZone($pekingTimeZone)); 
                                    $dtMoscow->setTimestamp($timestamp); //adjust the object to correct timestamp
                                    $dtPeking->setTimestamp($timestamp); //adjust the object to correct timestamp
                                ?>
                                <p class="text-gray fs-6 mb-0"><?=Loc::getMessage('MOSCOW');?> <span id="moscow-time"><?=$dtMoscow->format('H:i');?></span></p>
                                <?$APPLICATION->IncludeComponent(
                                    "bitrix:main.include", 
                                    ".default", 
                                    array(
                                        "AREA_FILE_SHOW" => "file",
                                        "AREA_FILE_SUFFIX" => "inc",
                                        "AREA_FILE_RECURSIVE" => "Y",
                                        "EDIT_TEMPLATE" => "",
                                        "COMPONENT_TEMPLATE" => ".default",
                                        "PATH" => "/include/moscow_working_hours.php"
                                    ),
                                    false
                                );?>
                            </li>
                            <li class="mb-2">
                                <p class="text-gray fs-6 mb-0"><?=Loc::getMessage('PEKING');?> <span id="peking-time"><?=$dtPeking->format('H:i');?></span></p>
                                
                                <?$APPLICATION->IncludeComponent(
                                    "bitrix:main.include", 
                                    ".default", 
                                    array(
                                        "AREA_FILE_SHOW" => "file",
                                        "AREA_FILE_SUFFIX" => "inc",
                                        "AREA_FILE_RECURSIVE" => "Y",
                                        "EDIT_TEMPLATE" => "",
                                        "COMPONENT_TEMPLATE" => ".default",
                                        "PATH" => "/include/peking_working_hours.php"
                                    ),
                                    false
                                );?>
                            </li>
                            <li class="mb-1">
                                <p class="text-gray fs-6 mb-0"><?=Loc::getMessage('SUNDAY');?></p>
                                <p class="text-white  mb-0"><?=Loc::getMessage('WEEKEND');?></p>
                                
                            </li>
                        </ul>
                    </div>


                    
                    <div class="footer__col mb-3 mb-sm-0 fs-6">
                        <h3 class="h5 text-white fw-bold mb-3"><?=Loc::getMessage('OUR_ADDRESSES');?></h3>
                        <ul>
                            <li class="mb-2">
                                <p class="text-gray  mb-0"><?=Loc::getMessage('ADDRESS_1');?> </p>
                                <?$APPLICATION->IncludeComponent(
                                    "bitrix:main.include", 
                                    ".default", 
                                    array(
                                        "AREA_FILE_SHOW" => "file",
                                        "AREA_FILE_SUFFIX" => "inc",
                                        "AREA_FILE_RECURSIVE" => "Y",
                                        "EDIT_TEMPLATE" => "",
                                        "COMPONENT_TEMPLATE" => ".default",
                                        "PATH" => "/include/manchuria_address.php"
                                    ),
                                    false
                                );?>
                            </li>
                            <li class="mb-2">
                                <p class="text-gray  mb-0"><?=Loc::getMessage('ADDRESS_2');?></p>
                                <?$APPLICATION->IncludeComponent(
                                    "bitrix:main.include", 
                                    ".default", 
                                    array(
                                        "AREA_FILE_SHOW" => "file",
                                        "AREA_FILE_SUFFIX" => "inc",
                                        "AREA_FILE_RECURSIVE" => "Y",
                                        "EDIT_TEMPLATE" => "",
                                        "COMPONENT_TEMPLATE" => ".default",
                                        "PATH" => "/include/guangzhou_address.php"
                                    ),
                                    false
                                );?>
                            </li>
                            <li>
                                <p class="text-gray  mb-0"><?=Loc::getMessage('ADDRESS_3');?></p>
                                <?$APPLICATION->IncludeComponent(
                                    "bitrix:main.include", 
                                    ".default", 
                                    array(
                                        "AREA_FILE_SHOW" => "file",
                                        "AREA_FILE_SUFFIX" => "inc",
                                        "AREA_FILE_RECURSIVE" => "Y",
                                        "EDIT_TEMPLATE" => "",
                                        "COMPONENT_TEMPLATE" => ".default",
                                        "PATH" => "/include/moscow_address.php"
                                    ),
                                    false
                                );?>
                            </li>
                        </ul>
                    </div>

                    
                    <div class="footer__col">
                        <h3 class="h5 text-white fw-bold mb-3"><?=Loc::getMessage('CONTACT_US');?></h3>
                        <ul>
                            <div class="d-sm-block d-flex justify-content-between flex-wrap">
                                <li class="mb-2" style="text-align: left;">
                                    <p class="text-gray fs-6 mb-0 text-start"><?=Loc::getMessage('PHONE_NUMBER_1');?></p>
                                    <?$APPLICATION->IncludeComponent(
                                        "bitrix:main.include", 
                                        ".default", 
                                        array(
                                            "AREA_FILE_SHOW" => "file",
                                            "AREA_FILE_SUFFIX" => "inc",
                                            "AREA_FILE_RECURSIVE" => "Y",
                                            "EDIT_TEMPLATE" => "",
                                            "COMPONENT_TEMPLATE" => ".default",
                                            "PATH" => "/include/chinese_phone_number.php"
                                        ),
                                        false
                                    );?><br>
                                    <?$APPLICATION->IncludeComponent(
                                        "bitrix:main.include", 
                                        ".default", 
                                        array(
                                            "AREA_FILE_SHOW" => "file",
                                            "AREA_FILE_SUFFIX" => "inc",
                                            "AREA_FILE_RECURSIVE" => "Y",
                                            "EDIT_TEMPLATE" => "",
                                            "COMPONENT_TEMPLATE" => ".default",
                                            "PATH" => "/include/chinese_phone_number_2.php"
                                        ),
                                        false
                                    );?>                        
                                </li>
                                <li class="mb-8">
                                    <p class="text-gray fs-6 mb-0 text-start"><?=Loc::getMessage('PHONE_NUMBER_2');?></p>
                                    <?$APPLICATION->IncludeComponent(
                                        "bitrix:main.include", 
                                        ".default", 
                                        array(
                                            "AREA_FILE_SHOW" => "file",
                                            "AREA_FILE_SUFFIX" => "inc",
                                            "AREA_FILE_RECURSIVE" => "Y",
                                            "EDIT_TEMPLATE" => "",
                                            "COMPONENT_TEMPLATE" => ".default",
                                            "PATH" => "/include/russian_phone_number.php"
                                        ),
                                        false
                                    );?>
                                </li>
                            </div>
                            
                            <li class="d-flex justify-content-center justify-content-sm-start">
                                <?$APPLICATION->IncludeComponent(
                                    "bitrix:main.include", 
                                    ".default", 
                                    array(
                                        "AREA_FILE_SHOW" => "file",
                                        "AREA_FILE_SUFFIX" => "inc",
                                        "AREA_FILE_RECURSIVE" => "Y",
                                        "EDIT_TEMPLATE" => "",
                                        "COMPONENT_TEMPLATE" => ".default",
                                        "PATH" => "/include/telegram_address_footer.php"
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
                                        "PATH" => "/include/vk_address_footer.php"
                                    ),
                                    false
                                );?>                               
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <div class="footer__bottom py-sm-6 py-2 ">
            <div class="container px-xxl-10 <?php echo $isMobile ? 'footer-in-line-links' : 'd-flex';?> justify-content-evenly justify-content-sm-between  align-items-center">
                <!-- <a href="/">
                    <img src="<?//=SITE_TEMPLATE_PATH;?>/img/footer-logo.svg" alt="">
                </a> -->
                <?php if ($isMobile):?>
                    <a href="/privacy_policy/" class="text-white footer-in-line-links">
                        <?=Loc::getMessage('PRIVACY_POLITICS');?>
                    </a><br>
                    <a href="/personal_data_processing/" class="text-white footer-in-line-links">
                        <?=Loc::getMessage('PERSONAL_DATA_PROCESSING');?>
                    </a><br><br>
                <?php endif;?>
                <span class="text-white <?php echo $isMobile ? 'footer-in-line-links' : '';?>">
                 <?php
                    $APPLICATION->IncludeComponent(
                        "bitrix:main.include", 
                        ".default", 
                        array(
                            "AREA_FILE_SHOW" => "file",
                            "AREA_FILE_SUFFIX" => "inc",
                            "AREA_FILE_RECURSIVE" => "Y",
                            "EDIT_TEMPLATE" => "",
                            "COMPONENT_TEMPLATE" => ".default",
                            "PATH" => "/include/copyright_text.php"
                        ),
                        false
                    );
                    ?>
                </span>
                <?php if (!$isMobile):?>
                    <a href="/privacy_policy/" class="text-white">
                        <?=Loc::getMessage('PRIVACY_POLITICS');?>
                    </a>
                    <a href="/personal_data_processing/" class="text-white">
                        <?=Loc::getMessage('PERSONAL_DATA_PROCESSING');?>
                    </a>
                <?php endif;?>
            </div>
        </div>
    </footer>
</body>
</html>