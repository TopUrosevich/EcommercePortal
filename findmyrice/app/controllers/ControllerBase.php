<?php
namespace Findmyrice\Controllers;

use Phalcon\Mvc\Controller;
use Phalcon\Mvc\Dispatcher;
use Findmyrice\Forms\LoginForm;

/**
 * ControllerBase
 * This is the base controller for all controllers in the application
 */
class ControllerBase extends Controller
{
    /**
     * Execute before the router so we can determine if this is a provate controller, and must be authenticated, or a
     * public controller that is open to all.
     *
     * @param Dispatcher $dispatcher
     * @return boolean
     */
    public function beforeExecuteRoute(Dispatcher $dispatcher)
    {
        $login_form = new LoginForm();
        $this->view->login_form = $login_form;
        $this->view->csrf_form = $this->security->getSessionToken();

        $this->view->setVar('logged_in', is_array($this->auth->getIdentity()));

        $controllerName = $dispatcher->getControllerName();

        // Only check permissions on private controllers
        if ($this->acl->isPrivate($controllerName)) {

            // Get the current identity
            $identity = $this->auth->getIdentity();

            // If there is no identity available the user is redirected to index/index
            if (!is_array($identity)) {

                $this->flash->notice('You don\'t have access to this module: private');

                $dispatcher->forward(array(
                    'controller' => 'index',
                    'action' => 'index'
                ));
                return false;
            }

            // Check if the user have permission to the current option
            $actionName = $dispatcher->getActionName();
            if (!$this->acl->isAllowed($identity['profile'], $controllerName, $actionName)) {

                $this->flash->notice('You don\'t have access to this module: ' . $controllerName . ':' . $actionName);

                if ($this->acl->isAllowed($identity['profile'], $controllerName, 'index')) {
                    $dispatcher->forward(array(
                        'controller' => $controllerName,
                        'action' => 'index'
                    ));
                } else {
                    $dispatcher->forward(array(
                        'controller' => 'user_control',
                        'action' => 'index'
                    ));
                }

                return false;
            }
        }
    }

    public function afterExecuteRoute()
    {
        $identity = $this->session->get('auth-identity');
        $profileRole = 'RO';
        $this->view->profileName = '';
        if(isset($identity['profile']) && !empty($identity['profile'])){

            switch ($identity['profile']) {
                case 'Read-Only':
                    $profileRole = 'RO';
                    break;
                case 'Users':
                    $profileRole = 'U';
                    break;
                case 'Companies':
                    $profileRole = 'C';
                    break;
                case 'Administrators':
                    $profileRole = 'A';
                    break;
                case 'News-Contributors':
                    $profileRole = 'NC';
                    break;

                default:
                    $profileRole = 'RO';
            }
            $this->view->profileName = $identity['name'];
        }
        $this->view->profileRole = $profileRole;
    }
}
