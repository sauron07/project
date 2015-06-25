<?php
/**
 * Created by PhpStorm.
 * User: matveev
 * Date: 6/24/15
 * Time: 12:31 PM
 */

namespace Application\Interfaces;

use I18n\Translator\Translator;

interface TranslatorAwareInterface
{
    public function setTranslator(Translator $translator);
}
