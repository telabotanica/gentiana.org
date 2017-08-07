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
// CVS : $Id$
/**
* Interface DAO pour LangueValeur
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
*@version       $Revision$ $Date$
// +------------------------------------------------------------------------------------------------------+
*/

// +------------------------------------------------------------------------------------------------------+
// |                                            ENTETE du PROGRAMME                                       |
// +------------------------------------------------------------------------------------------------------+

// +------------------------------------------------------------------------------------------------------+
// |                                            CORPS du PROGRAMME                                        |
// +------------------------------------------------------------------------------------------------------+
interface iDaoElv {
	/*** Constantes : ***/
	
	/** Récupère toutes les informations.*/
	const CONSULTER = 0;
	/** Récupère les informations correspondant à un id précis.*/
	const CONSULTER_ID = 1;
	/** Récupère l'id maximal.*/
	const CONSULTER_ID_MAX = 2;
	/** Récupère les informations permettant de comparer 2 objets.*/
	const CONSULTER_ID_COMPARE = 3;
	/** Récupère toutes les données d'un projet.*/
	const CONSULTER_ID_PROJET = 4;
	/** Récupère toutes les données pour une catégorie donnée.*/
	const CONSULTER_ID_CATEGORIE = 5;
	
	/*** Méthodes : ***/

	/**
	* Retourne un objet LangueValeur.
	* 
	* @param integer l'identifiant de la commande de consultation à exécuter.
	* @param array le tableau de paramêtres à passer à l'exécutant de la commande.
	* @return LangueValeur un objet LangueValeur.
	*/
	public function consulter($cmd, $parametres = array());
	
	/**
	* Ajoute une ligne :  Langue Valeur.
	* 
	* @param LangueValeur l'objet contenant les valeurs à ajouter.
	* @param string nom de la base de donnée où réaliser l'insertion.
	* @return mixed l'identifiant de la ligne ajoutée ou false.
	*/
	public function ajouter(LangueValeur $obj, $bdd = null);
	
	/**
	* Supprime une ligne :  Langue Valeur.
	* 
	* @param LangueValeur l'objet contenant les identifiants de la ligne à supprimer.
	* @return boolean true si la ligne est bien supprimé, sinon false.
	*/
	public function supprimer(LangueValeur $obj);
	
	/**
	* Modifie une ligne :  Langue Valeur.
	* 
	* @param LangueValeur l'objet contenant les valeurs à modifier.
	* @return boolean true si la ligne est bien modifié, sinon false.
	*/
	public function modifier(LangueValeur $obj);

	// Les autres méthodes communes aux DAO doivent être ajouté ici...
}

/* +--Fin du code ----------------------------------------------------------------------------------------+
*
* $Log$
* Revision 1.2  2006-12-21 17:28:48  jp_milcent
* Correction de l'ajout de la consultation par id de catégorie.
*
* Revision 1.1  2006/07/20 17:50:11  jp_milcent
* Les fichies d'interface sont déplacé dans un dossier spécifique.
*
* Revision 1.1  2006/07/20 16:11:05  jp_milcent
* Ajout des classes générées automatiquements.
*
*
*
* +-- Fin du code ----------------------------------------------------------------------------------------+
*/
?>