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
* Interface DAO pour ChorologieDonnee
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
interface iDaoEcd {
	/*** Constantes : ***/
	
	/** R�cup�re toutes les informations.*/
	const CONSULTER = 0;
	/** R�cup�re les informations correspondant � un id pr�cis.*/
	const CONSULTER_ID = 1;
	/** R�cup�re l'id maximal.*/
	const CONSULTER_ID_MAX = 2;
	/** R�cup�re les informations permettant de comparer 2 objets.*/
	const CONSULTER_ID_COMPARE = 3;
	/** R�cup�re toutes les donn�es d'un projet.*/
	const CONSULTER_ID_PROJET = 4;
	/** R�cup�re toutes les donn�es pour un taxon et un projet choro donn�.*/
	const CONSULTER_VERSION_CHORO_TAXON = 5;
	/** R�cup�re toutes les zones g�ographiques pour un projet de taxon et un projet choro donn�.*/
	const CONSULTER_ZG_CHORO_VERSION = 6;
	/** R�cup�re tous les projets choro pour un projet de taxon donn�.*/
	const CONSULTER_PROJET_CHORO_VERSION = 7;
	/** R�cup�re tous les taxons pour une zone g�ographique et un projet choro donn�.*/
	const CONSULTER_TAXON_PAR_ZG_ET_PROJET_CHORO = 8;
	/** R�cup�re le nombre de taxons pour une zone g�ographique et un projet choro donn�.*/
	const CONSULTER_NBRE_TAXON_PAR_ZG_ET_PROJET_CHORO = 9;
	/** R�cup�re toutes les infos pour un projet choro donn�.*/
	const CONSULTER_PROJET_CHORO = 10;
	
	/*** M�thodes : ***/

	/**
	* Retourne un objet ChorologieDonnee.
	* 
	* @param integer l'identifiant de la commande de consultation � ex�cuter.
	* @param array le tableau de param�tres � passer � l'ex�cutant de la commande.
	* @return ChorologieDonnee un objet ChorologieDonnee.
	*/
	public function consulter($cmd, $parametres = array());
	
	/**
	* Ajoute une ligne :  Chorologie Donnee.
	* 
	* @param ChorologieDonnee l'objet contenant les valeurs � ajouter.
	* @param string nom de la base de donn�e o� r�aliser l'insertion.
	* @return mixed l'identifiant de la ligne ajout�e ou false.
	*/
	public function ajouter(ChorologieDonnee $obj, $bdd = null);
	
	/**
	* Supprime une ligne :  Chorologie Donnee.
	* 
	* @param ChorologieDonnee l'objet contenant les identifiants de la ligne � supprimer.
	* @return boolean true si la ligne est bien supprim�, sinon false.
	*/
	public function supprimer(ChorologieDonnee $obj);
	
	/**
	* Modifie une ligne :  Chorologie Donnee.
	* 
	* @param ChorologieDonnee l'objet contenant les valeurs � modifier.
	* @return boolean true si la ligne est bien modifi�, sinon false.
	*/
	public function modifier(ChorologieDonnee $obj);

	// Les autres m�thodes communes aux DAO doivent �tre ajout� ici...
}

/* +--Fin du code ----------------------------------------------------------------------------------------+
*
* $Log$
* Revision 1.4  2007-06-27 17:07:45  jp_milcent
* Ajout d'une requete count.
*
* Revision 1.3  2007-06-21 17:43:50  jp_milcent
* Ajout de requetes utilis�es entre autre par le module Chorologie.
*
* Revision 1.2  2007-06-11 12:42:58  jp_milcent
* D�but ajout des requ�tes provenant de des DAO d'eFlore utilis� avant la cr�ation de l'API g�n�rale.
*
* Revision 1.1  2006-07-20 17:50:11  jp_milcent
* Les fichies d'interface sont d�plac� dans un dossier sp�cifique.
*
* Revision 1.4  2006/07/20 16:11:05  jp_milcent
* Ajout des classes g�n�r�es automatiquements.
*
*
*
* +-- Fin du code ----------------------------------------------------------------------------------------+
*/
?>