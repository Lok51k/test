<?php
    require_once('Components/Database.php');
    require_once('Components/TableModuleClasses.php');
    require_once('Views/Common/nav.php');

    $header = "Изменение данных фотографа";
    $types = TypePhotoTable::GetTypePhotos();

    $photographer = PhotographerActions::GetPhotographer();

    $errors = PhotographerActions::EditPhotographer();

    require_once('Views/Other/photographers/editPhoto.php');

    require_once('Views/Common/footer.html');