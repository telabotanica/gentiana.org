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
* Interface DAO pour Zg
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
interface iDaoEzg {
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
	/** Récupère toutes les données pour un projet et un groupe d'id.*/
	const CONSULTER_ID_PROJET_GROUPE_ID = 5;
	/** Récupère toutes les infos pour un code et un projet de zone géo.*/
	const CONSULTER_PROJET_ID_CODE = 6;
	/** Récupère toutes les infos pour un code utilisant la clause LIKE et un projet de zone géo.*/
	const CONSULTER_PROJET_ID_CODE_LIKE = 7;
	/** Récupère toutes les infos pour groupe d'id et un projet de zone géo.*/
	const CONSULTER_GROUPE_ID = 8;
	
	/*** Méthodes : ***/

	/**
	* Retourne un objet Zg.
	* 
	* @param integer l'identifiant de la commande de consultation à exécuter.
	* @param array le tableau de paramêtres à passer à l'exécutant de la commande.
	* @return Zg un objet Zg.
	*/
	public function consulter($cmd, $parametres = array());
	
	/**
	* Ajoute une ligne :  Zg.
	* 
	* @param Zg l'objet contenant les valeurs à ajouter.
	* @param string nom de la base de donnée où réaliser l'insertion.
	* @return mixed l'identifiant de la ligne ajoutée ou false.
	*/
	public function ajouter(Zg $obj, $bdd = null);
	
	/**
	* Supprime une ligne :  Zg.
	* 
	* @param Zg l'objet contenant les identifiants de la ligne à supprimer.
	* @return boolean true si la ligne est bien supprimé, sinon false.
	*/
	public function supprimer(Zg $obj);
	
	/**
	* Modifie une ligne :  Zg.
	* 
	* @param Zg l'objet contenant les valeurs à modifier.
	* @return boolean true si la ligne est bien modifié, sinon false.
	*/
	public function modifier(Zg $obj);

	// Les autres méthodes communes aux DAO doivent être ajouté ici...
}

/* +--Fin du code ----------------------------------------------------------------------------------------+
*
* $Log$
* Revision 1.5  2007-06-21 17:43:50  jp_milcent
* Ajout de requetes utilisées entre autre par le module Chorologie.
*
* Revision 1.4  2007-06-11 12:42:58  jp_milcent
* Début ajout des requêtes provenant de des DAO d'eFlore utilisé avant la création de l'API générale.
*
* Revision 1.3  2007-02-09 16:20:44  jp_milcent
* Mise à jour vers la version 1.2 des interface des classes du module zg.
*
* Revision 1.2  2007/01/03 17:06:21  jp_milcent
* Ajout de requêtes de consultation utilisées par l'interface web eFlore.
*
* Revision 1.1  2006/07/20 17:50:11  jp_milcent
* Les fichies d'interface sont déplacé dans un dossier spécifique.
*
* Ajout des classes générées automatiquements.
*
*
*
* +-- Fin du code ----------------------------------------------------------------------------------------+
*/
?>