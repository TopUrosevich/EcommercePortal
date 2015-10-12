<?php
namespace Findmyrice\Forms;


use Phalcon\Forms\Element\Text;
use Phalcon\Forms\Form;
use Phalcon\Validation\Validator\PresenceOf;

class NewsCategoriesForm extends Form
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
            ))
        ));

        $this->add($alias);
    }
}