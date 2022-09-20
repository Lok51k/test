<?php

    class Router
    {
        private mixed $routes;

        public function __construct()
        {
            $routesPath = ROOT . '/Config/routes.php';
            $this->routes = include($routesPath);
        }

        // Returns request string
        private function getURI(): ?string
        {
            if (!empty($_SERVER['REQUEST_URI']))
                return trim($_SERVER['REQUEST_URI'], '/');
            else
                return null;
        }

        public function run() : void
        {
            $uri = $this->getURI();
            $result = null;

            foreach ($this->routes as $uriPattern => $path) {

                if(preg_match("~$uriPattern~", $uri)) {

                    $internalRoute = preg_replace("~$uriPattern~", $path, $uri);

                    $segments = explode('/', $internalRoute);

                    //unset($segments[0]);

                    // Saves the first value from an array and removes it from the array
                    $controllerName = array_shift($segments).'Controller';
                    // ucfirst - Uppercase First
                    $controllerName = ucfirst($controllerName);

                    // Get actionName from array
                    $actionName = 'action' . ucfirst(array_shift($segments));

                    $parameters = $segments;

                    $controllerFile = ROOT . '/Controllers/' . $controllerName . '.php';

                    if (file_exists($controllerFile)) {
                        include_once($controllerFile);
                    }

                    $controllerObject = new $controllerName;

                    $result = call_user_func_array(array($controllerObject, $actionName), $parameters);
                    if ($result != NULL) {
                        break;
                    }
                }
            }
            if ($result == NULL)
                header("Location: " . ROOT . "/index.php");
        }
    }