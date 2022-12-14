<?php
    use Symfony\Component\Routing;

    $routes = new Routing\RouteCollection();

    $routes->add('index', new Routing\Route(
        path: '/',
        defaults: ['_controller'=>'App\Controller\DefaultController::index']
    ));

    $routes->add('login', new Routing\Route(
        path: '/login',
        defaults: ['_controller'=>'App\Controller\DefaultController::login'],
        methods: ['GET']
    ));

    $routes->add('login-process', new Routing\Route(
        path: '/login-process',
        defaults: ['_controller'=>'App\Controller\DefaultController::login_process'],
        methods: ['POST']
    ));

    $routes->add('register', new Routing\Route(
        path: '/register',
        defaults: ['_controller'=>'App\Controller\DefaultController::register'],
        methods: ['GET']
    ));

    $routes->add('register-process', new Routing\Route(
        path: '/register-process',
        defaults: ['_controller'=>'App\Controller\DefaultController::register_process'],
        methods: ['POST']
    ));

    #$routes->add('register', new Routing\Route('/register'));
    #$routes->add('register-process', new Routing\Route('/register-process'));

    $routes->add('logout', new Routing\Route('/logout'));

    $routes->add('tweet-new', new Routing\Route('/tweet-new'));
    $routes->add('tweet-new-process', new Routing\Route('/tweet-new-process'));

    return $routes;