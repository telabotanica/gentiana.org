<?php

//vim: set expandtab tabstop=4 shiftwidth=4:
// +------------------------------------------------------------------------------------------------------+
// | PHP version 4.1                                                                                      |
// +------------------------------------------------------------------------------------------------------+
// | Copyright (C) 2003 Tela Botanica (accueil@tela-botanica.org)                                         |
// +------------------------------------------------------------------------------------------------------+
// |                                                                                                      |
// | This library is free software; you can redistribute it and/or                                        |
// | modify it under the terms of the GNU Lesser General Public                                           |
// | License as published by the Free Software Foundation; either                                         |
// | version 2.1 of the License, or (at your option) any later version.                                   |
// |                                                                                                      |
// | This library is distributed in the hope that it will be useful,                                      |
// | but WITHOUT ANY WARRANTY; without even the implied warranty of                                       |
// | MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the GNU                                    |
// | Lesser General Public License for more details.                                                      |
// |                                                                                                      |
// | You should have received a copy of the GNU Lesser General Public                                     |
// | License along with this library; if not, write to the Free Software                                  |
// | Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA                            |
// |                                                                                                      |
// +------------------------------------------------------------------------------------------------------+
// CVS : $Id: pap_config_avancee.inc.php,v 1.31 2007-08-28 14:13:40 jp_milcent Exp $
/**
* Page de configuration avanc�e de Papyrus
*
* La page contient diff�rents param�tre permettant de configurer, le chronom�trage, le d�bogage, les url...
*
*@package Papyrus
*@subpackage Configuration
//Auteur original :
*@author            Jean-Pascal MILCENT <jpm@tela-botanica.org>
//Autres auteurs :
*@author            Alexandre GRANIER <alex@tela-botanica.org>
*@author            Laurent COUDOUNEAU <laurent.coudouneau@ema.fr>
*@copyright         Tela-Botanica 2000-2004
*@version           $Revision: 1.31 $ $Date: 2007-08-28 14:13:40 $
// +------------------------------------------------------------------------------------------------------+
*/

// +------------------------------------------------------------------------------------------------------+
// |                                            ENT�TE du PROGRAMME                                       |
// +------------------------------------------------------------------------------------------------------+

//test au cas ou il s'agirai d'une nouvelle installation ou si le fichier de conf n'existe pas
if (file_exists('papyrus/configuration/pap_config.inc.php') ) {include_once 'papyrus/configuration/pap_config.inc.php';}
if (!defined("PAP_CHEMIN_RACINE")) define('PAP_CHEMIN_RACINE','');
// +------------------------------------------------------------------------------------------------------+
// Param�trage du mode d'�criture des fichiers sur le serveur
/** Bool�en permetant de savoir si on utilise ou pas le ftp. */
define('GEN_FTP_UTILISE', true) ;//ini_get('safe_mode')

// +------------------------------------------------------------------------------------------------------+
// |                                            CORPS du PROGRAMME                                        |
// +------------------------------------------------------------------------------------------------------+

// +------------------------------------------------------------------------------------------------------+
// Param�trage de la version : NE PAS MODIFIER MANUELLEMENT!
/** Constante stockant la version de Papyrus.*/
define('GEN_VERSION', '0.25');

// +------------------------------------------------------------------------------------------------------+
// Param�trage du d�bogage.
/** Constante stockant une valeur bool�en permettant de savoir si on veut d�boguer le code (true) ou pas (false).*/
define('GEN_DEBOGAGE', true);// true ou false
/** Constante permettant de savoir sous quelle forme le d�bogage va avoir lieu.*/
//define('PAP_DEBOGAGE_TYPE', 'FIREBUG');// HTML ou FIREBUG
define('PAP_DEBOGAGE_TYPE', 'HTML');// HTML ou FIREBUG
/** Constante stockant une valeur correspondant au niveau d'erreur � employer pour le code PHP
* de Papyrus et de ses applications.*/
define('GEN_DEBOGAGE_NIVEAU', E_ALL);// Voir le manuel de PHP pour les diff�rents niveaux disponibles.
/** Constante permettant de savoir si on veut afficher le contexte des variables d'une erreur
* pour le code PHP de Papyrus et de ses applications.*/
define('GEN_DEBOGAGE_CONTEXTE', false);// true or false
/** Constante permettant de savoir la langue pour le d�bogage du code PHP de Papyrus et de ses
* applications.*/
define('GEN_DEBOGAGE_I18N', 'fr');

// +------------------------------------------------------------------------------------------------------+
// Param�trage de l'identification : Auth
$tps = time()+3600*24*30;
/** Constante stockant la dur�e pendant laquelle on m�morise l'identification via un cookie.*/
define('PAP_AUTH_SESSION_DUREE', (int)$tps);// Mettre 0 pour "d�connecter en fin de session" sinon utiliser la variable $tps
/** Constante stockant si oui (true) ou non (false) on met en place la s�curit� avanc�e pour l'identification.*/
define('PAP_AUTH_SECURITE_AVANCEE', true);
/** Constante stockant le pr�fixe pour les noms des sessions Papyrus.*/
define('PAP_AUTH_SESSION_PREFIXE', 'pap-');

// +------------------------------------------------------------------------------------------------------+
// Param�trage du nom du champ servant � identifier un site dans l'url
/** Type du code d'un site pass� dans l'url.*/
define('GEN_URL_ID_TYPE_SITE', 'int');// string ou int
/** Type du code d'un menu pass� dans l'url.*/
define('GEN_URL_ID_TYPE_MENU', 'int');// string ou int
/** Type du code d'un site pour les urls raccourcies.*/
define('GEN_URL_RACCOURCI_ID_TYPE_SITE', 'string');// string ou int
/** Type du code d'un menu pour les urls raccourcies.*/
define('GEN_URL_RACCOURCI_ID_TYPE_MENU', 'string');// string ou int

// +------------------------------------------------------------------------------------------------------+
// Param�trage des cl�s de l'url
// Red�fini le s�parateur utilis� lorsque PHP g�n�re des URLs pour s�parer les arguments. (compatible XHTML strict)
ini_set('arg_separator.output', '&amp;');
/** Nom de la variable pass�e dans l'url et contenant l'identifiant d'un site.*/
define('GEN_URL_CLE_SITE', 'site');
/** Nom de la variable pass�e dans l'url et contenant l'identifiant d'un menu.*/
define('GEN_URL_CLE_MENU', 'menu');
/** Nom de la variable pass�e dans l'url et contenant l'identifiant d'une internationalisation.*/
define('GEN_URL_CLE_I18N', 'langue');
/** Nom de la variable pass�e dans l'url et contenant une date.*/
define('GEN_URL_CLE_DATE', 'date');
/** Nom de la variable pass�e dans l'url et contenant un format.*/
define('GEN_URL_CLE_FORMAT', 'format');

// +------------------------------------------------------------------------------------------------------+
// Param�trage des langues
/** Identifiant de l'I18N par d�faut de Papyrus. */
define('GEN_I18N_ID_DEFAUT', 'fr');

// +------------------------------------------------------------------------------------------------------+
// Noms des sites
/** Nom du site par d�faut d'administration de Papyrus.*/
define('GEN_SITE_DEFAUT', 'admin');

// +------------------------------------------------------------------------------------------------------+
// Param�trage r�ecriture d'URL et erreur HTTP
/** Mot signalant une r�ecriture d'url pr�sent � la base de l'url. */
define('PAP_URL_REECRITURE_MENU', 'page');
/** Mot signalant une r�ecriture d'url pr�sent � la base de l'url. */
define('PAP_URL_REECRITURE_SITE', 'site');
/** Caract�re s�parant les informations constituant le permalien Papyrus. */
// Si vous utilisez "/", vous devrez indiquer le chemin depuis la racine pour les chemins pr�sent dans les squelettes.
// Exemple : "/sites/commun..." et non "sites/commun..."
define('PAP_URL_REECRITURE_SEP', ':');
/** Chemin et nom du fichier affichant une erreur HTTP.*/
define('PAP_FICHIER_ERREUR_HTTP', PAP_CHEMIN_RACINE.'sites/commun/%s/http_erreurs/erreur%s.php');
/** URL absolue du fichier affichant une erreur HTTP.*/
define('PAP_URL_ERREUR_HTTP', '/sites/commun/%s/http_erreurs/erreur%s.php?url=%s');

// +------------------------------------------------------------------------------------------------------+
/** S�parateur dans les chemins d'acc�s aux fichiers.*/
define('GEN_SEP', '/');
/** Chemin relatif par rapport au fichier papyrus.php vers le dossier contenant les fichiers des api.*/
define('GEN_CHEMIN_API', PAP_CHEMIN_RACINE.'api'.GEN_SEP);
/** Chemin relatif par rapport au fichier papyrus.php vers le dossier contenant les fichiers des api.*/
define('PAP_CHEMIN_API_PEAR', GEN_CHEMIN_API.'pear'.GEN_SEP);
/** Chemin relatif par rapport au fichier papyrus.php vers le dossier contenant le reste de l'application Papyrus.*/
define('GEN_CHEMIN_PAP', 'papyrus'.GEN_SEP);
/** Chemin relatif par rapport au fichier papyrus.php vers le dossier contenant les applications clientes.*/
define('GEN_CHEMIN_CLIENT', 'client'.GEN_SEP);
/** Chemin relatif par rapport au fichier papyrus.php vers le dossier contenant les fichiers des sites.*/
define('GEN_CHEMIN_SITES', 'sites'.GEN_SEP);
/** Chemin relatif par rapport au fichier papyrus.php vers le dossier contenant les fichiers de configuration de Papyrus.*/
define('GEN_CHEMIN_CONFIG', GEN_CHEMIN_PAP.'configuration'.GEN_SEP);
/** Chemin relatif par rapport au fichier papyrus.php vers le dossier contenant les fichiers sql d'installation de Papyrus.*/
define('GEN_CHEMIN_INSTAL', GEN_CHEMIN_PAP.'installation'.GEN_SEP);
/** Chemin relatif par rapport au fichier papyrus.php vers le dossier contenant les applications internes � Papyrus.*/
define('GEN_CHEMIN_APPLICATION', GEN_CHEMIN_PAP.'applications'.GEN_SEP);
/** Chemin relatif par rapport au fichier papyrus.php vers le dossier contenant les applettes.*/
define('GEN_CHEMIN_APPLETTE', GEN_CHEMIN_PAP.'applettes'.GEN_SEP);
/** Chemin relatif par rapport au fichier papyrus.php vers le dossier contenant la biblioth�que de codes de Papyrus.*/
define('GEN_CHEMIN_BIBLIO', GEN_CHEMIN_PAP.'bibliotheque'.GEN_SEP.'fonctions'.GEN_SEP);
/** Chemin relatif par rapport au fichier papyrus.php vers le dossier contenant la biblioth�que de codes de Papyrus.*/
define('GEN_CHEMIN_BIBLIO_CLASSE', GEN_CHEMIN_PAP.'bibliotheque'.GEN_SEP.'classes'.GEN_SEP);
/** Chemin relatif par rapport au fichier papyrus.php vers le dossier contenant les traductions de Papyrus.*/
define('GEN_CHEMIN_LANGUE', GEN_CHEMIN_PAP.'langues'.GEN_SEP);
/** Chemin vers le dossier Commun des sites.*/
define('GEN_CHEMIN_COMMUN', GEN_CHEMIN_SITES.'commun'.GEN_SEP);
/** Chemin vers le dossier contenant des fichiers temporaires.*/
define('GEN_CHEMIN_TMP', 'tmp');

// +------------------------------------------------------------------------------------------------------+
// Nom des dossiers d'un site pr�sent dans le dossier de langue.
/** Nom du dossier contenant les squelettes d'un site donn�.*/
define('GEN_DOSSIER_SQUELETTE', 'squelettes');
/** Nom du dossier contenant les feuilles de styles d'un site donn�.*/
define('GEN_DOSSIER_STYLE', 'styles');
/** Nom du dossier contenant les scripts c�t� client d'un site donn�.*/
define('GEN_DOSSIER_SCRIPT', 'scripts');
/** Nom du dossier contenant les images d'un site donn�.*/
define('GEN_DOSSIER_IMAGE', 'images');
/** Nom du dossier contenant les documents d'un site donn�.*/
define('GEN_DOSSIER_DOC', 'documents');
/** Nom du dossier contenant des dossiers et fichiers communs � plusieurs langues.*/
define('GEN_DOSSIER_GENERIQUE', 'generique');

// +------------------------------------------------------------------------------------------------------+
// Nom des fichiers par d�faut d'un site pr�sent dans le dossier de langue.
/** Nom du fichier de configuration principal de Papyrus.*/
define('GEN_FICHIER_CONFIG', 'pap_config.inc.php');
/** Nom du fichier squelette par d�faut d'un site donn�.*/
define('GEN_FICHIER_SQUELETTE', 'defaut.html');
/** Nom du fichier de styles par d�faut d'un site donn�.*/
define('GEN_FICHIER_STYLE', 'defaut.css');
/** Chemin relatif par rapport au fichier papyrus.php vers le dossier contenant les fichiers des wikini*/
define('GEN_CHEMIN_WIKINI', 'wikini'.GEN_SEP);


// +------------------------------------------------------------------------------------------------------+
// Nom des styles de Papyrus.
/** Style erreur.*/
define('GEN_CSS_ERREUR', 'pap_erreur');
// +------------------------------------------------------------------------------------------------------+
//Gestion des actions Papyrus

/** Les sites correspodant aux liens interwiki. */
$GLOBALS['_PAPYRUS_']['interwiki_sites'] = array(
    'Papyrus'       => 'http://'.$_SERVER['HTTP_HOST'].'/'.$_SERVER['PHP_SELF'].'?menu=%s',
    'Weflore'       => 'http://wiki.tela-botanica.org/eflore/wakka.php?wiki=%s',
    'Wikipedia'     => 'http://fr.wikipedia.org/wiki/%s',
    'Wikipedia_fr'  => 'http://fr.wikipedia.org/wiki/%s'
);

/** Les sites correspodant � l'action inclure. */
$GLOBALS['_PAPYRUS_']['inclure_sites'] = array(
    'Papyrus' => array('preg' => '/<!-- start contenu -->(.*)<!-- end contenu -->/Umsi', 'url' => 'http://'.$_SERVER['HTTP_HOST'].'/'.$_SERVER['PHP_SELF'].'?menu=%s'),
    'Wikipedia' => array('preg' => '/<!-- start content -->(.*)<!-- end content -->/Umsi', 'url' => 'http://fr.wikipedia.org/wiki/%s'),
    'Wikipedia_fr' => array('preg' => '/<!-- start content -->(.*)<!-- end content -->/Umsi', 'url' => 'http://fr.wikipedia.org/wiki/%s'),
    'Wikipedia_en' => array('preg' => '/<!-- start content -->(.*)<!-- end content -->/Umsi', 'url' => 'http://en.wikipedia.org/wiki/%s'),
    'Wikini_eFlore' => array('preg' => '/<div class="page">(.*)<\/div>.*<div class="commentsheader">/Umsi', 'url' => 'http://www.tela-botanica.org/wikini/eflore/wakka.php?wiki=%s'),
    'Wikini_isff' => array('preg' => '/<div class="page">(.*)<\/div>.*<div class="commentsheader">/Umsi', 'url' => 'http://www.tela-botanica.org/wikini/isff/wakka.php?wiki=%s')
);
/* +--Fin du code ---------------------------------------------------------------------------------------+
* $Log: pap_config_avancee.inc.php,v $
* Revision 1.31  2007-08-28 14:13:40  jp_milcent
* Modifications pour permettre � l'applette Inclure de fonctionner!
*
* Revision 1.30  2007-04-19 16:54:24  neiluj
* changement de version
*
* Revision 1.29  2007/03/01 11:07:19  jp_milcent
* Gestion de la constante d�finissant le type de d�bogage.
*
* Revision 1.28  2006/12/14 15:01:05  jp_milcent
* Utilisation d'un syst�me permettant de m�moriser les idenitifications.
* Passage � Auth 1.4.3 et DB 1.7.6.
*
* Revision 1.27  2006/11/20 17:48:33  jp_milcent
* Mise � 0 de PAP_AUTH_SESSION_DUREE pour garder la compatibilit� avec les anciennes installations.
*
* Revision 1.26  2006/11/20 17:29:04  jp_milcent
* Ajout d'une constante permettant de g�rer la dur�e des session de Papyrus.
*
* Revision 1.25  2006/10/26 16:29:52  jp_milcent
* Correction erreur redirection en boucle.
*
* Revision 1.24  2006/10/18 10:18:04  jp_milcent
* Gestion des erreurs HTTP par Papyrus.
*
* Revision 1.23  2006/10/11 18:04:11  jp_milcent
* Gestion avanc�e de la r�ecriture d'URL.
*
* Revision 1.22  2006/10/05 13:17:47  ddelon
* Changement Version Papyrus : 0.21 --> 0.24
*
* Revision 1.21  2006/09/13 12:31:18  florian
* ménage: fichier de config Papyrus, fichiers temporaires
*
* Revision 1.20  2006/04/28 12:41:49  florian
* corrections erreurs chemin
*
* Revision 1.19  2006/03/13 21:00:20  ddelon
* Suppression messages d'erreur multilinguisme
*
* Revision 1.18  2006/03/02 10:49:49  ddelon
* Fusion branche multilinguisme dans branche principale
*
* Revision 1.17.2.1  2005/12/01 23:31:57  ddelon
* Merge Head vers multilinguisme
*
* Revision 1.14  2005/04/18 16:40:39  jpm
* Ajout de constantes pour contr�ler les permaliens.
*
* Revision 1.12  2005/04/06 13:22:58  jpm
* Ajout du chemin vers l'API PEAR pr�sente dans le dossier api.
*
* Revision 1.11  2005/02/28 11:12:24  jpm
* Modification des auteurs.
*
* Revision 1.10  2005/02/17 17:56:33  jpm
* Changement de version de 0.2 � 0.21.
*
* Revision 1.9  2004/10/25 16:26:19  jpm
* Changement de la valeur de la variable GEN_VERSION.
*
* Revision 1.8  2004/10/22 17:22:41  jpm
* Modification du au changement de place de l'inclusion de ce fichier dans Papyrus.
*
* Revision 1.7  2004/10/21 18:16:18  jpm
* Ajout de contantes pour le d�bogage et corrections de commentaires.
*
* Revision 1.6  2004/10/19 16:00:23  jpm
* Extraction de constante pour ajout dans le fichier de conf g�r� par l'installateur de Papyrus.
* Ajout de nouvelles constantes.
*
* Revision 1.4  2004/10/14 16:37:04  jpm
* Correction.
*
* Revision 1.3  2004/09/13 17:09:25  jpm
* Red�fini le s�parateur utilis� lorsque PHP g�n�re des URLs pour s�parer les arguments. (compatible XHTML strict)
*
* Revision 1.2  2004/06/16 15:06:45  jpm
* Ajout de constantes de chemin.
*
* Revision 1.1  2004/06/15 15:19:56  jpm
* Changement de nom et d'arborescence de Genesia en Papyrus.
*
* Revision 1.10  2004/05/06 11:14:56  jpm
* Ajout de nouvelles constantes.
*
* Revision 1.8  2004/04/01 11:26:27  jpm
* Ajout et modification de commentaires pour PhpDocumentor.
*
* Revision 1.7  2004/03/31 16:55:44  jpm
* Ajout de constant g�rant l'url.
*
* Revision 1.6  2004/03/27 11:09:21  jpm
* Transformation de variable en constante.
*
* Revision 1.5  2004/03/22 10:58:59  jpm
* Ajout de commentaires.
*
* Revision 1.4  2003/12/16 16:57:59  alex
* mise à jour pour compatibilité avec genesia
*
* Revision 1.3  2003/12/05 14:35:41  alex
* en cours
*
* Revision 1.2  2003/11/24 15:19:52  jpm
* Mise en conformit� avec la convention de codage.
*
* +--Fin du code ----------------------------------------------------------------------------------------+
*/
?>
