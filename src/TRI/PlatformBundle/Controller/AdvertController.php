<?php

// src\TRI\PlatformBundle\Controller\AdvertController.php

namespace TRI\PlatformBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use TRI\PlatformBundle\Entity\Advert;
use TRI\PlatformBundle\Entity\Image;
use TRI\PlatformBundle\Entity\Application;
use TRI\PlatformBundle\Entity\Category;
use TRI\PlatformBundle\TRIPlatformBundle;


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
        $em = $this->getDoctrine()->getManager();

        $advert = $em
            ->getRepository('TRIPlatformBundle:Advert')
            ->find($id);

        if (null === $advert)
        {
            throw new NotFoundHttpException("L'annonce d'id ".$id. " n'existe pas");
        }

        $listApplications = $em
            ->getRepository('TRIPlatformBundle:Application')
            ->findBy(array('advert' => $advert))
            ;

        $listAdvertSkills = $em
            ->getRepository('TRIPlatformBundle:AdvertSkill')
            ->findBy(array('advert' => $advert))
        ;

        return $this->render('TRIPlatformBundle:Advert:view.html.twig', array(
            'advert' => $advert,
            'listApplications' => $listApplications,
            'listAdvertSkills' => $listAdvertSkills
        ));
    }


    public function addAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $advert = new Advert();
        $advert->setTitle("Recherche Pere Noel");
        $advert->setAuthor("Bobby");
        $advert->setContent("cherche pere noel pour le 25dec");

        // On récupère toutes les compétences possibles
        $listSkills = $em->getRepository('TRIPlatformBundle:Skill')->findAll();

        // Pour chaque compétence
        foreach ($listSkills as $skill) {
            // On crée une nouvelle « relation entre 1 annonce et 1 compétence »
            $advertSkill = new AdvertSkill();

            // On la lie à l'annonce, qui est ici toujours la même
            $advertSkill->setAdvert($advert);
            // On la lie à la compétence, qui change ici dans la boucle foreach
            $advertSkill->setSkill($skill);

            // Arbitrairement, on dit que chaque compétence est requise au niveau 'Expert'
            $advertSkill->setLevel('Expert');

            // Et bien sûr, on persiste cette entité de relation, propriétaire des deux autres relations
            $em->persist($advertSkill);
        }

        // Doctrine ne connait pas encore l'entité $advert. Si vous n'avez pas défini la relation AdvertSkill
        // avec un cascade persist (ce qui est le cas si vous avez utilisé mon code), alors on doit persister $advert
        $em->persist($advert);

        // On déclenche l'enregistrement
        $em->flush();


        $image = new image();
        $image->setUrl('https://picsum.photos/200/300');
        $image->setAlt('ramdomimage');

        $advert->setImage($image);

        $application1 = new Application();
        $application1->setAuthor('José');
        $application1->setContent('Je sui un super pere noel');

        $application2 = new Application();
        $application2->setAuthor('Abdoul');
        $application2->setContent('dispo le 25decembre');

        $application1->setAdvert($advert);
        $application2->setAdvert($advert);


        $em = $this->getDoctrine()->getManager();

        $em->persist($advert);
        $em->persist($application1);
        $em->persist($application2);

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
        $em = $this->getDoctrine()->getManager();

        $advert = $em->getRepository('TRIPlatformBundle:Advert')->find($id);

        if(null === $advert) {
            throw new NotFoundHttpException("L'annonce d'id ".$id." n'existe pas.");
        }

        $listCategories = $em->getRepository('TRIPlatformBundle:Category')->findAll();

        foreach ($listCategories as $category) {
            $advert->addCategory($category);
        }

        $em->flush();

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
        $em = $this-><$this->getDoctrine()->getManager();

        $advert = $em->getRepository('TRIPlatformBundle:Advert')->find($id);

        if (null === $advert) {
            throw new NotFoundHttpException("L'annonce d'id ".$id." n'existe pas");
        }

        foreach ($advert->getCategories() as $category) {
            $advert->removeCategory($category);
        }

        $em->flush();

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
