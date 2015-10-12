<?php
namespace Findmyrice\Models;


use Phalcon\Mvc\Collection;

class EventCategories extends Collection
{
    public function getSource()
    {
        return 'event_categories';
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
        $events = Events::find(array(
            array(
                'category_id' => (string) $this->_id
            )
        ));

        foreach ($events as $event) {
            if (!$event->delete()) {
                return false;
            }
        }
    }

    public static function findForSelect()
    {
        $categories = EventCategories::find(array(
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

    public static function findForFilterSelect()
    {
        $categories = EventCategories::find(array(
            'fields' => array(
                'alias',
                'title'
            )
        ));

        $array = array();

        foreach ($categories as $category) {
            $array[(string) $category['alias']] = $category['title'];
        }

        return $array;
    }

    public static function findByAlias($alias)
    {
        return EventCategories::findFirst(array(
            array(
                'alias' => $alias
            )
        ));
    }
}