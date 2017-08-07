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
// CVS : $Id: Applette.class.php,v 1.5 2007-08-02 22:12:43 jp_milcent Exp $
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
*@version       $Revision: 1.5 $ $Date: 2007-08-02 22:12:43 $
// +------------------------------------------------------------------------------------------------------+
*/

// +------------------------------------------------------------------------------------------------------+
// |                                            ENT�TE du PROGRAMME                                       |
// +------------------------------------------------------------------------------------------------------+

class Applette {
	
	var $bool_balise_appli = false;
	
    function __construct()
    {
    	
    }
    
	function getBoolBaliseAppli()
	{
		return $this->bool_balise_appli;
	}
	
	function parserBaliseApplette($contenu, $bool_appli = false)
	{
		$GLOBALS['_EFLORE_']['applette']['nbr_balise'] = preg_match_all(
				'/\{\{(\w+) ?[^}]*\}\}/',
				$contenu,
				$tab_decoupage,
				PREG_SET_ORDER);
		if ($bool_appli && $GLOBALS['_EFLORE_']['applette']['nbr_balise'] > 0) {
			$this->bool_balise_appli = true;
		}
		for ($i = 0; $i < $GLOBALS['_EFLORE_']['applette']['nbr_balise']; $i++) {
			// Cr�ation du nom de l'applette.
			$applette_nom = $tab_decoupage[$i][1];
			if (!isset($GLOBALS['_EFLORE_']['info_applette'][$applette_nom])) {
				$GLOBALS['_EFLORE_']['info_applette'][$applette_nom]['nom'] = $applette_nom;
				
				// Recherche du fichier de l'applette
				$applette_dossier = preg_replace('/([a-z])([A-Z])/', '$1_$2', $applette_nom);
				$applette_fichier = EF_CHEMIN_MODULE.strtolower($applette_dossier).'/'.$applette_nom.'.class.php';
				if (file_exists($applette_fichier)) {
					$GLOBALS['_EFLORE_']['info_applette'][$applette_nom]['chemin'] = $applette_fichier;
				} else {
					// On supprime l'applette de la liste
					unset($GLOBALS['_EFLORE_']['info_applette'][$applette_nom]);
			        // Ne devrait pas arr�ter le programme! Mais instancier le gestionnaire de d�boguage.
			        $message = 	'ERREUR : Impossible de trouver le fichier de l\'applette. <br />'.
			            		'Nom applette : '.$GLOBALS['_EFLORE_']['info_applette'][$applette_nom]['nom'].' <br />'.
			            		'Chemin fichier applette : '.$applette_fichier.' <br />'.
			            		'Ligne n� : '. __LINE__ .'<br />'.
			            		'Fichier : '. __FILE__ ;
					trigger_error($message, E_USER_ERROR);
			    }	
				
				// Nous incluons l'applette
			    if (file_exists($GLOBALS['_EFLORE_']['info_applette'][$applette_nom]['chemin'])) {
			        include_once($GLOBALS['_EFLORE_']['info_applette'][$applette_nom]['chemin']);
			        // Nous r�cup�rons l'expression r�guli�re de la balise pour l'utiliser lors de l'appel
			        // de la fonction de l'applette. L'appel des fonctions des applettes � lieu apr�s l'appel
			        // de l'application pour permettre � l'appli de modifier certains param�tres (identification, ordre des menus).
			        $GLOBALS['_EFLORE_']['info_applette'][$applette_nom]['applette_balise'] = call_user_func(array($applette_nom, 'getAppletteBalise'));
			    }
			}
			// R�cup�ration des infos sur la balise courrante.
			if (preg_match(	'/'.$GLOBALS['_EFLORE_']['info_applette'][$applette_nom]['applette_balise'].'/', $tab_decoupage[$i][0], $applet_arguments)) {
				$info_balise = array();
				// Nous stockons la chaine de caract�res repr�sentant l'appel
				$info_balise['balise'] = $applet_arguments[0];
				unset($applet_arguments[0]);
				// Nous cr�ons le tableau des param�tres
				$parametres = array();
				foreach ($applet_arguments as $argument) {
					$arg_explo = explode('=', $argument);
					$parametres[$arg_explo[0]] = trim($arg_explo[1], '"');
				}
				$info_balise['parametres'] = $parametres;
			    // R�cup�ration de l'action � ex�cuter sur le module
			    $info_balise['action'] = '';
			    foreach($applet_arguments as $argument) {
				    $tab_parametres = explode('=', $argument);
				    if ($tab_parametres[0] == 'action') {
						$info_balise['action'] = trim($tab_parametres[1], '"');
				    } 
			    }
			    $GLOBALS['_EFLORE_']['info_applette'][$applette_nom]['balises'][] = $info_balise;
			    //echo '<pre>'.print_r($GLOBALS['_EFLORE_']['info_applette'][$applette_nom]['balises'][$i], true).'</pre>';
				
			} else {
				$GLOBALS['_EFLORE_']['info_applette'][$applette_nom]['balises'][] = array();
				$message = 	'ERREUR : Impossible de r�cup�rer les arguments de l\'applette. <br />'.
							'Nom applette : '.$GLOBALS['_EFLORE_']['info_applette'][$applette_nom]['nom'].' <br />'.
							'Chemin fichier applette : '.$GLOBALS['_EFLORE_']['info_applette'][$applette_nom]['chemin'].' <br />'.
							'Ligne n� : '. __LINE__ .'<br />'.
							'Fichier : '. __FILE__ .'<br />'.
							'<pre>'.print_r($tab_decoupage[$i][0], true).'</pre>'.
							'<pre>'.print_r('/'.$GLOBALS['_EFLORE_']['info_applette'][$applette_nom]['applette_balise'].'/', true).'</pre>';
				trigger_error($message, E_USER_ERROR);
			}
		}
	}
	
	function remplacerBaliseApplette($sortie)
	{
		if (isset($GLOBALS['_EFLORE_']['info_applette'])) {
			//echo '<pre>'.print_r($GLOBALS['_EFLORE_']['info_applette'], true).'</pre>';
			foreach ($GLOBALS['_EFLORE_']['info_applette'] as $applette_id => $applette) {
			    // Si on trouve au moins une balise, on lance la boucle pour les remplacer
			    $balise_nbre = count($applette['balises']);
			    for ($j = 0; $j < $balise_nbre; $j++) {
					//+------------------------------------------------------------------------------------------------+
					// Gestion de l'applette
			        $Registre = Registre::getInstance();
					$Module = new $applette['nom']();

					//+------------------------------------------------------------------------------------------------+
					// Gestion des param�tres
					$Registre->set('applette_parametre', null); // Nous vidons ce param�tre dans le Registre
					$Registre->set('applette_parametre', $applette['balises'][$j]['parametres']);

					//+------------------------------------------------------------------------------------------------+
					// Gestion des actions
					$Registre->set('action', null); // Nous vidons ce param�tre dans le Registre
	                $Registre->set('action', $applette['balises'][$j]['action']);
	                
					$rendu = $Module->traiterAction();
					
					//+------------------------------------------------------------------------------------------------+
			        // Remplacement des balises d'applette de Papyrus dans le squelette
			        $sortie =	str_replace(	$applette['balises'][$j]['balise'], 
			                					$rendu, $sortie);
				}
			}
		}
		return $sortie;
	}
}
?>