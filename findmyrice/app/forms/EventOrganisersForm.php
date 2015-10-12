<?php
namespace Findmyrice\Forms;


use Phalcon\Forms\Element\Hidden;
use Phalcon\Forms\Element\Submit;
use Phalcon\Forms\Element\Text;
use Phalcon\Forms\Form;
use Phalcon\Validation\Validator\Email;
use Phalcon\Validation\Validator\PresenceOf;

class EventOrganisersForm extends Form
{
    public function initialize($entity = null, $options = null)
    {
        $name = new Text('organiser_name');
        $name->setLabel('Organiser Name');
        $name->addValidators(array(
            new PresenceOf(array(
                'message' => 'The Name is required'
            ))
        ));

        $this->add($name);

        $contactName = new Text('contact_name');
        $contactName->setLabel('Contact Name');
        $contactName->addValidators(array(
            new PresenceOf(array(
                'message' => 'The Name is required'
            ))
        ));

        $this->add($contactName);

        $email = new Text('email');
        $email->setLabel('Email Address');
        $email->addValidators(array(
            new PresenceOf(array(
                'message' => 'The Name is required'
            )),
            new Email(array(
                'message' => 'The e-mail is not valid'
            ))
        ));

        $this->add($email);

        $streetAddress = new Text('street_address');
        $streetAddress->setLabel('Street Address');
        $streetAddress->addValidators(array(
            new PresenceOf(array(
                'message' => 'The Street Address is required'
            ))
        ));

        $this->add($streetAddress);

        $country = new Text('country', array(
            /*'disabled' => (!$options['edit']) ? 'disabled' : null*/
        ));
        $country->addValidators(array(
            new PresenceOf(array(
                'message' => 'The Country is required'
            ))
        ));

        $this->add($country);

        $state = new Text('state', array(
            /*'disabled' => (!$options['edit']) ? 'disabled' : null*/
        ));
        $state->setLabel('State');

        $this->add($state);

        $city = new Text('city', array(
            /*'disabled' => (!$options['edit']) ? 'disabled' : null*/
        ));
        $city->addValidators(array(
            new PresenceOf(array(
                'message' => 'The City is required'
            ))
        ));

        $this->add($city);

        $zipCode = new Text('zip_code');
        $zipCode->setLabel('Postcode/Zip Code');
        $zipCode->addValidators(array(
            new PresenceOf(array(
                'message' => 'The Postcode/Zip Code is required'
            ))
        ));

        $this->add($zipCode);

        $countryCode = new Text('country_code');
        $countryCode->setLabel('Country Code');
        $countryCode->addValidators(array(
            new PresenceOf(array(
                'message' => 'The Country Code is required'
            ))
        ));

        $this->add($countryCode);

        $areaCode = new Text('area_code');
        $areaCode->setLabel('Area Code');
        $areaCode->addValidators(array(
            new PresenceOf(array(
                'message' => 'The Area Code is required'
            ))
        ));

        $this->add($areaCode);

        $phone = new Text('phone');
        $phone->setLabel('Phone');
        $phone->addValidators(array(
            new PresenceOf(array(
                'message' => 'The Phone is required'
            ))
        ));

        $this->add($phone);

        $submit = new Submit('submit', array(
            'value' => $options['edit'] ? 'Save' : 'Create'
        ));

        $this->add($submit);
    }
}