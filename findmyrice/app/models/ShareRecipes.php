<?php
namespace Findmyrice\Models;


use Phalcon\DI;
use Phalcon\Mvc\Collection;
use Phalcon\Mvc\Model\Validator\Email;

class ShareRecipes extends Collection
{
    public function getSource()
    {
        return 'share_recipes';
    }

    /**
     * @var \MongoId
     */
    public $_id;

    /**
     * @var string
     */
    public $recipe_id;

    /**
     * @var string
     */
    public $owner_id;

    /**
     * @var string
     */
    public $email;

    /**
     * @var boolean
     */
    public $shown;

    /**
     * @var int
     */
    public $created_at;

    public function validation()
    {
        $this->validate(new Email(array(
            'field' => 'email',
            'message' => 'The Email is not valid'
        )));

        return !$this->validationHasFailed();
    }

    public function beforeCreate()
    {
        $profiles = $this->getDI()->get('session')->get('auth-identity');
        $this->owner_id = $profiles['id'];
        $this->created_at = time();
        $this->shown = false;
    }

    public function getOwner()
    {
        if (!$this->owner_id) {
            return false;
        }

        return Users::findById($this->owner_id);
    }

    public function getRecipe()
    {
        if (!$this->recipe_id) {
            return false;
        }

        return Recipes::findById($this->recipe_id);
    }

    public static function findMyShares()
    {
        $profiles = DI::getDefault()->get('session')->get('auth-identity');

        $user = Users::findById($profiles['id']);

        return ShareRecipes::find(array(
            array(
                'email' => $user->email
            ),
            'sort' => array(
                'created_at' => -1
            )
        ));
    }
}