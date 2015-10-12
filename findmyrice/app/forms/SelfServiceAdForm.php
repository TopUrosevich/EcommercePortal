<?php
namespace Findmyrice\Forms;



use Phalcon\Forms\Element\Submit;
use Phalcon\Forms\Element\File;
use Phalcon\Forms\Element\Text;
use Phalcon\Forms\Element\TextArea;
use Phalcon\Forms\Form;
use Phalcon\Validation\Validator\PresenceOf;

class SelfServiceAdForm extends Form
{
    public function initialize($entity = null, $options = null)
    {
        $upl_image = new Text('upl_image', array('class'=>'form-control'));
        $upl_image->setLabel('Image name');
        $upl_image->addValidators(array(
            new PresenceOf(array(
                'message' => 'The Image is required'
            ))
        ));

        $this->add($upl_image);

        $upl_image_upload = new File('upl_image_upload', array('class'=>'file_upload_btn'));
        $upl_image_upload->setLabel('Image');
//        $upl_image_upload->addValidators(array(
//            new PresenceOf(array(
//                'message' => 'Please choose the Image again.'
//            ))
//        ));

        $this->add($upl_image_upload);

        $headline = new Text('headline', array('class'=>'form-control'));
        $headline->setLabel('Headline');
        $headline->addValidators(array(
            new PresenceOf(array(
                'message' => 'The Headline is required'
            ))
        ));

        $this->add($headline);

        $textArea = new TextArea('text', array('class'=>'form-control'));
        $textArea->setLabel('Text');
        $textArea->addValidators(array(
            new PresenceOf(array(
                'message' => 'The Text is required'
            ))
        ));

        $this->add($textArea);


        $submit = new Submit('submit', array(
            'value' => $options['edit'] ? 'Save' : 'Create'
        ));

        $this->add($submit);
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