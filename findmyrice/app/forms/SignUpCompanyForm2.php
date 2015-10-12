<?php
namespace Findmyrice\Forms;

use Phalcon\Forms\Form;
use Phalcon\Forms\Element\Text;
use Phalcon\Forms\Element\File;
use Phalcon\Forms\Element\Submit;
use Phalcon\Forms\Element\Select;
use Phalcon\Validation\Validator\PresenceOf;
use Phalcon\Validation\Validator\Regex;
use Phalcon\Validation\Validator\StringLength;
use Findmyrice\Models\Countries;

class SignUpCompanyForm2 extends Form
{

    public function initialize($entity = null, $options = null)
    {
        $this->initializeProfileElements();
        // Sign Up
        $this->add(new Submit('Next', array(
            'class' => 'btn btn-success'
        )));
    }

    public function initializeEdit(){

        $this->initializeProfileElements();
        // Sign Up
        $this->add(new Submit('Add Single Service Area', array(
            'class' => 'btn btn-success'
        )));
    }

    protected function initializeProfileElements(){

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
            'class'=>'form-control'
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
                'class'=>'form-control'
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

//        // Product List
//        $product_list = new Select('product_list', array(
//            '' => 'Select ...',
//            'Sydney Product List' => 'Sydney Product List',
//            'Melbourne Product List' => 'Melbourne Product List',
//            'Perth Product List' => 'Perth Product List'
//        ),
//            array('class'=>'form-control')
//        );
//        $product_list->setLabel('Product List');
//        $product_list->addValidators(array(
//            new PresenceOf(array(
//                'message' => 'The Product List is required'
//            ))
//        ));
//        $this->add($product_list);

//        // Status
//        $status = new Select('status', array(
//            '' => 'Select ...',
//            'Complete' => 'Complete',
//            'Incomplete' => 'Incomplete'
//        ),
//            array('class'=>'form-control')
//        );
//        $status->setLabel('Status');
//        $status->addValidators(array(
//            new PresenceOf(array(
//                'message' => 'The Status is required'
//            ))
//        ));
//        $this->add($status);

        // Product File
        $product_file = new File('productToUpload');
        $product_file->setLabel('Product');
//        $product_file->addValidators(array(
//            new PresenceOf(array(
//                'message' => 'The Product is required'
//            ))
//        ));
        $this->add($product_file);
    }

    public function setDefault($fieldName,$value){
        \Phalcon\Tag::setDefault($fieldName, $value);
    }

    public function setDefaultsFromServiceArea($service_area){
        \Phalcon\Tag::setDefaults(array(
            'area_name'     => $service_area['area_name'],
            'country'  => $service_area['country'],
            'suburb_town_city'     => $service_area['suburb_town_city'],
            'country_code'    => $service_area['country_code'],
            'area_code'  => $service_area['area_code'],
            'phone'  => $service_area['phone'],
            'street_address'    => $service_area['street_address'],
            'state'        => $service_area['state'],
            'postcode'       => $service_area['postcode'],
//            'status'       => $service_area['status'],
//            'productToUpload'       => $request['product_info']['name']
        ));
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
//                'productToUpload'       => $session['product_info']['name']
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
