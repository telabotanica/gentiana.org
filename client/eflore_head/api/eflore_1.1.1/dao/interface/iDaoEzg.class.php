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
	/** R�cup�re toutes les donn�es pour un projet et un groupe d'id.*/
	const CONSULTER_ID_PROJET_GROUPE_ID = 5;
	/** R�cup�re toutes les infos pour un code et un projet de zone g�o.*/
	const CONSULTER_PROJET_ID_CODE = 6;
	/** R�cup�re toutes les infos pour un code utilisant la clause LIKE et un projet de zone g�o.*/
	const CONSULTER_PROJET_ID_CODE_LIKE = 7;
	/** R�cup�re toutes les infos pour groupe d'id et un projet de zone g�o.*/
	const CONSULTER_GROUPE_ID = 8;
	
	/*** M�thodes : ***/

	/**
	* Retourne un objet Zg.
	* 
	* @param integer l'identifiant de la commande de consultation � ex�cuter.
	* @param array le tableau de param�tres � passer � l'ex�cutant de la commande.
	* @return Zg un objet Zg.
	*/
	public function consulter($cmd, $parametres = array());
	
	/**
	* Ajoute une ligne :  Zg.
	* 
	* @param Zg l'objet contenant les valeurs � ajouter.
	* @param string nom de la base de donn�e o� r�aliser l'insertion.
	* @return mixed l'identifiant de la ligne ajout�e ou false.
	*/
	public function ajouter(Zg $obj, $bdd = null);
	
	/**
	* Supprime une ligne :  Zg.
	* 
	* @param Zg l'objet contenant les identifiants de la ligne � supprimer.
	* @return boolean true si la ligne est bien supprim�, sinon false.
	*/
	public function supprimer(Zg $obj);
	
	/**
	* Modifie une ligne :  Zg.
	* 
	* @param Zg l'objet contenant les valeurs � modifier.
	* @return boolean true si la ligne est bien modifi�, sinon false.
	*/
	public function modifier(Zg $obj);

	// Les autres m�thodes communes aux DAO doivent �tre ajout� ici...
}

/* +--Fin du code ----------------------------------------------------------------------------------------+
*
* $Log$
* Revision 1.5  2007-06-21 17:43:50  jp_milcent
* Ajout de requetes utilis�es entre autre par le module Chorologie.
*
* Revision 1.4  2007-06-11 12:42:58  jp_milcent
* D�but ajout des requ�tes provenant de des DAO d'eFlore utilis� avant la cr�ation de l'API g�n�rale.
*
* Revision 1.3  2007-02-09 16:20:44  jp_milcent
* Mise � jour vers la version 1.2 des interface des classes du module zg.
*
* Revision 1.2  2007/01/03 17:06:21  jp_milcent
* Ajout de requ�tes de consultation utilis�es par l'interface web eFlore.
*
* Revision 1.1  2006/07/20 17:50:11  jp_milcent
* Les fichies d'interface sont d�plac� dans un dossier sp�cifique.
*
* Ajout des classes g�n�r�es automatiquements.
*
*
*
* +-- Fin du code ----------------------------------------------------------------------------------------+
*/
?>