<?php
    use Symfony\Component\Routing;

    $routes = new Routing\RouteCollection();

    const NAME_SPACE = "App\\Controller\\";

    # Índex, pàgina principal
    $routes->add('index', new Routing\Route(
        path: '/',
        defaults: ['_controller'=> NAME_SPACE . 'DefaultController::index']
    ));

    # Formulari d'inici de sessió
    $routes->add('login', new Routing\Route(
        path: '/login',
        defaults: ['_controller'=> NAME_SPACE . 'SessionController::login'],
        methods: ['GET']
    ));

    $routes->add('login-process', new Routing\Route(
        path: '/login-process',
        defaults: ['_controller'=> NAME_SPACE . 'SessionController::login_process'],
        methods: ['POST']
    ));

    # Formulari de registre
    $routes->add('register', new Routing\Route(
        path: '/register',
        defaults: ['_controller'=> NAME_SPACE . 'SessionController::register'],
        methods: ['GET']
    ));

    $routes->add('register-process', new Routing\Route(
        path: '/register-process',
        defaults: ['_controller'=> NAME_SPACE . 'SessionController::register_process'],
        methods: ['POST']
    ));

    # Tancament de sessió
    $routes->add('logout', new Routing\Route(
       path: '/logout',
       defaults: ['_controller'=> NAME_SPACE . 'SessionController::logout'],
       methods: ['GET']
    ));

    # Afegiment de tweets
    $routes->add('tweet-new', new Routing\Route(
        path: '/tweet/new',
        defaults: ['_controller'=> NAME_SPACE . 'TweetController::tweet_new'],
        methods: ['GET']
    ));

    $routes->add('tweet-new-process', new Routing\Route(
        path: '/tweet/new/process',
        defaults: ['_controller'=> NAME_SPACE . 'TweetController::tweet_new_process'],
        methods: ['POST']
    ));

    # Explorador per categories
    $routes->add('explore', new Routing\Route(
        path: '/explore',
        defaults: ['_controller'=> NAME_SPACE . 'DefaultController::explore'],
        methods: ['POST', 'GET']
    ));

    # Buscar tweet per contingut
    $routes->add('found-tweets', new Routing\Route(
        path: '/tweets/search',
        defaults: ['_controller'=> NAME_SPACE . 'TweetController::find_tweets'],
        methods: ['GET']
    ));

    # Apartat del perfil d'usuari
    $routes->add('profile', new Routing\Route(
        path: '/profile',
        defaults: ['_controller'=> NAME_SPACE . 'UserController::profile'],
        methods: ['GET']
    ));

    $routes->add('edit-name', new Routing\Route(
        path: '/profile/edit-name',
        defaults: ['_controller'=> NAME_SPACE . 'UserController::edit_name'],
        methods: ['POST', 'GET']
    ));

    $routes->add('confirm-update-name', new Routing\Route(
        path: '/profile/confirm-update-name',
        defaults: ['_controller'=> NAME_SPACE . 'UserController::confirm_update_name'],
        methods: ['POST']
    ));

    $routes->add('edit-username', new Routing\Route(
        path: '/profile/edit-username',
        defaults: ['_controller'=> NAME_SPACE . 'UserController::edit_username'],
        methods: ['POST', 'GET']
    ));

    $routes->add('confirm_update_username', new Routing\Route(
        path: '/profile/confirm-update-username',
        defaults: ['_controller'=> NAME_SPACE . 'UserController::confirm_update_username'],
        methods: ['POST']
    ));

    $routes->add('delete_user', new Routing\Route(
        path: '/profile/delete-user',
        defaults: ['_controller'=> NAME_SPACE . 'UserController::delete_user'],
        methods: ['POST']
    ));

    $routes->add('confirm_delete_user', new Routing\Route(
        path: '/profile/confirm-delete-user',
        defaults: ['_controller'=> NAME_SPACE . 'UserController::confirm_delete_user'],
        methods: ['POST']
    ));

    return $routes;