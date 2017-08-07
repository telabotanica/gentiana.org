<?php
// +------------------------------------------------------------------------------------------------------+
// | PHP version 5.0.1                                                                                    |
// +------------------------------------------------------------------------------------------------------+
// | Copyright (C) 2005 Jean-Pascal MILCENT (jpm@clapas.org)                                              |
// +------------------------------------------------------------------------------------------------------+
// | This file is part of eRibo.                                                                          |
// |                                                                                                      |
// | eRibo is free software; you can redistribute it and/or modify                                       |
// | it under the terms of the GNU General Public License as published by                                 |
// | the Free Software Foundation; either version 2 of the License, or                                    |
// | (at your option) any later version.                                                                  |
// |                                                                                                      |
// | eRibo is distributed in the hope that it will be useful,                                            |
// | but WITHOUT ANY WARRANTY; without even the implied warranty of                                       |
// | MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the                                        |
// | GNU General Public License for more details.                                                         |
// |                                                                                                      |
// | You should have received a copy of the GNU General Public License                                    |
// | along with eRibo; if not, write to the Free Software                                                |
// | Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA                            |
// +------------------------------------------------------------------------------------------------------+
/**
* Titre
*
* Description
*
*@package eRibo
*@subpackage 
//Auteur original :
*@author        Jean-Pascal MILCENT <jpm@clapas.org>
//Autres auteurs :
*@author        Aucun
*@copyright     Jean-Pascal MILCENT 2005
*@version       $Id: index.php,v 1.1 2007-07-17 07:46:24 jp_milcent Exp $
// +------------------------------------------------------------------------------------------------------+
*/

// +------------------------------------------------------------------------------------------------------+
// |                                            ENTETE du PROGRAMME                                       |
// +------------------------------------------------------------------------------------------------------+
// +------------------------------------------------------------------------------------------------------+
// Constante de l'application
define('DS', DIRECTORY_SEPARATOR);

// +------------------------------------------------------------------------------------------------------+
// Gestion du chemin des services et du dossier de configuration
if (!defined('PAP_VERSION')) {
	/** Constante "dynamique" stockant le chemin absolue de base des services.*/
	define('EFS_CHEMIN_SERVICE', dirname(realpath($_SERVER['SCRIPT_FILENAME'])).DS);
	/** Constante "dynamique" stockant le chemin relatif de base des services.*/
	define('EFS_CHEMIN_SERVICE_RELATIF', str_replace(realpath($_SERVER['DOCUMENT_ROOT']), '', DS));	
} else {
	/** Constante "dynamique" stockant le chemin absolue de base des services.*/
	define('EFS_CHEMIN_SERVICE', dirname(realpath(__FILE__)).DS);
	/** Constante "dynamique" stockant le chemin relatif de base des services.*/
	define('EFS_CHEMIN_SERVICE_RELATIF', str_replace($_SERVER['DOCUMENT_ROOT'], '', EF_CHEMIN_APPLI));
}
/** Constante "dynamique" stockant le chemin absolue de base de l'appli'.*/
define('EF_CHEMIN_APPLI', EFS_CHEMIN_SERVICE.'..'.DS);
/** Constante "dynamique" stockant le chemin relatif de base de l'appli'.*/
define('EF_CHEMIN_APPLI_RELATIF', EFS_CHEMIN_SERVICE_RELATIF.'..'.DS);

// +------------------------------------------------------------------------------------------------------+
// Inclusion des fichiers propres � l'appli
/** Constante stockant le chemin vers le dossier configuration.*/
define('EF_CHEMIN_CONFIG', EFS_CHEMIN_SERVICE.'..'.DS.'configuration'.DS);
// Tentative d'inclusion du fichier de configuration sp�cifique � un d�ploiment de l'appli
if (file_exists(EF_CHEMIN_CONFIG.'ef_config.inc.php')) {
	/** Inclusion du fichier config sp�cifique de l'application eflore. */
	require_once EF_CHEMIN_CONFIG.'ef_config.inc.php';
} else {
	$message = 'Fichier introuvable : '.EF_CHEMIN_CONFIG.'ef_config.inc.php ';
	$message .= 'Veuillez configurer l\'application!';
	die($message);
}

// +------------------------------------------------------------------------------------------------------+
// Inclusion des fichiers de configuration g�n�raux d'eFlore
/** Inclusion du fichier config des chemins d'eflore. */
require_once EF_CHEMIN_CONFIG.'ef_config_chemin.inc.php';
/** Inclusion du fichier config de la base de donn�es d'eflore. */
require_once EF_CHEMIN_CONFIG.'ef_config_bdd.inc.php';

// +------------------------------------------------------------------------------------------------------+
// Inclusion du fichier de config des services
/** Constante stockant le chemin vers le dossier configuration.*/
define('EFS_CHEMIN_CONFIG', EFS_CHEMIN_SERVICE);
/** Inclusion du fichier config sp�cifique des services. */
require_once EFS_CHEMIN_CONFIG.'config.inc.php';

// +------------------------------------------------------------------------------------------------------+
// Inclusion du fichier de configuration g�n�ral des urls d'eFlore
/** Inclusion du fichier config des URLs de l'application eflore. */
require_once EF_CHEMIN_CONFIG.'ef_config_url.inc.php';

// +------------------------------------------------------------------------------------------------------+
// Initialisation du Registre
$Registre = Registre::getInstance();

// +------------------------------------------------------------------------------------------------------+
// Initialisation du gestionnaire d'erreur et du d�bogage
$Registre->set('Erreur', new GestionnaireErreur(EF_DEBOGAGE_CONTEXTE));
$Registre->get('Erreur')->setNiveauErreurCourrant(EF_DEBOGAGE_NIVEAU);

// +------------------------------------------------------------------------------------------------------+
// |                                            CORPS du PROGRAMME                                        |
// +------------------------------------------------------------------------------------------------------+
//echo '<pre>'.print_r($_SERVER, true).'</pre>';

// Initialisation de la Requete HTTP et ajout des attributs � la requ�te.
$Requete = new HttpRequete($_SERVER);

// Initialise la R�ponse HTTP et ajoute les attributs � la requ�tes
$Reponse = new HttpReponse($_SERVER);

// D�marrage du controlleur
$Controlleur = new ControlleurService($Requete, $Reponse);

// Lancement de l'ex�cution du service
$Controlleur->executer();

// +------------------------------------------------------------------------------------------------------+
// |                                            LISTE DE FONCTIONS                                        |
// +------------------------------------------------------------------------------------------------------+
/**
* La fonction __autoload() charge dynamiquement les classes trouv�es dans le code.
*
* Cette fonction est appel�e par php5 quand il trouve une instanciation de classe dans le code.
*
*@param string le nom de la classe appel�e.
*@return void le fichier contenant la classe doit �tre inclu par la fonction.
*/
function __autoload($classe)
{
	$fichier = $classe.'.php';
	if (file_exists($fichier)) {
		require_once $fichier;
	} else if (substr_count($classe, '_') > 0) {
		// Gestion des classes PEAR
		$tab_chemin = explode('_', $classe);
		$fichier = '';
		$nbre_niveau = count($tab_chemin);
		for ($i = 0; $i < $nbre_niveau; $i++) {
			if (($nbre_niveau-1) == $i) {
				$fichier .= $tab_chemin[$i].'.php';
			} else {
				$fichier .= $tab_chemin[$i].DS;
			}
		}
		if (file_exists(EF_CHEMIN_PEAR.$fichier)) {
			require EF_CHEMIN_PEAR.$fichier;
			return null;
		} else if (file_exists(EF_CHEMIN_BIBLIO_PEAR.$fichier)) {
			require EF_CHEMIN_BIBLIO_PEAR.$fichier;
			return null;
		}
	} else {
		// Ajout du dossier
		foreach ($GLOBALS['_EFS_']['chemins'] as $chemin) {
			$fichier = $chemin.$classe.'.class.php';
			if (file_exists($fichier)) {
				require $fichier;
				return null;
				break;
			}
		}
	}
	trigger_error('Le fichier contenant la classe : '.$classe.' est introuvable !', E_USER_WARNING);
}

?>