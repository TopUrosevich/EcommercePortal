<?php
namespace Findmyrice\Controllers;

use Findmyrice\Models\Profiles;
use Findmyrice\Models\Permissions;

/**
 * View and define permissions for the various profile levels.
 */
class PermissionsController extends ControllerBase
{

    public function initialize()
    {
        $this->view->setTemplateBefore('private');
        $this->view->adminPage = true;
    }
    /**
     * View the permissions for a profile level, and change them if we have a POST.
     */
    public function indexAction()
    {
        if ($this->request->isPost()) {

            $savePermissions = $this->request->getPost('savePermissions');
            $profileId = $this->request->getPost('profileId');

            // Validate the profile
            if (isset($profileId) && !empty($profileId)) {

            $profile = Profiles::findById($this->request->getPost('profileId'));


            if ($profile) {

                if ($this->request->hasPost('permissions') && $savePermissions == 'Save') {
                    // Deletes the current permissions
                    $old_permissions = Permissions::find(array(
                        array("profilesId" => $this->request->getPost('idProfile'))
                    ));
                    foreach ($old_permissions as $old_permission) {
                        if ($old_permission->delete() == false) {
                            echo "Sorry, we can't delete the permission right now: \n";
                            foreach ($old_permission->getMessages() as $message) {
                                echo $message, "\n";
                            }
                        }
//                        else {
//                            echo "The permissions where deleted successfully!";
//                        }
                    }


                    // Save the new permissions
                    foreach ($this->request->getPost('permissions') as $permission) {
                        $parts = explode('.', $permission);
                        $permission = new Permissions();
                        $permission->profilesId = $this->request->getPost('idProfile');
                        $permission->resource = $parts[0];
                        $permission->action = $parts[1];
                        $permission->save();
                    }

                    $this->flash->success('Permissions were updated with success');
                }

                // Rebuild the ACL with
                $this->acl->rebuild();

                // Pass the current permissions to the view
                $this->view->permissions = $this->acl->getPermissions($profile);
            }

            $this->view->profile = $profile;
        }
        }

        $profiles = Profiles::find(array(array(
            "active" => "Y"
        ),
            'fields' => array(
                '_id',
                'name'
            )
        ));
        // Pass all the active profiles
        $this->view->profiles = $this->external->returnArrayForSelect($profiles);
    }
}
