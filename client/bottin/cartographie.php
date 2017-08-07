<?php

//vim: set expandtab tabstop=4 shiftwidth=4: 
// +-----------------------------------------------------------------------------------------------+
// | PHP version 4.0                                                                               |
// +-----------------------------------------------------------------------------------------------+
// | Copyright (c) 1997, 1998, 1999, 2000, 2001 The PHP Group                                      |
// +-----------------------------------------------------------------------------------------------+
// | This source file is subject to version 2.0 of the PHP license,                                | 
// | that is bundled with this package in the file LICENSE, and is                                 |
// | available at through the world-wide-web at                                                    |
// | http://www.php.net/license/2_02.txt.                                                          |
// | If you did not receive a copy of the PHP license and are unable to                            |
// | obtain it through the world-wide-web, please send a note to                                   |
// | license@php.net so we can mail you a copy immediately.                                        |
// +-----------------------------------------------------------------------------------------------+
/**
*
*Page permettant l'affichage des informations de cartographie des inscrits
*
*@package cartographie
//Auteur original :
*@author                Alexandre GRANIER <alexandre@tela-botanica.org>
//Autres auteurs :
*@copyright         Tela-Botanica 2000-2004
*@version             03 mai 2004
// +-----------------------------------------------------------------------------------------------+
//
// $Id: cartographie.php,v 1.9 2007/04/11 08:30:12 neiluj Exp $
// FICHIER : $RCSfile: cartographie.php,v $
// AUTEUR    : $Author: neiluj $
// VERSION : $Revision: 1.9 $
// DATE        : $Date: 2007/04/11 08:30:12 $
*/
include_once PAP_CHEMIN_RACINE.'/client/bottin/configuration/bottin.config.inc.php';
include_once INS_CHEMIN_APPLI.'configuration/cartographie.config.inc.php';
include_once INS_CHEMIN_APPLI.'bibliotheque/bottin.fonct.php';
include_once INS_CHEMIN_APPLI.'bibliotheque/lib.carto.php';

//================================================================================================
if ( isset($_GET['voir_fiche']) or isset($_GET['voir_abonnement']) or isset($_GET['voir_actus']) or isset($_GET['voir_ressources']) or isset($_GET['voir_competences']) ) {
	//---------------le menu de l'appli-----------
	function afficherContenuNavigation () {
		$res =inscription_onglets();
		return $res ;
	}
}

//================================================================================================
function construit_hierarchie(&$info_zone, &$carto_config, $info_zone_hierarchie, &$monde) {
	static $i=0;
	$i++;
	
	//on ajoute la carto en cours en tant que fils
	$monde->ajouterFils($info_zone_hierarchie->czh_code_alpha, $info_zone_hierarchie->czh_identifiant_table_info_couleur,
						$info_zone_hierarchie->czh_nom, $info_zone_hierarchie->czh_fichier_masque,
						$info_zone_hierarchie->czh_fichier_image, '');
	$monde->fils[$info_zone_hierarchie->czh_code_alpha]->definirCouleurs ('255', '255', '255','255', '250', '130','255', '204', '0','255', '153', '0') ;
			    		
	//requete pour trouver les fils de la carte de depart voulue
	$requete_zone_fils = 'SELECT * FROM carto_zone_hierarchie '.
						 'WHERE czh_id_zone_pere='.$info_zone_hierarchie->czh_id_zone;/*echo $requete_zone_fils;*/
	$resultat_zone_fils = $GLOBALS['ins_db']->query($requete_zone_fils) ;
	if (DB::isError($resultat_zone_fils )) {
    	echo ($resultat_zone_fils->getMessage().'<br />'.$resultat_zone_fils->getDebugInfo()).'<br />'.$requete_zone_fils ;
	}
	
	if ($resultat_zone_fils->numRows()!=0) {
		while ($ligne_zone_fils  = $resultat_zone_fils ->fetchRow(DB_FETCHMODE_OBJECT)) {
			//requete pour obtenir toutes les infos (repartition par zones, nom des tables et champs pour les couleurs,.. ) pour la carte à afficher
			$requete_01 = 'SELECT '.$ligne_zone_fils->czh_nom_champs_id_pere.',count('.$ligne_zone_fils->czh_nom_champs_id_pere.') AS nbr'.
			    		  ' FROM '.$carto_config['cc_table1'].', '.$ligne_zone_fils->czh_nom_table_info_couleur;
			if ($carto_config['cc_table2']!=0) $requete_01 .=  ', '.$carto_config['cc_table2'];     
			$requete_01 .= ' WHERE '.$ligne_zone_fils->czh_champs_jointure_annuaire.' = '.$ligne_zone_fils->czh_nom_champs_id;
			if ($carto_config['cc_sql']!='') $requete_01 .=  ' AND ('.$carto_config['cc_sql'].')';
			$requete_01 .= ' GROUP BY '.$ligne_zone_fils->czh_nom_champs_id_pere;
			$resultat_01 = $GLOBALS['ins_db']->query($requete_01) ;
			if (DB::isError($resultat_01)) {
			    echo ($resultat_01->getMessage().'<br />'.$resultat_01->getDebugInfo()).'<br />'.$requete_01 ;
			}    
			$tableau_repartition=array();    
			while ($ligne_01 = $resultat_01->fetchRow(DB_FETCHMODE_OBJECT)) {
				$id=$ligne_zone_fils->czh_nom_champs_id_pere;
			    $tableau_repartition[$ligne_01->$id] = $ligne_01->nbr; 		
			}
			$info_zone[$i]['nom_table_zone'] =$info_zone_hierarchie->czh_nom_table_info_couleur;
			$info_zone[$i]['nom_chp_id_zone'] =$info_zone_hierarchie->czh_nom_champs_id;
			$info_zone[$i]['nom_chp_nom_zone'] =$info_zone_hierarchie->czh_nom_champs_intitule;
			$info_zone[$i]['nom_chp_rouge'] =$info_zone_hierarchie->czh_nom_champs_couleur_R;
			$info_zone[$i]['nom_chp_vert'] =$info_zone_hierarchie->czh_nom_champs_couleur_V;
			$info_zone[$i]['nom_chp_bleu'] =$info_zone_hierarchie->czh_nom_champs_couleur_B;
			$info_zone[$i]['nom_chp_zone_sup'] =$info_zone_hierarchie->czh_nom_champs_id_pere;
			$info_zone[$i]['tableau_valeurs_zone'] = $tableau_repartition;
			if ($i == 1) {				
				$monde->_info_table_zg = $info_zone[1];		    
				$monde->definirCouleurs('255', '255', '255','255', '250', '130','255', '204', '0','255', '153', '0') ;
				construit_hierarchie($info_zone, $carto_config, $ligne_zone_fils, $monde);						
			} else {
				$monde->_info_table_zg = $info_zone[$i];	
	    		construit_hierarchie($info_zone, $carto_config, $ligne_zone_fils, $monde->fils[$info_zone_hierarchie->czh_code_alpha]);
			}					
		}								
	}
}

function afficherContenuCorps() {
    global $image_x;
    global $image_y;
    global $historique_cartes;
    global $mailer;
    global $fin;
    global $sendpwd;//utilisé dans liste_inscrit.php
    global $select;//utilisé dans liste_inscrit.php
    global $liste_zone_carte;
    
	//=================================================================================================
	//Gestion de la configuration    
    $requete = 'SELECT * FROM carto_config WHERE cc_menu_id='.$GLOBALS['_GEN_commun']['info_menu']->gm_id_menu;
    $resultat = $GLOBALS['ins_db']->query($requete) ;
    if (DB::isError($resultat)) {
       	die ("Echec de la requete<br />".$resultat->getMessage()."<br />".$resultat->getDebugInfo()) ;
    }
    if ($resultat->numRows()>0) {
    	$carto_config = $resultat->fetchRow(DB_FETCHMODE_ASSOC);
        
	   	//on affiche les infos lorsqu'on regarde une fiche
	   	if ( isset($_GET['voir_fiche']) or isset($_GET['voir_abonnement']) or isset($_GET['voir_actus']) or isset($_GET['voir_ressources']) or isset($_GET['voir_competences']) ) {
	   		$res = affiche_onglet_info();
	   	} else {            		    	
			//requete pour afficher la carte de depart voulue dans la conf. 
			$requete_zone_hierarchie = 'SELECT * FROM carto_zone_hierarchie WHERE czh_id_zone='.$carto_config['cc_ce_premiere_carte'];
			$resultat_zone_hierarchie = $GLOBALS['ins_db']->query($requete_zone_hierarchie) ;
			if (DB::isError($resultat_zone_hierarchie )) {
		    	echo ($resultat_zone_hierarchie->getMessage().'<br />'.$resultat_zone_hierarchie->getDebugInfo()) ;
			}    
			$ligne_zone_hierarchie  = $resultat_zone_hierarchie ->fetchRow(DB_FETCHMODE_OBJECT);
			
			//initialisation de la variable 2 dimensions, contenant les infos specifiques a chaque echelle de territoire 
	    	$info_zone= array();
	    	$monde = new Carto_Carte($ligne_zone_hierarchie->czh_code_alpha, '', $ligne_zone_hierarchie->czh_nom, 
	    							 $ligne_zone_hierarchie->czh_fichier_masque, $ligne_zone_hierarchie->czh_fichier_image,
			   		                 INS_CHEMIN_APPLI.'presentations/fonds/', '');
			construit_hierarchie($info_zone, $carto_config, $ligne_zone_hierarchie, $monde);				
			echo '<pre>'.var_dump($monde).'</pre>';
				
				//requete 
	//			$requete_02 = 'SELECT CC_ID_Continent FROM carto_CONTINENT';
	//		
	//		$resultat_02 = $GLOBALS['ins_db']->query($requete_02) ;
	//		if (DB::isError($resultat_02)) {
	//		    die ($resultat_02->getMessage().'<br />'.$resultat_02->getDebugInfo()) ;
	//		}
	//		
	//		while ($ligne_02 = $resultat_02->fetchRow(DB_FETCHMODE_OBJECT)) {
	//		    $requete_03 = 'SELECT CP_ID_Pays, count(cp_id_pays) as nbr '.
	//		                  ' FROM '.$nom_table1.', carto_PAYS';
	//		    if ($nom_table2!=0) $requete_03 .=  ', '.$nom_table2;
	//		    $requete_03 .= ' WHERE '.$nom_champs_pays.'= cp_id_pays';
	//		    if ($requete_sql!='') $requete_03 .=  ' AND ('.$requete_sql.')';
	//		    $requete_03 .= ' AND cp_id_continent = "'.$ligne_02->CC_ID_Continent.'"'.
	//		                   ' GROUP BY cp_id_pays';
	//		    $resultat_03 = $GLOBALS['ins_db']->query($requete_03) ;
	//		    if (DB::isError($resultat_03)) {
	//		        die ($resultat_03->getMessage().'<br />'.$resultat_03->getDebugInfo()) ;
	//		    }
	//		    
	//		    $tableau_ad_pays = array();
	//		    while ($ligne_03 = $resultat_03->fetchRow(DB_FETCHMODE_OBJECT)) {
	//		        $tableau_ad_pays[$ligne_03->CP_ID_Pays] = $ligne_03->nbr; 
	//		    }
	//		    
	//		    $info_pays[$ligne_02->CC_ID_Continent]['nom_table_zone'] = 'carto_PAYS';
	//		    $info_pays[$ligne_02->CC_ID_Continent]['nom_chp_id_zone'] = 'CP_ID_Pays';
	//		    $info_pays[$ligne_02->CC_ID_Continent]['nom_chp_nom_zone'] = 'CP_Intitule_pays';
	//		    $info_pays[$ligne_02->CC_ID_Continent]['nom_chp_rouge'] = 'CP_Couleur_R';
	//		    $info_pays[$ligne_02->CC_ID_Continent]['nom_chp_vert'] = 'CP_Couleur_V';
	//		    $info_pays[$ligne_02->CC_ID_Continent]['nom_chp_bleu'] = 'CP_Couleur_B';
	//		    $info_pays[$ligne_02->CC_ID_Continent]['nom_chp_zone_sup'] = 'CP_ID_Continent';
	//		    $info_pays[$ligne_02->CC_ID_Continent]['tableau_valeurs_zone'] = $tableau_ad_pays;
			}
	//		//============================================================================================================
	//			//if (!isset($_POST['historique_cartes']) && INS_ECHELLE_DEPART!='france') {
	//				$requete_04 = 'SELECT CD_ID_Departement, count(cd_id_departement) as nbr'.
	//		    	    	      ' FROM '.$nom_table1.', carto_DEPARTEMENT'.
	//		        			  ' WHERE '.$nom_champs_pays.' = "fr"'.
	//							  ' AND SUBSTRING('.$nom_champs_cp.' FROM 1 FOR 2) = cd_id_Departement'.
	//		        			  ' GROUP BY cd_id_Departement';
	//		    	$resultat_04 = $GLOBALS['ins_db']->query ($requete_04) ;
	//		    	$tableau_ad_dpt_france = array();
	//		    	while ($ligne_04 = $resultat_04->fetchRow(DB_FETCHMODE_OBJECT)) {
	//		    		$tableau_ad_dpt_france[$ligne_04->CD_ID_Departement] = $ligne_04->nbr;
	//		    	}
	//		    	$info_dpt_france['nom_table_zone'] = 'carto_DEPARTEMENT';
	//		    	$info_dpt_france['nom_chp_id_zone'] = 'CD_ID_Departement';
	//		    	$info_dpt_france['nom_chp_nom_zone'] = 'CD_Intitule_departement';
	//		    	$info_dpt_france['nom_chp_rouge'] = 'CD_Couleur_R';
	//		    	$info_dpt_france['nom_chp_vert'] = 'CD_Couleur_V';
	//		    	$info_dpt_france['nom_chp_bleu'] = 'CD_Couleur_B';
	//		    	$info_dpt_france['nom_chp_zone_sup'] = 'CD_ID_Pays';
	//		    	$info_dpt_france['tableau_valeurs_zone'] = $tableau_ad_dpt_france;
	//		    //}    
	//		
			//============================================================================================================
			
			
			//============================================================================================================
			// On cree tout d'abord l'arborescence
			/*
			$monde = new Carto_Carte('continent', '', 'Monde', 'monde_masque5c.png', 'monde5c.png',
			                          INS_CHEMIN_APPLI.'presentations/fonds/', $info_zone[1]);    
			$monde->definirCouleurs('255', '255', '255','255', '250', '130','255', '204', '0','255', '153', '0') ;*/    
			if (isset($_POST['historique_cartes'])) {
				$monde->historique_cartes = $_POST['historique_cartes'];
			} else {
				$monde->historique_cartes = INS_ECHELLE_DEPART;
			}
			$monde->image_x = $image_x;
			$monde->image_y = $image_y;
			$monde->liste_zone_carte = $liste_zone_carte;
			$monde->url = $GLOBALS['ins_url']->getURL();
			/*
			foreach ($info_zone[2] as $cle => $valeur) {
			    $requete_05 = 
			        "SELECT CDC_Titre_carte, CDC_ID_Carte, CDC_Carte_fond, CDC_Carte_masque, CDC_ID_Zone_geo_carte".
			        " FROM carto_DESCRIPTION_CARTE, carto_ACTION ".
			        " WHERE CA_ID_Zone_geo = '$cle'".
			        " AND CA_Type_zone = 1".
			        " AND CA_ID_Carte_destination = CDC_ID_Carte";
			    
			    $resultat_05 = $GLOBALS['ins_db']->query ($requete_05) ;
			    if (DB::isError($resultat_05)) {
			        die ($resultat_05->getMessage().'<br />'.$resultat_05->getDebugInfo()) ;
			    }        
			    $ligne_05 = $resultat_05->fetchRow(DB_FETCHMODE_OBJECT);        
			    $monde->ajouterFils($ligne_05->CDC_ID_Carte, $ligne_05->CDC_ID_Zone_geo_carte, $ligne_05->CDC_Titre_carte, 
			                                    $ligne_05->CDC_Carte_masque, $ligne_05->CDC_Carte_fond, $valeur);
			    $monde->fils[$ligne_05->CDC_ID_Carte]->definirCouleurs ('255', '255', '255','255', '250', '130','255', '204', '0','255', '153', '0') ;
			}
			*/
			//$monde->fils['europe']->ajouterFils('france', 'fr', 'France' ,'france_masque.png', 'france.png', $info_zone[3]);
			//$monde->fils['europe']->fils['france']->definirCouleurs ('255', '255', '255','255', '250', '130','255', '204', '0','255', '153', '0') ;
			
			// Une fois l'arborescence créée on lance la methode donnerFormulaireImage() pour recuperer la carte
			// (dans $img). S'il n'y a pas de carte a afficher donnerFormulaireImage() renvoi false. On peut alors recuperer
			// le niveau ou on en est grace a $monde->historique (du type continent*namerique*ca).
			    
			$img = false;
			if ($mailer == 1 || $fin == true) {
			    $objet_carte = $_SESSION['carte'] ;
			    $monde = unserialize($objet_carte);}
			else {
			    $img = $monde->donnerFormulaireImage();
			}
			       
			// Quoi qu'il arrive, on ouvre la balise formulaire
			if ($carto_config['cc_titre_carto']!='') $res = '<h1>'.$carto_config['cc_titre_carto'].'</h1>'."\n";
			else $res = '<h1>'.INS_CARTOGRAPHIE.'</h1>'."\n";
			$res .= '<form name="formmail" action="'.$monde->url.'" method="post">'."\n";
			if ((INS_AFFICHE_ECHELLE)and($img)) {
			   	$historique_carte = new Carto_HistoriqueCarte ($monde, '&gt;', 'chemin_carto');
			   	$res .= $historique_carte->afficherHistoriqueCarte()."\n" ;
			}
			if (!$img ) {
				//include 'bibliotheque/cartographie.fonct.liste_inscrit.php';
			    $res .= carto_liste_fiches($monde, $carto_config['cc_table1'], $carto_config['cc_table2'], $carto_config['cc_pays'],$carto_config['cc_cp'], $carto_config['cc_sql']);
			    return $res;
			} else {
				$res .= $img;
			    $res .= '<p class="zone_info">'."\n";
				$res .= '<strong>'.INS_CLIQUER_ACCEDER.'</strong><br />'."\n";
			    $res .= INS_COULEUR."\n".'</p>'."\n";                
			}
			$res .= '</form>'."\n";
	        return $res;
	    
	//----------------------------------------------------------------------------------------------------------------------
	// Cas ou la carto n'a pas encore ete configuree        
    } else {
    	return '<p class="zone_alert">'.INS_FAUT_CONFIGURER_CARTO.'</p>'."\n";
    }
}


//-- Fin du code source    ------------------------------------------------------------
/*
* $Log: cartographie.php,v $
* Revision 1.9  2007/04/11 08:30:12  neiluj
* remise en Ã©tat du CVS...
*
* Revision 1.6  2006/12/01 13:23:17  florian
* integration annuaire backoffice
*
* Revision 1.5  2006/04/19 13:49:04  alexandre_tb
* correction de bug sur l'utilisation de l'id_menu de papyrus
*
* Revision 1.4  2006/04/10 14:01:36  florian
* uniformisation de l'appli bottin: plus qu'un fichier de fonctions
*
* Revision 1.3  2006/04/04 12:23:05  florian
* modifs affichage fiches, gÃ©nÃ©ricitÃ© de la carto, modification totale de l'appli annuaire
*
* Revision 1.2  2005/11/24 16:17:52  florian
* changement template inscription + modifs carto
*
* Revision 1.1  2005/09/22 14:02:49  ddelon
* nettoyage annuaire et php5
*
* Revision 1.2  2005/09/22 13:30:49  florian
* modifs pour compatibilitÃ© XHTML Strict + corrections de bugs (mais ya encore du boulot!!)
*
* Revision 1.1  2004/12/15 13:33:03  alex
* version initiale
*
* Revision 1.2  2004/06/18 08:48:03  alex
* améliorations diverses
*
* Revision 1.1  2004/06/09 13:56:47  alex
* corrections diverses
*
* Revision 1.9  2003/05/06 12:49:27  alex
* remplacement include par include_once
*
* Revision 1.8  2003/03/07 15:20:32  jpm
* Correction d'une erreur de texte.
*
* Revision 1.7  2003/02/28 08:43:33  jpm
* Gestion des nouvelles tables MySql carto.
*
* Revision 1.6  2003/02/21 13:50:19  jpm
* Mise à jour nouvel objet Carto_Carte.
*
* Revision 1.5  2003/02/17 14:33:52  jpm
* Modification pour être compatible avec la nouvelle classe carte.
*
*
*/
?>