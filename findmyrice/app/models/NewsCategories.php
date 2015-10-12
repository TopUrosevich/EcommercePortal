<?php
namespace Findmyrice\Models;


use Phalcon\Mvc\Collection;

class NewsCategories extends Collection
{
    public function getSource()
    {
        return 'news_categories';
    }

    /**
     * @var integer
     */
    public $_id;

    /**
     * @var string
     */
    public $title;

    /**
     * @var string
     */
    public $alias;

    public function beforeDelete()
    {
        $articles = Articles::find(array(
            array(
                'category_id' => (string) $this->_id
            )
        ));

        foreach ($articles as $article) {
            if (!$article->delete()) {
                return false;
            }
        }
    }

    public static function findForSelect()
    {
        $categories = NewsCategories::find(array(
            'fields' => array(
                '_id',
                'title'
            )
        ));

        $array = array();

        foreach ($categories as $category) {
            $array[(string) $category['_id']] = $category['title'];
        }

        return $array;
    }

    public static function findByAlias($alias)
    {
        return NewsCategories::findFirst(array(
            array(
                'alias' => $alias
            )
        ));
    }
}