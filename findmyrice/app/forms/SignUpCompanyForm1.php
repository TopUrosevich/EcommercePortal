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
use Findmyrice\Models\Countries;

class SignUpCompanyForm1 extends Form
{

    public function initialize()
    {
        $this->initializeProfileElements();

        // Sign Up
        $this->add(new Submit('Next >', array(
            'class' => 'next_btn',
            'id' => 'next_btn_1', 'tabIndex'=>'25'
        )));

        \Phalcon\Tag::setDefault('password', '');
        \Phalcon\Tag::setDefault('confirmPassword', '');
    }



    public function initializeEdit(){

        $this->initializeProfileElements();
        // Sign Up
        $this->add(new Submit('Next >', array(
            'class' => 'next_btn',
            'id' => 'next_btn_1', 'tabIndex'=>'25'
        )));

        \Phalcon\Tag::setDefault('password', '');
        \Phalcon\Tag::setDefault('confirmPassword', '');
    }

    protected function initializeProfileElements(){

        // First Name
        $first_name = new Text('first_name', array('class'=>'form-control', 'tabIndex'=>'1'));

        $first_name->setLabel('First Name');

        $first_name->addValidators(array(
            new PresenceOf(array(
                'message' => 'The First Name is required'
            ))
        ));

        $this->add($first_name);


        // Last Name
        $last_name = new Text('last_name', array('class'=>'form-control', 'tabIndex'=>'2'));

        $last_name->setLabel('Last Name');

        $last_name->addValidators(array(
            new PresenceOf(array(
                'message' => 'The Last Name is required'
            ))
        ));

        $this->add($last_name);


        // Username
        $name = new Text('name', array('class'=>'form-control', 'tabIndex'=>'3'));

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
        $confirmUsername = new Text('confirmUsername', array('class'=>'form-control', 'tabIndex'=>'4'));

        $confirmUsername->setLabel('Confirm Username');

        $confirmUsername->addValidators(array(
            new PresenceOf(array(
                'message' => 'The Confirm Username is required'
            ))
        ));

        $this->add($confirmUsername);

        // Email
        $email = new Text('email', array('class'=>'form-control', 'tabIndex'=>'5'));

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
        $confirmEmail = new Text('confirmEmail', array('class'=>'form-control', 'tabIndex'=>'6'));

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
        $password = new Password('password', array('class'=>'form-control', 'tabIndex'=>'7'));

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
        $confirmPassword = new Password('confirmPassword', array('class'=>'form-control', 'tabIndex'=>'8'));

        $confirmPassword->setLabel('Confirm Password');

        $confirmPassword->addValidators(array(
            new PresenceOf(array(
                'message' => 'The confirmation password is required'
            ))
        ));

        $this->add($confirmPassword);




        //Business Name
        $business_name = new Text('business_name', array('class'=>'form-control', 'tabIndex'=>'9'));

        $business_name->setLabel('Business Name');

        $business_name->addValidators(array(
            new PresenceOf(array(
                'message' => 'The business name is required'
            ))
        ));

        $this->add($business_name);

        //Type Address
        $type_address = new Text('type_address', array(
            'class'=>'form-control',
            'placeholder'=>'Type Address',
            'tabIndex'=>'10'
        ));
        $type_address->setLabel('Type Address');
//        $type_address->addValidators(array(
//            new PresenceOf(array(
//                'message' => 'The street address is required'
//            ))
//        ));
        $this->add($type_address);

        //Street Address
        $street_address = new Text('street_address', array(
            'class'=>'form-control', 'tabIndex'=>'12'
        ));

        $street_address->setLabel('Street Address');

        $street_address->addValidators(array(
            new PresenceOf(array(
                'message' => 'The street address is required'
            ))
        ));

        $this->add($street_address);


        //Country
        $country = new Text('country', array('class'=>'form-control', 'tabIndex'=>'11'));
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
        $state = new Text('state', array('class'=>'form-control', 'tabIndex'=>'14'));

        $state->setLabel('State');

        $state->addValidators(array(
            new PresenceOf(array(
                'message' => 'The State is required'
            ))
        ));

        $this->add($state);

        //Suburb/Town/City
        $suburb_town_city = new Text('suburb_town_city', array('class'=>'form-control', 'tabIndex'=>'13'));

        $suburb_town_city->setLabel('Suburb/Town/City');

        $suburb_town_city->addValidators(array(
            new PresenceOf(array(
                'message' => 'The Suburb/Town/City is required'
            ))
        ));

        $this->add($suburb_town_city);

        //Postcode/Zip Code
        $postcode = new Text('postcode', array('class'=>'form-control', 'tabIndex'=>'16'));

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
                'class'=>'form-control',
                'tabIndex'=>'17'
            ));
        $country_code->setLabel('Country Code');
        $country_code->addValidators(array(
            new PresenceOf(array(
                'message' => 'The Country Code is required'
            ))
        ));
        $this->add($country_code);

        //Area Code
        $area_code = new Text('area_code', array('class'=>'form-control', 'tabIndex'=>'18'));

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
        $phone = new Text('phone', array('class'=>'form-control', 'tabIndex'=>'19'));

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
        ),
            array('class'=>'form-control', 'tabIndex'=>'15')
        );
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
        ),
            array('class'=>'form-control', 'tabIndex'=>'20')
        );
        $primary_product_service->setLabel('Primary Product Service');
        $primary_product_service->addValidators(array(
            new PresenceOf(array(
                'message' => 'The Primary Product Service is required'
            ))
        ));
        $this->add($primary_product_service);

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
            'value' => 'yes', 'tabIndex'=>'21'
        ));
        $currently_import->setLabel('I currently import products from overseas.');
        $this->add($currently_import);

        //Currently Export
        $currently_export = new Check('currently_export', array(
            'value' => 'yes', 'tabIndex'=>'22'
        ));
        $currently_export->setLabel('I currently export products overseas.');
        $this->add($currently_export);

        // Terms
        $terms = new Check('terms', array(
            'value' => 'yes',
            'tabIndex'=>'23'
        ));

        $terms->setLabel('I understand and accept Find My Rice\'s <a href="/terms"><span>Terms & Conditions *</span></a>');

        $terms->addValidator(new Identical(array(
            'value' => 'yes',
            'message' => 'Terms and conditions must be accepted'
        )));

        $this->add($terms);


        //Subscribe to News
        $subscribe_news = new Check('subscribe_news', array(
            'value' => 'yes', 'tabIndex'=>'24'
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
    }

    public function setDefault($fieldName,$value){
        \Phalcon\Tag::setDefault($fieldName, $value);
    }

    public function setDefaults($object){
        if($object instanceof \Findmyrice\Models\Users){
            $this->setDefaultsFromObject($object);
        }
        else if($object instanceof \Phalcon\Http\Request){
            $this->setDefaultsFromRequest($object);
        }
    }

    protected function setDefaultsFromObject(\Findmyrice\Models\Users $user){
        \Phalcon\Tag::setDefaults(array(
            'email'     => $user->email,
            'first_name'     => $user->first_name,
            'last_name'    => $user->last_name,
            'username'  => $user->name,
//            'password'   => $user->password,
            'business_name'    => $user->business_name,
            'street_address'      => $user->street_address,
            'suburb_town_city'    => $user->suburb_town_city,
            'state'        => $user->state,
            'country'       => $user->country,
            'postcode'       => $user->postcode,
            'country_code'       => $user->country_code,
            'area_code'       => $user->area_code,
            'phone'       => $user->phone,
            'business_type'       => $user->business_type,
            'other_business_type'       => $user->other_business_type,
            'currently_export'       => $user->currently_export,
            'currently_import'       => $user->currently_import,
            'logo'       => $user->logo,
            'membership_type'       => $user->membership_type,
            'badges_buttons'       => $user->badges_buttons,
            'mustChangePassword'       => $user->mustChangePassword,
            'profilesId'       => $user->profilesId,
            'banned'       => $user->banned,
            'suspended'       => $user->suspended,
            'active'       => $user->active,
            'primary_product_service'       => $user->primary_product_service
        ));
    }

    protected function setDefaultsFromRequest(\Phalcon\Http\Request $request){
        \Phalcon\Tag::setDefaults(array(
            'email'     => $request->getPost('email'),
            'first_name'     => $request->getPost('first_name'),
            'last_name'    => $request->getPost('last_name'),
            'username'  => $request->getPost('name'),
//            'password'   => $request->getPost('password'),
            'business_name'    => $request->getPost('business_name'),
            'street_address'      => $request->getPost('street_address'),
            'suburb_town_city'    => $request->getPost('suburb_town_city'),
            'state'        => $request->getPost('state'),
            'country'       => $request->getPost('country'),
            'postcode'       => $request->getPost('postcode'),
            'country_code'       => $request->getPost('country_code'),
            'area_code'       => $request->getPost('area_code'),
            'phone'       => $request->getPost('phone'),
            'business_type'       => $request->getPost('business_type'),
            'other_business_type'       => $request->getPost('other_business_type'),
            'currently_export'       => $request->getPost('currently_export'),
            'currently_import'       => $request->getPost('currently_import'),
            'logo'       => $request->getPost('logo'),
            'membership_type'       => $request->getPost('membership_type'),
            'badges_buttons'       => $request->getPost('badges_buttons'),
            'mustChangePassword'       => $request->getPost('mustChangePassword'),
            'profilesId'       => $request->getPost('profilesId'),
            'banned'       => $request->getPost('banned'),
            'suspended'       => $request->getPost('suspended'),
            'active'       => $request->getPost('active'),
            'primary_product_service'       => $request->getPost('primary_product_service')
        ));
    }

    public function setDefaultsFromSession($session){
        if(isset($session) && !empty($session)){
            \Phalcon\Tag::setDefaults(array(
                'email'     => $session['email'],
                'confirmEmail'  => $session['confirmEmail'],
                'first_name'     => $session['first_name'],
                'last_name'    => $session['last_name'],
                'name'  => $session['name'],
                'confirmUsername'  => $session['confirmUsername'],
                'business_name'    => $session['business_name'],
                'street_address'      => $session['street_address'],
                'suburb_town_city'    => $session['suburb_town_city'],
                'state'        => $session['state'],
                'country'       => $session['country'],
                'postcode'       => $session['postcode'],
                'country_code'       => $session['country_code'],
                'area_code'       => $session['area_code'],
                'phone'       => $session['phone'],
                'business_type'       => $session['business_type'],
                'primary_product_service'       => $session['primary_product_service'],
                'currently_export'       => $session['currently_export'],
                'currently_import'       => $session['currently_import'],
                'terms'       => $session['terms'],
                'subscribe_news'       => $session['subscribe_news']

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
