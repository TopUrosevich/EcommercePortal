<?php
namespace Findmyrice\Forms;


use Findmyrice\Models\EventCategories;
use Findmyrice\Models\EventOrganisers;
use Phalcon\Forms\Element\Check;
use Phalcon\Forms\Element\Date;
use Phalcon\Forms\Element\File;
use Phalcon\Forms\Element\Select;
use Phalcon\Forms\Element\Submit;
use Phalcon\Forms\Element\Text;
use Phalcon\Forms\Element\TextArea;
use Phalcon\Forms\Form;
use Phalcon\Validation\Validator\Email;
use Phalcon\Validation\Validator\PresenceOf;
use Phalcon\Validation\Validator\Regex;
use Phalcon\Validation\Validator\Url;

class EventsForm extends Form
{
    public function initialize($entity = null, $options = null)
    {
        if ($entity) {
            $entity->start_date = date('Y-m-d', $entity->start_date);
            $entity->end_date = date('Y-m-d', $entity->end_date);
            $entity->alias = substr($entity->alias, strpos($entity->alias, '-') + 1);
        }

        $name = new Text('event_name');
        $name->setLabel('Event Name');
        $name->addValidators(array (
            new PresenceOf(array (
                'message' => 'The Event Name is required'
            ))
        ));

        $this->add($name);

        $venue = new Text('venue');
        $venue->setLabel('Venue');
        $venue->addValidators(array (
            new PresenceOf(array (
                'message' => 'The Venue is required'
            ))
        ));

        $this->add($venue);

        if (!isset($options['submit'])) {
            $organiser = new Select('organiser_id', EventOrganisers::findForSelect(), array(
                'using' => array(
                    '_id',
                    'organiser_name'
                ),
                'useEmpty' => true,
                'emptyText' => 'Select...',
                'emptyValue' => ''
            ));
            $organiser->setLabel('Organiser');
            $organiser->addValidators(array (
                new PresenceOf(array (
                    'message' => 'The Organiser is required'
                ))
            ));

            $this->add($organiser);
        }

        $category = new Select('category_id', EventCategories::findForSelect(), array(
            'using' => array(
                '_id',
                'title'
            ),
            'useEmpty' => true,
            'emptyText' => 'Select...',
            'emptyValue' => ''
        ));
        $category->setLabel('Category');
        $category->addValidators(array (
            new PresenceOf(array (
                'message' => 'The Category is required'
            ))
        ));

        $this->add($category);

        $startDate = new Date('start_date', array(
            'value' => date('Y-m-d', time())
        ));
        $startDate->setLabel('Start Date');
        $startDate->addValidators(array (
            new PresenceOf(array (
                'message' => 'The Start Date is required'
            ))
        ));

        $this->add($startDate);

        $endDate = new Date('end_date', array(
            'value' => date('Y-m-d', time())
        ));
        $endDate->setLabel('End Date');
        $endDate->addValidators(array (
            new PresenceOf(array (
                'message' => 'The End Date is required'
            ))
        ));

        $this->add($endDate);

        $enquiryEmail = new Text('enquiry_email');
        $enquiryEmail->setLabel('Enquiry Email');
//        $enquiryEmail->addValidators(array(
//            new PresenceOf(array(
//                'message' => 'The Enquiry Email is required'
//            )),
//            new Email(array(
//                'message' => 'The e-mail is not valid'
//            ))
//        ));

        $this->add($enquiryEmail);

        $website = new Text('website');
        $website->setLabel('Website');
//        $website->addValidators(array (
//            new PresenceOf(array (
//                'message' => 'The Website is required'
//            )),
//            new Url(array(
//                'message' => 'The Website URL is not valid'
//            ))
//        ));

        $this->add($website);

        $facebook = new Text('facebook');
        $facebook->setLabel('Facebook');

        $this->add($facebook);

        $twitter = new Text('twitter');
        $twitter->setLabel('Twitter');

        $this->add($twitter);

        $instagram = new Text('instagram');
        $instagram->setLabel('Instagram');

        $this->add($instagram);

        $description = new TextArea('description');
        $description->setLabel('Event Description');
        $description->addValidators(array(
            new PresenceOf(array(
                'message' => 'The Event Description is required'
            ))
        ));

        $this->add($description);

        $image = new File('image_origin');
        $image->setLabel('Upload Image (1370 x 250 px)');

        $this->add($image);

        $previewImage = new File('image_preview');
        $previewImage->setLabel('Upload Preview Image (210 x 130 px)');

        $this->add($previewImage);

        $alias = new Text('alias');
        $alias->setLabel('Alias');
//        $alias->addValidators(array(
//            new PresenceOf(array(
//                'message' => 'The Alias is required'
//            )),
//            new Regex(array(
//                'pattern' => '/^[a-z0-9-]+$/',
//                'message' => 'Only "a-z", "0-9", "-" and "_" are valid for Alias'
//            ))
//        ));

        $this->add($alias);

        $approval = new Check('approval');
        $approval->setLabel('Approval');

        $this->add($approval);

        $submit = new Submit('submit', array(
            'value' => isset($options['edit']) ? 'Save' : 'Create'
        ));

        $this->add($submit);

        $address = new Text('street_address');
        $address->setLabel('Street Address');
        $address->addValidators(array(
            new PresenceOf(array(
                'message' => 'The Street Address is required'
            ))
        ));

        $this->add($address);

        $time = new Text('time');
        $time->setLabel('Time');
//        $time->addValidators(array(
//            new PresenceOf(array(
//                'message' => 'The Time is required'
//            ))
//        ));

        $this->add($time);

        $country = new Text('country');
        $country->addValidators(array(
            new PresenceOf(array(
                'message' => 'The Country is required'
            ))
        ));

        $this->add($country);

        $city = new Text('city');
        $city->addValidators(array(
            new PresenceOf(array(
                'message' => 'The City is required'
            ))
        ));

        $this->add($city);

        $timezone = new Text('timezone');
        $timezone->addValidators(array(
            new PresenceOf(array(
                'message' => 'The Timezone is required'
            ))
        ));
        $this->add($timezone);
    }
}