<?php

    require_once("Models/Posts.php");
    require_once("Models/Guards.php");

    class PostsController implements IController
    {
        private Posts $posts;
        private Guards $guards;

        public function __construct(){
            $this->posts = new Posts();
            $this->guards = new Guards();
        }

        function actionShow(int $id = 0) : bool {
            $title = "Охранные пункты";
            require_once ('Views/Common/nav.php');

            $posts = $this->posts->GetRecords();
            require_once('Views/Other/Posts/show.php');

            require_once ('Views/Common/footer.php');
            return true;
        }

        function actionEdit(int $id) : bool {
            $title = "Редактирование охранника";
            $this->posts->CheckId($id);
            require_once ('Views/Common/nav.php');

            $posts = $this->posts->GetRecord($id);
            $this->posts->EditPost($id);
            require_once('Views/Other/Posts/edit.php');

            require_once ('Views/Common/footer.php');
            return true;
        }

        function actionDelete(int $id) : bool {
            $title = "Удаление охранного пункта";
            $this->posts->CheckId($id);
            require_once ('Views/Common/nav.php');

            $posts = $this->posts->GetRecords();
            $this->posts->DeletePost($id, $this->guards);

            $num = 0;
            foreach ($posts as $key => $item) {
                if ($item['id'] == $id) {
                    $header = "Удаление охранного пункта " ;
                    $num = $item['id'];
                }
            }

            for ($i = 0; $i < count($posts); $i++)
                if ($posts[$i]['id'] == $num)
                    unset($posts[$i]);

            require_once('Views/Other/Posts/delete.php');

            require_once ('Views/Common/footer.php');
            return true;
        }

        function actionAdd() : bool {
            $title = "Добавление охранного пункта";
            require_once ('Views/Common/nav.php');

            $errors = $this->posts->AddPost();
            require_once('Views/Other/Posts/add.php');

            require_once ('Views/Common/footer.php');
            return true;
        }
    }