<?php
    require_once __DIR__ . '/../bootstrap.php';

    use Symfony\Component\Routing;

    use Symfony\Component\HttpFoundation\Request;
    use Symfony\Component\HttpFoundation\Response;
    use Symfony\Component\HttpFoundation\RedirectResponse;

    $request = Request::createFromGlobals();

    $routes = include __DIR__ . '/../routes.php';

    $context = new Routing\RequestContext();
    $context->fromRequest($request);

    $matcher = new Routing\Matcher\UrlMatcher($routes, $context);

    try {
        extract($matcher->match($request->getPathInfo()), EXTR_SKIP);
        include sprintf(__DIR__ . '/../%s.php', $_route);
    } catch (Routing\Exception\ResourceNotFoundException $exception) {
        $response = new Response('404 Page Not Found', Response::HTTP_NOT_FOUND);
        $response->send();
    } catch (Exception $exception) {
        $response = new Response('An error occurred', Response::HTTP_INTERNAL_SERVER_ERROR);
        echo $exception->getMessage();
        $response->send();
    }