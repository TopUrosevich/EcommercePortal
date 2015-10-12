<?php
namespace Findmyrice\Controllers;

require_once BASE_DIR . '/app/vendor/aws/aws-autoloader.php';

use Aws\S3\S3Client;
use Findmyrice\Forms\EventCategoriesForm;
use Findmyrice\Forms\EventOrganisersForm;
use Findmyrice\Forms\EventsForm;
use Findmyrice\Models\EventCategories;
use Findmyrice\Models\EventOrganiserMessages;
use Findmyrice\Models\EventOrganisers;
use Findmyrice\Models\Events;
use Phalcon\Paginator\Adapter\NativeArray as Paginator;

class ManageeventsController extends ControllerBase
{
    public function initialize()
    {
        $identity = $this->session->get('auth-identity');
        $userProfile = $identity['profile'];

        if ($userProfile != 'Administrators') {
            $this->flash->error('You don\'t have access to this module');
            $this->dispatcher->forward(array(
                'controller' => 'events',
                'action' => 'index'
            ));
        }
        $this->view->setTemplateBefore('private');
        $this->view->adminPage = true;
    }

    public function categoriesAction()
    {
        $this->assets->addJs('js/alias_generator.js');

        $form = new EventCategoriesForm();

        if ($this->request->isPost()) {
            $categories = new EventCategories();
            $form->bind($this->request->getPost(), $categories);

            if ($form->isValid()) {
                if (!$categories->save()) {
                    $this->response->setStatusCode(500, 'Can\'t save category in database');
                } else {
                    $this->flash->success('News Category was created successfully');
                    $form->clear();
                }
            }
        }

        $categories = EventCategories::find();

        $this->view->setVars(array(
            'categories' => $categories,
            'form' => $form
        ));
    }

    public function deleteCategoriesAction()
    {
        if ($this->request->isPost()) {
            $rmCategory = $this->request->getPost('category');

            foreach ($rmCategory as $id => $status) {
                if ($status == 'on') {
                    $category = EventCategories::findById($id);
                    if ($category) {
                        if (!$category->delete()) {
                            $this->response->setStatusCode(500, 'Can\'t delete category from database');
                        } else {
                            $this->response->redirect('manageEvents/categories');
                        }
                    }
                }
            }
        }
    }

    public function organisersAction()
    {
        $this->assets->addJs('js/jquery.dataTables.min.js')
            ->addJs('js/manage-events-organiser.js')
            ->addCss('css/jquery.dataTables.css');

        if ($this->request->isPost()) {
            if ($this->request->hasFiles()) {
                $files = $this->request->getUploadedFiles();
                $organisers = array();
                $keys = array(
                    'organiser_name',
                    'contact_name',
                    'email',
                    'street_address',
                    'country',
                    'timezone',
                    'state',
                    'city',
                    'zip_code',
                    'country_code',
                    'area_code',
                    'phone'
                );

                $f = fopen($files[0]->getRealPath(), 'r');

                while (($data = fgetcsv($f)) !== false) {
                    $count = count($data);
                    if ($count != 12) {
                        $this->flash->success('CSV format error');
                        break;
                    }
                    $organiser = new EventOrganisers();
                    for ($i = 0; $i < $count; $i++) {
                        $organiser->{$keys[$i]} = $data[$i];
                    }
                    $organiser->save();
                    array_push($organisers, $organiser);
                }

                fclose($f);

                if (!empty($organisers)) {
                    $this->flash->success('Event Organiser was created successfully');
                }
            }
        }

        $organisers = EventOrganisers::find();


        if($this->request->isPost()){
            if($this->request->isAjax()){

                $start=$this->request->getPost('start');
                $length=$this->request->getPost('length');
                $draw= $this->request->getPost('draw');
                $search=$this->request->getPost('search');
                $order=$this->request->getPost('order');
                $columns= $this->request->getPost('columns');
                $column= $order[0]['column'];

                $total_records = count($organisers);

                $organisers = EventOrganisers::getOrganisersByAjax($start, $length, $draw, $search, $order);


                $items = array();
                foreach($organisers as $key=>$item){
                    $item = (array)$item;
                    $items[$key] = $item;
                }

                $data = array("start"=>$start, "length"=>$length,"search"=>$search,"order"=>$order,"column"=>$column,"draw"=>$draw, "recordsFiltered"=>$total_records, "recordsTotal"=>$total_records, "data"=>$items);
                echo json_encode($data);
                exit;
            }
        }


        $pagination = new Paginator(array(
            'data' => $organisers,
            'limit' => 20,
            'page' => $this->request->get('page', 'int')
        ));

        $page = $pagination->getPaginate();

        $this->view->setVars(array(
            'page' => $page
        ));
    }

    public function  createOrganiserAction()
    {
        $this->assets
            ->addJs('js/events_organiser_preview.js')
            ->addJs('js/jquery-ui.min.js')
            ->addJs('js/jeoquery.js')
            ->addJs('js/events_organiser_city_autocomplete.js');
        $this->assets->addCss('css/jquery-ui.css');

        $form = new EventOrganisersForm();

        if ($this->request->isPost()) {
            $organisers = new EventOrganisers();
            $form->bind($this->request->getPost(), $organisers);

            if ($form->isValid()) {
                if (!$organisers->save()) {
                    $this->response->setStatusCode(500, 'Can\'t save organiser in database');
                } else {
                    $this->flash->success('Organiser was created successfully');
                    $form->clear();
                }
            }
        }

        $this->view->setVar('form', $form);
    }

    public function editOrganiserAction($id)
    {
        $this->assets
            ->addJs('js/events_organiser_preview.js')
            ->addJs('js/jquery-ui.min.js')
            ->addJs('js/jeoquery.js')
            ->addJs('js/events_organiser_city_autocomplete.js');
        $this->assets->addCss('css/jquery-ui.css');

        $organiser = EventOrganisers::findById($id);

        if ($organiser) {
            $form = new EventOrganisersForm($organiser, array('edit' => true));

            if ($this->request->isPost()) {
                $form->bind($this->request->getPost(), $organiser);

                if ($form->isValid()) {
                    if (!$organiser->save()) {
                        $this->response->setStatusCode(500, 'Can\'t save organiser in database');
                    } else {
                        $this->response->redirect('manageEvents/organisers');
                    }
                }
            }

            $this->view->setVars(array(
                'form' => $form,
                'organiser' => $organiser
            ));
        } else {
            return $this->dispatcher->forward(array(
                'controller' => 'manageEvents',
                'action' => 'organisers'
            ));
        }
    }

    public function deleteOrganisersAction()
    {
        if ($this->request->isPost()) {
            $rmOrganiser = $this->request->getPost('organiser');

            foreach ($rmOrganiser as $id => $status) {
                if ($status == 'on') {
                    $organiser = EventOrganisers::findById($id);
                    if ($organiser) {
                        if (!$organiser->delete()) {
                            $this->response->setStatusCode(500, 'Can\'t delete organiser from database');
                        } else {
                            $this->response->redirect('manageEvents/organisers');
                        }
                    }
                }
            }
        }
    }

    /**
     * Contact organiser messages
     */
    public function organiserMessagesAction($id)
    {
        $messages = EventOrganiserMessages::find(array(
            array(
                'event_id' => $id
            )
        ));

        $this->view->setVar('messages', $messages);
    }

    public function deleteOrganiserMessagesAction()
    {
        if ($this->request->isPost()) {
            $rmMessage = $this->request->getPost('message');

            foreach ($rmMessage as $id => $status) {
                if ($status == 'on') {
                    $message = EventOrganiserMessages::findById($id);
                    if ($message) {
                        if (!$message->delete()) {
                            $this->response->setStatusCode(500, 'Can\'t delete message from database');
                        } else {
                            $this->response->redirect($this->request->getHTTPReferer());
                        }
                    }
                }
            }
        }
    }

    public function indexAction()
    {
        $this->assets->addJs('js/jquery.dataTables.min.js')
            ->addJs('js/manage-events-index.js')
            ->addCss('css/jquery.dataTables.css');
        if ($this->request->isPost()) {
            if ($this->request->hasFiles()) {
                $files = $this->request->getUploadedFiles();
                $events = array();
                $keys = array(
                    'event_name',
                    'venue',
                    'alias',
                    'organiser_id',
                    'category_id',
                    'start_date',
                    'end_date',
                    'enquiry_email',
                    'website',
                    'facebook',
                    'twitter',
                    'instagram',
                    'description',
                    'image_preview',
                    'image_origin',
                    'approval'
                );

                $f = fopen($files[0]->getRealPath(), 'r');

                while (($data = fgetcsv($f)) !== false) {
                    $count = count($data);
                    if ($count != 16) {
                        $this->flash->success('CSV format error');
                        break;
                    }
                    $event = new Events();
                    for ($i = 0; $i < $count; $i++) {
                        if ($i == 15) $data[15] = empty($data[15]);
                        $event->{$keys[$i]} = $data[$i];
                    }
                    $event->save();
                    array_push($events, $event);
                }


                fclose($f);

                if (!empty($events)) {
                    $this->flash->success('Event was created successfully');
                }
            }
        }

        $events = Events::find(array(
            'conditions' => array(
                'approval' => true,
                'end_date' => array(
                    '$gt' => time()
                )
            ),
            'sort' => array(
                'start_date' => 1
            )
        ));

        $pagination = new Paginator(array(
            'data' => $events,
            'limit' => count($events)
        ));


        if($this->request->isPost()){
            if($this->request->isAjax()){

                $start=$this->request->getPost('start');
                $length=$this->request->getPost('length');
                $draw= $this->request->getPost('draw');
                $search=$this->request->getPost('search');
                $order=$this->request->getPost('order');
                $columns= $this->request->getPost('columns');
                $column= $order[0]['column'];

                $total_records = count($events);

                $events = Events::getEventsByAjax($start, $length, $draw, $search, $order);

                $items = array();
                foreach($events as $key=>$item){
                    $category = $item->getCategory();
                    $item = (array)$item;
                    $item['category']['title'] = $category->title;
                    $item['category']['alias'] = $category->alias;
                    $items[$key] = $item;
                }

                $data = array("start"=>$start, "length"=>$length,"search"=>$search,"order"=>$order,"column"=>$column,"draw"=>$draw, "recordsFiltered"=>$total_records, "recordsTotal"=>$total_records, "data"=>$items);
                echo json_encode($data);
                exit;
            }
        }

        $page = $pagination->getPaginate();

        $this->view->setVars(array(
            'page' => $page
        ));
    }

    public function createAction()
    {
        $this->assets
            ->addJs('js/events_event_preview.js')
            ->addJs('js/alias_generator.js')
            ->addJs('js/image_uploader.js');

        $form = new EventsForm();

        if ($this->request->isPost()) {
            $event = new Events();
            $form->bind($this->request->getPost(), $event);

            if ($form->isValid()) {
                $event->approval = (boolean) $this->request->getPost('approval');
                if (!$event->save()) {
                    $this->response->setStatusCode(500, 'Can\'t save event in database');
                } else {
                    $images = $this->_saveUploadedImage((string) $event->_id);
                    $event->image_origin = $images['image_origin'];
                    $event->image_preview = $images['image_preview'];
                    $event->save();

                    $this->flash->success('Event was created successfully');
                    $form->clear();
                }
            }
        }

        $this->view->setVars(array(
            'form' => $form
        ));
    }

    public function editAction($id)
    {
        $this->assets
            ->addJs('js/events_event_preview.js')
            ->addJs('js/alias_generator.js')
            ->addJs('js/image_uploader.js');

        $event = Events::findById($id);

        if ($event) {
            $form = new EventsForm($event, array('edit' => true));

            if ($this->request->isPost()) {
                $form->bind($this->request->getPost(), $event);

                if ($form->isValid()) {
                    if ($this->request->hasFiles()) {
                        $images = $this->_saveUploadedImage((string) $event->_id);
                        $event->image_origin = $images['image_origin'];
                        $event->image_preview = $images['image_preview'];
                    }
                    $event->approval = (boolean) $this->request->getPost('approval');
                    if (!$event->save()) {
                        $this->response->setStatusCode(500, 'Can\'t save event in database');
                    } else {
                        $this->response->redirect('manageEvents');
                    }
                }
            }

            $this->view->setVars(array(
                'form' => $form,
                'event' => $event
            ));
        } else {
            return $this->dispatcher->forward(array(
                'controller' => 'manageEvents',
                'action' => 'index'
            ));
        }
    }

    public function deleteAction()
    {
        if ($this->request->isPost()) {
            $rmEvent = $this->request->getPost('event');

            foreach ($rmEvent as $id => $status) {
                if ($status == 'on') {
                    $event = Events::findById($id);
                    if ($event) {
                        if (!$event->delete()) {
                            $this->response->setStatusCode(500, 'Can\'t delete event from database');
                        } else {
                            $this->response->redirect('manageEvents');
                        }
                    }
                }
            }
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