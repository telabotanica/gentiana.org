<?php
/*vim: set expandtab tabstop=4 shiftwidth=4: */ 
// Copyright (C) 1999-2004 Tela Botanica (accueil@tela-botanica.org)
//
// Ce logiciel est un programme informatique servant � g�rer du contenu et des
// applications web.
                                                                                                      
// Ce logiciel est r�gi par la licence CeCILL soumise au droit fran�ais et
// respectant les principes de diffusion des logiciels libres. Vous pouvez
// utiliser, modifier et/ou redistribuer ce programme sous les conditions
// de la licence CeCILL telle que diffus�e par le CEA, le CNRS et l'INRIA 
// sur le site "http://www.cecill.info".

// En contrepartie de l'accessibilit� au code source et des droits de copie,
// de modification et de redistribution accord�s par cette licence, il n'est
// offert aux utilisateurs qu'une garantie limit�e.  Pour les m�mes raisons,
// seule une responsabilit� restreinte p�se sur l'auteur du programme,  le
// titulaire des droits patrimoniaux et les conc�dants successifs.

// A cet �gard  l'attention de l'utilisateur est attir�e sur les risques
// associ�s au chargement,  � l'utilisation,  � la modification et/ou au
// d�veloppement et � la reproduction du logiciel par l'utilisateur �tant 
// donn� sa sp�cificit� de logiciel libre, qui peut le rendre complexe � 
// manipuler et qui le r�serve donc � des d�veloppeurs et des professionnels
// avertis poss�dant  des  connaissances  informatiques approfondies.  Les
// utilisateurs sont donc invit�s � charger  et  tester  l'ad�quation  du
// logiciel � leurs besoins dans des conditions permettant d'assurer la
// s�curit� de leurs syst�mes et ou de leurs donn�es et, plus g�n�ralement, 
// � l'utiliser et l'exploiter dans les m�mes conditions de s�curit�. 

// Le fait que vous puissiez acc�der � cet en-t�te signifie que vous avez 
// pris connaissance de la licence CeCILL, et que vous en avez accept� les
// termes.
// ----
// CVS : $Id: admin_menu.php,v 1.29 2007-10-25 10:10:23 alexandre_tb Exp $
/**
* Application g�rant les menus de Papyrus
*
* Cette application permet de g�rer les menus classiques, les menus communs 
* et les liaison d'une application � un menu.
*
*@package Admin_menu
//Auteur original :
*@author        Jean-Pascal MILCENT <jpm@tela-botanica.org>
//Autres auteurs :
*@author        Alexandre GRANIER <alexandre@tela-botanica.org>
*@author        Laurent COUDOUNEAU <lc@gsite.org>
*@copyright     Tela-Botanica 2000-2004
*@version       $Revision: 1.29 $ $Date: 2007-10-25 10:10:23 $
// +------------------------------------------------------------------------------------------------------+
*/

// +------------------------------------------------------------------------------------------------------+
// |                                            ENTETE du PROGRAMME                                       |
// +------------------------------------------------------------------------------------------------------+
/** Inclusion du fichier de configuration de cette application.*/
require_once GEN_CHEMIN_PAP.'applications/admin_menu/configuration/adme_configuration.inc.php';

//Utilisation de la bibliotheque PEAR NET_URL

/** Inclusion de la bibliotheque PEAR de conception de formulaire.*/
require_once ADME_CHEMIN_BIBLIOTHEQUE_PEAR.'HTML/QuickForm.php';
require_once ADME_CHEMIN_BIBLIOTHEQUE_PEAR.'HTML/QuickForm/select.php';

/** Inclusion de l'API de fonctions gerant les erreurs sql.*/
require_once ADME_CHEMIN_BIBLIOTHEQUE_API.'debogage/BOG_sql.fonct.php';

/** Inclusion des fonctions de manipulation du sql.
* Permet la recuperation d'un nouvel identifiant d'une table.*/
require_once ADME_CHEMIN_BIBLIOTHEQUE_API.'sql/SQL_manipulation.fonct.php';

/** <BR> Inclusion de la bibliotheque de fonctions concernant les tables "gen_site..." de Papyrus.*/
require_once ADME_CHEMIN_BIBLIOTHEQUE_GEN.'pap_site.fonct.php';

/** <BR> Inclusion de la bibliotheque de fonctions concernant les tables "gen_menu..." de Papyrus.*/
require_once ADME_CHEMIN_BIBLIOTHEQUE_GEN.'pap_menu.fonct.php';

/** <BR> Inclusion de la bibliotheque de fonctions concernant les tables "gen_applications..." de Papyrus.*/
require_once ADME_CHEMIN_BIBLIOTHEQUE_GEN.'pap_application.fonct.php';

/** <BR> Inclusion de la bibliotheque de fonctions concernant l'affichage commun.*/
require_once ADME_CHEMIN_BIBLIOTHEQUE_ADME.'adme_general.fonct.php';//ok

/** <BR> Inclusion de la bibliotheque de fonctions concernant la gestion des menus classiques.*/
require_once ADME_CHEMIN_BIBLIOTHEQUE_ADME.'adme_menu_classique.fonct.php';//ok

/** <BR> Inclusion de la bibliotheque de fonctions concernant la gestion des menus communs.*/
require_once ADME_CHEMIN_BIBLIOTHEQUE_ADME.'adme_menu_commun.fonct.php';//ok

/** <BR> Inclusion de la bibliotheque de fonctions concernant la gestion de la redaction de contenu.*/
//require_once ADME_CHEMIN_BIBLIOTHEQUE_ADME.'adme_contenu.fonct.php';//ok

// Inclusion des fichiers de traduction de l'appli ADME dePapyrus
if (file_exists(ADME_CHEMIN_LANGUE.'adme_langue_'.$GLOBALS['_GEN_commun']['i18n'].'.inc.php')) {
    /** Inclusion du fichier de traduction suite a la transaction avec le navigateur.*/
    require_once ADME_CHEMIN_LANGUE.'adme_langue_'.$GLOBALS['_GEN_commun']['i18n'].'.inc.php';
} else {
    /** Inclusion du fichier de traduction par defaut.*/
    require_once ADME_CHEMIN_LANGUE.'adme_langue_'.ADME_I18N_DEFAUT.'.inc.php';
}

// Stockage des styles de l'application
GEN_stockerStyleExterne('adme_standard', ADME_CHEMIN_STYLE.'adme_standard.css');

// +------------------------------------------------------------------------------------------------------+
// |                                            CORPS du PROGRAMME                                        |
// +------------------------------------------------------------------------------------------------------+

function afficherContenuCorps()
{
	
	

    //-------------------------------------------------------------------------------------------------------------------
    // Initialisation des variables
    $sortie_xhtml = '';
    $objet_pear_auth = $GLOBALS['_GEN_commun']['pear_auth'];
    $objet_pear_db = $GLOBALS['_GEN_commun']['pear_db'];
    $objet_pear_url = $GLOBALS['_GEN_commun']['url'];
    $copie_objet_pear_url = (PHP_VERSION < 5) ? $objet_pear_url : clone($objet_pear_url); 
    $url_site = $GLOBALS['_GEN_commun']['url_site'];
    if (isset($GLOBALS['_GEN_commun']['url_menu'])) {
	    $url_menu = $GLOBALS['_GEN_commun']['url_menu'];
    }
    if (isset($_POST['adme_site_id'])) {
        $_GET['adme_site_id'] = $_POST['adme_site_id'];
    } else {
        $_GET['adme_site_id'] = (!isset($_GET['adme_site_id'])) ? 1 : $_GET['adme_site_id'];
    }
    $_GET['adme_menu_id'] = (!isset($_GET['adme_menu_id'])) ? 0 : $_GET['adme_menu_id'];
    $_GET['adme_action'] = (!isset($_GET['adme_action'])) ? '' : $_GET['adme_action'];
    
    //-------------------------------------------------------------------------------------------------------------------
    // Authentification
    if ($objet_pear_auth->getAuth()) {
        //---------------------------------------------------------------------------------------------------------------
        // GESTION DES MENUS CLASSIQUES
        
        // Ajouter un menu classique
        if (isset($_GET['adme_action']) && $_GET['adme_action'] == ADME_LG_ACTION_CLASSIQUE_AJOUTER) {
            $message = ADME_ajouterMenuClassique($objet_pear_db, $objet_pear_auth, $_GET['adme_site_id'], $_GET['adme_menu_id']);
            $copie_objet_pear_url->addQueryString('adme_site_id',$_GET['adme_site_id']);
			header("Location: ".str_replace('&amp;', '&', $copie_objet_pear_url->getUrl()));
			exit;
        }
        
                
        // Formulaire de mise � jour du menu
        if (isset($_GET['adme_action']) && $_GET['adme_action'] == ADME_LG_ACTION_CLASSIQUE_MODIFIER) {
        	$copie_objet_pear_url->addQueryString('adme_site_id',$_GET['adme_site_id']);
        	$copie_objet_pear_url->addQueryString('adme_menu_id',$_GET['adme_menu_id']);
        	$copie_objet_pear_url->addQueryString('adme_action',ADME_LG_ACTION_CLASSIQUE_MODIFIER_ACTION);
        	header("Location: ".str_replace('&amp;', '&', $copie_objet_pear_url->getUrl()));
        	exit;
        }
          
        if (isset($_GET['adme_action']) && $_GET['adme_action'] == ADME_LG_ACTION_CLASSIQUE_MODIFIER_ACTION) {
            $sortie_xhtml .= ADME_afficherFormMenuClassique($objet_pear_db, $objet_pear_url, $_GET['adme_site_id'], $_GET['adme_menu_id'], $_POST);
            return $sortie_xhtml;
        }
        
        //var_dump($_POST);
        if (isset($_POST['form_boutons'][ADME_LG_ACTION_CLASSIQUE_VERIFIER])) {
            // Nous cherchons a enregistrer une modification de menu
            $message = ADME_validerFormAjouterMenuClassique($objet_pear_db, $_POST);
            if (!empty($message)) {
                // Les donnees ne sont pas valide. Nous retournons le formulaires avec les messages d'erreurs.
                $sortie_xhtml .= $message;
                $sortie_xhtml .= ADME_afficherFormMenuClassique($objet_pear_db, $objet_pear_url, $_GET['adme_site_id'], $_GET['adme_menu_id'], $_POST);
                return $sortie_xhtml;
            } else {
                // Les donnees sont valide. Nous les enregistrons et retournons au formulaire de depart.
                $message = ADME_modifierMenuClassique($objet_pear_db, $objet_pear_auth, $_GET['adme_menu_id'], $_POST);
            }
        }
        
        // Deplacer le menu vers le haut
        if (isset($_GET['adme_action']) && $_GET['adme_action'] == ADME_LG_ACTION_CLASSIQUE_MONTER) {
            ADME_deplacerMenuClassique($objet_pear_db, $_GET['adme_site_id'], $_GET['adme_menu_id'], true);
        }
        
        // Deplacer le menu vers le bas
        if (isset($_GET['adme_action']) && $_GET['adme_action'] == ADME_LG_ACTION_CLASSIQUE_DESCENDRE) {
            ADME_deplacerMenuClassique($objet_pear_db, $_GET['adme_site_id'], $_GET['adme_menu_id'], false);
        }
        
        // Deplacer le menu vers la gauche (diminuer d'un niveau)
        if (isset($_GET['adme_action']) && $_GET['adme_action'] == ADME_LG_ACTION_CLASSIQUE_DIMINUER) {
            ADME_indenterMenuClassique($objet_pear_db, $_GET['adme_site_id'], $_GET['adme_menu_id'], true);
        }
        
        // Deplacer le menu vers la droite (augmenter d'un niveau)
        if (isset($_GET['adme_action']) && $_GET['adme_action'] == ADME_LG_ACTION_CLASSIQUE_AUGMENTER) {
            ADME_indenterMenuClassique($objet_pear_db, $_GET['adme_site_id'], $_GET['adme_menu_id'], false);
        }
        
        // Traduire le menu 
        if (isset($_GET['adme_action']) && $_GET['adme_action'] == ADME_LG_ACTION_CLASSIQUE_TRADUIRE) {
        	$message='';
        	$message = ADME_verifier_traduction_possible($objet_pear_db, $objet_pear_url, $_GET['adme_site_id'], $_GET['adme_menu_id'], $_POST);
            if ((!empty($message))) {
            // Pas de traduction possible !
                $sortie_xhtml .= $message;
            	$sortie_xhtml .= ADME_afficherFormPrincipal($objet_pear_db, $objet_pear_url, $_GET['adme_site_id'], $_GET['adme_menu_id'], $_GET['adme_action']);
        		return $sortie_xhtml;
            }
            else {
		        // 	Les donn�es sont valide. Nous affichons le formulaire de traduction
	        	$copie_objet_pear_url->addQueryString('adme_site_id',$_GET['adme_site_id']);
	        	$copie_objet_pear_url->addQueryString('adme_menu_id',$_GET['adme_menu_id']);
	        	$copie_objet_pear_url->addQueryString('adme_action',ADME_LG_ACTION_CLASSIQUE_TRADUIRE_ACTION);
	        	header("Location: ".str_replace('&amp;', '&', $copie_objet_pear_url->getUrl()));
	        	exit;
        	}
        	
        }
        
        if (isset($_GET['adme_action']) && $_GET['adme_action'] == ADME_LG_ACTION_CLASSIQUE_TRADUIRE_ACTION) {
        	$sortie_xhtml .= ADME_afficherFormMenuClassique($objet_pear_db, $objet_pear_url, $_GET['adme_site_id'], $_GET['adme_menu_id'], $_POST,TRUE);
        	return $sortie_xhtml;
        }
        
        
        if (isset($_POST['form_boutons'][ADME_LG_ACTION_CLASSIQUE_VERIFIER_TRADUCTION])) {
            // Nous cherchons a enregistrer une traduction de menu
            $message = ADME_validerFormTraduireMenuClassique($objet_pear_db, $_POST);
            if (!empty($message)) {
                // Les donnees ne sont pas valide. Nous retournons le formulaires avec les messages d'erreurs.
                $sortie_xhtml .= $message;
                $sortie_xhtml .= ADME_afficherFormMenuClassique($objet_pear_db, $objet_pear_url, $_GET['adme_menu_id'], $_POST);
                return $sortie_xhtml;
            } else {
                // Les donnees sont valide. Nous les enregistrons et retournons au formulaire de depart.
                $message = ADME_traduireMenuClassique($objet_pear_db, $objet_pear_auth, $_GET['adme_menu_id'], $_POST);
            }
        }
        
        
        // Supprimer le menu
        if (isset($_GET['adme_action']) && $_GET['adme_action'] == ADME_LG_ACTION_CLASSIQUE_SUPPRIMER) {
            // Recuperation du menu de remplacement pour eviter de fermer l'arborescence
            if (GEN_donnerDernierFreres($_GET['adme_menu_id']) == false) {
                $adme_menu_id_remplacement = GEN_lireIdentifiantMenuPere($_GET['adme_menu_id']);;
            } else {
                $adme_menu_id_remplacement = GEN_donnerDernierFreres($_GET['adme_menu_id']);
            }
            // Suppression du menu classique
            $message = ADME_supprimerMenuClassique($objet_pear_db, $_GET['adme_site_id'], $_GET['adme_menu_id']);
            // Remplacement de l'id du menu courant par le remplacant.
            $_GET['adme_menu_id'] = $adme_menu_id_remplacement;
            $copie_objet_pear_url->addQueryString('adme_site_id',$_GET['adme_site_id']);
            header("Location: ".str_replace('&amp;', '&', $copie_objet_pear_url->getUrl()));
            exit;
        }
        
        
        // Supprimer le menu traduit
        if (isset($_GET['adme_action']) && $_GET['adme_action'] == ADME_LG_ACTION_CLASSIQUE_SUPPRIMER_TRADUCTION) {
            // Suppression du menu classique
            $message = ADME_supprimerMenuClassiqueTraduction($objet_pear_db, $_GET['adme_site_id'], $_GET['adme_menu_id']);
            $copie_objet_pear_url->addQueryString('adme_site_id',$_GET['adme_site_id']);
            header("Location: ".str_replace('&amp;', '&', $copie_objet_pear_url->getUrl()));
            exit;
        }
        
        // Selectionner le menu comme traduction par defaut :
        
        if (isset($_GET['adme_action']) && $_GET['adme_action'] == ADME_LG_ACTION_CLASSIQUE_TRADUCTION_DEFAUT) {
            $message = ADME_selectionnerMenuClassiqueTraduction($objet_pear_db, $_GET['adme_site_id'], $_GET['adme_menu_id']);
            $copie_objet_pear_url->addQueryString('adme_site_id',$_GET['adme_site_id']);
            header("Location: ".str_replace('&amp;', '&', $copie_objet_pear_url->getUrl()));
            exit;
        }
        
        
        // Restreindre le menu a la langue selectionne
        
        if (isset($_GET['adme_action']) && $_GET['adme_action'] == ADME_LG_ACTION_CLASSIQUE_LIMITER) {
            $message = ADME_limiterMenuClassique($objet_pear_db, $_GET['adme_site_id'], $_GET['adme_menu_id'],$_GET['zone']);
            $copie_objet_pear_url->addQueryString('adme_site_id',$_GET['adme_site_id'],$_GET['zone']);
            header("Location: ".str_replace('&amp;', '&', $copie_objet_pear_url->getUrl()));
            exit;
        }

        // Ouvrir le menu suite a une restriction
        
        if (isset($_GET['adme_action']) && $_GET['adme_action'] == ADME_LG_ACTION_CLASSIQUE_OUVRIR) {
            $message = ADME_ouvrirMenuClassique($objet_pear_db, $_GET['adme_site_id'], $_GET['adme_menu_id']);
            $copie_objet_pear_url->addQueryString('adme_site_id',$_GET['adme_site_id']);
            header("Location: ".str_replace('&amp;', '&', $copie_objet_pear_url->getUrl()));
            exit;
        }
        
        
        
        
        
        //---------------------------------------------------------------------------------------------------------------
        // GESTION DES MENUS COMMUNS
        
        // Ajout un menu commun
        if (isset($_GET['adme_action']) && $_GET['adme_action'] == ADME_LG_ACTION_COMMUN_AJOUTER) {
            $message = ADME_ajouterMenuCommun($objet_pear_db, $objet_pear_auth, $_GET['adme_site_id'], $_GET['adme_menu_id']);
            $copie_objet_pear_url->addQueryString('adme_site_id',$_GET['adme_site_id']);
			header("Location: ".str_replace('&amp;', '&', $copie_objet_pear_url->getUrl()));
			exit;
            
        }
        
        
        
        // Formulaire de mise a jour du menu commun.
        if (isset($_GET['adme_action']) && $_GET['adme_action'] == ADME_LG_ACTION_COMMUN_MODIFIER) {
            $copie_objet_pear_url->addQueryString('adme_site_id',$_GET['adme_site_id']);
        	$copie_objet_pear_url->addQueryString('adme_menu_id',$_GET['adme_menu_id']);
        	$copie_objet_pear_url->addQueryString('adme_action',ADME_LG_ACTION_COMMUN_MODIFIER_ACTION);
        	header("Location: ".str_replace('&amp;', '&', $copie_objet_pear_url->getUrl()));
        	exit;
        }
        
            
        if (isset($_GET['adme_action']) && $_GET['adme_action'] == ADME_LG_ACTION_COMMUN_MODIFIER_ACTION) {
            $sortie_xhtml .= ADME_afficherFormMenuClassique($objet_pear_db, $objet_pear_url, $_GET['adme_site_id'], $_GET['adme_menu_id'], $_POST);
            return $sortie_xhtml;
        }
        
        
        
        if (isset($_POST[ADME_LG_ACTION_COMMUN_VERIFIER])) {
            // Nous cherchons a enregistrer une modification de menu
            $message = ADME_validerFormAjouterMenuCommun($objet_pear_db, $_POST);
            if (!empty($message)) {
                // Les donnees ne sont pas valide. Nous retournons le formulaires avec les messages d'erreurs.
                $sortie_xhtml .= $message;
                $sortie_xhtml .= ADME_afficherFormMenuCommun($objet_pear_db, $objet_pear_url, $_GET['adme_site_id'], $_GET['adme_menu_id'], $_POST);
                return $sortie_xhtml;
            } else {
                // Les donnees sont valide. Nous les enregistrons et retournons au formulaire de depart.
                $message = ADME_modifierMenuCommun($objet_pear_db, $objet_pear_auth, $_GET['adme_menu_id'], $_POST);
            }
        }
        
        // Deplace vers le haut de la hierarchie un menu commun
        if (isset($_GET['adme_action']) && $_GET['adme_action'] == ADME_LG_ACTION_COMMUN_MONTER) {
            ADME_deplacerMenuCommun($objet_pear_db, $_GET['adme_site_id'], $_GET['adme_menu_id'], true);
        }
        
        // Deplace vers le bas de la hierarchie un menu commun
        if (isset($_GET['adme_action']) && $_GET['adme_action'] == ADME_LG_ACTION_COMMUN_DESCENDRE) {
            ADME_deplacerMenuCommun($objet_pear_db, $_GET['adme_site_id'], $_GET['adme_menu_id'], false);
        }

        // Deplacer le menu vers la gauche (diminuer d'un niveau)
        if (isset($_GET['adme_action']) && $_GET['adme_action'] == ADME_LG_ACTION_COMMUN_DIMINUER) {
            ADME_indenterMenuCommun($objet_pear_db, $_GET['adme_site_id'], $_GET['adme_menu_id'], true);
        }
        
        // Deplacer le menu vers la droite (augmenter d'un niveau)
        if (isset($_GET['adme_action']) && $_GET['adme_action'] == ADME_LG_ACTION_COMMUN_AUGMENTER) {
            ADME_indenterMenuCommun($objet_pear_db, $_GET['adme_site_id'], $_GET['adme_menu_id'], false);
        }
        
        // Traduire le menu 
        if (isset($_GET['adme_action']) && $_GET['adme_action'] == ADME_LG_ACTION_COMMUN_TRADUIRE) {
        	$message='';
        	$message = ADME_verifier_traduction_possible($objet_pear_db, $objet_pear_url, $_GET['adme_site_id'], $_GET['adme_menu_id'], $_POST);
            if ((!empty($message))) {
            // Pas de traduction possible !
                $sortie_xhtml .= $message;
            	$sortie_xhtml .= ADME_afficherFormPrincipal($objet_pear_db, $objet_pear_url, $_GET['adme_site_id'], $_GET['adme_menu_id'], $_GET['adme_action']);
        		return $sortie_xhtml;
            }
            else {
		        // 	Les donn�es sont valide. Nous affichons le formulaire de traduction
	        	$copie_objet_pear_url->addQueryString('adme_site_id',$_GET['adme_site_id']);
	        	$copie_objet_pear_url->addQueryString('adme_menu_id',$_GET['adme_menu_id']);
	        	$copie_objet_pear_url->addQueryString('adme_action',ADME_LG_ACTION_COMMUN_TRADUIRE_ACTION);
	        	header("Location: ".str_replace('&amp;', '&', $copie_objet_pear_url->getUrl()));
	        	exit;
        	}
        	
        }
        
        if (isset($_GET['adme_action']) && $_GET['adme_action'] == ADME_LG_ACTION_COMMUN_TRADUIRE_ACTION) {
        	$sortie_xhtml .= ADME_afficherFormMenuCommun($objet_pear_db, $objet_pear_url, $_GET['adme_site_id'], $_GET['adme_menu_id'], $_POST,TRUE);
        	return $sortie_xhtml;
        }
        
        
        if (isset($_POST[ADME_LG_ACTION_COMMUN_VERIFIER_TRADUCTION])) {
            // Nous cherchons � enregistrer une traduction de menu
            $message = ADME_validerFormTraduireMenuCommun($objet_pear_db, $_POST);
            if (!empty($message)) {
                // Les donn�es ne sont pas valide. Nous retournons le formulaires avec les messages d'erreurs.
                $sortie_xhtml .= $message;
                $sortie_xhtml .= ADME_afficherFormMenuCommun($objet_pear_db, $objet_pear_url, $_GET['adme_menu_id'], $_POST);
                return $sortie_xhtml;
            } else {
                // Les donn�es sont valide. Nous les enregistrons et retournons au formulaire de d�part.
                $message = ADME_traduireMenuCommun($objet_pear_db, $objet_pear_auth, $_GET['adme_menu_id'], $_POST);
            }
        }
        
        
        
        // Supprime d�finitivement un menu commun
        if (isset($_GET['adme_action']) && $_GET['adme_action'] == ADME_LG_ACTION_COMMUN_SUPPRIMER) {
            // R�cup�ration du menu de remplacement pour �viter de fermer l'arborescence
            if (GEN_donnerDernierFreres($_GET['adme_menu_id']) == false) {
                $adme_menu_id_remplacement = GEN_lireIdentifiantMenuPere($_GET['adme_menu_id']);;
            } else {
                $adme_menu_id_remplacement = GEN_donnerDernierFreres($_GET['adme_menu_id']);
            }
            // Suppression du menu commun
            ADME_supprimerMenuCommun($objet_pear_db, $_GET['adme_menu_id']);
            // Remplacement de l'id du menu courant par le rempla�ant.
            $_GET['adme_menu_id'] = $adme_menu_id_remplacement;
            $copie_objet_pear_url->addQueryString('adme_site_id',$_GET['adme_site_id']);
            header("Location: ".str_replace('&amp;', '&', $copie_objet_pear_url->getUrl()));
            exit;
            
        }
        
        // Supprimer le menu traduit
        if (isset($_GET['adme_action']) && $_GET['adme_action'] == ADME_LG_ACTION_COMMUN_SUPPRIMER_TRADUCTION) {
            // Suppression du menu commun
            $message = ADME_supprimerMenuCommunTraduction($objet_pear_db, $_GET['adme_site_id'], $_GET['adme_menu_id']);
            $copie_objet_pear_url->addQueryString('adme_site_id',$_GET['adme_site_id']);
            header("Location: ".str_replace('&amp;', '&', $copie_objet_pear_url->getUrl()));
            exit;
        }
        
        if (isset($_GET['adme_action']) && $_GET['adme_action'] == ADME_LG_ACTION_COMMUN_TRADUCTION_DEFAUT) {
            $message = ADME_selectionnerMenuCommunTraduction($objet_pear_db, $_GET['adme_site_id'], $_GET['adme_menu_id']);
            $copie_objet_pear_url->addQueryString('adme_site_id',$_GET['adme_site_id']);
            header("Location: ".str_replace('&amp;', '&', $copie_objet_pear_url->getUrl()));
            exit;
        }
        
        
        
        
        //---------------------------------------------------------------------------------------------------------------
        // GESTION DES INTERFACES D'ADMINISTRATION
        
        // Appel de l'application d'administration
        if (isset($_GET['adme_action']) && $_GET['adme_action'] == ADME_LG_ACTION_ADMINISTRER) {
            $id_appli = GEN_retournerIdAppliMenu($objet_pear_db, $_GET['adme_menu_id']);
            $chemin_admin = GEN_retournerCheminInterfaceAdmin($objet_pear_db, $id_appli);
            $nom_admin = GEN_retournerNomInterfaceAdmin($objet_pear_db, $id_appli);
            if ($chemin_admin !== false) {
                include_once $chemin_admin;
                $objet_admin = new $nom_admin;
                if (method_exists($objet_admin, 'afficherContenuCorps')) {
                    $retour_admin = $objet_admin->afficherContenuCorps();
                }
                if ($retour_admin !== false) {
                    return $retour_admin;
                }
            }
        }
        
        //---------------------------------------------------------------------------------------------------------------
        // Affichage des messages si n�cessaire
        if (! empty($message)) {
            $sortie_xhtml .= "\n".'<p class="pap_erreur">'.$message.'</p>';
        }
        
        //---------------------------------------------------------------------------------------------------------------
        // Affichage formulaire principal et retour du XHTML!
        $sortie_xhtml .= ADME_afficherFormPrincipal($objet_pear_db, $objet_pear_url, $_GET['adme_site_id'], $_GET['adme_menu_id'], $_GET['adme_action']);
        return $sortie_xhtml;
        // Fin de l'authentification
    } else {
        // Pas d'authentification nous affichons un message!
        $res='';
    	$res .= '<p class="zone_alert">'.ADME_IDENTIFIEZ_VOUS.'</p>'."\n" ;
		$res .= '<form id="form_connexion" style="clear:both;" class="form_identification" action="' ;		
		$res .= $objet_pear_url->getURL();
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
}// Fin de la fonction afficherContenuCorps()

// +------------------------------------------------------------------------------------------------------+
// |                                            PIED du PROGRAMME                                         |
// +------------------------------------------------------------------------------------------------------+



/* +--Fin du code ----------------------------------------------------------------------------------------+
*
* $Log: admin_menu.php,v $
* Revision 1.29  2007-10-25 10:10:23  alexandre_tb
* supression des erreurs d encodage dans les commentaires, il en reste !
*
* Revision 1.28  2007-10-24 14:43:01  ddelon
* Gestion des menus reservés à une langue
*
* Revision 1.27  2007-07-04 14:59:13  florian
* correction bug maj non prise en charge
*
* Revision 1.26  2007/04/19 15:34:35  neiluj
* préparration release (livraison) "Narmer" - v0.25
*
* Revision 1.25  2006/10/06 10:40:51  florian
* harmonisation des messages d'erreur de l'authentification
*
* Revision 1.24  2006/06/29 19:13:26  ddelon
* Bug defaut traduction sur menu commun
*
* Revision 1.23  2006/06/29 18:58:57  ddelon
* Multilinguisme : menu par defaut pour les menu commun
*
* Revision 1.22  2006/06/28 12:53:34  ddelon
* Multilinguisme : menu par defaut
*
* Revision 1.21  2006/04/12 21:11:54  ddelon
* Multilinguisme menus communs
*
* Revision 1.20  2006/03/23 20:24:58  ddelon
* *** empty log message ***
*
* Revision 1.19  2006/03/02 10:49:49  ddelon
* Fusion branche multilinguisme dans branche principale
*
* Revision 1.18.2.2  2006/02/28 14:02:08  ddelon
* Finition multilinguisme
*
* Revision 1.18.2.1  2005/12/27 15:56:00  ddelon
* Fusion Head vers multilinguisme (wikini double clic)
*
* Revision 1.18  2005/09/23 15:27:17  florian
* correction de bugs
*
* Revision 1.17  2005/07/18 16:14:32  ddelon
* css admin + menu communs
*
* Revision 1.16  2005/07/08 21:13:15  ddelon
* Gestion indentation menu
*
* Revision 1.15  2005/02/28 11:04:25  jpm
* Modification des auteurs.
*
* Revision 1.14  2005/02/28 10:31:41  jpm
* Changement de nom de dossier.
*
* Revision 1.13  2004/11/16 13:01:41  jpm
* Ajout d'un commentaire.
*
* Revision 1.12  2004/11/15 16:51:08  jpm
* Correction bogue de mise � jour de l'ordre des menus.
*
* Revision 1.11  2004/11/10 17:26:18  jpm
* Fin gestion de la traduction.
*
* Revision 1.10  2004/11/10 11:58:58  jpm
* Mise en place des constantes de traduction de l'appli.
*
* Revision 1.9  2004/11/09 17:53:03  jpm
* Changement des noms des actions sur les menus classiques.
*
* Revision 1.8  2004/11/09 17:49:11  jpm
* Mise en conformit� et gestion de diff�rentes interfaces d'administration.
*
* Revision 1.7  2004/10/25 16:28:02  jpm
* Correction convention de codage.
*
* Revision 1.6  2004/09/23 17:45:19  jpm
* Am�lioration de la gestion des liens annuler et du selecteur de sites.
*
* Revision 1.5  2004/09/23 16:49:24  jpm
* Correction d'une erreur dans l'url de l'ajout de menu commun.
*
* Revision 1.4  2004/07/06 17:24:54  jpm
* Suppression d'inclusions de fichiers inutiles.
*
* Revision 1.3  2004/07/06 17:07:28  jpm
* Modification de la documentation pour une mailleur analyse par PhpDocumentor.
*
* Revision 1.2  2004/06/16 15:06:30  jpm
* Suppression fichier inutile.
*
* Revision 1.1  2004/06/16 15:04:39  jpm
* Changement de nom de G�n�sia en Papyrus.
* Changement de l'arborescence.
*
* Revision 1.26  2004/05/10 14:32:21  jpm
* Changement du titre.
*
* Revision 1.25  2004/05/10 12:13:23  jpm
* Ajout de la s�lection des sites.
*
* Revision 1.24  2004/05/07 16:33:05  jpm
* Int�gration de constantes.
*
* Revision 1.23  2004/05/07 07:23:53  jpm
* Am�lioration du code, des commentaires et correction de bogues.
*
* Revision 1.22  2004/05/05 06:45:44  jpm
* Suppression de l'appel de la fonction g�n�rant le "vous �tes ici" dans la fonction affichant l'ent�te de l'application.
*
* Revision 1.21  2004/05/04 16:27:33  jpm
* R�duction de code pour la fonction afficherContenuTete().
*
* Revision 1.20  2004/05/03 11:23:26  jpm
* D�but mise en conformit� des commentaires.
*
*
* +-- Fin du code ----------------------------------------------------------------------------------------+
*/
?>
