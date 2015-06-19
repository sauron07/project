<?php

namespace Admin\Controllers;

use Admin\Service\IndexService;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

/**
 * Class IndexController
 * @package Admin\Controllers
 */
class IndexController extends AbstractActionController
{
    const ALIAS = 'Admin/IndexController';

    public function indexAction()
    {
        /** @var \AcMailer\Service\MailService $mailer */
        $mailer = $this->getServiceLocator()->get('acmailer.mailservice.default');
        $mailer->getMessage()
            ->addTo('matyeyev.sasha@gmail.com')
            ->setSubject('subject')
            ->setBody('body');

        $result = $mailer->send();

        $test = $this->getServiceLocator()->get(IndexService::ALIAS)->test();
        return new ViewModel(['foo' => $test]);
    }
    public function loginAction()
    {
        return $this->forward()->dispatch('zfcuser', array('action' => 'login'));
    }

}