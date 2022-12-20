<?php
    use Symfony\Component\Routing;

    $routes = new Routing\RouteCollection();

    const NAME_SPACE = "App\\Controller\\";
    const DEFAULT_CONTROLLER = 'DefaultController';
    const SESSION_CONTROLLER = 'SessionController';
    const USER_CONTROLLER = 'UserController';
    const TWEET_CONTROLLER = 'TweetController';

    # Índex, pàgina principal
    $routes->add('index', new Routing\Route(
        path: '/',
        defaults: ['_controller' => NAME_SPACE.DEFAULT_CONTROLLER.'::index']
    ));

    # Formulari d'inici de sessió
    $routes->add('login', new Routing\Route(
        path: '/login',
        defaults: ['_controller' => NAME_SPACE.SESSION_CONTROLLER.'::login'],
        methods: ['GET']
    ));

    $routes->add('login-process', new Routing\Route(
        path: '/login-process',
        defaults: ['_controller' => NAME_SPACE.SESSION_CONTROLLER.'::login_process'],
        methods: ['POST']
    ));

    # Formulari de registre
    $routes->add('register', new Routing\Route(
        path: '/register',
        defaults: ['_controller' => NAME_SPACE.SESSION_CONTROLLER.'::register'],
        methods: ['GET']
    ));

    $routes->add('register-process', new Routing\Route(
        path: '/register-process',
        defaults: ['_controller' => NAME_SPACE.SESSION_CONTROLLER.'::register_process'],
        methods: ['POST']
    ));

    # Tancament de sessió
    $routes->add('logout', new Routing\Route(
       path: '/logout',
       defaults: ['_controller' => NAME_SPACE.SESSION_CONTROLLER.'::logout'],
       methods: ['GET']
    ));

    # Afegiment de tweets
    $routes->add('tweet-new', new Routing\Route(
        path: '/tweet/new',
        defaults: ['_controller' => NAME_SPACE.TWEET_CONTROLLER.'::tweet_new'],
        methods: ['GET']
    ));

    $routes->add('tweet-new-process', new Routing\Route(
        path: '/tweet/new/process',
        defaults: ['_controller' => NAME_SPACE.TWEET_CONTROLLER.'::tweet_new_process'],
        methods: ['POST']
    ));

    # Explorador per categories
    $routes->add('explore', new Routing\Route(
        path: '/explore',
        defaults: ['_controller' => NAME_SPACE.DEFAULT_CONTROLLER.'::explore'],
        methods: ['POST', 'GET']
    ));

    # Buscar tweet per contingut
    $routes->add('found-tweets', new Routing\Route(
        path: '/tweets/search',
        defaults: ['_controller' => NAME_SPACE.TWEET_CONTROLLER.'::find_tweets'],
        methods: ['GET']
    ));

    # Apartat del perfil d'usuari
    $routes->add('profile', new Routing\Route(
        path: '/profile',
        defaults: ['_controller' => NAME_SPACE.USER_CONTROLLER.'::profile'],
        methods: ['GET']
    ));

    # Edició de nom
    $routes->add('edit-name', new Routing\Route(
        path: '/profile/edit-name',
        defaults: ['_controller' => NAME_SPACE.USER_CONTROLLER.'::edit_name'],
        methods: ['POST', 'GET']
    ));

    $routes->add('confirm-update-name', new Routing\Route(
        path: '/profile/confirm-update-name',
        defaults: ['_controller' => NAME_SPACE.USER_CONTROLLER.'::confirm_update_name'],
        methods: ['POST']
    ));

    # Edició de nom d'usuari
    $routes->add('edit-username', new Routing\Route(
        path: '/profile/edit-username',
        defaults: ['_controller' => NAME_SPACE.USER_CONTROLLER.'::edit_username'],
        methods: ['POST', 'GET']
    ));

    $routes->add('confirm_update_username', new Routing\Route(
        path: '/profile/confirm-update-username',
        defaults: ['_controller' => NAME_SPACE.USER_CONTROLLER.'::confirm_update_username'],
        methods: ['POST']
    ));

    # Borrat d'usuari
    $routes->add('delete_user', new Routing\Route(
        path: '/profile/delete-user',
        defaults: ['_controller' => NAME_SPACE.USER_CONTROLLER.'::delete_user'],
        methods: ['POST']
    ));

    $routes->add('confirm_delete_user', new Routing\Route(
        path: '/profile/confirm-delete-user',
        defaults: ['_controller' => NAME_SPACE.USER_CONTROLLER.'::confirm_delete_user'],
        methods: ['POST']
    ));

    # Implementació d'api
    $routes->add('api_search', new Routing\Route(
        path: '/api/v1/users/search',
        defaults: ['_controller' => NAME_SPACE.DEFAULT_CONTROLLER.'::api_search'],
        methods: ['GET']
    ));

    return $routes;