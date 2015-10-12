<?php
namespace Findmyrice\Models;


use Phalcon\Mvc\Collection;

class RecipeRatings extends Collection
{
    public function getSource()
    {
        return 'recipe_ratings';
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
     * @var int
     */
    public $score;

    /**
     * @var int
     */
    public $created_at;

    public function beforeCreate()
    {
        $profiles = $this->getDI()->get('session')->get('auth-identity');
        $this->owner_id = $profiles['id'];
        $this->created_at = time();
    }
}