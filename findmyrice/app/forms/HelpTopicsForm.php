<?php
namespace Findmyrice\Forms;


use Phalcon\Forms\Element\Check;
use Phalcon\Forms\Element\Radio;
use Phalcon\Forms\Element\Text;
use Phalcon\Forms\Element\TextArea;
use Phalcon\Forms\Element\Hidden;
use Phalcon\Forms\Form;
use Phalcon\Validation\Validator\PresenceOf;

class HelpTopicsForm extends Form
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
        
        // Topic title
        $title = new Text('title');
        $title->addValidators(array(
            new PresenceOf(array(
                'message' => 'The Title is required'
            ))
        ));

        $this->add($title);

        // Topic alias
        $alias = new Text('alias');
        $alias->addValidators(array(
            new PresenceOf(array(
                'message' => 'The Alias is required'
            ))
        ));

        $this->add($alias);

        // Topic content
        $content = new TextArea('content');
        $content->addValidators(array(
            new PresenceOf(array(
                'message' => 'The Content is required'
            ))
        ));

        $this->add($content);

        // Category id checkbox
        $categories = new Radio('category_id', array(

        ));
        $categories->addValidators(array(
            new PresenceOf(array(
                'message' => 'Category not selected'
            ))
        ));

        $this->add($categories);

        // Add to topic to top FAQ
        $topFAQ = new Check('top_faq');
        $topFAQ->setLabel('Add to Top FAQ\'s');

        $this->add($topFAQ);
    }
}