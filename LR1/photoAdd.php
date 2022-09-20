<?php
    require_once('Components/Database.php');
    require_once('Components/TableModuleClasses.php');
    require_once('Views/Common/nav.php');

    $header = "Добавление фотографа";
    $types = TypePhotoTable::GetTypePhotos();
    $errors = PhotographerActions::AddPhotographer();

    require_once('Views/Other/photographers/addPhoto.php');

    require_once('Views/Common/footer.html');