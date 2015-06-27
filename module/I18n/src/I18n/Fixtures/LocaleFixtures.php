<?php
/**
 * Created by PhpStorm.
 * User: matveev
 * Date: 28.06.15
 * Time: 0:02
 */

namespace I18n\Fixtures;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use I18n\Entity\Locale;

class LocaleFixtures extends AbstractFixture implements OrderedFixtureInterface
{

    /**
     * Load data fixtures with the passed EntityManager
     *
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        $ruLocale = new Locale();
        $ruLocale->setLang('ru');
        $ruLocale->setLocale('ru_RU');

        $enLocale = new Locale();
        $enLocale->setLang('en');
        $enLocale->setLocale('en_EN');

        $manager->persist($ruLocale);
        $manager->persist($enLocale);
        $manager->flush();
    }

    /**
     * Get the order of this fixture
     *
     * @return integer
     */
    public function getOrder()
    {
        return 3;
    }
}
