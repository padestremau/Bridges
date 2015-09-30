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

        $senderName = $_POST['senderContact'];
        $senderEmail = $_POST['emailContact'];
        $senderSubject = $_POST['subjectMail'];
        $senderContent = $_POST['corpsMail'];

        // Message for client
        $message = \Swift_Message::newInstance()
            ->setContentType('text/html')
            ->setSubject('Copy of your mail')
            ->setFrom(array('amolina@bridgestoday.com' => 'Bridges'))
            ->setTo($senderEmail)
            ->setBody(
                $this->renderView('BridgesMainBundle:Main:emailClient.html.twig',
                    array(  'senderName' => $senderName,
                            'senderSubject' => $senderSubject,
                            'senderContent' => $senderContent
                            )
                )
            )
        ;

        // Message for manager/admin
        $messageAdmin = \Swift_Message::newInstance()
            ->setContentType('text/html')
            ->setSubject('Nuevo mensaje')
            ->setFrom(array($senderEmail => $senderName))
            ->setTo('amolina@bridgestoday.com')
            // ->setTo('p.a.destremau@gmail.com')                                                // A CHANGER !!!!
            ->setBody(
                $this->renderView('BridgesMainBundle:Main:emailAdmin.html.twig',
                    array(  'senderName' => $senderName,
                            'senderEmail' => $senderEmail,
                            'senderSubject' => $senderSubject,
                            'senderContent' => $senderContent
                            )
                )
            )
        ;

        $this->get('mailer')->send($message);
        $this->get('mailer')->send($messageAdmin);        

        // On redirige vers la page de visualisation de le document nouvellement créé
        return $this->redirect($this->generateUrl('bridges_main_footer_contact_thankYou'));
    }

    public function footerContactThankYouAction() 
    {
        
        return $this->render('BridgesMainBundle:Main:contactThankYou.html.twig');
    }

}
