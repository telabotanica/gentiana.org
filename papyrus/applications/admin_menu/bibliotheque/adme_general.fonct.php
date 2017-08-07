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
// CVS : $Id: adme_general.fonct.php,v 1.20 2007-10-24 14:43:02 ddelon Exp $
/**
* Contient l'affichage par d�faut de l'appli quand aucune actin
*
* Ce fichier contient les fonctions d'affichage commune � toute l'application Admin Menu.
* Nous y trouvons, entre autre, la fonction d'affichage par d�faut de l'appli.
*
*@package Admin_menu
*@subpackage Fonctions
//Auteur original :
*@author        Jean-Pascal MILCENT <jpm@tela-botanica.org>
//Autres auteurs :
*@author        Aucun
*@copyright     Tela-Botanica 2000-2004
*@version       $Revision: 1.20 $ $Date: 2007-10-24 14:43:02 $
// +------------------------------------------------------------------------------------------------------+
*/

// +------------------------------------------------------------------------------------------------------+
// |                                            ENTETE du PROGRAMME                                       |
// +------------------------------------------------------------------------------------------------------+


// +------------------------------------------------------------------------------------------------------+
// |                                           LISTE de FONCTIONS                                         |
// +------------------------------------------------------------------------------------------------------+
/** Fonction ADME_afficherFormPrincipal() - Affichage par d�faut.
*
* Fournit l'affichage par d�faut de l'application Admin Menus.
*
* @param  object objet Pear de connection � la base de donn�es.
* @param  object objet Pear repr�sentant l'url de base.
* @return string le XHTML par d�faut de la page.
*/
function ADME_afficherFormPrincipal($objet_pear_db, $objet_pear_url, $adme_site_id, $adme_menu_id, $adme_action)
{
    
    $db=$objet_pear_db;
    
    $id_langue = $GLOBALS['_GEN_commun']['i18n']; //identifiant de la langue choisie
	
	// Langue en cours : langue choisie ou langue par defaut (principale)
	
	if (isset($id_langue) && ($id_langue!='')) {
		$langue_test=$id_langue;
	} else {
		$langue_test=GEN_I18N_ID_DEFAUT;
	}

//$langue_test=GEN_I18N_ID_DEFAUT;
	
	//requete pour recuperer l'id du menu par defaut 
     $requete =  'SELECT gs_id_site '.
                'FROM gen_site, gen_site_relation '.
                'WHERE gsr_id_site_01 = gsr_id_site_02 '.
                'AND gsr_id_site_01 = gs_id_site '.
                'AND gsr_id_valeur=101 '.
                'AND gs_ce_i18n = "'.$langue_test.'" ';                        
    $resultat = $db->query($requete);
    (DB::isError($resultat)) ? die(BOG_afficherErreurSql(__FILE__, __LINE__, $resultat->getMessage(), $requete)) : '' ;
    while ($ligne = $resultat->fetchRow(DB_FETCHMODE_OBJECT)) {
    	$id_site_par_defaut=$ligne->gs_id_site;
    }
    
    // Liste des sites principaux :
    // Recherche de tous les sites langue en cours
    
    $requete =  'SELECT * '.
                'FROM gen_site, gen_site_relation '.
                'WHERE gsr_id_site_01 = gsr_id_site_02 '.
                'AND gsr_id_site_01 = gs_id_site '.
                'AND gsr_id_valeur IN (102, 103) '.
                'AND gs_ce_i18n = "'.$langue_test.'" '.
                'ORDER BY gsr_ordre';
                    
    
    $resultat = $db->query($requete);
    (DB::isError($resultat)) ? die(BOG_afficherErreurSql(__FILE__, __LINE__, $resultat->getMessage(), $requete)) : '' ;
    
    
    
    $liste_site=array();
    while ($ligne = $resultat->fetchRow(DB_FETCHMODE_OBJECT)) {
    	
    		if ($langue_test == GEN_I18N_ID_DEFAUT) {
    			
    		  $requete_est_traduction =   'SELECT gsr_id_site_01 '.
	                       'FROM  gen_site_relation '.
	                       'WHERE '.$ligne->gs_id_site.' = gsr_id_site_02 ' .
	                  	   'AND  gsr_id_site_01 <> gsr_id_site_02 ' .
	                       'AND gsr_id_valeur = 1 ';// 1 = "avoir traduction"
	                                
	                                
	            $resultat_est_traduction = $db->query($requete_est_traduction);
	            (DB::isError($resultat_est_traduction))
	                ? die(BOG_afficherErreurSql(__FILE__, __LINE__, $resultat_est_traduction->getMessage(), $requete_est_traduction))
	                : '';
	                
	   			if ( $resultat_est_traduction->numRows() == 0 ) {
    	 			$liste_site[]=$ligne;
	            }
    		}
    		else {
    			   $liste_site[]=$ligne;
    		}
    }
    $resultat->free();
    
    // Si la langue en cours n'est pas la langue par d�faut, recherche des sites ayant comme langue
    // la langue par defaut, non traduits dans la langue en cours et n'etant pas des traductions
  	
  	
	if ($langue_test != GEN_I18N_ID_DEFAUT) {

    
	    $requete =  'SELECT * '.
	                'FROM gen_site, gen_site_relation '.
	                'WHERE gsr_id_site_01 = gsr_id_site_02 '.
	                'AND gs_id_site = gsr_id_site_01 '.
	                'AND gsr_id_valeur IN (102, 103) '.
	                'AND gs_ce_i18n = "'.GEN_I18N_ID_DEFAUT.'" '.
	                'ORDER BY gs_code_num ASC';// 102 = site "principal" et 103 = site "externe"
	                
	    $resultat = $db->query($requete);
	    (DB::isError($resultat)) ? die(BOG_afficherErreurSql(__FILE__, __LINE__, $resultat->getMessage(), $requete)) : '';
	    
	    
	            
	    
	    // Recherche de tous les sites de la langue principale  qui ne sont pas traduits dans la langue en cours
	    
	    while ($ligne = $resultat->fetchRow(DB_FETCHMODE_OBJECT)) {
	    	
	    		$requete_est_traduction =   'SELECT gsr_id_site_01 '.
	                                'FROM  gen_site_relation '.
	                                'WHERE '.$ligne->gs_id_site.' = gsr_id_site_02 ' .
	                                'AND  gsr_id_site_01 <> gsr_id_site_02 ' .
	                                'AND gsr_id_valeur = 1 ';// 1 = "avoir traduction"
	                                
	                                
	            $resultat_est_traduction = $db->query($requete_est_traduction);
	            (DB::isError($resultat_est_traduction))
	                ? die(BOG_afficherErreurSql(__FILE__, __LINE__, $resultat_est_traduction->getMessage(), $requete_est_traduction))
	                : '';
	                
	            if ( $resultat_est_traduction->numRows() == 0 ) {
	            	
		    	
					if (isset($id_langue) && ($id_langue!='')) {
						$langue_test=$id_langue;
					} else {
						$langue_test=GEN_I18N_ID_DEFAUT;
					}
				    	
		    		$requete_traduction =   'SELECT gsr_id_site_01 '.
		                                    'FROM  gen_site_relation, gen_site '.
		                                    'WHERE '.$ligne->gs_id_site.' = gsr_id_site_01 ' .
		                                    'AND gsr_id_site_02 = gs_id_site '.
		                                    'AND gs_ce_i18n = "'.$langue_test.'" '.
		                                    'AND gsr_id_valeur = 1 ';// 1 = "avoir traduction"
		                                    
		            $resultat_traduction = $db->query($requete_traduction);
		            (DB::isError($resultat_traduction))
		                ? die(BOG_afficherErreurSql(__FILE__, __LINE__, $resultat_traduction->getMessage(), $requete_traduction))
		                : '';
		                
		            if ( $resultat_traduction->numRows() == 0 ) {
		            	$liste_site []=$ligne;
		            }
		            
		            $resultat_traduction->free();
		            
	            }
	               $resultat_est_traduction->free();
		    
	    }
	    $resultat->free();
	}
      
              // Traduction d'un site principal uniquement :
	        
	        $requete =  'SELECT * '.
	                    'FROM gen_site_relation '.
	                    'WHERE gsr_id_site_02 = '.$adme_site_id.' '.
	                    'AND gsr_id_valeur =1  '; // 1 = "avoir traduction"
	        
	        $resultat = $db->query($requete);
	        
	        if (DB::isError($resultat)) {
	            die( BOG_afficherErreurSql(__FILE__, __LINE__, $resultat->getMessage(), $requete) );
	        }
	
	        if ( $resultat->numRows() == 0 ) {
	        	$adme_site_id =$adme_site_id;
	        }
	        else {
	        	$ligne = $resultat->fetchRow(DB_FETCHMODE_OBJECT);
		        $adme_site_id = $ligne->gsr_id_site_01;
		    }
	        $resultat->free();
       		 
    
    	
    //---------------------------------------------------------------------------------------------------------------
    // Cr�ation du formulaire
    // Notes : Quickform semble remplacer les & des &amp; � nouveau par des &amp; solution utiliser str_replace()...
    $form = new HTML_QuickForm('adme_form_sites', 'post', str_replace('&amp;', '&', $objet_pear_url->getUrl()));
    $tab_index = 1000;
    $squelette =& $form->defaultRenderer();
    $squelette->setformTemplate("\n".'<form {attributes}>'."\n".'{content}'."\n"."\n".'</form>'."\n");
    $squelette->setElementTemplate( '{label}'."\n".'{element}'."\n".
                                    '<!-- BEGIN required --><span class="symbole_obligatoire">*</span><!-- END required -->'."\n".
                                    '<!-- BEGIN error --><span class="erreur">{error}</span><!-- END error -->'."\n");
    $partie_site_debut =    '<fieldset>'."\n".
                            '<legend>'.ADME_LG_FORM_SITE_TITRE.'</legend>'."\n";
    $form->addElement('html', $partie_site_debut);
    $id = 'adme_site_id';
    $aso_attributs = array('id'=> $id, 'tabindex' => $tab_index++, 'onchange' => 'javascript:this.form.submit();');
    $label = '<label for="'.$id.'">'.ADME_LG_FORM_SITE_CHOIX.'</label>';
    $objet_select = new HTML_QuickForm_select($id, $label, '', $aso_attributs);
    $aso_options = array();
    
//print    $adme_site_id;

    foreach ($liste_site as $ligne ) {
        if (!isset($adme_site_id) || $adme_site_id == 0) {
            $adme_site_id = $ligne->gs_id_site;
        }
//        print   $ligne->gs_id_site;
        
        if ($ligne->gs_id_site == $adme_site_id) {
            $objet_select->addOption(htmlentities($ligne->gs_nom.' ('.$ligne->gs_code_alpha.')'), $ligne->gs_id_site, 'selected="selected"');
            // Attribution du nom du site sur lequel on travaille pour le titre
            $site_nom = $ligne->gs_nom;
        } else {
            $objet_select->addOption(htmlentities($ligne->gs_nom.' ('.$ligne->gs_code_alpha.')'), $ligne->gs_id_site);
        }
    }
    $form->addElement($objet_select);
    $form->addElement('submit', 'choisir_site', ADME_LG_FORM_SITE_VALIDER);
    $partie_site_fin = "\n".'</fieldset>';
    $form->addElement('html', $partie_site_fin);
    
    // Instanciation des valeurs par d�faut du formulaire
    if (isset($id_site_par_defaut)) {    	
    	if (!isset($_GET['adme_site_id'])) {
    		$adme_site_id=$id_site_par_defaut;
    	} else {
    		$adme_site_id=$_GET['adme_site_id'];
    	}
    }
    $form->setDefaults(array('adme_site_id' => $adme_site_id));
    
    $retour ='';
    $retour .= '<h1>'.ADME_LG_MENU_TITRE.$site_nom.'</h1>'."\n";
    $retour .= $form->toHTML()."\n";
    
    //---------------------------------------------------------------------------------------------------------------
    // Gestion des menus classiques
    $retour .= '<p>'."\n";
    $objet_pear_url_copie = $objet_pear_url;
    $objet_pear_url_copie->addQueryString('adme_action', ADME_LG_ACTION_CLASSIQUE_AJOUTER);
    $objet_pear_url_copie->addQueryString('adme_site_id', $adme_site_id);
    $objet_pear_url_copie->addQueryString('adme_menu_id', 0);
    $url_ajout_menu_classique_n1 = $objet_pear_url_copie->getURL();
    //unset($url_ajout_menu_n1);
    $retour .=    '<a href="'.$url_ajout_menu_classique_n1.'" >'.
                            ADME_LG_MENU_CLASSIQUE_RACINE.'&nbsp;'.
                            '<img class="'.ADME_CLASS_IMG_ICONE.'" src="'.ADME_IMAGE_NOUVEAU.'" alt="+" />'.
                        '</a>'."\n";
    $retour .= '</p>'."\n";
    
    $retour .= ADME_afficherListeMenuClassique($objet_pear_db, $objet_pear_url, $adme_site_id, $adme_menu_id, $adme_action, 0);
    
    
    //---------------------------------------------------------------------------------------------------------------
    // Gestion des menus communs
    $retour .=     '<p>'."\n";
    $objet_pear_url_copie = $objet_pear_url;
    $objet_pear_url_copie->addQueryString('adme_action', ADME_LG_ACTION_COMMUN_AJOUTER);
    $objet_pear_url_copie->addQueryString('adme_site_id', $adme_site_id);
    $objet_pear_url_copie->addQueryString('adme_menu_id', 0);
    $url_ajout_menu_commun_n1 = $objet_pear_url_copie->getURL();
    //unset($url_ajout_menu_n1);
    $retour .=     '<a href="'.$url_ajout_menu_commun_n1.'">'.
                            ADME_LG_MENU_COMMUN_RACINE.'&nbsp;'.
                            '<img class="'.ADME_CLASS_IMG_ICONE.'" src="'.ADME_IMAGE_NOUVEAU.'" alt="+" />'.
                        '</a>'."\n";
    $retour .=     '</p>'."\n";
    $retour .= ADME_afficherListeMenuCommun($objet_pear_db, $objet_pear_url, $adme_site_id, $adme_menu_id, $adme_action, 0);
    return $retour;
}
// +------------------------------------------------------------------------------------------------------+
// |                                            PIED du PROGRAMME                                         |
// +------------------------------------------------------------------------------------------------------+


/* +--Fin du code ----------------------------------------------------------------------------------------+
*
* $Log: adme_general.fonct.php,v $
* Revision 1.20  2007-10-24 14:43:02  ddelon
* Gestion des menus reservés à une langue
*
* Revision 1.19  2007-04-19 15:34:35  neiluj
* préparration release (livraison) "Narmer" - v0.25
*
* Revision 1.18  2006/10/16 15:49:07  ddelon
* Refactorisation code mulitlinguisme et gestion menu invisibles
*
* Revision 1.17  2006/10/06 13:38:45  florian
* ergonomie amélioree
*
* Revision 1.16  2006/04/28 12:41:49  florian
* corrections erreurs chemin
*
* Revision 1.15  2006/03/24 13:03:24  ddelon
* bug afficheur multilinguisme
*
* Revision 1.14  2006/03/23 20:24:59  ddelon
* *** empty log message ***
*
* Revision 1.13  2006/03/13 21:00:20  ddelon
* Suppression messages d'erreur multilinguisme
*
* Revision 1.12  2006/03/02 10:49:49  ddelon
* Fusion branche multilinguisme dans branche principale
*
* Revision 1.11.2.1  2006/02/28 14:02:11  ddelon
* Finition multilinguisme
*
* Revision 1.11  2005/07/18 16:14:32  ddelon
* css admin + menu communs
*
* Revision 1.10  2005/07/08 21:57:24  ddelon
* Copyright
*
* Revision 1.9  2005/05/12 16:51:37  alex
* Changement de l'odre d'apparition des sites dans l'administration des menus.
*
* Revision 1.8  2005/01/26 16:18:05  jpm
* Correction bogue 221 : mauvais r�glage du titre.
*
* Revision 1.7  2004/11/24 11:31:51  jpm
* Ajout d'une contante de langue � la place d'un texte.
*
* Revision 1.6  2004/11/10 17:26:07  jpm
* Fin gestion de la traduction.
*
* Revision 1.5  2004/11/10 11:58:54  jpm
* Mise en place des constantes de traduction de l'appli.
*
* Revision 1.4  2004/11/09 17:48:35  jpm
* Gestion de diff�rentes interfaces d'administration.
*
* Revision 1.3  2004/11/09 12:37:34  jpm
* Fin de gestion des menus et mise en conformit� avec la convention de codage.
*
* Revision 1.2  2004/11/08 17:41:07  jpm
* L�g�res corrections : multisite, corrections SQL.
*
* Revision 1.1  2004/11/04 12:26:42  jpm
* Contient les fonctions d'affichage g�n�ral de l'appli ADME.
*
*
* +-- Fin du code ----------------------------------------------------------------------------------------+
*/
?>