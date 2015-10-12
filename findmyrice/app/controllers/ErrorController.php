<?php
namespace Findmyrice\Controllers;
/**
 * ErrorController
 */
class ErrorController extends ControllerBase
{
    public function show404Action()
    {
        $this->view->setTemplateBefore('public404page');
        $this->view->error404Page = true;
        $this->response->setStatusCode(404, 'Not Found');
        $this->view->pick('404/404');
    }
}