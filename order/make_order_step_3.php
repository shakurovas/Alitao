<?php
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");

$APPLICATION->SetTitle("Заказ");

use \Bitrix\Main\Localization\Loc;
use Bitrix\Main\Page\Asset;

Asset::getInstance()->addJs('/order/js/adding_order.js');

Loc::loadMessages(__FILE__);

session_start();

// echo '<pre>';
// print_r($_SESSION['users_info']);
// echo '</pre>';

?>

<main>
    <?php if ($USER->isAuthorized()):?>
        <section class="container pt-7 mt-1 pb-10 mb-4  text">
            <h1 class="fs-2 text-center mb-6 mb-lg-8"><?=Loc::getMessage('CONFIRMATION');?></h1>

            <div class="steps mb-10 mb-lg-7">
                <div class="steps__step prev">
                    <div class="steps__num ">1</div>
                    <p class="steps__text"><?=Loc::getMessage('ORDER_CONTENTS');?></p>
                </div>

                <div class="steps__step prev">
                    <div class="steps__num">2</div>
                    <p class="steps__text"><?=Loc::getMessage('DELIVERY_ADDRESS');?></p>
                </div>

                <div class="steps__step active">
                    <div class="steps__num">3</div>
                    <p class="steps__text"><?=Loc::getMessage('CONFIRMATION');?></p>
                </div>
            </div>

            <form class="row text-dark fs-5">
                
                <div class="col-12 mb-6  mb-lg-0 col-lg-5 text-dark">
                    
                    <div class="mb-lg-4 mb-2">
                        <p class="fs-3 fw-bold mb-2"><?=Loc::getMessage('FULL_NAME');?></p>
                        <p class="fs-4 fs-lg-3 text-secondary "><?=$_SESSION['users_info']['full_name'];?></p>
                    </div>

                    <!-- <div class="mb-lg-4 mb-2">
                        <p class="fs-3 fw-bold mb-2"><?//=Loc::getMessage('NUMBER_OF_ORDER');?></p>
                        <p class="fs-4 fs-lg-3 text-secondary ">123456</p>
                    </div> -->

                    <div class="mb-lg-4 mb-2">
                        <p class="fs-3 fw-bold mb-2"><?=Loc::getMessage('PHONE');?></p>
                        <p class="fs-4 fs-lg-3 text-secondary "><?=$_SESSION['users_info']['phone'];?></p>
                    </div>

                    <div class="mb-lg-4 mb-2">
                        <p class="fs-3 fw-bold mb-2"><?=Loc::getMessage('REGION');?></p>
                        <p class="fs-4 fs-lg-3 text-secondary "><?=$_SESSION['users_info']['region'];?></p>
                    </div>

                    <div class="mb-lg-4 mb-2">
                        <p class="fs-3 fw-bold mb-2"><?=Loc::getMessage('CITY');?></p>
                        <p class="fs-4 fs-lg-3 text-secondary "><?=$_SESSION['users_info']['city'];?></p>
                    </div>

                    <div class="mb-lg-4 mb-2">
                        <p class="fs-3 fw-bold mb-2"><?=Loc::getMessage('ADDRESS');?></p>
                        <p class="fs-4 fs-lg-3 text-secondary "><?=$_SESSION['users_info']['address'];?></p>
                    </div>

                    <div>
                        <p class="fs-3 fw-bold mb-2"><?=Loc::getMessage('DELIVERY_METHOD');?></p>
                        <p class="fs-4 fs-lg-3 text-secondary "><?=$_SESSION['users_info']['delivery_type'];?></p>
                    </div>
                    
                    
                </div>
                <div class="col-12 col-lg-7 ps-lg-7 d-flex flex-column">
                    <div class="d-flex flex-column flex-grow-1">
                        <label for="comment" class="fs-3 d-block fw-bold mb-lg-2  mb-4 text-center text-lg-start"><?=Loc::getMessage('COMMENT');?></label>

                        <textarea name="comment" id="comment" class="form-control mo-textarea flex-grow-1" ></textarea>
                    </div>
                    
                </div>
                <div class="col-12 mt-7">
                    <div class="d-flex justify-content-center mb-6">
                        <div class="order__amount fs-lg-2 text-dark">
                            <span class="order__amount-caption"><?=Loc::getMessage('TOTAL_WITH_COMMISSION');?>:</span> <span class="text-success order__amount-value d-block d-lg-inline text-center">2 244,37 ₽</span>
                        </div>
                    </div>
                    <p class="text-center mb-4 d-none d-lg-block"><?=Loc::getMessage('CHECK_INFO');?>.</p>
                    <div class="d-flex justify-content-center">
                        <button id="confirm-order-btn" class="btn btn-primary btn-add-product w-100 w-sm-auto"><?=Loc::getMessage('CONFIRM_THE_ORDER');?></button>
                    </div>
                </div>

                
            </form>
            
        </section>
    <?php else:?>
        <section class="container pt-7 mt-1 pb-10 mb-4  text">
            <div class="cabinet"><?=Loc::getMessage('NEED_TO_BE_AUTHORIZED');?></div>
        </section>
    <?php endif;?>
</main>


<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>