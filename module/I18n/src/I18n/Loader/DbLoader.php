<?php
/**
 * Created by PhpStorm.
 * User: matveev
 * Date: 6/24/15
 * Time: 1:43 PM
 */

namespace I18n\Loader;


use Doctrine\ORM\EntityManager;
use Zend\I18n\Translator\Loader\RemoteLoaderInterface;

class DbLoader implements RemoteLoaderInterface
{
    /** @var  EntityManager */
    protected $em;

    public function __construct(EntityManager $entityManager)
    {
        $this->em = $entityManager;
    }

    /**
     * Load translations from a remote source.
     *
     * @param  string $locale
     * @param  string $textDomain
     *
     * @return \Zend\I18n\Translator\TextDomain|null
     */
    public function load($locale, $textDomain)
    {
        /** @var \I18n\Repository\LocateData $repo */
        $repo = $this->em->getRepository('I18n\Entity\LocaleData');
        $result = $repo->getTranslationsByLocale($locale);
        $messages = array_reduce($result, function($message, $item){
            $message[$item['alias']] = $item['data'];
            return $message;
        });
        return $messages;
    }
}