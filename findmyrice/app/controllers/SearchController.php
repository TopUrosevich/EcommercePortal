<?php
namespace Findmyrice\Controllers;

use Findmyrice\Models\ElasticSearchModel;
use Phalcon\Tag;
use Phalcon\Mvc\Collection;
use Phalcon\Paginator\Adapter\NativeArray as Paginator;
use Findmyrice\Models\Users;
use Elasticsearch;

use Findmyrice\Forms\AdvancedSearchForm;
use Findmyrice\Forms\SimpleSearchForm;

/**
 * Findmyrice\Controllers\SearchController
 *
 */
class SearchController extends ControllerBase
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
    public function defaultAction()
    {
        $this->assets
            ->addJs('js/chosen.jquery.min.js')
            ->addJs('js/jquery-ui.min.js')
            ->addJs('js/search/index.js')
            ->addJs('js/elasticsearch_autocomplete.js')
            ->addcss('css/chosen.min.css')
            ->addCss('css/wingding3.css')
            ->addCss('css/jquery-ui.min.css');

        $get_data = $this->request->getQuery();
        $ad_form = new AdvancedSearchForm(null, $get_data);
        $this->view->ad_form = $ad_form;

        $sp_form = new SimpleSearchForm(null, $get_data);
        $this->view->sp_form = $sp_form;

        //for elasticsearch
        $ElasticSearchModel = new ElasticSearchModel();

        $featuredCompanies = $ElasticSearchModel->_prepareFeaturedCompanies(3);

        $geoData = $this->external->getGeoData();
        $new_companies_in_your_area = $ElasticSearchModel->findCompaniesByArea($geoData);

        if(!empty($new_companies_in_your_area)){
            $paginator = new Paginator(array(
                'data' => $new_companies_in_your_area,
                'limit' => 12,
                'page' => $this->request->get('page', 'int')
            ));
            $page = $paginator->getPaginate();
        }else{
            $page = false;
        }

        $this->view->setVars(array(
            'page' => $page,
            'featuredCompanies' =>$featuredCompanies,
        ));
    }

    /**
     * Index action, shows the search form
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
        $get_data = $this->request->getQuery();

        $this->view->url_params = $get_data;

        $leftSide = false;
        $ad_form = new AdvancedSearchForm(null, $get_data);
        $this->view->ad_form = $ad_form;

        $sp_form = new SimpleSearchForm(null, $get_data);
        $this->view->sp_form = $sp_form;

        $this->view->bucketUrl = BUCKET_URL;
        $this->view->companies = false;
        $this->view->profile = '';

        //for Elasticsearch
        $ElasticSearchModel = new ElasticSearchModel();

        if(count($get_data) > 1 && !isset($get_data["products_only"]) && !isset($get_data["companies_only"])){
            $lf_filter_data = true;
            $companies_allData = $ElasticSearchModel->search($get_data);
            if(!empty($get_data['name_pcck']) || !empty($companies_allData['location'])){
                if(!empty($companies_allData['companies']) || !empty($companies_allData['plsa'])){
                    $leftSide = true;
                }
            }
            if(empty($get_data['name_pcck']) || empty($companies_allData['location'])){
                if(!empty($companies_allData['companies']) || !empty($companies_allData['plsa'])){
                    $leftSide = true;
                }
            }
        } elseif(!isset($lf_filter_data)) {
            $companies = $ElasticSearchModel->findCompaniesProfile();
            $companies_allData["companies"] = $companies["companies"];
            $companies_allData["plsa"]["totalProducts"] = 0;
            foreach($companies_allData["companies"] as $key=>$company){
                $products = $ElasticSearchModel->getProductsFromCompany(array(), '', $company);
                if($products["totalProducts"] != 0){
                    $companies_allData["plsa"]["totalProducts"] += $products["totalProducts"];
                    $companies_allData["plsa"][$company["_source"]["user_id"]]= $products[$company["_source"]["user_id"]];

                }
            }
            $companies_allData["companies"]["totalCompanies"] = $companies["totalCompanies"];
        }else{
            $companies_allData['companies'] = array();
            $companies_allData['plsa'] = array();
        }

        $count_products = 0;
        $count_companies = 0;

        if(isset($companies_allData["plsa"]["totalProducts"])){
            $count_products = $companies_allData["plsa"]["totalProducts"];
            unset($companies_allData["plsa"]["totalProducts"]);
        }

        if(isset($companies_allData["companies"]["totalCompanies"])){
            $count_companies = $companies_allData["companies"]["totalCompanies"];
            unset($companies_allData["companies"]["totalCompanies"]);
        }

        $featuredCompanies = $ElasticSearchModel->_prepareFeaturedCompanies(3);

        if(isset($companies_allData["facets"])){
            $this->_prepareFacets($companies_allData["facets"]);
            unset($companies_allData["facets"]);
        }


        $this->view->setVars(array(
            'companies_allData' => $companies_allData,
            'count_companies' =>$count_companies,
            'count_products' =>$count_products,
            'featuredCompanies' =>$featuredCompanies,
            'leftSide' =>$leftSide,
        ));
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

    private function _prepareFacets($dataFacets){

        $categoriesData = array();
        $stateData = array();
        $cityData = array();
        $keywordsData = array();
        $businessTypeData = array();
        $premium = array();
        $currently_export = array();
        $currently_import = array();
        if(isset($dataFacets) && !empty($dataFacets)){
            foreach($dataFacets as $key=>$companies_facet){
                switch ($key) {
                    case "tagline_exact":
                        $categoriesData = $companies_facet;
                        break;
                    case "state_exact":
                        $stateData = $companies_facet;
                        break;
                    case "city_exact":
                        $cityData = $companies_facet;
                        break;
                    case "keywords_exact":
                        $keywordsData = $companies_facet;
                        break;
                    case "business_type_exact":
                        $businessTypeData = $companies_facet;
                        break;
                    case "premium":
                        $premium = $companies_facet;
                        break;
                    case "currently_export":
                        $currently_export = $companies_facet;
                        break;
                    case "currently_import":
                        $currently_import = $companies_facet;
                        break;
                }
            }
        }
        $this->view->setVars(array(
            'categoriesData' => $categoriesData,
            'stateData' => $stateData,
            'cityData' =>$cityData,
            'keywordsData' =>$keywordsData,
            'businessTypeData' =>$businessTypeData,
            'premiumData' =>$premium,
            'exporterData' =>$currently_export,
            'importerData' =>$currently_import,
        ));
    }
}
