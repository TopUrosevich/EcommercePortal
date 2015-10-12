<?php
namespace Findmyrice\Models;

use Phalcon\Mvc\Model;
//use MongoId;

/**
 * Findmyrice\Models\Countries
 * All Countries
 */
class Countries extends \Phalcon\Mvc\Collection
{

    public function getSource()
    {
        return "location_country_new";
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
    public $iso_code;

    /**
     *
     * @var string
     */
    public $country_name;

    /**
     *
     * @var string
     */
    public $country_code;


    public function getMessages()
    {
        return $this->_errorMessages;
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
}
