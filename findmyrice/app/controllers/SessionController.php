<?php
namespace Findmyrice\Controllers;

require_once BASE_DIR . '/app/vendor/aws/aws-autoloader.php';
use Aws\S3\S3Client;

use Findmyrice\Auth\Exception;
use Findmyrice\Forms\LoginCompanyForm;
use Findmyrice\Forms\LoginForm;
use Findmyrice\Forms\SignUpContributorForm;
use Findmyrice\Forms\SignUpUserForm;
use Findmyrice\Forms\SignUpCompanyForm;
use Findmyrice\Forms\SignUpCompanyForm1;
use Findmyrice\Forms\SignUpCompanyForm2;
use Findmyrice\Forms\SignUpCompanyForm3;
use Findmyrice\Forms\ForgotPasswordForm;
use Findmyrice\Auth\Exception as AuthException;
use Findmyrice\Models\ProductList;
use Findmyrice\Models\Profile;
use Findmyrice\Models\ServiceArea;
use Findmyrice\Models\Users;
use Findmyrice\Models\ResetPasswords;
use Findmyrice\Models\Subscribers;
use Findmyrice\Models\Profiles;
use Phalcon\Tag as Tag;

use Symfony\Component\Process\Process;
use Elasticsearch;
/**
 * Controller used handle non-authenticated session actions like login/logout, user signup, and forgotten passwords
 */
class SessionController extends ControllerBase
{

    /**
     * Default action. Set the public layout (layouts/public.volt)
     */
    public function initialize()
    {
        $this->view->setTemplateBefore('public');
    }

    public function indexAction()
    {

    }

    /**
     * Allow a user to signup to the system
     */

    public function signupUserAction(){

        $form = new SignUpUserForm();

        if ($this->request->isPost()) {


            if ($form->isValid($this->request->getPost()) != false) {

                $user = new Users();
//                $data = $this->request->getPost();
                $user->email = $this->request->getPost('email', 'email');
                $user->first_name = $this->request->getPost('first_name', 'striptags');
                $user->name = $user->email;
                $user->password = $this->security->hash($this->request->getPost('password'));
                $user->profilesId = USER_PROFILE_ID; //Users

                if ($user->save()) {

                    $subscribe_news = $this->request->getPost('subscribe_news');
                    if(isset($subscribe_news) && $subscribe_news == 'yes'){

                        $subscribe_news = new Subscribers();
                        $subscribe_news->user_id = $user->_id;
                        $subscribe_news->username = $user->name;
                        $subscribe_news->email = $user->email;
                        $subscribe_news->save();
                    }
                    return $this->dispatcher->forward(array(
                        'controller' => 'index',
                        'action' => 'index'
                    ));
                }
                $this->flash->error($user->getMessages());
            }
        }

        $this->view->form = $form;
    }

    /*
     *
    */
    public function regCompanyStep1Action()
    {
        $this->assets->addJs('https://maps.googleapis.com/maps/api/js?v=3.exp&signed_in=true&libraries=places');
        $this->assets->addJs('js/registration/reg-step1.js');

        $form = new SignUpCompanyForm1();
        $step1 = $this->session->get('step1');
//        $this->session->remove("step1");
        if (isset($step1) && !empty($step1) && !$this->request->isPost()) {
            $form->setDefaultsFromSession($step1); // it will set the filled data
        } else {
            if ($this->request->isPost()) {//im using my custom request class
                $user = new Users();
                $email = $this->request->getPost('email');
                $name = $this->request->getPost('name');
                $user->email = $email;
                $user->name = $name;
                if ($form->isValid($this->request->getPost()) != false) {
                    if($user->validation()){
                        $step1 = $this->request->getPost();
                        if(!isset($step1['currently_export']) || empty($step1['currently_export']))
                            $step1['currently_export'] = '';
                        if(!isset($step1['currently_import']) || empty($step1['currently_import']))
                            $step1['currently_import'] = '';
                        if(!isset($step1['subscribe_news']) || empty($step1['subscribe_news']))
                            $step1['subscribe_news'] = '';

                        $this->session->set('step1', $step1);
                        return $this->response->redirect('session/register-company-step2');
                    } else {
                        $this->flash->error($user->getMessages());
                    }
                }
            }
        }
        $this->view->form = $form;

    }

    public function regCompanyStep2Action($ses_action = null, $ses_unique = null)
    {
        $this->assets->addJs('https://maps.googleapis.com/maps/api/js?v=3.exp&signed_in=true&libraries=places');
        $this->assets->addJs('js/registration/reg-step2.js');
        $this->assets->addJs('js/registration/reg-step1.js');
        $step1 = $this->session->get('step1');
        $form = new SignUpCompanyForm2((object)$step1, array("edit"=>true));
        $product_files = array();
        if(isset($step1) && !empty($step1)){
//            $step2 = $this->session->get('step2');
            $product_files = array();
            foreach ($_SESSION as $key=>$ses_file){
                if (strpos($key,'step2_') !== false) {
                    $product_files[$key] = $ses_file;
                }
            }
            if($ses_action == 'delete' && isset($ses_unique)){
                $this->session->remove($ses_unique);
                return $this->response->redirect('session/register-company-step2');
            }
            if($ses_action == 'edit' && isset($ses_unique) && !$this->request->isPost()){
                $this->session->set('editAction', 'edit');
                $this->session->set('editUnique', $ses_unique);
                $edit_ses = $this->session->get($ses_unique);
                $form->setDefaultsFromSession($edit_ses); // it will set the filled data
            }
            $editAction = $this->session->get('editAction');
            $editUnique = $this->session->get('editUnique');
            if ($this->request->isPost()) {//im using my custom request class
                if ($form->isValid($this->request->getPost()) != false) {
                    $service_area = $this->request->getPost();
                    $unique =  md5(uniqid(rand(), true));
                    $ProdctListFolderName = $this->session->get('ProdctListFolderName');
                    if(!isset($ProdctListFolderName) || empty($ProdctListFolderName)){
                        $this->session->set('ProdctListFolderName', $unique);
                    }

                    #check if there is any file
                    if($this->request->hasFiles() == true){
                        $uploads = $this->request->getUploadedFiles();
                        $isUploaded = false;
                        #do a loop to handle each file individually
                        if($uploads){
                            $upload = $uploads[0];
                            $file_size = $upload->getSize();
                            $file_extension = $upload->getExtension();
                            if($file_extension !='pdf'
                                && $file_extension !='doc'
                                && $file_extension !='doc'
                                && $file_extension !='docx'
                                && $file_extension !='xls'
                                && $file_extension !='xlsx'
                                && $file_extension !='csv'){
                                $this->flashSession->error('Please use only pdf. doc. docx. xls. xlsx. csv for Product upload field.');
                                if(isset($editAction) && $editAction == 'edit' && isset($editUnique) && $editUnique != ''){
                                    $redir_url = 'session/register-company-step2/'.$editAction.'/'.$editUnique;
                                    return $this->response->redirect($redir_url);
                                } else {
                                    return $this->response->redirect('session/register-company-step2');
                                }
                            }
                            $ProdctListFolderName = $this->session->get('ProdctListFolderName');
                            if(!is_dir(BASE_DIR .'/public/files/products/')){
                                mkdir(BASE_DIR .'/public/files/products/', 0755);
                            }
                            $file_dir = BASE_DIR .'/public/files/products/'.$ProdctListFolderName .'/';
                            if(!is_dir($file_dir)){
                                mkdir($file_dir, 0755);
                            }
                            #define a “unique” name and a path to where our file must go
                            $unique_name = $unique .'-'.strtolower($upload->getname());
//                                $path = BASE_DIR .'/public/files/products/'. $unique_name;
                            $path = $file_dir . $unique_name;
                            #move the file and simultaneously check if everything was ok
                            ($upload->moveTo($path)) ? $isUploaded = true : $isUploaded = false;
                        }

                        #if any file couldn’t be moved, then throw an message
                        if($isUploaded){
                            $product_list_name = str_replace(".".$file_extension, "", $upload->getname());
                            $product_info = array(
                                'original-name'=> $upload->getname(),
                                'unique'=> $unique,
                                'name'=> $unique_name,
                                'size'=> $file_size,
                                'extension'=> $file_extension,
                                'product_list_name'=> $product_list_name
                            );

                            $product_service_area = array(
                                'service_area'=>$service_area,
                                'product_info'=>$product_info,
                            );
                            $this->session->set('step2_'.$unique, $product_service_area);
                            //File successfully uploaded
                            $this->response->setContent(1);

                        } else {
                            //Some error occurred when uploading the file
                            $this->response->setContent(0);
                            $this->session->set('step2_'.$unique, $service_area);
                        }
                    } else {
                        #if no files were sent, throw a message warning user
                        $this->flashSession->error('Please select a product.');
                        $form->setDefaultsFromServiceArea($service_area); // it will set the filled data
                        if(isset($editAction) && $editAction == 'edit' && isset($editUnique) && $editUnique != ''){
                            $redir_url = 'session/register-company-step2/'.$editAction.'/'.$editUnique;
                            $this->session->remove('editUnique');
                            $this->session->remove('editAction');
                            return $this->response->redirect($redir_url);
                        }
                    }
                    if(isset($editAction) && $editAction == 'edit' && isset($editUnique) && $editUnique != ''){
                        $this->session->remove($editUnique);
                        $this->session->remove('editUnique');
                        $this->session->remove('editAction');
                    }
                    return $this->response->redirect('session/register-company-step2');
                } else {
//                        foreach ($form->getMessages() as $message) {
//                            echo $message, '<br>';
//                        }
                }
            }

        } else {
            return $this->response->redirect('session/register-company-step1');
        }
        $this->view->products = $product_files;
        $this->view->form = $form;
    }

    public function regCompanyStep3Action()
    {
        $this->assets->addJs('js/registration/reg-step3.js');
        $form = new SignUpCompanyForm3();
        $step1 = $this->session->get('step1');
        if(isset($step1) && !empty($step1)) {

            $product_files = array();
            foreach ($_SESSION as $key=>$ses_file){
                if (strpos($key,'step2_') !== false) {
                    $product_files[$key] = $ses_file;
                }
            }
            if ($this->request->isPost()) {
                //im using my custom request class
                if ($form->isValid($this->request->getPost()) != false) {
                    $step3 = $this->request->getPost();
                    //save data from step1 begin
                    $user = new Users();
                    $user->email = $step1['email'];
                    $user->first_name = $step1['first_name'];
                    $user->last_name = $step1['last_name'];
                    $user->name = $step1['name'];
                    $user->password = $this->security->hash($step1['password']);
                    $user->business_name = $step1['business_name'];
                    $user->street_address = $step1['street_address'];
                    $user->suburb_town_city = $step1['suburb_town_city'];
                    $user->state = $step1['state'];
                    $user->country = $step1['country'];
                    $user->postcode = $step1['postcode'];
                    $user->country_code = $step1['country_code'];
                    $user->area_code = $step1['area_code'];
                    $user->phone = $step1['phone'];
                    $user->business_type = $step1['business_type'];
                    $user->other_business_type = ''; //???
                    $user->currently_export = $step1['currently_export'];
                    $user->currently_import = $step1['currently_import'];

                    $user->logo = ''; //???
                    $user->membership_type = 'Basic'; //???
                    $user->badges_buttons = ''; //???
                    $user->primary_product_service = $step1['primary_product_service']; //???
                    $user->primary_supplier_category = ''; //???
                    $user->profilesId = COMPANY_PROFILE_ID; //Companies

                    if ($user->save()) {

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
                        $process_Company->start();
                        //end Elasticsearch

                        $subscribe_news = $step1['subscribe_news'];
                        if (isset($subscribe_news) && $subscribe_news == 'yes') {

                            $subscribe_news = new Subscribers();
                            $subscribe_news->user_id = $user->_id;
                            $subscribe_news->username = $user->name;
                            $subscribe_news->email = $user->email;
                            $subscribe_news->save();
                        }
                        $userProfile = new Profile();

                        $userProfile->user_id = $user->_id;
                        $userProfile->title = $user->business_name;
                        $userProfile->email = $user->email;
                        $userProfile->address = $user->street_address;
                        $userProfile->city = $user->suburb_town_city;
                        $userProfile->state = $user->state;
                        $userProfile->country = $user->country;
                        $userProfile->phone = $user->phone;
                        $userProfile->logo = $user->logo;
                        $userProfile->primary_product_service = $user->primary_product_service;
                        $userProfile->primary_supplier_category = $user->primary_supplier_category;
                        $userProfile->postcode = $user->postcode;
                        $userProfile->keywords = $step3['key_words_area'];
                        if(!$userProfile->save()){
                            $this->flashSession->error($userProfile->getMessages());
                        }else{
                            //for Elasticsearch
                            $el_company_profile_params = array();
                            $el_company_profile_params['index'] = $this->config->elasticSearch->companyProfile->index;
                            $el_company_profile_params['type']  = $this->config->elasticSearch->companyProfile->type;
                            $el_company_profile_params['id']    = (string)$userProfile->_id;
                            $el_company_profile_params['user_id']    = (string)$userProfile->user_id;
                            $el_company_profile_params['title']    = $userProfile->title;
                            $el_company_profile_params['title_exact']    = $userProfile->title;
                            $el_company_profile_params['email']    = $userProfile->email;
                            $el_company_profile_params['address']    = $userProfile->address;
                            $el_company_profile_params['city']    = $userProfile->city;
                            $el_company_profile_params['city_exact']    = $userProfile->city;
                            $el_company_profile_params['state']    = $userProfile->state;
                            $el_company_profile_params['state_exact']    = $userProfile->state;
                            $el_company_profile_params['country']    = $userProfile->country;
                            $el_company_profile_params['country_exact']    = $userProfile->country;
                            $el_company_profile_params['phone']    = $userProfile->phone;
                            $el_company_profile_params['logo']    = $userProfile->logo;
                            $el_company_profile_params['keywords']    = array_map('trim', explode(",",$userProfile->keywords));
                            $el_company_profile_params['keywords_exact']    = array_map('trim', explode(",",$userProfile->keywords));
                            $el_company_profile_params['created_at']    = $userProfile->created_at;
                            $el_company_profile_params['modified_at']    = date('Y-m-d', $userProfile->modified_at);
                            $el_company_profile_params['modified_at_exact']    = date('Y-m-d', $userProfile->modified_at);
                            $el_company_profile_params['business_type']    = $userProfile->business_type;
                            $el_company_profile_params['business_type_exact']    = $userProfile->business_type;
                            $el_company_profile_params['currently_export']    = $userProfile->currently_export;
                            $el_company_profile_params['currently_import']    = $userProfile->currently_import;
                            $el_company_profile_params['active']    = $userProfile->active;
                            $el_company_profile_params['postcode']    = $userProfile->postcode;
                            $el_company_profile_params['postcode_exact']    = $userProfile->postcode;
                            $el_company_profile_params['primary_product_service'] = $userProfile->primary_product_service;
                            $el_company_profile_params['primary_product_service_exact'] = $userProfile->primary_product_service;
                            $el_company_profile_params['primary_supplier_category'] = $userProfile->primary_supplier_category;
                            $el_company_profile_params['primary_supplier_category_exact'] = $userProfile->primary_supplier_category;

                            $encode_CompanyProfile = base64_encode(serialize($el_company_profile_params));
                            $cmd_profile = 'php '.APP_DIR .'/cli.php elastic createIndex ' . $encode_CompanyProfile;
                            $process_profile = new Process($cmd_profile);
                            $process_profile->start();
                            //end Elasticsearch
                        }

                        if (isset($product_files) && !empty($product_files)) {
                            $ProdctListFolderName = $this->session->get('ProdctListFolderName');
                            $dir = BASE_DIR .'/public/files/products/'. $ProdctListFolderName;
                            $bucket = 'findmyrice';
                            $keyPrefix = 'companies/'.$user->_id;

                            foreach ($product_files as $key => $ses_file) {
                                $productList = new ProductList();
                                $productList->user_id = $user->_id;
                                $productList->pl_name = $ses_file['product_info']['product_list_name'];
                                $productList->pl_file_type = $ses_file['product_info']['extension'];
                                $productList->pl_size = $ses_file['product_info']['size'];
                                $productList->pl_url = "https://s3-us-west-2.amazonaws.com/".$bucket."/".$keyPrefix."/". $ses_file['product_info']['name'];

                                if ($productList->save()) {

                                    //for Elasticsearch
                                    $el_productList_params = array();
                                    $el_productList_params['index'] = $this->config->elasticSearch->productList->index;
                                    $el_productList_params['type']  = $this->config->elasticSearch->productList->type;
                                    $el_productList_params['id']    = (string)$productList->_id;
                                    $el_productList_params['user_id']    = (string)$productList->user_id;
                                    $el_productList_params['pl_name']    = $productList->pl_name;
                                    $el_productList_params['pl_name_exact']    = $productList->pl_name;
                                    $el_productList_params['pl_file_type']    = $productList->pl_file_type;
                                    $el_productList_params['pl_file_type_exact']    = $productList->pl_file_type;
                                    $el_productList_params['pl_size']    = $productList->pl_size;
                                    $el_productList_params['pl_url']    = $productList->pl_url;
                                    $el_productList_params['pl_uploaded']    = date('Y-m-d',$productList->pl_uploaded);
                                    $el_productList_params['pl_uploaded_exact']    = date('Y-m-d',$productList->pl_uploaded);


                                    $encode_ProductList = base64_encode(serialize($el_productList_params));
                                    $cmd_ProductList = 'php '.APP_DIR .'/cli.php elastic createIndex ' . $encode_ProductList;
                                    $process_ProductList = new Process($cmd_ProductList);
                                    $process_ProductList->start();
                                    //end Elasticsearch

                                    $service_area = new ServiceArea();
                                    $service_area->user_id = $productList->user_id;
                                    $service_area->product_list_id = $productList->_id;
                                    $service_area->sa_area_name = $ses_file['service_area']['area_name'];
                                    $service_area->sa_country = $ses_file['service_area']['country'];
                                    $service_area->sa_country_code = $ses_file['service_area']['country_code'];
                                    $service_area->sa_area_code = $ses_file['service_area']['area_code'];
                                    $service_area->sa_phone = $ses_file['service_area']['phone'];
                                    $service_area->sa_street_address = $ses_file['service_area']['street_address'];
                                    $service_area->sa_state = $ses_file['service_area']['state'];
                                    $service_area->sa_city = $ses_file['service_area']['suburb_town_city'];
                                    $service_area->sa_postcode = $ses_file['service_area']['postcode'];
//                                    $service_area->sa_status = $ses_file['service_area']['status'];

                                    $inputFileName = BASE_DIR .'/public/files/products/'.$ProdctListFolderName .'/' . $ses_file['product_info']['name'];
                                    $arrProduct = $this->external->getArrayProductsFromFile($productList->pl_file_type, $inputFileName);

                                    if (!$service_area->save()) {
                                        if(!empty($arrProduct)){
                                            $el_products_params = array();
                                            $el_products_params['index'] = $this->config->elasticSearch->products->index;
                                            $el_products_params['type']  = $this->config->elasticSearch->products->type;
                                            $el_products_params['product_list_id']    = (string)$productList->_id;
                                            $el_products_params['user_id']    = (string)$productList->user_id;
                                            $el_products_params['product_created_at']    = date('Y-m-d',$productList->pl_uploaded);
                                            $el_products_params['product_modified_at']    = date('Y-m-d',$productList->pl_uploaded);
                                            $el_products_params['product_modified_at_exact']    = date('Y-m-d',$productList->pl_uploaded);
                                            $el_products_params['productsData']    = $arrProduct;


                                            $el_params = array();
                                            foreach($el_products_params["productsData"] as $key=>$val){
                                                $el_params['body'][] = array(
                                                    'index' => array(
                                                        '_index' => $el_products_params['index'],
                                                        '_type' => $el_products_params['type']
                                                    )
                                                );
                                                $el_params['body'][] = array(
                                                    'user_id' => $el_products_params['user_id'],
                                                    'product_list_id' => $el_products_params['product_list_id'],
                                                    'product_created_at' => $el_products_params['product_created_at'],
                                                    'product_modified_at' => $el_products_params['product_modified_at'],
                                                    'product_modified_at_exact' => $el_products_params['product_modified_at_exact'],
                                                    'product_name' => $val['product_name'],
                                                    'product_name_exact' => $val['product_name'],
                                                    'unit_qty' => $val['unit_qty'],
                                                    'unit_qty_exact' => $val['unit_qty'],
                                                    'brand' => $val['brand'],
                                                    'brand_exact' => $val['brand'],
                                                    'product_category' => $val['product_category'],
                                                    'product_category_exact' => $val['product_category']
                                                );
                                            }
                                            $client_elastic = new Elasticsearch\Client();
                                            if(!empty($el_params)){
                                                $bulk_products_index = $client_elastic->bulk($el_params);
                                            }
                                        }

                                        $this->flashSession->error($service_area->getMessages());
                                    }else{
                                        $product_sa = ProductList::findById((string)$service_area->product_list_id);
                                        //for Elasticsearch
                                        $el_product_list_service_area_params = array();
                                        $el_product_list_service_area_params['index'] = $this->config->elasticSearch->productList_serviceArea->index;
                                        $el_product_list_service_area_params['type']  = $this->config->elasticSearch->productList_serviceArea->type;
                                        $el_product_list_service_area_params['id']    = (string)$service_area->_id;

                                        $el_product_list_service_area_params['pl_name']    = $product_sa->pl_name;
                                        $el_product_list_service_area_params['pl_name_exact']    = $product_sa->pl_name;
                                        $el_product_list_service_area_params['pl_file_type']    = $product_sa->pl_file_type;
                                        $el_product_list_service_area_params['pl_file_type_exact']    = $product_sa->pl_file_type;
                                        $el_product_list_service_area_params['pl_size']    = $product_sa->pl_size;
                                        $el_product_list_service_area_params['pl_url']    = $product_sa->pl_url;
                                        $el_product_list_service_area_params['pl_uploaded']    = date('Y-m-d',$product_sa->pl_uploaded);
                                        $el_product_list_service_area_params['pl_uploaded_exact']    = date('Y-m-d',$product_sa->pl_uploaded);

                                        $el_product_list_service_area_params['user_id']    = (string)$service_area->user_id;
                                        $el_product_list_service_area_params['product_list_id']    = (string)$service_area->product_list_id;
                                        $el_product_list_service_area_params['sa_area_name']    = $service_area->sa_area_name;
                                        $el_product_list_service_area_params['sa_area_name_exact']    = $service_area->sa_area_name;
                                        $el_product_list_service_area_params['sa_country']    = $service_area->sa_country;
                                        $el_product_list_service_area_params['sa_country_exact']    = $service_area->sa_country;
                                        $el_product_list_service_area_params['sa_country_code']    = $service_area->sa_country_code;
                                        $el_product_list_service_area_params['sa_country_code_exact']    = $service_area->sa_country_code;
                                        $el_product_list_service_area_params['sa_area_code']    = $service_area->sa_area_code;
                                        $el_product_list_service_area_params['sa_phone']    = $service_area->sa_phone;
                                        $el_product_list_service_area_params['sa_street_address']    = $service_area->sa_street_address;
                                        $el_product_list_service_area_params['sa_state']    = $service_area->sa_state;
                                        $el_product_list_service_area_params['sa_state_exact']    = $service_area->sa_state;
                                        $el_product_list_service_area_params['sa_city']    = $service_area->sa_city;
                                        $el_product_list_service_area_params['sa_city_exact']    = $service_area->sa_city;
                                        $el_product_list_service_area_params['sa_postcode']    = $service_area->sa_postcode;
                                        $el_product_list_service_area_params['sa_postcode_exact']    = $service_area->sa_postcode;
                                        $el_product_list_service_area_params['sa_created_at']    = $service_area->sa_created_at;
                                        $el_product_list_service_area_params['sa_modified_at']    = date('Y-m-d',$service_area->sa_modified_at);
                                        $el_product_list_service_area_params['sa_modified_at_exact']    = date('Y-m-d',$service_area->sa_modified_at);

                                        $encode_product_list_service_area = base64_encode(serialize($el_product_list_service_area_params));
                                        $cmd_product_list_service_area = 'php '.APP_DIR .'/cli.php elastic createIndex ' . $encode_product_list_service_area;
                                        $process_product_list_service_area = new Process($cmd_product_list_service_area);
                                        $process_product_list_service_area->start();
                                        //end Elasticsearch
                                        if(!empty($arrProduct)){
                                            $el_products_params = array();
                                            $el_products_params['index'] = $this->config->elasticSearch->products->index;
                                            $el_products_params['type']  = $this->config->elasticSearch->products->type;
                                            $el_products_params['product_list_id']    = (string)$service_area->product_list_id;
                                            $el_products_params['user_id']    = (string)$service_area->user_id;
                                            $el_products_params['product_created_at']    = date('Y-m-d',$product_sa->pl_uploaded);
                                            $el_products_params['product_modified_at']    = date('Y-m-d',$product_sa->pl_uploaded);
                                            $el_products_params['product_modified_at_exact']    = date('Y-m-d',$product_sa->pl_uploaded);
                                            $el_products_params['productsData']    = $arrProduct;


                                            $el_params = array();
                                            foreach($el_products_params["productsData"] as $key=>$val){
                                                $el_params['body'][] = array(
                                                    'index' => array(
                                                        '_index' => $el_products_params['index'],
                                                        '_type' => $el_products_params['type']
                                                    )
                                                );
                                                $el_params['body'][] = array(
                                                    'user_id' => $el_products_params['user_id'],
                                                    'product_list_id' => $el_products_params['product_list_id'],
                                                    'product_created_at' => $el_products_params['product_created_at'],
                                                    'product_modified_at' => $el_products_params['product_modified_at'],
                                                    'product_modified_at_exact' => $el_products_params['product_modified_at_exact'],
                                                    'product_name' => $val['product_name'],
                                                    'product_name_exact' => $val['product_name'],
                                                    'unit_qty' => $val['unit_qty'],
                                                    'unit_qty_exact' => $val['unit_qty'],
                                                    'brand' => $val['brand'],
                                                    'brand_exact' => $val['brand'],
                                                    'product_category' => $val['product_category'],
                                                    'product_category_exact' => $val['product_category']
                                                );
                                            }
                                            $client_elastic = new Elasticsearch\Client();
                                            if(!empty($el_params)){
                                                $bulk_products_index = $client_elastic->bulk($el_params);
                                            }
                                        }

                                    }
                                } else {
                                    $this->flashSession->error($productList->getMessages());
                                }
                            }
                            $client = S3Client::factory(array(
                                'key'    => $this->config->amazon->AWSAccessKeyId,
                                'secret' => $this->config->amazon->AWSSecretKey,
                                'region' => 'us-west-2'
                            ));
                            $options = array(
                                'params'      => array('ACL' => 'public-read'),
                                'concurrency' => 20
                            );
                            $uploadDirectory = $client->uploadDirectory($dir, $bucket, $keyPrefix, $options);
                            $this->rrmdir($dir); // delete folder
                            session_unset();
                            session_destroy();
                        } else {
                            $this->flashSession->error("Not registered any Product List and Service Area.");
                        }
                        return $this->dispatcher->forward(array(
                            'controller' => 'index',
                            'action' => 'index'
                        ));

                    } else {
                        $this->flash->error($user->getMessages());
                        return $this->response->redirect('session/register-company-step1');
                    }
                    //save data from step1 end

                    return $this->response->redirect('session/register-company-step3');
                }
            }

        } else {
            return $this->response->redirect('session/register-company-step1');
        }
        $this->view->form = $form;
    }

    public function regContributorAction()
    {

        $form = new SignUpContributorForm();

        if ($this->request->isPost()) {


            if ($form->isValid($this->request->getPost()) != false) {

                $user = new Users();
                $user->email = $this->request->getPost('email', 'email');
                $user->first_name = $this->request->getPost('first_name', 'striptags');
                $user->name = $user->email;
                $user->password = $this->security->hash($this->request->getPost('password'));
                $user->content_type = $this->request->getPost('content_type');
                $user->profilesId = NEWS_CONTRIBUTOR_PROFILE_ID; //Contributor
                if ($user->save()) {

                    return $this->dispatcher->forward(array(
                        'controller' => 'index',
                        'action' => 'index'
                    ));
                }
                $this->flash->error($user->getMessages());
            }
        }

        $this->view->form = $form;
    }

    /**
     * Starts a session in the admin backend
     */
    public function loginAction()
    {
        $form = new LoginForm();
        $form_company = new LoginCompanyForm();

        try {

            if (!$this->request->isPost()) {

                if ($this->auth->hasRememberMe()) {
                    return $this->auth->loginWithRememberMe();
                }
            } else {

                $username_email = $this->request->getPost('email');

                if(filter_var($username_email, FILTER_VALIDATE_EMAIL)) {
                    //login User, Admin
                    if ($form->isValid($this->request->getPost()) == false) {
                        foreach ($form->getMessages() as $message) {
                            $this->flash->error($message);
                        }
                    } else {

                        $this->auth->check(array(
                            'email' => $this->request->getPost('email'),
                            'password' => $this->request->getPost('password'),
                            'remember' => $this->request->getPost('remember')
                        ));

                        $identity = $this->session->get('auth-identity');

                        if($identity['profile'] == 'Companies'){
                            return $this->response->redirect('company');
                        }
                        if($identity['profile'] == 'Administrators'){
                            return $this->response->redirect('admin-dashboard');
                        }

                        return $this->response->redirect('user');
                    }
                } else {
                    //login Company
                    if ($form_company->isValid($this->request->getPost()) == false) {
                        foreach ($form_company->getMessages() as $message) {
                            $this->flash->error($message);
                        }
                    } else {

                        $this->auth->checkCompany(array(
                            'username' => $this->request->getPost('email'),
                            'password' => $this->request->getPost('password'),
                            'remember' => $this->request->getPost('remember')
                        ));

                        $identity = $this->session->get('auth-identity');

                        if($identity['profile'] == 'Companies'){
                            return $this->response->redirect('company');
                        }
                        if($identity['profile'] == 'Administrators'){
                            return $this->response->redirect('admin-dashboard');
                        }

                        return $this->response->redirect('user');
                    }
                }
            }
        } catch (AuthException $e) {
            $this->flash->error($e->getMessage());
        }

        $this->view->form = $form;
    }

    /**
     * Shows the forgot password form
     */
    public function forgotPasswordAction()
    {
        $form = new ForgotPasswordForm();

        if ($this->request->isPost()) {

            if ($form->isValid($this->request->getPost()) == false) {
                foreach ($form->getMessages() as $message) {
                    $this->flash->error($message);
                }
            } else {

                $user = Users::findFirstByEmail($this->request->getPost('email'));
                if (!$user) {
                    $this->flash->success('There is no account associated to this email');
                } else {

                    $resetPassword = new ResetPasswords();
                    $resetPassword->usersId = $user->_id->{'$id'};
                    if ($resetPassword->save()) {
                        $this->flash->success('Success! Please check your messages for an email reset password');
                    } else {
                        foreach ($resetPassword->getMessages() as $message) {
                            $this->flash->error($message);
                        }
                    }
                }
            }
        }

        $this->view->form = $form;
    }

    /**
     * Closes the session
     */
    public function logoutAction()
    {
        $this->auth->remove();

        return $this->response->redirect('index');
    }

    public function rrmdir($dir) {
        if (is_dir($dir)) {
            $objects = scandir($dir);
            foreach ($objects as $object) {
                if ($object != "." && $object != "..") {
                    if (filetype($dir."/".$object) == "dir") rrmdir($dir."/".$object); else unlink($dir."/".$object);
                }
            }
            reset($objects);
            rmdir($dir);
        }
    }
}
