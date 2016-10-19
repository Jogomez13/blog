<?php


namespace AdminBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

/**
 * Description of AdminViewController
 *
 * @author jonathan
 */
class AdminViewController extends Controller {
     /**
     * @Route("/admin", name="admin")
     */
    public function getAdmin()
    {
        return $this->render('AdminBundle:Default:admin.html.twig');
    }
    
     /**
     * @Route("/connexion", name="connexion")
     */
    public function GetConnexion()
    {
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
     */
    public function GetInscription()
    {
        return $this->render('AdminBundle:Default:inscription.html.twig');
    }
    
     /**
     * @Route("/profil", name="profil")
     */
    public function GetProfil()
    {
        return $this->render('AdminBundle:Default:profil.html.twig');
    }
    
     /**
     * @Route("/modifprofil", name="modifprofil")
     */
    public function GetModifprofil()
    {
        return $this->render('AdminBundle:Default:modifprofil.html.twig');
    }
    
    /**
     * @Route("/brouillions", name="brouillons")
     */
    public function GetBrouillons()
    {
        return $this->render('AdminBundle:Default:brouillons.html.twig');
    }
}
