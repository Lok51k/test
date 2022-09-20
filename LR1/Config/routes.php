<?php

    // Controllers/Action
    return array(
        // Изменение данных охранника
        HOST . '/guards/edit/([0-9]?)' => 'guards/edit/$1',
        // Удаление охранника
        HOST . '/guards/delete/([0-9]?)' => 'guards/delete/$1',
        // Просмотр охранников на указанном посту
        HOST . '/guards/show/([0-9]?)' => 'guards/show/$1',
        // Просмотр всех охранников
        HOST . '/guards/show' => 'guards/index',
        // Добавление охранника
        HOST . '/guards/add' => 'guards/add',

        // Изменение данных  охранного поста
        HOST . '/posts/edit/([0-9]?)' => 'posts/edit/$1',
        // Удаление охранного поста
        HOST . '/posts/delete/([0-9]?)' => 'posts/delete/$1',
        // Просмотр охранных постов
        HOST . '/posts/show' => 'posts/show',
        // Добавление охранного поста
        HOST . '/posts/add' => 'posts/add',

        HOST => 'guards/index',
    );