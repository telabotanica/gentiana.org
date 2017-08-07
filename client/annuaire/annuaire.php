<?php
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
/**
* programme principal du module annuaire
*
* programme principal du module annuaire
*
*@package annuaire
//Auteur original :
*@author		Alexandre Granier <alexandre@tela-botanica.org>
//Autres auteurs :
*@author		Jean-Pascal MILCENT <jpm@tela-botanica.org>
*@copyright	 Tela-Botanica 2000-2007
*@version	   $Id: annuaire.php,v 1.4 2005/03/24 08:24:39 alex Exp $
// +------------------------------------------------------------------------------------------------------+
*/

// +------------------------------------------------------------------------------------------------------+
// |											ENTETE du PROGRAMME									   |
// +------------------------------------------------------------------------------------------------------+

include_once 'client/annuaire/configuration/ann_config.inc.php' ;
include_once ANN_CHEMIN_LIBRAIRIE.'annuaire.fonct.php' ;
/** Constante "dynamique" stockant la langue demandée par l'utilisateur pour l'application.*/
define('INS_LANGUE', substr($GLOBALS['_GEN_commun']['i18n'], 0, 2));
$fichier_lg = ANN_CHEMIN_APPLI.'/langues/ann_langue_'.INS_LANGUE.'.inc.php';
if (file_exists($fichier_lg)) {
	include_once $fichier_lg;
} else {
	include_once ANN_CHEMIN_APPLI.'/langues/ann_langue_fr.inc.php' ;
}
include_once PAP_CHEMIN_API_PEAR.'HTML/QuickForm.php' ;

// Ajout d'une feuille de style externe
GEN_stockerStyleExterne ('inscription', 'client/annuaire/annuaire.css') ;

/**
 *  Renvoie le code HTML de l'application
 *
 * @return  string  HTML
 */
function afficherContenuCorps () {
	$res = '<h1 class="annuaire_titre1">'.ANN_TITRE.'</h1>'."\n";
	if (!$GLOBALS['AUTH']->getAuth())  {
		$res .= AUTH_formulaire_login();
	} else {
		// Le code javascript des cases à cocher
		$java =
			"function setCheckboxes(the_form)
			{
			var do_check=document.forms[the_form].elements['selecttotal'].checked;
			var elts			= document.forms[the_form].elements['select[]'];
			var elts_cnt = (typeof(elts.length) != 'undefined')
								? elts.length
								: 0;
			if (elts_cnt) {
				for (var i = 0; i < elts_cnt; i++) {
					elts[i].checked = do_check;
				} // Fin for
			} else {
				elts.checked = do_check;
			} // Fin if... else
			return true;
		} // Fin de la fonction 'setCheckboxes()'";
		GEN_stockerCodeScript($java) ;

		$res .= '<h2 class="annuaire_titre2">'.ANN_CLIQUEZ_LETTRE.'</h2>'."\n";
		
		// Nettoyage des variables du POST
		$cles = array('corps', 'titre_mail');
		foreach ($cles as $cle) {
			if (isset($_POST[$cle]) && !empty($_POST[$cle])) {
				$_POST[$cle] = translittererCp1252VersIso88591(stripslashes($_POST[$cle]));
			}
		}

		// S'il y a un mail a envoyé, on l'envoie
		if (isset($_POST['select']) && is_array($_POST['select'])) {
			if (isset($_POST['corps']) && isset($_POST['titre_mail'])) {
				$res .= envoie_mail($_POST['select'], $_POST['titre_mail'], $_POST['corps']) ;
			}
		}

		$res .= parcourrirAnnu() ;
	}
	return $res;
}

function afficherContenuPied () {
	$sortie  = 	'<p id="annuaire_pied_page">'.ANN_PIED_INFO.
					'<a href="mailto:'.ANN_PIED_MAIL.'">'.ANN_PIED_MAIL.'</a>.'.
				'</p>';
	return $sortie;
}
?>
