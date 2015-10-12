<?php
namespace Findmyrice\Controllers;

use Findmyrice\Forms\ContactCompanyForm;
use Phalcon\Tag;
use Phalcon\Mvc\Collection;
use Phalcon\Paginator\Adapter\NativeArray as Paginator;
use Findmyrice\Models\Users;
use Findmyrice\Models\Profile;
use Findmyrice\Models\Gallery;
use Findmyrice\Models\CompanyMessages;
use Findmyrice\Models\UserMessages;


/**
 * Findmyrice\Controllers\CompaniesController
 */
class CompaniesController extends ControllerBase
{

    public function initialize()
    {
        $this->assets->addCss('css/font-awesome.min.css');
        $this->assets->addCss('css/wingding.css');
        $this->assets->addJs('js/companies/companies_like.js');
        $this->view->setTemplateBefore('public');
    }

    /**
     * Default action, shows the search form
     */
    public function indexAction($company_id = null)
    {
        $this->assets->addJs('js/no-conflict.js')
            ->addJs('js/fancyapps/lib/jquery-1.10.1.min.js')
            ->addJs('js/fancyapps/lib/jquery.mousewheel-3.0.6.pack.js')
            ->addJs('js/fancyapps/source/jquery.fancybox.js?v=2.1.5')
            ->addCss('js/fancyapps/source/jquery.fancybox.css?v=2.1.5')
            ->addJs('js/companies/for-fancy.js');

        $this->assets->addJs('js/no-conflict.js')
            ->addJs('js/jquery-1.6.1.min.js')
            ->addJs('js/jquery.masonry.js')
            ->addJs('js/companies/index.js')
            ->addCss('css/style_masonry.css');

        $company_id = $this->dispatcher->getParam('company_id');

        $this->view->company = '';
        $this->view->profile = '';
        $this->view->Products_Location = false;
        $this->view->company_id = $company_id;
        $this->view->bucketUrl = BUCKET_URL;
        $this->view->galleries = false;
        $this->view->similarCompanies = false;
        $this->view->contactForm = false;

        try {
            //Company
            $company = Users::findById($company_id);

            if(!$company){
                $this->flash->error("Something wrong for this company.");
                return $this->dispatcher->forward(array(
                    'controller' => 'index',
                    'action' => 'index'
                ));
            }
            //Company Profile
            $company_profile = Profile::findByUserId($company_id);

            $this->view->company = $company;
            $this->view->profile = $company_profile;

            $product_and_serviceArea = $this->external->Products_Location($company_id);

            if($product_and_serviceArea){
                $this->view->Products_Location = $product_and_serviceArea;
            }
            try{
                $galleries = array();
                $galleriesArr = Gallery::findByUserId($company_id);
                if(!empty($galleriesArr)){
                    foreach($galleriesArr as $gallery){
                        $galleries[] = $gallery->photo_name;
                    }
                }

                $this->view->galleries = $galleries;
            }catch (\Exception $eg){

            }

            try{
             $similarCompanies = Users::find(array(
                    array(
                        'active' => 'Y',
                        'profilesId'=> $company->profilesId,
                        'business_type' => $company->business_type
                    ),
                    'sort' => array(
                        'start_date' => 1
                    )
                ));

                $sCompanis_profile = array();
                $arr_company = array();
                foreach($similarCompanies as $sk=>$sCompany){
                    $profile_c = Profile::findByUserId($sCompany->_id);
                    if($profile_c){
                        $arr_company[$sk] = $sCompany->toArray();
                        $sCompanis_profile[$sk] = $profile_c->toArray();
                    }
                    if(count($sCompanis_profile) == 4){
                        break;
                    }
                }

                $similarCompaniesProfiles = array();
                foreach($sCompanis_profile as $key=>$sCompany_p){
                    if($sCompany_p){
                        $similarCompaniesProfiles[$key]['user']  = $arr_company[$key];
                        $similarCompaniesProfiles[$key]['profile']  = $sCompanis_profile[$key];
                    }
                }

                $this->view->similarCompanies = $similarCompaniesProfiles;
            }catch (\Exception $er_s){

            }

            $contactForm = new ContactCompanyForm();
            $this->view->contactForm = $contactForm;

            $this->_prepareFlashMessages();

        }catch (\Exception $e){
            $this->flash->error("Company was not found");
            return $this->dispatcher->forward(array(
                'controller' => 'index',
                'action' => 'index'
            ));
        }

    }

    /**
     * Gallery of Company
     */
    public function galleryAction($company_id = null)
    {
        $company_id = $this->dispatcher->getParam('company_id');
        $this->assets->addJs('js/no-conflict.js')
                     ->addJs('js/fancyapps/lib/jquery-1.10.1.min.js')
                     ->addJs('js/fancyapps/lib/jquery.mousewheel-3.0.6.pack.js')
                     ->addJs('js/fancyapps/source/jquery.fancybox.js?v=2.1.5')
                     ->addCss('js/fancyapps/source/jquery.fancybox.css?v=2.1.5')
                     ->addJs('js/companies/for-fancy.js');
        $this->assets->addJs('js/no-conflict.js')
                     ->addJs('js/jquery-1.6.1.min.js')
                     ->addJs('js/jquery.masonry.js')
                     ->addJs('js/companies/gallery.js')
                     ->addCss('css/style_masonry.css');

        $this->view->company = '';
        $this->view->profile = '';
        $this->view->Products_Location = false;
        $this->view->company_id = $company_id;
        $this->view->bucketUrl = BUCKET_URL;
        $this->view->galleries = false;

        try {
            //Company
            $company = Users::findById($company_id);

            //Company Profile
            $company_profile = Profile::findByUserId($company_id);

            $this->view->company = $company;
            $this->view->profile = $company_profile;

        }catch (\Exception $e){
            $this->flash->error("Company was not found");
            return $this->dispatcher->forward(array(
                'controller' => 'index',
                'action' => 'index'
            ));
        }
        try{
            $galleries = array();
            $galleriesArr = Gallery::findByUserId($company_id);
            if(!empty($galleriesArr)){
                foreach($galleriesArr as $gallery){
                    $galleries[] = $gallery->photo_name;
                }
            }
            $this->view->galleries = $galleries;
        }catch (\Exception $eg){

        }

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

    public function contactCompanyAction()
    {
        if ($this->request->isPost()) {
            $form = new ContactCompanyForm();
            
            $companyMessages = new CompanyMessages();
            $userMessage = new UserMessages();
            
            $form->bind($this->request->getPost(), $companyMessages);

            if ($form->isValid()) {
                
                // Company message                
                $companyMessages->status = '1';
                $companyMessages->read = '0';
                $companyMessages->subject = 'subject';
                $companyMessages->company_id = $this->request->getPost('company_id');
                $companyMessages->email = $this->request->getPost('email', 'email');
                $companyMessages->message = $this->request->getPost('message');
                $companyMessages->name = $this->request->getPost('name');
                
                $company = Users::findById($companyMessages->company_id);
                
                // User message
                $user = Users::findFirstByEmail($companyMessages->email);
                
                if ($user) {
                    $userMessage->user_id = $user->_id->{'$id'};
                }
                $userMessage->status = '2';
                $userMessage->subject = 'subject';
                $userMessage->message = $companyMessages->message;
                
                if ($company) {
                    $userMessage->name = $company->first_name ."  ". $company->last_name;
                    $userMessage->email = $company->email;
                }
                
                // Send message
                if (!$companyMessages->save()) {
                    $this->response->setStatusCode(500, 'Can\'t save company message in database');
                } else {
                    
                    $from = $companyMessages->email;    // give from email address

	                // mandatory headers for email message, change if you need something different in your setting.
	                $headers = "From: " . $from . "\r\n";
                    
                    if ($userMessage->save()) {
                        if ($this->getDI()->getMail()->sendMessage($company->email, $companyMessages->subject, 'communication', array('email' => $companyMessages->email, 'name' => $companyMessages->name, 'message' => $companyMessages->message), $headers)) {

                            $ref_url = $this->request->getHTTPReferer();
                            $ref = explode('?',$ref_url);
                            $this->response->redirect($ref[0].'?message=ok');

                        }

                        $ref_url = $this->request->getHTTPReferer();
                        $ref = explode('?',$ref_url);
                        $this->response->redirect($ref[0].'?message=ok');
                    }
                }
            } else {
                $ref_url = $this->request->getHTTPReferer();
                $ref = explode('?',$ref_url);
                $this->response->redirect($ref[0].'?message=error');
            }
        }
    }

    private function _prepareFlashMessages()
    {
        $message = $this->request->get('message');
        if ($message == 'ok') {
            $this->flash->success('Message was sent successfully');
        } else if ($message == 'error') {
            $this->flash->error('Message was not sent');
        }
    }

    /**
     * Creates a User
     */
    public function createAction()
    {

    }

    /**
     * Saves the user from the 'edit' action
     */
    public function editAction($id = null)
    {

    }

    /**
     * Deletes a User
     *
     * @param int $id
     */
    public function deleteAction($id)
    {

    }

}
