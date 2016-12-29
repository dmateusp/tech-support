English version: README.md
# Systeme pour la gestion d'objets casses (dans les chambres d'hotels ou les bureaux), gestion d'evenements et de lignes de telephone (cree pour un hotel!)

Le nom de l'application est "support-technique" car l'application etait au depart purement une application de gestion de tickets techniques, mais durant le stage elle a evoluee.

## Utiliser l'application
1. Installez et lancez `Docker` sur votre machine
2. Telechargez et decompressez ce projet (ou utilisez git pour le cloner)
3. Ouvrez une console a la racine du projet
4. tappez `docker-compose up` et validez (cette commande va telecharger et demarrer tous les services et toutes les dependances, toujours dans les containers)
5. allez a 192.168.99.100 pour acceder a l'application et utilisez `admin` comme nom d'utilisateur et `helloworld` comme mot de passe
5. OU POUR GERER LA BASE DE DONNEES allez a 192.168.99.100:8181 pour ouvrir phpMyAdmin et utilisez `root` comme nom d'utilisateur et `YOURPASSWORD` comme mot de passe
6. changez vos mots de passe!

## Ou est ma base de donnees?
Votre BDD est contenue dans les containers, cependant, les donnees sont sauvegardees sous `./database/mysql/data`

## Puis-je utiliser ce logiciel?
Bien sur! c'est gratuit et open source, vous pouvez meme le modifier, adapter, ameliorer et me proposer vos changements sur GitHub.
Pour me contacter: dmateusp@gmail.com.

## Devrais-je utiliser ce logiciel?
Ce logiciel est propose sans garantie de fonctionnement.
Cependant, le logiciel fut utilise pendant 3 ans et est toujours utilise dans un grand hotel/centre de conference et je n'ai eu a faire de support a aucun moment!

## Developpement et histoire
J'ai developpe ce logiciel en 2eme annee d'universite pendant mon stage dans un hotel. Mon role etait de trouver des procedes qui pouvaient etre ameliores a l'hotel en utilisant l'outil informatique (et de developper ces solutions). Le code et le design est tel qu'il etait a la fin du developpement, les imperfections de design et code viennent de mon manque d'experience a l'epoque de la creation.

## Ce que fait le logiciel
* Administrateur peut gerer et creer des utilisateurs pour le logiciel, de plusieurs types: (Utilisateur, Service technique, Coordinateur, Standard, Administrateur)
* Administrateur peut gerer et creer des objets comme des TVs, des telephones etc. Cette fonction a ete ajoutee car la plupart du staff du service de chambre ne parlait pas Francais et il etait difficile pour eux d'ecrire correctement le nom des objets
* Utilisateur peut creer des demandes de support (example de l'employe de l'hotel qui veut signaler une imprimante cassee)
* Marketing (Coordinateur) peut creer et gerer des evenements et faire de demandes de lignes telephoniques pour ces derniers
* Reception (Standard) peut voir les demandes de lignes telephoniques pour pouvoir brancher ou debrancher ces lignes suivant les besoins

## Technologies
Cette application marche avec Apache http server, PHP, Yii Framework (pre-2.0), phpMyAdmin et une base de donnees MySQL.

Pour une installation simple et un environnement stable elle est contenue dans des "containers" Docker