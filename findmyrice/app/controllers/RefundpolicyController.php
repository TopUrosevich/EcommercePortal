<?php
namespace Findmyrice\Controllers;

/**
 * Display the terms and conditions page.
 */
class RefundpolicyController extends ControllerBase
{

    /**
     * Default action. Set the public layout (layouts/public.volt)
     */
    public function indexAction()
    {
        $this->view->setTemplateBefore('public');
    }
}
