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
// CVS : $Id: vous_etes_ici.php,v 1.13.2.1 2008-08-08 15:10:06 jp_milcent Exp $
/**
* Applette : Vous Etes Ici
*
* Affiche les liens contenant la suite des menus visités pour arriver
* au menu courant visioné par l'utilisateur.
* Nécessite :
* - Constantes et variable de Papyrus.
* - Base de données de Papyrus
* - Pear Net_URL
* - Pear DB
* - API Débogage 1.0
*
*@package Applette
*@subpackage Vous_Etes_Ici
//Auteur original :
*@author        Jean-Pascal MILCENT <jpm@tela-botanica.org>
//Autres auteurs :
*@author        Aucun
*@copyright     Tela-Botanica 2000-2004
*@version       $Revision: 1.13.2.1 $ $Date: 2008-08-08 15:10:06 $
// +------------------------------------------------------------------------------------------------------+
*/

// +------------------------------------------------------------------------------------------------------+
// |                                            ENTÊTE du PROGRAMME                                       |
// +------------------------------------------------------------------------------------------------------+
// Inclusion de la bibliothèque defonction sur les menu : inutile car inclue par Papyrus
// require_once GEN_CHEMIN_BIBLIO.'pap_menu.fonct.php';

$GLOBALS['_VEI_']['nom_fonction'] = 'afficherVousEtesIci';
$GLOBALS['_GEN_commun']['info_applette_nom_fonction'] = $GLOBALS['_VEI_']['nom_fonction'];
$GLOBALS['_GEN_commun']['info_applette_balise'] = 	'(?:<!-- '.$GLOBALS['_GEN_commun']['balise_prefixe'].'(VOUS_ETES_ICI) -->|'.
													'\{\{[Vv]ousEtesIci\s*\}\})';

// +------------------------------------------------------------------------------------------------------+
// |                                            CORPS du PROGRAMME                                        |
// +------------------------------------------------------------------------------------------------------+



// +------------------------------------------------------------------------------------------------------+
// |                                           LISTE de FONCTIONS                                         |
// +------------------------------------------------------------------------------------------------------+

/** Fonction afficherVousEtesIci() - Déploie le "vous êtes ici" d'un menu.
*
* Affiche la suite des menus visité, sous forme de lien, pour arriver
* au menu courant visioné par l'utilisateur.
* Necessite :
* - Constantes et variable de Papyrus.
* - Pear Net_URL
* - Pear DB
*
* @param  array  tableau d'éventuel arguments présent dans la balise transmis à la fonction. 
* @param  array  tableau global de Papyrus.
* @param int identifiant du menu courant qui représentent la fin du "vous êtes ici".
* @param boolean indique que nous avons à faire au premier appel de cette fonction récursive.
* @return  string  une liste de listes XHTML représentant le plan du site.
*/
function afficherVousEtesIci($tab_arguments, $_GEN_commun, $menu_courant_id = '', $premier_appel = true)
{
    // Initialisation de variable.
    $objet_pear_db =& $_GEN_commun['pear_db'];
    $vei_numero = $GLOBALS['_PAPYRUS_']['applette']['comptage'][$GLOBALS['_VEI_']['nom_fonction']];
    if (isset($_GEN_commun['info_menu']->gm_id_menu)) {
    	(empty($menu_courant_id)) ? $menu_courant_id = $_GEN_commun['info_menu']->gm_id_menu : '';
    }
    $vei = '';
    
    // Gestion des erreurs
    if (empty($menu_courant_id)) {
        if (isset($GLOBALS['_VEI_']['usurpation'])) {
            $vei = $GLOBALS['_VEI_']['usurpation'];
        }
        return $vei;
    }
    
    // Début contruction du vei
    $menu_pere_id = GEN_lireIdentifiantMenuPere($menu_courant_id, $objet_pear_db);
    // Récupération des infos sur sur l'entrée du menu à afficher
    
    // GEN_I18N_ID_DEFAUT;
	
	
	$id_langue = $_GEN_commun['i18n'];
    
	if (isset($id_langue) && ($id_langue!='')) {
		$langue_test=$id_langue;
	} else {
		$langue_test = GEN_I18N_ID_DEFAUT;
	}
    
    $requete_traduction =   'SELECT gmr_id_menu_02,  gm_ce_i18n '.
                            'FROM  gen_menu_relation, gen_menu '.
                            'WHERE '.$menu_courant_id.' = gmr_id_menu_01 ' .
                            'AND  gmr_id_menu_02  = gm_id_menu   '.
                            'AND  gmr_id_valeur  = 2 '.// 2 = "avoir traduction"
                            'AND gm_ce_i18n = "'.$langue_test.'" ';
	$resultat_traduction = 	$objet_pear_db->query($requete_traduction);
			        (DB::isError($resultat_traduction))             ? die(BOG_afficherErreurSql(__FILE__, __LINE__, $resultat_traduction->getMessage(), $requete_traduction))
			                : '';

	if ($resultat_traduction->numRows() > 0) {
		$ligne_resultat_traduction=$resultat_traduction->fetchRow(DB_FETCHMODE_ASSOC);
		$menu_courant_id=$ligne_resultat_traduction['gmr_id_menu_02'];
	}          
    
    $menu_info = GEN_lireInfoMenu($objet_pear_db, $menu_courant_id, DB_FETCHMODE_ASSOC);
    // Nous affichons le menu seulement si sa date de validité est bonne
    if ($menu_info['gm_date_fin_validite'] == '0000-00-00 00:00:00' || strtotime($menu_info['gm_date_fin_validite']) > time() ) {
    	// Préparation d'une entrée dans la liste du menu
	    $menu_nom = htmlentities($menu_info['gm_nom']);
	    $menu_hreflang = htmlentities($menu_info['gm_ce_i18n']);
	    $menu_accesskey = '';
	    $raccourci_txt = '';
	    if (($menu_accesskey = htmlentities($menu_info['gm_raccourci_clavier'])) != '') {
	        $raccourci_txt = '(Raccourci : '.$menu_accesskey.' ).';
	        $menu_accesskey = 'accesskey="'.$menu_accesskey.'" ';
	    }
	    $menu_texte_title = '';
	    if (($menu_texte_title = htmlentities($menu_info['gm_description_resume'])) != '') {
	        $menu_texte_title = 'title="'.$raccourci_txt.$menu_texte_title.'" ';;
	    }
	   
	    // Création de l'url du menu courant
	    $une_url = new Pap_URL(PAP_URL);
	    $une_url->setId($menu_courant_id);
	    $menu_url = $une_url->getURL();
		
		// Construction du VEI
		$vei .= '<a id="vei_menu_'.$vei_numero.'_'.$menu_courant_id.'" href="'.$menu_url.'" ';
		$vei .= 'hreflang="'.$menu_hreflang.'" '.$menu_texte_title.$menu_accesskey.'>'.$menu_nom.'</a>';
	    if ($menu_pere_id != 0) {
	        // Ce n'est pas le menu racine : nous afficons le symbole de séparation
	        $vei .= ' >>> ';
	    }
	    $vei .= "\n";
    }
	// Ce n'est pas le menu racine : nous continuons à rechercher les menus
	if ($menu_pere_id != 0) {
		$vei .= afficherVousEtesIci($tab_arguments, $_GEN_commun, $menu_pere_id, false);
	}
	
    // Retour du VEI après la recherche récursive des liens
    if ($premier_appel) {
        $tab_vei = explode(' >>> ', $vei);
        // Récupération des liens pour les inverser et créer le VEI
        $retour = '';
        for ($i = (count($tab_vei) - 1); $i >= 0 ;$i--) {
            if ($i == 0) {
                // Supprime le lien pour le nom du menu courant
                $tab_txt_capture='';
                preg_match("/>(.*)<\/a>/", $tab_vei[$i], $tab_txt_capture);
                $retour .= $tab_txt_capture[1];
            } else {
                $retour .= $tab_vei[$i];
            }
            // Ajout du séparateur
            $retour .= ($i != 0) ? "\n".'<span class="separateur_vei"> > </span>'."\n" : '' ;
        }
        // Retour de la chaine de liens et de textes du VEI
        return $retour;
    }
    
    return $vei;
}

// +------------------------------------------------------------------------------------------------------+
// |                                            PIED du PROGRAMME                                         |
// +------------------------------------------------------------------------------------------------------+



/* +--Fin du code ----------------------------------------------------------------------------------------+
*
* $Log: vous_etes_ici.php,v $
* Revision 1.13.2.1  2008-08-08 15:10:06  jp_milcent
* Correction du boge : FS#89
*
* Revision 1.13  2007-05-24 16:51:55  jp_milcent
* Utilisation de la constante PAP_URL.
*
* Revision 1.12  2006-12-12 13:53:54  jp_milcent
* Mise en place du nouveau format des balises d'applette.
*
* Revision 1.11  2006/12/01 16:33:40  florian
* Amélioration de la gestion des applettes et compatibilité avec le nouveau mode de gestion de l'inclusion des applettes.
*
* Revision 1.10  2006/04/28 12:41:49  florian
* corrections erreurs chemin
*
* Revision 1.9  2006/03/02 10:49:49  ddelon
* Fusion branche multilinguisme dans branche principale
*
* Revision 1.8.2.1  2006/02/28 14:02:10  ddelon
* Finition multilinguisme
*
* Revision 1.8  2005/09/26 20:18:27  ddelon
* Appli projet : php5 et generalisation
*
* Revision 1.7  2005/09/23 14:21:18  florian
* compatibilitÃ© XHTML
*
* Revision 1.6  2005/04/14 16:38:02  jpm
* Ajout de la gestion des URL avec la classe Pap_URL de Papyrus.
*
* Revision 1.5  2004/12/06 19:39:57  jpm
* Gestion de l'usurpation de VEI.
*
* Revision 1.4  2004/11/10 19:41:27  jpm
* Correction bogue quand pas de menu par défaut.
*
* Revision 1.3  2004/09/23 17:57:19  jpm
* La page active n'est pas afficher sous forme de lien mais sous forme de texte.
*
* Revision 1.2  2004/07/06 17:07:21  jpm
* Modification de la documentation pour une mailleur analyse par PhpDocumentor.
*
* Revision 1.1  2004/06/15 15:06:25  jpm
* Changement de nom et d'arborescence de Genesia en Papyrus.
*
* Revision 1.4  2004/05/05 14:33:19  jpm
* Gestion de l'indication de langue dans l'url.
* Utile que si on veut forcer la langue.
*
* Revision 1.2  2004/05/05 06:44:33  jpm
* Complément des commentaires indiquant les paquetages nécessaire à l'applette.
*
* Revision 1.1  2004/05/05 06:39:18  jpm
* Transformation en applette de la fonction générant le "vous êtes ici".
*
*
* +-- Fin du code ----------------------------------------------------------------------------------------+
*/
?>
