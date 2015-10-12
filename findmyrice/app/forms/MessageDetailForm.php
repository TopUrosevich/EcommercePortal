<?php
namespace Findmyrice\Forms;

use Phalcon\Forms\Form;
use Phalcon\Forms\Element\Text;
use Phalcon\Forms\Element\TextArea;
use Phalcon\Forms\Element\Hidden;
use Phalcon\Forms\Element\Select;
use Phalcon\Forms\Element\Password;
use Phalcon\Forms\Element\Submit;
use Phalcon\Forms\Element\Check;
use Phalcon\Validation\Validator\PresenceOf;
use Phalcon\Validation\Validator\Email;
use Phalcon\Validation\Validator\Identical;
use Phalcon\Validation\Validator\Regex;
use Phalcon\Validation\Validator\StringLength;
use Phalcon\Validation\Validator\Confirmation;
use Findmyrice\Models\Profiles;
use Findmyrice\Models\Countries;


class MessageDetailForm extends Form
{

    public function initialize($entity = null, $options = null)
    {
        \Phalcon\Tag::setDefault('password', '');
        \Phalcon\Tag::setDefault('confirmPassword', '');

        // In edition the id is hidden
        if (isset($options['edit']) && $options['edit']) {
            $id = new Hidden('id');
        } else {
            $id = new Hidden('id');
        }

        $this->add($id);
        

        // Email
        $email = new Hidden('email');

        $this->add($email);
        

        // Subject
        $subject = new Hidden('subject');

        $this->add($subject);
        

        // Message
        $message = new TextArea('message', array('class'=>'form-control', 'rows'=>'10', 'placeholder'=>'Type your message ...'));

        $message->setLabel('Message');

        $message->addValidators(array(
            new PresenceOf(array(
                'message' => 'The message is required'
            ))
        ));

        $this->add($message);
        
        
        
        // Send Message        
        $submit = new Submit('send', array('class' => 'red_btn', 'value' => 'Send Message'));
        
        $this->add($submit);


        
        
        //All Check
        $all_check = new Check('all_check', array(
            'value' => 'yes'
        ));
        $this->add($all_check);

        //Each Check
        $each_check = new Check('each_check', array(
            'value' => 'yes'
        ));
        $this->add($each_check);
        
        

        ///-----------

        $profiles = Profiles::find(array(array(
            "active" => "Y"
        ),
            'fields' => array(
                '_id',
                'name'
        )
        ));
        $this->add(new Select('profilesId', $this->external->returnArrayForSelect($profiles), array(
            'using' => array(
                '_id',
                'name'
            ),
            'useEmpty' => true,
            'emptyText' => '...',
            'emptyValue' => '',
            'class'=>'form-control'
        )));

        $this->add(new Select('banned', array(
            'Y' => 'Yes',
            'N' => 'No'
        )));

        $this->add(new Select('suspended', array(
            'Y' => 'Yes',
            'N' => 'No'
        )));

        $this->add(new Select('active', array(
            'Y' => 'Yes',
            'N' => 'No'
        )));
    }

    /**
     * Prints messages for a specific element
     */
    public function messages($name)
    {
        if ($this->hasMessagesFor($name)) {
            foreach ($this->getMessagesFor($name) as $message) {
                $this->flash->error($message);
            }
        }
    }

}
