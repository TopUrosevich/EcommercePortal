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

class PLAreaDetailsForm extends Form
{

    public function initialize($entity = null, $options = null)
    {
        // In edition the id is hidden
        $id = new Hidden('id');
        $this->add($id);

        $this->initializeElements();
        // Sign Up
        $this->add(new Submit('Save', array(
            'class' => 'red_btn save_btn'
        )));
    }

    protected function initializeElements(){
        $identity = $this->session->get('auth-identity');
        $user_id = $identity['id'];

        //Type Address
        $type_address = new Text('ad_type_address', array(
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
        $country = new Text('ad_country', array('class'=>'form-control'));
        $country->setLabel('Country');
        $country->addValidators(array(
            new PresenceOf(array(
                'message' => 'The Country is required'
            ))
        ));
        $this->add($country);

        //State
        $state = new Text('ad_state', array('class'=>'form-control'));
        $state->setLabel('State');
        $state->addValidators(array(
            new PresenceOf(array(
                'message' => 'The State is required'
            ))
        ));
        $this->add($state);

        //Suburb/Town/City
        $suburb_town_city = new Text('ad_suburb_town_city', array('class'=>'form-control'));
        $suburb_town_city->setLabel('Suburb/Town/City');
        $suburb_town_city->addValidators(array(
            new PresenceOf(array(
                'message' => 'The Suburb/Town/City is required'
            ))
        ));
        $this->add($suburb_town_city);
    }

    public function setDefault($fieldName,$value){
        \Phalcon\Tag::setDefault($fieldName, $value);
    }

    public function setDefaultsFromSession($session){
        if(isset($session) && !empty($session)){
            \Phalcon\Tag::setDefaults(array(

            ));
        }
    }

    public function setDefaultsFromEdit($ServiceArea){
        if(isset($ServiceArea) && !empty($ServiceArea)){
            \Phalcon\Tag::setDefaults(array(

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
