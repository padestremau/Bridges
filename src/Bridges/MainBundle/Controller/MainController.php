<?php

namespace Bridges\MainBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class MainController extends Controller
{
    public function indexMainAction()
    {
        return $this->render('BridgesMainBundle:Main:indexMain.html.twig');
    }

    public function newsletterEmailAction()
    {
        $allMails = $this ->getDoctrine()
                                ->getManager()
                                ->getRepository('LBFMainBundle:NewsletterEmail')
                                ->findAll();

        $newsletterEmail = new NewsletterEmail;
        $email = stripslashes($_POST['newsletterEmail']);
        $type = stripslashes($_POST['newsletterType']);
        $newsletterEmail->setEmail($email);
        $newsletterEmail->setCategory($type);

        $decision = 'YES';
        for ($i=0; $i < sizeof($allMails); $i++) { 
            if ($allMails[$i]->getEmail() == $email) {
                $decision = 'NO';
            }
        }
        if ($decision == 'YES') {
            $em = $this->getDoctrine()->getManager();
            $em->persist($newsletterEmail);
            $em->flush();

            // Message for manager/admin
            $message = \Swift_Message::newInstance()
                ->setContentType('text/html')
                ->setSubject('[Le Buffet Francés] ')
                ->setFrom(array('antoine@lebuffetfrances.com' => 'Le Buffet Francés'))
                ->setTo($email)
                ->setBody(
                    $this->renderView('LBFAdminBundle:Admin:emailNewsletterClient.html.twig',
                        array(  
                            'emailClient' => $email
                            )
                    )
                )
            ;

            $this->get('mailer')->send($message);
        }

        return $this->render('LBFMainBundle:Main:thankYouNewsletterEmail.html.twig');
    }

    public function newsletterEmailUndoAction($email)
    {
        $allMails = $this ->getDoctrine()
                                ->getManager()
                                ->getRepository('LBFMainBundle:NewsletterEmail')
                                ->findAll();

        $newsletterEmail = new NewsletterEmail;
        for ($i=0; $i < sizeof($allMails); $i++) { 
            if ($allMails[$i]->getEmail() == $email) {
                $newsletterEmail = $allMails[$i];
                break;
            }
        }

        if ($newsletterEmail->getEmail()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($newsletterEmail);
            $em->flush();
        }

        return $this->render('LBFMainBundle:Main:confirmQuitNewsletterEmail.html.twig', array(
            'emailQuit' => $email
            ));
    }

    public function addToCartAction()
    {

        $request = Request::createFromGlobals();
        $cart = json_decode($request->cookies->get('sessionCart'), true);
        // $response->headers->setCookie(new Cookie('foo', 'bar'));

        // Système de session pour éviter de créer des comptes.
        $session = $this->getRequest()->getSession();
        $sessionCart = $session->get('cart');
        if ($session and $sessionCart) {
            // Si oui, On continue
        }
        else {
            // Sinon, On crée d'abord la session
            $IP_user = $this->container->get('request')->getClientIp();
            $session->set('IP', $IP_user);
            $session->set('cart',array());

            $sessionCart = array();
        }

        // On vérifie que l'élément est bien un produit proposé
        $allProducts = $this ->getDoctrine()
                            ->getManager()
                            ->getRepository('LBFMainBundle:Element')
                            ->findBy(['active' => array('active', 'new')]);

        for ($i=0; $i < sizeof($cart); $i++) { 
            $single_el = $cart[$i];
            for ($j=0; $j < sizeof($allProducts); $j++) { 
                $typeAvailable = $allProducts[$j];
                if ($typeAvailable->getType() == $single_el['type']) {
                    for ($k=0; $k < sizeof($sessionCart); $k++) { 
                        if ($sessionCart[$k]['item'] == $typeAvailable) {
                            $new_qty = $single_el['qty'] + $sessionCart[$i]['qty'];
                            $sessionCart[$i] = array('item' => $typeAvailable, 'qty' => $new_qty);
                            break;
                        }
                    }
                    $sessionCart[$i] = array('item' => $typeAvailable, 'qty' => $single_el['qty']);
                    break;
                }
            }
        }
        $session->set('cart', $sessionCart);   

        return $this->redirect($this->generateUrl('lbf_main_cart'));
    }

    public function deleteFromCartAction ($type)
    {
        // Système de session pour éviter de créer des comptes.
        $session = $this->getRequest()->getSession();
        $sessionCart = $session->get('cart');
        if ($session and $sessionCart) {
            // Si oui, On continue
        }
        else {
            // Sinon, On crée d'abord la session
            $IP_user = $this->container->get('request')->getClientIp();
            $session->set('IP', $IP_user);
            $session->set('cart',array());

            $sessionCart = array();
        }

        for ($i=0; $i < sizeof($sessionCart); $i++) { 
            $cart_el = $sessionCart[$i];
            if ($cart_el['item']->getType() == $type) {
                array_splice($sessionCart, $i, 1);
                break;
            }
        }
        $session->set('cart', $sessionCart);   

        return $this->redirect($this->generateUrl('lbf_main_cart'));   
    }

    public function myCartAction()
    {
        // Système de session pour éviter de créer des comptes.
        $session = $this->getRequest()->getSession();
        $cart = $session->get('cart');
        if ($session and $cart) {
            // Si oui, On continue
        }
        else {
            // Sinon, On crée d'abord la session
            $IP_user = $this->container->get('request')->getClientIp();
            $session->set('IP', $IP_user);
            $session->set('cart',array());
        }

        return $this->render('LBFMainBundle:Main:cart.html.twig');
    }

    public function emptyCartAction()
    {
        // Système de session pour éviter de créer des comptes.
        $session = $this->getRequest()->getSession();
        if ($session) {
            $session->clear('cart');
        }

        return $this->redirect($this->generateUrl('lbf_main_homepage'));
    }

    public function orderAction() 
    {

        /* Current User */
        $currentUser = $this->getUser();

        // Système de session pour éviter de créer des comptes.
        $session = $this->getRequest()->getSession();
        $cart = $session->get('cart');

        $newOrder = new Orders();
        $newOrder->setUser($currentUser);
        $newOrder->setElements($cart);
        $newOrder->setDeliveryAt(new \DateTime());

        // On utiliser le OrdersType
        $formNewOrder = $this->createForm(new OrdersType(), $newOrder);

        // On récupère la requête
        $formNewOrder->handleRequest($this->getRequest());

        // On vérifie que les valeurs entrées sont correctes
        if ($formNewOrder->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($newOrder);
            $em->flush();

            // Message for client
            $message = \Swift_Message::newInstance()
                ->setContentType('text/html')
                ->setSubject('[Le Buffet Francés]')
                ->setFrom(array('antoine@lebuffetfrances.com' => 'Le Buffet Francés'))
                ->setTo($currentUser->getEmail())
                ->setBody(
                    $this->renderView('LBFUserBundle:User:emailConfirmation.html.twig',
                        array(  'newOrder' => $newOrder,
                                'member' => $currentUser)
                    )
                )
            ;

            $this->get('mailer')->send($message);


            // Message for manager/admin
            $messageAdmin = \Swift_Message::newInstance()
                ->setContentType('text/html')
                ->setSubject('[Le Buffet Francés] Nouvelle commande.')
                ->setFrom(array('antoine@lebuffetfrances.com' => 'Le Buffet Francés'))
                ->setTo('antoine@lebuffetfrances.com')
                ->setBody(
                    $this->renderView('LBFUserBundle:User:emailAdmin.html.twig',
                        array(  'newOrder' => $newOrder,
                                'member' => $currentUser)
                    )
                )
            ;

            $this->get('mailer')->send($messageAdmin);
            

            // On redirige vers la page de visualisation de le document nouvellement créé
            return $this->redirect($this->generateUrl('lbf_main_empty_special'));
        }

        return $this->render('LBFMainBundle:Main:order.html.twig', array(
            'formNewOrder' => $formNewOrder->createView(),
            'cart' => $cart
        ));
    }


    public function emptySpecialAction()
    {
        // Système de session pour éviter de créer des comptes.
        $session = $this->getRequest()->getSession();
        $session->clear('cart');

        return $this->redirect($this->generateUrl('lbf_main_confirm'));
    }

    public function confirmAction() 
    {    
        return $this->render('LBFMainBundle:Main:confirm.html.twig');
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

    public function newTestimonyAction()
    {
        $testimony = new Testimony;

        // On utiliser le OrdersType
        $formNewTestimony = $this->createForm(new TestimonyType(), $testimony);

        // On récupère la requête
        $formNewTestimony->handleRequest($this->getRequest());

        // On vérifie que les valeurs entrées sont correctes
        if ($formNewTestimony->isValid()) {

            $em = $this->getDoctrine()->getManager();
            $em->persist($testimony);
            $em->flush();
            
            $messageAdminContent = stripslashes($formNewTestimony->get('content')->getData());
            $messageAdminAuthor = stripslashes($formNewTestimony->get('author')->getData());
            $messageAdminRate = stripslashes($formNewTestimony->get('rate')->getData());

            // Message for manager/admin
            $messageAdmin = \Swift_Message::newInstance()
                ->setContentType('text/html')
                ->setSubject('[Le Buffet Francés] Nouveau commentaire.')
                ->setFrom(array('antoine@lebuffetfrances.com' => 'Le Buffet Francés'))
                ->setTo('antoine@lebuffetfrances.com')
                ->setBody(
                    $this->renderView('LBFAdminBundle:Admin:emailTestimonyAdmin.html.twig',
                        array(  
                            'messageAdminContent' => $messageAdminContent,
                            'messageAdminAuthor' => $messageAdminAuthor,
                            'messageAdminRate' => $messageAdminRate
                            )
                    )
                )
            ;

            $this->get('mailer')->send($messageAdmin);

            return $this->redirect($this->generateUrl('lbf_main_testimony_thankYou'));
            

        }
        return $this->render('LBFMainBundle:Main:newTestimony.html.twig', array(
            'formNewTestimony' => $formNewTestimony->createView()
            ));
    }

    public function thankYouTestimonyAction() 
    {
        
        return $this->render('LBFMainBundle:Main:thankYouTestimony.html.twig');
    }
}
