<?php

// src\TRI\PlatformBundle\Controller\AdvertController.php

namespace TRI\PlatformBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;


class AdvertController extends Controller
{

    public function indexAction($page)
    {
        if($page < 1) {
            throw new NotFoundHttpException('Page"'.$page.'" inexistante.');
        }
        return $this->render('TRIPlatformBundle:Advert:index.html.twig');
    }


    public function viewAction($id)
    {
        return $this->render('TRIPlatformBundle:Advert:view.html.twig', array('id' => $id));
    }


    public function addAction($request)
    {
       if($request->isMethod('POST')){
           $request->getSession()->getFlashBag()->add('notice', 'Annonce bien enregistrée.');
           return $this->redirectToRoute('tri_platform_view', array('id' => 5));
       }
       return $this->render('TRIPlatformBundle:Advert:add.html.twig');
    }

    public function editAction($id, Request $request)
    {
        if ($request->isMethod('POST')){
            $request->getSession()->getFlashBag()->add('notice', 'Annonce bien modifiée.');
            return $this->redirectToRoute('tri_platform_view', array('id' => 5));
        }
        return $this->render('TRIPlatformBundle:Advert:edit.html.twig');
    }

    public function deleteAction($id)
    {
        return $this->render('TRIPlatformBundle:Advert:delete.html.twig');
    }
}
