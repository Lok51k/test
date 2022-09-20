<?php
    require_once('Components/Database.php');
    require_once('Components/TableModuleClasses.php');

    PhotographerActions::DeletePhotographer();

    header("Location: photoShow.php");
    exit();