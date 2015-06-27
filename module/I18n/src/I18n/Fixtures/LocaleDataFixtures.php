<?php

namespace I18n\Fixtures;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use I18n\Entity\LocaleData;

class LocaleDataFixtures extends AbstractFixture implements OrderedFixtureInterface
{

    /**
     * Load data fixtures with the passed EntityManager
     *
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        $ruLocaleEntity = $manager->find('I18n\Entity\Locale', 1);
        $ruData = [
            'skeleton_application' => 'Скелет приложения',
            'admin' => 'Админ',
            'home' => 'Домашняя',
            'sign_out' => 'Выход',
            'user' => 'Пользователь',
        ];
        $enLocaleEntity = $manager->find('I18n\Entity\Locale', 2);
        $enData = [
            'skeleton_application' => 'Skeleton Application',
            'admin' => 'Admin',
            'home' => 'Home',
            'sign_out' => 'Sign Out',
            'user' => 'User',
        ];
        foreach ($ruData as $key => $data) {
            $class = new LocaleData();
            $class->setLocale($ruLocaleEntity);
            $class->setAlias($key);
            $class->setData($data);
            $manager->persist($class);
        }
        foreach ($enData as $key => $data) {
            $class = new LocaleData();
            $class->setLocale($enLocaleEntity);
            $class->setAlias($key);
            $class->setData($data);
            $manager->persist($class);
        }
        $manager->flush();
    }

    /**
     * Get the order of this fixture
     *
     * @return integer
     */
    public function getOrder()
    {
        return 4;
    }
}
