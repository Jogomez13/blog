Blog
====

# **Technologies utilisées:**
    
    ## Front-end :
        
        ### * HTML (version 5)
        ### * CSS (version 3)
        ### * Bootstrap (version 3.3)
        ### * SASS (version 3.5)
        
    ## Back-end :
      
        ### * PHP (version 5.5.9)
        ### * Framework "Symphony" (version 3.1)
        ### * PHPmyadmin (version 4.6.4)
   
    ## IDE :
     
        ### * Netbeans(version 8.1)

# **Procédures d installation:**

    ## Récupérez le dépôt sur Github (console)

    ## Installez les dépendances (boostrap en l'occurence) via composer:
        ### 1. clique-droit project -> composer -> install (dev)
        ### Pensez aux droits d'accés d'écriture du dossier vendor quand vous installez composer sous Linux

    ## Installation des entités:

    ### * -Les points abordés:
        ### 1. Créez la base de données sur phpmyadmin
        ### 2. Liez votre base de données dans parameters.yml
        ### 3. Installez doctrine pour générer les entités (php bin/console generate:doctrine:entity)
        ### 4. Créez et pushez les tables sur phpmyadmin avec la console (php app/console doctrine:schema:update --force)
         
# **Liens outils collaboratifs:**  

        ### * Framapad [GitHub](https://mypads.framapad.org/mypads/?/mypads/group/projet-blog-charles-jonathan-thibaut-x6may7nt/pad/view/taches-a-accomplir-69mby7fc)
        ### * Trello [Github] (https://trello.com/b/yPCaaZKs/projet-certif)

# **Auteurs du projet:**

        ### * Charles-André PALADE (http://www.driad.fr/)
        ### * Gaston SABOY ()
        ### * Jonathan GOMEZ (http://jonathan-gomez.fr/)
        ### * Thibaut FIGUERES (http://thibaut-figueres.fr/)

A Symfony project created on October 18, 2016, 10:01 am.
