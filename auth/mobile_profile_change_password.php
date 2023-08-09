<?php require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Вход в личный кабинет");

use \Bitrix\Main\Localization\Loc;
Loc::loadMessages(__FILE__);
?>

<main >

    <section class="container mobile-form-container pt-7 mt-1 pb-10  mb-4">

        <h1 class="h1 text-center mb-6"><?=Loc::getMessage('PASSWORD_CHANGE_TITLE');?></h1>
        

        <form action="/" data-target="desktop-change-password">

                
            <div class="mb-4" data-field="old_password">
              <label for="old-password" class="form-label"><?=Loc::getMessage('ENTER_OLD_PASSWORD');?></label>
              <input type="password" class="form-control" id="old-password" placeholder="<?=Loc::getMessage('ENTER_PASSWORD');?>" name="old_password" required>                     
            </div>
            <div class="mb-7" data-field="new_password">
              <label for="new-password" class="form-label"><?=Loc::getMessage('ENTER_NEW_PASSWORD');?></label>
              <input type="password" class="form-control" id="new-password" placeholder="<?=Loc::getMessage('ENTER_NEW_PASSWORD');?>" name="new_password" required>                     
            </div>
            <button class="btn btn-success fs-5 px-6 py-3 w-100"><?=Loc::getMessage('CHANGE_PASSWORD');?></button>
        </form>    
        
        
    </section>

</main>


<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>
