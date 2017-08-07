<?php
/*vim: set expandtab tabstop=4 shiftwidth=4: */
// +------------------------------------------------------------------------------------------------------+
// | PHP version 5.1                                                                                      |
// +------------------------------------------------------------------------------------------------------+
// | Copyright (C) 1999-2006 Tela Botanica (accueil@tela-botanica.org)                                    |
// +------------------------------------------------------------------------------------------------------+
// | This file is part of eflore_bp.                                                                         |
// |                                                                                                      |
// | eflore_bp is free software; you can redistribute it and/or modify                                       |
// | it under the terms of the GNU General Public License as published by                                 |
// | the Free Software Foundation; either version 2 of the License, or                                    |
// | (at your option) any later version.                                                                  |
// |                                                                                                      |
// | eflore_bp is distributed in the hope that it will be useful,                                            |
// | but WITHOUT ANY WARRANTY; without even the implied warranty of                                       |
// | MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the                                        |
// | GNU General Public License for more details.                                                         |
// |                                                                                                      |
// | You should have received a copy of the GNU General Public License                                    |
// | along with Foobar; if not, write to the Free Software                                                |
// | Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA                            |
// +------------------------------------------------------------------------------------------------------+
// CVS : $Id: EfloreProjet.class.php,v 1.8 2007-08-23 08:00:43 jp_milcent Exp $
/**
* eflore_bp - EfloreProjet.php
*
* Description :
*
*@package eflore_bp
//Auteur original :
*@author        Jean-Pascal MILCENT <jpm@tela-botanica.org>
//Autres auteurs :
*@author        Aucun
*@copyright     Tela-Botanica 1999-2007
*@version       $Revision: 1.8 $ $Date: 2007-08-23 08:00:43 $
// +------------------------------------------------------------------------------------------------------+
*/

// +------------------------------------------------------------------------------------------------------+
// |                                            ENTÊTE du PROGRAMME                                       |
// +------------------------------------------------------------------------------------------------------+


// +------------------------------------------------------------------------------------------------------+
// |                                            CORPS du PROGRAMME                                        |
// +------------------------------------------------------------------------------------------------------+
class EfloreProjet extends aEfloreModule {
		
	public function consulterVersion($version_id = null, $projet_id = null)
	{
		$sql = 	'SELECT * '.
				'FROM eflore_projet_version '.
				((!is_null($version_id)) ? "WHERE eprv_id_version IN ($version_id)" : '').
				((!is_null($projet_id)) ? "WHERE eprv_ce_projet IN ($projet_id)" : '');
		//$this->setDebogage(true);
		$resultat = $this->executerSql($sql);
		return $resultat;
	}
	
	public function verifierVersionHistorique($version_id = null, $projet_id = null)
	{
		$resultat = $this->consulterVersion($version_id, $projet_id);
		if (is_null($resultat['eprv']['date_fin_version']) || $resultat['eprv']['date_fin_version'] == '0000-00-00') {
			return false;
		}
		return true;
	}
		
	public function consulterProjet($projet_id = null, $abbreviation = null)
	{
		$abbreviation = (!is_null($abbreviation)) ? $this->echapperQuote($abbreviation) : null;
		$sql = 	'SELECT * '.
				'FROM eflore_projet '.
				((!is_null($projet_id)) ? "WHERE epr_id_projet = $projet_id " : '').
				((!is_null($abbreviation)) ? "WHERE epr_abreviation_projet = '$abbreviation' " : '');
		//$this->setDebogage(true);
		$resultat = $this->executerSql($sql);
		return $resultat;
	}
	
	public function consulterProjetDerniereVersion($projet_id = null)
	{
		$sql = 	'SELECT DISTINCT * '.				
				'FROM eflore_projet_version '.
				'WHERE '.
				((!is_null($projet_id)) ? "eprv_ce_projet = $projet_id " : '').				
				'AND eprv_date_fin_version IS NULL';
		//$this->setDebogage(true);
		$resultat = $this->executerSql($sql);
		return $resultat;
	}

	// Récupère tous les projets de type synonymie-taxonomie par défaut
	// Une liste d'id de projet peut être passée en paramêtre
	public function consulterProjets($projets_id = null, $consultable = 1)
	{
		$sql = 	'SELECT DISTINCT projet.* '.
				'FROM eflore_projet AS projet, eflore_projet_version, eflore_projet_utiliser_module '. 
				"WHERE epr_mark_projet_consultable = $consultable ". 
				'AND epr_ce_type_projet IN (4, 5) '.
				'AND eprum_id_module = 18 ' .
				'AND eprum_id_version = eprv_id_version '.
				'AND (eprv_date_fin_version IS NULL OR eprv_date_fin_version = "0000-00-00") '.
				'AND eprv_ce_projet = epr_id_projet '.
				((!is_null($projets_id)) ? "AND epr_id_projet IN ($projets_id) " : '');
		//$this->setDebogage(true);
		$resultat = $this->executerSql($sql);
		return $resultat;
	}

}

/* +--Fin du code ----------------------------------------------------------------------------------------+
*
* $Log: EfloreProjet.class.php,v $
* Revision 1.8  2007-08-23 08:00:43  jp_milcent
* Mise en forme et ajout de la consultation de projet par abréviation.
*
* Revision 1.7  2007-08-05 10:52:17  jp_milcent
* Ajout d'une méthode pour vérifier qu'une version est historique ou pas.
*
* Revision 1.6  2007-08-02 22:13:22  jp_milcent
* Ajout des requêtes pour le module Recherche.
*
* Revision 1.5  2007-07-05 19:07:52  jp_milcent
* Amélioration et ajout de requêtes.
*
* Revision 1.4  2007-07-02 15:33:01  jp_milcent
* Utilisation du Wrapper SQL pour l'ensemble des requêtes de ces modules.
*
* Revision 1.3  2007-06-29 16:23:31  jp_milcent
* Ajout de la gestion du wrapper SQL. Mise en classe abstraite de EfloreModule.
*
* Revision 1.2  2007-06-25 16:36:40  jp_milcent
* Correction problème avec la compression de la sortie dans Papyrus.
*
* Revision 1.1  2007-06-22 16:28:51  jp_milcent
* Ajout du module Projet aux classes métiers.
*
*
* +-- Fin du code ----------------------------------------------------------------------------------------+
*/
?>