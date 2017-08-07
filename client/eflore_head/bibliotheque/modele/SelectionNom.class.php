<?php
/*vim: set expandtab tabstop=4 shiftwidth=4: */ 
// +------------------------------------------------------------------------------------------------------+
// | PHP version 5.0.4                                                                                    |
// +------------------------------------------------------------------------------------------------------+
// | Copyright (C) 2005 Tela Botanica (accueil@tela-botanica.org)                                         |
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
// CVS : $Id: SelectionNom.class.php,v 1.2 2005-09-16 16:41:45 jp_milcent Exp $
/**
* eFlore : Classe SelectionNom
*
*@package eFlore
*@subpackage selection_nom
//Auteur original :
*@author        Jean-Pascal MILCENT <jpm@tela-botanica.org>
//Autres auteurs :
*@author        aucun
*@copyright     Tela-Botanica 2000-2005
*@version       $Revision: 1.2 $ $Date: 2005-09-16 16:41:45 $
// +------------------------------------------------------------------------------------------------------+
*/

// +------------------------------------------------------------------------------------------------------+
// |                                            ENTETE du PROGRAMME                                       |
// +------------------------------------------------------------------------------------------------------+


// +------------------------------------------------------------------------------------------------------+
// |                                            CORPS du PROGRAMME                                        |
// +------------------------------------------------------------------------------------------------------+

class SelectionNom extends AModele
{
	/*** Attributes : ***/

	private $ce_statut;
	private $code_numerique_1;
	private $code_numerique_2;
	private $code_alphanumerique_1;
	private $code_alphanumerique_2;
	private $commentaire_nomenclatural;
	
	/*** Constructeur : ***/
	
	public function __construct( )
	{

	}
	
	/*** Accesseurs : ***/

	// Ce Statut
	public function setCeStatut( $cs )
	{
		$this->ce_statut = $cs; 
	}
	public function getCeStatut()
	{
		return $this->ce_statut; 
	}
	
	// Code Numérique 1
	public function getCodeNumerique1()
	{
		return $this->code_numerique_1; 
	}
	public function setCodeNumerique1( $cn1 )
	{
		$this->code_numerique_1 = $cn1; 
	}
	
	// Code Numérique 2
	public function getCodeNumerique2()
	{
		return $this->code_numerique_2; 
	}
	public function setCodeNumerique2( $cn2 )
	{
		$this->code_numerique_2 = $cn2; 
	}
	
	// Code Alphanumérique 1
	public function getCodeAlphanumerique1()
	{
		return $this->code_alphanumerique_1; 
	}
	public function setCodeAlphanumerique1( $can1 )
	{
		$this->code_alphanumerique_1 = $can1; 
	}
	
	// Code Alphanumérique 2
	public function getCodeAlphanumerique2()
	{
		return $this->code_alphanumerique_2; 
	}
	public function setCodeAlphanumerique2( $can2 )
	{
		$this->code_alphanumerique_2 = $can2; 
	}
	
	// Commentaire Nomenclatural
	public function getCommentaireNomenclatural()
	{
		return $this->commentaire_nomenclatural; 
	}
	public function setCommentaireNomenclatural( $cn )
	{
		$this->commentaire_nomenclatural = $cn; 
	}
	
	/*** Méthodes : ***/
	

} // end of SelectionNom

/* +--Fin du code ----------------------------------------------------------------------------------------+
*
* $Log: SelectionNom.class.php,v $
* Revision 1.2  2005-09-16 16:41:45  jp_milcent
* Gestion de l'onglet Synthèse en cours.
* Création du modèle pour l'attribution des noms vernaculaires aux taxons.
*
* Revision 1.1  2005/09/14 16:57:58  jp_milcent
* Début gestion des fiches, onglet synthèse.
* Amélioration du modèle et des objets DAO.
*
*
* +-- Fin du code ----------------------------------------------------------------------------------------+
*/
?>