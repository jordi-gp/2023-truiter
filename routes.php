<?php
    use Symfony\Component\Routing;

    $routes = new Routing\RouteCollection();

    $routes->add('index', new Routing\Route('/'));

    $routes->add('login', new Routing\Route('/login'));
    $routes->add('login-process', new Routing\Route('/login-process'));

    $routes->add('logout', new Routing\Route('/logout'));

    $routes->add('tweet-new', new Routing\Route('/tweet-new'));
    $routes->add('tweet-new-process', new Routing\Route('/tweet-new-process'));

    return $routes;