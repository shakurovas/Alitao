<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Обработка персональных данных");

use \Bitrix\Main\Localization\Loc;
Loc::loadMessages(__FILE__);
?>
<main>        
    <article class="container text">
        <section class=" pt-7 mt-1 mb-8  ">
            <h1 class="h1 mb-5"><?=Loc::getMessage('PERSONAL_DATA_PROCESSING_TITLE');?></h1>
            <p><?=Loc::getMessage('PERSONAL_DATA_PROCESSING_DESCRIPTION');?></p>
        </section>
    
        <section class=" pt-2 mt-1 mb-8 ">
            <h2 class="h1 mb-5"><?=Loc::getMessage('COLLECTING_INFO');?></h2>
            <p><?=Loc::getMessage('WHAT_INFO_IS_COLLECTING');?></p>
            <ul class="list-style-disc">
                <li><span class="fs-lg-3 fs-5"><?=Loc::getMessage('NAME');?></span></li>
                <li><span class="fs-lg-3 fs-5"><?=Loc::getMessage('MAIL_ADDRESS');?></span></li>
                <li><span class="fs-lg-3 fs-5"><?=Loc::getMessage('EMAIL');?></span></li>
                <li><span class="fs-lg-3 fs-5"><?=Loc::getMessage('PHONE_NUMBER');?></span></li>
            </ul>
        </section>
    
        <section class=" pt-lg-2  mt-1 pb-10 mb-4 ">
            <h2 class="h1 mb-5"><?=Loc::getMessage('INFORMATION_USE');?></h2>
            <p><?=Loc::getMessage('WAYS_OF_INFO_USE');?>:</p>
            <ul class="list-style-disc">
                <li><span class="fs-lg-3 fs-5"><?=Loc::getMessage('USAGE');?></span></li>
            </ul>
            <p><?=Loc::getMessage('INFORMATION_DISCLOSURE_TITLE');?></p>
            <p><?=Loc::getMessage('INFORMATION_DISCLOSURE_TEXT');?>:</p>        
            <ul class="list-style-disc">            
                <li><span class="fs-lg-3 fs-5"><?=Loc::getMessage('INFORMATION_DISCLOSURE_REASON');?></span></li>
            </ul>
            <p><?=Loc::getMessage('ADDITIONAL_INFO_TITLE');?></p>
            <p><?=Loc::getMessage('ADDITIONAL_INFO_TEXT');?></p>
        </section>
    </article>
    

</main>

<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>
