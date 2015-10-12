<?php
namespace Findmyrice\Models;


use Phalcon\Mvc\Collection;

class Ingredients extends Collection
{
    public function getSource()
    {
        return 'ingredients';
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