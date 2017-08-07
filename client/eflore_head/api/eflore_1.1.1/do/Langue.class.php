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
* Classe Langue
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

class Langue extends aDonneesObjet
{
	/*** Constantes : ***/
	/** Donne l'id du projet ISO-639-1.*/
	const ISO_639_1 = 14;
	/** Donne l'id du projet ISO-639-1.*/
	const ISO_639_2B = 15;
	/** Donne l'id du projet ISO-639-1.*/
	const ISO_639_2T = 16;
	/** Donne l'id du projet SIL.*/
	const SIL = 0;
	
	/** Constante définissant le nom de l'objet.*/
	const CLASSE_NOM = 'Langue';
	
	/*** Attributes : ***/
	private $nom_langue_principal;
	private $code_langue;
	private $note_langue;
	
	/*** Constructeur : ***/
	
	/*** Accesseurs : ***/
	// Nom Langue Principal
	public function getNomLanguePrincipal()
	{
		return $this->nom_langue_principal;
	}
	public function setNomLanguePrincipal( $nlp )
	{
		$this->nom_langue_principal = $nlp;
		$this->setMetaAttributsUtilises('nom_langue_principal');
	}
	
	// Code Langue
	public function getCodeLangue()
	{
		return $this->code_langue;
	}
	public function setCodeLangue( $cl )
	{
		$this->code_langue = $cl;
		$this->setMetaAttributsUtilises('code_langue');
	}
	
	// Note Langue
	public function getNoteLangue()
	{
		return $this->note_langue;
	}
	public function setNoteLangue( $nl )
	{
		$this->note_langue = $nl;
		$this->setMetaAttributsUtilises('note_langue');
	}
	
	/*** Méthodes : ***/
	
}

/* +--Fin du code ----------------------------------------------------------------------------------------+
*
* $Log$
* Revision 1.3  2007-01-03 17:05:30  jp_milcent
* Remplacement du nom de la classse "aModele" par "aDonneesObjet" pour éviter le téléscopage avec la classe déjà présente dans eFlore.
*
* Revision 1.2  2006/12/21 17:25:07  jp_milcent
* Ajout de constante pour récupérer les id des projets.
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