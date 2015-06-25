<?php
/**
 * Created by PhpStorm.
 * User: matveev
 * Date: 5/21/15
 * Time: 3:24 PM
 */

namespace User\Service;

use Zend\EventManager\Event;

/**
 * Class RegisterFrom
 *
 * Class provides ability to edit registration form
 * @package User\Service
 */
class RegisterForm
{
    const ALIAS = 'User\Service\RegisterForm';

    /**
     * Add more fields to register form, or do something else
     *
     * @param Event $event
     */
    public function onFormInit(Event $event)
    {
        /** @var \ZfcUser\Form\Register $target */
        $target = $event->getTarget();
    }

    /**
     * Change validation rules
     *
     * @param Event $event
     */
    public function onFormFilterInit(Event $event)
    {
        /** @var \ZfcUser\Form\RegisterFilter $target */
        $target = $event->getTarget();
    }
}
