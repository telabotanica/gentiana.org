<?php
/*vim: set expandtab tabstop=4 shiftwidth=4: */ 
// +------------------------------------------------------------------------------------------------------+
// | PHP version 4.1                                                                                      |
// +------------------------------------------------------------------------------------------------------+
// | Copyright (C) 2004 Tela Botanica (accueil@tela-botanica.org)                                         |
// +------------------------------------------------------------------------------------------------------+
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
// +------------------------------------------------------------------------------------------------------+
// CVS : $Id: identification.php,v 1.35.2.2 2008-04-18 14:14:55 jp_milcent Exp $
/**
* Applette : identification
*
* Génère un formulaire les champs nécessaires pour s'identifier.
* Nécessite :
* - Variable globale de Génésia.
* - Pear Auth
* - Pear Net_URL
*
* A faire : remplacer le formulaire par un QuickForm
*
*@package Applette
*@subpackage Identification
//Auteur original :
*@author        Jean-Pascal MILCENT <jpm@tela-botanica.org>
//Autres auteurs :
*@author        Aucun
*@copyright     Tela-Botanica 2000-2004
*@version       $Revision: 1.35.2.2 $ $Date: 2008-04-18 14:14:55 $
// +------------------------------------------------------------------------------------------------------+
*/

// +------------------------------------------------------------------------------------------------------+
// |                                            ENTÊTE du PROGRAMME                                       |
// +------------------------------------------------------------------------------------------------------+
$GLOBALS['_GEN_commun']['info_applette_nom_fonction'] = 'afficherFormIdentification';
$GLOBALS['_GEN_commun']['info_applette_balise'] = 	'(?:<!-- '.$GLOBALS['_GEN_commun']['balise_prefixe'].'(IDENTIFICATION) -->|'.
													'\{\{[Ii]dentification'.
													'(?:\s*'.
														'(?:'.
															'(template=".*")|'.
														')'.
													')+'.
													'\s*\}\})';

/** Inclusion du fichier de configuration de cette applette.*/
require_once GEN_CHEMIN_APPLETTE.'identification'.GEN_SEP.'configuration'.GEN_SEP.'iden_config.inc.php';

// Inclusion des fichiers de traduction de l'applette.
if (file_exists(IDEN_CHEMIN_LANGUE.'iden_langue_'.$GLOBALS['_GEN_commun']['i18n'].'.inc.php')) {
    /** Inclusion du fichier de traduction suite à la transaction avec le navigateur.*/
    require_once IDEN_CHEMIN_LANGUE.'iden_langue_'.$GLOBALS['_GEN_commun']['i18n'].'.inc.php';
} else {
    /** Inclusion du fichier de traduction par défaut.*/
    require_once IDEN_CHEMIN_LANGUE.'iden_langue_'.IDEN_I18N_DEFAUT.'.inc.php';
}
// +------------------------------------------------------------------------------------------------------+
// |                                            CORPS du PROGRAMME                                        |
// +------------------------------------------------------------------------------------------------------+

// Si le site utilise une authentification.
if ($GLOBALS['_GEN_commun']['info_auth']->gsa_ce_type_auth == 1) {
	$cookie_persistant_nom = session_name().'-memo';
    // Si un formulaire nous renvoie en POST une variable "deconnexion", nous délogons l'utilisateur.
    if ((isset($_REQUEST['deconnexion']) || isset($_REQUEST['logout']))) {
		$GLOBALS['_GEN_commun']['pear_auth']->logout();
		// Destruction du cookie de session de Papyrus : est ce utile?
		setcookie(session_name(), session_id(), time()-3600, '/');
		// Destruction du cookie de permanence de l'identitification de Papyrus
		setcookie($cookie_persistant_nom, '', time()-3600, '/');
		//$GLOBALS['_GEN_commun']['pear_auth']->start();
    } else {
		
    	if (isset($_REQUEST['connexion'])) {
	    	// Si un formulaire nous renvoie en POST une variable "connexion", nous logons l'utilisateur.
			// Nous vérifions que l'utilisateur est coché "Mémoriser mon compte"
			if (isset($_POST['persistant']) && $_POST['persistant'] == 'o' && IDEN_AUTH_SESSION_DUREE != 0) {
		        // Expiration si l'utilisateur ne referme pas son navigateur
				$GLOBALS['_GEN_commun']['pear_auth']->setExpire((int)IDEN_AUTH_SESSION_DUREE);
				// Création d'un cookie pour rendre permanente l'identification de Papyrus
				$cookie_val = md5($_POST['password']).$_POST['username'];
				setcookie($cookie_persistant_nom, $cookie_val, (int)IDEN_AUTH_SESSION_DUREE, '/');
			}
	    } else if (isset($_COOKIE[$cookie_persistant_nom])) {
			// Si un cookie existe, nous loggons l'utilisateur.
			$GLOBALS['_GEN_commun']['pear_auth']->password = substr($_COOKIE[$cookie_persistant_nom], 0, 32 );
			$GLOBALS['_GEN_commun']['pear_auth']->username = substr($_COOKIE[$cookie_persistant_nom], 32);
			// Nous sommes obligés de crypter le mot de passe
			if (isset($GLOBALS['_GEN_commun']['pear_auth']->storage_options)) {
				$GLOBALS['_GEN_commun']['pear_auth']->storage_options['cryptType'] = 'none';
    		}
    		if (isset($GLOBALS['_GEN_commun']['pear_auth']->storage->options)) {
				$GLOBALS['_GEN_commun']['pear_auth']->storage->options['cryptType'] = 'none';
			}
			
		}
		$GLOBALS['_GEN_commun']['pear_auth']->login();
		//echo '<pre>'.print_r($GLOBALS['_GEN_commun']['pear_auth'], true).'</pre>';
    }
}

// +------------------------------------------------------------------------------------------------------+
// |                                           LISTE de FONCTIONS                                         |
// +------------------------------------------------------------------------------------------------------+

/** Fonction afficherFormIdentification() - Retourne une formulaire pour s'identifier.
*
* Retourne un formulaire d'identificatin ou de déconnexion suivant que l'utilisateur est
* identifié ou pas.
*
* @param  array  tableau d'éventuel arguments présent dans la balise transmis à la fonction. 
* @param  array  tableau global de Papyrus.
* @return string formulaire de connexion ou de déconnexion.
*/
function afficherFormIdentification($tab_arguments, $_GEN_commun)
{
    // Extraction des arguments s il y a
    $balise = $tab_arguments[0];
    $tab_arguments = $tab_arguments;
	unset($tab_arguments[0]);
    foreach($tab_arguments as $argument) {
    	if ($argument != '') {
	    	$tab_parametres = explode('=', $argument, 2);
	    	if (isset($tab_parametres[1])) $options[$tab_parametres[0]] = trim($tab_parametres[1], '"');
    	}
    }
    if (!isset($options['template'])) {
    	$options['template'] = IDEN_CHEMIN_APPLETTE.'squelettes/'.IDEN_SQUELETTE_DEFAUT;
    }
    // Initialisation de variable.
    $retour = '';
    $id_xhtml = '';
    if ( $GLOBALS['_PAPYRUS_']['applette']['comptage']['afficherFormIdentification'] > 1) {
    	$id_xhtml =  $GLOBALS['_PAPYRUS_']['applette']['comptage']['afficherFormIdentification'];
    }
    $objet_pear_auth =& $_GEN_commun['pear_auth'];
    $objet_pear_db =& $_GEN_commun['pear_db'];
    $InfoAuthBdd =& $_GEN_commun['info_auth_bdd'];
    $objet_url =& $_GEN_commun['url'];
    $url = $objet_url->getURL();
    $objet_url->addQueryString('logout', 1);
    $url_deconnect = $objet_url->getURL();
    $objet_url->removeQueryString('logout');
    // Récupération des valeurs pour le login et le mot de passe
    $mot_de_passe = (! isset($_POST['password']))    ? '' : $_POST['password'];
    $login        = (! isset($_POST['username']))    ? '' : $_POST['username'];
    
    // ATTENTION : Partie à supprimer une fois les mise à jour effectué dans l'annuaire de Tela Botanica
    // Devrait être déplacer dans l'appli inscription de Tela.
    if (isset($InfoAuthBdd->gsab_nom_table) && $InfoAuthBdd->gsab_nom_table == 'annuaire_tela') {
        verification_mot_de_passe($objet_pear_db, $mot_de_passe, $login);
        if (isset($_POST['connexion'])) {
            $objet_pear_auth->login();
        }
    }
        
	// L'utilisateur a essayé de s'identifier mais a échoué
	$url_erreur = false;
	if ($login != '') {
		$url_erreur = '#';
		if (isset($InfoAuthBdd->url_erreur)) {
			$url_erreur = $InfoAuthBdd->url_erreur;
		} else if (isset($InfoAuthBdd->url_inscription)) {
			$url_erreur = $InfoAuthBdd->url_inscription;
		}
	}
	$url_inscription_aide = '';
	$url_page_inscription = '';
	$url_page_modif_inscription = '';
	if (isset($InfoAuthBdd->url_inscription)) {
    	$url_page_inscription = $InfoAuthBdd->url_inscription;
	}
	if (isset($InfoAuthBdd->url_inscription_modif)) {
    	$url_page_modif_inscription = $InfoAuthBdd->url_inscription_modif;
	}
	if (isset($InfoAuthBdd->url_inscription_aide)) {
		$url_inscription_aide = $InfoAuthBdd->url_inscription_aide;
	}
	$chp_personne_prenom='';
    if (isset($InfoAuthBdd->chp_personne_prenom)) {
        $chp_personne_prenom = $objet_pear_auth->getAuthData($InfoAuthBdd->chp_personne_prenom);
    }
    $chp_personne_nom='';
    if (isset($InfoAuthBdd->chp_personne_nom)) {
    	$chp_personne_nom = $objet_pear_auth->getAuthData($InfoAuthBdd->chp_personne_nom);
    }                
    $chp_structure='';           
    if (isset($InfoAuthBdd->chp_structure_nom)) {
    	$chp_structure = $objet_pear_auth->getAuthData($InfoAuthBdd->chp_structure_nom);
    }
    if ($objet_pear_auth->getAuth()) { $loggue = true; } else { $loggue = false; }
            
	ob_start();
	include $options['template'];
	$retour = ob_get_contents();
	// Arrete et detruit le buffer
	ob_end_clean();		       

    return $retour;
}

// +------------------------------------------------------------------------------------------------------+
// |                                            PIED du PROGRAMME                                         |
// +------------------------------------------------------------------------------------------------------+



/* +--Fin du code ----------------------------------------------------------------------------------------+
*
* $Log: identification.php,v $
* Revision 1.35.2.2  2008-04-18 14:14:55  jp_milcent
* Gestion de plusieurs applettes identifications sur la mÃªme page html.
* Correction de bogues.
*
* Revision 1.35.2.1  2007-11-27 11:25:30  jp_milcent
* Correction bogue : non affichage de l'url d'erreur de saisie du login.
*
* Revision 1.35  2007-10-11 14:14:22  florian
* amelioration du template de l'applette inscription
*
* Revision 1.34  2007-09-18 08:40:54  alexandre_tb
* modification de la balise identification pour permettre de preciser un template.
*
* Revision 1.33  2007-08-28 14:23:35  jp_milcent
* Amélioration de la gestion des mots de passe perdus.
*
* Revision 1.32  2007-08-28 14:14:35  jp_milcent
* Ajout de la gestion des erreurs d'identification.
*
* Revision 1.31  2006-12-15 14:49:47  jp_milcent
* Correction bogue : le type de cryptage est stocké à 2 endroits...
*
* Revision 1.30  2006/12/14 15:01:05  jp_milcent
* Utilisation d'un système permettant de mémoriser les idenitifications.
* Passage à Auth 1.4.3 et DB 1.7.6.
*
* Revision 1.29  2006/12/12 13:53:54  jp_milcent
* Mise en place du nouveau format des balises d'applette.
*
* Revision 1.28  2006/12/12 13:26:42  jp_milcent
* Modification de la gestion de l'identification. Utilisation des variables de session.
*
* Revision 1.27  2006/12/08 18:14:57  jp_milcent
* Correction bogue : l'identification ne tenait pas...
*
* Revision 1.26  2006/12/01 16:33:40  florian
* Amélioration de la gestion des applettes et compatibilité avec le nouveau mode de gestion de l'inclusion des applettes.
*
* Revision 1.25  2006/11/20 18:40:33  jp_milcent
* Amélioration de la gestion des infos sur l'inscription.
* Ajout du paramêtre url_inscription_aide permettant d'indiquer l'url vers une page d'aide sur l'inscription.
*
* Revision 1.24  2006/11/20 17:42:40  jp_milcent
* Ajout d'un test activant ou pas la mémorisation de l'identification.
*
* Revision 1.23  2006/11/20 17:30:40  jp_milcent
* Amélioration de la gestion de l'identification.
* Utilisation des durées de session correcte.
* Suppression du code pour Spip non fonctionnel.
*
* Revision 1.22  2006/09/21 15:25:17  jp_milcent
* Nettoyage dans l'url de la querystring logout.
*
* Revision 1.21  2006/03/02 10:49:49  ddelon
* Fusion branche multilinguisme dans branche principale
*
* Revision 1.20  2005/12/13 11:13:35  alexandre_tb
* ajout d'un message si l'identification échoue
*
* Revision 1.19.2.1  2005/12/20 14:40:24  ddelon
* Fusion Head vers Livraison
*
* Revision 1.20  2005/12/13 11:13:35  alexandre_tb
* ajout d'un message si l'identification échoue
*
* Revision 1.19  2005/10/31 17:09:28  ddelon
* Suppression auth start suite à deconnexion ... attention aux effets de bord
*
* Revision 1.18  2005/09/27 09:07:32  ddelon
* size applette et squelettes
*
* Revision 1.17  2005/09/12 09:17:17  alexandre_tb
* utilisation de l'objet Net_URL pour ajouter la variable logout dans le lien de déconnexion
*
* Revision 1.16  2005/06/09 17:06:28  jpm
* Ajout de constantes de langue.
*
* Revision 1.15  2005/06/02 11:56:00  jpm
* Modification de l'affichage de l'identification.
*
* Revision 1.14  2005/05/19 14:00:58  jpm
* Déplacement du menu de modif de l'inscription.
*
* Revision 1.13  2005/04/14 16:37:22  jpm
* Ajout de la gestion de la modification de son inscription.
*
* Revision 1.12  2005/03/25 14:40:51  jpm
* Prise en compte du paramêtre url_inscription permettant de faire figurer dans l'applette inscription un lien vers la page d'inscription.
*
* Revision 1.11  2005/03/17 15:52:17  jpm
* Suppression d'un / causant un bogue.
*
* Revision 1.10  2005/03/15 14:47:14  jpm
* Utilisation d'un lien à la place d'un formulaire pour la déconnexion.
*
* Revision 1.9  2005/03/15 14:17:46  jpm
* Ajout d'un fichier de config et de traduction.
* Début gestion des constantes de langue.
*
* Revision 1.8  2005/03/10 12:50:44  alex
* remplacement de & par  &amp;
*
* Revision 1.7  2005/01/07 12:43:03  alex
* réauction de la taille des champs texte à 12
*
* Revision 1.6  2004/12/13 18:07:09  alex
* désauthentification spip presque parfaite
*
* Revision 1.5  2004/09/23 14:31:12  jpm
* Correction bogue sur l'identification de l'annuaire_tela.
*
* Revision 1.4  2004/09/23 10:53:44  jpm
* Suppression de l'attribut size. Gestion via les css.
*
* Revision 1.3  2004/06/28 10:18:48  alex
* suppression de balises <p>
*
* Revision 1.2  2004/06/21 07:37:30  alex
* Modification d'un label
*
* Revision 1.1  2004/06/15 15:01:41  jpm
* Changement de nom et d'arborescence de Genesia en Papyrus.
*
* Revision 1.5  2004/05/05 06:44:15  jpm
* Complément des commentaires indiquant les paquetages nécessaire à l'applette.
*
* Revision 1.4  2004/05/03 11:18:55  jpm
* Intégration de la variable globale de Génésia dans les arguments de la fonction de l'applette.
*
* Revision 1.3  2004/05/01 17:21:16  jpm
* Ajout d'un fieldset et d'une légende au formulaire.
*
* Revision 1.2  2004/05/01 16:13:07  jpm
* Ajout du nom de la balise de l'applette dans le code de l'applette.
*
* Revision 1.1  2004/05/01 11:42:01  jpm
* Ajout de l'applette identification.
*
*
* +-- Fin du code ----------------------------------------------------------------------------------------+
*/
?>
