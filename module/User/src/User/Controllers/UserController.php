<?php
/**
 * @author: matveev
 * @date: 6/25/15
 * @time: 7:04 PM
 */

namespace User\Controllers;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

/**
 * Class UserController
 * @author  ${USER}
 * @package User\Controllers
 */
class UserController extends AbstractActionController
{
    const ALIAS = 'User\UserController';

    public function indexAction()
    {
        if (!$this->zfcUserAuthentication()->hasIdentity()) {
            return $this->redirect()->toRoute('home/zfcuser/login');
        }
        return new ViewModel();
    }
}
