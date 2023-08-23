<?php
CHTTP::SetStatus("404 Not Found");
@define("ERROR_404","Y");

require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("404 Страница не найдена");

use \Bitrix\Main\Localization\Loc;
Loc::loadMessages(__FILE__);
?>

<main>
	<section class="container pt-7 mt-1  pb-10 mb-4">
		<div class="d-flex justify-content-center mb-7">
			<div class="px-10">
				<img src="<?=SITE_TEMPLATE_PATH;?>/img/404.svg" alt="" class="img">
			</div>
		</div>
		<h1 class="text-secondary text-center mb-4 fs-2 fs-lg-1"><?=Loc::getMessage('PAGE_IS_NOT_FOUND_TITLE');?></h1>
		<p class="fw-bold fs-lg-3 fs-4 text-center"><?=Loc::getMessage('PAGE_IS_NOT_FOUND_TEXT');?></p>
	</section>
</main>

<?php require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>
