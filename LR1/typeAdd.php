<?php
    require_once('Components/Database.php');
    require_once('Components/TableModuleClasses.php');
    require_once('Views/Common/nav.php');

    $header = "Добавление типа фотосъёмки";
    $errors = TypePhotoActions::AddTypePhoto();

    require_once('Views/Other/types/addType.php');

    require_once('Views/Common/footer.html');