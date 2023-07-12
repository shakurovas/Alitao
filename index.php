<?
require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/header.php");
$APPLICATION->SetTitle("Alitao.shop");

use \Bitrix\Main\Localization\Loc;
Loc::loadMessages(__FILE__);
?>

    <main>
        <section class="hero py-md-0 py-10 mb-lg-8 mb-5">
            <img src="<?=SITE_TEMPLATE_PATH;?>/img/banner.png" alt="" class="hero__bg">
            <div class="hero__content container">

                <div class="hero__content__text-block">
                    <h1 class="h1 text-white mb-6">
                        <?$APPLICATION->IncludeComponent(
                            "bitrix:main.include", 
                            ".default", 
                            array(
                                "AREA_FILE_SHOW" => "file",
                                "AREA_FILE_SUFFIX" => "inc",
                                "AREA_FILE_RECURSIVE" => "Y",
                                "EDIT_TEMPLATE" => "",
                                "COMPONENT_TEMPLATE" => ".default",
                                "PATH" => "/include/motto.php"
                            ),
                            false
                        );?>
                    </h1>

                    <?$APPLICATION->IncludeComponent(
                        "bitrix:main.include", 
                        ".default", 
                        array(
                            "AREA_FILE_SHOW" => "file",
                            "AREA_FILE_SUFFIX" => "inc",
                            "AREA_FILE_RECURSIVE" => "Y",
                            "EDIT_TEMPLATE" => "",
                            "COMPONENT_TEMPLATE" => ".default",
                            "PATH" => "/include/site_description.php"
                        ),
                        false
                    );?>

                    <div class="hero__btn-wrap">
                        <a href="/make-order.html" class="btn btn-lg btn-primary w-100 w-sm-auto"><?=Loc::getMessage('MAKE_AN_ORDER');?></a>
                    </div>
                </div>
                
            </div>
        </section>

        <section class="py-lg-8 py-5 container">
            <h2 class="h1 mb-6 mb-lg-9"><?=Loc::getMessage('PURCHASE_OF_GOODS');?></h2>
            <h3 class="h2 text-secondary mb-4 mb-lg-6"><?=Loc::getMessage('SEARCH_AND_DELIVERY_OF_GOODS');?> </h3>

            <?$APPLICATION->IncludeComponent(
	"bitrix:news.list", 
	"sites_order_main", 
	array(
		"DISPLAY_DATE" => "Y",
		"DISPLAY_NAME" => "Y",
		"DISPLAY_PICTURE" => "Y",
		"DISPLAY_PREVIEW_TEXT" => "Y",
		"AJAX_MODE" => "Y",
		"IBLOCK_TYPE" => "products",
		"IBLOCK_ID" => "6",
		"NEWS_COUNT" => "6",
		"SORT_BY1" => "SORT",
		"SORT_ORDER1" => "DESC",
		"SORT_BY2" => "SORT",
		"SORT_ORDER2" => "ASC",
		"FILTER_NAME" => "",
		"FIELD_CODE" => array(
			0 => "NAME",
			1 => "PREVIEW_TEXT",
			2 => "",
		),
		"PROPERTY_CODE" => array(
			0 => "SVG_IMAGE_CODE",
			1 => "LINK",
			2 => "DESCRIPTION",
			3 => "",
		),
		"CHECK_DATES" => "Y",
		"DETAIL_URL" => "",
		"PREVIEW_TRUNCATE_LEN" => "",
		"ACTIVE_DATE_FORMAT" => "d.m.Y",
		"SET_TITLE" => "N",
		"SET_BROWSER_TITLE" => "N",
		"SET_META_KEYWORDS" => "Y",
		"SET_META_DESCRIPTION" => "Y",
		"SET_LAST_MODIFIED" => "Y",
		"INCLUDE_IBLOCK_INTO_CHAIN" => "Y",
		"ADD_SECTIONS_CHAIN" => "Y",
		"HIDE_LINK_WHEN_NO_DETAIL" => "Y",
		"PARENT_SECTION" => "",
		"PARENT_SECTION_CODE" => "",
		"INCLUDE_SUBSECTIONS" => "Y",
		"CACHE_TYPE" => "A",
		"CACHE_TIME" => "3600",
		"CACHE_FILTER" => "Y",
		"CACHE_GROUPS" => "Y",
		"DISPLAY_TOP_PAGER" => "Y",
		"DISPLAY_BOTTOM_PAGER" => "Y",
		"PAGER_TITLE" => "Новости",
		"PAGER_SHOW_ALWAYS" => "Y",
		"PAGER_TEMPLATE" => "",
		"PAGER_DESC_NUMBERING" => "Y",
		"PAGER_DESC_NUMBERING_CACHE_TIME" => "36000",
		"PAGER_SHOW_ALL" => "Y",
		"PAGER_BASE_LINK_ENABLE" => "Y",
		"SET_STATUS_404" => "Y",
		"SHOW_404" => "Y",
		"MESSAGE_404" => "",
		"PAGER_BASE_LINK" => "",
		"PAGER_PARAMS_NAME" => "arrPager",
		"AJAX_OPTION_JUMP" => "N",
		"AJAX_OPTION_STYLE" => "Y",
		"AJAX_OPTION_HISTORY" => "N",
		"AJAX_OPTION_ADDITIONAL" => "",
		"COMPONENT_TEMPLATE" => "sites_order_main",
		"STRICT_SECTION_CHECK" => "N",
		"FILE_404" => ""
	),
	false
);?>

        </section>

        <section class="py-lg-8 py-5 container">
            <h2 class="h1 mb-6"><?=Loc::getMessage('OUR_SERVICES');?></h2>

            <?$APPLICATION->IncludeComponent(
	"bitrix:news.list", 
	"services_list_main", 
	array(
		"DISPLAY_DATE" => "Y",
		"DISPLAY_NAME" => "Y",
		"DISPLAY_PICTURE" => "Y",
		"DISPLAY_PREVIEW_TEXT" => "Y",
		"AJAX_MODE" => "Y",
		"IBLOCK_TYPE" => "products",
		"IBLOCK_ID" => "3",
		"NEWS_COUNT" => "3",
		"SORT_BY1" => "SORT",
		"SORT_ORDER1" => "DESC",
		"SORT_BY2" => "SORT",
		"SORT_ORDER2" => "ASC",
		"FILTER_NAME" => "",
		"FIELD_CODE" => array(
			0 => "NAME",
			1 => "PREVIEW_PICTURE",
			2 => "",
		),
		"PROPERTY_CODE" => array(
			0 => "",
			1 => "DESCRIPTION",
			2 => "",
		),
		"CHECK_DATES" => "Y",
		"DETAIL_URL" => "",
		"PREVIEW_TRUNCATE_LEN" => "",
		"ACTIVE_DATE_FORMAT" => "d.m.Y",
		"SET_TITLE" => "N",
		"SET_BROWSER_TITLE" => "N",
		"SET_META_KEYWORDS" => "Y",
		"SET_META_DESCRIPTION" => "Y",
		"SET_LAST_MODIFIED" => "Y",
		"INCLUDE_IBLOCK_INTO_CHAIN" => "Y",
		"ADD_SECTIONS_CHAIN" => "Y",
		"HIDE_LINK_WHEN_NO_DETAIL" => "Y",
		"PARENT_SECTION" => "",
		"PARENT_SECTION_CODE" => "",
		"INCLUDE_SUBSECTIONS" => "Y",
		"CACHE_TYPE" => "A",
		"CACHE_TIME" => "3600",
		"CACHE_FILTER" => "Y",
		"CACHE_GROUPS" => "Y",
		"DISPLAY_TOP_PAGER" => "Y",
		"DISPLAY_BOTTOM_PAGER" => "Y",
		"PAGER_TITLE" => "Новости",
		"PAGER_SHOW_ALWAYS" => "Y",
		"PAGER_TEMPLATE" => "",
		"PAGER_DESC_NUMBERING" => "Y",
		"PAGER_DESC_NUMBERING_CACHE_TIME" => "36000",
		"PAGER_SHOW_ALL" => "Y",
		"PAGER_BASE_LINK_ENABLE" => "Y",
		"SET_STATUS_404" => "Y",
		"SHOW_404" => "Y",
		"MESSAGE_404" => "",
		"PAGER_BASE_LINK" => "",
		"PAGER_PARAMS_NAME" => "arrPager",
		"AJAX_OPTION_JUMP" => "N",
		"AJAX_OPTION_STYLE" => "Y",
		"AJAX_OPTION_HISTORY" => "N",
		"AJAX_OPTION_ADDITIONAL" => "",
		"COMPONENT_TEMPLATE" => "services_list_main",
		"STRICT_SECTION_CHECK" => "N",
		"FILE_404" => ""
	),
	false
);?>

        </section>

        <section class="py-lg-8 py-5 container" id="help">
            <h2 class="h1 mb-6"><?=Loc::getMessage('HELP');?></h2>
            <div class="swiper help-slider">
                <div class="help-swiper-wrapper">

                    <div class="swiper-slide">
                        <a href="/helpful_info/how_to_place_order.php" class="help-link">
                            <div class="help-link__inner">
                                <img src="<?=SITE_TEMPLATE_PATH;?>/img/help/1.jpg" alt="" class="help-link__img">
                                <div class="help-link__text-block">
                                    <p class="text-white fs-3"><?=Loc::getMessage('HOW_TO_MAKE_AN_ORDER');?></p>
                                </div>
                            </div>
                        </a>
                    </div>

                    <div class="swiper-slide">
                        <a href="/helpful_info/payment.php" class="help-link">
                            <div class="help-link__inner">
                                <img src="<?=SITE_TEMPLATE_PATH;?>/img/help/2.jpg" alt="" class="help-link__img">
                                <div class="help-link__text-block">
                                    <p class="text-white fs-3"><?=Loc::getMessage('HOW_TO_PAY_FOR_ORDER');?></p>
                                </div>
                            </div>
                        </a>
                    </div>

                    <div class="swiper-slide">
                        <a href="/helpful_info/select_size.php" class="help-link">
                            <div class="help-link__inner">
                                <img src="<?=SITE_TEMPLATE_PATH;?>/img/help/3.jpg" alt="" class="help-link__img">
                                <div class="help-link__text-block">
                                    <p class="text-white fs-3"><?=Loc::getMessage('CHOOSING_SIZE');?></p>
                                </div>
                            </div>
                        </a>
                    </div>

                    <div class="swiper-slide">
                        <a href="/helpful_info/search_on_taobao.php" class="help-link">
                            <div class="help-link__inner">
                                <img src="<?=SITE_TEMPLATE_PATH;?>/img/help/4.jpg" alt="" class="help-link__img">
                                <div class="help-link__text-block">
                                    <p class="text-white fs-3"><?=Loc::getMessage('GOODS_SEARCH_AT_TAOBAO');?></p>
                                </div>
                            </div>
                        </a>
                    </div>

                    <div class="swiper-slide">
                        <a href="/helpful_info/select_colour.php" class="help-link">
                            <div class="help-link__inner">
                                <img src="<?=SITE_TEMPLATE_PATH;?>/img/help/5.jpg" alt="" class="help-link__img">
                                <div class="help-link__text-block">
                                    <p class="text-white fs-3"><?=Loc::getMessage('HOW_TO_CHOOSE_COLOUR');?> </p>
                                </div>
                            </div>
                        </a>
                    </div>

                    <div class="swiper-slide">
                        <a href="/helpful_info/delivery.php" class="help-link">
                            <div class="help-link__inner">
                                <img src="<?=SITE_TEMPLATE_PATH;?>/img/help/6.jpg" alt="" class="help-link__img">
                                <div class="help-link__text-block">
                                    <p class="text-white fs-3"><?=Loc::getMessage('HOW_MUCH_DELIVERY_COSTS');?></p>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>
                <div class="swiper-pagination pagination"></div>
            </div>
        </section>

        <section class="py-lg-8 py-5 stages">

            <div class="container">

                <h2 class="h1 mb-lg-4 mb-2"><?=Loc::getMessage('STAGES_OF_WORK');?></h2>
                <p class="text text-dark mb-6 mb-lg-9"><?=Loc::getMessage('STAGES_OF_WORK_DESCRIPTION');?> </p>

                <div class="stages-grid">
                    <div class="stages-grid__item">
                        <div class="stages-grid__num-wrap">
                            <p class="big-num text-secondary">01</p>

                            <div class="stages-grid__arrow">                            
                                <img src="<?=SITE_TEMPLATE_PATH;?>/img/icons/orange-arrow.svg" alt="">
                            </div>
                        </div>                       
                        <p class="fs-3 text-secondary fw-bold ps-6 ps-xl-10"><?=Loc::getMessage('STAGE_1');?></p>
                    </div>
                    <div class="stages-grid__item">
                        <div class="stages-grid__num-wrap">
                        <p class="big-num text-secondary">02</p>

                        <div class="stages-grid__arrow">                            
                            <img src="<?=SITE_TEMPLATE_PATH;?>/img/icons/orange-arrow.svg" alt="">
                        </div>
                        </div>                       
                    <p class="fs-3 text-secondary fw-bold ps-6 ps-xl-10"><?=Loc::getMessage('STAGE_2');?></p>
                </div>
                    <div class="stages-grid__item">
                        <div class="stages-grid__num-wrap">
                            <p class="big-num text-secondary">03</p>

                            <div class="stages-grid__arrow long-to-right">                            
                                
                            </div>
                        </div>                       
                        <p class="fs-3 text-secondary fw-bold ps-6 ps-xl-10"><?=Loc::getMessage('STAGE_3');?></p>
                    </div>

                    <div class="stages-grid__item">
                        <div class="stages-grid__num-wrap">
                        <p class="big-num text-secondary">04</p>

                        <div class="stages-grid__arrow long-from-left">                            
                            <img src="<?=SITE_TEMPLATE_PATH;?>/img/icons/orange-arrow.svg" alt="">
                        </div>

                        <div class="stages-grid__arrow">                            
                            <img src="<?=SITE_TEMPLATE_PATH;?>/img/icons/orange-arrow.svg" alt="">
                        </div>
                        </div>                       
                    <p class="fs-3 text-secondary fw-bold ps-6 ps-xl-10"><?=Loc::getMessage('STAGE_4');?></p>
                </div>

                <div class="stages-grid__item">
                        <div class="stages-grid__num-wrap">
                            <p class="big-num text-secondary">05</p>

                            <div class="stages-grid__arrow">                            
                                <img src="<?=SITE_TEMPLATE_PATH;?>/img/icons/orange-arrow.svg" alt="">
                            </div>
                        </div>                       
                        <p class="fs-3 text-secondary fw-bold ps-6 ps-xl-10"><?=Loc::getMessage('STAGE_5');?></p>
                    </div>
                    <div class="stages-grid__item">
                        <div class="stages-grid__num-wrap">
                        <p class="big-num text-secondary">06</p>

                        
                        </div>                       
                    <p class="fs-3 text-secondary fw-bold ps-6 ps-xl-10"><?=Loc::getMessage('STAGE_6');?></p>
                </div>
                </div>
                <div class="mt-lg-10 mt-6">
                    <a href="/make-order.html" class="btn btn-lg btn-primary w-100 w-sm-auto"><?=Loc::getMessage('MAKE_AN_ORDER');?></a>
                </div>
            </div>


            
        </section>

        <section class="py-lg-8 py-5 container mb-8" id="faq">
            <h2 class="h1 mb-lg-9 mb-6"><?=Loc::getMessage('Q&A');?></h2>
            <?$APPLICATION->IncludeComponent(
	"bitrix:news.list", 
	"questions_and_answers_main", 
	array(
		"DISPLAY_DATE" => "Y",
		"DISPLAY_NAME" => "Y",
		"DISPLAY_PICTURE" => "Y",
		"DISPLAY_PREVIEW_TEXT" => "Y",
		"AJAX_MODE" => "Y",
		"IBLOCK_TYPE" => "news",
		"IBLOCK_ID" => "5",
		"NEWS_COUNT" => "5",
		"SORT_BY1" => "SORT",
		"SORT_ORDER1" => "DESC",
		"SORT_BY2" => "SORT",
		"SORT_ORDER2" => "ASC",
		"FILTER_NAME" => "",
		"FIELD_CODE" => array(
			0 => "NAME",
			1 => "DETAIL_TEXT",
			2 => "",
		),
		"PROPERTY_CODE" => array(
			0 => "",
			1 => "DESCRIPTION",
			2 => "",
		),
		"CHECK_DATES" => "Y",
		"DETAIL_URL" => "",
		"PREVIEW_TRUNCATE_LEN" => "",
		"ACTIVE_DATE_FORMAT" => "d.m.Y",
		"SET_TITLE" => "N",
		"SET_BROWSER_TITLE" => "N",
		"SET_META_KEYWORDS" => "Y",
		"SET_META_DESCRIPTION" => "Y",
		"SET_LAST_MODIFIED" => "Y",
		"INCLUDE_IBLOCK_INTO_CHAIN" => "Y",
		"ADD_SECTIONS_CHAIN" => "Y",
		"HIDE_LINK_WHEN_NO_DETAIL" => "Y",
		"PARENT_SECTION" => "",
		"PARENT_SECTION_CODE" => "",
		"INCLUDE_SUBSECTIONS" => "Y",
		"CACHE_TYPE" => "A",
		"CACHE_TIME" => "3600",
		"CACHE_FILTER" => "Y",
		"CACHE_GROUPS" => "Y",
		"DISPLAY_TOP_PAGER" => "Y",
		"DISPLAY_BOTTOM_PAGER" => "Y",
		"PAGER_TITLE" => "Новости",
		"PAGER_SHOW_ALWAYS" => "Y",
		"PAGER_TEMPLATE" => "",
		"PAGER_DESC_NUMBERING" => "Y",
		"PAGER_DESC_NUMBERING_CACHE_TIME" => "36000",
		"PAGER_SHOW_ALL" => "Y",
		"PAGER_BASE_LINK_ENABLE" => "Y",
		"SET_STATUS_404" => "Y",
		"SHOW_404" => "Y",
		"MESSAGE_404" => "",
		"PAGER_BASE_LINK" => "",
		"PAGER_PARAMS_NAME" => "arrPager",
		"AJAX_OPTION_JUMP" => "N",
		"AJAX_OPTION_STYLE" => "Y",
		"AJAX_OPTION_HISTORY" => "N",
		"AJAX_OPTION_ADDITIONAL" => "",
		"COMPONENT_TEMPLATE" => "questions_and_answers_main",
		"STRICT_SECTION_CHECK" => "N",
		"FILE_404" => ""
	),
	false
);?>

            <div class="mt-9">

                <h3 class="h2 mb-4"><?=Loc::getMessage('MORE_QUESTIONS?');?></h3>
                <p class="text text-dark mb-6"><?=Loc::getMessage('ASK_MORE_QUESTIONS');?></p>

                <button  class="btn btn-lg btn-primary w-100 w-sm-auto d-none d-lg-inline-block" data-bs-toggle="modal" href="#sendQuestion" role="button"><?=Loc::getMessage('ASK_A_QUESTION');?></button>
                <a  class="btn btn-lg btn-primary w-100 w-sm-auto d-lg-none"  href="/mobile-send-question.html"><?=Loc::getMessage('ASK_A_QUESTION');?></a>
            </div>
        </section>
    </main>

<?require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/footer.php");?>