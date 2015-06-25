<?php
/**
 * Created by PhpStorm.
 * User: matveev
 * Date: 5/25/15
 * Time: 3:52 PM
 */

namespace Admin\Service;


use Application\Interfaces\EntityManagerAwareInterface;
use Application\Interfaces\TranslatorAwareInterface;
use Application\Traits\EntityManagerAwareTrait;
use User\Repository\UserRepository;
use Application\Traits\TranslatorAwareTrait;

class UserService implements EntityManagerAwareInterface,
                             TranslatorAwareInterface
{
    use EntityManagerAwareTrait;
    use TranslatorAwareTrait;

    const ALIAS = 'Admin\UserService';

    public function listAction()
    {
        /** @var UserRepository $userRepo */
        $userRepo = $this->getEntityManager()->getRepository('User\Entity\User');
        return $userRepo->getUsers();
    }

}