<?php
namespace Findmyrice\Models;

//use Findmyrice\Models\UniqueValidator;
use Phalcon\Acl\Exception;
use Phalcon\Mvc\Model;
use Findmyrice\Models\FavoritesCompanies;
use Findmyrice\Models\Profile;

/**
 * Findmyrice\Models\Users
 * All the users registered in the application
 */
class Users extends \Phalcon\Mvc\Collection
{

    public function getSource()
    {
        return "users";
    }

    /**
     *
     * @var integer
     */
    public $_id;

    /**
     *
     * @var string
     */
    public $email;

    /**
     *
     * @var string
     */
    public $first_name;

    /**
     *
     * @var string
     */
    public $last_name;

    /**
     *
     * @var string
     */
    public $name;



    /**
     *
     * @var string
     */
    public $password;

    /**
     *
     * @var string
     */
    public $business_name;

    /**
     *
     * @var string
     */
    public $street_address;

    /**
     *
     * @var string
     */
    public $suburb_town_city;

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
    public $postcode;

    /**
     *
     * @var string
     */
    public $country_code;

    /**
     *
     * @var string
     */
    public $area_code;

    /**
     *
     * @var string
     */
    public $phone;

    /**
     *
     * @var string
     */
    public $business_type;

    /**
     *
     * @var string
     */
    public $other_business_type;

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
    public $logo;

    /**
     *
     * @var string
     */
    public $membership_type;

    /**
     *
     * @var string
     */
    public $badges_buttons;


    /**
     *
     * @var string
     */
    public $mustChangePassword;

    /**
     *
     * @var string
     */
    public $profilesId;

    /**
     *
     * @var string
     */
    public $banned;

    /**
     *
     * @var string
     */
    public $suspended;

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

    public function beforeCreate()
    {
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
        if (empty($this->password)) {

            // Generate a plain temporary password
            $tempPassword = preg_replace('/[^a-zA-Z0-9]/', '', base64_encode(openssl_random_pseudo_bytes(12)));

            // The user must change its password in first login
            $this->mustChangePassword = 'Y';

            // Use this password as default
            $this->password = $this->getDI()
                ->getSecurity()
                ->hash($tempPassword);
        } else {
            // The user must not change its password in first login
            $this->mustChangePassword = 'N';
        }

        // The account must be confirmed via e-mail
        $this->active = 'N';

        // The account is not suspended by default
        $this->suspended = 'N';

        // The account is not banned by default
        $this->banned = 'N';
    }

    /**
     * Send a confirmation e-mail to the user if the account is not active
     */

    public function afterSave()
    {
        if ($this->active == 'N') {

            $emailConfirmation = new EmailConfirmations();

            $emailConfirmation->usersId = $this->_id;


//            $emailConfirmation->user = $this;

            if ($emailConfirmation->save()) {
                $this->getDI()
                    ->getFlash()
                    ->notice('A confirmation mail has been sent to ' . $this->email);
            }
        }
        try{
            $userProfile = Profile::findByUserId((string)$this->_id);
            if($userProfile){
                $userProfile->business_type = $this->business_type;
                $userProfile->currently_export = $this->currently_export;
                $userProfile->currently_import = $this->currently_import;
                $userProfile->active = $this->active;
                $userProfile->primary_product_service = $this->primary_product_service;
                $userProfile->primary_supplier_category = $this->primary_supplier_category;
                $userProfile->save();
            }
        }catch (\Exception $e){

        }

    }


    /**
     * Validate that emails are unique across users
     */
    public function validation()
    {
        $this->validate(new UniqueValidator(array(
            "field" => "name",
            "message" => "The username is already registered"
        )));
        $this->validate(new UniqueValidator(array(
            "field" => "email",
            "message" => "The email is already registered"
        )));
        return $this->validationHasFailed() != true;

    }

    public function initialize()
    {

//        $this->belongsTo('profilesId', 'Findmyrice\Models\Profiles', '_id', array(
//            'alias' => 'profile',
//            'reusable' => true
//        ));
//
//        $this->hasMany('_id', 'Findmyrice\Models\SuccessLogins', 'usersId', array(
//            'alias' => 'successLogins',
//            'foreignKey' => array(
//                'message' => 'User cannot be deleted because he/she has activity in the system'
//            )
//        ));
//
//        $this->hasMany('_id', 'Findmyrice\Models\PasswordChanges', 'usersId', array(
//            'alias' => 'passwordChanges',
//            'foreignKey' => array(
//                'message' => 'User cannot be deleted because he/she has activity in the system'
//            )
//        ));
//
//        $this->hasMany('_id', 'Findmyrice\Models\ResetPasswords', 'usersId', array(
//            'alias' => 'resetPasswords',
//            'foreignKey' => array(
//                'message' => 'User cannot be deleted because he/she has activity in the system'
//            )
//        ));
    }

    public static function findFirstByEmail($userEmail)
    {

        $user = Users::find(array(
            array("email" => $userEmail)
        ));

        if (isset($user) && !empty($user)) {
            return $user[0];
        } else {
            return false;
        }

        return false;
    }

    //find via Username
    public static function findFirstByUsername($username)
    {

        $user = Users::find(array(
            array("name" => $username)
        ));

        if (isset($user) && !empty($user)) {
            return $user[0];
        } else {
            return false;
        }

        return false;
    }

    /**
     * Find all news contributors
     * @return array
     * @throws Exception
     */
    public static function findNewsContributors()
    {
        $profiles = Profiles::findFirstByName('News-Contributors');
        $contributors = null;

        if ($profiles) {
            $contributors = Users::find(array(
                array(
                    'profilesId' => (string) $profiles->_id
                )
            ));
        }

        return $contributors;
    }

    /**
     * Return user's total articles count if the user is news contributor
     * @return bool|int
     */
    public function getTotalArticles()
    {
        $profilesId = Profiles::findFirstByName('News-Contributors')->_id;

        if (!$this->_id || $this->profilesId != $profilesId) {
            return false;
        }

        $articles = Articles::find(array(
            array(
                'contributor_id' => (string) $this->_id
            )
        ));

        if (!empty($articles) && is_array($articles)) {
            return count($articles);
        }

        return 0;
    }

    /**
     * Return user's last published date if the user is news contributor
     * @return bool|null|string
     */
    public function getLastPublished()
    {
        $profilesId = Profiles::findFirstByName('News-Contributors')->_id;

        if (!$this->_id || $this->profilesId != $profilesId) {
            return false;
        }

        $articles = Articles::findFirst(array(
            array(
                'contributor_id' => (string) $this->_id
            ),
            'sort' => array(
                'date' => -1
            )
        ));

        return !$articles ? null : date('y/m/d', $articles->date);
    }

    /**
     * Return user's profile
     * @return bool|null|string
     */
    public function getProfile()
    {
        if (!$this->_id) {
            return false;
        }

        return Profile::findFirst(array(
            array(
                'user_id' => (string) $this->_id
            )
        ));
    }
    /**
     * Return Companies
     * @return objects
     */
    public function getCompanies()
    {
        $companies = Users::find(array(
            array(
                'active'=>'Y',
                'profilesId'=> COMPANY_PROFILE_ID
            )
        ));

        if (isset($companies) && !empty($companies)) {
            return $companies;
        } else {
            return false;
        }
        return false;

    }

    public function getFavoritesCount()
    {
        if (!$this->_id) {
            return 0;

        }

        return FavoritesCompanies::count(array(
            array(
                'company_id' => (string) $this->_id
            )
        ));
    }
}
