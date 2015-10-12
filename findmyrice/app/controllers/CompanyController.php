<?php
namespace Findmyrice\Controllers;
require_once BASE_DIR . '/app/vendor/aws/aws-autoloader.php';

use Findmyrice\Forms\ProductListsServiceAreaForm;
use Findmyrice\Forms\SelfServiceAdForm;
use Findmyrice\Forms\PLAreaDetailsForm;
use Findmyrice\Forms\BannerAdForm;

use Findmyrice\Forms\CompanyMessageForm;

use Findmyrice\Models\BannerAd;
use Findmyrice\Models\GeoPcRegions;
use Findmyrice\Models\Profile;
use Findmyrice\Models\Gallery;
use Findmyrice\Models\ResetPasswords;
use Findmyrice\Models\ProductList;
use Findmyrice\Models\ServiceArea;
use Findmyrice\Models\SelfServiceAd;
use Phalcon\Tag;
use Phalcon\Mvc\Collection;
use Phalcon\Paginator\Adapter\NativeArray as Paginator;
use Findmyrice\Forms\ChangePasswordForm;
use Findmyrice\Forms\MyAccountForm;
use Findmyrice\Forms\ProfileForm;

use Findmyrice\Forms\MessageForm;

use Findmyrice\Models\Users;
use Findmyrice\Models\PasswordChanges;
use Findmyrice\Models\SuccessLogins;
use Findmyrice\Models\CompanyMessages;
use MongoId;

use Aws\S3\S3Client;
use \Phalcon\Image\Adapter\GD as GdAdapter;
use Symfony\Component\Process\Process;
use Elasticsearch;
/**
 * Findmyrice\Controllers\CompanyController
 *
 */
class CompanyController extends ControllerBase
{

    public function initialize()
    {
        $this->view->setTemplateBefore('private');
        $this->view->siteUrl = SITE_URL;
    }

    /**
     * Saves the user from the 'index' action
     */
    public function indexAction($id = null)
    {
        $this->assets->addJs('https://maps.googleapis.com/maps/api/js?v=3.exp&signed_in=true&libraries=places');
        $this->assets->addJs('js/company/index.js');

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

            $form = new MyAccountForm($user, array(
                'edit' => true
            ));
            if ($this->request->isPost()) {
                if ($form->isValid($this->request->getPost()) == false) {
                    foreach ($form->getMessages() as $message) {
                        $this->flashSession->error($message);
                    }
                    Tag::resetInput();
                    Tag::setDefault('password', '');
                    Tag::setDefault('confirmPassword', '');
                } else {

                    $user->email = $this->request->getPost('email', 'email');
                    $user->first_name = $this->request->getPost('first_name', 'striptags');
                    $user->last_name = $this->request->getPost('last_name', 'striptags');
//                    $user->name = $this->request->getPost('name', 'striptags');
                    $password = $this->request->getPost('password');
                    if (!empty($password)) {
                        $user->password = $this->security->hash($password);
                    }
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
//                    $user->other_business_type = $this->request->getPost('other_business_type'); //???
                    $user->primary_supplier_category = $this->request->getPost('primary_supplier_category'); //???
                    $user->currently_export = $this->request->getPost('currently_export');
                    $user->currently_import = $this->request->getPost('currently_import');
//                $user->logo = $this->request->getPost('logo'); //???
                    $membership_type = $this->request->getPost('membership_type');
                    if (!empty($membership_type)) {
                        $user->membership_type = $membership_type;
                    }
//                $user->membership_type = 'Basic'; //???
                    $user->badges_buttons = $this->request->getPost('badges_buttons'); //???
                    $profilesId = $this->request->getPost('profilesId');
                    if (!empty($profilesId)) {
                        $user->profilesId = $profilesId;
                    }


                    $banned = $this->request->getPost('banned');
                    if (!empty($banned)) {
                        $user->banned = $banned;
                    }
                    $suspended = $this->request->getPost('suspended');
                    if (!empty($suspended)) {
                        $user->suspended = $suspended;
                    }
                    $active = $this->request->getPost('active');
                    if (!empty($active)) {
                        $user->active = $active;
                    }

                    if (!$user->save()) {
//                        $this->flash->error($user->getMessages());
                        $this->flashSession->error($user->getMessages());
                    } else {
                        $this->_saveCompanyInElastic($user);
                        $userProfile = Profile::findByUserId((string)$user->_id);
                        $this->_saveCompanyProfileInElastic($userProfile);

                        $this->flashSession->success("Company was updated successfully");
                        Tag::resetInput();
                        Tag::setDefault('password', '');
                        Tag::setDefault('confirmPassword', '');
                    }
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

            $url_toarray_user = explode('/', $user->logo);
            if(isset($url_toarray_user) && !empty($url_toarray_user)
                && is_array($url_toarray_user)
                && count($url_toarray_user) == 6){
                $user_url_tumb = $url_toarray_user[0]. '//'. $url_toarray_user[2] . '/' . $url_toarray_user[3] . '/' . $url_toarray_user[4] . '/thumb_290x190_'.$url_toarray_user[5];
                $this->view->userLogo_thumb = $user_url_tumb;
            }else{
                $this->view->userLogo_thumb = '';
            }
            $this->view->userLogo = $user->logo;

            $this->view->form = $form;
            
            $count = CompanyMessages::count(array(
                array(
                    "read" => '0',
                    "company_id" => $user_id
                )
            ));  
            $this->view->newMessageCount = $count;
    }

    public function editAction($userID = null)
    {
        $this->assets->addJs('https://maps.googleapis.com/maps/api/js?v=3.exp&signed_in=true&libraries=places');
        $this->assets->addJs('js/company/edit.js');
        $identity = $this->session->get('auth-identity');
        $user_id = $identity['id'];
        $user_profile = $identity['profile'];
        if ($user_profile != 'Administrators' && $user_id != $userID) {
            $userID = $user_id;
        }
        $user = Users::findById($userID);
        if (!$user) {
            $this->flash->error("User was not found");
            return $this->dispatcher->forward(array(
                'action' => 'index'
            ));
        }
        $profile = Profile::findByUserId($userID);

        $reset_inputs = true;
        if (!$profile) {
            $profile = new Profile();
            $profile->user_id = $user->_id;
            $form = new ProfileForm(null);
            $reset_inputs = false;
        } else {
            $form = new ProfileForm($profile, array(
                'edit' => true
            ));
        }

        if ($this->request->isPost()) {
            if ($form->isValid($this->request->getPost()) != false){
                //profile
                $profile->title = $this->request->getPost('title', 'striptags');
                $profile->tagline = $this->request->getPost('tagline', 'striptags');
                $profile->short_description = $this->request->getPost('short_description', 'striptags');
                $profile->long_description = $this->request->getPost('long_description', 'striptags');
                $profile->web_site = $this->request->getPost('web_site');
                $profile->email = $this->request->getPost('email', 'email');

                //social media
                $profile->linkdin = $this->request->getPost('linkdin');
                $profile->facebook = $this->request->getPost('facebook');
                $profile->google_plus = $this->request->getPost('google_plus');
                $profile->twitter = $this->request->getPost('twitter');
                $profile->pinterest = $this->request->getPost('pinterest');
                $profile->instagram = $this->request->getPost('instagram');

                //address
                $profile->address = $this->request->getPost('address');
                $profile->city = $this->request->getPost('city');
                $profile->state = $this->request->getPost('state');
                $profile->country = $this->request->getPost('country');
                $profile->postcode = $this->request->getPost('postcode');

                //contact detail
                $profile->phone = $this->request->getPost('phone');
                $profile->fax = $this->request->getPost('fax');

                //profile image
//            $profile->profile_image = $this->request->getPost('profile_image');

                //profile logo
//            $profile->logo = $this->request->getPost('logo');

                //Hours Open
                $profile->ho_mon_1 = $this->request->getPost('ho_mon_1');
                $profile->ho_mon_2 = $this->request->getPost('ho_mon_2');
                $profile->ho_tu_1 = $this->request->getPost('ho_tu_1');
                $profile->ho_tu_2 = $this->request->getPost('ho_tu_2');
                $profile->ho_wed_1 = $this->request->getPost('ho_wed_1');
                $profile->ho_wed_2 = $this->request->getPost('ho_wed_2');
                $profile->ho_thu_1 = $this->request->getPost('ho_thu_1');
                $profile->ho_thu_2 = $this->request->getPost('ho_thu_2');
                $profile->ho_fri_1 = $this->request->getPost('ho_fri_1');
                $profile->ho_fri_2 = $this->request->getPost('ho_fri_2');
                $profile->ho_sat_1 = $this->request->getPost('ho_sat_1');
                $profile->ho_sat_2 = $this->request->getPost('ho_sat_2');
                $profile->ho_sun_1 = $this->request->getPost('ho_sun_1');
                $profile->ho_sun_2 = $this->request->getPost('ho_sun_2');

                //Keywords
                $profile->keywords = $this->request->getPost('keywords', 'striptags');

                if (!$profile->save()) {
                    $this->flash->error($profile->getMessages());
                } else {
                    $this->_saveCompanyProfileInElastic($profile);

                    $this->flash->success("Company was updated successfully.");
                    if($reset_inputs){
                        Tag::resetInput();
                    }
                }
            }
        }
        $this->view->user = $user;
        $url_toarray_profile = explode('/', $profile->profile_image);
        if(isset($url_toarray_profile) && !empty($url_toarray_profile) && is_array($url_toarray_profile) && count($url_toarray_profile) == 6){
            $profile_url_tumb = $url_toarray_profile[0]. '//'. $url_toarray_profile[2] . '/' . $url_toarray_profile[3] . '/' . $url_toarray_profile[4] . '/thumb_290x190_'.$url_toarray_profile[5];
            $this->view->profileImage_thumb = $profile_url_tumb;
        }else{
            $this->view->profileImage_thumb = '';
        }
        $this->view->profileImage = $profile->profile_image;


        $url_toarray_user = explode('/', $user->logo);
        if(isset($url_toarray_user) && !empty($url_toarray_user) && is_array($url_toarray_user) && count($url_toarray_user) == 6){
            $user_url_tumb = $url_toarray_user[0]. '//'. $url_toarray_user[2] . '/' . $url_toarray_user[3] . '/' . $url_toarray_user[4] . '/thumb_290x190_'.$url_toarray_user[5];
            $this->view->userLogo_thumb = $user_url_tumb;
        }else{
            $this->view->userLogo_thumb = '';
        }

        $this->view->userLogo = $user->logo;


        $this->view->form = $form;
            
        $count = CompanyMessages::count(array(
            array(
                "read" => '0',
                "company_id" => $user_id
            )
        ));  
        $this->view->newMessageCount = $count;
    }

    public function productListServiceAreaAction($action = null, $service_area_id = null)
    {
        $this->assets->addJs('https://maps.googleapis.com/maps/api/js?v=3.exp&signed_in=true&libraries=places');
        $this->assets->addJs('js/company/product_lsa.js');
        $identity = $this->session->get('auth-identity');
        $user_id = $identity['id'];
        $user_profile = $identity['profile'];

        $delete_Product_id = $this->request->get('delete');
        if(!empty($delete_Product_id)) {
            try {
                $Product_delete = ProductList::findById($delete_Product_id);
                if($Product_delete->delete()){

                    try{
                        $products_delete = new Elasticsearch\Client();
                        $el_products_delete_params['index'] = $this->config->elasticSearch->products->index;
                        $el_products_delete_params['type']  = $this->config->elasticSearch->products->type;
                        $el_products_delete_params['body']['query']['bool']['must'] = array(
                            'match' => array('product_list_id' => $delete_Product_id)
                        );
                        $result_delete = $products_delete->deleteByQuery($el_products_delete_params);
                    }catch (\Exception $er){

                    }

                    //for Elasticsearch
                    $el_productList_delete_params = array();
                    $el_productList_delete_params['index'] = $this->config->elasticSearch->productList->index;
                    $el_productList_delete_params['type']  = $this->config->elasticSearch->productList->type;
                    $el_productList_delete_params['id']    = $delete_Product_id;

                    $encode_productList_delete = base64_encode(serialize($el_productList_delete_params));
                    $cmd_productList_delete = 'php '.APP_DIR .'/cli.php elastic deleteDocument ' . $encode_productList_delete;
                    $process_productList_delete = new Process($cmd_productList_delete);
                    $process_productList_delete->run();
                    //end Elasticsearch


                    try {
                        $delete_ServiceAreaS = ServiceArea::findByProductListId($delete_Product_id);
                        foreach($delete_ServiceAreaS as $delete_ServiceArea){
                            $delete_sa_id = (string)$delete_ServiceArea->_id;
                            if($delete_ServiceArea->delete()){

                                //for Elasticsearch
                                $el_serviceArea_delete_params = array();
//                                $el_serviceArea_delete_params['index'] = $this->config->elasticSearch->serviceArea->index;
//                                $el_serviceArea_delete_params['type']  = $this->config->elasticSearch->serviceArea->type;
                                $el_serviceArea_delete_params['index'] = $this->config->elasticSearch->productList_serviceArea->index;
                                $el_serviceArea_delete_params['type']  = $this->config->elasticSearch->productList_serviceArea->type;
                                $el_serviceArea_delete_params['id']    = $delete_sa_id;

                                $encode_serviceArea_delete = base64_encode(serialize($el_serviceArea_delete_params));
                                $cmd_serviceArea_delete = 'php '.APP_DIR .'/cli.php elastic deleteDocument ' . $encode_serviceArea_delete;
                                $process_serviceArea_delete = new Process($cmd_serviceArea_delete);
                                $process_serviceArea_delete->run();
                                //end Elasticsearch

//                                $this->flashSession->success('The Service Area was deleted');
                            }else{
//                                $this->flashSession->error('Something went wrong. Please try again.');
                            }
                        }
                        return $this->response->redirect('company/product-list-service-area');
                    } catch (\Exception $ex) {
//                        $this->flashSession->error('Something went wrong. Please try again.');
                    }
                    $this->flashSession->success('The Product was deleted');
                }else{
                    $this->flashSession->error('Something went wrong. Please try again.');
                }
                return $this->response->redirect('company/product-list-service-area');
            } catch (\Exception $ex) {
                $this->flashSession->error('Something went wrong. Please try again.');
            }
        }

        try {
            $service_area_edit = ServiceArea::findById($service_area_id);
            $form = new ProductListsServiceAreaForm($service_area_edit, array(
                'edit'=>true
            ));
        } catch (\Exception $ex) {
            $form = new ProductListsServiceAreaForm();
        }
        $ad_form = new PLAreaDetailsForm();

        if($action == 'delete' && isset($service_area_id)){
            try {
                $ServiceArea_delete = ServiceArea::findById($service_area_id);
                if($ServiceArea_delete->delete()){
                    //for Elasticsearch
                    $el_serviceArea_delete_params = array();
//                    $el_serviceArea_delete_params['index'] = $this->config->elasticSearch->serviceArea->index;
//                    $el_serviceArea_delete_params['type']  = $this->config->elasticSearch->serviceArea->type;
                    $el_serviceArea_delete_params['index'] = $this->config->elasticSearch->productList_serviceArea->index;
                    $el_serviceArea_delete_params['type']  = $this->config->elasticSearch->productList_serviceArea->type;
                    $el_serviceArea_delete_params['id']    = $service_area_id;

                    $encode_serviceArea_delete = base64_encode(serialize($el_serviceArea_delete_params));
                    $cmd_serviceArea_delete = 'php '.APP_DIR .'/cli.php elastic deleteDocument ' . $encode_serviceArea_delete;
                    $process_serviceArea_delete = new Process($cmd_serviceArea_delete);
                    $process_serviceArea_delete->run();
                    //end Elasticsearch

                    $this->flashSession->success('The Service Area was deleted');
                }else{
                    $this->flashSession->error('Something went wrong. Please try again.');
                }
                return $this->response->redirect('company/product-list-service-area');
            } catch (\Exception $ex) {
                $this->flashSession->error('Something went wrong. Please try again.');
            }
        }

        if($action == 'edit' && isset($service_area_id) && !$this->request->isPost()){
            try {
                $ServiceArea_edit = ServiceArea::findById($service_area_id);
                $this->view->service_area_id = $service_area_id;
                $form->setDefaultsFromEdit($ServiceArea_edit); // it will set the filled data
            } catch (\Exception $ex) {
                $this->flashSession->error('Something went wrong. Please try again.');
            }
        }

        //ProductList
        $products = ProductList::findByUserId($user_id);
        $productsArr = array();
        if($products){
            foreach($products as $key1 =>$product_s){
                foreach($product_s as $key=>$val){
                    if(is_object($val)){
                        $productsArr[$key1][$key] = (string)$val;
                    }else{
                        $productsArr[$key1][$key] = $val;
                    }
                    if($key == 'pl_size'){
                        $productsArr[$key1][$key] = round($val / 1024, 2);
                    }
                    if($key == 'pl_uploaded'){
                        $date = date('d M y', $val);
                        $productsArr[$key1][$key] = $date;
                    }
                }
            }
        }
        if($productsArr){
            $this->view->products = $productsArr;
        }else{
            $this->view->products = '';
        }

        //ServiceArea
        $ServiceAreas = ServiceArea::findByUserId($user_id);
        $ServiceAreasArr = array();
        if($ServiceAreas){
            foreach($ServiceAreas as $key1 =>$ServiceArea_s){
                foreach($ServiceArea_s as $key=>$val){
                    if(is_object($val)){
                        $ServiceAreasArr[$key1][$key] = (string)$val;
                    }else{
                        $ServiceAreasArr[$key1][$key] = $val;
                    }
                    if($key == 'product_list_id'){
                        $ProductList = ProductList::findById($val);
                        $ServiceAreasArr[$key1]['product_list_name'] = $ProductList->pl_name;
                    }
                }
            }
        }
        if($ServiceAreasArr){
            $this->view->ServiceAreas = $ServiceAreasArr;
        }else{
            $this->view->ServiceAreas = '';
        }

        if($this->request->isPost()){
            if($form->isValid($this->request->getPost()) != false){

                $new_service_area = new ServiceArea();
                $mongo_user_id = new MongoId($user_id);
                $new_service_area->user_id = $mongo_user_id;
                $new_service_area->sa_area_name = $this->request->getPost('area_name');
                $new_service_area->sa_country = $this->request->getPost('country');
                $new_service_area->sa_city = $this->request->getPost('suburb_town_city');
                $new_service_area->sa_country_code = $this->request->getPost('country_code');
                $new_service_area->sa_area_code = $this->request->getPost('area_code');
                $new_service_area->sa_phone = $this->request->getPost('phone');
                $new_service_area->sa_street_address = $this->request->getPost('street_address');
                $new_service_area->sa_state = $this->request->getPost('state');
                $new_service_area->sa_postcode = $this->request->getPost('postcode');
//                $new_service_area->sa_status = $this->request->getPost('status');
                $mongo_product_list_id = new MongoId($this->request->getPost('product_list'));
                $new_service_area->product_list_id = $mongo_product_list_id; //???
                if($new_service_area->save()){
                    $this->_saveProductListServiceAreaInElastic($new_service_area);
                    $this->flashSession->success('The Service Area was updated');
                    $service_area_edit_id = $this->request->getPost('id');
                    if(!empty($service_area_edit_id)){
                        try {
                            $service_area_edit_delete = ServiceArea::findById($service_area_edit_id);
                            $service_area_edit_delete->delete();

                            //for Elasticsearch
                            $el_serviceArea_delete_params = array();
//                            $el_serviceArea_delete_params['index'] = $this->config->elasticSearch->serviceArea->index;
//                            $el_serviceArea_delete_params['type']  = $this->config->elasticSearch->serviceArea->type;
                            $el_serviceArea_delete_params['index'] = $this->config->elasticSearch->productList_serviceArea->index;
                            $el_serviceArea_delete_params['type']  = $this->config->elasticSearch->productList_serviceArea->type;
                            $el_serviceArea_delete_params['id']    = $service_area_edit_id;

                            $encode_serviceArea_delete = base64_encode(serialize($el_serviceArea_delete_params));
                            $cmd_serviceArea_delete = 'php '.APP_DIR .'/cli.php elastic deleteDocument ' . $encode_serviceArea_delete;
                            $process_serviceArea_delete = new Process($cmd_serviceArea_delete);
                            $process_serviceArea_delete->run();
                            //end Elasticsearch

                        } catch (\Exception $ex) {
                            //$this->flashSession->error('Something went wrong. Please try again.');
                        }
                    }

                }else{
                    $this->flashSession->error('Something went wrong. Please try again.');
                }
                return $this->response->redirect('company/product-list-service-area');
            }else{
//                foreach ($form->getMessages() as $message) {
//                    echo $message, '<br>';
//                }
            }
        }
            
        $count = CompanyMessages::count(array(
            array(
                "read" => '0',
                "company_id" => $user_id
            )
        ));  
        $this->view->newMessageCount = $count;
        $this->view->action = $action;
        $this->view->form = $form;
        $this->view->ad_form = $ad_form;
    }

    public function certificationAwardsAction(){
        $identity = $this->session->get('auth-identity');
        $user_id = $identity['id'];
            
        $count = CompanyMessages::count(array(
            array(
                "read" => '0',
                "company_id" => $user_id
            )
        ));  
        $this->view->newMessageCount = $count;

    }

    public function premiumFeaturesAction(){
        $identity = $this->session->get('auth-identity');
        $user_id = $identity['id'];
            
        $count = CompanyMessages::count(array(
            array(
                "read" => '0',
                "company_id" => $user_id
            )
        ));  
        $this->view->newMessageCount = $count;
    }

    public function reportingAction(){
        $identity = $this->session->get('auth-identity');
        $user_id = $identity['id'];
            
        $count = CompanyMessages::count(array(
            array(
                "read" => '0',
                "company_id" => $user_id
            )
        ));  
        $this->view->newMessageCount = $count;
    }

    public function messagesAction($userID = null, $page_num = null){
        $this->assets->addCss("css/font-awesome.min.css")
                    ->addJs('js/company/messages.js');
        
        $identity = $this->session->get('auth-identity');
        $user_id = $identity['id'];
        $user_profile = $identity['profile'];
        
        if ($user_profile != 'Administrators' && $user_id != $userID) {
            $userID = $user_id;
        }
        
        $user = Users::findById($userID);
        
        if (!$user) {
            $this->flash->error("User was not found");
            return $this->dispatcher->forward(array(
                'action' => 'index'
            ));
        }
        
        $profile = Profile::findByUserId($userID);
        $company_id = $user->_id;
        
        try {
            
            $form = new MessageForm();
            $m_ct = 0;
            $m_ct = intval($this->request->getPost('m_ct'));

            if ($m_ct != 0) {
                for ($i = 1; $i < $m_ct + 1; $i ++) {

                    if( $this->request->getPost('each_check'.$i) == 'yes' ) {
                        $message_id = $this->request->getPost('messageId'.$i);
                        $message = CompanyMessages::findByMessageId($message_id);
                        $message->read = '1';
                        if ($message->save() == false) {
                            $this->flash->error("You can't do it.");
                        }
                    }
                }
            }
            
            $messages = CompanyMessages::findByUserIdStatus($user_id, '1');
            
            if ($messages) {
                foreach ($messages as $message) {
                    $messageLength = strlen($message->message);
                    $messageCustom = "";
                    if (30 <= $messageLength) {
                        $messageCustom = substr($message->message, 0, 30);
                        $messageCustom = $messageCustom . " ...";
                    }else {
                        $messageCustom = $message->message;
                    }
                    $message->message = $messageCustom;
                }
            }
            
            $messages_count = CompanyMessages::count(array(
                array(
                    "status" => '1',
                    "company_id" => $user_id
                )
            ));
            
            // Page
            $limit = 5;            
            if ($limit != 0) {
                $m_co = (int)($messages_count/$limit);
            }
            
            $min = $messages_count - ( $limit * $m_co );            
            if ($min > 0) {
                $m_co = $m_co + 1;
            }
            
            if ($this->dispatcher->getParam('page_num') != null ) {
                $page_num = $this->dispatcher->getParam('page_num');
            }else {
                $page_num = 1;
            }
            
            $this->view->page_num = $page_num;            
            $this->view->limit = $limit;            
            $this->view->m_co = $m_co;
            
            $count = CompanyMessages::count(array(
                array(
                    "read" => '0',
                    "company_id" => $user_id
                )
            ));  
            
            $this->view->messages = $messages;            
            $this->view->ct = $count;            
            $this->view->m_ct = $messages_count;            
            $this->view->form = $form;            
            $this->view->newMessageCount = $count;
        } catch (\Exception $e) {
            $this->flash->error("Message was not found.");
        }
    }
    public function advertisingAction(){
        $identity = $this->session->get('auth-identity');
        $user_id = $identity['id'];
            
        $count = CompanyMessages::count(array(
            array(
                "read" => '0',
                "company_id" => $user_id
            )
        ));  
        $this->view->newMessageCount = $count;
    }
    public function connectionAction(){
        $identity = $this->session->get('auth-identity');
        $user_id = $identity['id'];
            
        $count = CompanyMessages::count(array(
            array(
                "read" => '0',
                "company_id" => $user_id
            )
        ));  
        $this->view->newMessageCount = $count;
    }
    public function membershipFormAction(){

    }

    public function advertisingBannerAction()
    {
        $this->assets->addJs('js/company/banner-ad.js');
        $identity = $this->session->get('auth-identity');
        $user_id = $identity['id'];
        $user_profile = $identity['profile'];

        $this->view->user_id = $user_id;

        $form = new BannerAdForm(null);

        if($this->request->isPost()) {
            $data = $this->request->getPost();
            if ($form->isValid($this->request->getPost()) != false) {

                $BannerAd = new BannerAd();

                if ($this->request->hasFiles() == true) {
                    $uploads = $this->request->getUploadedFiles();
                    $bucket = 'findmyrice';
                    if (!empty($uploads)) {
                        $upload = $uploads[0];

                        $mimeType = $upload->getRealType();

                        switch ($mimeType) {
                            case 'image/jpeg':
                                $correct_image = true;
                                break;
                            case 'image/png':
                                $correct_image = true;
                                break;
                            case 'image/gif':
                                $correct_image = true;
                                break;
                            default:
                                $correct_image = false;
                        }
                        if ($correct_image) {
                            $BannerAd->banner_ad_file = $unique_name = md5(uniqid(rand(), true)) . '-' . strtolower($upload->getname());

                            $client = S3Client::factory(array(
                                'key' => $this->config->amazon->AWSAccessKeyId,
                                'secret' => $this->config->amazon->AWSSecretKey,
                                'region' => 'us-west-2'
                            ));

                            $image = new GdAdapter($upload->getRealPath());
                            if ($user_profile == 'Users') {
                                $key = 'users/' . $user_id . '/banner-ad/' . $unique_name;
                            } else if ($user_profile == 'Companies') {
                                $key = 'companies/' . $user_id . '/banner-ad/' . $unique_name;
                            } else {
                                $key = 'banner-ad';
                            }
                            $image->resize(265, 265);
                            $file_dir = BASE_DIR . '/public/tmp/' . $user_id;
                            if (!is_dir($file_dir)) {
                                mkdir($file_dir, 0755);
                            }
                            $dir = $file_dir . '/265x265_'. $unique_name;

                            if ($image->save($dir)) {
                                $image_size265x265 = new GdAdapter($dir);
                                $result_size265x265 = $client->putObject(array(
                                    'Bucket' => $bucket,
                                    'Key' => $key,
                                    'SourceFile' => $image_size265x265->getRealPath(),
                                    'ACL' => 'public-read',
                                    'ContentType' => 'text/plain'
                                ));
                                unlink($dir); // delete file
                            }
                            $this->external->rrmdir($file_dir); // delete folder
                        }
                    }

                }
                $BannerAd->user_id = new MongoId($user_id);
                $BannerAd->alt_text = $this->request->getPost('alt_text', 'striptags');

                if($BannerAd->save()){
                    $this->flashSession->success('Successfully Place ordered...');
                    $form->clear();
                }else{
                    $this->flashSession->success('Something wrong... Please tray again later.');
                }
                return $this->response->redirect('company/advertising-banner');
            }
        }
        
        $count = CompanyMessages::count(array(
            array(
                "read" => '0',
                "company_id" => $user_id
            )
        ));  
        $this->view->newMessageCount = $count;        
        $this->view->form = $form;
    }

    public function advertisingSelfServiceAction(){

        $this->assets->addJs('js/company/self-service-ad.js');
        $identity = $this->session->get('auth-identity');
        $user_id = $identity['id'];
        $user_profile = $identity['profile'];

        $this->view->user_id = $user_id;

        $form = new SelfServiceAdForm(null);

        if($this->request->isPost()) {
            $data = $this->request->getPost();
            if ($form->isValid($this->request->getPost()) != false) {

                $SelfServiceAd = new SelfServiceAd();

                if ($this->request->hasFiles() == true) {
                    $uploads = $this->request->getUploadedFiles();
                    $bucket = 'findmyrice';
                    if (!empty($uploads)) {
                        $upload = $uploads[0];

                        $mimeType = $upload->getRealType();

                        switch ($mimeType) {
                            case 'image/jpeg':
                                $correct_image = true;
                                break;
                            case 'image/png':
                                $correct_image = true;
                                break;
                            case 'image/gif':
                                $correct_image = true;
                                break;
                            default:
                                $correct_image = false;
                        }
                        if ($correct_image) {
                            $SelfServiceAd->image_name = $unique_name = md5(uniqid(rand(), true)) . '-' . strtolower($upload->getname());

                            $client = S3Client::factory(array(
                                'key' => $this->config->amazon->AWSAccessKeyId,
                                'secret' => $this->config->amazon->AWSSecretKey,
                                'region' => 'us-west-2'
                            ));

                                $image = new GdAdapter($upload->getRealPath());
                                if ($user_profile == 'Users') {
                                    $key = 'users/' . $user_id . '/self-service-ad/' . $unique_name;
                                } else if ($user_profile == 'Companies') {
                                    $key = 'companies/' . $user_id . '/self-service-ad/' . $unique_name;
                                } else {
                                    $key = 'self-service-ad';
                                }
                                $image->resize(145, 145);
                                $file_dir = BASE_DIR . '/public/tmp/' . $user_id;
                                if (!is_dir($file_dir)) {
                                    mkdir($file_dir, 0755);
                                }
                                $dir = $file_dir . '/145x145_'. $unique_name;

                                if ($image->save($dir)) {
                                    $image_size145x145 = new GdAdapter($dir);
                                    $result_size145x145 = $client->putObject(array(
                                        'Bucket' => $bucket,
                                        'Key' => $key,
                                        'SourceFile' => $image_size145x145->getRealPath(),
                                        'ACL' => 'public-read',
                                        'ContentType' => 'text/plain'
                                    ));
                                    unlink($dir); // delete file
                                }
                                $this->external->rrmdir($file_dir); // delete folder
                        }
                    }

                }
                $SelfServiceAd->user_id = new MongoId($user_id);
                $SelfServiceAd->headline = $this->request->getPost('headline', 'striptags');
                $SelfServiceAd->text = $this->request->getPost('text', 'striptags');

                if($SelfServiceAd->save()){
                    $this->flashSession->success('Successfully Place ordered...');
                    $form->clear();
                }else{
                    $this->flashSession->success('Something wrong... Please tray again later.');
                }
                return $this->response->redirect('company/create-a-self-service-ad');
            }
        }
        $count = CompanyMessages::count(array(
            array(
                "read" => '0',
                "company_id" => $user_id
            )
        ));  
        $this->view->newMessageCount = $count;
        $this->view->form = $form;

    }
    public function advertisingMyCampaignsAction(){

//        $regions = GeoPcRegions::find(array(array(
//
//        ),
//            'fields'=>array(
//                '_id',
//                'iso',
//                'country',
//                'language',
//                'level',
//                'type',
//                'name',
//                'region1',
//                'region2',
//                'region3',
//                'region4',
//                'iso2',
//                'fips',
//                'nuts',
//                'hasc',
//                'stat'
//            )
//        ));
//        echo '<pre />';var_dump($regions);die;
        $identity = $this->session->get('auth-identity');
        $user_id = $identity['id'];
            
        $count = CompanyMessages::count(array(
            array(
                "read" => '0',
                "company_id" => $user_id
            )
        ));  
        $this->view->newMessageCount = $count;
    }

    public function badgeIconAction(){
        $identity = $this->session->get('auth-identity');
        $user_id = $identity['id'];
        $user_profile = $identity['profile'];
//        $user = Users::findById($user_id);
//
//        if (!$user) {
//            $this->flash->error("User was not found");
//            return $this->dispatcher->forward(array(
//                'action' => 'index'
//            ));
//        }
//        $this->view->user = $user;
        $count = CompanyMessages::count(array(
            array(
                "read" => '0',
                "company_id" => $user_id
            )
        ));  
        $this->view->newMessageCount = $count;
        $this->view->user_id = $user_id;
    }
    public function galleryAction(){
        $this->assets->addJs('js/no-conflict.js')
            ->addJs('js/company/gallery.js');
        $this->assets->addJs('js/no-conflict.js')
            ->addJs('js/fancyapps/lib/jquery-1.10.1.min.js')
            ->addJs('js/fancyapps/lib/jquery.mousewheel-3.0.6.pack.js')
            ->addJs('js/fancyapps/source/jquery.fancybox.js?v=2.1.5')
            ->addCss('js/fancyapps/source/jquery.fancybox.css?v=2.1.5')
            ->addJs('js/company/for-fancy.js');
        $this->assets->addJs('js/no-conflict.js')
            ->addJs('js/jquery-1.6.1.min.js')
            ->addJs('js/jquery.masonry.js')
            ->addJs('js/company/gallery-gallery.js')
            ->addCss('css/style_masonry.css');

        $identity = $this->session->get('auth-identity');
        $user_id = $identity['id'];
        $user_profile = $identity['profile'];

        //Galleries
        $galleries = Gallery::findByUserId($user_id);
        $photoArr = array();
        if($galleries){
            foreach($galleries as $key1 =>$photo){
                foreach($photo as $key=>$val){
                    if(is_object($val)){
                        $photoArr[$key1][$key] = (string)$val;
                    }else{
                        $photoArr[$key1][$key] = $val;
                    }
                }
            }
        }
        if($photoArr){
            $this->view->photos = $photoArr;
        }else{
            $this->view->photos = '';
        }
        $this->view->bucketUrl = BUCKET_URL;            
        $count = CompanyMessages::count(array(
            array(
                "read" => '0',
                "company_id" => $user_id
            )
        ));  
        $this->view->newMessageCount = $count;
    }

    /**
     * Users must use this action to change its password
     */
    public function changePasswordAction()
    {
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
    }

    private function _saveCompanyInElastic($user){

        //for Elasticsearch
        $el_company_params = array();
        $el_company_params['index'] = $this->config->elasticSearch->company->index;
        $el_company_params['type']  = $this->config->elasticSearch->company->type;
        $el_company_params['id']    = (string)$user->_id;
        //body
        $el_company_params['email'] = $user->email;
        $el_company_params['first_name'] = $user->first_name;
        $el_company_params['last_name'] = $user->last_name;
        $el_company_params['name'] = $user->name;
        $el_company_params['business_name'] = $user->business_name;
        $el_company_params['business_name_exact'] = $user->business_name;
        $el_company_params['street_address'] = $user->street_address;
        $el_company_params['suburb_town_city'] = $user->suburb_town_city;
        $el_company_params['suburb_town_city_exact'] = $user->suburb_town_city;
        $el_company_params['state'] = $user->state;
        $el_company_params['state_exact'] = $user->state;
        $el_company_params['country'] = $user->country;
        $el_company_params['country_exact'] = $user->country;
        $el_company_params['area_code'] = $user->area_code;
        $el_company_params['phone'] = $user->phone;
        $el_company_params['business_type'] = $user->business_type;
        $el_company_params['business_type_exact'] = $user->business_type;
        $el_company_params['currently_export'] = $user->currently_export;
        $el_company_params['currently_import'] = $user->currently_import;
        $el_company_params['logo'] = $user->logo;
        $el_company_params['membership_type'] = $user->membership_type;
        $el_company_params['membership_type_exact'] = $user->membership_type;
        $el_company_params['badges_buttons'] = $user->badges_buttons;
        $el_company_params['primary_product_service'] = $user->primary_product_service;
        $el_company_params['primary_product_service_exact'] = $user->primary_product_service;
        $el_company_params['primary_supplier_category'] = $user->primary_supplier_category;
        $el_company_params['primary_supplier_category_exact'] = $user->primary_supplier_category;
        $el_company_params['profilesId'] = $user->profilesId;
        $el_company_params['active'] = $user->active;
        $el_company_params['suspended'] = $user->suspended;
        $el_company_params['banned'] = $user->banned;
        $el_company_params['created_at'] = $user->created_at;
        $el_company_params['modified_at'] = date('Y-m-d', $user->modified_at);
        $el_company_params['modified_at_exact'] = date('Y-m-d', $user->modified_at);
        $el_company_params['postcode'] = $user->postcode;
        $el_company_params['postcode_exact'] = $user->postcode;
        $encode_Company = base64_encode(serialize($el_company_params));
        $cmd_Company = 'php '.APP_DIR .'/cli.php elastic createIndex ' . $encode_Company;
        $process_Company = new Process($cmd_Company);
        $process_Company->run();
        //end Elasticsearch
    }
    private function _saveCompanyProfileInElastic($profile){
        //for Elasticsearch
        $el_company_profile_params = array();
        $el_company_profile_params['index'] = $this->config->elasticSearch->companyProfile->index;
        $el_company_profile_params['type']  = $this->config->elasticSearch->companyProfile->type;
        $el_company_profile_params['id']    = (string)$profile->_id;
        $el_company_profile_params['user_id']    = (string)$profile->user_id;
        $el_company_profile_params['title']    = $profile->title;
        $el_company_profile_params['title_exact']    = $profile->title;
        $el_company_profile_params['tagline']    = array_map('trim', explode(",",$profile->tagline));
        $el_company_profile_params['tagline_exact']    = array_map('trim', explode(",",$profile->tagline));
        $el_company_profile_params['short_description']    = $profile->short_description;
        $el_company_profile_params['long_description']    = $profile->long_description;
        $el_company_profile_params['web_site']    = $profile->web_site;
        $el_company_profile_params['email']    = $profile->email;
        $el_company_profile_params['address']    = $profile->address;
        $el_company_profile_params['city']    = $profile->city;
        $el_company_profile_params['city_exact']    = $profile->city;
        $el_company_profile_params['state']    = $profile->state;
        $el_company_profile_params['state_exact']    = $profile->state;
        $el_company_profile_params['country']    = $profile->country;
        $el_company_profile_params['country_exact']    = $profile->country;
        $el_company_profile_params['phone']    = $profile->phone;
        $el_company_profile_params['logo']    = $profile->logo;
        $el_company_profile_params['profile_image']    = $profile->profile_image;
        $el_company_profile_params['keywords']    = array_map('trim', explode(",",$profile->keywords));
        $el_company_profile_params['keywords_exact']    = array_map('trim', explode(",",$profile->keywords));
        $el_company_profile_params['created_at']    = $profile->created_at;
        $el_company_profile_params['modified_at']    = date('Y-m-d', $profile->modified_at);
        $el_company_profile_params['modified_at_exact']    = date('Y-m-d', $profile->modified_at);
        $el_company_profile_params['business_type']    = $profile->business_type;
        $el_company_profile_params['business_type_exact']    = $profile->business_type;
        $el_company_profile_params['currently_export']    = $profile->currently_export;
        $el_company_profile_params['currently_import']    = $profile->currently_import;
        $el_company_profile_params['active']    = $profile->active;
        $el_company_profile_params['postcode']    = $profile->postcode;
        $el_company_profile_params['postcode_exact']    = $profile->postcode;
        $el_company_profile_params['primary_product_service'] = $profile->primary_product_service;
        $el_company_profile_params['primary_product_service_exact'] = $profile->primary_product_service;
        $el_company_profile_params['primary_supplier_category'] = $profile->primary_supplier_category;
        $el_company_profile_params['primary_supplier_category_exact'] = $profile->primary_supplier_category;
        $encode_CompanyProfile = base64_encode(serialize($el_company_profile_params));
        $cmd_profile = 'php '.APP_DIR .'/cli.php elastic createIndex ' . $encode_CompanyProfile;
        $process_profile = new Process($cmd_profile);
        $process_profile->run();
        //end Elasticsearch
    }
    private function _saveProductListServiceAreaInElastic($new_service_area){

        $product_sa = ProductList::findById((string)$new_service_area->product_list_id);
        //for Elasticsearch
        $el_product_list_service_area_params = array();
        $el_product_list_service_area_params['index'] = $this->config->elasticSearch->productList_serviceArea->index;
        $el_product_list_service_area_params['type']  = $this->config->elasticSearch->productList_serviceArea->type;
        $el_product_list_service_area_params['id']    = (string)$new_service_area->_id;

        $el_product_list_service_area_params['pl_name']    = $product_sa->pl_name;
        $el_product_list_service_area_params['pl_name_exact']    = $product_sa->pl_name;
        $el_product_list_service_area_params['pl_file_type']    = $product_sa->pl_file_type;
        $el_product_list_service_area_params['pl_file_type_exact']    = $product_sa->pl_file_type;
        $el_product_list_service_area_params['pl_size']    = $product_sa->pl_size;
        $el_product_list_service_area_params['pl_url']    = $product_sa->pl_url;
        $el_product_list_service_area_params['pl_uploaded']    = date('Y-m-d',$product_sa->pl_uploaded);
        $el_product_list_service_area_params['pl_uploaded_exact']    = date('Y-m-d',$product_sa->pl_uploaded);

        $el_product_list_service_area_params['user_id']    = (string)$new_service_area->user_id;
        $el_product_list_service_area_params['product_list_id']    = (string)$new_service_area->product_list_id;
        $el_product_list_service_area_params['sa_area_name']    = $new_service_area->sa_area_name;
        $el_product_list_service_area_params['sa_area_name_exact']    = $new_service_area->sa_area_name;
        $el_product_list_service_area_params['sa_country']    = $new_service_area->sa_country;
        $el_product_list_service_area_params['sa_country_exact']    = $new_service_area->sa_country;
        $el_product_list_service_area_params['sa_country_code']    = $new_service_area->sa_country_code;
        $el_product_list_service_area_params['sa_country_code_exact']    = $new_service_area->sa_country_code;
        $el_product_list_service_area_params['sa_area_code']    = $new_service_area->sa_area_code;
        $el_product_list_service_area_params['sa_phone']    = $new_service_area->sa_phone;
        $el_product_list_service_area_params['sa_street_address']    = $new_service_area->sa_street_address;
        $el_product_list_service_area_params['sa_state']    = $new_service_area->sa_state;
        $el_product_list_service_area_params['sa_state_exact']    = $new_service_area->sa_state;
        $el_product_list_service_area_params['sa_city']    = $new_service_area->sa_city;
        $el_product_list_service_area_params['sa_city_exact']    = $new_service_area->sa_city;
        $el_product_list_service_area_params['sa_postcode']    = $new_service_area->sa_postcode;
        $el_product_list_service_area_params['sa_postcode_exact']    = $new_service_area->sa_postcode;
        $el_product_list_service_area_params['sa_created_at']    = $new_service_area->sa_created_at;
        $el_product_list_service_area_params['sa_modified_at']    = date('Y-m-d',$new_service_area->sa_modified_at);
        $el_product_list_service_area_params['sa_modified_at_exact']    = date('Y-m-d',$new_service_area->sa_modified_at);

        $encode_product_list_service_area = base64_encode(serialize($el_product_list_service_area_params));
        $cmd_product_list_service_area = 'php '.APP_DIR .'/cli.php elastic createIndex ' . $encode_product_list_service_area;
        $process_product_list_service_area = new Process($cmd_product_list_service_area);
        $process_product_list_service_area->run();
        //end Elasticsearch
    }
}
