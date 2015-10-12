<?php
namespace Findmyrice\Forms;

use Phalcon\Forms\Form;
use Phalcon\Forms\Element\Text;
use Phalcon\Forms\Element\Hidden;
use Phalcon\Forms\Element\Password;
use Phalcon\Forms\Element\File;
use Phalcon\Validation\Validator\PresenceOf;
use Phalcon\Validation\Validator\Email;
use Phalcon\Validation\Validator\Confirmation;


class UserEditProfileForm extends Form
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

        ///-----------
        // First Name
        $first_name = new Text('first_name', array('class'=>'form-control'));

        $first_name->setLabel('First Name');

        $first_name->addValidators(array(
            new PresenceOf(array(
                'message' => 'The Name is required'
            ))
        ));

        $this->add($first_name);


        // Email
        $email = new Text('email', array('class'=>'form-control'));
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

        // Password
        $password = new Password('password', array(
            'placeholder'=>'New Password',
            'class'=>'form-control'
        ));
        $password->setLabel('Password');
        $password->addValidators(array(
//            new PresenceOf(array(
//                'message' => 'The password is required'
//            )),
//            new StringLength(array(
//                'min' => 8,
//                'messageMinimum' => 'Password is too short. Minimum 8 characters'
//            )),
            new Confirmation(array(
                'message' => 'Password doesn\'t match confirmation',
                'with' => 'confirmPassword'
            ))
        ));
        $this->add($password);

        // Confirm Password
        $confirmPassword = new Password('confirmPassword', array(
            'placeholder'=>'Confirm Password',
            'class'=>'form-control'
        ));
        $confirmPassword->setLabel('Confirm Password');
//        $confirmPassword->addValidators(array(
//            new PresenceOf(array(
//                'message' => 'The confirmation password is required'
//            ))
//        ));
        $this->add($confirmPassword);

        //Position
        $position = new Text('position', array('class'=>'form-control'));
        $position->setLabel('Position');
        $this->add($position);



        //Country
        $country = new Text('country', array('class'=>'form-control'));
        $country->setLabel('Country');
        $this->add($country);

        //State
        $state = new Text('state', array('class'=>'form-control'));
        $state->setLabel('State');
        $this->add($state);



        // Logo
        $logo = new File('logo');
        $logo->setLabel('Logo');
        $this->add($logo);

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
