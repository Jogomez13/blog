<?php

namespace BlogBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;


class BlogController extends Controller {
    /**
     * @Route("/", name="accueil")
     */
    public function getAccueil()
    {
        return $this->render('accueil.html.twig');
    }
    
     /**
     * @Route ("/ordinateur",name="ordinateur")
     */
    public function getArticlesOrdi() {
        //ici je récupere toutes les news ordinateur
        $repository = $this->getDoctrine()->getManager()->getRepository('AdminBundle:News');
        $listNews = $repository->findBy(array(), array('date' => 'desc') , null , null);

        return $this->render('ordi.html.twig', array('listNews' => $listNews));
    }
    
     /**
     * @Route ("/tablette",name="tablette")
     */
    public function getArticlesTablette() {
        //ici je récupere toutes les news tablette
        $repository = $this->getDoctrine()->getManager()->getRepository('AdminBundle:News');
        $listNews = $repository->findBy(array(), array('date' => 'desc') , null , null);

        return $this->render('tablette.html.twig', array('listNews' => $listNews));
    }
    
    /**
     * @Route ("/telephone",name="telephone")
     */
    public function getArticlesTelephone() {
        //ici je récupere toutes les news telephone
        $repository = $this->getDoctrine()->getManager()->getRepository('AdminBundle:News');
        $listNews = $repository->findBy(array(), array('date' => 'desc') , null , null);

        return $this->render('telephone.html.twig', array('listNews' => $listNews));
    }
    
    
    /**
     * @Route("/contact", name="contact")
     */
    public function getContact()
    {
        return $this->render('contact.html.twig');
    }
     
}
