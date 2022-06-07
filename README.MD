# PROJET_DWWM20

## Base

### Création du projet

- Ouvrir un nouveau terminal
- Se rendre dans le dossier où l'on veux créer le projet (ex : wamp64/www) :
```
cd chemin_vers_le_dossier
```
- Créer le projet avec Symfony CLI (pas besoin de créer le dossier du projet) :
```
symfony new --webapp nom_du_projet --version=6.0
```
- Créer le projet avec Composer (pas besoin de créer le dossier du projet)
```
composer create-projet symfony/website-skeleton nom_du_projet ^6.0
```

### Lier à un projet Git

- Créer un dépôt Git sur Github
- Avec un terminal, se rendre dans le dossier du projet (cd chemin_du_dossier ou VSC ou Atom)
- initialiser un dépôt local :

```
git init
```
-lier le dépôt local au dépot distant :
```
git remote add origin https://github.com/nom_d_utilisateur/nom_du_dépot_distant.git
```
-ajoutter tous les fichiers :
```
git add *
```
-donner un nom au commit :
```
git commit -m "message_du_commit"
```
-récupérer les dernières modifications :
```
git pull origin main
```
-envoyer des modifications (ou (master)) :
```
git push origin main
```
-voir la liste des commits (flèches haut et bas pour naviguer dans la liste, q pour quitter) :
```
git log
```

## Composer

### Ajout du Apache-Pack

- suite d'outils pour Apache (barre de débug, routing, .htaccess)
- dans le terminal :
```
composer require symfony/apache-pack
```

### Supprimer un package

- Concerne uniquement le pack encore)
```
composer remove [package présent dans composer.json]
composer remove symfony/webpack-encore-bundle
```

## Commandes Symfony

### Connexion au Serveur

- Démarrer le serveur (moins pratique qu'en arrière-plan): (Ctrl + C pour quitter)
```
symfony server:start
```

- Démarrer le serveur en arrière plan (règlera certains soucis comparer au démarrage normal)
```
symfony server:start -d
```

- Arrêter le service :
```
symfony server:stop
```

## Git

### RÉCUPÉRER UN FICHIER

- Télecharger le zip ou faire un pull sur un nouveau dossier
```
git init
```
```
git remote add origin https://github.com/nom_d_utilisateur/nom_du_dépot_distant.git
```
- Recréer le fichier .env à la racine du projet (avc ses propres informations), les informations importantes sont APP_ENV, APP_SECRET, DATABASE_URL et MAILER_URL)

- Mettre à jour le projet (installer les dépendances, génerer le cache)
```
composer install
```

## Autres Commandes

## Visualiser les routes

- voir toutes les routes :
```
php bin/console debug:router
```
- mise en forme de la route (vérifie que la route existe dans le Controller)
```
php bin/console route:match /url_de_la_route
```

## Liste des Actions lors du projet

### Création de la BDD

- .env, créer le chemin d'accès dans ce fichier : ([BDD_utilisé]://[nom_utilisateur]:[mdp_utilisateur]@[adresse_connexion]:[port_connexion]/[nom_BDD]?serverVersion=5.7)
```
DATABASE_URL="mysql://root:@127.0.0.1:3306/symfony_dwwm20?serverVersion=5.7"
```

- Créer la BDD avec la commande doctrine
```
php bin/console doctrine:database:create
```

- Créer une entité (table) (le fichier sera créer dans le dossier : src/Entity):
```
php bin/console make:entity nom_de_l_entite
```
(note : suivre les indications selon les besoins de la BDD)
(Pour lier deux tables, utiliser le type relation : n;1 / 1;n / n;n / 1;1 )

- Exeption : créer un utilisateur :
```
php bin/console make:user
```
- Modifier l'utilisateur :
```
php bin/console make:entity User
```

(note : une valeur unique est demandé : laisser en email pour avoir un champ unique pour chaque user)

- migration (vérification + doctrine):
```
php bin/console make:migration
```
```
php bin/console doctrine:migrations:migrate
```

### FIXTURES (à part)
- installer le bundle (fixtures permet de créer des données bidons pour faire des tests)
```
composer require --dev orm-fixtures
```
- compléter le fichier srv/DataFixtures/AppFixtures.php
- persist ()
- flush()

- envoyer en base de données (en écrasant les données existantes)
```
php bin/console doctrine:fixtures:load
```

- envoyer en base de données (en ajoutant à la suite)
```
php bin/console doctrine:fixtures:load --append
```

- bundle pour générer de fausses données :
```
composer require fakerphp/faker
```

### Créer un formulaire

- créer le formulaire :
```
php bin/console make:form nom_du_formulaire
```
- mise en forme des formulaires avec un thème (config/packages/twig.yaml) :
```
twig:
    form_themes: ['bootstrap_5_layout.html.twig']
```

### Gestion des Comptes

#### 1. Créer le User
- créer l'entité User (nom + préciser la valeur unique) :
```
php bin/console make:user
```
- ajouter des champs à l'entité User  :
```
php bin/console make:entity user
```
- migration (habituelle)

#### 2. Créer le formulaire de création du compte

- créer le formulaire d'inscription
```
php bin/console make:registration-form
```
- 1
- LoginFormAuthenticator
- SecurityController
- yes

- Installer le package manquant
```
composer require symfonycasts/verify-email-bundle
```
- modifier la dernière redirection après la vérification de l'adresse mail (RegistrationController::verifyUserEmail())
- gérer l'affichage des messages flash (register.html.twig, ...)
- personnaliser le formulaire, le controller et les templates
- migration pour gérer la propriété User::isVerified

- (Après la vérification du fonctionnement du mail) Installer Rollerworks (pour vérifier la sécurité du mdp)
```
composer require rollerworks/password-strength-bundle
```
-dans le formulaire
```
use Rollerworks\...\PasswordStrength;
....
new PasswordStrength
```
- y ajouter les contraintes souhaitées

### EMAIL

- installer le mailer :
```
composer require symfony/mailer
```
- installer le package tiers (uniquement les mails google, voir doc → mailer, 3rd party transport):
```
composer require symfony/
```
