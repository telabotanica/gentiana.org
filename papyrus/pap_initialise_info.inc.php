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
// CVS : $Id: pap_initialise_info.inc.php,v 1.32 2007-10-23 13:45:33 ddelon Exp $
/**
*Initialisation de Papyrus : v�rification et r�cup�ration de param�tres g�n�raux.
*
* La page contient le code initialisant l'�xecution du rendu d'une page par Papyrus.
* Nous y trouvons la recherche des informations disponibles sur :
* - le site pr�sent sur le serveur demand�,
* - l'identification,
* - la langue,
* - le menu,
* - la page
* - l'application
*
*@package Papyrus
//Auteur original :
*@author            Jean-Pascal MILCENT <jpm@tela-botanica.org>
//Autres auteurs :
*@author            Alexandre GRANIER <alex@tela-botanica.org>
*@author            Laurent COUDOUNEAU <laurent.coudouneau@ema.fr>
*@copyright         Tela-Botanica 2000-2004
*@version           $Revision: 1.32 $ $Date: 2007-10-23 13:45:33 $
// +------------------------------------------------------------------------------------------------------+
*/

// +------------------------------------------------------------------------------------------------------+
// |                                            ENT�TE du PROGRAMME                                       |
// +------------------------------------------------------------------------------------------------------+
/** Inclusion de l'objet PEAR servant � n�gocier le language avec le navigateur client. */
require_once PAP_CHEMIN_API_PEAR.'HTTP.php';
/** Inclusion de la classe PEAR g�rant les URL : Utilis� pour l'url demand�e par le client.*/
require_once PAP_CHEMIN_API_PEAR.'Net/URL.php';
/** Inclusion de la biblioth�que de fonctions servant � l'initialisation des variables globales de Papyrus. */
require_once GEN_CHEMIN_BIBLIO.'pap_initialisation.fonct.php';
/** Inclusion de la classe Papyrus g�rant les URL : Utilis� pour l'url demand�e par le client.*/
require_once GEN_CHEMIN_BIBLIO_CLASSE.'pap_url.class.php';
/** Inclusion de la biblioth�que de fonctions servant au menu pour la r�ecriture d'url. */
require_once GEN_CHEMIN_BIBLIO.'pap_menu.fonct.php';

// +------------------------------------------------------------------------------------------------------+
// |                                            CORPS du PROGRAMME                                        |
// +------------------------------------------------------------------------------------------------------+
// +------------------------------------------------------------------------------------------------------+
// Gestion de la r�ecriture d'url et des url erreur 404
if ((defined('PAP_URL_REECRITURE') AND PAP_URL_REECRITURE == '1' && (! isset($_GET[GEN_URL_CLE_SITE]) || empty($_GET[GEN_URL_CLE_SITE])) && (! isset($_GET[GEN_URL_CLE_MENU]) || empty($_GET[GEN_URL_CLE_MENU]))) ) {
	$tab_type_reecriture = array('MENU', 'SITE');
	foreach ($tab_type_reecriture as $reecriture) {
		if (PAP_URL_REECRITURE_SEP == '/') {
			$masque_reecriture = '/^(\/.*?)'.constant('PAP_URL_REECRITURE_'.$reecriture).'\\'.PAP_URL_REECRITURE_SEP.'([^?]+?)(?:\?(.*)|)$/';
		} else {
			$masque_reecriture = '/^(\/.*?)'.constant('PAP_URL_REECRITURE_'.$reecriture).PAP_URL_REECRITURE_SEP.'([^?]+?)(?:\?(.*)|)$/';
		}
		if (preg_match($masque_reecriture, rawurldecode($_SERVER['REQUEST_URI']), $tab_raccourci)) {		
			$chemin_vers_papyrus = $tab_raccourci[1];
			$raccourci = $tab_raccourci[2];
			$parametres = '';
			if (isset($tab_raccourci[3])) {
				$parametres = $tab_raccourci[3];
			}
			if ($reecriture == 'SITE') {
				/** Inclusion de la biblioth�que de fonctions servant au site pour la r�ecriture d'url. */
				require_once GEN_CHEMIN_BIBLIO.'pap_site.fonct.php';
			}
			// Nous cherchons � savoir si le raccourci est enti�rement num�rique ou pas.
			if (preg_match('/^[0-9]+$/', $raccourci)) {
				// Nous v�rifions si nous utilisons les codes num�riques ou alphanum�rique dans les url
				if (constant('GEN_URL_ID_TYPE_'.$reecriture) != 'int') {
					$_GET[constant('GEN_URL_CLE_'.$reecriture)] = call_user_func('GEN_retourner'.$reecriture.'CodeAlpha', $db, $raccourci);
				} else {
					$_GET[constant('GEN_URL_CLE_'.$reecriture)] = $raccourci;
				}
			} else {
				// Nous v�rifions si nous utilisons les codes num�riques ou alphanum�rique dans les url
				if (constant('GEN_URL_ID_TYPE_'.$reecriture) != 'int') {
					$_GET[constant('GEN_URL_CLE_'.$reecriture)] = $raccourci;
				} else {
					$_GET[constant('GEN_URL_CLE_'.$reecriture)] = call_user_func('GEN_retourner'.$reecriture.'CodeNum', $db, $raccourci);
				}
			}
		}
	}
}

// +------------------------------------------------------------------------------------------------------+
// Gestion des sites : disponibles sur le serveur courant.
// Liste des cat�gories de site � prendre en compte :
// Pas de site, ni de menu dans l'URL, recherche du site par d�faut
$site_liste_id = '102, 103';// 102 = site "principal" et 103 = site "externe"
if ( (! isset($_GET[GEN_URL_CLE_SITE]) || empty($_GET[GEN_URL_CLE_SITE])) && (! isset($_GET[GEN_URL_CLE_MENU]) || empty($_GET[GEN_URL_CLE_MENU])) ) {
    $requete =  'SELECT gen_site.*, GSR02.* '.
                'FROM gen_site, gen_site_relation AS GSR01, gen_site_relation AS GSR02 '.
                'WHERE GSR01.gsr_id_site_01 = GSR01.gsr_id_site_02 '.
                'AND GSR01.gsr_id_valeur = 101 '.// 101 = site d�faut
                'AND GSR01.gsr_id_site_01 = gs_id_site '.
                'AND GSR02.gsr_id_site_01 = GSR02.gsr_id_site_02 '.
                'AND GSR02.gsr_id_valeur IN ('.$site_liste_id.') '.
                'AND GSR02.gsr_id_site_01 = gs_id_site';
    
    $resultat = $db->query($requete);
    if (DB::isError($resultat)) {
        die( BOG_afficherErreurSql(__FILE__, __LINE__, $resultat->getMessage(), $requete) );
    }
    
    // Aucun site trouv�
    if ($resultat->numRows() == 0) {
        // Appel � l'application Installateur si n�cessaire
        /** <br> Inclusion du programme Installateur de Papyrus.
        * L'abscence de site oblige � relancer l'installation et le script sql qui reg�n�rera la base de donn�es.*/
        include_once GEN_CHEMIN_APPLICATION.'installateur/installateur.php';
        $_GEN_commun['sortie'] = afficherContenuCorps();
        include_once GEN_CHEMIN_PAP.'pap_envoi.inc.php';
        // Fin du programme Papyrus.
        exit(0);
    }
    // Nous avons trouv� un site.
    $_GEN_commun['info_site'] = $resultat->fetchRow(DB_FETCHMODE_OBJECT);
    $resultat->free();
    if (GEN_URL_ID_TYPE_SITE == 'int') {
        $_GEN_commun['url_site'] = $_GEN_commun['info_site']->gs_code_num;
    } else {
        $_GEN_commun['url_site'] = $_GEN_commun['info_site']->gs_code_alpha;
    }
 // Le code du menu est pr�sent dans l'url mais pas celui du site
} else if ( (! isset($_GET[GEN_URL_CLE_SITE]) || empty($_GET[GEN_URL_CLE_SITE])) && (isset($_GET[GEN_URL_CLE_MENU]) || !empty($_GET[GEN_URL_CLE_MENU])) ) {
    // Nous r�cup�rons les infos du menu et du sites dans la variable globale de Papyrus.
    $_GEN_commun['url_menu'] = $_GET[GEN_URL_CLE_MENU];
    // R�cup�ration des informations sur le menu demand�
    $requete =  'SELECT * '.
                'FROM gen_menu '.
                'WHERE ';
    $requete .= (GEN_URL_ID_TYPE_MENU == 'int')
        ? 'gm_code_num = '.$_GEN_commun['url_menu']
        : 'gm_code_alpha = "'.$_GEN_commun['url_menu'].'"';

    $resultat = $db->query($requete);
    (DB::isError($resultat))
        ? die(BOG_afficherErreurSql(__FILE__, __LINE__, $resultat->getMessage(), $requete))
       : '';
    
    $_GEN_commun['info_menu'] = $resultat->fetchRow(DB_FETCHMODE_OBJECT);
    $resultat->free();
    if ($_GEN_commun['info_menu']->gm_ce_site != 0) {
        // R�cup�ration des infos du site
        $requete =  'SELECT * '.
                    'FROM gen_site, gen_site_relation '.
                    'WHERE gsr_id_site_01 = gsr_id_site_02 '.
                    'AND gsr_id_valeur IN ('.$site_liste_id.') '.
                    'AND gsr_id_site_01 = gs_id_site '.
                    'AND gs_id_site = '. $_GEN_commun['info_menu']->gm_ce_site;
        
        $resultat = $db->query($requete);
        (DB::isError($resultat)) ? die(BOG_afficherErreurSql(__FILE__, __LINE__, $resultat->getMessage(), $requete)) : '';
        
        $_GEN_commun['info_site'] = $resultat->fetchRow(DB_FETCHMODE_OBJECT);
        $_GEN_commun['url_site'] = (GEN_URL_ID_TYPE_SITE == 'int')
            ? $_GEN_commun['info_site']->gs_code_num
            : $_GEN_commun['info_site']->gs_code_alpha;
        $resultat->free();
    } else {
        // R�cup�ration des infos du site
        $requete =  'SELECT * '.
                    'FROM gen_site, gen_site_relation '.
                    'WHERE gsr_id_site_01 = gsr_id_site_02 '.
                    'AND gsr_id_valeur = 101 '.
                    'AND gsr_id_site_01 = gs_id_site ';
        
        $resultat = $db->query($requete);
        (DB::isError($resultat)) ? die(BOG_afficherErreurSql(__FILE__, __LINE__, $resultat->getMessage(), $requete)) : '';
        
        $_GEN_commun['info_site'] = $resultat->fetchRow(DB_FETCHMODE_OBJECT);
        $_GEN_commun['url_site'] = (GEN_URL_ID_TYPE_SITE == 'int')
            ? $_GEN_commun['info_site']->gs_code_num
            : $_GEN_commun['info_site']->gs_code_alpha;
        $resultat->free();
    }
} else {
    // R�cup�ration de la valeur identifiant le site depuis l'url
    $_GEN_commun['url_site'] = $_GET[GEN_URL_CLE_SITE];
    
    // R�cup�ration des informations sur le site
    $requete =  'SELECT * '.
                'FROM gen_site, gen_site_relation '.
                'WHERE gsr_id_site_01 = gsr_id_site_02 '.
                'AND gsr_id_valeur IN ('.$site_liste_id.') '.
                'AND gsr_id_site_01 = gs_id_site '.
                'AND ';
    $requete .= (GEN_URL_ID_TYPE_SITE == 'int')
        ? 'gs_code_num = '.$_GEN_commun['url_site']
        : 'gs_code_alpha = "'.$_GEN_commun['url_site'].'"';
    
    $resultat = $db->query($requete);
    (DB::isError($resultat)) ? die(BOG_afficherErreurSql(__FILE__, __LINE__, $resultat->getMessage(), $requete)) : '';
    $_GEN_commun['info_site'] = $resultat->fetchRow(DB_FETCHMODE_OBJECT);
    $resultat->free();
}

//Gestion de l'erreur aucun site trouvable.
if (! isset($_GEN_commun['info_site'])) {
    // Appel � l'application Installateur si n�cessaire
    /** <br> Inclusion du programme Installateur de Papyrus.
    * L'abscence de site oblige � relancer l'installation et le script sql qui reg�n�rera la base de donn�es.*/
    include_once GEN_CHEMIN_APPLICATION.'installateur/installateur.php';
    $_GEN_commun['sortie'] .= afficherContenuCorps();
    include_once GEN_CHEMIN_PAP.'pap_envoi.inc.php';
    // Fin du programme Papyrus.
    exit(0);
} else if ($_GEN_commun['info_site']->gsr_id_valeur == 103) {
    // Gestion de la redirection pour les sites "externes"
    header('Location:'.$_GEN_commun['info_site']->gs_url);
    exit(0);
}

// Recherche de la pr�sence de la valeur d'i18n dans l'url
if ( (isset($_GET[GEN_URL_CLE_I18N])) && (!empty($_GET[GEN_URL_CLE_I18N])) ) {
    $_GEN_commun['i18n'] = $_GET[GEN_URL_CLE_I18N];
} else {
  $_GEN_commun['i18n'] = GEN_I18N_ID_DEFAUT;
}

// Nous r�cup�rons des informations sur l'internationalisation
$requete =  'SELECT * '.
            'FROM gen_i18n '.
            'WHERE gi_id_i18n = "'.$_GEN_commun['i18n'].'"';

$resultat = $db->query($requete);
(DB::isError($resultat)) ? die(BOG_afficherErreurSql(__FILE__, __LINE__, $resultat->getMessage(), $requete)) : '';

$_GEN_commun['info_i18n'] = $resultat->fetchRow(DB_FETCHMODE_OBJECT);
$resultat->free();


// R�cup�ration des informations sur la langue
$requete =  'SELECT * '.
            'FROM gen_i18n_langue '.
            'WHERE gil_id_langue = "'.$_GEN_commun['info_i18n']->gi_ce_langue.'"';
$resultat = $db->query($requete);
(DB::isError($resultat)) ? die(BOG_afficherErreurSql(__FILE__, __LINE__, $resultat->getMessage(), $requete)) : '';

$_GEN_commun['info_i18n_langue'] = $resultat->fetchRow(DB_FETCHMODE_OBJECT);
$resultat->free();

// R�cup�ration des informations sur le pays
$requete =  'SELECT * '.
            'FROM gen_i18n_pays '.
            'WHERE gip_id_pays = "'.$_GEN_commun['info_i18n']->gi_ce_pays.'"';
$resultat = $db->query($requete);
(DB::isError($resultat)) ? die(BOG_afficherErreurSql(__FILE__, __LINE__, $resultat->getMessage(), $requete)) : '';

$_GEN_commun['info_i18n_pays'] = $resultat->fetchRow(DB_FETCHMODE_OBJECT);
$resultat->free();

// +------------------------------------------------------------------------------------------------------+
// Gestion des menus

// Nous v�rifions le cas o� le code du menu est introuvable dans l'url.
if ( (! isset($_GET[GEN_URL_CLE_MENU])) || (empty($_GET[GEN_URL_CLE_MENU])) ) {
    // Recherche du premier menu du site courant:
    $requete =  'SELECT gen_menu.* '.
                'FROM gen_menu, gen_menu_relation '.
                'WHERE gm_ce_site = '.$_GEN_commun['info_site']->gs_id_site.' '.
                'AND gmr_id_menu_01 = gm_id_menu '.
                'AND gmr_id_menu_01 = gmr_id_menu_02 '.
                'AND gmr_id_valeur = 101 ';// 101 = menu par "defaut"

    $resultat = $db->query($requete);
    (DB::isError($resultat))
        ? die(BOG_afficherErreurSql(__FILE__, __LINE__, $resultat->getMessage(), $requete))
        : '';
    // Nous avons trouv� un menu "d�faut" pour le site courant.
    $_GEN_commun['info_menu'] = $resultat->fetchRow(DB_FETCHMODE_OBJECT);
    $resultat->free();

    if (isset($_GEN_commun['url_menu'])) {
	    // Stockage du code du menu demand�e dans la variable globale de Papyrus.
	    if (GEN_URL_ID_TYPE_MENU == 'int') {
	        $_GEN_commun['url_menu'] = $_GEN_commun['info_menu']->gm_code_num;
	    } else {
	        $_GEN_commun['url_menu'] = $_GEN_commun['info_menu']->gm_code_alpha;
	    }
    }
}

else
if (! isset($_GET['url_menu']) && empty($_GEN_commun['url_menu'])) {
    // Le code du menu est pr�sent dans l'url et il n'a pas encore �t� r�cup�r�
    // Nous le r�cup�rons dans la variable globale de Papyrus.
    $_GEN_commun['url_menu'] = $_GET[GEN_URL_CLE_MENU];

    // R�cup�ration des informations sur le menu demand�
    $requete = 'SELECT * '.
                'FROM gen_menu '.
                'WHERE ';
    $requete .= (GEN_URL_ID_TYPE_MENU == 'int')
        ? 'gm_code_num = '.$_GEN_commun['url_menu']
        : 'gm_code_alpha = "'.$_GEN_commun['url_menu'].'"';

    $resultat = $db->query($requete);
    (DB::isError($resultat))
        ? die(BOG_afficherErreurSql(__FILE__, __LINE__, $resultat->getMessage(), $requete))
        : '';

    $_GEN_commun['info_menu'] = $resultat->fetchRow(DB_FETCHMODE_OBJECT);
    $resultat->free();
}

// +------------------------------------------------------------------------------------------------------+
// Gestion des traductions

// Si le r�sultat de la n�gociation de l'internationalisation donne une langue diff�rente
//  de celle du site principal, nous r�cup�rons les �ventuelles valeurs traduite pour le site.

$id_langue = $GLOBALS['_GEN_commun']['i18n'];

if (isset($id_langue) && ($id_langue!='')) {
       $langue_test=$id_langue;
} else {
       $langue_test=GEN_I18N_ID_DEFAUT;
}

if ($langue_test!=GEN_I18N_ID_DEFAUT) {
    // R�cup�ration des informations sur la traduction du site
    $requete =  'SELECT * '.
                'FROM gen_site '.
                'WHERE gs_ce_i18n = "'.$langue_test.'" '.
                'AND gs_code_num = "'.$_GEN_commun['info_site']->gs_code_num.'"';
                
//                'WHERE gs_ce_i18n = "'.$_GEN_commun['i18n'].'" '.
//                'AND gs_code_alpha = "'.$_GEN_commun['info_site']->gs_code_alpha.'"';

    $resultat = $db->query($requete);
    (DB::isError($resultat)) ? die(BOG_afficherErreurSql(__FILE__, __LINE__, $resultat->getMessage(), $requete)) : '';

    // Nous cr��ons l'entr�e 'traduction_info_site' dans _GEN_commun que si nous avons bien trouv� une
    // traduction pour le site. Il faut donc tester l'existence de cette entr�e avant de l'utiliser.
    if ($resultat->numRows() > 0) {
        $_GEN_commun['traduction_info_site'] = $resultat->fetchRow(DB_FETCHMODE_OBJECT);
    }
    $resultat->free();
}

// Si le r�sultat de la n�gociation de l'internationalisation donne une langue diff�rente
//  de celle du menu, nous r�cup�rons les �ventuelles valeurs traduite pour le menu.

//print_r($_GEN_commun);

if (isset($_GEN_commun['info_menu']))  { // Evite les warning si pas encore de menu cree pour ce site 

    if ($langue_test!=GEN_I18N_ID_DEFAUT) {
        // R�cup�ration des informations sur la traduction du menu
        $requete =  'SELECT * '.
                    'FROM gen_menu '.
                    'WHERE gm_ce_i18n = "'.$langue_test.'" '.
                    'AND gm_code_num = "'.$_GEN_commun['info_menu']->gm_code_num.'"';
    //                'WHERE gm_ce_i18n = "'.$_GEN_commun['i18n'].'" '.
    //                'AND gm_code_alpha = "'.$_GEN_commun['info_menu']->gm_code_alpha.'"';
    
        $resultat = $db->query($requete);
        (DB::isError($resultat)) ? die(BOG_afficherErreurSql(__FILE__, __LINE__, $resultat->getMessage(), $requete)) : '';
    
        // Nous cr��ons l'entr�e 'traduction_info_menu' dans _GEN_commun que si nous avons bien trouv� une
        // traduction pour le menu. Il faut donc tester l'existence de cette entr�e avant de l'utiliser.
        if ($resultat->numRows() > 0) {
            $_GEN_commun['traduction_info_menu'] = $resultat->fetchRow(DB_FETCHMODE_OBJECT);
        }
        $resultat->free();
    }
    
}
    
// +------------------------------------------------------------------------------------------------------+
// Gestion de l'application du menu demand�.

// Recherche de la premi�re application li�e
if (isset($_GEN_commun['info_menu']->gm_id_menu)) {
    $info_appli_menu = GEN_donnerIdPremiereApplicationLiee($_GEN_commun['info_menu']->gm_id_menu);
    if (is_array($info_appli_menu)) {
        $id_application = $info_appli_menu['gm_ce_application'];
        $id_menu_actif = $info_appli_menu['gm_id_menu'];

        // Si le menu n'a pas d'application li�, on recalcule l'objet $_GEN_commun['info_menu']
        if ($id_menu_actif != $_GEN_commun['info_menu']->gm_id_menu) {
            $requete =  'SELECT gen_menu.* '.
                        'FROM gen_menu '.
                        'WHERE gm_id_menu = '.$id_menu_actif;

            $resultat = $db->query($requete);
            (DB::isError($resultat))
                ? die(BOG_afficherErreurSql(__FILE__, __LINE__, $resultat->getMessage(), $requete))
                : '';
            // Nous avons trouv� un menu "d�faut" pour le site courant.
            $_GEN_commun['info_menu'] = $resultat->fetchRow(DB_FETCHMODE_OBJECT);
            $resultat->free();
        }


        // Recherche des informations sur l'application li�e
        $requete_applicaton =   'SELECT * '.
                                'FROM gen_application '.
                                'WHERE gap_id_application = '.$id_application;

        $resultat_applicaton = $db->query($requete_applicaton);
        (DB::isError($resultat_applicaton))
            ? die(BOG_afficherErreurSql(__FILE__, __LINE__, $resultat_applicaton->getMessage(), $requete_applicaton))
            : '';

        $_GEN_commun['info_application'] = $resultat_applicaton->fetchRow(DB_FETCHMODE_OBJECT) ;
        $resultat_applicaton->free();
    } else {
        // Gestion des erreurs sur la recherche de l'application li�e.
        // Finalement il a �t� d�cid� de ne pas afficher cette information sous la forme d'erreur.
        //trigger_error('application du menu demand�e introuvable', E_USER_NOTICE);
    }
}

// +------------------------------------------------------------------------------------------------------+
// Gestion des arguments de l'application

if (isset($_GEN_commun['info_menu']->gm_application_arguments)) {
    $arguments = explode(' ', $_GEN_commun['info_menu']->gm_application_arguments);

    // Initialisaton de la variable globale $GS_ARGUMENTS
    $_GEN_commun['info_application']->cache = false;
    $_GEN_commun['info_application']->cache_duree = 0;

    for ($i = 0; $i < count($arguments); $i++) {
        $attr = explode('=', $arguments[$i]);

        if ($attr[0] == 'cache_duree') {
            $_GEN_commun['info_application']->cache_duree = $attr[1];
            if ($_GEN_commun['info_application']->cache_duree > 0) {
                $_GEN_commun['info_application']->cache = true;
            }
        } else if ($attr[0] != '') {
            $_GEN_commun['info_application']->$attr[0] = (isset($attr[1]) ? $attr[1] : '');
        }
    }
}

// +------------------------------------------------------------------------------------------------------+
// Gestion des applettes

$requete =  'SELECT * '.
            'FROM gen_application '.
            'WHERE gap_bool_applette = 1 ';
$resultat = $_GEN_commun['pear_db']->query($requete);
(DB::isError($resultat)) ? die(BOG_afficherErreurSql(__FILE__, __LINE__, $resultat->getMessage(), $requete)) : '';

$_GEN_commun['info_applette'] = array();
$i = 0;
while ($ligne = $resultat->fetchRow(DB_FETCHMODE_OBJECT)) {
    $_GEN_commun['info_applette'][$i] = $ligne;
    $i++;
}
$resultat->free();

// +------------------------------------------------------------------------------------------------------+
// Gestion de l'objet URL

$_GEN_commun['url'] = new Pap_URL(PAP_URL);
if (isset($_GEN_commun['info_menu'])) {
	$_GEN_commun['url']->setId($_GEN_commun['info_menu']->gm_id_menu);
}

if ( (isset($_GEN_commun['url_site'])) && (!empty($_GEN_commun['url_site'])) ) {
    $_GEN_commun['url']->addQueryString(GEN_URL_CLE_SITE, $_GEN_commun['url_site']);
}

if ( (isset($_GEN_commun['url_menu'])) && (!empty($_GEN_commun['url_menu'])) ) {
    $_GEN_commun['url']->addQueryString(GEN_URL_CLE_MENU, $_GEN_commun['url_menu']);
}

if ( (isset($_GET[GEN_URL_CLE_DATE])) && (!empty($_GET[GEN_URL_CLE_DATE])) ) {
    $_GEN_commun['url_date'] = $_GET[GEN_URL_CLE_DATE];
    $_GEN_commun['url']->addQueryString(GEN_URL_CLE_DATE, $_GEN_commun['url_date']);
}

if ( (isset($_GET[GEN_URL_CLE_FORMAT])) && (!empty($_GET[GEN_URL_CLE_FORMAT])) ) {
    $_GEN_commun['url_format'] = $_GET[GEN_URL_CLE_FORMAT];
    $_GEN_commun['url']->addQueryString(GEN_URL_CLE_FORMAT, $_GEN_commun['url_format']);
}

/* +--Fin du code ---------------------------------------------------------------------------------------+
* $Log: pap_initialise_info.inc.php,v $
* Revision 1.32  2007-10-23 13:45:33  ddelon
* Suppression warning en cas de traduction d'un site sans menu
*
* Revision 1.31  2007-04-19 16:54:52  ddelon
* backport mulitlinguisme
*
* Revision 1.30  2007/04/19 15:34:35  neiluj
* préparration release (livraison) "Narmer" - v0.25
*
* Revision 1.29  2007/04/13 09:41:09  neiluj
* réparration cvs
*
* Revision 1.28  2006/12/01 15:41:21  ddelon
* erreur affichage
*
* Revision 1.27  2006/11/07 18:43:54  jp_milcent
* Modification des expressions r�guli�res des permaliens.
*
* Revision 1.26  2006/10/18 10:18:05  jp_milcent
* Gestion des erreurs HTTP par Papyrus.
*
* Revision 1.25  2006/10/11 18:04:11  jp_milcent
* Gestion avanc�e de la r�ecriture d'URL.
*
* Revision 1.24  2006/03/02 10:49:49  ddelon
* Fusion branche multilinguisme dans branche principale
*
* Revision 1.23.2.2  2005/12/20 14:40:24  ddelon
* Fusion Head vers Livraison
*
* Revision 1.23.2.1  2005/12/01 23:31:57  ddelon
* Merge Head vers multilinguisme
*
* Revision 1.23  2005/09/22 14:02:49  ddelon
* nettoyage annuaire et php5
*
* Revision 1.22  2005/09/20 17:01:22  ddelon
* php5 et bugs divers
*
* Revision 1.21  2005/08/31 17:34:52  ddelon
* Integrateur Wikini et administration des Wikini
*
* Revision 1.20  2005/06/24 10:48:35  jpm
* Modification des chemins des fichiers pour fonctionnement avec API Pear locale.
*
* Revision 1.19  2005/04/14 13:52:37  jpm
* Utilisation de la classe Pap_URL.
*
* Revision 1.18  2005/02/28 11:20:42  jpm
* Modification des auteurs.
*
* Revision 1.17  2005/02/23 15:35:04  jpm
* L'erreur "pas d'application" a �t� supprim� une message dans le corps du texte fourni d�j� cette information.
*
* Revision 1.16  2005/02/17 17:51:40  florian
* Correction bug monde sans menu ni appli
*
* Revision 1.15  2004/12/06 12:12:28  jpm
* D�but de gestion des auth multiples.
*
* Revision 1.14  2004/11/15 17:14:09  jpm
* Gestion des url avec seulement le code d'un menu.
*
* Revision 1.13  2004/11/03 17:14:38  jpm
* Gestion des sites externes.
*
* Revision 1.12  2004/10/26 18:42:21  jpm
* Gestion des sites externes.
*
* Revision 1.11  2004/10/25 16:28:47  jpm
* Ajout de nouvelles balises Papyrus, ajout v�rification mise � jour de Papyrus, meilleure gestion des sessions...
*
* Revision 1.10  2004/10/22 17:23:59  jpm
* D�but am�lioration de la gestion des erreurs et de l'installation.
*
* Revision 1.9  2004/10/15 18:29:19  jpm
* Modif pour g�rer l'appli installateur de Papyrus.
*
* Revision 1.8  2004/09/23 14:30:53  jpm
* Correction bogue sur les menus.
*
* Revision 1.7  2004/09/23 10:46:46  jpm
* Am�lioration de la gestion du menu actif quand un menu n'a pas d'application li�e.
*
* Revision 1.6  2004/09/10 16:38:34  jpm
* Ajout de l'initialisation d'une variable stockant les infos de d�bogage.
*
* Revision 1.5  2004/06/30 07:35:16  jpm
* Correction d'un bogue du � une mauvaise gestion de la r�solution des conflits entre fichier CVS.
*
* Revision 1.4  2004/06/30 07:25:37  jpm
* Ajout d'un commentaire.
*
* Revision 1.3  2004/06/18 15:52:45  alex
* Actualisation de la variable $_GEN_commun['info_menu'] lorsque un menu n'a pas d'application li�
*
* Revision 1.2  2004/06/17 07:03:01  jpm
* Correction d'un bogue concernant l'internationalisation par d�faut quand la langue du navigateur ne correspond pas � celle du site.
*
* Revision 1.1  2004/06/16 08:13:20  jpm
* Changement de nom de G�n�sia en Papyrus.
* Changement de l'arborescence.
*
* Revision 1.24  2004/05/05 14:33:37  jpm
* Gestion de l'indication de langue dans l'url.
* Utile que si on veut forcer la langue.
*
* Revision 1.23  2004/05/05 10:42:35  jpm
* Am�lioration de la gestion de l'internationalisation.
*
* Revision 1.22  2004/05/04 16:17:05  jpm
* L�g�re am�lioration du code (lib�ration de ressource).
*
* Revision 1.21  2004/05/03 11:21:58  jpm
* Fin de la gestion des applettes et suppression de l'info_menu_hierarchie de _GEN_commun.
*
* Revision 1.20  2004/04/30 16:17:27  jpm
* Ajout de la r�cup�ration d'une info sur la hi�rarchie.
* Surement � supprimer car inutile.
*
* Revision 1.19  2004/04/28 12:04:31  jpm
* Changement du mod�le de la base de donn�es.
*
* Revision 1.18  2004/04/22 08:28:12  jpm
* Transformation de $GS_GLOBAL en $_GEN_commun.
*
* Revision 1.17  2004/04/09 16:43:32  jpm
* Suppression d'un blanc.
*
* Revision 1.16  2004/04/09 16:20:11  jpm
* R�cup�ration de la cr�ation de l'objet URL.
* Gestion des tables i18n.
*
* Revision 1.15  2004/04/05 16:37:43  jpm
* Utilisation de la classe Pear HTTP pour la n�gociation du langage � utiliser pour le site.
*
* Revision 1.14  2004/04/02 16:29:30  jpm
* D�placement dans le fichier gen_initialisation_pear.inc.php de la cr�ation des objets Pear Net_URL et Auth.
*
* Revision 1.13  2004/04/01 11:27:13  jpm
* Ajout et modification de commentaires pour PhpDocumentor.
*
* Revision 1.12  2004/03/31 16:50:04  jpm
* Prise en compte du nouveau mod�le de G�n�sia r�vision 1.9.
*
* Revision 1.11  2004/03/27 11:04:14  jpm
* D�placement des fonctions de gestion d'erreur dans la bibliotheque de l'application Installateur.
* Modification des commentaires vis � vis du nouveau mod�le.
* Changement et simplification des noms des variables globales.
* Suppression de l'attribution d'une configuration par d�faut.
* Remplacement de variable par des constante provenant du fichier de configuration.
* Traduction en fran�ais de certaines variables et partie de code.
*
* Revision 1.10  2004/03/24 07:20:03  jpm
* Mise en forme requ�te sql.
*
* Revision 1.9  2004/03/23 17:06:56  jpm
* Ajout de commentaire dans l'ent�te.
* Mise en conformit� avec la convention de codage.
*
* Revision 1.8  2004/03/23 16:31:54  jpm
* Ajout du code provenant de gen_noyau.inc.php.
* Ajout, formatage et traduction des commentaires.
*
* Revision 1.7  2004/03/22 18:35:32  jpm
* Traduction et ajout de commentaires.
* Am�lioration de la conformit� avec la convention de codage.
* Changement requ�te sql pour le nouveau mod�le de G�n�sia.
*
* Revision 1.6  2004/03/22 11:14:30  jpm
* Ajout de commentaires et mise en forme.
* Correction des requ�tes sql pour mise en conformit� avec le nouveau mod�le de G�n�sia et la convention de codage.
*
* Revision 1.5  2003/12/16 16:57:59  alex
* mise à jour pour compatibilité avec genesia
*
* Revision 1.4  2003/11/24 16:05:02  jpm
* Ajout de commentaires et d�but de mise en conformit�
* avec la convention de codage.
*
*
* +--Fin du code ----------------------------------------------------------------------------------------+
*/
?>
