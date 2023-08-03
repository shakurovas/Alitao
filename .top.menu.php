<?
// если страница открыта в мобильной версии
$isMobile = preg_match("/(android|avantgo|blackberry|bolt|boost|cricket|docomo|fone|hiptop|mini|mobi|palm|phone|pie|tablet|up\.browser|up\.link|webos|wos)/i", $_SERVER["HTTP_USER_AGENT"]);
if ($isMobile) $makeOrderPage = '/order/mobile_add_edit_order.php';
else $makeOrderPage = '/order/make_order_step_1.php';

$aMenuLinks = Array(
	Array(
		"Сделать заказ", 
		$makeOrderPage, 
		Array(), 
		Array(), 
		"" 
	),
	Array(
		"О нас", 
		"/about_us/", 
		Array(), 
		Array(), 
		"" 
	),
	Array(
		"Помощь", 
		"/index.php#help", 
		Array(), 
		Array(), 
		"" 
	),
	Array(
		"Условия", 
		"/terms/", 
		Array(), 
		Array(), 
		"" 
	),
	Array(
		"Вопросы и ответы", 
		"/index.php#faq", 
		Array(), 
		Array(), 
		"" 
	),
	Array(
		"Оплата", 
		"/helpful_info/payment.php", 
		Array(), 
		Array(), 
		"" 
	),
	Array(
		"Доставка", 
		"/helpful_info/delivery.php", 
		Array(), 
		Array(), 
		"" 
	)
);
?>