<?php
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");

$APPLICATION->SetTitle("Мои заказы");

use \Bitrix\Main\Localization\Loc;
Loc::loadMessages(__FILE__);

// echo '<pre>';
// print_r($_SESSION);
// echo '</pre>';
?>
<main>
    <?php if ($USER->isAuthorized()):?>
        <section class="container pt-7 mt-1 pb-10 mb-4  text">
            <div class="d-flex flex-wrap justify-content-between align-items-center mb-4">
                <h1 class="fs-2 mb-4 mb-sm-0">Редактировать №1234</h1>
                <a href="#" class="btn btn-primary w-100 w-sm-auto px-8"><?=Loc::getMessage('EDIT');?></a>
            </div>

            <div class="d-flex flex-wrap justify-content-between align-items-center fs-5 text-dark mb-6">
                <div class="mb-4 mb-lg-0">
                    <p class="mb-1">Горняков Дмитий Алексеевич</p> 
                    <p class="mb-1 mb-lg-0">обл. Московская, г.Химки ул. Молодёжная 21 кв.28 (123456)</p>  
                    <p class="mb-1 mb-lg-0"><b><?=Loc::getMessage('DELIVERY_METHOD');?>:</b> Быстрая авиа доставка</p>
                    <p class="mb-1 mb-lg-0"><b><?=Loc::getMessage('ORDER_STATUS');?>:</b> Не оплачен</p>
                    <p class="text-secondary">Заказ застрахован</p>
                </div>
                <div>
                    <p class="mb-1 mb-lg-0"><?=Loc::getMessage('CREATED');?>: 19-04-2023, 15:24</p>
                    <p class="mb-1 mb-lg-0"><?=Loc::getMessage('UPDATED');?>: 30-04-2023, 13:41</p>
                    <button class="link-secondary mb-2 text-decoration-underline"><?=Loc::getMessage('REPEAT_THE_ORDER');?></button>

                    <div class="d-flex align-items-center">
                        <span class="d-inline-block me-3"><?=Loc::getMessage('FOLDER');?></span>
                        <div class="dropdown dropdown_orders single-order">
                            <button class="btn btn-outline-secondary dropdown-toggle fs-6 px-2 py-1" type="button" id="orders-place" data-bs-toggle="dropdown" aria-expanded="false">
                                
                                <svg width="15" height="8" viewBox="0 0 15 8" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd" clip-rule="evenodd" d="M8.03033 7.53033C7.73744 7.82322 7.26256 7.82322 6.96967 7.53033L0.96967 1.53033C0.676777 1.23744 0.676777 0.762563 0.96967 0.46967C1.26256 0.176777 1.73744 0.176777 2.03033 0.46967L7.5 5.93934L12.9697 0.46967C13.2626 0.176777 13.7374 0.176777 14.0303 0.46967C14.3232 0.762563 14.3232 1.23744 14.0303 1.53033L8.03033 7.53033Z" fill="#FF431A"/>
                                </svg>
                                <span class="value ms-2"><?=Loc::getMessage('NOT_CHOSEN');?></span>    
                            </button>
                            <ul class="dropdown-menu" aria-labelledby="orders-place">
                                <li class="dropdown-item custom fs-6" ><?=Loc::getMessage('NOT_CHOSEN');?></li>
                                <li class="dropdown-item custom fs-6" >Папка 1</li>
                                <li class="dropdown-item custom fs-6" >Папка 2</li>
                                <li class="dropdown-item custom fs-6" >Папка 3</li>
                                
                            </ul>
                        </div>
                    </div>
                </div>
            </div>


            <div class="order row justify-content-between">
                <div class="col-lg-5 col-12 mb-2">
                    <div class="order__description d-flex ">
                        <div class="order__img-block me-2 flex-shrink-0">
                            <img src="<?=SITE_TEMPLATE_PATH;?>/img/products/1.jpg" alt="" class="order__img" width="100" height="100">
                        </div>
                        <div class="order__text-block flex-grow-1">
                            <div class="mb-1 fs-5 mb-lg-0"><a href="#" class="link-secondary text-decoration-underline fs-5">Футболка</a></div>
                            

                            <div class="d-inline-flex flex-wrap mb-2">
                                <div class="order-tag me-2">
                                    <div class="order-tag__char bg-dark text-white"><?=Loc::getMessage('COLOUR');?></div>
                                    <div class="order-tag__value bg-secondary text-white">Зеленый</div>
                                </div>

                                <div class="order-tag me-2">
                                    <div class="order-tag__char bg-dark text-white"><?=Loc::getMessage('SIZE');?></div>
                                    <div class="order-tag__value bg-secondary text-white">M (46)</div>
                                </div>
                            </div>

                            <p class="text">Идейные соображения высшего порядка, а также постоянный количественный рост и сфера нашей активности говорит о возможностях переосмысления внешнеэкономических политик.</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-7 col-12 mb-6 mb-lg-0 ps-xl-10">
                    <div class="order-price-table text-dark">
                        <div>
                            <div class="fw-bold mb-2">
                                <?=Loc::getMessage('QUANTITY');?>
                            </div>
                            <div class=" mb-2 text-secondary text-center fs-lg-5">
                                1
                            </div>
                            <div class="text-dark d-none d-lg-block fs-lg-5">

                            </div>
                        </div>

                        <div>
                            <div class="fw-bold mb-2">
                                <?=Loc::getMessage('SUMMATION');?>
                            </div>
                            <div class=" mb-2 text-secondary fs-lg-5">
                                ¥ 10.00
                            </div>
                            <div class="text-dark d-none d-lg-block fs-lg-5">
                                ₽ 125.00
                            </div>
                        </div>

                        <div>
                            <div class="fw-bold mb-2">
                                <?=Loc::getMessage('DELIVERY');?>
                            </div>
                            <div class=" mb-2 text-secondary fs-lg-5">
                                ¥ 0.00
                            </div>
                            <div class="text-dark d-none d-lg-block fs-lg-5">
                                ₽ 0.00
                            </div>
                        </div>

                        <div>
                            <div class="fw-bold mb-2">
                                <?=Loc::getMessage('SERVICES');?>
                            </div>
                            <div class=" mb-2 text-secondary fs-lg-5">
                                ¥ 3.00
                            </div>
                            <div class="text-dark d-none d-lg-block fs-lg-5 ">
                                ₽ 37.50
                            </div>
                        </div>
                        
                        <div>
                            <div class="fw-bold mb-2">
                                <?=Loc::getMessage('TOTAL');?>
                            </div>
                            <div class="text-success d-lg-none">
                                <span>¥ 13</span> <span>( ₽ 162.00 )</span>
                            </div>
                            <div class=" mb-2 text-secondary d-none d-lg-block fs-lg-5">
                                ¥ 13.00
                            </div>
                            <div class="text-dark text-success d-none d-lg-block fs-lg-5">
                                ₽ 162.00
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-12 mt-lg-7">
                    <div class="d-flex justify-content-center">
                        <div class="order__amount fs-lg-2 text-dark">
                            <span class="order__amount-caption"><?=Loc::getMessage('TOTAL');?>:</span> <span class="text-success order__amount-value">2 244,37 ₽</span>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <?php else:?>
            <section class="container pt-7 mt-1 pb-10 mb-4  text">
                <div class="cabinet"><?=Loc::getMessage('NEED_TO_BE_AUTHORIZED');?></div>
            </section>
        <?php endif;?>
</main>


<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>