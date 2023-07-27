<?php
define('STOP_STATISTICS', true);
require_once($_SERVER['DOCUMENT_ROOT'].'/bitrix/modules/main/include/prolog_before.php');
use \Bitrix\Main\Localization\Loc;

$APPLICATION->RestartBuffer();

session_start();

foreach ($_POST as $key) {
    $_POST[$key] = strip_tags($_POST[$key]);
}

// echo json_encode($_POST);

if (isset ($_POST['link']) && !empty($_POST['link'])) {

    // $arFields = [];  // массив полей изображения

    // // проверяем есть ли загруженные фото
    // if ($_FILES['product_photo']['error'] == '1'){
    //     echo '<script>alert("Изображение слишком большое или слишком маленькое. Попробуйте загрузить другое.");</script>';
    // }
    // // если есть вложение
    // if (isset($_FILES['product_photo']) && !empty($_FILES['product_photo']['tmp_name'])) {
    //     // проверяем расширение (что это картинка):
    //     if (strpos($_FILES['photo']['type'], 'image') !== false){
    //         // закачиваем файл в /upload/users_pics
    //         $name = $_FILES['photo']['name'];
    //         $uploads_dir = $_SERVER['DOCUMENT_ROOT'].'/upload/users_pics';
    //         $isMoved = move_uploaded_file($_FILES['photo']['tmp_name'], "$uploads_dir/$name");
    //         if ($isMoved){
    //             // если всё ок:
    //             $user = new CUser;
    //             $arFields = [];

    //             // $fileId = CFile::SaveFile($_FILES["personal-photo"],'avatar');
    //             $arFile = CFile::MakeFileArray($_SERVER["DOCUMENT_ROOT"]."/upload/users_pics/".$name);
    //             $arFile['del'] = "Y";
    //             $arFile['old_file'] = $_POST['old_photo_id'];
    //             $arFields['PERSONAL_PHOTO'] = $arFile;

    //             $result = $user->Update($USER->GetID(), $arFields);

    //             // удаляем временный файл:
    //             unlink ($uploads_dir."/".$name);
    //         } else {
    //             echo 'ERROR_FILE_MOVED';
    //         }
    //     }else{
    //         echo 'INVALID_FILE_TYPE';
    //     }
    // } else if (isset($_FILES['photo']) && empty($_FILES['photo']['tmp_name'])) {
    //     echo 'NO_PHOTO_ADDED';
    // } else {
    //     echo 'SOMETHING_WENT_WRONG';
    // }
    
    $_SESSION['cart'][$_POST['link']] = [
        'name' => $_POST['name'],
        'price' => $_POST['price'],
        'quantity' => $_POST['quantity'],
        'colour' => $_POST['colour'],
        'size' => $_POST['size'],
        'delivery_through_china' => $_POST['delivery_cost'],
        'comment' => $_POST['comment'],
        // 'photo' => $_POST['delivery_cost'],
        'photo_report_is_needed' => (int)$_POST['photoreport']
    ];
}

$goodsString = '';

if (count($_SESSION['cart']) == 1) {
    $goodsString .= '<div class="order-list py-4 py-lg-9" id="goods-list">';
}

$sumRub = 0;
foreach ($_SESSION['cart'] as $link => $props){
    $goodsString .= '
    <div class="mo-order">
        <div class="mo-order__description">
            <div class="mo-order__img-block me-2 flex-shrink-0">
                <img src="' . SITE_TEMPLATE_PATH . '/img/products/1.jpg" alt="" class="mo-order__img" width="100" height="100">
            </div>
            <div class="mo-order__text-block flex-grow-1">
                <div class="mb-1 fs-5 mb-lg-0"><a href="' . $link. '" class="link-of-good link-secondary text-decoration-underline fs-5" data-target-field="product_name">' . $props['name']. '</a></div>
                

                <div class="d-inline-flex flex-wrap mb-2">
                    <div class="order-tag me-2">
                        <div class="order-tag__char bg-dark text-white">' . Loc::getMessage('COLOUR'). '</div>
                        <div class="order-tag__value bg-secondary text-white" data-target-field="product_color">'; if ($props['colour']) $colour = $props['colour']; else $colour = Loc::getMessage('NOT_SPECIFIED'); $goodsString .= $colour . '</div>
                    </div>

                    <div class="order-tag me-2">
                        <div class="order-tag__char bg-dark text-white">' . Loc::getMessage('SIZE'). '</div>
                        <div class="order-tag__value bg-secondary text-white" data-target-field="product_size">'; if ($props['size']) $size = $props['size']; else $size = Loc::getMessage('NOT_SPECIFIED'); $goodsString .= $size . '</div>
                    </div>
                </div>

                <p class="text text-gray" data-target-field="product_comment">' . $props['comment'] . ' </p>
            </div>
        </div>

        <div class=" mo-order__price-table-wrap">
            <div class="mo-order__widget-wrap">
                <div class="inc-widget vertical">
                    <div data-rate="' . $_SESSION['cnyRate'] . '" data-price="' . $props['price'] . '" class="inc-widget__btn inc plus-cost-calc-list"></div>
                    <input type="tel" class="inc-widget__input product-qty-list" name="product_qty" min="1" value="' . $props['quantity'] . '" data-cross-field="product_price" data-calc="data-price-calc">
                    <div data-rate="' . $_SESSION['cnyRate'] . '" data-price="' . $props['price'] . '" class="inc-widget__btn dec minus-cost-calc-list"></div>
                </div>
            </div>
            <div class="mo-order__price-table text-dark flex-grow-1">
            

                
                <div>
                    <div class="fw-bold mb-2">
                        ' . Loc::getMessage('SUMMATION'). '
                    </div>
                    <div class=" mb-2 text-secondary" >
                        '; $cost = number_format($props['quantity'] * $props['price'], 2, '.', ' '); $goodsString .= '
                        ¥ <span class="product-cost-yuan-list" data-target-field="product_price">' . $cost . '</span>
                    </div>
                    <div class="text-dark d-none d-lg-block product-cost-rub-list">
                        ₽ ' . number_format($cost * $_SESSION['cnyRate'], 2, '.', ' ') . '
                    </div>
                </div>

                <div>
                    <div class="fw-bold mb-2">
                        ' . Loc::getMessage('DELIVERY') . '
                    </div>
                    <div class=" mb-2 text-secondary" >
                        '; $deliveryCost = number_format((float)$props['delivery_through_china'], 2, '.', ' '); $goodsString .= '
                        ¥ <span data-target-field="delivery_price" class="delivery-cost-yuan-list">' . $deliveryCost . '</span>
                    </div>
                    <div class="text-dark d-none d-lg-block delivery-cost-rub-list">
                        ₽ ' . $deliveryCost * $_SESSION['cnyRate'] . '
                    </div>
                </div>

                <div>
                    <div class="fw-bold mb-2">
                        ' . Loc::getMessage('SERVICES') . '
                    </div>
                    <div class=" mb-2 text-secondary services-cost-yuan-list">
                        ¥ '; if ($props['photo_report_is_needed']) $services = 5.00; else $services = 0.00;
                        $goodsString .= $services . '
                    </div>
                    <div class="text-dark d-none d-lg-block services-cost-rub-list">
                        ₽ ' . $services * $_SESSION['cnyRate']. '
                    </div>
                </div>
                
                <div>
                    <div class="fw-bold mb-2">
                        ' . Loc::getMessage('TOTAL'). '
                    </div>
                    ';
                    $totalCostYuan = $cost + $deliveryCost + $services;
                    $totalCostRub = $totalCostYuan * $_SESSION['cnyRate'];
                    $sumRub .= $totalCostRub;
                    $goodsString .= '
                    <div class="text-success d-lg-none" >
                        <span class="total-cost-yuan-list-none">¥ ' . $totalCostYuan. '</span> <span class="total-cost-rub-list-none">( ₽ ' . $totalCostRub. ' )</span>
                    </div>
                    <div class=" mb-2 text-secondary d-none d-lg-block total-cost-yuan-list">
                        ¥ ' . number_format($totalCostYuan, 2, '.', ' '). '
                    </div>
                    <div class="text-success d-none d-lg-block total-cost-rub-list">
                        ₽ ' . number_format($totalCostRub, 2, '.', ' '). '
                    </div>
                </div>

                
            </div>
        </div>
        

        <div class="mo-order__controls-col ">
            
            <button class="mo-order__remove mb-3">
                <img src="' . SITE_TEMPLATE_PATH. '/img/icons/remove.svg" alt="">
            </button>

            <button class="mo-order__edit" data-bs-toggle="modal" href="#makeOrderModal" role="button">
                <img src="' . SITE_TEMPLATE_PATH. '/img/icons/edit.svg" alt="">
            </button>
        </div>
    </div>';
}

if (count($_SESSION['cart']) == 1) {
    $goodsString .= '</div>

    <div class="d-flex justify-content-center">
        <button class="btn btn-outline-primary btn-add-product w-100 w-sm-auto d-none d-md-inline-block" data-target-field="product_link" data-bs-toggle="modal" href="#makeOrderModal" role="button">' . Loc::getMessage('ADD_GOOD') . '</button>
        <a href="mobile-add-edit-order.html" class="btn btn-outline-primary btn-add-product w-100 w-sm-auto d-md-none" >' . Loc::getMessage('ADD_GOOD') . '</a>
    </div>

    <p class="my-7 text-dark text-center fs-5" id="total-with-commission-cost">' . Loc::getMessage('TOTAL_WITH_COMMISSION') . ': ' . number_format($sumRub, 2, '.', ' ') . ' ₽  </p>
    <div class="d-flex justify-content-center">
        <a class="btn btn-primary btn-add-product w-100 w-sm-auto" href="/order/make_order_step_2.php">' . Loc::getMessage('CONTINUE') . '</a>
    </div>';
}

echo json_encode(['goods_string' => $goodsString]);
// echo json_encode(['cart' => $_SESSION['cart']]);
// unset($_SESSION['cart']);

die();