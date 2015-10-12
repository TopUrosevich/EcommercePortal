<?php
namespace Findmyrice\Models;


use Phalcon\Escaper;
use Phalcon\Mvc\Collection;

class RecipeComments extends Collection
{
    public function getSource()
    {
        return 'recipe_comments';
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
    public $recipe_id;

    /**
     * @var string
     */
    public $message;

    /**
     * @var int
     */
    public $created_at;

    public function beforeCreate()
    {
        $profiles = $this->getDI()->get('session')->get('auth-identity');
        $this->owner_id = $profiles['id'];
        $this->created_at = time();

        $escaper = new Escaper();
        $this->message = $escaper->escapeHtml($this->message);
    }

    public function getOwner()
    {
        if (!$this->owner_id) {
            return false;
        }

        return Users::findById($this->owner_id);
    }

    /**
     * Return recipes sorted by most comments
     * @return array
     */
    public static function findRecipes()
    {
        $rids = RecipeComments::aggregate(array(
            array(
                '$group' => array(
                    '_id' => '$recipe_id',
                    'count' => array(
                        '$sum' => 1
                    )
                )
            ),
            array(
                '$sort' => array(
                    'count' => -1
                )
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