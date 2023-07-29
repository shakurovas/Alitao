<?
require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/header.php");
$APPLICATION->SetTitle("История заказов");

use \Bitrix\Main\Localization\Loc;
Loc::loadMessages(__FILE__);
?>

<main>        
        <section class="container pt-7 mt-1 pb-10 mb-4  text">
            <div class="cabinet">
                <nav class="cabinet__nav  fw-bold text-center text-md-start">
                    <ul>
                        <li>
                            <a href="/auth/personal.php" class="cabinet__nav-link  link-dark"><?=Loc::getMessage('PROFILE');?></a>
                        </li>                
                        <li>
                            <a href="/order/my_orders.php" class="cabinet__nav-link  link-dark"><?=Loc::getMessage('MY_ORDERS');?></a>                
                        </li>
                        <li>
                            <a href="/order/history.php" class="cabinet__nav-link active link-dark"><?=Loc::getMessage('HISTORY');?></a>                
                        </li>
                        <li>
                            <a href="/?logout=yes&<?=bitrix_sessid_get();?>" class="cabinet__nav-link link-dark"><?=Loc::getMessage('LOG_OUT');?></a>                
                        </li>
                    </ul>
                    
                    
                </nav>

                <section class="cabinet__content">
                    <h1 class="fs-3 mb-4 d-none d-md-block"><?=Loc::getMessage('HISTORY');?></h1>
					<?$APPLICATION->IncludeComponent(
						"bitrix:news.list", 
						"history_orders", 
						array(
							"DISPLAY_DATE" => "Y",
							"DISPLAY_NAME" => "Y",
							"DISPLAY_PICTURE" => "Y",
							"DISPLAY_PREVIEW_TEXT" => "Y",
							"AJAX_MODE" => "Y",
							"IBLOCK_TYPE" => "products",
							"IBLOCK_ID" => "8",
							"NEWS_COUNT" => "",
							"SORT_BY1" => "ACTIVE_FROM",
							"SORT_ORDER1" => "DESC",
							"SORT_BY2" => "SORT",
							"SORT_ORDER2" => "ASC",
							"FILTER_NAME" => "",
							"FIELD_CODE" => array(
								0 => "ID",
								1 => "NAME",
								2 => "DATE_ACTIVE_FROM",
								3 => "ACTIVE_FROM",
								4 => "TIMESTAMP_X",
								5 => "",
							),
							"PROPERTY_CODE" => array(
								0 => "CUSTOMER",
								1 => "IS_INSURED",
								2 => "MESSAGES",
								3 => "ORDER_CONTENT",
								4 => "DELIVERY_METHOD",
								5 => "STATUS",
								6 => "DESCRIPTION",
								7 => "",
							),
							"CHECK_DATES" => "Y",
							"DETAIL_URL" => "",
							"PREVIEW_TRUNCATE_LEN" => "",
							"ACTIVE_DATE_FORMAT" => "d-m-Y",
							"SET_TITLE" => "N",
							"SET_BROWSER_TITLE" => "N",
							"SET_META_KEYWORDS" => "N",
							"SET_META_DESCRIPTION" => "N",
							"SET_LAST_MODIFIED" => "N",
							"INCLUDE_IBLOCK_INTO_CHAIN" => "N",
							"ADD_SECTIONS_CHAIN" => "N",
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
							"COMPONENT_TEMPLATE" => "history_orders",
							"STRICT_SECTION_CHECK" => "N",
							"FILE_404" => ""
						),
						false
					);?>

                </section>
            </div>
        </section>
    </main>

<?require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/footer.php");?>