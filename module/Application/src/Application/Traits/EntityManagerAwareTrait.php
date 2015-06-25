<?php

namespace Application\Traits;

use Doctrine\ORM\EntityManager;

/**
 * Class EntityManagerAwareTrait
 *
 * Implementation fom EntityManagerAwareInterface
 * @package Application\Traits
 */
trait EntityManagerAwareTrait
{
    /**
     * @var EntityManager
     */
    public $entityManager;

    /**
     * @return EntityManager
     */
    public function getEntityManager()
    {
        return $this->entityManager;
    }

    /**
     * @param EntityManager $entityManager
     */
    public function setEntityManager(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
    }
}
