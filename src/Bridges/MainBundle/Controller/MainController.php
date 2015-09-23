<?php

namespace Bridges\MainBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class MainController extends Controller
{
    public function indexMainAction()
    {
        $pages = $this ->getDoctrine()
                        ->getManager()
                        ->getRepository('BridgesMainBundle:Page')
                        ->findAll();

        $stories = $this ->getDoctrine()
                        ->getManager()
                        ->getRepository('BridgesMainBundle:Story')
                        ->findAll(['orderList' => 'ASC']);

        $photos = $this ->getDoctrine()
                        ->getManager()
                        ->getRepository('BridgesMainBundle:Photo')
                        ->findAll(['category' => 'ASC']);
        
        return $this->render('BridgesMainBundle:Main:indexMain.html.twig', array(
            'pages' => $pages,
            'stories' => $stories,
            'photos' => $photos
            ));
    }

    public function footerContactAction() 
    {

        /* Current User */
        $currentUser = $this->getUser();
        if ($currentUser) {
            $senderName = $currentUser->getFirstName();
            $senderEmail = $currentUser->getEmail();
        } else {
            $senderName = $_POST['senderContact'];
            $senderEmail = $_POST['emailContact'];
        }
        $senderSubject = $_POST['sujetMail'];
        
        $senderOrderNumber = '';
        if ($_POST['orderNumber']) {
            $senderOrderNumber = $_POST['orderNumber'];
        }

        $senderContent = $_POST['corpsMail'];

        // Message for client
        $message = \Swift_Message::newInstance()
            ->setContentType('text/html')
            ->setSubject('[Le Buffet Francés]')
            ->setFrom(array('antoine@lebuffetfrances.com' => 'Le Buffet Francés'))
            ->setTo($senderEmail)
            ->setBody(
                $this->renderView('LBFMainBundle:Main:emailContactClient.html.twig',
                    array(  'senderName' => $senderName,
                            'senderSubject' => $senderSubject,
                            'senderOrderNumber' => $senderOrderNumber,
                            'senderContent' => $senderContent
                            )
                )
            )
        ;

        // Message for manager/admin
        $messageAdmin = \Swift_Message::newInstance()
            ->setContentType('text/html')
            ->setSubject('[Le Buffet Francés] Nouveau message.')
            ->setFrom(array('antoine@lebuffetfrances.com' => 'Le Buffet Francés'))
            ->setTo('antoine@lebuffetfrances.com')
            ->setBody(
                $this->renderView('LBFMainBundle:Main:emailContactAdmin.html.twig',
                    array(  'senderName' => $senderName,
                            'senderEmail' => $senderEmail,
                            'senderSubject' => $senderSubject,
                            'senderOrderNumber' => $senderOrderNumber,
                            'senderContent' => $senderContent
                            )
                )
            )
        ;

        $this->get('mailer')->send($message);
        $this->get('mailer')->send($messageAdmin);        

        // On redirige vers la page de visualisation de le document nouvellement créé
        return $this->redirect($this->generateUrl('lbf_main_footer_contact_thankYou'));
    }

    public function footerContactThankYouAction() 
    {
        
        return $this->render('LBFMainBundle:Main:contactThankYou.html.twig');
    }

}
