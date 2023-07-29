<?php require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Редактирование профиля");

use \Bitrix\Main\Localization\Loc;
use Bitrix\Main\Page\Asset;

Loc::loadMessages(__FILE__);

Asset::getInstance()->addJs("/auth/js/auth_script.js");
?>
<main>
    <?php
    if ($USER->IsAuthorized()):?>
        <?php
        $rsUser = CUser::GetByID($USER->GetID()); //получаем ID авторизованного пользователя и сразу же его поля
        $arUser = $rsUser->Fetch();
        ?>
        <section class="container pt-7 mt-1 pb-10 mb-4 text">
            <div class="cabinet">
                <nav class="cabinet__nav  fw-bold text-center text-md-start">
                    <ul>
                        <li>
                            <a href="/auth/personal.php" class="cabinet__nav-link active link-dark"><?=Loc::getMessage('MY_PROFILE');?></a>
                        </li>                
                        <li>
                            <a href="/order/my_orders.php" class="cabinet__nav-link  link-dark"><?=Loc::getMessage('MY_ORDERS');?></a>                
                        </li>
                        <li>
                            <a href="/order/history.php" class="cabinet__nav-link link-dark"><?=Loc::getMessage('HISTORY');?></a>                
                        </li>
                        <li>
                            <a href="/?logout=yes&<?=bitrix_sessid_get();?>" class="cabinet__nav-link link-dark"><?=Loc::getMessage('EXIT');?></a>                
                        </li>
                    </ul>
                    
                    
                </nav>

                <section class="cabinet__content">
                    <div class="user">
                        <div class="user__photo" style="display: flex; flex-direction: column; justify-content: flex-start;">
                            <?php if (!empty($arUser['PERSONAL_PHOTO'])):?>
                                <img src="<?=CFile::GetPath($arUser['PERSONAL_PHOTO']);?>" alt="" width="182" height="251">
                            <?php else:?>
                                <?=Loc::getMessage('NO_PHOTO_TEXT');?>
                            <?php endif;?>
                            <form class="fs-5" id="change-photo" action="/auth/personal.php" method="POST" enctype="multipart/form-data">
                                <input type="hidden" name="old_photo_id" value="<?php echo $arUser['PERSONAL_PHOTO']?>">
                                <input type="file" name="photo" accept="image/*" width="182" height="251" style="width: 100%; font-size: 10px; margin-top: 10px;">
                                <input type="submit" id="change-photo-btn" value="<?=GetMessage('CHANGE_PHOTO');?>" style="width: 100%; font-size: 10px; margin-top: 10px;">
                            </form>
                            <p style="font-size: 10px; margin-top: 10px;">
                                <?=GetMessage('TIME_FOR_PHOTO_UPDATE');?>
                            </p>
                        </div>
                        
                        <div class="user__data fs-3 text-dark">
                            
                            <p class="h2 fs-2 mb-8 mb-lg-3"><?=$USER->GetFullName();?></p>
                            
                            <div class="d-lg-none">
                                <div class="mb-2 d-xl-flex">
                                    <p class="fw-bold  mb-2 mb-xl-0 me-xl-2"><?=Loc::getMessage('FULL_NAME');?></p>
                                    <p><?=$arUser['LAST_NAME'] . ' ' . $arUser['NAME'] . ' ' . $arUser['SECOND_NAME'];?></p>
                                </div>
        
                                <div class="mb-2 d-xl-flex">
                                    <p class="fw-bold  mb-2 mb-xl-0 me-xl-2"><?=Loc::getMessage('REGION');?>:</p>
                                    <?php if (!empty($arUser['PERSONAL_STATE']) && !empty($arUser['PERSONAL_CITY'])):?>
                                        <p><?=$arUser['PERSONAL_STATE'] . ', ' . $arUser['PERSONAL_CITY'];?></p>
                                    <?php elseif (!empty($arUser['PERSONAL_STATE'])):?>
                                        <p><?=$arUser['PERSONAL_STATE'];?></p>
                                    <?php elseif (!empty($arUser['PERSONAL_CITY'])):?>
                                        <p><?=$arUser['PERSONAL_CITY'];?></p>
                                    <?php else:?>
                                        <p><?=Loc::getMessage('NO_INFO');?></p>
                                    <?php endif;?>
                                </div>
        
                                <div class="mb-2 d-xl-flex">
                                    <p class="fw-bold  mb-2 mb-xl-0 me-xl-2"><?=Loc::getMessage('ADDRESS');?>:</p>
                                    <?php if (!empty($arUser['PERSONAL_STREET']) && !empty($arUser['PERSONAL_ZIP'])):?>
                                        <p><?=$arUser['PERSONAL_STREET'];?> 28, <?=$arUser['PERSONAL_ZIP'];?>  </p>
                                    <?php elseif (!empty($arUser['PERSONAL_STREET'])):?>
                                        <p><?=$arUser['PERSONAL_STREET'];?></p>
                                    <?php elseif (!empty($arUser['PERSONAL_ZIP'])):?>
                                        <p><?=$arUser['PERSONAL_ZIP'];?>  </p>
                                    <?php else:?>
                                        <p><?=Loc::getMessage('NO_INFO');?></p>
                                    <?php endif;?>
                                </div>
        
                                <div class="mb-2 d-xl-flex">
                                    <p class="fw-bold  mb-2 mb-xl-0 me-xl-2"><?=Loc::getMessage('PHONE');?>:</p>
                                    <p><?=$arUser['PERSONAL_PHONE'];?></p>
                                    
                                </div>
        
                                <div class="mb-2 d-xl-flex">
                                    <p class="fw-bold  mb-2 mb-xl-0 me-xl-2"><?=Loc::getMessage('EMAIL');?>:</p>
                                    <p><?=$arUser['EMAIL'];?></p>
                                </div>
                                <div class="mb-2 d-xl-flex">
                                    <p class="fw-bold  mb-2 mb-xl-0 me-xl-2"><?=Loc::getMessage('MOSCOW_TIME_DIFFERENCE');?>:</p>
                                    <p><?=$arUser['UF_MOSCOW_TIME_DIFFERENCE'];?></p>
                                </div>
                            </div>
                            

                            
                            <div class="d-flex py-4 py-xl-2 mb-2 mb-lg-0">
                                <a class="btn btn-secondary me-4 px-xl-9" href="/auth/personal.php"><?=Loc::getMessage('EDIT');?></a>
                                <button id="change-password-btn" class="btn btn-outline-secondary px-xl-9 d-none d-md-inline-block" data-bs-toggle="modal" href="#changePassword" role="button"><?=Loc::getMessage('CHANGE_PASSWORD');?></button>
                                <a class="btn btn-outline-secondary d-md-none" href="/auth/mobile_change_password.php" ><?=Loc::getMessage('CHANGE_PASSWORD');?></a>
                            </div>

                            <!-- <form action="/auth/personal.php" class="fs-5"> -->
                            <form class="fs-5" id="save-changes-btn" action="/auth/personal.php" method="POST" onsubmit="return saveChanges();" enctype="multipart/form-data">
                                <!-- <input type="file" name="photo" accept="image/*"> -->
                                <div class="mb-4">
                                    <label for="nickname" class="form-label mb-0"><?=Loc::getMessage('NICK_OR_NAME');?></label>
                                    <input type="text" class="form-control py-2 py-1" id="nickname" placeholder="<?=Loc::getMessage('NICK_OR_NAME');?>" name="nickname" required value="<?=$arUser['UF_NICKNAME'];?>">                     
                                </div>

                                <div class="mb-4">
                                    <label for="fullname" class="form-label mb-0"><?=Loc::getMessage('YOUR_FULL_NAME');?></label>
                                    <input type="text" class="form-control py-2 py-1" id="fullname" placeholder="<?=Loc::getMessage('YOUR_FULL_NAME');?>" name="fullname" required value="<?=$arUser['LAST_NAME'] . ' ' . $arUser['NAME'] . ' ' . $arUser['SECOND_NAME'];?>">                     
                                </div>

                                <div class="row mb-4">
                                    <div class="col-12 col-lg-6 mb-4 mb-lg-0">
                                        <label for="region" class="form-label mb-0"><?=Loc::getMessage('REGION');?></label>
                                        <input type="text" class="form-control py-2 py-1" id="region" placeholder="<?=Loc::getMessage('REGION');?>" name="region" required value="<?=$arUser['PERSONAL_STATE'];?>">                     
                                    </div>
                                    <div class="col-12 col-lg-6">
                                        <label for="city" class="form-label mb-0"><?=Loc::getMessage('CITY');?></label>
                                        <input type="text" class="form-control py-2 py-1" id="city" placeholder="<?=Loc::getMessage('CITY');?>" name="city" required value="<?=$arUser['PERSONAL_CITY'];?>">                     
                                    </div>
                                </div>

                                <div class="row mb-4">
                                    <div class="col-12 col-lg-6 mb-4 mb-lg-0">
                                        <label for="address" class="form-label mb-0"><?=Loc::getMessage('FULL_ADDRESS');?></label>
                                        <input type="text" class="form-control py-2 py-1" id="address" placeholder="<?=Loc::getMessage('FULL_ADDRESS');?>" name="address" required value="<?=$arUser['PERSONAL_STREET'];?>">                     
                                    </div>
                                    <div class="col-12 col-lg-6">
                                        <label for="zipindex" class="form-label mb-0"><?=Loc::getMessage('POSTCODE');?></label>
                                        <input type="text" class="form-control py-2 py-1" id="zipindex" placeholder="<?=Loc::getMessage('POSTCODE');?>" name="zipindex" required value="<?=$arUser['PERSONAL_ZIP'];?>">                     
                                    </div>
                                </div>
                                <div class="row mb-4">
                                    <div class="col-12 col-lg-6 mb-4 mb-lg-0">
                                        <label for="phone" class="form-label mb-0"><?=Loc::getMessage('CONTACT_PHONE_NUMBER');?></label>
                                        <input type="tel" class="form-control py-2 py-1" id="phone" placeholder="<?=Loc::getMessage('CONTACT_PHONE_NUMBER');?>" name="phone" required value="<?=$arUser['PERSONAL_PHONE'];?>">                     
                                    </div>
                                    <div class="col-12 col-lg-6">
                                        <label for="email" class="form-label mb-0"><?=Loc::getMessage('EMAIL_ADDRESS');?></label>
                                        <input type="text" class="form-control py-2 py-1" id="email" placeholder="<?=Loc::getMessage('EMAIL_ADDRESS');?>" name="email" required value="<?=$arUser['EMAIL'];?>">                     
                                    </div>
                                </div>
                                <div class="row mb-7 mb-lg-6 mb-9 align-item-center">
                                    <div class="col-6 mb-7 mb-lg-0">
                                        <label for="?" class="form-label mb-0"><?=Loc::getMessage('MOSCOW_DIFFERENCE');?></label>
                                        <select class="form-select py-2" id="hours-difference">
                                            <option value="0" <?php echo ($arUser['UF_MOSCOW_TIME_DIFFERENCE'] == '0 ' . Loc::getMessage('HOURS_ENDING_OV')) ? 'selected' : '';?>>0 <?=Loc::getMessage('HOURS_ENDING_OV');?></option>
                                            <option value="1" <?php echo ($arUser['UF_MOSCOW_TIME_DIFFERENCE'] == '1 ' . Loc::getMessage('HOURS_WITHOUT_ENDING')) ? 'selected' : '';?>>1 <?=Loc::getMessage('HOURS_WITHOUT_ENDING');?></option>
                                            <option value="2" <?php echo ($arUser['UF_MOSCOW_TIME_DIFFERENCE'] == '2 ' . Loc::getMessage('HOURS_ENDING_A')) ? 'selected' : '';?>>2 <?=Loc::getMessage('HOURS_ENDING_A');?></option>
                                            <option value="3" <?php echo ($arUser['UF_MOSCOW_TIME_DIFFERENCE'] == '3 ' . Loc::getMessage('HOURS_ENDING_A')) ? 'selected' : '';?>>3 <?=Loc::getMessage('HOURS_ENDING_A');?></option>
                                            <option value="4" <?php echo ($arUser['UF_MOSCOW_TIME_DIFFERENCE'] == '4 ' . Loc::getMessage('HOURS_ENDING_A')) ? 'selected' : '';?>>4 <?=Loc::getMessage('HOURS_ENDING_A');?></option>
                                            <option value="5" <?php echo ($arUser['UF_MOSCOW_TIME_DIFFERENCE'] == '5 ' . Loc::getMessage('HOURS_ENDING_OV')) ? 'selected' : '';?>>5 <?=Loc::getMessage('HOURS_ENDING_OV');?></option>
                                            <option value="6" <?php echo ($arUser['UF_MOSCOW_TIME_DIFFERENCE'] == '6 ' . Loc::getMessage('HOURS_ENDING_OV')) ? 'selected' : '';?>>6 <?=Loc::getMessage('HOURS_ENDING_OV');?></option>
                                            <option value="7" <?php echo ($arUser['UF_MOSCOW_TIME_DIFFERENCE'] == '7 ' . Loc::getMessage('HOURS_ENDING_OV')) ? 'selected' : '';?>>7 <?=Loc::getMessage('HOURS_ENDING_OV');?></option>
                                            <option value="8" <?php echo ($arUser['UF_MOSCOW_TIME_DIFFERENCE'] == '8 ' . Loc::getMessage('HOURS_ENDING_OV')) ? 'selected' : '';?>>8 <?=Loc::getMessage('HOURS_ENDING_OV');?></option>
                                            <option value="9" <?php echo ($arUser['UF_MOSCOW_TIME_DIFFERENCE'] == '9 ' . Loc::getMessage('HOURS_ENDING_OV')) ? 'selected' : '';?>>9 <?=Loc::getMessage('HOURS_ENDING_OV');?></option>
                                            
                                        </select>                
                                    </div>
                                    <div class="col-12 col-lg-6 d-flex align-item-center">
                                        <div class="form-check d-flex align-items-center">
                                            <input class="form-check-input me-2" type="checkbox" value="alert" id="alert" <?php echo $arUser['UF_NOTIFY_ABOUT_ORDERS'] ? 'CHECKED' : '';?>>
                                            <label class="form-check-label fs-5" for="alert">
                                                <?=Loc::getMessage('NOTIFY_ABOUT_ORDERS');?>
                                            </label>
                                        </div>                  
                                    </div>
                                </div>

                                <!-- <div style="color: #FF6948; margin-bottom: 15px;">
                                    Изменения будут применены в течение нескольких секунд           
                                </div>  -->

                                <button id="save-profile-changes-btn" class="btn btn-primary w-100 w-lg-auto fs-4 fs-lg-5"><?=Loc::getMessage('SAVE_CHANGES_BTN');?></button>
                            </form>

                            
                        </div>
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