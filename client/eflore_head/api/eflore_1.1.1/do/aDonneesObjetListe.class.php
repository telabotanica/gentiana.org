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
// CVS : $Id: aDonneesObjetListe.class.php,v 1.1 2007-01-03 17:05:30 jp_milcent Exp $
/**
* eFlore : Classe AModeleListe
*
* 
*
*@package eFlore
*@subpackage abstractions
//Auteur original :
*@author        Jean-Pascal MILCENT <jpm@tela-botanica.org>
//Autres auteurs :
*@author        aucun
*@copyright     Tela-Botanica 2000-2005
*@version       $Revision: 1.1 $ $Date: 2007-01-03 17:05:30 $
// +------------------------------------------------------------------------------------------------------+
*/

// +------------------------------------------------------------------------------------------------------+
// |                                            ENTETE du PROGRAMME                                       |
// +------------------------------------------------------------------------------------------------------+


// +------------------------------------------------------------------------------------------------------+
// |                                            CORPS du PROGRAMME                                        |
// +------------------------------------------------------------------------------------------------------+
/**
 * class AModeleListe
 * 
 *  Classe abstraite représentant un objet de type liste.
 */
class aDonneesObjetListe extends aDonneesObjet
{

	/*** Attributes: ***/

	/**
	 * @access private
	 */
	private $intitule;

	/**
	 * @access private
	 */
	private $abreviation;

	/**
	 * @access private
	 */
	private $description;


	/**
	 *
	 * @return string
	 * @access public
	 */
	public function getIntitule( ) {
		return $this->intitule;
	} // end of member function getIntitule

	/**
	 *
	 * @param string intitule
	 * @return 
	 * @access public
	 */
	public function setIntitule( $intitule ) {
		$this->intitule = $intitule;
	} // end of member function setIntitule

	/**
	 *
	 * @return string
	 * @access public
	 */
	public function getAbreviation( ) {
		return $this->abreviation;
	} // end of member function getAbreviation

	/**
	 *
	 * @param string abreviation
	 * @return 
	 * @access public
	 */
	public function setAbreviation( $abreviation ) {
		$this->abreviation = $abreviation;
	} // end of member function setAbreviation

	/**
	 *
	 * @return string
	 * @access public
	 */
	public function getDescription( ) {
		return $this->description;
	} // end of member function getDescription

	/**
	 *
	 * @param string description
	 * @return 
	 * @access public
	 */
	public function setDescription( $description ) {
		$this->description = $description;
	} // end of member function setDescription

} // end of aDonneesObjetListe


/* +--Fin du code ----------------------------------------------------------------------------------------+
*
* $Log: aDonneesObjetListe.class.php,v $
* Revision 1.1  2007-01-03 17:05:30  jp_milcent
* Remplacement du nom de la classse "aModele" par "aDonneesObjet" pour éviter le téléscopage avec la classe déjà présente dans eFlore.
*
* Revision 1.1  2006/07/20 17:51:29  jp_milcent
* Le dossier modele est renomé en "do" puis les classes qu'il contient sont das "Data Object".
*
* Revision 1.1  2006/04/04 13:59:02  jp_milcent
* Gestion dans des dossier séparés des différentes version de l'API.
*
* Revision 1.1  2005/11/07 17:03:43  jp_milcent
* Début gestion de l'API eFlore commune.
*
* Revision 1.1  2005/08/11 10:15:48  jp_milcent
* Fin de gestion des noms verna avec requête rapide.
* Début gestion choix aplhabétique des taxons.
*
* Revision 1.1  2005/08/04 15:51:45  jp_milcent
* Implémentation de la gestion via DAO.
* Fin page d'accueil.
* Fin formulaire recherche taxonomique.
*
* Revision 1.2  2005/08/03 15:52:31  jp_milcent
* Fin gestion des résultats recherche nomenclaturale.
* Début gestion formulaire taxonomique.
*
* Revision 1.1  2005/08/01 16:18:39  jp_milcent
* Début gestion résultat de la recherche par nom.
*
*
* +-- Fin du code ----------------------------------------------------------------------------------------+
*/
?>