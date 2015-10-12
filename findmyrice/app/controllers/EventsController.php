<?php
namespace Findmyrice\Controllers;

require_once BASE_DIR . '/app/vendor/aws/aws-autoloader.php';

use Aws\S3\S3Client;
use Findmyrice\Forms\AttendEventForm;
use Findmyrice\Forms\ContactEventOrganiserForm;
use Findmyrice\Forms\EventOrganisersForm;
use Findmyrice\Forms\EventsFilterForm;
use Findmyrice\Forms\EventsForm;
use Findmyrice\Models\AttendingPeople;
use Findmyrice\Models\EventCategories;
use Findmyrice\Models\EventOrganiserMessages;
use Findmyrice\Models\EventOrganisers;
use Findmyrice\Models\Events;
use Findmyrice\Models\FavoritesEvents;
use Ivory\GoogleMap\Helper\MapHelper;
use Ivory\GoogleMap\Map;
use Ivory\GoogleMap\MapTypeId;
use Ivory\GoogleMap\Overlays\Animation;
use Ivory\GoogleMap\Overlays\Marker;
use Phalcon\Http\Request;
use Phalcon\Http\Response;
use Phalcon\Paginator\Adapter\NativeArray as Paginator;

use Geocoder\HttpAdapter\CurlHttpAdapter;
use Geocoder\Provider\GoogleMapsProvider;
use Ivory\GoogleMap\Services\Geocoding\Geocoder;

class EventsController extends ControllerBase
{
    public function initialize()
    {
        $this->view->setTemplateBefore('public');
    }

    public function indexAction()
    {
        $this->assets
            ->addJs('js/events_filter.js')
            ->addJs('js/chosen.jquery.min.js')
            ->addJs('js/events_index.js')
            ->addCss('css/chosen.min.css');

        $this->_prepareFeaturedEvents(6);

        $form = new EventsFilterForm(null, $this->dispatcher->getParams());

        $conditions = array(
            'conditions' => array(
                'approval' => true,
                'end_date' => array(
                    '$gt' => time()
                )
            ),
            'sort' => array(
                'start_date' => 1
            )
        );

        $category = $this->dispatcher->getParam('category');
        $country = $this->dispatcher->getParam('country');
        $city = $this->dispatcher->getParam('city');

        if ($category) {
            $category = EventCategories::findByAlias($category);
            if ($category) {
                $conditions = array_merge_recursive($conditions,
                    array('conditions' => array('category_id' => (string) $category->_id)));
            }
        }
        if ($country) {
            $conditions = array_merge_recursive($conditions,
                array('conditions' => array('country' => ucwords($country))));

            if ($city) {
                $conditions = array_merge_recursive($conditions,
                    array('conditions' => array('city' => ucwords($city))));
            }
        }

        $events = Events::find($conditions);
        $events_count = count($events);

        if($this->request->isPost()){
            if($this->request->isAjax()){

                $ajax_page_int = $this->request->getPost('ajax_page_int');
                $ajax_category = $this->request->getPost('ajax_category');
                $ajax_country = $this->request->getPost('ajax_country');
                $ajax_city = $this->request->getPost('ajax_city');

                $ajax_conditions = array(
                    'conditions' => array(
                        'approval' => true,
                        'end_date' => array(
                            '$gt' => time()
                        )
                    ),
                    'sort' => array(
                        'start_date' => 1
                    )
                );

                if ($ajax_category) {
                    $ajax_category = EventCategories::findByAlias($ajax_category);
                    if ($ajax_category) {
                        $ajax_conditions = array_merge_recursive($ajax_conditions,
                            array('conditions' => array('category_id' => (string) $ajax_category->_id)));
                    }
                }
                if ($ajax_country) {
                    $ajax_conditions = array_merge_recursive($ajax_conditions,
                        array('conditions' => array('country' => ucwords($ajax_country))));

                    if ($ajax_city) {
                        $ajax_conditions = array_merge_recursive($ajax_conditions,
                            array('conditions' => array('city' => ucwords($ajax_city))));
                    }
                }

                $ajax_events = Events::find($ajax_conditions);

                $ajax_paginator = new Paginator(array(
                    'data' => $ajax_events,
                    'limit' => 21,
                    'page' => $ajax_page_int
                ));

                $ajax_page = $ajax_paginator->getPaginate();

                $items = array();
                foreach($ajax_page->items as $key=>$item){
                    $category = $item->getCategory();
                    $item = (array)$item;
                    $item['category']['title'] = $category->title;
                    $item['category']['alias'] = $category->alias;
                    $items[$key] = $item;
                }
                echo json_encode($items);
                exit;
            }
        }

        $paginator = new Paginator(array(
            'data' => $events,
            'limit' => 21
        ));

        $page = $paginator->getPaginate();

        $this->view->setVars(array(
            'form' => $form,
            'page' => $page,
            'events_count'=>$events_count
        ));
    }

    public function eventAction()
    {
        $this->assets
            ->addJs('js/send_email.js')
            ->addJs('js/events_add_to_calendar.js')
            ->addJs('js/jquery-ui.min.js')
            ->addJs('js/jeoquery.js')
            ->addJs('js/events_city_autocomplete.js')
            ->addJs('js/events_like.js')
            ->addJs('js/events_contact_organiser.js');
        $this->assets
            ->addCss('css/atc-style-menu-wb.css')
            ->addCss('css/atc-style-button-icon.css')
            ->addCss('css/jquery-ui.css')
            ->addCss('css/font-awesome.min.css');

        $category = $this->dispatcher->getParam('category');
//        $event = $this->dispatcher->getParam('event');
        $event_id = $this->dispatcher->getParam('event');

        $category = EventCategories::findByAlias($category);
//        $event = Events::findFirst(array(
//            array(
//                'alias' => $event,
//                'category_id' => (string) $category->_id
//            )
//        ));
        try{
            $event = Events::findById($event_id);
        }catch (\Exception $e_event){
            $this->flash->error('The invalid event...');
            $this->dispatcher->forward(array(
                'controller' => 'events',
                'action' => 'index'
            ));
            return;
        }

        if($event->lat == 0 && $event->lon == 0){
            try {
                $address = $event->venue . ', ' . $event->street_address . ', ' . $event->city . ', ' . $event->country;

                $geocoder = new Geocoder();
                $provider = new GoogleMapsProvider(new CurlHttpAdapter(), null, null, true,
                    $this->getDI()->get('config')->googleMaps->serverApiKey);
                $geocoder->registerProvider($provider);
                $result = $geocoder->geocode($address);

                $event->lat = $result->getLatitude();
                $event->lon = $result->getLongitude();
                $event->save();
            } catch (\Exception $e) {
//                $event->lat = 0;
//                $event->lon = 0;
            }
        }
        if(!isset($event->timezone) || empty($event->timezone)){
            try {
                $event->timezone = $this->external->get_nearest_timezone($event->lat,$event->lon);
                $event->save();
            } catch (\Exception $e) {

            }
        }

        $relatedEvents = Events::find(array(
            array(
                'category_id' => $event->category_id,
                'approval' => true,
                'end_date' => array(
                    '$gt' => time()
                )
            ),
            'sort' => array(
                'start_date' => 1
            ),
            'limit' => 4
        ));

        $moreEvents = Events::find(array(
            array(
                'approval' => true,
                'end_date' => array(
                    '$gt' => time()
                ),
                'city' => $event->city
            ),
            'sort' => array(
                'start_date' => 1
            ),
            'limit' => 4
        ));

        $contactForm = new ContactEventOrganiserForm();
        $attendFrom = new AttendEventForm();

        $this->_prepareFeaturedEvents(3);
        $this->_prepareMap($event->lat, $event->lon);

        $this->_prepareFlashMessages();

        $this->view->setVars(array(
            'category' => $category,
            'event' => $event,
            'relatedEvents' => $relatedEvents,
            'moreEvents' => $moreEvents,
            'contactForm' => $contactForm,
            'attendForm' => $attendFrom
        ));
    }

    public function contactOrganiserAction()
    {
        if ($this->request->isPost()) {
            $form = new ContactEventOrganiserForm();
            $organiserMessages = new EventOrganiserMessages();
            $form->bind($this->request->getPost(), $organiserMessages);

            if ($form->isValid()) {
                if (!$organiserMessages->save()) {
                    $this->response->setStatusCode(500, 'Can\'t save organiser message in database');
                } else {
                    $this->response->redirect($this->request->getHTTPReferer().'?message=ok');
                }
            } else {
                $this->response->redirect($this->request->getHTTPReferer().'?message=error');
            }
        }
    }

    public function attendAction()
    {
        if ($this->request->isPost()) {
            $form = new AttendEventForm();
            $attendingPeople = new AttendingPeople();
            $form->bind($this->request->getPost(), $attendingPeople);

            $attended = AttendingPeople::findFirst(array(
                array(
                    'event_id' => $attendingPeople->event_id,
                    'email' => $attendingPeople->email
                )
            ));

            if ($form->isValid() && !$attended) {
                if (!$attendingPeople->save()) {
                    $this->response->setStatusCode(500, 'Can\'t save attending people in database');
                } else {
                    $this->response->redirect($this->request->getHTTPReferer().'?attend=ok');
                }
            } else {
                $this->response->redirect($this->request->getHTTPReferer().'?attend=error');
            }
        }
    }

    public function submitAction()
    {
        $this->view->setTemplateBefore('private');

        $identity = $this->session->get('auth-identity');
        $userProfile = $identity['profile'];

        if (!($userProfile == 'Users' || $userProfile == 'Administrators')) {
            $this->dispatcher->forward(array(
                'controller' => 'session',
                'action' => 'login'
            ));
        }

        $this->assets
            ->addJs('js/alias_generator.js')
            ->addJs('js/image_uploader.js')
            ->addJs('js/jquery-ui.min.js')
            ->addJs('js/jeoquery.js')
            ->addJs('js/events_organiser_city_autocomplete.js');
        $this->assets->addCss('css/jquery-ui.css');

        $eventOrganisersForm = new EventOrganisersForm();
        $eventsForm = new EventsForm(null, array('submit' => true));

        if ($this->request->isPost()) {
            $organiser = new EventOrganisers();
            $event = new Events();

            $eventOrganisersForm->bind($this->request->getPost(), $organiser);

            if ($eventOrganisersForm->isValid()) {
                if ($organiser->save()) {
                    $event->organiser_id = (string) $organiser->_id;
                    $event->approval = (boolean) $this->request->getPost('approval');
                    $eventsForm->bind($this->request->getPost(), $event);

                    if ($eventsForm->isValid()) {
                        $images = $this->_saveUploadedImage((string) new \MongoId());
                        $event->image_origin = $images['image_origin'];
                        $event->image_preview = $images['image_preview'];

                        $event->save();

                        $this->flash->success('Event was submitted successfully');
                    } else {
                        $organiser->delete();
                    }
                }
            }
        }

        $this->view->setVars(array(
            'organisersForm' => $eventOrganisersForm,
            'eventsForm' => $eventsForm
        ));
    }

    /**
     * Like event using AJAX
     */
    public function likeAjaxAction()
    {
        $this->view->disable();

        $response = new Response();

        $identity = $this->session->get('auth-identity');
        $userProfile = $identity['profile'];
        $userId = $identity['id'];
        $eventId = $this->request->get('id', 'string');

        if (!($userProfile == 'Users' || $userProfile == 'Administrators')) {
            $response->setHeader('Redirect', '/session/login');
            $response->setStatusCode(401, 'Unauthorized');
            return $response;
        }

        $event = Events::findById($eventId);

        if ($event) {
            $favoriteEvent = FavoritesEvents::findFirst(array(
                array(
                    'event_id' => $eventId,
                    'user_id' => $userId
                )
            ));

            if (!$favoriteEvent) {
                $favoriteEvent = new FavoritesEvents();
                $favoriteEvent->event_id = $eventId;
                $favoriteEvent->user_id = $userId;

                if ($favoriteEvent->save()) {
                    $response->setStatusCode(201, 'Created');
                    return $response;
                }
            }
        }

        $response->setStatusCode(400, 'Bad Request');

        return $response;
    }

    private function _prepareFeaturedEvents($limit)
    {
        $events = Events::find(array(
            array(
                'approval' => true
            ),
            'sort' => array(
                'created_at' => -1
            ),
            'limit' => $limit
        ));
        $this->view->setVar('featuredEvents', $events);
    }

    private function _prepareMap($lat, $lon)
    {
        $map = new Map();

        $map->setPrefixJavascriptVariable('map_');
        $map->setHtmlContainerId('map_canvas');

        $map->setAsync(false);
        $map->setAutoZoom(false);

        $map->setCenter($lat, $lon, true);
        $map->setMapOption('zoom', 15);

        $map->setBound(-2.1, -3.9, 2.6, 1.4, true, true);

        $map->setMapOption('mapTypeId', MapTypeId::ROADMAP);

        $map->setMapOptions(array(
            'disableDefaultUI'       => true,
            'disableDoubleClickZoom' => true,
        ));

        $map->setStylesheetOptions(array(
            'width'  => '330px',
            'height' => '300px',
        ));

        $map->setLanguage('en');

        $marker = new Marker();

        $marker->setPrefixJavascriptVariable('marker_');
        $marker->setPosition($lat, $lon, true);
        $marker->setAnimation(Animation::DROP);

        $marker->setOptions(array(
            'clickable' => false,
            'flat'      => true,
        ));

        $map->addMarker($marker);

        $mapHelper = new MapHelper();

        $this->view->setVars(array(
            'map' => $mapHelper->renderHtmlContainer($map),
            'mapJs' => $mapHelper->renderJavascripts($map),
            'mapCss' => $mapHelper->renderStylesheets($map)
        ));
    }

    private function _prepareFlashMessages()
    {
        $message = $this->request->get('message');
        if ($message == 'ok') {
            $this->flash->success('Message was sent successfully');
        } else if ($message == 'error') {
            $this->flash->error('Message was not sent');
        }

        $attend = $this->request->get('attend');
        if ($attend == 'ok') {
            $this->flash->success('You are attending a event');
        } else if ($attend == 'error') {
            $this->flash->error('You are not attending a event');
        }
    }

    /**
     * Save event images and return array with image URLs
     * @param string $id event ID
     * @return array image URL
     */
    private function _saveUploadedImage($id)
    {
        $uploads = $this->request->getUploadedFiles();
        $images = array();

        foreach ($uploads as $file) {
            $uniqueName = $file->getKey() . '-' . $id;
            $key = 'events/' . $uniqueName;

            switch ($file->getRealType()) {
                case 'image/jpeg':
                    $image = imagecreatefromjpeg($file->getRealPath());
                    break;
                case 'image/png':
                    $image = imagecreatefrompng($file->getRealPath());
                    break;
                default:
                    $image = null;
            }

            if ($image) {
                $tmp = tempnam(null, null);
                imagejpeg($image, $tmp, 75);
                imagedestroy($image);

                $client = S3Client::factory(array(
                    'key'    => $this->config->amazon->AWSAccessKeyId,
                    'secret' => $this->config->amazon->AWSSecretKey,
                    'region' => 'us-west-2'
                ));
                $bucket = 'findmyrice';

                $result = $client->putObject(array(
                    'Bucket'     => $bucket,
                    'Key'        => $key,
                    'ACL'=> 'public-read',
                    'SourceFile' => $tmp,
                    'ContentType'     => 'image/jpeg'
                ));

                unlink($tmp);

                if ($result) {
                    $images[$file->getKey()] =  $result['ObjectURL'];
                }
            }
        }
        return $images;
    }
}