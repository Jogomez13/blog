<?php


namespace AdminBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

/**
 * Description of AdminViewController
 *
 * @author jonathan
 */
class AdminViewController extends Controller {
     /**
     * @Route("/admin")
     * @Template("AmdinBundle:Default:admin.html.twig")
     */
    public function getAdmin()
    {
        return $this->render('AdminBundle:Default:admin.html.twig');
    }
    
     /**
     * @Route("/admin/connexion", name="connexion")
     * @Template("AmdinBundle:Default:connexion.html.twig")
     */
    public function GetConnexion()
    {
        return $this->render('AdminBundle:Default:connexion.html.twig');
    }
    
    /**
     * @Route("/admin/inscription", name="inscription")
     * @Template("AmdinBundle:Default:inscription.html.twig")
     */
    public function GetInscription()
    {
        return $this->render('AdminBundle:Default:inscription.html.twig');
    }
}
