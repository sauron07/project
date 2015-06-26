<?php
namespace Admin;

use Admin\Controllers\IndexController;
use Admin\Controllers\UserController;
use Admin\Service\IndexService;
use Admin\Service\UserService;
use Admin\Table\User;
use Zend\ModuleManager\Feature\AutoloaderProviderInterface;
use Zend\ModuleManager\Feature\ConfigProviderInterface;
use Zend\ModuleManager\Feature\ControllerProviderInterface;
use Zend\ModuleManager\Feature\ServiceProviderInterface;
use Zend\ModuleManager\Feature\ViewHelperProviderInterface;
use Zend\Mvc\Controller\ControllerManager;

/**
 * Class Module
 * @package Admin
 */
class Module implements
    AutoloaderProviderInterface,
    ConfigProviderInterface,
    ControllerProviderInterface,
    ServiceProviderInterface,
    ViewHelperProviderInterface
{
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
            'invokables' => [
            ],
            'factories'  => [
                IndexController::ALIAS => function (ControllerManager $cm) {
                    $zfcUserConfig = $cm->getServiceLocator()->get('zfcuser_module_options');
                    $zfcUserConfig->setEnableRegistration(false);

                    return new IndexController();
                },
                UserController::ALIAS  => function (ControllerManager $controllerManager) {
                    /** @var UserService $userService */
                    $userService = $controllerManager->getServiceLocator()->get(UserService::ALIAS);
                    /** @var User $userTable */
                    $userTable   = $controllerManager->getServiceLocator()->get(User::ALIAS);

                    return new UserController($userService, $userTable);
                }
            ]
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
                IndexService::ALIAS => 'Admin\Service\IndexService',
                UserService::ALIAS  => 'Admin\Service\UserService',
                User::ALIAS         => 'Admin\Table\User'
            ]
        ];
    }

    /**
     * Expected to return \Zend\ServiceManager\Config object or array to
     * seed such an object.
     *
     * @return array|\Zend\ServiceManager\Config
     */
    public function getViewHelperConfig()
    {
        return [
            'invokables' => [
                ViewHelper\StateHelper::ALIAS => 'Admin\ViewHelper\StateHelper' //
            ]
        ];
    }
}
