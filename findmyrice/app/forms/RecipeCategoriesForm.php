<?php
namespace Findmyrice\Forms;


use Phalcon\Forms\Element\Text;
use Phalcon\Forms\Form;
use Phalcon\Validation\Validator\PresenceOf;
use Phalcon\Validation\Validator\Regex;

class RecipeCategoriesForm extends Form
{
    public function initialize($entity = null, $options = null)
    {
        $title = new Text('title');
        $title->setLabel('Category Title');
        $title->addValidators(array(
            new PresenceOf(array(
                'message' => 'The Category Title is required'
            ))
        ));

        $this->add($title);

        $alias = new Text('alias');
        $alias->setLabel('Category Alias');
        $alias->addValidators(array(
            new PresenceOf(array(
                'message' => 'The Category Alias is required'
            )),
            new Regex(array(
                'pattern' => '/^[a-z0-9-]+$/',
                'message' => 'Only "a-z", "0-9", "-" and "_" are valid for Alias'
            ))
        ));

        $this->add($alias);
    }
}