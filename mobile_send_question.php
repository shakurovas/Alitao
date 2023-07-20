<?php
require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/header.php");
$APPLICATION->SetTitle("Задать вопрос");

use \Bitrix\Main\Localization\Loc;
Loc::loadMessages(__FILE__);
?>

<main>
    <section class="container mobile-form-container pt-7 mt-1 pb-10  mb-4">
        <h1 class="h1 text-center mb-6" ><?=Loc::getMessage('MORE_QUESTIONS?');?></h1>
        <p class="fs-5 text-center mb-6"><?=Loc::getMessage('LEAVE_A_REQUEST');?></p>
        <form action="/" data-target="desktop-send-question" class="mb-4">
            <div class="mb-6" data-field="name">
                <label for="sq-name" class="form-label"><?=Loc::getMessage('NAME');?></label>
                <input type="text" class="form-control" id="sq-name" placeholder="<?=Loc::getMessage('YOUR_NAME');?>" name="name" required>                    
            </div>

            <div class="mb-6" data-field="contact">
                <label for="sq-contact" class="form-label"><?=Loc::getMessage('CONTACT');?></label>
                <input type="text" class="form-control" id="sq-contact" placeholder="<?=Loc::getMessage('CONTACT');?>" name="contact" required>                     
            </div>
            <div class="mb-8" data-field="question">
              <label for="sq-message" class="form-label"><?=Loc::getMessage('ENTER_THE_MESSAGE');?></label>
              <textarea class="form-control" id="sq-message" rows="8" placeholder="<?=Loc::getMessage('ENTER_THE_MESSAGE');?>е" name="message"></textarea>
            </div>


            
            <div class="d-flex justify-content-center ">
                <button class="btn btn-primary fs-4 px-9 w-100 py-2"><?=Loc::getMessage('SEND');?></button>
            </div>
        </form>  
    </section>

</main>

<?require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/footer.php");?>