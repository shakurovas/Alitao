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

$this->addExternalJS("/local/components/alitao/main.register/templates/alitao_registration_mobile/js/script.js");

if($arResult["SHOW_SMS_FIELD"] == true)
{
	CJSCore::Init('phone_auth');
}

?>


<form method="POST" action="<?=POST_FORM_ACTION_URI;?>" name="regform" data-target="desktop-sing-up" enctype="multipart/form-data">
	
	<?php if($arResult["BACKURL"] <> ''):?>
		<input type="hidden" name="backurl" value="<?=$arResult["BACKURL"]?>" />
	<?php endif;?>
	
	<div class="mb-5" data-field="register_login">
		<label for="sing-in-email" class="form-label"><?=GetMessage('EMAIL');?></label>
		<input type="email" class="form-control" id="register-email" placeholder="<?=GetMessage('ENTER_EMAIL');?>" name="REGISTER[EMAIL]" required>                    
	</div>
	
	<div class="mb-9" data-field="register_password">
		<label for="sing-in-password" class="form-label"><?=GetMessage('PASSWORD');?></label>
		<input type="password" class="form-control" id="register-password" placeholder="<?=GetMessage('ENTER_PASSWORD');?>" name="REGISTER[PASSWORD]" required>                     
	</div>

	<div class="form-check d-flex align-items-center mb-7">
		<input class="form-check-input me-2 agree-checkbox-mobile" type="checkbox" value="" id="approve-ppd" checked data-target-btn="#sing-up-btn">
		<label class="form-check-label fs-very-small" for="approve-ppd">
		<?=GetMessage('I_AGREE');?> <a class="link-secondary" href="/personal_data_processing/" target="_blank"><?=GetMessage('AGREE_FOR_DATA_PROCESSING');?></a>
		</label>
	</div>

	<input type="hidden" name="register_submit_button" value="<?=GetMessage('REGISTER');?>" />
	<button type="submit" class="btn btn-success fs-4 w-100 mb-6 sign-up-button-mobile" id="sing-up-btn"><?=GetMessage('REGISTER');?></button>


	<a href="/auth/mobile_authorization.php" class="fs-4 d-block w-100 text-center link-secondary"><?=GetMessage('I_ALREADY_HAVE_A_PROFILE');?></a>
</form>
