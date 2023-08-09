<?php
define('STOP_STATISTICS', true);
require_once($_SERVER['DOCUMENT_ROOT'].'/bitrix/modules/main/include/prolog_before.php');
$APPLICATION->RestartBuffer();

$moscowTimeZone = 'Europe/Moscow';
$pekingTimeZone = 'Asia/Hong_Kong'; // для Пекина отдельно нет
$timestamp = time();
$dtMoscow = new DateTime("now", new DateTimeZone($moscowTimeZone)); 
$dtPeking = new DateTime("now", new DateTimeZone($pekingTimeZone)); 
$dtMoscow->setTimestamp($timestamp);
$dtPeking->setTimestamp($timestamp);

echo json_encode(['moscow_time' => $dtMoscow->format('H:i'), 'peking_time' => $dtPeking->format('H:i')]);


die();
