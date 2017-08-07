<?php
/*vim: set expandtab tabstop=4 shiftwidth=4: */ 
// +------------------------------------------------------------------------------------------------------+
// | PHP version 5.0.4                                                                                    |
// +------------------------------------------------------------------------------------------------------+
// | Copyright (C) 2005 Tela Botanica (accueil@tela-botanica.org)                                         |
// +------------------------------------------------------------------------------------------------------+
// | This file is part of eFlore-Fiche.                                                                   |
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
// CVS : $Id: effi_chorologie.vue.php,v 1.10 2007-06-19 10:32:57 jp_milcent Exp $
/**
* Fichier de vue du module eFlore-Fiche : Chorologie
*
* Contient la génération de la vue pour l'onglet "Chorologie".
*
*@package eFlore
*@subpackage ef_fiche
//Auteur original :
*@author        Jean-Pascal MILCENT <jpm@tela-botanica.org>
//Autres auteurs :
*@author        aucun
*@copyright     Tela-Botanica 2000-2005
*@version       $Revision: 1.10 $ $Date: 2007-06-19 10:32:57 $
// +------------------------------------------------------------------------------------------------------+
*/

// +------------------------------------------------------------------------------------------------------+
// |                                            ENTETE du PROGRAMME                                       |
// +------------------------------------------------------------------------------------------------------+


// +------------------------------------------------------------------------------------------------------+
// |                                            CORPS du PROGRAMME                                        |
// +------------------------------------------------------------------------------------------------------+

class VueChorologie extends aVue {
	
	public function __construct($Registre)
	{
		$this->setNom('chorologie');
		parent::__construct($Registre);
		// Création du Squelette
		$this->setSquelette( new HTML_Template_IT( $this->getChemin() ) );
	}
	
	public function preparer()
	{
		// Récupération d'une référence au squelette
		$squelette = $this->getSquelette();
		$NomSelectionFormatage = new NomFormatage($this->getDonnees('nom_selection'));
		$NomRetenuFormatage = new NomFormatage($this->getDonnees('nom_retenu'));

		// Gestion du block Afficher Carte
		if ($this->getDonnees('carto_bool') == true) {
			// Gestion du block légende
			foreach ($this->getDonnees('legende') as $legende) {
				$squelette->setCurrentBlock('LEGENDE_LIGNE');
				$rvb = $legende['couleur']['R'].','.$legende['couleur']['V'].','.$legende['couleur']['B'];
				$squelette->setVariable( 'LEGENDE_COULEUR', 'rgb('.$rvb.')' );
				$squelette->setVariable( 'LEGENDE_INTITULE', $legende['intitule'] );
				$squelette->parseCurrentBlock('LEGENDE_LIGNE');
			}
			
			// Gestion du block AfficherCarte
			$squelette->setCurrentBlock('CARTO');
			$squelette->setVariable( 'CARTE', $this->getDonnees('carte_france')  );
			$squelette->parseCurrentBlock('CARTO');
		} else {
			$squelette->setCurrentBlock('CARTO_INFO');
			$squelette->setVariable( 'CARTO_INFO', $this->getDonnees('carto_info') );
			$squelette->parseCurrentBlock('CARTO_INFO');
		}
		if ($this->getDonnees('projet_id') == EF_PRV_DONNEE_CHORO_DEFAUT_ID) {
			$squelette->setCurrentBlock('CARTO_AVERTISSEMENT');
			$squelette->parseCurrentBlock('CARTO_AVERTISSEMENT');
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
		$squelette->parseCurrentBlock();	
	}
}

/* +--Fin du code ----------------------------------------------------------------------------------------+
*
* $Log: effi_chorologie.vue.php,v $
* Revision 1.10  2007-06-19 10:32:57  jp_milcent
* Début utilisation de classes par module utilisant l'API 1.1.1.
* Renomage des anciennes classes en "Deprecie".
*
* Revision 1.9  2007-01-17 17:05:37  jp_milcent
* Ajout de la gestion de l'avertissement choro en fonction du projet.
*
* Revision 1.8  2006/07/07 09:26:17  jp_milcent
* Modification selon les remarques de Daniel du 29 juin 2006.
* Changement de nom de classes abstraites.
*
* Revision 1.7  2006/05/29 16:11:49  jp_milcent
* Modification interface selon remarque de Daniel du 29 mai 2006.
*
* Revision 1.6  2006/05/02 10:01:40  jp_milcent
* Corrections diverses de l'interface graphique conformément aux demandes de Daniel.
* Ajout du moteur de recherche en haut de la page synthèse.
*
* Revision 1.5  2005/12/09 17:28:44  jp_milcent
* Suppression du passage par référence d'un objet.
*
* Revision 1.4  2005/11/23 18:07:23  jp_milcent
* Début correction des bogues du module Fiche suite à mise en ligne eFlore Beta.
*
* Revision 1.3  2005/10/25 12:50:04  jp_milcent
* Fin amélioration générale.
*
* Revision 1.2  2005/10/11 17:30:31  jp_milcent
* Amélioration gestion de la chorologie en cours.
*
* Revision 1.1  2005/10/04 16:34:03  jp_milcent
* Début gestion de la chorologie.
* Ajout de la bibliothèque de cartographie (à améliorer!).
*
*
* +-- Fin du code ----------------------------------------------------------------------------------------+
*/
?>