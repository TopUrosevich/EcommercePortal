<?php
namespace Findmyrice\Controllers;

use Findmyrice\Forms\HomePageForm;
/**
 * Display the default index page.
 */
class IndexController extends ControllerBase
{

    public function initialize()
    {
        $this->view->setTemplateBefore('public');
    }
    /**
     * Default action. Set the public layout (layouts/public.volt)
     */
    public function indexAction()
    {
        $this->assets
            ->addJs('js/jquery-ui.min.js')
            ->addJs('js/home-page/home.js')
            ->addCss('css/jquery-ui.min.css');
        $form = new HomePageForm();
        $this->view->form = $form;
        $this->view->setVar('logged_in', is_array($this->auth->getIdentity()));
    }
}
