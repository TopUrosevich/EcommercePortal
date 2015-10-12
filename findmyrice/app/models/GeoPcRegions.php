<?php
namespace Findmyrice\Models;

/**
 * Findmyrice\Models\GeoPcRegions
 *
 */
class GeoPcRegions extends \Phalcon\Mvc\Collection
{

    public function getSource()
    {
        return "geopc_regions";
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
    public $iso;

    /**
     *
     * @var string
     */
    public $country;

    /**
     *
     * @var string
     */
    public $language;

    /**
     *
     * @var string
     */
    public $level;



    /**
     *
     * @var string
     */
    public $type;

    /**
     *
     * @var string
     */
    public $name;

    /**
     *
     * @var string
     */
    public $region1;

    /**
     *
     * @var string
     */
    public $region2;


    /**
     *
     * @var string
     */
    public $region3;

     /**
     *
     * @var string
     */
    public $region4;

    /**
     *
     * @var string
    */
    public $iso2;

    /**
     *
     * @var string
    */
    public $fips;

    /**
     *
     * @var string
    */
    public $nuts;

    /**
     *
     * @var string
    */
    public $hasc;

    /**
     *
     * @var string
    */
    public $stat;


    public function getMessages()
    {
        return $this->_errorMessages;
    }

    /**
    *
    */
    public function beforeValidationOnCreate()
    {

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
}
