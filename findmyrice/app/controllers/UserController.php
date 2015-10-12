<?php
namespace Findmyrice\Controllers;

use Findmyrice\Forms\AdvancedSearchForm;
use Findmyrice\Forms\SimpleSearchForm;
use Findmyrice\Models\ElasticSearchModel;
use Findmyrice\Models\Profile;
use Phalcon\Tag;
use Phalcon\Mvc\Collection;
use Phalcon\Paginator\Adapter\NativeArray as Paginator;
use Findmyrice\Forms\ChangePasswordForm;
use Findmyrice\Forms\UserEditProfileForm;
use Findmyrice\Models\Users;
use Findmyrice\Models\PasswordChanges;
use Findmyrice\Models\FavoritesCompanies;
use Findmyrice\Models\UserMessages;

/**
 * Findmyrice\Controllers\UserController
 *
 */
class UserController extends ControllerBase
{

    public function initialize()
    {
        $this->view->setTemplateBefore('private_user');

        $identity = $this->session->get('auth-identity');
        $user_id = $identity['id'];
        $user_profile = $identity['profile'];

        $favoritesCompanies = FavoritesCompanies::find(array(
            array(
                'user_id'=>$user_id
            )
        ));
        $favourite_company_data = array();
        foreach($favoritesCompanies as $k=>$favoritesCompany){
            $company = Users::findById($favoritesCompany->company_id);
            $company_profile = Profile::findByUserId($favoritesCompany->company_id);
            $favourite_company_data[$k]['company'] = $company->toArray();
            $favourite_company_data[$k]['profile'] = $company_profile->toArray();
        }
        if(isset($favourite_company_data) && !empty($favourite_company_data)){
            $this->view->favourite_company_data = $favourite_company_data;
        }else{
            $this->view->favourite_company_data = false;
        }
        
        $count = UserMessages::count(array(
            array(
                "read" => '0',
                "user_id" => $user_id
            )
        ));
        $this->view->newMessageCount = $count;
    }

    /**
     * Default action, shows the search form
     */
    public function indexAction()
    {
        $this->assets
            ->addJs('js/chosen.jquery.min.js')
            ->addJs('js/jquery-ui.min.js')
            ->addJs('js/search/index.js')
            ->addJs('js/elasticsearch_autocomplete.js')
            ->addcss('css/chosen.min.css')
            ->addCss('css/wingding3.css')
            ->addCss('css/jquery-ui.min.css');

        $this->assets->addJs('js/no-conflict.js')
             ->addJs('js/fancyapps/lib/jquery-1.10.1.min.js')
             ->addJs('js/fancyapps/lib/jquery.mousewheel-3.0.6.pack.js')
             ->addJs('js/fancyapps/source/jquery.fancybox.js?v=2.1.5')
             ->addCss('js/fancyapps/source/jquery.fancybox.css?v=2.1.5')
             ->addJs('js/user/for-fancy.js');
        $this->assets->addJs('js/no-conflict.js')
                ->addJs('js/jquery-1.6.1.min.js')
                ->addJs('js/jquery.masonry.js')
                ->addJs('js/user/index.js')
                ->addCss('css/style_masonry.css');
        
        $identity = $this->session->get('auth-identity');
        $user_id = $identity['id'];
        
        $ad_form = new AdvancedSearchForm();

        $this->view->ad_form = $ad_form;

        $sp_form = new SimpleSearchForm();

        $this->view->sp_form = $sp_form;


        $ElasticSearchModel = new ElasticSearchModel();

        $geoData = $this->external->getGeoData();
        $new_companies_in_your_area = $ElasticSearchModel->findCompaniesByArea($geoData);

        if(!empty($new_companies_in_your_area)){
            $paginator = new Paginator(array(
                'data' => $new_companies_in_your_area,
                'limit' => 8,
                'page' => $this->request->get('page', 'int')
            ));
            $page = $paginator->getPaginate();
        }else{
            $page = false;
        }

        $this->view->setVars(array(
            'page' => $page
        ));
        
        $count = UserMessages::count(array(
            array(
                "read" => '0',
                "user_id" => $user_id
            )
        ));
        $this->view->newMessageCount = $count;
    }

    public function editAction($id = null)
    {
        $this->assets->addJS('js/user/edit.js');
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

        $form = new UserEditProfileForm($user, array(
            'edit' => true
        ));


        if ($this->request->isPost()) {
            if ($form->isValid($this->request->getPost()) != false) {

                $user->email = $this->request->getPost('email', 'email');
                $user->first_name = $this->request->getPost('first_name', 'striptags');
                $user->name = $user->email;
                $password = $this->request->getPost('password');
                if (!empty($password)) {
                    $user->password = $this->security->hash($password);
                }

                $user->position = $this->request->getPost('position', 'striptags');
                $user->state = $this->request->getPost('state', 'striptags');
                $user->country = $this->request->getPost('country', 'striptags');


                if (!$user->save()) {
                    $this->flash->error($user->getMessages());
                } else {
                    $this->flash->success("User was updated successfully");
                    Tag::resetInput();
                    Tag::setDefault('password', '');
                    Tag::setDefault('confirmPassword', '');
                }
            }
        }

        $url_toarray_user = explode('/', $user->logo);
        if(isset($url_toarray_user) && !empty($url_toarray_user) && is_array($url_toarray_user) && count($url_toarray_user) == 6){
            $user_url_tumb = $url_toarray_user[0]. '//'. $url_toarray_user[2] . '/' . $url_toarray_user[3] . '/' . $url_toarray_user[4] . '/thumb_290x190_'.$url_toarray_user[5];
            $this->view->userLogo_thumb = $user_url_tumb;
        }else{
            $this->view->userLogo_thumb = '';
        }
        $this->view->userLogo = $user->logo;

        $this->view->form = $form;
        
        $count = UserMessages::count(array(
            array(
                "read" => '0',
                "user_id" => $user_id
            )
        ));
        $this->view->newMessageCount = $count;
    }

    /**
     * Users must use this action to change its password
     */
    public function changePasswordAction()
    {
        $identity = $this->session->get('auth-identity');
        $user_id = $identity['id'];
        
        $form = new ChangePasswordForm();

        if ($this->request->isPost()) {

            if (!$form->isValid($this->request->getPost())) {

                foreach ($form->getMessages() as $message) {
                    $this->flash->error($message);
                }
            } else {

                $user = $this->auth->getUser();

                $user->password = $this->security->hash($this->request->getPost('password'));
                $user->mustChangePassword = 'N';

                if (!$user->save()) {
                    $this->flash->error($user->getMessages());
                } else {

                    $passwordChange = new PasswordChanges();
    //                $passwordChange->user = $user;
                    $passwordChange->usersId = $user->_id->{'$id'};
                    $passwordChange->ipAddress = $this->request->getClientAddress();
                    $passwordChange->userAgent = $this->request->getUserAgent();

                    if (!$passwordChange->save()) {
                        $this->flash->error($passwordChange->getMessages());
                    } else {
//                        $this->flash->success('Your password was successfully changed');
                        Tag::resetInput();
                    }
                    $this->flash->success('Your password was successfully changed');
                }
            }
        }

        $this->view->form = $form;
        
        $count = UserMessages::count(array(
            array(
                "read" => '0',
                "user_id" => $user_id
            )
        ));
        $this->view->newMessageCount = $count;
    }
}
