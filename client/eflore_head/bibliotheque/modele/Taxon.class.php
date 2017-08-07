<?php
/*vim: set expandtab tabstop=4 shiftwidth=4: */ 
// +------------------------------------------------------------------------------------------------------+
// | PHP version 5.0.4                                                                                    |
// +------------------------------------------------------------------------------------------------------+
// | Copyright (C) 2005 Tela Botanica (accueil@tela-botanica.org)                                         |
// +------------------------------------------------------------------------------------------------------+
// | This file is part of eFlore.                                                                         |
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
// CVS : $Id: Taxon.class.php,v 1.5 2006-03-07 11:07:08 jp_milcent Exp $
/**
* Classe : Taxon
*
* 
*
*@package eFlore
*@subpackage taxon
//Auteur original :
*@author        Jean-Pascal MILCENT <jpm@tela-botanica.org>
//Autres auteurs :
*@author        aucun
*@copyright     Tela-Botanica 2000-2005
*@version       $Revision: 1.5 $ $Date: 2006-03-07 11:07:08 $
// +------------------------------------------------------------------------------------------------------+
*/

// +------------------------------------------------------------------------------------------------------+
// |                                            ENTETE du PROGRAMME                                       |
// +------------------------------------------------------------------------------------------------------+


// +------------------------------------------------------------------------------------------------------+
// |                                            CORPS du PROGRAMME                                        |
// +------------------------------------------------------------------------------------------------------+

class Taxon extends AModele
{
	/*** Attributes : ***/
	private $id_nom_retenu;
	private $id_rang;
		
	/*** Constructeur : ***/
	
	public function __construct( &$donnees = array() ) {
		foreach ($donnees as $cle => $val) {
			switch ($cle) {
				case 'et_id_taxon' :
					$this->setId($val, 'taxon');
					unset($donnees[$cle]);
					break;
				case 'et_id_version_projet_taxon' :
					$this->setId($val, 'version_projet_taxon');
					unset($donnees[$cle]);
					break;
				case 'esn_id_version_projet_nom' :
					$this->setId($val, 'version_projet_nom');
					unset($donnees[$cle]);
					break;
				case 'esn_id_nom' :
				case 'en_id_nom' :
					$this->setIdNomRetenu($val);
					unset($donnees[$cle]);
					break;
				case 'en_ce_rang' :
					$this->setIdRang($val);
					unset($donnees[$cle]);
					break;
			}
		}
		parent::__construct($donnees);
	}
	
	/*** Accesseurs : ***/
	
	/**
	 * Lit la valeur de l'attribut id_nom_retenu.
	 *
	 * @return int
	 * @access public
	 */
	public function getIdNomRetenu( ) {
		return (int)$this->id_nom_retenu;
	} // end of member function getIdNomRetenu

	/**
	 * Définit la valeur de l'attribut id_nom_retenu.
	 *
	 * @param int Contient l'identifiant du nom retenu pour ce taxon.
	 * @return void
	 * @access public
	 */
	public function setIdNomRetenu( $id_nom_retenu ) {
		$this->id_nom_retenu = $id_nom_retenu;
	} // end of member function setIdNomRetenu
	
	/**
	 * Lit la valeur de l'attribut id_rang.
	 *
	 * @return int
	 * @access public
	 */
	public function getIdRang( ) {
		return (int)$this->id_rang;
	} // end of member function getRang

	/**
	 * Définit la valeur de l'attribut id_rang.
	 *
	 * @param int Contient l'identifiant du rang de ce taxon.
	 * @return void
	 * @access public
	 */
	public function setIdRang( $id_rang ) {
		$this->id_rang = $id_rang;
	} // end of member function setIdRang
	
	/*** Méthodes : ***/
	
}


/* +--Fin du code ----------------------------------------------------------------------------------------+
*
* $Log: Taxon.class.php,v $
* Revision 1.5  2006-03-07 11:07:08  jp_milcent
* Fusion avec les corrections de la branche livraison_bdnbe_v1.
*
* Revision 1.4.6.1  2006/03/07 10:36:20  jp_milcent
* Ajout de la gestion de l'id de la version du projet du nom retenu.
*
* Revision 1.4  2005/09/26 15:48:15  jp_milcent
* Fin de l'onglet synthèse pour la fiche d'un taxon.
*
* Revision 1.3  2005/08/19 08:34:36  jp_milcent
* Gestion de la recherche par taxon en cours...
*
* Revision 1.2  2005/08/11 10:15:48  jp_milcent
* Fin de gestion des noms verna avec requête rapide.
* Début gestion choix aplhabétique des taxons.
*
* Revision 1.1  2005/08/05 15:13:35  jp_milcent
* Gestion de l'affichage des résultats des recherches taxonomiques (en cours).
*
*
* +-- Fin du code ----------------------------------------------------------------------------------------+
*/
?>