<?php

namespace Admin\Controllers;

use Application\Interfaces\TranslatorAwareInterface;
use Application\Traits\TranslatorAwareTrait;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

/**
 * Class IndexController
 * @package Admin\Controllers
 */
class IndexController extends AbstractActionController implements TranslatorAwareInterface
{
    use TranslatorAwareTrait;

    /**
     * Class Alias
     */
    const ALIAS = 'Admin/IndexController';

    /**
     * Index action
     *
     * @return ViewModel
     */
    public function indexAction()
    {
        return new ViewModel(['foo' => $this->translate('test')]);
    }

    /**
     * Delegating login to vendor module
     *
     * @return mixed
     */
    public function loginAction()
    {
        return $this->forward()->dispatch('zfcuser', array('action' => 'login'));
    }
}
