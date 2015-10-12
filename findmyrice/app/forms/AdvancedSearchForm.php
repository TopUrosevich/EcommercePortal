<?php
namespace Findmyrice\Forms;

use Phalcon\Forms\Form;
use Phalcon\Forms\Element\Text;
use Phalcon\Forms\Element\Check;
use Phalcon\Forms\Element\Submit;
use Phalcon\Forms\Element\Select;
use Phalcon\Forms\Element\Hidden;
use Phalcon\Validation\Validator\PresenceOf;
use Findmyrice\Models\Countries;
use Findmyrice\Models\ElasticSearchModel;
use Elasticsearch;

class AdvancedSearchForm extends Form
{

    public function initialize($entity = null, $options = null)
    {
        //advanced search
        $advanced_search = new Hidden('advanced_search', array('value'=>"yes"));
        $this->add($advanced_search);

        // Company Name
        $company_name = new Text('company_name', array(
            'class'=>'form-control',
            'placeholder'=>'Company Name'
        ));
        $company_name->setLabel('Company Name');
        if (isset($options['company_name'])) {
            $company_name->setDefault(ucwords($options['company_name']));
        }
        $this->add($company_name);


        // Product or Service only
        $product_or_service = new Text('product_or_service', array(
            'class'=>'form-control',
            'placeholder'=>'Product or Service only'
        ));
        $product_or_service->setLabel('Product or Service');
        if (isset($options['product_or_service'])) {
            $product_or_service->setDefault(ucwords($options['product_or_service']));
        }
        $this->add($product_or_service);



        //Company Category
        $ElasticSearchModel = new ElasticSearchModel();
        $categories = $ElasticSearchModel->_prepareGetCategoriesData();
        if(empty($categories["categories"])){
            $select_categories = array();
        }else{
            $select_categories = array_combine($categories["categories"], $categories["categories"]);
        }
        $company_category = new Select('company_category', $select_categories, array(
            'useEmpty' => true,
            'emptyText' => 'Company Category',
            'emptyValue' => '',
            'class'=>'form-control select_btn'
        ));

        if (isset($options['company_category'])) {
            $company_category->setDefault($options['company_category']);
        }
        $this->add($company_category);


        //Business Type
        $business_type = new Select('business_type', array(
            '' => 'Business Type',
            'Distributor only' => 'Distributor only',
            'Manufacturer only' => 'Manufacturer only',
            'Manufacturer & Distributor' => 'Manufacturer & Distributor',
            'Importer' => 'Importer',
            'Technology' => 'Technology',
            'Recruitment' => 'Recruitment',
            'Design/Creative' => 'Design/Creative',
            'Service Provider' => 'Service Provider',
            'Industry Association' => 'Industry Association',
            'Other' => 'Other'
        ), array('class'=>'form-control select_btn'));
        $business_type->setLabel('Business Type');
//        $business_type->addValidators(array(
//            new PresenceOf(array(
//                'message' => 'The Business Type is required'
//            ))
//        ));
        if (isset($options['business_type'])) {
            $business_type->setDefault($options['business_type']);
        }
        $this->add($business_type);

        //Importers
        $import = new Check('importers', array(
            'value' => 'yes'
        ));
        $import->setLabel('Importers');
        if (isset($options['importers'])) {
            $import->setDefault($options['importers']);
        }
        $this->add($import);

        //Exporters
        $export = new Check('exporters', array(
            'value' => 'yes'
        ));
        $export->setLabel('Exporters');
        if (isset($options['exporters'])) {
            $export->setDefault($options['exporters']);
        }
        $this->add($export);


        //Country
        $ElasticSearchModel = new ElasticSearchModel();

        $countries = $ElasticSearchModel->distinctCountries();

        $country = new Select('country', array_combine($countries, $countries), array(
            'useEmpty' => true,
            'emptyText' => 'Country',
            'emptyValue' => '',
            'class'=>'form-control select_btn'
        ));

        if (isset($options['country'])) {
            $country->setDefault(ucwords($options['country']));
        }
        $this->add($country);

        //state
        $state = new Select('state', array(), array(
            'useEmpty' => true,
            'emptyText' => 'State',
            'emptyValue' => '',
            'class'=>'form-control select_btn',
            'disabled' => isset($options['state']) || isset($options['country']) ? null : true
        ));

        if (isset($options['city']) || isset($options['country'])) {
            $states = $ElasticSearchModel->distinctStatesByCountry(ucwords($options['country']));
            $state->setOptions(array_combine($states, $states));

            if (isset($options['state'])){
                $state->setDefault(ucwords($options['state']));
            }
        }
        $this->add($state);

        //city
        $city = new Select('city', array(), array(
            'useEmpty' => true,
            'emptyText' => 'City',
            'emptyValue' => '',
            'class'=>'form-control select_btn',
            'disabled' => isset($options['city']) || isset($options['state']) ? null : true
        ));

        if (isset($options['city']) || isset($options['state'])) {
            $cities = $ElasticSearchModel->distinctCitiesByState(ucwords($options['country']), ucwords($options['state']));
            $city->setOptions(array_combine($cities, $cities));

            if (isset($options['city'])){
                $city->setDefault(ucwords($options['city']));
            }
        }
        $this->add($city);

        // Search
        $this->add(new Submit('Search', array(
            'class' => 'red_btn'
        )));
    }
    /**
     * Prints messages for a specific element
     */
    public function messages($name)
    {
        if ($this->hasMessagesFor($name)) {
            foreach ($this->getMessagesFor($name) as $message) {
                $this->flash->error($message);
            }
        }
    }

}
