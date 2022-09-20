<?php
    require_once('Components/Database.php');
    require_once('Components/TableModuleClasses.php');
    require_once('Views/Common/nav.php');

    $types = TypePhotoTable::GetTypePhotos();
    TypePhotoActions::DeleteTypePhoto();

    $id = 0;
    foreach ($types as $key => $item) {
        if ($item['id'] == $_GET['id']) {
            $header = "Удаление типа " . $item['name'];
            $id = $item['id'];
        }
    }

    for ($i = 0; $i < count($types); $i++)
        if ($types[$i]['id'] == $id)
            unset($types[$i]);



    require_once('Views/Other/types/deleteType.php');

    require_once('Views/Common/footer.html');
