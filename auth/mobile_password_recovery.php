<?php require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Вход в личный кабинет");

use \Bitrix\Main\Localization\Loc;
Loc::loadMessages(__FILE__);
?>

<main>
    <section class="container mobile-form-container pt-7 mt-1 pb-10  mb-4">
        <h1 class="h1 text-center mb-6" ><?=Loc::getMessage('PASSWORD_RECOVERY_TITLE');?></h1>
        <p class="fs-5 text-center mb-6"><?=Loc::getMessage('ENTER_EMAIL_PHRASE');?>.</p>

        <form action="/" data-target="desktop-recovery" class="mb-7">
            <div class="mb-9" data-field="login">
                <label for="sing-in-email" class="form-label"><?=Loc::getMessage('EMAIL');?></label>
                <input type="email" class="form-control" id="sing-in-email" placeholder="<?=Loc::getMessage('ENTER_EMAIL');?>" name="login" required>                    
            </div>                
                       
            <button class="btn btn-success fs-4 w-100 mb-6"><?=Loc::getMessage('RECOVER');?></button>


            <a class="fs-4 d-block w-100 text-center link-secondary" href="/auth/mobile_authorization.php"><?=Loc::getMessage('I_HAVE_REMEMBERED_PASSWORD');?></a>
        </form>
        <hr class="text-gray my-7"/>
        <p class="text-center fs-4 py-4"><?=Loc::getMessage('OR');?></p>
        <a href="/auth/mobile_registration.php" class="fs-4 d-block w-100 text-center link-secondary"><?=Loc::getMessage('REGISTER_NEW_PROFILE');?></a>
    </section>

</main>


<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>
