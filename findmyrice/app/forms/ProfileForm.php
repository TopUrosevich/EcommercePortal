<?php
namespace Findmyrice\Forms;

use Phalcon\Forms\Form;
use Phalcon\Forms\Element\Text;
use Phalcon\Forms\Element\TextArea;
use Phalcon\Forms\Element\Hidden;
use Phalcon\Forms\Element\Submit;
use Phalcon\Forms\Element\Select;
use Phalcon\Validation\Validator\PresenceOf;
use Phalcon\Validation\Validator\Email;
use Phalcon\Validation\Validator\Regex;
use Phalcon\Validation\Validator\StringLength;
use Findmyrice\Models\Countries;

class ProfileForm extends Form
{

    public $timesAM = array(
        "1:00 AM"=>"1:00 AM",
        "1:30 AM"=>"1:30 AM",
        "2:00 AM"=>"2:00 AM",
        "2:30 AM"=>"2:30 AM",
        "3:00 AM"=>"3:00 AM",
        "3:30 AM"=>"3:30 AM",
        "4:00 AM"=>"4:00 AM",
        "4:30 AM"=>"4:30 AM",
        "5:00 AM"=>"5:00 AM",
        "5:30 AM"=>"5:30 AM",
        "6:00 AM"=>"6:00 AM",
        "6:30 AM"=>"6:30 AM",
        "7:00 AM"=>"7:00 AM",
        "7:30 AM"=>"7:30 AM",
        "8:00 AM"=>"8:00 AM",
        "8:30 AM"=>"8:30 AM",
        "9:00 AM"=>"9:00 AM",
        "9:30 AM"=>"9:30 AM",
        "10:00 AM"=>"10:00 AM",
        "10:30 AM"=>"10:30 AM",
        "11:00 AM"=>"11:00 AM",
        "11:30 AM"=>"11:30 AM",
        "12:00 AM"=>"12:00 AM",
        "12:30 AM"=>"12:30 AM",
        "Closed"=>"Closed"
    );

    public $timesPM = array(
        "1:00 PM"=>"1:00 PM",
        "1:30 PM"=>"1:30 PM",
        "2:00 PM"=>"2:00 PM",
        "2:30 PM"=>"2:30 PM",
        "3:00 PM"=>"3:00 PM",
        "3:30 PM"=>"3:30 PM",
        "4:00 PM"=>"4:00 PM",
        "4:30 PM"=>"4:30 PM",
        "5:00 PM"=>"5:00 PM",
        "5:30 PM"=>"5:30 PM",
        "6:00 PM"=>"6:00 PM",
        "6:30 PM"=>"6:30 PM",
        "7:00 PM"=>"7:00 PM",
        "7:30 PM"=>"7:30 PM",
        "8:00 PM"=>"8:00 PM",
        "8:30 PM"=>"8:30 PM",
        "9:00 PM"=>"9:00 PM",
        "9:30 PM"=>"9:30 PM",
        "10:00 PM"=>"10:00 PM",
        "10:30 PM"=>"10:30 PM",
        "11:00 PM"=>"11:00 PM",
        "11:30 PM"=>"11:30 PM",
        "12:00 PM"=>"12:00 PM",
        "12:30 PM"=>"12:30 PM",
        "Closed"=>"Closed"
    );

    public function initialize($entity = null, $options = null)
    {
        // In edition the id is hidden
        if (isset($options['edit']) && $options['edit']) {
            $id = new Hidden('id');
        } else {
            $id = new Hidden('id');
        }

        $this->add($id);

        // In edition the user_id is hidden
        if (isset($options['edit']) && $options['edit']) {
            $user_id = new Hidden('user_id');
        } else {
            $user_id = new Hidden('user_id');
        }
        $this->add($user_id);

        $this->initializeProfileElements();

        // Sign Up
        $this->add(new Submit('Update', array(
            'class' => 'next_btn'
        )));
    }



    public function initializeEdit(){

        // In edition the id is hidden
        if (isset($options['edit']) && $options['edit']) {
            $id = new Hidden('id');
        } else {
            $id = new Text('id');
        }
        $this->add($id);

        // In edition the user_id is hidden
        if (isset($options['edit']) && $options['edit']) {
            $user_id = new Hidden('user_id');
        } else {
            $user_id = new Text('user_id');
        }
        $this->add($user_id);

        $this->initializeProfileElements();
        // Sign Up
        $this->add(new Submit('Update', array(
            'class' => 'next_btn'
        )));
    }

    protected function initializeProfileElements(){

        // user_id
//        $user_id = new Text('user_id');
//        $user_id->setLabel('User Id');
////        $user_id->addValidators(array(
////            new PresenceOf(array(
////                'message' => 'The User Id is required'
////            ))
////        ));
//        $this->add($user_id);

        // Title
        $title = new Text('title', array('class'=>'form-control'));
        $title->setLabel('Title');
        $title->addValidators(array(
            new PresenceOf(array(
                'message' => 'The Title is required'
            ))
        ));
        $this->add($title);


        // Tagline
        $tagline = new Text('tagline', array('class'=>'form-control'));
        $tagline->setLabel('Tagline');
        $this->add($tagline);


        // Short Description
        $short_description = new TextArea('short_description', array(
            'class'=>'form-control',
            "cols" => "6",
            "rows" => 5
        ));
        $short_description->setLabel('Short Description');
        $short_description->addValidators(array(
            new PresenceOf(array(
                'message' => 'The Short Description is required'
            )),
            new StringLength(array(
                'max' => 250,
                'messageMaximum' => 'Short Description is too long. Maximum 250 characters'
            ))
        ));
        $this->add($short_description);

        // Long Description
        $long_description = new TextArea('long_description', array(
            'class'=>'form-control',
            "cols" => "6",
            "rows" => 10
        ));
        $long_description->setLabel('About Us');
        $long_description->addValidators(array(
            new PresenceOf(array(
                'message' => 'The About Us is required'
            )),
            new StringLength(array(
                'max' => 1000,
                'messageMaximum' => 'About Us is too long. Maximum 1000 characters'
            ))
        ));
        $this->add($long_description);

        // Web Site
        $web_site = new Text('web_site', array('class'=>'form-control'));
        $web_site->setLabel('Web Site');
        $this->add($web_site);

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

        //Linkdin
        $linkdin = new Text('linkdin', array('class'=>'form-control'));
        $linkdin->setLabel('Linkdin');
        $this->add($linkdin);

        //Facebook
        $facebook = new Text('facebook', array('class'=>'form-control'));
        $facebook->setLabel('Facebook');
        $this->add($facebook);

        //Google+
        $google_plus = new Text('google_plus', array('class'=>'form-control'));
        $google_plus->setLabel('Google+');
        $this->add($google_plus);

        //Twitter
        $twitter = new Text('twitter', array('class'=>'form-control'));
        $twitter->setLabel('Twitter');
        $this->add($twitter);

        //Pinterest
        $pinterest = new Text('pinterest', array('class'=>'form-control'));
        $pinterest->setLabel('Pinterest');
        $this->add($pinterest);

        //Instagram
        $instagram = new Text('instagram', array('class'=>'form-control'));
        $instagram->setLabel('Instagram');
        $this->add($instagram);

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

        //Street Address
        $address = new Text('address', array('class'=>'form-control'));
        $address->setLabel('Address');
        $address->addValidators(array(
            new PresenceOf(array(
                'message' => 'The Address is required'
            ))
        ));
        $this->add($address);


        //City
        $city = new Text('city', array('class'=>'form-control'));
        $city->setLabel('City');
        $city->addValidators(array(
            new PresenceOf(array(
                'message' => 'The City is required'
            ))
        ));
        $this->add($city);

        //State
        $state = new Text('state', array('class'=>'form-control'));
        $state->setLabel('State');
        $state->addValidators(array(
            new PresenceOf(array(
                'message' => 'The State is required'
            ))
        ));
        $this->add($state);

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
                'country_name'
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
        //Postcode/Zip Code
        $postcode = new Text('postcode', array('class'=>'form-control'));
        $postcode->setLabel('Postcode/Zip Code');
        $postcode->addValidators(array(
            new PresenceOf(array(
                'message' => 'The Postcode/Zip Code is required'
            ))
        ));
        $this->add($postcode);

        //Phone
        $phone = new Text('phone', array('class'=>'form-control'));
        $phone->setLabel('Phone');
        $phone->addValidators(array(
            new PresenceOf(array(
                'message' => 'The Phone is required'
            )),
            new Regex(array(
                    'message' => 'The Phone should be number',
                    'pattern' => '/[0-9]+/'
            )),
            new StringLength(array(
                'messageMinimum' => 'The Phone is too short',
                'min' => 2
            ))
        ));
        $this->add($phone);

        //Fax
        $fax = new Text('fax', array('class'=>'form-control'));
        $fax->setLabel('Fax');
        $this->add($fax);


        //Profile Image
        $profile_image = new Text('profile_image', array('class'=>'form-control'));
        $profile_image->setLabel('Profile Image');
        $this->add($profile_image);

        //Logo
        $logo = new Text('logo');
        $logo->setLabel('Logo');
        $this->add($logo);


        //Monday ho_mon_1
        $ho_mon_1 = new Select('ho_mon_1', $this->timesAM, array('class'=>'form-control'));
        $ho_mon_1->setLabel('Monday');
        $ho_mon_1->addValidators(array(
            new PresenceOf(array(
                'message' => 'The Monday is required'
            ))
        ));
        $this->add($ho_mon_1);

        //Monday ho_mon_2
        $ho_mon_2 = new Select('ho_mon_2', $this->timesPM, array('class'=>'form-control'));
        $ho_mon_2->setLabel('Monday');
        $ho_mon_2->addValidators(array(
            new PresenceOf(array(
                'message' => 'The Monday is required'
            ))
        ));
        $this->add($ho_mon_2);

        //Tuesday ho_tu_1
        $ho_tu_1 = new Select('ho_tu_1', $this->timesAM, array('class'=>'form-control'));
        $ho_tu_1->setLabel('Tuesday');
        $ho_tu_1->addValidators(array(
            new PresenceOf(array(
                'message' => 'The Tuesday is required'
            ))
        ));
        $this->add($ho_tu_1);

        //Tuesday ho_tu_2
        $ho_tu_2 = new Select('ho_tu_2', $this->timesPM, array('class'=>'form-control'));
        $ho_tu_2->setLabel('Tuesday');
        $ho_tu_2->addValidators(array(
            new PresenceOf(array(
                'message' => 'The Tuesday is required'
            ))
        ));
        $this->add($ho_tu_2);


        //Wednesday ho_wed_1
        $ho_wed_1 = new Select('ho_wed_1', $this->timesAM, array('class'=>'form-control'));
        $ho_wed_1->setLabel('Wednesday');
        $ho_wed_1->addValidators(array(
            new PresenceOf(array(
                'message' => 'The Wednesday is required'
            ))
        ));
        $this->add($ho_wed_1);

        //Wednesday ho_tu_2
        $ho_wed_2 = new Select('ho_wed_2', $this->timesPM, array('class'=>'form-control'));
        $ho_wed_2->setLabel('Wednesday');
        $ho_wed_2->addValidators(array(
            new PresenceOf(array(
                'message' => 'The Wednesday is required'
            ))
        ));
        $this->add($ho_wed_2);

        //Thursday ho_wed_1
        $ho_thu_1 = new Select('ho_thu_1', $this->timesAM, array('class'=>'form-control'));
        $ho_thu_1->setLabel('Thursday');
        $ho_thu_1->addValidators(array(
            new PresenceOf(array(
                'message' => 'The Thursday is required'
            ))
        ));
        $this->add($ho_thu_1);

        //Thursday ho_thu_2
        $ho_thu_2 = new Select('ho_thu_2', $this->timesPM, array('class'=>'form-control'));
        $ho_thu_2->setLabel('Thursday');
        $ho_thu_2->addValidators(array(
            new PresenceOf(array(
                'message' => 'The Thursday is required'
            ))
        ));
        $this->add($ho_thu_2);


        //Friday ho_fri_1
        $ho_fri_1 = new Select('ho_fri_1', $this->timesAM, array('class'=>'form-control'));
        $ho_fri_1->setLabel('Friday');
        $ho_fri_1->addValidators(array(
            new PresenceOf(array(
                'message' => 'The Friday is required'
            ))
        ));
        $this->add($ho_fri_1);

        //Friday ho_fri_2
        $ho_fri_2 = new Select('ho_fri_2', $this->timesPM, array('class'=>'form-control'));
        $ho_fri_2->setLabel('Friday');
        $ho_fri_2->addValidators(array(
            new PresenceOf(array(
                'message' => 'The Friday is required'
            ))
        ));
        $this->add($ho_fri_2);

        //Saturday $ho_sat_1
        $ho_sat_1 = new Select('ho_sat_1', $this->timesAM, array('class'=>'form-control'));
        $ho_sat_1->setLabel('Saturday');
        $ho_sat_1->addValidators(array(
            new PresenceOf(array(
                'message' => 'The Saturday is required'
            ))
        ));
        $this->add($ho_sat_1);

        //Saturday ho_sat_2
        $ho_sat_2 = new Select('ho_sat_2', $this->timesPM, array('class'=>'form-control'));
        $ho_sat_2->setLabel('Saturday');
        $ho_sat_2->addValidators(array(
            new PresenceOf(array(
                'message' => 'The Saturday is required'
            ))
        ));
        $this->add($ho_sat_2);

        //Sunday ho_sun_2
        $ho_sun_1 = new Select('ho_sun_1', $this->timesAM, array('class'=>'form-control'));
        $ho_sun_1->setLabel('Saturday');
        $ho_sun_1->addValidators(array(
            new PresenceOf(array(
                'message' => 'The Saturday is required'
            ))
        ));
        $this->add($ho_sun_1);

        //Sunday ho_sun_2
        $ho_sun_2 = new Select('ho_sun_2', $this->timesPM, array('class'=>'form-control'));
        $ho_sun_2->setLabel('Saturday');
        $ho_sun_2->addValidators(array(
            new PresenceOf(array(
                'message' => 'The Saturday is required'
            ))
        ));
        $this->add($ho_sun_2);

        // Long keywords
        $keywords = new TextArea('keywords', array('class'=>'form-control'));
        $keywords->setLabel('Keywords');
//        $keywords->addValidators(array(
//            new PresenceOf(array(
//                'message' => 'The Keywords is required'
//            ))
//        ));
        $this->add($keywords);
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

    protected function setDefaultsFromObject(\Findmyrice\Models\Profile $profile){
        \Phalcon\Tag::setDefaults(array(
            'title'     => $profile->title,
            'tagline'     => $profile->tagline,
            'short_description'     => $profile->short_description,
            'long_description'     => $profile->long_description,
            'web_site'     => $profile->web_site,
            'email'     => $profile->email,
            'linkdin'     => $profile->linkdin,
            'facebook'     => $profile->facebook,
            'google_plus'     => $profile->google_plus,
            'twitter'     => $profile->twitter,
            'pinterest'     => $profile->pinterest,
            'instagram'     => $profile->instagram,
            'address'     => $profile->address,
            'city'     => $profile->city,
            'state'     => $profile->state,
            'country'     => $profile->country,
            'phone'     => $profile->phone,
            'fax'     => $profile->fax,
            'profile_image'     => $profile->profile_image,
            'logo'     => $profile->logo,
            'ho_mon_1'     => $profile->ho_mon_1,
            'ho_mon_2'     => $profile->ho_mon_2,
            'ho_tu_1'     => $profile->ho_tu_1,
            'ho_tu_2'     => $profile->ho_tu_2,
            'ho_wed_1'     => $profile->ho_wed_1,
            'ho_wed_2'     => $profile->ho_wed_2,
            'ho_thu_1'     => $profile->ho_thu_1,
            'ho_thu_2'     => $profile->ho_thu_2,
            'ho_fri_1'     => $profile->ho_fri_1,
            'ho_fri_2'     => $profile->ho_fri_2,
            'ho_sat_1'     => $profile->ho_sat_1,
            'ho_sat_2'     => $profile->ho_sat_2,
            'ho_sun_1'     => $profile->ho_sun_1,
            'ho_sun_2'     => $profile->ho_sun_2,
            'keywords'     => $profile->keywords
        ));
    }

    protected function setDefaultsFromRequest(\Phalcon\Http\Request $request){
        \Phalcon\Tag::setDefaults(array(
            'title'     => $request->title,
            'tagline'     => $request->tagline,
            'short_description'     => $request->short_description,
            'long_description'     => $request->long_description,
            'web_site'     => $request->web_site,
            'email'     => $request->email,
            'linkdin'     => $request->linkdin,
            'facebook'     => $request->facebook,
            'google_plus'     => $request->google_plus,
            'twitter'     => $request->twitter,
            'pinterest'     => $request->pinterest,
            'instagram'     => $request->instagram,
            'address'     => $request->address,
            'city'     => $request->city,
            'state'     => $request->state,
            'country'     => $request->country,
            'phone'     => $request->phone,
            'fax'     => $request->fax,
            'profile_image'     => $request->profile_image,
            'logo'     => $request->logo,
            'ho_mon_1'     => $request->ho_mon_1,
            'ho_mon_2'     => $request->ho_mon_2,
            'ho_tu_1'     => $request->ho_tu_1,
            'ho_tu_2'     => $request->ho_tu_2,
            'ho_wed_1'     => $request->ho_wed_1,
            'ho_wed_2'     => $request->ho_wed_2,
            'ho_thu_1'     => $request->ho_thu_1,
            'ho_thu_2'     => $request->ho_thu_2,
            'ho_fri_1'     => $request->ho_fri_1,
            'ho_fri_2'     => $request->ho_fri_2,
            'ho_sat_1'     => $request->ho_sat_1,
            'ho_sat_2'     => $request->ho_sat_2,
            'ho_sun_1'     => $request->ho_sun_1,
            'ho_sun_2'     => $request->ho_sun_2,
            'keywords'     => $request->keywords
        ));
    }

    public function setDefaultsFromSession($session){
        if(isset($session) && !empty($session)){
            \Phalcon\Tag::setDefaults(array(
                'title'     => $session['title'],
                'tagline'     => $session['tagline'],
                'short_description'     => $session['short_description'],
                'long_description'     => $session['long_description'],
                'web_site'     => $session['web_site'],
                'email'     => $session['email'],
                'linkdin'     => $session['linkdin'],
                'facebook'     => $session['facebook'],
                'google_plus'     => $session['google_plus'],
                'twitter'     => $session['twitter'],
                'pinterest'     => $session['pinterest'],
                'instagram'     => $session['instagram'],
                'address'     => $session['address'],
                'city'     => $session['city'],
                'state'     => $session['state'],
                'country'     => $session['country'],
                'phone'     => $session['phone'],
                'fax'     => $session['fax'],
                'profile_image'     => $session['profile_image'],
                'logo'     => $session['logo'],
                'ho_mon_1'     => $session['ho_mon_1'],
                'ho_mon_2'     => $session['ho_mon_2'],
                'ho_tu_1'     => $session['ho_tu_1'],
                'ho_tu_2'     => $session['ho_tu_2'],
                'ho_wed_1'     => $session['ho_wed_1'],
                'ho_wed_2'     => $session['ho_wed_2'],
                'ho_thu_1'     => $session['ho_thu_1'],
                'ho_thu_2'     => $session['ho_thu_2'],
                'ho_fri_1'     => $session['ho_fri_1'],
                'ho_fri_2'     => $session['ho_fri_2'],
                'ho_sat_1'     => $session['ho_sat_1'],
                'ho_sat_2'     => $session['ho_sat_2'],
                'ho_sun_1'     => $session['ho_sun_1'],
                'ho_sun_2'     => $session['ho_sun_2'],
                'keywords'     => $session['keywords']
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
