<?php
namespace Findmyrice\Controllers;

/**
 * Findmyrice\Controllers\MembershipController
 */
class MembershipController extends ControllerBase
{
    public function initialize()
    {
        $this->view->setTemplateBefore('public');
    }

    /**
     * Default action, shows the search form
     */
    public function indexAction()
    {
        $this->assets->addCss('css/tooltip.min.css');
        $this->assets->addCss('css/font-awesome.min.css');
        $this->assets->addJs('js/tooltip.min.js');
        $this->assets->addJs('js/membership/main.js');
    }

}