<?php
namespace Findmyrice\Models;


use Phalcon\Mvc\Collection;

class FavoritesEvents extends Collection
{
    public function getSource()
    {
        return 'favorites_events';
    }

    public $_id;
    public $event_id;
    public $user_id;
}