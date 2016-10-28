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
    public function getAdmin() {//Fonction qui retourne la vue de la page admin
        if ($this->getUser() == null) {//Teste si un utilisateur est connecté 
            return $this->DroitsRefuse(); //Si non , refuse les droits d'accès 
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
    public function getInscription(Request $request) {//Fonction qui permet de s'inscrire en tant que simple utilisateur
        $em = $this->getDoctrine()->getManager();
        $user = new User(); //Instance de l'entité User

        $user_form = $this->createForm(UserType::class, $user);
        if ($request->getMethod() == 'POST') {
            $user_form->handleRequest($request);


            $image = $user->getAvatar(); //Récupère l'image sélectionné dans le formulaire
            $nom = $image->getClientOriginalName(); //Récupération du nom de l'image
            $image->move("img/" . $user->getPseudo(), $nom); //Et déplacement dans le bon dossier , (création automatique)

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
    public function getArticles() {//Fonction qui récupère tout les articles et les affiches
        if ($this->getUser() == null) {
            return $this->DroitsRefuse();
        }

        $repository = $this->getDoctrine()->getManager()->getRepository('AdminBundle:News');
        $listNews = $repository->findBy(array(), array('date' => 'desc'), null, null); //Récupération des articles et classement par le plus récent

        return $this->render('articles.html.twig', array('listNews' => $listNews));
    }

    /**
     * @Route("/add",name="add")
     */
    public function addArticle(Request $request) {//Fonction pour ajouter un article
        if ($this->getUser() == null) {
            return $this->DroitsRefuse();
        }

        //Je crée un nouvel objet
        $article = new News();
        //ci-dessous je déclare que les articles sont forcément en brouillon de base grâce à l'id 2
        $article->setEtatpublication($this->getDoctrine()->getRepository(Etatpublication::class)->find(2));
        $user = $this->getUser()->getRoles();


        //Je crée le formulaire selon le rôle de l'utilisateur (On laisse le choix de l'état de publication pour l'utilisateur admin)
        if ($user === array('ROLE_ADMIN')) {
            $news = $this->CreateFormAdmin($article);
        } else {
            $news = $this->CreateFormUser($article);
        }


        //Quand le formulaire est envoyé on envoi un nouvel article
        if ($request->getMethod() == 'POST') {
            $news->handleRequest($request);
            $img = $article->getImage();

            $nom = $img->getClientOriginalName();
            $img->move("img/article", $nom);


            $em = $this->getDoctrine()->getEntityManager();

            $article->setAuteur($this->getUser()->getPseudo()); //Met le pseudo de l'utilisateur en auteur
            $article->setImage("img/article/" . $nom);
            $article->setDate(new DateTime()); //Règle la date sur la date actuelle

            $em->persist($article);
            $em->flush();
            return $this->redirectToRoute('articles');
        }

        return $this->render('newarticle.html.twig', array('form' => $news->createView()));
    }

    /**
     * @Route("/modif/{id}", name="modif")
     */
    public function modifArticle($id, Request $request) {//Fonction permettant de modifier un article , à partir de son id
        if ($this->getUser() == null) {
            return $this->DroitsRefuse();
        }
        $em = $this->getDoctrine()->getManager();
        $article = $em->find('AdminBundle:News', $id);
        $image_courante = $article->getImage(); //Récupération de la source de l'image avant changement via le formulaire

        $nom_img = explode("/", $image_courante); //Séparation de la source de l'image par rapport aux slash , donc crée un tableau de trois cases
        $article->setImage(new UploadedFile($article->getImage(), $nom_img[2])); //Créeation de l'image grâce au nom de l'image qui est dans la troisième case du tableau nom_img
        //Je crée le formulaire selon le rôle de l'utilisateur (On laisse le choix de l'état de publication pour l'utilisateur admin)
        if ($this->getUser()->getRoles() === array('ROLE_ADMIN')) {
            $news = $this->CreateFormAdmin($article);
        } else {
            $news = $this->CreateFormUser($article);
        }

        if ($request->getMethod() == 'POST') {
            $news->handleRequest($request);

            if ($article->getImage() == null) {//Si on ne veut pas changer d'image
                $article->setImage($image_courante); //On laisse l'ancienne image
            } else {
                $image = $article->getImage();
                $nom = $image->getClientOriginalName();
                $image->move("img/article/", $nom); //Déplacement de l'image dans le bon dossier
                $article->setImage("img/article/" . $nom); //Ajout de la source dans le champ image
            }

            $em->merge($article);
            $em->flush();

            return $this->redirectToRoute('articles');
        }
        return $this->render('modifarticle.html.twig', array('form' => $news->createView()));
    }

    /**
     * @Route("/supp/{id}", name="supp")//Fonction pour supprimer un article à partir de son id
     */
    public function suppArticle($id) {
        if ($this->getUser() == null) {
            return $this->DroitsRefuse();
        }
        $em = $this->getDoctrine()->getManager();
        $news = $em->find('AdminBundle:News', $id);

        //ici je la supprime
        $em->remove($news);

        $em->flush();
        //affecte tous les changements en base de donnée
        return $this->redirectToRoute('articles');
        //ci-dessus une fois mon article supprimé je redirige vers la vue articles
    }

    /**
     * @Route ("/brouillons",name="brouillons")
     */
    public function getBrouillons() {//Fonction pour récuperer tous les articles brouillons
        if ($this->getUser() == null) {
            return $this->DroitsRefuse();
        }
        //ici je récupere les brouillons , seuls ceux que j'ai écrit pour l'utilisateur normal , et tous pour l'utilisateur admin  
        //Triés selon le plus récent
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
    public function getProfil() {//Fonction pour récuperer les informations du profil de l'utilisateur connecté
        if ($this->getUser() == null) {
            return $this->DroitsRefuse();
        }

        $repository = $this->getDoctrine()->getManager()->getRepository('AdminBundle:User');
        $monProfil = $repository->findBy(array('pseudo' => $this->getUser()->getPseudo()));

        return $this->render('profil.html.twig', array('monProfil' => $monProfil));
    }

    /**
     * @Route("/modifprofil", name="modifprofil")//Fonction pour modifier le profil de l'utilisateur connecté
     */
    public function getModifprofil(Request $request) {
        if ($this->getUser() == null) {
            return $this->DroitsRefuse();
        }
        $em = $this->getDoctrine()->getManager();
        $user = $this->getUser(); //Récupération de l'utilisateur connecté

        $avatar_courant = $user->getAvatar();
        $pseudo_courant = $user->getPseudo();
        $pass_courant = $user->getPassword();

        $user->setAvatar(new UploadedFile($user->getAvatar(), $user->getAvatar()));

        $profil = $this->createForm(UserType::class, $user); //Création du formulaire avec les données personnelles
        $profil->handleRequest($request);
        if ($profil->isSubmitted() && $profil->isValid()) {

            if ($user->getPseudo() !== $pseudo_courant) {
                rename("img/" . $pseudo_courant, "img/" . $user->getPseudo()); //Si on change le pseudo , on doit changer le nom du dossier personnel de l'utilisateur
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
    public function getModifPass(Request $request) {//Fonction pour modifier le mot de passe de l'utilisateur
        if ($this->getUser() == null) {
            return $this->DroitsRefuse();
        }

        $user = $this->getUser();
        $em = $this->getDoctrine()->getManager();

        if ($request->getMethod() == "POST") {//Quand la requête ajax est lancé
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
    //Fonction à lancer une seule fois au déploiment du site 
    //Il insert 3 catégories , deux états de publication , et créer un utilisateur admin
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

        mkdir("img/admin");//Création du dossier personnel du compte admin créer
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

    public function CreateFormAdmin($article) {//Création du formulaire pour l'admin 
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

    public function CreateFormUser($article) {//Création du formulaire pour l'user
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
