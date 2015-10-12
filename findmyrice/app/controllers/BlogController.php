<?php
namespace Findmyrice\Controllers;

use Findmyrice\Models\Articles;
use Findmyrice\Models\NewsCategories;
use Phalcon\Escaper;
use Phalcon\Mvc\View;
use Phalcon\Mvc\View\Engine\Volt;
use Phalcon\Paginator\Adapter\NativeArray as Paginator;

class BlogController extends ControllerBase
{
    public function initialize()
    {
        $this->view->setTemplateBefore('public');
    }

    public function indexAction()
    {
        $this->assets->addJs('js/blog/index.js');
        $category = $this->dispatcher->getParam('category');

        $condition = array(
            'conditions' => array(
                'publish' => true,
                'date' => array(
                    '$lt' => time()
                )
            ),
            'sort' => array(
                'date' => -1
            )
        );

        if ($category) {
            $category = NewsCategories::findByAlias($category);
            if ($category) {
                $condition = array_merge($condition,
                    array('conditions' => array('category_id' => (string) $category->_id)));
            }
        }

        $articles = Articles::find($condition);
        $articles_count = count($articles);
        //Ajax pagination
        if($this->request->isPost()){
            if($this->request->isAjax()){
                $ajax_blog_page_int = $this->request->getPost('ajax_blog_page_int');
                $ajax_category = $this->request->getPost('ajax_category');
                $ajax_conditions = array(
                    'conditions' => array(
                        'publish' => true,
                        'date' => array(
                            '$lt' => time()
                        )
                    ),
                    'sort' => array(
                        'date' => -1
                    )
                );
                if ($ajax_category) {
                    $ajax_category = NewsCategories::findByAlias($ajax_category);
                    if ($ajax_category) {
                        $ajax_conditions = array_merge($ajax_conditions,
                            array('conditions' => array('category_id' => (string) $ajax_category->_id)));
                    }
                }
                $ajax_articles = Articles::find($ajax_conditions);

                $ajax_paginator = new Paginator(array(
                    'data' => $ajax_articles,
                    'limit' => 7,
                    'page' => $ajax_blog_page_int
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
        //Ajax pagination End

        $this->_prepareNewsCategories();
        $this->_prepareTopArticles();

        $paginator = new Paginator(array(
            'data' => $articles,
            'limit' => 7,
            'page' => $this->request->get('page', 'int')
        ));

        $page = $paginator->getPaginate();

        $this->view->setVars(array(
            'page' => $page,
            'articles_count'=>$articles_count
        ));
    }

    /**
     * Show article by category and article aliases
     */
    public function articleAction()
    {
        $this->assets->addCss("css/font-awesome.min.css");
        $category = $this->dispatcher->getParam('category');
        $article = $this->dispatcher->getParam('article');

        $category = NewsCategories::findByAlias($category);
        $article = Articles::findFirst(array(
            array(
                'category_id' => (string) $category->_id,
                'alias' => $article
            )
        ));
		$article->save();

        $this->_prepareNewsCategories();

        $mightLike = Articles::find(array(
            array(
                'category_id' => (string) $category->_id,
                'publish' => true,
                'date' => array(
                    '$lt' => time()
                )
            ),
            'sort' => array(
                'total_views' => -1
            ),
            'limit' => 3
        ));

        $this->view->setVars(array(
            'article' => $article,
            'mightLike' => $mightLike
        ));
    }

    private function _prepareNewsCategories()
    {
        $categories = NewsCategories::find();
        $this->view->setVar('categories', $categories);
    }

    private function _prepareTopArticles()
    {
        $articles = Articles::find(array(
            array(
                'publish' => true,
                'date' => array(
                    '$lt' => time()
                )
            ),
            'sort' => array(
                'total_views' => -1
            ),
            'limit' => 7
        ));

        $featureStories = Articles::find(array(
            array(
                'publish' => true,
                'date' => array(
                    '$lt' => time()
                )
            ),
            'sort' => array(
                'date' => -1
            ),
            'limit' => 2
        ));

        $this->view->setVars(array(
            'topArticles' => $articles,
            'featureStories' => $featureStories
        ));
    }
}