<?php
namespace Findmyrice\Controllers;

use Findmyrice\Mail\Mail;
use Findmyrice\Forms\SuggestionForm;

/**
 * Findmyrice\Controllers\SuggestionController
 *
*/
class SuggestionController extends ControllerBase
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
        $this->assets->addJs('js/suggestion.js');

        $form = new SuggestionForm(null);

        if ($this->request->isPost()) {
            $mail = $this->getDI()
                ->getMail();
            if ($form->isValid($this->request->getPost()) != false) {

                try{
                    $mail->send(
                        array($this->config->mail->fromEmail => $this->config->mail->fromName),
                        'Suggestion',
                        'suggestion', array(
                            'name' => $this->request->getPost('name'),
                            'email' => $this->request->getPost('email'),
                            'message' => $this->request->getPost('message'),
                            'feedback_type'=>$this->request->getPost('feedback_type')
                        )
                    );
                    $this->flash->success('Your suggestions have been sent to administrator.');
                    $form->clear();
                }catch (Exception $e){
                    echo $e->getMessage();
                }

            }
        }
        $this->view->form = $form;
    }

}