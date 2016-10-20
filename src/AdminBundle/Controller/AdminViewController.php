<?php

namespace AdminBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use AdminBundle\Entity\User;

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
    public function GetInscription(Request $request) {

        $em = $this->getDoctrine()->getManager();
        $user = new User();//Instance de l'entité User

        //Si il détecte une requete ajax
        if ($request->getMethod() == "POST") {
            $user->setUsername($request->get('username'));
            $user->setPassword($request->get('password'));
            $user->setNom($request->get('nom'));
            $user->setPrenom($request->get('prenom'));
            $user->setSalt("");
            $user->setRoles(array("ROLE_USER"));

            $em->persist($user);
            $em->flush();


            $response = new JsonResponse(); //Retour des données au format Json
            $response->setData(array('reussite' => 'Inscription reussi !'));

            return $response;
        }
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
    public function GetArticles() {
        //ici je récupere toutes les news
        $repository = $this->getDoctrine()->getManager()->getRepository('AdminBundle:News');
        $listNews = $repository->findAll();

        return $this->render('AdminBundle:Default:articles.html.twig', array('listNews' => $listNews));
    }

    /**
     * @Route("/supp/{id}", name="supp")
     */
    public function suppArticles($id) {
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
