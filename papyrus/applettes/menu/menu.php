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
// CVS : $Id: menu.php,v 1.32.2.2 2008-08-12 16:22:05 jp_milcent Exp $
/**
* Applette : menu
*
* Génère une liste de listes comportant tous les niveaux des menus "classiques" d'un site.
* Nécessite :
* - Variable de Papyrus.
* - Base de données de Papyrus
* - Pear DB
* - Pear Net_URL
* - API Débogage 1.0
*
*@package Applette
*@subpackage Menu
//Auteur original :
*@author        Jean-Pascal MILCENT <jpm@tela-botanica.org>
//Autres auteurs :
*@author        Aucun
*@copyright     Tela-Botanica 2000-2004
*@version       $Revision: 1.32.2.2 $ $Date: 2008-08-12 16:22:05 $
// +------------------------------------------------------------------------------------------------------+
*/

// +------------------------------------------------------------------------------------------------------+
// |                                            ENTÊTE du PROGRAMME                                       |
// +------------------------------------------------------------------------------------------------------+
// Inclusion de la bibliothèque defonction sur les menu : inutile car inclue par Papyrus
 require_once GEN_CHEMIN_BIBLIO.'pap_menu.fonct.php';

$GLOBALS['_MENU_']['nom_fonction'] = 'afficherMenuNiveauMultiple';
$GLOBALS['_GEN_commun']['info_applette_nom_fonction'] = $GLOBALS['_MENU_']['nom_fonction'];
$GLOBALS['_GEN_commun']['info_applette_balise'] = '<!-- '.$GLOBALS['_GEN_commun']['balise_prefixe'].'(MENU_?(?:(|CLASSIQUE|COMMUN|DEROULANT)_([0-9]+)_([0-9]+)(|_ID_([0-9]+))|(UNIQUE)_([0-9]+))(?:|_NUMID_([0-9]+))) -->';

// +------------------------------------------------------------------------------------------------------+
// |                                            CORPS du PROGRAMME                                        |
// +------------------------------------------------------------------------------------------------------+


// +------------------------------------------------------------------------------------------------------+
// |                                           LISTE de FONCTIONS                                         |
// +------------------------------------------------------------------------------------------------------+
/** Fonction GEN_afficherMenuNiveauMultiple() - Retourne la liste des listes de menus.
*
* Cette fonction retourne ne fait qu'encapsuler une fonction récursive
* retournant les listes de menus de l'arborescence d'un site dans une
* langue donnée.
*
* @param  array contient les arguments de la fonction en 1 le niveau de départ et en 2 le niveau d'arrivée (profondeur max demandée).
* @param  array  tableau global de Papyrus.
* @return string HTML la liste des listes de menus.
*/
function afficherMenuNiveauMultiple($tab_applette_arguments, $_GEN_commun)
{
    // Initialisation de variable et gestion des globales
    $objet_pear_db = $_GEN_commun['pear_db'];
    $id_site = $_GEN_commun['info_site']->gs_id_site;
    if (isset($_GEN_commun['info_menu'])) {
    	$id_menu = $_GEN_commun['info_menu']->gm_id_menu;
    }
    $num_menu = $GLOBALS['_PAPYRUS_']['applette']['comptage'][$GLOBALS['_MENU_']['nom_fonction']];
    
    // Indentation du html
    $indent_origine = 12;// Indentation de départ en nombre d'espace
    $indent_pas     = 4;// Pas d'indentation en nombre d'espace
    
    // Récupérations des arguments passés dans la balise.
    // Pour les menus CLASSIQUE et COMMUN
    $balise           = $tab_applette_arguments[1];
    $menu_type        = $tab_applette_arguments[2];
    $niveau_depart    = (isset($tab_applette_arguments[3])) ? $tab_applette_arguments[3] : 1;
    $profondeur       = $tab_applette_arguments[4];
	$menu_depart = 0;
    // Si on indique un ID de menu de départ
    if (isset($tab_applette_arguments[5]) && !empty($tab_applette_arguments[5])) {
        $menu_depart = $tab_applette_arguments[6];
    }
    // Pour les menus UNIQUE
    if (isset($tab_applette_arguments[7])) {
        $menu_type = $tab_applette_arguments[7]; // Type de menu : UNIQUE
    }
    if (isset($tab_applette_arguments[8])) {
        $menu_depart = $tab_applette_arguments[8]; // ID du menu de type UNIQUE
    }
    // Pour les balises menus avec NUMID en dur    
    // Gestion du numéro unique pour l'attribut id des li des menus
    if (isset($tab_applette_arguments[9])) {
        $num_menu = $tab_applette_arguments[9];
    }
    
    // Gestion du type de menu
    switch ($menu_type) {
        case 'COMMUN' :
            $menu_type = 'commun';
        break;
        case 'UNIQUE' :
            $menu_type = 'unique';
        break;
        case 'DEROULANT' :
            $menu_type = 'deroulant';
        break;
        case 'CLASSIQUE' :
        default:
            $menu_type = 'classique';
    }
	// Si le niveau de départ est supérieur à 1 et qu'aucun id de menu n'a été indiqué dans la balise
	$niveau_actuel = 1;
	if (1 < $niveau_depart && 0 == $menu_depart && isset($id_menu)) {
		$menu_depart = GEN_lireIdentifiantMenuPere($id_menu);
		$niveau_actuel = GEN_donnerProfondeur($id_site, $id_menu);
		//trigger_error("Niveau actuel du menu si$id_site:me$id_menu pour la balise {$tab_applette_arguments[0]} : $niveau_actuel", E_USER_NOTICE);
	}
	
    //Construction du menu
    $xhtml_menu = afficherListeNiveauMultiple(   $objet_pear_db, $id_site,$niveau_depart, 
                                                    $profondeur, $menu_depart, 1, $menu_type, $indent_origine, 
                                                    $indent_pas, $_GEN_commun, $num_menu, $niveau_actuel);
    
    // Si le menu est déroulant il faut stocker un peu de javascript pour IE
    if ($menu_type == 'deroulant') {
        GEN_stockerCodeScript ('sfHover = function() {
	var sfEls = document.getElementById("groupe_menu_1_0").getElementsByTagName("LI");
	for (var i=0; i<sfEls.length; i++) {
		sfEls[i].onmouseover=function() {
			this.className+=" sfhover";
		}
		sfEls[i].onmouseout=function() {
			this.className=this.className.replace(new RegExp(" sfhover\\\\b"), "");
		}
	}
}
if (window.attachEvent) window.attachEvent("onload", sfHover);') ;
    }
    //Si nous avons un 
    if (! empty($xhtml_menu)) {
        $retour = $xhtml_menu;
    } else {
        $retour = '<!-- '.$balise.' : aucun menu trouvé ! -->';
    }
    return $retour;
}

/** Fonction afficherListeNiveauMultiple() - Affiche une arborescence des menu classiques d'un site.
*
* Créé et retourne une liste pour chaque niveau de menu classique trouvé dans l'arborescence
* des menus d'un site dans une langue donnée.
* C'est une fonction récursive.
*
* @param  mixed   objet Pear DB de connexion à la base de données.
* @param  integer identifiant d'un site.
* @param  integer identifiant de la langue demandée.
* @param  integer niveau de départ.
* @param  integer niveau d'arrivée (profondeur max demandée).
* @param  integer identifiant d'un menu pére.
* @return  string  les listes de menus au format XHTML.
*/
function afficherListeNiveauMultiple( &$objet_pear_db, $id_site,  $niveau_depart, $profondeur, 
                                        $id_pere_menu_a_deployer, $position, $menu_type, $indent_origine = 12, 
                                        $indent_pas = 4, $_GEN_commun, $num_menu, $niveau_actuel = 1)
{
    // Initialisation des variables
    $retour = '';
    $tete = '';
    $corps = '';
    $pied = '';
    $i18n_url = '' ;
    $id_langue = $_GEN_commun['i18n'];//identifiant de la langue choisie
    
    if ($id_langue != GEN_I18N_ID_DEFAUT) {
    	$i18n_url=$id_langue;
    } 
    
    
	if (isset($id_langue) && ($id_langue!='')) {
		$langue_test=$id_langue;
	} else {
		$langue_test=GEN_I18N_ID_DEFAUT;
	}
    
    
    // Récupération des infos sur sur l'entrée du menu à afficher
    $menu_info = GEN_lireInfoMenu($objet_pear_db, $id_pere_menu_a_deployer, DB_FETCHMODE_ASSOC);
    // Gestion des menus uniques
    if ($menu_type == 'unique' && ($menu_info['gm_date_fin_validite'] == '0000-00-00 00:00:00' || strtotime($menu_info['gm_date_fin_validite']) > time() )) {
        $retour .= afficherEntreeListeMenu( $objet_pear_db, $id_pere_menu_a_deployer, $i18n_url,
                                            $niveau_actuel, 1, $position, $menu_type, $indent_origine, $indent_pas, $_GEN_commun, $num_menu);
        // Dans le cas, d'un menu unique, on retourne directement le résultat ici.
        return $retour;
    } 
    // On affiche un menu que si $profondeur <= $niveau_actuel <= $depart
    if ($niveau_actuel > $profondeur) {
        return null;
    }
    
    // Nous regardons si nous devons afficher un menu racine
    if ($id_pere_menu_a_deployer != 0 && $niveau_actuel == 1 && ($menu_info['gm_date_fin_validite'] == '' || $menu_info['gm_date_fin_validite'] == '0000-00-00 00:00:00' || strtotime($menu_info['gm_date_fin_validite']) > time() )) {
        $tete .=   str_repeat(' ', $indent_origine + ($indent_pas * $position)).
                    '<ul class="groupe_menu_'.$num_menu.'_'.$id_pere_menu_a_deployer.'" class="menu_'.$menu_type.'_'.'n'.$niveau_actuel.'">'."\n";
        $id_menu_selectionne = $GLOBALS['_GEN_commun']['info_menu']->gm_id_menu;
        if (!empty($id_menu_selectionne) && (GEN_etreAncetre($id_pere_menu_a_deployer, $id_menu_selectionne) || $id_pere_menu_a_deployer == $id_menu_selectionne) ) {
            $classe = 'menu_actif';
        } else {
            $classe = 'menu_inactif';
        }
        
        
        
       // Pour un menu dont on spécifie l'identifiant du menu départ, on affiche ce menu. 
   	    $corps .=  str_repeat(' ', $indent_origine + ($indent_pas * ($position + 1))).
       	            '<li id="menu_'.$num_menu.'_'.$id_pere_menu_a_deployer.'" class="'.$classe.'">'."\n";
        $corps .= afficherEntreeListeMenu( $objet_pear_db, $id_pere_menu_a_deployer, $i18n_url,
   	                                        $niveau_actuel, 1, $position, $menu_type, $indent_origine, $indent_pas, $_GEN_commun, $num_menu);
    }
    
    if ($niveau_actuel >= $niveau_depart && $niveau_actuel <= $profondeur) {
        $tete .=   str_repeat(' ', $indent_origine + ($indent_pas * ($position + 1))).
                    '<ul id="groupe_menu_'.$num_menu.'_'.$id_pere_menu_a_deployer.'" class="menu_'.$menu_type.'_'.'n'.$niveau_actuel.'">'."\n";
    }
    
    $requete =  'SELECT gm_id_menu, gm_date_fin_validite, gm_ce_i18n , GMR01.gmr_ordre, gm_nom '.
                'FROM gen_menu, gen_menu_relation AS GMR01, gen_menu_relation AS GMR02 '.
                'WHERE GMR01.gmr_id_menu_01 = gm_id_menu '.
                'AND GMR01.gmr_id_valeur = 1 '.// 1 = "avoir père"
                'AND GMR02.gmr_id_menu_02 = gm_id_menu '.
                'AND GMR02.gmr_id_menu_01 = GMR02.gmr_id_menu_02 '.
                'AND (gm_ce_i18n  = "'.GEN_I18N_ID_DEFAUT.'" '.
                'OR gm_ce_i18n  = "'.$langue_test.'" )' ;
                
    $requete .= 'AND GMR01.gmr_id_menu_02 = '.$id_pere_menu_a_deployer.' ';
    
    if ($menu_type == 'classique' || $menu_type == 'deroulant') {
        $requete .= 'AND gm_ce_site = '.$id_site.' '.
                    'AND GMR02.gmr_id_valeur = 100 '.// 100 = type "menu classique"
                    'ORDER BY GMR01.gmr_ordre ASC';
    } else if ($menu_type == 'commun') {
        $requete .= 'AND gm_ce_site = 0 '.
                    'AND GMR02.gmr_id_valeur = 102 '.// 102 = type "menu commun"
                    'ORDER BY GMR01.gmr_ordre ASC';
    }
    //$GLOBALS['_GEN_commun']['debogage_info'] .= $requete;
    
    $resultat = $objet_pear_db->query($requete);
    (DB::isError($resultat)) ? die(BOG_afficherErreurSql(__FILE__, __LINE__, $resultat->getMessage(), $requete)) : '';
    
        
    $liste_menu=array();
    
    
    // On ne retient pas les menus qui sont des traductions ...
     
     
    while ($ligne = $resultat->fetchRow(DB_FETCHMODE_OBJECT)) {
    	
    			if ($langue_test == GEN_I18N_ID_DEFAUT) {
    				
    				// Le menu n'est pas une traduction : on le traite
    				$requete_est_traduction =   'SELECT gmr_id_menu_01 '.
	                                    'FROM  gen_menu_relation '.
	                                    'WHERE '.$ligne->gm_id_menu.' = gmr_id_menu_02 ' .
	                                    'AND gmr_id_menu_01 <> gmr_id_menu_02  '.
	                                    'AND  gmr_id_valeur  = 2 ';// 2 = "avoir traduction"
		            $resultat_est_traduction = $objet_pear_db->query($requete_est_traduction);
		            (DB::isError($resultat_est_traduction))
		                ? die(BOG_afficherErreurSql(__FILE__, __LINE__, $resultat_est_traduction->getMessage(), $requete_est_traduction))
		                : '';
		                
		   			if ( $resultat_est_traduction->numRows() == 0 ) {
	    	 			   $liste_menu[]=$ligne;
		            }
    			}
    			// Par defaut, on traite tous les menus trouvés
    			else {									
    				    $liste_menu[]=$ligne;
    			}
    
    }
       
	if (!function_exists('cmp')) {
		function cmp($a, $b) {
		    if ($a->gmr_ordre == $b->gmr_ordre) {
	   			return 0;
			}
			return ($a->gmr_ordre < $b->gmr_ordre) ? -1 : 1;
		}
	}
	
	usort ($liste_menu,"cmp");
	
    foreach ($liste_menu as $ligne) {

    //while ($ligne = $resultat->fetchRow(DB_FETCHMODE_OBJECT)) {
        if ($ligne->gm_date_fin_validite == '' || $ligne->gm_date_fin_validite == '0000-00-00 00:00:00' || strtotime($ligne->gm_date_fin_validite) > time()) {
            
	// On ne retient pas egalement les menu reserve a une seule langue 
 			$requete_restriction =    'SELECT gmr_id_menu_02 '.
	                                  'FROM  gen_menu_relation '.
	                                   'WHERE '.$ligne->gm_id_menu.' = gmr_id_menu_01 ' .
	                                   'AND  gmr_id_valeur  = 106 ';// 106 restriction de menu
			$resultat_restriction = $objet_pear_db->query($requete_restriction);
			(DB::isError($resultat_restriction))             ? die(BOG_afficherErreurSql(__FILE__, __LINE__, $resultat_restriction->getMessage(), $requete_restriction))
				: '';
					       
		    if ($resultat_restriction->numRows()>0 && $langue_test!=$ligne->gm_ce_i18n) {
		    	$select_menu=0;
		    }
		    else {
		    	$select_menu=1;
		    }		    
			                            
            if ($niveau_actuel >= $niveau_depart && $niveau_actuel <= $profondeur  && $select_menu==1) {
            	
                $id_menu_inf = $ligne->gm_id_menu;
                $id_menu_selectionne = '';
                if (isset($GLOBALS['_GEN_commun']['info_menu']->gm_id_menu)) {
                    $id_menu_selectionne = $GLOBALS['_GEN_commun']['info_menu']->gm_id_menu;
                }
                // On vérifie si le menu est le menu sélectionné
                if (!empty($id_menu_selectionne) && (GEN_etreAncetre($id_menu_inf, $id_menu_selectionne) || $id_menu_inf == $id_menu_selectionne) ) {
                    $classe = 'menu_actif';
                } else {
                    $classe = 'menu_inactif';
                }
                
                
   
                
	                $tmp= afficherEntreeListeMenu( $objet_pear_db, $id_menu_inf, $niveau_actuel, 
    	                                                $ligne->gmr_ordre, $position, $menu_type, $indent_origine, $indent_pas, $_GEN_commun, $num_menu);
            	    // Affichage du menu
            	    
            	    if ($tmp!='') {
	                	$corps .=   str_repeat(' ', $indent_origine + ($indent_pas * ($position + 2))).
                    	        '<li id="menu_'.$num_menu.'_'.$id_menu_inf.'" class="'.$classe.'">'."\n";
		                $corps .= $tmp;
            	    }
            }
            // Pour chaque menu on regarde s'il y a des fils. Si oui, on les déploie.
            $requete_fils = 'SELECT gm_id_menu '.
                            'FROM gen_menu, gen_menu_relation AS GMR01, gen_menu_relation AS GMR02 '.
                            'WHERE GMR01.gmr_id_menu_02 = '.$ligne->gm_id_menu.' '.
                            'AND GMR01.gmr_id_menu_01 = gm_id_menu '.
                            'AND GMR01.gmr_id_valeur = 1 '.// 1 = "avoir père"
                            'AND GMR02.gmr_id_menu_02 = gm_id_menu '.
                            'AND GMR02.gmr_id_menu_01 = GMR02.gmr_id_menu_02 ' ;
            if ($menu_type == 'classique') {
                $requete_fils .='AND GMR02.gmr_id_valeur = 100 ' ;// 100 = type "menu classique"
            } 
            if ($menu_type == 'commun') {
                $requete_fils .='AND GMR02.gmr_id_valeur = 102 '; // 102 = type "menu commun"
            }
            $requete_fils .= 'ORDER BY GMR01.gmr_ordre ASC LIMIT 0,1';
            
            $resultat_fils = $objet_pear_db->query($requete_fils);
            (DB::isError($resultat_fils))
                ? die(BOG_afficherErreurSql(__FILE__, __LINE__, $resultat_fils->getMessage(), $requete_fils))
                : '';
           
           	if (isset($_GEN_commun['info_menu'])) { 
	            if ($resultat_fils->numRows() != 0 && $ligne->gm_id_menu == $GLOBALS['_GEN_commun']['info_menu']->gm_id_menu 
	                || GEN_etreAncetre($ligne->gm_id_menu, $GLOBALS['_GEN_commun']['info_menu']->gm_id_menu) || $menu_type == 'deroulant') {
	                $niveau_actuel++;
	                $corps .= afficherListeNiveauMultiple( $objet_pear_db, $id_site, $niveau_depart, 
	                                                            $profondeur, $ligne->gm_id_menu, ($position + 3), $menu_type, 
	                                                            null, null, $_GEN_commun, $num_menu, $niveau_actuel);
	                // On ramène $niveau_actuel un cran plus bas
	                $niveau_actuel--;
	            }
           	}
            
            if ($niveau_actuel >= $niveau_depart && $niveau_actuel <= $profondeur) {
                $corps .= str_repeat(' ', $indent_origine + ($indent_pas * ($position + 2))).'</li>'."\n";
            }
            
            $resultat_fils->free();
        }
    }
    
    if ($niveau_actuel >= $niveau_depart && $niveau_actuel <= $profondeur) {
        $pied .= str_repeat(' ', $indent_origine + ($indent_pas * $position+ 1)).'</ul>'."\n";
    }
    
    // Nous regardons si nous avons affiché le menu racine
    if ($id_pere_menu_a_deployer != 0 && $niveau_actuel == 1) {
        $corps .= str_repeat(' ', $indent_origine + ($indent_pas * ($position + 1))).'</li>'."\n";
        $pied .= str_repeat(' ', $indent_origine + ($indent_pas * $position)).'</ul>'."\n";
    }
    
    if (empty($corps)) {
        return $retour;
    } else {
        $retour = $tete.$corps.$pied;
        return $retour;
    }
}

/** Fonction afficherEntreeListeMenu() - Contruit une entrée dans une liste du menu d'un site.
*
* Cette fonction retourne une entrée dans la liste du menu d'un site (<a></a>).
* Le menu est un lien.
* Necessite l'utilisation de Pear Net_URL par le programme appelant cette fonction.
*
* @param  mixed   objet Pear DB de connexion à la base de données.
* @param  integer niveau du menu.
* @param  integer ordre du menu dans le niveau.
* @return  string  liste représentant le menu duHTML
* 
* $menu_id : identifiant du menu (!= code menu)
*/
function afficherEntreeListeMenu($db, $menu_id, $niveau, $ordre, $position, $menu_type, $indent_origine = 12, $indent_pas = 4, $_GEN_commun, $num_menu)
{

	
	
	$id_langue = $GLOBALS['_GEN_commun']['i18n'];
    
	if (isset($id_langue) && ($id_langue!='')) {
		$langue_test=$id_langue;
	} else {
		$langue_test=GEN_I18N_ID_DEFAUT;
	}
    

    $requete_traduction =   'SELECT gmr_id_menu_02,  gm_ce_i18n '.
                            'FROM  gen_menu_relation, gen_menu '.
                            'WHERE '.$menu_id.' = gmr_id_menu_01 ' .
                            'AND  gmr_id_menu_02  = gm_id_menu   '.
                            'AND  gmr_id_valeur  = 2 '.// 2 = "avoir traduction"
                            'AND gm_ce_i18n = "'.$langue_test.'" ';
	$resultat_traduction = $db->query($requete_traduction);
			        (DB::isError($resultat_traduction))             ? die(BOG_afficherErreurSql(__FILE__, __LINE__, $resultat_traduction->getMessage(), $requete_traduction))
			                : '';

	if ($resultat_traduction->numRows() > 0) {
		$ligne_resultat_traduction=$resultat_traduction->fetchRow(DB_FETCHMODE_ASSOC);
		$menu_id=$ligne_resultat_traduction['gmr_id_menu_02'];
	}

	
	else {
		
		// Ne sont affichés que les traductions par defaut des menus
		// non traduits
		
		// Ici : pas de traduction

			if ($langue_test!=GEN_I18N_ID_DEFAUT) {
		
			    $requete_defaut =   'SELECT gmr_id_menu_02 '.
	                            	'FROM  gen_menu_relation '.
	                            	'WHERE '.$menu_id. ' = gmr_id_menu_01 ' .
	                            	'AND  gmr_id_valeur  = 105 ';// 105 Traduction par defaut
				$resultat_defaut = $db->query($requete_defaut);
				(DB::isError($resultat_defaut))             ? die(BOG_afficherErreurSql(__FILE__, __LINE__, $resultat_defaut->getMessage(), $requete_defaut))
				: '';
				if ($resultat_defaut->numRows() > 0) {
						
						$ligne_resultat_defaut=$resultat_defaut->fetchRow(DB_FETCHMODE_ASSOC);
						$menu_id=$ligne_resultat_defaut['gmr_id_menu_02'];
				}
			}
		
	}            
	
    // Récupération des infos sur sur l'entrée du menu à afficher
    $menu_info = GEN_lireInfoMenu($db, $menu_id, DB_FETCHMODE_ASSOC);
   
   
    
    // Préparation d'une entrée dans la liste du menu
    $menu_nom = htmlentities($menu_info['gm_nom']);
    

    if (trim($menu_nom)=='') return '';    
    
    
    $menu_accesskey = '';
    $raccourci_txt = '';
    if (($menu_accesskey = htmlentities($menu_info['gm_raccourci_clavier'])) != '') {
        $raccourci_txt = '[Raccourci : Alt+'.$menu_accesskey.' ] ';
        $menu_accesskey = 'accesskey="'.$menu_accesskey.'" ';
    }
    $menu_texte_title = '';
    if (($menu_texte_title = htmlentities($menu_info['gm_description_resume'])) != '') {
        $menu_texte_title = 'title="'.$raccourci_txt.$menu_texte_title.'" ';;
    }
    
    $une_url = new Pap_URL(PAP_URL);
    $une_url->setId($menu_id);

	if (isset($i18n) && ($i18n!='')) {
		$une_url->addQuerystring(GEN_URL_CLE_I18N,$i18n);
	}    
    //Création d'une entrée dans la liste du menu
    $espaces = str_repeat(' ', $indent_origine + ($indent_pas * ($position + 2)));
    //$retour  =  $espaces.'<a id="menu_lien_'.$num_menu.'_'.$menu_id.'" href="'.$une_url->getURL().'" '.$menu_texte_title.$menu_accesskey.'>'.$menu_nom.'</a>'."\n";
    $retour  =  $espaces.'<a id="menu_lien_'.$menu_id.'_'.$menu_id.'" href="'.$une_url->getURL().'" '.$menu_texte_title.$menu_accesskey.'>'.$menu_nom.'</a>'."\n";
    return $retour;
}

// +------------------------------------------------------------------------------------------------------+
// |                                            PIED du PROGRAMME                                         |
// +------------------------------------------------------------------------------------------------------+


/* +--Fin du code ----------------------------------------------------------------------------------------+
*
* $Log: menu.php,v $
* Revision 1.32.2.2  2008-08-12 16:22:05  jp_milcent
* Correction bogue FS#101.
*
* Revision 1.32.2.1  2008-08-08 14:58:15  jp_milcent
* Les listes de menu sous les menus cachÃ©s s'affiche maintenant.
*
* Revision 1.33  2008-08-08 14:56:46  jp_milcent
* Les listes de menu sous les menus cachÃ©s s'affiche maintenant.
*
* Revision 1.32  2007-10-24 14:43:02  ddelon
* Gestion des menus reservÃ©s Ã  une langue
*
* Revision 1.31  2006-12-01 16:33:40  florian
* Amélioration de la gestion des applettes et compatibilité avec le nouveau mode de gestion de l'inclusion des applettes.
*
* Revision 1.30  2006/11/27 13:47:23  florian
* ajout de la touche alt pour les raccourcis
*
* Revision 1.29  2006/10/16 15:49:46  ddelon
* Refactorisation code mulitlinguisme et gestion menu invisibles
*
* Revision 1.28  2006/09/21 15:52:19  jp_milcent
* Utilisation de PAP_URL pour Net_URL à la place des constantes serveur.
*
* Revision 1.27  2006/09/20 09:25:31  alexandre_tb
* Initialisation de la variable $i18n_url pour éviter un notice
*
* Revision 1.26  2006/07/04 09:43:21  alexandre_tb
* correction d'un bug du javascript
*
* Revision 1.25  2006/06/28 12:53:34  ddelon
* Multilinguisme : menu par defaut
*
* Revision 1.24  2006/03/13 21:00:20  ddelon
* Suppression messages d'erreur multilinguisme
*
* Revision 1.23  2006/03/02 10:49:49  ddelon
* Fusion branche multilinguisme dans branche principale
*
* Revision 1.22.2.2  2006/02/28 14:02:11  ddelon
* Finition multilinguisme
*
* Revision 1.22.2.1  2005/12/20 14:40:25  ddelon
* Fusion Head vers Livraison
*
* Revision 1.22  2005/09/27 08:42:49  ddelon
* Menu et Squelette
*
* Revision 1.21  2005/09/22 14:02:49  ddelon
* nettoyage annuaire et php5
*
* Revision 1.20  2005/05/27 14:56:51  alex
* correction de bug d'affichage des menus communs
*
* Revision 1.19  2005/05/27 10:23:00  jpm
* Modification du style des raccourcis.
*
* Revision 1.18  2005/05/03 08:39:32  jpm
* Ajout d'un test sur la date.
*
* Revision 1.17  2005/04/19 16:59:51  jpm
* Suppression de l'affichage d'un débogage.
*
* Revision 1.16  2005/04/19 16:47:24  jpm
* Gestion des dates  de fin de validité des menus.
*
* Revision 1.15  2005/04/14 16:37:48  jpm
* Ajout de la gestion des URL avec la classe Pap_URL de Papyrus.
*
* Revision 1.14  2005/03/02 11:02:33  jpm
* Suppression des espaces avant l'ouverture de la balise php.
*
* Revision 1.13  2005/02/08 19:03:03  alex
* ajout de la balise DEROULANT qui permet de faire un affichage des menus avec survol javascript. Il nécessite des styles particuliers.
*
* Revision 1.12  2004/12/02 10:42:15  jpm
* Correction bogue liste ul vide si pas de menu.
*
* Revision 1.11  2004/11/26 19:02:22  jpm
* Correction bogue li surnuméraires.
*
* Revision 1.10  2004/11/15 17:40:02  jpm
* Changement nom balise.
*
* Revision 1.9  2004/11/15 16:17:40  jpm
* Gestion des différents types de menus.
*
* Revision 1.8  2004/11/10 18:59:21  jpm
* Début de gestion de l'ensemble des types de menu dans l'applette menu.
*
* Revision 1.7  2004/09/23 14:31:40  jpm
* Correction bogue sur le menu actif.
*
* Revision 1.6  2004/09/23 10:47:16  jpm
* Amélioration de la gestion du menu actif en fonction du menu demandé dans l'url.
*
* Revision 1.5  2004/09/15 09:32:21  jpm
* Mise en conformité avec le standard XHTML Strict.
* Amélioration de la gestion de l'indentation.
*
* Revision 1.4  2004/09/13 18:02:34  jpm
* Changement de nom de m_select en menu_actif et de m_non_select en menu_inactif.
* Amélioration du rendu du code html.
*
* Revision 1.3  2004/07/23 11:21:25  alex
* suppression du javascript.
*
* Revision 1.2  2004/06/25 08:32:02  alex
* modification des styles
*
* Revision 1.1  2004/06/15 15:04:14  jpm
* Changement de nom et d'arborescence de Genesia en Papyrus.
*
* Revision 1.10  2004/05/05 14:33:04  jpm
* Gestion de l'indication de langue dans l'url.
* Utile que si on veut forcer la langue.
*
* Revision 1.8  2004/05/05 06:44:19  jpm
* Complément des commentaires indiquant les paquetages nécessaire à l'applette.
*
* Revision 1.7  2004/05/04 14:19:37  jpm
* Mise entre guillemet simple d'un texte.
*
* Revision 1.6  2004/05/03 14:11:01  jpm
* Intégration du fichier bibliothèquie de fonctions sur gen_menu provenant de la bibliothèque de Génésia INUTILE!
*
* Revision 1.5  2004/05/03 14:09:32  jpm
* Intégration du fichier bibliothèquie de fonctions sur gen_menu provenant de la bibliothèque de Génésia.
*
* Revision 1.4  2004/05/03 11:19:00  jpm
* Intégration de la variable globale de Génésia dans les arguments de la fonction de l'applette.
*
* Revision 1.3  2004/05/03 08:52:44  jpm
* Modification pour intégrer les sous listes (ul) de menus à l'intèrieur de l'entrée (li) du menu supérieur.
*
* Revision 1.2  2004/05/01 17:22:23  jpm
* Changement de nom de l'applette dans les commentaires.
*
* Revision 1.1  2004/05/01 16:12:39  jpm
* Ajout de l'applette gérant les menus multi niveaux ou niveau unique.
*
*
* +-- Fin du code ----------------------------------------------------------------------------------------+
*/
?>
