<?php

namespace AdminBundle\Controller;

use AdminBundle\Entity\News;
use AdminBundle\Form\NewsType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * Description of AdminViewController
 *
 * @author jonathan
 */
class AdminViewController extends Controller {

    /**
     * @Route("/admin")
     */
    public function getAdmin() {
        return $this->render('AdminBundle:Default:admin.html.twig');
    }

    /**
     * @Route("/connexion", name="connexion")
     * 
     */
    public function GetConnexion() {  //Fonction pour connecter l'utilisateur
        if ($this->get('security.authorization_checker')->isGranted('IS_AUTHENTICATED_REMEMBERED')) {

            return $this->redirectToRoute("bool"); //Retour sur la page principal//             
        }

        $authenticationUtils = $this->get('security.authentication_utils');

        return $this->render('AdminBundle:Default:connexion.html.twig', array(
                    'last_username' => $authenticationUtils->getLastUsername(),
                    'error' => $authenticationUtils->getLastAuthenticationError(),
        ));
    }

    /**
     * @Route("/inscription", name="inscription")
     * 
     */
    public function GetInscription() {
        //TEST//

        return $this->render('AdminBundle:Default:inscription.html.twig');
    }

    /**
     * @Route("/profil", name="profil")
     */
    public function GetProfil() {
        return $this->render('AdminBundle:Default:profil.html.twig');
    }

    /**
     * @Route("/modifprofil", name="modifprofil")
     */
    public function GetModifprofil() {
        return $this->render('AdminBundle:Default:modifprofil.html.twig');
    }

    /**
     * @Route("/brouillions", name="brouillons")
     */
    public function GetBrouillons() {
        return $this->render('AdminBundle:Default:brouillons.html.twig');
    }
    
    /**
     * @Route ("/articles",name="articles")
     */
    public function GetArticles(){
       //ici je récupere toutes les news
       $repository = $this->getDoctrine()->getManager()->getRepository('AdminBundle:News');
       $listNews = $repository->findAll();
       
        return $this->render('AdminBundle:Default:articles.html.twig',array('listNews' => $listNews));
    }
    
    /**
     * @Route("/add",name="add")
     */
    public function addNews(Request $request){
        //Je crée un nouvel objet
        $article = new News();
        //Je crée le formulaire à partir de la classe NewsType
        $news= $this->createForm(NewsType::class,$article);
        //quand le formulaire est envoyé on envoi un nouvel article
        if ($request->getMethod() == 'POST') {
            $news->handleRequest($request);
            $em = $this->getDoctrine()->getEntityManager();
            $em->persist($article);
            $em->flush();
            return $this->redirectToRoute('articles');
        }
    
        return $this->render('AdminBundle:Default:newarticle.html.twig' , array('form' => $news->createView()));
     
    }
    
     /**
     * @Route("/modif/{id}", name="modif")
     */
    public function modifNews($id, Request $request) {
        $em = $this->getDoctrine()->getEntityManager();
        $article = $em->find('AdminBundle:News', $id);
        $news= $this->createForm(NewsType::class,$article);
         if ($request->getMethod() == 'POST') {
            $news->handleRequest($request);
            $em->merge($article);
            $em->flush();
            return $this->redirectToRoute('articles');
        }
        return $this->render('AdminBundle:Default:modifarticle.html.twig' , array('form' => $news->createView()));
        
    }
     /**
     * @Route("/supp/{id}", name="supp")
     */
    public function suppArticles($id){
        $em = $this->getDoctrine()->getEntityManager();
        $news = $em->find('AdminBundle:News', $id);
        //ici je récupère l'entité par l'idée
        $em->remove($news);
        //ici je la supprimé
        $em->flush();
        //affecte tous les changements en base de données
        return $this->redirectToRoute('articles');
        //ci-dessus une fois mon article supprimé je redirige vers la vue articles
    }
    
    
}
