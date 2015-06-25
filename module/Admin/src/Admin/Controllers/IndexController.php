<?php

namespace Admin\Controllers;

use Admin\Service\IndexService;
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

    const ALIAS = 'Admin/IndexController';

    public function indexAction()
    {
        /** @var \AcMailer\Service\MailService $mailer */
//        $mailer = $this->getServiceLocator()->get('acmailer.mailservice.default');
//        $mailer->getMessage()
//            ->addTo('matyeyev.sasha@gmail.com')
//            ->setSubject('subject')
//            ->setBody('body');
//
//        $result = $mailer->send();

//        $test = $this->getServiceLocator()->get(IndexService::ALIAS)->test();
        return new ViewModel(['foo' => $this->translate('test')]);
    }
    public function loginAction()
    {
        return $this->forward()->dispatch('zfcuser', array('action' => 'login'));
    }

}