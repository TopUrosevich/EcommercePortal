<?php
namespace Findmyrice\Forms;


use Findmyrice\Models\HelpCategories;
use Phalcon\Forms\Element\Check;
use Phalcon\Forms\Element\Select;
use Phalcon\Forms\Element\Text;
use Phalcon\Forms\Element\Hidden;
use Phalcon\Forms\Form;
use Phalcon\Validation\Validator\PresenceOf;
use Phalcon\Validation\Validator\Regex;

class HelpCategoriesForm extends Form
{
    public function initialize($entity = null, $options = null)
    {

        // In edition the id is hidden
        if (isset($options['edit']) && $options['edit']) {
            $id = new Hidden('id');
        } else {
            $id = new Hidden('id');
        }

        $this->add($id);
        
        // Category title
        $title = new Text('title');
        $title->setLabel('Category Title');
        $title->addValidators(array(
            new PresenceOf(array(
                'message' => 'The Category Title is required'
            ))
        ));

        $this->add($title);

        // Alias for category
        $alias = new Text('alias');
        $alias->setLabel('Alias');
        $alias->addValidators(array(
            new Regex(array(
                'pattern' => '/^[a-z0-9-]+$/',
                'message' => 'Only "a-z", "0-9", "-" and "_" are valid for Alias'
            ))
        ));

        $this->add($alias);

        // Parent category id
        $parentCategory = new Select('parent_id', HelpCategories::findForSelect(), array(
            'using' => array(
                '_id',
                'name'
            ),
            'useEmpty' => true,
            'emptyText' => 'Parent Category',
            'emptyValue' => ''
        ));
        $parentCategory->setLabel('Parent Category');

        $this->add($parentCategory);

    }
}