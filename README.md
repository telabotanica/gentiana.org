# gentiana.org

Site Web gentiana.org, basé sur le CMS Papyrus. Inclut une copie de Papyrus et des applications clientes

Réintégration depuis le SVN de Tela Botanica / la copie de test d'Orobanche (2017)

## Installation
* cloner dans `_dossier_web_/gentiana.org`
* à la racine du dossier web, lier les fichiers/dossiers du site :
```
ln -s gentiana.org/accueil accueil
ln -s gentiana.org/animation animation
ln -s gentiana.org/api api
ln -s gentiana.org/client client
ln -s gentiana.org/erreur_http.php erreur_http.php
ln -s gentiana.org/favicon.ico favicon.ico
ln -s gentiana.org/.htaccess .htaccess
ln -s gentiana.org/index.php index.php
ln -s gentiana.org/papyrus papyrus
ln -s gentiana.org/papyrus.php papyrus.php
ln -s gentiana.org/sites sites
```

## À savoir
Nécessite `register_globals` ou [une simulation](http://www.kaffeetalk.de/using-register_globals-in-php-5-5/) pour fonctionner

La directive `error_reporting` de PHP est écrasée par Papyrus, voir `papyrus/configuration/pap_config_avancee.inc.php` ligne 67

Les contenus suivants ne sont pas versionnés (trop lourd) :
 * sites/flore/generique/images/cartes
 * sites/commun/generique/fckeditor

