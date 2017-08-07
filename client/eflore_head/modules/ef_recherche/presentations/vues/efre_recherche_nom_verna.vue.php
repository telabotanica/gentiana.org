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
// CVS : $Id: efre_recherche_nom_verna.vue.php,v 1.14 2007-06-11 12:46:51 jp_milcent Exp $
/**
* project_name
*
* 
*
*@package project_name
*@subpackage 
//Auteur original :
*@author        Jean-Pascal MILCENT <jpm@tela-botanica.org>
//Autres auteurs :
*@author        aucun
*@copyright     Tela-Botanica 2000-2005
*@version       $Revision: 1.14 $ $Date: 2007-06-11 12:46:51 $
// +------------------------------------------------------------------------------------------------------+
*/

// +------------------------------------------------------------------------------------------------------+
// |                                            ENTETE du PROGRAMME                                       |
// +------------------------------------------------------------------------------------------------------+


// +------------------------------------------------------------------------------------------------------+
// |                                            CORPS du PROGRAMME                                        |
// +------------------------------------------------------------------------------------------------------+

class VueRechercheNomVerna extends aVue {

	public function __construct($Registre)
	{
		$this->setNom('recherche_nom_verna');
		parent::__construct($Registre);
		// Création du Squelette
		$this->setSquelette( new HTML_Template_IT( $this->getChemin() ) );
	}
	
	public function preparer()
	{
		// Récupération d'une référence au squelette
		$squelette = $this->getSquelette();
		$i = 1;
		foreach ($this->getDonnees('noms_vernaculaires') as $nom) {
			// Assigne les données au block courant
			$squelette->setCurrentBlock('NOM');
			// Le numéro de la ligne
			$squelette->setVariable('EFLORE_NOM_VERNA_LISTE_NUM', $i++);
			// La langue
			$squelette->setVariable('EFLORE_NOM_VERNA_LG_INTITULE', $nom['lg_intitule']);
			$squelette->setVariable('EFLORE_NOM_VERNA_LG_ABREVIATION', $nom['lg_abreviation']);
			// La zone géographique
			$squelette->setVariable('EFLORE_NOM_VERNA_ZG_INTITULE', $nom['zg_intitule']);
			$squelette->setVariable('EFLORE_NOM_VERNA_ZG_ABREVIATION', $nom['zg_abreviation']);
			// L'intitulé du nom vernaculaire
			$squelette->setVariable('EFLORE_NOM_VERNA', $nom['intitule']);
			// L'intitulé du nom latin
			$squelette->setVariable('EFLORE_NOM', $nom['nom_latin']);			
			// Ajout du paramêtre action à l'url courante.
			$squelette->setVariable('EFLORE_FICHE_URL', $nom['url_fiche']);	
			$squelette->parseCurrentBlock('NOM');
		}
		
		// Si nous avons des résultats
		if (count($this->getDonnees('noms_vernaculaires')) > 0) {
			$squelette->setCurrentBlock('RESULTAT');
			$squelette->setVariable('EFLORE_RADICAL', $this->getDonnees('radical'));
			$squelette->parseCurrentBlock('RESULTAT');			
		}

		// Nous affichons les information s'il y en a.
		if (!is_null($this->getDonnees('info'))) {
			foreach ($this->getDonnees('info') as $info) {
				$squelette->setCurrentBlock('INFO');
				$squelette->setVariable('EFLORE_INFO', $info);
				$squelette->parseCurrentBlock('INFO');
			}
		}
		
		$squelette->setCurrentBlock();
		$squelette->setVariable('TITRE_GENERAL', $this->getDonnees('titre_general'));
		$squelette->setVariable('TITRE_GENERAL_REFERENTIEL', $this->getDonnees('titre_general_referentiel'));
		$squelette->setVariable('FORMULAIRE_RECHERCHE_NOM', $this->getDonnees('un_form_nom'));
		$squelette->setVariable('EFLORE_RESULTAT_NBRE', count($this->getDonnees('noms_vernaculaires')));
		//Affichage recherche approchée 
		$nom = $this->getDonnees('nom_vernaculaire_approche');
		if (isset($nom) && ($nom <> '')) {		
			$squelette->setVariable('EFLORE_NOM_VERNACULAIRE_APPROCHE_URL', $this->getDonnees('url_approchee'));
			$squelette->setVariable('EFLORE_NOM_VERNACULAIRE_APPROCHE', $nom);
				
			$squelette->setCurrentBlock('NOM_VERNACULAIRE_APPROCHE');
			$squelette->parseCurrentBlock('NOM_VERNACULAIRE_APPROCHE');
		}
		$squelette->parseCurrentBlock();		
	}
	
}


/* +--Fin du code ----------------------------------------------------------------------------------------+
*
* $Log: efre_recherche_nom_verna.vue.php,v $
* Revision 1.14  2007-06-11 12:46:51  jp_milcent
* Fusion correction provenant de la livraison Moquin-Tandon : 11 juin 2007
*
* Revision 1.13.6.1  2007-06-11 11:49:11  jp_milcent
* Correction problème url et changement de nom de variable de retour.
*
* Revision 1.13  2006-07-07 09:26:17  jp_milcent
* Modification selon les remarques de Daniel du 29 juin 2006.
* Changement de nom de classes abstraites.
*
* Revision 1.12  2006/07/05 15:11:22  jp_milcent
* Modification du module de recherche suite à remarque de Daniel du 29 juin 2006.
*
* Revision 1.11  2006/05/11 10:28:27  jp_milcent
* Début modification de l'interface d'eFlore pour la livraison Decaisne.
*
* Revision 1.10  2005/12/21 17:15:33  jp_milcent
* Fusion avec les corrections de la branche livraison_bdnff_v3_v4.
*
* Revision 1.9.2.1  2005/12/16 10:37:15  jp_milcent
* Correction bogue : affichage du code de la version inexistant.
*
* Revision 1.9  2005/12/15 16:01:21  jp_milcent
* Fusion de la branche bdnff_v3_v4 vers la branche principale.
*
* Revision 1.8  2005/12/06 09:47:26  ddelon
* Recherche vernaculaire (extension) + recherche approche
*
* Revision 1.7  2005/12/02 21:29:41  ddelon
* Limitation recherche nom verna
*
* Revision 1.6  2005/11/28 16:53:01  jp_milcent
* Restriction du nombre de variables de session.
*
* Revision 1.5  2005/10/10 07:28:07  jp_milcent
* Utilisation du webservice Yahoo-Image.
*
* Revision 1.4  2005/09/13 16:25:23  jp_milcent
* Fin de gestion des interfaces de recherche.
*
* Revision 1.3  2005/08/19 13:54:11  jp_milcent
* Début de gestion de la navigation au sein de la classification.
*
* Revision 1.2  2005/08/19 08:34:36  jp_milcent
* Gestion de la recherche par taxon en cours...
*
* Revision 1.1  2005/08/11 10:15:49  jp_milcent
* Fin de gestion des noms verna avec requête rapide.
* Début gestion choix aplhabétique des taxons.
*
*
* +-- Fin du code ----------------------------------------------------------------------------------------+
*/
?>