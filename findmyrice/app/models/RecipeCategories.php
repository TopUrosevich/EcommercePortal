<?php
namespace Findmyrice\Models;


use Phalcon\Mvc\Collection;

class RecipeCategories extends Collection
{
    public function getSource()
    {
        return 'recipe_categories';
    }

    public $_id;
    public $title;
    public $alias;

    public static function findForSelect()
    {
        $categories = RecipeCategories::find(array(
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
}