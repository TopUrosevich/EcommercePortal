<?php
namespace Findmyrice\Models;

//use Phalcon\Mvc\Model;
use Findmyrice\Models\Users;

/**
 * EmailConfirmations
 * Stores the reset password codes and their evolution
 */
class EmailConfirmations extends \Phalcon\Mvc\Collection
{

    public function getSource()
    {
        return "email_confirmations";
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

    public $confirmed;

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
        $this->confirmed = 'N';
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
     * Send a confirmation e-mail to the user after create the account
     */
    public function afterCreate()
    {
        $user = Users::findById($this->usersId);
        $this->getDI()
            ->getMail()
            ->send(array(
                $user->email => $user->name
        ), "Please confirm your email", 'confirmation', array(
            'confirmUrl' => '/confirm/' . $this->code . '/' . $user->email
        ));

    }
    public static function findFirstByCode($code)
    {
        $confirmation = EmailConfirmations::find(array(
            array(
                "code" => $code
            )
        ));

        if (isset($confirmation) && !empty($confirmation)) {
            return $confirmation[0];
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
