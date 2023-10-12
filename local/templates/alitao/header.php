<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
define("NEED_AUTH", true);?>





<?php global $USER, $APPLICATION;
use Bitrix\Main\Page\Asset;
use \Bitrix\Main\Localization\Loc;
use Bitrix\Highloadblock as HL;
use Bitrix\Main\Type\DateTime;

Loc::loadMessages(__FILE__);
session_start();

// если страница открыта в мобильной версии
$isMobile = preg_match("/(android|avantgo|blackberry|bolt|boost|cricket|docomo|fone|hiptop|mini|mobi|palm|phone|pie|tablet|up\.browser|up\.link|webos|wos)/i", $_SERVER["HTTP_USER_AGENT"]);

// получение курса валют
CModule::IncludeModule('highloadblock');
$entity = HL\HighloadBlockTable::compileEntity('ExchangeRate');
$curClass = $entity->getDataClass();

$obCache = new CPHPCache();

if($obCache->InitCache(3600, 'cachekey', "/template/"))
{
   // если кеш существует, то его результат сразу будет выдан и не надо выполнять код с запросами к БД
   $resultCur = $obCache->GetVars();
} else {   // если кеша нет, то выполнится код и сформируется кеш. В дальнейшем будет отдаваться переменная из кеша, а не выполняться этот код
    $obCache->StartDataCache();

    $resultCur = array();
    $rsData = $curClass::getList(
        array(
        "select" => array('*'),
        "order" => array('ID' => 'ASC'),
        "filter" => array()
        )
    );
    while ($arData = $rsData->Fetch()) {
        $resultCur[$arData["ID"]] = $arData;
    }

   $obCache->EndDataCache($resultCur);
}


// получили текущие значения курса валют USD-RUB и CNY-RUB
$_SESSION['usdRate'] = $resultCur[1]['UF_MAIN_VALUE']; 
$_SESSION['cnyRate'] = $resultCur[2]['UF_MAIN_VALUE'];


// если страницу открыли с параметрами USER_LOGIN и USER_CHECKWORD - т. е. открыли ссылку с почты для восстановления пароля 
$isChangePasswordPage = !empty($_GET['USER_LOGIN']) && !empty($_GET['USER_CHECKWORD']);


?>

<!DOCTYPE html>
<html lang="ru_RU">
<head>

<!-- Yandex.Metrika counter -->
<script type="text/javascript" >
   (function(m,e,t,r,i,k,a){m[i]=m[i]||function(){(m[i].a=m[i].a||[]).push(arguments)};
   m[i].l=1*new Date();
   for (var j = 0; j < document.scripts.length; j++) {if (document.scripts[j].src === r) { return; }}
   k=e.createElement(t),a=e.getElementsByTagName(t)[0],k.async=1,k.src=r,a.parentNode.insertBefore(k,a)})
   (window, document, "script", "https://mc.yandex.ru/metrika/tag.js", "ym");

   ym(94717754, "init", {
        clickmap:true,
        trackLinks:true,
        accurateTrackBounce:true
   });
</script>
<noscript><div><img src="https://mc.yandex.ru/watch/94717754" style="position:absolute; left:-9999px;" alt="" /></div></noscript>
<!-- /Yandex.Metrika counter -->

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $APPLICATION->ShowTitle();?></title>
    <? $APPLICATION->ShowHead();?>
    <link rel="shortcut icon" href="<?=SITE_TEMPLATE_PATH;?>/img/favicon.svg" type="image/x-icon">

    <?php
    // стили
    Asset::getInstance()->addCss(SITE_TEMPLATE_PATH . "/css/main.css");
    Asset::getInstance()->addCss(SITE_TEMPLATE_PATH . "/css/bootstrap.min.css");
    Asset::getInstance()->addCss(SITE_TEMPLATE_PATH . "/css/main.min.css");

    // скрипты
    CJSCore::Init(array('jquery2'));

    if (!$isMobile && $APPLICATION->GetCurPage() != '/order/make_order_step_1.php') {
        Asset::getInstance()->addJs(SITE_TEMPLATE_PATH . "/js/bootstrap.bundle.min.js");
    } else if (!$isMobile && $APPLICATION->GetCurPage() == '/order/make_order_step_1.php') {
        Asset::getInstance()->addJs(SITE_TEMPLATE_PATH . "/js/bootstrap.bundle.min.js");
    }
       
    Asset::getInstance()->addJs(SITE_TEMPLATE_PATH . "/js/swiper-bundle.min.js");
    Asset::getInstance()->addJs(SITE_TEMPLATE_PATH . "/js/imask.js");
    Asset::getInstance()->addJs(SITE_TEMPLATE_PATH . "/js/forms.js");
    Asset::getInstance()->addJs(SITE_TEMPLATE_PATH . "/js/main.js");
    
    $APPLICATION->AddHeadString('<script src="//code.jivo.ru/widget/uVIN73ZcQ1" async></script>', true);
    
    ?>

</head>
<body>
    <?$APPLICATION->ShowPanel();?>
    <header class="header">
        <div class="header__top py-3 bg-primary d-none d-md-block">
            <div class="container fs-6" >
                <div class="d-flex justify-content-between align-items-center">
                    <strong class="text-white text-small "><?=Loc::getMessage('TITLE');?></strong>

                    <div class="d-inline-flex ">
                        <b class="text-white me-2"><?=Loc::getMessage('EXCHANGE_RATE');?>:</b>.
                        <b class="text-white">1 ¥ = <?=$_SESSION['cnyRate'];?> ₽ | 1 $ = <?=$_SESSION['usdRate'];?> ₽</b>
                    </div>
                    

                    <div class="d-inline-flex align-items-center">
                        <b class="text-white me-3"><?=Loc::getMessage('SOCIAL_NETWORKS');?></b>
                        <div class="d-inline-flex">
                        
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
                                    "PATH" => "/include/telegram_address_header_desktop.php"
                                ),
                                false
                            );
                            ?>    
                       
                            <?
                            $APPLICATION->IncludeComponent(
                                "bitrix:main.include", 
                                ".default", 
                                array(
                                    "AREA_FILE_SHOW" => "file",
                                    "AREA_FILE_SUFFIX" => "inc",
                                    "AREA_FILE_RECURSIVE" => "Y",
                                    "EDIT_TEMPLATE" => "",
                                    "COMPONENT_TEMPLATE" => ".default",
                                    "PATH" => "/include/vk_address_header_desktop.php"
                                ),
                                false
                            );
                            ?>
                        </div>
                    </div>
                </div>                
            </div>
        </div>
        <div class="header__bottom py-md-4 py-5">
            <div class="container">
            <div class="d-flex justify-content-center justify-content-xl-between align-items-center position-relative" >

                    

                    <a href="/">
                        <img src="<?=SITE_TEMPLATE_PATH;?>/img/header-logo.svg" alt="">                    
                    </a>
                    <?$APPLICATION->IncludeComponent(
	"bitrix:menu", 
	"header_menu", 
	array(
		"ROOT_MENU_TYPE" => "top",
		"MAX_LEVEL" => "1",
		"CHILD_MENU_TYPE" => "top",
		"USE_EXT" => "Y",
		"DELAY" => "N",
		"ALLOW_MULTI_SELECT" => "Y",
		"MENU_CACHE_TYPE" => "N",
		"MENU_CACHE_TIME" => "3600",
		"MENU_CACHE_USE_GROUPS" => "Y",
		"MENU_CACHE_GET_VARS" => array(
		),
		"COMPONENT_TEMPLATE" => "header_menu"
	),
	false
);?>

                    <div class="ps-xxl-10 ms-xxl-9 d-xl-flex d-none">
                        <?php if (!$USER->IsAuthorized()):?>
                            <button class="btn btn-primary d-inline-flex align-items-center" data-bs-toggle="modal" href="#singInModal" role="button">
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M12 12C13.4587 12 14.8576 11.4205 15.8891 10.3891C16.9205 9.35764 17.5 7.95869 17.5 6.5C17.5 5.04131 16.9205 3.64236 15.8891 2.61091C14.8576 1.57946 13.4587 1 12 1C10.5413 1 9.14236 1.57946 8.11091 2.61091C7.07946 3.64236 6.5 5.04131 6.5 6.5C6.5 7.95869 7.07946 9.35764 8.11091 10.3891C9.14236 11.4205 10.5413 12 12 12V12ZM15.6667 6.5C15.6667 7.47246 15.2804 8.40509 14.5927 9.09273C13.9051 9.78036 12.9725 10.1667 12 10.1667C11.0275 10.1667 10.0949 9.78036 9.40728 9.09273C8.71964 8.40509 8.33333 7.47246 8.33333 6.5C8.33333 5.52754 8.71964 4.59491 9.40728 3.90728C10.0949 3.21964 11.0275 2.83333 12 2.83333C12.9725 2.83333 13.9051 3.21964 14.5927 3.90728C15.2804 4.59491 15.6667 5.52754 15.6667 6.5V6.5ZM23 21.1667C23 23 21.1667 23 21.1667 23H2.83333C2.83333 23 1 23 1 21.1667C1 19.3333 2.83333 13.8333 12 13.8333C21.1667 13.8333 23 19.3333 23 21.1667ZM21.1667 21.1593C21.1648 20.7083 20.8843 19.3517 19.6413 18.1087C18.446 16.9133 16.1965 15.6667 12 15.6667C7.80167 15.6667 5.554 16.9133 4.35867 18.1087C3.11567 19.3517 2.837 20.7083 2.83333 21.1593H21.1667Z" fill="white"/>
                                </svg>
                                <span class="d-inline-block ms-2"><?=Loc::getMessage('LOG_IN');?></span>
                            </button>
                        <?php else:?>
                            <a class="btn btn-primary d-inline-flex align-items-center" href="/auth/personal.php">
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M12 12C13.4587 12 14.8576 11.4205 15.8891 10.3891C16.9205 9.35764 17.5 7.95869 17.5 6.5C17.5 5.04131 16.9205 3.64236 15.8891 2.61091C14.8576 1.57946 13.4587 1 12 1C10.5413 1 9.14236 1.57946 8.11091 2.61091C7.07946 3.64236 6.5 5.04131 6.5 6.5C6.5 7.95869 7.07946 9.35764 8.11091 10.3891C9.14236 11.4205 10.5413 12 12 12V12ZM15.6667 6.5C15.6667 7.47246 15.2804 8.40509 14.5927 9.09273C13.9051 9.78036 12.9725 10.1667 12 10.1667C11.0275 10.1667 10.0949 9.78036 9.40728 9.09273C8.71964 8.40509 8.33333 7.47246 8.33333 6.5C8.33333 5.52754 8.71964 4.59491 9.40728 3.90728C10.0949 3.21964 11.0275 2.83333 12 2.83333C12.9725 2.83333 13.9051 3.21964 14.5927 3.90728C15.2804 4.59491 15.6667 5.52754 15.6667 6.5V6.5ZM23 21.1667C23 23 21.1667 23 21.1667 23H2.83333C2.83333 23 1 23 1 21.1667C1 19.3333 2.83333 13.8333 12 13.8333C21.1667 13.8333 23 19.3333 23 21.1667ZM21.1667 21.1593C21.1648 20.7083 20.8843 19.3517 19.6413 18.1087C18.446 16.9133 16.1965 15.6667 12 15.6667C7.80167 15.6667 5.554 16.9133 4.35867 18.1087C3.11567 19.3517 2.837 20.7083 2.83333 21.1593H21.1667Z" fill="white"/>
                                </svg>
                                <span class="d-inline-block ms-2">
                                    <?php
                                    if ($USER->GetFullName()) {
                                        $nameAndSurname = explode(' ', $USER->GetFullName());
                                        echo $nameAndSurname[0] . ' ' . mb_substr($nameAndSurname[1], 0, 1) . '.';
                                    } else {
                                        echo GetMessage('PROFILE_TITLE');
                                    }
                                    ?>
                                </span>
                            </a>
                        <?php endif;?>
                    </div>


                    <button class="hamburger d-inline-block d-xl-none">
                        <img src="<?=SITE_TEMPLATE_PATH;?>/img/icons/hamburger.svg" alt="">
                    </button>
            </div>
            </div>
        </div>
    </header>

    
<div class="mobile-menu bg-dark d-xl-none">
	<div class="mobile-menu__header">
		<div class="container py-4 d-flex justify-content-between align-items-center">

			<h3 class="fs-2 fw-bold text-white mb-0"><?=Loc::getMessage('MENU');?></h3>

			<button class="mobile-menu__close">
				<svg width="32" height="32" viewBox="0 0 32 32" fill="none" xmlns="http://www.w3.org/2000/svg">
					<path fill-rule="evenodd" clip-rule="evenodd" d="M4.62627 4.62621C5.01679 4.23568 5.64996 4.23568 6.04048 4.62621L27.3738 25.9595C27.7643 26.3501 27.7643 26.9832 27.3738 27.3738C26.9833 27.7643 26.3501 27.7643 25.9596 27.3738L4.62627 6.04042C4.23574 5.6499 4.23574 5.01673 4.62627 4.62621Z" fill="white"/>
					<path fill-rule="evenodd" clip-rule="evenodd" d="M27.3738 4.62621C27.7643 5.01673 27.7643 5.6499 27.3738 6.04042L6.04048 27.3738C5.64996 27.7643 5.01679 27.7643 4.62627 27.3738C4.23574 26.9832 4.23574 26.3501 4.62627 25.9595L25.9596 4.62621C26.3501 4.23568 26.9833 4.23568 27.3738 4.62621Z" fill="white"/>
				</svg>                        
			</button>

		</div>
	</div>
	<nav class="mobile-menu__body ">
		<div class="container py-2 pb-6 d-flex flex-column flex-grow-1">
            <?$APPLICATION->IncludeComponent("bitrix:menu", "mobile_header_menu", Array(
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
                    
			<div class="d-flex justify-content-center mb-6 ">
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
                        "PATH" => "/include/vk_address_burger_menu_mobile.php"
                    ),
                    false
                );
                ?>	
            
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
                        "PATH" => "/include/telegram_address_burger_menu_mobile.php"
                    ),
                    false
                );
                ?>
			</div>


			<div class="fw-bold text-center fs-3">
				<div class="mb-2 text-white">
					<?=Loc::getMessage('EXCHANGE_RATE');?>:
				</div>
				<div class="text-primary">
					1 ¥ = <?=$_SESSION['cnyRate'];?> ₽ | 1 $ = <?=$_SESSION['usdRate'];?> ₽
				</div>
			</div>

			<div class="mt-8 flex-grow-1 d-flex align-items-end">
                <?php if (!$USER->IsAuthorized()):?>
                    <a href="/auth/mobile_authorization.php" class="btn btn-primary py-3 d-inline-flex align-items-center justify-content-center">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M12 12C13.4587 12 14.8576 11.4205 15.8891 10.3891C16.9205 9.35764 17.5 7.95869 17.5 6.5C17.5 5.04131 16.9205 3.64236 15.8891 2.61091C14.8576 1.57946 13.4587 1 12 1C10.5413 1 9.14236 1.57946 8.11091 2.61091C7.07946 3.64236 6.5 5.04131 6.5 6.5C6.5 7.95869 7.07946 9.35764 8.11091 10.3891C9.14236 11.4205 10.5413 12 12 12V12ZM15.6667 6.5C15.6667 7.47246 15.2804 8.40509 14.5927 9.09273C13.9051 9.78036 12.9725 10.1667 12 10.1667C11.0275 10.1667 10.0949 9.78036 9.40728 9.09273C8.71964 8.40509 8.33333 7.47246 8.33333 6.5C8.33333 5.52754 8.71964 4.59491 9.40728 3.90728C10.0949 3.21964 11.0275 2.83333 12 2.83333C12.9725 2.83333 13.9051 3.21964 14.5927 3.90728C15.2804 4.59491 15.6667 5.52754 15.6667 6.5V6.5ZM23 21.1667C23 23 21.1667 23 21.1667 23H2.83333C2.83333 23 1 23 1 21.1667C1 19.3333 2.83333 13.8333 12 13.8333C21.1667 13.8333 23 19.3333 23 21.1667ZM21.1667 21.1593C21.1648 20.7083 20.8843 19.3517 19.6413 18.1087C18.446 16.9133 16.1965 15.6667 12 15.6667C7.80167 15.6667 5.554 16.9133 4.35867 18.1087C3.11567 19.3517 2.837 20.7083 2.83333 21.1593H21.1667Z" fill="white"/>
                        </svg>
                        <span class="d-inline-block fs-4 ms-2"><?=Loc::getMessage('LOG_IN');?></span>
                    </a>
                <?php else: ?>
                    <a class="btn btn-primary py-3 d-inline-flex align-items-center justify-content-center" href="/auth/personal.php">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M12 12C13.4587 12 14.8576 11.4205 15.8891 10.3891C16.9205 9.35764 17.5 7.95869 17.5 6.5C17.5 5.04131 16.9205 3.64236 15.8891 2.61091C14.8576 1.57946 13.4587 1 12 1C10.5413 1 9.14236 1.57946 8.11091 2.61091C7.07946 3.64236 6.5 5.04131 6.5 6.5C6.5 7.95869 7.07946 9.35764 8.11091 10.3891C9.14236 11.4205 10.5413 12 12 12V12ZM15.6667 6.5C15.6667 7.47246 15.2804 8.40509 14.5927 9.09273C13.9051 9.78036 12.9725 10.1667 12 10.1667C11.0275 10.1667 10.0949 9.78036 9.40728 9.09273C8.71964 8.40509 8.33333 7.47246 8.33333 6.5C8.33333 5.52754 8.71964 4.59491 9.40728 3.90728C10.0949 3.21964 11.0275 2.83333 12 2.83333C12.9725 2.83333 13.9051 3.21964 14.5927 3.90728C15.2804 4.59491 15.6667 5.52754 15.6667 6.5V6.5ZM23 21.1667C23 23 21.1667 23 21.1667 23H2.83333C2.83333 23 1 23 1 21.1667C1 19.3333 2.83333 13.8333 12 13.8333C21.1667 13.8333 23 19.3333 23 21.1667ZM21.1667 21.1593C21.1648 20.7083 20.8843 19.3517 19.6413 18.1087C18.446 16.9133 16.1965 15.6667 12 15.6667C7.80167 15.6667 5.554 16.9133 4.35867 18.1087C3.11567 19.3517 2.837 20.7083 2.83333 21.1593H21.1667Z" fill="white"/>
                        </svg>
                        <span class="d-inline-block fs-4 ms-2">
                            <?php
                            if ($USER->GetFullName()) {
                                $nameAndSurname = explode(' ', $USER->GetFullName());
                                echo $nameAndSurname[0] . ' ' . mb_substr($nameAndSurname[1], 0, 1) . '.';
                            } else {
                                echo GetMessage('PROFILE_TITLE');
                            }
                            ?>
                        </span>
                    </a>
                <?PHP endif;?>
			</div>
		</div>
	</nav>
</div>

<div class="modal fade text-dark" id="singInModal" aria-hidden="true" aria-labelledby="singInModalLabel" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
      	<div class="modal-content">
			<div class="modal-header">          
				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
			</div>
			<div class="modal-body">
				<h5 class="h2 text-center mb-6"  id="singInModalLabel"><?=Loc::getMessage('LOG_IN');?></h5>
				<p class="fs-5 text-center mb-7"><?=Loc::getMessage('ENTER_EMAIL_AND_PASSWORD_FOR_LOGIN');?></p>
                <?$APPLICATION->IncludeComponent("bitrix:system.auth.form", "alitao_login_form",
                Array(
                    "REGISTER_URL" => "/",
                    "FORGOT_PASSWORD_URL" => "/",
                    "PROFILE_URL" => "/auth/personal.php",
                    "SHOW_ERRORS" => "Y" 
                    )
                );?>

				<hr class="text-gray my-4"/>
				<p class="text-center py-4"><?=Loc::getMessage('OR');?></p>
				<div class="d-flex justify-content-center">
					<button class="link-secondary" data-bs-target="#singUpModal" data-bs-toggle="modal" data-bs-dismiss="modal"><?=Loc::getMessage('REGISTER_NEW_PROFILE');?></button>

					
				</div>
				
			</div>
      	</div>
    </div>
</div>
  
<div class="modal fade text-dark" id="singUpModal" aria-hidden="true" aria-labelledby="singUpModalLabel" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header">          
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <h5 class="h2 text-center mb-6"  id="singUpModalLabel"><?=Loc::getMessage('REGISTRATION');?></h5>
            <p class="fs-5 text-center mb-7"><?=Loc::getMessage('ENTER_EMAIL_AND_PASSWORD_FOR_REGISTRATION');?></p>

            <?$APPLICATION->IncludeComponent("alitao:main.register", "alitao_registration", Array(
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
            
        </div>
        
      </div>
    </div>
  </div>
  
<div class="modal fade text-dark" id="recoveryModal" aria-hidden="true" aria-labelledby="recoveryModalLabel" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header">          
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <h5 class="h2 text-center mb-6"  id="recoveryModalLabel"><?=Loc::getMessage('PASSWORD_RECOVERY');?></h5>
            <p class="fs-5 text-center mb-7"><?=Loc::getMessage('ENTER_EMAIL_FOR_PASSWORD_RECOVERY');?></p>

            <form action="/" data-target="desktop-recovery" class="mb-7">
                <div class="mb-7" data-field="login">
                    <label for="sing-in-email" class="form-label"><?=Loc::getMessage('EMAIL');?></label>
                    <input type="email" class="form-control" id="sing-in-email" placeholder="<?=Loc::getMessage('ENTER_EMAIL');?>" name="login" required>                    
                </div>                
                
                <div class="d-flex justify-content-between align-items-center">
                    <button class="btn btn-success fs-5 px-6 py-3"><?=Loc::getMessage('RECOVER');?></button>
                    <span class="fs-5 d-inline-block link-secondary " data-bs-target="#singInModal" data-bs-toggle="modal" data-bs-dismiss="modal"><?=Loc::getMessage('I_REMEMBERED_PASSWORD');?></span>
                </div>
            </form>
            <hr class="text-gray my-4"/>
            <p class="text-center py-4"><?=Loc::getMessage('OR');?></p>
            <div class="d-flex justify-content-center">
                <button class="link-secondary" data-bs-target="#singUpModal" data-bs-toggle="modal" data-bs-dismiss="modal"><?=Loc::getMessage('REGISTER_NEW_PROFILE');?></button>

                
            </div>
            
        </div>
        
      </div>
    </div>
  </div>
  
<?php if (!$isMobile):?>
    <div class="modal fade text-dark <?php echo $isChangePasswordPage ? 'show' : '';?>" id="resetPassword" aria-hidden="<?php echo $isChangePasswordPage ? 'false': 'true';?>" aria-labelledby="resetPasswordLabel" tabindex="-1" <?php echo $isChangePasswordPage ? 'style="display: inline-block;"': '';?>>
        <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">          
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <h5 class="h2 text-center mb-6"  id="resetPasswordLabel"><?=Loc::getMessage('PASSWORD_RECOVERY');?></h5>
                
                <form action="/" data-target="desktop-reset-password">

                    <!--Логин-->
                    <input type="hidden" name="login" value="<?=$_GET['USER_LOGIN'];?>">
                    <!--Контрольная строка-->
                    <input type="hidden" name="checkword" value="<?=$_GET['USER_CHECKWORD'];?>">

                    <div class="mb-4" data-field="password">
                    <label for="recovery-password" class="form-label"><?=Loc::getMessage('NEW_PASSWORD');?></label>
                    <input type="password" class="form-control" id="recovery-password" placeholder="<?=Loc::getMessage('ENTER_PASSWORD');?>" name="password" required>                     
                    </div>
                    <div class="mb-7" data-field="retype-password">
                    <label for="recovery-password-2" class="form-label"><?=Loc::getMessage('PASSWORD');?></label>
                    <input type="password" class="form-control" id="recovery-password-2" placeholder="<?=Loc::getMessage('REPEAT_PASSWORD');?>" name="retype" required>                     
                    </div>
                    <button class="btn btn-success fs-5 px-6 py-3"><?=Loc::getMessage('RECOVER');?></button>
                </form>            
                            
            </div>
            
        </div>
        </div>
    </div>
<?php endif;?>
  
<div class="modal modal-send-question fade text-dark" id="sendQuestion" aria-hidden="true" aria-labelledby="sendQuestionLabel" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content send-question">
        <div class="modal-header">          
          <button type="button" id="questions-modal-close" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <h5 class="h1 text-center mb-4"  id="sendQuestionLabel"><?=Loc::getMessage('MORE_QUESTIONS?');?></h5>
            <p class="fs-5 text-center mb-9"><?=Loc::getMessage('LEAVE_A_QUESTION');?></p>


            <form action="/" data-target="desktop-send-question" class="mb-4">
                <div class="mb-6" data-field="name">
                    <label for="sq-name" class="form-label"><?=Loc::getMessage('USERS_NAME');?></label>
                    <input type="text" class="form-control" id="sq-name"
                        <?php if ($USER->IsAuthorized()) echo 'value="' . $USER->GetFirstName() . '"';
                        else echo 'placeholder="' . Loc::getMessage('YOUR_NAME') . '"';?>
                        name="name" required>                    
                </div>

                <div class="mb-6" data-field="contact">
                    <label for="sq-contact" class="form-label"><?=Loc::getMessage('USERS_CONTACT');?></label>
                    <input type="text" class="form-control" id="sq-contact"
                        <?php
                        if ($USER->IsAuthorized()) echo 'value="' . $USER->GetEmail() . '"';
                        else echo 'placeholder="' . Loc::getMessage('USERS_CONTACT') . '"';?>
                        name="contact" required>                     
                </div>
                <div class="mb-6" data-field="question">
                  <label for="sq-message" class="form-label"><?=Loc::getMessage('ENTER_MESSAGE');?></label>
                  <textarea class="form-control" id="sq-message" rows="6" placeholder="<?=Loc::getMessage('ENTER_MESSAGE');?>" name="message"></textarea>
                </div>


                
                <div class="d-flex justify-content-center">
                    <button class="btn btn-primary fs-5 px-9 py-3"><?=Loc::getMessage('SEND');?></button>
                </div>
            </form>            
            
        </div>
        
      </div>
    </div>
  </div>

    <?php if ($APPLICATION->GetCurPage() == '/auth/personal.php' || $APPLICATION->GetCurPage() == '/auth/profile_edit.php'):?>
        <div class="modal fade text-dark" id="changePassword" aria-hidden="true" aria-labelledby="changePasswordLabel" tabindex="-1">
            <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">          
                <button type="button" class="btn-close" id="change-password-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <h5 class="h2 text-center mb-6" id="changePasswordLabel"><?=Loc::getMessage('PASSWORD_CHANGE');?></h5>
                    
                    <form action="/" data-target="desktop-change-password">

                        
                        <div class="mb-4" data-field="old_password">
                        <label for="old-password" class="form-label"><?=Loc::getMessage('ENTER_PREVIOUS_PASSWORD');?></label>
                        <input type="password" class="form-control" id="old-password" placeholder="<?=Loc::getMessage('ENTER_PASSWORD');?>" name="old_password" required>                     
                        </div>
                        <div class="mb-7" data-field="new_password">
                        <label for="new-password" class="form-label"><?=Loc::getMessage('ENTER_NEW_PASSWORD');?></label>
                        <input type="password" class="form-control" id="new-password" placeholder="<?=Loc::getMessage('ENTER_NEW_PASSWORD');?>" name="new_password" required>                     
                        </div>
                        <button id="change-password-btn" class="btn btn-success fs-5 px-6 py-3"><?=Loc::getMessage('CHANGE_PASSWORD_BTN');?></button>
                    </form>            
                                
                </div>
                
            </div>
            </div>
        </div>
    <?php endif;?>

    <?php if ($APPLICATION->GetCurPage() == '/order/make_order_step_1.php' && !$isMobile):?>
        <div class="modal fade mo-modal text-dark" id="makeOrderModal" aria-hidden="true" aria-labelledby="makeOrderModalLabel" tabindex="-1">
            <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header bg-primary">  
                    <button id="close-adding-order-modal-btn" type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="adding-good-form" enctype="multipart/form-data" action="<?php echo $isMobile ? '/order/mobile_edit_add_order.php' : '/order/make_order_step_1.php';?>">
                        <h3 class="h2 mb-6"><?=Loc::getMessage('ENTER_POSITION_PARAMETERS');?> </h3>

                        <div class="mb-4">
                            <div class="mb-1">
                                <input type="url" name="product_link" id="product-link" class="form-control py-2"  placeholder="<?=Loc::getMessage('LINK_FOR_GOOD');?>">
                            </div>
                            <label class="text-dark fs-5 text-gray" for="product-link"><?=Loc::getMessage('PASTE_LINK');?>   
                                <a href="https://taobao.com" class="link-secondary" target="_blank">taobao,</a> 
                                <a href="https://tmall.com" class="link-secondary" target="_blank">tmall,</a>  
                                <a href="https://1688.com" class="link-secondary" target="_blank">1688,</a>  
                                
                                <span class="text-secondary"> <?=Loc::getMessage('OR_OTHER_CHINESE_SITES');?></span>
                            </label>
                        </div>
                            
                        <div class="mb-4">
                            <div class="mb-1">
                                <input type="text" name="product_name" id="product-name" class="form-control py-2"  placeholder="<?=Loc::getMessage('GOOD_NAME');?>">
                            </div>
                            <label class="text-dark fs-5 text-gray" for="product-name"><?=Loc::getMessage('SPECIFY_GOOD_NAME');?></label>
                        </div>

                        <div class="row mb-4">
                            <div class="col-6">

                                <div class="row">
                                    <input type="hidden" name="is_edit_mode" id="is_edit_mode" class="form-control py-2" value="<?php echo (isset($_GET['edit']) && $_GET['edit'] == 'y') ? 1 : 0;?>">
                                    <div class="col-6 mb-4">
                                        <label class="text-dark fs-5 mb-1" for="product-name"><?=Loc::getMessage('COST');?> ¥</label>
                                        <div >
                                            <input type="number" name="product_price" id="product-price" class="form-control py-2"  placeholder="<?=Loc::getMessage('OF_GOOD');?>" data-cross-field="product_qty" data-calc="data-price-calc">
                                        </div>
                                        
                                    </div>
                                    <div class="col-6 mb-4">
                                        <label class="text-dark fs-5 mb-1" for="product-size"><?=Loc::getMessage('SIZE');?></label>
                                        <div >
                                            <input type="text" name="product_size" id="product-size" class="form-control py-2"  placeholder="<?=Loc::getMessage('SPECIFY_SIZE');?>">
                                        </div>
                                        
                                    </div>
                                    <div class="col-6">
                                        <label class="text-dark fs-5 mb-1" for="delivery-price"><?=Loc::getMessage('DELIVERY');?>  ¥</label>
                                        <div >
                                            <input type="number" name="delivery_price" id="delivery-price" class="form-control py-2"  placeholder="<?=Loc::getMessage('THROUGH_CHINA');?>" data-calc="data-price-delivery">
                                        </div>
                                        
                                    </div>
                                    <div class="col-6">
                                        <label class="text-dark fs-5 mb-1" for="product-color"><?=Loc::getMessage('COLOUR');?></label>
                                        <div >
                                            <input type="tel" name="product_color" id="product-color" class="form-control py-2"  placeholder="<?=Loc::getMessage('SPECIFY_COLOUR');?>">
                                        </div>
                                        
                                    </div>

                                    
                                </div>


                            </div>
                            <div class="col-6 d-flex flex-column">
                                <label class="text-dark fs-5 mb-1" for="product-comment"><?=Loc::getMessage('NOTE');?></label>
                                
                                <textarea name="product_comment" id="product-comment" class="form-control py-2 flex-grow-1"  placeholder="<?=Loc::getMessage('ENTER_NOTE');?>"></textarea>
                                
                            </div>
                        </div>

                        <div class="d-flex align-items-center mb-4" >
                            <div class="flex-shrink-0 me-4 d-flex align-items-center">
                                <div class="inc-widget">
                                    <div id="minus-calc-btn" class="inc-widget__btn dec"></div>
                                    <input type="tel" class="inc-widget__input" name="product_qty" id="product-qty" min="1" value="1" data-cross-field="product_price" data-calc="data-price-calc">
                                    <div id="plus-calc-btn" class="inc-widget__btn inc"></div>
                                </div>
                            </div>
                            <div class="col flex-grow-1">
                                <div class="d-flex justify-content-between flex-wrap fs-6">
                                    <div>
                                        <p class="mb-2"><b><?=Loc::getMessage('SUMMATION');?></b></p>
                                        <p class="text-secondary">¥ <span id="product-cost-calc" data-price-calc="">0</span></p>
                                        <!-- <p class="text-secondary">₽ <span id="product-cost-calc-rub" data-price-calc="">0</span></p> -->
                                    </div>

                                    <div>
                                        <p class="mb-2"><b><?=Loc::getMessage('DELIVERY');?></b></p>
                                        <p class="text-secondary">¥ <span id="delivery-cost-calc" data-price-delivery="">0</span></p>
                                        <!-- <p class="text-secondary">₽ <span id="delivery-cost-calc-rub" data-price-delivery="">0</span></p> -->
                                    </div>

                                    <div>
                                        <p class="mb-2"><b><?=Loc::getMessage('SERVICES');?></b></p>
                                        <p class="text-secondary">¥ <span id="services-cost-calc" data-price-delivery="3">8</span></p>
                                        <!-- <p class="text-secondary">₽ <span id="services-cost-calc-rub" data-price-delivery="3"><?=8 * $_SESSION['cnyRate'];?></span></p> -->
                                    </div>
                                    <div>
                                        <p class="mb-2"><b><?=Loc::getMessage('TOTAL');?></b></p>
                                        <p class="text-success">¥ <span id="total-cost-calc" data-summ="3">0</span></p>
                                        <!-- <p class="text-success">₽ <span id="total-cost-calc-rub" data-summ="3">0</span></p> -->
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="d-flex mb-4">
                            <label for="product-photo" class="add-product-photo me-4 flex-shrink-0">
                                <div class="d-none">
                                    <input class="form-control" type="file" name="files[]" id="product-photo" class="message-files" multiple accept="image/*">   
                                </div>
                                <svg width="56" height="56" viewBox="0 0 56 56" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd" clip-rule="evenodd" d="M19.4348 6.21738C19.7312 5.6245 20.3372 5.25 21 5.25H35C35.6629 5.25 36.2688 5.6245 36.5652 6.21738L40.0652 13.2174C40.3365 13.7599 40.3075 14.4041 39.9886 14.92C39.6698 15.436 39.1065 15.75 38.5 15.75H17.5C16.8935 15.75 16.3302 15.436 16.0114 14.92C15.6925 14.4041 15.6635 13.7599 15.9348 13.2174L19.4348 6.21738ZM22.0816 8.75L20.3316 12.25H35.6684L33.9184 8.75H22.0816Z" fill="#FF431A"/>
                                    <path fill-rule="evenodd" clip-rule="evenodd" d="M8.16602 15.75C7.19952 15.75 6.41602 16.5335 6.41602 17.5V45.5C6.41602 46.4665 7.19952 47.25 8.16602 47.25H47.8327C48.7992 47.25 49.5827 46.4665 49.5827 45.5V17.5C49.5827 16.5335 48.7992 15.75 47.8327 15.75H8.16602ZM2.91602 17.5C2.91602 14.6005 5.26652 12.25 8.16602 12.25H47.8327C50.7322 12.25 53.0827 14.6005 53.0827 17.5V45.5C53.0827 48.3995 50.7322 50.75 47.8327 50.75H8.16602C5.26652 50.75 2.91602 48.3995 2.91602 45.5V17.5Z" fill="#FF431A"/>
                                    <path fill-rule="evenodd" clip-rule="evenodd" d="M16.916 31.5C16.916 25.3788 21.8782 20.4166 27.9993 20.4166C34.1205 20.4166 39.0827 25.3788 39.0827 31.5C39.0827 37.6211 34.1205 42.5833 27.9993 42.5833C21.8782 42.5833 16.916 37.6211 16.916 31.5ZM27.9993 23.9166C23.8112 23.9166 20.416 27.3118 20.416 31.5C20.416 35.6881 23.8112 39.0833 27.9993 39.0833C32.1875 39.0833 35.5827 35.6881 35.5827 31.5C35.5827 27.3118 32.1875 23.9166 27.9993 23.9166Z" fill="#FF431A"/>
                                </svg>
                                    
                            </label>


                            <div class="products-photo-grid flex-grow-1"></div>
                                            
                        </div>
                        <div style="color: #FF6948;"><?=Loc::getMessage('ADDING_PHOTOS_DESCRIPTION');?></div><br>

                        <div class="form-check d-flex align-items-center mb-8">
                            <input class="form-check-input me-2" type="checkbox" value="" id="photoreport" name="photoreport" checked >
                            <label class="form-check-label fs-lg-5 fs-6" for="photoreport">
                                <?=Loc::getMessage('I_NEED_PHOTO_REPORT');?> <span class="text-secondary">+5¥</span>
                            </label>
                        </div>

                        
                        <div class="d-flex justify-content-center mb-2">
                            <button type="submit" id="add-good-btn" class="btn btn-primary btn-add-product w-100 w-sm-auto" ><?=Loc::getMessage('ADD_GOOD');?></button>
                        </div>
                        <div id="required-fields" class="text-center" style="color: #FF6948; display: none;"><?=Loc::getMessage('NOT_ALL_REQUIRED_FIELDS_ARE_FILLED');?></div>
                        <p class="text-center text-gray"><?=Loc::getMessage('CHECK_PRICES');?> </p>
                    </form>
                </div>
                
            </div>
            </div>
        </div>
    




<?php endif;?>