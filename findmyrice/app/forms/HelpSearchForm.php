<?php
namespace Findmyrice\Forms;


use Phalcon\Forms\Element\Text;
use Phalcon\Forms\Form;
use Phalcon\Validation\Validator\PresenceOf;
use Phalcon\Validation\Validator\StringLength;

class HelpSearchForm extends Form
{
    public function initialize($entity = null, $options = null)
    {
        $query = new Text('query');
        $query->setLabel('Search Query');
        $query->addValidators(array(
            new PresenceOf(array(
                'message' => 'The Search Query is required'
            )),
            new StringLength(array(
                'min' => 3,
                'max' => 100,
                'message' => 'The Search Query should contain at least 3 characters'
            ))
        ));

        $this->add($query);
    }
}