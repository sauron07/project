<?php
/**
 * Created by PhpStorm.
 * User: matveev
 * Date: 5/21/15
 * Time: 3:24 PM
 */

namespace User\Service;

use Zend\EventManager\Event;
use Zend\ServiceManager\ServiceLocatorInterface;
use Zend\ServiceManager\ServiceManager;

/**
 * Class RegisterFrom
 *
 * Class provides ability to edit registration form
 * @package User\Service
 */
class LoginForm
{
    const ALIAS = 'User\Service\LoginForm';

    /** @var  ServiceManager */
    private $sm;

    public function __construct($sm)
    {
        $this->sm = $sm;
    }

    /**
     * Add more fields to register form, or do something else
     *
     * @param Event $event
     */
    public function onFormInit(Event $event)
    {
        /** @var \ZfcUser\Form\Register $target */
        $target = $event->getTarget();
        $request = $this->sm->get('request');
        if(strpos($request->getRequestUri(), '/admin') !== false){
            $target->add(
                array(
                    'type' => 'Hidden',
                    'name' => 'redirect',
                    'attributes' => array(
                        'value' => 'zfcadmin'
                    )
                )
            );
        }
    }

    /**
     * Change validation rules
     *
     * @param Event $event
     */
    public function onFormFilterInit(Event $event)
    {

    }
}