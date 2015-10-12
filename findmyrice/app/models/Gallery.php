<?php
namespace Findmyrice\Models;

use Phalcon\Mvc\Model;
use MongoId;

/**
 * Findmyrice\Models\Users
 * All the users registered in the application
 */
class Gallery extends \Phalcon\Mvc\Collection
{

    public function getSource()
    {
        return "gallery";
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
    public $photo_name;



    public function getMessages()
    {
        return $this->_errorMessages;
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
        $galleries = Gallery::find(array(
                array("user_id" => $mongo_user_id)
        ));
        if (isset($galleries) && !empty($galleries)) {
            return $galleries;
        } else {
            return false;
        }

        return false;
    }
}
