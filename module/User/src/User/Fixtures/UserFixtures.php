<?php
/**
 * Created by PhpStorm.
 * User: matveev
 * Date: 6/23/15
 * Time: 5:31 PM
 */

namespace User\Fixtures;


use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use User\Entity\User;

class UserFixtures extends AbstractFixture implements OrderedFixtureInterface
{

    /**
     * Load data fixtures with the passed EntityManager
     *
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        $admin = new User();
        $admin->setEmail('admin@admin.com');
        $admin->setUsername('admin');
        $admin->setPassword('$2y$14$s8SdLylmuKoIlR4tvUAV9OckPj.0dt4E5US1d9tyRA96oqt8iCELC');
        $admin->setState(1);
        $admin->addRole($manager->getRepository('User\Entity\Role')->find(1));

        $manager->persist($admin);
        $manager->flush();
    }

    /**
     * Get the order of this fixture
     *
     * @return integer
     */
    function getOrder()
    {
        return 2;
    }
}