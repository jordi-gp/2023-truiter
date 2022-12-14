<?php
    use Symfony\Component\Routing;

    $routes = new Routing\RouteCollection();

    # Índex, pàgina principal
    $routes->add('index', new Routing\Route(
        path: '/',
        defaults: ['_controller'=>'App\Controller\DefaultController::index']
    ));

    # Formulari d'inici de sessió
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

    # Formulari de registre
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

    # Tancament de sessió
    $routes->add('logout', new Routing\Route(
       path: '/logout',
       defaults: ['_controller'=>'App\Controller\DefaultController::logout'],
       methods: ['GET']
    ));

    # Afegiment de tweets
    $routes->add('tweet-new', new Routing\Route(
        path: '/tweet-new',
        defaults: ['_controller'=>'App\Controller\DefaultController::tweet_new'],
        methods: ['GET']
    ));

    $routes->add('tweet-new-process', new Routing\Route(
        path: '/tweet-new-process',
        defaults: ['_controller'=>'App\Controller\DefaultController::tweet_new_process'],
        methods: ['POST']
    ));

    #Explorador per categories
    $routes->add('explore', new Routing\Route(
        path: '/explore',
        defaults: ['_controller'=>'App\Controller\DefaultController::explore'],
        methods: ['POST', 'GET']
    ));

    # Buscador de Tweets per contingut
    $routes->add('find-tweets', new Routing\Route(
        path: '/find-tweets',
        defaults: ['_controller'=>'App\Controller\DefaultController::find_tweets'],
        methods: ['POST']
    ));

    /*$routes->add('found-tweets', new Routing\Route(
        path: '/found-tweets',
        defaults: ['_controller'=>'App\Controller\DefaultController::found_tweets'],
        methods: ['GET']
    ));*/

    return $routes;