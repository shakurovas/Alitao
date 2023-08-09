<?php
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Вход в личный кабинет");

use \Bitrix\Main\Localization\Loc;
Loc::loadMessages(__FILE__);
?>

<main>
    
    <?php if (!$USER->IsAuthorized()):?>

        <section class="container mobile-form-container pt-7 mt-1 pb-10  mb-4">

            <h1 class="h1 text-center mb-6" ><?=Loc::getMessage('LOG_IN');?></h1>
            <p class="fs-5 text-center mb-6"><?=Loc::getMessage('ENTER_EMAIL_AND_PASSWORD_FOR_LOGIN');?></p>

            <?$APPLICATION->IncludeComponent("bitrix:system.auth.form", "alitao_login_form_mobile", Array(
                "REGISTER_URL" => "/",
                "FORGOT_PASSWORD_URL" => "/auth/mobile_change_password.php",
                "PROFILE_URL" => "/auth/personal.php",
                "SHOW_ERRORS" => "Y" 
                )
            );?>


            <hr class="text-gray my-7"/>
            <p class="text-center fs-4 py-4"><?=Loc::getMessage('OR');?></p>
            <a href="/auth/mobile_registration.php" class="fs-4 d-block w-100 text-center link-secondary"><?=Loc::getMessage('REGISTER_NEW_PROFILE');?></a>
                
            
        </section>

    <?php else:?>
        <section class="container pt-7 mt-1 pb-10 mb-4  text">
            <div class="cabinet"><?=Loc::getMessage('YOU_ARE_AUTHORIZED');?></div>
        </section>
    <?php endif;?>
</main>

<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>
