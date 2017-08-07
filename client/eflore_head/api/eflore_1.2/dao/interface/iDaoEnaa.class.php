<?php
// +------------------------------------------------------------------------------------------------------+
// | PHP version 5.2                                                                                      |
// +------------------------------------------------------------------------------------------------------+
// | Copyright (C) 2007 Tela Botanica (accueil@tela-botanica.org)                                         |
// +------------------------------------------------------------------------------------------------------+
// | This file is part of eFlore.                                                                         |
// |                                                                                                      |
// | eFlore is free software; you can redistribute it and/or modify                                       |
// | it under the terms of the GNU General Public License as published by                                 |
// | the Free Software Foundation; either version 2 of the License, or                                    |
// | (at your option) any later version.                                                                  |
// |                                                                                                      |
// | eFlore is distributed in the hope that it will be useful,                                            |
// | but WITHOUT ANY WARRANTY; without even the implied warranty of                                       |
// | MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the                                        |
// | GNU General Public License for more details.                                                         |
// |                                                                                                      |
// | You should have received a copy of the GNU General Public License                                    |
// | along with Foobar; if not, write to the Free Software                                                |
// | Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA                            |
// +------------------------------------------------------------------------------------------------------+
// CVS : $Id: iDaoEnaa.class.php,v 1.1 2007-02-11 19:47:52 jp_milcent Exp $
/**
* Interface DAO pour NaturalisteAbreviation
*
* Description
*
*@package eFlore
*@subpackage dao_interface
//Auteur original :
*@author        Jean-Pascal MILCENT <jpm@tela-botanica.org>
//Autres auteurs :
*@author        aucun
*@copyright     Tela-Botanica 2000-2007
*@version       $Revision: 1.1 $ $Date: 2007-02-11 19:47:52 $
// +------------------------------------------------------------------------------------------------------+
*/

// +------------------------------------------------------------------------------------------------------+
// |                                            ENTETE du PROGRAMME                                       |
// +------------------------------------------------------------------------------------------------------+

// +------------------------------------------------------------------------------------------------------+
// |                                            CORPS du PROGRAMME                                        |
// +------------------------------------------------------------------------------------------------------+
interface iDaoEnaa {
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
	
	/*** Méthodes : ***/

	/**
	* Retourne un objet NaturalisteAbreviation.
	* 
	* @param integer l'identifiant de la commande de consultation à exécuter.
	* @param array le tableau de paramêtres à passer à l'exécutant de la commande.
	* @return NaturalisteAbreviation un objet NaturalisteAbreviation.
	*/
	public function consulter($cmd, $parametres = array());
	
	/**
	* Ajoute une ligne :  Naturaliste Abreviation.
	* 
	* @param NaturalisteAbreviation l'objet contenant les valeurs à ajouter.
	* @param string nom de la base de donnée où réaliser l'insertion.
	* @return mixed l'identifiant de la ligne ajoutée ou false.
	*/
	public function ajouter(NaturalisteAbreviation $obj, $bdd = null);
	
	/**
	* Supprime une ligne :  Naturaliste Abreviation.
	* 
	* @param NaturalisteAbreviation l'objet contenant les identifiants de la ligne à supprimer.
	* @return boolean true si la ligne est bien supprimé, sinon false.
	*/
	public function supprimer(NaturalisteAbreviation $obj);
	
	/**
	* Modifie une ligne :  Naturaliste Abreviation.
	* 
	* @param NaturalisteAbreviation l'objet contenant les valeurs à modifier.
	* @return boolean true si la ligne est bien modifié, sinon false.
	*/
	public function modifier(NaturalisteAbreviation $obj);

	// Les autres méthodes communes aux DAO doivent être ajouté ici...
}

/* +--Fin du code ----------------------------------------------------------------------------------------+
*
* $Log: iDaoEnaa.class.php,v $
* Revision 1.1  2007-02-11 19:47:52  jp_milcent
* Début gestion de l'api de la version 1.2 d'eFlore.
*
*
* +-- Fin du code ----------------------------------------------------------------------------------------+
*/
?>