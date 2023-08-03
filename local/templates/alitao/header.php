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
   //Если кеш существует, то его результат сразу будет выдан и не надо выполнять код с запросами к БД
   $resultCur = $obCache->GetVars();
} else {   //Если кеша нет, то выполнится код и сформируется кеш. В дальнейшем будет отдаваться переменная из кеша, а не выполняться этот код
    $obCache->StartDataCache();

    $resultCur = array();
    $rsData = $curClass::getList(
        array(
        "select" => array('*'),
        "order" => array('ID' => 'ASC'),
        "filter" => array()
        )
    );
    while($arData = $rsData->Fetch()){
        $resultCur[$arData["ID"]] = $arData;
    }

   //$arCurSection - передаем в кеш переменную с полученными в коде значениями
   $obCache->EndDataCache($resultCur);
}


// получили текущие значения курса валют USD-RUB и CNY-RUB
$_SESSION['usdRate'] = $resultCur[1]['UF_MAIN_VALUE']; 
$_SESSION['cnyRate'] = $resultCur[2]['UF_MAIN_VALUE'];

// получаем текущее время и последнее время обновления данных в таблице, чтобы далее узнать, не позже часа ли они обновлялись
$timestampUSD = strtotime($resultCur[1]['UF_CUR_DATE']);
$timestampCNY = strtotime($resultCur[2]['UF_CUR_DATE']);
$today = time();
// AddMessage2Log('MARWEY');
// AddMessage2Log($today - $timestampUSD);
// AddMessage2Log(gettype($today - $timestampCNY));
// проверяем, если курс обновлялся больше часа назад, то нужно получить новые данные
if (($today - $timestampUSD) > 3600 || ($today - $timestampCNY) > 3600) {

    // с помощью curl получаем данные с сайта openexchangerates.org
    $url = "https://openexchangerates.org/api/latest.json?app_id=bd73895d82e44ebeb67cda1004b0abe9";
    $curl = curl_init($url);
    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    $response = curl_exec($curl);
    curl_close($curl);
    $decodedRates = json_decode($response)->rates;

    // создаём и заполняем массивы данных для обновления записей в highload-блоке
    $arFieldUSD = array();
    $arFieldCNY = array();

    $arFieldUSD['UF_CUR_DATE'] = DateTime::createFromTimestamp(time())->toString();
    // т. к. в бесплатной версии api курса валют в качестве базовой валюты доступен только USD, другие валюты считаем через него
    $arFieldUSD['UF_MAIN_VALUE'] = round($decodedRates->RUB, 1);

    $arFieldCNY['UF_CUR_DATE'] = DateTime::createFromTimestamp(time())->toString();
    // т. к. в бесплатной версии api курса валют в качестве базовой валюты доступен только USD, другие валюты считаем через него 
    $arFieldCNY['UF_MAIN_VALUE'] = round($decodedRates->RUB / $decodedRates->CNY, 1);
    
    // обновляем данные в highload-блоке
    $curClass::update(1, $arFieldUSD);
    $curClass::update(2, $arFieldCNY);

    $_SESSION['usdRate'] = round($decodedRates->RUB, 1);
    $_SESSION['cnyRate'] = round($decodedRates->RUB / $decodedRates->CNY, 1);

    //  $APPLICATION->IncludeComponent("bitrix:system.auth.forgotpasswd", "", Array(
    //     "REGISTER_URL" => "/",
    //     "FORGOT_PASSWORD_URL" => "",
    //     "PROFILE_URL" => "/auth/personal.php",
    //     "SHOW_ERRORS" => "Y" 
    //     )
    // );
}


// $_SESSION['usdRate'] = 90.4;
// $_SESSION['cnyRate'] = 12.6;

// если страницу открыли с параметрами USER_LOGIN и USER_CHECKWORD - т. е. открыли ссылку с почты для восстановления пароля 
$isChangePasswordPage = !empty($_GET['USER_LOGIN']) && !empty($_GET['USER_CHECKWORD']);


?>

<!DOCTYPE html>
<html lang="ru_RU">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Краткое описание страницы"/>
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
                            <a href="#" class="me-3" target="_blank">
                                <svg width="26" height="26" viewBox="0 0 26 26" fill="none" xmlns="http://www.w3.org/2000/svg">                                
                                    <path d="M13 0C9.55297 0 6.24406 1.37048 3.80859 3.80758C1.37061 6.24564 0.000675329 9.55212 0 13C0 16.4464 1.37109 19.7553 3.80859 22.1924C6.24406 24.6295 9.55297 26 13 26C16.447 26 19.7559 24.6295 22.1914 22.1924C24.6289 19.7553 26 16.4464 26 13C26 9.55358 24.6289 6.24467 22.1914 3.80758C19.7559 1.37048 16.447 0 13 0Z" fill="white"/>
                                    <path d="M5.88454 12.8628C9.67485 11.2118 12.2017 10.1232 13.4652 9.59736C17.0767 8.09565 17.8263 7.83484 18.3158 7.826C18.4234 7.82428 18.6631 7.85089 18.8195 7.97733C18.9495 8.08397 18.9861 8.22819 19.0044 8.32945C19.0206 8.43061 19.043 8.66115 19.0247 8.84112C18.8297 10.8967 17.9827 15.8851 17.552 18.1875C17.3713 19.1617 17.0117 19.4883 16.6644 19.5202C15.9088 19.5897 15.3359 19.0213 14.6047 18.5422C13.4611 17.792 12.8152 17.3252 11.7041 16.5934C10.4203 15.7476 11.2531 15.2826 11.9844 14.5229C12.1753 14.3241 15.5025 11.2985 15.5655 11.0241C15.5736 10.9898 15.5817 10.8618 15.5045 10.7944C15.4294 10.7267 15.3177 10.7499 15.2364 10.7682C15.1206 10.7942 13.2945 12.0024 9.75204 14.3925C9.23407 14.7488 8.76485 14.9225 8.34235 14.9133C7.87923 14.9034 6.98548 14.6509 6.32126 14.4352C5.50876 14.1705 4.86079 14.0306 4.91766 13.581C4.9461 13.347 5.26907 13.1076 5.88454 12.8628Z" fill="#FF6948"/>
                                </svg>
                            </a>
                            <a href="https://vk.com/id812920522" target="_blank">
                                <svg width="26" height="26" viewBox="0 0 26 26" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <g clip-path="url(#clip0_210_52115)">
                                        <path d="M10.2798 0.00325L11.0695 0H14.9305L15.7213 0.00325L16.7115 0.0140833L17.1806 0.0216667L17.6334 0.0335833L18.07 0.04875L18.4903 0.0660833L18.8955 0.0888333L19.2855 0.115917L19.6593 0.148417L20.02 0.184167C21.905 0.3965 23.1974 0.8515 24.1724 1.8265C25.1474 2.8015 25.6024 4.09283 25.8148 5.97892L25.8516 6.33967L25.883 6.7145L25.9101 7.1045L25.9318 7.50858L25.9588 8.14558L25.9718 8.58975L25.9859 9.28742L25.9957 10.2787L26 11.3403L25.9989 14.9294L25.9957 15.7202L25.9848 16.7104L25.9773 17.1795L25.9653 17.6323L25.9502 18.0689L25.9328 18.4893L25.9101 18.8944L25.883 19.2844L25.8505 19.6582L25.8148 20.0189C25.6024 21.9039 25.1474 23.1963 24.1724 24.1713C23.1974 25.1463 21.9061 25.6013 20.02 25.8137L19.6593 25.8505L19.2844 25.8819L18.8944 25.909L18.4903 25.9307L17.8533 25.9577L17.4092 25.9707L16.7115 25.9848L15.7203 25.9946L14.6586 25.9989L11.0695 25.9978L10.2787 25.9946L9.2885 25.9837L8.81942 25.9762L8.36658 25.9642L7.93 25.9491L7.50967 25.9317L7.1045 25.909L6.7145 25.8819L6.34075 25.8494L5.98 25.8137C4.095 25.6013 2.80258 25.1463 1.82758 24.1713C0.852583 23.1963 0.397583 21.905 0.18525 20.0189L0.148417 19.6582L0.117 19.2833L0.0899167 18.8933L0.06825 18.4893L0.0411667 17.8522L0.0281667 17.4081L0.0140833 16.7104L0.00433333 15.7192L0 14.6575L0.00108333 11.0684L0.00433333 10.2776L0.0151667 9.28742L0.02275 8.81833L0.0346667 8.3655L0.0498333 7.92892L0.0671667 7.50858L0.0899167 7.10342L0.117 6.71342L0.1495 6.33967L0.18525 5.97892C0.397583 4.09392 0.852583 2.8015 1.82758 1.8265C2.80258 0.8515 4.09392 0.3965 5.98 0.184167L6.34075 0.147333L6.71558 0.115917L7.10558 0.0888333L7.50967 0.0671667L8.14667 0.0400833L8.59083 0.0270833L9.2885 0.013L10.2798 0.00325ZM7.35583 7.90725H4.3875C4.52833 14.6672 7.90833 18.7297 13.8342 18.7297H14.17V14.8622C16.3475 15.0789 17.9942 16.6714 18.655 18.7297H21.7317C20.8867 15.6531 18.6658 13.9522 17.2792 13.3022C18.6658 12.5006 20.6158 10.5506 21.0817 7.90725H18.2867C17.68 10.0522 15.8817 12.0022 14.17 12.1864V7.90725H11.375V15.4039C9.64167 14.9706 7.45333 12.8689 7.35583 7.90725Z" fill="white"/>
                                    </g>
                                    <defs>
                                        <clipPath id="clip0_210_52115">
                                            <rect width="26" height="26" rx="13" fill="white"/>
                                        </clipPath>
                                    </defs>
                                </svg>                                    
                            </a>
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
				<a href="#" class="px-6" target="_blank">
					<svg width="64" height="64" viewBox="0 0 64 64" fill="none" xmlns="http://www.w3.org/2000/svg">
						<g clip-path="url(#clip0_506_29843)">
							<path d="M32 0C23.515 0 15.37 3.3735 9.375 9.3725C3.37381 15.3739 0.00166235 23.5129 0 32C0 40.4835 3.375 48.6285 9.375 54.6275C15.37 60.6265 23.515 64 32 64C40.485 64 48.63 60.6265 54.625 54.6275C60.625 48.6285 64 40.4835 64 32C64 23.5165 60.625 15.3715 54.625 9.3725C48.63 3.3735 40.485 0 32 0Z" fill="white"/>
							<path d="M14.485 31.662C23.815 27.598 30.035 24.9185 33.145 23.624C42.035 19.9275 43.88 19.2855 45.085 19.2637C45.35 19.2595 45.94 19.325 46.325 19.6362C46.645 19.8987 46.735 20.2537 46.78 20.503C46.82 20.752 46.875 21.3195 46.83 21.7625C46.35 26.8225 44.265 39.1015 43.205 44.769C42.76 47.167 41.875 47.971 41.02 48.0495C39.16 48.2205 37.75 46.8215 35.95 45.642C33.135 43.7955 31.545 42.6465 28.81 40.845C25.65 38.763 27.7 37.6185 29.5 35.7485C29.97 35.259 38.16 27.8115 38.315 27.136C38.335 27.0515 38.355 26.7365 38.165 26.5705C37.98 26.404 37.705 26.461 37.505 26.506C37.22 26.57 32.725 29.544 24.005 35.4275C22.73 36.3045 21.575 36.732 20.535 36.7095C19.395 36.685 17.195 36.0635 15.56 35.5325C13.56 34.881 11.965 34.5365 12.105 33.43C12.175 32.854 12.97 32.2645 14.485 31.662Z" fill="#1A2030"/>
						</g>
						<defs>
							<clipPath id="clip0_506_29843">
								<rect width="64" height="64" fill="white"/>
							</clipPath>
						</defs>
					</svg>
						
				</a>
				<a href="#" class="px-6" target="_blank">
					<svg width="64" height="64" viewBox="0 0 64 64" fill="none" xmlns="http://www.w3.org/2000/svg">
						<g clip-path="url(#clip0_506_29846)">
							<path d="M25.304 0.008L27.248 0H36.752L38.6987 0.008L41.136 0.0346667L42.2907 0.0533333L43.4053 0.0826667L44.48 0.12L45.5147 0.162667L46.512 0.218667L47.472 0.285333L48.392 0.365333L49.28 0.453333C53.92 0.976 57.1013 2.096 59.5013 4.496C61.9013 6.896 63.0213 10.0747 63.544 14.7173L63.6347 15.6053L63.712 16.528L63.7787 17.488L63.832 18.4827L63.8987 20.0507L63.9307 21.144L63.9653 22.8613L63.9893 25.3013L64 27.9147L63.9973 36.7493L63.9893 38.696L63.9627 41.1333L63.944 42.288L63.9147 43.4027L63.8773 44.4773L63.8347 45.512L63.7787 46.5093L63.712 47.4693L63.632 48.3893L63.544 49.2773C63.0213 53.9173 61.9013 57.0987 59.5013 59.4987C57.1013 61.8987 53.9227 63.0187 49.28 63.5413L48.392 63.632L47.4693 63.7093L46.5093 63.776L45.5147 63.8293L43.9467 63.896L42.8533 63.928L41.136 63.9627L38.696 63.9867L36.0827 63.9973L27.248 63.9947L25.3013 63.9867L22.864 63.96L21.7093 63.9413L20.5947 63.912L19.52 63.8747L18.4853 63.832L17.488 63.776L16.528 63.7093L15.608 63.6293L14.72 63.5413C10.08 63.0187 6.89867 61.8987 4.49867 59.4987C2.09867 57.0987 0.978667 53.92 0.456 49.2773L0.365333 48.3893L0.288 47.4667L0.221333 46.5067L0.168 45.512L0.101333 43.944L0.0693333 42.8507L0.0346667 41.1333L0.0106667 38.6933L0 36.08L0.00266667 27.2453L0.0106667 25.2987L0.0373333 22.8613L0.056 21.7067L0.0853333 20.592L0.122667 19.5173L0.165333 18.4827L0.221333 17.4853L0.288 16.5253L0.368 15.6053L0.456 14.7173C0.978667 10.0773 2.09867 6.896 4.49867 4.496C6.89867 2.096 10.0773 0.976 14.72 0.453333L15.608 0.362667L16.5307 0.285333L17.4907 0.218667L18.4853 0.165333L20.0533 0.0986667L21.1467 0.0666667L22.864 0.032L25.304 0.008ZM18.1067 19.464H10.8C11.1467 36.104 19.4667 46.104 34.0533 46.104H34.88V36.584C40.24 37.1173 44.2933 41.0373 45.92 46.104H53.4933C51.4133 38.5307 45.9467 34.344 42.5333 32.744C45.9467 30.7707 50.7467 25.9707 51.8933 19.464H45.0133C43.52 24.744 39.0933 29.544 34.88 29.9973V19.464H28V37.9173C23.7333 36.8507 18.3467 31.6773 18.1067 19.464Z" fill="white"/>
						</g>
						<defs>
							<clipPath id="clip0_506_29846">
								<rect width="64" height="64" rx="32" fill="white"/>
							</clipPath>
						</defs>
					</svg>                        
				</a>
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
                <?$APPLICATION->IncludeComponent("bitrix:system.auth.form", "alitao_login_form", Array(
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

            <?
            // $APPLICATION->IncludeComponent("bitrix:system.auth.forgotpasswd", "", Array(
            //     "REGISTER_URL" => "/",
            //     "FORGOT_PASSWORD_URL" => "",
            //     "PROFILE_URL" => "/auth/personal.php",
            //     "SHOW_ERRORS" => "Y" 
            //     )
            // );
            ?>

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
    <!-- <div class="modal fade text-dark" id="resetPassword" aria-hidden="true" aria-labelledby="resetPasswordLabel" tabindex="-1"> -->
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
                                    </div>

                                    <div>
                                        <p class="mb-2"><b><?=Loc::getMessage('DELIVERY');?></b></p>
                                        <p class="text-secondary">¥ <span id="delivery-cost-calc" data-price-delivery="">0</span></p>
                                    </div>

                                    <div>
                                        <p class="mb-2"><b><?=Loc::getMessage('SERVICES');?></b></p>
                                        <p class="text-secondary">¥ <span id="services-cost-calc" data-price-delivery="3">5</span></p>
                                    </div>
                                    <div>
                                        <p class="mb-2"><b><?=Loc::getMessage('TOTAL');?></b></p>
                                        <p class="text-success">¥ <span id="total-cost-calc" data-summ="3">0</span></p>
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


                            <div class="products-photo-grid flex-grow-1">
                                <!-- <div class="products-photo-grid__item">
                                    <img src="<?//=SITE_TEMPLATE_PATH;?>/img/products/1.jpg" alt="">

                                    <div class="products-photo-grid__item-remove">
                                        <img src="<?//=SITE_TEMPLATE_PATH;?>/img/icons/remove-product.svg" alt="">
                                    </div>
                                </div> -->

                            
                            </div>
                                            
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
                        <p class="text-center text-gray"><?=Loc::getMessage('CHECK_PRICES');?> </p>
                    </form>
                </div>
                
            </div>
            </div>
        </div>
    <?php endif;?>

  
    