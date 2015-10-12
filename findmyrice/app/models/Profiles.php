<?php
namespace Findmyrice\Models;

//use Findmyrice\Models\Permissions;
/**
 * Findmyrice\Models\Profiles
 * All the profile levels in the application. Used in conjenction with ACL lists
 */
class Profiles extends \Phalcon\Mvc\Collection
{

    public function getSource()
    {
        return "profiles";
    }
    /**
     * ID
     * @var integer
     */
    public $_id;

    /**
     * Name
     * @var string
     */
    public $name;

    public function getPermissions()
    {
        $perms = Permissions::find(array(
            array("profilesId"=>"$this->_id")
        ));
        $permissions = array();
        foreach ($perms as $permission) {
            $permissions[$permission->resource . '.' . $permission->action] = true;
        }
        return $permissions;
    }

    /**
     * Define relationships to Users and Permissions
     */
    public function initialize()
    {
//        $this->hasMany('_id', 'Findmyrice\Models\Users', 'profilesId', array(
//            'alias' => 'users',
//            'foreignKey' => array(
//                'message' => 'Profile cannot be deleted because it\'s used on Users'
//            )
//        ));
//
//        $this->hasMany('_id', 'Findmyrice\Models\Permissions', 'profilesId', array(
//            'alias' => 'permissions'
//        ));
    }

    /**
     * Find profiles by name
     * @param string $name profiles name
     * @return array
     */
    public static function findFirstByName($name)
    {
        return Profiles::findFirst(array(
            array(
                'name' => $name
            )
        ));
    }
}
