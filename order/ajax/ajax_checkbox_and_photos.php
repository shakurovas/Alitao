<?php
define('STOP_STATISTICS', true);
require_once($_SERVER['DOCUMENT_ROOT'].'/bitrix/modules/main/include/prolog_before.php');

$APPLICATION->RestartBuffer();

session_start();

if (isset($_POST['link']) && !empty($_POST['link'])) {
    $_POST['link'] = strip_tags($_POST['link']);

    $photosInString = '';

    if (isset($_SESSION['editable_order']) && !empty($_SESSION['editable_order'])) {
        $goods = $_SESSION['editable_order'];
    } else {
        $goods = $_SESSION['cart'];
    }

    foreach ($goods[$_POST['link']]['photo'] as $photo) {
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
                    let removeUploadImgBtn = document.querySelectorAll(\'.products-photo-grid__item-remove\');

                    if ( productPhotoGridEdit ){

                        productPhotoGridEdit.addEventListener(\'click\', function(event){
                            if (event.target.classList.contains(\'products-photo-grid__item-remove\') || event.target.closest(\'.products-photo-grid__item-remove\')  ){
                                let productImgItem = event.target.closest(\'.products-photo-grid__item\');
                                productImgItem.remove();            
                            }
                        })
                    }

                    if (removeUploadImgBtn) {
                        for (let i = 0; i < removeUploadImgBtn.length; i++) {
                            removeUploadImgBtn[i].addEventListener(\'click\', function() {
                                alert(this.closest(\'.products-photo-grid__item\'));
                                this.closest(\'.products-photo-grid__item\').remove();
                            });
                        }
                    }
                ">
                    <img src="' . SITE_TEMPLATE_PATH . '/img/icons/remove-product.svg" alt="">
                </div>
            </div>';
    }

    echo json_encode([
        'checkbox' => (int)$goods[$_POST['link']]['photo_report_is_needed'],
        'photos' => $photosInString
    ]);
}


die();