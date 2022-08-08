<?php
class Router
    {
        private $routes;

        public function __construct()
        {
                $routesPath = ROOT.'/config/routes.php';
                $this->routes = include $routesPath;
        }
        //получить строку запроса
        private function getURI(){
            if(!empty($_SERVER['REQUEST_URI'])) {
                return trim($_SERVER['REQUEST_URI'], '/');
            }
        }


        public function run()
        {
            // получаем строку запроса
           $uri = $this->getURI();
           foreach ($this->routes as $uriPattern => $path){
              if(preg_match("~$uriPattern~",$uri)){

                // определяем какой контроллер и экшен обрабатывают запорас
                $segment = explode('/',$path);

                 $controllerName = array_shift($segment).'Controller';
                 $controllerName = ucfirst($controllerName);

                 $actionName = 'action'.ucfirst(array_shift($segment));

                // подключение файла класса контроллера
                  $controllerFile = ROOT.'/controllers/'.$controllerName.'.php';
                  if (file_exists($controllerFile)){
                      include_once($controllerFile);
                  }

                  // созвать объект и вызвать метод

                  $controllerObject = new $controllerName;
                  $result = $controllerObject->$actionName();
                  if($result != null) {
                      break;
                  }

              }
           }
        }





    }