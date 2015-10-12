<?php
namespace Findmyrice\Models;

use Findmyrice\Models\UniqueValidator;
use Findmyrice\Models\Users;
use Phalcon\Mvc\Model;
use MongoId;

/**
 * Findmyrice\Models\Users
 * All the users registered in the application
 */
class Profile extends \Phalcon\Mvc\Collection
{

    public function getSource()
    {
        return "profile";
    }

    /**
     *
     * @var string
     */
    public $_id;

    /**
     *
     * @var string
     */
    public $user_id;

    /**
     *
     * @var string
     */
    public $title;

    /**
     *
     * @var string
     */
    public $tagline;

    /**
     *
     * @var string
     */
    public $short_description;



    /**
     *
     * @var string
     */
    public $long_description;

    /**
     *
     * @var string
     */
    public $web_site;

    /**
     *
     * @var string
     */
    public $email;

    /**
     *
     * @var string
     */
    public $linkdin;

    /**
     *
     * @var string
     */
    public $facebook;

    /**
     *
     * @var string
     */
    public $google_plus;

    /**
     *
     * @var string
     */
    public $twitter;

    /**
     *
     * @var string
     */
    public $pinterest;

    /**
     *
     * @var string
     */
    public $instagram;

    /**
     *
     * @var string
     */
    public $address;

    /**
     *
     * @var string
     */
    public $city;

    /**
     *
     * @var string
     */
    public $state;

    /**
     *
     * @var string
     */
    public $country;

    /**
     *
     * @var string
     */
    public $phone;

    /**
     *
     * @var string
     */
    public $fax;

    /**
     *
     * @var string
     */
    public $profile_image;

    /**
     *
     * @var string
     */
    public $logo;


    /**
     *
     * @var string
     */
    public $ho_mon_1;

    /**
     *
     * @var string
     */
    public $ho_mon_2;

    /**
     *
     * @var string
     */
    public $ho_tu_1;

    /**
     *
     * @var string
     */
    public $ho_tu_2;

    /**
     *
     * @var string
     */
    public $ho_wed_1;

    /**
     *
     * @var string
     */
    public $ho_wed_2;

    /**
     *
     * @var string
     */
    public $ho_thu_1;

    /**
     *
     * @var string
     */
    public $ho_thu_2;

    /**
     *
     * @var string
     */
    public $ho_fri_1;

    /**
     *
     * @var string
     */
    public $ho_fri_2;

    /**
     *
     * @var string
     */
    public $ho_sat_1;

    /**
     *
     * @var string
     */
    public $ho_sat_2;

    /**
     *
     * @var string
     */
    public $ho_sun_1;

    /**
     *
     * @var string
     */
    public $ho_sun_2;

    /**
     *
     * @var string
     */
    public $keywords;

    /**
     *
     * @var string
     */
    public $created_at;

    /**
     *
     * @var string
     */
    public $modified_at;

    /**
     *
     * @var string
     */
    public $business_type;

    /**
     *
     * @var string
     */
    public $currently_export;

    /**
     *
     * @var string
     */
    public $currently_import;

    /**
     *
     * @var string
     */
    public $active;

    /**
     *
     * @var string
     */
    public $primary_product_service;
    /**
     *
     * @var string
     */
    public $primary_supplier_category;

    public function beforeCreate()
    {
        $user = Users::findById($this->user_id);
        $this->business_type = $user->business_type;
        $this->currently_export = $user->currently_export;
        $this->currently_import = $user->currently_import;
        $this->primary_product_service = $user->primary_product_service;
        $this->primary_supplier_category = $user->primary_supplier_category;
        $this->active = $user->active;

        $this->created_at = time();
        $this->modified_at = time();
    }

    public function beforeUpdate()
    {
        if($this->created_at == null){
            $this->created_at = time();
        }
        $this->modified_at = time();
    }


    public function getMessages()
    {
        return $this->_errorMessages;
    }

    /**
     * Before create the user assign a password
     */
    public function beforeValidationOnCreate()
    {
        //Hours Open of week
        $this->ho_mon_1 = '9:00 AM';
        $this->ho_mon_2 = '5:00 PM';
        $this->ho_tu_1 = '9:00 AM';
        $this->ho_tu_2 = '5:00 PM';
        $this->ho_wed_1 = '9:00 AM';
        $this->ho_wed_2 = '5:00 PM';
        $this->ho_thu_1 = '9:00 AM';
        $this->ho_thu_2 = '5:00 PM';
        $this->ho_fri_1 = '9:00 AM';
        $this->ho_fri_2 = '5:00 PM';
        $this->ho_sat_1 = 'Closed';
        $this->ho_sat_2 = 'Closed';
        $this->ho_sun_1 = 'Closed';
        $this->ho_sun_2 = 'Closed';

    }

    /**
     * Send a confirmation e-mail to the user if the account is not active
     */

    public function afterSave()
    {

    }


    /**
     * Validate that emails are unique across users
     * Validate that phones are unique across users
     */
    public function validation()
    {
        $this->validate(new UniqueValidator(array(
            "field" => "email",
            "message" => "The email is already registered"
        )));
        return $this->validationHasFailed() != true;

        $this->validate(new UniqueValidator(array(
            "field" => "phone",
            "message" => "The phone is already registered"
        )));
        return $this->validationHasFailed() != true;

    }

    public function initialize()
    {

//        $this->belongsTo('user_id', 'Findmyrice\Models\Users', '_id', array(
//            'alias' => 'profile',
//            'reusable' => true
//        ));
    }

    public static function findByUserId($user_id)
    {
        $mongo_user_id = new MongoId($user_id);
        $profile = Profile::find(array(
                array("user_id" => $mongo_user_id)
        ));
        if (isset($profile) && !empty($profile)) {
            return $profile[0];
        } else {
            return false;
        }

        return false;
    }
}
