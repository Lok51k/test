<?php
    require_once('Components/Database.php');
    require_once('Components/TableModuleClasses.php');

    require_once('Views/Common/nav.php');

    $photographers = PhotographerActions::GetPhotographers();

    require_once('Views/Other/photographers/viewPhoto.php');

    require_once('Views/Common/footer.html');
