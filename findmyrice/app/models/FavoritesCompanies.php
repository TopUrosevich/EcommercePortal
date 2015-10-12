<?php
namespace Findmyrice\Models;


use Phalcon\Mvc\Collection;

class FavoritesCompanies extends Collection
{
    public function getSource()
    {
        return 'favorites_companies';
    }

    public $_id;
    public $company_id;
    public $user_id;
}