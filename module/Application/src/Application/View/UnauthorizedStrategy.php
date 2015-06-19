<?php
/**
 * Created by PhpStorm.
 * User: matveev
 * Date: 5/21/15
 * Time: 5:21 PM
 */

namespace Application\View;


use Zend\Authentication\AuthenticationService;
use Zend\EventManager\EventManagerInterface;
use Zend\EventManager\ListenerAggregateInterface;
use Zend\Http\Response as HttpResponse;
use Zend\Mvc\MvcEvent;
use Zend\Mvc\Router\Http\RouteMatch;
use Zend\Mvc\View\Http\RouteNotFoundStrategy;
use Zend\Stdlib\ResponseInterface as Response;

class UnauthorizedStrategy implements ListenerAggregateInterface
{
    /** @var \Zend\Stdlib\CallbackHandler[] */
    protected $listeners = array();

    /** @var RouteNotFoundStrategy  */
    protected $notFoundStrategy;

    /** @var  AuthenticationService */
    protected $authenticationService;

    public function __construct(RouteNotFoundStrategy $notFoundStrategy, AuthenticationService $authenticationService)
    {
        $this->notFoundStrategy = $notFoundStrategy;
        $this->authenticationService = $authenticationService;
    }

    /**
     * Attach one or more listeners
     *
     * @param EventManagerInterface $events
     */
    public function attach(EventManagerInterface $events)
    {
        $this->listeners[] = $events->attach(MvcEvent::EVENT_DISPATCH_ERROR, [$this, 'onDispatchError'], -5000);
    }

    /**
     * Detach all previously attached listeners
     *
     * @param EventManagerInterface $events
     *
     * @return void
     */
    public function detach(EventManagerInterface $events)
    {
        foreach ($this->listeners as $index => $listener){
            if($events->detach($listener)){
                unset($this->listeners[$index]);
            }
        }
    }

    public function onDispatchError(MvcEvent $e)
    {
        //Do nothing if the result is a response object
        $result = $e->getResult();
        if($result instanceof Response){
            return;
        }

        $router = $e->getRouter();
        $match = $e->getRouteMatch();

        $response = $e->getResponse();
        if(!$response){
            $response = new HttpResponse();
            $e->setResponse($response);
        }

        // if route not found go to 404 page
        if($match === null){
            $this->notFoundStrategy->prepareNotFoundViewModel($e);
            return;
        }

        //get url to the zfcuser/login route
        $options['name'] = 'zfcuser/login';
        //redirect if needed to show login form on admin/ route not only admin/login
        if(strpos($match->getMatchedRouteName(), 'zfcadmin') >= 0){
            $options['name'] = 'home';
        }

        if($this->authenticationService->hasIdentity() && $this->authenticationService->getIdentity()->isAdmin()) {
            $options['name'] = 'zfcadmin';
        }

        $url = $router->assemble([], $options);

        // Work out where were we trying to het to
        $options['name'] = $match->getMatchedRouteName();
        $redirect = $router->assemble($match->getParams(), $options);

        // Set up response to redirect to login page

        //remove in production env
        $response->getHeaders()->addHeaderLine('Location', $url . '?redirect='.$redirect);
        $response->setStatusCode(302);

    }
}