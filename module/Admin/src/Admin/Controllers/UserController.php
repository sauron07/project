<?php
/**
 * Created by PhpStorm.
 * User: matveev
 * Date: 5/25/15
 * Time: 11:59 AM
 */

namespace Admin\Controllers;


use Admin\Service\UserService;
use Admin\Table\User;
use Application\Interfaces\TranslatorAwareInterface;
use Application\Traits\ExtendAdminTableTrait;
use Application\Interfaces\ExtendAdminTableInterface;
use Application\Traits\TranslatorAwareTrait;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

/**
 * Class UserController
 * @package Admin\Controllers
 */
class UserController
    extends AbstractActionController
    implements ExtendAdminTableInterface
{
    use ExtendAdminTableTrait;

    const ALIAS = 'Admin\UserController';

    protected $dbAdapter;

    /** @var  UserService */
    protected $userService;

    /** @var  User */
    protected $userTable;

    /**
     * @param UserService $userService
     * @param User        $userTable
     */
    public function __construct(UserService $userService, User $userTable)
    {
        $this->userService = $userService;
        $this->userTable = $userTable;
    }

    /**
     * Show User action
     */
    public function indexAction()
    {
        $userId = $this->params()->fromRoute('id', false);
        if(!$userId){
            return $this->redirectToList('Empty Id params');
        }

        /** @var \User\Entity\User $user */
        $user = $this->userService->getEntityManager()->find('User\Entity\User', $userId);

        if(null === $user){
            return $this->redirectToList('User not found');
        }

        return new ViewModel(['user' => $user]);
    }

    /**
     * Create User
     */
    public function createAction()
    {
        die('create');
    }

    /**
     * Edit User
     */
    public function editAction()
    {
        die('edit');
    }

    /**
     * Action to display table
     */
    public function usersAction(){}

    /**
     * Action to serve ajax requests
     *
     * @return bool|\Zend\Http\PhpEnvironment\Response
     */
    public function ajaxUsersAction()
    {
        $form = $this->userTable->getForm();

        $request = $this->getRequest();

        $filter = $this->userTable->getFilter();
        $form->setInputFilter($filter);
        $form->setData($request->getPost());

        if ($form->isValid()){
            $users = $this->userService->listAction();
            $this->userTable->setSource($users)->setParamAdapter($this->getRequest()->getPost());

            return $this->prepareHtmlResponse($this->getResponse(), $this->userTable->render());
        }
        else{
            return false;
        }
    }

    /**
     * @param $message string
     *
     * @return \Zend\Http\Response
     */
    private function redirectToList($message)
    {
        $this->flashMessenger()->addMessage($message);

        return $this->redirect()->toRoute('zfcadmin/users');
    }
}