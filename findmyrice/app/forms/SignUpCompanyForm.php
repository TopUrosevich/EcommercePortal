<?php
namespace Findmyrice\Forms;

use Phalcon\Forms\Form;
use Phalcon\Forms\Element\Text;
use Phalcon\Forms\Element\Hidden;
use Phalcon\Forms\Element\Password;
use Phalcon\Forms\Element\Submit;
use Phalcon\Forms\Element\Check;
use Phalcon\Forms\Element\Select;
use Phalcon\Validation\Validator\PresenceOf;
use Phalcon\Validation\Validator\Email;
use Phalcon\Validation\Validator\Identical;
use Phalcon\Validation\Validator\Regex;
use Phalcon\Validation\Validator\StringLength;
use Phalcon\Validation\Validator\Confirmation;

class SignUpCompanyForm extends Form
{

    public function initialize($entity = null, $options = null)
    {

        // First Name
        $first_name = new Text('first_name');

        $first_name->setLabel('First Name');

        $first_name->addValidators(array(
            new PresenceOf(array(
                'message' => 'The First Name is required'
            ))
        ));

        $this->add($first_name);


        // Last Name
        $last_name = new Text('last_name');

        $last_name->setLabel('Last Name');

        $last_name->addValidators(array(
            new PresenceOf(array(
                'message' => 'The Last Name is required'
            ))
        ));

        $this->add($last_name);


        // Username
        $name = new Text('name');

        $name->setLabel('Username');

        $name->addValidators(array(
            new PresenceOf(array(
                'message' => 'The Username is required'
            )),
            new Confirmation(array(
                'message' => 'Username doesn\'t match confirmation',
                'with' => 'confirmUsername'
            ))
        ));

        $this->add($name);

        // Confirm Username
        $confirmUsername = new Text('confirmUsername');

        $confirmUsername->setLabel('Confirm Username');

        $confirmUsername->addValidators(array(
            new PresenceOf(array(
                'message' => 'The Confirm Username is required'
            ))
        ));

        $this->add($confirmUsername);

        // Email
        $email = new Text('email');

        $email->setLabel('E-Mail');

        $email->addValidators(array(
            new PresenceOf(array(
                'message' => 'The e-mail is required'
            )),
            new Email(array(
                'message' => 'The e-mail is not valid'
            )),
            new Confirmation(array(
                'message' => 'Email doesn\'t match confirmation',
                'with' => 'confirmEmail'
            ))
        ));

        $this->add($email);



        // Confirm Email
        $confirmEmail = new Text('confirmEmail');

        $confirmEmail->setLabel('Confirm E-Mail');

        $confirmEmail->addValidators(array(
            new PresenceOf(array(
                'message' => 'The Confirm e-mail is required'
            )),
            new Email(array(
                'message' => 'The Confirm e-mail is not valid'
            ))
        ));

        $this->add($confirmEmail);

        // Password
        $password = new Password('password');

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
        $confirmPassword = new Password('confirmPassword');

        $confirmPassword->setLabel('Confirm Password');

        $confirmPassword->addValidators(array(
            new PresenceOf(array(
                'message' => 'The confirmation password is required'
            ))
        ));

        $this->add($confirmPassword);




        //Business Name
        $business_name = new Text('business_name');

        $business_name->setLabel('Business Name');

        $business_name->addValidators(array(
            new PresenceOf(array(
                'message' => 'The business name is required'
            ))
        ));

        $this->add($business_name);

        //Street Address
        $street_address = new Text('street_address');

        $street_address->setLabel('Street Address');

        $street_address->addValidators(array(
            new PresenceOf(array(
                'message' => 'The street address is required'
            ))
        ));

        $this->add($street_address);



        //Country
        /*
        $countries = Countries::find(array(array(

        ),
            'fields' => array(
                '_id',
                'name'
            )
        ));
        $this->add(new Select('country', $this->external->returnArrayForSelect($countries), array(
            'using' => array(
                '_id',
                'name'
            ),
            'useEmpty' => true,
            'emptyText' => '...',
            'emptyValue' => ''
        )));
        */

        $country = new Select('country', array(
            'AU' => 'Australia',
            'CA' => 'Canada',
            'US' => 'United States'
        ),
            array(
                'using' => array(
                    '_id',
                    'name'
                ),
                'useEmpty' => true,
                'emptyText' => 'Select ...',
                'emptyValue' => ''
            )
        );
        $country->setLabel('Country');
        $country->addValidators(array(
            new PresenceOf(array(
                'message' => 'The Country is required'
            ))
        ));
        $this->add($country);

        //State
        $state = new Text('state');

        $state->setLabel('State');

        $state->addValidators(array(
            new PresenceOf(array(
                'message' => 'The State is required'
            ))
        ));

        $this->add($state);

        //Suburb/Town/City
        $suburb_town_city = new Text('suburb_town_city');

        $suburb_town_city->setLabel('Suburb/Town/City');

        $suburb_town_city->addValidators(array(
            new PresenceOf(array(
                'message' => 'The Suburb/Town/City is required'
            ))
        ));

        $this->add($suburb_town_city);

        //Postcode/Zip Code
        $postcode = new Text('postcode');

        $postcode->setLabel('Postcode/Zip Code');

        $postcode->addValidators(array(
            new PresenceOf(array(
                'message' => 'The Postcode/Zip Code is required'
            ))
        ));

        $this->add($postcode);


        //Country Code
        $country_code = new Select('country_code', array(
            '' => 'Select ...',
            'AU' => 'Australia +61',
            'CA' => 'Canada +1',
            'US' => 'United States +1'
        ));
        $country_code->setLabel('Country Code');
        $country_code->addValidators(array(
            new PresenceOf(array(
                'message' => 'The Country Code is required'
            ))
        ));
        $this->add($country_code);

        //Area Code
        $area_code = new Text('area_code');

        $area_code->setLabel('Area Code');

        $area_code->addValidators(array(
            new PresenceOf(array(
                'message' => 'The area code is required'
            ))
        ));

        $this->add($area_code);

        //Phone
        $phone = new Text('phone');

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
        ));
        $business_type->setLabel('Business Type');
        $business_type->addValidators(array(
            new PresenceOf(array(
                'message' => 'The Business Type is required'
            ))
        ));
        $this->add($business_type);


        //Primary Product Service
        $primary_product_service = new Select('primary_product_service', array(
            '' => 'Select ...',
            '1' => '1',
            '2' => '2',
            '3' => '3'
        ));
        $primary_product_service->setLabel('Primary Product Service');
        $primary_product_service->addValidators(array(
            new PresenceOf(array(
                'message' => 'The Primary Product Service is required'
            ))
        ));
        $this->add($primary_product_service);

        //Other Business Type
        $other_business_type = new Text('other_business_type');

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

        // Terms
        $terms = new Check('terms', array(
            'value' => 'yes'
        ));

        $terms->setLabel('I understand and accept Find My Rice\'s <a href="/terms">Terms & Conditions</a>');

        $terms->addValidator(new Identical(array(
            'value' => 'yes',
            'message' => 'Terms and conditions must be accepted'
        )));

        $this->add($terms);


        //Subscribe to News
        $subscribe_news = new Check('subscribe_news', array(
            'value' => 'yes'
        ));
        $subscribe_news->setLabel('Subscribe to news from Find My Rice.');
        $this->add($subscribe_news);

        // CSRF
        $csrf = new Hidden('csrf');

        $csrf->addValidator(new Identical(array(
            'value' => $this->security->getSessionToken(),
            'message' => 'CSRF validation failed'
        )));

        $this->add($csrf);

        // Sign Up
        $this->add(new Submit('Register', array(
            'class' => 'btn btn-success'
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
