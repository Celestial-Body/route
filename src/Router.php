<?php
declare(strict_types=1);
/**
 * Genial Route.
 *
 * @author  Nicholas English <nenglish0820@outlook.com>.
 *
 * @link    <https://github.com/Genial-Framework/Route> Github repository.
 * @license <https://github.com/Genial-Framework/Route/blob/master/LICENSE> BSD 3-Clause.
 */

namespace Genial\Route;

use function strpos;
use function substr;
use function rawurldecode;
use function call_user_func_array;

/**
 * Router.
 */
class Router implements RouterInterface
{

    /**
     * @var RouteCollection|null $collections The route collection.
     */
    private $collection = null;
    
    /**
     * Create a new router.
     *
     * @param RouteCollection $collection The route collection.
     *
     * @return void Return nothing.
     */
    public function __construct(RouteCollection $collection)
    {
        $this->collection = $collection;
        $this->uri = new Uri;
    }
    
    /**
     * Run the router and render a response.
     *
     * @param string $method The request method.
     * @param string $uri    The request uri.
     *
     * @return string The rendered response.
     */
    public function response(string $method, string $uri): string
    {
        if (false !== $pos = strpos($uri, '?')) {
            $uri = substr($uri, 0, $pos);
        }
        $uri = rawurldecode($uri);
        $routes = $this->collection->getRoutes;
        foreach ($routes as $routeName => $routeInfo) {
            if ($this->uri->matches($uri, $routeInfo['path']) && $method == $routeInfo['method']) {
                return (string) call_user_func_array(array($routeInfo['controller'], 'index'), $this->uri->getRouteParams($uri));
            }
        }
        return '';
    }
    
}
