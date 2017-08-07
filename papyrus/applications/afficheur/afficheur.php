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
// CVS : $Id: afficheur.php,v 1.14 2007-06-26 15:38:39 jp_milcent Exp $
/**
* Application réalisant l'affichage du contenu stocké dans Papyrus.
*
* Récupère le dernier contenu lié à un menu et le retourne.
*
*@package Afficheur
//Auteur original :
*@author        Jean-Pascal MILCENT <jpm@tela-botanica.org>
//Autres auteurs :
*@author        Alexandre GRANIER <alexandrel@tela-botanica.org>
*@copyright     Tela-Botanica 2000-2004
*@version       $Revision: 1.14 $ $Date: 2007-06-26 15:38:39 $
// +------------------------------------------------------------------------------------------------------+
*/

// +------------------------------------------------------------------------------------------------------+
// |                                            ENTÊTE du PROGRAMME                                       |
// +------------------------------------------------------------------------------------------------------+
/** Inclusion du fichier de configuration de cette application.*/
require_once GEN_CHEMIN_PAP.'applications/afficheur/configuration/affi_configuration.inc.php';
// Inclusion de la bibliothèque PEAR Text_Wiki réalisées par Papyrus.

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

function afficherContenuCorps() {
	$retour = '';
    $db = $GLOBALS['_AFFICHEUR']['objet_pear_db'];
	$id_or = GEN_rechercheMenuCode($db, GEN_rechercheMenuIdentifiant($db, $GLOBALS['_AFFICHEUR']['menu_courant_id']));

    $ligne_contenu = GEN_rechercheContenu($db, $id_or);
	        
	$contenu = $ligne_contenu->gmc_contenu;
	
	// Inclusion de la bibliothèque Text_Wiki_Papyrus effectuées par Papyrus précédement
	// Les actions Text_Wiki_Papyrus sont gérées par Papyrus
	
	// Nous regardons si nous avons à faire à un texte sous format Wikini ou XHTML
	if (($ligne_contenu->gmc_ce_type_contenu == 1)||(substr($ligne_contenu->gmc_ce_type_contenu,-1)== 1)) {
	    $retour = $contenu;
	} elseif (($ligne_contenu->gmc_ce_type_contenu == 2) || (substr($ligne_contenu->gmc_ce_type_contenu,-1)== 2)){
	    include_once AFFI_CHEMIN_BIBLIOTHEQUE_API.'text/wiki_wikini/Wikini.class.php';
	    // Création d'un objet Text_Wikini :
	    $wikini = new Text_Wikini();
	    // Pour éviter de remplacer les caractères spéciaux du XHTML:
	    $wikini->setFormatConf('Xhtml', 'translate', false);
	    // Configuration de la règle Freelink :
	    $wikini->setRenderConf('Xhtml', 'freelink', 'pages', null);
	    $wikini->setRenderConf('Xhtml', 'freelink', 'view_url', AFFI_URL_PAPYRUS);
	    // Configuration de la règle Interwiki :
	    $wikini->setRenderConf('Xhtml', 'interwiki', 'sites', $GLOBALS['_AFFICHEUR']['interwiki_sites']);
	    // Application des règles de Wikini :
	    $retour = $wikini->transform($contenu, 'Xhtml');
	}
  
    //----------------------------------------------------------------------------
    // Renvoie du contenu de la page
    return $retour;
}
	


/** Fonction afficherContenuCorps() - Fonction appelé par le gestionnaire Papyrus.
*
* Elle retourne le contenu stocké dans Papyrus pour le menu courant demandé.
*
* @return  string  du code XHTML correspondant au contenu du menu demandé.
*/
function afficherContenuCorpsOld()
{
    //----------------------------------------------------------------------------
    // Initialisation des variable
    $retour = '';
    
    $id_langue = $GLOBALS['_GEN_commun']['i18n'];
    
    if (isset($id_langue) && ($id_langue!='')) {
		$langue_test=$id_langue;
	} else {
		$langue_test=GEN_I18N_ID_DEFAUT;
	}

	//-------------------------------------------------------------------------------------------------------------------
        // Récupération des informations du contenu concerné.
     $ligne_menu = GEN_lireInfoMenu($GLOBALS['_AFFICHEUR']['objet_pear_db'], $GLOBALS['_AFFICHEUR']['menu_courant_id'], DB_FETCHMODE_ASSOC);
        
        
     if ($ligne_menu == false) {
            die('ERREUR Papyrus Administrateur de Menus: impossible de lire les infos du menu.<br />'.
                'Idenitifiant du menu n° : '. $GLOBALS['_AFFICHEUR']['objet_pear_db'] .'<br />'.
                'Ligne n° : '. __LINE__ .'<br />'.
                'Fichier n° : '. __FILE__ .'<br />');
     }
        

    // Comment ca marche ?
    // Historiquement, le code menu est associé au contenu
    // Depuis le passage au multilinguisme : ce comportement est conservé mais :
    // Tout nouveau contenu, contient également l'information code gm_id_menu, enfoui dans le 
    // type contenu.
    
    // Récupération identifiant du menu en cours 
    
    $requete =  'SELECT gm_id_menu, gm_code_num   '.
                'FROM gen_menu  '.
                'WHERE gm_code_num =  '.$ligne_menu['gm_code_num'].' '.
                'AND gm_ce_i18n = "'.$langue_test.'" ';

	$resultat = $GLOBALS['_AFFICHEUR']['objet_pear_db']->query($requete);
	
	(DB::isError($resultat)) ? die(BOG_afficherErreurSql(__FILE__, __LINE__, $resultat->getMessage(), $requete)) : '';
	if ( $resultat->numRows() > 0 ) {
	
			$ligne = $resultat->fetchRow(DB_FETCHMODE_OBJECT);
	}
	else {
	
	// Recherche defaut :

	$requete =  'SELECT gm_id_menu, gm_code_num   '.
                'FROM gen_menu  '.
                'WHERE gm_code_num =  '.$ligne_menu['gm_code_num'].' ';
                'AND gm_ce_i18n = "'.GEN_I18N_ID_DEFAUT.'" ';

		$resultat = $GLOBALS['_AFFICHEUR']['objet_pear_db']->query($requete);

	(DB::isError($resultat)) ? die(BOG_afficherErreurSql(__FILE__, __LINE__, $resultat->getMessage(), $requete)) : '';
		
		$ligne = $resultat->fetchRow(DB_FETCHMODE_OBJECT);
		
			if ($langue_test!=GEN_I18N_ID_DEFAUT) {
		
			    $requete_defaut =   'SELECT gmr_id_menu_02 as gm_id_menu , ' . $ligne->gm_code_num . ' as gm_code_num '.
	                            	'FROM  gen_menu_relation '.
	                            	'WHERE '.$ligne->gm_id_menu. ' = gmr_id_menu_01 ' .
	                            	'AND  gmr_id_valeur  = 105 ';// 105 Traduction par defaut
				$resultat_defaut = $GLOBALS['_AFFICHEUR']['objet_pear_db']->query($requete_defaut);
				(DB::isError($resultat_defaut))             ? die(BOG_afficherErreurSql(__FILE__, __LINE__, $resultat_defaut->getMessage(), $requete_defaut))
				: '';
				if ($resultat_defaut->numRows() > 0) {
						$ligne=$resultat_defaut->fetchRow(DB_FETCHMODE_OBJECT);
				}
			}
		}  

	// Cas historique : ce menu n'a jamais été traduit.
	$requete =  'SELECT gmc_contenu , gmc_ce_type_contenu '.
	                'FROM gen_menu_contenu  '.
	                'WHERE gmc_ce_menu = '.$ligne->gm_id_menu.' '.
	                'AND gmc_ce_type_contenu in (1,2) '.
	                'AND gmc_bool_dernier = 1';
	
	$resultat = $GLOBALS['_AFFICHEUR']['objet_pear_db']->query($requete);
	(DB::isError($resultat)) ? die(BOG_afficherErreurSql(__FILE__, __LINE__, $resultat->getMessage(), $requete)) : '';
	
	
	// Rien trouvé ? : Migration multilinguisme ou pas encore de contenu 
	
	if ( $resultat->numRows() == 0 ) {
	
		
	    // Migration multilinguisme 
	     
	    $requete =  'SELECT gmc_contenu , gmc_ce_type_contenu '.
	                'FROM gen_menu_contenu  '.
	                'WHERE gmc_ce_menu = '.$ligne_menu['gm_code_num'].' '.
	                'AND truncate((gmc_ce_type_contenu/10),0) = '. $ligne->gm_id_menu . ' '.
	                'AND gmc_bool_dernier = 1';
	    
	    $resultat = $GLOBALS['_AFFICHEUR']['objet_pear_db']->query($requete);
	    (DB::isError($resultat)) ? die(BOG_afficherErreurSql(__FILE__, __LINE__, $resultat->getMessage(), $requete)) : '';
	
		// Pas de contenu, tentative de recuperation du contenu se 
			
		if ( $resultat->numRows() == 0 ) {
			
					
	
						    $requete =   'SELECT gmr_id_menu_02 as gm_id_menu , ' . $ligne->gm_code_num . ' as gm_code_num '.
				                            	'FROM  gen_menu_relation '.
				                            	'WHERE '.$ligne->gm_id_menu. ' = gmr_id_menu_01 ' .
				                            	'AND  gmr_id_valeur  = 105 ';// 105 Traduction par defaut
				                            	
							$resultat = $GLOBALS['_AFFICHEUR']['objet_pear_db']->query($requete);
							
				                            	
							(DB::isError($resultat))             ? die(BOG_afficherErreurSql(__FILE__, __LINE__, $resultat->getMessage(), $requete))
							: '';

						
					    $requete =  'SELECT gmc_contenu , gmc_ce_type_contenu '.
		                'FROM gen_menu_contenu, gen_menu_relation '.
		                'WHERE truncate((gmc_ce_type_contenu/10),0) = gmr_id_menu_01 '.
		                'AND '.$ligne->gm_id_menu.' = gmr_id_menu_02 '.
		                'AND gmr_id_valeur = 2 '.
		                'AND gmc_bool_dernier = 1';

					    $resultat = $GLOBALS['_AFFICHEUR']['objet_pear_db']->query($requete);
					    (DB::isError($resultat)) ? die(BOG_afficherErreurSql(__FILE__, __LINE__, $resultat->getMessage(), $requete)) : '';

/*   
	
						    $requete =   'SELECT gmr_id_menu_02 as gm_id_menu , ' . $ligne->gm_code_num . ' as gm_code_num '.
				                            	'FROM  gen_menu_relation '.
				                            	'WHERE '.$ligne->gm_id_menu. ' = gmr_id_menu_01 ' .
				                            	'AND  gmr_id_valeur  = 105 ';// 105 Traduction par defaut
				                            	
							$resultat = $GLOBALS['_AFFICHEUR']['objet_pear_db']->query($requete);
							print_r ($requete);
							
				                            	
							(DB::isError($resultat))             ? die(BOG_afficherErreurSql(__FILE__, __LINE__, $resultat->getMessage(), $requete))
							: '';
*/
									
				}
				// Toujours rien ?
					
				if ( $resultat->numRows() == 0 ) {
					
						$requete =  'SELECT gmc_contenu , gmc_ce_type_contenu '.
	                	'FROM gen_menu_contenu  '.
	                	'WHERE gmc_ce_menu = '.$ligne->gm_code_num.' '.
	                	'AND gmc_ce_type_contenu in (1,2) '.
	                	'AND gmc_bool_dernier = 1';
					                
					                
					    $resultat = $GLOBALS['_AFFICHEUR']['objet_pear_db']->query($requete);
					    (DB::isError($resultat)) ? die(BOG_afficherErreurSql(__FILE__, __LINE__, $resultat->getMessage(), $requete)) : '';
	    
									
				}
				
		}
			
		 $ligne_contenu = $resultat->fetchRow(DB_FETCHMODE_OBJECT);
	    
	        
	$contenu = $ligne_contenu->gmc_contenu;
	
	    // Inclusion de la bibliothèque Text_Wiki_Papyrus effectuées par Papyrus précédement
	    // Les actions Text_Wiki_Papyrus sont gérées par Papyrus
	    
	    // Nous regardons si nous avons à faire à un texte sous format Wikini ou XHTML
	    if (($ligne_contenu->gmc_ce_type_contenu == 1)||(substr($ligne_contenu->gmc_ce_type_contenu,-1)== 1)) {
	        $retour = $contenu;
	    } elseif (($ligne_contenu->gmc_ce_type_contenu == 2) || (substr($ligne_contenu->gmc_ce_type_contenu,-1)== 2)){
	        include_once AFFI_CHEMIN_BIBLIOTHEQUE_API.'text/wiki_wikini/Wikini.class.php';
	        // Création d'un objet Text_Wikini :
	        $wikini = new Text_Wikini();
	        // Pour éviter de remplacer les caractères spéciaux du XHTML:
	        $wikini->setFormatConf('Xhtml', 'translate', false);
	        // Configuration de la règle Freelink :
	        $wikini->setRenderConf('Xhtml', 'freelink', 'pages', null);
	        $wikini->setRenderConf('Xhtml', 'freelink', 'view_url', AFFI_URL_PAPYRUS);
	        // Configuration de la règle Interwiki :
	        $wikini->setRenderConf('Xhtml', 'interwiki', 'sites', $GLOBALS['_AFFICHEUR']['interwiki_sites']);
	        // Application des règles de Wikini :
	        $retour = $wikini->transform($contenu, 'Xhtml');
	    }

	// +---------------------------------------------------------------------------------------------------------------+
	// Nous regardons si nous voulons surligner ou pas des mots
	if (isset($_GET['var_recherche'])) {
		$tab_mots = explode(' ', rawurldecode($_GET['var_recherche']));
		foreach ($tab_mots as $mot) {
			if (strlen($mot) >= 2) {
				$regexp = '/(>[^<]*)('.$mot.'\b)/Uis';
				$retour = preg_replace($regexp, '$1<span class="surlignage">$2</span>', $retour);
			}
		}
	}

    //----------------------------------------------------------------------------
    // Renvoie du contenu de la page
    return $retour;
}
// +------------------------------------------------------------------------------------------------------+
// |                                           LISTE de FONCTIONS                                         |
// +------------------------------------------------------------------------------------------------------+



// +------------------------------------------------------------------------------------------------------+
// |                                            PIED du PROGRAMME                                         |
// +------------------------------------------------------------------------------------------------------+



/* +--Fin du code ----------------------------------------------------------------------------------------+
*
* $Log: afficheur.php,v $
* Revision 1.14  2007-06-26 15:38:39  jp_milcent
* Ajout de la gestion de l'historique du contenu.
* Réédition possible des versions archivées du contenu.
*
* Revision 1.13  2006-11-21 18:52:20  jp_milcent
* Ajout de la possibilité de surligner des mots.
*
* Revision 1.12  2006/11/21 15:50:05  jp_milcent
* Ajout du surlignage des mots passé dans la query string via la variable var_recherche.
*
* Revision 1.11  2006/10/16 15:49:07  ddelon
* Refactorisation code mulitlinguisme et gestion menu invisibles
*
* Revision 1.10  2006/06/29 15:12:26  ddelon
* Multilinguisme : contenu par defaut
*
* Revision 1.9  2006/03/27 10:50:24  ddelon
* Still some pb
*
* Revision 1.7  2006/03/13 21:00:20  ddelon
* Suppression messages d'erreur multilinguisme
*
* Revision 1.6  2006/03/02 10:49:49  ddelon
* Fusion branche multilinguisme dans branche principale
*
* Revision 1.5.2.3  2006/03/02 00:22:23  ddelon
* bug afficheur multilinguisme
*
* Revision 1.5.2.2  2006/03/01 23:51:07  ddelon
* bug afficheur multilinguisme
*
* Revision 1.5.2.1  2006/02/28 14:02:11  ddelon
* Finition multilinguisme
*
* Revision 1.5  2005/04/21 16:46:17  jpm
* Gestion via Papyrus du XHTML.
*
* Revision 1.4  2005/02/22 18:25:13  jpm
* Déplacement d'un message d'alerte en cas d'erreur sql.
*
* Revision 1.3  2004/12/07 12:24:30  jpm
* Changement chemin d'accés à l'api Text/Wiki...
*
* Revision 1.2  2004/11/26 13:10:05  jpm
* Utilisation des actions Papyrus et implémentation de la syntaxe Wikini.
*
* Revision 1.1  2004/06/16 14:35:26  jpm
* Changement de nom de Génésia en Papyrus.
* Changement de l'arborescence.
*
* Revision 1.12  2004/05/05 11:35:12  jpm
* Amélioration de la gestion de l'internationalisation.
*
* Revision 1.11  2004/05/05 06:45:40  jpm
* Suppression de l'appel de la fonction générant le "vous êtes ici" dans la fonction affichant l'entête de l'application.
*
* Revision 1.10  2004/05/04 16:28:22  jpm
* Réduction de code pour la fonction afficherContenuTete().
*
*
* +-- Fin du code ----------------------------------------------------------------------------------------+
*/
?>
