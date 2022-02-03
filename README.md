# Checkpoint4_Nathan_Chapelle

## Installations 
Afin de commencer à travailler sur le projet, suivez ce read me afin de bien installer le projet sur votre machine :)

Tout d’abord clonez le repo dans le dossier où vous le voulez avec
<pre><code>git clone git@github.com:WildCodeSchool/orleans-202109-php-project-cerha.git</code></pre>

Ensuite mettez-vous dans le dossier du projet.

Maintenant installez les différentes dépendances avec
<pre><code>composer Install</code></pre> Et <pre><code>yarn install</code></pre>

N’oubliez pas de faire un <pre><code>yarn encore dev</code></pre> Afin de build les fichiers du site dans le cache.

## Configuration 
Maintenant les installations faites, il faut configurer votre projet.
Créez un dossier .env.local (faites un copié/collé de .env) et ajouter votre base de données
> DATABASE_URL="mysql://db_user:db_password@127.0.0.1:3306/db_name?serverVersion=8.0"

Remplacez db_user/db_password par votre utilisateur MySql et db_name par le nom de votre base de données ici (cerha par exemple)

Il faut maintenant ajouter le MAILER afin que le site fonctionne bien
Allez sur votre site préféré pour tester les mails (nous utiliserons Mailtrap ici)
Cliquez sur My Inbox, dans SMTP settings, sélectionnez Symfony 5+ dans la catégorie intégration et copiez la ligne MAILER_DSN
Ensuite, toujours dans env.local, dans la partie dédiée au Mailer collez le mailer  sans mettre de #
Ensuite, mettez l’adresse email de votre choix sur la ligne MAILER_FROM_ADDRESSE en retirant le #.

## Base de données
Maintenant il ne reste plus qu’à configurer la Base de Données.

Vous aurez besoin de faire un <pre><code>php bin/console doctrine:database:create</code></pre> afin de créer la base de données localement
Ensuite <pre><code>php bin/console doctrine:migration:migrate</code></pre> afin d’avoir les bonnes tables et les bons champs
Et enfin <pre><code>php bin/console doctrine:fixtures:load</code></pre> afin de remplir la base de données et de bien tester l’application.

Il ne manque plus qu’à faire <pre><code>symfony server:start</code></pre> afin de démarrer le serveur Symfony.
Vous pouvez maintenant utiliser notre merveilleux site en allant sur localhost:8000 :D !

## Comptes

Si vous voulez vous connecter sur le site, vous pouvez vous inscrire ou utiliser le compte john@doe.com avec "whoami" comme mot de passe

## Ressources

Vous pourrez admirer mon magnifique figma [ici](https://www.figma.com/file/Gkgw8Opg4luQCfgOh9Oj0L/Focusse)
Et vous pourrez voir mon backlog [la](https://docs.google.com/spreadsheets/d/1QCqZhjap4UufvBpsEKdQKtp0QFjjrJZ-dOknnC9FSag/edit#gid=0)
