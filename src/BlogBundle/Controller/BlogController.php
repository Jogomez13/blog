<?php

namespace BlogBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;


class BlogController extends Controller {
    /**
     * @Route("/accueil", name="accueil")
     */
    public function indexAction()
    {
        return $this->render('BlogBundle:Default:accueil.html.twig');
    }
    /**
     * @Route("/telephone", name="telephone")
     */
    public function indexTelephone()
    {
        return $this->render('BlogBundle:Default:telephone.html.twig');
    }
    /**
     * @Route("/tablette", name="tablette")
     */
    public function indexTablette()
    {
        return $this->render('BlogBundle:Default:tablette.html.twig');
    }
    /**
     * @Route("/ordinateur", name="ordinateur")
     */
    public function indexOrdi()
    {
        return $this->render('BlogBundle:Default:ordi.html.twig');
    }
    /**
     * @Route("/membre", name="membre")
     */
    public function indexEspaceMembre()
    {
        return $this->render('BlogBundle:Default:contact.html.twig');
    }
}
