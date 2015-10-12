<?php
namespace Findmyrice\Models;


use Phalcon\Escaper;
use Phalcon\Mvc\Collection;

use MongoId;    

class UserMessages extends \Phalcon\Mvc\Collection
{
    public function getSource()
    {
        return 'user_messages';
    }

    public $_id;
    public $user_id;
    public $name;
    public $email;
    public $message;
    public $status;
    public $read;
    public $subject;
    public $created_at;
    public $created_time;
    
    public function initialize() {
        
    }

    public function beforeCreate()
    {
        $this->created_at = date("M j, Y, g:i a");
        $this->created_time = time();
    }

    public function beforeSave()
    {
        $e = new Escaper();
        $attributes = array(
            'name',
            'email',
            'message'
        );

        foreach ($attributes as $attr) {
            $this->{$attr} = $e->escapeHtml($this->{$attr});
        }
    }

    /**
     * Send a e-mail to the user if comapany recieved a mail.
     */
    
    public function afterSave()
    {
        
    }
    
    public static function findByUserId($user_id)
    {
        $messages = UserMessages::find(array(
            array(
                "user_id" => $user_id
            ),
            "sort" => array("created_time" => -1)
        ));
        
        if (isset($messages) && !empty($messages)) {
            return $messages;
        } else {
            return false;
        }

        return false;
    }
    
    public static function findByUserIdRead($user_id, $read)
    {
        $messages = UserMessages::find(array(
            array(
                "user_id" => $user_id,
                "read" => $read
            ),
            "sort" => array("created_time" => -1)
        ));
        
        if (isset($messages) && !empty($messages)) {
            return $messages;
        } else {
            return false;
        }
    }
    
    public static function findByMessageId($message_id)
    {   
        $mongo_message_id = new MongoId($message_id);
        $messages = UserMessages::findFirst(array(
                array(
                    "_id" => $mongo_message_id
                )
        ));
        
        if (isset($messages) && !empty($messages)) {
            return $messages;
        } else {
            return false;
        }
        
        return false;
    }
    
    public static function findByUserIdStatus($user_id, $status)
    {
        $messages = UserMessages::find(array(
            array(
                "user_id" => $user_id,
                "status" => $status
            ),
            "sort" => array("created_time" => -1)
        ));
        
        if (isset($messages) && !empty($messages)) {
            return $messages;
        } else {
            return false;
        }
    }
    
    public static function findByEmail($email)
    {
        $message = UserMessages::findFirst(array(
                array(
                    "email" => $email
                )
        ));
        
        if (isset($message) && !empty($message)) {
            return $message;
        } else {
            return false;
        }
    }
}