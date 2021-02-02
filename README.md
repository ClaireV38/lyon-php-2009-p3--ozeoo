# Project 3 - OzeLaDiversite : Test

Ce projet a pour base le Symfony website-skeleton.

### Concept
Imaginé par le cabinet RH Ozé La Diversité, Ozeoo a été ensuite conçu par une équipe de jeunes développeurs issus de la Wild Code School.
Ozeoo est une plateforme de mise en relation de profils atypiques et entreprises en vue d'un recrutement.

Le site web contient des offres d'emploi basées sur des compétences. Si les compétences requises correspondent à celles du candidat, un "match" a lieu, et le candidat peut alors postuler à l'offre.
Un match existe dès lors qu'au moins 5 soft skills (savoir-être) et 5 hard skills (savoir-faire) du candidat correspondent à celles exigées par l'entreprise.

### Installation
1. Faire un `git clone https://github.com/WildCodeSchool/lyon-php-2009-p3--ozeladiversite`
2. Copier la ligne suivante du fichier .env : `DATABASE_URL=mysql://db_user:db_password@127.0.0.1:3306/db_name`. A la racine, créer un nouveau fichier .env.local et y coller la ligne.
Remplacer les valeurs comme suit :
- `db_user` = nom d'utilisateur courant en base de données
- `db_password` = mot de passe habituel
- `db_name` = nom de la base de données (au choix)
3. Lancer `composer install`
4. Lancer `yarn install`
5. Lancer `yarn encore dev`
6. Lancer dans l'ordre suivant :
   - `php bin/console doctrine:database:create`
   - `php bin/console doctrine:migration:migrate`
   - `php bin/console doctrine:fixtures:load`

### Mise en route
1. Lancer `symfony server:start` pour démarrer le serveur local
2. Lancer `yarn run dev --watch` pour charger les assets

### Credentials
Pour tester les users, vous trouverez les emails et mots de passe du compte admin par défaut, d'un compte entreprise et d'un compte candidat dans les fixtures.                                    
 
### Tests avancés
Pour tester l'inscription candidat et entreprise, installer le composant Mailer en lançant : `composer require symfony/mailer`
 
      Se rendre sur https://mailtrap.io/ 
      Créer un compte ou s'y connecter
      Cliquer sur l'icône "Settings"
      Dans la liste déroulante sous "Intégration", sélectionner "Symfony"
      Copier la ligne MAILER_DSN, l’intégrer dans env.local à cet endroit :

      ###> symfony/mailer ###
      MAILER_DSN= lien donné par Mailtrap
      MAILER_FROM_ADDRESS=hello@ozeoo.com
      ###< symfony/mailer ###

