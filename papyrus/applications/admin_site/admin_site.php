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
/**
* Application Administrateur de Papyrus.
*
* Application permettant de gérer actulement les projets et la mise en cache des pages.
* Dans l'avenir la gestion via l'interface d'administration des fichiers CSS et 
* des Squelettes pourrait être envisagée.
* Cette application peut prendre 1 des 3 arguments ci-dessous lors de son appel par un menu de Papyrus :
* - site : pour indiquer que l'on veut gérer les sites
* - cache : pour indiquer que l'on veut gérer le cache
* Liste des paquetages Pear nécessaire à cette application :
* - DB
* - Auth
* - Net_URL
*
*@package Admin_site
//Auteur original :
*@author        Jean-Pascal MILCENT <jpm@tela-botanica.org>
//Autres auteurs :
*@author        Alexandre GRANIER <alexandre@tela-botanica.org>
*@author        Laurent COUDOUNEAU <lc@gsite.org>
*@copyright     Tela-Botanica 2000-2004
*@version       $Revision: 1.12 $ $Date: 2006-10-06 10:40:51 $
// +------------------------------------------------------------------------------------------------------+
//
// $Id: admin_site.php,v 1.12 2006-10-06 10:40:51 florian Exp $
// FICHIER : $RCSfile: admin_site.php,v $
// AUTEUR  : $Author: florian $
// VERSION : $Revision: 1.12 $
// DATE    : $Date: 2006-10-06 10:40:51 $
// +------------------------------------------------------------------------------------------------------+
**/
// +------------------------------------------------------------------------------------------------------+
// |                                            ENTÊTE du PROGRAMME                                       |
// +------------------------------------------------------------------------------------------------------+

// Note : cette application fait appel à des fonctions présentent dans la bibliotheque de Papyrus.

/** Inclusion du fichier de configuration de cette application.*/
require_once GEN_CHEMIN_APPLICATION.'admin_site/configuration/adsi_configuration.inc.php';



// Inclusion des fichiers de traduction de l'appli ADSI de Papyrus
if (file_exists(ADSI_CHEMIN_LANGUE.'adsi_langue_'.$GLOBALS['_GEN_commun']['i18n'].'.inc.php')) {
    require_once ADSI_CHEMIN_LANGUE.'adsi_langue_'.$GLOBALS['_GEN_commun']['i18n'].'.inc.php';
} else {
    require_once ADSI_CHEMIN_LANGUE.'adsi_langue_'.ADSI_I18N_DEFAUT.'.inc.php';
}

/** Inclusion de la bibliothèque PEAR de conception de formulaire.*/
require_once ADSI_CHEMIN_BIBLIOTHEQUE_PEAR.'HTML/QuickForm.php';
require_once ADSI_CHEMIN_BIBLIOTHEQUE_PEAR.'HTML/QuickForm/element.php';


/** Inclusion de l'API de fonctions gérant les erreurs sql.*/
require_once ADSI_CHEMIN_BIBLIOTHEQUE_API.'debogage/BOG_sql.fonct.php';

/** Inclusion des fonctions de manipulation du sql.
* Permet la récupération d'un nouvel identifiant d'une table.*/
require_once ADSI_CHEMIN_BIBLIOTHEQUE_API.'sql/SQL_manipulation.fonct.php';

/** Inclusion des fonctions de manipulation de fichiers et dossiers.
* Permet la suppression d'un dossier et de son contenu.*/
require_once ADSI_CHEMIN_BIBLIOTHEQUE_API.'fichier/FIC_manipulation.fonct.php';

/** Inclusion de la bibliothèque de fonctions concernant les tables "gen_menu..." de Papyrus.
* Permet d'inclure la fonction d'affichage du "Vous êtes ici".*/
require_once ADSI_CHEMIN_BIBLIOTHEQUE_GEN.'pap_menu.fonct.php';

/** Inclusion de la bibliothèque de fonctions concernant les tables "gen_site..." de Papyrus.*/
require_once ADSI_CHEMIN_BIBLIOTHEQUE_GEN.'pap_site.fonct.php';

/** Inclusion de la bibliotheque de fonction gérant l'affichage de l'application Administrateur.*/
require_once ADSI_CHEMIN_BIBLIOTHEQUE_ADSI.'adsi_affichage.fonct.php';

/** Inclusion de la bibliotheque de fonction gérant l'administration des sites de Papyrus.*/
require_once ADSI_CHEMIN_BIBLIOTHEQUE_ADSI.'adsi_site.fonct.php';



///** Inclusion de la bibliotheque de fonction gérant l'administration du cache de Papyrus.*/
//require_once ADSI_CHEMIN_BIBLIOTHEQUE_ADSI.'adsi_cache.fonct.php';

///** Inclusion de la bibliotheque de fonction gérant l'administration des squelettes des sites de Papyrus.*/
//require_once ADSI_CHEMIN_BIBLIOTHEQUE_ADSI.'adsi_squelette.fonct.php';

///** Inclusion de la bibliotheque de fonction gérant l'administration des feuilles de styles des sites de Papyrus.*/
//require_once ADSI_CHEMIN_BIBLIOTHEQUE_ADSI.'adsi_style.fonct.php';

// +------------------------------------------------------------------------------------------------------+
// |                                            CORPS du PROGRAMME                                        |
// +------------------------------------------------------------------------------------------------------+

/** Fonction afficherContenuTete() - Fonction appelé par le gestionnaire Papyrus.
*
* Elle retourne l'entête de l'application..
*
* @return  string  du code XHTML correspondant à la zone d'entête de l'application.
*/
function afficherContenuTete()
{
    return '';
}

/** Fonction afficherContenuCorps() - Retourne le contenu XHTML à afficherdans la zone contenu corps.
*
* Cette fonction retourne le contenu final d'un appel à l'application Administrateur.
* Cette fonction peut être appelé par Papyrus où depuis n'importe quel autre interface.
*
* @return  string  le contenu xhtml généré par l'application Administrateur et devant être affiché.
*/
function afficherContenuCorps() 
{

    // +----------------------------------------------------------------------------------------------+
    // Initialisation des variables 
    
    // +----------------------------------------------------------------------------------------------+
    // Objet Pear Auth
    $objet_pear_auth =& $GLOBALS['_GEN_commun']['pear_auth'];
    // +----------------------------------------------------------------------------------------------+
    // Gestion de l'URL pour revenir sur le menu courant.
    $url = $GLOBALS['_GEN_commun']['url']->getUrl();
    // +----------------------------------------------------------------------------------------------+
    if ($objet_pear_auth->getAuth()) {
        // +----------------------------------------------------------------------------------------------+
        // Initialisation des variables.
        $sortie_xhtml = '';// Le XHTML à renvoyer.// Ancien nom : $outputText
        $msg = '';
        
        // +----------------------------------------------------------------------------------------------+
        // Arguments passé par le menu de Papyrus à l'application l'Administrateur de site.
        
        // Initialisation des variables qui contiendront les arguments
        $id_site_a_administrer  = '';
        $bool_site              = false;
        $bool_auth              = false;
        $bool_cache             = false;
        $bool_squelette         = false;
        $bool_style             = false;
        
        // Instantciation des variables arguments
        if (isset($GLOBALS['_GEN_commun']['info_application']->id_site)) {
            $id_site_a_administrer = $GLOBALS['_GEN_commun']['info_application']->id_site;
        }
        
        if (isset($GLOBALS['_GEN_commun']['info_application']->bool_site) && $GLOBALS['_GEN_commun']['info_application']->bool_site == 'true') {
            // Interface d'administration des sites
            $bool_site = true;
        }
        
        if (isset($GLOBALS['_GEN_commun']['info_application']->bool_auth) && $GLOBALS['_GEN_commun']['info_application']->bool_auth == 'true') {
            // Interface d'administration du cache d'un site
            $bool_cache = true;
        }
        
        if (isset($GLOBALS['_GEN_commun']['info_application']->bool_cache) && $GLOBALS['_GEN_commun']['info_application']->bool_cache == 'true') {
            // Interface d'administration du cache d'un site
            $bool_cache = true;
        }
        
        if (isset($GLOBALS['_GEN_commun']['info_application']->bool_squelette) && $GLOBALS['_GEN_commun']['info_application']->bool_squelette == 'true') {
            // Interface d'administration du fichier squelette d'un site
            $bool_squelette = true;
        }
        if (isset($GLOBALS['_GEN_commun']['info_application']->bool_style) && $GLOBALS['_GEN_commun']['info_application']->bool_style == 'true') {
            // Interface d'administration du fichier de styles d'un site
            $bool_style = true;
        }
        
        // Si aucun argument transmis on affiche l'interface de gestion des sites
        if ( !($bool_site && $bool_cache && $bool_squelette && $bool_style) ) {
            $bool_site = true;
        }
        
        // +----------------------------------------------------------------------------------------------+
        // Gestion des sites...
        if ($bool_site) {
            if (isset($_POST['form_sites_ajouter'])) {
                // Nous voulons le formulaire d'ajout d'un site
                $sortie_xhtml .= ADMIN_afficherFormSite($GLOBALS['_GEN_commun']['pear_db'], $url);
                return $sortie_xhtml;
            } else if (isset($_POST['site_enregistrer'])) {
                // Nous cherchons à enregistrer un site
                $message = ADMIN_validerFormSite($GLOBALS['_GEN_commun']['pear_db'], $_POST);
                if (!empty($message)) {
                    // Les données ne sont pas valide. Nous retournons le formulaires avec les messages d'erreurs.
                    $sortie_xhtml .= ADMIN_afficherFormSite($GLOBALS['_GEN_commun']['pear_db'], $url, $_POST, $message);
                } else {
                    // Les données sont valide. Nous les enregistrons et retournons au formulaire de départ.
                    $message = ADMIN_enregistrerSite($GLOBALS['_GEN_commun']['pear_db'], $_POST, $objet_pear_auth->getAuthData('ga_id_administrateur'));
                    $sortie_xhtml .= ADMIN_afficherFormListeSites($GLOBALS['_GEN_commun']['pear_db'], $url, $message);
                }
                return $sortie_xhtml;
            } else if (isset($_POST['form_sites_modifier'])) {
                // Nous cherchons à modifier un site
                $message = ADMIN_validerFormListesSites($GLOBALS['_GEN_commun']['pear_db'], $_POST);
                if (!empty($message)) {
                    // Les données ne sont pas valide. Nous retournons le formulaires avec les messages d'erreurs.
                    $sortie_xhtml .= ADMIN_afficherFormListeSites($GLOBALS['_GEN_commun']['pear_db'], $url, $message);
                } else {
                    // Les données sont valide. Nous affichons le formulaire de modification.
                    $sortie_xhtml .= ADMIN_afficherFormSite($GLOBALS['_GEN_commun']['pear_db'], $url, $_POST, $message);
                }
                return $sortie_xhtml;
            } else if (isset($_POST['site_modifier'])) {
                // Nous cherchons à enregistrer les modification d'un site
                $message = ADMIN_validerFormSite($GLOBALS['_GEN_commun']['pear_db'], $_POST);
                if (!empty($message)) {
                    // Les données ne sont pas valide. Nous retournons le formulaires avec les messages d'erreurs.
                    $sortie_xhtml .= ADMIN_afficherFormSite($GLOBALS['_GEN_commun']['pear_db'], $url, $_POST, $message);
                } else {
                    // Les données sont valide. Nous les enregistrons et retournons au formulaire de départ.
                    $message = ADMIN_modifierSite($GLOBALS['_GEN_commun']['pear_db'], $_POST, $objet_pear_auth->getAuthData('ga_id_administrateur'));
                    $sortie_xhtml .= ADMIN_afficherFormListeSites($GLOBALS['_GEN_commun']['pear_db'], $url, $message);
                }
                return $sortie_xhtml;
            } else if (isset($_POST['form_sites_supprimer'])) {
                // Nous cherchons à supprimer un site
                $message = ADMIN_validerFormListesSites($GLOBALS['_GEN_commun']['pear_db'], $_POST);
                if (!empty($message)) {
                    // Les données ne sont pas valide. Nous retournons le formulaires avec les messages d'erreurs.
                    $sortie_xhtml .= ADMIN_afficherFormListeSites($GLOBALS['_GEN_commun']['pear_db'], $url, $message);
                } else {
                    // Les données sont valide. Nous supprimons et retournons au formulaire de départ.
                    $message = ADMIN_supprimerSite($GLOBALS['_GEN_commun']['pear_db'], $_POST);
                    $sortie_xhtml .= ADMIN_afficherFormListeSites($GLOBALS['_GEN_commun']['pear_db'], $url, $message);
                }
                return $sortie_xhtml;
            } else if (isset($_POST['form_sites_traduire'])) {
                // Nous cherchons à traduire un site
                $message = ADMIN_validerFormListesSites($GLOBALS['_GEN_commun']['pear_db'], $_POST);
                if ((!empty($message))) {
                    // Les données ne sont pas valide. Nous retournons le formulaires avec les messages d'erreurs.
                    $sortie_xhtml .= ADMIN_afficherFormListeSites($GLOBALS['_GEN_commun']['pear_db'], $url, $message);
                } else {
                	$message = ADMIN_verifier_traduction_possible($GLOBALS['_GEN_commun']['pear_db'], $_POST);
                	if ((!empty($message))) {
                    // Les données ne sont pas valide. Nous retournons le formulaires avec les messages d'erreurs.
                    $sortie_xhtml .= ADMIN_afficherFormListeSites($GLOBALS['_GEN_commun']['pear_db'], $url, $message);
                	}
                	else {
	                    // 	Les données sont valide. Nous affichons le formulaire de traduction
    	                $sortie_xhtml .= ADMIN_afficherFormSite($GLOBALS['_GEN_commun']['pear_db'], $url, $_POST, $message);
                	}
                }
                return $sortie_xhtml;
            } else if (isset($_POST['site_traduire'])) {
                // Nous cherchons à enregistrer la  traduction d'un site
                $message = ADMIN_validerFormSite($GLOBALS['_GEN_commun']['pear_db'], $_POST);
                $message='';
                if (!empty($message)) {
                    // Les données ne sont pas valide. Nous retournons le formulaires avec les messages d'erreurs.
                    $sortie_xhtml .= ADMIN_afficherFormSite($GLOBALS['_GEN_commun']['pear_db'], $url, $_POST, $message);
                } else {
                    // Les données sont valide. Nous les enregistrons et retournons au formulaire de départ.
                    $message = ADMIN_traduireSite($GLOBALS['_GEN_commun']['pear_db'], $_POST, $objet_pear_auth->getAuthData('ga_id_administrateur'));
                    $sortie_xhtml .= ADMIN_afficherFormListeSites($GLOBALS['_GEN_commun']['pear_db'], $url, $message);
                }
                return $sortie_xhtml;
            } else if (isset($_POST['form_annuler'])) {
                // Retour à la liste des sites
                $sortie_xhtml .= ADMIN_afficherFormListeSites($GLOBALS['_GEN_commun']['pear_db'], $url);
                return $sortie_xhtml;
            } else {
                // Liste des sites
                $sortie_xhtml .= ADMIN_afficherFormListeSites($GLOBALS['_GEN_commun']['pear_db'], $url);
            }
        }
        // +----------------------------------------------------------------------------------------------+
        // Gestion du cache... A FAIRE
        if ($bool_cache) {
            
        }
        // +----------------------------------------------------------------------------------------------+
        // Gestion des squelettes... A FAIRE
        if ($bool_squelette) {
            
        }
        // +----------------------------------------------------------------------------------------------+
        // Gestion des styles... A FAIRE
        if ($bool_style) {
            
        }
        
        return $sortie_xhtml;
    } else {
        // L'utilisateur n'est pas identifie, nous lui demandons de le faire.        
        $res='';
    	$res .= '<p class="zone_alert">'.ADSI_IDENTIFIEZ_VOUS.'</p>'."\n" ;
		$res .= '<form id="form_connexion" style="clear:both;" class="form_identification" action="' ;		
		$res .= $url;
		$res .= '" method="post">
                <fieldset>
                    <legend>Identifiez vous</legend>                    
                        <label for="username">Courriel : </label>
                        <input type="text"  id="username" name="username" maxlength="80" tabindex="1" value="courriel" />                    
                        <label for="password">Mot de passe : </label>
                        <input type="password" id="password" name="password" maxlength="80" tabindex="2" value="mot de passe" />                    
                        <input type="submit" id="connexion" name="connexion" tabindex="3" value="ok" />                    
                </fieldset>
                </form>';
        return $res ;    
    }
}//Fin de la fonction afficherContenuCorps().

/* +--Fin du code ---------------------------------------------------------------------------------------+
* $Log: admin_site.php,v $
* Revision 1.12  2006-10-06 10:40:51  florian
* harmonisation des messages d'erreur de l'authentification
*
* Revision 1.11  2006/03/15 23:35:25  ddelon
* Gestion site
*
* Revision 1.10  2006/03/02 10:49:49  ddelon
* Fusion branche multilinguisme dans branche principale
*
* Revision 1.9.2.2  2006/02/28 14:02:09  ddelon
* Finition multilinguisme
*
* Revision 1.9.2.1  2006/01/19 21:26:20  ddelon
* Multilinguisme site + bug ftp
*
* Revision 1.9  2005/04/08 13:28:43  jpm
* Utiliation de références.
*
* Revision 1.8  2005/02/28 13:09:17  jpm
* Correction bogue : virgule manquante.
*
* Revision 1.7  2005/02/28 11:07:05  jpm
* Modification des auteurs.
*
* Revision 1.6  2005/02/28 10:58:38  jpm
* Suppression de code inutile.
*
* Revision 1.5  2005/02/28 10:32:06  jpm
* Changement de nom de dossier.
*
* Revision 1.4  2004/12/03 19:22:57  jpm
* Gestion des types de sites externes gérés par Papyrus.
*
* Revision 1.3  2004/10/18 18:27:37  jpm
* Correction problèmes FTP et manipulation de fichiers.
*
* Revision 1.2  2004/07/06 17:08:14  jpm
* Modification de la documentation pour une mailleur analyse par PhpDocumentor.
*
* Revision 1.1  2004/06/16 14:20:39  jpm
* Changement de nom de Génésia en Papyrus.
* Changement de l'arborescence.
*
* Revision 1.23  2004/05/10 12:23:26  jpm
* Correction mineure.
*
* Revision 1.22  2004/05/07 16:33:18  jpm
* Intégration de constantes.
*
* Revision 1.21  2004/05/07 07:23:03  jpm
* Ajout de la gestion des modification et suppression de site. Amélioration de la création des sites.
*
* Revision 1.20  2004/05/05 06:45:36  jpm
* Suppression de l'appel de la fonction générant le "vous êtes ici" dans la fonction affichant l'entête de l'application.
*
* Revision 1.19  2004/05/04 16:28:30  jpm
* Réduction de code pour la fonction afficherContenuTete().
*
* Revision 1.18  2004/04/30 16:22:59  jpm
* Poursuite de l'administration des sites.
*
* Revision 1.17  2004/04/22 08:33:11  jpm
* Transformation de $GS_GLOBAL en $_GEN_commun.
*
* Revision 1.16  2004/04/09 16:24:08  jpm
* Prise en compte des tables i18n.
*
* Revision 1.15  2004/04/02 16:37:09  jpm
* Modification de la gestion des actions d'administration.
* Ajout de commentaires.
*
* Revision 1.14  2004/03/31 16:58:15  jpm
* Changement des chemins d'accès aux fichiers à inclure.
*
* Revision 1.13  2004/03/24 10:07:04  jpm
* Ajout des commentaires d'entête.
* Début mise en conformité avec la convention de codage.
* Déplacement de la fonction d'affichage du xhtml dans la bibliothèque de fonctions.
*
* +--Fin du code ----------------------------------------------------------------------------------------+
*/
?>