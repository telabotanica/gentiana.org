<?php
/*vim: set expandtab tabstop=4 shiftwidth=4: */
// +------------------------------------------------------------------------------------------------------+
// | PHP version 5.0.4                                                                                    |
// +------------------------------------------------------------------------------------------------------+
// | Copyright (C) 2005 Tela Botanica (accueil@tela-botanica.org)                                         |
// +------------------------------------------------------------------------------------------------------+
// | This file is part of project_name.                                                                |
// |                                                                                                      |
// | Foobar is free software; you can redistribute it and/or modify                                       |
// | it under the terms of the GNU General Public License as published by                                 |
// | the Free Software Foundation; either version 2 of the License, or                                    |
// | (at your option) any later version.                                                                  |
// |                                                                                                      |
// | Foobar is distributed in the hope that it will be useful,                                            |
// | but WITHOUT ANY WARRANTY; without even the implied warranty of                                       |
// | MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the                                        |
// | GNU General Public License for more details.                                                         |
// |                                                                                                      |
// | You should have received a copy of the GNU General Public License                                    |
// | along with Foobar; if not, write to the Free Software                                                |
// | Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA                            |
// +------------------------------------------------------------------------------------------------------+
// CVS : $Id: efre_completion_nom_latin.action.php,v 1.14 2007-06-19 10:32:57 jp_milcent Exp $
/**
* project_name
*
*
*
*@package project_name
*@subpackage
//Auteur original :
*@author        David Delon <dd@clapas.net>
//Autres auteurs :
*@author        aucun
*@copyright     Tela-Botanica 2000-2006
*@version       $Revision: 1.14 $ $Date: 2007-06-19 10:32:57 $
// +------------------------------------------------------------------------------------------------------+
*/

// +------------------------------------------------------------------------------------------------------+
// |                                            ENTETE du PROGRAMME                                       |
// +------------------------------------------------------------------------------------------------------+


// +------------------------------------------------------------------------------------------------------+
// |                                            CORPS du PROGRAMME                                        |
// +------------------------------------------------------------------------------------------------------+

class ActionCompletionNomLatin implements iActionAvecCache {

	public function get_identifiant()
	{
			return $_GET['referentiel'].':'.$_GET['nom'];
	}
	
	public function executer()
	{
		
		// +------------------------------------------------------------------------------------------------------+
		// Initialisation des variables
		$tab_retour = array();
		$tab_retour['noms'] = array();
		$tab_param = array();
		$dao_nom = new NomDeprecieDao();
		//$dao_nom->setDebogage(EF_DEBOG_SQL);
		
		// +------------------------------------------------------------------------------------------------------+
		// Constitution du tableau de radicaux du nom permettant de constituer le tableau de paramêtres pour la requête
		
		// Nettoyage parametres
		$nom = trim(preg_replace('/\s+/', ' ', $_GET['nom']));
		if (EF_LANGUE_UTF8) {
			$nom = mb_convert_encoding($nom, 'UTF-8', $GLOBALS['_EFLORE_']['encodage']);
		}
		$referentiel = $_GET['referentiel'];
		
		list($genre, $espece) = explode(' ', $nom);
		$genre = preg_replace('/%+/', '%', $genre); // Evitons de surcharger le serveur

		if ((strlen($genre) > 2) && ($genre != '%')) {
			$tab_param[] = $referentiel;
			if (strlen($espece) > 0) {
				$type = EF_CONSULTER_NOM_COMPLETION_ESPECE;
				$tab_param[] = $genre;
				$tab_param[] = $espece."%";
			} else {
				$type = EF_CONSULTER_NOM_COMPLETION_GENRE;
				$tab_param[] = $genre."%";
			}
			
			$tab_noms = $dao_nom->consulter($type, $tab_param);
		
			foreach($tab_noms as $un_nom) {
				$tab_nom = array();
				//echo '<pre>'.print_r($un_nom, true).'</pre>';
				$tab_nom['intitule'] = $un_nom->formaterNom(NomDeprecie::FORMAT_SIMPLE);
				$tab_nom['numero'] = $un_nom->getId('nom');
				$tab_retour['noms'][] = $tab_nom;
			}
			
			
		}

		$tab_retour['eflore_nom'] = $nom;
		//echo '<pre>'.print_r($tab_retour,true).'</pre>';
		// +------------------------------------------------------------------------------------------------------+
		// Retour des données
		return $tab_retour;

 	}// Fin méthode executer()
	
}


/* +--Fin du code ----------------------------------------------------------------------------------------+
*
* $Log: efre_completion_nom_latin.action.php,v $
* Revision 1.14  2007-06-19 10:32:57  jp_milcent
* Début utilisation de classes par module utilisant l'API 1.1.1.
* Renomage des anciennes classes en "Deprecie".
*
* Revision 1.13  2007-06-11 12:46:51  jp_milcent
* Fusion correction provenant de la livraison Moquin-Tandon : 11 juin 2007
*
* Revision 1.9.4.5  2007-06-11 10:11:25  jp_milcent
* Résolution de l'ensemble des problèmes d'encodage.
*
* Revision 1.9.4.4  2007-06-08 12:19:48  jp_milcent
* Simplification utilisation utf8.
*
* Revision 1.9.4.3  2007-06-07 13:59:13  jp_milcent
* Prise en comtpe de l'utf8 via une constante.
*
* Revision 1.12  2007-06-04 12:17:08  jp_milcent
* Fusion avec la livraison Moquin-Tandon : 04 juin 2007
*
* Revision 1.9.4.2  2007-06-04 11:30:58  jp_milcent
* Correction problème utf8 : la convertion iso vers utf8 et inversément est réalisée par Mysql.
*
* Revision 1.9.4.1  2007-05-11 15:09:02  jp_milcent
* Correction bogue : isoëtes
*
* Revision 1.11  2007-05-11 15:11:41  jp_milcent
* Correction bogue : isoëtes
*
* Revision 1.10  2007/01/24 15:36:36  jp_milcent
* Ajout du référentiel dans l'identifiant.
*
* Revision 1.9  2006/11/15 15:51:58  jp_milcent
* Correction bogue complétion inactive avec le cache.
*
* Revision 1.8  2006/10/25 08:15:22  jp_milcent
* Fusion avec la livraison Decaisne.
*
* Revision 1.7.2.2  2006/07/27 14:12:11  jp_milcent
* Correction bogue mauvais nom de variable.
*
* Revision 1.7.2.1  2006/07/27 10:05:17  jp_milcent
* Gestion du référentiel pour la complétion.
* Améliorer la gestion du cache en fonction du référentiel.
* Améliorer la gestion de la fonction actualiserUrl().
*
* Revision 1.7  2006/07/07 09:26:17  jp_milcent
* Modification selon les remarques de Daniel du 29 juin 2006.
* Changement de nom de classes abstraites.
*
* Revision 1.6  2006/05/15 19:51:07  ddelon
* parametrage cache
*
* Revision 1.5  2006/05/11 09:43:37  ddelon
* Action cache
*
* Revision 1.4  2006/04/26 16:57:04  ddelon
* Fusion bdnbe + saisie assistee
*
* Revision 1.3  2006/04/19 21:11:26  ddelon
* Optimisations completion et petits bugs
*
* Revision 1.2  2006/04/11 10:08:36  ddelon
* completion
*
* Revision 1.1.2.1  2006/04/07 10:50:29  ddelon
* Completion a la google suggest
*
*
* +-- Fin du code ----------------------------------------------------------------------------------------+
*/
?>