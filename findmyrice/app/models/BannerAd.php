<?php
namespace Findmyrice\Models;

use Phalcon\Mvc\Model;
use MongoId;

/**
 * Findmyrice\Models\BannerAd
 *
 */
class BannerAd extends \Phalcon\Mvc\Collection
{

    public function getSource()
    {
        return "banner_ad";
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
    public $banner_ad_file;

    /**
     *
     * @var string
     */
    public $alt_text;

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
        $BannerAds = BannerAd::find(array(
                array("user_id" => $mongo_user_id)
        ));
        if (isset($BannerAds) && !empty($BannerAds)) {
            return $BannerAds;
        } else {
            return false;
        }

        return false;
    }
}
