<?php
namespace Findmyrice\Forms;


use Findmyrice\Models\RecipeCategories;
use Phalcon\Forms\Element\Check;
use Phalcon\Forms\Element\File;
use Phalcon\Forms\Element\Hidden;
use Phalcon\Forms\Element\Select;
use Phalcon\Forms\Element\Text;
use Phalcon\Forms\Element\TextArea;
use Phalcon\Forms\Form;
use Phalcon\Validation\Message;
use Phalcon\Validation\Validator\PresenceOf;

class RecipesForm extends Form
{
    public function initialize($entity = null, $options = null)
    {
        $name = new Text('name');
        $name->setLabel('Recipe Name');
        $name->setFilters(array(
            'trim',
            'striptags'
        ));
        $name->addValidators(array(
            new PresenceOf(array(
                'message' => 'The Recipe Name is required'
            ))
        ));

        $this->add($name);

        $category = new Select('category_id', RecipeCategories::findForSelect(), array(
            'using' => array(
                '_id',
                'title'
            ),
            'useEmpty' => true,
            'emptyText' => 'Select...',
            'emptyValue' => ''
        ));
        $category->setLabel('Recipe Category');
        $category->setFilters(array(
            'trim',
            'striptags'
        ));
        $category->addValidators(array(
            new PresenceOf(array(
                'message' => 'The Recipe Category is required'
            ))
        ));

        $this->add($category);

        $photo = new File('photo', array(
            'accept' => 'image/png,image/jpeg'
        ));
        $photo->setLabel('Photo');

        $this->add($photo);

        $notes = new TextArea('notes');
        $notes->setLabel('Notes');
        $notes->setFilters(array(
            'trim',
            'striptags'
        ));
        $notes->addValidators(array(
            new PresenceOf(array(
                'message' => 'The Notes is required'
            ))
        ));

        $this->add($notes);

        $public = new Check('public');
        $public->setLabel('Make recipe public');

        $this->add($public);

        $tags = new TextArea('tags');
        $tags->setLabel('Tags');
        $tags->setFilters(array(
            'trim',
            'striptags'
        ));

        if ($entity != null) {
            $entity->tags = implode(', ', $entity->tags);
        }

        $this->add($tags);


        if ($options['type'] == 'single') {
            $ingredients = new Hidden('ingredients');
            $ingredients->setLabel('Add Ingredients');

            $this->add($ingredients);

            // Preparation method
            $methods = new Hidden('methods');
            $methods->setLabel('Preparation Method');

            $this->add($methods);

            $servings = new Text('servings');
            $servings->setLabel('Servings');
            $servings->setFilters(array(
                'int'
            ));

            $this->add($servings);
        }
    }

    public function addMessagesFromModel($model)
    {
        if (!$this->_messages) {
            $this->_messages = array();
        }

        foreach ($model->getMessages() as $message) {
            $this->_messages[$message->getField()] = new Message\Group(array(
                new Message($message->getMessage(), $message->getField())
            ));
        }
    }
}