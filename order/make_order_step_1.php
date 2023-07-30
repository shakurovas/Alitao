<?php
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");

$APPLICATION->SetTitle("Заказ");

use \Bitrix\Main\Localization\Loc;
use Bitrix\Main\Page\Asset;

Asset::getInstance()->addJs('/order/js/adding_goods.js');
Loc::loadMessages(__FILE__);

session_start();
echo '<pre>';
var_dump($_SESSION['cart']);
echo '</pre>';

// echo '<pre>';
// var_dump($_FILES);
// echo '</pre>';
// unset($_SESSION['cart']);
?>

<main>
    <?php if ($USER->isAuthorized()):?>
        <section class="container pt-7 mt-1 pb-10 mb-4  text">
            <h1 class="fs-2 text-center mb-6 mb-lg-8"><?=Loc::getMessage('MAKE_AN_ORDER_TITLE');?></h1>

            <div class="steps mb-4">
                <div class="steps__step active">
                    <div class="steps__num ">1</div>
                    <p class="steps__text"><?=Loc::getMessage('ORDER_CONTENTS');?></p>
                </div>

                <div class="steps__step">
                    <div class="steps__num">2</div>
                    <p class="steps__text"><?=Loc::getMessage('DELIVERY_ADDRESS');?></p>
                </div>

                <div class="steps__step">
                    <div class="steps__num">3</div>
                    <p class="steps__text"><?=Loc::getMessage('CONFIRMATION');?></p>
                </div>
            </div>

            <div class="mo-instructions <?php echo isset($_SESSION['cart']) && !empty ($_SESSION['cart']) ? 'd-none' : ''?>">
                <p class="fs-3 text-dark text-center mb-2 mb-lg-4"><?=Loc::getMessage('NO_GOODS_ADDED');?></p>
                <div class="d-flex justify-content-center mb-6">
                    <a href="/helpful_info/how_to_place_order.php" class="link-secondary fs-5"><?=Loc::getMessage('HOW_TO_ADD_GOOD');?>?</a>   
                </div>

                <div class="mb-2">
                    <input type="url" id="add-product-input" name="mo-product-link" class="form-control" placeholder="<?=Loc::getMessage('PRODUCT_LINK');?>">
                </div>
                <p class="text-dark fs-5 text-center mb-7"> <?=Loc::getMessage('PASTE_LINK');?> 
                    <a href="https://taobao.com" class="link-secondary" target="_blank">taobao,</a> 
                    <a href="https://tmall.com" class="link-secondary" target="_blank">tmall,</a>  
                    <a href="https://1688.com" class="link-secondary" target="_blank">1688,</a>  
                    <a href="https://alibaba.com" class="link-secondary" target="_blank">alibaba,</a>  
                    <a href="https://jd.com" class="link-secondary" target="_blank">jd,</a>  
                    <a href="https://poizon.com" class="link-secondary" target="_blank">poizon </a>  
                    <span class="text-secondary"> <?=Loc::getMessage('OR_OTHER_SITES');?></span>
                </p>
                
                <div class="d-flex justify-content-center">
                    <button class="btn btn-primary add-goods-btn-cart btn-add-product-before-goods btn-add-product w-100 w-sm-auto d-none d-md-inline-block" data-bs-toggle="modal" href="#makeOrderModal" role="button"><?=Loc::getMessage('ADD_GOOD');?></button>
                    <a href="/order/mobile_add_edit_order.php" class="btn btn-primary btn-add-product-before-goods btn-add-product w-100 w-sm-auto d-md-none" ><?=Loc::getMessage('ADD_GOOD');?></a>
                </div>
                
            </div>
            

            
                <!-- <div class="order-calc-block" <?php //echo (!isset($_SESSION['cart']) || empty($_SESSION['cart'])) ? 'id="goods-list"' : '';?>>
                    <?php //if (isset($_SESSION['cart']) && !empty($_SESSION['cart'])):?>
                        <div class="order-list py-4 py-lg-9" id="goods-list"> -->
                <div class="order-calc-block">
                        <div class="order-list py-4 py-lg-9" id="goods-list">

                            <?php 
                            $sumRub = 0;  // подсчёт стоимости всех товаров
                            foreach ($_SESSION['cart'] as $link => $props):?>
                                <div class="mo-order">
                                    <div class="mo-order__description">
                                        <?php 
                                        if (!empty($props['photo']) && isset($props['photo'][count($props['photo'])-1]['name']) && !empty($props['photo'][count($props['photo'])-1]['name'])) {
                                            $photoPath = '/upload/users_pics/' . $props['photo'][count($props['photo'])-1]['name'];
                                        } else {
                                            $photoPath = SITE_TEMPLATE_PATH . '/img/no-photo.jpg';
                                        }
                                        ?>
                                        <div class="mo-order__img-block me-2 flex-shrink-0">
                                            <img src="<?=$photoPath;?>" alt="" class="mo-order__img" width="100" height="100">
                                        </div>
                                    
                                        <div class="mo-order__text-block flex-grow-1">
                                            <div class="mb-1 fs-5 mb-lg-0"><a href="<?=$link;?>" class="link-of-good link-secondary text-decoration-underline fs-5" data-target-field="product_name"><?=$props['name'];?></a></div>
                                            

                                            <div class="d-inline-flex flex-wrap mb-2">
                                                <div class="order-tag me-2">
                                                    <div class="order-tag__char bg-dark text-white"><?=Loc::getMessage('COLOUR');?></div>
                                                    <div class="order-tag__value bg-secondary text-white" data-target-field="product_color"><?php echo $props['colour'] ?: Loc::getMessage('NOT_SPECIFIED');?></div>
                                                </div>

                                                <div class="order-tag me-2">
                                                    <div class="order-tag__char bg-dark text-white"><?=Loc::getMessage('SIZE');?></div>
                                                    <div class="order-tag__value bg-secondary text-white" data-target-field="product_size"><?php echo $props['size'] ?: Loc::getMessage('NOT_SPECIFIED');;?></div>
                                                </div>
                                            </div>

                                            <p class="text text-gray" data-target-field="product_comment"><?=$props['comment'];?> </p>
                                        </div>
                                    </div>

                                    <div class=" mo-order__price-table-wrap">
                                        <div class="mo-order__widget-wrap">
                                            <div class="inc-widget vertical">
                                                <div data-rate="<?=$_SESSION['cnyRate'];?>" data-price="<?=$props['price'];?>" class="inc-widget__btn inc plus-cost-calc-list"></div>
                                                <input type="tel" class="inc-widget__input product-qty-list" name="product_qty" min="1" value="<?=$props['quantity'];?>" data-cross-field="product_price" data-calc="data-price-calc">
                                                <div data-rate="<?=$_SESSION['cnyRate'];?>" data-price="<?=$props['price'];?>" class="inc-widget__btn dec minus-cost-calc-list"></div>
                                            </div>
                                        </div>
                                        <div class="mo-order__price-table text-dark flex-grow-1">
                                        

                                            
                                            <div>
                                                <div class="fw-bold mb-2">
                                                    <?=Loc::getMessage('SUMMATION');?>
                                                </div>
                                                <div class=" mb-2 text-secondary" >
                                                    <?php $cost = number_format((int)$props['quantity'] * (int)$props['price'], 2, '.', ' ');?>
                                                    ¥ <span class="product-cost-yuan-list" data-target-field="product_price"><?=$cost;?></span>
                                                </div>
                                                <div class="text-dark d-none d-lg-block product-cost-rub-list">
                                                    ₽ <?=number_format((float)$cost * $_SESSION['cnyRate'], 2, '.', ' ');?>
                                                </div>
                                            </div>
                    
                                            <div>
                                                <div class="fw-bold mb-2">
                                                    <?=Loc::getMessage('DELIVERY');?>
                                                </div>
                                                <div class=" mb-2 text-secondary" >
                                                    <?php $deliveryCost = number_format((float)$props['delivery_through_china'], 2, '.', ' ');?>
                                                    ¥ <span data-target-field="delivery_price" class="delivery-cost-yuan-list"><?=$deliveryCost;?></span>
                                                </div>
                                                <div class="text-dark d-none d-lg-block delivery-cost-rub-list">
                                                    ₽ <?=number_format($deliveryCost * $_SESSION['cnyRate'], 2, '.', ' ');?>
                                                </div>
                                            </div>
                    
                                            <div>
                                                <div class="fw-bold mb-2">
                                                    <?=Loc::getMessage('SERVICES');?>
                                                </div>
                                                <div class=" mb-2 text-secondary services-cost-yuan-list">
                                                    ¥ <?php if ($props['photo_report_is_needed']) $services = 5.00;
                                                    else $services = 0.00;
                                                    echo number_format($services, 2, '.', ' ');?>
                                                </div>
                                                <div class="text-dark d-none d-lg-block services-cost-rub-list">
                                                    ₽ <?=number_format($services * $_SESSION['cnyRate'], 2, '.', ' ');?>
                                                </div>
                                            </div>
                                            
                                            <div>
                                                <div class="fw-bold mb-2">
                                                    <?=Loc::getMessage('TOTAL');?>
                                                </div>
                                                <?php
                                                $totalCostYuan = $cost + $deliveryCost + $services;
                                                $totalCostRub = $totalCostYuan * $_SESSION['cnyRate'];
                                                $sumRub += $totalCostRub;?>
                                                <div class="text-success d-lg-none" >
                                                    <span class="total-cost-yuan-list-none">¥ <?=$totalCostYuan;?></span> <span class="total-cost-rub-list-none">( ₽ <?=$totalCostRub;?> )</span>
                                                </div>
                                                <div class=" mb-2 text-secondary d-none d-lg-block total-cost-yuan-list">
                                                    ¥ <?=number_format($totalCostYuan, 2, '.', ' ');?>
                                                </div>
                                                <div class="text-success d-none d-lg-block total-cost-rub-list">
                                                    ₽ <?=number_format($totalCostRub, 2, '.', ' ');?>
                                                </div>
                                            </div>

                                            
                                        </div>
                                    </div>
                                    
                    
                                    <div class="mo-order__controls-col ">
                                        
                                        <button class="mo-order__remove mb-3">
                                            <img src="<?=SITE_TEMPLATE_PATH;?>/img/icons/remove.svg" alt="">
                                        </button>

                                        <button class="mo-order__edit" data-bs-toggle="modal" href="#makeOrderModal" role="button">
                                            <img src="<?=SITE_TEMPLATE_PATH;?>/img/icons/edit.svg" alt="">
                                        </button>
                                    </div>
                                </div>
                            <?php endforeach;?>
                            
                        </div>

                        <?php if (isset($_SESSION['cart']) && !empty($_SESSION['cart'])):?>
                            <div class="d-flex justify-content-center delete-after-add-goods">
                                <button class="btn btn-outline-primary add-goods-btn-cart btn-add-product w-100 w-sm-auto d-none d-md-inline-block" data-target-field="product_link" data-bs-toggle="modal" href="#makeOrderModal" role="button"><?=Loc::getMessage('ADD_GOOD');?></button>
                                <a href="/order/mobile_add_edit_order.php" class="btn btn-outline-primary btn-add-product w-100 w-sm-auto d-md-none" ><?=Loc::getMessage('ADD_GOOD');?></a>
                            </div>

                            <p class="my-7 text-dark text-center fs-5 delete-after-add-goods" id="total-with-commission-cost"><?=Loc::getMessage('TOTAL_WITH_COMMISSION');?>: <?=number_format($sumRub, 2, '.', ' ')?> ₽  </p>
                            <div class="d-flex justify-content-center delete-after-add-goods">
                                <a class="btn btn-primary btn-add-product w-100 w-sm-auto" href="/order/make_order_step_2.php"><?=Loc::getMessage('CONTINUE');?></a>
                            </div>
                        <?php endif;?>
                    <?php //endif;?>
                </div>
            
            


        </section>
    <?php else:?>
        <section class="container pt-7 mt-1 pb-10 mb-4  text">
            <div class="cabinet"><?=Loc::getMessage('NEED_TO_BE_AUTHORIZED');?></div>
        </section>
    <?php endif;?>
</main>


<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>