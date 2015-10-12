<?php
namespace Findmyrice\Forms;

use Phalcon\Forms\Form;
use Phalcon\Forms\Element\Text;
use Phalcon\Forms\Element\Password;
use Phalcon\Forms\Element\Submit;
use Phalcon\Forms\Element\Check;
use Phalcon\Forms\Element\Hidden;
use Phalcon\Validation\Validator\PresenceOf;
use Phalcon\Validation\Validator\Email;
use Phalcon\Validation\Validator\Identical;

class LoginCompanyForm extends Form
{

    public function initialize()
    {
        // username
        $username = new Text('email', array(
            'class'=>'form-control username_box',
            'placeholder'=>"Username"
        ));

        $username->addValidators(array(
            new PresenceOf(array(
                'message' => 'The Username is required'
            ))
        ));

        $this->add($username);

        // Password
        $password = new Password('password', array(
            'class'=>"form-control password_box",
            'placeholder'=>"Password"
        ));

        $password->addValidator(new PresenceOf(array(
            'message' => 'The password is required'
        )));

        $this->add($password);

        // Remember
        $remember = new Check('remember', array(
            'value' => 'yes'
        ));

        $remember->setLabel('Remember me');

        $this->add($remember);

        // CSRF
        $csrf = new Hidden('csrf');

        $csrf->addValidator(new Identical(array(
            'value' => $this->security->getSessionToken(),
            'message' => 'CSRF validation failed'
        )));

        $this->add($csrf);

        $this->add(new Submit('Login', array(
            'class' => 'red_btn login_btn'
        )));
    }
}