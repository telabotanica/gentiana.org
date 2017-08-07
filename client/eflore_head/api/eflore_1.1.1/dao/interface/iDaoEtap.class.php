<?php
/*vim: set expandtab tabstop=4 shiftwidth=4: */ 
// +------------------------------------------------------------------------------------------------------+
// | PHP version 5.1.1                                                                                    |
// +------------------------------------------------------------------------------------------------------+
// | Copyright (C) 2006 Tela Botanica (accueil@tela-botanica.org)                                         |
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
// CVS : $Id: iDaoEtap.class.php,v 1.2 2007-01-03 17:06:21 jp_milcent Exp $
/**
* Interface DAO pour TaxonAProtection
*
* Description
*
*@package eFlore
*@subpackage dao_interface
//Auteur original :
*@author        Jean-Pascal MILCENT <jpm@tela-botanica.org>
//Autres auteurs :
*@author        aucun
*@copyright     Tela-Botanica 2000-2006
*@version       $Revision: 1.2 $ $Date: 2007-01-03 17:06:21 $
// +------------------------------------------------------------------------------------------------------+
*/

// +------------------------------------------------------------------------------------------------------+
// |                                            ENTETE du PROGRAMME                                       |
// +------------------------------------------------------------------------------------------------------+

// +------------------------------------------------------------------------------------------------------+
// |                                            CORPS du PROGRAMME                                        |
// +------------------------------------------------------------------------------------------------------+
interface iDaoEtap {
	/*** Constantes : ***/
	
	/** Récupère toutes les informations.*/
	const CONSULTER = 0;
	/** Récupère les informations correspondant à un id précis.*/
	const CONSULTER_ID = 1;
	/** Récupère l'id maximal.*/
	const CONSULTER_ID_MAX = 2;
	/** Récupère les informations permettant de comparer 2 objets.*/
	const CONSULTER_ID_COMPARE = 3;
	/** Récupère les données d'un projet de taxon et d'un taxon donnés.*/
	const CONSULTER_ID_PROJET_TAXON_ID_TAXON = 4;
	
	/*** Méthodes : ***/

	/**
	* Retourne un objet TaxonAProtection.
	* 
	* @param integer l'identifiant de la commande de consultation à exécuter.
	* @param array le tableau de paramêtres à passer à l'exécutant de la commande.
	* @return TaxonAProtection un objet TaxonAProtection.
	*/
	public function consulter($cmd, $parametres = array());
	
	/**
	* Ajoute une ligne :  Taxon A Protection.
	* 
	* @param TaxonAProtection l'objet contenant les valeurs à ajouter.
	* @param string nom de la base de donnée où réaliser l'insertion.
	* @return mixed l'identifiant de la ligne ajoutée ou false.
	*/
	public function ajouter(TaxonAProtection $obj, $bdd = null);
	
	/**
	* Supprime une ligne :  Taxon A Protection.
	* 
	* @param TaxonAProtection l'objet contenant les identifiants de la ligne à supprimer.
	* @return boolean true si la ligne est bien supprimé, sinon false.
	*/
	public function supprimer(TaxonAProtection $obj);
	
	/**
	* Modifie une ligne :  Taxon A Protection.
	* 
	* @param TaxonAProtection l'objet contenant les valeurs à modifier.
	* @return boolean true si la ligne est bien modifié, sinon false.
	*/
	public function modifier(TaxonAProtection $obj);

	// Les autres méthodes communes aux DAO doivent être ajouté ici...
}

/* +--Fin du code ----------------------------------------------------------------------------------------+
*
* $Log: iDaoEtap.class.php,v $
* Revision 1.2  2007-01-03 17:06:21  jp_milcent
* Ajout de requêtes de consultation utilisées par l'interface web eFlore.
*
* Revision 1.1  2006/12/28 20:57:16  jp_milcent
* Ajout du module Protection.
*
* Revision 1.1  2006/07/20 16:11:05  jp_milcent
* Ajout des classes générées automatiquements.
*
*
*
* +-- Fin du code ----------------------------------------------------------------------------------------+
*/
?>