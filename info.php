<?php
$orderContent = array(
    'link_1' => [
        'name' => 'Носки',
        'price' => 23,
        'quantity' => 1,
        'colour' => 'Чёрные',
        'size' => 23,
        'delivery_through_china' => 150,
        'note' => '',
        'photo' => [],
        'photo_report_is_needed' => 'N'
    ],
    'link_2'=> [
        'name' => 'Рюкзак',
        'price' => 109,
        'quantity' => 1,
        'colour' => 'Голубой',
        'size' => 'не светящийся',
        'delivery_through_china' => 450,
        'note' => '',
        'photo' => [],
        'photo_report_is_needed' => 'Y'
    ],
    'link_3'=> [
        'name' => 'Футболка',
        'price' => 68,
        'quantity' => 2,
        'colour' => 'розовая',
        'size' => 44,
        'delivery_through_china' => 300,
        'note' => 'abc',
        'photo' => [],
        'photo_report_is_needed' => 'Y'
    ]
);
print_r($orderContent);
echo ("<br></br>");
$serializedOrderContent = base64_encode(serialize($orderContent));
print_r($serializedOrderContent);
