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
                                <a href="#" class="me-3" target="_blank">
                                    <svg width="40" height="40" viewBox="0 0 40 40" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <g clip-path="url(#clip0_524_11594)">
                                            <path d="M20 0C14.6969 0 9.60625 2.10844 5.85938 5.85781C2.10863 9.60868 0.00103897 14.6956 0 20C0 25.3022 2.10938 30.3928 5.85938 34.1422C9.60625 37.8916 14.6969 40 20 40C25.3031 40 30.3938 37.8916 34.1406 34.1422C37.8906 30.3928 40 25.3022 40 20C40 14.6978 37.8906 9.60719 34.1406 5.85781C30.3938 2.10844 25.3031 0 20 0Z" fill="white"/>
                                            <path d="M9.05312 19.7888C14.8844 17.2488 18.7719 15.5741 20.7156 14.7651C26.2719 12.4548 27.425 12.0535 28.1781 12.0399C28.3437 12.0373 28.7125 12.0782 28.9531 12.2727C29.1531 12.4368 29.2094 12.6587 29.2375 12.8144C29.2625 12.9701 29.2969 13.3248 29.2687 13.6016C28.9687 16.7641 27.6656 24.4385 27.0031 27.9807C26.725 29.4794 26.1719 29.9819 25.6375 30.031C24.475 30.1379 23.5938 29.2635 22.4687 28.5263C20.7094 27.3723 19.7156 26.6541 18.0062 25.5282C16.0312 24.2269 17.3125 23.5116 18.4375 22.3429C18.7312 22.0369 23.85 17.3823 23.9469 16.9601C23.9594 16.9073 23.9719 16.7104 23.8531 16.6066C23.7375 16.5026 23.5656 16.5382 23.4406 16.5663C23.2625 16.6063 20.4531 18.4651 15.0031 22.1423C14.2062 22.6904 13.4844 22.9576 12.8344 22.9435C12.1219 22.9282 10.7469 22.5398 9.725 22.2079C8.475 21.8007 7.47812 21.5854 7.56562 20.8938C7.60937 20.5338 8.10625 20.1654 9.05312 19.7888Z" fill="#1A2030"/>
                                        </g>
                                        <defs>
                                            <clipPath id="clip0_524_11594">
                                                <rect width="40" height="40" fill="white"/>
                                            </clipPath>
                                        </defs>
                                    </svg>
                                                                                
                                </a>                   
                                <a href="https://vk.com/id812920522" target="_blank">
                                    <svg width="40" height="40" viewBox="0 0 40 40" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <g clip-path="url(#clip0_524_11597)">
                                            <path d="M15.815 0.005L17.03 0H22.97L24.1867 0.005L25.71 0.0216667L26.4317 0.0333333L27.1283 0.0516667L27.8 0.075L28.4467 0.101667L29.07 0.136667L29.67 0.178333L30.245 0.228333L30.8 0.283333C33.7 0.61 35.6883 1.31 37.1883 2.81C38.6883 4.31 39.3883 6.29667 39.715 9.19833L39.7717 9.75333L39.82 10.33L39.8617 10.93L39.895 11.5517L39.9367 12.5317L39.9567 13.215L39.9783 14.2883L39.9933 15.8133L40 17.4467L39.9983 22.9683L39.9933 24.185L39.9767 25.7083L39.965 26.43L39.9467 27.1267L39.9233 27.7983L39.8967 28.445L39.8617 29.0683L39.82 29.6683L39.77 30.2433L39.715 30.7983C39.3883 33.6983 38.6883 35.6867 37.1883 37.1867C35.6883 38.6867 33.7017 39.3867 30.8 39.7133L30.245 39.77L29.6683 39.8183L29.0683 39.86L28.4467 39.8933L27.4667 39.935L26.7833 39.955L25.71 39.9767L24.185 39.9917L22.5517 39.9983L17.03 39.9967L15.8133 39.9917L14.29 39.975L13.5683 39.9633L12.8717 39.945L12.2 39.9217L11.5533 39.895L10.93 39.86L10.33 39.8183L9.755 39.7683L9.2 39.7133C6.3 39.3867 4.31167 38.6867 2.81167 37.1867C1.31167 35.6867 0.611667 33.7 0.285 30.7983L0.228333 30.2433L0.18 29.6667L0.138333 29.0667L0.105 28.445L0.0633333 27.465L0.0433333 26.7817L0.0216667 25.7083L0.00666667 24.1833L0 22.55L0.00166667 17.0283L0.00666667 15.8117L0.0233333 14.2883L0.035 13.5667L0.0533333 12.87L0.0766667 12.1983L0.103333 11.5517L0.138333 10.9283L0.18 10.3283L0.23 9.75333L0.285 9.19833C0.611667 6.29833 1.31167 4.31 2.81167 2.81C4.31167 1.31 6.29833 0.61 9.2 0.283333L9.755 0.226667L10.3317 0.178333L10.9317 0.136667L11.5533 0.103333L12.5333 0.0616667L13.2167 0.0416667L14.29 0.02L15.815 0.005ZM11.3167 12.165H6.75C6.96667 22.565 12.1667 28.815 21.2833 28.815H21.8V22.865C25.15 23.1983 27.6833 25.6483 28.7 28.815H33.4333C32.1333 24.0817 28.7167 21.465 26.5833 20.465C28.7167 19.2317 31.7167 16.2317 32.4333 12.165H28.1333C27.2 15.465 24.4333 18.465 21.8 18.7483V12.165H17.5V23.6983C14.8333 23.0317 11.4667 19.7983 11.3167 12.165Z" fill="white"/>
                                        </g>
                                        <defs>
                                            <clipPath id="clip0_524_11597">
                                                <rect width="40" height="40" rx="20" fill="white"/>
                                            </clipPath>
                                        </defs>
                                    </svg>
                                        
                                </a>                   
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