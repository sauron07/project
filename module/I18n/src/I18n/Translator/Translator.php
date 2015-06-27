<?php
/**
 * Created by PhpStorm.
 * User: matveev
 * Date: 6/24/15
 * Time: 12:36 PM
 */

namespace I18n\Translator;

use Application\Interfaces\EntityManagerAwareInterface;
use Application\Traits\EntityManagerAwareTrait;
use \Zend\I18n\Translator\Translator as MvcTranslator;
use Zend\Mvc\Router\RouteMatch;
use Zend\Session\Container;

/**
 * Class Translator
 * @package I18n\Translator
 */
class Translator extends MvcTranslator implements EntityManagerAwareInterface
{
    use EntityManagerAwareTrait;

    const DEFAULT_LANG = 'en';

    const DEFAULT_LOCALE = 'en_EN';

    /** @var  RouteMatch */
    private $routeMatch;

    /** @var  Container */
    private $sessionContainer;

    public function __construct(RouteMatch $routeMatch, Container $container)
    {
        $this->routeMatch = $routeMatch;
        $this->sessionContainer = $container;
    }

    /**
     * @param string $message
     * @param string $textDomain
     * @param null $locale
     *
     * @return string
     */
    public function translate($message, $textDomain = 'default', $locale = null)
    {
        return parent::translate($message, $textDomain, $this->getLocaleFromRoute());
    }

    /**
     * @return mixed|string
     */
    public function getLocaleFromRoute()
    {
        $lang = self::DEFAULT_LANG;
        if ($this->routeMatch->getParam('lang') !== '') {
            $lang = $this->routeMatch->getParam('lang');
        }
        if ($this->sessionContainer->offsetGet('lang')) {
            $lang = $this->sessionContainer->offsetGet('lang');
        }

        $localeRepo = $this->getEntityManager()->getRepository('I18n\Entity\Locale');
        $localeEntity = $localeRepo->findOneBy(['lang' => $lang]);
        return $localeEntity !== null ? $localeEntity->getLocale() : self::DEFAULT_LOCALE;
    }
}
