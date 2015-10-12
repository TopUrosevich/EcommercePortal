<?php
namespace Findmyrice\Models;

//use Phalcon\Mvc\Model;

/**
 * PasswordChanges
 * Register when a user changes his/her password
 */
class PasswordChanges extends \Phalcon\Mvc\Collection
{

    public function getSource()
    {
        return "password_changes";
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

    /**
     *
     * @var integer
     */
    public $createdAt;

    /**
     * Before create the user assign a password
     */
    public function beforeValidationOnCreate()
    {
        // Timestamp the confirmaton
        $this->createdAt = time();
    }

    public function initialize()
    {
//        $this->belongsTo('usersId', 'Findmyrice\Models\Users', '_id', array(
//            'alias' => 'user'
//        ));
    }
}
