<?php

namespace Bridges\UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Bridges\MainBundle\Entity\Page;
use Bridges\MainBundle\Form\PageType;

use Bridges\MainBundle\Entity\Story;
use Bridges\MainBundle\Form\StoryType;

use Bridges\MainBundle\Entity\Photo;
use Bridges\MainBundle\Form\PhotoType;

class UserController extends Controller
{
    public function indexUserAction()
    {
        return $this->render('BridgesUserBundle:User:indexUser.html.twig');
    }

    public function pageAction($pageId = null)
    {
        $pages = $this ->getDoctrine()
                        ->getManager()
                        ->getRepository('BridgesMainBundle:Page')
                        ->findAll(['updatedAt' => 'DESC']);

        if ($pageId == null) {
            $pageAsked = $this ->getDoctrine()
                                ->getManager()
                                ->getRepository('BridgesMainBundle:Page')
                                ->findLatestOne();
            if (sizeof($pageAsked) > 0) {
                $pageAsked = $pageAsked[0];
            }
            else {
                $pageAsked = new Page;
            }
        }
        else {
            $pageAsked = $this ->getDoctrine()
                                ->getManager()
                                ->getRepository('BridgesMainBundle:Page')
                                ->find($pageId);
        }

        return $this->render('BridgesUserBundle:User:pages.html.twig', array(
            'pages' => $pages,
            'pageAsked' => $pageAsked
            ));
    }

    public function pageNewAction($pageId = null)
    {
        if ($pageId == null) {
            $page = new Page;
        }
        else {
            $page = $this ->getDoctrine()
                                ->getManager()
                                ->getRepository('BridgesMainBundle:Page')
                                ->find($pageId);
        }

        // On utiliser le OrdersType
        $formNewPage = $this->createForm(new pageType(), $page);

        // On récupère la requête
        $formNewPage->handleRequest($this->getRequest());

        // On vérifie que les valeurs entrées sont correctes
        if ($formNewPage->isValid()) {
            $page->setUpdatedAt(new \Datetime);
            $em = $this->getDoctrine()->getManager();
            $em->persist($page);
            $em->flush();

            // On redirige vers la page de visualisation de le document nouvellement créé
            return $this->redirect($this->generateUrl('bridges_user_page'));
        }

        return $this->render('BridgesUserBundle:User:newPage.html.twig', array(
            'formNewPage' => $formNewPage->createView(),
            'pageAsked' => $page
        ));
    }

    public function pageDeleteAction($pageId)
    {
        $page = $this ->getDoctrine()
                            ->getManager()
                            ->getRepository('BridgesMainBundle:Page')
                            ->find($pageId);

        if (!$page) {
            throw $this->createNotFoundException("Ningun pagina a suprimir encontrada ...");
        }

        $em = $this->getDoctrine()->getManager();
        $em->remove($page);
        $em->flush();

        // On redirige vers la page de visualisation de le document nouvellement créé
        return $this->redirect($this->generateUrl('bridges_user_page'));
    }

    public function photosAction()
    {
        $photos = $this ->getDoctrine()
                        ->getManager()
                        ->getRepository('BridgesMainBundle:Photo')
                        ->findAll();

        return $this->render('BridgesUserBundle:User:photos.html.twig', array(
            'photos' => $photos
            ));
    }

    public function photoNewAction()
    {
        $photo = new Photo;

        // On utiliser le OrdersType
        $formNewPhoto = $this->createForm(new PhotoType(), $photo);

        // On récupère la requête
        $formNewPhoto->handleRequest($this->getRequest());

        // On vérifie que les valeurs entrées sont correctes
        if ($formNewPhoto->isValid()) {
            $photo->setUpdatedAt(new \Datetime);
            $em = $this->getDoctrine()->getManager();
            $em->persist($photo);
            $em->flush();

            // On redirige vers la page de visualisation de le document nouvellement créé
            return $this->redirect($this->generateUrl('bridges_user_photos'));
        }

        return $this->render('BridgesUserBundle:User:newPhoto.html.twig', array(
            'formNewPhoto' => $formNewPhoto->createView()
        ));
    }

    public function photoDeleteAction($photoId)
    {
        $photo = $this ->getDoctrine()
                            ->getManager()
                            ->getRepository('BridgesMainBundle:Photo')
                            ->find($photoId);

        if (!$photo) {
            throw $this->createNotFoundException("Ningun foto a suprimir encontrada ...");
        }

        $em = $this->getDoctrine()->getManager();
        $em->remove($photo);
        $em->flush();

        // On redirige vers la page de visualisation de le document nouvellement créé
        return $this->redirect($this->generateUrl('bridges_user_photos'));
    }

    public function storiesAction()
    {
        $stories = $this ->getDoctrine()
                        ->getManager()
                        ->getRepository('BridgesMainBundle:Story')
                        ->findAll(['orderList' => 'ASC']);

        return $this->render('BridgesUserBundle:User:stories.html.twig', array(
            'stories' => $stories
            ));
    }

    public function storyNewAction($storyId = null)
    {
        if ($storyId == null) {
            $story = new Story;
        }
        else {
            $story = $this ->getDoctrine()
                                ->getManager()
                                ->getRepository('BridgesMainBundle:Story')
                                ->find($storyId);
        }

        // On utiliser le OrdersType
        $formNewStory = $this->createForm(new StoryType(), $story);

        // On récupère la requête
        $formNewStory->handleRequest($this->getRequest());

        // On vérifie que les valeurs entrées sont correctes
        if ($formNewStory->isValid()) {
            $story->setUpdatedAt(new \Datetime);
            $em = $this->getDoctrine()->getManager();
            $em->persist($story);
            $em->flush();

            // On redirige vers la page de visualisation de le document nouvellement créé
            return $this->redirect($this->generateUrl('bridges_user_stories'));
        }

        return $this->render('BridgesUserBundle:User:newStory.html.twig', array(
            'formNewStory' => $formNewStory->createView()
        ));
    }

    public function storyDeleteAction($storyId)
    {
        $story = $this ->getDoctrine()
                            ->getManager()
                            ->getRepository('BridgesMainBundle:Story')
                            ->find($storyId);

        if (!$story) {
            throw $this->createNotFoundException("Ningun historia a suprimir encontrada ...");
        }

        $em = $this->getDoctrine()->getManager();
        $em->remove($story);
        $em->flush();

        // On redirige vers la page de visualisation de le document nouvellement créé
        return $this->redirect($this->generateUrl('bridges_user_stories'));
    }

}
