<?php
namespace Findmyrice\Models;

use Phalcon\Mvc\Model;
use MongoId;

/**
 * Findmyrice\Models\SelfServiceAd
 *
 */
class SelfServiceAd extends \Phalcon\Mvc\Collection
{

    public function getSource()
    {
        return "self_service_ad";
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
    public $image_name;

    /**
     *
     * @var string
     */
    public $headline;

    /**
     *
     * @var string
     */
    public $text;

    /**
     *
     * @var string
     */
    public $status;

    /**
     *
     * @var string
     */
    public $createdAt;


    public function getMessages()
    {
        return $this->_errorMessages;
    }

    /**
     * Before create the SelfServiceAd assign a status, createdAt
     */
    public function beforeValidationOnCreate()
    {
        //Status
        $this->status = 0;
        // Timestamp
        $this->createdAt = time();
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
        $SelfServiceAds = SelfServiceAd::find(array(
                array("user_id" => $mongo_user_id)
        ));
        if (isset($SelfServiceAds) && !empty($SelfServiceAds)) {
            return $SelfServiceAds;
        } else {
            return false;
        }

        return false;
    }
}
