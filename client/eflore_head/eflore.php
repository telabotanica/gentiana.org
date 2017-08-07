<?php
/*vim: set expandtab tabstop=4 shiftwidth=4: */
// +------------------------------------------------------------------------------------------------------+
// | PHP version 4.3  																					|
// +------------------------------------------------------------------------------------------------------+
// | Copyright (C) 2004 Tela Botanica (accueil@tela-botanica.org) 										|
// +------------------------------------------------------------------------------------------------------+
// | This file is part of eFlore-consultation.															|
// |  																									|
// | Foobar is free software; you can redistribute it and/or modify   									|
// | it under the terms of the GNU General Public License as published by 								|
// | the Free Software Foundation; either version 2 of the License, or									|
// | (at your option) any later version.  																|
// |  																									|
// | Foobar is distributed in the hope that it will be useful,											|
// | but WITHOUT ANY WARRANTY; without even the implied warranty of   									|
// | MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the										|
// | GNU General Public License for more details. 														|
// |  																									|
// | You should have received a copy of the GNU General Public License									|
// | along with Foobar; if not, write to the Free Software												|
// | Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA							|
// +------------------------------------------------------------------------------------------------------+
// CVS : $Id: eflore.php,v 1.64 2007-08-23 08:13:25 jp_milcent Exp $
/**
* Fichier principal des modules d'eFlore.
*
* Ce fichier correspond au patter FontController. Il est systématiquement appelé. Il identifie le module et
* l'action demandée. Il exécute alors l'action puis passe son résultat à la vue liée. Le résultat de la vue est alors
* renvoyée en fonction du format demandé.
*
*@package eFlore
//Auteur original :
*@author		Linda ANGAMA <linda_angama@yahoo.fr>
//Autres auteurs :
*@author		Jean-Pascal MILCENT <jpm@tela-botanica.org>
*@copyright 	Tela-Botanica 2000-2004
*@version   	$Revision: 1.64 $
// +------------------------------------------------------------------------------------------------------+
*/

// +------------------------------------------------------------------------------------------------------+
// |											ENTÊTE du PROGRAMME   									|
// +------------------------------------------------------------------------------------------------------+
// +------------------------------------------------------------------------------------------------------+
// Variable globale de l'application
/** Definition de la variable globale d'eFlore.*/
$GLOBALS['_EFLORE_'] = array();

// +------------------------------------------------------------------------------------------------------+
// Gestion du chemin de l'application et de son dossier de configuration
if (!defined('PAP_VERSION')) {
	/** Constante "dynamique" stockant le chemin absolue de base de l'application recherche de plante.*/
	define('EF_CHEMIN_APPLI', dirname(realpath($_SERVER['SCRIPT_FILENAME'])).DIRECTORY_SEPARATOR);
	/** Constante "dynamique" stockant le chemin relatif de base de l'application recherche de plante.*/
	define('EF_CHEMIN_APPLI_RELATIF', str_replace(realpath($_SERVER['DOCUMENT_ROOT']), '', EF_CHEMIN_APPLI));	
} else {
	/** Constante "dynamique" stockant le chemin absolue de base de l'application recherche de plante.*/
	define('EF_CHEMIN_APPLI', dirname(realpath(__FILE__)).DIRECTORY_SEPARATOR);
	/** Constante "dynamique" stockant le chemin relatif de base de l'application recherche de plante.*/
	define('EF_CHEMIN_APPLI_RELATIF', str_replace($_SERVER['DOCUMENT_ROOT'], '', EF_CHEMIN_APPLI));
}
/** Constante stockant le chemin et le nom du fichier contenant la fonction d'autoload des classes.*/
require_once EF_CHEMIN_APPLI.'autoload.inc.php';
/** Constante stockant le chemin vers le dossier configuration.*/
define('EF_CHEMIN_CONFIG', EF_CHEMIN_APPLI.'configuration'.DIRECTORY_SEPARATOR);

// +------------------------------------------------------------------------------------------------------+
// Inclusion des fichiers propres à l'appli
// Tentative d'inclusion du fichier de configuration spécifique à un déploiment de l'appli
if (file_exists(EF_CHEMIN_CONFIG.'ef_config.inc.php')) {
	/** Inclusion du fichier config spécifique de l'application eflore. */
	require_once EF_CHEMIN_CONFIG.'ef_config.inc.php';
} else {
	$message = 'Fichier introuvable : '.EF_CHEMIN_CONFIG.'ef_config.inc.php ';
	$message .= 'Veuillez configurer l\'application!';
	die($message);
}
/** Inclusion du fichier config des chemins d'eflore. */
require_once EF_CHEMIN_CONFIG.'ef_config_chemin.inc.php';
/** Inclusion du fichier config de la base de données d'eflore. */
require_once EF_CHEMIN_CONFIG.'ef_config_bdd.inc.php';
/** Inclusion du fichier config des paramêtres propre à eflore. */
require_once EF_CHEMIN_CONFIG.'ef_config_eflore.inc.php';

// +------------------------------------------------------------------------------------------------------+
// Inclusion de l'API PEAR BD qui n'arrive pas être inclu par autoload...
/** Inclusion de la classe PEAR d'abstraction de base de donnée. */
//require_once EF_CHEMIN_PEAR.'DB.php';

// +------------------------------------------------------------------------------------------------------+
// Gestion du fonctionnement hors Papyrus
if (!defined('PAP_VERSION')) {
	/** Inclusion du fichier config pour un fonctionnement hors de Papyrus. */
	require_once EF_CHEMIN_CONFIG.'ef_config_papyrus.inc.php';
} else {
	// Création de l'identification du site à partir de celle de Papyrus
	$GLOBALS['_EFLORE_']['identification'] = new EfloreIdentification($GLOBALS['_GEN_commun']['pear_auth']);
}

// +------------------------------------------------------------------------------------------------------+
// Gestion de la langue de l'application et inclusion des fichiers nécessaires
/** Constante "dynamique" stockant la langue demandée par l'utilisateur pour l'application.*/
define('EF_LANGUE', substr($GLOBALS['_GEN_commun']['i18n'], 0, 2));
// Si une valeur n'a pas était traduite, elle apparaîtra dans la langue principale
if (EF_LANGUE != EF_LANGUE_PRINCIPALE) {
	/** Inclusion du fichier de langue principal de l'application eflore. */
	require_once EF_CHEMIN_LANGUE.'ef_langue_'.EF_LANGUE_PRINCIPALE.'.inc.php';
}
/** Inclusion du fichier de langue demandé par l'utilisateur de l'application eFlore. */
require_once EF_CHEMIN_LANGUE.'ef_langue_'.EF_LANGUE.'.inc.php';

// +------------------------------------------------------------------------------------------------------+
// Inclusion des fichiers propres à l'appli (utilisant PEAR)
/** Inclusion du fichier config des URLs de l'application eflore. */
require_once EF_CHEMIN_CONFIG.'ef_config_url.inc.php';

// +------------------------------------------------------------------------------------------------------+
// Utilisation du chornométrage.
// Doit toujours être créé, sinon il faut mettre des conditions à chaque mesure de temps...
$GLOBALS['_EFLORE_']['chrono'] = new Chronometre();

// +------------------------------------------------------------------------------------------------------+
// Gestion de variables

// Attribution à la variable de session des recherches effectuées
if (isset($_POST['eflore_form_nomenclature']) || isset($_POST['eflore_form_taxonomie'])) {
	$_GLOBALS['_EFLORE_']['rechercher'] = $_POST;
}

// Gestion des paramêtres passés par Papyrus
if (isset($GLOBALS['_GEN_commun']['info_application']->module)) {
 		$_GET[EF_LG_URL_MODULE] = $GLOBALS['_GEN_commun']['info_application']->module;
}
if (isset($GLOBALS['_GEN_commun']['info_application']->action) && !isset($_GET[EF_LG_URL_ACTION])) {
 		$_GET[EF_LG_URL_ACTION] = $GLOBALS['_GEN_commun']['info_application']->action;
}

// Module par défaut
if (!isset($_GET[EF_LG_URL_MODULE])) {
	$_GET[EF_LG_URL_MODULE] = 'recherche';
}

//En fonction du module, nous définissons l'action par défaut.
if (!isset($_GET[EF_LG_URL_ACTION])) {
	switch ($_GET[EF_LG_URL_MODULE]) {
		case 'fiche' :
			$_GET[EF_LG_URL_ACTION] = 'synthese';
			break;
		case 'recherche' :
			$_GET[EF_LG_URL_ACTION] = 'accueil';
			break;
		default:
			$_GET[EF_LG_URL_ACTION] = '';
	}
}

// Format par défaut
if (!isset($_GET[EF_LG_URL_FORMAT])) {
	$_GET[EF_LG_URL_FORMAT] = 'html';
}

// +------------------------------------------------------------------------------------------------------+
// |											CORPS du PROGRAMME										|
// +------------------------------------------------------------------------------------------------------+

function afficherContenuMenu()
{
	$sortie  = '';
	return $sortie;
}

function afficherContenuNavigation()
{
	$sortie  = '&nbsp;';
	$afficher_onglet = false;
	//En fonction du module, si celui-ci doit contenir des onglets, nous définissons l'action par défaut.
	switch ($_GET[EF_LG_URL_MODULE]) {
		case 'fiche' :
			$afficher_onglet = true;
			break;
		case 'recherche' :
			$afficher_onglet = true;
			break;
	}

	if ($afficher_onglet == true) {
		$ancien_action = $_GET[EF_LG_URL_ACTION];
		$ancien_format = $_GET[EF_LG_URL_FORMAT];
		$Registre = Registre::getInstance();
		$Registre->set('onglet', $ancien_action);
		$_GET[EF_LG_URL_ACTION] = EF_LG_URL_ACTION_ONGLET;
		$_GET[EF_LG_URL_FORMAT] = aVue::FORMAT_HTML;
		$sortie = afficherContenuCorps();
		$_GET[EF_LG_URL_ACTION] = $ancien_action;
		$_GET[EF_LG_URL_FORMAT] = $ancien_format;
	}
	return $sortie;
}

function afficherContenuTete()
{
	$sortie  = '';
	return $sortie;
}

function afficherContenuCorps()
{
	// +--------------------------------------------------------------------------------------------------+
	// Initialisation
	$sortie = '';
	$Registre = Registre::getInstance();
	if (isset($_GET[EF_LG_URL_FORMAT])) {
		$Registre->set(EF_LG_URL_FORMAT, $_GET[EF_LG_URL_FORMAT]);
	}
	// TODO : supprimer la condition ci-dessous une fois toutes les appli portées vers le nouveau système de module
	if ($_GET[EF_LG_URL_ACTION] == '') {
		$_GET[EF_LG_URL_ACTION] = null;
	}
	if (isset($_GET[EF_LG_URL_ACTION])) {
		$Registre->set(EF_LG_URL_ACTION, $_GET[EF_LG_URL_ACTION]);
	}
	
	// +--------------------------------------------------------------------------------------------------+
	// Gestion des actions
	$chemin_module = EF_CHEMIN_MODULE.'ef_'.$_GET[EF_LG_URL_MODULE].'/ef_'.$_GET[EF_LG_URL_MODULE].'.php';
	$module_nom = implode('', array_map('ucfirst', explode('_', $_GET[EF_LG_URL_MODULE])));
	$chemin_module_nouveau = EF_CHEMIN_MODULE.strtolower($_GET[EF_LG_URL_MODULE]).'/'.$module_nom.'.class.php';
	
	if (file_exists($chemin_module)) {//&& !file_exists($chemin_module_nouveau)
			// TODO : supprimer la condition ci-dessous une fois toutes les appli portées vers le nouveau système de module
			if ($_GET[EF_LG_URL_ACTION] == 'pied_page') {
				$sortie  = 	'<p id="eflore_pied_page">'.$GLOBALS['_EF_']['i18n']['_defaut_']['pied_page']['info'].
					'<a href="mailto:'.$GLOBALS['_EF_']['i18n']['_defaut_']['pied_page']['mail'].'">'.
						$GLOBALS['_EF_']['i18n']['_defaut_']['pied_page']['mail'].
					'</a>'.$GLOBALS['_EF_']['i18n']['_defaut_']['general']['point'].
				'</p>';
				return $sortie;
			}
			
			// Chargement du module demandé
			include_once $chemin_module;
			$classe_nom_module = 'Ef'.str_replace('_', '', ucwords($_GET[EF_LG_URL_MODULE]));
			$un_module = new $classe_nom_module();
			$un_module->setFormat($_GET[EF_LG_URL_FORMAT]);
			$sortie = $un_module->executer($_GET[EF_LG_URL_ACTION]);
			
			switch($_GET[EF_LG_URL_FORMAT]) {
				case aVue::FORMAT_HTML :
					// +--------------------------------------------------------------------------------------------------+
					// Remplacement du titre fournit par Papyrus par celui créé dans l'appli
					if (defined('PAP_VERSION') && !empty($GLOBALS['_EFLORE_']['titre'])) {
						$GLOBALS['_PAPYRUS_']['rendu']['TITRE_PAGE'] = $GLOBALS['_EFLORE_']['titre'];
					}
					
					// +--------------------------------------------------------------------------------------------------+
					// A FAIRE : Gestion des statistiques
					// Dans le cas de l'action Wiki, nous n'analysons pas les balises car cela remplace les actions Wikini...
					if (isset($_GET[EF_LG_URL_ACTION]) && $_GET[EF_LG_URL_ACTION] != 'wiki') {
						// +------------------------------------------------------------------------------------------------------+
						// Gestion des inclusions des fichiers d'applettes présentes dans le squelette
						$GLOBALS['_EFLORE_']['info_applette'] = array();
						$Applette = new Applette();
						
						$Applette->parserBaliseApplette($sortie, true);
						// +------------------------------------------------------------------------------------------------------+
						// Remplacement des balises des applettes de Papyrus et des Clients dans le squelette avant les appli
						$sortie = $Applette->remplacerBaliseApplette($sortie);
					}
					return EfloreEncodage::remplacerEsperluette($sortie);
					break;
				case aVue::FORMAT_EXIT_HTML :
					echo EfloreEncodage::remplacerEsperluette($sortie);
					exit();
					break;
				case aVue::FORMAT_JSON :
					echo $sortie;
					exit();
					break;
				case aVue::FORMAT_PDF :
					header('Content-type: application/pdf');
					header('Content-Length: '.strlen($sortie));
					header('Content-Disposition: inline; filename='.str_replace(' ', '_', $GLOBALS['_EFLORE_']['titre_fichier']).'.pdf');//
					echo $sortie;
					break;
			}
	} else if (file_exists($chemin_module_nouveau)) {
		include_once $chemin_module_nouveau;
		$Module = new $module_nom();
		$sortie = $Module->traiterAction();
		$Applette = new Applette();
		$Applette->parserBaliseApplette($sortie, true);
		$sortie = $Applette->remplacerBaliseApplette($sortie);
		return $sortie;
	} else {
		trigger_error('Module '.$_GET[EF_LG_URL_MODULE].' introuvable!', E_USER_ERROR);
	}
}

function afficherContenuPied()
{
	$sortie  = '&nbsp;';
	$ancien_action = $_GET[EF_LG_URL_ACTION];
	$ancien_format = $_GET[EF_LG_URL_FORMAT];
	$_GET[EF_LG_URL_ACTION] = 'pied_page';
	$_GET[EF_LG_URL_FORMAT] = aModule::SORTIE_HTML;
	$sortie = afficherContenuCorps();
	$_GET[EF_LG_URL_ACTION] = $ancien_action;
	$_GET[EF_LG_URL_FORMAT] = $ancien_format;
	return $sortie;
}

/* +--Fin du code ----------------------------------------------------------------------------------------+
*
* $Log: eflore.php,v $
* Revision 1.64  2007-08-23 08:13:25  jp_milcent
* Amélioration de la gestion des onglets et des paramêtres par défaut.
*
* Revision 1.63  2007-08-08 17:33:26  jp_milcent
* Transformation du pied de page en action gérée par les modules.
*
* Revision 1.62  2007-07-24 14:33:18  jp_milcent
* Correction permettant de gérer une identification Pear::Auth extérieure.
*
* Revision 1.61  2007-07-18 11:54:58  jp_milcent
* Amélioration des paramêtres passés via Papyrus.
*
* Revision 1.60  2007-07-17 07:46:58  jp_milcent
* Séparation de l'autoload dans un fichier à part.
*
* Revision 1.59  2007-06-25 16:39:48  jp_milcent
* Utilisation de la constante stockant le type de séparation de dossier.
*
* Revision 1.58  2007-06-25 13:37:58  jp_milcent
* Compatibilité de la gestion des chemins de l'appli avec une utilisation dans Papyrus.
*
* Revision 1.57  2007-06-25 13:25:41  jp_milcent
* Complément au message demandant la configuration de l'appli.
*
* Revision 1.56  2007-06-19 10:32:57  jp_milcent
* Début utilisation de classes par module utilisant l'API 1.1.1.
* Renomage des anciennes classes en "Deprecie".
*
* Revision 1.55  2007-06-11 12:47:08  jp_milcent
* Fusion correction provenant de la livraison Moquin-Tandon : 11 juin 2007
*
* Revision 1.54  2007-06-01 13:23:05  jp_milcent
* Fusion avec livraison Moquin-Tandon : 01 juin 2007
*
* Revision 1.49.2.2  2007-05-14 14:14:26  jp_milcent
* Correction bogue applette wikini...
*
* Revision 1.53  2007-02-12 14:54:08  jp_milcent
* Amélioration de la gestion des chemins de l'appli.
*
* Revision 1.52  2007/02/10 17:30:02  jp_milcent
* Pour les nouveaux modules, les dossiers utilisent des undescrores à la place des tirets.
*
* Revision 1.51  2007/02/07 18:04:45  jp_milcent
* Fusion avec la livraison Moquin-Tandon.
*
* Revision 1.50  2007/01/24 16:44:27  jp_milcent
* Ajout du format de sortie pour JSON.
* Passage par le registre du format pour les nouveaux modules.
*
* Revision 1.49.2.1  2007/02/02 18:13:19  jp_milcent
* Ajout du remplacement d'un caractère mal passé en utf8.
*
* Revision 1.49  2007/01/05 18:40:13  jp_milcent
* Début gestion d'applette et d'un nouveau système de module.
*
* Revision 1.48  2007/01/05 14:29:55  jp_milcent
* Simplification gestion hors de Papyrus.
* Amélioration de l'autoload.
*
* Revision 1.47  2007/01/03 19:45:43  jp_milcent
* Ajout du chargement des classes de l'api d'eFlore.
*
* Revision 1.46  2006/07/12 17:09:29  jp_milcent
* Correction bogue onglet non sélectionné.
* Utilisation du Registre.
*
* Revision 1.45  2006/07/12 09:05:55  jp_milcent
* Correction bogue : ajout du exit.
*
* Revision 1.44  2006/07/11 16:19:19  jp_milcent
* Intégration de l'appllette Xper.
*
* Revision 1.43  2006/07/07 09:26:17  jp_milcent
* Modification selon les remarques de Daniel du 29 juin 2006.
* Changement de nom de classes abstraites.
*
* Revision 1.42  2006/06/20 16:28:58  jp_milcent
* Amélioration sortie pdf.
*
* Revision 1.41  2006/06/20 13:18:34  ddelon
* Bug chemin
*
* Revision 1.40  2006/06/17 11:56:12  ddelon
* Bug chemin
*
* Revision 1.39  2006/05/29 13:58:02  ddelon
* Integration wiki dans eflore
*
* Revision 1.38  2006/05/15 19:51:07  ddelon
* parametrage cache
*
* Revision 1.37  2006/05/11 12:55:38  jp_milcent
* Ajout de chemins à l'autoload.
*
* Revision 1.36  2006/05/11 10:28:27  jp_milcent
* Début modification de l'interface d'eFlore pour la livraison Decaisne.
*
* Revision 1.35  2006/05/11 09:43:37  ddelon
* Action cache
*
* Revision 1.34  2006/05/02 10:01:40  jp_milcent
* Corrections diverses de l'interface graphique conformément aux demandes de Daniel.
* Ajout du moteur de recherche en haut de la page synthèse.
*
* Revision 1.33  2006/04/26 16:57:04  ddelon
* Fusion bdnbe + saisie assistee
*
* Revision 1.32  2006/04/10 17:22:40  jp_milcent
* Fusion avec la livraison bdnbe_v1.
*
* Revision 1.31.2.1  2006/03/10 15:19:53  jp_milcent
* Correction bogue qui empéchait l'affichage du titre formaté sous Papyrus.
*
* Revision 1.31  2006/03/03 17:29:17  jp_milcent
* Amélioration de la gestion des variables de session.
* Ajout du nouveau projet indépendant de la BDNFF : BDNBE.
*
* Revision 1.30  2005/12/21 16:10:30  jp_milcent
* Gestion des fichiers de localisation et simplification du code.
*
* Revision 1.29  2005/12/15 16:01:21  jp_milcent
* Fusion de la branche bdnff_v3_v4 vers la branche principale.
*
* Revision 1.28  2005/12/09 16:51:34  jp_milcent
* Utilisation d'une variable globale pour passer à la fonction autoload les chemins où rechercher les classes.
*
* Revision 1.27  2005/12/06 16:38:28  jp_milcent
* Ajout des chemins d'accès aux classes du module commun.
*
* Revision 1.26  2005/12/01 17:42:54  jp_milcent
* Réglage bogue chemin relatif de l'appli.
*
* Revision 1.25  2005/12/01 17:26:13  jp_milcent
* Gestion des chemins relatifs de l'appli pour les images de la recherche de taxons.
*
* Revision 1.24  2005/12/01 15:53:03  ddelon
* orthographe
*
* Revision 1.23  2005/11/29 16:49:23  jp_milcent
* Modification pour garder la compatibilité avec Papyrus.
*
* Revision 1.22  2005/11/28 17:45:30  jp_milcent
* Utilisation de $_POST à la place de $_REQUEST.
*
* Revision 1.21  2005/11/23 18:07:23  jp_milcent
* Début correction des bogues du module Fiche suite à mise en ligne eFlore Beta.
*
* Revision 1.20  2005/10/19 16:46:48  jp_milcent
* Correction de bogue liés à la modification des urls.
*
* Revision 1.19  2005/10/18 17:17:20  jp_milcent
* Début de la gestion des url d'eFlore.
*
* Revision 1.18  2005/10/11 17:30:32  jp_milcent
* Amélioration gestion de la chorologie en cours.
*
* Revision 1.17  2005/10/10 13:53:34  jp_milcent
* Amélioration de la gestion des sessions.
*
* Revision 1.16  2005/10/10 07:28:07  jp_milcent
* Utilisation du webservice Yahoo-Image.
*
* Revision 1.15  2005/09/28 16:29:31  jp_milcent
* Début et fin de gestion des onglets.
* Début gestion de la fiche Synonymie.
*
* Revision 1.14  2005/09/16 16:41:45  jp_milcent
* Gestion de l'onglet Synthèse en cours.
* Création du modèle pour l'attribution des noms vernaculaires aux taxons.
*
* Revision 1.13  2005/09/13 16:25:23  jp_milcent
* Fin de gestion des interfaces de recherche.
*
* Revision 1.12  2005/08/19 13:54:11  jp_milcent
* Début de gestion de la navigation au sein de la classification.
*
* Revision 1.11  2005/08/17 15:37:50  jp_milcent
* Gestion de la rechercher par taxon en cours...
*
* Revision 1.10  2005/08/11 10:15:49  jp_milcent
* Fin de gestion des noms verna avec requête rapide.
* Début gestion choix aplhabétique des taxons.
*
* Revision 1.9  2005/08/05 15:13:35  jp_milcent
* Gestion de l'affichage des résultats des recherches taxonomiques (en cours).
*
* Revision 1.8  2005/08/04 15:51:45  jp_milcent
* Implémentation de la gestion via DAO.
* Fin page d'accueil.
* Fin formulaire recherche taxonomique.
*
* Revision 1.7  2005/08/02 16:19:33  jp_milcent
* Amélioration des requetes de recherche de noms.
*
* Revision 1.6  2005/08/01 16:18:40  jp_milcent
* Début gestion résultat de la recherche par nom.
*
* Revision 1.5  2005/07/28 15:37:56  jp_milcent
* Début gestion des squelettes et de l'API eFlore.
*
* Revision 1.4  2005/07/27 15:43:21  jp_milcent
* Début débogage avec gestion de l'appli hors Papyrus.
*
* Revision 1.3  2005/07/26 16:27:29  jp_milcent
* Début mise en place framework eFlore.
*
* Revision 1.2  2005/07/26 09:19:05  jp_milcent
* Légère modif.
*
* Revision 1.1  2005/07/25 14:24:36  jp_milcent
* Début appli de consultation simplifiée.
*
*
* +-- Fin du code ----------------------------------------------------------------------------------------+
*/
?>