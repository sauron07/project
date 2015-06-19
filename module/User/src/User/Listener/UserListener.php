<?php
/**
 * Created by PhpStorm.
 * User: matveev
 * Date: 5/21/15
 * Time: 1:59 PM
 */

namespace User\Listener;


use User\Service\LoginForm;
use Zend\EventManager\AbstractListenerAggregate;
use Zend\EventManager\EventManagerInterface;
use Zend\ServiceManager\ServiceManager;

class UserListener extends AbstractListenerAggregate
{
    const ALIAS = 'User\Listener\UserListener';

    /** @var  ServiceManager */
    protected $sm;

    public function __construct(ServiceManager $sm)
    {
        $this->sm = $sm;
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
        $sharedManager = $events->getSharedManager();
        $this->listeners[] = $sharedManager->attach('ZfcUser\Service\User', 'register', ['User\Service\UserRegister', 'onRegister']);
        $this->listeners[] = $sharedManager->attach('ZfcUser\Service\User', 'register.post', ['User\Service\UserRegister', 'onRegisterPost']);

        $this->listeners[] = $sharedManager->attach('ZfcUser\Form\Register', 'init', ['User\Service\RegisterForm', 'onFormInit']);
        $this->listeners[] = $sharedManager->attach('ZfcUser\Form\RegisterFilter', 'init', ['User\Service\RegisterForm', 'onFormFilterInit']);

        $this->listeners[] = $sharedManager->attach('ZfcUser\Form\Login', 'init', [$this->sm->get(LoginForm::ALIAS), 'onFormInit']);
        $this->listeners[] = $sharedManager->attach('ZfcUser\Form\LoginFilter', 'init', [$this->sm->get(LoginForm::ALIAS), 'onFormFilterInit']);
    }
}