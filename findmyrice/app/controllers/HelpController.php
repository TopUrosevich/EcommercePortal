<?php
namespace Findmyrice\Controllers;

use Findmyrice\Forms\HelpCategoriesForm;
use Findmyrice\Forms\HelpSearchForm;
use Findmyrice\Forms\HelpTopicsForm;
use Findmyrice\Models\HelpCategories;
use Findmyrice\Models\HelpTopics;

/**
 * HelpController
 */
class HelpController extends ControllerBase
{
    public function initialize()
    {
        $this->view->setTemplateBefore('public');
    }

    public function indexAction()
    {
        $topFAQ = HelpTopics::find(array(
            array(
                'top_faq' => true
            ),
            'sort' => array(
                'order' => 1
            )
        ));

        $this->_prepareHelpCategoriesForNavigation();

        $this->view->setVars(array(
            'topFaqTopics' => $topFAQ
        ));
    }

    public function generalAction()
    {
        $categories = HelpCategories::find(array(
            'sort' => array(
                'order' => 1
            )
        ));

        $this->_prepareHelpCategoriesForNavigation();
        $this->view->setVar('categories', $categories);
    }

    public function searchAction()
    {
        $query = $this->request->get('query');
        $form = new HelpSearchForm();
        $categories = null;

        if (!empty($query)) {
            if ($form->isValid($this->request->get())) {
                // implementation search
                $categories = false;
            }
        }

        $this->_prepareHelpCategoriesForNavigation();

        $this->view->setVars(array(
            'form' => $form,
            'categories' => $categories
        ));
    }

    public function categoryAction()
    {
        $alias = $this->dispatcher->getParam('category', 'trim');

        $category = HelpCategories::findByAlias($alias);

        if (!$category) {
            return $this->dispatcher->forward(array(
                'controller' => 'help',
                'action' => 'index'
            ));
        }

        $topics = $category->getTopics();

        $this->_prepareHelpCategoriesForNavigation();

        $this->view->setVars(array(
            'category' => $category,
            'topics' => $topics
        ));

    }

    public function manageCategoriesAction()
    {
        $identity = $this->session->get('auth-identity');
        $userProfile = $identity['profile'];

        if ($userProfile != 'Administrators') {
            $this->flash->error('You don\'t have access to this module');
            $this->dispatcher->forward(array(
                'controller' => 'help',
                'action' => 'index'
            ));
        }
        $this->assets->addJs('js/alias_generator.js');
        $this->assets->addJs('js/jquery.dataTables.min.js')
            ->addJs('js/help/manage_categories.js')
            ->addCss('css/jquery.dataTables.css');

        $form = new HelpCategoriesForm();

        if ($this->request->isPost()) {
            $category = new HelpCategories();
            $form->bind($this->request->getPost(), $category);

            if ($form->isValid()) {
                if (!$category->save()) {
                    $this->response->setStatusCode(500, 'Can\'t save category in database');
                } else {
                    $this->flash->success('Help Category was created successfully');

                    $form->initialize();
                    $form->clear();
                }
            }
        }

        $categories = HelpCategories::find(array(
            'sort' => array(
                'order' => 1
            )
        ));

        $this->view->setVars(array(
            'form' => $form,
            'categories' => $categories
        ));
    }

    public function manageCategoriesEditAction($categoryId = null)
    {
        $identity = $this->session->get('auth-identity');
        $userProfile = $identity['profile'];

        if ($userProfile != 'Administrators') {
            $this->flash->error('You don\'t have access to this module');
            $this->dispatcher->forward(array(
                'controller' => 'help',
                'action' => 'index'
            ));
        }
        $this->assets->addJs('js/alias_generator.js');
        $this->assets->addJs('js/jquery.dataTables.min.js')
            ->addJs('js/help/manage_categories.js')
            ->addCss('css/jquery.dataTables.css');
        
        $categoryId = $this->dispatcher->getParam('categoryId');  
        $category = HelpCategories::findById($categoryId);
            
        if (!$category) {
            $form = new HelpCategoriesForm();
            $reset_inputs = false;
        } else {
            $form = new HelpCategoriesForm($category, array(
                'edit' => true
            ));
        }

        if ($this->request->isPost()) {
            
            $form->bind($this->request->getPost(), $category);

            if ($form->isValid()) {
                if (!$category->update()) {
                    $this->response->setStatusCode(500, 'Can\'t update category in database');
                } else {
                    $this->flash->success('Help Category was updated successfully');
                }
            }
        }

        $categories = HelpCategories::find(array(
            'sort' => array(
                'order' => 1
            )
        ));

        $this->view->setVars(array(
            'form' => $form,
            'categories' => $categories
        ));
    }

    public function deleteCategoriesAction()
    {
        $identity = $this->session->get('auth-identity');
        $userProfile = $identity['profile'];

        if ($userProfile != 'Administrators') {
            $this->flash->error('You don\'t have access to this module');
            $this->dispatcher->forward(array(
                'controller' => 'help',
                'action' => 'index'
            ));
        }
        if ($this->request->isPost()) {
            $rmCategory = $this->request->getPost('category');

            foreach ($rmCategory as $id => $status) {
                if ($status == 'on') {
                    $category = HelpCategories::findById($id);
                    if ($category) {
                        if (!$category->deleteTopics() || !$category->delete()) {
                            $this->response->setStatusCode(500, 'Can\'t delete category from database');
                        } else {
                            $this->response->redirect('help/manage/categories');
                        }
                    }
                }
            }
        }
    }

    public function swapCategoriesOrderAction()
    {
        $identity = $this->session->get('auth-identity');
        $userProfile = $identity['profile'];

        if ($userProfile != 'Administrators') {
            $this->flash->error('You don\'t have access to this module');
            $this->dispatcher->forward(array(
                'controller' => 'help',
                'action' => 'index'
            ));
        }
        // Category id
        $cid = $this->request->get('cid');
        $move = $this->request->get('move');

        if ($move == 'up' || $move == 'down') {
            $currentCategory = HelpCategories::findById($cid);
            $nearestCategory = null;

            if ($currentCategory) {
                $nearestCategory = HelpCategories::findFirst(array(
                    array(
                        'order' => array(
                            ($move == 'up') ? '$lt' : '$gt' => $currentCategory->order
                        )
                    ),
                    'sort' => array(
                        'order' => ($move == 'up') ? -1 : 1
                    )
                ));

                if ($nearestCategory || $currentCategory->order > 1) {
                    if (!$nearestCategory) {
                        $currentCategory->order = 1;
                    } else {
                        $diff = $currentCategory->order - $nearestCategory->order;

                        if ($diff >= 2) {
                            $currentCategory->order = $currentCategory->order - $diff + 1;
                        } else {
                            $orderTmp = $nearestCategory->order;
                            $nearestCategory->order = $currentCategory->order;
                            $currentCategory->order = $orderTmp;
                        }
                    }

                    if (($nearestCategory && !$nearestCategory->save()) || !$currentCategory->save()) {
                        $this->response->setStatusCode(500, 'Can\'t swap orders in database');
                    } else {
                        $this->response->redirect('help/manage/categories');
                        $this->view->disable();
                    }
                }
            }
        }
    }

    public function manageTopicsAction()
    {
        $identity = $this->session->get('auth-identity');
        $userProfile = $identity['profile'];

        if ($userProfile != 'Administrators') {
            $this->flash->error('You don\'t have access to this module');
            $this->dispatcher->forward(array(
                'controller' => 'help',
                'action' => 'index'
            ));
        }
        $this->assets->addJs('js/alias_generator.js');
        $this->assets->addJs('js/jquery.dataTables.min.js')
            ->addJs('js/help/manage_topics.js')
            ->addCss('css/jquery.dataTables.css');

        $form = new HelpTopicsForm();

        if ($this->request->isPost()) {
            $topic = new HelpTopics();
            $form->bind($this->request->getPost(), $topic);

            if ($form->isValid()) {
                if (!$topic->save()) {
                    $this->response->setStatusCode(500, 'Can\'t save topic in database');
                } else {
                    $this->flash->success('Help Topic was created successfully');

                    $form->initialize();
                    $form->clear();
                }
            }
        }

        $categories = HelpCategories::find();
        $topics = HelpTopics::find(array(
            'sort' => array(
                'order' => 1
            )
        ));

        $this->view->setVars(array(
            'form' => $form,
            'categories' => $categories,
            'topics' => $topics
        ));
    }
    
    public function manageTopicsEditAction($topicId = null)
    {
        $identity = $this->session->get('auth-identity');
        $userProfile = $identity['profile'];

        if ($userProfile != 'Administrators') {
            $this->flash->error('You don\'t have access to this module');
            $this->dispatcher->forward(array(
                'controller' => 'help',
                'action' => 'index'
            ));
        }
        $this->assets->addJs('js/alias_generator.js');
        $this->assets->addJs('js/jquery.dataTables.min.js')
            ->addJs('js/help/manage_topics.js')
            ->addCss('css/jquery.dataTables.css');
        
        $topicId = $this->dispatcher->getParam('topicId');  
        $topic = HelpTopics::findById($topicId);
            
        if (!$topic) {
            $form = new HelpTopicsForm();
            $reset_inputs = false;
        } else {
            $form = new HelpTopicsForm($topic, array(
                'edit' => true
            ));
        }

        if ($this->request->isPost()) {
            
            $form->bind($this->request->getPost(), $topic);

            if ($form->isValid()) {
                if (!$topic->update()) {
                    $this->response->setStatusCode(500, 'Can\'t update topic in database');
                } else {
                    $this->flash->success('Help Topic was updated successfully');
                }
            }
        }

        $categories = HelpCategories::find();
        $topics = HelpTopics::find(array(
            'sort' => array(
                'order' => 1
            )
        ));

        $this->view->setVars(array(
            'form' => $form,
            'categories' => $categories,
            'topics' => $topics
        ));
    }

    public function deleteTopicsAction()
    {
        $identity = $this->session->get('auth-identity');
        $userProfile = $identity['profile'];

        if ($userProfile != 'Administrators') {
            $this->flash->error('You don\'t have access to this module');
            $this->dispatcher->forward(array(
                'controller' => 'help',
                'action' => 'index'
            ));
        }
        if ($this->request->isPost()) {
            $rmTopic = $this->request->getPost('topic');

            foreach ($rmTopic as $id => $status) {
                if ($status == 'on') {
                    $topic = HelpTopics::findById($id);
                    if ($topic) {
                        if (!$topic->delete()) {
                            $this->response->setStatusCode(500, 'Can\'t delete topic from database');
                        } else {
                            $this->response->redirect('help/manage/topics');
                        }
                    }
                }
            }
        }
    }

    public function swapTopicsOrderAction()
    {
        $identity = $this->session->get('auth-identity');
        $userProfile = $identity['profile'];

        if ($userProfile != 'Administrators') {
            $this->flash->error('You don\'t have access to this module');
            $this->dispatcher->forward(array(
                'controller' => 'help',
                'action' => 'index'
            ));
        }
        // Topic id
        $tid = $this->request->get('tid');
        $move = $this->request->get('move');

        if ($move == 'up' || $move == 'down') {
            $currentTopic = HelpTopics::findById($tid);
            $nearestTopic = null;

            if ($currentTopic) {
                $nearestTopic = HelpTopics::findFirst(array(
                    array(
                        'order' => array(
                            ($move == 'up') ? '$lt' : '$gt' => $currentTopic->order
                        )
                    ),
                    'sort' => array(
                        'order' => ($move == 'up') ? -1 : 1
                    )
                ));

                if ($nearestTopic || $currentTopic->order > 1) {
                    if (!$nearestTopic) {
                        $currentTopic->order = 1;
                    } else {
                        $diff = $currentTopic->order - $nearestTopic->order;

                        if ($diff >= 2) {
                            $currentTopic->order = $currentTopic->order - $diff + 1;
                        } else {
                            $orderTmp = $nearestTopic->order;
                            $nearestTopic->order = $currentTopic->order;
                            $currentTopic->order = $orderTmp;
                        }
                    }

                    if (($nearestTopic && !$nearestTopic->save()) || !$currentTopic->save()) {
                        $this->response->setStatusCode(500, 'Can\'t swap topics in database');
                    } else {
                        $this->response->redirect('help/manage/topics');
                        $this->view->disable();
                    }
                }
            }
        }
    }

    private function _prepareHelpCategoriesForNavigation()
    {
        $helpMenu = HelpCategories::find(array(
            array(
                'parent_id' => null
            ),
            'fields' => array(
                'title',
                'alias'
            ),
            'sort' => array(
                'order' => 1
            )
        ));

        $this->view->setVar('helpMenuCategories', $helpMenu);
    }
}