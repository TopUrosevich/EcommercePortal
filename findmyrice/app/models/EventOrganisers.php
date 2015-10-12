<?php
namespace Findmyrice\Models;


use Phalcon\Escaper;
use Phalcon\Mvc\Collection;
use Phalcon\Paginator\Adapter\NativeArray as Paginator;
use MongoRegex;

class EventOrganisers extends Collection
{
    public function getSource()
    {
        return 'event_organisers';
    }

    public $_id;
    public $organiser_name;
    public $contact_name;
    public $email;
    public $country;
    public $state;
    public $city;
    public $zip_code;
    public $street_address;
    public $country_code;
    public $area_code;
    public $phone;

    public function beforeSave()
    {
        $e = new Escaper();
        $attributes = array(
            'organiser_name',
            'contact_name',
            'email',
            'country',
            'state',
            'city',
            'zip_code',
            'street_address',
            'area_code',
            'phone'
        );
        foreach ($attributes as $attr) {
            $this->{$attr} = $e->escapeHtml($this->{$attr});
        }
    }

    public function beforeDelete()
    {
        $events = Events::find(array(
            array(
                'category_id' => (string) $this->_id
            )
        ));

        foreach ($events as $event) {
            $event->delete();
        }
    }

    public static function findForSelect()
    {
        $organisers = EventOrganisers::find(array(
            'fields' => array(
                '_id',
                'organiser_name'
            )
        ));

        $array = array();

        foreach ($organisers as $organiser) {
            $array[(string) $organiser['_id']] = $organiser['organiser_name'];
        }

        return $array;
    }

    public static function findAllInCity($country, $city)
    {
        $organisers = EventOrganisers::find(array(
            array(
                'country' => $country,
                'city' => $city
            ),
            'fields' => array(
                '_id'
            )
        ));

        $array = array();

        foreach ($organisers as $organiser) {
            array_push($array, (string) $organiser->_id);
        }

        return $array;
    }

    public static function findAllInCountry($country)
    {
        $organisers = EventOrganisers::find(array(
            array(
                'country' => $country
            ),
            'fields' => array(
                '_id'
            )
        ));

        $array = array();

        foreach ($organisers as $organiser) {
            array_push($array, (string) $organiser->_id);
        }

        return $array;
    }

    public static function getOrganisersByAjax($start, $length, $draw, $search, $order)
    {
        $conditions = array(
            'conditions' => array(

            ),
            'sort' => array(
                'start_date' => -1
            )
        );

        if (isset($search['value']) && !empty($search['value'])) {
            $regex = new MongoRegex("/".$search['value']."/i");
            $conditions = array_merge_recursive($conditions,
                array('conditions' => array('organiser_name' => $regex)));
        }

        if (isset($order) && !empty($order)) {
            $column= $order[0]['column'];
            $column_dir= $order[0]['dir'];
            switch ($column) {
                case 0:
                    $column = "organiser_name";
                    break;
                case 1:
                    $column = "email";
                    break;
                case 2:
                    $column = "phone";
                    break;
                default:
                    $column = "organiser_name";
            }
            switch ($column_dir) {
                case 'asc':
                    $column_dir = 1;
                    break;
                case 'desc':
                    $column_dir = -1;
                    break;
                default:
                    $column_dir = -1;
            }
            $conditions = array_merge($conditions,
                array('sort' => array($column => $column_dir)));
        }

        $organisers = self::find($conditions);

        $pagination = new Paginator(array(
            'data' => $organisers,
            'limit'=>$length,
            'page'=> ($start / $length != 0) ?  ($start / $length + 1) : 1
        ));
        $page = $pagination->getPaginate();
        $organisers = $page->items;

        return $organisers;
    }
}