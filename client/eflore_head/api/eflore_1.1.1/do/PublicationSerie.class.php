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
* Classe PublicationSerie
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

class PublicationSerie extends aDonneesObjet
{
	/*** Constantes : ***/
	
	/** Constante définissant le nom de l'objet.*/
	const CLASSE_NOM = 'PublicationSerie';
	
	/*** Attributes : ***/
	private $sous_titre;
	private $date_debut;
	private $date_fin;
	private $mark_dans_biblio;
	
	/*** Constructeur : ***/
	
	/*** Accesseurs : ***/
	// Sous Titre
	public function getSousTitre()
	{
		return $this->sous_titre;
	}
	public function setSousTitre( $st )
	{
		$this->sous_titre = $st;
		$this->setMetaAttributsUtilises('sous_titre');
	}
	
	// Date Debut
	public function getDateDebut()
	{
		return $this->date_debut;
	}
	public function setDateDebut( $dd )
	{
		$this->date_debut = $dd;
		$this->setMetaAttributsUtilises('date_debut');
	}
	
	// Date Fin
	public function getDateFin()
	{
		return $this->date_fin;
	}
	public function setDateFin( $df )
	{
		$this->date_fin = $df;
		$this->setMetaAttributsUtilises('date_fin');
	}
	
	// Mark Dans Biblio
	public function getMarkDansBiblio()
	{
		return $this->mark_dans_biblio;
	}
	public function setMarkDansBiblio( $mdb )
	{
		$this->mark_dans_biblio = $mdb;
		$this->setMetaAttributsUtilises('mark_dans_biblio');
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