<?php
namespace Findmyrice\Controllers;

use Phalcon\Tag;
use Phalcon\Mvc\Collection;
use Phalcon\Paginator\Adapter\NativeArray as Paginator;
use Findmyrice\Models\Users;

/**
 * Findmyrice\Controllers\UsersController
 * CRUD to manage users
 */
class ProductsController extends ControllerBase
{

    public function initialize()
    {
        $this->assets->addCss('css/font-awesome.min.css');
        $this->assets->addCss('css/wingding.css');
        $this->view->setTemplateBefore('public');
    }

    /**
     * Default action, shows the search form
     */
    public function indexAction()
    {
        $this->view->bucketUrl = BUCKET_URL;
        $this->view->companies = false;
        $this->view->profile = '';

        //Companies
        $users = new Users();
        $companies = $users->getCompanies();
//
        $data = array();
        foreach($companies as $k=>$company){
            $data[$k]['company'] = $company->toArray();
            $company_profile = $company->getProfile();
            if($company_profile){
                $data[$k]['profile'] = $company_profile->toArray();
            }else{
                $data[$k]['profile'] = false;
            }
            $data[$k]['products'] = $this->external->Products_Location($company->_id->{'$id'});
        }

        $this->view->all_data = $data;
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
}
