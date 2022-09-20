<?php

    class Database
    {
        // Экземпляр данного класса
        private static $instance = null;

        // Экземпляр подключения к БД
        private $connection = null;

        // Запрещаем создание новых экземпляров снаружи класса
        protected function __construct(){
            $paramsPath = 'Config/db_params.php';
            $params = include($paramsPath);

            $dsn = "mysql:host={$params['host']};dbname={$params['dbname']}";

            $this->connection = new PDO($dsn, $params['user'], $params['password']);
        }

        // Запрещаем клонирование
        protected function __clone(){}

        // Запрещаем десериализацию
        public function __wakeup(){
            throw  new BadMethodCallException("Unable to deserialize database connection");
        }

        // Создает экземпляр класса, хранящий подключение к БД
        public static function getInstance(): Database
        {
            if (null == self::$instance) {
                self::$instance = new static();
            }
            return self::$instance;
        }

        // Экземпляр подключения к БД
        public static function connection(): PDO{
            return static::getInstance()->connection;
        }
    }

    // Проверяем класс на подключение
    try{
        Database::getInstance();
    }
    catch (PDOException $e)
    {
        die("Ошибка подключения к базе данных");
    }