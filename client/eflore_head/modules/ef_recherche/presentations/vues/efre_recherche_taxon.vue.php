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
// CVS : $Id: efre_recherche_taxon.vue.php,v 1.17 2006-07-07 09:26:17 jp_milcent Exp $
/**
* project_name
*
* A FAIRE : terminer la gestion des images dans l'arborescence.
*
*@package project_name
*@subpackage 
//Auteur original :
*@author        Jean-Pascal MILCENT <jpm@tela-botanica.org>
//Autres auteurs :
*@author        aucun
*@copyright     Tela-Botanica 2000-2005
*@version       $Revision: 1.17 $ $Date: 2006-07-07 09:26:17 $
// +------------------------------------------------------------------------------------------------------+
*/

// +------------------------------------------------------------------------------------------------------+
// |                                            ENTETE du PROGRAMME                                       |
// +------------------------------------------------------------------------------------------------------+
include_once EFRE_CHEMIN_VUE.'efre_form_taxon.vue.php';

// +------------------------------------------------------------------------------------------------------+
// |                                            CORPS du PROGRAMME                                        |
// +------------------------------------------------------------------------------------------------------+
class VueRechercheTaxon extends aVue {
	/**
	* @param string filename of template
	*/
	public function __construct($Registre)
	{
		$this->setNom('recherche_taxon');
		parent::__construct($Registre);
		// Création du Squelette
		$this->setSquelette( new HTML_Template_IT( $this->getChemin() ) );
	}
	
	public function preparer()
	{
		// Récupération d'une référence au squelette
		$squelette = $this->getSquelette();
		//echo '<pre>'.print_r($this->getDonnees('referenciels'), true).'</pre>';

		// Obtention du nombre de taxons affichés.
		$taxons_nbre = $this->getDonnees('taxons_nbre');

		// Récupération du rang des taxons recherchés
		foreach ($this->getDonnees('rangs') as $un_rang) {
			if ($GLOBALS['eflore_rang'] == $un_rang->getId('rang')) {
				$rang_nom = $un_rang->getIntitule();
				break;
			}
		}
		
		// Affichage de l'arborescence des taxons
		if ($taxons_nbre > 0 ) {
			$squelette->setCurrentBlock('RESULTAT');
			$squelette->setVariable('EFLORE_RESULTAT_NBRE', $taxons_nbre);
			//echo '<pre>'.print_r($this->getDonnees('taxons'), true).'</pre>';
			$squelette->setVariable('EFLORE_CLASSIF', $this->creerClassif($this->getDonnees('taxons')));
			$squelette->parse('RESULTAT');
		}

		// Nous affichons les information s'il y en a.
		if (!is_null($this->getDonnees('info'))) {
			foreach ($this->getDonnees('info') as $info) {
				$squelette->setCurrentBlock('INFO');
				$squelette->setVariable('EFLORE_INFO', $info);
				$squelette->parseCurrentBlock('INFO');
			}
		}

		// Création du formulaire de recherche par taxon
//		$this->getRegistre()->set('vue_donnees', $this->getDonnees());
//		$une_vue_recherche_taxon = new VueFormTaxon($this->getRegistre());
//		$une_vue_recherche_taxon->setSquelette( $this->getSquelette() );
//		$une_vue_recherche_taxon->preparer();
//		$this->setSquelette( $une_vue_recherche_taxon->getSquelette() );

		// Gestion du block principal
		$squelette->setCurrentBlock();
		$squelette->setVariable('TITRE_GENERAL_REFERENTIEL', $this->getDonnees('titre_general_referentiel'));
		$squelette->setVariable('FORMULAIRE_RECHERCHE_NOM', $this->getDonnees('un_form_nom'));
		$squelette->setVariable('FORMULAIRE_RECHERCHE_TAXON', $this->getDonnees('un_form_taxon'));
		$squelette->parseCurrentBlock();

		
	}
	
	/** 
	* Créer l'arbre de la classification.
	* 
	*/	
	public function creerClassif($taxons, $bool_fils = false)
	{
		// Récupération d'une référence au squelette
		$un_squelette = clone $this->getSquelette();
		//$un_squelette->clearCacheOnParse = true;
		$taxons = $this->trierParSecondIndex($taxons, 'nom');
		foreach ($taxons as $taxon) {
			// Assigne les données au block TAXON
			$un_squelette->setCurrentBlock('TAXON');
			// L'intitulé du taxon
			$un_squelette->setVariable('EFLORE_NOM', $taxon['nom']);
			// L'id du taxon
			$un_squelette->setVariable('EFLORE_TAXON_ID', $taxon['id']);
			// Ajout de l'url de la fiche du taxson.
			$un_squelette->setVariable('EFLORE_URL_FICHE', $taxon['url_fiche']);
			//echo $taxon['fils_nbre'].'<br/>';
			if ( $taxon['fils_nbre'] > 0 ) {
				if (isset($taxon['fils'])) {
					// Ajout de l'url pour fermer la classification infèrieure du taxson.
					$un_squelette->setVariable( 'EFLORE_PLIER_DEPLIER', $this->insererPlierDeplier($taxon, 'plier') );
					$un_squelette->setVariable('EFLORE_CLASSIF_FILS', $this->creerClassif($taxon['fils'], true));
				} else {
					// Ajout de l'url pour ouvrir la classification infèrieure du taxson.
					$un_squelette->setVariable( 'EFLORE_PLIER_DEPLIER', $this->insererPlierDeplier($taxon, 'deplier') );
				}
			} else {
				// Ajout de l'image de branche pour ce taxson final (= feuille de l'arbre).
				// Ne s'affiche pas correctement à revoir... Nécessite de contenir une variable si on veut que
				// le contenu apparaisse.
				//$un_squelette->setVariable( 'EFLORE_PLIER_DEPLIER', $this->insererPlierDeplier($taxon, 'feuille') );
			}
			$un_squelette->parseCurrentBlock('TAXON');
		}
		$un_squelette->setCurrentBlock('CLASSIF');
		$un_squelette->setVariable( 'EFLORE_TAXON', $un_squelette->get('TAXON') );
		$un_squelette->parseCurrentBlock('CLASSIF');
		//echo '<pre><code>'.print_r($un_squelette->get('CLASSIF'), true).'</code></pre>';
		
		return $un_squelette->get('CLASSIF');
	}
	
	/** 
	* Insérer Plier-Déplier
	* 
	*/
	function insererPlierDeplier( $taxon, $action )
	{
		// Récupération d'une référence au squelette
		$un_squelette = clone $this->getSquelette();
		switch ($action) {
			case 'deplier' :
				$type = 'DESCENDANT';
				break;
			case 'plier' :
				$type = 'ASCENDANT';
				break;
			case 'feuille' :
				$type = 'FEUILLE';
				break;
			default :
				$type = 'DESCENDANT';
				break;
		}
		$un_squelette->setCurrentBlock('TAXON_'.$type);
		
		// Ajout de l'url pour ouvrir la classification infèrieure du taxon.
		$un_squelette->setVariable('EFLORE_URL_CLASSIF', $taxon['url_classif']);
		// L'id du taxon
		$un_squelette->setVariable('EFLORE_TAXON_ID', $taxon['id']);
		// Le chemin vers l'image
		$un_squelette->setVariable('EFLORE_CHEMIN_IMG', EF_CHEMIN_APPLI_RELATIF);
		
		$un_squelette->parseCurrentBlock('TAXON_'.$type);
		return $un_squelette->get('TAXON_'.$type);	
	}
	
}


/* +--Fin du code ----------------------------------------------------------------------------------------+
*
* $Log: efre_recherche_taxon.vue.php,v $
* Revision 1.17  2006-07-07 09:26:17  jp_milcent
* Modification selon les remarques de Daniel du 29 juin 2006.
* Changement de nom de classes abstraites.
*
* Revision 1.16  2006/07/05 15:11:22  jp_milcent
* Modification du module de recherche suite à remarque de Daniel du 29 juin 2006.
*
* Revision 1.15  2006/04/10 17:22:40  jp_milcent
* Fusion avec la livraison bdnbe_v1.
*
* Revision 1.14.4.1  2006/03/08 18:21:31  jp_milcent
* Gestion de la suppression du menu déroulant si un seul référentiel.
* Correction du bogue empéchant le résumé de s'afficher pour la recherche par arbre des taxons.
*
* Revision 1.14  2005/12/15 16:01:22  jp_milcent
* Fusion de la branche bdnff_v3_v4 vers la branche principale.
*
* Revision 1.13.2.2  2005/12/15 14:59:40  jp_milcent
* Prêt pour mise en ligne bdnffv3 et v4.
*
* Revision 1.13.2.1  2005/12/13 13:00:59  jp_milcent
* Correction bogue "Only variables should be assigned by reference".
*
* Revision 1.13  2005/12/01 17:27:28  jp_milcent
* Gestion des chemins relatifs de l'appli pour les images de la recherche de taxons.
*
* Revision 1.12  2005/11/28 16:53:01  jp_milcent
* Restriction du nombre de variables de session.
*
* Revision 1.11  2005/11/23 18:07:23  jp_milcent
* Début correction des bogues du module Fiche suite à mise en ligne eFlore Beta.
*
* Revision 1.10  2005/09/12 08:19:14  jp_milcent
* Fin de la gestion de l'arborescence.
*
* Revision 1.9  2005/09/05 15:53:30  jp_milcent
* Ajout de la gestion du bouton plus et moins.
* Optimisation en cours.
*
* Revision 1.8  2005/08/31 16:40:58  jp_milcent
* Correction de quelques bogues sur la navigation dans la classification.
*
* Revision 1.7  2005/08/30 16:11:13  jp_milcent
* La recherche dans la classification fonctionne de manière récursive.
*
* Revision 1.6  2005/08/26 16:45:09  jp_milcent
* Amélioration de la navigation dans la classif.
*
* Revision 1.5  2005/08/22 16:10:41  jp_milcent
* Gestion de l'arborescence de la classif en cours...
*
* Revision 1.4  2005/08/19 13:54:11  jp_milcent
* Début de gestion de la navigation au sein de la classification.
*
* Revision 1.3  2005/08/19 08:34:36  jp_milcent
* Gestion de la recherche par taxon en cours...
*
* Revision 1.2  2005/08/17 15:37:50  jp_milcent
* Gestion de la rechercher par taxon en cours...
*
* Revision 1.1  2005/08/11 10:15:49  jp_milcent
* Fin de gestion des noms verna avec requête rapide.
* Début gestion choix aplhabétique des taxons.
*
*
* +-- Fin du code ----------------------------------------------------------------------------------------+
*/
?>