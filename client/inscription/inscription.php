<?php
// +------------------------------------------------------------------------------------------------------+
// | PHP version 4.1																					  |
// +------------------------------------------------------------------------------------------------------+
// | Copyright (C) 2004 Tela Botanica (accueil@tela-botanica.org)							   	          |
// +------------------------------------------------------------------------------------------------------+
// | This library is free software; you can redistribute it and/or										  |
// | modify it under the terms of the GNU Lesser General Public										      |
// | License as published by the Free Software Foundation; either										  |
// | version 2.1 of the License, or (at your option) any later version.								      |
// |																									  |
// | This library is distributed in the hope that it will be useful,									  |
// | but WITHOUT ANY WARRANTY; without even the implied warranty of									      |
// | MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the GNU									  |
// | Lesser General Public License for more details.													  |
// |																									  |
// | You should have received a copy of the GNU Lesser General Public									  |
// | License along with this library; if not, write to the Free Software								  |
// | Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA							  |
// +------------------------------------------------------------------------------------------------------+
/**
* Inscription
*
* Un module d'inscription, en général ce code est spécifique à un site web.
*
*@package inscription
//Auteur original :
*@author		Alexandre GRANIER <alexandre@tela-botanica.org>
//Autres auteurs :
*@author	   Jean-Pascal MILCENT <jpm@tela-botanica.org>
*@copyright	   Tela-Botanica 2000-2004
*@version	   $Id: inscription.php,v 1.3 2005/03/21 16:50:21 alex Exp $
// +------------------------------------------------------------------------------------------------------+
*/

// +------------------------------------------------------------------------------------------------------+
// |											ENTETE du PROGRAMME									   |
// +------------------------------------------------------------------------------------------------------+
include_once PAP_CHEMIN_API_PEAR.'Mail.php' ;
require_once PAP_CHEMIN_API_PEAR.'HTML/QuickForm.php' ;
require_once PAP_CHEMIN_API_PEAR.'HTML/QuickForm/checkbox.php' ;
require_once PAP_CHEMIN_API_PEAR.'HTML/QuickForm/password.php' ;
/** Constante "dynamique" stockant la langue demandée par l'utilisateur pour l'application.*/
define('INS_LANGUE', substr($GLOBALS['_GEN_commun']['i18n'], 0, 2));
$fichier_lg = 'client/inscription/langues/ins_langue_'.INS_LANGUE.'.inc.php';
if (file_exists($fichier_lg)) {
    include_once $fichier_lg;
	include_once 'client/inscription/langues/ins_langue_'.INS_LANGUE.'.inc.php';
} else {
	include_once 'client/inscription/langues/ins_langue_fr.inc.php' ;
}
include_once 'client/inscription/configuration/ins_config.inc.php';
include_once 'client/inscription/bibliotheque/inscription.fonct.php';
include_once INS_CHEMIN_FICHIER.'bibliotheque/inscription.class.php';

// Ajout d'une feuille de style externe
GEN_stockerStyleExterne ('inscription', 'client/inscription/inscription.css') ;

// +------------------------------------------------------------------------------------------------------+
// |										   LISTE de FONCTIONS										 |
// +------------------------------------------------------------------------------------------------------+

function afficherContenuTete() {
	$retour = '<h1 class="titre1_inscription">Inscription à Gentiana</h1>';
	return ;
}

//  ================ Note =======================
//  La variable action sert à définir ce qui est demandé (inscription, modification d'inscription, suppression ...
//  Elle est appelé avec $_REQUEST car elle peut aussi bien venir d'un formulaire que d'un lien.
// ==============================================


/**
 *
 * @global  AUTH	Un pointeur vers un objet PEAR::Auth
 * @global  ins_url Un pointeur vers un objet PEAR::Net_URL 
 * @return  string  Le contenu de l'application inscription
 */
function afficherContenuCorps() {

	$url = preg_replace ("/&amp;/", "&", $GLOBALS['ins_url']->getURL()) ;
	// Attibution  de l'action par défaut à effectuer.
	if (!isset ($_REQUEST['action'])) {
		$_REQUEST['action'] = 'inscription';
	}
	$res = '' ;
	$est_loggue = true ;
	
	// ... tentative de déconnection
	if (isset ($_GET['logout']) && $_GET['logout'] == 1) {
		$GLOBALS['AUTH']->logout() ;
		$_POST['username'] = '' ;
		$_POST['password'] = '' ;
		//return AUTH_formulaire_login() ;
	}
		
	// ...supprimer l'inscription
	if (isset ($_POST['supprimer'])) {
		$mail_utilisateur = $GLOBALS['AUTH']->getUsername();
		$id_utilisateur = $GLOBALS['AUTH']->getAuthData(INS_CHAMPS_ID) ;
		$bool_inscription_lettre = $GLOBALS['AUTH']->getAuthData(INS_CHAMPS_LETTRE);
		$resultat = $GLOBALS['AUTH']->removeUser($mail_utilisateur) ;

		if (PEAR::isError($resultat)) {
			die ($resultat->getMessage().'<br />'.$resultat->getDebugInfo()) ;
		}

		// Désinscription de la lettre d'info
		if (INS_UTILISE_LISTE) {
			if ($bool_inscription_lettre == 1) { 
				inscription_lettre(INS_MAIL_DESINSCRIPTION_LISTE) ;
			}
		}
		$GLOBALS['AUTH']->logout() ;
		
		// Ajout d'une ligne dans les statistiques
		if (INS_UTILISE_STAT) {
			$requete = 'INSERT INTO '.INS_TABLE_STATISTIQUE.' SET '.INS_STATS_CHAMPS_DATE.'=NOW(), '.INS_STATS_CHAMPS_ACTION.'="del"' ;
			$resultat = $GLOBALS['ins_db']->query ($requete) ;
			if (DB::isError ($resultat)) {
				die ('Echec de la requete : '.$requete.'<br />'.$resultat->getMessage()) ;
			}
		}
		//return AUTH_formulaire_login() ;
	}

	// ... envoie de mot de passe
	if ($_REQUEST['action'] == 'sendpasswd') {
		envoie_passe();
	}
	
	// ...oublie de mot de passe 
	if (preg_match('/^(?:mdp_oubli|sendpasswd)$/', $_REQUEST['action'])) {
		return message_erreur(false);
	}
	
	// ...inscription dans la base si l'utilisateur clique sur le lien du mail
	if ($_GET['action'] == 'ajouter' && isset($_GET['id']) && !$GLOBALS['AUTH']->getAuth()) {
		$requete = 'SELECT id_donnees FROM inscription_demande WHERE id_identifiant_session="'.$_GET['id'].'"' ;
		$resultat = $GLOBALS['ins_db']->query($requete) ;
		if (DB::isError ($resultat)) {
			die ("Echec de la requete : $requete<br />".$resultat->getMessage()) ;
		}
		if ($resultat->numRows() == 0) {
			return INS_MESSAGE_EXPIRATION;
		}
		$ligne = $resultat->fetchRow(DB_FETCHMODE_OBJECT) ;
		$donnees = unserialize (stripslashes($ligne->id_donnees)) ;
		trigger_error(print_r($donnees, true), E_USER_WARNING);
		// Ajout des données dans la base
		insertion($donnees);
		
		// On loggue l'utilisateur
		$GLOBALS['AUTH']->username = $donnees['email'] ;
		$GLOBALS['AUTH']->password = $donnees['mot_de_passe'] ;
		$GLOBALS['AUTH']->login() ;
		
		// Inscription à la lettre d'information
		if (INS_UTILISE_LISTE) {
			if (isset ($donnees['lettre'])) {
				inscription_lettre(INS_MAIL_INSCRIPTION_LISTE) ;
			}
		}
		
		// On supprime la demande d'inscription
		$requete = 'DELETE FROM inscription_demande WHERE id_identifiant_session="'.$_GET['id'].'"' ;
		$resultat = $GLOBALS['ins_db']->query ($requete) ;
		if (DB::isError ($resultat)) {
			die ("Echec de la requete : $requete<br />".$resultat->getMessage()) ;
		}
		// On envoi les mails d'information sur la nouvelle inscription.
		envoie_mail() ;
	}

	// ... affichage d'une erreur en cas de pb
	if (!$GLOBALS['AUTH']->getAuth() &&  $_REQUEST['action'] != 'inscription' && $_REQUEST['action'] != 'inscription_v')	{
		if (isset($_POST['username']) && $_POST['username'] != '') {
			$res .= message_erreur();
		}
	}

	// ... la personne est identifiée nous affichons ses informations
	if ($GLOBALS['AUTH']->getAuth () && !isset($_POST['modifier']) && $_REQUEST['action'] != 'modifier_v') {
			return info().bouton($url);
	}
	
	// ...tentative d'inscription ou Inscription structure 
	if (preg_match('/^(?:inscription|inscription_v|modifier_v)$/', $_REQUEST['action']) || isset($_POST['modifier'])) {
		$action = preg_replace ("/&amp;/", "&", $GLOBALS['ins_url']->getURL()) ;
		$formulaire = new HTML_formulaireInscription('formulaire_inscription', 'post', $action) ;
		// Construction de la liste des pays
		$liste_pays = new ListeDePays($GLOBALS['ins_db']) ;

		if (isset($_POST['structure'])) {
			$formulaire->formulaireStructure() ;
		}

		if (!isset($_POST['modifier'])) {
			$GLOBALS['ins_url']->addQueryString('action', 'mdp_oubli');
			$url_oubli = preg_replace ('/&amp;/', '&', $GLOBALS['ins_url']->getURL()) ;
			$GLOBALS['ins_url']->removeQueryString('action');
			$res .= '<h1 class="titre1_inscription">'.INS_ACCUEIL_INSCRIPTION.'</h1>';
			$res .= '<h2 class="titre2_inscription">'.INS_LAIUS_INSCRIPTION.'</h2>'."\n" ;
			$res .= '<p>'.INS_LAIUS_INSCRIPTION_2.'</p>'."\n" ;
			$res .= '<p>'.INS_TEXTE_PERDU.' <a href="'.$url_oubli.'">'.INS_MDP_PERDU_OUBLI.'</a></p>'."\n" ;
		} else {
			$formulaire->mode_ajout = false;
			$res .= '<h1 class="titre1_inscription">'.INS_ACCUEIL_INSCRIPTION.'</h1>';			
		}

		$formulaire->construitFormulaire($action, $liste_pays->getListePays('fr')) ;
		
		if (isset($_POST['modifier'])) {
			$formulaire->addElement ('hidden', 'action', 'modifier_v') ;
			$formulaire->setDefaults(formulaire_defaults()) ;
			if (INS_UTILISE_LISTE) {
				if ($GLOBALS['AUTH']->getAuthData(INS_CHAMPS_LETTRE) == 1) {
					$lettre = & $formulaire->getElement('lettre') ;
					$lettre->setChecked(true) ;
				}
			}
		} else if ($_REQUEST['action'] == 'inscription') {
			$formulaire->addElement ('hidden', 'action', 'inscription_v') ;
			$formulaire->setDefaults (array ('pays' => 'fr', 'asso' => 3, 'activite' => 3, 'niveau' => 4, 'lettre' => 1)) ;
			if (INS_UTILISE_LISTE) {
				$lettre = & $formulaire->getElement('lettre') ;
				$lettre->setChecked(true) ;
			}
		} else if ($_REQUEST['action'] == 'inscription_v') {
			if ($formulaire->validate()) {
				$formulaire->process('demande_inscription', false) ;
				return message_inscription() ;
			}
		} else if ($_REQUEST['action'] == 'modifier_v') {
			if ($formulaire->validate()) {
				if (INS_UTILISE_LISTE) {
					$valeur_lettre = $GLOBALS['AUTH']->getAuthData(INS_CHAMPS_LETTRE) ;
				}
				$formulaire->process('mise_a_jour', false) ;
			}
			if (INS_UTILISE_LISTE) {
				if (isset($_POST['lettre'])) {
					if ($valeur_lettre == '') {
						inscription_lettre (INS_MAIL_INSCRIPTION_LISTE) ;
					}
				} else {
					if ($valeur_lettre == 1) {
						inscription_lettre (INS_MAIL_DESINSCRIPTION_LISTE) ;
					}
				}
			}
			return info($GLOBALS['AUTH']->getAuthData(INS_CHAMPS_ID)).bouton($url);
		}
		
		return $res.$formulaire->toHTML() ;
	}
	
	return $res ;
}

function afficherContenuPied () {
    $sortie  = 	'<p id="ins_pied_page">'.INS_PIED_INFO.
					'<a href="mailto:'.INS_PIED_MAIL.'">'.INS_PIED_MAIL.'</a>.'.
				'</p>';
    return $sortie;
}
?>