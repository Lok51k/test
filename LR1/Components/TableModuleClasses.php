<?php


    class PhotographerTable{
        public static function GetPhotographerWithTypePhoto(int $id) : ?array{
            $sql = "SELECT photographer.id, photographer.name, type_photo.id as id_type, type_photo.name as type_name, biography, year_of_birth, img_path FROM photographer JOIN type_photo " .
                "ON photographer.id_type_photo = type_photo.id WHERE type_photo.id = :id ORDER BY photographer.id";

            // Для видимости объявляем массив тут
            $data = array();

            $statement = Database::connection()->prepare($sql);

            $statement->bindValue(":id", $id);

            $statement->execute();

            for($i = 0; $value = $statement->fetch(PDO::FETCH_ASSOC); $i++){
                $data[$i]['id'] = $value['id'];
                $data[$i]['img_path'] = $value['img_path'];
                $data[$i]['name'] = $value['name'];
                $data[$i]['type_name'] = $value['type_name'];
                $data[$i]['biography'] = $value['biography'];
                $data[$i]['year_of_birth'] = $value['year_of_birth'];
                $data[$i]['id_type'] = $value['id_type'];
                $i++;
            }

            return $data;
        }
        public static function GetPhotographers() : ?array{
            $sql = "SELECT photographer.id, photographer.name, type_photo.id as id_type, type_photo.name as type_name, biography, year_of_birth, img_path FROM photographer JOIN type_photo " .
                "ON photographer.id_type_photo = type_photo.id ORDER BY photographer.id";
            $result = Database::connection()->query($sql);

            // Для видимости объявляем массив тут
            $data = array();

            for($i = 0; $value = $result->fetch(PDO::FETCH_ASSOC); $i++){
                $data[$i]['id'] = $value['id'];
                $data[$i]['img_path'] = $value['img_path'];
                $data[$i]['name'] = $value['name'];
                $data[$i]['type_name'] = $value['type_name'];
                $data[$i]['biography'] = $value['biography'];
                $data[$i]['year_of_birth'] = $value['year_of_birth'];
                $data[$i]['id_type'] = $value['id_type'];
            }

            return $data;
        }
        public static function GetPhotographer($id) : array{
            $sql = "SELECT photographer.id, photographer.name, type_photo.id as id_type, type_photo.name as type_name, biography, year_of_birth, img_path FROM photographer JOIN type_photo " .
                "ON photographer.id_type_photo = type_photo.id WHERE photographer.id = :id";

            $statement = Database::connection()->prepare($sql);
            $statement->bindValue(":id", $id);
            $statement->execute();

            return $statement->fetch(PDO::FETCH_ASSOC);
        }
        public static function AddPhotographer($name, $biography, $id_type_photo, $year_of_birth, $img_path){
            $sql =  "INSERT INTO photographer(name, biography, id_type_photo, year_of_birth, img_path) ".
                "VALUES(:name, :biography, :id_type_photo, :year_of_birth, :img_path)";
            $statement = Database::connection()->prepare($sql);

            $statement->bindValue(":name", $name);
            $statement->bindValue(":biography", $biography);
            $statement->bindValue(":id_type_photo", $id_type_photo);
            $statement->bindValue(":year_of_birth", $year_of_birth);
            $statement->bindValue(":img_path", $img_path);

            $statement->execute();
        }
        public static function DeletePhotographer($id){
            // Удаляем картинку записи из локального хранилища
            static::DeletePhotographerImage($id);

            // Удаляем запись из БД
            $sql = "DELETE FROM photographer WHERE id = :id";

            $statement = Database::connection()->prepare($sql);
            $statement->bindValue(":id", $id);
            $statement->execute();
        }
        public static function CheckId($id): bool
        {
            $sql = "SELECT id FROM photographer WHERE id = :id";

            $statement = Database::connection()->prepare($sql);
            $statement->bindValue(":id", $id);
            $statement->execute();

            return $statement->rowCount() == 1;
        }
        private static function DeletePhotographerImage($id){
            $sql = "SELECT img_path FROM photographer WHERE id = :id";

            $statement = Database::connection()->prepare($sql);
            $statement->bindValue(":id", $id);
            $statement->execute();

            $path = $statement->fetch(PDO::FETCH_ASSOC);
            $images_dir = $_SERVER['DOCUMENT_ROOT'] . "/LR1/Template/Images/" . $path['img_path'];
            unlink($images_dir);
        }
        public static function EditPhotographer($id, $name, $biography, $id_type_photo, $year_of_birth, $img_path){
            $sql =  "UPDATE photographer " .
                "SET name = :name, biography = :biography, id_type_photo = :id_type_photo, year_of_birth = :year_of_birth";
            if ($img_path != null)
            {
                static::DeletePhotographerImage($id);
                $sql .= ", img_path = :img_path";
            }
            $sql .= " WHERE id = :id ";

            $statement = Database::connection()->prepare($sql);

            $statement->bindValue(":id", $id);
            $statement->bindValue(":name", $name);
            $statement->bindValue(":biography", $biography);
            $statement->bindValue(":id_type_photo", $id_type_photo);
            $statement->bindValue(":year_of_birth", $year_of_birth);

            if ($img_path != null){
                $statement->bindValue(":img_path", $img_path);
            }

            $statement->execute();
        }
        public static function EditPhotographersWithTypePhoto($first_id, $second_id){
            $sql = "UPDATE photographer SET id_type_photo = :second_id WHERE id_type_photo = :first_id";
            $statement = Database::connection()->prepare($sql);

            $statement->bindValue(":first_id", $first_id);
            $statement->bindValue(":second_id", $second_id);

            $statement->execute();
        }
        public static function DeletePhotographersWithTypePhoto($id){
            $sql = "SELECT id FROM photographer WHERE id_type_photo = :id";
            $statement = Database::connection()->prepare($sql);
            $statement->bindValue(":id", $id);
            $statement->execute();

            while($result = $statement->fetch(PDO::FETCH_ASSOC))
                self::DeletePhotographer($result['id']);
        }
    }

    class PhotographerActions
    {
        public static function GetPhotographers(): array
        {
            if ($_SERVER['REQUEST_METHOD'] == 'GET' and !empty($_GET['id']) and intval($_GET['id']))
                $photographers = PhotographerTable::GetPhotographerWithTypePhoto($_GET['id']);
            else
                $photographers = PhotographerTable::GetPhotographers();
            return $photographers;
        }
        public static function DeletePhotographer(): bool
        {
            if (intval($_GET['id']) and PhotographerTable::CheckId($_GET['id'])) {
                PhotographerTable::DeletePhotographer($_GET['id']);
                return true;
            }
            return false;
        }
        public static function AddPhotographer(): array
        {
            // Массив с ошибками
            $message = array();
            $pattern = '/[а-яёА-ЯЁa-zA-Z0-9&\s.,-]+$/u';

            if ($_POST) {

                if (isset($_POST['name'])){
                    if (empty(trim($_POST['name'])))
                        $message['name'] = "Вы не ввели имя фотографа";
                    else if (!preg_match($pattern, $_POST['name']))
                        $message['name'] = "Имя фотографа содержит неподходящие символы";
                }

                if (isset($_POST['biography'])){
                    if (empty(trim($_POST['biography'])))
                        $message['biography'] = "Вы не ввели описание фотографа";
                    else if (!preg_match($pattern, $_POST['biography']))
                        $message['biography'] = "Описание содержит неподходящие символы";
                }

                if (isset($_POST['year_of_birth'])){
                    if (empty($_POST['year_of_birth']))
                        $message['year_of_birth'] =  "Вы не ввели дату рождения";
                    else if (!is_numeric($_POST['year_of_birth']))
                        $message['year_of_birth'] = "Ошибка, вы ввели не число";
                    else if ($_POST['year_of_birth'] < 0)
                        $message['year_of_birth'] = "Ошибка, вы ввели отрицательное число";
                    else if (intval($_POST['year_of_birth']) > date("Y") ||
                        date("Y") - intval($_POST['year_of_birth']) > 70
                    )
                        $message['year_of_birth'] = "Ошибка, неподходящий возраст";
                }


                if (isset($_FILES['image'])){
                    if (empty($_FILES['image']['tmp_name']))
                        $message['image'] = "Вы не отправили файл";
                    else if (!preg_match('/[а-яёА-ЯЁa-zA-Z0-9&_.,-]+(img|png|gif|jpg)$/u', $_FILES['image']['name']))
                        $message['image'] = "Ожидалось расширение типа img|png|gif";
                }

                if (isset($_POST['name']) && isset($_POST['biography']) && isset($_POST['year_of_birth']) && isset($_POST['type_photo']) && isset($_FILES['image']) && !empty($_FILES['image']['tmp_name']) && count($message) == 0) {
                    $upload_dir = $_SERVER['DOCUMENT_ROOT'] . "/LR1/Template/Images/";
                    $new_name = $upload_dir . $_FILES['image']['name'];

                    move_uploaded_file($_FILES['image']['tmp_name'], $new_name);

                    $handle = fopen($new_name, 'r');
                    $content = fread($handle, filesize($new_name));
                    fclose($handle);

                    PhotographerTable::AddPhotographer($_POST['name'], $_POST['biography'], intval($_POST['type_photo']), intval($_POST['year_of_birth']), $_FILES['image']['name']);

                    header("Location: index.php");
                    exit();
                }
            }

            return $message;
        }
        public static function GetPhotographer()
        {
            if (isset($_GET['id']) and PhotographerTable::CheckId($_GET['id']))
                return PhotographerTable::GetPhotographer($_GET['id']);
            else {
                header("Location: index.php");
                exit();
            }
        }
        public static function EditPhotographer(): ?array{
            if (!$_SERVER['REQUEST_METHOD'] == 'POST' or !$_POST)
                return null;

            $pattern = '/[а-яёА-ЯЁa-zA-Z0-9&\s.,-]+$/u';
            $message = array();

            // Проверка ввода названия продукта
            if (isset($_POST['name'])){
                if (empty($_POST['name']))
                    $message['name'] = "Вы не ввели название товара";
                else if (!preg_match($pattern, $_POST['name']))
                    $message['name'] = "Название товара содержит неподходящие символы";
            }


            // Проверка ввода описания товара
            if (isset($_POST['biography'])){
                if (empty($_POST['biography']))
                    $message['biography'] = "Вы не ввели описание товара";
                else if (!preg_match($pattern, $_POST['biography']))
                    $message['biography'] = "Описание содержит неподходящие символы";
            }

            if (isset($_POST['year_of_birth'])){
                if (empty($_POST['year_of_birth']))
                    $message['year_of_birth'] =  "Вы не ввели дату рождения";
                else if (!is_numeric($_POST['year_of_birth']))
                    $message['year_of_birth'] = "Ошибка, вы ввели не число";
                else if ($_POST['year_of_birth'] < 0)
                    $message['year_of_birth'] = "Ошибка, вы ввели отрицательное число";
                else if (intval($_POST['year_of_birth']) > date("Y") ||
                    date("Y") - intval($_POST['year_of_birth']) > 70
                )
                    $message['year_of_birth'] = "Ошибка, неподходящий возраст";
            }

            // Проверка типа отправленного изображения
            if (isset($_FILES['image']) && !empty($_FILES['image']['tmp_name']) and !preg_match('/[а-яёА-ЯЁa-zA-Z0-9&_.,-]+(img|png|gif|jpg)$/u', $_FILES['image']['name'])) {
                $message['image'] = "Ожидалось расширение типа img|png|gif|jpg";
            }

            if (isset($_POST['name']) && isset($_POST['biography']) && isset($_POST['year_of_birth']) && isset($_POST['type_photo']) && count($message) == 0) {
                if (isset($_FILES['image']) && !empty($_FILES['image']['tmp_name']))
                {
                    $upload_dir = $_SERVER['DOCUMENT_ROOT'] . "/LR1/Template/Images/";
                    $new_name = $upload_dir . $_FILES['image']['name'];

                    move_uploaded_file($_FILES['image']['tmp_name'], $new_name);

                    $handle = fopen($new_name, 'r');
                    $content = fread($handle, filesize($new_name));
                    fclose($handle);

                    PhotographerTable::EditPhotographer(intval($_GET['id']), $_POST['name'], $_POST['biography'], intval($_POST['type_photo']), intval($_POST['year_of_birth']), $_FILES['image']['name']);
                }
                else
                    PhotographerTable::EditPhotographer(intval($_GET['id']), $_POST['name'], $_POST['biography'], intval($_POST['type_photo']), intval($_POST['year_of_birth']), null);
                header("Location: photoShow.php");
            }
            return $message;
        }
    }

    class TypePhotoTable{
        public static function GetTypePhotos(): ?array
        {
            $sql = "SELECT id, name FROM type_photo";
            $result = Database::connection()->query($sql);

            // Для видимости объявляем массив тут
            $text = array();

            for($i = 0; $value = $result->fetch(PDO::FETCH_ASSOC) ; $i ++){
                $text[$i]['id'] = $value['id'];
                $text[$i]['name'] = $value['name'];
            }

            return $text;
        }
        public static function AddTypePhoto($name) {
            $sql = "INSERT INTO type_photo(name) VALUES(:name)";

            $statement = Database::connection()->prepare($sql);
            $statement->bindValue(":name", $name);
            $statement->execute();

            header("Location: typeShow.php");
            exit();
        }
        public static function CheckId($id): bool {
            $sql = "SELECT id FROM type_photo WHERE id = :id";

            $statement = Database::connection()->prepare($sql);
            $statement->bindValue(":id", $id);
            $statement->execute();

            return $statement->rowCount() == 1;
        }
        public static function DeleteCTypePhoto($id){
            $sql = "DELETE FROM type_photo WHERE id = :id";

            $statement = Database::connection()->prepare($sql);
            $statement->bindValue(":id", $id);
            $statement->execute();
        }
        public static function GetTypePhoto($id){
            $sql = "SELECT id, name FROM type_photo WHERE id = :id";

            $statement = Database::connection()->prepare($sql);
            $statement->bindValue(":id", $id);
            $statement->execute();

            return $statement->fetch(PDO::FETCH_ASSOC);
        }
        public static function EditTypePhoto($id, $name){
            $sql =  "UPDATE type_photo SET name = :name WHERE id = :id";

            $statement = Database::connection()->prepare($sql);

            $statement->bindValue(":id", $id);
            $statement->bindValue(":name", $name);

            $statement->execute();
            header("Location: typeShow.php");
        }
    }

    class TypePhotoActions{
        public static function AddTypePhoto(){
            if ($_POST){
                if (!empty(trim($_POST['name'])))
                    TypePhotoTable::AddTypePhoto(trim($_POST['name']));
                else
                    return "Ошибка, вы не ввели название категории";
            }
        }
        public static function DeleteTypePhoto()
        {
            if (TypePhotoTable::CheckId($_GET['id'])) {
                if ($_POST)
                {
                    if (isset($_POST['flexRadioDefault']) and isset($_POST['type_photo']))
                        PhotographerTable::EditPhotographersWithTypePhoto($_GET['id'], $_POST['type_photo']);
                    else
                        PhotographerTable::DeletePhotographersWithTypePhoto($_GET['id']);
                    TypePhotoTable::DeleteCTypePhoto($_GET['id']);
                    header("Location: typeShow.php");
                    exit();
                }
            }
            else
                header("Location: typeShow.php");
        }
        public static function GetTypePhoto(){
            if (TypePhotoTable::CheckId($_GET['id'])) {
                if($_POST)
                {
                    if (!empty(trim($_POST['name'])))
                        TypePhotoTable::EditTypePhoto($_GET['id'], trim($_POST['name']));
                }
                else
                    return TypePhotoTable::GetTypePhoto($_GET['id']);
            }
            else
                header("Location: typeShow.php");
        }
    }
