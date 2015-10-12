<?php
namespace Findmyrice\Forms;

use Phalcon\Forms\Form;
use Phalcon\Forms\Element\Text;
use Phalcon\Forms\Element\Select;
use Phalcon\Forms\Element\Submit;
use Findmyrice\Models\Countries;
//use Findmyrice\Models\Categories;


class HomePageForm extends Form
{

    public function initialize($entity = null, $options = null)
    {
        // product_name
        $product_name = new Text('product_name', array(
            'placeholder'=>"Select Product"
        ));
        $product_name->setLabel('Product');
//        $product_name->addValidators(array(
//            new PresenceOf(array(
//                'message' => 'The Product is required'
//            ))
//        ));
        $this->add($product_name);


        //Country
        /*
        $categories = Categories::find(array(array(

        ),
            'fields' => array(
                '_id',
                'category_name'
            )
        ));
        $arr_category  = $this->external->returnArrayForSelectCountries($categories);
        */
        $arr_category = array(1=>'category 1',2=>'category 2',3=>'category 3',4=>'category 4',5=>'category 5');
        $category= new Select('category', $arr_category, array(
            'using' => array(
                '_id',
                'category_name'
            ),
            'useEmpty' => true,
            'emptyText' => '-Select Category-',
            'emptyValue' => '',
            'class'=>'btn select_btn'
        ));
        $category->setLabel('Category');
//        $category->addValidators(array(
//            new PresenceOf(array(
//                'message' => 'The Category is required'
//            ))
//        ));
        $this->add($category);

        //Country
        $countries = Countries::find(array(array(

        ),
            'fields' => array(
                '_id',
                'country_name'
            )
        ));
        $arr_country  = $this->external->returnArrayForSelectCountries($countries);

        $country = new Select('country', $arr_country, array(
            'using' => array(
                '_id',
                'country_name'
            ),
            'useEmpty' => true,
            'emptyText' => '-Select Country-',
            'emptyValue' => '',
            'class'=>'btn select_btn'
        ));
        $country->setLabel('Country');
//        $country->addValidators(array(
//            new PresenceOf(array(
//                'message' => 'The Country is required'
//            ))
//        ));
        $this->add($country);

        // Sign Up
        $this->add(new Submit('Search', array(
            'class' => 'search_btn'
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
