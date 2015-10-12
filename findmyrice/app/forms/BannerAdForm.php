<?php
namespace Findmyrice\Forms;

use Phalcon\Forms\Element\Submit;
use Phalcon\Forms\Element\File;
use Phalcon\Forms\Element\Text;
use Phalcon\Forms\Form;
use Phalcon\Validation\Validator\PresenceOf;

class BannerAdForm extends Form
{
    public function initialize($entity = null, $options = null)
    {
        $ad_file = new Text('ad_file', array('class'=>'form-control'));
        $ad_file->setLabel('Banner Ad File');
        $ad_file->addValidators(array(
            new PresenceOf(array(
                'message' => 'The Banner Ad File is required'
            ))
        ));

        $this->add($ad_file);

        $upl_image_upload = new File('upl_image_upload', array('class'=>'file_upload_btn'));
        $upl_image_upload->setLabel('Banner');
//        $upl_image_upload->addValidators(array(
//            new PresenceOf(array(
//                'message' => 'Please choose the Image again.'
//            ))
//        ));
        $this->add($upl_image_upload);

        $alt_text = new Text('alt_text', array('class'=>'form-control'));
        $alt_text->setLabel('Alt Text (Ad name)');
        $alt_text->addValidators(array(
            new PresenceOf(array(
                'message' => 'The Alt Text is required'
            ))
        ));

        $this->add($alt_text);

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