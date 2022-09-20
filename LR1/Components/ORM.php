<?php

    abstract class ORM
    {
        abstract public function GetTableName() : string;
        abstract public function GetFields() : array;
        abstract public function GetPage() : string;

        public function DeleteRecord(int $id) : void{
            $nameId = array_search('id',$this->GetFields());

            $sql = 'DELETE FROM ' . $this->GetTableName() . ' WHERE ' . $nameId . ' = :id';

            $statement = Database::connection()->prepare($sql);
            $statement->bindValue(":id", $id);
            $statement->execute();
        }

        public function CheckId(int $id) : void{
            $nameId = array_search('id',$this->GetFields());

            $sql = 'SELECT id FROM ' . $this->GetTableName() . ' WHERE ' . $nameId . ' = :id';

            $statement = Database::connection()->prepare($sql);
            $statement->bindValue(":id", $id);
            $statement->execute();

            if (!$statement->rowCount() == 1){
                header('Location: /' . HOST . '/' . $this->GetTableName() . '/show');
                exit();
            }
        }

        public function GetRecords() : ?array{

            $sql = 'SELECT * FROM ' .  $this->GetTableName();
            $result = Database::connection()->query($sql);

            $data = array();
            $keys = array_keys($this->GetFields());

            for($i = 0; $value = $result->fetch(PDO::FETCH_ASSOC); $i++)
                for($j = 0; $j < count($keys) ; $j++)
                    if ($this->GetFields()[$keys[$j]] != 'list')
                        $data[$i][$keys[$j]] = $value[$keys[$j]];


            return $data;
        }

        public function GetRecord(int $id) : ?array{
            $nameId = array_search('id',$this->GetFields());
            $sql = 'SELECT * FROM ' .  $this->GetTableName() . ' WHERE ' . $nameId . ' = :id';

            $statement = Database::connection()->prepare($sql);
            $statement->execute(array('id'=>$id));

            return $statement->fetch(PDO::FETCH_ASSOC);
        }

        protected function AddRecord(array $params){
            $fields = $this->GetFields();

            unset($fields[array_search('id',$fields)]);
            while(array_search('list',$fields)){
                unset($fields[array_search('list',$fields)]);
            }

            $into = implode(',', array_keys($fields));
            $values = implode(',:', array_keys($fields));

            $sql = 'INSERT INTO ' . $this->GetTableName() . '( '. $into .') VALUES (:'. $values .')';

            var_dump($params);
            var_dump($sql);

            $statement = Database::connection()->prepare($sql);
            $statement->execute($params);

            header('Location: /' . HOST . '/' . $this->GetPage() . '/show');
            exit();
        }

        protected function EditRecord(array $params){

            $keys = array_keys($this->GetFields());
            $nameId = array_search('id',$this->GetFields());

            $count = count($keys);
            for($i = 0; $i < $count ; $i++){
                if (array_key_exists($keys[$i], $params))
                    $keys[$i] = $keys[$i] . ' = :' . $keys[$i];
                else unset($keys[$i]);
            }

            $str = implode(', ',$keys);
            $sql = 'UPDATE ' . $this->GetTableName() . ' SET ' . $str . ' WHERE ' . $nameId . ' = :id';

            $statement = Database::connection()->prepare($sql);
            $statement->execute($params);

            header('Location: /' . HOST . '/' . $this->GetPage() . '/show');
            exit();
        }

        protected function SaveImage() : void{
            $upload_dir = $_SERVER['DOCUMENT_ROOT'] . "/" . HOST ."/Source/items/";
            $new_name = $upload_dir . $_FILES['image']['name'];

            move_uploaded_file($_FILES['image']['tmp_name'], $new_name);

            $handle = fopen($new_name, 'r');
            $content = fread($handle, filesize($new_name));
            fclose($handle);
        }

        protected function DeleteImage(string $img_path) : void{
            $images_dir = $_SERVER['DOCUMENT_ROOT'] . "/" . HOST . "/Source/items/" . $img_path;
            unlink($images_dir);
        }

        protected function CheckString(string $input) : ?string{
            $pattern = '/[а-яёА-ЯЁa-zA-Z0-9&\s.,-]+$/u';
            if (empty(trim($input)))
                return "Вы не ввели ";
            else if (!preg_match($pattern, $input))
                return "Не соответствует требованиям";
            return null;
        }


        protected function CheckYearOfBirth(string $input) : ?string{
            if (empty(trim($input)))
                return "Вы не ввели дату рождения";
            else if (!is_numeric($input))
                return "Ошибка, вы ввели не число";
            else if ($input < 0)
                return "Ошибка, вы ввели отрицательное число";
            else if (intval($input) > date("Y") ||
                abs(intval($input) - date("Y")) < 18 ||
                date("Y") - intval($input) > 60)
                return "Ошибка, неподходящий возраст";
            return null;
        }

    }