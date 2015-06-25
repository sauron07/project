<?php
/**
 * Created by PhpStorm.
 * User: matveev
 * Date: 6/24/15
 * Time: 12:32 PM
 */

namespace Application\Traits;


use I18n\Translator\Translator;

trait TranslatorAwareTrait
{
    /** @var  \I18n\Translator\Translator */
    public $translator;

    /**
     * @return \I18n\Translator\Translator
     */
    public function getTranslator()
    {
        return $this->translator;
    }

    /**
     * @param \I18n\Translator\Translator $translator
     */
    public function setTranslator(Translator $translator)
    {
        $this->translator = $translator;
    }

    public function translate($message, $textDomain = 'default', $locale = null)
    {
        return $this->translator->translate($message, $textDomain, $locale);
    }

}