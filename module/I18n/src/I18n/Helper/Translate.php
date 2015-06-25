<?php
/**
 * Created by PhpStorm.
 * User: matveev
 * Date: 6/24/15
 * Time: 4:11 PM
 */

namespace I18n\Helper;


use I18n\Translator\Translator;
use Zend\I18n\Exception\RuntimeException;
use Zend\I18n\View\Helper\AbstractTranslatorHelper;

class Translate extends AbstractTranslatorHelper
{
    public function __invoke($message, $textDomain = 'default', $locale = null)
    {
        /** @var Translator $translator */
        $translator = $this->getTranslator();
        if(null === $translator){
            throw new RuntimeException('Translator does not loaded!' );
        }
        if(null === $textDomain){
            $textDomain = $this->getTranslatorTextDomain();
        }
        return $translator->translate($message, $textDomain, $locale);
    }
}