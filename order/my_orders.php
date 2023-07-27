<?php
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");

$APPLICATION->SetTitle("Мои заказы");

use \Bitrix\Main\Localization\Loc;
Loc::loadMessages(__FILE__);

// echo '<pre>';
// print_r($_SESSION);
// echo '</pre>';
$arSort = array('SORT' => 'ASC', 'ID' => 'DESC');
$arFilter = array('ACTIVE' => 'Y', 'IBLOCK_CODE' => 'orders');
$arSelect = array('ID');

$count = 0;
$res = CIBlockElement::getList($arSort, $arFilter, false, false, $arSelect);
while ($row = $res->fetch()) {
   $count += 1;
}
?>

<main>
    <?php if ($USER->isAuthorized()):?>
        <section class="container pt-7 mt-1 pb-10 mb-4  text">
            <div class="cabinet">
                <nav class="cabinet__nav  fw-bold text-center text-md-start">
                    <ul>
                        <li>
                            <a href="/auth/personal.php" class="cabinet__nav-link  link-dark"><?=Loc::getMessage('MY_PROFILE');?></a>
                        </li>                
                        <li>
                            <a href="/order/my_orders.php" class="cabinet__nav-link active link-dark"><?=Loc::getMessage('MY_ORDERS');?></a>                
                        </li>
                        <li>
                            <a href="/order/history.php" class="cabinet__nav-link link-dark"><?=Loc::getMessage('HISTORY');?></a>                
                        </li>
                        <li>
                            <a href="/?logout=yes&<?=bitrix_sessid_get();?>" class="cabinet__nav-link link-dark"><?=Loc::getMessage('LOG_OUT');?></a>                
                        </li>
                    </ul>
                    
                    
                </nav>

                <section class="cabinet__content">
                    <div class="orders">
						<?php if ($count):?>
							<div class="orders__filters-block mb-7 mb-lg-4">
								<div class="dropdown dropdown_orders me-md-7 mb-3 mb-md-0">
									<button class="btn btn-outline-secondary dropdown-toggle" type="button" id="orders-state" data-bs-toggle="dropdown" aria-expanded="false">
										
										<svg width="15" height="8" viewBox="0 0 15 8" fill="none" xmlns="http://www.w3.org/2000/svg">
											<path fill-rule="evenodd" clip-rule="evenodd" d="M8.03033 7.53033C7.73744 7.82322 7.26256 7.82322 6.96967 7.53033L0.96967 1.53033C0.676777 1.23744 0.676777 0.762563 0.96967 0.46967C1.26256 0.176777 1.73744 0.176777 2.03033 0.46967L7.5 5.93934L12.9697 0.46967C13.2626 0.176777 13.7374 0.176777 14.0303 0.46967C14.3232 0.762563 14.3232 1.23744 14.0303 1.53033L8.03033 7.53033Z" fill="#FF431A"/>
										</svg>
										<span class="value ms-2"><?=Loc::getMessage('ANY_STATUS');?></span>    
									</button>
									<ul class="dropdown-menu" aria-labelledby="orders-state">
										<li class="dropdown-item custom" ><?=Loc::getMessage('ANY_STATUS');?></li>
										<li class="dropdown-item custom"><?=Loc::getMessage('NOT_PAID');?></li>                          
										<li class="dropdown-item custom"><?=Loc::getMessage('COMPLETED');?></li>
									</ul>
								</div>

								<div class="dropdown dropdown_orders ">
									<button class="btn btn-outline-secondary dropdown-toggle" type="button" id="orders-place" data-bs-toggle="dropdown" aria-expanded="false">
										
										<svg width="15" height="8" viewBox="0 0 15 8" fill="none" xmlns="http://www.w3.org/2000/svg">
											<path fill-rule="evenodd" clip-rule="evenodd" d="M8.03033 7.53033C7.73744 7.82322 7.26256 7.82322 6.96967 7.53033L0.96967 1.53033C0.676777 1.23744 0.676777 0.762563 0.96967 0.46967C1.26256 0.176777 1.73744 0.176777 2.03033 0.46967L7.5 5.93934L12.9697 0.46967C13.2626 0.176777 13.7374 0.176777 14.0303 0.46967C14.3232 0.762563 14.3232 1.23744 14.0303 1.53033L8.03033 7.53033Z" fill="#FF431A"/>
										</svg>
										<span class="value ms-2"><?=Loc::getMessage('ALL_FOLDERS');?></span>    
									</button>
									<ul class="dropdown-menu" aria-labelledby="orders-place">
										<li class="dropdown-item custom" ><?=Loc::getMessage('ALL_FOLDERS');?></li>
										<li class="dropdown-item custom">Папка 1</li>
										<li class="dropdown-item custom"><?=Loc::getMessage('CREATE_NEW_FOLDER');?></li>                          
										<li class="dropdown-item custom"><?=Loc::getMessage('EDIT_FOLDERS');?></li>
									</ul>
								</div>
							</div>
						<?php endif;?>
                        <div class="orders__list fs-5 text-dark">
                        <?$APPLICATION->IncludeComponent(
	"bitrix:news.list", 
	"orders_list", 
	array(
		"DISPLAY_DATE" => "Y",
		"DISPLAY_NAME" => "Y",
		"DISPLAY_PICTURE" => "Y",
		"DISPLAY_PREVIEW_TEXT" => "Y",
		"AJAX_MODE" => "Y",
		"IBLOCK_TYPE" => "products",
		"IBLOCK_ID" => "8",
		"NEWS_COUNT" => "",
		"SORT_BY1" => "SORT",
		"SORT_ORDER1" => "DESC",
		"SORT_BY2" => "SORT",
		"SORT_ORDER2" => "ASC",
		"FILTER_NAME" => "",
		"FIELD_CODE" => array(
			0 => "ID",
			1 => "NAME",
			2 => "PREVIEW_TEXT",
			3 => "PREVIEW_PICTURE",
			4 => "DATE_CREATE",
			5 => "",
		),
		"PROPERTY_CODE" => array(
			0 => "EMAIL",
			1 => "ADDRESS",
			2 => "CUSTOMER",
			3 => "IS_INSURED",
			4 => "NOTES",
			5 => "MESSAGES",
			6 => "ORDER_CONTENT",
			7 => "DELIVERY_METHOD",
			8 => "STATUS",
			9 => "PHONE",
			10 => "SVG_IMAGE_CODE",
			11 => "LINK",
			12 => "DESCRIPTION",
			13 => "",
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
		"COMPONENT_TEMPLATE" => "orders_list",
		"STRICT_SECTION_CHECK" => "N",
		"FILE_404" => ""
	),
	false
);?>
</div>

                        <div class="pt-7 pb-5">
                            <a href="<?php echo $isMobile ? '/order/mobile_add_edit_order.php' : '/order/make_order_step_1.php';?>" class="btn btn-primary w-100 w-lg-auto px-10"><?=Loc::getMessage('NEW_ORDER');?></a>
                        </div>
						<?php if ($count):?>
							<div class="form-check d-flex align-items-center text-dark">
								<input class="form-check-input me-2" type="checkbox" value="archive-orders" id="archive-orders" >
								<label class="form-check-label fs-5" for="archive-orders">
									<?=Loc::getMessage('SHOW_ORDERS_FROM_ARCHIVE');?>
								</label>
							</div>
                        <?php endif;?>
                    </div>
                </section>
            </div>
        </section>
    <?php else:?>
        <section class="container pt-7 mt-1 pb-10 mb-4  text">
            <div class="cabinet"><?=Loc::getMessage('NEED_TO_BE_AUTHORIZED');?></div>
        </section>
    <?php endif;?>
</main>


<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>