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
// CVS : $Id: efre_form_taxon.vue.php,v 1.9 2006-07-07 09:26:17 jp_milcent Exp $
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
*@version       $Revision: 1.9 $ $Date: 2006-07-07 09:26:17 $
// +------------------------------------------------------------------------------------------------------+
*/

// +------------------------------------------------------------------------------------------------------+
// |                                            ENTETE du PROGRAMME                                       |
// +------------------------------------------------------------------------------------------------------+


// +------------------------------------------------------------------------------------------------------+
// |                                            CORPS du PROGRAMME                                        |
// +------------------------------------------------------------------------------------------------------+

class VueFormTaxon extends aVue {
	/**
	* @param string filename of template
	*/
	public function __construct($Registre)
	{
		$this->setNom('form_taxon');
		parent::__construct($Registre);
		// Création du Squelette
		$this->setSquelette( new HTML_Template_IT( $this->getChemin() ) );
	}
	
	public function preparer()
	{
		// Récupération d'une référence au squelette
		$squelette = $this->getSquelette();
		
		$bool_projet_multiple = false;
		foreach ($this->getDonnees('referenciels') as $referenciel) {
			foreach ($referenciel['versions'] as $version) {
				if (count($this->getDonnees('referenciels')) > 1 || count($referenciel['versions']) > 1) {
					$bool_projet_multiple = true;
					$squelette->setCurrentBlock('REFERENCIEL') ;
					$squelette->setVariable('EFLORE_REF_MULTIPLE_ABREVIATION', $referenciel['abreviation']);
					$squelette->setVariable('EFLORE_REF_MULTIPLE_VERSION', $version['code']);
					$squelette->setVariable('EFLORE_REF_MULTIPLE_INTITULE', $referenciel['intitule']);
					$squelette->setVariable('EFLORE_REF_MULTIPLE_ID', $version['id']);
					if ($bool_projet_multiple) {
						if ($GLOBALS['eflore_referenciel'] == $version['id']) {
							$squelette->setVariable('EFLORE_REF_MULTIPLE_SELECTED', ' selected="selected"');
							// Ajout du nom du référenciel courant à la la variable globale pour l'affichage du 
							// "résumé de la recherche"'
							// TODO : améliorer la gestion des cette variable. Il faudrait au moins utiliser $GLOBALS['_EFLORE_']
							$GLOBALS['eflore_referenciel_nom']['intitule'] = $referenciel['intitule'];
							$GLOBALS['eflore_referenciel_nom']['abreviation'] = $referenciel['abreviation'];
							$GLOBALS['eflore_referenciel_nom']['code'] = $version['code'];
						} else {
							$squelette->setVariable('EFLORE_REF_MULTIPLE_SELECTED', '');
						}
					}
					$squelette->parseCurrentBlock('REFERENCIEL');
				} else {
					$squelette->setCurrentBlock('REFERENCIEL_UNIQUE');
					$squelette->setVariable('EFLORE_REF_UNIQUE_ABREVIATION', $referenciel['abreviation']);
					$squelette->setVariable('EFLORE_REF_UNIQUE_VERSION', $version['code']);
					$squelette->setVariable('EFLORE_REF_UNIQUE_INTITULE', $referenciel['intitule']);
					$squelette->setVariable('EFLORE_REF_UNIQUE_ID', $version['id']);
					$squelette->parseCurrentBlock('REFERENCIEL_UNIQUE');
					// Ajout du nom du référenciel courant à la la variable globale pour l'affichage du 
					// "résumé de la recherche"'
					// TODO : améliorer la gestion des cette variable. Il faudrait au moins utiliser $GLOBALS['_EFLORE_']
					$GLOBALS['eflore_referenciel_nom']['intitule'] = $referenciel['intitule'];
					$GLOBALS['eflore_referenciel_nom']['abreviation'] = $referenciel['abreviation'];
					$GLOBALS['eflore_referenciel_nom']['code'] = $version['code'];
				}

			}
		}
		if ($bool_projet_multiple) {
			$squelette->setCurrentBlock('REFERENCIEL_MULTIPLE');
			$squelette->parseCurrentBlock('REFERENCIEL_MULTIPLE');
		}
		
		foreach ($this->getDonnees('rangs') as $un_rang) {
			$squelette->setCurrentBlock('RANG');
			$squelette->setVariable('RANG_ID', $un_rang->getId('rang'));
			$squelette->setVariable('RANG_NOM', $un_rang->getIntitule());
			if ($GLOBALS['eflore_rang'] == $un_rang->getId('rang')) {
				$squelette->setVariable('EFLORE_RANG_SELECTED', ' selected="selected"');
			} else {
				$squelette->setVariable('EFLORE_RANG_SELECTED', '');
			}
			$squelette->parseCurrentBlock('RANG');
		}
		
		if (array_key_exists('lettre', $this->getDonnees()) && array_key_exists('alphabet', $this->getDonnees())) {
			$squelette->setCurrentBlock('ALPHABET');
			foreach ($this->getDonnees('alphabet') as $lettre => $lettre_nbre) {
				$squelette->setCurrentBlock('LETTRE');
				$squelette->setVariable('EFLORE_FORM_LETTRE', $lettre);
				$squelette->setVariable('EFLORE_FORM_LETTRE_NBRE', $lettre_nbre);
				if ($this->getDonnees('lettre') == $lettre) {
					$lettre_selectionnee = $lettre;
					$squelette->setVariable('EFLORE_FORM_LETTRE_DISABLED', 'disabled="disabled"');
				}
				$squelette->parse('LETTRE');
			}
			$squelette->setVariable('EFLORE_FORM_LETTRE', $lettre_selectionnee);
			$squelette->parse('ALPHABET');
		}
		
		$squelette->setCurrentBlock('FORM_TAXON');
		$squelette->setVariable('URL', $this->getDonnees('url')->getURL());
		$squelette->parseCurrentBlock('FORM_TAXON');
	
	}
	
}

/* +--Fin du code ----------------------------------------------------------------------------------------+
*
* $Log: efre_form_taxon.vue.php,v $
* Revision 1.9  2006-07-07 09:26:17  jp_milcent
* Modification selon les remarques de Daniel du 29 juin 2006.
* Changement de nom de classes abstraites.
*
* Revision 1.8  2006/04/10 17:22:40  jp_milcent
* Fusion avec la livraison bdnbe_v1.
*
* Revision 1.7.2.1  2006/03/08 18:21:31  jp_milcent
* Gestion de la suppression du menu déroulant si un seul référentiel.
* Correction du bogue empéchant le résumé de s'afficher pour la recherche par arbre des taxons.
*
* Revision 1.7  2006/03/03 17:29:17  jp_milcent
* Amélioration de la gestion des variables de session.
* Ajout du nouveau projet indépendant de la BDNFF : BDNBE.
*
* Revision 1.6  2005/12/15 16:01:22  jp_milcent
* Fusion de la branche bdnff_v3_v4 vers la branche principale.
*
* Revision 1.5.2.2  2005/12/13 13:00:59  jp_milcent
* Correction bogue "Only variables should be assigned by reference".
*
* Revision 1.5.2.1  2005/12/08 17:50:33  jp_milcent
* Passage v3+v4 en cours.
*
* Revision 1.5  2005/11/28 16:53:01  jp_milcent
* Restriction du nombre de variables de session.
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