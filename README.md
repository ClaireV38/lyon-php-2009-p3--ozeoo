# Project 3 - OzeLaDiversite - Test

Pour tester le projet Oze la diversité, il vous faut :

  - 250 gr de farine
  - 4 oeufs
  - 1/2 litre de lait
  - 1 pincée de sel
  - 50 gr de beurre
  
Mélanger la farine et le sel, ajouter les oeufs. Quand le mélange s'épaissie ajouter petit à petit le lait. Puis le beurre fondue.
Voila, vous pouvez manger des crepes en testant notre projet.

1/ Composer install
2/ Modifier le .env.local
3/ php bin/console doctrine:database:drop
   php bin/console doctrine:database:create
   php bin/console doctrine:migration:migrate
   php bin/console doctrine:fixtures:load
   
4/ php bin/console make:migration

5/ Vous pouvez tester les inscriptions candidats et entreprises, mais il existe des profils auto générés par les fixtures :

  Vous trouverez la liste des users dans la table user.
  Les mots de passe sont: 
    pour applicant : applicantpassword
    pour company : companypassword
    
 Vous pouvez utiliser le compte, pour la partie company, => company1@monsite.com
                                 pour la partie applicant => utiliser le user avec l'id 1 généré aléatoirement
                                 
 Ils contiennent des annonces avec des matchs ou des annonces qui correspondent au profil
 ns
 6/ Pour tester l'inscription, il faut installer le composant mailer: composer require symfony/mailer
 
        mailtrap: https://mailtrap.io/ 
      créer compte si pas existant
      Aller sur l'icône settings
      Dans la liste déroulante  sous Intégration, sélectionner Symfony
      Copier la ligne MAILER_DSN, l’intégrer dans env.local:

      ###> symfony/mailer ###
      MAILER_DSN= lien donné par mailtrap
      MAILER_FROM_ADDRESS=hello@ozeoo.com
      ###< symfony/mailer ###
      
7/ Pour la partie administrateur,

  adresse mail : admin@monsite.com
  mot de passe : adminpassword
  
  La partie administrateur permettra a OzelaDiversité de vérifier les informations de l'entreprise lors de leur inscription.
  
  Cliquer sur éditer pour valider ou pas valider une entreprise.
  
8/ Voila

