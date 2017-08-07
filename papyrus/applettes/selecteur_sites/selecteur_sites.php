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
// CVS : $Id: selecteur_sites.php,v 1.12 2007-05-24 16:26:08 jp_milcent Exp $
/**
* Applette : selecteur sites
*
* Génère un formulaire contenant un menu déroulant permettant de choisir un site parmis les disponibles.
* Nécessite :
* - Constantes et globales de Papyrus.
* - Base de données de Papyrus
* - Pear Net_URL
* - Pear DB
* - API Débogage 1.0
* Le nom de l'applette est "SELECTEUR_SITES" pour afficher un formulaire HTML et "SELECTEUR_SITES_XHTML" 
* pour afficher un formulaire XHTML strict.
*
*@package Applette
*@subpackage Selecteur_sites
//Auteur original :
*@author        Jean-Pascal MILCENT <jpm@tela-botanica.org>
//Autres auteurs :
*@author        Aucun
*@copyright     Tela-Botanica 2000-2004
*@version       $Revision: 1.12 $ $Date: 2007-05-24 16:26:08 $
// +------------------------------------------------------------------------------------------------------+
*/

// +------------------------------------------------------------------------------------------------------+
// |                                            ENTÊTE du PROGRAMME                                       |
// +------------------------------------------------------------------------------------------------------+
$GLOBALS['_GEN_commun']['info_applette_nom_fonction'] = 'afficherSelecteurSite';
$GLOBALS['_GEN_commun']['info_applette_balise'] = '<!-- '.$GLOBALS['_GEN_commun']['balise_prefixe'].'(SELECTEUR_SITES_?(XHTML)?_?(SANS_(?:\d+_?)+)?) -->';


/** Inclusion du fichier de configuration de cette applette.*/
require_once GEN_CHEMIN_APPLETTE.'selecteur_sites'.GEN_SEP.'configuration'.GEN_SEP.'sesi_config.inc.php';

// Inclusion des fichiers de traduction de l'applette.
if (file_exists(SESI_CHEMIN_LANGUE.'sesi_langue_'.$GLOBALS['_GEN_commun']['i18n'].'.inc.php')) {
    /** Inclusion du fichier de traduction suite à la transaction avec le navigateur.*/
    require_once SESI_CHEMIN_LANGUE.'sesi_langue_'.$GLOBALS['_GEN_commun']['i18n'].'.inc.php';
} else {
    /** Inclusion du fichier de traduction par défaut.*/
    require_once SESI_CHEMIN_LANGUE.'sesi_langue_'.SESI_I18N_DEFAUT.'.inc.php';
}

// +------------------------------------------------------------------------------------------------------+
// |                                            CORPS du PROGRAMME                                        |
// +------------------------------------------------------------------------------------------------------+

// +------------------------------------------------------------------------------------------------------+
// |                                           LISTE de FONCTIONS                                         |
// +------------------------------------------------------------------------------------------------------+
/** Fonnction GEN_afficherContenuApplette() - Fournit un formulaire de sélection des sites.
*
* Renvoie un formulaire permettant de passer de site en site pour une langue donnée.
* Le formulaire affiche les noms des sites en fonctions de la langue passée dans l'url.
* Necessite l'utilisation de Pear Net_URL par le programme appelant cette fonction.
*
* @param  array  tableau d'éventuel arguments présent dans la balise transmis à la fonction. 
* @param  array  tableau global de Papyrus.
* @return   string  formulaire XHTML contenant les sites disponibles.
*/
function afficherSelecteurSite($tab_applette_arguments, $_GEN_commun)
{
    // Initialisation de variable de configuration.
    $liste_type_site = '102, 103';// Les id des types des sites pouvant apparaître dans le sélecteur
    $objet_pear_db = $_GEN_commun['pear_db'];//objet Pear créé par DB contenant la connexion à la base de données.
    $code_site = $_GEN_commun['url_site'];//identifiant du site courant.
    $id_langue = $_GEN_commun['i18n'];//identifiant de la langue choisie
    $url_base = PAP_URL;
    $url_cle_site = GEN_URL_CLE_SITE;
    $url_cle_i18n = GEN_URL_CLE_I18N;
    $url_id_type_site = GEN_URL_ID_TYPE_SITE;
    
    
    $indent_origine = 12;// Indentation de départ en nombre d'espace
    $indent_pas     = 4;// Pas d'indentation en nombre d'espace
    
    // Récupérations des arguments passés dans la balise.
    // Nous vérifions si on veut du XHTML strict ou pas
    $bln_xhtml_strict = 0;
    if (isset($tab_applette_arguments[2]) && $tab_applette_arguments[2] == 'XHTML') {
        $bln_xhtml_strict = 1;
    }
    // Nous vérifions s'il y a des sites que nous ne voulons pas afficher:
    $morceau_requete_id_suppr = '';
    $tab_id_suppr_groupe = '';
    if (isset($tab_applette_arguments[3]) && ereg('SANS_(.+)', $tab_applette_arguments[3], $tab_id_suppr_groupe)) {
        if (preg_match('/^\d+$/', $tab_id_suppr_groupe[1])) {
            $liste_id_suppr = $tab_id_suppr_groupe[1];
        } else if (preg_match('/^\d+(?:_\d+)+$/', $tab_id_suppr_groupe[1])) {
            $liste_id_suppr = preg_replace('/_/', ', ', $tab_id_suppr_groupe[1]);
        } else {
            $liste_id_suppr = '0';
        }
        $morceau_requete_id_suppr = 'AND gs_id_site NOT IN ('.$liste_id_suppr.') ';
    }
    
    // Recherche de tous les sites  langue en cours
    
    // On recherche l'ensemble des site en excluant le site admin ? (administration de Papyrus).

	if (isset($id_langue) && ($id_langue != '')) {
		$langue_test = $id_langue;
	} else {
		$langue_test = GEN_I18N_ID_DEFAUT;
	}
    
    $requete =  'SELECT gs_id_site, gs_code_num, gs_code_alpha, gs_nom, gs_ce_i18n '.
                'FROM gen_site, gen_site_relation '.
                'WHERE gsr_id_site_01 = gsr_id_site_02 '.
                'AND gs_id_site = gsr_id_site_01 '.
                'AND gsr_id_valeur IN ('.$liste_type_site.') '.
                'AND gs_ce_i18n = "'.$langue_test.'" '.
                $morceau_requete_id_suppr.// Liste des sites ne devant pas figurer
                'ORDER BY gs_code_num ASC';// 102 = site "principal" et 103 = site "externe"
                
    $resultat = $objet_pear_db->query($requete);
    (DB::isError($resultat)) ? die(BOG_afficherErreurSql(__FILE__, __LINE__, $resultat->getMessage(), $requete)) : '';
    
    $liste_site = array();
    
    while ($ligne = $resultat->fetchRow(DB_FETCHMODE_ASSOC)) {
    	         // Si le site trouvé est une traduction vers la langue principale, on ne le selectionne pas
    			if ($langue_test == GEN_I18N_ID_DEFAUT) {
    		  		$requete_est_traduction = 'SELECT gsr_id_site_01 '.
	                       'FROM  gen_site_relation '.
	                       'WHERE '.$ligne['gs_id_site'].' = gsr_id_site_02 ' .
	                  	   'AND  gsr_id_site_01 <> gsr_id_site_02 ' .
	                       'AND gsr_id_valeur = 1 ';// 1 = "avoir traduction"
	                                
		            $resultat_est_traduction = $objet_pear_db->query($requete_est_traduction);
		            (DB::isError($resultat_est_traduction))
		                ? die(BOG_afficherErreurSql(__FILE__, __LINE__, $resultat_est_traduction->getMessage(), $requete_est_traduction))
		                : '';
		                
		   			if ( $resultat_est_traduction->numRows() == 0 ) {
	    	 			$liste_site[] = $ligne;
		            }
    			}
    			else {
    				$liste_site[] = $ligne;
    			}
    }
    $resultat->free();

    // Si la langue en cours n'est pas la langue par défaut, recherche des sites ayant comme langue
    // la langue par defaut et non traduits dans la langue en cours.

    // On recherche l'ensemble des site en excluant le site admin (administration de Papyrus).
	if ($langue_test != GEN_I18N_ID_DEFAUT) {
    // Site ayant commme langue, la langue par defaut 
	    $requete =  'SELECT gs_id_site, gs_code_num, gs_code_alpha, gs_nom, gs_ce_i18n '.
	                'FROM gen_site, gen_site_relation '.
	                'WHERE gsr_id_site_01 = gsr_id_site_02 '.
	                'AND gs_id_site = gsr_id_site_01 '.
	                'AND gsr_id_valeur IN ('.$liste_type_site.') '.
	                'AND gs_ce_i18n = "'.GEN_I18N_ID_DEFAUT.'" '.
	                $morceau_requete_id_suppr.// Liste des sites ne devant pas figurer
	                'ORDER BY gs_code_num ASC';// 102 = site "principal" et 103 = site "externe"
	                
	    $resultat = $objet_pear_db->query($requete);
	    (DB::isError($resultat)) ? die(BOG_afficherErreurSql(__FILE__, __LINE__, $resultat->getMessage(), $requete)) : '';
	    
	    // Est il traduit ? Non, alors affichage 
	    while ($ligne = $resultat->fetchRow(DB_FETCHMODE_ASSOC)) {
				if (isset($id_langue) && ($id_langue != '')) {
					$langue_test=$id_langue;
				} else {
					$langue_test=GEN_I18N_ID_DEFAUT;
				}
			    
				$requete_est_traduction =   'SELECT gsr_id_site_01 '.
											'FROM  gen_site_relation '.
											'WHERE '.$ligne['gs_id_site'].' = gsr_id_site_02 ' .
	                            		    'AND  gsr_id_site_01 <> gsr_id_site_02 ' .
											'AND gsr_id_valeur = 1 ';// 1 = "avoir traduction"
	                                
	                                
	            $resultat_est_traduction = $objet_pear_db->query($requete_est_traduction);
	            (DB::isError($resultat_est_traduction))
	                ? die(BOG_afficherErreurSql(__FILE__, __LINE__, $resultat_est_traduction->getMessage(), $requete_est_traduction))
	                : '';
	                
	            if ( $resultat_est_traduction->numRows() == 0 ) {
		    		$requete_traduction =   'SELECT gsr_id_site_01 '.
		                                    'FROM  gen_site_relation, gen_site '.
		                                    'WHERE '.$ligne['gs_id_site'].' = gsr_id_site_01 ' .
		                                    'AND gsr_id_site_02 = gs_id_site '.
		                                    'AND gs_ce_i18n = "'.$langue_test.'" '.
		                                    'AND gsr_id_valeur = 1 ';// 1 = "avoir traduction"
		                                    
		            $resultat_traduction = $objet_pear_db->query($requete_traduction);
		            (DB::isError($resultat_traduction))
		                ? die(BOG_afficherErreurSql(__FILE__, __LINE__, $resultat_traduction->getMessage(), $requete_traduction))
		                : '';
		                
		            if ( $resultat_traduction->numRows() == 0 ) {
		            	$liste_site[] = $ligne;
		            }
		            
		            $resultat_traduction->free();
	            }
		    
	    }
	    $resultat->free();
	}
   
        
    if (count($liste_site) == 0 ) {
        $retour =  str_repeat(' ', $indent_origine + ($indent_pas * 0)).
                '<!-- '.SESI_LG_ETIQUETTE_VALIDER.' -->';
    } else {
        // Préparation de l'url de retour du formulaire
        $objet_pear_url =  new Pap_URL($url_base);
		$objet_pear_url->setPermalienBool(false);
		
        // Préparation du code du sites
        $champs_code_site = ($url_id_type_site == 'int') ? 'gs_code_num' : 'gs_code_alpha';
        
        // Préparation du formulaire
        $retour = str_repeat(' ', $indent_origine + ($indent_pas * 0)).
                '<form id="sesi_selecteur" ';
        // Test sur XHTML strict
        if ($bln_xhtml_strict == 0) {
            $retour .= 'name="sesi_selecteur" ';
        }
        $retour .= 'action="'.$objet_pear_url->getURL().'" method="get">'."\n";
        
        $retour .= str_repeat(' ', $indent_origine + ($indent_pas * 1)).
                '<fieldset>'."\n";
        $retour .= str_repeat(' ', $indent_origine + ($indent_pas * 2)).
                '<legend>'.SESI_LG_LEGENDE.'</legend>'."\n";
        $retour .= str_repeat(' ', $indent_origine + ($indent_pas * 2)).
                '<select id="sesi_'.$url_cle_site.'" name="'.$url_cle_site.'" onchange="javascript:this.form.submit();">'."\n";
        $retour .= str_repeat(' ', $indent_origine + ($indent_pas * 3)).
                '<option value="'.$code_site.'" selected="selected">'.SESI_LG_DEFAUT.'</option>'."\n";
        foreach ($liste_site as $ligne ) {
            // Initialisation des variables
            $nom = $ligne['gs_nom'];
            $retour .= str_repeat(' ', $indent_origine + ($indent_pas * 3)).
                    '<option value="'.$ligne[$champs_code_site].'">'.$nom.'</option>'."\n";
        }
        $retour .= str_repeat(' ', $indent_origine + ($indent_pas * 2)).
                '</select>'."\n";
        $retour .= str_repeat(' ', $indent_origine + ($indent_pas * 2)).
                '<input id="sesi_ok" name="sesi_ok" type="submit" value="'.SESI_LG__VALIDER.'"/>'."\n";
        $retour .= str_repeat(' ', $indent_origine + ($indent_pas * 1)).
                '</fieldset>'."\n";
        if ($langue_test != GEN_I18N_ID_DEFAUT) {
	        $retour .= str_repeat(' ', $indent_origine + ($indent_pas * 1)).
					 '<input name="'.$url_cle_i18n.'" type="hidden" value="'.$id_langue.'"/>'."\n";
        }
        $retour .= str_repeat(' ', $indent_origine + ($indent_pas * 0)).
        '</form>'."\n";
        
                
    }
    
    return $retour;
}

// +------------------------------------------------------------------------------------------------------+
// |                                            PIED du PROGRAMME                                         |
// +------------------------------------------------------------------------------------------------------+



/* +--Fin du code ----------------------------------------------------------------------------------------+
*
* $Log: selecteur_sites.php,v $
* Revision 1.12  2007-05-24 16:26:08  jp_milcent
* Utilisation de Pap_URL.
*
* Revision 1.11  2006-12-01 16:33:40  florian
* Amélioration de la gestion des applettes et compatibilité avec le nouveau mode de gestion de l'inclusion des applettes.
*
* Revision 1.10  2006/10/11 17:20:19  jp_milcent
* Formatage du code.
*
* Revision 1.9  2006/04/28 12:41:49  florian
* corrections erreurs chemin
*
* Revision 1.8  2006/03/02 10:49:49  ddelon
* Fusion branche multilinguisme dans branche principale
*
* Revision 1.7.2.4  2006/02/28 14:02:07  ddelon
* Finition multilinguisme
*
* Revision 1.7.2.3  2006/01/19 21:26:20  ddelon
* Multilinguisme site + bug ftp
*
* Revision 1.7.2.2  2005/12/20 14:40:24  ddelon
* Fusion Head vers Livraison
*
* Revision 1.7.2.1  2005/12/07 19:46:14  ddelon
* Merge + navi sites
*
* Revision 1.7  2005/05/25 12:53:00  jpm
* Changement et ajout d'attributs id.
*
* Revision 1.6  2005/05/23 09:31:43  jpm
* Ajout d'une majuscule à un txt.
*
* Revision 1.5  2004/10/26 18:42:02  jpm
* Possibilité d'externaliser l'applette.
* Gestion des sites externes.
*
* Revision 1.4  2004/09/15 09:32:01  jpm
* Mise en conformité avec le standard XHTML Strict.
*
* Revision 1.3  2004/07/06 17:07:16  jpm
* Modification de la documentation pour une mailleur analyse par PhpDocumentor.
*
* Revision 1.2  2004/06/21 07:37:50  alex
* Modification d'un label
*
* Revision 1.1  2004/06/15 15:05:47  jpm
* Changement de nom et d'arborescence de Genesia en Papyrus.
*
* Revision 1.5  2004/05/05 08:27:12  jpm
* Ajout du paramétrage de l'indentation et l'utilisation de variable pour contenir les textes de l'appli.
*
* Revision 1.4  2004/05/05 06:44:28  jpm
* Complément des commentaires indiquant les paquetages nécessaire à l'applette.
*
* Revision 1.3  2004/05/03 11:19:10  jpm
* Intégration de la variable globale de Génésia dans les arguments de la fonction de l'applette.
*
* Revision 1.2  2004/05/01 16:13:11  jpm
* Ajout du nom de la balise de l'applette dans le code de l'applette.
*
* Revision 1.1  2004/05/01 10:30:59  jpm
* Ajout de l'applette selecteur de sites.
*
*
* +-- Fin du code ----------------------------------------------------------------------------------------+
*/
?>