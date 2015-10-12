<?php
namespace Findmyrice\Models;

//use Phalcon\Mvc\Model;

/**
 * Permissions
 * Stores the permissions by profile
 */
class Permissions extends \Phalcon\Mvc\Collection
{

    public function getSource()
    {
        return "permissions";
    }

    /**
     *
     * @var integer
     */
    public $_id;

    /**
     *
     * @var integer
     */
    public $profilesId;

    /**
     *
     * @var string
     */
    public $resource;

    /**
     *
     * @var string
     */
    public $action;

    public function initialize()
    {
//        $this->belongsTo('profilesId', 'Findmyrice\Models\Profiles', '_id', array(
//            'alias' => 'profile'
//        ));
    }
}
