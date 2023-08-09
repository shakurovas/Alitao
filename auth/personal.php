<?php
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");

$APPLICATION->SetTitle("Профиль пользователя");

use \Bitrix\Main\Localization\Loc;
Loc::loadMessages(__FILE__);

if ($USER->IsAuthorized()) {
    $rsUser = CUser::GetByID($USER->GetID());  // получаем ID авторизованного пользователя и сразу же его поля
    $arUser = $rsUser->Fetch();
}
?>

<main>
    <?php if ($USER->IsAuthorized()):?>
        <section class="container pt-7 mt-1 pb-10 mb-4  text">
            <div class="cabinet">
                <nav class="cabinet__nav  fw-bold text-center text-md-start">
                    <ul>
                        <li>
                            <a href="/auth/personal.php" class="cabinet__nav-link active link-dark"><?=Loc::getMessage('MY_PROFILE');?></a>
                        </li>                
                        <li>
                            <a href="/order/my_orders.php" class="cabinet__nav-link link-dark"><?=Loc::getMessage('MY_ORDERS');?></a>                
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
                        <div class="user__photo">
                            <?php if (!empty($arUser['PERSONAL_PHOTO'])):?>
                                <img src="<?=CFile::GetPath($arUser['PERSONAL_PHOTO']);?>" alt="" width="182" height="251">
                            <?php else:?>
                                <img src="<?=SITE_TEMPLATE_PATH;?>/img/no-user.png" alt="" width="182" height="251">
                            <?php endif;?>
                        </div>
                        <div class="user__data fs-3 text-dark">
                            <p class="h2 fs-2 mb-8 mb-lg-6">
                                <?php if (!empty($arUser['UF_NICKNAME'])) {
                                    echo $arUser['UF_NICKNAME'];
                                } else {
                                    echo Loc::getMessage('ENTER_YOUR_DATA');
                                }?>
                            </p>
                            
                            <div class="mb-2 d-xl-flex">
                                <p class="fw-bold  mb-2 mb-xl-0 me-xl-2"><?=Loc::getMessage('FULL_NAME');?>:</p>
                                <p>
                                    <?php if ($arUser['LAST_NAME'] && $arUser['NAME'] && $arUser['SECOND_NAME']) {
                                        echo $arUser['LAST_NAME'] . ' ' . $arUser['NAME'] . ' ' . $arUser['SECOND_NAME'];
                                    } else {
                                        echo Loc::getMessage('NO_INFO');
                                    }?>
                                </p>
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
                                    <p><?=$arUser['PERSONAL_STREET'];?>, <?=$arUser['PERSONAL_ZIP'];?>  </p>
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
                                <p>
                                    <?php if ($arUser['PERSONAL_PHONE']) {
                                        echo phoneFormat(trim($arUser['PERSONAL_PHONE']));
                                    } else {
                                        echo Loc::getMessage('NO_INFO');
                                    }?>
                                </p>
                                
                            </div>

                            <div class="mb-2 d-xl-flex">
                                <p class="fw-bold  mb-2 mb-xl-0 me-xl-2"><?=Loc::getMessage('EMAIL');?>:</p>
                                <p><?=$arUser['EMAIL'];?></p>
                            </div>
                            <div class="mb-2 d-xl-flex">
                                <p class="fw-bold  mb-2 mb-xl-0 me-xl-2"><?=Loc::getMessage('MOSCOW_TIME_DIFFERENCE');?>:</p>
                                <p>
                                    <?php if ($arUser['UF_MOSCOW_TIME_DIFFERENCE']) {
                                        echo $arUser['UF_MOSCOW_TIME_DIFFERENCE'];
                                    } else {
                                        echo Loc::getMessage('NO_INFO');
                                    }?>
                                </p>
                            </div>

                            <div class="d-flex py-4 py-xl-2">
                                <a class="btn btn-outline-secondary me-4 px-xl-9" href="/auth/profile_edit.php"><?=Loc::getMessage('EDIT');?></a>
                                <button class="btn btn-outline-secondary px-xl-9 d-none d-md-inline-block" data-bs-toggle="modal" href="#changePassword" role="button"><?=Loc::getMessage('CHANGE_PASSWORD');?></button>
                                <a class="btn btn-outline-secondary d-md-none" href="/auth/mobile_profile_change_password.php"><?=Loc::getMessage('CHANGE_PASSWORD');?></a>
                            </div>
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
