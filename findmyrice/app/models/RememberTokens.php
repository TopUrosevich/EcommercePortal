<?php
namespace Findmyrice\Models;

//use Phalcon\Mvc\Model;

/**
 * RememberTokens
 * Stores the remember me tokens
 */
class RememberTokens extends \Phalcon\Mvc\Collection
{

    public function getSource()
    {
        return "remember_tokens";
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
    public $token;

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
