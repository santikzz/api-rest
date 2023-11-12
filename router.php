<?php
    require_once 'config.php';
    require_once './libs/router.php';

    require_once './controller/movie.api.controller.php';
    require_once './controller/user.api.controller.php';

    $router = new Router();

    $router->addRoute('movies',                 'GET',    'MovieAPIController',     'getMovies');
    $router->addRoute('movies/add',             'POST',   'MovieAPIController',     'createMovie');
    $router->addRoute('movies/:ID',             'GET',    'MovieAPIController',     'getMovies');
    $router->addRoute('movies/genre/:GENRE',    'GET',    'MovieAPIController',     'getByGenre');
    $router->addRoute('movies/update',          'PUT',    'MovieAPIController',     'updateMovie');
    // $router->addRoute('movies/:ID',             'DELETE', 'MovieAPIController',     'deleteMovie');
    $router->addRoute('genres',                 'GET',    'MovieAPIController',     'getGenres');
    
    $router->addRoute('user/token', 'GET',    'UserAPIController', 'getToken');
    
    $router->route($_GET['resource']        , $_SERVER['REQUEST_METHOD']);