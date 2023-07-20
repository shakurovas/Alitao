<?
/**
 * Bitrix Framework
 * @package bitrix
 * @subpackage main
 * @copyright 2001-2014 Bitrix
 */

/**
 * Bitrix vars
 * @global CMain $APPLICATION
 * @global CUser $USER
 * @param array $arParams
 * @param array $arResult
 * @param CBitrixComponentTemplate $this
 */

if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)
	die();

IncludeTemplateLangFile(__FILE__);

if($arResult["SHOW_SMS_FIELD"] == true)
{
	CJSCore::Init('phone_auth');
}

// echo '<pre>';
// print_r($arResult);
// echo '</pre>';
// echo POST_FORM_ACTION_URI;
?>


<!-- <form action="/" data-target="desktop-sing-up"> -->
<form method="POST" action="<?=POST_FORM_ACTION_URI;?>" name="regform" data-target="desktop-sing-up" enctype="multipart/form-data">
	
	<?php if($arResult["BACKURL"] <> ''):?>
		<input type="hidden" name="backurl" value="<?=$arResult["BACKURL"]?>" />
	<?php endif;?>
	
	<div class="mb-4" data-field="register_login">
		<label for="sing-in-email" class="form-label"><?=GetMessage('EMAIL');?></label>
		<input type="email" class="form-control" id="register-email" placeholder="<?=GetMessage('ENTER_EMAIL');?>" name="REGISTER[EMAIL]" required>                    
	</div>
	
	<div class="mb-7" data-field="register_password">
		<label for="sing-in-password" class="form-label"><?=GetMessage('PASSWORD');?></label>
		<input type="password" class="form-control" id="register-password" placeholder="<?=GetMessage('ENTER_PASSWORD');?>" name="REGISTER[PASSWORD]" required>                     
	</div>

	<div class="form-check d-flex align-items-center mb-7">
		<input class="form-check-input me-2" type="checkbox" value="" id="approve-ppd" checked data-target-btn="#sing-up-btn" name="agreement">
		<label class="form-check-label fs-6" for="approve-ppd">
			<?=GetMessage('I_AGREE');?> <a class="link-secondary" href="/personal_data_processing/" target="_blank"><?=GetMessage('PROCESSING_OF_PERSONAL_DATA');?></a>
		</label>
	</div>

	<div class="d-flex justify-content-between align-items-center">
		<input type="hidden" name="register_submit_button" value="<?=GetMessage('REGISTER');?>" />
		<button type="submit" class="btn btn-success fs-5 px-1 py-3" id="sing-up-btn"><?=GetMessage('REGISTER');?></button>
		<span class="fs-5 d-inline-block link-secondary " data-bs-target="#singInModal" data-bs-toggle="modal" data-bs-dismiss="modal"><?=GetMessage('I_ALREADY_HAVE_A_PROFILE');?></span>
	</div>
</form>




