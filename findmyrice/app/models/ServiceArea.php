<?php
namespace Findmyrice\Models;

use Phalcon\Mvc\Model;
use MongoId;

/**
 * Findmyrice\Models\Users
 * All the users registered in the application
 */
class ServiceArea extends \Phalcon\Mvc\Collection
{

    public function getSource()
    {
        return "service_area";
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
    public $product_list_id;

    /**
     *
     * @var string
     */
    public $sa_area_name;

    /**
     *
     * @var string
     */
    public $sa_status;

    /**
     *
     * @var string
     */
    public $sa_country;

    /**
     *
     * @var string
     */
    public $sa_country_code;

    /**
     *
     * @var string
     */
    public $sa_state;

    /**
     *
     * @var string
     */
    public $sa_city;

    /**
     *
     * @var string
     */
    public $sa_street_address;

    /**
     *
     * @var string
     */
    public $sa_postcode;

    /**
     *
     * @var string
     */
    public $sa_area_code;

    /**
     *
     * @var string
     */
    public $sa_phone;

    /**
     *
     * @var string
     */
    public $sa_created_at;

    /**
     *
     * @var string
     */
    public $sa_modified_at;

    public function beforeCreate()
    {
        $this->sa_created_at = time();
        $this->sa_modified_at = time();
    }

    public function beforeUpdate()
    {
        if($this->sa_created_at == null){
            $this->sa_created_at = time();
        }
        $this->sa_modified_at = time();
    }


    public function getMessages()
    {
        return $this->_errorMessages;
    }

    /**
     *
     */
    public function beforeValidationOnCreate()
    {

        $this->sa_status = 'Complete';
//        $this->sa_status = 'Incomplete';
    }

    /**
     *
     */

    public function afterSave()
    {

    }


    /**
     *
     */
    public function validation()
    {

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
        $ServiceArea = ServiceArea::find(array(
                array("user_id" => $mongo_user_id)
        ));
        if (isset($ServiceArea) && !empty($ServiceArea)) {
            return $ServiceArea;
        } else {
            return false;
        }
        return false;
    }

    public static function findByProductListId($product_list_id)
    {
        $mongo_product_list_id = new MongoId($product_list_id);
        $ServiceArea = ServiceArea::find(array(
            array("product_list_id" => $mongo_product_list_id)
        ));
        if (isset($ServiceArea) && !empty($ServiceArea)) {
            return $ServiceArea;
        } else {
            return false;
        }
        return false;
    }
}
