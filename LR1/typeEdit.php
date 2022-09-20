<?php
    require_once('Components/Database.php');
    require_once('Components/TableModuleClasses.php');
    require_once('Views/Common/nav.php');

    $header = "Изменение типа фотосъёмки";
    $type = TypePhotoActions::GetTypePhoto();

    require_once('Views/Other/types/editType.php');

    require_once('Views/Common/footer.html');