<?php
    require_once __DIR__ . '/../bootstrap.php';

    use Symfony\Component\Routing;

    use Symfony\Component\HttpFoundation\Request;
    use Symfony\Component\HttpFoundation\Response;

    $request = Request::createFromGlobals();

    $routes = include __DIR__ . '/../routes.php';

    $context = new Routing\RequestContext();
    $context->fromRequest($request);

    $matcher = new Routing\Matcher\UrlMatcher($routes, $context);

    try {
        extract($matcher->match($request->getPathInfo()), EXTR_SKIP);
        include sprintf(__DIR__ . '/../%s.php', $_route);
    } catch (Routing\Exception\ResourceNotFoundException $exception) {
        $response = new Response('Not Found', Response::HTTP_NOT_FOUND);
    } catch (Exception $exception) {
        $response = new Response('An error occurred', Response::HTTP_INTERNAL_SERVER_ERROR);
    }

    $response->send();