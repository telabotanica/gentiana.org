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
// CVS : $Id: aDonneesObjet.class.php,v 1.6 2007-06-27 17:09:20 jp_milcent Exp $
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
*@version       $Revision: 1.6 $ $Date: 2007-06-27 17:09:20 $
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
abstract class aDonneesObjet
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

	/**
	 * Tableau des données attributs utilisés.
	 * @access private
	 * @var array
	 */	
	private $meta_attributs_utilises = array();

	/*** Constructeur : ***/
	 

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
		} else if (isset($this->id[$cle])) {
			return $this->id[$cle];
		} else {
			return false;
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
			$this->setMetaAttributsUtilises( $cle );
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
		} else if (isset($this->ce[$cle])) {
			return $this->ce[$cle];
		} else {
			return false;
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
			$this->setMetaAttributsUtilises( $cle );
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
	}
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
		$this->setMetaAttributsUtilises( 'notes' );
	}
	
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
		$this->setMetaAttributsUtilises( 'date_derniere_modif' );
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
		$this->setMetaAttributsUtilises( 'modifier_par' );
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
		$this->setAttributUtilise( 'etat' );
	} // end of member function setEtat
	
	// Meta Attributs Utilises
	public function getMetaAttributsUtilises()
	{
		return $this->meta_attributs_utilises;
	}
	public function setMetaAttributsUtilises( $attribut )
	{
		if (isset($this->meta_attributs_utilises[$attribut])) {
			$this->meta_attributs_utilises[$attribut] = $this->meta_attributs_utilises[$attribut]+1;
		} else {
			$this->meta_attributs_utilises[$attribut] = 1;
		}
	}
	
	/*** Méthodes : ***/
	// Récupérer toutes les valeurs de l'objet sous forme de tableaux associatif
	public function getTableauAttributs()
	{
		$aso_retour = array();
		foreach ($this->meta_attributs_utilises as $attribut => $val) {
			if ($val >= 1) {
				$donnee = '';
				$bool_id = false;
				$bool_ce = false;
				$methode_get = 'get'.str_replace(' ', '', ucwords(str_replace('_', ' ', $attribut)));
				//trigger_error($methode_get, E_USER_WARNING);
				if (is_callable(array($this, $methode_get))) {
					$donnee = $this->$methode_get();
				} else if ($this->getId($attribut) != '') {
					$donnee = $this->getId($attribut);
					$bool_id = true;
				} else if ($this->getCe($attribut) != '') {
					$donnee = $this->getCe($attribut);
					$bool_ce = true;
				} else if ($this->$attribut != '') {
					// Atribut spéciaux provenant des directement requêtes sql (mot clé AS)
					$donnee = $this->$attribut;
				}
			}
			// Nous affichons seulement les champs contenant une valeur
			if ($donnee != '') {
				// Nous remplaçons version_projet par seulement projet dans un but de simplification et de compatibilité
				// avec la future version 1.2
				$attribut = preg_replace('/^version_(projet_.*)$/', "$1", $attribut);
				if ($bool_id) {
					$aso_retour[$attribut.'_id'] = $donnee;
				} else if ($bool_ce) {
					$aso_retour[$attribut.'_ce'] = $donnee;
				} else {
					$aso_retour[$attribut] = $donnee;
				}
			}
		}
		return $aso_retour;
	}
} // end of AModele

/* +--Fin du code ----------------------------------------------------------------------------------------+
*
* $Log: aDonneesObjet.class.php,v $
* Revision 1.6  2007-06-27 17:09:20  jp_milcent
* Mise en forme.
*
* Revision 1.5  2007-06-25 16:38:24  jp_milcent
* Suppression de sauts de ligne inutile.
*
* Revision 1.4  2007-06-21 17:44:51  jp_milcent
* Ajout de la gestion des attributs provenant des requetes sql.
*
* Revision 1.3  2007-06-19 10:32:57  jp_milcent
* Début utilisation de classes par module utilisant l'API 1.1.1.
* Renomage des anciennes classes en "Deprecie".
*
* Revision 1.2  2007-06-18 14:39:51  jp_milcent
* Ajout d'une méthode permettant de récupérer un tableau associatif des attributs utilisés et non vides.
*
* Revision 1.1  2007-01-03 17:05:30  jp_milcent
* Remplacement du nom de la classse "aModele" par "aDonneesObjet" pour éviter le téléscopage avec la classe déjà présente dans eFlore.
*
* Revision 1.1  2006/07/20 17:51:29  jp_milcent
* Le dossier modele est renomé en "do" puis les classes qu'il contient sont das "Data Object".
*
* Revision 1.1  2006/04/04 13:59:02  jp_milcent
* Gestion dans des dossier séparés des différentes version de l'API.
*
* Revision 1.5  2006/02/16 18:20:17  jp_milcent
* Poursuite amélioration de l'API.
*
* Revision 1.4  2006/02/10 17:34:15  jp_milcent
* Début gestion de l'ajout, modif et suppression.
*
* Revision 1.3  2005/11/15 17:33:00  jp_milcent
* Ajout de nouveaux objets au modèle.
* Ajout de constantes à certains objets du modèle.
*
* Revision 1.2  2005/11/07 21:58:30  jp_milcent
* Corrections de bogue dus à la hiérarchie des classes.
*
* Revision 1.1  2005/11/07 17:03:44  jp_milcent
* Début gestion de l'API eFlore commune.
*
* Revision 1.4  2005/09/16 16:41:45  jp_milcent
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