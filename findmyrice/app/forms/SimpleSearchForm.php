<?php
namespace Findmyrice\Forms;

use Phalcon\Forms\Form;
use Phalcon\Forms\Element\Text;
use Phalcon\Forms\Element\Submit;
use Phalcon\Forms\Element\Select;
use Phalcon\Forms\Element\Hidden;

class SimpleSearchForm extends Form
{

    public function initialize($entity = null, $options = null)
    {
        //simple search
        $simple_search = new Hidden('simple_search', array('value'=>"yes"));
        $this->add($simple_search);
        //Search Field
//        $search_field = new Select('search_field', array(
//            'All' => 'All',
//            'Categories' => 'Categories',
//            'Companies' => 'Companies',
//            'Keywords' => 'Keywords',
//            'Product Lists' => 'Product Lists'
//        ), array('class'=>'form-control'));
//        $search_field->setLabel('Search Field');
//        $this->add($search_field);
//
//        if (isset($options['search_field'])) {
//            $search_field->setDefault($options['search_field']);
//        }

        //Product, Service or Company
        $name_pcck = new Text('name_pcck', array(
            'class'=>'form-control',
            'placeholder'=>'Product, Company, Category or Keyword'
        ));
        $name_pcck->setLabel('Product, Company, Category or Keyword');

        if (isset($options['name_pcck'])) {
            $name_pcck->setDefault($options['name_pcck']);
        }

        $this->add($name_pcck);

        //State, City or Town
        $location = new Text('location', array(
            'class'=>'form-control form_control',
            'placeholder'=>'Location (country , state or city, post/zip code)'
        ));
        $location->setLabel('Location (country , state or city, post/zip code)');
        if (isset($options['location'])) {
            $location->setDefault($options['location']);
        }
        $this->add($location);

        // Search
        $this->add(new Submit('', array(
            'class' => 'primary_btn'
        )));
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
