<?php
namespace Findmyrice\Mail;

require_once __DIR__ . '/../../vendor/swiftmailer/lib/swift_required.php';
//require __DIR__ . '/../../vendor/aws/aws-autoloader.php';
//use Aws\Ses\SesClient;
//use Aws\Sts\StsClient;
//use Aws\S3\S3Client;
//use Aws\Ses\SesClient as AmazonSES;
use Phalcon\Mvc\User\Component;
use Swift_Message as Message;
use Swift_SmtpTransport as Smtp;
use Phalcon\Mvc\View;


/**
 * Findmyrice\Mail\Mail
 * Sends e-mails based on pre-defined templates
 */
class Mail extends Component
{

    protected $transport;

    protected $amazonSes;

    protected $directSmtp = true;

    /**
     * Send a raw e-mail via AmazonSES
     *
     * @param string $raw
     */
    private function amazonSESSend($raw)
    {
//        if ($this->amazonSes == null) {
//
////            $this->amazonSes = new \AmazonSES(
////                $this->config->amazon->AWSAccessKeyId,
////                $this->config->amazon->AWSSecretKey
////            );
//
//            $this->amazonSes = SesClient::factory(array(
//                'key'    => $this->config->amazon->AWSAccessKeyId,
//                'secret' => $this->config->amazon->AWSSecretKey,
//                'region' => 'us-west-2'
//            ));
//
////            $this->amazonSes->disable_ssl_verification();
//        }
//
////Now that you have the client ready, you can build the message
//        $msg = array();
//        $msg['Source'] = "markosyanhov@gmail.com";
////ToAddresses must be an array
//        $msg['Destination']['ToAddresses'][] = "testhwemp@gmail.com";
//
//        $msg['Message']['Subject']['Data'] = "Text only subject";
//        $msg['Message']['Subject']['Charset'] = "UTF-8";
//
//        $msg['Message']['Body']['Text']['Data'] ="Text data of email";
//        $msg['Message']['Body']['Text']['Charset'] = "UTF-8";
//        $msg['Message']['Body']['Html']['Data'] ="HTML Data of email<br />";
//        $msg['Message']['Body']['Html']['Charset'] = "UTF-8";
////
//        try{
////            $msg = $raw;
//            $result =  $this->amazonSes->sendEmail($msg);
//            $result = $this->amazonSes->sendRawEmail(array(
//            'Data' => base64_encode($raw)
//        ), array(
//            'curlopts' => array(
//                CURLOPT_SSL_VERIFYHOST => 0,
//                CURLOPT_SSL_VERIFYPEER => 0
//            )
//        ));

//            //save the MessageId which can be used to track the request
//            $msg_id = $result->get('MessageId');
//            echo("MessageId: $msg_id");
//
//            //view sample output
//            print_r($result);
//        } catch (\Aws\Ses\Exception $e) {
//            //An error happened and the email did not get sent
//            echo $e->getMessage();
//        }
//
////
////        $response = $this->amazonSes->send_raw_email(array(
////            'Data' => base64_encode($raw)
////        ), array(
////            'curlopts' => array(
////                CURLOPT_SSL_VERIFYHOST => 0,
////                CURLOPT_SSL_VERIFYPEER => 0
////            )
////        ));
////
//        if (!$response->isOK()) {
//            throw new Exception('Error sending email from AWS SES: ' . $response->body->asXML());
//        }
//        if (!$result->isOK()) {
//            throw new Exception('Error sending email from AWS SES: ' . $response->body->asXML());
//        }
//
//        return true;
    }

    /**
     * Applies a template to be used in the e-mail
     *
     * @param string $name
     * @param array $params
     */
    public function getTemplate($name, $params)
    {
        $parameters = array_merge(array(
            'publicUrl' => $this->config->application->publicUrl
        ), $params);

        return $this->view->getRender('emailTemplates', $name, $parameters, function ($view) {
            $view->setRenderLevel(View::LEVEL_LAYOUT);
        });

        return $view->getContent();
    }

    /**
     * Sends e-mails via AmazonSES based on predefined templates
     *
     * @param array $to
     * @param string $subject
     * @param string $name
     * @param array $params
     */
    public function send($to, $subject, $name, $params)
    {

        // Settings
        $mailSettings = $this->config->mail;

        $template = $this->getTemplate($name, $params);

        // Create the message
        $message = Message::newInstance()
            ->setSubject($subject)
            ->setTo($to)
            ->setFrom(array(
                $mailSettings->fromEmail => $mailSettings->fromName
            ))
            ->setBody($template, 'text/html');

        if ($this->directSmtp) {

            if (!$this->transport) {
                $this->transport = Smtp::newInstance(
                    $mailSettings->smtp->server,
                    $mailSettings->smtp->port,
                    $mailSettings->smtp->security
                )
                ->setUsername($mailSettings->smtp->username)
                ->setPassword($mailSettings->smtp->password);
            }

            // Create the Mailer using your created Transport
            $mailer = \Swift_Mailer::newInstance($this->transport);

            return $mailer->send($message);
        } else {
            return $this->amazonSESSend($message->toString());
        }
    }
    
    
    // Send Message in Sending Message System
    public function sendMessage($to, $subject, $name, $param, $from)
    {
        $mailSettings = $this->config->mail;
        $template = $this->getTemplate($name, $param);
        $message = Message::newInstance()
            ->setSubject($subject)
            ->setTo($to)
            ->setFrom(array(
                $mailSettings->fromEmail => $from
            ))
            ->setBody($template, 'text/html');
        if ($this->directSmtp) {
            if (!$this->transport) {
                $this->transport = Smtp::newInstance(
                    $mailSettings->smtp->server,
                    $mailSettings->smtp->port,
                    $mailSettings->smtp->security
                )
                ->setUsername($mailSettings->smtp->username)
                ->setPassword($mailSettings->smtp->password);
            }
            $mailer = \Swift_Mailer::newInstance($this->transport);
            return $mailer->send($message);
        } else {
            return $this->amazonSESSend($message->toString());
        }
    }
}
