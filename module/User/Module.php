<?php
/**
 * Created by PhpStorm.
 * User: matveev
 * Date: 5/21/15
 * Time: 11:24 AM
 */

namespace User;


use User\Controllers\UserController;
use User\Listener\UserListener;
use User\Service\LoginForm;
use User\Service\RegisterForm;
use User\Service\UserRegister;
use Zend\Di\ServiceLocatorInterface;
use Zend\ModuleManager\Feature\AutoloaderProviderInterface;
use Zend\ModuleManager\Feature\ConfigProviderInterface;
use Zend\ModuleManager\Feature\ControllerProviderInterface;
use Zend\ModuleManager\Feature\ServiceProviderInterface;
use Zend\Mvc\MvcEvent;
use Zend\ServiceManager\ServiceManager;

class Module implements AutoloaderProviderInterface,
                        ConfigProviderInterface,
                        ControllerProviderInterface,
                        ServiceProviderInterface
{

    public function onBootstrap(MvcEvent $event)
    {
        $application = $event->getApplication();
        $sm = $application->getServiceManager();
        $em = $application->getEventManager();

        $em->attachAggregate($sm->get(UserListener::ALIAS));
    }
    /**
     * Return an array for passing to Zend\Loader\AutoloaderFactory.
     *
     * @return array
     */
    public function getAutoloaderConfig()
    {
        return [
            'Zend\Loader\StandardAutoloader' => [
                'namespaces' => [
                    __NAMESPACE__ => __DIR__ . '/src/' . __NAMESPACE__
                ]
            ]
        ];
    }

    /**
     * Returns configuration to merge with application configuration
     *
     * @return array|\Traversable
     */
    public function getConfig()
    {
        return include __DIR__ . '/config/module.config.php';
    }

    /**
     * Expected to return \Zend\ServiceManager\Config object or array to seed
     * such an object.
     *
     * @return array|\Zend\ServiceManager\Config
     */
    public function getControllerConfig()
    {
        return [
            'invokables' => []
        ];
    }

    /**
     * Expected to return \Zend\ServiceManager\Config object or array to
     * seed such an object.
     *
     * @return array|\Zend\ServiceManager\Config
     */
    public function getServiceConfig()
    {
        return [
            'invokables' => [
                UserRegister::ALIAS => 'User\Service\UserRegister',
                RegisterForm::ALIAS => 'User\Service\RegisterFrom',
            ],
            'factories' => [
                UserListener::ALIAS => function(ServiceManager $serviceManager){
                    return new UserListener($serviceManager);
                },
                LoginForm::ALIAS => function(ServiceManager $serviceManager){
                    return new LoginForm($serviceManager);
                }
            ]
        ];
    }
}