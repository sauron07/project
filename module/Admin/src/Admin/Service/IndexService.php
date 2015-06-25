<?php
namespace Admin\Service;

use Application\Interfaces\EntityManagerAwareInterface;
use Application\Traits\EntityManagerAwareTrait;

/**
 * Class IndexService
 * @package Admin\Services
 */
class IndexService implements EntityManagerAwareInterface
{
    use EntityManagerAwareTrait;

    const ALIAS = 'Admin\IndexService';

    /**
     * @return string
     */
    public function test()
    {
        return 'lalka';
    }
}
