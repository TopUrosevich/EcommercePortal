<?php
namespace Findmyrice\Forms;


use Findmyrice\Models\EventCategories;
use Findmyrice\Models\EventOrganisers;
use Findmyrice\Models\Events;
use Phalcon\Forms\Element\Select;
use Phalcon\Forms\Element\Text;
use Phalcon\Forms\Form;

class EventsFilterForm extends Form
{
    public function initialize($entity = null, $options = null)
    {
        $category = new Select('category', EventCategories::findForFilterSelect(), array(
            'using' => array(
                'alias',
                'title'
            ),
            'useEmpty' => true,
            'emptyText' => 'Category',
            'emptyValue' => ''
        ));

        if (isset($options['category'])) {
            $category->setDefault($options['category']);
        }

        $this->add($category);

        $countries = Events::distinctCountries();

        $country = new Select('country', array_combine($countries, $countries), array(
            'useEmpty' => true,
            'emptyText' => 'Country',
            'emptyValue' => ''
        ));

        if (isset($options['country'])) {
            $country->setDefault(ucwords($options['country']));
        }

        $this->add($country);

        $city = new Select('city', array(), array(
            'useEmpty' => true,
            'emptyText' => 'City',
            'emptyValue' => '',
            'disabled' => isset($options['city']) || isset($options['country']) ? null : true
        ));

        if (isset($options['city']) || isset($options['country'])) {
            $cities = Events::distinctCitiesByCountry(ucwords($options['country']));
            $city->setOptions(array_combine($cities, $cities));

            if (isset($options['city'])){
                $city->setDefault(ucwords($options['city']));
            }
        }

        $this->add($city);
    }
}