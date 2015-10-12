<?php
namespace Findmyrice\Forms;

use Phalcon\Forms\Element\TextArea;
use Phalcon\Forms\Form;
use Phalcon\Forms\Element\Text;
use Phalcon\Forms\Element\Select;
use Phalcon\Validation\Validator\PresenceOf;
use Phalcon\Validation\Validator\Email;

class SuggestionForm extends Form
{

    public function initialize($entity = null, $options = null)
    {
        $feedback_type = new Select('feedback_type', array(
            'feedback_type_1' => 'Feedback Type 1',
            'feedback_type_2' => 'Feedback Type 2',
            'feedback_type_3' => 'Feedback Type 3'
        ),
            array(
                'using' => array(
                    '_id',
                    'name'
                ),
                'useEmpty' => true,
                'emptyText' => 'FEEDBACK TYPE',
                'emptyValue' => '',
                'class'=>'feedback_type'
            )
        );
        $feedback_type->setLabel('Feedback Type');
        $feedback_type->addValidators(array(
            new PresenceOf(array(
                'message' => 'The Feedback Type is required'
            ))
        ));
        $this->add($feedback_type);

        $name = new Text('name', array(
            "required"=>"required"
        ));

        $name->addValidators(array(
            new PresenceOf(array(
                'message' => 'The name is required'
            ))
        ));

        $this->add($name);

        $email = new Text('email', array(
            "required"=>"required"
        ));

        $email->addValidators(array(
            new PresenceOf(array(
                'message' => 'The e-mail is required'
            )),
            new Email(array(
                'message' => 'The e-mail is not valid'
            ))
        ));

        $this->add($email);

        $message = new TextArea('message', array(
            "required"=>"required"
        ));

        $message->addValidators(array(
            new PresenceOf(array(
                'message' => 'The Message is required'
            ))
        ));

        $this->add($message);

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
