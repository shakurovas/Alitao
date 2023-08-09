<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
/** @var array $arParams */
/** @var array $arResult */
/** @global CMain $APPLICATION */
/** @global CUser $USER */
/** @global CDatabase $DB */
/** @var CBitrixComponentTemplate $this */
/** @var string $templateName */
/** @var string $templateFile */
/** @var string $templateFolder */
/** @var string $componentPath */
/** @var CBitrixComponent $component */
$this->setFrameMode(true);
$this->addExternalJS("/order/js/adding_goods.js");
$this->addExternalJS("/local/templates/alitao/components/bitrix/news/my_orders/bitrix/news.list/orders_list/js/script.js");
?>

<main>
	<?php if ($USER->isAuthorized()):?>
		<section class="container pt-7 mt-1 pb-10 mb-4  text">
			<div class="cabinet">
				<nav class="cabinet__nav  fw-bold text-center text-md-start">
					<ul>
						<li>
							<a href="/auth/personal.php" class="cabinet__nav-link  link-dark"><?=GetMessage('MY_PROFILE');?></a>
						</li>                
						<li>
							<a href="/order/my_orders.php" class="cabinet__nav-link active link-dark"><?=GetMessage('MY_ORDERS');?></a>                
						</li>
						<li>
							<a href="/order/history.php" class="cabinet__nav-link link-dark"><?=GetMessage('HISTORY');?></a>                
						</li>
						<li>
							<a href="/?logout=yes&<?=bitrix_sessid_get();?>" class="cabinet__nav-link link-dark"><?=GetMessage('LOG_OUT');?></a>                
						</li>
					</ul>
					
					
				</nav>

				<section class="cabinet__content">
					<div class="orders">
						<?php if ($arResult['COUNTER']):?>
							<div class="orders__filters-block mb-7 mb-lg-4">
								<div class="dropdown dropdown_orders me-md-7 mb-3 mb-md-0">
									<button class="btn btn-outline-secondary dropdown-toggle" type="button" id="orders-state" data-bs-toggle="dropdown" aria-expanded="false">
										
										<svg width="15" height="8" viewBox="0 0 15 8" fill="none" xmlns="http://www.w3.org/2000/svg">
											<path fill-rule="evenodd" clip-rule="evenodd" d="M8.03033 7.53033C7.73744 7.82322 7.26256 7.82322 6.96967 7.53033L0.96967 1.53033C0.676777 1.23744 0.676777 0.762563 0.96967 0.46967C1.26256 0.176777 1.73744 0.176777 2.03033 0.46967L7.5 5.93934L12.9697 0.46967C13.2626 0.176777 13.7374 0.176777 14.0303 0.46967C14.3232 0.762563 14.3232 1.23744 14.0303 1.53033L8.03033 7.53033Z" fill="#FF431A"/>
										</svg>
										<span class="value ms-2" id="status-choosing"><?=GetMessage('ANY_STATUS');?></span>    
									</button>
									<ul class="dropdown-menu" aria-labelledby="orders-state">
										<li class="dropdown-item custom" ><?=GetMessage('ANY_STATUS');?></li>
										<li class="dropdown-item custom"><?=GetMessage('NOT_PAID');?></li>
										<li class="dropdown-item custom"><?=GetMessage('PAID');?></li>                          
										<li class="dropdown-item custom"><?=GetMessage('COMPLETED');?></li>
									</ul>
								</div>
							</div>
						<?php endif;?>

						<div class="orders__list fs-5 text-dark">
							<?php if ($arResult["ITEMS"]):?>
								<?foreach($arResult["ITEMS"] as $arItem):?>
									<?
									$this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_EDIT"));
									$this->AddDeleteAction($arItem['ID'], $arItem['DELETE_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => GetMessage('CT_BNL_ELEMENT_DELETE_CONFIRM')));
									?>
									<p class="news-item" id="<?=$this->GetEditAreaId($arItem['INFO']['ID']);?>">
										<div class="order-item" style="margin-bottom: 30px;">
											<?php if (mb_strtolower($arItem['PROPERTIES']['STATUS']['VALUE']) == mb_strtolower(GetMessage('NOT_PAID'))):?>
												<div class="order-item__controls">
													<button class="order-item__edit-btn order-edit-btn" data-id="<?=$arItem['ID'];?>" data-content="<?=$arItem['PROPERTIES']['ORDER_CONTENT']['VALUE']['TEXT'];?>" data-comment="<?=$arItem['PROPERTIES']['NOTES']['VALUE']['TEXT'];?>" data-insurance="<?=$arItem['PROPERTIES']['IS_INSURED']['VALUE'];?>" data-delivery="<?=$arItem['PROPERTIES']['DELIVERY_METHOD']['VALUE'];?>">
														<img src="<?=SITE_TEMPLATE_PATH;?>/img/icons/edit.svg" alt="">
													</button>
													<button class="order-item__edit-btn order-hide-btn" data-id="<?=$arItem['ID'];?>">
														<img src="<?=SITE_TEMPLATE_PATH;?>/img/icons/remove.svg" alt="">
													</button>
												</div>
											<?php endif;?>


											<div class="order-item__col-title fw-bold fs-5 text-dark col-title-1">
												<a href="<?=$arItem['DETAIL_PAGE_URL'];?>">№ <?=GetMessage('OF_ORDER');?></a>
											</div>
											<div class="order-item__col-title fw-bold fs-5 text-dark col-title-2">
												<a href="<?=$arItem['DETAIL_PAGE_URL'];?>"><?php $orderedGoods = unserialize(base64_decode($arItem['PROPERTIES']['ORDER_CONTENT']['VALUE']['TEXT']));
												if (is_array($orderedGoods) && count($orderedGoods) == 1) $orderName = $orderedGoods[array_keys($orderedGoods)[0]]['name'];
												else if (is_array($orderedGoods) && count($orderedGoods) > 1) $orderName = $orderedGoods[array_keys($orderedGoods)[0]]['name'] . ' ' . GetMessage('AND_OTHERS');
												else $orderName = GetMessage('WITHOUT_NAME');
												?>
												<?=$orderName;?></a>
											</div>
											<div class="order-item__col-title fw-bold fs-5 text-dark col-title-3">
												<?=GetMessage('INFO');?>
											</div>
										
											<div class="order-item__num-order">
												<a href="<?=$arItem['DETAIL_PAGE_URL'];?>">№ <?=$arItem['ID'];?></a>
											</div>
											<div class="order-item__date-order">
												<?=substr($arItem['DATE_CREATE'], 0, -3);?>
											</div>

											<div class="order-item__products">
											
												<?php 
												if (!empty($arItem['PROPERTIES']['PICTURES']['VALUE'])) {
													if (count($arItem['PROPERTIES']['PICTURES']['VALUE']) == 1) {?>
														<div class="mo-order__description">
															<div class="mo-order__img-block me-2 flex-shrink-0">
																<img src="<?=CFile::GetPath($arItem['PROPERTIES']['PICTURES']['VALUE'][0]);?>" alt="" class="mo-order__img" width="100" height="100">
															</div>
														</div>
													<? } else {
														$counter = 0;
														foreach ($arItem['PROPERTIES']['PICTURES']['VALUE'] as $photoId){
															$counter += 1;
															if ($counter == 4) {
																break;
															}?>
															<div class="order-item__product-img-wrap">
																<div class="order-item__product-img-inner-wrap ">
																	<img class="order-item__product-img" src="<?=CFile::GetPath($photoId);?>">
																</div>                                    
															</div>
														<?php }
													}
													
												} else {?>
													<div class="mo-order__description">
														<div class="mo-order__img-block me-2 flex-shrink-0">
															<img src="/local/templates/alitao/img/no-photo.jpg" alt="" class="mo-order__img" width="100" height="100">
														</div>
													</div>
												<?php }?>

												<?php if (!empty($arItem['PROPERTIES']['PICTURES']['VALUE']) && count($arItem['PROPERTIES']['PICTURES']['VALUE']) > 4):?>
													<div class="order-item__product-count-wrap">
														<div class="order-item__product-count-inner-wrap ">
															<div class="order-item__product-count">
																<?=GetMessage('MORE');?> <br /><?=count($arItem['PROPERTIES']['PICTURES']['VALUE']) - 4;?> <?=GetMessage('OF_PHOTOS');?>
															</div>
														</div>
													</div>
												<?php endif;?>
											</div>

											<div class="order-item__pay-state fs-6">
												<?=GetMessage('STATUS');?>: <span class="<?php echo mb_strtolower($arItem['PROPERTIES']['STATUS']['VALUE']) == mb_strtolower(GetMessage('NOT_PAID')) ? 'text-danger' : 'text-success';?>"><?=$arItem['PROPERTIES']['STATUS']['VALUE_ENUM'];?></span>
											</div>

											<div class="order-item__order-state fs-6">
												<?php if (mb_strtolower($arItem['PROPERTIES']['STATUS']['VALUE']) == mb_strtolower(GetMessage('NOT_PAID'))):?>
													<?=GetMessage('ORDER_IS_ON_EDIT_STAGE');?>
												<?php else:?>
													<?=GetMessage('ORDER_IS_NOT_ON_EDIT_STAGE');?>
												<?php endif;?>
											</div>

											<?php if (mb_strtolower($arItem['PROPERTIES']['STATUS']['VALUE']) == mb_strtolower(GetMessage('NOT_PAID'))):?>
												<div class="order-item__deep-btn pb-2">
													<button data-id="<?=$arItem['ID'];?>" class="btn btn-primary w-100 w-xl-auto d-none d-xl-inline-block add-good-mobile" data-bs-toggle="modal" href="#messagesModal2" role="button"><?=GetMessage('ASK_FOR_A_BILL');?></button>
													<a class="btn btn-primary w-100 w-xl-auto d-xl-none add-good-mobile" data-id="<?=$arItem['ID'];?>"><?=GetMessage('ASK_FOR_A_BILL');?></a>
												</div>
											<?php endif;?>

											<div class="order-item__qty-col">
												<p class="fw-bold pb-2 pb-lg-4"><?=GetMessage('QUANTITY');?></p>
												<div class="mb-2 mb-lg-4">
													<span class="pb-2 pe-2"><?=GetMessage('OF_GOODS_CAPITALIZED');?></span>
													<span><?=$arItem['GOODS_QUANTITY'];?></span>
												</div>
												<div>
													<span class="pe-2"><?=GetMessage('OF_POSITIONS');?></span>
													<span><?=$arItem['POSITIONS_QUANTITY'];?></span>
												</div>
											</div>
											<div class="order-item__summ-col">
												<p class="fw-bold pb-2 pb-lg-4"><?=GetMessage('TOTAL');?></p>
												<div class="mb-2 mb-lg-4 text-secondary">¥ <?=number_format($arItem['TOTAL_SUM_YUAN'], 2, '.', ' ');?></div>
												<div class="text-success">₽ <?=number_format($arItem['TOTAL_SUM_RUB'], 2, '.', ' ');?></div>
											</div>
										</div>
									</p>
								<?php endforeach;?>
							<?php else:?>
								<div class="fw-bold fs-5 text-dark"><?=GetMessage('NO_ORDERS_YET');?></div>
							<?php endif;?>
						</div>


						<div class="pt-7 pb-5">
							<a href="<?php echo $isMobile ? '/order/mobile_add_edit_order.php' : '/order/make_order_step_1.php';?>" class="btn btn-primary w-100 w-lg-auto px-10"><?=GetMessage('NEW_ORDER');?></a>
						</div>
					</div>
				</section>
			</div>
		</section>
	<?php else:?>
		<section class="container pt-7 mt-1 pb-10 mb-4 text">
			<div class="cabinet"><?=GetMessage('NEED_TO_BE_AUTHORIZED');?></div>
		</section>
	<?php endif;?>
</main>
