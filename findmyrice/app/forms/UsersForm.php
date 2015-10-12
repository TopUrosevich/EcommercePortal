<?php
namespace Findmyrice\Forms;

use Phalcon\Forms\Form;
use Phalcon\Forms\Element\Text;
use Phalcon\Forms\Element\Hidden;
use Phalcon\Forms\Element\Select;
use Phalcon\Forms\Element\Password;
use Phalcon\Forms\Element\Check;
use Phalcon\Validation\Validator\PresenceOf;
use Phalcon\Validation\Validator\Email;
use Phalcon\Validation\Validator\Regex;
use Phalcon\Validation\Validator\StringLength;
use Phalcon\Validation\Validator\Confirmation;
use Findmyrice\Models\Profiles;
use Findmyrice\Models\Countries;


class UsersForm extends Form
{

    public function initialize($entity = null, $options = null)
    {
        // In edition the id is hidden
        if (isset($options['edit']) && $options['edit']) {
            $id = new Hidden('id');
        } else {
            $id = new Text('id');
        }

        $this->add($id);


        ///-----------
        // First Name
        $first_name = new Text('first_name', array('class'=>'form-control'));

        $first_name->setLabel('First Name');

        $first_name->addValidators(array(
            new PresenceOf(array(
                'message' => 'The First Name is required'
            ))
        ));

        $this->add($first_name);


        // Last Name
        $last_name = new Text('last_name', array('class'=>'form-control'));

        $last_name->setLabel('Last Name');

        $last_name->addValidators(array(
            new PresenceOf(array(
                'message' => 'The Last Name is required'
            ))
        ));

        $this->add($last_name);


        // Username
        $name = new Text('name', array('class'=>'form-control'));

        $name->setLabel('Username');

        $name->addValidators(array(
            new PresenceOf(array(
                'message' => 'The Username is required'
            ))
        ));

        $this->add($name);


        // Email
        $email = new Text('email', array('class'=>'form-control'));

        $email->setLabel('E-Mail');

        $email->addValidators(array(
            new PresenceOf(array(
                'message' => 'The e-mail is required'
            )),
            new Email(array(
                'message' => 'The e-mail is not valid'
            ))
        ));

        $this->add($email);

        // Password
        $password = new Password('password', array(
            'placeholder'=>'New Password',
            'class'=>'form-control'
        ));

        $password->setLabel('Password');

        $password->addValidators(array(
            new PresenceOf(array(
                'message' => 'The password is required'
            )),
            new StringLength(array(
                'min' => 8,
                'messageMinimum' => 'Password is too short. Minimum 8 characters'
            )),
            new Confirmation(array(
                'message' => 'Password doesn\'t match confirmation',
                'with' => 'confirmPassword'
            ))
        ));

        $this->add($password);

        // Confirm Password
        $confirmPassword = new Password('confirmPassword', array(
            'placeholder'=>'Confirm Password',
            'class'=>'form-control'
        ));

        $confirmPassword->setLabel('Confirm Password');

        $confirmPassword->addValidators(array(
            new PresenceOf(array(
                'message' => 'The confirmation password is required'
            ))
        ));

        $this->add($confirmPassword);




        //Business Name
        $business_name = new Text('business_name', array('class'=>'form-control'));

        $business_name->setLabel('Business Name');

        $business_name->addValidators(array(
            new PresenceOf(array(
                'message' => 'The business name is required'
            ))
        ));

        $this->add($business_name);

        //Street Address
        $street_address = new Text('street_address', array('class'=>'form-control'));

        $street_address->setLabel('Street Address');

        $street_address->addValidators(array(
            new PresenceOf(array(
                'message' => 'The street address is required'
            ))
        ));

        $this->add($street_address);



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
        $this->add($country);

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
        $this->add($country_code);

        //Area Code
        $area_code = new Text('area_code', array('class'=>'form-control'));

        $area_code->setLabel('Area Code');

        $area_code->addValidators(array(
            new PresenceOf(array(
                'message' => 'The area code is required'
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


        //Business Type
        $business_type = new Select('business_type', array(
            '' => 'Select ...',
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
        ), array('class'=>'form-control'));
        $business_type->setLabel('Business Type');
        $business_type->addValidators(array(
            new PresenceOf(array(
                'message' => 'The Business Type is required'
            ))
        ));
        $this->add($business_type);

        //Other Business Type
        $other_business_type = new Text('other_business_type', array('class'=>'form-control'));

        $other_business_type->setLabel('Other Business Type');

//        $other_business_type->addValidators(array(
//            new PresenceOf(array(
//                'message' => 'The other business type is required'
//            ))
//        ));

        $this->add($other_business_type);


        //Currently Import
        $currently_import = new Check('currently_import', array(
            'value' => 'yes'
        ));
        $currently_import->setLabel('I currently import products from overseas.');
        $this->add($currently_import);

        //Currently Export
        $currently_export = new Check('currently_export', array(
            'value' => 'yes'
        ));
        $currently_export->setLabel('I currently export products overseas.');
        $this->add($currently_export);

        // Logo
        $logo = new Text('logo');
        $logo->setLabel('Logo');
        $this->add($logo);

        //Bembership Type
        $membership_type = new Text('membership_type', array('class'=>'form-control'));
        $membership_type->setLabel('Membership Type');
        $this->add($membership_type);


        ///-----------

        $profiles = Profiles::find(array(array(
            "active" => "Y"
        ),
            'fields' => array(
                '_id',
                'name'
        )
        ));
        $this->add(new Select('profilesId', $this->external->returnArrayForSelect($profiles), array(
            'using' => array(
                '_id',
                'name'
            ),
            'useEmpty' => true,
            'emptyText' => '...',
            'emptyValue' => '',
            'class'=>'form-control'
        )));

        $this->add(new Select('banned', array(
            'Y' => 'Yes',
            'N' => 'No'
        )));

        $this->add(new Select('suspended', array(
            'Y' => 'Yes',
            'N' => 'No'
        )));

        $this->add(new Select('active', array(
            'Y' => 'Yes',
            'N' => 'No'
        )));
    }

    /**
     * Prints messages for a specific element
     */
//    public function messages($name)
//    {
//        if ($this->hasMessagesFor($name)) {
//            foreach ($this->getMessagesFor($name) as $message) {
//                $this->flash->error($message);
//            }
//        }
//    }
}
