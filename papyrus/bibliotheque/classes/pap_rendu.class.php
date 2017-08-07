<?php
/*vim: set expandtab tabstop=4 shiftwidth=4: */ 
// +------------------------------------------------------------------------------------------------------+
// | PHP version 5.1                                                                                      |
// +------------------------------------------------------------------------------------------------------+
// | Copyright (C) 2006 Tela Botanica (accueil@tela-botanica.org)                                         |
// +------------------------------------------------------------------------------------------------------+
// | Ce logiciel est un programme informatique servant � g�rer du contenu et des applications web.        |                                                                           |
// |                                                                                                      |
// | Ce logiciel est r�gi par la licence CeCILL soumise au droit fran�ais et respectant les principes de  | 
// | diffusion des logiciels libres. Vous pouvez utiliser, modifier et/ou redistribuer ce programme sous  |
// | les conditions de la licence CeCILL telle que diffus�e par le CEA, le CNRS et l'INRIA sur le site    |
// | "http://www.cecill.info".                                                                            |
// |                                                                                                      |
// | En contrepartie de l'accessibilit� au code source et des droits de copie, de modification et de      |
// | redistribution accord�s par cette licence, il n'est offert aux utilisateurs qu'une garantie limit�e. |
// | Pour les m�mes raisons, seule une responsabilit� restreinte p�se sur l'auteur du programme, le       |
// | titulaire des droits patrimoniaux et les conc�dants successifs.                                      |
// |                                                                                                      |
// | A cet �gard l'attention de l'utilisateur est attir�e sur les risques associ�s au chargement, �       |
// | l'utilisation,  � la modification et/ou au d�veloppement et � la reproduction du logiciel par        |
// | l'utilisateur �tant donn� sa sp�cificit� de logiciel libre, qui peut le rendre complexe � manipuler  |
// | et qui le r�serve donc � des d�veloppeurs et des professionnels avertis poss�dant des connaissances  |
// | informatiques approfondies. Les utilisateurs sont donc invit�s � charger  et  tester  l'ad�quation   |
// | du logiciel � leurs besoins dans des conditions permettant d'assurer la s�curit� de leurs syst�mes   | 
// | et ou de leurs donn�es et, plus g�n�ralement, � l'utiliser et l'exploiter dans les m�mes conditions  |
// | de s�curit�.                                                                                         |
// |                                                                                                      |
// | Le fait que vous puissiez acc�der � cet en-t�te signifie que vous avez pris connaissance de la       |
// | licence CeCILL, et que vous en avez accept� les termes.                                              |
// +------------------------------------------------------------------------------------------------------+
// CVS : $Id: pap_rendu.class.php,v 1.10 2007-09-06 14:44:51 neiluj Exp $
/**
* Classe : pap_rendu
*
* Fournit des m�thodes pour le rendu.
*
*@package Papyrus
*@subpackage Classes
//Auteur original :
*@author        Jean-Pascal MILCENT <jpm@tela-botanica.org>
//Autres auteurs :
*@author        Aucun
*@copyright     Tela-Botanica 2000-2006
*@version       $Revision: 1.10 $ $Date: 2007-09-06 14:44:51 $
// +------------------------------------------------------------------------------------------------------+
*/

// +------------------------------------------------------------------------------------------------------+
// |                                            ENT�TE du PROGRAMME                                       |
// +------------------------------------------------------------------------------------------------------+

class Pap_Rendu {
	
	var $bool_balise_appli = false;
	
    function pap_rendu()
    {
    	
    }
    
	function getBoolBaliseAppli()
	{
		return $this->bool_balise_appli;
	}
	
	function parserBaliseApplette($contenu, $bool_appli = false)
	{
		$noms_applettes = 'IDENTIFICATION|MENU|MOTEUR_RECHERCHE|SELECTEUR_SITES|VOUS_ETES_ICI|BAZAR_CALENDRIER|BODY_ATTRIBUTS';// Compatibilite ancienne syntaxe
		$GLOBALS['_PAPYRUS_']['applette']['nbr_balise'] = preg_match_all(
				'/\{\{(\w+) ?.*?\}\}|<!-- (?:'.$GLOBALS['_GEN_commun']['balise_prefixe'].'|'.$GLOBALS['_GEN_commun']['balise_prefixe_client'].')('.$noms_applettes.')[^ ]* -->/',
				$contenu,
				$tab_decoupage,
				PREG_SET_ORDER);
		if ($bool_appli && $GLOBALS['_PAPYRUS_']['applette']['nbr_balise'] > 0) {
			$this->bool_balise_appli = true;
		}
		for ($i = 0; $i < $GLOBALS['_PAPYRUS_']['applette']['nbr_balise']; $i++) {
			// Creation du nom de l'applette.
			$applette_nom = '';
			if (!empty($tab_decoupage[$i][1])) {
				$applette_nom = $tab_decoupage[$i][1];
			} else if (!empty($tab_decoupage[$i][2])) {
				$applette_nom = $tab_decoupage[$i][2];
			}
			// Ajout d'underscore devant les majuscules composant un nom d'applette puis mise en minuscule.
			// Ex : MotCles devient mot_cles
			$applette_nom = strtolower(preg_replace('/([a-z0-9])([A-Z])/', '$1_$2', $applette_nom));
			if (!isset($GLOBALS['_PAPYRUS_']['info_applette'][$applette_nom])) {
				$GLOBALS['_PAPYRUS_']['info_applette'][$applette_nom]['nom'] = $applette_nom;
				
				// Recherche du fichier de l'applette
				$repertoire = '';
				$applette_nom_fichier = '';
				// Spécial Bazar Calendrier!
				if (preg_match('/_/', $applette_nom)) {
					$e = explode ('_', $applette_nom);
					$repertoire = $e[0];
					$applette_nom_fichier = $e[1];
					//trigger_error('<pre>'.$applette_nom_fichier.'-'.$repertoire.'</pre>', E_USER_ERROR);
				}
				if (file_exists(GEN_CHEMIN_APPLETTE.$applette_nom.GEN_SEP.$applette_nom.'.php')) {
					$GLOBALS['_PAPYRUS_']['info_applette'][$applette_nom]['chemin'] = GEN_CHEMIN_APPLETTE.$applette_nom.GEN_SEP.$applette_nom.'.php';	
				} else if (file_exists(GEN_CHEMIN_CLIENT.$applette_nom.GEN_SEP.$applette_nom.'.php')) {
					$GLOBALS['_PAPYRUS_']['info_applette'][$applette_nom]['chemin'] = GEN_CHEMIN_CLIENT.$applette_nom.GEN_SEP.$applette_nom.'.php';						
				} else if (file_exists(GEN_CHEMIN_CLIENT.$repertoire.GEN_SEP.$repertoire.'_'.$applette_nom_fichier.'.applette.php')) {
					// Syntaxe à privilièger en cas d'intégration d'une applette dans une application
					$GLOBALS['_PAPYRUS_']['info_applette'][$applette_nom]['chemin'] = GEN_CHEMIN_CLIENT.$repertoire.GEN_SEP.$repertoire.'_'.$applette_nom_fichier.'.applette.php';
				} else if (file_exists(GEN_CHEMIN_CLIENT.$repertoire.GEN_SEP.$repertoire.'.'.$applette_nom_fichier.'.applette.php')) {
					// Syntaxe obsolete
					$GLOBALS['_PAPYRUS_']['info_applette'][$applette_nom]['chemin'] = GEN_CHEMIN_CLIENT.$repertoire.GEN_SEP.$repertoire.'.'.$applette_nom_fichier.'.applette.php';
					$message = 	'MESSAGE Papyrus : le nom du fichier de l\'applette a une syntaxe obsolete'.'<br />'.
								'Nom applette : '.$GLOBALS['_PAPYRUS_']['info_applette'][$applette_nom]['nom'].'<br />'.
								'Chemin fichier applette : '.$GLOBALS['_PAPYRUS_']['info_applette'][$applette_nom]['chemin'].'<br />'.
								'Chemin fichier correct : '.GEN_CHEMIN_CLIENT.$repertoire.GEN_SEP.$repertoire.'_'.$applette_nom_fichier.'.applette.php'.'<br />';
								
					trigger_error($message, E_USER_WARNING);						
				} else {
					// On supprime l'applette de la liste
					unset($GLOBALS['_PAPYRUS_']['info_applette'][$applette_nom]);
			        // Ne devrait pas arreter le programme! Mais instancier le gestionnaire de deboguage.
			        $message = 	'ERREUR Papyrus : Impossible de trouver le fichier de l\'applette. <br />'.
			            		'Nom applette : '.$GLOBALS['_PAPYRUS_']['info_applette'][$applette_nom]['nom'].' <br />'.
			            		'Chemin fichier applette : '.$GLOBALS['_PAPYRUS_']['info_applette'][$applette_nom]['chemin'].' <br />'.
			            		'Ligne n&deg; : '. __LINE__ .'<br />'.
			            		'Fichier : '. __FILE__ ;
					trigger_error($message, E_USER_ERROR);
			    }
				// Nous incluons l'applette
			    if (file_exists($GLOBALS['_PAPYRUS_']['info_applette'][$applette_nom]['chemin'])) {
			        include_once($GLOBALS['_PAPYRUS_']['info_applette'][$applette_nom]['chemin']);
			        // Nous recuperons l'expression reguliere de la balise pour l'utiliser lors de l'appel
			        // de la fonction de l'applette. L'appel des fonctions des applettes a lieu apres l'appel
			        // de l'application pour permettre a l'appli de modifier certains parametres (identification, ordre des menus).
			        $GLOBALS['_PAPYRUS_']['info_applette'][$applette_nom]['applette_balise'] = $GLOBALS['_GEN_commun']['info_applette_balise'];
			        $GLOBALS['_PAPYRUS_']['info_applette'][$applette_nom]['applette_fonction'] = $GLOBALS['_GEN_commun']['info_applette_nom_fonction'];
			    }
			}
			// Recuperation des infos sur la balise courrante.
			if (preg_match(	'/'.$GLOBALS['_PAPYRUS_']['info_applette'][$applette_nom]['applette_balise'].'/', $tab_decoupage[$i][0], $applet_arguments)) {
				$GLOBALS['_PAPYRUS_']['info_applette'][$applette_nom]['balises'][] = $applet_arguments;
			} else {
				$GLOBALS['_PAPYRUS_']['info_applette'][$applette_nom]['balises'][] = array();
				$message = 	'ERREUR Papyrus : Impossible de r&eacute;cup&eacute;rer les arguments de l\'applette. <br />'.
							'Nom applette : '.$GLOBALS['_PAPYRUS_']['info_applette'][$applette_nom]['nom'].' <br />'.
							'Chemin fichier applette : '.$GLOBALS['_PAPYRUS_']['info_applette'][$applette_nom]['chemin'].' <br />'.
							'Ligne n&deg; : '. __LINE__ .'<br />'.
							'Fichier : '. __FILE__ .'<br />'.
							'<pre>'.print_r($tab_decoupage[$i][0], true).'</pre>'.
							'<pre>'.print_r('/'.$GLOBALS['_PAPYRUS_']['info_applette'][$applette_nom]['applette_balise'].'/', true).'</pre>';
				trigger_error($message, E_USER_ERROR);
			}
		}
		//echo '<pre>'.print_r($GLOBALS['_PAPYRUS_']['info_applette'], true).'</pre>';
	}
	
	function remplacerBaliseApplette()
	{
		foreach ($GLOBALS['_PAPYRUS_']['info_applette'] as $applette_id => $applette_val) {
		    // Si on trouve au moins une balise, on lance la boucle pour les remplacer
		    if (!isset($GLOBALS['_PAPYRUS_']['info_applette'][$applette_id]['balises'])) {
		    	echo 'oc:'.$applette_id;
		    }
		    for ($j = 0; $j < count($GLOBALS['_PAPYRUS_']['info_applette'][$applette_id]['balises']); $j++) {
		        // TODO : supprimer cette particularit� et utiliser la variable $GLOBALS['_PAPYRUS_']['info_applette'] 
		        // Nous comptabilisons le nombre d'utilisation des applettes dans un squelette pour l'applette Menu:
		        if (!isset($GLOBALS['_PAPYRUS_']['applette']['comptage'][$applette_val['applette_fonction']])) {
		            $GLOBALS['_PAPYRUS_']['applette']['comptage'][$applette_val['applette_fonction']] = 1;
		        } else {
		            $GLOBALS['_PAPYRUS_']['applette']['comptage'][$applette_val['applette_fonction']]++;
		        }
		        // Nous v�rifions que le nom de la fonction principale de l'applette existe.
		        if (function_exists($GLOBALS['_PAPYRUS_']['info_applette'][$applette_id]['applette_fonction'])) {
		            $GLOBALS['_PAPYRUS_']['applette']['contenu_applette'] = 
		                call_user_func( $GLOBALS['_PAPYRUS_']['info_applette'][$applette_id]['applette_fonction'], 
		                                    $GLOBALS['_PAPYRUS_']['info_applette'][$applette_id]['balises'][$j], 
		                                    $GLOBALS['_GEN_commun']);
		        } else {
		            $GLOBALS['_PAPYRUS_']['applette']['contenu_applette'] = 
		                '<!-- '."\n".
		                $GLOBALS['_PAPYRUS_']['info_applette'][$applette_id]['balises'][$j][0].' : '.
		                'fonction de l\'applette "'.$applette_id.'" introuvable! '."\n".
		                'Fonction : '.$GLOBALS['_PAPYRUS_']['info_applette'][$applette_id]['applette_fonction']."\n".
		                ' -->';
		        }
		        // Remplacement des balises d'applette de Papyrus dans le squelette
		        $GLOBALS['_PAPYRUS_']['general']['contenu_squelette'] = 
		            str_replace(	$GLOBALS['_PAPYRUS_']['info_applette'][$applette_id]['balises'][$j][0], 
		                			$GLOBALS['_PAPYRUS_']['applette']['contenu_applette'], 
		                			$GLOBALS['_PAPYRUS_']['general']['contenu_squelette']);
			}
		}
	}
}
?>