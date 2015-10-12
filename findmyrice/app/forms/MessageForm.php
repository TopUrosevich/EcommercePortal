<?php
namespace Findmyrice\Forms;

use Phalcon\Forms\Form;
use Phalcon\Forms\Element\Text;
use Phalcon\Forms\Element\TextArea;
use Phalcon\Forms\Element\Hidden;
use Phalcon\Forms\Element\Submit;
use Phalcon\Forms\Element\Check;
use Phalcon\Validation\Validator\PresenceOf;
use Phalcon\Validation\Validator\Email;

class MessageForm extends Form
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
        $email = new Text('email', array('class'=>'form-control', 'placeholder'=>'To'));

        $email->setLabel('E-Mail');

        $email->addValidators(array(
            new PresenceOf(array(
                'message' => 'The e-mail is required'
            )),
            new Email(array(
                'message' => 'The e-mail is not valid'
            ))
        ));

        $this->add($email);
        

        // Subject
        $subject = new Text('subject', array('class'=>'form-control', 'placeholder'=>'Enter a subject'));

        $subject->setLabel('Subject');

        $subject->addValidators(array(
            new PresenceOf(array(
                'message' => 'The subject is required'
            ))
        ));

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
        
        
        // Check Box
//        $currently_import = new Check('currently_import', array(
//            'value' => 'yes'
//        ));
//        $currently_import->setLabel('I currently import products from overseas.');
//        $this->add($currently_import);
        
        // Check Box
        
        $each_check = array();
        for ($i = 0; $i < 1000; $i ++) {
            $each_check[$i] = new Check('each_check'.$i, array(
                'value' => 'yes'
            ));
            
            $this->add($each_check[$i]);
        }
        
        // Hidden Field Array
        $messageId = array();
        for ($i = 0; $i < 1000; $i ++) {
            $messageId[$i] = new Hidden('messageId'.$i, array(
                'value' => ''
            ));
            
            $this->add($messageId[$i]);
        }
        
        // Hidden Field
        $m_ct = new Hidden('m_ct', array(
                'value' => ''
            ));
        
        $this->add($m_ct);
        
        
        
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
