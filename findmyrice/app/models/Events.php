<?php
namespace Findmyrice\Models;


use Geocoder\HttpAdapter\CurlHttpAdapter;
use Geocoder\Provider\GoogleMapsProvider;
use Ivory\GoogleMap\Services\Geocoding\Geocoder;
use Phalcon\Escaper;
use Phalcon\Mvc\Collection;
use Phalcon\Paginator\Adapter\NativeArray as Paginator;
use MongoRegex;

class Events extends Collection
{
    public function getSource()
    {
        return 'events';
    }

    public $_id;
    public $event_name;
    public $venue;
    public $organiser_id;
    public $category_id;
    public $street_address;
    public $time;
    public $timezone;
    public $country;
    public $city;
    public $start_date;
    public $end_date;
    public $enquiry_email;
    public $website;
    public $facebook;
    public $twitter;
    public $instagram;
    public $description;
    public $image_origin;
    public $image_preview;
    public $approval;
    public $alias;
    public $created_at;
    public $lat;
    public $lon;

    public function beforeCreate()
    {
        $this->created_at = time();
        $this->alias = str_replace(" ","-",trim(strtolower($this->event_name)));
    }

    public function beforeSave()
    {
        $this->alias = str_replace(" ","-",trim(strtolower($this->event_name)));

        if (!is_int($this->end_date) && !is_int($this->start_date)) {
            $this->start_date = strtotime($this->start_date);
            $this->end_date = strtotime($this->end_date);
            $this->alias = date('jS', $this->start_date) . '-' . $this->alias;
        }
        try {
            $address = $this->venue.', '.$this->street_address.', '.$this->city.', '.$this->country;

            $geocoder = new Geocoder();
            $provider = new GoogleMapsProvider(new CurlHttpAdapter(), null, null, true,
                $this->getDI()->get('config')->googleMaps->serverApiKey);
            $geocoder->registerProvider($provider);
            $result = $geocoder->geocode($address);

            $this->lat = $result->getLatitude();
            $this->lon = $result->getLongitude();
        } catch (\Exception $e) {
            $this->lat = 0;
            $this->lon = 0;
        }

        $e = new Escaper();
        $attributes = array(
            'event_name',
            'venue',
            'description'
        );

        foreach ($attributes as $attr) {
            $this->{$attr} = $e->escapeHtml($this->{$attr});
        }
    }

    public function getCategory()
    {
        if (!$this->_id) {
            return false;
        }
        return EventCategories::findById($this->category_id);
    }

    public function getOrganiser()
    {
        if (!$this->organiser_id) {
            return false;
        }
        return EventOrganisers::findById($this->organiser_id);
    }

    public function getAttendingPeopleCount()
    {
        if (!$this->_id) {
            return false;
        }

        $people = AttendingPeople::find(array(
            array(
                'event_id' => (string) $this->_id
            )
        ));

        return $people ? count($people) : 0;
    }

    public function getFavoritesCount()
    {
        if (!$this->_id) {
            return 0;

        }

        return FavoritesEvents::count(array(
            array(
                'event_id' => (string) $this->_id
            )
        ));
    }

    /**
     * Get all unique countries for search select
     * @return array
     */
    public static function distinctCountries()
    {
        $result = Events::execute('db.events.distinct("country")');
        $countries = $result['retval'];
        return sort($countries) ? $countries : array();
    }

    /**
     * Get all unique cities of the country
     * @param string $country country name
     * @return array
     */
    public static function distinctCitiesByCountry($country)
    {
        $result = Events::execute(
            'db.events.distinct("city", {country: "'.$country.'"})'
        );
        $cities = $result['retval'];
        return sort($cities) ? $cities : array();
    }
    /**
     *
     */
    public static function getEventsByAjax($start, $length, $draw, $search, $order)
    {

        $conditions = array(
            'conditions' => array(
                'approval' => true,
                'end_date' => array(
                    '$gt' => time()
                )
            ),
            'sort' => array(
                'start_date' => -1
            )
        );

        if (isset($search['value']) && !empty($search['value'])) {
                $regex = new MongoRegex("/".$search['value']."/i");
                $conditions = array_merge_recursive($conditions,
                    array('conditions' => array('event_name' => $regex)));
        }

        if (isset($order) && !empty($order)) {
            $column= $order[0]['column'];
            $column_dir= $order[0]['dir'];
            switch ($column) {
                case 0:
                    $column = "event_name";
                    break;
                case 1:
                    $column = "category_id";
                    break;
                case 3:
                    $column = "start_date";
                    break;
                default:
                    $column = "event_name";
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

        $events = Events::find($conditions);

        $pagination = new Paginator(array(
            'data' => $events,
            'limit'=>$length,
            'page'=> ($start / $length != 0) ?  ($start / $length + 1) : 1
        ));
        $page = $pagination->getPaginate();
        $events = $page->items;

        return $events;
    }
}