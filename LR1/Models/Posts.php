<?php

    class Posts extends ORM
    {
        public function GetTableName(): string
        {
            return 'guard_posts';
        }

        public function GetFields(): array
        {
            return [
                'id' => 'id',
                'location' => 'string'
            ];
        }

        public function GetPage(): string
        {
            return 'posts';
        }

        public function EditPost(int $id){
            if($_POST)
                if ($this->CheckString($_POST['location']) == null) {
                    parent::EditRecord(array(
                        'id' => $id,
                        'location' => trim($_POST['location'])
                    ));
                }
        }

        public function AddPost() {
            if($_POST)
            {
                if ($this->CheckString($_POST['location']) == null) {
                    parent::AddRecord(array(
                        'location' => trim($_POST['location'])
                    ));
                }
                else
                    return $this->CheckString($_POST['location']);
            }
        }

        public function DeletePost(int $id, Guards $guards){
            if ($_POST)
            {
                if (isset($_POST['flexRadioDefault']) and isset($_POST['id_guard_post']))
                    $guards->EditGuardWithPost($id, $_POST['id_guard_post']);
                else
                    $guards->DeleteGuardWithPost($id);
                $this->DeleteRecord($id);

                header("Location: /" . HOST . "/" . $this->GetPage() . "/show");
                exit();
            }
        }

    }