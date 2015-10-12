<?php
namespace Findmyrice\Models;

//use Phalcon\Mvc\Model;
use Findmyrice\Auth\Exception;
use Findmyrice\Models\Users;
/**
 * ResetPasswords
 * Stores the reset password codes and their evolution
 */
class ResetPasswords extends \Phalcon\Mvc\Collection
{

    public function getSource()
    {
        return "reset_passwords";
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
    public $code;

    /**
     *
     * @var integer
     */
    public $createdAt;

    /**
     *
     * @var integer
     */
    public $modifiedAt;

    /**
     *
     * @var string
     */
    public $reset;

    /**
     * Before create the user assign a password
     */
    public function beforeValidationOnCreate()
    {
        // Timestamp the confirmaton
        $this->createdAt = time();

        // Generate a random confirmation code
        $this->code = preg_replace('/[^a-zA-Z0-9]/', '', base64_encode(openssl_random_pseudo_bytes(24)));

        // Set status to non-confirmed
        $this->reset = 'N';
    }

    /**
     * Sets the timestamp before update the confirmation
     */
    public function beforeValidationOnUpdate()
    {
        // Timestamp the confirmaton
        $this->modifiedAt = time();
    }

    /**
     * Send an e-mail to users allowing him/her to reset his/her password
     */
    public function afterCreate()
    {
        $user = Users::findById($this->usersId);
        $this->getDI()
            ->getMail()
            ->send(array(
            $user->email => $user->name
        ), "Reset your password", 'reset', array(
            'resetUrl' => '/reset-password/' . $this->code . '/' . $user->email
        ));
    }

    public static function findFirstByCode($code)
    {
        $resetPassword = ResetPasswords::find(array(
            array(
                "code" => $code
            )
        ));

        if (isset($resetPassword) && !empty($resetPassword)) {
            return $resetPassword[0];
        } else {
            return false;
        }

        return false;

    }

    public function initialize()
    {
//        $this->belongsTo('usersId', 'Findmyrice\Models\Users', '_id', array(
//            'alias' => 'user'
//        ));
    }
}
