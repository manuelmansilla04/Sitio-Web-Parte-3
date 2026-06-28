<?php
    require_once './libs/router/router.php';
    require_once './app/controllers/categoria_api_controller.php';
    require_once './libs/jwt/jwt.middleware.php';
    require_once './app/middlewares/guard-api.middleware.php';
    require_once './app/controllers/auth-api.controller.php';


    $router = new Router();
    $router->addRoute('auth/login','GET','AuthApiController','login');

    $router->addMiddleware(new JWTMiddleware());
    //endpoints
    $router->addRoute('categorias','GET','CategoriaApiController','getCategorias');
    $router->addRoute('categorias/:id','GET','CategoriaApiController','getCategoriaByID');
    $router->addMiddleware(new GuardMiddleware());
    $router->addRoute('categorias/:id','DELETE','CategoriaApiController','deleteCategoria');
    $router->addRoute('categorias/:id','PUT','CategoriaApiController','editCategoria');
    $router->addRoute('categorias','POST','CategoriaApiController','addCategoria');

    //ruteo
    $router->route($_GET['resource'] ?? '', $_SERVER['REQUEST_METHOD']);
?>
