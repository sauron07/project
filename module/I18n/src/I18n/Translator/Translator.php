<?php
/**
 * Created by PhpStorm.
 * User: matveev
 * Date: 6/24/15
 * Time: 12:36 PM
 */

namespace I18n\Translator;

use \Zend\I18n\Translator\Translator as MvcTranslator;

/**
 * Class Translator
 * @package I18n\Translator
 */
class Translator extends MvcTranslator
{
    /**
     * @param string $message
     * @param string $textDomain
     * @param null   $locale
     *
     * @return string
     */
    public function translate($message, $textDomain = 'default', $locale = null)
    {
        return parent::translate($message, $textDomain, 'en_EN');
    }
}