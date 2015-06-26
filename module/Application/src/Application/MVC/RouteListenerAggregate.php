<?php
/**
 * @author: matveev
 * @date: 6/26/15
 * @time: 2:00 PM
 */

namespace Application\MVC;

use I18n\Translator\Translator;
use Zend\EventManager\AbstractListenerAggregate;
use Zend\EventManager\EventManagerInterface;
use Zend\Mvc\MvcEvent;
use Zend\Session\Container;

class RouteListenerAggregate extends AbstractListenerAggregate
{
    const ALIAS = 'Application\RouteListenerAggregate';

    /** @var  Container */
    private $session;

    public function __construct(Container $sessionContainer)
    {
        $this->session = $sessionContainer;
    }

    /**
     * Attach one or more listeners
     *
     * Implementors may add an optional $priority argument; the EventManager
     * implementation will pass this to the aggregate.
     *
     * @param EventManagerInterface $events
     *
     * @return void
     */
    public function attach(EventManagerInterface $events)
    {
        $this->listeners[] = $events->attach(MvcEvent::EVENT_ROUTE, array($this, 'onRoute'));
    }

    public function onRoute(MvcEvent $event)
    {
        $routeMatch = $event->getRouteMatch();

        //have lang in route and continue to use it
        if(array_key_exists('lang', $routeMatch->getParams()) && $routeMatch->getParam('lang') !== ''){
            if($routeMatch->getParam('lang') !== $this->session->offsetGet('lang')){
                $this->session->offsetSet('lang', $routeMatch->getParam('lang'));
            }
            return $routeMatch->setParam('lang', $routeMatch->getParam('lang'));
        }
        $routeMatch->setParam('lang', $this->session->offsetGet('lang') ?: Translator::DEFAULT_LANG);
    }
}
