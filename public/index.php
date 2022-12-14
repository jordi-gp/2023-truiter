<?php
    require_once __DIR__ . '/../bootstrap.php';

    use Symfony\Component\HttpKernel\Controller\ArgumentResolver;
    use Symfony\Component\HttpKernel\Controller\ControllerResolver;
    use Symfony\Component\Routing;

    use Symfony\Component\HttpFoundation\Request;
    use Symfony\Component\HttpFoundation\Response;

    $request = Request::createFromGlobals();

    $routes = include __DIR__ . '/../routes.php';

    $context = new Routing\RequestContext();
    $context->fromRequest($request);

    $matcher = new Routing\Matcher\UrlMatcher($routes, $context);

    $controllerResolver = new ControllerResolver();
    $argumentResolver = new ArgumentResolver();

    try {
        $request->attributes->add($matcher->match($request->getPathInfo()));

        $controller = $controllerResolver->getController($request);
        #var_dump($request);
        var_dump($controller);
        $arguments = $argumentResolver->getArguments($request, $controller);
        #var_dump($arguments);

        $response = call_user_func_array($controller, $arguments);
        #var_dump($response);
    } catch (Routing\Exception\ResourceNotFoundException $exception) {
        $response = new Response('404 Page Not Found', Response::HTTP_NOT_FOUND);
        #$response->send();
    } catch (Exception $exception) {
        $response = new Response('An error occurred', Response::HTTP_INTERNAL_SERVER_ERROR);
        echo $exception->getMessage();
        #$response->send();
    }
    $response->send();