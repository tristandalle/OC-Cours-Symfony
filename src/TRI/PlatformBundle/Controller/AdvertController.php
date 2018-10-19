<?php

// src\TRI\PlatformBundle\Controller\AdvertController.php

namespace TRI\PlatformBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;


class AdvertController extends Controller
{
    public function indexAction()
    {
        $content = $this->get('templating')
            ->render('TRIPlatformBundle:Advert:index.html.twig', array('nom' => 'Biby'));

        return new Response($content);
    }
}
