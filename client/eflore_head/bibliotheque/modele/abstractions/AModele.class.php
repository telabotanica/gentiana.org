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
// CVS : $Id: AModele.class.php,v 1.4 2005-09-16 16:41:45 jp_milcent Exp $
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
*@version       $Revision: 1.4 $ $Date: 2005-09-16 16:41:45 $
// +------------------------------------------------------------------------------------------------------+
*/

// +------------------------------------------------------------------------------------------------------+
// |                                            ENTETE du PROGRAMME                                       |
// +------------------------------------------------------------------------------------------------------+


// +------------------------------------------------------------------------------------------------------+
// |                                            CORPS du PROGRAMME                                        |
// +------------------------------------------------------------------------------------------------------+

/**
 * class AModele
 * 
 * Classe abstraite représentant un type de données d'eFlore.
 */
abstract class AModele
{
	/*** Attributs: ***/

	/**
	 * Identifiant du type de données. Dans le cas de clé primaire multiple, nous avons un tableau qui contient les
	 * différentes valeurs des clés.
	 * @access private
	 * @var mixed
	 */
	private $id;

	/**
	 * Identifiant de clé étrangère. Si la table contient plusieurs clés étrangères, nous avons un tableau qui contient
	 * les différentes valeurs des clés.
	 * @access private
	 * @var mixed
	 */
	private $ce;

	
	/**
	 * Notes sur la donnée.
	 * @access private
	 * @var string
	 */
	private $notes;
	
	/**
	 * Date de dernière modification de la donnée.
	 * @access private
	 * @var string
	 */
	private $date_derniere_modif;

	/**
	 * Identifiant de la personne ayant effectué la dernière modification de la donnée.
	 * @access private
	 * @var integer
	 */
	private $ce_modifier_par;

	/**
	 * Identifiant de l'état de la donnée.
	 * @access private
	 * @var integer
	 */
	private $ce_etat;

	
	/*** Constructeur : ***/
	 
	/**
	 * Constructeur du type de données issu de la base de données.
	 *
	 * @param array Tableau contenant les données.
	 * @return object
	 * @access public
	 */
	public function __construct(&$donnees)
	{
		foreach ($donnees as $cle => $val) {
			$this->$cle = $val;
			unset($donnees[$cle]);
		}
	} // end of member function __construct

	/*** Accesseurs : ***/

	// Id 
	/**
	 * Lit la valeur de l'attribut id.
	 *
	 * @return int
	 * @access public
	 */
	public function getId( $cle = null )
	{
		if (is_null($cle)) {
			return $this->id;
		} else {
			return $this->id[$cle];
		}
	} // end of member function getId
	/**
	 * Définit la valeur de l'attribut id.
	 *
	 * @param int id Contient l'id à attribuer à ce type de données.
	 * @return 
	 * @access public
	 */
	public function setId( $id, $cle = null )
	{
		if (is_null($cle)) {
			$this->id = $id;
		} else {
			$this->id[$cle] = $id;
		}
	} // end of member function setId
	
	// Ce 
	/**
	 * Lit la valeur de l'attribut ce.
	 *
	 * @return int
	 * @access public
	 */
	public function getCe( $cle = null )
	{
		if (is_null($cle)) {
			return $this->ce;
		} else {
			return $this->ce[$cle];
		}
	} // end of member function getCe
	/**
	 * Définit la valeur de l'attribut ce.
	 *
	 * @param int ce Contient l'identifiant de la clé étrangère.
	 * @return 
	 * @access public
	 */
	public function setCe( $ce, $cle = null )
	{
		if (is_null($cle)) {
			$this->ce = $ce;
		} else {
			$this->ce[$cle] = $ce;
		}
	} // end of member function setCe
	
	// Notes
	/**
	 * Lit la valeur de l'attribut notes.
	 *
	 * @return string
	 * @access public
	 */
	public function getNotes( )
	{
		return $this->notes;
	} // end of member function getNotes
	/**
	 * Définit la valeur de l'attribut notes.
	 *
	 * @param string Contient les notes à attribuer à ce type de données.
	 * @return 
	 * @access public
	 */
	public function setNotes( $notes )
	{
		$this->notes = $notes;
	} // end of member function setNotes
	
	// Date Dernière Modif
	/**
	* Lit la valeur de l'attribut date_derniere_modif.
	*
	* @return string la date de dernière modif.
	* @access public
	*/
	public function getDateDerniereModif( )
	{
		return $this->date_derniere_modif;
	} // end of member function getDateDerniereModif
	/**
	* Définit la valeur de l'attribut date_derniere_modif.
	*
	* @param string Contient la date de dernière modif.
	* @return void
	* @access public
	*/
	public function setDateDerniereModif( $date )
	{
		$this->date_derniere_modif = $date;
	} // end of member function setDateDerniereModif
	
	// Ce Modifier Par
	/**
	* Lit la valeur de l'attribut ce_modifier_par.
	*
	* @return int l'id de la personne ayant modifié la dernière la donnée.
	* @access public
	*/
	public function getCeModifierPar( )
	{
		return $this->ce_modifier_par;
	} // end of member function getCeModifierPar
	/**
	* Définit la valeur de l'attribut ce_modifier_par.
	*
	* @param int contient l'id de la personne ayant modifié la dernière la donnée.
	* @return void
	* @access public
	*/
	public function setCeModifierPar( $id )
	{
		$this->ce_modifier_par = $id;
	} // end of member function setCeModifierPar
	
	// Ce Etat
	/**
	* Lit la valeur de l'attribut ce_etat.
	*
	* @return int l'id de l'état de la donnée.
	* @access public
	*/
	public function getCeEtat( )
	{
		return $this->ce_etat;
	} // end of member function getCeEtat
	/**
	* Définit la valeur de l'attribut ce_etat.
	*
	* @param int contient l'id de l'état de la donnée.
	* @return void
	* @access public
	*/
	public function setCeEtat( $id )
	{
		$this->ce_etat = $id;
	} // end of member function setEtat
	
	/*** Méthodes : ***/

} // end of AModele



/* +--Fin du code ----------------------------------------------------------------------------------------+
*
* $Log: AModele.class.php,v $
* Revision 1.4  2005-09-16 16:41:45  jp_milcent
* Gestion de l'onglet Synthèse en cours.
* Création du modèle pour l'attribution des noms vernaculaires aux taxons.
*
* Revision 1.3  2005/09/14 16:57:58  jp_milcent
* Début gestion des fiches, onglet synthèse.
* Amélioration du modèle et des objets DAO.
*
* Revision 1.2  2005/08/19 08:34:36  jp_milcent
* Gestion de la recherche par taxon en cours...
*
* Revision 1.1  2005/08/11 10:15:48  jp_milcent
* Fin de gestion des noms verna avec requête rapide.
* Début gestion choix aplhabétique des taxons.
*
* Revision 1.2  2005/08/05 15:13:35  jp_milcent
* Gestion de l'affichage des résultats des recherches taxonomiques (en cours).
*
* Revision 1.1  2005/08/04 15:51:45  jp_milcent
* Implémentation de la gestion via DAO.
* Fin page d'accueil.
* Fin formulaire recherche taxonomique.
*
*
* +-- Fin du code ----------------------------------------------------------------------------------------+
*/
?>