<?php

namespace Application\Interfaces;

use Doctrine\ORM\EntityManager;

/**
 * Interface EntityManagerAwareInterface
 *
 * No needed to initialise doctrine entity manager every ware. Just implement this interface and
 * use Application\Traits\EntityManagerAwareTrait in every service. If needed $entityManager in controller, need to
 * realize 'EntityManager' for getControllerConfig method in Module.php
 *
 * @package Application\Interfaces
 */
interface EntityManagerAwareInterface
{
    /**
     * @param EntityManager $em
     *
     * @return mixed
     */
    public function setEntityManager(EntityManager $em);
}
