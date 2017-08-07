<?php
/*vim: set expandtab tabstop=4 shiftwidth=4: */ 
// +------------------------------------------------------------------------------------------------------+
// | PHP version 5.0.4                                                                                    |
// +------------------------------------------------------------------------------------------------------+
// | Copyright (C) 2004 Tela Botanica (accueil@tela-botanica.org)                                         |
// +------------------------------------------------------------------------------------------------------+
// | This file is part of eFlore-recherche.                                                               |
// |                                                                                                      |
// | Foobar is free software; you can redistribute it and/or modify                                       |
// | it under the terms of the GNU General Public License as published by                                 |
// | the Free Software Foundation; either version 2 of the License, or                                    |
// | (at your option) any later version.                                                                  |
// |                                                                                                      |
// | Foobar is distributed in the hope that it will be useful,                                            |
// | but WITHOUT ANY WARRANTY; without even the implied warranty of                                       |
// | MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the                                        |
// | GNU General Public License for more details.                                                         |
// |                                                                                                      |
// | You should have received a copy of the GNU General Public License                                    |
// | along with Foobar; if not, write to the Free Software                                                |
// | Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA                            |
// +------------------------------------------------------------------------------------------------------+
// CVS : $Id: ef_saisie.php,v 1.11 2007-07-17 07:47:26 jp_milcent Exp $
/**
* Fichier contenant les applications d'assistance à la saisie
*
*@package eflore
*@subpackage ef_saisie
//Auteur original :
*@author        David DELON <dd@clapas.net>
//Autres auteurs :
*@author        aucun
*@copyright     Tela-Botanica 2000-2006
*@version       $Revision: 1.11 $ $Date: 2007-07-17 07:47:26 $
// +------------------------------------------------------------------------------------------------------+
*/

// +------------------------------------------------------------------------------------------------------+
// |                                            ENTETE du PROGRAMME                                       |
// +------------------------------------------------------------------------------------------------------+
/** Inclusion du fichier config du module ef_saisie. */
require_once EF_CHEMIN_MODULE.'ef_saisie/configuration/efsa_config.inc.php';

// Instanciation de la valeur de l'action par défaut
if (!isset($_GET[EF_LG_URL_ACTION])) {
	$_GET[EF_LG_URL_ACTION] = 'saisie_continue';
}

// +------------------------------------------------------------------------------------------------------+
// Gestion des variables de session

// Gestion de la session pour le nom
if (isset($GLOBALS['eflore_nom']) ) {
    if (isset($_POST['eflore_nom']) AND $GLOBALS['eflore_nom'] != $_POST['eflore_nom']) {
        $GLOBALS['eflore_nom'] = $_POST['eflore_nom'];
    }
} else {
    if (isset($_POST['eflore_nom'])) {
        $GLOBALS['eflore_nom'] = $_POST['eflore_nom'];
    } else {
        $GLOBALS['eflore_nom'] = '';
    }
}
// Gestion de la session pour l'id du référenciel
if (isset($GLOBALS['eflore_referenciel']) ) {
    if (isset($_POST['eflore_referenciel']) AND $GLOBALS['eflore_referenciel'] != $_POST['eflore_referenciel']) {
        $GLOBALS['eflore_referenciel'] = (int)$_POST['eflore_referenciel'];
    }
} else {
    if (isset($_POST['eflore_referenciel'])) {
        $GLOBALS['eflore_referenciel'] = (int)$_POST['eflore_referenciel'];
    } else if (isset($_GET[EF_LG_URL_NVP])) {
        $GLOBALS['eflore_referenciel'] = (int)$_GET[EF_LG_URL_NVP];
    } else {
        $GLOBALS['eflore_referenciel'] = (int)$GLOBALS['_EFLORE_']['projet_version_defaut'];
    }
}

// Gestion de la session pour le nom du référenciel
if (!isset($GLOBALS['eflore_referenciel_nom'])) {
    $GLOBALS['eflore_referenciel_nom'] = '';
}

// +-------------------------------------------------------------------------------------------------------------------+
// |                                               CORPS du PROGRAMME                                                  |
// +-------------------------------------------------------------------------------------------------------------------+

class EfSaisie extends aServiceDeprecie {
	
	public function __construct($Registre = null)
	{
		// Ajout du nom du service
		$this->setNom('saisie');
		parent::__construct($Registre);
	}
	
	public function executer($action) 
	{
		// +-------------------------------------------------------------------------------------------------------------+
		// Initialisation des variables
		$classe_nom = str_replace(' ', '', ucwords(str_replace('_', ' ', $action)));
		$retour = '';
		
		// +-------------------------------------------------------------------------------------------------------------+
		// Mesure du temps d'éxecution : début
		$GLOBALS['_EFLORE_']['chrono']->setTemps(array('debut_saisie_'.$action => microtime()));

		// +-------------------------------------------------------------------------------------------------------------+
		// Gestion de l'appel des actions
		$chemin_fichier_action = EFSA_CHEMIN_ACTION.'efsa_'.$action.'.action.php';
		
		if (file_exists($chemin_fichier_action)) {
			
			include_once $chemin_fichier_action;
			$class_action_nom = 'Action'.$classe_nom;
			if (class_exists($class_action_nom)) {
				// Ajout d'information au registre
				$this->getRegistre()->set('module_nom', $this->getNom());
				if (isset($GLOBALS['_EF_']['i18n'][$this->getNom()])) {
					$this->getRegistre()->set('module_i18n', $GLOBALS['_EF_']['i18n'][$this->getNom()]);
				}
				$une_action = new $class_action_nom($this->getRegistre());
				if (EF_BOOL_STOCKAGE_CACHE) {
					if ($une_action instanceof iActionAvecCache) {
						$cachefile = EF_CHEMIN_STOCKAGE_CACHE.$une_action->get_identifiant().'.cache.txt';
	 					if (file_exists($cachefile) ) {
							echo "/* Cached copy, generated ".date('Y M D H:i', filemtime($cachefile))." */\n";
	    					readfile($cachefile);
	    					exit;
						}
					}
				}
				
				
				if (method_exists($une_action,'executer')) {
					
					// +----------------------------------------------------------------------------------------------------+
					// Mesure du temps d'éxecution : début
					//$GLOBALS['_EFLORE_']['chrono']->setTemps(array('debut_action_'.$action => microtime()));
					
					$tab_donnees = $une_action->executer();
					
					// +----------------------------------------------------------------------------------------------------+
					// Mesure du temps d'éxecution : fin
					//$GLOBALS['_EFLORE_']['chrono']->setTemps(array('fin_action_'.$action => microtime()));
					
				} else {
					trigger_error("Impossible de trouver la méthode d'action: executer().", E_USER_ERROR);
				}
			} else {
				trigger_error("Impossible de trouver la classe d'action: $class_action_nom.", E_USER_ERROR);
			}
		} else {
			trigger_error("Impossible de trouver le fichier d'action: $chemin_fichier_action.", E_USER_ERROR);
		}

		// +-------------------------------------------------------------------------------------------------------------+
		// Gestion de la vue
		$chemin_fichier_vue = EFSA_CHEMIN_VUE.'efsa_'.$action.'.vue.php';
		if (file_exists($chemin_fichier_vue)) {
			include_once $chemin_fichier_vue;
			$class_vue_nom = 'Vue'.$classe_nom;
			if (class_exists($class_vue_nom)) {
				// Ajout d'information au registre pour la vue
				$this->getRegistre()->set('vue_donnees', $tab_donnees);
				$this->getRegistre()->set('vue_format', $this->getFormat());
				$this->getRegistre()->set('vue_chemin_squelette', EFSA_CHEMIN_SQUELETTE);

				// Construction de la vue
				$une_vue = new $class_vue_nom($this->getRegistre());
				// +----------------------------------------------------------------------------------------------------+
				// Mesure du temps d'éxecution : début
				//$GLOBALS['_EFLORE_']['chrono']->setTemps(array('debut_rendu_'.$action => microtime()));

				// Envoie du rendu
				if ($une_vue->getUtiliseTpl()) {
					$une_vue->chargerSquelette();
					$une_vue->preparer();
				}
				$retour = $une_vue->retournerRendu();
				
				// +----------------------------------------------------------------------------------------------------+
				// Mesure du temps d'éxecution : début
				//$GLOBALS['_EFLORE_']['chrono']->setTemps(array('fin_rendu_'.$action => microtime()));
								
			} else {
				trigger_error("Impossible de trouver la classe de vue: $class_vue_nom.", E_USER_ERROR);
			}
		} else {
			trigger_error("Impossible de trouver le fichier de vue: $chemin_fichier_vue.", E_USER_ERROR);
		}
		
		// +-------------------------------------------------------------------------------------------------------------+
		// Mesure du temps d'éxecution : fin
		$GLOBALS['_EFLORE_']['chrono']->setTemps(array('fin_recherche_'.$action => microtime()));
		
		// Cache
		if ($une_action instanceof iActionAvecCache) {
			 if (EF_BOOL_STOCKAGE_CACHE) {
				$fp = fopen($cachefile, 'w');
				fwrite($fp, $retour);
				fclose($fp);
			 }
			 echo $retour; // A revoir si besoin de 
			 exit;         // Cache generique
		}
			
		return $retour;
		
	}
}
/* +--Fin du code -----------------------------------------------------------------------------------------------------+
*
* $Log: ef_saisie.php,v $
* Revision 1.11  2007-07-17 07:47:26  jp_milcent
* Renommage de l'ancienne classe aService en aServiceDeprecie.
*
* Revision 1.10  2006-12-27 14:06:54  jp_milcent
* Ajout d'information sur le référentiel.
*
* Revision 1.9  2006/07/07 09:59:13  jp_milcent
* Correction bogue changement nom classe ActionAvecCache en iActionAvecCache.
*
* Revision 1.8  2006/07/07 09:53:21  jp_milcent
* Correction de bogues dûs au changement de nom des classes du noyau.
*
* Revision 1.7  2006/07/07 09:26:17  jp_milcent
* Modification selon les remarques de Daniel du 29 juin 2006.
* Changement de nom de classes abstraites.
*
* Revision 1.6  2006/05/16 09:19:22  ddelon
* correction gestion cache
*
* Revision 1.5  2006/05/15 19:51:07  ddelon
* parametrage cache
*
* Revision 1.4  2006/05/11 10:28:27  jp_milcent
* Début modification de l'interface d'eFlore pour la livraison Decaisne.
*
* Revision 1.3  2006/05/11 09:43:37  ddelon
* Action cache
*
* Revision 1.2  2006/04/26 16:57:04  ddelon
* Fusion bdnbe + saisie assistee
*
* Revision 1.1.2.1  2006/04/21 20:50:27  ddelon
* Saisie continue
*
*
* +-- Fin du code ----------------------------------------------------------------------------------------+
*/
?>