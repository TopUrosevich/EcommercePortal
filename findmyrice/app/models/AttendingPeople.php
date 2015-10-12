<?php
namespace Findmyrice\Models;


use Phalcon\Escaper;
use Phalcon\Mvc\Collection;

class AttendingPeople extends Collection
{
    public function getSource()
    {
        return 'attending_people';
    }

    public $_id;
    public $event_id;
    public $name;
    public $email;
    public $city;
    public $company;

    public function beforeSave()
    {
        $e = new Escaper();
        $attributes = array(
            'name',
            'email',
            'city',
            'company'
        );

        foreach ($attributes as $attr) {
            $this->{$attr} = $e->escapeHtml($this->{$attr});
        }
    }
}