<?php
    require_once('Components/Database.php');
    require_once('Components/TableModuleClasses.php');

    require_once('Views/Common/nav.php');

    $types = TypePhotoTable::GetTypePhotos();

    require_once('Views/Other/types/viewType.php');

    require_once('Views/Common/footer.html');