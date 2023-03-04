# Projet Grany
Pour récupérer le projet :

Votre version de PHP doit être la version 8.1.12 - Le projet travaille sous Symfony 6.2.4

Cloner le projet par l'intermédiaire des commandes depuis le Terminal grâce à son URL GitLab, pour cela :
	
	1 – Se mettre dans le Terminal sur le répertoire htdocs :
	cd ../../
	cd c:/xampp/htdocs/

	2 - Il faut cloner le projet pour créer le dossier astride dans htdocs, taper la ligne de commande suivante :

	git clone https://gitlab.com/hdfid/astride.git
    
    (adresse URL du projet qui se trouve sur le site GitLab dans la page du projet astride, cliquer dans l'icône « Clone » sur GitLab et choisir l'URL dans la fenêtre Clone with HTTPS)

	Grâce à git clone, vous avez récupéré tous les fichiers et toutes les branches du projet sur votre machine locale

	3 - Pour récupérer les répertoires manquants du projet

		dans le Terminal se mettre sur le répertoire du projet :
		cd ../../
		cd c:/xampp/htdocs/astride

		taper la ligne de commande :

		composer install ou composer i

		S'il y a un blocage au niveau du composer install à cause de la version de PHP faire :
		
		composer update

	4 – Créer la base de données et récupérer les tables du projet :

	Ne pas oublier de lancer le serveur Apache et MySQL dans XAMPP.

	Pour configurer la base de données, on crée un fichier env.local (faire un copie de env.env et le renommer .env.local. Dans le fichier .env.local décommenter la ligne 31 

	#DATABASE_URL="mysql://app:!ChangeMe!@127.0.0.1:3306/app?serverVersion=8&charset=utf8mb4"

	Modifier cette ligne, elle doit correspondre à ça :

	DATABASE_URL="mysql://root:@127.0.0.1:3306/astride?serverVersion=mariadb-10.4.27&charset=utf8mb4"

	ATTENTION : Vérifier que votre version de mariadb est la bonne : Ici c'est la version 10.4.27
	Pour avoir la version de mySQL, taper la ligne de commande :

	mysql -V depuis le dossier xampp\mysql\bin ou aller dans l'accueil de phpMyAdmin pour avoir la version

	Dans ce fichier .env.local, on va ajouter aussi les paramètres de configuration pour Mailhog (outil pour tester des e-mails dans un environnement de développement local) :

	###> symfony/mailer ### 
	MAILER_URL=smtp://localhost:1025 
	EMAIL_SUPPORT=support@hdfid.fr 
	EMAIL_NO_REPLY=noreply+123@hdfid.fr
	MAILER_DSN=smtp://localhost:1025 
	###< symfony/mailer ### 

	ATTENTION : Dans le fichier .env, si ce n'est pas le cas il faut commenter la ligne 31 actuellement active pour la désactiver (mettre # devant la ligne)

	5 – Créer la base de données en utilisant le nom de la BDD du projet, qui s'appelle astride (se mettre sur la branche dev)

		php bin/console doctrine:database:create

        Entrer le nom de la base de données suivant : astride (sans majuscule)

	6 – Faire la migration de la BDD pour récupérer la structure de la BDD (tables du projet)

	taper la ligne de commande :

		php bin/console doctrine:migrations:migrate

	Le message suivant apparaît : ATTENTION ! Vous êtes sur le point d'exécuter une migration 	dans la base de données "nomduProjet" qui pourrait entraîner des modifications de schéma et une perte de données. Êtes-vous sûr de vouloir continuer ? (oui/non) [oui] :

	taper yes puis faire entrer

ATTENTION : Par l'intermédiaire de cette procédure, on récupère la structure de la Base de Données (le nom de BDD et la structure des tables créées), mais pas les données de la BDD. Dans ce cas, il faudrait que l'on récupère un export de la BDD et l'importer grâce à phpMyAdmin.

	7 – Synchroniser les fixtures :

		Deux cas possible :

		7-1 Aucune données à conserver dans la base de données. Dans ce cas, lancer la commande :

			php bin/console doctrine:fixtures:load

		Le message suivant apparaît : ATTENTION ! Vous êtes sur le point d'exécuter une migration dans la base de données "nomduProjet" qui pourrait entraîner des modifications de schéma 	et une perte de données. Êtes-vous sûr de vouloir continuer ? (oui/non) [oui] :

		taper yes puis faire entrer

		7-2 Des tables, notamment de référence, doivent conserver leurs données. Dans ce cas, lancer la commande :

			php bin/console doctrine:fixtures:load --append

		L’option –append permet de ne pas écraser les données de la base de données et notamment les données de ces tables.

		Remarque : Si on veut gagner du temps et éviter la question voulez-vous écraser vos données existantes, on peut ajouter --no-interaction :

			php bin/console doctrine:fixtures:load --no-interaction

Vous pouvez maintenant travailler sur le projet :

    Attention : Penser à changer de branche, vous devez travailler sur votre branche :

    git checkout Nom_de_la_branche_de_travail

## Installation des outils de débugage

PHP-CS-Fixer:
PHP doit être une version minimale de PHP 7.4.0 et une version maximale de PHP 8.1. *. PHP CS Fixer ne fonctionne pas avec la version 8.2.. Pour installer PHP-CS-Fixer dans VS Code :

1 - Installer php-cs-fixer à l'aide de Composer dans le Terminal :

	composer global require-dev friendsofphp/php-cs-fixer

Pour vérifier qu'il est installé :

	php-cs-fixer -v

2 - Installez l'extension php cs fixer par Junstyle dans VS Code.

3 - Dans le fichier composer.json, ajoutez l'enregistrement de dépendance friendsofphp/php-cs-fixer à la section require-dev en écrivant directement :

	"friendsofphp/php-cs-fixer": "3.13.2"

Lancer ensuite la commande suivante pour installer la dépendance php-cs-fixer :

	composer update

Composer créer sur la racine du projet un fichier de configuration .php-cs-fixer.dist

Vérifier que dans le fichier composer.json la présence dans le scripts de php-cs-fixer": ["php-cs-fixer --config=./.php-cs-fixer.dist"], sinon l’ajouter.

Lancer la commande suivante pour connaître la version de php-cs-fixer (ici 3.13.2) :

	php-cs-fixer -v

Dans Vs code, aller dans file/preferences/settings puis dans la fenêtre User/Extensions cliquer sur PHP CS Fixer et configurer PHP CS Fixer en choisissant les paramètres voulus.

Pour mettre à jour php-cs-fixer :

	composer global update friendsofphp/php-cs-fixer

PHPStan :
PHPStan nécessite une version minimale de PHP 7.2.. Pour l'installer lancer la commande :

	composer require --dev phpstan/phpstan

Pour connaitre la version de PHPStan installée :

	vendor/bin/phpstan analyse -V

Installation de l'extension phpstan Symfony :

	composer require --dev phpstan/phpstan phpstan/phpstan-symfony

Cette extension Symfony n'est pas obligatoire, juste recommandée pour améliorer l'intégration avec le framework. Il fournit essentiellement des retours corrects pour certaines méthodes Symfony.

## Outils de débugage

Les vérificateurs locaux de variables classiques :

	Dans un fichier php:

		dd($variable); ou dump($variable);

	Dans un fichier Twig :

		{{ dump($variable) }}

	Dans un fichier JS :

		console.log('value');

Les vérificateurs et correcteurs généraux:

	Formater le code dans un fichier php avec PHP-CS-Fixer

		Pour vérifier manuellement un fichier :

			php-cs-fixer: fix Nom_du_fichier

		Pour vérifier manuellement un dossier :

			php-cs-fixer fix Nom_du_dossier

		Dans Symfony, on vérifie principalement le dossier src :

			php-cs-fixer fix src

	Analyser en statique le code de fichier php avec PhpStan

		Pour laisser PHPStan analyser votre base de code, vous devez utiliser la commande analyse et la pointer vers les répertoires à analyser, sans précision le niveau d’analyse est à 0 par défaut :

			vendor/bin/phpstan analyse Chemin/du/dossier

			vendor/bin/phpstan analyse Chemin/du/dossier/nomdufichier

		Exemple du dossier src à la racine du projet Symfony :

			vendor/bin/phpstan analyse src

		Pour analyser avec un autre niveau (niveau  de 0 à 9) mettre l’option -L numero_niveau.
		Exemple d’un niveau 6 sur le dossier src :

			vendor/bin/phpstan analyse -l 6 src

 		Si on passe par le fichier de configuration phpstan.neon, lancer la commande :

            php vendor/bin/phpstan analyse -c phpstan.neon

			Le fichier phpstan.neon permet de configurer phpstan (choix du niveau d'analyse, choixdes dossiers à analyser ou pas), mais aussi d'ignorer les erreurs phpstan qu'on ne peut/sait pas corriger

		Pour générer une entrée ignoreErrors qui va permettre d'ignorer une erreur :

		Se rendre sur le site suivant et remplir les champs pour générer votre entrée ignoreErrors :
			https://phpstan.org/user-guide/ignoring-errors
		
		Copier entierement le message d'erreur que phpStan vous fournit dans VS-code et le mettre dans le premier champ sur le site. Copier ensuite le nom du fichier concerné avec son chemin d'accès (indiqué aussi dans le message d'erreur) et le coller dans le deuxième champ du site. Le troisième champ génère automatiquement le paramètre pour ignorer, qu'il faut copier et coller dans le fichier phpstan.neon.

	Pour lancer grumphp :

			vendor/bin/grumphp run

	Dans un fichier Twig :

	Vérifier les erreurs de syntaxe des fichiers Twig avec Linting Twig Templates :

		La commande lint:twig vérifie que vos modèles Twig n'ont pas d'erreurs de syntaxe. Il est utile de l'exécuter avant de déployer votre application en production :

		Vérifier tous les modèles d’application:

			php bin/console lint:twig

		# Vous pouvez également vérifier les répertoires et les modèles individuels:

			php bin/console lint:twig templates/email/

			php bin/console lint:twig templates/article/recent_list.html.twig

		# Vous pouvez également afficher les fonctionnalités obsolètes utilisées dans vos modèles:

			php bin/console lint:twig --show-deprecations templates/email/

## Getting started

To make it easy for you to get started with GitLab, here's a list of recommended next steps.

Already a pro? Just edit this README.md and make it your own. Want to make it easy? [Use the template at the bottom](#editing-this-readme)!

## Add your files

- [ ] [Create](https://docs.gitlab.com/ee/user/project/repository/web_editor.html#create-a-file) or [upload](https://docs.gitlab.com/ee/user/project/repository/web_editor.html#upload-a-file) files
- [ ] [Add files using the command line](https://docs.gitlab.com/ee/gitlab-basics/add-file.html#add-a-file-using-the-command-line) or push an existing Git repository with the following command:

```
cd existing_repo
git remote add origin https://gitlab.com/hdfid/astrid.git
git branch -M main
git push -uf origin main
```

## Integrate with your tools

- [ ] [Set up project integrations](https://gitlab.com/hdfid/astrid/-/settings/integrations)

## Collaborate with your team

- [ ] [Invite team members and collaborators](https://docs.gitlab.com/ee/user/project/members/)
- [ ] [Create a new merge request](https://docs.gitlab.com/ee/user/project/merge_requests/creating_merge_requests.html)
- [ ] [Automatically close issues from merge requests](https://docs.gitlab.com/ee/user/project/issues/managing_issues.html#closing-issues-automatically)
- [ ] [Enable merge request approvals](https://docs.gitlab.com/ee/user/project/merge_requests/approvals/)
- [ ] [Automatically merge when pipeline succeeds](https://docs.gitlab.com/ee/user/project/merge_requests/merge_when_pipeline_succeeds.html)

## Test and Deploy

Use the built-in continuous integration in GitLab.

- [ ] [Get started with GitLab CI/CD](https://docs.gitlab.com/ee/ci/quick_start/index.html)
- [ ] [Analyze your code for known vulnerabilities with Static Application Security Testing(SAST)](https://docs.gitlab.com/ee/user/application_security/sast/)
- [ ] [Deploy to Kubernetes, Amazon EC2, or Amazon ECS using Auto Deploy](https://docs.gitlab.com/ee/topics/autodevops/requirements.html)
- [ ] [Use pull-based deployments for improved Kubernetes management](https://docs.gitlab.com/ee/user/clusters/agent/)
- [ ] [Set up protected environments](https://docs.gitlab.com/ee/ci/environments/protected_environments.html)

***

# Editing this README

When you're ready to make this README your own, just edit this file and use the handy template below (or feel free to structure it however you want - this is just a starting point!). Thank you to [makeareadme.com](https://www.makeareadme.com/) for this template.

## Suggestions for a good README
Every project is different, so consider which of these sections apply to yours. The sections used in the template are suggestions for most open source projects. Also keep in mind that while a README can be too long and detailed, too long is better than too short. If you think your README is too long, consider utilizing another form of documentation rather than cutting out information.

## Name
Choose a self-explaining name for your project.

## Description
Let people know what your project can do specifically. Provide context and add a link to any reference visitors might be unfamiliar with. A list of Features or a Background subsection can also be added here. If there are alternatives to your project, this is a good place to list differentiating factors.

## Badges
On some READMEs, you may see small images that convey metadata, such as whether or not all the tests are passing for the project. You can use Shields to add some to your README. Many services also have instructions for adding a badge.

## Visuals
Depending on what you are making, it can be a good idea to include screenshots or even a video (you'll frequently see GIFs rather than actual videos). Tools like ttygif can help, but check out Asciinema for a more sophisticated method.

## Installation
Within a particular ecosystem, there may be a common way of installing things, such as using Yarn, NuGet, or Homebrew. However, consider the possibility that whoever is reading your README is a novice and would like more guidance. Listing specific steps helps remove ambiguity and gets people to using your project as quickly as possible. If it only runs in a specific context like a particular programming language version or operating system or has dependencies that have to be installed manually, also add a Requirements subsection.

## Usage
Use examples liberally, and show the expected output if you can. It's helpful to have inline the smallest example of usage that you can demonstrate, while providing links to more sophisticated examples if they are too long to reasonably include in the README.

## Support
Tell people where they can go to for help. It can be any combination of an issue tracker, a chat room, an email address, etc.

## Roadmap
If you have ideas for releases in the future, it is a good idea to list them in the README.

## Contributing
State if you are open to contributions and what your requirements are for accepting them.

For people who want to make changes to your project, it's helpful to have some documentation on how to get started. Perhaps there is a script that they should run or some environment variables that they need to set. Make these steps explicit. These instructions could also be useful to your future self.

You can also document commands to lint the code or run tests. These steps help to ensure high code quality and reduce the likelihood that the changes inadvertently break something. Having instructions for running tests is especially helpful if it requires external setup, such as starting a Selenium server for testing in a browser.

## Authors and acknowledgment
Show your appreciation to those who have contributed to the project.

## License
For open source projects, say how it is licensed.

## Project status
If you have run out of energy or time for your project, put a note at the top of the README saying that development has slowed down or stopped completely. Someone may choose to fork your project or volunteer to step in as a maintainer or owner, allowing your project to keep going. You can also make an explicit request for maintainers.
