<?php
namespace Findmyrice\Models;


use Phalcon\Mvc\Collection;

/**
 * Category for help section
 */
class HelpCategories extends Collection
{
    public function getSource()
    {
        return 'help_categories';
    }

    /**
     *
     * @var integer
     */
    public $_id;

    /**
     *
     * @var string
     */
    public $title;

    /**
     *
     * @var integer
     */
    public $order;

    /**
     *
     * @var integer
     */
    public $parent_id;

    /**
     *
     * @var string
     */
    public $alias;

    /**
     * Get Parent Category name
     */
    public function getParent()
    {
        return  HelpCategories::findById($this->parent_id);
    }

    public function beforeCreate()
    {
        $lastOrder = HelpCategories::findFirst(array(
            'sort' =>array('order' => -1)
        ));

        $this->order = !$lastOrder ? 1 : $lastOrder->order + 1;
        $this->parent_id = !empty($this->parent_id) ? $this->parent_id : null;
    }

    /**
     * Find categories without parent category for select in form
     * @return array
     */
    public static function findForSelect()
    {
        $categories = HelpCategories::find(array(
            array('parent_id' => null),
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
        return HelpCategories::findFirst(array(
            array(
                'alias' => $alias
            )
        ));
    }

    public function getTopics()
    {
        if (!$this->_id) {
            return null;
        }

        $topics = HelpTopics::find(array(
            array(
                'category_id' => (string) $this->_id
            ),
            'sort' => array(
                'order' => 1
            )
        ));

        return $topics;
    }

    public function deleteTopics()
    {
        if (!$this->_id) {
            return false;
        }

        $topics = HelpTopics::find(array(
            array(
                'category_id' => (string) $this->_id
            )
        ));

        foreach ($topics as $topic) {
            $topic->delete();
        }

        return true;
    }

    public function getTopicsCount()
    {
        $topics = $this->getTopics();

        if (!empty($topics) && is_array($topics)) {
            return count($topics);
        }

        return 0;
    }

}