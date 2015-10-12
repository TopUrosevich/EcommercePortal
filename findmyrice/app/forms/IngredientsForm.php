<?php
namespace Findmyrice\Forms;


use Phalcon\Forms\Element\Text;
use Phalcon\Forms\Form;
use Phalcon\Validation\Validator\PresenceOf;

class IngredientsForm extends Form
{
    public function initialize($entity = null, $options = null)
    {
        $ingredient = new Text('name');
        $ingredient->setLabel("Ingredient");
        $ingredient->setFilters(array(
            'trim',
            'striptags'
        ));
        $ingredient->addValidators(array(
            new PresenceOf(array(
                'message' => 'The Ingredient is required'
            ))
        ));

        $this->add($ingredient);
    }
}