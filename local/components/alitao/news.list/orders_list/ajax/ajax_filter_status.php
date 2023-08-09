<?php
define('STOP_STATISTICS', true);
require_once($_SERVER['DOCUMENT_ROOT'].'/bitrix/modules/main/include/prolog_before.php');
use \Bitrix\Main\Localization\Loc;

Loc::loadMessages(__FILE__);

$APPLICATION->RestartBuffer();

session_start();

// echo json_encode($_POST);

if (CModule::IncludeModule("iblock")) {
    // ищем id инфоблока с заказами
    $arrFilter = array(
        'ACTIVE' => 'Y',
        'CODE' => 'orders',
        'SITE_ID' => "s1",
    );

    $res = CIBlock::GetList(Array("SORT" => "ASC"), $arrFilter, false);

    if ($arRes = $res->Fetch()) {
        $ordersIblockId = $arRes["ID"];
    }


    if ($_POST['status'] == Loc::getMessage('ANY_STATUS')) {
        $statusText = '';
    } else {
        $statusText = mb_strtolower($_POST['status']);
    }

    // отбираем заказы, удовлетворяющие условию
    $arFilter = Array(
        "IBLOCK_ID" => $ordersIblockId, 
        "PROPERTY_STATUS_VALUE" => $statusText, 
        "ACTIVE" => "Y",
		"PROPERTY_CUSTOMER" => $USER->GetID()
    );
    $arSelect = Array(
        'ID', 'IBLOCK_ID', 'PROPERTY_STATUS', 'NAME', 'DATE_CREATE', 'PROPERTY_PICTURES', 'PROPERTY_ORDER_CONTENT',
		'PROPERTY_GOODS_QUANTITY', 'PROPERTY_POSITIONS_QUANTITY', 'PROPERTY_GOODS_AND_DELIVERY_THROUGH_CHINA_COST_YUAN',
		'PROPERTY_GOODS_AND_DELIVERY_THROUGH_CHINA_COST_RUB', 'DETAIL_PAGE_URL'
	);
    // строка, в которую будем записывать заказы, подходящие по условию
    $ordersString = '';

	// массив с отфильтрованными заказами
	$filteredOrders = [];
	
    $res = CIBlockElement::GetList(Array("ID" => "DESC"), $arFilter, $arSelect);
    while($arFields = $res->GetNext())
    {
		if (!array_key_exists($arFields['ID'], $filteredOrders)) 
			$filteredOrders[$arFields['ID']] = $arFields;
		else {
			if (!is_array($filteredOrders[$arFields['ID']]['PROPERTY_PICTURES_VALUE'])) {
				$filteredOrders[$arFields['ID']]['PROPERTY_PICTURES_VALUE'] = [$filteredOrders[$arFields['ID']]['PROPERTY_PICTURES_VALUE']];
				$filteredOrders[$arFields['ID']]['PROPERTY_PICTURES_VALUE'][] = $arFields['PROPERTY_PICTURES_VALUE'];
			} else {
				$filteredOrders[$arFields['ID']]['PROPERTY_PICTURES_VALUE'][] = $arFields['PROPERTY_PICTURES_VALUE'];
			}
		}
	}

	
	foreach ($filteredOrders as $order) {

		$orderContent = unserialize(base64_decode($order['PROPERTY_ORDER_CONTENT_VALUE']['TEXT']));

		$countGoods = 0;
		$countPositions = 0;

		foreach ($orderContent as $link => $props) {
			$countPositions += 1;
			$countGoods += $props['quantity'];
		}

		$ordersString .= '<style>@media (min-width: 1200px) {
			.orders__list {
			  grid-gap: 10px !important;
			}
		  }</style>
		  <p class="news-item">
			<div class="order-item">';
				if (mb_strtolower($order['PROPERTY_STATUS_VALUE']) == mb_strtolower(GetMessage('NOT_PAID'))) {
					$ordersString .= '<div class="order-item__controls">
						<button class="order-item__edit-btn order-edit-btn" data-id="' . $order['ID'] . '">
							<img src="' . SITE_TEMPLATE_PATH . '/img/icons/edit.svg" alt="">
						</button>
						<button class="order-item__edit-btn order-hide-btn" data-id="' . $order['ID'] . '" onclick="
							$.ajax( {
								url: \'/local/templates/alitao/components/bitrix/news/my_orders/bitrix/news.list/orders_list/ajax/ajax_hide_order.php\',
								method: \'POST\',
								dataType: \'html\',
								data: {\'id\': this.dataset.id},
								success: function(data) {
									console.log(data);
									location.reload();
								}
							});
						">
							<img src="' . SITE_TEMPLATE_PATH . '/img/icons/remove.svg" alt="">
						</button>
					</div>';
                }


				$ordersString .= '<div class="order-item__col-title fw-bold fs-5 text-dark col-title-1">
					№ ' . GetMessage('OF_ORDER') . '
				</div>
				<div class="order-item__col-title fw-bold fs-5 text-dark col-title-2">
					<a href="' . $order['DETAIL_PAGE_URL'] . '">';
					if (is_array($orderContent) && count($orderContent) == 1) $orderName = $orderContent[array_keys($orderContent)[0]]['name'];
					else if (is_array($orderContent) && count($orderContent) > 1) $orderName = $orderContent[array_keys($orderContent)[0]]['name'] . ' ' . GetMessage('AND_OTHERS');
					else $orderName = GetMessage('WITHOUT_NAME');
					
					$ordersString .= $orderName . '</a>
				</div>
				<div class="order-item__col-title fw-bold fs-5 text-dark col-title-3">
					' . GetMessage('INFO') . '
				</div>
			
				<div class="order-item__num-order">
					№ ' . $order['ID'] . '
				</div>
				<div class="order-item__date-order">
					' . substr($order['DATE_CREATE'], 0, -3) . '
				</div>

				<div class="order-item__products">';
				
					if (!empty($order['PROPERTY_PICTURES_VALUE'])) {
						if (!is_array($order['PROPERTY_PICTURES_VALUE'])) {
							$ordersString .= '<div class="mo-order__description">
								<div class="mo-order__img-block me-2 flex-shrink-0">
									<img src="' . CFile::GetPath($order['PROPERTY_PICTURES_VALUE']) . '" alt="" class="mo-order__img" width="100" height="100">
								</div>
							</div>';
						} else {
							$counter = 0;
							foreach ($order['PROPERTY_PICTURES_VALUE'] as $photoId){
								$counter += 1;
								if ($counter == 4) {
									break;
								}
								$ordersString .= '<div class="order-item__product-img-wrap">
									<div class="order-item__product-img-inner-wrap ">
										<img class="order-item__product-img" src="' . CFile::GetPath($photoId) . '">
									</div>                                    
								</div>';
							}
						}
						
					} else {
						$ordersString .= '<div class="mo-order__description">
							<div class="mo-order__img-block me-2 flex-shrink-0">
								<img src="/local/templates/alitao/img/no-photo.jpg" alt="" class="mo-order__img" width="100" height="100">
							</div>
						</div>';
					}

					if (is_array($order['PROPERTY_PICTURES_VALUE']) && !empty($order['PROPERTY_PICTURES_VALUE']) && count($order['PROPERTY_PICTURES_VALUE']) > 4) {
						$ordersString .= '<div class="order-item__product-count-wrap">
							<div class="order-item__product-count-inner-wrap ">
								<div class="order-item__product-count">
									' . GetMessage('MORE') . ' <br />' . count($order['PROPERTY_PICTURES_VALUE']) - 4 . ' ' . GetMessage('OF_PHOTOS') .
								'</div>
							</div>
						</div>';
                    }
                $ordersString .= '</div>

				<div class="order-item__pay-state fs-6">
				    ' . GetMessage('STATUS') . ': <span class="' . (mb_strtolower($order['PROPERTY_STATUS_VALUE']) == mb_strtolower(GetMessage('NOT_PAID')) ? 'text-danger' : 'text-success') . '">' . $order['PROPERTY_STATUS_VALUE'] . '</span>
				</div>

				<div class="order-item__order-state fs-6">';
				AddMessage2Log('bvniorto');
				AddMessage2Log(mb_strtolower($order['PROPERTY_STATUS_VALUE']));
				AddMessage2Log(mb_strtolower(GetMessage('NOT_PAID')));
					if (mb_strtolower($order['PROPERTY_STATUS_VALUE']) == mb_strtolower(GetMessage('NOT_PAID'))) {
						$ordersString .= GetMessage('ORDER_IS_ON_EDIT_STAGE');
					} else {
						$ordersString .= GetMessage('ORDER_IS_NOT_ON_EDIT_STAGE');
					}
				$ordersString .= '</div>';

				if (mb_strtolower($order['PROPERTY_STATUS_VALUE']) == mb_strtolower(GetMessage('NOT_PAID'))) {
					$ordersString .= '<div class="order-item__deep-btn pb-2">
						<button data-id="' . $order['ID'] . '" class="btn btn-primary w-100 w-xl-auto d-none d-xl-inline-block add-good-mobile" data-bs-toggle="modal" href="#messagesModal2" role="button">' . GetMessage('ASK_FOR_A_BILL') . '</button>
						<a class="btn btn-primary w-100 w-xl-auto d-xl-none add-good-mobile" data-id="' . $order['ID'] . '">' . GetMessage('ASK_FOR_A_BILL') . '</a>
					</div>';
				}

				$ordersString .= '<div class="order-item__qty-col">
					<p class="fw-bold pb-2 pb-lg-4">' . GetMessage('QUANTITY') . '</p>
					<div class="mb-2 mb-lg-4">
						<span class="pb-2 pe-2">' . GetMessage('OF_GOODS_CAPITALIZED') . '</span>
						<span>' . $countGoods . '</span>
					</div>
					<div>
						<span class="pe-2">' . GetMessage('OF_POSITIONS') . '</span>
						<span>' . $countPositions . '</span>
					</div>
				</div>
				<div class="order-item__summ-col">
					<p class="fw-bold pb-2 pb-lg-4">' . GetMessage('TOTAL') . '</p>
					<div class="mb-2 mb-lg-4 text-secondary">¥ ' . number_format($order['PROPERTY_GOODS_AND_DELIVERY_THROUGH_CHINA_COST_YUAN_VALUE'], 2, '.', ' ') . '</div>
					<div class="text-success">₽ ' . number_format($order['PROPERTY_GOODS_AND_DELIVERY_THROUGH_CHINA_COST_RUB_VALUE'], 2, '.', ' ') . '</div>
				</div>
			</div>
		</p>';
    }
       

    // если строка до сих пор пустая - это значит, что заказы по указанному условию не нашлись, - тогда выведем
    // пользователю сообщение о том, что таких заказов нет 
    if ($ordersString == '') {
        $ordersString = '<p class="news-item"><div class="fw-bold fs-5 text-dark">' . GetMessage('NO_ORDERS_FOUND') . '</div></p>';
    }

    echo json_encode(['orders_in_string' => $ordersString]);
}


die();