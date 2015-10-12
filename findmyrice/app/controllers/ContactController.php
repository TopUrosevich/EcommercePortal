<?php
namespace Findmyrice\Controllers;

use Aws\CloudFront\Exception\Exception;
use Phalcon\Tag;
use Findmyrice\Forms\ContactForm;
use Findmyrice\Models\ContactUs;
use Findmyrice\Mail\Mail;

/**
 * Findmyrice\Controllers\UsersController
 * CRUD to manage users
 */
class ContactController extends ControllerBase
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
        $form = new ContactForm(null);

        if ($this->request->isPost()) {
            $mail = $this->getDI()
                ->getMail();
            if ($form->isValid($this->request->getPost()) != false) {

                try{
                    $mail->send(
                        array($this->config->mail->fromEmail => $this->config->mail->fromName),
                        'Contact Us',
                        'contact-us', array(
                            'name' => $this->request->getPost('name'),
                            'email' => $this->request->getPost('email'),
                            'message' => $this->request->getPost('message')
                        )
                    );
                    $this->flash->success('Your message have been sent to administrator.');
                    $form->clear();
                }catch (Exception $e){
                    echo $e->getMessage();
                }

            }
        }
        $this->view->form = $form;
    }

}