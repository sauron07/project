<?php

namespace User\Service;

use Zend\Mvc\Application;
use Zend\Mvc\Router\Http\RouteMatch;
use Zend\Mvc\Router\RouteInterface;
use Zend\Mvc\Router\Exception;
use Zend\Http\PhpEnvironment\Response;
use ZfcUser\Options\ModuleOptions;

/**
 * Buils a redirect response based on the current routing and parameters
 */
class RedirectCallback
{
    const ALIAS = 'User\Service\redirectCallback';

    /** @var RouteInterface  */
    private $router;

    /** @var Application */
    private $application;

    /** @var ModuleOptions */
    private $options;

    /**
     * @param Application $application
     * @param RouteInterface $router
     * @param ModuleOptions $options
     */
    public function __construct(Application $application, RouteInterface $router, ModuleOptions $options)
    {
        $this->router = $router;
        $this->application = $application;
        $this->options = $options;
    }

    /**
     * @return Response
     */
    public function __invoke()
    {
        $routeMatch = $this->application->getMvcEvent()->getRouteMatch();
        $redirect = $this->getRedirect($routeMatch, $this->getRedirectRouteFromRequest());

        $response = $this->application->getResponse();
        $response->getHeaders()->addHeaderLine('Location', $redirect);
        $response->setStatusCode(302);
        return $response;
    }

    /**
     * Return the redirect from param.
     * First checks GET then POST
     * @return string
     */
    private function getRedirectRouteFromRequest()
    {
        $request  = $this->application->getRequest();
        $redirect = $request->getQuery('redirect');
        if ($redirect) {
            return $redirect;
        }

        $redirect = $request->getPost('redirect');
        if ($redirect) {
            return $redirect;
        }

        return false;
    }

    /**
     * @param $route
     * @return bool
     */
    private function routeExists($route)
    {
        try {
            $this->router->assemble(array(), array('name' => $route));
        } catch (Exception\RuntimeException $e) {
            return false;
        }
        return true;
    }

    /**
     * Returns the url to redirect to based on current route.
     * If $redirect is set and the option to use redirect is set to true, it will return the $redirect url.
     *
     * @param string|RouteMatch $currentRoute
     * @param bool              $redirect
     *
     * @return mixed
     */
    protected function getRedirect(RouteMatch $currentRoute, $redirect = false)
    {
        $useRedirect = $this->options->getUseRedirectParameterIfPresent();
        $routeExists = ($redirect && $this->routeExists($redirect));
        if (!$useRedirect || !$routeExists) {
            $redirect = false;
        }

        switch ($currentRoute->getMatchedRouteName()) {
            case 'home/zfcuser/register':
            case 'home/zfcuser/login':
                $route = ($redirect) ?: $this->options->getLoginRedirectRoute();
                return $this->router->assemble($currentRoute->getParams(), array('name' => $route));
                break;
            case 'hone/zfcuser/logout':
                $route = ($redirect) ?: $this->options->getLogoutRedirectRoute();
                return $this->router->assemble($currentRoute->getParams(), array('name' => $route));
                break;
            default:
                return $this->router->assemble($currentRoute->getParams(), array('name' => 'home/zfcuser'));
        }
    }
}
