<?php
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");

$APPLICATION->SetTitle("Заказ");

use \Bitrix\Main\Localization\Loc;
use Bitrix\Main\Page\Asset;

Asset::getInstance()->addJs('/order/js/adding_goods.js');
Loc::loadMessages(__FILE__);

session_start();

if (!isset($_SESSION['editable_order'][$_GET['link']])) {
    $_GET['link'] = substr($_GET['link'], 0, -1);
}

?>

<main>
    <?php if ($USER->isAuthorized()):?>
        <section class="container pt-7 mt-1 pb-10 mb-4  text">
            <h3 class="h2 mb-6"><?=Loc::getMessage('SPECIFY_THE_POSITION_PARAMETERS');?> </h3>

            <div class="mb-4">
                <div class="mb-1">
                    <input type="url" name="product_link" id="product-link" class="form-control py-2"  placeholder="Ссылка на товар" value="<?php if (isset($_GET['link']) && !empty($_GET['link'])) echo strip_tags($_GET['link']);?>">
                </div>
                <label class="text-dark fs-5 text-gray" for="product-link">  <?=Loc::getMessage('PASTE_LINK_FROM_THE_SITE');?> 
                    <a href="https://taobao.com" class="link-secondary" target="_blank">taobao,</a> 
                    <a href="https://tmall.com" class="link-secondary" target="_blank">tmall,</a>  
                    <a href="https://1688.com" class="link-secondary" target="_blank">1688,</a>  
                    
                    <span class="text-secondary"> <?=Loc::getMessage('OR_THE_OTHERS');?></span>
                </label>
            </div>
                
            <div class="mb-4">
                <div class="mb-1">
                    <input type="text" name="product_name" id="product-name" class="form-control py-2"  placeholder="<?=Loc::getMessage('GOOD_NAME');?>" value="<?php if (isset($_SESSION['editable_order']) && isset($_GET['link'])) echo $_SESSION['editable_order'][$_GET['link']]['name'];?>">
                </div>
                <label class="text-dark fs-5 text-gray" for="product-name"><?=Loc::getMessage('SPECIFY_GOOD_NAME');?></label>
            </div>

            <div class="row mb-4">
                <div class="col-md-6 col-12 mb-4 mb-md-0">

                    <div class="row">
                    <input type="hidden" name="is_edit_mode" id="is_edit_mode" class="form-control py-2" value="<?php echo (isset($_GET['edit']) && $_GET['edit'] == 'y') ? 1 : 0;?>">
                        <div class="col-6 mb-4">
                            <label class="text-dark fs-5 mb-1" for="product-name"><?=Loc::getMessage('COST');?> ¥</label>
                            <div >
                                <input type="number" name="product_price" id="product-price" class="form-control py-2"  placeholder="<?=Loc::getMessage('OF_THE_GOOD');?>" data-cross-field="product_qty" data-calc="data-price-calc" value="<?php echo (isset($_SESSION['editable_order']) && isset($_GET['link'])) ? $_SESSION['editable_order'][$_GET['link']]['price'] : '';?>">
                            </div>
                            
                        </div>
                        <div class="col-6 mb-4">
                            <label class="text-dark fs-5 mb-1" for="product-size"><?=Loc::getMessage('SIZE');?></label>
                            <div >
                                <input type="text" name="product_size" id="product-size" class="form-control py-2"  placeholder="<?=Loc::getMessage('SPECIFY_SIZE');?>" value="<?php echo (isset($_SESSION['editable_order']) && isset($_GET['link'])) ? $_SESSION['editable_order'][$_GET['link']]['size'] : '';?>">
                            </div>
                            
                        </div>
                        <div class="col-6">
                            <label class="text-dark fs-5 mb-1" for="delivery-price"><?=Loc::getMessage('DELIVERY');?>  ¥</label>
                            <div >
                                <input type="number" name="delivery_price" id="delivery-price" class="form-control py-2"  placeholder="<?=Loc::getMessage('THROUGH_CHINA');?>" data-calc="data-price-delivery" value="<?php echo (isset($_SESSION['editable_order']) && isset($_GET['link'])) ? $_SESSION['editable_order'][$_GET['link']]['delivery_through_china'] : '';?>">
                            </div>
                            
                        </div>
                        <div class="col-6">
                            <label class="text-dark fs-5 mb-1" for="product-color"><?=Loc::getMessage('COLOUR');?></label>
                            <div >
                                <input type="text" name="product_color" id="product-color" class="form-control py-2"  placeholder="<?=Loc::getMessage('SPECIFY_COLOUR');?>" value="<?php echo (isset($_SESSION['editable_order']) && isset($_GET['link'])) ? $_SESSION['editable_order'][$_GET['link']]['colour'] : '';?>">
                            </div>
                            
                        </div>

                        
                    </div>


                </div>
                <div class="col-md-6 col-12 d-flex flex-column">
                    <label class="text-dark fs-5 mb-1" for="product-comment"><?=Loc::getMessage('NOTE');?></label>
                    
                    <textarea name="product_comment" id="product-comment" class="form-control py-2 flex-grow-1"  placeholder="<?=Loc::getMessage('ENTER_NOTE');?>" value="<?php echo (isset($_SESSION['editable_order']) && isset($_GET['link'])) ? $_SESSION['editable_order'][$_GET['link']]['comment'] : '';?>"></textarea>
                    
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
                    <div class="d-flex justify-content-between flex-wrap fs-very-small">
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
                            <p class="text-secondary">¥ <span id="services-cost-calc" data-price-delivery="3">3</span></p>
                        </div>
                        <div>
                            <p class="mb-2"><b><?=Loc::getMessage('TOTAL');?></b></p>
                            <p class="text-success">¥ <span id="total-cost-calc" data-summ="3">0</span></p>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="d-flex mb-lg-4 mb-7">
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
                    <?php if (isset($_SESSION['editable_order']) && isset($_GET['link']) && !empty($_SESSION['editable_order'][$_GET['link']]['photo'])):?>
                        <?php foreach($_SESSION['editable_order'][$_GET['link']]['photo'] as $key => $fileProps) :?>
                            <div class="products-photo-grid__item">
                                <img src="/upload/users_pics/<?=$fileProps['name'];?>" alt="">

                                <div class="products-photo-grid__item-remove">
                                    <img src="<?=SITE_TEMPLATE_PATH;?>/img/icons/remove-product.svg" alt="">
                                </div>
                            </div>
                        <?php endforeach;?>
                    <?php endif;?>
                
                </div>
                                
            </div>
            <div style="color: #FF6948;"><?=Loc::getMessage('ADDING_PHOTOS_DESCRIPTION');?></div><br>

            <div class="form-check d-flex align-items-center mb-8">
                <input class="form-check-input me-2" type="checkbox" value="" id="photoreport" name="photoreport"
                    <?php if (isset($_SESSION['editable_order']) && isset($_GET['link']) && $_SESSION['editable_order'][$_GET['link']]['photo_report_is_needed']) echo 'checked';?>
                >
                <label class="form-check-label fs-lg-5 fs-6" for="photoreport">
                    <?=Loc::getMessage('PHOTOREPORT_IS_NEEDED');?> <span class="text-secondary">+5¥</span>
                </label>
            </div>

            
            <div class="d-flex justify-content-center mb-2">
                <button id="add-good-btn" class="btn btn-primary btn-add-product w-100 w-sm-auto"><?=Loc::getMessage('ADD_GOOD');?></button>
            </div>
            <div id="required-fields-mobile" class="d-flex justify-content-center mb-2" style="color: #FF6948; display: none;">
                <?=Loc::getMessage('FILL_REQUIRED_FIELDS');?>
            </div>
        </section>
    <?php else:?>
        <section class="container pt-7 mt-1 pb-10 mb-4  text">
            <div class="cabinet"><?=Loc::getMessage('NEED_TO_BE_AUTHORIZED');?></div>
        </section>
    <?php endif;?>
</main>


<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>
