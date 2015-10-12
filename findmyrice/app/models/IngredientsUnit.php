<?php
namespace Findmyrice\Models;


use Phalcon\Mvc\Collection;

class IngredientsUnit extends Collection
{
    public function getSource()
    {
        return 'ingredients_unit';
    }

    /**
     * @var \MongoId
     */
    public $_id;

    /**
     * @var string
     */
    public $name;
}