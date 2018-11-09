<?php

// src\TRI\PlatformBundle\Controller\AdvertController.php

namespace TRI\PlatformBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use TRI\PlatformBundle\Entity\Advert;


class AdvertController extends Controller
{

    public function indexAction($page)
    {
        if ($page < 1) {
            throw new NotFoundHttpException('Page"' . $page . '" inexistante.');
        }

        $listAdverts = array(
            array(
                'title' => 'Recherche développpeur Symfony',
                'id' => 1,
                'author' => 'Alexandre',
                'content' => 'Nous recherchons un développeur Symfony débutant sur Lyon. Blabla…',
                'date' => new \Datetime()),
            array(
                'title' => 'Mission de webmaster',
                'id' => 2,
                'author' => 'Hugo',
                'content' => 'Nous recherchons un webmaster capable de maintenir notre site internet. Blabla…',
                'date' => new \Datetime()),
            array(
                'title' => 'Offre de stage webdesigner',
                'id' => 3,
                'author' => 'Mathieu',
                'content' => 'Nous proposons un poste pour webdesigner. Blabla…',
                'date' => new \Datetime())
        );

        return $this->render('TRIPlatformBundle:Advert:index.html.twig', array(
            'listAdverts' => $listAdverts
        ));
    }


    public function viewAction($id)
    {
        $repository = $this->getDoctrine()
            ->getManager()
            ->getRepository('TRIPlatformBundle:Advert')
            ;

        $advert = $repository->find($id);

        if (null === $advert)
        {
            throw new NotFoundHttpException("L'annonce d'id ".$id. " n'existe pas");
        }
        
        return $this->render('TRIPlatformBundle:Advert:view.html.twig', array(
            'advert' => $advert
        ));
    }


    public function addAction(Request $request)
    {
        $advert = new Advert();
        $advert->setTitle("Recherche Pere Noel");
        $advert->setAuthor("Bobby");
        $advert->setContent("cherche pere noel pour le 25dec");

        $em = $this->getDoctrine()->getManager();

        $em->persist($advert);

        $em->flush();

        if ($request->isMethod('POST'))
        {
            $request->getSession()->getFlashBag()->add('notice', 'Annonce bien enregistrée.');

            return $this->redirectToRoute('tri_platform_view', array('id' => $advert->getId()));
        }

        return $this->render('TRIPlatformBundle:Advert:add.html.twig', array('advert' => $advert));
    }

    public function editAction($id, Request $request)
    {
        if ($request->isMethod('POST')) {
            $request->getSession()->getFlashBag()->add('notice', 'Annonce bien modifiée.');
            return $this->redirectToRoute('tri_platform_view', array('id' => 5));
        }
        $advert = array(
            'title' => 'Recherche développpeur Symfony',
            'id' => $id,
            'author' => 'Alexandre',
            'content' => 'Nous recherchons un développeur Symfony débutant sur Lyon. Blabla…',
            'date' => new \Datetime()
        );

        return $this->render('TRIPlatformBundle:Advert:edit.html.twig', array(
            'advert' => $advert
        ));
    }

    public function deleteAction($id)
    {
        return $this->render('TRIPlatformBundle:Advert:delete.html.twig');
    }

    public function menuAction()
    {
        $listAdverts = array(
            array('id' => 2, 'title' => 'Recherche dev Symfony'),
            array('id' => 5, 'title' => 'Mission webmaster'),
            array('id' => 9, 'title' => 'Offre de stage webdesigner'),
        );

        return $this->render('TRIPlatformBundle:Advert:menu.html.twig', array(
            'listAdverts' => $listAdverts
        ));
    }
}
