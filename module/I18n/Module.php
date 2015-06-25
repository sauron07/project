<?php

namespace I18n;


use Application\Interfaces\TranslatorAwareInterface;
use I18n\Loader\DbLoader;
use I18n\Translator\Translator;
use Zend\ModuleManager\Feature\AutoloaderProviderInterface;
use Zend\ModuleManager\Feature\ConfigProviderInterface;
use Zend\ModuleManager\Feature\ControllerProviderInterface;
use Zend\ModuleManager\Feature\ServiceProviderInterface;
use Zend\ModuleManager\Feature\ViewHelperProviderInterface;
use Zend\Mvc\Controller\ControllerManager;
use Zend\Mvc\Service\ControllerLoaderFactory;
use Zend\ServiceManager\ServiceLocatorInterface;

class Module implements ConfigProviderInterface,
                        AutoloaderProviderInterface,
                        ServiceProviderInterface,
                        ControllerProviderInterface,
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
     * Expected to return \Zend\ServiceManager\Config object or array to
     * seed such an object.
     *
     * @return array|\Zend\ServiceManager\Config
     */
    public function getServiceConfig()
    {
        return [
            'factories' => [
                'MvcTranslator' => function(ServiceLocatorInterface $sm){
                    $loader = $sm->get('I18n\Loader\DbLoader');

                    $translator = new Translator();
                    $translator->getPluginManager()->setService('I18n\Loader\DbLoader', $loader);
                    $translator->addRemoteTranslations('I18n\Loader\DbLoader');
                    return $translator;
                },
                'I18n\Loader\DbLoader' => function(ServiceLocatorInterface $sm){
                    return new DbLoader($sm->get('Doctrine\ORM\EntityManager'));
                }
            ],
            'initializers' => [
                'Translator' => function($instance, ServiceLocatorInterface $sm){
                    if($instance instanceof TranslatorAwareInterface){
                        $instance->setTranslator($sm->get('MvcTranslator'));
                    }
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
            'initializers' => [
                'TranslatorController' => function($instance, ControllerManager $controllerManager){
                    if($instance instanceof TranslatorAwareInterface){
                        $instance->setTranslator($controllerManager->getServiceLocator()->get('MvcTranslator'));
                    }
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
    public function getViewHelperConfig()
    {
        return [
            'invokables' => [
                'translate' => 'I18n\Helper\Translate'
            ]
        ];
    }
}