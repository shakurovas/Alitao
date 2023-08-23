<?php require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Вход в личный кабинет");
$APPLICATION->AddHeadString('<link rel="canonical" href="' . ((!empty($_SERVER['HTTPS'])) ? 'https' : 'http') . '://' . $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'] . '"/>');

use \Bitrix\Main\Localization\Loc;
Loc::loadMessages(__FILE__);
?>

<main>
    <section class="container mobile-form-container pt-7 mt-1 pb-10  mb-4">
        <h1 class="h1 text-center mb-6" ><?=Loc::getMessage('PASSWORD_CHANGE_TITLE');?></h1>
        

        <form action="/auth/mobile_change_password.php" data-target="desktop-reset-password">

            <!--Логин-->
            <input type="hidden" name="login" value="<?=$_GET['USER_LOGIN'];?>">
            <!--Контрольная строка-->
            <input type="hidden" name="checkword" value="<?=$_GET['USER_CHECKWORD'];?>">

            <div class="mb-4" data-field="password">
              <label for="recovery-password" class="form-label"><?=Loc::getMessage('NEW_PASSWORD');?></label>
              <input type="password" class="form-control" id="recovery-password" placeholder="<?=Loc::getMessage('ENTER_PASSWORD');?>" name="password" required>                     
            </div>
            <div class="mb-7" data-field="retype-password">
              <label for="recovery-password-2" class="form-label"><?=Loc::getMessage('PASSWORD');?></label>
              <input type="password" class="form-control" id="recovery-password-2" placeholder="<?=Loc::getMessage('REPEAT_PASSWORD');?>" name="retype" required>                     
            </div>
            <button class="btn btn-success fs-4 w-100"><?=Loc::getMessage('CHANGE');?></button>
        </form>   
    </section>

</main>


<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>
