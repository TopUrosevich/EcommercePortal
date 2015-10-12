<?php
namespace Findmyrice\Forms;

use Findmyrice\Models\ProductList;
use Phalcon\Forms\Form;
use Phalcon\Forms\Element\Text;
use Phalcon\Forms\Element\File;
use Phalcon\Forms\Element\Submit;
use Phalcon\Forms\Element\Select;
use Phalcon\Forms\Element\Hidden;
use Phalcon\Validation\Validator\PresenceOf;
use Phalcon\Validation\Validator\Regex;
use Phalcon\Validation\Validator\StringLength;
use Findmyrice\Models\Countries;

class ProductListsServiceAreaForm extends Form
{

    public function initialize($entity = null, $options = null)
    {
        // In edition the id is hidden
        $id = new Hidden('id');
        $this->add($id);

        $this->initializeProfileElements();
        // Sign Up
        $this->add(new Submit('Next', array(
            'class' => 'btn btn-success'
        )));
    }

    protected function initializeProfileElements(){
        $identity = $this->session->get('auth-identity');
        $user_id = $identity['id'];

        // Area Name
        $area_name = new Text('area_name', array('class'=>'form-control'));
        $area_name->setLabel('Area Name');
        $area_name->addValidators(array(
            new PresenceOf(array(
                'message' => 'The Area Name is required'
            ))
        ));
        $this->add($area_name);

        //Type Address
        $type_address = new Text('type_address', array(
            'class'=>'form-control',
            'placeholder'=>'Type Address'
        ));
        $type_address->setLabel('Type Address');
//        $type_address->addValidators(array(
//            new PresenceOf(array(
//                'message' => 'The street address is required'
//            ))
//        ));
        $this->add($type_address);

        //Country
        $country = new Text('country', array('class'=>'form-control'));
        $country->setLabel('Country');
        $country->addValidators(array(
            new PresenceOf(array(
                'message' => 'The Country is required'
            ))
        ));
        $this->add($country);

        //Country
        $countries = Countries::find(array(array(

        ),
            'fields' => array(
                '_id',
                'country_name',
                'iso_code',
                'country_code'
            )
        ));
        /*
        $arr_country  = $this->external->returnArrayForSelectCountries($countries);
        $country = new Select('country', $arr_country, array(
            'using' => array(
                '_id',
                'country_name'
            ),
            'useEmpty' => true,
            'emptyText' => 'Select ...',
            'emptyValue' => '',
            'class'=>'form-control for-chosen'
        ));
        $country->setLabel('Country');
        $country->addValidators(array(
            new PresenceOf(array(
                'message' => 'The Country is required'
            ))
        ));
        $this->add($country);
        */

        //State
        $state = new Text('state', array('class'=>'form-control'));
        $state->setLabel('State');
        $state->addValidators(array(
            new PresenceOf(array(
                'message' => 'The State is required'
            ))
        ));
        $this->add($state);

        //Suburb/Town/City
        $suburb_town_city = new Text('suburb_town_city', array('class'=>'form-control'));
        $suburb_town_city->setLabel('Suburb/Town/City');
        $suburb_town_city->addValidators(array(
            new PresenceOf(array(
                'message' => 'The Suburb/Town/City is required'
            ))
        ));
        $this->add($suburb_town_city);

        //Street Address
        $street_address = new Text('street_address', array('class'=>'form-control'));
        $street_address->setLabel('Street Address');
        $street_address->addValidators(array(
            new PresenceOf(array(
                'message' => 'The street address is required'
            ))
        ));
        $this->add($street_address);

        //Postcode/Zip Code
        $postcode = new Text('postcode', array('class'=>'form-control'));
        $postcode->setLabel('Postcode/Zip Code');
        $postcode->addValidators(array(
            new PresenceOf(array(
                'message' => 'The Postcode/Zip Code is required'
            ))
        ));
        $this->add($postcode);


        //Country Code
        $arr_country_code  = $this->external->returnArrayForSelectCountryCodes($countries);
        $country_code = new Select('country_code', $arr_country_code,
            array(
                'using' => array(
                    '_id',
                    'country_code'
                ),
                'useEmpty' => true,
                'emptyText' => 'Select ...',
                'emptyValue' => '',
                'class'=>'form-control for-chosen'
        ));
        $country_code->setLabel('Country Code');
        $country_code->addValidators(array(
            new PresenceOf(array(
                'message' => 'The Country Code is required'
            ))
        ));
        $this->add($country_code);

        //Area Code
        $area_code = new Text('area_code', array('class'=>'form-control'));
        $area_code->setLabel('Area Code');
        $area_code->addValidators(array(
            new PresenceOf(array(
                'message' => 'The area code is required'
            )),
            new Regex(array(
                'message' => 'The area code should be number',
                'pattern' => '/[0-9]+/'
            ))
        ));
        $this->add($area_code);

        //Phone
        $phone = new Text('phone', array('class'=>'form-control'));
        $phone->setLabel('Phone');
        $phone->addValidators(array(
            new PresenceOf(array(
                'message' => 'The Phone is required'
            )),
            new Regex(array(
                'message' => 'The Phone should be number',
                'pattern' => '/[0-9 ]+/'
            )),
            new StringLength(array(
                'messageMinimum' => 'The Phone is too short',
                'min' => 2
            ))
        ));
        $this->add($phone);

        // Product List
//        $product_list = new Select('product_list', array(
//            '' => 'Select ...',
//            'Sydney Product List' => 'Sydney Product List',
//            'Melbourne Product List' => 'Melbourne Product List',
//            'Perth Product List' => 'Perth Product List'
//        ),
//            array('class'=>'form-control')
//        );

        $products = ProductList::findByUserId($user_id);
        $productsArr = array();
        if($products){
            foreach($products as $key1 =>$product_s){
                foreach($product_s as $key=>$val){
                    if($key == '_id'){
                        $productsArr[$key1][$key] = (string)$val;
                    }
                    if($key == 'pl_name'){
                        $productsArr[$key1][$key] = $val;
                    }
                }
            }
        }
        $arr_product = array();
        for($i=0; $i < count($productsArr); $i++){
            $arr_product[$productsArr[$i]['_id']] = $productsArr[$i]['pl_name'];
        }

        $product_list = new Select('product_list', $arr_product,
            array(
                'using' => array(
                    '_id',
                    'pl_name'
                ),
                'useEmpty' => true,
                'emptyText' => 'Select ...',
                'emptyValue' => '',
                'class'=>'form-control for-chosen'
            )
        );

        $product_list->setLabel('Product List');
        $product_list->addValidators(array(
            new PresenceOf(array(
                'message' => 'The Product List is required'
            ))
        ));
        $this->add($product_list);

//        // Status
//        $status = new Select('status', array(
//            '' => 'Select ...',
//            'Complete' => 'Complete',
//            'Incomplete' => 'Incomplete'
//        ),
//            array('class'=>'form-control for-chosen')
//        );
//        $status->setLabel('Status');
//        $status->addValidators(array(
//            new PresenceOf(array(
//                'message' => 'The Status is required'
//            ))
//        ));
//        $this->add($status);

//        // Product File
//        $product_file = new File('productToUpload');
//        $product_file->setLabel('Product');
////        $product_file->addValidators(array(
////            new PresenceOf(array(
////                'message' => 'The Product is required'
////            ))
////        ));
//        $this->add($product_file);
    }

    public function setDefault($fieldName,$value){
        \Phalcon\Tag::setDefault($fieldName, $value);
    }

    public function setDefaultsFromSession($session){
        if(isset($session) && !empty($session)){
            \Phalcon\Tag::setDefaults(array(
                'area_name'     => $session['service_area']['area_name'],
                'country'  => $session['service_area']['country'],
                'suburb_town_city'     => $session['service_area']['suburb_town_city'],
                'country_code'    => $session['service_area']['country_code'],
                'area_code'  => $session['service_area']['area_code'],
                'phone'  => $session['service_area']['phone'],
                'street_address'    => $session['service_area']['street_address'],
                'state'        => $session['service_area']['state'],
                'postcode'       => $session['service_area']['postcode'],
//                'status'       => $session['service_area']['status'],
                'product_list'       => $session['service_area']['product_list_id']
            ));
        }
    }

    public function setDefaultsFromEdit($ServiceArea){
        if(isset($ServiceArea) && !empty($ServiceArea)){
            \Phalcon\Tag::setDefaults(array(
                'area_name'     => $ServiceArea->sa_area_name,
                'country'  => $ServiceArea->sa_country,
                'suburb_town_city'     => $ServiceArea->sa_city,
                'country_code'    => $ServiceArea->sa_country_code,
                'area_code'  => $ServiceArea->sa_area_code,
                'phone'  => $ServiceArea->sa_phone,
                'street_address'    => $ServiceArea->sa_street_address,
                'state'        => $ServiceArea->sa_state,
                'postcode'       => $ServiceArea->sa_postcode,
//                'status'       => $ServiceArea->sa_status,
                'product_list'       => $ServiceArea->product_list_id
            ));
        }
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
