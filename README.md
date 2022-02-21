# CryptoRecap V 2.0


CONFIGURATION RECOMMANDEE :
- Serveur AWS EC2 (offre gratuite) ou autre pour faire tourner vos bots
- Serveur AWS EDS (offre gratuite) pour héberger la DB
- Installer Wamp sur votre PC pour pouvoir utiliser en local le dashboard 

Il est fortement recommandé d'utiliser ce systême en local car je n'ai sécurisé aucune requete php. Je ne suis pas responsable si quelqu'un arrive à injecter du code via une requete php


INSTALLATION : 
- Ajouter le dossier 'Dashboard' dans le dossier www de Wamp (ou autre logiciel)
- Remplir les infos de connexion à la DB dans le fichier script.php
  - Par defaut, la DB sera cryptobot

- Mise en place de la DB :
  - Copier coller le code SQL de InstallDB.sql sur votre serveur EDS (ou autre serveur SQL).
  - Répéter l'étape pour chacun de vos bot en pensant à modifier le chiffre. 
  - Vous devez avoir 2 table par bot : orderBook et Bot.

- Placer le fichier recap.py dans le dossier live strategy sur le serveur oú votre bot est hebergé.
- Penser à remplir les infos de connexion à la DB
  - Par defaut, la DB sera cryptobot

- Inserer les morceaux de code dans le fichier de votre bot actif
- Penser à remplir les infos de connexion à la DB
  - Par defaut, la DB sera cryptobot

- Ajouter une ligne dans votre crontab pour lancer recap.py tout les jours
  - 0 5 * * * python3 cBot-Project/live_strategy/Recap.py




################
      FAQ
################

- Q: Impossible de me connecter à ma DB via index.php
  - R: Vérifier de bien avoir rentrer toute les informations de connexion dans script.php

- Q: Impossible de me connecter à ma DB via python
  - R: Vérifier de bien avoir rentrer toute les informations de connexion dau début des différents fichiers

- Q: Erreur de connexion SQL ou délai dépassé avec AWS EDS
  - R: Penser à whitelister votre adresse IP et l'adresse Ip du serveur oú votre bot est hébergé dans les règles entrantes de votre Security group

- Q: Qu'est ce que AWS EDS, AWS EC2, Wamp, ...
  - R: Google :)
