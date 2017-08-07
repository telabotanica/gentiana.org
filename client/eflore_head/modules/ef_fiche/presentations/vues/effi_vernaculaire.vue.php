<?php
/*vim: set expandtab tabstop=4 shiftwidth=4: */ 
// +------------------------------------------------------------------------------------------------------+
// | PHP version 5.0.4                                                                                    |
// +------------------------------------------------------------------------------------------------------+
// | Copyright (C) 2005 Tela Botanica (accueil@tela-botanica.org)                                         |
// +------------------------------------------------------------------------------------------------------+
// | This file is part of eFlore-Fiche.                                                                |
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
// CVS : $Id: effi_vernaculaire.vue.php,v 1.13 2007-06-19 10:32:57 jp_milcent Exp $
/**
* Fichier de vue du module eFlore-Fiche : Vernaculaire
*
* Contient la génération de la vue pour l'onglet "Nom vernaculaire".
*
*@package eFlore
*@subpackage ef_fiche
//Auteur original :
*@author        Jean-Pascal MILCENT <jpm@tela-botanica.org>
//Autres auteurs :
*@author        aucun
*@copyright     Tela-Botanica 2000-2005
*@version       $Revision: 1.13 $ $Date: 2007-06-19 10:32:57 $
// +------------------------------------------------------------------------------------------------------+
*/

// +------------------------------------------------------------------------------------------------------+
// |                                            ENTETE du PROGRAMME                                       |
// +------------------------------------------------------------------------------------------------------+


// +------------------------------------------------------------------------------------------------------+
// |                                            CORPS du PROGRAMME                                        |
// +------------------------------------------------------------------------------------------------------+

class VueVernaculaire extends aVue {
	
	public function __construct($Registre)
	{
		$this->setNom('vernaculaire');
		parent::__construct($Registre);
		// Création du Squelette
		$this->setSquelette( new HTML_Template_IT( $this->getChemin() ) );
	}
	
	public function preparer()
	{
		// Récupération d'une référence au squelette
		$squelette = $this->getSquelette();
		$tab_nvi = $this->getDonnees('noms_verna_intitule');
		$NomSelectionFormatage = new NomFormatage($this->getDonnees('nom_selection'));
		$NomRetenuFormatage = new NomFormatage($this->getDonnees('nom_retenu'));		
		
		// Gestion du block des lignes du tableau des noms vernaculaires
		if ($this->getDonnees('noms_verna_bool') != false) {
			$tab_cle_nv = array();

			// Nous trions le résultat de la recherche
			$tab_noms_verna = $this->getDonnees('noms_verna');
			foreach ($tab_noms_verna as $cle => $val) {
   			$index_langue[$cle]  = $val['lg_intitule'];
   			$index_nom_verna[$cle] = $val['intitule'];
			}
			array_multisort($index_langue, SORT_ASC, $index_nom_verna, SORT_ASC, $tab_noms_verna);

			// Affichage des infos
			$squelette->setCurrentBlock('VERNA');
						
			foreach ($tab_noms_verna as $nv) {
				// Assigne les données au block VERNA
				for ($i = 0; $i < count($tab_nvi); $i++) {
					$cle = $tab_nvi[$i];
					//echo $cle.'<br/>';
					if (!empty($nv[$cle])) {
						//echo $cle.'-'.$nv[$cle].'<br/>';
						switch ($cle) {
							case 'zg_intitule' :
								$squelette->setCurrentBlock('VERNA_CELL_BODY_ZG') ;
								$squelette->setVariable('VERNA_VAL_ZGI', $nv[$cle]);
								$squelette->setVariable('VERNA_VAL_ZGC', $nv['zg_code']);
								$squelette->parseCurrentBlock('VERNA_CELL_BODY_ZG');
								break;
							case 'lg_intitule' :
								$squelette->setCurrentBlock('VERNA_CELL_BODY_LG') ;
								$squelette->setVariable('VERNA_VAL_LGI', $nv[$cle]);
								$squelette->setVariable('VERNA_VAL_LGC', $nv['lg_code']);
								$squelette->parseCurrentBlock('VERNA_CELL_BODY_LG');
								break;
							case 'intitule' :
								$squelette->setCurrentBlock('VERNA_CELL_BODY_NV') ;
								$squelette->setVariable('VERNA_VAL_NOM', $nv[$cle]);
								$squelette->parseCurrentBlock('VERNA_CELL_BODY_NV');
								break;
							case 'genre_nbre' :
								$squelette->setCurrentBlock('VERNA_CELL_BODY_GN') ;
								$squelette->setVariable('VERNA_VAL_GN', $nv[$cle]);
								$squelette->parseCurrentBlock('VERNA_CELL_BODY_GN');
								break;
							case 'emploi' :
								$squelette->setCurrentBlock('VERNA_CELL_BODY_CE') ;
								$squelette->setVariable('VERNA_VAL_CE', $nv[$cle]);
								$squelette->parseCurrentBlock('VERNA_CELL_BODY_CE');
								break;
							case 'notes' :
								$squelette->setCurrentBlock('VERNA_CELL_BODY_NOTE') ;
								$squelette->setVariable('VERNA_VAL_NOTE', $nv[$cle]);
								$squelette->parseCurrentBlock('VERNA_CELL_BODY_NOTE');					
								break;
						}
						$tab_cle_nv[$cle] = $cle;					
					}
				}
				$squelette->setCurrentBlock('VERNA_BODY') ;
				$squelette->parseCurrentBlock('VERNA_BODY');
			}
	
			// Gestion du block d'entête du tableau des noms vernaculaires
			for ($i = 0; $i < count($tab_nvi); $i++) {
				$cle = $tab_nvi[$i];
				if (!empty($tab_cle_nv[$cle])) {
					$squelette->setCurrentBlock('VERNA_CELLULE_HEAD') ;
					switch ($cle) {
						case 'intitule' :
							$titre = 'Nom';
							break;
						case 'genre_nbre' :
							$titre = 'Genre et nombre';
							break;
						case 'zg_code' :
						case 'zg_intitule' :
							$titre = 'Zone géographique';
							break;
						case 'lg_code' :
						case 'lg_intitule' :
							$titre = 'Langue';
							break;
						case 'emploi' :
							$titre = 'Conseil d\'emploi';
							break;
						case 'notes' :
							$titre = 'Notes';
							break;
					}
					$squelette->setVariable('VERNA_CLE', $titre);
					$squelette->parseCurrentBlock('VERNA_CELLULE_HEAD');
				}
			}
			$squelette->setCurrentBlock('VERNA_HEAD') ;
			$squelette->parseCurrentBlock('VERNA_HEAD');
			
			$squelette->parseCurrentBlock('VERNA');
		} else {
			$squelette->setCurrentBlock('VERNA_INFO') ;
			$squelette->setVariable( 'NOM_VERNA_INFO', $this->getDonnees('noms_verna_info') );
			$squelette->parseCurrentBlock('VERNA_INFO');
		}		
		// Gestion du block principal
		$squelette->setCurrentBlock();
		$squelette->setVariable('TITRE_GENERAL_REFERENTIEL', $this->getDonnees('titre_general_referentiel'));
		$squelette->setVariable('FORMULAIRE_RECHERCHE_NOM', $this->getDonnees('un_form_nom'));
		$squelette->setVariable('TITRE', $NomRetenuFormatage->formaterNom(NomDeprecie::FORMAT_ULTRA_SIMPLE));
		if ($this->getDonnees('nom_retenu_famille') != null) {
			$NomFamilleFormatage = new NomFormatage($this->getDonnees('nom_retenu_famille'));
			$squelette->setVariable('NOM_RETENU_FAMILLE', $NomFamilleFormatage->formaterNom(NomDeprecie::FORMAT_ULTRA_SIMPLE) );
		}
		$squelette->setVariable('NOM_RETENU_SIMPLE', $this->getDonnees('nom_retenu_simple') );
		$squelette->parseCurrentBlock();
	}
}

/* +--Fin du code ----------------------------------------------------------------------------------------+
*
* $Log: effi_vernaculaire.vue.php,v $
* Revision 1.13  2007-06-19 10:32:57  jp_milcent
* Début utilisation de classes par module utilisant l'API 1.1.1.
* Renomage des anciennes classes en "Deprecie".
*
* Revision 1.12  2006-07-07 09:26:17  jp_milcent
* Modification selon les remarques de Daniel du 29 juin 2006.
* Changement de nom de classes abstraites.
*
* Revision 1.11  2006/05/29 16:11:49  jp_milcent
* Modification interface selon remarque de Daniel du 29 mai 2006.
*
* Revision 1.10  2006/05/19 12:04:18  jp_milcent
* Exclusion des noms supérieur à l'espèce de la BDNFF v3.02 pour les correspondances de noms retenus.
*
* Revision 1.9  2006/05/02 10:01:40  jp_milcent
* Corrections diverses de l'interface graphique conformément aux demandes de Daniel.
* Ajout du moteur de recherche en haut de la page synthèse.
*
* Revision 1.8  2005/12/09 14:52:16  jp_milcent
* Suppression du passage par référence de l'objet squelette.
*
* Revision 1.7  2005/11/23 18:07:23  jp_milcent
* Début correction des bogues du module Fiche suite à mise en ligne eFlore Beta.
*
* Revision 1.6  2005/10/25 12:50:04  jp_milcent
* Fin amélioration générale.
*
* Revision 1.5  2005/10/20 16:37:49  jp_milcent
* Amélioration de l'onglet Synthèse.
*
* Revision 1.4  2005/10/18 17:17:20  jp_milcent
* Début de la gestion des url d'eFlore.
*
* Revision 1.3  2005/10/04 16:34:03  jp_milcent
* Début gestion de la chorologie.
* Ajout de la bibliothèque de cartographie (à améliorer!).
*
* Revision 1.2  2005/09/30 16:22:01  jp_milcent
* Fin de la gestion de l'onglet Noms Vernaculaires.
*
* Revision 1.1  2005/09/29 16:16:14  jp_milcent
* Fin de la gestion de la synonymie.
* Début de la gestion des noms vernaculaires.
*
*
* +-- Fin du code ----------------------------------------------------------------------------------------+
*/
?>