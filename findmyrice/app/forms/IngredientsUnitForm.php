<?php
namespace Findmyrice\Forms;


use Phalcon\Forms\Element\Text;
use Phalcon\Forms\Form;
use Phalcon\Validation\Validator\PresenceOf;

class IngredientsUnitForm extends Form
{
    public function initialize($entity = null, $options = null)
    {
        $unit = new Text('name');
        $unit->setLabel('Unit');
        $unit->setFilters(array(
            'trim',
            'striptags'
        ));
        $unit->addValidators(array(
            new PresenceOf(array(
                'message' => 'The Unit is required'
            ))
        ));

        $this->add($unit);
    }
}