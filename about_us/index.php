<?php require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetPageProperty("title", "О нас | Alitao.shop");
$APPLICATION->SetPageProperty("description", "Alitao.shop - Ваш надежный партнер по покупке и доставке товаров из Китая. Узнайте больше о нашей истории и том, как мы помогаем нашим клиентам.");
$APPLICATION->SetTitle("О нас");
$APPLICATION->AddHeadString('<link rel="canonical" href="' . ((!empty($_SERVER['HTTPS'])) ? 'https' : 'http') . '://' . $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'] . '"/>');

use \Bitrix\Main\Localization\Loc;
Loc::loadMessages(__FILE__);
?>
<main>
        <article class="container pt-4 mt-1 pb-10 mb-4 text">
            <section class="py-lg-6 py-4">
                <h1 class="h1 mb-4 mb-lg-6"><?=Loc::getMessage('OUR_SERVICES_TITLE');?></h1>
                <?$APPLICATION->IncludeComponent(
                    "bitrix:main.include", 
                    ".default", 
                    array(
                        "AREA_FILE_SHOW" => "file",
                        "AREA_FILE_SUFFIX" => "inc",
                        "AREA_FILE_RECURSIVE" => "Y",
                        "EDIT_TEMPLATE" => "",
                        "COMPONENT_TEMPLATE" => ".default",
                        "PATH" => "/include/services_description.php"
                    ),
                    false
                );?>
            </section>

            <section class="py-lg-6 py-4">
                <h2 class="h1 mb-4 mb-lg-6"><?=Loc::getMessage('AREAS_OF_WORK');?></h2>
                <ul class="list-style-disc">
                    <li><span class="fs-lg-3 fs-5"><?=Loc::getMessage('WORK_AREA_1');?></span></li>
                    <li><span class="fs-lg-3 fs-5"> <?=Loc::getMessage('WORK_AREA_2');?></span></li>
                    <li><span class="fs-lg-3 fs-5"><?=Loc::getMessage('WORK_AREA_3');?></span></li>
                    <li><span class="fs-lg-3 fs-5"><?=Loc::getMessage('WORK_AREA_4');?></span></li>
                    <li><span class="fs-lg-3 fs-5"><?=Loc::getMessage('WORK_AREA_5');?></span></li>
                </ul>
            </section>

            <section class="py-lg-6 py-4">
                <h2 class="h1 mb-4 mb-lg-6"><?=Loc::getMessage('WHY_CHOOSE_US_TITLE');?></h2>
                <p class="mb-5 mb-lg-7"><?=Loc::getMessage('REASON_1');?></p>
                <p class="mb-5 mb-lg-7"><?=Loc::getMessage('REASON_2');?></p>
                <p><?=Loc::getMessage('REASON_3_1');?></p>
                <p><?=Loc::getMessage('REASON_3_2');?></p>
            </section>


            <section class="py-lg-6 py-4">
                <h2 class="h1 mb-4 mb-lg-6"><?=Loc::getMessage('PURCHASE_OF_GOODS_TITLE');?></h2>
                <p><?=Loc::getMessage('PURCHASE_OF_GOODS_TEXT_1');?></p>
                <p><?=Loc::getMessage('PURCHASE_OF_GOODS_TEXT_2');?></p>
            </section>
            <section class="py-lg-6 py-4">
                <h2 class="h1 mb-4 mb-lg-6"><?=Loc::getMessage('ORDERING_SCHEME_TITLE');?>:</h2>

                <ul class="text-primary">
                    <li class="d-flex align-items-center mb-4">
                        <span class="big-num me-4">01</span>
                        <p class="fs-5 fs-lg-2 text-for-big-num"><?=Loc::getMessage('STEP_1');?></p>
                    </li>
                    <li class="d-flex align-items-center mb-4">
                        <span class="big-num me-4">02</span>
                        <p class="fs-5 fs-lg-2 text-for-big-num"><?=Loc::getMessage('STEP_2');?> </p>
                    </li>
                    <li class="d-flex align-items-center">
                        <span class="big-num me-4">03</span>
                        <p class="fs-5 fs-lg-2 text-for-big-num"><?=Loc::getMessage('STEP_3');?></p>
                    </li>
                </ul>
            </section>


            <section class="py-lg-6 py-4">
                <h2 class="h1 mb-4 mb-lg-6"><?=Loc::getMessage('OUR_DOCUMENTS_TITLE');?></h2>

                <div class="our-docs">
                    <div>
                        <img src="<?=SITE_TEMPLATE_PATH;?>/img/about-us/1.png" alt="" class="img">
                    </div>
                    <div>
                        <img src="<?=SITE_TEMPLATE_PATH;?>/img/about-us/2.png" alt="" class="img">
                    </div>
                </div>
            </section>

            <section class="py-lg-6 py-4">
                <h2 class="h1 mb-4 mb-lg-6"><?=Loc::getMessage('MORE_QUESTIONS?');?></h2>
                <p class="mb-4 mb-lg-6"><?=Loc::getMessage('ASK_MANAGERS_QUESTIONS');?></p>

                <button class="btn btn-primary fs-lg-3 fs-4 w-100 w-sm-auto d-none d-lg-inline-block" data-bs-toggle="modal" href="#sendQuestion" role="button"><?=Loc::getMessage('ASK_THE_QUESTION');?></button>
                <a class="btn btn-primary fs-lg-3 fs-4 w-100 w-sm-auto d-lg-none"  href="/mobile-send-question.html"><?=Loc::getMessage('ASK_THE_QUESTION');?></a>
            </section>
        </article>
    </main>

<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>