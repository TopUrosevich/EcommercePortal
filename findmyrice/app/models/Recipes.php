<?php
namespace Findmyrice\Models;


use Phalcon\Escaper;
use Phalcon\Mvc\Collection;
use Phalcon\Validation;
use Phalcon\Validation\Message;
use Phalcon\Validation\Validator\PresenceOf;

class Recipes extends Collection
{
    public function getSource()
    {
        return 'recipes';
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
     * @var string
     */
    public $category_id;

    /**
     * @var string
     */
    public $notes;

    /**
     * @var string original photo URL
     */
    public $photo_origin;

    /**
     * @var string preview photo URL
     */
    public $photo_preview;

    /**
     * @var array[array[string qty, string unit, string ingredient]]
     */
    public $ingredients;

    /**
     * @var array[string method]
     */
    public $methods;

    /**
     * @var int
     */
    public $servings;

    /**
     * @var boolean
     */
    public $public;

    /**
     * @var string 'photo' or 'single' recipe type
     */
    public $type;

    /**
     * @var array[tag]
     */
    public $tags;

    /**
     * @var int
     */
    public $created_at;

    /**
     * @var \Phalcon\Validation\Message\Group
     */
    protected $_errorMessages;

    public function validation()
    {
        if ($this->type == 'single') {
            $escaper = new Escaper();
            $this->_errorMessages = new Validation\Message\Group();

            // Clear empty ingredients
            foreach ($this->ingredients as $key => $ingredient) {
                if (empty($ingredient['qty'])
                    && empty($ingredient['unit'])
                    && empty($ingredient['ingredient'])) {
                    unset($this->ingredients[$key]);
                }
            }
            // Clear empty method
            foreach ($this->methods as $key => $method) {
                if (empty($method)) {
                    unset($this->methods[$key]);
                }
            }

            if (!empty($this->ingredients) && is_array($this->ingredients)) {
                foreach ($this->ingredients as $key =>$ingredient) {
                    if (count($ingredient) == 3
                        && (array_key_exists('qty', $ingredient)
                            && array_key_exists('unit', $ingredient)
                            && array_key_exists('ingredient', $ingredient))) {
                        // XSS protection
                        foreach ($ingredient as $k => $val) {
                            $ingredient[$k] = $escaper->escapeHtml(strip_tags($val));
                        }

                        $this->ingredients[$key] = $ingredient;

                        // Validate data
                        $validation = new Validation();
                        foreach ($ingredient as $k => $val) {
                            $validation->add($k, new PresenceOf(array(
                                'message' => 'The '.ucfirst($k).' is required'
                            )));
                        }

                        $messages = $validation->validate($ingredient);
                        if (count($messages) != 0) {
                            foreach ($messages as $message) {
                                $this->_errorMessages->appendMessage($message);
                            }
                        }
                    }
                }
            } else {
                $this->_errorMessages->appendMessage(
                    new Validation\Message('The Ingredients is required', 'ingredients'));
            }

            if (!empty($this->methods) && is_array($this->methods)) {
                // XSS protection
                foreach ($this->methods as $key => $method) {
                    $this->methods[$key] = $escaper->escapeHtml(strip_tags($method));
                }

                // Validate data
                $validation = new Validation();
                foreach ($this->methods as $key => $method) {
                    $validation->add($key, new PresenceOf(array(
                        'message' => 'The Preparation Method is required'
                    )));
                }

                $messages = $validation->validate($this->methods);
                if (count($messages) != 0) {
                    foreach ($messages as $message) {
                        $this->_errorMessages->appendMessage($message);
                    }
                }
            } else {
                $this->_errorMessages->appendMessage(
                    new Validation\Message('The Preparation Method is required', 'methods'));
            }

            if ($this->getDI()->get('dispatcher')->getActionName() == 'add'
                && !$this->getDI()->get('request')->hasFiles()) {
                $this->_errorMessages->appendMessage(
                    new Message('The Photo is required', 'photo'));
            }

            return ($this->_errorMessages->count() == 0);
        }

        return true;
    }

    public function beforeCreate()
    {
        $profiles = $this->getDI()->get('session')->get('auth-identity');
        $this->owner_id = $profiles['id'];
        $this->created_at = time();
    }

    public function beforeSave()
    {
        $escaper = new Escaper();
        $tags = explode(',', $this->tags);
        $this->tags = array_map(function($value) use($escaper) {
            return $escaper->escapeHtml($value);
        }, $tags);
        $this->name = $escaper->escapeHtml($this->name);
    }

    public function beforeDelete()
    {
        $recipeId = (string) $this->_id;

        // remove from ratings
        $ratings = RecipeRatings::find(array(
            array(
                'recipe_id' => $recipeId
            )
        ));

        foreach ($ratings as $rating) {
            $rating->delete();
        }

        // remove from comments
        $comments = RecipeComments::find(array(
            array(
                'recipe_id' => $recipeId
            )
        ));

        foreach ($comments as $comment) {
            $comment->delete();
        }

        // remove from cookbooks
        $cookbooks = Cookbooks::find(array(
            array(
                'recipes' => $recipeId
            )
        ));

        foreach ($cookbooks as $cookbook) {
            if (is_array($cookbook->recipes)) {
                foreach ($cookbook->recipes as $key => $rid) {
                    if ($rid == $recipeId) {
                        unset($cookbook->recipes[$key]);
                    }
                }
                $cookbook->recipes = array_values($cookbook->recipes);
                $cookbook->save();
            }
        }

        // remove from share
        $shares = ShareRecipes::find(array(
            array(
                'recipe_id' => $recipeId
            )
        ));

        foreach ($shares as $share) {
            $share->delete();
        }
    }

    public function getCategory()
    {
        if (!$this->category_id) {
            return false;
        }

        return RecipeCategories::findById($this->category_id);
    }

    public function getFavoritesCount()
    {
        if (!$this->_id) {
            return 0;
        }

        return Cookbooks::count(array(
            array(
                'recipes' => (string) $this->_id
            )
        ));
    }

    public function getSharesCount()
    {
        if (!$this->_id) {
            return 0;
        }

        return ShareRecipes::count(array(
            array(
                'recipe_id' => (string) $this->_id
            )
        ));
    }

    public function getAuthor()
    {
        if (!$this->owner_id) {
            return false;
        }

        return Users::findById($this->owner_id);
    }

    public static function findMostPopularRecipes($limit = 3)
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
                '$limit' => $limit
            ),
            array(
                '$sort' => array(
                    'count' => -1
                ),
            ),
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

    public static function findAllByMostComments()
    {
        $mostComments = RecipeComments::findRecipes();

        $noComments = Recipes::find(array(
            array(
                '_id' => array(
                    '$nin' => array_map(function($value){
                        return $value->_id;
                    }, $mostComments)
                ),
                'public' => true
            )
        ));

        return array_merge($mostComments, $noComments);
    }

    public static function findAllByMostPopular()
    {
        $mostFavourites = Cookbooks::findAllMostFavourites();

        $noFavourites = Recipes::find(array(
            array(
                '_id' => array(
                    '$nin' => array_map(function($value){
                        return $value->_id;
                    }, $mostFavourites)
                ),
                'public' => true
            )
        ));

        return array_merge($mostFavourites, $noFavourites);
    }
}