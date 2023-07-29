<?php
define('STOP_STATISTICS', true);
require_once($_SERVER['DOCUMENT_ROOT'].'/bitrix/modules/main/include/prolog_before.php');
$APPLICATION->RestartBuffer();

// проверяем размер файла
if ($_FILES['photo']['error'] == '1'){
    echo 'INVALID_FILE_SIZE';
    die();
}

// если есть вложение
if (isset($_FILES['photo']) && !empty($_FILES['photo']['tmp_name'])) {
    // проверяем расширение (что это картинка):
    if (strpos($_FILES['photo']['type'], 'image') !== false){
        // закачиваем файл в /upload/users_pics
        $name = $_FILES['photo']['name'];
        $uploadsDir = $_SERVER['DOCUMENT_ROOT'].'/upload/users_pics';
        $isMoved = move_uploaded_file($_FILES['photo']['tmp_name'], "$uploadsDir/$name");
        if ($isMoved){
            // если всё ок:
            $user = new CUser;
            $arFields = [];

            // $fileId = CFile::SaveFile($_FILES["personal-photo"],'avatar');
            $arFile = CFile::MakeFileArray($_SERVER["DOCUMENT_ROOT"] . "/upload/users_pics/" . $name);
            $arFile['del'] = "Y";
            $arFile['old_file'] = $_POST['old_photo_id'];
            $arFields['PERSONAL_PHOTO'] = $arFile;

            $result = $user->Update($USER->GetID(), $arFields);

            // удаляем временный файл:
            unlink ($uploadsDir."/".$name);
        } else {
            echo 'ERROR_FILE_MOVED';
        }
    }else{
        echo 'INVALID_FILE_TYPE';
    }
} else if (isset($_FILES['photo']) && empty($_FILES['photo']['tmp_name'])) {
    echo 'NO_PHOTO_ADDED';
} else {
    echo 'SOMETHING_WENT_WRONG';
}


die();