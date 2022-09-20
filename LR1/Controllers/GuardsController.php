<?php

    require_once("Models/Guards.php");
    require_once("Models/Posts.php");

    class GuardsController implements IController
    {
        private Guards $guards;
        private Posts $posts;

        public function __construct(){
            $this->guards = new Guards();
            $this->posts = new Posts();
        }

        function actionIndex() : bool {
            $title = "Охранные посты";
            require_once ('Views/Common/nav.php');

            $guards = $this->guards->GetRecords();

            require_once('Views/Other/Guards/show.php');

            require_once ('Views/Common/footer.php');
            return true;
        }

        function actionShow(int $id = 0) : bool {
            $title = "Охранные посты";
            require_once ('Views/Common/nav.php');

            if ($id != 0)
                $guards = $this->guards->GetGuardWithPost($id, $this->posts);
            else{
                $guardsList = $this->guards->GetRecords();
                $postsList = $this->posts->GetRecords();

                for($i = 0; $i < count($guardsList) ; $i++) {
                    for($j = 0; $j < count($postsList) ; $j++) {
                        if ($postsList[$j]['id'] == $guardsList[$i]['id_guard_post'])
                            $guardsList[$i]['guard_post'] = $postsList[$j]['location'];
                    }
                }
            }
            require_once('Views/Other/Guards/show.php');

            require_once ('Views/Common/footer.php');
            return true;
        }

        function actionEdit(int $id) : bool {
            $title = "Редактирование охранного поста";
            require_once ('Views/Common/nav.php');

            $posts = $this->posts->GetRecords();

            $this->guards->CheckId($id);
            $guards = $this->guards->GetRecord($id);
            $errors = $this->guards->EditGuard($id);
            require_once('Views/Other/Guards/edit.php');

            require_once ('Views/Common/footer.php');
            return true;
        }

        function actionDelete(int $id) : bool {
            $this->guards->DeleteGuard($id);

            header("Location: /" . HOST . "/" . $this->guards->GetPage() . "/show");
            exit();
        }

        function actionAdd() : bool {
            $title = "Добавление охранного поста";
            require_once ('Views/Common/nav.php');

            $posts = $this->posts->GetRecords();
            $errors = $this->guards->AddGuard();
            require_once('Views/Other/Guards/add.php');

            require_once ('Views/Common/footer.php');
            return true;
        }
    }