<?php
/**
 * Created by PhpStorm.
 * User: matveev
 * Date: 5/21/15
 * Time: 3:18 PM
 */

namespace User\Service;

use Zend\EventManager\Event;

/**
 * Class UserRegister
 *
 * Class provides ability to do something before and after registration
 * @package User\Service
 */
class UserRegister
{
    const ALIAS = 'User\Service\UserRegister';

    /**
     * Do something before registration
     *
     * @param Event $e
     */
    public function onRegister(Event $e)
    {
        /** @var \ZfcUser\Service\User $target */
        $target = $e->getTarget();
        $sm     = $target->getServiceManager();
        /** @var \Doctrine\ORM\EntityManager $em */
        $em = $sm->get('Doctrine\ORM\EntityManager');
        /** @var \User\Entity\User $user */
        $user   = $e->getParam('user');
        $config = $sm->get('config');

        $criteria = ['roleId' => $config['zfcuser']['new_user_default_role']];
        /** @var \User\Entity\Role $defaultUserRole */
        $defaultUserRole = $em->getRepository('User\Entity\Role')->findOneBy($criteria);

        if ($defaultUserRole !== null) {
            $user->addRole($defaultUserRole);
        }
    }

    /**
     * Do something after registration
     *
     * @param Event $e
     */
    public function onRegisterPost(Event $e)
    {
        $user = $e->getParam('user');
        $form = $e->getParam('form');
    }
}
