<?php
    require_once("Models/Posts.php");

    class Guards extends ORM
    {
        public function GetTableName(): string
        {
            return 'guards';
        }

        public function GetFields(): array
        {
            return [
                'id' => 'id',
                'full_name' => 'string',
                'biography' => 'string',
                'year_of_birth' => 'int',
                'guard_post' => 'list',
                'id_guard_post' => 'int',
                'img_path' => 'image'
            ];
        }

        public function GetPage(): string
        {
            return 'guards';
        }

        public function GetRecords(): ?array
        {
            $guards = parent::GetRecords();
            $posts = new Posts;
            $postsList = $posts->GetRecords();

            for($i = 0; $i < count($guards) ; $i++) {
                for($j = 0; $j < count($postsList) ; $j++) {
                    if ($postsList[$j]['id'] == $guards[$i]['id_guard_post'])
                        $guards[$i]['guard_post'] = $postsList[$j]['location'];
                }
            }

            return $guards;
        }

        private function CheckValues() : ?array{
            if (!$_POST)
                return null;

            $message = array();

            parent::CheckString($_POST['full_name']) == null ? : $message['full_name'] = parent::CheckString($_POST['full_name']) ;
            parent::CheckString($_POST['biography']) == null ? : $message['biography'] = parent::CheckString($_POST['biography']) ;
            parent::CheckYearOfBirth($_POST['year_of_birth']) == null ? : $message['year_of_birth'] = parent::CheckYearOfBirth($_POST['year_of_birth']) ;

            return $message;
        }

        public function AddGuard() : ?array{
            $message = $this->CheckValues();

            if (isset($_FILES['image'])){
                if (empty($_FILES['image']['tmp_name']))
                    $message['image'] = "Вы не отправили файл";
                else if (!preg_match('/[а-яёА-ЯЁa-zA-Z0-9&_.,-]+(img|png|gif|jpg)$/u', $_FILES['image']['name']))
                    $message['image'] = "Ожидалось расширение типа img|png|gif";
            }


            if (isset($_POST['full_name']) && isset($_POST['biography']) && isset($_POST['year_of_birth']) && isset($_POST['guard_post']) && isset($_FILES['image']) && !empty($_FILES['image']['tmp_name']) && count($message) == 0) {
                $this->SaveImage();

                parent::AddRecord(array(
                        'full_name' => $_POST['full_name'],
                        'biography' => $_POST['biography'],
                        'id_guard_post' => intval($_POST['guard_post']),
                        'year_of_birth' => intval($_POST['year_of_birth']),
                        'img_path' => $_FILES['image']['name'])
                );
            }

            return $message;
        }

        public function EditGuard(int $id) : ?array{
            $message = $this->CheckValues();

            if (isset($_FILES['image']) && !empty($_FILES['image']['tmp_name']) and !preg_match('/[а-яёА-ЯЁa-zA-Z0-9&_.,-]+(img|png|gif|jpg)$/u', $_FILES['image']['name']))
                $message['image'] = "Ожидалось расширение типа img|png|gif|jpg";

            if (isset($_POST['full_name']) && isset($_POST['biography']) && isset($_POST['year_of_birth']) && isset($_POST['guard_post']) && count($message) == 0) {
                $params = array(
                    'id' => $id,
                    'full_name' => $_POST['full_name'],
                    'biography' => $_POST['biography'],
                    'id_guard_post' => intval($_POST['guard_post']),
                    'year_of_birth' => intval($_POST['year_of_birth'])
                );

                if (isset($_FILES['image']) && !empty($_FILES['image']['tmp_name']))
                {
                    $this->SaveImage();

                    $params['img_path'] = $_FILES['image']['name'];
                    parent::EditRecord($params);
                }
                else
                    parent::EditRecord($params);
            }
            return $message;
        }

        public function DeleteGuard(int $id){
            $path = $this->GetRecord($id)['img_path'];

            $this->DeleteImage($path);
            $this->DeleteRecord($id);
        }

        public function GetGuardWithPost(int $id) : ?array{
            $guardList = $this->GetRecords();

            $result_items = array();
            $count = 0;

            for($i = 0; $i < count($guardList) ; $i++) {
                if ($id == $guardList[$i]['id_guard_post']){
                    $result_items[$count] = $guardList[$i];
                    $count++;
                }
            }

            return $result_items;
        }

        #debug
        public function EditGuardWithPost(int $first_id, int $second_id){
            $sql = "UPDATE guards SET id_guard_post = :second_id WHERE id_guard_post = :first_id";

            // prepare
            $statement = Database::connection()->prepare($sql);

            // bind
            $statement->bindValue(":first_id", $first_id);
            $statement->bindValue(":second_id", $second_id);

            // execute
            $statement->execute();
        }
    #debug
        public function DeleteGuardWithPost(int $id){
            $guards = $this->GetGuardWithPost($id);
            $count = count($guards);

            for($i = 0; $i < $count ; $i++)
                if ($guards[$i]['id_guard_post'] == $id)
                    $this->DeleteGuard($guards[$i]['id']);
        }
    }