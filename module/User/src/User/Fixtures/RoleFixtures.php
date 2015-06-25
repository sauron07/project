<?php

namespace User\Fixtures;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use User\Entity\Role;

class RoleFixtures extends AbstractFixture implements OrderedFixtureInterface
{

    /**
     * Load data fixtures with the passed EntityManager
     *
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        $admin = new Role();
        $admin->setRoleId('admin');

        $user = new Role();
        $user->setRoleId('user');

        $guest = new Role();
        $guest->setRoleId('guest');

        $manager->persist($admin);
        $manager->persist($user);
        $manager->persist($guest);
        $manager->flush();
    }

    /**
     * Get the order of this fixture
     *
     * @return integer
     */
    public function getOrder()
    {
        return 1;
    }
}
