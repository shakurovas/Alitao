<?php
define('STOP_STATISTICS', true);
require_once($_SERVER['DOCUMENT_ROOT'].'/bitrix/modules/main/include/prolog_before.php');
$APPLICATION->RestartBuffer();

// echo (json_encode($_POST));
$_POST['name'] = strip_tags($_POST['name']);
$_POST['contact'] = strip_tags($_POST['contact']);
$_POST['question'] = strip_tags($_POST['question']);

if (isset($_POST['name']) && !empty($_POST['name']) && isset($_POST['contact']) && !empty($_POST['contact']) && isset($_POST['question']) && !empty($_POST['question'])) {
    
    CModule::IncludeModule('iblock');
    $el = new \CIBlockElement;

    // ищем id инфоблока с вопросами от пользователей
    $arrFilter = array(
        'ACTIVE' => 'Y',
        'CODE' => 'questions',
        'SITE_ID' => "s1",
    );

    $res = CIBlock::GetList(Array("SORT" => "ASC"), $arrFilter, false);

    if ($arRes = $res->Fetch()) {
        $questionsIblockId = $arRes["ID"];
    }

    // добавляем новый элемент в инфоблок с вопросами  от пользователей
    $elemProps = array(
        "NAME" => $_POST['name'],
        "CONTACT" => $_POST['contact'],
        "MESSAGE" => $_POST['question']
    );

    $elArray = Array(
        "ACTIVE_FROM" => date('d.m.Y H:i:s'),
        "IBLOCK_ID" => $questionsIblockId,
        "PROPERTY_VALUES" => $elemProps,
        "NAME" => 'Новый вопрос',
        "ACTIVE" => "Y",
        // "MODIFIED_BY" => 1,
    );

    if($elemId = $el->Add($elArray)) {

        // отсылаем администратору письмо на почту
        $arEventFields = array(
            'USER_TO' => COption::GetOptionString('main', 'email_from', 'shakurovas@bk.ru'),  // дефолтный email из настроек
            "NAME" => $_POST['name'],
            "CONTACT" => $_POST['contact'],
            "QUESTION" => $_POST['question'],
            'SUBJECT' => 'Новый вопрос'
        );
        
        CEvent::Send('NEW_QUESTION', 's1', $arEventFields, 'N');

        // выводим информацию пользователю о том, что всё прошло вспешно:)
        echo json_encode(
            [
                'question' => [
                    'state' => 'success',
                    'message' => "Вопрос отправлен. Мы скоро с вами свяжемся"
                ]
            ]
        );
    } else
        echo json_encode(
            [
                'question' => [
                    'state' => 'error',
                    'message' => $elemId->LAST_ERROR
                ]
            ]
        );

} else {
    echo json_encode(
        [
            'question' => [
                'state' => 'error',
                'message' => "Заполните все поля"
            ]
        ]
    );
}


die();