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

7. Importer la base de donnée :
   - `mysql -u db_user -p db_name < ozeoo.sql`
   
   
### Mise en route
1. Lancer `symfony server:start` pour démarrer le serveur local
2. Lancer `yarn run dev --watch` pour charger les assets

### Mail
Pour configurer votre adresse Mail de contact, il faut ajouter dans le fichier .env.local les lignes suivantes:

      ###> symfony/mailer ###
      MAILER_FROM_ADDRESS=email@example.com
      ###< symfony/mailer ###

### Pour l'administrateur : modalités pour vérifier les entreprises
1. Se connecter avec l'email de contact Ozé La Diversité
2. Vous êtes redirigé vers l'interface Administrateur
3. Dans le menu à gauche, cliquer sur le lien "Gestion Entreprises"
4. La liste de toutes les entreprises s'affiche. Les entreprises "non vérifiées" apparaissent automatiquement en haut de liste. Les entreprises "vérifiées" apparaissent comme telles.
5. Pour accorder le statut "Vérifiée" à une entreprise, cliquer sur le bouton "Editer" à droite
6. Les données de l'entreprise s'affichent dans une fenêtre blanche
7. Au dessus de la fenêtre, cliquer su le lien bleu "Vérifier"
8. Sauvegarder les modifications
9. Se déconnecter en haut à droite
