<?php

namespace TRI\CoreBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;

class CoreController extends Controller
{
    public function indexAction()
    {
        return $this->render('TRICoreBundle:Core:index.html.twig');
    }

    public function contactAction(Request $request)
    {
        $session = $request->getSession();

        $session->getFlashBag()->add('info', 'La page de contact n\'est pas encore dispo');

        return $this->redirectToRoute('tri_core_homepage');
    }
}
