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
* Classe SelectionNom
*
* Description
*
*@package eFlore
*@subpackage modele
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

class SelectionNom extends aDonneesObjet
{
	/*** Constantes : ***/
	
	/** Constante définissant le nom de l'objet.*/
	const CLASSE_NOM = 'SelectionNom';
	
	/*** Attributes : ***/
	private $code_numerique_1;
	private $code_numerique_2;
	private $code_alphanumerique_1;
	private $code_alphanumerique_2;
	private $commentaire_nomenclatural;
	private $notes_nom_selection;
	
	/*** Constructeur : ***/
	
	/*** Accesseurs : ***/
	// Code Numerique 1
	public function getCodeNumerique1()
	{
		return $this->code_numerique_1;
	}
	public function setCodeNumerique1( $cn )
	{
		$this->code_numerique_1 = $cn;
		$this->setMetaAttributsUtilises('code_numerique_1');
	}
	
	// Code Numerique 2
	public function getCodeNumerique2()
	{
		return $this->code_numerique_2;
	}
	public function setCodeNumerique2( $cn )
	{
		$this->code_numerique_2 = $cn;
		$this->setMetaAttributsUtilises('code_numerique_2');
	}
	
	// Code Alphanumerique 1
	public function getCodeAlphanumerique1()
	{
		return $this->code_alphanumerique_1;
	}
	public function setCodeAlphanumerique1( $ca )
	{
		$this->code_alphanumerique_1 = $ca;
		$this->setMetaAttributsUtilises('code_alphanumerique_1');
	}
	
	// Code Alphanumerique 2
	public function getCodeAlphanumerique2()
	{
		return $this->code_alphanumerique_2;
	}
	public function setCodeAlphanumerique2( $ca )
	{
		$this->code_alphanumerique_2 = $ca;
		$this->setMetaAttributsUtilises('code_alphanumerique_2');
	}
	
	// Commentaire Nomenclatural
	public function getCommentaireNomenclatural()
	{
		return $this->commentaire_nomenclatural;
	}
	public function setCommentaireNomenclatural( $cn )
	{
		$this->commentaire_nomenclatural = $cn;
		$this->setMetaAttributsUtilises('commentaire_nomenclatural');
	}
	
	// Notes Nom Selection
	public function getNotesNomSelection()
	{
		return $this->notes_nom_selection;
	}
	public function setNotesNomSelection( $nns )
	{
		$this->notes_nom_selection = $nns;
		$this->setMetaAttributsUtilises('notes_nom_selection');
	}
	
	/*** Méthodes : ***/
	
}

/* +--Fin du code ----------------------------------------------------------------------------------------+
*
* $Log$
* Revision 1.2  2007-01-03 17:05:30  jp_milcent
* Remplacement du nom de la classse "aModele" par "aDonneesObjet" pour éviter le téléscopage avec la classe déjà présente dans eFlore.
*
* Revision 1.1  2006/07/20 17:51:29  jp_milcent
* Le dossier modele est renomé en "do" puis les classes qu'il contient sont das "Data Object".
*
* Revision 1.1  2006/07/20 16:11:05  jp_milcent
* Ajout des classes générées automatiquements.
*
*
*
* +-- Fin du code ----------------------------------------------------------------------------------------+
*/
?>