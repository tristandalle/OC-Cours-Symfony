<?php

namespace TRI\PlatformBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('TRIPlatformBundle:Default:index.html.twig');
    }
}
