<?php
namespace Findmyrice\Models;


use Phalcon\Escaper;
use Phalcon\Mvc\Collection;

class EventOrganiserMessages extends Collection
{
    public function getSource()
    {
        return 'event_organiser_messages';
    }

    public $_id;
    public $event_id;
    public $name;
    public $email;
    public $message;
    public $created_at;

    public function beforeCreate()
    {
        $this->created_at = time();
    }

    public function beforeSave()
    {
        $e = new Escaper();
        $attributes = array(
            'name',
            'email',
            'message'
        );

        foreach ($attributes as $attr) {
            $this->{$attr} = $e->escapeHtml($this->{$attr});
        }
    }
}