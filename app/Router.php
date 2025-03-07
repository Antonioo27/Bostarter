<?php

namespace App;

use Symfony\Component\Routing\RequestContext;
use Symfony\Component\Routing\RouteCollection;
use Symfony\Component\Routing\Matcher\UrlMatcher;
use Symfony\Component\Routing\Exception\ResourceNotFoundException;

class Router
{
    public function __invoke(RouteCollection $routes)
    {
        // Creazione del contesto della richiesta
        $context = new RequestContext();
        $context->setMethod($_SERVER['REQUEST_METHOD']);
        $context->setBaseUrl('');
        $context->setPathInfo(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH));

        // Creazione del matcher per confrontare la richiesta con le rotte
        $matcher = new UrlMatcher($routes, $context);

        try {
            // Otteniamo il percorso richiesto
            $path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
            $match = $matcher->match($path);

            // Creazione del controller e chiamata del metodo corrispondente
            $controllerClass = "\\App\\Controllers\\" . $match['controller'];
            $method = $match['method'];

            if (class_exists($controllerClass) && method_exists($controllerClass, $method)) {
                $controller = new $controllerClass();
                $controller->$method($routes);
            } else {
                throw new ResourceNotFoundException();
            }
        } catch (ResourceNotFoundException $e) {
            http_response_code(404);
            echo "Errore 404: Pagina non trovata.";
        } catch (\Exception $e) {
            http_response_code(500);
            echo "Errore interno del server: " . $e->getMessage();
        }
    }
}
