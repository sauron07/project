<?php
/**
 * @author: matveev
 * @date: 6/25/15
 * @time: 7:04 PM
 */

namespace User\Controllers;

use Zend\Mvc\Application;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\Mvc\Router\RouteInterface;
use Zend\Mvc\Router\RouteMatch;
use Zend\View\Model\ViewModel;

/**
 * Class UserController
 * @author  ${USER}
 * @package User\Controllers
 */
class UserController extends AbstractActionController
{
    const ALIAS = 'User\UserController';

    /** @var  RouteMatch */
    protected $routeMatch;

    public function __construct(Application $application)
    {
        $this->routeMatch = $application->getMvcEvent()->getRouteMatch();
    }

    public function indexAction()
    {
        if (!$this->zfcUserAuthentication()->hasIdentity()) {
            return $this->redirect()->toRoute('home/zfcuser/login', $this->routeMatch->getParams());
        }
        return new ViewModel();
    }
}
