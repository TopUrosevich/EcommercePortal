<?php
namespace Findmyrice\Controllers;

/**
 * Findmyrice\Controllers\LeadController
 */
class LeadController extends ControllerBase
{
    public function initialize()
    {
        $this->view->setTemplateBefore('public');
    }

    /**
     * Default action
     */
    public function indexAction()
    {

    }

}