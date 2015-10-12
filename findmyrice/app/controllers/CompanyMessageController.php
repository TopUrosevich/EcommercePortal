<?php
namespace Findmyrice\Controllers;
require_once BASE_DIR . '/app/vendor/aws/aws-autoloader.php';

use Findmyrice\Models\Profile;
use Findmyrice\Forms\MessageForm;
use Findmyrice\Forms\MessageDetailForm;
use Findmyrice\Models\Users;
use Findmyrice\Models\CompanyMessages;
use Findmyrice\Models\UserMessages;
use MongoId;

use Aws\S3\S3Client;
use \Phalcon\Image\Adapter\GD as GdAdapter;
use Symfony\Component\Process\Process;
use Elasticsearch;
use Phalcon\Mvc\Model;

/**
 * Findmyrice\Controllers\CompanyMessageController
 */
class CompanyMessageController extends ControllerBase
{


    public function initialize()
    {
        $this->view->setTemplateBefore('private');
        $this->view->siteUrl = SITE_URL;
    }
    
    /**
     * Sent action, shows the sent messages
     */
    public function sentAction($userID = null, $page_num = null)
    {
        $this->assets->addJs('js/company/messages.js')
            ->addJs('js/jquery-1.6.1.min.js')
            ->addJs('js/jquery.masonry.js')
            ->addCss('css/messages.css');
        
        $this->assets->addCss("css/font-awesome.min.css");
        
        $identity = $this->session->get('auth-identity');
        $user_id = $identity['id'];
        $user_profile = $identity['profile'];
        
        if ($user_profile != 'Administrators' && $user_id != $userID) {
            $userID = $user_id;
        }
        
        $user = Users::findById($userID);
        
        if (!$user) {
            $this->flash->error("User was not found");
            return $this->dispatcher->forward(array(
                'action' => 'index'
            ));
        }
        
        
        
        try {
            
            $form = new MessageForm();
            
            $messages = CompanyMessages::findByUserIdStatus($user_id, '2');
            if ($messages) {
                foreach ($messages as $message) {
                    $messageCustom = "";
                    $messageLength = strlen($message->message);
                    if (30 <= $messageLength) {
                        $messageCustom = substr($message->message, 0, 30);
                        $messageCustom = $messageCustom . " ...";
                    } else {
                        $messageCustom = $message->message;
                    }
                    $message->message = $messageCustom;
                }
            }
            
            $messages_count = 0;            
            $messages_count = CompanyMessages::count(array(
                array(
                    "status" => '2',
                    "company_id" => $user_id
                )
            ));
            
            // Page
            $limit = 5;
            
            if ($limit != 0) {
                $m_co = (int)($messages_count/$limit);
            }
            
            $min = $messages_count - ( $limit * $m_co );
            
            if ($min > 0) {
                $m_co = $m_co + 1;
            }
            
            if ($this->dispatcher->getParam('page_num') != null ) {
                $page_num = $this->dispatcher->getParam('page_num');
            }else {
                $page_num = 1;
            }
            
            $this->view->page_num = $page_num;            
            $this->view->limit = $limit;            
            $this->view->m_co = $m_co; 
            
            $count = CompanyMessages::count(array(
                array(
                    "read" => '0',
                    "company_id" => $user_id
                )
            )); 
            
            $this->view->messages = $messages;            
            $this->view->ct = $count;            
            $this->view->m_ct = $messages_count;            
            $this->view->form = $form;
            $this->view->newMessageCount = $count;
            
        } catch (\Exception $e) {
            $this->flash->error("Message was not found.");
        }
    }
    
    /**
     * Trash Button action, show trashing message
     */
    public function trashAction($userID = null, $message_id = null, $page_up = null)
    {
        
        $this->assets->addJs('js/company/messages.js')
            ->addJs('js/jquery-1.6.1.min.js')
            ->addJs('js/jquery.masonry.js')
            ->addCss('css/messages.css');
        
        $this->assets->addCss("css/font-awesome.min.css");
        
        $identity = $this->session->get('auth-identity');
        $user_id = $identity['id'];
        $user_profile = $identity['profile'];
        
        if ($user_profile != 'Administrators' && $user_id != $userID) {
            $userID = $user_id;
        }
        
        $user = Users::findById($userID);
        
        if (!$user) {
            $this->flash->error("User was not found");
            return $this->dispatcher->forward(array(
                'action' => 'index'
            ));
        }
        
        try {           
            
            $form = new MessageForm();

            $m_ct = 0;
            $m_ct = intval($this->request->getPost('m_ct'));

            if ($m_ct != 0) {

                for ($i = 1; $i < $m_ct + 1; $i ++) {

                    if( $this->request->getPost('each_check'.$i) == 'yes' ) {

                        $message_id = $this->request->getPost('messageId'.$i);
                        $message = CompanyMessages::findByMessageId($message_id);

                        if ($message->status == '4') {

                            if ($message->delete() == false) {
                                $this->flash->error("You can't delete this message.");
                            }

                        } else { 

                            $message->status = '4';
                            $message->read = '1';

                            if ($message->save() == false) {
                                $this->flash->error("You can't trash this message.");
                            }
                        }
                    }
                }
            }
            
            $messages = CompanyMessages::findByUserIdStatus($user_id, '4');              
            
            if ($messages) {
                foreach ($messages as $message) {

                    $messageLength = strlen($message->message);

                    $messageCustom = "";

                    if (30 <= $messageLength) {
                        $messageCustom = substr($message->message, 0, 30);
                        $messageCustom = $messageCustom." ...";
                    } else {
                        $messageCustom = $message->message;
                    }

                    $message->message = $messageCustom;

                }
            }
            
            $messages_count = CompanyMessages::count(array(
                array(
                    "status" => '4',
                    "company_id" => $user_id
                )
            ));
            
            
            // Page
            $limit = 5;
            $page_num = 1;
            
            if ($limit != 0) {
                $m_co = (int)($messages_count/$limit);
            }
            
            $min = $messages_count - ( $limit * $m_co );
            
            if ($min > 0) {
                $m_co = $m_co + 1;
            }
            
            if ($this->dispatcher->getParam('page_num') != null) {
                $page_num = $this->dispatcher->getParam('page_num');
            }else {
                $page_num = 1;
            }
            
            $this->view->page_num = $page_num;            
            $this->view->limit = $limit;            
            $this->view->m_co = $m_co;
            
            
            $count = CompanyMessages::count(array(
                array(
                    "read" => '0',
                    "company_id" => $user_id
                )
            ));
            
            $this->view->messages = $messages;            
            $this->view->ct = $count;            
            $this->view->m_ct = $messages_count;            
            $this->view->form = $form;
            $this->view->newMessageCount = $count;
            
        } catch (\Exception $e) {
            $this->flash->error("Message was not found.");
        }
    }

    /**
     * Detail action, shows the message detail
     */
    public function detailAction($message_id = null)
    {
        
        
        $this->assets->addJs('js/company/messages.js')
            ->addJs('js/jquery-1.6.1.min.js')
            ->addJs('js/jquery.masonry.js')
            ->addCss('css/messages.css');
        
        $this->assets->addCss("css/font-awesome.min.css");
        
        $identity = $this->session->get('auth-identity');
        $user_id = $identity['id']; 
        
        $user = Users::findById($user_id);
        
        $message_id = $this->dispatcher->getParam('message_id');  
                
        try {
            $message = CompanyMessages::findByMessageId($message_id);
            
            if (!$message) {
                $form = new MessageDetailForm();
                $reset_inputs = false;
            } else {
                $form = new MessageDetailForm($message, array(
                    'edit' => true
                ));
            }
            
            
            if ($this->request->isPost()) {
                if ($form->isValid($this->request->getPost()) != false) {                    
                    
                    // Company message
                    $message = new CompanyMessages();
                    
                    $message->status = '2';
                    
                    $message->company_id = $user_id;
                    $message->email = $this->request->getPost('email', 'email');
                    $message->subject = $this->request->getPost('subject');
                    $message->message = $this->request->getPost('message');
                    
                    $mm = Users::findFirstByEmail($message->email);
                    
                    if ($mm) {
                        $message->name = $mm->first_name ."  ". $mm->last_name;
                    }                  
                    
                    // User message create
                    $userMessage = new UserMessages();
                    
                    $userMessage->status = '1';                    
                    if ($mm) {
                        $userMessage->user_id = $mm->_id->{'$id'};
                    }
                    $userMessage->email = $user->email;
                    $userMessage->subject = $message->subject;
                    $userMessage->message = $message->message;
                    $userMessage->name = $user->first_name ."  ". $user->last_name;
                    $userMessage->read = '0';
                    
                    // Send message
                    $from = $user->email;    // give from email address
	                $headers = "From: " . $from . "\r\n";
                      
                    if ($message->save()) {
                        
                        if ($userMessage->save()) {
                        
                            if ($this->getDI()->getMail()->sendMessage($message->email, $message->subject, 'communication', array('email' => $user->email, 'name' => $user->name, 'message' => $message->message), $headers)) {

                                $this->flash->success("Message Sending Success.");
                                return $this->dispatcher->forward(
                                    array(
                                        'controller' => 'companyMessage',
                                        'action' => 'sent'
                                    )
                                );

                            }

                            $this->flash->success("Message Sending Success.");
                            return $this->dispatcher->forward(
                                array(
                                    'controller' => 'companyMessage',
                                    'action' => 'sent'
                                )
                            );
                        }
                        
                    } else {
                        $this->flash->error("Message Sending Failed.");
                        return $this->dispatcher->forward(
                            array(
                                'controller' => 'company',
                                'action' => 'messages'
                            )
                        );
                    }
                }
            }            
            
            $message->read = '1';
            
            if ($message->update() == false) {
                $this->flash->error("You can't see this message.");
                return $this->dispatcher->forward(
                    array(
                        'controller' => 'company',
                        'action' => 'messages'
                    )
                );
            }
            
            $count = CompanyMessages::count(array(
                array(
                    "read" => '0',
                    "company_id" => $user_id
                )
            ));
            
            $this->view->ct = $count;                        
            $this->view->message = $message;            
            $this->view->form = $form;
            $this->view->newMessageCount = $count;
        } catch (\Exception $e) {
            $this->flash->error("Sending message failed!");
            return $this->dispatcher->forward(
                array(
                    'controller' => 'company',
                    'action' => 'messages'
                )
            );
        }
    }

    /**
     * Reply button action, show reply
     */    
    public function replyAction($message_id = null)
    {
        
        $this->assets->addJs('js/company/messages.js')
            ->addJs('js/jquery-1.6.1.min.js')
            ->addJs('js/jquery.masonry.js')
            ->addCss('css/messages.css');
        $this->assets->addCss("css/font-awesome.min.css");
        
        $identity = $this->session->get('auth-identity');
        $user_id = $identity['id'];
        $user_profile = $identity['profile'];
        
        $user = Users::findById($user_id);
        
        $message_id = $this->dispatcher->getParam('message_id');  
                
        try {
            $message = CompanyMessages::findByMessageId($message_id);
            
            if (!$message) {
                $form = new MessageForm();
                $reset_inputs = false;
            } else {
                $form = new MessageForm($message, array(
                    'edit' => true
                ));
            }
            
            if ($this->request->isPost()) {
                if ($form->isValid($this->request->getPost()) != false) {                      
                    
                    // Company message
                    $message = new CompanyMessages();
                    
                    $message->status = '2';
                    
                    $message->company_id = $user_id;
                    $message->email = $this->request->getPost('email', 'email');
                    $message->subject = $this->request->getPost('subject');
                    $message->message = $this->request->getPost('message');
                    
                    $mm = Users::findFirstByEmail($message->email);
                    
                    if ($mm) {
                        $message->name = $mm->first_name ."  ". $mm->last_name;
                    }                  
                    
                    // User message create
                    $userMessage = new UserMessages();
                    
                    $userMessage->status = '1';                    
                    if ($mm) {
                        $userMessage->user_id = $mm->_id->{'$id'};
                    }
                    $userMessage->email = $user->email;
                    $userMessage->subject = $message->subject;
                    $userMessage->message = $message->message;
                    $userMessage->name = $user->first_name ."  ". $user->last_name;
                    $userMessage->read = '0';
                    
                    
                    // Send message
                    $from = $user->email;    // give from email address
	                $headers = "From: " . $from . "\r\n";
                      
                    if ($message->save()) {
                        
                        if ($userMessage->save()) {
                        
                            if ($this->getDI()->getMail()->sendMessage($message->email, $message->subject, 'communication', array('email' => $user->email, 'name' => $user->name, 'message' => $message->message), $headers)) {

                                $this->flash->success("Message Sending Success.");
                                return $this->dispatcher->forward(
                                    array(
                                        'controller' => 'companyMessage',
                                        'action' => 'sent'
                                    )
                                );

                            }

                            $this->flash->success("Message Sending Success.");
                            return $this->dispatcher->forward(
                                array(
                                    'controller' => 'companyMessage',
                                    'action' => 'sent'
                                )
                            );
                            
                        }
                        
                    } else {
                        $this->flash->error("Message Sending Failed.");
                        return $this->dispatcher->forward(
                            array(
                                'controller' => 'company',
                                'action' => 'messages'
                            )
                        );
                    }
                }
            }            
            
            $count = CompanyMessages::count(array(
                array(
                    "read" => '0',
                    "company_id" => $user_id
                )
            ));
            
            $this->view->ct = $count;            
            $this->view->form = $form;            
            $this->view->message_id = $message_id;            
            $this->view->message = $message;
            $this->view->newMessageCount = $count;
        } catch (\Exception $e) {
            $this->flash->error("Sending message failed!");
            return $this->dispatcher->forward(
                array(
                    'controller' => 'company',
                    'action' => 'messages'
                )
            );
        }
    }

    /**
     * forward button action, show forward
     */    
    public function forwardAction($message_id = null)
    {
        
        $this->assets->addJs('js/company/messages.js')
            ->addJs('js/jquery-1.6.1.min.js')
            ->addJs('js/jquery.masonry.js')
            ->addCss('css/messages.css');
        
        $this->assets->addCss("css/font-awesome.min.css");
        
        $identity = $this->session->get('auth-identity');
        $user_id = $identity['id']; 
        $user_profile = $identity['profile'];
        
        $user = Users::findById($user_id);
        
        $message_id = $this->dispatcher->getParam('message_id');  
                
        try {
            $message = CompanyMessages::findByMessageId($message_id);
            
            if (!$message) {
                $form = new MessageForm();
                $reset_inputs = false;
            } else {
                $form = new MessageForm($message, array(
                    'edit' => true
                ));
            }
            
            if ($this->request->isPost()) {
                if ($form->isValid($this->request->getPost()) != false) {
                    
                    //Company message
                    $message = new CompanyMessages();
                    
                    $message->status = '2';
                    $message->company_id = $user_id;
                    $message->email = $this->request->getPost('email', 'email');
                    $message->subject = $this->request->getPost('subject', 'striptags');
                    $message->message = $this->request->getPost('message');
                    
                    $mm = Users::findFirstByEmail($message->email);
                    
                    if ($mm) {
                        $message->name = $mm->first_name ."  ". $mm->last_name;
                    }                  
                    
                    // User message create
                    $userMessage = new UserMessages();
                    
                    $userMessage->status = '1';                    
                    if ($mm) {
                        $userMessage->user_id = $mm->_id->{'$id'};
                    }
                    $userMessage->email = $user->email;
                    $userMessage->subject = $message->subject;
                    $userMessage->message = $message->message;
                    $userMessage->name = $user->first_name ."  ". $user->last_name;
                    $userMessage->read = '0';
                    
                    // Send
                    $from = $user->email;    // give from email address
	                $headers = "From: " . $from . "\r\n";
                        
                    if ($message->save()) {
                        
                        if ($userMessage->save()) {
                        
                            if ($this->getDI()->getMail()->sendMessage($message->email, $message->subject, 'communication', array('email' => $user->email, 'name' => $user->name, 'message' => $message->message), $headers)) {

                                $this->flash->success("Message Sending Success.");
                                return $this->dispatcher->forward(
                                    array(
                                        'controller' => 'companyMessage',
                                        'action' => 'sent'
                                    )
                                );

                            }

                            $this->flash->success("Message Sending Success.");
                            return $this->dispatcher->forward(
                                array(
                                    'controller' => 'companyMessage',
                                    'action' => 'sent'
                                )
                            );
                            
                        }
                        
                    } else {
                        $this->flash->error("Message Sending Failed.");
                        return $this->dispatcher->forward(
                            array(
                                'controller' => 'company',
                                'action' => 'messages'
                            )
                        );
                    }
                }
            }            
            
            $count = CompanyMessages::count(array(
                array(
                    "read" => '0',
                    "company_id" => $user_id
                )
            ));
            
            $this->view->ct = $count;            
            $this->view->form = $form;
            $this->view->newMessageCount = $count;
        } catch (\Exception $e) {
            $this->flash->error("Message was not found.");
        }
    }
    
    /**
     * Delete Button action
     */
    public function deleteAction($message_id = null)
    {
        
        $this->assets->addJs('js/company/messages.js')
            ->addJs('js/jquery-1.6.1.min.js')
            ->addJs('js/jquery.masonry.js')
            ->addCss('css/messages.css');
        
        $this->assets->addCss("css/font-awesome.min.css");
        
        $identity = $this->session->get('auth-identity');
        $user_id = $identity['id'];
        $user_profile = $identity['profile'];
        
        try {
            
            if ($this->dispatcher->getParam('message_id') != null ) {

                $message_id = $this->dispatcher->getParam('message_id');

                $message = CompanyMessages::findByMessageId($message_id);

                if ($message) {
                    if ($message->status == '4') {
                        if ($message->delete() == false) {
                            $this->flash->error("This message can't delete, try after this.");
                            
                            $ref_url = $this->request->getHTTPReferer();
                            $ref = explode('?',$ref_url);
                            $this->response->redirect($ref[0].'?delete=false');
                            
                        } else {
                            $this->flash->success("This message has deleted successfully.");
                            
                            $ref_url = $this->request->getHTTPReferer();
                            $ref = explode('?',$ref_url);
                            $this->response->redirect($ref[0].'?delete=Ok');
                            
                        }
                    } else {
                        $message->status = '4';
                        $message->read = '1';
                        if ($message->update()) {
                            $this->flash->success("This message has trashed successfully.");
                            
                            $ref_url = $this->request->getHTTPReferer();
                            $ref = explode('?',$ref_url);
                            $this->response->redirect($ref[0].'?trash=Ok');
                            
                        }
                    }
                }
            }
            $count = CompanyMessages::count(array(
                array(
                    "read" => '0',
                    "company_id" => $user_id
                )
            ));
            $this->view->newMessageCount = $count;
        } catch (\Exception $e) {
            $this->flash->error("Message was not found.");
            return $this->dispatcher->forward(
                array(
                    'controller' => 'company',
                    'action' => 'messages'
                )
            );
        }
    }
    
    /**
     * Unread message click
     */
    
    public function unreadAction($userID = null, $page_num = null) {
        
        $this->assets->addJs('js/company/messages.js')
            ->addJs('js/jquery-1.6.1.min.js')
            ->addJs('js/jquery.masonry.js')
            ->addCss('css/messages.css');
        
        $this->assets->addCss("css/font-awesome.min.css");
        
        $identity = $this->session->get('auth-identity');
        $user_id = $identity['id'];
        $user_profile = $identity['profile'];
        
        if ($user_profile != 'Administrators' && $user_id != $userID) {
            $userID = $user_id;
        }
        
        $user = Users::findById($userID);
        
        if (!$user) {
            $this->flash->error("User was not found");
            return $this->dispatcher->forward(array(
                'action' => 'index'
            ));
        }
        
        try {            
            
            
            $form = new MessageForm();
                    
            $m_ct = 0;
            $m_ct = intval($this->request->getPost('m_ct'));

            if ($m_ct != 0) {

                for ($i = 1; $i < $m_ct + 1; $i ++) {

                    if( $this->request->getPost('each_check'.$i) == 'yes' ) {

                        $message_id = $this->request->getPost('messageId'.$i);
                        $message = CompanyMessages::findByMessageId($message_id);
                        $message->read = '0';

                        if ($message->save() == false) {
                            $this->flash->error("You can't do it.");
                        }
                    }
                }
            }
            
            $messages = CompanyMessages::findByUserIdRead($user_id, '0'); 
            
            if ($messages) {
                foreach ($messages as $message) {
                    $messageLength = strlen($message->message);

                    $messageCustom = "";
                    if (30 <= $messageLength) {
                        $messageCustom = substr($message->message, 0, 30);
                        $messageCustom = $messageCustom . " ...";
                    } else {
                        $messageCustom = $message->message;
                    }
                    $message->message = $messageCustom;
                }
            }
            
            $count = 0;
            
            $count = CompanyMessages::count(array(
                array(
                    "read" => '0',
                    "company_id" => $user_id
                )
            ));
            
            // Page
            $limit = 5;            
            $page_num = 1;            
            $m_co = 0;
            
            if ($limit != 0) {
                $m_co = (int)($count/$limit);
            }
            
            $min = $count - ( $limit * $m_co );
            
            if ($min > 0) {
                $m_co = $m_co + 1;
            }
            
            if ($this->dispatcher->getParam('page_num') != null ) {
                $page_num = $this->dispatcher->getParam('page_num');
            }else {
                $page_num = 1;
            }
            
            $this->view->page_num = $page_num;            
            $this->view->limit = $limit;            
            $this->view->m_co = $m_co;            
            $this->view->messages = $messages;            
            $this->view->form = $form;            
            $this->view->ct = $count;            
            $this->view->m_ct = $count;
            $this->view->newMessageCount = $count;
        } catch (\Exception $e) {
            $this->flash->error("Message was not found.");
        }
    }

    /**
     * New button action, new message form
     */    
    public function newAction()
    {
        
        $this->assets->addJs('js/company/messages.js')
            ->addJs('js/jquery-1.6.1.min.js')
            ->addJs('js/jquery.masonry.js')
            ->addCss('css/messages.css');
        $this->assets->addCss("css/font-awesome.min.css");
        
        $identity = $this->session->get('auth-identity');
        $user_id = $identity['id'];
        $user_profile = $identity['profile'];
        
        $user = Users::findById($user_id);
                
        try {
            $message = new CompanyMessages();
            
            if (!$message) {
                $form = new MessageForm();
                $reset_inputs = false;
            } else {
                $form = new MessageForm($message, array(
                    'edit' => true
                ));
            }
            
            if ($this->request->isPost()) {
                if ($form->isValid($this->request->getPost()) != false) {
                    
                    // Company message
                    $message = new CompanyMessages();
                    
                    $message->status = '2';
                    $message->company_id = $user_id;
                    $message->email = $this->request->getPost('email', 'email');
                    $message->subject = $this->request->getPost('subject', 'striptags');
                    $message->message = $this->request->getPost('message');
                    
                    $mm = Users::findFirstByEmail($message->email);
                    
                    if ($mm) {
                        $message->name = $mm->first_name ."  ". $mm->last_name;
                    }                  
                    
                    // User message create
                    $userMessage = new UserMessages();
                    
                    $userMessage->status = '1';                    
                    if ($mm) {
                        $userMessage->user_id = $mm->_id->{'$id'};
                    }
                    $userMessage->email = $user->email;
                    $userMessage->subject = $message->subject;
                    $userMessage->message = $message->message;
                    $userMessage->name = $user->first_name ."  ". $user->last_name;
                    $userMessage->read = '0';
                    
                    // Send message
                    $from = $user->email;    // give from email address
	                $headers = "From: " . $from . "\r\n";
                      
                    if ($message->save()) {
                        
                        if ($userMessage->save()) {
                        
                            if ($this->getDI()->getMail()->sendMessage($message->email, $message->subject, 'communication', array('email' => $user->email, 'name' => $user->name, 'message' => $message->message), $headers)) {

                                $this->flash->success("Message Sending Success.");
                                return $this->dispatcher->forward(
                                    array(
                                        'controller' => 'companyMessage',
                                        'action' => 'sent'
                                    )
                                );

                            }

                            $this->flash->success("Message Sending Success.");
                            return $this->dispatcher->forward(
                                array(
                                    'controller' => 'companyMessage',
                                    'action' => 'sent'
                                )
                            );
                        }
                        
                    } else {
                        $this->flash->error("Message Sending Failed.");
                        return $this->dispatcher->forward(
                            array(
                                'controller' => 'companyMessage',
                                'action' => 'new'
                            )
                        );
                    }
                }
            }            
            
            $count = CompanyMessages::count(array(
                array(
                    "read" => '0',
                    "company_id" => $user_id
                )
            ));
            
            $this->view->ct = $count;            
            $this->view->form = $form;            
            $this->view->message = $message;
            $this->view->newMessageCount = $count;
        } catch (\Exception $e) {
            $this->flash->error("Sending message failed!");
            return $this->dispatcher->forward(
                array(
                    'controller' => 'company',
                    'action' => 'messages'
                )
            );
        }
    }

}