<?php
define('STOP_STATISTICS', true);
require_once($_SERVER['DOCUMENT_ROOT'].'/bitrix/modules/main/include/prolog_before.php');

$APPLICATION->RestartBuffer();

session_start();

if (isset($_POST['link']) && !empty($_POST['link'])) {
    $_POST['link'] = strip_tags($_POST['link']);

    $photosInString = '';

    foreach ($_SESSION['cart'][$_POST['link']]['photo'] as $photo) {
        $photosInString .=
            '<div class="products-photo-grid__item">
                <img src="/upload/users_pics/' . $photo['name'] . '" alt="">
    
                <div class="products-photo-grid__item-remove" onclick="
                    console.log(this.parentNode.querySelector(\'img\').src);
                    let dataToSend = {
                        \'link\': \'' . $_POST['link'] . '\',
                        \'image_src\': decodeURIComponent(this.parentNode.querySelector(\'img\').src)
                    };
                    $.ajax( {
                        url: \'/order/ajax/ajax_delete_image.php\',
                        method: \'POST\',
                        dataType: \'html\',
                        data: dataToSend,
                        success: function(data) {
                          console.log(data);
                        }
                    });
                    let  productPhotoGridEdit =  document.querySelector(\'.products-photo-grid\');

                    if ( productPhotoGridEdit ){

                        productPhotoGridEdit.addEventListener(\'click\', function(event){
                            if (event.target.classList.contains(\'products-photo-grid__item-remove\') || event.target.closest(\'.products-photo-grid__item-remove\')  ){
                                let productImgItem = event.target.closest(\'.products-photo-grid__item\');
                                productImgItem.remove();            
                            }
                        })
                    }
                ">
                    <img src="' . SITE_TEMPLATE_PATH . '/img/icons/remove-product.svg" alt="">
                </div>
            </div>';
    }

    echo json_encode([
        'checkbox' => (int)$_SESSION['cart'][$_POST['link']]['photo_report_is_needed'],
        'photos' => $photosInString
    ]);
}


die();