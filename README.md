Blog
====

# **Technologies utilisées:**
    
    ## Front-end :
        
        ###  HTML (version 5)
        ###  CSS (version 3)
        ###  Bootstrap (version 3.3)
        ###  SASS (version 3.5)
        
    ## Back-end :
      
        ###  PHP (version 5.5.9)
        ###  Framework "Symphony" (version 3.1)
        ###  PHPmyadmin (version 4.6.4)
   
    ## IDE :
     
        ###  Netbeans(version 8.1)

# **Procédures d installation:**

     ##Créer un dossier vide nommé blog
    
    ## Récupérez le dépôt sur Github (console)
      
       Ouvrir le projet dans Netbeans

    ## Installez les dépendances via composer:
        ### 1. clique-droit project -> composer -> install (dev)

    ## Installation de la base de données:

    ### * -Les points abordés:
        ### 1. Créez la base de données (terminal : database:create)
        ### 2. Créez le fichier parameters.yml dans app/config si il n'existe pas
        ### 3. Liez votre base de données dans parameters.yml
        ### 4. Synchroniser la BDD avec le projet blog dans le terminal : 
               php bin/console doctrine:schema:update --force 
        ### 5. Pensez aux droits d'administration: sudo chmod -R 777 *
        ### 6. Tapez "base" dans l'url pour initialisé les tables catégories et étatspublication et pour créer un compte admin .
        Identifiant : admin 
        Mot de passe : admin

# **Liens outils collaboratifs:**  

        ### * Framapad [GitHub](https://mypads.framapad.org/mypads/?/mypads/group/projet-blog-charles-jonathan-thibaut-x6may7nt/pad/view/taches-a-accomplir-69mby7fc)
        ### * Trello [Github] (https://trello.com/b/yPCaaZKs/projet-certif)

# **Auteurs du projet:**

        ### * Charles-André PALADE (http://www.driad.fr/)
        ### * Gaston SABOY ()
        ### * Jonathan GOMEZ (http://jonathan-gomez.fr/)
        ### * Thibaut FIGUERES (http://thibaut-figueres.fr/)

A Symfony project created on October 18, 2016, 10:01 am.
