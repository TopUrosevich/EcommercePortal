<?php
namespace Findmyrice\Controllers;

use Findmyrice\Models\ResetPasswords;
use Phalcon\Tag;
use Phalcon\Mvc\Collection;
use Phalcon\Paginator\Adapter\NativeArray as Paginator;
use Findmyrice\Forms\ChangePasswordForm;
use Findmyrice\Forms\UsersForm;
use Findmyrice\Models\Users;
use Findmyrice\Models\PasswordChanges;
use Findmyrice\Models\SuccessLogins;

/**
 * Findmyrice\Controllers\UsersController
 * CRUD to manage users
 */
class AdminController extends ControllerBase
{

    public function initialize()
    {
        $this->view->setTemplateBefore('private');
        $this->view->adminPage = true;
    }

    /**
     * Default action, shows the search form
     */
    public function indexAction()
    {

//        $this->persistent->conditions = null;
//        $this->view->form = new UsersForm();
    }
    public function manageUsersAction()
    {
        $this->persistent->conditions = null;
        $this->view->form = new UsersForm();
    }
    /**
     * Searches for users
     */
    public function searchAction()
    {
        $numberPage = 1;
        if ($this->request->isPost()) {
            $searshFields = $this->external->searchParams($this->request->getPost());
            $this->persistent->searchParams = $searshFields;
        } else {
            $numberPage = $this->request->getQuery("page", "int");
        }

        $parameters = array();
        if ($this->persistent->searchParams) {
            $parameters = $this->persistent->searchParams;
        }

        $users = Users::find(array($parameters));
        if (count($users) == 0) {
            $this->flash->notice("The search did not find any users");
            return $this->dispatcher->forward(array(
                "action" => "index"
            ));
        }

        $paginator = new Paginator(array(
            "data" => $users,
            "limit" => 10,
            "page" => $numberPage
        ));

        $this->view->page = $paginator->getPaginate();
    }

    /**
     * Creates a User
     */
    public function createAction()
    {
        if ($this->request->isPost()) {

            $user = new Users();
            $user->profilesId = $this->request->getPost('profilesId');
            $user->email = $this->request->getPost('email', 'email');
            $user->first_name = $this->request->getPost('first_name', 'striptags');
            $user->last_name = $this->request->getPost('last_name', 'striptags');
            $user->name = $this->request->getPost('name', 'striptags');
//            $user->password = $this->security->hash($this->request->getPost('password'));
            $user->business_name = $this->request->getPost('business_name', 'striptags');
            $user->street_address = $this->request->getPost('street_address');
            $user->suburb_town_city = $this->request->getPost('suburb_town_city');
            $user->state = $this->request->getPost('state');
            $user->country = $this->request->getPost('country');
            $user->postcode = $this->request->getPost('postcode');
            $user->country_code = $this->request->getPost('country_code');
            $user->area_code = $this->request->getPost('area_code');
            $user->phone = $this->request->getPost('phone');
            $user->business_type = $this->request->getPost('business_type');
            $user->other_business_type = $this->request->getPost('other_business_type'); //???
            $user->currently_export = $this->request->getPost('currently_export');
            $user->currently_import = $this->request->getPost('currently_import');

            $user->logo = $this->request->getPost('logo'); //???
            $membership_type = $this->request->getPost('membership_type');
            if(!empty($membership_type)){
                $user->membership_type = $membership_type;
            }
            //                $user->membership_type = 'Basic'; //???
            $user->badges_buttons = $this->request->getPost('badges_buttons'); //???

            if (!$user->save()) {
                $this->flash->error($user->getMessages());
            } else {

                $this->flash->success("User was created successfully");

                Tag::resetInput();
            }
        }

        $this->view->form = new UsersForm(null);
    }

    /**
     * Saves the user from the 'edit' action
     */
    public function editAction($id = null)
    {
        $identity = $this->session->get('auth-identity');
        $user_id = $identity['id'];
        $user_profile = $identity['profile'];

        if($user_profile != 'Administrators' && $user_id != $id){
            $id = $user_id;
        }
        $user = Users::findById($id);

            if (!$user) {
                $this->flash->error("User was not found");
                return $this->dispatcher->forward(array(
                    'action' => 'index'
                ));
            }
        $formPassword = new ChangePasswordForm();
            if ($this->request->isPost()) {

                $user->email = $this->request->getPost('email', 'email');
                $user->first_name = $this->request->getPost('first_name', 'striptags');
                $user->last_name = $this->request->getPost('last_name', 'striptags');
                $user->name = $this->request->getPost('name', 'striptags');
//                $user->password = $this->security->hash($this->request->getPost('password'));
                $user->business_name = $this->request->getPost('business_name', 'striptags');
                $user->street_address = $this->request->getPost('street_address');
                $user->suburb_town_city = $this->request->getPost('suburb_town_city');
                $user->state = $this->request->getPost('state');
                $user->country = $this->request->getPost('country');
                $user->postcode = $this->request->getPost('postcode');
                $user->country_code = $this->request->getPost('country_code');
                $user->area_code = $this->request->getPost('area_code');
                $user->phone = $this->request->getPost('phone');
                $user->business_type = $this->request->getPost('business_type');
                $user->other_business_type = $this->request->getPost('other_business_type'); //???
                $user->currently_export = $this->request->getPost('currently_export');
                $user->currently_import = $this->request->getPost('currently_import');

                $user->logo = $this->request->getPost('logo'); //???
                $membership_type = $this->request->getPost('membership_type');
                if(!empty($membership_type)){
                    $user->membership_type = $membership_type;
                }
//                $user->membership_type = 'Basic'; //???
                $user->badges_buttons = $this->request->getPost('badges_buttons'); //???

                $profilesId = $this->request->getPost('profilesId');
                if(!empty($profilesId)){
                    $user->profilesId = $profilesId;
                }

                $banned = $this->request->getPost('banned');
                if(!empty($banned)){
                    $user->banned = $banned;
                }
                $suspended = $this->request->getPost('suspended');
                if(!empty($suspended)){
                    $user->suspended = $suspended;
                }
                $active = $this->request->getPost('active');
                if(!empty($active)){
                    $user->active = $active;
                }

                if (!$user->save()) {
                    $this->flash->error($user->getMessages());
                } else {

                    $this->flash->success("User was updated successfully");
                    Tag::resetInput();
                }
            }

            $successLogins = SuccessLogins::find(array(
                array('usersId' => $id)
            ));
            $user->successLogins = $successLogins;

            $passwordChanges = PasswordChanges::find(array(
                array('usersId' => $id)
            ));
            $user->passwordChanges = $passwordChanges;

            $resetPasswords = ResetPasswords::find(array(
                array('usersId' => $id)
            ));
            $user->resetPasswords = $resetPasswords;

            $this->view->user = $user;
            $this->view->user_id = $user->_id;

            $this->view->form = new UsersForm($user, array(
                'edit' => true
            ));
            $this->view->formPassword = $formPassword;
    }

    /**
     * Deletes a User
     *
     * @param int $id
     */
    public function deleteAction($id)
    {
        $user = Users::findById($id);
        if (!$user) {
            $this->flash->error("User was not found");
            return $this->dispatcher->forward(array(
                'action' => 'index'
            ));
        }

        if (!$user->delete()) {
            $this->flash->error($user->getMessages());
        } else {
            $this->flash->success("User was deleted");
        }

        return $this->dispatcher->forward(array(
            'action' => 'index'
        ));
    }

    /**
     * Users must use this action to change its password
     */
    public function changePasswordAction($user_id = null)
    {
        if ($this->request->isPost() && !isset($user_id)) {
            $user_id = $this->request->getPost('user_id');
        }
        $user = Users::findById($user_id);

        if (!$user) {
            $user = $this->auth->getUser();
        }
        $this->view->username = $user->email;
        $this->view->user_id = $user->_id;

        $form = new ChangePasswordForm();

        if ($this->request->isPost()) {

            if (!$form->isValid($this->request->getPost())) {

                foreach ($form->getMessages() as $message) {
                    $this->flash->error($message);
                }
            } else {

                $user->password = $this->security->hash($this->request->getPost('password'));
                $user->mustChangePassword = 'N';

                if (!$user->save()) {
                    $this->flash->error($user->getMessages());
                } else {
                    $passwordChange = new PasswordChanges();
                    $passwordChange->usersId = $user->_id->{'$id'};
                    $passwordChange->ipAddress = $this->request->getClientAddress();
                    $passwordChange->userAgent = $this->request->getUserAgent();

                    if (!$passwordChange->save()) {
                        $this->flash->error($passwordChange->getMessages());
                    } else {
                        Tag::resetInput();
                    }
                    $this->flash->success('Your password was successfully changed');
                }
            }
        }

        $this->view->form = $form;
    }
}
