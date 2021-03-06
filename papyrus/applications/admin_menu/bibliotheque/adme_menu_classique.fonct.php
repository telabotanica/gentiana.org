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
// CVS : $Id: adme_menu_classique.fonct.php,v 1.42 2007-10-25 14:26:56 ddelon Exp $
/**
* Fonctions de gestion des menus classiques
*
* Permet de lister, d'ajouter, de modifier, et de d�placer des menus classiques.
* Par menus classiques nous entendons tous les menus devant paraitre dans l'arborescences 
* des menus disponibles pour le site courant.
*
*@package Admin_menu
*@subpackage Fonctions
//Auteur original :
*@author        Jean-Pascal MILCENT <jpm@tela-botanica.org>
//Autres auteurs :
*@author        Alexandre GRANIER <alexandre@tela-botanica.org>
*@copyright     Tela-Botanica 2000-2004
*@version       $Revision: 1.42 $ $Date: 2007-10-25 14:26:56 $
// +------------------------------------------------------------------------------------------------------+
*/

// +------------------------------------------------------------------------------------------------------+
// |                                            ENT�TE du PROGRAMME                                       |
// +------------------------------------------------------------------------------------------------------+


// +------------------------------------------------------------------------------------------------------+
// |                                           LISTE de FONCTIONS                                         |
// +------------------------------------------------------------------------------------------------------+

/** Fonction ADME_afficherListeMenuClassique () - Affiche un arbre de menu en xhtml
*
* Elle forme l'arbre des menus classiques � administrer.
* Ancien nom : deployer_menu().
*
* @param  object objet Pear de connection � la base de donn�es.
* @param  object objet Pear repr�sentant l'url de base.
* @param  integer l'identifiant du menu � administrer.
* @param  integer l'identifiant du menu sur lequel on agit.
* @param  string le nom de l'action courante.
* @param  integer l'identifiant du menu en cours de d�ploiement.
* @param  boolean true indique que l'on a � faire au premier appel de cette fonction r�cursive.
* @return string  le code XHTML constituant l'arbre des menus � administrer.
*/
function ADME_afficherListeMenuClassique($db, $url, $adme_site_id, $adme_menu_id, $adme_action, $id_menu_a_deployer, $bln_premier_appel = true)
{

	
    // Initialisation des variables :
    $retour = '';
    
    // Est-ce que ces menus comporte des sous-menus ?
    $requete_sous_menu =    'SELECT gm_id_menu '.
                            'FROM gen_menu, gen_menu_relation AS GMR01, gen_menu_relation AS GMR02 '.
                            'WHERE GMR01.gmr_id_menu_02 = '.$id_menu_a_deployer.' '.
                            'AND GMR01.gmr_id_menu_01 = gm_id_menu '.
                            'AND gm_ce_site = '.$adme_site_id.' '.
                            'AND GMR01.gmr_id_valeur = 1 '.// 1 = avoir "p�re"
                            'AND GMR02.gmr_id_menu_02 = gm_id_menu '.
                            'AND GMR02.gmr_id_menu_01 = GMR02.gmr_id_menu_02 '.
                            'AND GMR02.gmr_id_valeur = 100 '.// 100 = type "menu classique"
                            'ORDER BY GMR01.gmr_ordre ASC';
    
    $resultat_sous_menu = $db->query($requete_sous_menu) ;
    if (DB::isError($resultat_sous_menu)) {
        die(BOG_afficherErreurSql(__FILE__, __LINE__, $resultat_sous_menu->getMessage(), $requete_sous_menu));
    }
    
    // Gestion du stockage ou d�stockage des menus ouverts
    if (($adme_action == ADME_LG_ACTION_DEPLIER || $adme_action == ADME_LG_ACTION_CLASSIQUE_AJOUTER) && $id_menu_a_deployer != 0) {
        $_SESSION['adme_menus_classiques_ouverts'][$adme_menu_id] = $adme_menu_id;
    }
    if ($adme_action == ADME_LG_ACTION_PLIER && $id_menu_a_deployer != 0) {
        unset($_SESSION['adme_menus_classiques_ouverts'][$adme_menu_id]);
        foreach ($_SESSION['adme_menus_classiques_ouverts'] as $val) {
            if (GEN_etreAncetre($adme_menu_id, $val)) {
                unset($_SESSION['adme_menus_classiques_ouverts'][$val]);
            }
        }
    }
    
    // Gestion affichage des menus
    if ($resultat_sous_menu->numRows() > 0) {
        // Ici, on sait qu'un menu a des sous menus, on commence par l'afficher:
        if ($bln_premier_appel == false) {
            $retour .= '<li>'."\n";
            
            if (GEN_etreAncetre($id_menu_a_deployer, $adme_menu_id) || 
                ($id_menu_a_deployer == $adme_menu_id && $adme_action == ADME_LG_ACTION_DEPLIER) || 
                isset($_SESSION['adme_menus_classiques_ouverts'][$id_menu_a_deployer])
                ){
                // Affiche un -
                $retour .= ADME_retournerXhtmlMenuClassique($db, $url, $adme_site_id, $id_menu_a_deployer, 1);
            } else if ( !GEN_etreAncetre($id_menu_a_deployer, $adme_menu_id) || 
                        ($id_menu_a_deployer == $adme_menu_id && $adme_action == ADME_LG_ACTION_PLIER) || 
                        !isset($_SESSION['adme_menus_classiques_ouverts'][$id_menu_a_deployer])
                        ){
                // Affiche un +
                $retour .= ADME_retournerXhtmlMenuClassique($db, $url, $adme_site_id, $id_menu_a_deployer, 2);
            }
        }
        if ($bln_premier_appel == true || GEN_etreAncetre($id_menu_a_deployer, $adme_menu_id) || 
            ($id_menu_a_deployer == $adme_menu_id && $adme_action == ADME_LG_ACTION_DEPLIER) || 
            isset($_SESSION['adme_menus_classiques_ouverts'][$id_menu_a_deployer])
            ){
            $retour .= '<ul class="menu_classique">'."\n";
            while ($ligne_sous_menu = $resultat_sous_menu->fetchRow(DB_FETCHMODE_OBJECT)) {
                $retour .= ADME_afficherListeMenuClassique($db, $url, $adme_site_id, $adme_menu_id, $adme_action, $ligne_sous_menu->gm_id_menu, false);
            }
            $retour .= '</ul>'."\n";
        }
        if ($bln_premier_appel == false) {
            $retour .= '</li>'."\n";
        }
    } else if ($resultat_sous_menu->numRows() == 0 && $bln_premier_appel == false) {
        $retour .= '<li>'."\n";
        $retour .= ADME_retournerXhtmlMenuClassique($db, $url, $adme_site_id, $id_menu_a_deployer, 0);
        $retour .= '</li>'."\n";
    }
    
    return $retour;
}

/** Fonction ADME_retournerXhtmlMenuClassique() - Effectue une sortie d'un menu en XHTML
*
* Retourne le XHTML d'une ligne de l'arbre des menus "classiques" permettant de l'administer.
* Ancien nom : menu_toHtml().
*
* @param  object objet Pear de connection � la base de donn�es.
* @param  object objet Pear repr�sentant l'url de base.
* @param  integer l'identifiant du site � administrer.
* @param  integer l'identifiant du menu � administrer.
* @param  integer 0 indique que le menu ne poss�de pas de fils, 1 qu'il faut afficher un - et 2 un +.
* @return string une ligne de liste XHTML
*/
function ADME_retournerXhtmlMenuClassique($db, $url, $adme_site_id, $adme_menu_id, $int_deplier,$est_traduction=false,$menu_traduction_defaut=0)
{
    //-------------------------------------------------------------------------------------------------------------------
    // Initialisation des variables

    
    //-------------------------------------------------------------------------------------------------------------------
    // R�cup�ration des infos concernant l'administrateur d'un menu
    $requete =  'SELECT gen_menu.*, ga_prenom '.
                'FROM gen_menu, gen_annuaire '.
                'WHERE gm_id_menu = '.$adme_menu_id.' '.
                'AND gm_ce_admin = ga_id_administrateur';
    
    $resultat = $db->query($requete);
    if (DB::isError($resultat)) {
        die(BOG_afficherErreurSql(__FILE__, __LINE__, $resultat->getMessage(), $requete));
    }
    $ligne = $resultat->fetchRow(DB_FETCHMODE_OBJECT);
    //-------------------------------------------------------------------------------------------------------------------
    // Recup�ration des infos de l'appli du menu courant.
    $ligne_app = GEN_retournerInfoAppliMenu($db, $adme_menu_id);
    
    //-------------------------------------------------------------------------------------------------------------------
    // XHTML image plier-d�plier
    
    $url->addQueryString('adme_site_id', $adme_site_id);
    $url->addQueryString('adme_menu_id', $adme_menu_id);
    $xhtml_pd = '';
    if ($int_deplier != 0) {
        if ($int_deplier == 1) {
            // Afficher un -
            $image_plier_deplier = ADME_IMAGE_MOINS;
            $alt = ADME_LG_ACTION_PLIER_ALT;
            $url->addQueryString('adme_action', ADME_LG_ACTION_PLIER);
            $url_plier_deplier = $url->getURL();
        } else if ($int_deplier == 2) {
            // Afficher un +
            $image_plier_deplier = ADME_IMAGE_PLUS;
            $alt = ADME_LG_ACTION_DEPLIER_ALT;
            $url->addQueryString('adme_action', ADME_LG_ACTION_DEPLIER);
            $url_plier_deplier = $url->getURL();
        }
        $xhtml_pd = '<a href="'.$url_plier_deplier.'" title="'.$alt.'">'.
                        '<img class="'.ADME_CLASS_IMG_PD.'" src="'.$image_plier_deplier.'" alt="'.$alt.'" />'.
                    '</a>'.'&nbsp;'."\n";
    }
    
    //-------------------------------------------------------------------------------------------------------------------
    // XHTML du nom du menu et de ses infos
    $xhtml_info  = htmlentities(empty($ligne->gm_nom) ? ADME_LG_PARENTHESE_OUVRANTE.$ligne->gm_nom.ADME_LG_PARENTHESE_FERMANTE : $ligne->gm_nom);
    $xhtml_info .= '&nbsp;';
    if (!isset($ligne_app->gap_nom)) {
    	$gap_nom='';
    }
    else  {
    	$gap_nom=$ligne_app->gap_nom;
    }
    $xhtml_info .= ADME_LG_PARENTHESE_OUVRANTE.$gap_nom.'&nbsp;'.ADME_LG_SLASH.'&nbsp;'.$ligne->ga_prenom.ADME_LG_PARENTHESE_FERMANTE;
    $xhtml_info .= '&nbsp;'."\n";
    
    //-------------------------------------------------------------------------------------------------------------------
    // XHTML actions
    $url->removeQueryString('adme_action');
    
    $url->addQueryString('adme_action', ADME_LG_ACTION_CLASSIQUE_MODIFIER);
    $xhtml_action = '<a href="'.$url->getURL().'" title="'.ADME_LG_ACTION_CLASSIQUE_MODIFIER_TITLE.'">'.
                        '<img class="'.ADME_CLASS_IMG_ICONE.'" src="'.ADME_IMAGE_VOIR.'" alt="'.ADME_LG_ACTION_CLASSIQUE_MODIFIER_ALT.'" />'.
                    '</a>&nbsp;'."\n";
    $url->removeQueryString('adme_action');
    if (!$est_traduction) {
    	$url->addQueryString('adme_action', ADME_LG_ACTION_CLASSIQUE_MONTER);
    	$xhtml_action .=    '<a href="'.$url->getURL().'" title="'.ADME_LG_ACTION_CLASSIQUE_MONTER_TITLE.'">'.
        	                    '<img class="'.ADME_CLASS_IMG_ICONE.'" src="'.ADME_IMAGE_FLECHE_HAUT.'" alt="'.ADME_LG_ACTION_CLASSIQUE_MONTER_ALT.'" />'.
            	            '</a>&nbsp;'."\n";
    	$url->removeQueryString('adme_action');
    	$url->addQueryString('adme_action', ADME_LG_ACTION_CLASSIQUE_DESCENDRE);
    	$xhtml_action .=    '<a href="'.$url->getURL().'" title="'.ADME_LG_ACTION_CLASSIQUE_DESCENDRE_TITLE.'">'.
        	                    '<img class="'.ADME_CLASS_IMG_ICONE.'" src="'.ADME_IMAGE_FLECHE_BAS.'" alt="'.ADME_LG_ACTION_CLASSIQUE_DESCENDRE_ALT.'" />'.
            	            '</a>&nbsp;'."\n";
                        
		$url->addQueryString('adme_action',ADME_LG_ACTION_CLASSIQUE_DIMINUER);
    	$xhtml_action .=    '<a href="'.$url->getURL().'" title="'.ADME_LG_ACTION_CLASSIQUE_DIMINUER_TITLE.'">'.
        	                    '<img class="'.ADME_CLASS_IMG_ICONE.'" src="'.ADME_IMAGE_FLECHE_GAUCHE.'" alt="'.ADME_LG_ACTION_CLASSIQUE_DIMINUER_ALT.'" />'.
            	            '</a>&nbsp;'."\n";
    	$url->removeQueryString('adme_action');
    	$url->addQueryString('adme_action',ADME_LG_ACTION_CLASSIQUE_AUGMENTER);
    	$xhtml_action .=    '<a href="'.$url->getURL().'" title="'.ADME_LG_ACTION_CLASSIQUE_AUGMENTER_TITLE.'">'.
        	                    '<img class="'.ADME_CLASS_IMG_ICONE.'" src="'.ADME_IMAGE_FLECHE_DROITE.'" alt="'.ADME_LG_ACTION_CLASSIQUE_AUGMENTER_ALT.'" />'.
            	            '</a>&nbsp;'."\n";
    }
    $url->removeQueryString('adme_action');
    if (!$est_traduction) {
    $url->addQueryString('adme_action', ADME_LG_ACTION_CLASSIQUE_SUPPRIMER);
    $xhtml_action .=    '<a href="'.$url->getURL().'" title="'.ADME_LG_ACTION_CLASSIQUE_SUPPRIMER_TITLE.'" onclick="javascript:return confirm(\''.ADME_LG_ACTION_SUPPRIMER_CONFIRMATION.'\');">'.
                            '<img class="'.ADME_CLASS_IMG_ICONE.'" src="'.ADME_IMAGE_SUPPRIMER.'" alt="'.ADME_LG_ACTION_CLASSIQUE_SUPPRIMER_ALT.'" />'.
                        '</a>&nbsp;'."\n";
    }
    else {
    	    $url->addQueryString('adme_action', ADME_LG_ACTION_CLASSIQUE_SUPPRIMER_TRADUCTION);
    		$xhtml_action .=    '<a href="'.$url->getURL().'" title="'.ADME_LG_ACTION_CLASSIQUE_SUPPRIMER_TRADUCTION_TITLE.'" onclick="javascript:return confirm(\''.ADME_LG_ACTION_SUPPRIMER_CONFIRMATION.'\');">'.
                           		'<img class="'.ADME_CLASS_IMG_ICONE.'" src="'.ADME_IMAGE_SUPPRIMER.'" alt="'.ADME_LG_ACTION_CLASSIQUE_SUPPRIMER_TRADUCTION_ALT.'" />'.
                        		'</a>&nbsp;'."\n";
    	
    }
    $url->removeQueryString('adme_action');
    
    if (!$est_traduction) {
	    $url->addQueryString('adme_action', ADME_LG_ACTION_CLASSIQUE_AJOUTER);
	    $xhtml_action .=    '<a href="'.$url->getURL().'" title="'.ADME_LG_ACTION_CLASSIQUE_AJOUTER_TITLE.'">'.
	                            '<img class="'.ADME_CLASS_IMG_ICONE.'" src="'.ADME_IMAGE_NOUVEAU.'" alt="'.ADME_LG_ACTION_CLASSIQUE_AJOUTER_ALT.'" />'.
	                        '</a>'.'&nbsp;'."\n";
    }
    	                        
    $url->removeQueryString('adme_action');
    
    // Si le menu � une application li�e on regarde s'il y a une interface d'administration.
    if (!isset($ligne_app->gap_id_application)) {
    	$gap_id_application=0;
    }
    else  {
    	$gap_id_application=$ligne_app->gap_id_application;
    }
    
    if ($gap_id_application != 0 && GEN_verifierPresenceInterfaceAdmin($db, $gap_id_application)) {
        $url->removeQueryString('adme_action');
        $url->addQueryString('adme_action', ADME_LG_ACTION_ADMINISTRER);
        $xhtml_action .=    '<a href="'.$url->getURL().'" title="'.ADME_LG_ACTION_ADMINISTRER_TITLE.'">'.
                                '<img class="'.ADME_CLASS_IMG_ICONE.'" src="'.ADME_IMAGE_TEXTE.'" alt="'.ADME_LG_ACTION_ADMINISTRER_ALT.'" />'.
                            '</a>'.'&nbsp;'."\n";
    }
    
    if (!$est_traduction) {
    	
			            
			 $requete_traduction =   'SELECT gmr_id_menu_02,  gm_ce_i18n '.
			                                    'FROM  gen_menu_relation, gen_menu '.
			                                    'WHERE '.$adme_menu_id.' = gmr_id_menu_01 ' .
			                                    'AND  gmr_id_menu_02  = gm_id_menu   '.
			                                    'AND  gmr_id_valeur  = 2 ';// 2 = "avoir traduction"
			                
			$resultat_traduction = $db->query($requete_traduction);
			 (DB::isError($resultat_traduction))             ? die(BOG_afficherErreurSql(__FILE__, __LINE__, $resultat_traduction->getMessage(), $requete_traduction))
			                : '';
			
	
    	
			    $url->addQueryString('adme_action',ADME_LG_ACTION_CLASSIQUE_TRADUIRE);
			    $xhtml_action .=    '<a href="'.$url->getURL().'" title="'.ADME_LG_ACTION_CLASSIQUE_TRADUIRE_TITLE.'">'.
	                        ADME_LG_ACTION_CLASSIQUE_TRADUIRE_ALT.
	                        '</a>&nbsp;'."\n";
	                        

// Restriction possible � une langue si pas traduit 	    				                                   

				if ($resultat_traduction->numRows() == 0 ) {

		    	$requete_lang =  'SELECT * FROM gen_i18n ';
        	        

		        $resultat_lang = $db->query($requete_lang);
		    	(DB::isError($resultat_lang)) ? die(BOG_afficherErreurSql(__FILE__, __LINE__, $resultat_lang->getMessage(), $requete_lang)) : '';
    
        
        		$requete_restriction =    'SELECT gmr_id_menu_02 '.
			                                    'FROM  gen_menu_relation '.
			                                    'WHERE '.$adme_menu_id.' = gmr_id_menu_01 ' .
			                                    'AND  gmr_id_valeur  = 106 ';// 106 restriction de menu
				$resultat_restriction = $db->query($requete_restriction);
				(DB::isError($resultat_restriction))             ? die(BOG_afficherErreurSql(__FILE__, __LINE__, $resultat_restriction->getMessage(), $requete_restriction))
				: '';
	
								                                   
				if ($resultat_restriction->numRows() == 0 ) {
					$restriction=0;
				}
				else {
					$restriction=1;
				}
					
			   while ($ligne_lang = $resultat_lang->fetchRow(DB_FETCHMODE_OBJECT) ) {
			   	  if (($restriction) && ($ligne->gm_ce_i18n==$ligne_lang->gi_id_i18n)) {
			   	  	 $url->addQueryString('adme_action',ADME_LG_ACTION_CLASSIQUE_OUVRIR);
			   	  	 $url->addQueryString('zone',$ligne_lang->gi_id_i18n);
				    $xhtml_action .=    '<i><b><a href="'.$url->getURL().'" title="'.ADME_LG_ACTION_CLASSIQUE_OUVRIR_TITLE.'">'.
				    		$ligne_lang->gi_id_i18n.
	                        '</a></b></i>&nbsp;'."\n";
			   	  	
			   	  }
			   	  else  {
	  				    $url->addQueryString('adme_action',ADME_LG_ACTION_CLASSIQUE_LIMITER);
  					    $url->addQueryString('zone',$ligne_lang->gi_id_i18n);
					    $xhtml_action .=    '<a href="'.$url->getURL().'" title="'.ADME_LG_ACTION_CLASSIQUE_LIMITER_TITLE.'">'.
								$ligne_lang->gi_id_i18n.
	            	            '</a>&nbsp;'."\n";
	            	
			   	  }
		        }
				
				
				                                   
			}
				
                            
    }
	else {
		if ($menu_traduction_defaut==$adme_menu_id) {
	        $xhtml_action .=    '<img class="'.ADME_CLASS_IMG_ICONE.'" src="'.ADME_IMAGE_TRADUCTION_DEFAUT_AFFICHAGE.'" alt="'.ADME_LG_ACTION_CLASSIQUE_TRADUCTION_DEFAUT_ALT.'" />'.
                            '&nbsp;'."\n";
		}
		else {
				$url->removeQueryString('adme_action');
        		$url->addQueryString('adme_action', ADME_LG_ACTION_CLASSIQUE_TRADUCTION_DEFAUT);
        		$xhtml_action .=    '<a href="'.$url->getURL().'" title="'.ADME_LG_ACTION_CLASSIQUE_TRADUCTION_DEFAUT_TITLE.'">'.
                                '<img class="'.ADME_CLASS_IMG_ICONE.'" src="'.ADME_IMAGE_TRADUCTION_DEFAUT.'" alt="'.ADME_LG_ACTION_CLASSIQUE_TRADUCTION_DEFAUT_ALT.'" />'.
                            '</a>'.'&nbsp;'."\n";
        
		}
	}    
	    
    $xhtml_traduction='';
    
//    $id_langue = $GLOBALS['_GEN_commun']['i18n'];
            
    $requete_traduction =   'SELECT gmr_id_menu_02,  gm_ce_i18n '.
			                                    'FROM  gen_menu_relation, gen_menu '.
			                                    'WHERE '.$adme_menu_id.' = gmr_id_menu_01 ' .
			                                    'AND  gmr_id_menu_02  = gm_id_menu   '.
			                                    'AND  gmr_id_valeur  = 2 ';// 2 = "avoir traduction"
			                
	$resultat_traduction = $db->query($requete_traduction);
			        (DB::isError($resultat_traduction))             ? die(BOG_afficherErreurSql(__FILE__, __LINE__, $resultat_traduction->getMessage(), $requete_traduction))
			                : '';
	
	if ($resultat_traduction->numRows() > 0 ) {
	
			$requete_traduction_defaut =    'SELECT gmr_id_menu_02 '.
			                                    'FROM  gen_menu_relation '.
			                                    'WHERE '.$adme_menu_id.' = gmr_id_menu_01 ' .
			                                    'AND  gmr_id_valeur  = 105 ';// 105 traduction par defaut
			$resultat_traduction_defaut = $db->query($requete_traduction_defaut);
			(DB::isError($resultat_traduction_defaut))             ? die(BOG_afficherErreurSql(__FILE__, __LINE__, $resultat_traduction->getMessage(), $requete_traduction_defaut))
			: '';
				                                   
				                                   
			if ($resultat_traduction_defaut->numRows() == 0 ) {
                $menu_traduction_defaut=0;
                $xhtml_action .=    '<img class="'.ADME_CLASS_IMG_ICONE.'" src="'.ADME_IMAGE_TRADUCTION_DEFAUT_AFFICHAGE.'" alt="'.ADME_LG_ACTION_CLASSIQUE_TRADUCTION_DEFAUT_ALT.'" />'.
                            '&nbsp;'."\n";
			}
			else {
				
				
				$ligne_traduction_defaut = $resultat_traduction_defaut->fetchRow(DB_FETCHMODE_OBJECT);
				$menu_traduction_defaut=$ligne_traduction_defaut->gmr_id_menu_02;
				
				if ($menu_traduction_defaut!=$adme_menu_id) {
					$url->removeQueryString('adme_action');
        			$url->addQueryString('adme_action', ADME_LG_ACTION_CLASSIQUE_TRADUCTION_DEFAUT);
        			$xhtml_action .=    '<a href="'.$url->getURL().'" title="'.ADME_LG_ACTION_CLASSIQUE_TRADUCTION_DEFAUT_TITLE.'">'.
                    	            '<img class="'.ADME_CLASS_IMG_ICONE.'" src="'.ADME_IMAGE_TRADUCTION_DEFAUT.'" alt="'.ADME_LG_ACTION_CLASSIQUE_TRADUCTION_DEFAUT_ALT.'" />'.
                        	    '</a>'.'&nbsp;'."\n";
				}
				else {
				   $xhtml_action .=    '<img class="'.ADME_CLASS_IMG_ICONE.'" src="'.ADME_IMAGE_TRADUCTION_DEFAUT_AFFICHAGE.'" alt="'.ADME_LG_ACTION_CLASSIQUE_TRADUCTION_DEFAUT_ALT.'" />'.
                            '&nbsp;'."\n";
					
				}
				
			}
			
			while ($ligne_resultat = $resultat_traduction->fetchRow(DB_FETCHMODE_OBJECT)) {
					$xhtml_traduction.="<br><em>".$ligne_resultat->gm_ce_i18n.":&nbsp;".ADME_retournerXhtmlMenuClassique($db, $url, $adme_site_id, $ligne_resultat->gmr_id_menu_02, 0,true,$menu_traduction_defaut)."</em>";
			
			}
			
			
	} 
	
	

    //-------------------------------------------------------------------------------------------------------------------
    // Envoi du menu.
    //-------------------------------------------------------------------------------------------------------------------
    
    
    $retour = $xhtml_pd.$xhtml_info.$xhtml_action.$xhtml_traduction;
    
    return $retour;
}

/** Fonction ADME_ajouterMenuClassique() - Ajoute un sous menu au menu courant
*
* Cette fonction permet d'ajouter un sous-menu de type "classique" au menu courant.
* Ancien nom : addMenu()
*
* @param  object objet Pear de connection � la base de donn�es.
* @param  object objet Pear d'authentification.
* @param  integer l'identifiant du site � administrer.
* @param  integer l'identifiant du menu � administrer.
* @return void le menu classique est ajout� � la base de donn�es.
*/
function ADME_ajouterMenuClassique($db, $auth, $adme_site_id, $adme_menu_id) 
{
	
	$url=$GLOBALS['_GEN_commun']['url'];
	$url->removeQueryString('adme_action');
	
    //----------------------------------------------------------------------------
    // R�cup�ration d'infos sur le site principal.
    $objet_site = GEN_lireInfoSitePrincipal($db, $adme_site_id);
    if ($objet_site == false) {
        die('ERREUR G�n�sia Administrateur de Menus : impossible de lire les infos du site.<br />'.
            'ID du site : '.$adme_site_id.'<br />'.
            'Ligne n� : '. __LINE__ .'<br />'.
            'Fichier n� : '. __FILE__ .'<br />');
    }
    
    $nouveau_id_menu = SQL_obtenirNouveauId($db, 'gen_menu', 'gm_id_menu');
    $auteur = $auth->getAuthData('ga_prenom').' '.$auth->getAuthData('ga_nom');
    
    //----------------------------------------------------------------------------
    // Ajout du nouveau menu
    $requete =  'INSERT INTO gen_menu '.
                'SET gm_id_menu = '.$nouveau_id_menu.', '.
                'gm_ce_site = '.$adme_site_id.', '.
                'gm_ce_i18n = "'.$objet_site->gs_ce_i18n.'", '.
                'gm_ce_application = 0, '.
                'gm_code_num = '.$nouveau_id_menu.', '.
                'gm_code_alpha = "menu_'.$nouveau_id_menu.'", '.
                'gm_nom = "menu_'.$nouveau_id_menu.'", '.
                'gm_titre = "menu_'.$nouveau_id_menu.'", '.
                'gm_description_resume = "menu_'.$nouveau_id_menu.'", '.
                'gm_auteur = "'.$auteur.'", '.
                'gm_editeur = "'.$objet_site->gs_auteur.'", '.
                'gm_date_creation = "'.date('Y-m-d H:i:s').'", '.
                'gm_date_soumission = "'.date('Y-m-d H:i:s').'", '.
                'gm_date_acceptation = "'.date('Y-m-d H:i:s').'", '.
                'gm_date_publication = "'.date('Y-m-d H:i:s').'", '.
                'gm_date_debut_validite = "'.date('Y-m-d H:i:s').'", '.
                'gm_date_fin_validite = "0000-00-00 00:00:00", '.
                'gm_date_copyright = "'.date('Y-00-00 00:00:00').'", '.
                'gm_categorie = "menu", '.
                'gm_ce_admin = '.$auth->getAuthData('ga_id_administrateur').' '
                ;
    
    $resultat = $db->query($requete);
    (DB::isError($resultat)) ? die(BOG_afficherErreurSql(__FILE__, __LINE__, $resultat->getMessage(), $requete)) : '';
    
    //----------------------------------------------------------------------------
    // Ajout de la relation "p�re"
    
    if (!isset($adme_menu_id) && empty($adme_menu_id)) {
        $adme_menu_id = 0 ;// Identifiant du p�re
    }
    //----------------------------------------------------------------------------
    // R�cup�ration d'infos sur la hierarchie du menu
    $requete =  'SELECT GMR01.gmr_ordre '.
                'FROM gen_menu_relation AS GMR01, gen_menu_relation AS GMR02 '.
                'WHERE GMR01.gmr_id_menu_02 = '.$adme_menu_id.' '.
                'AND GMR01.gmr_id_valeur = 1 '.// 1 = avoir "p�re"
                'AND GMR02.gmr_id_menu_01 = GMR01.gmr_id_menu_01 '.
                'AND GMR02.gmr_id_menu_01 = GMR02.gmr_id_menu_02 '.
                'AND GMR02.gmr_id_valeur = 100 '.// 100 = menu type "classique"
                'ORDER BY GMR01.gmr_ordre DESC';
    
    $resultat = $db->query($requete);
    (DB::isError($resultat)) ? die(BOG_afficherErreurSql(__FILE__, __LINE__, $resultat->getMessage(), $requete)) : '';
    
    $ligne = $resultat->fetchRow(DB_FETCHMODE_OBJECT);
    $nouveau_ordre_menu = $ligne->gmr_ordre + 1;
    $resultat->free();
    
    $requete =  'INSERT INTO gen_menu_relation '.
                'SET gmr_id_menu_02 = '.$adme_menu_id.', '.
                'gmr_id_menu_01 = '.$nouveau_id_menu.', '.
                'gmr_id_valeur = 1, '.
                'gmr_ordre = '.$nouveau_ordre_menu;
    
    $resultat = $db->query($requete);
    (DB::isError($resultat)) ? die(BOG_afficherErreurSql(__FILE__, __LINE__, $resultat->getMessage(), $requete)) : '';
    
    //----------------------------------------------------------------------------
    // Ajout de la relation-type "menu classique"
    
    // R�cup�ration d'infos sur la hierarchie du menu
    $requete =  'SELECT * '.
                'FROM gen_menu_relation, gen_menu '.
                'WHERE gmr_id_menu_02 = gmr_id_menu_01 '.
                'AND gmr_id_valeur = 100 '.// 100 = type menu "classique"
                'AND gmr_id_menu_01 = gm_id_menu '.
                'AND gm_ce_site = '.$adme_site_id.' '.
                'ORDER BY gmr_ordre DESC';
    
    $resultat = $db->query($requete);
    (DB::isError($resultat)) ? die(BOG_afficherErreurSql(__FILE__, __LINE__, $resultat->getMessage(), $requete)) : '';
    
    $ligne = $resultat->fetchRow(DB_FETCHMODE_OBJECT);
    $nouveau_ordre_menu_classique = $ligne->gmr_ordre + 1;
    $resultat->free();
    
    $requete =  'INSERT INTO gen_menu_relation '.
                'SET gmr_id_menu_01 = '.$nouveau_id_menu.', '.
                'gmr_id_menu_02 = '.$nouveau_id_menu.', '.
                'gmr_id_valeur = 100, '.
                'gmr_ordre = '.$nouveau_ordre_menu_classique;
    
    $result = $db->query($requete);
    (DB::isError($result)) ? die(BOG_afficherErreurSql(__FILE__, __LINE__, $result->getMessage(), $requete)) : '';
}

/** Fonction ADME_afficherFormMenuClassique() - Affiche le formulaire pour un menu classique
*
* Utilise HTML_QuickForm pour g�n�rer le formulaire.
* Ancien nom : showMenu()
*
* @param  object  objet Pear de connection � la base de donn�es.
* @param  object objet Pear repr�sentant l'url de base.
* @param  integer l'identifiant du site � administrer.
* @param  integer l'identifiant du menu � administrer.
* @param  array le tableau associatif des valeurs � afficher dans le formulaire.
* @return  string  le formulaire XHTML.
*/
function ADME_afficherFormMenuClassique($db, $url, $adme_site_id, $adme_menu_id, $aso_valeurs,$traduction=FALSE)
{
    // Initialisation de variable
    $url->addQueryString('adme_site_id', $adme_site_id);
    $url->addQueryString('adme_menu_id', $adme_menu_id);
    $script = 'function switchMenu(obj) {
		var el = document.getElementById(obj);
		if(el.style.display != "block")
		{
			el.style.display = "block";
		}
		else
		{
			el.style.display = "none";
		}
	}';
    GEN_stockerCodeScript($script);
    // Nous sommes toujours en modification car un menu est ajout� automatiquement!
    // R�cup�ration des informations du menu concern�.
    if (!isset($aso_valeurs[ADME_LG_ACTION_CLASSIQUE_VERIFIER]) && !isset($aso_valeurs[ADME_LG_ACTION_CLASSIQUE_VERIFIER_TRADUCTION])) {
        $aso_valeurs = GEN_lireInfoMenu($db, $adme_menu_id, DB_FETCHMODE_ASSOC);
        if ($aso_valeurs === false) {
            die('ERREUR Papyrus Administrateur de Menus : '.ADME_LG_ERREUR_INFO_MENU.'<br />'.
                'Idenitifiant du menu n� : '. $adme_menu_id .'<br />'.
                'Ligne n� : '. __LINE__ .'<br />'.
                'Fichier n� : '. __FILE__ .'<br />');
        }
        // Requete pour r�cup�rer les informations issues des relations du site � modifier
        $ligne = GEN_lireInfoMenuRelation($db, $adme_menu_id, $id_valeur = 101);
        $aso_valeurs['defaut'] = false;
        if (isset($ligne) && !empty($ligne)) {
		    if ($ligne->gmr_id_valeur != false) {// 101 = site par d�faut
		        $aso_valeurs['defaut'] = true;
		    }
        }
    }
    
    // Titre de la page
   
    if ($traduction) {
    	$retour = '<h1>'.ADME_LG_FORM_MENU_CLASSIQUE_TITRE_GENERAL_TRADUCTION.'</h1>'."\n";
    }
    else {
    	$retour = '<h1>'.ADME_LG_FORM_MENU_CLASSIQUE_TITRE_GENERAL.'</h1>'."\n";
    }

	$retour .= '<p class="adme_menu_id" >'.ADME_LG_FORM_MENU_ID.'<span id="adme_menu_id">'.$aso_valeurs['gm_id_menu'].'</span></p>'."\n";    
    
    // Cr�ation du formulaire
    // Notes : Quickform semble remplacer les & des &amp; � nouveau par des &amp; solution utiliser str_replace()...
    $form = new HTML_QuickForm('form_menu_classique', 'post', str_replace('&amp;', '&', $url->getUrl()));
    $tab_index = 1000;
    $squelette =& $form->defaultRenderer();
    $squelette->setFormTemplate("\n".'<form {attributes}>'."\n".'{content}'."\n".'</form>'."\n");
	$squelette->setElementTemplate( '<p class="formulaire_element"><span class="form_label">'."\n".
		'{label}'."\n".
		'<!-- BEGIN required --><span style="color:red; width:5px; margin:0; padding:0;">*</span><!-- END required -->'."\n".		
		'</span>'."\n".'{element}'."\n".
		'<!-- BEGIN error --><span class="erreur">{error}</span><!-- END error -->'."\n".
		'</p>'."\n");
	$squelette->setGroupElementTemplate('<p style="display:inline">{element}</p>', 'form_boutons');
	$squelette->setRequiredNoteTemplate("\n".'<p class="symbole_obligatoire">*&nbsp;:&nbsp;{requiredNote}</p>'."\n");
	//Note pour les erreurs javascript
	$form->setJsWarnings('Erreur de saisie', 'Veuillez verifier vos informations saisies');
    // Note de fin de formulaire
    $form->setRequiredNote(ADME_LG_FORM_TXT_CHP_OBLIGATOIRE);

    $partie_menu_debut = '<fieldset>'."\n".'<legend>'.ADME_LG_FORM_MENU_CLASSIQUE_TITRE_CONFIG.'</legend>'."\n";
    $form->addElement('html', $partie_menu_debut);
    
    $id = 'gm_code_alpha';
    $aso_attributs = array('id'=> $id, 'tabindex' => $tab_index++, 'size' => 35, 'maxlength' => 50);
    $label = '<label for="'.$id.'">'.ADME_LG_FORM_MENU_CODE_ALPHA.'</label>';
    $form->addElement('text', $id, $label, $aso_attributs);
    $form->addRule($id, ADME_LG_FORM_MENU_REGLE_CODE_ALPHA, 'required', '', 'client');
    
    $id = 'gm_nom';
    $aso_attributs = array('id'=> $id, 'tabindex' => $tab_index++, 'size' => 35, 'maxlength' => 100);
    $label = '<label for="'.$id.'">'.ADME_LG_FORM_MENU_NOM.'</label>';
    $form->addElement('text', $id, $label, $aso_attributs);
    $form->addRule($id, ADME_LG_FORM_MENU_REGLE_NOM, 'required', '', 'client');
    $form->applyFilter($id, 'trim');
    
    $id = 'gm_description_resume';
    $aso_attributs = array('id'=> $id, 'tabindex' => $tab_index++, 'rows' => 2, 'cols' => 50);
    $label = '<label for="'.$id.'">'.ADME_LG_FORM_MENU_INFO_BULLE.'</label>';
    $form->addElement('textarea', $id, $label, $aso_attributs);
    $form->addRule($id, ADME_LG_FORM_MENU_REGLE_INFO_BULLE, 'required', '', 'client');
    
    // Requ�te sur les applications
    $requete =  'SELECT gap_id_application, gap_nom '.
                'FROM gen_application '.
                'WHERE gap_bool_applette = 0 '.
                'ORDER BY gap_nom ASC';// Pour �viter d'afficher les applettes.
    $resultat = $db->query($requete);
    (DB::isError($resultat)) ? die(BOG_afficherErreurSql(__FILE__, __LINE__, $resultat->getMessage(), $requete)) : '';
    
    $aso_options = array();
    while ($ligne = $resultat->fetchRow(DB_FETCHMODE_OBJECT)) {
        $aso_options[$ligne->gap_id_application] = $ligne->gap_nom;
    }
    $resultat->free();
    $id = 'gm_ce_application';
    $aso_attributs = array('id'=> $id, 'tabindex' => $tab_index++);
    $label = '<label for="'.$id.'">'.ADME_LG_FORM_MENU_APPLI.'</label>';
    $form->addElement('select', $id, $label, $aso_options, $aso_attributs);
    
    
    if ($traduction) {
    	
    	// Recherche liste des menu deja traduits 
    		
	   	$requete =  'SELECT distinct gm_ce_i18n  '.
        	        'FROM gen_menu_relation, gen_menu '.
            	    'WHERE gmr_id_menu_01  = ' . $adme_menu_id .' '.
                	'AND gm_id_menu  = gmr_id_menu_02  '.
                	'AND gmr_id_valeur = 2  '; // 2 = "avoir traduction"
	
	  	$resultat = $db->query($requete) ;
	  	
	    if (DB::isError($resultat)) {
	        die( BOG_afficherErreurSql(__FILE__, __LINE__, $resultat->getMessage(), $requete) );
	    }
	    
	    $not_in_langue='';
	    if ( $resultat->numRows() == 0 ) {
			$not_in_langue="gi_id_i18n not in('".$aso_valeurs['gm_ce_i18n']."')";    
	    }
	    else {
	    	    while ($ligne = $resultat->fetchRow(DB_FETCHMODE_OBJECT)) {
 					$not_in_langue="'".$ligne->gm_ce_i18n."'".",".$not_in_langue;
 					$end="'".$ligne->gm_ce_i18n."'";
				}
	    		if ($not_in_langue) {
			    			$not_in_langue="'".$aso_valeurs['gm_ce_i18n']."'".",".$not_in_langue;
			    			$not_in_langue=' gi_id_i18n not in('.$not_in_langue.$end.')';
			    }
	    		else {
	    			$not_in_langue="gi_id_i18n not in('".$aso_valeurs['gm_ce_i18n']."')";
	    		}
	    }
	    
	   					
	    
		$resultat->free();		    
    	
    	$requete =  "SELECT * FROM gen_i18n where ".$not_in_langue;
    	
    	/*$requete =  'SELECT * '.
        	        'FROM gen_i18n ';*/
        	        
        $resultat = $db->query($requete);
    	(DB::isError($resultat)) ? die(BOG_afficherErreurSql(__FILE__, __LINE__, $resultat->getMessage(), $requete)) : '';
    
    	$aso_options = array();
        while ($ligne = $resultat->fetchRow(DB_FETCHMODE_OBJECT) ) {
        	$aso_options[$ligne->gi_id_i18n] = $ligne->gi_id_i18n;
        }
        $resultat->free();
    	$id = 'gs_ce_i18n';
    	$aso_attributs = array('id' => $id, 'tabindex' => $tab_index++);
    	$label = '<label for="'.$id.'">'.'Langue : '.'</label>';
    	$form->addElement('select', $id, $label, $aso_options, $aso_attributs);
    }
    
    $id = 'gm_titre';
    $aso_attributs = array('id'=> $id, 'tabindex' => $tab_index++, 'size' => 35, 'maxlength' => 255);
    $label = '<label for="'.$id.'">'.ADME_LG_FORM_MENU_TITRE.'</label>';
    $form->addElement('text', $id, $label, $aso_attributs);
    
    $id = 'gm_mots_cles';
    $aso_attributs = array('id'=> $id, 'tabindex' => $tab_index++, 'rows' => 3, 'cols' => 50);
    $label = '<label for="'.$id.'">'.ADME_LG_FORM_MENU_MOT_CLE.'</label>';
    $form->addElement('textarea', $id, $label, $aso_attributs);
    
    $id = 'gm_description_libre';
    $aso_attributs = array('id'=> $id, 'tabindex' => $tab_index++, 'rows' => 3, 'cols' => 45);
    $label = '<label for="'.$id.'">'.ADME_LG_FORM_MENU_DESCRIPTION.'</label>';
    $form->addElement('textarea', $id, $label, $aso_attributs);
        
    $partie_menu_fin = "\n".'</fieldset>'."\n";
    $form->addElement('html', $partie_menu_fin);
    
    //Lien javascript pour cacher les options compliqu�es
    $form->addElement('html', '<a href="#" onclick="switchMenu(\'config_avancee\');" title="'.ADME_VOIR_CONFIG_AVANCEE.'">'.ADME_VOIR_CONFIG_AVANCEE.'</a><br />'."\n");
    
    //d�but de la div cach�e pour les options compliqu�es-----------------------------------------------
    $form->addElement('html', '<div id="config_avancee" style="display:none;">');
    $partie_entete_debut = '<fieldset>'."\n".'<legend>'.ADME_CONFIG_AVANCEE.'</legend>'."\n";
    $form->addElement('html', $partie_entete_debut);
    
    $id = 'gm_code_num';
    $aso_attributs = array('id'=>$id, 'tabindex' => $tab_index++, 'size' => 5, 'maxlength' => 100);
    $label = '<label for="'.$id.'">'.ADME_LG_FORM_MENU_CODE_NUM.'</label>';
    $form->addElement('text', $id, $label, $aso_attributs);
    $form->addRule($id, ADME_LG_FORM_MENU_REGLE_CODE_NUM, 'required', '', 'client');
    
    $id = 'gm_raccourci_clavier';
    $aso_attributs = array('id'=> $id, 'tabindex' => $tab_index++, 'size' => 1, 'maxlength' => 1);
    $label = '<label for="'.$id.'">'.ADME_LG_FORM_MENU_RACCOURCI.'</label>';
    $form->addElement('text', $id, $label, $aso_attributs);
    
    $id = 'defaut';
    $aso_attributs = array('id'=> $id, 'tabindex' => $tab_index++);
    if ($aso_valeurs[$id] === true) {
        $aso_attributs['checked'] = 'checked';
    }
    $label = '<label for="'.$id.'">'.ADME_LG_FORM_MENU_DEFAUT.'</label>';
    $form->addElement('checkbox', $id, $label, '', $aso_attributs);
    
    $id = 'gm_fichier_squelette';
    $aso_attributs = array('id'=> $id, 'tabindex' => $tab_index++, 'size' => 35, 'maxlength' => 255);
    $label = '<label for="'.$id.'">'.ADME_LG_FORM_MENU_FICHIER_SQUELETTE.'</label>';
    $form->addElement('text', $id, $label, $aso_attributs);
    
    $id = 'gm_application_arguments';
    $aso_attributs = array('id'=> $id, 'tabindex' => $tab_index++, 'size' => 35, 'maxlength' => 255);   
    $label = '<label for="'.$id.'">'.ADME_LG_FORM_MENU_APPLI_ARGUMENT.'</label>';
    $form->addElement('text', $id, $label, $aso_attributs);
    
    $id = 'gm_robot';
    $aso_options = array(   'index,follow' => ADME_LG_FORM_MENU_INDEX_FOLLOW,
                            'index' => ADME_LG_FORM_MENU_INDEX,
                            'noindex' => ADME_LG_FORM_MENU_NOINDEX,
                            'noindex,nofollow' => ADME_LG_FORM_MENU_NOINDEX_NOFOLLOW,
                            '' => ADME_LG_FORM_MENU_INDEX_VIDE);
    $aso_attributs = array('id'=> $id, 'tabindex' => $tab_index++);
    $label = '<label for="'.$id.'">'.ADME_LG_FORM_MENU_ROBOT.'</label>';
    $form->addElement('select', $id, $label, $aso_options, $aso_attributs);
    
    $id = 'gm_titre_alternatif';
    $aso_attributs = array('id'=> $id, 'tabindex' => $tab_index++, 'size' => 35, 'maxlength' => 255);
    $label = '<label for="'.$id.'">'.ADME_LG_FORM_MENU_TITRE_ALTERNATIF.'</label>';
    $form->addElement('text', $id, $label, $aso_attributs);
    
    
    $id = 'gm_description_table_matieres';
    $aso_attributs = array('id'=> $id, 'tabindex' => $tab_index++, 'rows' => 3, 'cols' => 45);
    $label = '<label for="'.$id.'">'.ADME_LG_FORM_MENU_TABLE_MATIERE.'</label>';
    $form->addElement('textarea', $id, $label, $aso_attributs);
    
    $id = 'gm_source';
    $aso_attributs = array('id'=> $id, 'tabindex' => $tab_index++, 'size' => 35, 'maxlength' => 255);
    $label = '<label for="'.$id.'">'.ADME_LG_FORM_MENU_SOURCE.'</label>';
    $form->addElement('text', $id, $label, $aso_attributs);
    
    $id = 'gm_auteur';
    $aso_attributs = array('id'=> $id, 'tabindex' => $tab_index++, 'size' => 35, 'maxlength' => 255);
    $label = '<label for="'.$id.'">'.ADME_LG_FORM_MENU_AUTEUR.'</label>';
    $form->addElement('text', $id, $label, $aso_attributs);
    
    $id = 'gm_contributeur';
    $aso_attributs = array('id'=> $id, 'tabindex' => $tab_index++, 'rows' => 2, 'cols' => 45);
    $label = '<label for="'.$id.'">'.ADME_LG_FORM_MENU_CONTRIBUTEUR.'</label>';
    $form->addElement('textarea', $id, $label, $aso_attributs);
    
    $id = 'gm_editeur';
    $aso_attributs = array('id'=> $id, 'tabindex' => $tab_index++, 'size' => 35, 'maxlength' => 65000);
    $label = '<label for="'.$id.'">'.ADME_LG_FORM_MENU_EDITEUR.'</label>';
    $form->addElement('text', $id, $label, $aso_attributs);
    
    $id = 'gm_date_creation';
    $aso_attributs = array('id'=> $id, 'tabindex' => $tab_index++, 'size' => 19, 'maxlength' => 19);
    $label = '<label for="'.$id.'">'.ADME_LG_FORM_MENU_DATE_CREATION.'</label>';
    $form->addElement('text', $id, $label, $aso_attributs);
    
    $id = 'gm_date_debut_validite';
    $aso_attributs = array('id'=> $id, 'tabindex' => $tab_index++, 'size' => 19, 'maxlength' => 19);
    $label = '<label for="'.$id.'">'.ADME_LG_FORM_MENU_DATE_VALIDITE_DEBUT.'</label>';
    $form->addElement('text', $id, $label, $aso_attributs);
    
    $id = 'gm_date_fin_validite';
    $aso_attributs = array('id'=> $id, 'tabindex' => $tab_index++, 'size' => 19, 'maxlength' => 19);
    $label = '<label for="'.$id.'">'.ADME_LG_FORM_MENU_DATE_VALIDITE_FIN.'</label>';
    $form->addElement('text', $id, $label, $aso_attributs);
    
    $id = 'gm_date_copyright';
    $aso_attributs = array('id'=> $id, 'tabindex' => $tab_index++, 'size' => 19, 'maxlength' => 19);
    $label = '<label for="'.$id.'">'.ADME_LG_FORM_MENU_DATE_COPYRIGHT.'</label>';
    $form->addElement('text', $id, $label, $aso_attributs);
    
    $id = 'gm_licence';
    $aso_attributs = array('id'=> $id, 'tabindex' => $tab_index++, 'size' => 35, 'maxlength' => 255);
    $label = '<label for="'.$id.'">'.ADME_LG_FORM_MENU_URL_LICENCE.'</label>';
    $form->addElement('text', $id, $label, $aso_attributs);
    
    $id = 'gm_categorie';
    $aso_attributs = array('id'=> $id, 'tabindex' => $tab_index++, 'size' => 35, 'maxlength' => 100);
    $label = '<label for="'.$id.'">'.ADME_LG_FORM_MENU_CATEGORIE.'</label>';
    $form->addElement('text', $id, $label, $aso_attributs);
    
    $id = 'gm_public';
    $aso_attributs = array('id'=> $id, 'tabindex' => $tab_index++, 'size' => 35, 'maxlength' => 255);
    $label = '<label for="'.$id.'">'.ADME_LG_FORM_MENU_PUBLIC.'</label>';
    $form->addElement('text', $id, $label, $aso_attributs);
    
    $id = 'gm_public_niveau';
    $aso_attributs = array('id'=> $id, 'tabindex' => $tab_index++, 'size' => 25, 'maxlength' => 45);
    $label = '<label for="'.$id.'">'.ADME_LG_FORM_MENU_PUBLIC_NIVEAU.'</label>';
    $form->addElement('text', $id, $label, $aso_attributs);
    
    $id = 'gm_ce_type_portee_spatiale';
    $aso_options = array(   '' => ADME_LG_FORM_MENU_ZG_VIDE,
                            'iso3166' => ADME_LG_FORM_MENU_ZG_ISO,
                            'Point' => ADME_LG_FORM_MENU_ZG_POINT,
                            'Box' => ADME_LG_FORM_MENU_ZG_DC,
                            'TGN' => ADME_LG_FORM_MENU_ZG_GTGN);
    $aso_attributs = array('id'=> $id, 'tabindex' => $tab_index++);
    $label = '<label for="'.$id.'">'.ADME_LG_FORM_MENU_ZG_TYPE.'</label>';
    $form->addElement('select', $id, $label, $aso_options, $aso_attributs);
    
    $id = 'gm_portee_spatiale';
    $aso_attributs = array('id'=> $id, 'tabindex' => $tab_index++, 'size' => 35, 'maxlength' => 100);
    $label = '<label for="'.$id.'">'.ADME_LG_FORM_MENU_ZG_VALEUR.'</label>';
    $form->addElement('text', $id, $label, $aso_attributs);
    
    $id = 'gm_ce_type_portee_temporelle';
    $aso_options = array(   '' => ADME_LG_FORM_MENU_TMP_VIDE,
                            'W3CDTF' => ADME_LG_FORM_MENU_TMP_W3C,
                            'Period' => ADME_LG_FORM_MENU_TMP_DC);
    $aso_attributs = array('id'=> $id, 'tabindex' => $tab_index++);
    $label = '<label for="'.$id.'">'.ADME_LG_FORM_MENU_TMP_TYPE.'</label>';
    $form->addElement('select', $id, $label, $aso_options, $aso_attributs);
    
    $id = 'gm_portee_temporelle';
    $aso_attributs = array('id'=> $id, 'tabindex' => $tab_index++, 'size' => 35, 'maxlength' => 100);
    $label = '<label for="'.$id.'">'.ADME_LG_FORM_MENU_TMP_VALEUR.'</label>';
    $form->addElement('text', $id, $label, $aso_attributs);
  
    // Requete pour connaitre les informations sur l'administrateur ayant fait la derni�re modif
    if (!isset($aso_valeurs[ADME_LG_ACTION_CLASSIQUE_VERIFIER]) && !isset($aso_valeurs[ADME_LG_ACTION_CLASSIQUE_VERIFIER_TRADUCTION])) {
	    $requete_admin =    'SELECT * '.
    	                    'FROM gen_annuaire '.
        	                'WHERE ga_id_administrateur = '.$aso_valeurs['gm_ce_admin'];
    	$resultat_admin = $db->query($requete_admin);
    	if (DB::isError($resultat_admin)) {
	        die(BOG_afficherErreurSql(__FILE__, __LINE__, $resultat_admin->getMessage(), $requete_admin));
	    }
    	$ligne_admin = $resultat_admin->fetchRow(DB_FETCHMODE_OBJECT);
    	$info_admin =   '<p class="info">Derni�re modification par '.$ligne_admin->ga_prenom.' '.$ligne_admin->ga_nom.'</p>';
    	$form->addElement('html', $info_admin);
    }
    
    //fin de la div cach�e pour les options compliqu�es-------------------------------------------------
    $form->addElement('html', "\n".'</fieldset>'."\n".'</div>');
   
	
    $buttons[] = &HTML_QuickForm::createElement('link', 'annuler', ADME_LG_FORM_MENU_ANNULER, 
                 str_replace ("&amp;", "&", $url->getURL()), ADME_LG_FORM_MENU_ANNULER); // Le preg_replace contourne un pb de QuickForm et Net_URL
                                                                                         // qui remplacent deux fois les & par des &amp;
	//Bouton de validation du formulaire  
	if ($traduction) {
    	$buttons[] = &HTML_QuickForm::createElement('submit', ADME_LG_ACTION_CLASSIQUE_VERIFIER_TRADUCTION, ADME_LG_FORM_MENU_VALIDER);
		$form->addElement('hidden', 'adme_site_id', $adme_site_id);
    }    
    else {
    	$buttons[] = &HTML_QuickForm::createElement('submit', ADME_LG_ACTION_CLASSIQUE_VERIFIER, ADME_LG_FORM_MENU_VALIDER);
    }                                               
	$form->addGroup($buttons, 'form_boutons', null, '&nbsp;');
    
    $form->addElement('hidden', 'gm_id_menu', $aso_valeurs['gm_id_menu']);
    
    // Instanciation avec les valeur par d�faut
    $form->setDefaults($aso_valeurs);    
    
    $retour .= $form->toHTML()."\n";
    return $retour;
}

/** Fonction ADME_validerFormAjouterMenuClassique() - Valide les donn�es issues du formulaire pour gen_menu.
*
* Cette fonction valide les donn�es � ajouter dans la table gen_menu.
*
* @param  PEAR::DB   l'objet pear de connexion � la base de donn�es.
* @param  string   le tableau contenant les valeurs du formulaire.
* @return string   retourne les messages d'erreurs sinon rien.
*/
function ADME_validerFormAjouterMenuClassique($db, $aso_valeurs)
{
    $message = '';
    if ($aso_valeurs['gm_code_alpha'] == '') {
        $message .= '<p class="pap_erreur">'.ADME_LG_FORM_MENU_REGLE_CODE_ALPHA.'</p>';
    } 
    if ($aso_valeurs['gm_code_num'] == '') {
        $message .= '<p class="pap_erreur">'.ADME_LG_FORM_MENU_REGLE_CODE_NUM.'</p>';
    } 
    if ($aso_valeurs['gm_nom'] == '') {
        $message .= '<p class="pap_erreur">'.ADME_LG_FORM_MENU_REGLE_NOM.'</p>';
    }
    if ($aso_valeurs['gm_description_resume'] == '') {
        $message .= '<p class="pap_erreur">'.ADME_LG_FORM_MENU_REGLE_INFO_BULLE.'</p>';
    }
    return $message;
}


/** Fonction ADME_validerFormTraduireMenuClassique() - Valide les donn�es issues du formulaire de traduction de menu
*
* Cette fonction valide les donn�es � ajouter dans la table gen_menu.
*
* @param  PEAR::DB   l'objet pear de connexion � la base de donn�es.
* @param  string   le tableau contenant les valeurs du formulaire.
* @return string   retourne les messages d'erreurs sinon rien.
*/
function ADME_validerFormTraduireMenuClassique($db, $aso_valeurs)
{
    $message = '';
    if ($aso_valeurs['gm_code_alpha'] == '') {
        $message .= '<p class="pap_erreur">'.ADME_LG_FORM_MENU_REGLE_CODE_ALPHA.'</p>';
    } 
    if ($aso_valeurs['gm_code_num'] == '') {
        $message .= '<p class="pap_erreur">'.ADME_LG_FORM_MENU_REGLE_CODE_NUM.'</p>';
    } 
    if ($aso_valeurs['gm_nom'] == '') {
        $message .= '<p class="pap_erreur">'.ADME_LG_FORM_MENU_REGLE_NOM.'</p>';
    }
    if ($aso_valeurs['gm_description_resume'] == '') {
        $message .= '<p class="pap_erreur">'.ADME_LG_FORM_MENU_REGLE_INFO_BULLE.'</p>';
    }
    return $message;
}



/** Fonction ADME_modifierMenuClassique() - Met � jour les infos d'un menu classique
*
* Fonction modifiant un menu commun � Papyrus.
* Ancien nom : commitUpdateLevel()
*
* @param object objet Pear de connection � la base de donn�es.
* @param object objet Pear repr�sentant l'authentification.
* @param integer l'identifiant du menu � administrer.
* @param array le tableau des valeurs � modifier.
* @return void les changement sont fait dans la base de donn�es.
*/
function ADME_modifierMenuClassique($db, $auth, $adme_menu_id, $aso_valeurs)
{
    $requete =  'UPDATE gen_menu SET '.
                'gm_ce_application = '.$aso_valeurs['gm_ce_application'].', '.
                'gm_application_arguments = "'.$aso_valeurs['gm_application_arguments'].'", '.
                'gm_fichier_squelette = "'.$aso_valeurs['gm_fichier_squelette'].'", '.
                'gm_code_num = '.$aso_valeurs['gm_code_num'].', '.
                'gm_code_alpha = "'.$aso_valeurs['gm_code_alpha'].'", '.
                'gm_nom = "'.$aso_valeurs['gm_nom'].'", '.
                'gm_raccourci_clavier = "'.$aso_valeurs['gm_raccourci_clavier'].'", '.
                'gm_robot = "'.$aso_valeurs['gm_robot'].'", '.
                'gm_titre = "'.$aso_valeurs['gm_titre'].'", '.
                'gm_titre_alternatif = "'.$aso_valeurs['gm_titre_alternatif'].'", '.
                'gm_mots_cles = "'.$aso_valeurs['gm_mots_cles'].'", '.
                'gm_description_libre = "'.$aso_valeurs['gm_description_libre'].'", '.
                'gm_description_resume = "'.$aso_valeurs['gm_description_resume'].'", '.
                'gm_description_table_matieres = "'.$aso_valeurs['gm_description_table_matieres'].'", '.
                'gm_source = "'.$aso_valeurs['gm_source'].'", '.
                'gm_auteur = "'.$aso_valeurs['gm_auteur'].'", '.
                'gm_contributeur = "'.$aso_valeurs['gm_contributeur'].'", '.
                'gm_editeur = "'.$aso_valeurs['gm_editeur'].'", '.
                'gm_date_creation = "'.$aso_valeurs['gm_date_creation'].'", '.
                'gm_date_debut_validite = "'.$aso_valeurs['gm_date_debut_validite'].'", '.
                'gm_date_fin_validite = "'.$aso_valeurs['gm_date_fin_validite'].'", '.
                'gm_date_copyright = "'.$aso_valeurs['gm_date_copyright'].'", '.
                'gm_licence = "'.$aso_valeurs['gm_licence'].'", '.
                'gm_categorie = "'.$aso_valeurs['gm_categorie'].'", '.
                'gm_public = "'.$aso_valeurs['gm_public'].'", '.
                'gm_public_niveau = "'.$aso_valeurs['gm_public_niveau'].'", '.
                'gm_ce_type_portee_spatiale = "'.$aso_valeurs['gm_ce_type_portee_spatiale'].'", '.
                'gm_portee_spatiale = "'.$aso_valeurs['gm_portee_spatiale'].'", '.
                'gm_ce_type_portee_temporelle = "'.$aso_valeurs['gm_ce_type_portee_temporelle'].'", '.
                'gm_portee_temporelle = "'.$aso_valeurs['gm_portee_temporelle'].'", '.
                'gm_ce_admin = "'.$auth->getAuthData('ga_id_administrateur').'" '.
                'WHERE gm_id_menu = '.$adme_menu_id;
    
    $resultat = $db->query($requete);
    (DB::isError($resultat)) ? die(BOG_afficherErreurSql(__FILE__, __LINE__, $resultat->getMessage(), $requete)) : '';
    
    // Gestion de la relation menu par d�faut
    if (isset($aso_valeurs['defaut']) && $aso_valeurs['defaut'] == 1) {
        $requete_id_menu_supr_defaut =  'SELECT GM01.gm_id_menu AS id_menu_supr_defaut '.
                                        'FROM gen_menu AS GM01, gen_menu AS GM02, gen_menu_relation '.
                                        'WHERE GM02.gm_id_menu = '.$adme_menu_id.' '.
                                        'AND GM02.gm_ce_site = GM01.gm_ce_site '.
                                        'AND GM01.gm_id_menu = gmr_id_menu_01 '.
                                        'AND gmr_id_valeur = 101 ';// 101 = menu par "defaut"
        
        $resultat_menu_supr_defaut = $db->query($requete_id_menu_supr_defaut);
        if (DB::isError($resultat_menu_supr_defaut)) {
            die(BOG_afficherErreurSql(__FILE__, __LINE__, $resultat_menu_supr_defaut->getMessage(), $requete_id_menu_supr_defaut));
        }
        $ligne_menu_supr_defaut = $resultat_menu_supr_defaut->fetchRow(DB_FETCHMODE_OBJECT);
        if ($resultat_menu_supr_defaut->numRows() > 0 ) {
            $requete_supr_defaut =  'DELETE FROM gen_menu_relation '.
                                    'WHERE gmr_id_menu_01 = gmr_id_menu_02 '.
                                    'AND gmr_id_valeur = 101 '.// 101 = menu par "defaut"
                                    'AND gmr_id_menu_01 = '.$ligne_menu_supr_defaut->id_menu_supr_defaut;
            $resultat_supr_defaut = $db->query($requete_supr_defaut);
            if (DB::isError($resultat_supr_defaut)) {
                die(BOG_afficherErreurSql(__FILE__, __LINE__, $resultat_supr_defaut->getMessage(), $requete_supr_defaut));
            }
        }
        $resultat_menu_supr_defaut->free();
        
        
        // Requete d'insertion de la relation menu par d�faut
        $requete =  'INSERT INTO gen_menu_relation '.
                    'SET gmr_id_menu_01 = '.$adme_menu_id.', '.
                    'gmr_id_menu_02 = '.$adme_menu_id.', '.
                    'gmr_id_valeur = 101, '.
                    'gmr_ordre = NULL ';
        $resultat = $db->query($requete);
        if (DB::isError($resultat)) {
            die(BOG_afficherErreurSql(__FILE__, __LINE__, $resultat->getMessage(), $requete));
        }
        
    }
}

/** Fonction ADME_deplacerMenuClassique() - Permet de d�placer un menu dans la hi�rarchie.
*
* Permet de d�placer un menu dans la hi�rarchie des menus classiques.
* Ancien nom : moveMenu()
*
* @param  mixed   objet Pear DB de connexion � la base de donn�es.
* @param  integer  identifiant du site administr�.
* @param  integer identifiant du menu � d�placer.
* @param  boolean indique si on veut monter le menu (true) ou le descendre (false).
* @return void    modifie la base de donn�es.
*/
function ADME_deplacerMenuClassique($db, $adme_site_id, $adme_menu_id, $bln_monter)
{
    //-------------------------------------------------------------------------------------------------------------------
    // R�cup�ration d'information sur le site de ce menu.
    $objet_site = GEN_lireInfoSitePrincipal($db, $adme_site_id);
    if ($objet_site == false) {
        die('ERREUR Papyrus Administrateur de Menus : '.ADME_LG_ERREUR_INFO_SITE.'<br />'.
            'Id du site : '. $adme_site_id .'<br />'.
            'Ligne n� : '. __LINE__ .'<br />'.
            'Fichier n� : '. __FILE__ .'<br />');
    }
    //-------------------------------------------------------------------------------------------------------------------
    // R�cup�ration d'informations sur les relations du menu courant.
    $ligne_menu_courant_relation = GEN_lireInfoMenuRelation($db, $adme_menu_id, '1');
    if ($ligne_menu_courant_relation == false) {
        die('ERREUR Papyrus Administrateur de Menus : '.ADME_LG_ERREUR_INFO_MENU_RELATION.'<br />'.
            'Identifiant menu : '. $adme_menu_id .'<br />'.
            'Identifiant valeur relation : 1 <br />'.
            'Ligne n� : '. __LINE__ .'<br />'.
            'Fichier n� : '. __FILE__ .'<br />');
    }
    //-------------------------------------------------------------------------------------------------------------------
    // R�cup�ration de l'identifiant du menu p�re
    $id_pere = GEN_lireIdentifiantMenuPere($adme_menu_id);
    if ($id_pere === false) {
        die('ERREUR Papyrus Administrateur de Menus : '.ADME_LG_ERREUR_ID_MENU_PERE.'<br />'.
            'Identifiant menu fils : '. $adme_menu_id .'<br />'.
            'Ligne n� : '. __LINE__ .'<br />'.
            'Fichier n� : '. __FILE__ .'<br />');
    }
    //-------------------------------------------------------------------------------------------------------------------
    // Recherche d'information sur le menu pr�c�dent ou suivant le menu courant
    $requete =  'SELECT GMR01.gmr_ordre AS nouvel_ordre, GMR01.gmr_id_menu_01 AS id_menu_remplace '.
                'FROM gen_menu, gen_menu_relation AS GMR01, gen_menu_relation AS GMR02 '.
                'WHERE GMR02.gmr_id_menu_01 = GMR01.gmr_id_menu_01 '.
                'AND GMR01.gmr_id_menu_01 = gm_id_menu './/jonction avec la table GEN_MENU
                'AND gm_ce_site = '.$objet_site->gs_id_site.' '.
                'AND GMR02.gmr_id_valeur = 100 '.// 100 = menu type "classique"
                'AND GMR01.gmr_id_menu_02 = '.$id_pere.' '.
                'AND GMR01.gmr_id_valeur = 1 ';// 1 = relation menu "p�re"
    if ($bln_monter) {
        $requete .= 'AND GMR01.gmr_ordre < '.$ligne_menu_courant_relation->gmr_ordre.' '.
                    'ORDER BY GMR01.gmr_ordre DESC';
    } else {
        $requete .= 'AND GMR01.gmr_ordre > '.$ligne_menu_courant_relation->gmr_ordre.' '.
                    'ORDER BY GMR01.gmr_ordre ASC';
    }
    
    $resultat_menu = $db->query($requete);
    (DB::isError($resultat_menu)) ? die(BOG_afficherErreurSql(__FILE__, __LINE__, $resultat_menu->getMessage(), $requete)) : '';
    
    $ligne_menu = $resultat_menu->fetchRow(DB_FETCHMODE_OBJECT);
    
    $resultat_menu->free();
    //-------------------------------------------------------------------------------------------------------------------
    // Si la requete ne retourne rien nous ne faisons rien.
    if (! $ligne_menu) {
        return null;
    }
    //-------------------------------------------------------------------------------------------------------------------
    // Mise � jour des relations du menu courant
    $requete =  'UPDATE gen_menu_relation SET '.
                'gmr_ordre = '.$ligne_menu->nouvel_ordre.' '.
                'WHERE gmr_id_menu_01 = '.$ligne_menu_courant_relation->gmr_id_menu_01.' '.
                'AND gmr_id_valeur = 1';// 1 = relation menu "p�re"
    
    $resultat_update = $db->query($requete);
    (DB::isError($resultat_update)) ? die(BOG_afficherErreurSql(__FILE__, __LINE__, $resultat_update->getMessage(), $requete)) : '';
    //-------------------------------------------------------------------------------------------------------------------
    // Mise � jour des relations du menu pr�c�dent ou suivant
    $requete =  'UPDATE gen_menu_relation SET '.
                'gmr_ordre = '.$ligne_menu_courant_relation->gmr_ordre.' '.
                'WHERE gmr_id_menu_01 = '.$ligne_menu->id_menu_remplace.' '.
                'AND gmr_id_valeur = 1';// 1 = relation menu "p�re"
    
    $resultat_update = $db->query($requete);
    (DB::isError($resultat_update)) ? die(BOG_afficherErreurSql(__FILE__, __LINE__, $resultat_update->getMessage(), $requete)) : '';
}


/** Fonction ADME_traduireMenuClassique() - Permet de traduire un menu classique
*
* Permet de traduire un menu classique
*
* @param  mixed   objet Pear DB de connexion � la base de donn�es.
* @param  integer  identifiant du site administr�.
* @param  integer identifiant du menu � d�placer.
* @return void    modifie la base de donn�es.
*/
function ADME_traduireMenuClassique($db, $auth, $adme_menu_id, $aso_valeurs) {
	

    // R�cup�ration d'infos sur le site principal.
    $objet_site = GEN_lireInfoSitePrincipal($db, $aso_valeurs['adme_site_id']);
    if ($objet_site == false) {
        die('ERREUR G�n�sia Administrateur de Menus : impossible de lire les infos du site.<br />'.
            'ID du site : '.$aso_valeurs['adme_site_id'].'<br />'.
            'Ligne n� : '. __LINE__ .'<br />'.
            'Fichier n� : '. __FILE__ .'<br />');
    }
    
    $nouveau_id_menu = SQL_obtenirNouveauId($db, 'gen_menu', 'gm_id_menu');
    $auteur = $auth->getAuthData('ga_prenom').' '.$auth->getAuthData('ga_nom');
    
    
    
      $requete =  'INSERT INTO gen_menu '.
                'SET gm_id_menu = '.$nouveau_id_menu.', '.
                'gm_ce_site = '.$aso_valeurs['adme_site_id'].', '.
                'gm_ce_i18n = "'.$aso_valeurs['gs_ce_i18n'].'", '.
                'gm_ce_application = '.$aso_valeurs['gm_ce_application'].', '.
                'gm_application_arguments = "'.$aso_valeurs['gm_application_arguments'].'", '.
                'gm_fichier_squelette = "'.$aso_valeurs['gm_fichier_squelette'].'", '.
                'gm_code_num = '.$aso_valeurs['gm_code_num'].', '.
                'gm_code_alpha = "'.$aso_valeurs['gm_code_alpha'].'", '.
                'gm_nom = "'.$aso_valeurs['gm_nom'].'", '.
                'gm_raccourci_clavier = "'.$aso_valeurs['gm_raccourci_clavier'].'", '.
                'gm_robot = "'.$aso_valeurs['gm_robot'].'", '.
                'gm_titre = "'.$aso_valeurs['gm_titre'].'", '.
                'gm_titre_alternatif = "'.$aso_valeurs['gm_titre_alternatif'].'", '.
                'gm_mots_cles = "'.$aso_valeurs['gm_mots_cles'].'", '.
                'gm_description_libre = "'.$aso_valeurs['gm_description_libre'].'", '.
                'gm_description_resume = "'.$aso_valeurs['gm_description_resume'].'", '.
                'gm_description_table_matieres = "'.$aso_valeurs['gm_description_table_matieres'].'", '.
                'gm_source = "'.$aso_valeurs['gm_source'].'", '.
                'gm_auteur = "'.$aso_valeurs['gm_auteur'].'", '.
                'gm_contributeur = "'.$aso_valeurs['gm_contributeur'].'", '.
                'gm_editeur = "'.$aso_valeurs['gm_editeur'].'", '.
                'gm_date_creation = "'.$aso_valeurs['gm_date_creation'].'", '.
                'gm_date_debut_validite = "'.$aso_valeurs['gm_date_debut_validite'].'", '.
                'gm_date_fin_validite = "'.$aso_valeurs['gm_date_fin_validite'].'", '.
                'gm_date_copyright = "'.$aso_valeurs['gm_date_copyright'].'", '.
                'gm_licence = "'.$aso_valeurs['gm_licence'].'", '.
                'gm_categorie = "'.$aso_valeurs['gm_categorie'].'", '.
                'gm_public = "'.$aso_valeurs['gm_public'].'", '.
                'gm_public_niveau = "'.$aso_valeurs['gm_public_niveau'].'", '.
                'gm_ce_type_portee_spatiale = "'.$aso_valeurs['gm_ce_type_portee_spatiale'].'", '.
                'gm_portee_spatiale = "'.$aso_valeurs['gm_portee_spatiale'].'", '.
                'gm_ce_type_portee_temporelle = "'.$aso_valeurs['gm_ce_type_portee_temporelle'].'", '.
                'gm_portee_temporelle = "'.$aso_valeurs['gm_portee_temporelle'].'", '.
                'gm_ce_admin = "'.$auth->getAuthData('ga_id_administrateur').'" ';
    
    $resultat = $db->query($requete);
    (DB::isError($resultat)) ? die(BOG_afficherErreurSql(__FILE__, __LINE__, $resultat->getMessage(), $requete)) : '';
    
    //----------------------------------------------------------------------------
    // Ajout de la relation traduction
    
    if (!isset($adme_menu_id) && empty($adme_menu_id)) {
        $adme_menu_id = 0 ;// Identifiant du p�re
    }
    //----------------------------------------------------------------------------
    // R�cup�ration d'infos sur la hierarchie du menu
    $requete =  'SELECT GMR01.gmr_ordre '.
                'FROM gen_menu_relation AS GMR01, gen_menu_relation AS GMR02 '.
                'WHERE GMR01.gmr_id_menu_02 = '.$adme_menu_id.' '.
                'AND GMR01.gmr_id_valeur = 1 '.// 1 = avoir "p�re"
                'AND GMR02.gmr_id_menu_01 = GMR01.gmr_id_menu_01 '.
                'AND GMR02.gmr_id_menu_01 = GMR02.gmr_id_menu_02 '.
                'AND GMR02.gmr_id_valeur = 100 '.// 100 = menu type "classique"
                'ORDER BY GMR01.gmr_ordre DESC';
    
    $resultat = $db->query($requete);
    (DB::isError($resultat)) ? die(BOG_afficherErreurSql(__FILE__, __LINE__, $resultat->getMessage(), $requete)) : '';
    
    $ligne = $resultat->fetchRow(DB_FETCHMODE_OBJECT);
    $nouveau_ordre_menu = $ligne->gmr_ordre + 1;
    $resultat->free();
    
    
    // Traduction :
    $requete =  'INSERT INTO gen_menu_relation '.
                'SET gmr_id_menu_01 = '.$adme_menu_id.', '.
                'gmr_id_menu_02 = '.$nouveau_id_menu.', '.
                'gmr_id_valeur = 2, '. // Avoir traduction
                'gmr_ordre = '.$nouveau_ordre_menu;

    
    $resultat = $db->query($requete);
    (DB::isError($resultat)) ? die(BOG_afficherErreurSql(__FILE__, __LINE__, $resultat->getMessage(), $requete)) : '';
    
    //----------------------------------------------------------------------------
    // Ajout de la relation-type "menu classique"
    
    // R�cup�ration d'infos sur la hierarchie du menu
    $requete =  'SELECT * '.
                'FROM gen_menu_relation, gen_menu '.
                'WHERE gmr_id_menu_02 = gmr_id_menu_01 '.
                'AND gmr_id_valeur = 100 '.// 100 = type menu "classique"
                'AND gmr_id_menu_01 = gm_id_menu '.
                'AND gm_ce_site = '.$aso_valeurs['adme_site_id'].' '.
                'ORDER BY gmr_ordre DESC';
    
    $resultat = $db->query($requete);
    (DB::isError($resultat)) ? die(BOG_afficherErreurSql(__FILE__, __LINE__, $resultat->getMessage(), $requete)) : '';
    
    $ligne = $resultat->fetchRow(DB_FETCHMODE_OBJECT);
    $nouveau_ordre_menu_classique = $ligne->gmr_ordre + 1;
    $resultat->free();
    
    $requete =  'INSERT INTO gen_menu_relation '.
                'SET gmr_id_menu_01 = '.$nouveau_id_menu.', '.
                'gmr_id_menu_02 = '.$nouveau_id_menu.', '.
                'gmr_id_valeur = 100, '.
                'gmr_ordre = '.$nouveau_ordre_menu_classique;
    
    $result = $db->query($requete);
    (DB::isError($result)) ? die(BOG_afficherErreurSql(__FILE__, __LINE__, $result->getMessage(), $requete)) : '';
	
}

/** Fonction ADME_indenterMenuClassique() - Permet d'augmenter ou diminuer l'indentation d'un menu dans la
 * hierarchie
*
* Permet d'augmenter ou diminuer l'indentation d'un menu dans la hierarchie
*
* @param  mixed   objet Pear DB de connexion � la base de donn�es.
* @param  integer  identifiant du site administr�.
* @param  integer identifiant du menu � d�placer.
* @param  boolean indique si on veut diminuer (gauche) l'indentation (true) ou augmenter (droite) l'indentation (false).
* @return void    modifie la base de donn�es.
*/
function ADME_indenterMenuClassique($db, $adme_site_id, $adme_menu_id, $bln_diminuer) {

    //-------------------------------------------------------------------------------------------------------------------
    // R�cup�ration d'information sur le site de ce menu.
    $objet_site = GEN_lireInfoSitePrincipal($db, $adme_site_id);
    
    if ($objet_site == false) {
        die('ERREUR Papyrus Administrateur de Menus : '.ADME_LG_ERREUR_INFO_SITE.'<br />'.
            'Id du site : '. $adme_site_id .'<br />'.
            'Ligne n� : '. __LINE__ .'<br />'.
            'Fichier n� : '. __FILE__ .'<br />');
    }
    
    //-------------------------------------------------------------------------------------------------------------------
    // R�cup�ration d'informations sur les relations du menu courant.
    $ligne_menu_courant_relation = GEN_lireInfoMenuRelation($db, $adme_menu_id, '1');
    if ($ligne_menu_courant_relation == false) {
        die('ERREUR Papyrus Administrateur de Menus : '.ADME_LG_ERREUR_INFO_MENU_RELATION.'<br />'.
            'Identifiant menu : '. $adme_menu_id .'<br />'.
            'Identifiant valeur relation : 1 <br />'.
            'Ligne n� : '. __LINE__ .'<br />'.
            'Fichier n� : '. __FILE__ .'<br />');
    }
    
    
    	
    //-------------------------------------------------------------------------------------------------------------------
    // R�cup�ration de l'identifiant du menu p�re
     
    $id_pere = GEN_lireIdentifiantMenuPere($adme_menu_id);
    if ($id_pere === false) {
        die('ERREUR Papyrus Administrateur de Menus : '.ADME_LG_ERREUR_ID_MENU_PERE.'<br />'.
            'Identifiant menu fils : '. $adme_menu_id .'<br />'.
            'Ligne n� : '. __LINE__ .'<br />'.
            'Fichier n� : '. __FILE__ .'<br />');
    }
	    
	if ($bln_diminuer) {
	    
	    // Diminution d'un niveau 
	    
	    if ($id_pere) {
	    	
			 // R�cup�ration de l'identifiant du menu grand p�re, sera le nouveau pere
			  
		    $id_grand_pere = GEN_lireIdentifiantMenuPere($id_pere);
		    
		    if ($id_grand_pere === false) {
		        die('ERREUR Papyrus Administrateur de Menus : '.ADME_LG_ERREUR_ID_MENU_PERE.'<br />'.
		            'Identifiant menu fils : '. $adme_menu_id .'<br />'.
		            'Ligne n� : '. __LINE__ .'<br />'.
		            'Fichier n� : '. __FILE__ .'<br />');
		    }
		    
		    // R�cup�ration d'informations sur les relations du menu pere
		    
		    $ligne_menu_pere_relation = GEN_lireInfoMenuRelation($db, $id_pere, '1');
		    
	    	if ($ligne_menu_pere_relation == false) {
		        die('ERREUR Papyrus Administrateur de Menus : '.ADME_LG_ERREUR_INFO_MENU_RELATION.'<br />'.
		            'Identifiant menu : '. $adme_menu_id .'<br />'.
		            'Identifiant valeur relation : 1 <br />'.
		            'Ligne n� : '. __LINE__ .'<br />'.
		            'Fichier n� : '. __FILE__ .'<br />');
		    }
	    
			    	
		    //-------------------------------------------------------------------------------------------------------------------
		    // Recherche d'information sur le menu suivant le menu pere
		    //-------------------------------------------------------------------------------------------------------------------
		    
		    $requete =  'SELECT GMR01.gmr_ordre AS nouvel_ordre, GMR01.gmr_id_menu_01 AS id_menu_remplace '.
	                'FROM gen_menu, gen_menu_relation AS GMR01, gen_menu_relation AS GMR02 '.
	                'WHERE GMR02.gmr_id_menu_01 = GMR01.gmr_id_menu_01 '.
	                'AND GMR01.gmr_id_menu_01 = gm_id_menu './/jonction avec la table GEN_MENU
	                'AND gm_ce_site = '.$objet_site->gs_id_site.' '.
	                'AND GMR02.gmr_id_valeur = 100 '.// 100 = menu type "classique"
	                'AND GMR01.gmr_id_menu_02 = '.$id_grand_pere.' '.
	                'AND GMR01.gmr_id_valeur = 1 '.// 1 = relation menu "p�re"
				    'AND GMR01.gmr_ordre > '.$ligne_menu_pere_relation->gmr_ordre.' '.
				    'ORDER BY GMR01.gmr_ordre DESC';
	        
		    
		    $resultat_menu = $db->query($requete);
		    
		    (DB::isError($resultat_menu)) ? die(BOG_afficherErreurSql(__FILE__, __LINE__, $resultat_menu->getMessage(), $requete)) : '';
		    
		    $ligne_menu = $resultat_menu->fetchRow(DB_FETCHMODE_OBJECT);
		    $resultat_menu->free();
		    
		    //-------------------------------------------------------------------------------------------------------------------
		    // Si la requete ne retourne rien nous ne faisons rien. 
		    if (! $ligne_menu) {
		        $no=$ligne_menu_pere_relation->gmr_ordre+1;
		    }
		    else {
		    	$no=$ligne_menu->nouvel_ordre+1;
		    }
		    
			// Mise � jour pere menu courant
		   	$requete =  'UPDATE gen_menu_relation SET '.
		                'gmr_id_menu_02 =  '.$id_grand_pere.' ,'.
		                'gmr_ordre = '.$no.' '.
		                'WHERE gmr_id_menu_01 = '.$ligne_menu_courant_relation->gmr_id_menu_01.' '.
		                'AND gmr_id_valeur = 1';// 1 = relation menu "p�re"
		    
			$resultat_update = $db->query($requete);
		    (DB::isError($resultat_update)) ? die(BOG_afficherErreurSql(__FILE__, __LINE__, $resultat_update->getMessage(), $requete)) : '';
		    
		    
		    	    
	    }
	}	    
	else {

	    $requete =  'SELECT GMR01.gmr_id_menu_01 '.
	                'FROM gen_menu, gen_menu_relation AS GMR01, gen_menu_relation AS GMR02 '.
	                'WHERE GMR02.gmr_id_menu_01 = GMR01.gmr_id_menu_01 '.
	                'AND GMR01.gmr_id_menu_01 = gm_id_menu './/jonction avec la table GEN_MENU
	                'AND gm_ce_site = '.$objet_site->gs_id_site.' '.
	                'AND GMR02.gmr_id_valeur = 100 '.// 100 = menu type "classique"
	                'AND GMR01.gmr_id_menu_02 = '.$id_pere.' '.
	                'AND GMR01.gmr_id_valeur = 1 '.// 1 = relation menu "p�re"
        			'AND GMR01.gmr_ordre < '.$ligne_menu_courant_relation->gmr_ordre.' '.
                    'ORDER BY GMR01.gmr_ordre DESC';
    
	    $resultat_menu = $db->query($requete);
    	(DB::isError($resultat_menu)) ? die(BOG_afficherErreurSql(__FILE__, __LINE__, $resultat_menu->getMessage(), $requete)) : '';

	    $ligne_menu = $resultat_menu->fetchRow(DB_FETCHMODE_OBJECT);			    	
	    $resultat_menu->free();
	    //-------------------------------------------------------------------------------------------------------------------
	    // Si la requete ne retourne rien nous ne faisons rien.
	    if (! $ligne_menu) {
	        return null;
	    }
    	
    	//----------------------------------------------------------------------------
		// Recherche dernier fils
		
		$requete =  'SELECT GMR01.gmr_ordre '.
                'FROM gen_menu_relation AS GMR01, gen_menu_relation AS GMR02 '.
                'WHERE GMR01.gmr_id_menu_02 = '.$ligne_menu->gmr_id_menu_01.' '.
                'AND GMR01.gmr_id_valeur = 1 '.// 1 = avoir "p�re"
                'AND GMR02.gmr_id_menu_01 = GMR01.gmr_id_menu_01 '.
                'AND GMR02.gmr_id_menu_01 = GMR02.gmr_id_menu_02 '.
                'AND GMR02.gmr_id_valeur = 100 '.// 100 = menu type "classique"
                'ORDER BY GMR01.gmr_ordre DESC';
    
		$resultat = $db->query($requete);
		(DB::isError($resultat)) ? die(BOG_afficherErreurSql(__FILE__, __LINE__, $resultat->getMessage(), $requete)) : '';

		$ligne = $resultat->fetchRow(DB_FETCHMODE_OBJECT);
		
		$resultat->free();

	    if (isset($ligne)) {
	    	$no = $ligne->gmr_ordre + 1;
	    }	    
	    else  {
	    	$no = 1;
	    }
		// Mise � jour pere menu courant
	   	$requete =  'UPDATE gen_menu_relation SET '.
	                'gmr_id_menu_02 =  '.$ligne_menu->gmr_id_menu_01.' ,'.
	                'gmr_ordre = '.$no.' '.
	                'WHERE gmr_id_menu_01 = '.$ligne_menu_courant_relation->gmr_id_menu_01.' '.
	                'AND gmr_id_valeur = 1';// 1 = relation menu "p�re"
	    
		$resultat_update = $db->query($requete);
	    (DB::isError($resultat_update)) ? die(BOG_afficherErreurSql(__FILE__, __LINE__, $resultat_update->getMessage(), $requete)) : '';
    }
}


/** Fonction ADME_supprimerMenuClassique() - Supprime un menu classique.
*
* Supprime de la base de donn�es de Papyrus toutes les traces du menu classiques
* pass� en param�tre.
* Ancien nom : deleteMenu()
*
* @param  mixed  l'objet Pear DB de connexion � la base de donn�es.
* @param  integer l'identifiant du site du menu � supprimer
* @param  integer l'identifiant du menu � supprimer
* @return void   le menu classique est supprim� de la base de donn�es.
*/
function ADME_supprimerMenuClassique($db, $adme_id_site, $id_menu_a_supprimer)
{
	
	$code_menu = GEN_lireInfoMenu($db, $id_menu_a_supprimer, DB_FETCHMODE_ASSOC);
	
    //----------------------------------------------------------------------------
    // Y a t'il des sous_menus
    $requete =  'SELECT COUNT(gm_id_menu) AS compte '.
                'FROM gen_menu, gen_menu_relation '.
                'WHERE gmr_id_menu_02 = '.$id_menu_a_supprimer.' '.
                'AND gmr_id_valeur = 1 '.
                'AND gmr_id_menu_01 = gm_id_menu ';
    
    $resultat = $db->query($requete);
    (DB::isError($resultat)) ? die(BOG_afficherErreurSql(__FILE__, __LINE__, $resultat->getMessage(), $requete)) : '';
    
    $ligne = $resultat->fetchRow(DB_FETCHMODE_OBJECT);
    
    if ($ligne && ($ligne->compte > 0)) {
        return ADME_LG_ERREUR_EXISTE_SOUS_MENU;
    }
    
    //-------------------------------------------------------------------------------------------------------------------
    // Mise � jour de l'ordre des menus
    $ligne_menu_supr_relation = GEN_lireInfoMenuRelation($db, $id_menu_a_supprimer, '1'); // 1 = relation "avoir p�re"
    $requete =  'SELECT GMR01.gmr_id_menu_01, GMR01.gmr_ordre '.
                'FROM gen_menu, gen_menu_relation AS GMR01, gen_menu_relation AS GMR02 '.
                'WHERE GMR02.gmr_id_menu_01 = GMR01.gmr_id_menu_01 '.
                'AND GMR01.gmr_id_menu_01 = gm_id_menu './/jonction avec la table GEN_MENU
                'AND gm_ce_site = '.$adme_id_site.' '.// le site du menu!
                'AND GMR02.gmr_id_valeur = 100 '.// 100 = menu type "classique"
                'AND GMR01.gmr_id_menu_02 = '.$ligne_menu_supr_relation->gmr_id_menu_02.' '.
                'AND GMR01.gmr_id_valeur = 1 '.// 1 = relation menu "p�re"
                'AND GMR01.gmr_ordre > '.$ligne_menu_supr_relation->gmr_ordre.' '.
                'ORDER BY GMR01.gmr_ordre ASC';
    $resultat = $db->query($requete);
    while ($ligne = $resultat->fetchRow(DB_FETCHMODE_OBJECT)) {
        // Mise � jour des relations hi�rarchiques du menu courant
        $requete_maj =  'UPDATE gen_menu_relation SET '.
                        'gmr_ordre = '.($ligne->gmr_ordre - 1).' '.
                        'WHERE gmr_id_menu_01 = '.$ligne->gmr_id_menu_01.' '.
                        'AND gmr_id_valeur = 1';// 1 = relation menu "p�re"
        
        $resultat_maj = $db->query($requete_maj);
        (DB::isError($resultat_maj)) ? die(BOG_afficherErreurSql(__FILE__, __LINE__, $resultat_maj->getMessage(), $requete_maj)) : '';
    }
    $resultat->free();
    
    //----------------------------------------------------------------------------
    // S'il n'y a plus de sous niveau, on supprime le menu
    $requete =  'DELETE FROM gen_menu '.
                'WHERE gm_id_menu = '.$id_menu_a_supprimer;
    
    $resultat = $db->query($requete);
    (DB::isError($resultat)) ? die(BOG_afficherErreurSql(__FILE__, __LINE__, $resultat->getMessage(), $requete)) : '';
    
    //----------------------------------------------------------------------------
    // Puis on supprime les relations de ce menu
    $requete =  'DELETE FROM gen_menu_relation '.
                'WHERE gmr_id_menu_01 = '.$id_menu_a_supprimer;
                
                
                
    
    $resultat = $db->query($requete);
    (DB::isError($resultat)) ? die(BOG_afficherErreurSql(__FILE__, __LINE__, $resultat->getMessage(), $requete)) : '';
    
    
        
	 // Suppression du contenu !!!!
	
    $requete =  'DELETE FROM gen_menu_contenu '.
                'WHERE gmc_ce_menu= '.$id_menu_a_supprimer.' ';

    $resultat = $db->query($requete);
    (DB::isError($resultat)) ? die(BOG_afficherErreurSql(__FILE__, __LINE__, $resultat->getMessage(), $requete)) : '';
    
    
    
}

/** Fonction ADME_supprimerMenuClassiqueTraduction() - Supprime une traduction de menu classique.
*
* Supprime de la base de donn�es de Papyrus toutes les traces du menu classiques
* pass� en param�tre.
* Ancien nom : deleteMenu()
*
* @param  mixed  l'objet Pear DB de connexion � la base de donn�es.
* @param  integer l'identifiant du site du menu � supprimer
* @param  integer l'identifiant du menu � supprimer
* @return void   le menu classique est supprim� de la base de donn�es.
*/
function ADME_supprimerMenuClassiqueTraduction($db, $adme_id_site, $id_menu_a_supprimer)
{
	
	
	$code_menu = GEN_lireInfoMenu($db, $id_menu_a_supprimer, DB_FETCHMODE_ASSOC);
	
		
    if ($code_menu === false) {
            die('ERREUR Papyrus Administrateur de Menus : '.ADME_LG_ERREUR_INFO_MENU.'<br />'.
                'Idenitifiant du menu n� : '. $id_menu_a_supprimer .'<br />'.
                'Ligne n� : '. __LINE__ .'<br />'.
                'Fichier n� : '. __FILE__ .'<br />');
     }
	
	
	    
    $requete =  'DELETE FROM gen_menu '.
                'WHERE gm_id_menu = '.$id_menu_a_supprimer;
    
    $resultat = $db->query($requete);
    (DB::isError($resultat)) ? die(BOG_afficherErreurSql(__FILE__, __LINE__, $resultat->getMessage(), $requete)) : '';
    
    //----------------------------------------------------------------------------
    // Puis on supprime les relations de ce menu
    $requete =  'DELETE FROM gen_menu_relation '.
                'WHERE gmr_id_menu_01 = '.$id_menu_a_supprimer;
    
    $resultat = $db->query($requete);
    (DB::isError($resultat)) ? die(BOG_afficherErreurSql(__FILE__, __LINE__, $resultat->getMessage(), $requete)) : '';
    
        //----------------------------------------------------------------------------
    // Puis on supprime les relations de ce menu
    $requete =  'DELETE FROM gen_menu_relation '.
                'WHERE gmr_id_menu_02 = '.$id_menu_a_supprimer;
    
    $resultat = $db->query($requete);
    (DB::isError($resultat)) ? die(BOG_afficherErreurSql(__FILE__, __LINE__, $resultat->getMessage(), $requete)) : '';
    
    
    
	 // Suppression du contenu !!!!
	
    $requete =  'DELETE FROM gen_menu_contenu '.
                'WHERE gmc_ce_menu =  '.$id_menu_a_supprimer.' ';



    $resultat = $db->query($requete);
    (DB::isError($resultat)) ? die(BOG_afficherErreurSql(__FILE__, __LINE__, $resultat->getMessage(), $requete)) : '';
                
    
}

function ADME_verifier_traduction_possible($db, $url, $adme_site_id, $adme_menu_id) {
	
	
		$aso_valeurs = GEN_lireInfoMenu($db, $adme_menu_id, DB_FETCHMODE_ASSOC);
        if ($aso_valeurs === false) {
            die('ERREUR Papyrus Administrateur de Menus : '.ADME_LG_ERREUR_INFO_MENU.'<br />'.
                'Idenitifiant du menu n� : '. $adme_menu_id .'<br />'.
                'Ligne n� : '. __LINE__ .'<br />'.
                'Fichier n� : '. __FILE__ .'<br />');
        }
	
	    	// Recherche liste des menu deja traduits 
    		
	   	$requete =  'SELECT distinct gm_ce_i18n  '.
        	        'FROM gen_menu_relation, gen_menu '.
            	    'WHERE gmr_id_menu_01  = ' . $adme_menu_id .' '.
                	'AND gm_id_menu  = gmr_id_menu_02  '.
                	'AND gmr_id_valeur = 2  '; // 2 = "avoir traduction"
	
	  	$resultat = $db->query($requete) ;
	  	
	    if (DB::isError($resultat)) {
	        die( BOG_afficherErreurSql(__FILE__, __LINE__, $resultat->getMessage(), $requete) );
	    }
	    
	    $not_in_langue='';
	    if ( $resultat->numRows() == 0 ) {
			$not_in_langue="gi_id_i18n not in('".$aso_valeurs['gm_ce_i18n']."')";    
	    }
	    else {
	    	    while ($ligne = $resultat->fetchRow(DB_FETCHMODE_OBJECT)) {
 					$not_in_langue="'".$ligne->gm_ce_i18n."'".",".$not_in_langue;
 					$end="'".$ligne->gm_ce_i18n."'";
				}
	    		if ($not_in_langue) {
			    			$not_in_langue="'".$aso_valeurs['gm_ce_i18n']."'".",".$not_in_langue;
			    			$not_in_langue=' gi_id_i18n not in('.$not_in_langue.$end.')';
			    }
	    		else {
	    			$not_in_langue="gi_id_i18n not in('".$aso_valeurs['gm_ce_i18n']."')";
	    		}
	    }
	    
	   					
    	$requete =  "SELECT * FROM gen_i18n where ".$not_in_langue;

		$resultat = $db->query($requete) ;
	    if (DB::isError($resultat)) {
    	    die( BOG_afficherErreurSql(__FILE__, __LINE__, $resultat->getMessage(), $requete) );
    	}
    	
    
    $retour = $resultat->numRows();
    $resultat->free();
    
    $message='';
    if ($retour == 0) {
    	  $message = '<p class="pap_erreur">Plus de traduction possible pour ce menu </p>';
    }
    return  $message;
}



/** Fonction ADME_selectionnerMenuClassiqueTraduction()() Selection un menu classique comme traduction par defaut
*
*
* @param  mixed  l'objet Pear DB de connexion � la base de donn�es.
* @param  integer l'identifiant du site du menu � supprimer
* @param  integer l'identifiant du menu � supprimer
* @return void   le menu classique est supprim� de la base de donn�es.
*/
function ADME_selectionnerMenuClassiqueTraduction($db, $adme_id_site, $id_menu)
{
	
	// 1 : Rechercher traduction parente : si presente on est dans une traduc. si absente on
	// est dans un menu en version originale
	
			
	$requete_origine_traduction  =  'SELECT gmr_id_menu_01 '.
        	        				'FROM gen_menu_relation, gen_menu '.
            	    				'WHERE gmr_id_menu_02  = ' . $id_menu .' '.
				                	'AND gmr_id_valeur = 2  '; // 2 = "avoir traduction"
	
	$resultat_origine_traduction = $db->query($requete_origine_traduction) ;
	  	
	if (DB::isError($resultat_origine_traduction)) {
	    die( BOG_afficherErreurSql(__FILE__, __LINE__, $resultat->getMessage(), $requete_origine_traduction) );
	}
		
	
	if ($resultat_origine_traduction->numRows() > 0) {
		$ligne_origine_traduction = $resultat_origine_traduction->fetchRow(DB_FETCHMODE_OBJECT);
		$id_menu_origine=$ligne_origine_traduction->gmr_id_menu_01;
	}
	else {
		$id_menu_origine=$id_menu;
	}

	$requete_suppression   = 'DELETE from gen_menu_relation '.
						     'WHERE gmr_id_menu_01 = ' . $id_menu_origine . ' ' .
						     'AND gmr_id_valeur=105 '; // 105  Traduction par defaut 

    $resultat_suppression = $db->query($requete_suppression);
    (DB::isError($resultat_suppression)) ? die(BOG_afficherErreurSql(__FILE__, __LINE__, $resultat_suppression->getMessage(), $requete_suppression)) : '';
    

	$requete_insertion   = 'INSERT into gen_menu_relation '.
						     ' SET gmr_id_menu_01 = ' . $id_menu_origine . ', ' .
						     ' gmr_id_menu_02 = ' . $id_menu . ', ' .
						     ' gmr_id_valeur = 105' ;

    $resultat_insertion = $db->query($requete_insertion);
    (DB::isError($resultat_insertion)) ? die(BOG_afficherErreurSql(__FILE__, __LINE__, $resultat_insertion->getMessage(), $requete_insertion)) : '';


                
    
}
    

/** Fonction ADME_limiterMenuClassique() (limiter) un menu classique � la langue selectionne
*
*
* @param  mixed  l'objet Pear DB de connexion � la base de donn�es.
* @param  integer l'identifiant du site du menu � supprimer
* @param  integer l'identifiant du menu � supprimer
* @return void   le menu classique est supprim� de la base de donn�es.
*/
function ADME_limiterMenuClassique($db, $adme_id_site, $id_menu, $zone)
{

	
		$requete_insertion   = 'INSERT into gen_menu_relation '.
						     ' SET gmr_id_menu_01 = ' . $id_menu . ', ' .
						     ' gmr_id_menu_02 = ' . $id_menu . ', ' .
						     ' gmr_id_valeur = 106' ;

	    $resultat_insertion = $db->query($requete_insertion);



    $requete_mise_a_jour =  'UPDATE gen_menu SET '.
                'gm_ce_i18n = "'.$zone.'" '.
                'WHERE gm_id_menu = '.$id_menu;
    
    $resultat_mise_a_jour = $db->query($requete_mise_a_jour);
    (DB::isError($resultat_mise_a_jour)) ? die(BOG_afficherErreurSql(__FILE__, __LINE__, $resultat_mise_a_jour->getMessage(), $requete_mise_a_jour)) : '';

	    
}
    

/** Fonction ADME_ouvrirMenuClassique() Ouvrir un menu classique � toutes les langues (suite � une fermeture)
*
*
* @param  mixed  l'objet Pear DB de connexion � la base de donn�es.
* @param  integer l'identifiant du site du menu � supprimer
* @param  integer l'identifiant du menu � supprimer
* @return void   le menu classique est supprim� de la base de donn�es.
*/
function ADME_ouvrirMenuClassique($db, $adme_id_site, $id_menu)
{
	

	$requete_suppression   = 'DELETE from gen_menu_relation '.
						     'WHERE gmr_id_menu_01 = ' . $id_menu . ' ' .
						     'AND gmr_id_valeur=106 '; // 106  fermeture du menu

    $resultat_suppression = $db->query($requete_suppression);


    $requete_mise_a_jour =  'UPDATE gen_menu SET '.
                'gm_ce_i18n = "'.GEN_I18N_ID_DEFAUT.'" '.
                'WHERE gm_id_menu = '.$id_menu;
    
    $resultat_mise_a_jour = $db->query($requete_mise_a_jour);
    (DB::isError($resultat_mise_a_jour)) ? die(BOG_afficherErreurSql(__FILE__, __LINE__, $resultat_mise_a_jour->getMessage(), $requete_mise_a_jour)) : '';

	
}



// +------------------------------------------------------------------------------------------------------+
// |                                            PIED du PROGRAMME                                         |
// +------------------------------------------------------------------------------------------------------+


/* +--Fin du code ----------------------------------------------------------------------------------------+
*
* $Log: adme_menu_classique.fonct.php,v $
* Revision 1.42  2007-10-25 14:26:56  ddelon
* Multilinguisme : présentation restriction à une langue
*
* Revision 1.41  2007-10-24 14:43:02  ddelon
* Gestion des menus reservés à une langue
*
* Revision 1.40  2007-07-03 14:35:11  florian
* correction bug maj non prise en charge
*
* Revision 1.39  2007-07-03 14:07:02  florian
* correction bug maj non prise en charge
*
* Revision 1.38  2007-06-26 14:18:53  florian
* amélioration des formulaires des différentes applis de l'interface d'administration afin de les simplifier
*
* Revision 1.37  2006/10/16 15:49:07  ddelon
* Refactorisation code mulitlinguisme et gestion menu invisibles
*
* Revision 1.36  2006/10/06 13:38:45  florian
* ergonomie amélioree
*
* Revision 1.35  2006/09/07 13:45:56  jp_milcent
* Trie par ordre alphab�tique des appli.
*
* Revision 1.34  2006/06/29 23:04:01  ddelon
* Bug defaut traduction sur menu commun
*
* Revision 1.33  2006/06/29 18:58:57  ddelon
* Multilinguisme : menu par defaut pour les menu commun
*
* Revision 1.32  2006/06/28 12:53:34  ddelon
* Multilinguisme : menu par defaut
*
* Revision 1.31  2006/04/12 21:11:54  ddelon
* Multilinguisme menus communs
*
* Revision 1.30  2006/03/27 14:33:04  ddelon
* Gestion suppression de contenu menu afficheur
*
* Revision 1.29  2006/03/23 20:24:59  ddelon
* *** empty log message ***
*
* Revision 1.28  2006/03/15 09:30:50  florian
* suppression des echos, qui entrainaient des problemes d'affichages
*
* Revision 1.27  2006/03/13 21:00:20  ddelon
* Suppression messages d'erreur multilinguisme
*
* Revision 1.26  2006/03/10 11:02:36  alexandre_tb
* remplacement de l'image "Traduire" par un texte "traduire" vu qu'on a pas d'image pour la notion de traduire...
*
* Revision 1.25  2006/03/02 10:49:49  ddelon
* Fusion branche multilinguisme dans branche principale
*
* Revision 1.24.2.1  2006/02/28 14:02:11  ddelon
* Finition multilinguisme
*
* Revision 1.24  2005/09/23 13:58:07  ddelon
* Php5, Projet et Redirection
*
* Revision 1.23  2005/09/20 17:01:22  ddelon
* php5 et bugs divers
*
* Revision 1.22  2005/07/08 21:13:15  ddelon
* Gestion indentation menu
*
* Revision 1.21  2005/05/26 16:13:08  jpm
* Correction taille �diteur: passage en text
*
* Revision 1.19  2005/05/26 15:34:46  jpm
* Ajout d'un espace.
*
* Revision 1.18  2005/05/26 08:54:20  jpm
* Ajout info admin ayant fait la derni�re modif.
*
* Revision 1.17  2005/04/19 16:47:16  jpm
* Gestion des dates  de fin de validit� des menus.
*
* Revision 1.16  2005/03/29 15:49:12  jpm
* Ajout de la date de cr�ation dans le formulaire des menus.
*
* Revision 1.15  2005/02/28 11:05:06  jpm
* Modification des auteurs.
*
* Revision 1.14  2004/12/01 16:47:28  jpm
* Ajout d'une boite javascript de confirmation de suppression d'un menu.
*
* Revision 1.13  2004/11/29 18:34:51  jpm
* Correction bogue checkbox.
*
* Revision 1.12  2004/11/15 16:51:12  jpm
* Correction bogue de mise � jour de l'ordre des menus.
*
* Revision 1.11  2004/11/10 19:41:14  jpm
* Correction bogue.
*
* Revision 1.10  2004/11/10 17:26:07  jpm
* Fin gestion de la traduction.
*
* Revision 1.9  2004/11/09 17:53:00  jpm
* Changement des noms des actions sur les menus classiques.
*
* Revision 1.8  2004/11/09 17:48:35  jpm
* Gestion de diff�rentes interfaces d'administration.
*
* Revision 1.7  2004/11/09 12:37:34  jpm
* Fin de gestion des menus et mise en conformit� avec la convention de codage.
*
* Revision 1.6  2004/11/08 17:40:07  jpm
* Gestion correcte de l'ouverture et fermeture des menus.
* Utilisation des sessions.
*
* Revision 1.5  2004/11/04 19:11:38  jpm
* Mise en conformit� vis � vis de la convention de codage.
* Am�lioration de la r�cursivit� de la gestion de l'affichage des menus.
*
* Revision 1.4  2004/10/25 16:27:42  jpm
* Correction d'un bogue dans la gestion du d�placement des menus.
*
* Revision 1.3  2004/09/23 17:45:13  jpm
* Am�lioration de la gestion des liens annuler et du selecteur de sites.
*
* Revision 1.2  2004/07/06 17:07:37  jpm
* Modification de la documentation pour une mailleur analyse par PhpDocumentor.
*
* Revision 1.1  2004/06/16 15:04:32  jpm
* Changement de nom de G�n�sia en Papyrus.
* Changement de l'arborescence.
*
* Revision 1.27  2004/05/10 12:13:03  jpm
* Modification des formulaires.
*
* Revision 1.26  2004/05/07 16:31:20  jpm
* Am�lioration du formulaire d'un menu classique.
*
* Revision 1.25  2004/05/07 07:23:53  jpm
* Am�lioration du code, des commentaires et correction de bogues.
*
*
* +-- Fin du code ----------------------------------------------------------------------------------------+
*/
?>