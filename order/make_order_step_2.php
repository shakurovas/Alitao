<?php
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");

$APPLICATION->SetTitle("Заказ");

use \Bitrix\Main\Localization\Loc;
use Bitrix\Main\Page\Asset;

Asset::getInstance()->addJs('/order/js/adding_user_info.js');

Loc::loadMessages(__FILE__);

$rsUser = CUser::GetByID($USER->GetID());  // получаем ID авторизованного пользователя и сразу же его поля
$arUser = $rsUser->Fetch();

session_start();

?>

<main>
    <?php if ($USER->isAuthorized()):?>
        <section class="container pt-7 mt-1 pb-10 mb-4  text">
            <h1 class="fs-2 text-center mb-6 mb-lg-8"><?=Loc::getMessage('DELIVERY_ADDRESS');?></h1>

            <div class="steps mb-7">
                <div class="steps__step prev ">
                    <div class="steps__num ">1</div>
                    <p class="steps__text"><?=Loc::getMessage('ORDER_CONTENTS');?></p>
                </div>

                <div class="steps__step active">
                    <div class="steps__num">2</div>
                    <p class="steps__text"><?=Loc::getMessage('DELIVERY_ADDRESS');?></p>
                </div>

                <div class="steps__step">
                    <div class="steps__num">3</div>
                    <p class="steps__text"><?=Loc::getMessage('CONFIRMATION');?></p>
                </div>
            </div>

            <form id="users_info" class="row text-dark fs-5"  action="/order/make_order_step_3.php">
                <div class="col-12 col-lg-6">
                    <h3 class="h2 mb-2 text-center text-lg-start"><?=Loc::getMessage('ADDRESS_AND_CONTACTS');?></h3>
                    <p class="fs-5 mb-6 text-gray text-center text-lg-start"><?=Loc::getMessage('ALL_FIELDS_ARE_REQUIRED');?>!</p>
                    <div class=" mb-4" >
                        <label for="fio" class="d-block"><?=Loc::getMessage('YOUR_FULL_NAME');?></label>
                        <input type="text" class="form-control py-2 mo-input" name="fio" id="fio"  value="<?php echo ($arUser['LAST_NAME'] && $arUser['NAME'] && $arUser['SECOND_NAME']) ? ($arUser['LAST_NAME'] . ' ' . $arUser['NAME'] . ' ' . $arUser['SECOND_NAME']) : '';?>">
                    </div>
                    
                    <div class=" mb-4" >
                        <label for="region" class="d-block"><?=Loc::getMessage('REGION');?></label>
                        <input type="text" class="form-control py-2 mo-input"  name="region" id="region" value="<?php echo $arUser['PERSONAL_STATE'] ?: '';?>">
                    </div>
                    <div class=" mb-4" >
                        <label for="city" class="d-block"><?=Loc::getMessage('CITY');?></label>
                        <input type="text" class="form-control py-2 mo-input"  name="city" id="city" value="<?php echo $arUser['PERSONAL_CITY'] ?: '';?>">
                    </div>
                    <div class=" mb-4s" >
                        <label for="address" class="d-block"><?=Loc::getMessage('ADDRESS');?></label>
                        <input type="text" class="form-control py-2 mo-input" name="address"  id="address" value="<?php echo $arUser['PERSONAL_STREET'] ?: '';?>">
                    </div>
                    <div class=" mb-4" >
                        <label for="zipindex" class="d-block"><?=Loc::getMessage('POSTCODE');?></label>
                        <input type="tel" class="form-control py-2 mo-input" name="zipindex"  id="zipindex" value="<?php echo $arUser['PERSONAL_ZIP'] ?: '';?>">
                    </div>
                    <div class=" mb-4" >
                        <label for="phone" class="d-block"><?=Loc::getMessage('PHONE');?></label>
                        <input type="tel" class="form-control py-2 mo-input" name="phone"  id="phone" value="<?php echo $arUser['PERSONAL_PHONE'] ?: '';?>">
                    </div>
                    <div class=" mb-4" >
                        <label for="email" class="d-block"><?=Loc::getMessage('EMAIL');?></label>
                        <input type="email" class="form-control py-2 mo-input" name="email" id="email"  value="<?php echo $arUser['EMAIL'] ?: '';?>">
                    </div>
                </div>
                <div class="col-12 col-lg-6">
                    <h3 class="h2 mb-2 text-center text-lg-start"><?=Loc::getMessage('DELIVERY_SERVICE');?></h3>
                    <p class="fs-5 mb-6 text-gray text-center text-lg-start"><?=Loc::getMessage('CHOOSE_DELIVERY_SERVICE');?></p>

                    <div class="mb-6">
                        <div class="form-check d-flex align-items-center mb-2">
                            <input class="form-check-input me-2" type="radio" name="typedelivery" id="typedelivery-1" checked value="<?=Loc::getMessage('FAST_AVIA');?>">
                            <label class="form-check-label fs-5 fs-lg-3" for="typedelivery-1">
                                <?=Loc::getMessage('FAST_AVIA');?>
                            </label>
                        </div>
                        <p class="fs-6 fs-lg-5 text-dark ms-7"><?=Loc::getMessage('MORE_ABOUT');?> <a href="/helpful_info/delivery.php" target="_blank" class="link-secondary"><?=Loc::getMessage('ABOUT_TERMS_AND_PRICES');?></a></p>
                    </div>

                    <div class="mb-6">
                        <div class="form-check d-flex align-items-center mb-2">
                            <input class="form-check-input me-2" type="radio" name="typedelivery" id="typedelivery-2"  value="<?=Loc::getMessage('FAST_AUTO');?>">
                            <label class="form-check-label fs-5 fs-lg-3" for="typedelivery-2">
                                <?=Loc::getMessage('FAST_AUTO');?>
                            </label>
                        </div>
                        <p class="fs-6 fs-lg-5 text-dark ms-7"><?=Loc::getMessage('MORE_ABOUT');?> <a href="/helpful_info/delivery.php" target="_blank" class="link-secondary"><?=Loc::getMessage('ABOUT_TERMS_AND_PRICES');?></a></p>
                    </div>

                    <div class="mb-6">
                        <div class="form-check d-flex align-items-center mb-2">
                            <input class="form-check-input me-2" type="radio" name="typedelivery" id="typedelivery-3"  value="<?=Loc::getMessage('AUTO');?>">
                            <label class="form-check-label fs-5 fs-lg-3" for="typedelivery-3">
                                <?=Loc::getMessage('AUTO');?>
                            </label>
                        </div>
                        <p class="fs-6 fs-lg-5 text-dark ms-7"><?=Loc::getMessage('MORE_ABOUT');?> <a href="/helpful_info/delivery.php" target="_blank" class="link-secondary"><?=Loc::getMessage('ABOUT_TERMS_AND_PRICES');?></a></p>
                    </div>
                    
                </div>

                <div class="col-12 mt-2 mt-lg-7">
                    <h3 class="h2 mb-3 text-center text-lg-start"><?=Loc::getMessage('CARGO_INSURANCE');?></h3>
                    <p class="fs-5  text-dark mb-6"><?=Loc::getMessage('INSURANCE_DESCRIPTION');?> <a href="/helpful_info/delivery.php" class="link-secondary text-decoration-underline" target="_blank"><?=Loc::getMessage('IS_WRITTEN_HERE');?></a></p>
                    <div class="form-check d-flex align-items-center mb-7">
                        <input class="form-check-input me-2" type="checkbox" value="" id="insurance" checked >
                        <label class="form-check-label fs-lg-5 fs-6" for="insurance">
                            <?=Loc::getMessage('NEED_TO_INSURE?');?>
                        </label>
                    </div>

                    <p class="text-center mb-2 mb-lg-4 fs-lg-5 fs-6"><?=Loc::getMessage('CHECK_INFO');?>.</p>
                    <div class="d-flex justify-content-center">
                        <button id="continue-step-2" class="btn btn-primary btn-add-product w-100 w-sm-auto"><?=Loc::getMessage('CONTINUE');?></button>
                    </div>
                    <p id="all-fields-are-required" class="text-center mb-2 mb-lg-4 fs-lg-5 fs-6" style="color: red; display: none; margin-top: 10px;"><?=Loc::getMessage('ALL_FIELDS_ARE_REQUIRED');?>.</p>
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