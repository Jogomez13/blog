<?php

namespace AdminBundle\Controller;

use AdminBundle\Entity\Categorie;
use AdminBundle\Entity\Etatpublication;
use AdminBundle\Entity\News;
use AdminBundle\Entity\User;
use AdminBundle\Form\UserType;
use DateTime;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Description of AdminViewController
 *
 * @author jonathan
 */
class AdminViewController extends Controller {

    /**
     * @Route("/admin", name="admin")
     */
    public function getAdmin() {
        if ($this->getUser() == null) {
            return $this->DroitsRefuse();
        }
        return $this->render('admin.html.twig');
    }

    /**
     * @Route("/connexion", name="connexion")
     * 
     */
    public function getConnexion() {  //Fonction pour connecter l'utilisateur
        if ($this->get('security.authorization_checker')->isGranted('IS_AUTHENTICATED_REMEMBERED')) {

            return $this->redirectToRoute("accueil"); //Retour sur la page principal//             
        }

        $authenticationUtils = $this->get('security.authentication_utils');

        return $this->render('connexion.html.twig', array(
                    'last_username' => $authenticationUtils->getLastUsername(),
                    'error' => $authenticationUtils->getLastAuthenticationError(),
        ));
    }

    /**
     * @Route("/inscription", name="inscription")
     * 
     */
    public function getInscription(Request $request) {

        $em = $this->getDoctrine()->getManager();
        $user = new User(); //Instance de l'entité User
        //Si il détecte une requete ajax

        $user_form = $this->createForm(UserType::class, $user);
        if ($request->getMethod() == 'POST') {
            $user_form->handleRequest($request);


            $image = $user->getAvatar();
            $nom = $image->getClientOriginalName();
            $image->move("img/" . $user->getPseudo(), $nom);

            $user->setAvatar("img/" . $user->getPseudo() . "/" . $nom);
            $user->setSalt("");
            $user->setRoles(array('ROLE_USER'));

            $em->persist($user);
            $em->flush();
            return $this->redirectToRoute('accueil');
        }

        return $this->render('inscription.html.twig', array('form' => $user_form->createView()));
    }

    /**
     * @Route ("/articles",name="articles")
     */
    public function getArticles() {

        if ($this->getUser() == null) {
            return $this->DroitsRefuse();
        }
        //ici je récupere toutes les news
        $repository = $this->getDoctrine()->getManager()->getRepository('AdminBundle:News');
        $listNews = $repository->findBy(array(), array('date' => 'desc'), null, null);

        return $this->render('articles.html.twig', array('listNews' => $listNews));
    }

    /**
     * @Route("/add",name="add")
     */
    public function addArticle(Request $request) {
        if ($this->getUser() == null) {
            return $this->DroitsRefuse();
        }

        //Je crée un nouvel objet
        $article = new News();
        //ci-dessous je déclare que les articles sont forcément en brouillon de base grâce à l'id 2
        $article->setEtatpublication($this->getDoctrine()->getRepository(Etatpublication::class)->find(12));
        $user = $this->getUser()->getRoles();
        //Je crée le formulaire 

        if ($user === array('ROLE_ADMIN')) {
            $news = $this->CreateFormAdmin($article);
        } else {
            $news = $this->CreateFormUser($article);
        }


        //quand le formulaire est envoyé on envoi un nouvel article
        if ($request->getMethod() == 'POST') {
            $news->handleRequest($request);
            $img = $article->getImage();

            $nom = $img->getClientOriginalName();
            $img->move("img/article", $nom);


            $em = $this->getDoctrine()->getEntityManager();
            //Met le pseudo dans l'utilisateur courant dans le champ auteur

            $article->setAuteur($this->getUser()->getPseudo());
            $article->setImage("img/article/" . $nom);
            $article->setDate(new DateTime());

            $em->persist($article);
            $em->flush();
            return $this->redirectToRoute('articles');
        }

        return $this->render('newarticle.html.twig', array('form' => $news->createView()));
    }

    /**
     * @Route("/modif/{id}", name="modif")
     */
    public function modifArticle($id, Request $request) {
        if ($this->getUser() == null) {
            return $this->DroitsRefuse();
        }
        $em = $this->getDoctrine()->getManager();
        $article = $em->find('AdminBundle:News', $id);
        $image_courante = $article->getImage();

        $nom_img = explode("/", $image_courante);
        $article->setImage(new UploadedFile($article->getImage(), $nom_img[2]));

        if ($this->getUser()->getRoles() === array('ROLE_ADMIN')) {
            $news = $this->CreateFormAdmin($article);
        } else {
            $news = $this->CreateFormUser($article);
        }

        if ($request->getMethod() == 'POST') {
            $news->handleRequest($request);

            if ($article->getImage() == null) {//Si on ne veut pas changer d'image
                $article->setImage($image_courante);
            } else {
                $image = $article->getImage();
                $nom = $image->getClientOriginalName();
                $image->move("img/article/", $nom);
                $article->setImage("img/article/" . $nom);
            }

            $em->merge($article);
            $em->flush();
            return $this->redirectToRoute('articles');
        }
        return $this->render('modifarticle.html.twig', array('form' => $news->createView()));
    }

    /**
     * @Route("/supp/{id}", name="supp")
     */
    public function suppArticle($id) {
        if ($this->getUser() == null) {
            return $this->DroitsRefuse();
        }
        $em = $this->getDoctrine()->getManager();
        $news = $em->find('AdminBundle:News', $id);
        //ici je récupère l'entité par l'idée
        $em->remove($news);
        //ici je la supprimé
        $em->flush();
        //affecte tous les changements en base de données
        return $this->redirectToRoute('articles');
        //ci-dessus une fois mon article supprimé je redirige vers la vue articles
    }

    /**
     * @Route ("/brouillons",name="brouillons")
     */
    public function getBrouillons() {
        if ($this->getUser() == null) {
            return $this->DroitsRefuse();
        }
        //ici je récupere toutes les brouillons        
        if ($this->getUser()->getRoles() == array('ROLE_ADMIN')) {
            $repository = $this->getDoctrine()->getManager()->getRepository('AdminBundle:News');
            $listBrouillons = $repository->findBy(array(), array('date' => 'desc'));
        }
        if ($this->getUser()->getRoles() == array('ROLE_USER')) {
            $repository = $this->getDoctrine()->getManager()->getRepository('AdminBundle:News');
            $listBrouillons = $repository->findBy(array('auteur' => $this->getUser()->getPseudo()), array('date' => 'desc'));
        }

        return $this->render('brouillons.html.twig', array('listBrouillons' => $listBrouillons));
    }

    /**
     * @Route("/profil", name="profil")
     */
    public function getProfil() {
        if ($this->getUser() == null) {
            return $this->DroitsRefuse();
        }
        //ici je récupere toutes mon profil
        $repository = $this->getDoctrine()->getManager()->getRepository('AdminBundle:User');
        $monProfil = $repository->findBy(array('pseudo' => $this->getUser()->getPseudo()));

        return $this->render('profil.html.twig', array('monProfil' => $monProfil));
    }

    /**
     * @Route("/modifprofil", name="modifprofil")
     */
    public function getModifprofil(Request $request) {
        if ($this->getUser() == null) {
            return $this->DroitsRefuse();
        }
        $em = $this->getDoctrine()->getManager();
        $user = $this->getUser();

        $avatar_courant = $user->getAvatar();
        $pseudo_courant = $user->getPseudo();
        $pass_courant = $user->getPassword();

        $user->setAvatar(new UploadedFile($user->getAvatar(), $user->getAvatar()));

        $profil = $this->createForm(UserType::class, $user); //Création du formulaire avec les données personnelles
        $profil->handleRequest($request);
        if ($profil->isSubmitted() && $profil->isValid()) {
            if ($this->getUser() == null) {
                return $this->DroitsRefuse();
            }

            if ($user->getPseudo() !== $pseudo_courant) {
                rename("img/" . $pseudo_courant, "img/" . $user->getPseudo());
            }

            if ($user->getAvatar() == null) {
                $nom_img = explode("/", $avatar_courant);
                $user->setAvatar("img/" . $user->getPseudo() . "/" . $nom_img[2]);
            } else {

                $image = $user->getAvatar();
                $nom = $image->getClientOriginalName();
                $image->move("img/" . $user->getPseudo(), $nom);
                $user->setAvatar("img/" . $user->getPseudo() . "/" . $nom);
            }
            $user->setPassword($pass_courant);
            $em->merge($user);
            $em->flush();
        }
        return $this->render('modifprofil.html.twig', array('form' => $profil->createView()));
    }

    /**
     * @Route("/modifPass", name="modifPass")
     */
    public function getModifPass(Request $request) {
        if ($this->getUser() == null) {
            return $this->DroitsRefuse();
        }

        $user = $this->getUser();
        $em = $this->getDoctrine()->getManager();

        if ($request->getMethod() == "POST") {
            $user->setPassword($request->get('mdp'));
            $em->merge($user);
            $em->flush();
            $response = new JsonResponse(); //Retour des données au format Json
            $response->setData(array('reussite' => 'Votre mot de passe à bien été modifié !')); //Retour en format Json
            return $response;
        }

        return $this->render('modifPass.html.twig');
    }

    /**
     * @Route("/base", name="base")
     */
    public function Base() {

        $em = $this->getDoctrine()->getManager();

        $nom_categorie[0] = "ordinateur";
        $nom_categorie[1] = "tablette";
        $nom_categorie[2] = "telephone";

        $nom_etat[0] = "publier";
        $nom_etat[1] = "brouillon";

        $catego = new Categorie();
        $catego1 = new Categorie();
        $catego2 = new Categorie();

        $etat1 = new Etatpublication();
        $etat2 = new Etatpublication();

        $user_admin = new User();

        mkdir("img/admin");
        rename("img/avatar.png", "img/admin/avatar.png");

        $catego->setNom($nom_categorie[0]);
        $catego1->setNom($nom_categorie[1]);
        $catego2->setNom($nom_categorie[2]);

        $etat1->setEtat($nom_etat[0]);
        $etat2->setEtat($nom_etat[1]);

        $user_admin->setRoles(array('ROLE_ADMIN'));
        $user_admin->setUsername("admin");
        $user_admin->setAvatar("img/admin/avatar.png");
        $user_admin->setNom("admin");
        $user_admin->setPrenom("admin");
        $user_admin->setPseudo("admin");
        $user_admin->setPassword("admin");
        $user_admin->setSalt("");

        $em->persist($catego);
        $em->persist($catego1);
        $em->persist($catego2);

        $em->persist($etat1);
        $em->persist($etat2);

        $em->persist($user_admin);

        $em->flush();

        return $this->redirectToRoute("accueil");
    }

    public function CreateFormAdmin($article) {
        $news = $this->createFormBuilder($article)
                ->add('titre')
                ->add('image', null, array('required' => false))
                ->add('article', TextareaType::class)
                ->add('categorie')
                ->add('etatpublication')
                ->add('Envoyer', SubmitType::class)
                ->getForm();
        return $news;
    }

    public function CreateFormUser($article) {
        $news = $this->createFormBuilder($article)
                ->add('titre')
                ->add('image', null, array('required' => false))
                ->add('article', TextareaType::class)
                ->add('categorie')
                ->add('Envoyer', SubmitType::class)
                ->getForm();

        return $news;
    }

    public function DroitsRefuse() {
        return new Response("Vous n'avez pas les droits ou vous devriez vous connectez pour acceder à cette page !");
    }

}
