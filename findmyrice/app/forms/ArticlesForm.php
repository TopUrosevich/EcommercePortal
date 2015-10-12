<?php
namespace Findmyrice\Forms;


use Findmyrice\Models\NewsCategories;
use Phalcon\Forms\Element\Check;
use Phalcon\Forms\Element\Date;
use Phalcon\Forms\Element\Select;
use Phalcon\Forms\Element\Submit;
use Phalcon\Forms\Element\Text;
use Phalcon\Forms\Element\TextArea;
use Phalcon\Forms\Form;
use Phalcon\Validation\Validator\PresenceOf;

class ArticlesForm extends Form
{
    public function initialize($entity = null, $options = null)
    {
        if ($entity) {
            $entity->date = date('Y-m-d', $entity->date);
            $this->setEntity($entity);
        }

        $title = new Text('title');
        $title->setLabel('Article Title');
        $title->addValidators(array(
            new PresenceOf(array(
                'message' => 'The Article Title is required'
            ))
        ));

        $this->add($title);

        $alias = new Text('alias');
        $alias->setLabel('Article Alias');
        $alias->addValidators(array(
            new PresenceOf(array(
                'message' => 'The Article Alias is required'
            ))
        ));

        $this->add($alias);

        $category = new Select('category_id', NewsCategories::findForSelect(), array(
            'using' => array(
                '_id',
                'title'
            ),
            'useEmpty' => true,
            'emptyText' => 'Article Category',
            'emptyValue' => ''
        ));
        $category->addValidators(array(
            new PresenceOf(array(
                'message' => 'The Article Category is required'
            ))
        ));
        $category->setLabel('Article Category');

        $this->add($category);

        $date = new Date('date', array(
            'value' => date('Y-m-d', time())
        ));
        $date->setLabel('Submission Date');
        $date->addValidators(array(
            new PresenceOf(array(
                'message' => 'The Date is required'
            ))
        ));

        $this->add($date);

        $image = new Text('image');
        $image->setLabel('Article Image URL');
        $image->addValidators(array(
            new PresenceOf(array(
                'message' => 'The Main Image URL is required'
            ))
        ));

        $this->add($image);

        $content = new TextArea('content');
        $content->setLabel('Article');
        $content->addValidators(array(
            new PresenceOf(array(
                'message' => 'The Article is required'
            ))
        ));

        $this->add($content);

        $publish = new Check('publish');
        $publish->setLabel('Published');

        $this->add($publish);

        $submit = new Submit('submit', array(
            'value' => $options['edit'] ? 'Save' : 'Create'
        ));

        $this->add($submit);
    }
}