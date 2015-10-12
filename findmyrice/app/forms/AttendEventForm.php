<?php
namespace Findmyrice\Forms;


use Phalcon\Forms\Element\Hidden;
use Phalcon\Forms\Element\Text;
use Phalcon\Forms\Form;
use Phalcon\Validation;
use Phalcon\Validation\Validator\Email;
use Phalcon\Validation\Validator\PresenceOf;

class AttendEventForm extends Form
{
    public function initialize($entity = null, $options = null)
    {
        $id = new Hidden('event_id');

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

        $city = new Text('city');
        $city->setLabel('City');
        $city->addValidators(array(
            new PresenceOf(array(
                'message' => 'The City is required'
            ))
        ));

        $this->add($city);

        $company = new Text('company');
        $company->setLabel('Company');
        $company->addValidators(array(
            new PresenceOf(array(
                'message' => 'The Company is required'
            ))
        ));

        $this->add($company);


    }
}