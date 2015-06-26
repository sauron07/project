<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2015 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Application\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\Mvc\MvcEvent;
use Zend\View\Model\ViewModel;

class IndexController extends AbstractActionController
{
    const ALIAS = 'Application\IndexController';

    public function onBootstrap(MvcEvent $event)
    {
        var_dump($event->getRouteMatch()->getParams());
    }

    public function indexAction()
    {
        return new ViewModel();
    }
}
