<?php
namespace Findmyrice\Models;

use Phalcon\Mvc\Model;
use MongoId;

/**
 * Findmyrice\Models\ProductList
 * All the Product Lists registered in the application
 */
class ProductList extends \Phalcon\Mvc\Collection
{

    public function getSource()
    {
        return "product_lists";
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
    public $pl_name;

    /**
     *
     * @var string
     */
    public $pl_file_type;

    /**
     *
     * @var string
     */
    public $pl_size;

    /**
     *
     * @var string
     */
    public $pl_url;



    /**
     *
     * @var string
     */
    public $pl_uploaded;


    public function getMessages()
    {
        return $this->_errorMessages;
    }

    /**
     *
     */
    public function beforeValidationOnCreate()
    {
        // Timestamp the uploaded
        $this->pl_uploaded = time();

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
        $ProductLists = ProductList::find(array(
            array("user_id" => $mongo_user_id)
        ));
        if (isset($ProductLists) && !empty($ProductLists)) {
            return $ProductLists;
        } else {
            return false;
        }
        return false;
    }
}
