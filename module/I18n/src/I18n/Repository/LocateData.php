<?php
/**
 * Created by PhpStorm.
 * User: matveev
 * Date: 6/24/15
 * Time: 2:25 PM
 */

namespace I18n\Repository;

use Doctrine\ORM\EntityRepository;

class LocateData extends EntityRepository
{
    public function getTranslationsByLocale($locale)
    {
        if (empty($locale)) {
            return [];
        }
        $qb = $this->getEntityManager()->createQueryBuilder();
        $qb->select('d.data', 'd.alias')
            ->from('I18n\Entity\LocaleData', 'd')
            ->leftJoin('d.locale', 'l')
            ->where('l.locale = :locale')
            ->setParameter('locale', $locale);

        return $qb->getQuery()->getArrayResult();
    }
}
