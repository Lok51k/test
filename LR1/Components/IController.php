<?php

    interface IController{
        public function actionShow(int $id = 0);
        public function actionEdit(int $id);
        public function actionDelete(int $id);
        public function actionAdd();
    }