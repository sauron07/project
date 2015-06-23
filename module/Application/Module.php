<?php

namespace Application;

use Application\Controller\IndexController;
use Application\Interfaces\EntityManagerAwareInterface;
use Application\View\UnauthorizedStrategy;
use Redis\Service\RedisStorage;
use Zend\ModuleManager\Feature\ControllerProviderInterface;
use Zend\ModuleManager\Feature\ServiceProviderInterface;
use Zend\ModuleManager\ModuleEvent;
use Zend\ModuleManager\ModuleManager;
use Zend\Mvc\ModuleRouteListener;
use Zend\Mvc\MvcEvent;
use Zend\Mvc\View\Http\RouteNotFoundStrategy;
use Zend\ServiceManager\ServiceLocatorInterface;
use Zend\ServiceManager\ServiceManager;
use Zend\Stdlib\InitializableInterface;

/**
 * Class Module
 * @package Application
 */
class Module implements ServiceProviderInterface,
                        ControllerProviderInterface
{
    /**
     * @param ModuleManager $moduleManager
     */
    public function init(ModuleManager $moduleManager)
    {
        $events = $moduleManager->getEventManager();
        $events->attach(ModuleEvent::EVENT_MERGE_CONFIG, array($this, 'onMergeConfig'));
    }

    /**
     * @param MvcEvent $e
     */
    public function onBootstrap(MvcEvent $e)
    {
        $eventManager        = $e->getApplication()->getEventManager();
        $moduleRouteListener = new ModuleRouteListener();
        $moduleRouteListener->attach($eventManager);
        /** @var ServiceManager $serviceManager */
        $serviceManager = $e->getApplication()->getServiceManager();
        $serviceManager->addInitializer([$this, 'initializerCallback']);
        /** @var \Redis\Service\RedisStorage $storage */
        $storage = $serviceManager->get(RedisStorage::ALIAS);
        $storage->setSessionStorage();
    }

    /**
     * @param $instance
     *
     * @return mixed
     */
    public function initializerCallback($instance)
    {
        if($instance instanceof InitializableInterface){
            $instance->init();
        }
        return $instance;
    }

    /**
     * Remove entities from dudapiotr module to use orm:create without creating extra tables (customer and product)
     *
     * @param ModuleEvent $e
     */
    public function onMergeConfig(ModuleEvent $e)
    {
        $configListener = $e->getConfigListener();
        $config         = $configListener->getMergedConfig(false);

        if (array_key_exists('application_entities', $config['doctrine']['driver'])) {
            unset($config['doctrine']['driver']['application_entities'],
                  $config['doctrine']['driver']['orm_default']['drivers']['ZfTable\Entity']
            );
        }
        $configListener->setMergedConfig($config);
    }

    /**
     * @return mixed
     */
    public function getConfig()
    {
        return include __DIR__ . '/config/module.config.php';
    }

    /**
     * @return array
     */
    public function getAutoloaderConfig()
    {
        return array(
            'Zend\Loader\StandardAutoloader' => array(
                'namespaces' => array(
                    __NAMESPACE__ => __DIR__ . '/src/' . __NAMESPACE__
                )
            )
        );
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
            'initializers' => [
                'EntityManager' => function ($instance, ServiceLocatorInterface $sm) {
                    if ($instance instanceof EntityManagerAwareInterface) {
                        /** @var \Doctrine\ORM\EntityManager $em */
                        $em = $sm->get('Doctrine\ORM\EntityManager');
                        /** @var \Application\Interfaces\EntityManagerAwareInterface $instance */
                        $instance->setEntityManager($em);
                    }
                }
            ],
            'factories' => [
                'Application\View\UnauthorizedStrategy' => function(ServiceLocatorInterface $sm){
                    /** @var RouteNotFoundStrategy $notFoundStrategy */
                    $notFoundStrategy = $sm->get('404strategy');
                    $auth = $sm->get('zfcuser_auth_service');
                    return new UnauthorizedStrategy($notFoundStrategy, $auth);
                }
            ]
        ];
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
                IndexController::ALIAS => 'Application\Controller\IndexController',
            ]
        ];
    }
}
