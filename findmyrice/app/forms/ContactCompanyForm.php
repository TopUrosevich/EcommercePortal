<?php
namespace Findmyrice\Forms;


use Phalcon\Forms\Element\Hidden;
use Phalcon\Forms\Element\Text;
use Phalcon\Forms\Element\TextArea;
use Phalcon\Forms\Form;
use Phalcon\Validation\Validator\Email;
use Phalcon\Validation\Validator\PresenceOf;

class ContactCompanyForm extends Form
{
    public function initialize($entity = null, $options = null)
    {
        $id = new Hidden('company_id');
        $this->add($id);

        $name = new Text('name');
        $name->setLabel('Name');
        $name->addValidators(array(
            new PresenceOf(array(
                'message' => 'The Name is required'
            ))
        ));

        $this->add($name);

        $email = new Text('email');
        $email->setLabel('Email');
        $email->addValidators(array(
            new PresenceOf(array(
                'message' => 'The Email is required'
            )),
            new Email(array(
                'message' => 'The Email is not valid'
            ))
        ));

        $this->add($email);

        $message = new TextArea('message');
        $message->setLabel('Message');
        $message->addValidators(array(
            new PresenceOf(array(
                'message' => 'The Message is required'
            ))
        ));

        $this->add($message);
    }
}