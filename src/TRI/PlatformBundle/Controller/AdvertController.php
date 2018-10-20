<?php

// src\TRI\PlatformBundle\Controller\AdvertController.php

namespace TRI\PlatformBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;


class AdvertController extends Controller
{
    public function viewAction($id)
    {
        return new Response("Affichage de l'annonce d'id :".$id);
    }

    public function viewSlugAction($slug, $year, $_format)
    {
        return new Response(
            "On pourrait afficher l'annonce correspondant au slug '".$slug."', créée en ".$year." et au format ".$_format."."
        );
    }

    public function indexAction()
    {
        $url = $this->get('router')->generate(
            'tri_platform_view',
            array('id' => 5)
    );
        return new Response("L'URL de l'annonce d'id 5 est : ".$url);
    }

}
