<?php
namespace Findmyrice\Models;

//use Phalcon\Mvc\Model;

/**
 * SuccessLogins
 * This model registers successfull logins registered users have made
 */
class SuccessLogins extends \Phalcon\Mvc\Collection
{
    public function getSource()
    {
        return "success_logins";
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
    public $usersId;

    /**
     *
     * @var string
     */
    public $ipAddress;

    /**
     *
     * @var string
     */
    public $userAgent;

    public function initialize()
    {
//        $this->belongsTo('usersId', 'Findmyrice\Models\Users', '_id', array(
//            'alias' => 'user'
//        ));
    }
}
