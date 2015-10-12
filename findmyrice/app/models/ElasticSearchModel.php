<?php
namespace Findmyrice\Models;

use Elasticsearch;

class ElasticSearchModel extends \Phalcon\Mvc\Collection
{

    public function search(array $data){

        if(isset($data['simple_search']) && $data['simple_search'] == "yes"){
            $simple_search_result = $this->findSimpleSearch($data);
            return $simple_search_result;
        }

        if(isset($data['advanced_search']) && $data['advanced_search'] == "yes"){
            $advanced_search_result = $this->findAdvancedSearch($data);
            return $advanced_search_result;
        }
    }

    //simple search
    public function findSimpleSearch($data = null){

        $companies_allData = array();
        //products
        $pl_sa_s = array();
        if( (isset($data["location"]) && !empty($data["location"]))
            || (isset($data["lf_state"]) && !empty($data["lf_state"]))
            || (isset($data["lf_city"]) && !empty($data["lf_city"]))
        ){
            $pl_sa_s = $this->getProductsByNameAndLocation(array(),$data);
        }else{
            $pl_sa_s = $this->getProductsByName(array(),$data);
        }
        //companies
        $allData_companies = $this->getCompaniesByNameAndLocation($data);
        $companies_allData['companies'] = $allData_companies["hits"];
        $companies_allData['companies']["totalCompanies"] = $allData_companies["totalCompanies"];
        $companies_allData['facets'] = $allData_companies["facets"];
        $companies_allData['plsa'] = $pl_sa_s;
        return $companies_allData;
    }

    public function _preparePLSA_AdvanceSearch($filter = array(), array $data, $from = 0, $size = 1){

        $config = $this->getDI()->get('config');
        $clientPLSA= new Elasticsearch\Client();
        $searchPLSAParams['index'] = $config['elasticSearch']['productList_serviceArea']['index'];
        $searchPLSAParams['type']  = $config['elasticSearch']['productList_serviceArea']['type'];

        $query1PLSA = array();
        if(isset($data['country']) && !empty($data['country'])){
            $query1PLSA["bool"]["must"][]["match"] = array("sa_country"=>$data['country']);
        }
        if(isset($data['state']) && !empty($data['state'])){
            $query1PLSA["bool"]["must"][]["match"] = array("sa_state"=>$data['state']);
        }
        if(isset($data['city']) && !empty($data['city'])){
            $query1PLSA["bool"]["must"][]["match"] = array("sa_city"=>$data['city']);
        }
        $filter = $this->getLeftSideFilterForProducts($data);

        $searchPLSAParams["body"]["query"]["filtered"] = array(
            "query"=>$query1PLSA,
            "filter"=>$filter
        );
        $result_search = $clientPLSA->search($searchPLSAParams);

        $result_search_PLSA_hits = $result_search["hits"]["hits"];
        $all_data_products = array();
        $totalProducts = 0;
        foreach($result_search_PLSA_hits as $k=>$plsa){
            $filter1["bool"]["must"][]["term"]["product_list_id"] =  $plsa["_source"]["product_list_id"];
            $result_search_products = $this->getProductsByNameAdvancedSearch($filter1, $data, $from, $size);
            $totalProducts += $result_search_products["totalProducts"];
            unset($result_search_products["totalProducts"]);
            foreach($result_search_products as $key=>$data_products){
                foreach($data_products as $key2=>$_products){
                    if($key2 !== "totalProducts" ){
                        $all_data_products[$key][$key2] = $_products;
                        $all_data_products[$key][$key2]["_source"]["sa_state"] = $plsa["_source"]["sa_state"];
                        $all_data_products[$key][$key2]["_source"]["sa_city"] = $plsa["_source"]["sa_city"];
                    }else{
                        $all_data_products[$key][$key2] = $_products;
                    }
                }
            }
        }
        $all_data_products["totalProducts"] = $totalProducts;

        return $all_data_products;
    }

    public function _prepareCompanyForAdvancedSearch(array $data){

        $config = $this->getDI()->get('config');
        $clientCompanyProfile = new Elasticsearch\Client();
        $searchCompanyProfileParams['index'] = $config['elasticSearch']['companyProfile']['index'];
        $searchCompanyProfileParams['type']  = $config['elasticSearch']['companyProfile']['type'];

        $queryCompanyProfileParams = array();

        $queryCompanyProfileParams["bool"]["must"][]["match"] = array("active"=>"Y");

        if(!empty($data['company_name'])){
            $queryCompanyProfileParams["bool"]["must"][]["match"] = array("title"=>$data['company_name']);
        }
        if(!empty($data['company_category'])){
            $queryCompanyProfileParams["bool"]["must"][]["match"] = array("tagline"=>$data['company_category']);
        }
        if(!empty($data['business_type'])){
            $queryCompanyProfileParams["bool"]["must"][]["match"] = array("business_type"=>$data['business_type']);
        }
        if(!empty($data['country'])){
            $queryCompanyProfileParams["bool"]["must"][]["match"] = array("country"=>$data['country']);
        }
        if(isset($data['state']) && !empty($data['state'])){
            $queryCompanyProfileParams["bool"]["must"][]["match"] = array("state"=>$data['state']);
        }
        if(isset($data['city']) && !empty($data['city'])){
            $queryCompanyProfileParams["bool"]["must"][]["match"] = array("state"=>$data['city']);
        }

        if(isset($data['importers']) && !empty($data['importers'])){
            $queryCompanyProfileParams["bool"]["must"][]["match"] = array("currently_import"=>$data['importers']);
        }

        if(isset($data['exporters']) && !empty($data['exporters'])){
            $queryCompanyProfileParams["bool"]["must"][]["match"] = array("currently_export"=>$data['exporters']);
        }
        $filter = $this->getLeftSideFilterForCompanies($data);

        $searchCompanyProfileParams["body"]["query"]["filtered"] = array(
            "query"=>$queryCompanyProfileParams,
            "filter"=>$filter
        );

        $arr_facets = array(
            "tagline_exact","state_exact","city_exact","keywords_exact",
            "business_type_exact","premium","currently_export","currently_import"
        );
        foreach($arr_facets as $facets){
            $searchCompanyProfileParams["body"]["facets"][$facets]["terms"] = array(
                "field"=>$facets,
                "size" => 10
            );
        }

        $result_search_companies = $clientCompanyProfile->search($searchCompanyProfileParams);
        $totalCompanies = $result_search_companies["hits"]["total"];
        $companies["hits"] = $result_search_companies["hits"]["hits"];

        $companies["facets"] = $result_search_companies["facets"];
        $companies["totalCompanies"] = $totalCompanies;

        return $companies;
    }

    //advanced search
    public function findAdvancedSearch($data = null){

        $companies_allData = array();
        //companies
        $companies = $this->_prepareCompanyForAdvancedSearch($data);
        //Product Lists with Service Area
        $pl_sa_s = array();
        if( (isset($data["country"]) && !empty($data["country"]))
            || (isset($data["state"]) && !empty($data["state"]))
            || (isset($data["city"]) && !empty($data["city"]))
            || (isset($data["lf_state"]) && !empty($data["lf_state"]))
            || (isset($data["lf_city"]) && !empty($data["lf_city"]))
        ){
            $pl_sa_s = $this->_preparePLSA_AdvanceSearch(array(), $data);
        }else{
            $pl_sa_s = $this->getProductsByNameAdvancedSearch(array(),$data);
        }
        $companies_allData['plsa'] = $pl_sa_s;
        $companies_allData['companies'] = $companies["hits"];
        $companies_allData['companies']["totalCompanies"] = $companies["totalCompanies"];
        $companies_allData['facets'] = $companies["facets"];
        return $companies_allData;
    }

    public function findCompaniesProfile(){
        $config = $this->getDI()->get('config');

        $clientCompany = new Elasticsearch\Client();
        $searchCompanyParams['index'] = $config['elasticSearch']['companyProfile']['index'];
        $searchCompanyParams['type']  = $config['elasticSearch']['companyProfile']['type'];
        $searchCompanyParams['body']['query']['match']['active'] = 'Y';

        $result_search_companies = $clientCompany->search($searchCompanyParams);
        $totalCompanies = $result_search_companies["hits"]["total"];
        $companies["totalCompanies"] = $totalCompanies;
        $companies["companies"] = $result_search_companies["hits"]["hits"];
        return $companies;
    }

    public function findCompanyProfile($company_id = null){

        $config = $this->getDI()->get('config');

        $clientCompanyProfile = new Elasticsearch\Client();
        $searchCompanyProfileParams['index'] = $config['elasticSearch']['companyProfile']['index'];
        $searchCompanyProfileParams['type']  = $config['elasticSearch']['companyProfile']['type'];
//        $searchCompanyProfileParams['body']['query']['match']['active'] = 'Y';
        $filter_profile = array();
        $filter_profile['term']['user_id'] = $company_id;

        $searchCompanyProfileParams['body']['query']['filtered'] = array(
            "filter" => $filter_profile
        );
        $result_search_companies_profile = $clientCompanyProfile->search($searchCompanyProfileParams);
        if(!empty($result_search_companies_profile["hits"]["hits"])){
            $companyProfile = $result_search_companies_profile["hits"]["hits"][0];
        }else{
            $companyProfile = $result_search_companies_profile["hits"]["hits"];
        }

        return $companyProfile;
    }

    public function distinctCountries() {

        $config = $this->getDI()->get('config');

        $client_Companies = new Elasticsearch\Client();

        $searchCompanyProfileParams['index'] = $config['elasticSearch']['companyProfile']['index'];
        $searchCompanyProfileParams['type']  = $config['elasticSearch']['companyProfile']['type'];

        $searchCompanyProfileParams['body']['sort']['country'] = 'asc';
        $searchCompanyParams['body']['query']['match']['active'] = 'Y';

        $result_search_companies_profile = $client_Companies->search($searchCompanyProfileParams);
        $companiesProfile = $result_search_companies_profile["hits"]["hits"];
        $country = array();
        $i = 0;
        foreach($companiesProfile as $k=>$company) {
            $i = $k;
            $country[$k] = $company['_source']['country'];
        }

        $client_ServiceArea = new Elasticsearch\Client();
        $searchServiceAreaParams['index'] = $config['elasticSearch']['productList_serviceArea']['index'];
        $searchServiceAreaParams['type']  = $config['elasticSearch']['productList_serviceArea']['type'];
        $searchServiceAreaParams['body']['sort']['sa_country'] = 'asc';
        $result_search_service_area = $client_ServiceArea->search($searchServiceAreaParams);
        $serviceAreas = $result_search_service_area["hits"]["hits"];
        foreach($serviceAreas as $k=>$serviceArea) {
            $country[$i+$k] = $serviceArea['_source']['sa_country'];
        }
        array_multisort($country, SORT_ASC, SORT_STRING);
        return array_unique($country);
    }

    public function distinctStatesByCountry($country)
    {
        $config = $this->getDI()->get('config');

        $client_Companies = new Elasticsearch\Client();

        $searchCompanyProfileParams['index'] = $config['elasticSearch']['companyProfile']['index'];
        $searchCompanyProfileParams['type']  = $config['elasticSearch']['companyProfile']['type'];

        $searchCompanyProfileParams['body']['sort']['state'] = 'asc';

        $query = array();
        $query['match']['country_exact'] = $country;

        $searchCompanyProfileParams['body']['query']['filtered'] = array(
            "query"  => $query
        );

        $result_search_companies_profile = $client_Companies->search($searchCompanyProfileParams);
        $companiesProfile = $result_search_companies_profile["hits"]["hits"];
        $states = array();
        $i=0;
        foreach($companiesProfile as $k=>$company) {
            $i = $k;
            $states[$k] = $company['_source']['state'];
        }

        $client_ServiceArea = new Elasticsearch\Client();
        $searchServiceAreaParams['index'] = $config['elasticSearch']['productList_serviceArea']['index'];
        $searchServiceAreaParams['type']  = $config['elasticSearch']['productList_serviceArea']['type'];
        $searchServiceAreaParams['body']['sort']['sa_state'] = 'asc';
        $query_state = array();
        $query_state['match']['sa_country_exact'] = $country;
        $searchServiceAreaParams['body']['query']['filtered'] = array(
            "query"  => $query_state
        );

        $result_search_service_area = $client_ServiceArea->search($searchServiceAreaParams);
        $serviceAreas = $result_search_service_area["hits"]["hits"];
        foreach($serviceAreas as $k=>$serviceArea) {
            $states[$i+$k] = $serviceArea['_source']['sa_state'];
        }
        array_multisort($states, SORT_ASC, SORT_STRING);
        $states = array_unique($states);
        $response = array_combine($states, $states);
        return $response;
    }

    public function distinctCitiesByState($country, $state) {

        $config = $this->getDI()->get('config');

        $client_Companies = new Elasticsearch\Client();

        $searchCompanyProfileParams['index'] = $config['elasticSearch']['companyProfile']['index'];
        $searchCompanyProfileParams['type']  = $config['elasticSearch']['companyProfile']['type'];

        $searchCompanyProfileParams['body']['sort']['city'] = 'asc';
//        $searchCompanyParams['body']['query']['match']['active'] = 'Y';

        $searchCompanyProfileParams['body']['query']['bool']['must'] = array(
            array('match' => array('country_exact' => $country)),
            array('match' => array('state_exact' => $state)),
        );

        $result_search_companies_profile = $client_Companies->search($searchCompanyProfileParams);
        $companiesProfile = $result_search_companies_profile["hits"]["hits"];
        $cities = array();
        $i = 0;
        foreach($companiesProfile as $k=>$company) {
            $i = $k;
            $cities[$k] = $company['_source']['city'];
        }

        $client_ServiceArea = new Elasticsearch\Client();
        $searchServiceAreaParams['index'] = $config['elasticSearch']['productList_serviceArea']['index'];
        $searchServiceAreaParams['type']  = $config['elasticSearch']['productList_serviceArea']['type'];
        $searchServiceAreaParams['body']['sort']['sa_city'] = 'asc';

        $searchServiceAreaParams['body']['query']['bool']['must'] = array(
            array('match' => array('sa_country_exact' => $country)),
            array('match' => array('sa_state_exact' => $state)),
        );

        $result_search_service_area = $client_ServiceArea->search($searchServiceAreaParams);
        $serviceAreas = $result_search_service_area["hits"]["hits"];
        foreach($serviceAreas as $k=>$serviceArea) {
            $cities[$i+$k] = $serviceArea['_source']['sa_city'];
        }
        array_multisort($cities, SORT_ASC, SORT_STRING);

        $cities = array_unique($cities);
        $response = array_combine($cities, $cities);

        return $response;
    }

    public function _prepareFeaturedCompanies($limit = 3)
    {
        $config = $this->getDI()->get('config');

        //search Company Profile
        $clientCompanyProfile = new Elasticsearch\Client();
        $searchCompanyProfileParams['index'] = $config['elasticSearch']['companyProfile']['index'];
        $searchCompanyProfileParams['type'] = $config['elasticSearch']['companyProfile']['type'];

        $query_CompanyProfile = array();
        $query_CompanyProfile['term']['active'] = 'Y';
        $searchCompanyProfileParams['body']['sort']['modified_at'] = 'desc';
        $searchCompanyProfileParams['body']['from'] = 0;
        $searchCompanyProfileParams['body']['size']= $limit;
        $searchCompanyProfileParams['body']['query']['filtered'] = array(
            "query"  => $query_CompanyProfile
        );

        $result_search_companies_profile = $clientCompanyProfile->search($searchCompanyProfileParams);
        $companies_Featured = $result_search_companies_profile["hits"]["hits"];

        return $companies_Featured;
    }

    public function _prepareGetCategoriesData()
    {
        $config = $this->getDI()->get('config');

        $client_Companies = new Elasticsearch\Client();

        $searchCompanyProfileParams['index'] = $config['elasticSearch']['companyProfile']['index'];
        $searchCompanyProfileParams['type']  = $config['elasticSearch']['companyProfile']['type'];

        $searchCompanyProfileParams['body']['sort']['tagline'] = 'asc';

        $result_search_companies_profile = $client_Companies->search($searchCompanyProfileParams);
        $companiesProfile = $result_search_companies_profile["hits"]["hits"];


        $categories = array();
        foreach($companiesProfile as $k=>$company) {
            if(isset($company['_source']['tagline'])){
                $categories[] = $company['_source']['tagline'];
            }
        }
        if(!empty($categories)){
            $arr_categories = array();
            for($i=0; $i < count($categories); $i++){
                for($j=0; $j < count($categories[$i]); $j++){
                    $arr_categories[] = $categories[$i][$j];
                }
            }
            $count_categories = array_count_values($arr_categories);
            array_multisort($count_categories, SORT_DESC, SORT_NUMERIC);

            $categories = array_unique($arr_categories);

            $response["categories"] = $categories;
            $response["categories_count"] = $count_categories;
        }else {
            $response["categories"] = false;
            $response["categories_count"] = false;
        }

        return $response;
    }


    public function getProductsByCompanyId($company_id){
        $config = $this->getDI()->get('config');
            $clientPLSA= new Elasticsearch\Client();
            $searchPLSAParams['index'] = $config['elasticSearch']['productList_serviceArea']['index'];
            $searchPLSAParams['type']  = $config['elasticSearch']['productList_serviceArea']['type'];
            $searchPLSAParams['body']['query']['bool']['must'] = array(
                'match' => array('user_id' => $company_id)
            );
            $result_search = $clientPLSA->search($searchPLSAParams);

        return $result_search["hits"]["hits"];
    }
    public function getProductsByNameAndLocation($filter = array(), $data,  $from = 0, $size = 1){

        $config = $this->getDI()->get('config');
        $clientPLSA= new Elasticsearch\Client();
        $searchPLSAParams['index'] = $config['elasticSearch']['productList_serviceArea']['index'];
        $searchPLSAParams['type']  = $config['elasticSearch']['productList_serviceArea']['type'];

        $queryPLSA = array();
        if(!empty($data["location"])){
                $queryPLSA["bool"]["must"][]["multi_match"] = array(
                    "query" => $data["location"],
                    "fields" => array("sa_country", "sa_state", "sa_city","sa_postcode")
                );
        }

        $filter = $this->getLeftSideFilterForProducts($data);

        $searchPLSAParams["body"]["query"]["filtered"] = array(
            "query"=>$queryPLSA,
            "filter"=>$filter
        );
        $result_search_PLSA = $clientPLSA->search($searchPLSAParams);

        //find plsa
        $result_search_PLSA_hits = $result_search_PLSA["hits"]["hits"];
        $all_data_products = array();
        $totalProducts = 0;
        foreach($result_search_PLSA_hits as $k=>$plsa){
            $filter1["bool"]["must"][]["term"]["product_list_id"] =  $plsa["_source"]["product_list_id"];
            $result_search_products = $this->getProductsByName($filter1, $data, $from, $size);
            $totalProducts += $result_search_products["totalProducts"];
            unset($result_search_products["totalProducts"]);
            foreach($result_search_products as $key=>$data_products){
                foreach($data_products as $key2=>$_products){
                    if($key2 !== "totalProducts" ){
                        $all_data_products[$key][$key2] = $_products;
                        $all_data_products[$key][$key2]["_source"]["sa_state"] = $plsa["_source"]["sa_state"];
                        $all_data_products[$key][$key2]["_source"]["sa_city"] = $plsa["_source"]["sa_city"];
                    }else{
                        $all_data_products[$key][$key2] = $_products;
                    }
                }
            }
        }
        $all_data_products["totalProducts"] = $totalProducts;
        return $all_data_products;
    }

    public function getProductsByName($filter = array(), $data, $from = 0, $size = 1){

        $config = $this->getDI()->get('config');
        $client_products= new Elasticsearch\Client();
        $searchProductParams['index'] = $config['elasticSearch']['products']['index'];
        $searchProductParams['type']  = $config['elasticSearch']['products']['type'];

        $search = $this->getSearchNameAndFilter($data);
        $search_name = $search["name"];
        $filter_field = $search["filter_field"];

        $query_product = array();

        if($search_name != ''){
            $query_product["bool"]["must"][]["multi_match"] = array(
                "query" => $search_name,
                "operator" => "and",
                "fields" => array("product_name", "product_name_exact")
            );
        }
        $searchProductParams["body"]["query"]["filtered"] = array(
            "query"=>$query_product,
            "filter"=>$filter
        );


        $searchProductParams["body"]["facets"]["user_id"]["terms"] = array(
            "field"=>"user_id",
            "size" => 10
        );

        $result_search_products = $client_products->search($searchProductParams);
        $totalProducts = $result_search_products["hits"]["total"];
        $all_data_products = array();
        foreach($result_search_products["facets"]["user_id"]["terms"] as $fk=>$facet_user){
            $user_id = $facet_user["term"];
            try{
                $company = $this->findCompanyProfile($user_id);
                if(!empty($company)){
                    $products = $this->getProductsFromCompany($filter, $search_name, $company, $from, $size);
                    $all_data_products[$user_id] = $products[$user_id];
                }
            }catch (\Exception $err){

            }
        }
        $all_data_products["totalProducts"] = $totalProducts;
        return $all_data_products;
    }


    public function getProductsByNameAdvancedSearch($filter = array(), $data, $from = 0, $size = 1){

        $config = $this->getDI()->get('config');
        $client_products= new Elasticsearch\Client();
        $searchProductParams['index'] = $config['elasticSearch']['products']['index'];
        $searchProductParams['type']  = $config['elasticSearch']['products']['type'];

        $query_product = array();
        if(isset($data["product_or_service"]) && !empty($data["product_or_service"])){
            $query_product["bool"]["must"][]["multi_match"] = array(
                "query" => $data["product_or_service"],
                "operator" => "and",
                "fields" => array("product_name", "product_name_exact")
            );
        }

        $searchProductParams["body"]["query"]["filtered"] = array(
            "query"=>$query_product,
            "filter"=>$filter
        );
        $searchProductParams["body"]["facets"]["user_id"]["terms"] = array(
            "field"=>"user_id",
            "size" => 10
        );
        $result_search_products = $client_products->search($searchProductParams);
        $totalProducts = $result_search_products["hits"]["total"];

        $all_data_products = array();
        foreach($result_search_products["facets"]["user_id"]["terms"] as $fk=>$facet_user){
            $user_id = $facet_user["term"];
            try{
                $company = $this->findCompanyProfile($user_id);
                if(!empty($company)){
                    if(isset($data["product_or_service"])){
                        $products = $this->getProductsFromCompany($filter, $data["product_or_service"], $company, $from, $size);
                    }else{
                        $products = $this->getProductsFromCompany($filter, '', $company, $from, $size);
                    }
                    $all_data_products[$user_id] = $products[$user_id];
                }
            }catch (\Exception $err){

            }
        }
        $all_data_products["totalProducts"] = $totalProducts;
        return $all_data_products;
    }

    public function getProductsFromCompany($filter, $product_name, array $company, $from = 0, $size = 1){

        $config = $this->getDI()->get('config');
        $client_products= new Elasticsearch\Client();
        $searchProductParams['index'] = $config['elasticSearch']['products']['index'];
        $searchProductParams['type']  = $config['elasticSearch']['products']['type'];

        $query_product = array();
        if(isset($company["_source"]) && !empty($company["_source"])){
            $filter["bool"]["must"][]["term"]["user_id"] = $company["_source"]["user_id"];
        }

        if(!empty($product_name)){
            $query_product["bool"]["must"][]["multi_match"] = array(
                "query" => $product_name,
                "operator" => "and",
                "fields" => array("product_name", "product_name_exact")
            );
        }

        $searchProductParams["body"]["from"] = $from;
        $searchProductParams["body"]["size"] = $size;
        $searchProductParams["body"]["query"]["filtered"] = array(
            "query"=>$query_product,
            "filter"=>$filter
        );
        $searchProductParams["body"]["facets"]["user_id"]["terms"] = array(
            "field"=>"user_id",
            "size" => 10
        );
        $result_search_products = $client_products->search($searchProductParams);
        $totalProducts = $result_search_products["hits"]["total"];
        //find products
        $result_search_products_hits = $result_search_products["hits"]["hits"];
//        $all_data_products[$company["_source"]["user_id"]]["totalProducts"] = $result_search_products["facets"]["user_id"]["terms"][0]["count"];
        if(isset($company["_source"]) && !empty($company["_source"])) {
            $all_data_products[$company["_source"]["user_id"]]["totalProducts"] = $totalProducts;
            foreach ($result_search_products_hits as $key => $data_products) {
                $all_data_products[$company["_source"]["user_id"]][$key] = $data_products;
                $all_data_products[$company["_source"]["user_id"]][$key]["_source"]["c_title"] = $company["_source"]["title"];
                $all_data_products[$company["_source"]["user_id"]][$key]["_source"]["sa_state"] = '';
                $all_data_products[$company["_source"]["user_id"]][$key]["_source"]["sa_city"] = '';
            }
        }
        $all_data_products["totalProducts"] = $totalProducts;
        return $all_data_products;
    }

    public function getProductsForAjax($company_id, $data, $from = 0, $size = 1){
        $products = array();
        $filter = array();

        if(isset($data['simple_search']) && $data['simple_search'] == "yes"){
            $filter["bool"]["must"][]["term"]["user_id"] = $company_id;
            if( (isset($data["location"]) && !empty($data["location"]))
                || (isset($data["lf_state"]) && !empty($data["lf_state"]))
                || (isset($data["lf_city"]) && !empty($data["lf_city"]))
            ){
                $products = $this->getProductsByNameAndLocation($filter, $data, $from, $size);
            }else{
                $products = $this->getProductsByName($filter, $data, $from, $size);
            }
        }

        if(isset($data['advanced_search']) && $data['advanced_search'] == "yes"){
            $filter["bool"]["must"][]["term"]["user_id"] = $company_id;
            if( (isset($data["country"]) && !empty($data["country"]))
                || (isset($data["state"]) && !empty($data["state"]))
                || (isset($data["city"]) && !empty($data["city"]))
                || (isset($data["lf_state"]) && !empty($data["lf_state"]))
                || (isset($data["lf_city"]) && !empty($data["lf_city"]))
            ){
                $products = $this->_preparePLSA_AdvanceSearch($filter, $data, $from, $size);
            }else{
                $products = $this->getProductsByNameAdvancedSearch($filter,$data, $from, $size);
            }
        }

        if(!isset($data['advanced_search']) && !isset($data['simple_search'])){
            $filter["bool"]["must"][]["term"]["user_id"] = $company_id;
            $products = $this->getProductsByNameAdvancedSearch($filter,$data, $from, $size);
        }

        return $products;

    }

    public function getCompaniesByNameAndLocation($data){

        $config = $this->getDI()->get('config');
        //search company
        $clientCompany= new Elasticsearch\Client();
        $searchCompanyParams['index'] = $config['elasticSearch']['companyProfile']['index'];
        $searchCompanyParams['type']  = $config['elasticSearch']['companyProfile']['type'];
        $queryCompany = array();
        $search = $this->getSearchNameAndFilter($data);
        $search_name = $search["name"];
        $filter_field = $search["filter_field"];
        $filter = array();
        if(!empty($filter_field) && $filter_field != "pl_name"){
            if(!empty($data["location"])){
                $queryCompany["bool"]["must"][]["match"][$filter_field] = $search_name;
                $queryCompany["bool"]["must"][]["multi_match"] = array(
                    "query" => $data["location"],
                    "operator" => "and",
                    "fields" => array("country", "state", "city", "postcode")
                );

            }else{
                $queryCompany["bool"]["must"]["match"][$filter_field] = $search_name ;
            }
        }else{
            if($search_name != ''){
                $queryCompany["bool"]["must"][]["multi_match"] = array(
                    "query"=>$search_name,
                    "operator" => "and",
                    "fields" => array("title", "tagline", "keywords")
                );
                if(!empty($data["location"])){
                    $queryCompany["bool"]["must"][]["multi_match"] = array(
                        "query" => $data["location"],
                        "operator" => "and",
                        "fields" => array("country", "state", "city", "postcode")
                    );
                }
            }else{

                if(!empty($data["location"])){
                    $queryCompany["bool"]["must"][]["multi_match"] = array(
                        "query" => $data["location"],
                        "operator" => "and",
                        "fields" => array("country", "state", "city", "postcode")
                    );
                }

                if(!empty($data["name_pcck"])){
                    $queryCompany["bool"]["must"][]["multi_match"] = array(
                        "query"=>$data["name_pcck"],
                        "operator" => "and",
                        "fields" => array("title", "tagline", "keywords")
                    );
                }
            }
        }

        $filter = $this->getLeftSideFilterForCompanies($data);

        $searchCompanyParams["body"]["query"]["filtered"] = array(
            "query"=>$queryCompany,
            "filter" => $filter
        );
        $arr_facets = array(
            "tagline_exact","state_exact","city_exact","keywords_exact",
            "business_type_exact","premium","currently_export","currently_import"
        );
        foreach($arr_facets as $facets){
            $searchCompanyParams["body"]["facets"][$facets]["terms"] = array(
                "field"=>$facets,
                "size" => 10
            );
        }

        $result_search_company = $clientCompany->search($searchCompanyParams);
        $totalCompanies = $result_search_company["hits"]["total"];
        //find companies
        $result_search_company["hits"] = $result_search_company["hits"]["hits"];

        $result_search_company["facets"] = $result_search_company["facets"];
        $result_search_company["totalCompanies"] = $totalCompanies;
        return $result_search_company;
    }

    public function getSearchNameAndFilter($data){

        $filter_field = '';
        $name_pcck = array();
        if(isset($data['name_pcck'])){
            if (strpos($data['name_pcck'],"in All") !== false) {
                $name_pcck = explode("in All", $data['name_pcck']);
            }elseif (strpos($data['name_pcck'],"in Companies") !== false) {
                $name_pcck = explode("in Companies", $data['name_pcck']);
                $filter["bool"]["must"]["term"] = array("title"=>trim($name_pcck[0]));
                $filter_field = "title";
            }elseif (strpos($data['name_pcck'],"in Categories") !== false) {
                $name_pcck = explode("in Categories", $data['name_pcck']);
                $filter_field = "tagline";
            }elseif (strpos($data['name_pcck'],"in Keywords") !== false) {
                $name_pcck = explode("in Keywords", $data['name_pcck']);
                $filter_field = "keywords";
            }elseif (strpos($data['name_pcck'],"in Product Lists") !== false) {
                $name_pcck = explode("in Product Lists", $data['name_pcck']);
                $filter_field = "pl_name";
            }

            if(!empty($name_pcck)){
                $search["name"] = trim($name_pcck[0]);
            }else{
                $search["name"] = trim($data['name_pcck']);
            }
        }else{
            $search["name"] = '';
        }

        $search["filter_field"] = $filter_field;

        return $search;
    }

    public function getLeftSideFilterForCompanies($data){

        $filter = array();

        if(isset($data['lf_category']) && !empty($data['lf_category'])){
            $lf_category = explode(",", $data['lf_category']);
            if(count($lf_category) > 1){
                foreach($lf_category as $cat_val){
                    $filter["bool"]["must"][]["term"]["tagline_exact"] = $cat_val;
                }
            }else{
                $filter["bool"]["must"][]["term"]["tagline_exact"] = $data['lf_category'];
            }

        }
        if(isset($data['lf_state']) && !empty($data['lf_state'])){
            $lf_state = explode(",", $data['lf_state']);
            if(count($lf_state) > 1){
                foreach($lf_state as $state_val){
                    $filter["bool"]["must"][]["term"]["state_exact"] = $state_val;
                }
            }else{
                $filter["bool"]["must"][]["term"]["state_exact"] = $data['lf_state'];
            }
        }

        if(isset($data['lf_city']) && !empty($data['lf_city'])){
            $lf_city = explode(",", $data['lf_city']);
            if(count($lf_city) > 1){
                foreach($lf_city as $city_val){
                    $filter["bool"]["must"][]["term"]["city_exact"] = $city_val;
                }
            }else{
                $filter["bool"]["must"][]["term"]["city_exact"] = $data['lf_city'];
            }
        }

        if(isset($data['lf_keywords']) && !empty($data['lf_keywords'])){
            $lf_keywords = explode(",", $data['lf_keywords']);
            if(count($lf_keywords) > 1){
                foreach($lf_keywords as $keyword_val){
                    $filter["bool"]["must"][]["term"]["keywords_exact"] = $keyword_val;
                }
            }else{
                $filter["bool"]["must"][]["term"]["keywords_exact"] = $data['lf_keywords'];
            }
        }

        if(isset($data['lf_business_type']) && !empty($data['lf_business_type'])){
            $lf_business_type= explode(",", $data['lf_business_type']);
            if(count($lf_business_type) > 1){
                foreach($lf_business_type as $business_type_val){
                    $filter["bool"]["must"][]["term"]["business_type_exact"] = $business_type_val;
                }
            }else{
                $filter["bool"]["must"][]["term"]["business_type_exact"] = $data['lf_business_type'];
            }
        }

        if(isset($data['premium']) && $data['premium'] == "yes"){
            $filter["bool"]["must"][]["term"]["premium"] = $data['premium'];
        }
        if(isset($data['importers']) && $data['importers'] == "yes"){
            $filter["bool"]["must"][]["term"]["currently_import"] = $data['importers'];
        }
        if(isset($data['exporters']) && $data['exporters'] == "yes"){
            $filter["bool"]["must"][]["term"]["currently_export"] = $data['exporters'];
        }

        return $filter;
    }
    public function getLeftSideFilterForProducts($data){

        $filter = array();

        if(isset($data['lf_state']) && !empty($data['lf_state'])){
            $lf_state = explode(",", $data['lf_state']);
            if(count($lf_state) > 1){
                foreach($lf_state as $state_val){
                    $filter["bool"]["must"][]["term"]["sa_state_exact"] = $state_val;
                }
            }else{
                $filter["bool"]["must"][]["term"]["sa_state_exact"] = $data['lf_state'];
            }
        }

        if(isset($data['lf_city']) && !empty($data['lf_city'])){
            $lf_city = explode(",", $data['lf_city']);
            if(count($lf_city) > 1){
                foreach($lf_city as $city_val){
                    $filter["bool"]["must"][]["term"]["sa_city_exact"] = $city_val;
                }
            }else{
                $filter["bool"]["must"][]["term"]["sa_city_exact"] = $data['lf_city'];
            }
        }

        return $filter;
    }

    public function getProductsAndCompaniesByName($name_pcck, $from=0, $size = 1){

        $config = $this->getDI()->get('config');
        $client_products= new Elasticsearch\Client();
        $searchProductsParams['index'] = $config['elasticSearch']['products']['index'];
        $searchProductsParams['type']  = $config['elasticSearch']['products']['type'];
        $query_products["match"]["product_name"] = array(
            "query"=>$name_pcck,
            "operator" => "and"
        );
        $searchProductsParams["body"]["from"] = $from;
        $searchProductsParams["body"]["size"] = $size;
        $searchProductsParams["body"]["query"]["filtered"] = array(
            "query"=>$query_products
        );
        $result_search_products = $client_products->search($searchProductsParams);

        //find plsa
        $result_search_products = $result_search_products["hits"]["hits"];
        $result_search['plsa'] = $result_search_products;

        //search company
        $clientCompany= new Elasticsearch\Client();
        $searchCompanyParams['index'] = $config['elasticSearch']['companyProfile']['index'];
        $searchCompanyParams['type']  = $config['elasticSearch']['companyProfile']['type'];

        $query_company["match"]["_all"] = array(
            "query"=>$name_pcck,
            "operator" => "and"
        );
        $searchCompanyParams["body"]["query"]["filtered"] = array(
            "query"=>$query_company
        );
        $result_search_company = $clientCompany->search($searchCompanyParams);
        //find companies
        $result_search_company = $result_search_company["hits"]["hits"];
        $result_search['companies'] = $result_search_company;

        return $result_search;
    }

    public function getLocationData($location, $from = 0, $size = 1){
        $config = $this->getDI()->get('config');
        $result_search = array();
        //search company
        $clientCompany= new Elasticsearch\Client();
        $searchCompanyParams['index'] = $config['elasticSearch']['companyProfile']['index'];
        $searchCompanyParams['type']  = $config['elasticSearch']['companyProfile']['type'];

        $searchCompanyParams['from'] = $from;
        $searchCompanyParams['size'] = $size;
        $searchCompanyParams["body"]["query"]["match"]["_all"] = array(
            "query"=>$location,
            "operator" => "and"
        );


        $result_search_company = $clientCompany->search($searchCompanyParams);
        //find companies
        $result_search_company = $result_search_company["hits"]["hits"];
        $result_search['companies'] = $result_search_company;




        $clientPLSA= new Elasticsearch\Client();
        $searchPLSAParams['index'] = $config['elasticSearch']['productList_serviceArea']['index'];
        $searchPLSAParams['type']  = $config['elasticSearch']['productList_serviceArea']['type'];

        $query = array();

        if(!empty($location)){
            $query["multi_match"]= array(
                "query" => $location,
                "fields" => array("sa_country", "sa_state", "sa_city", "sa_postcode")
            );
        }
        $searchPLSAParams["body"]["query"]["filtered"] = array(
            "query"=>$query
        );

        $result_search_PLSA = $clientPLSA->search($searchPLSAParams);
        $result_search['plsa'] = $result_search_PLSA["hits"]["hits"];

        return $result_search;
    }

    public function findCompaniesByArea($geoData = null){

        $config = $this->getDI()->get('config');
        $result_search = array();

        if(!empty($geoData)){
            //search company
            $client_Companies = new Elasticsearch\Client();
            $searchCompanyProfileParams['index'] = $config['elasticSearch']['companyProfile']['index'];
            $searchCompanyProfileParams['type']  = $config['elasticSearch']['companyProfile']['type'];

            $searchCompanyProfileParams['body']['sort']['modified_at'] = 'desc';
            $searchCompanyProfileParams['body']['query']['bool']['must'][]["match"]['active'] = 'Y';

            if(!empty($geoData["country_name"])){
                $searchCompanyProfileParams['body']['query']['bool']['must'][]["match"] = array('country' => $geoData["country_name"]);
            }
            if(!empty($geoData["region_name"])){
                $searchCompanyProfileParams['body']['query']['bool']['must'][]["match"] = array('state' => $geoData["region_name"]);
            }

            $result_search_companies_profile = $client_Companies->search($searchCompanyProfileParams);
            $companiesProfile = $result_search_companies_profile["hits"]["hits"];

            return $companiesProfile;

        } else {

            return $result_search;
        }
    }

}