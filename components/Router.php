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
                return substr($_SERVER['REQUEST_URI'], strlen('/shop/'));
            }
        }


        public function run()
        {
            // получаем строку запроса
           $uri = $this->getURI();
           foreach ($this->routes as $uriPattern => $path){
              if(preg_match("~$uriPattern~",$uri)){

                  $internalRoute = preg_replace("~$uriPattern~", $path, $uri);

                // определяем какой контроллер и экшен обрабатывают запорас
                $segment = explode('/',$internalRoute);

                 $controllerName = array_shift($segment).'Controller';
                 $controllerName = ucfirst($controllerName);

                 $actionName = 'action'.ucfirst(array_shift($segment));

                 $parameters = $segment;
                  echo   $controllerName .'<br>';
                  echo  $actionName ;
                  print_r($parameters)  ;


                // подключение файла класса контроллера
                  $controllerFile = ROOT.'/controllers/'.$controllerName.'.php';
                  if (file_exists($controllerFile)){
                      include_once($controllerFile);
                  }

                  // созвать объект и вызвать метод

                  $controllerObject = new $controllerName;

                  $result = call_user_func_array(array($controllerObject,$actionName),$parameters);

                  if($result!= null) {
                      break;
                  }

              }
           }
        }





    }