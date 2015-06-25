<?php
/**
 * Created by PhpStorm.
 * User: matveev
 * Date: 5/26/15
 * Time: 1:55 PM
 */

namespace User\Repository;

use Doctrine\ORM\EntityRepository;

class UserRepository extends EntityRepository
{
    public function getUsers()
    {
        return $this->_em->createQueryBuilder()
            ->select('u, r')
            ->from($this->_entityName, 'u')
            ->join('u.roles', 'r');
    }
}
