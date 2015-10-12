<?php
namespace Findmyrice\Models;


use Phalcon\Mvc\Collection;

class Cookbooks extends Collection
{
    public function getSource()
    {
        return 'cookbooks';
    }

    /**
     * @var \MongoId
     */
    public $_id;

    /**
     * @var string
     */
    public $owner_id;

    /**
     * @var string
     */
    public $name;

    /**
     * @var array[recipeId]
     */
    public $recipes;

    /**
     * @var int
     */
    public $created_at;

    public function beforeCreate()
    {
        $this->created_at = time();
    }

    public function beforeDelete()
    {
        $shares = ShareCookbooks::find(array(
            array(
                'cookbook_id' => (string) $this->_id
            )
        ));

        foreach ($shares as $share) {
            $share->delete();
        }
    }

    /**
     * Get all recipes from cookbook
     */
    public function getRecipes()
    {
        if (!$this->_id) {
            return false;
        }

        return Recipes::find(array(
            array(
                '_id' => array(
                    '$in' => $this->recipes
                )
            )
        ));
    }

    public function getRecipesCount()
    {
        if (!is_array($this->recipes)) {
            return 0;
        }

        return count($this->recipes);
    }

    public static function findAllMostFavourites()
    {
        $rids =  Cookbooks::aggregate(array(
            array(
                '$unwind' => '$recipes'
            ),
            array(
                '$group' => array(
                    '_id' => '$recipes',
                    'count' => array(
                        '$sum' => 1
                    )
                )
            ),
            array(
                '$sort' => array(
                    'count' => -1
                ),
            )
        ));

        // http://stackoverflow.com/questions/3142260/order-of-responses-to-mongodb-in-query
        $ids = array();
        foreach ($rids['result'] as $rid) {
            array_push($ids, array('_id' => new \MongoId($rid['_id'])));
        }

        $recipes = Recipes::find(array(
            array(
                '$or' => $ids
            )
        ));

        return $recipes;
    }
}