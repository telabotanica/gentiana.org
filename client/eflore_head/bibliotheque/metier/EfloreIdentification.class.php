<?php
/*vim: set expandtab tabstop=4 shiftwidth=4: */
// +------------------------------------------------------------------------------------------------------+
// | PHP version 5.1                                                                                      |
// +------------------------------------------------------------------------------------------------------+
// | Copyright (C) 1999-2006 Tela Botanica (accueil@tela-botanica.org)                                    |
// +------------------------------------------------------------------------------------------------------+
// | This file is part of eflore_bp.                                                                         |
// |                                                                                                      |
// | eflore_bp is free software; you can redistribute it and/or modify                                       |
// | it under the terms of the GNU General Public License as published by                                 |
// | the Free Software Foundation; either version 2 of the License, or                                    |
// | (at your option) any later version.                                                                  |
// |                                                                                                      |
// | eflore_bp is distributed in the hope that it will be useful,                                            |
// | but WITHOUT ANY WARRANTY; without even the implied warranty of                                       |
// | MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the                                        |
// | GNU General Public License for more details.                                                         |
// |                                                                                                      |
// | You should have received a copy of the GNU General Public License                                    |
// | along with Foobar; if not, write to the Free Software                                                |
// | Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA                            |
// +------------------------------------------------------------------------------------------------------+
// CVS : $Id: EfloreIdentification.class.php,v 1.2 2007-07-24 14:32:49 jp_milcent Exp $
/**
* eflore_bp - EfloreIdentification.php
*
* Description : utilise PEAR AUTH 1.5
*
*@package eflore_bp
//Auteur original :
*@author        Jean-Pascal MILCENT <jpm@tela-botanica.org>
//Autres auteurs :
*@author        Aucun
*@copyright     Tela-Botanica 1999-2007
*@version       $Revision: 1.2 $ $Date: 2007-07-24 14:32:49 $
// +------------------------------------------------------------------------------------------------------+
*/

// +------------------------------------------------------------------------------------------------------+
// |                                            ENTÊTE du PROGRAMME                                       |
// +------------------------------------------------------------------------------------------------------+


// +------------------------------------------------------------------------------------------------------+
// |                                            CORPS du PROGRAMME                                        |
// +------------------------------------------------------------------------------------------------------+
class EfloreIdentification {
	
	private $identification;

	/*** Accesseurs ***/
	
	public function getIdentification()
	{
		return $this->identification;
	}

	/*** Constructeur et destructeur ***/	

	public function __construct($identification = null)
	{
		// Nous créons l'objet PEAR AUTH
		if (!is_null($identification)) {
			$this->identification = $identification;
		} else {
			// Authentification via une base de données
			require_once 'Auth.php';
			$param_bdd = array ('dsn' => EF_DSN_PRINCIPAL,
								'table' => 'eflore_personne',
								'usernamecol' => 'ep_login',
								'passwordcol' => 'ep_mot_de_passe',
								'cryptType' => 'md5',
								'db_fields' => '*');
			// L'authentification courrante
			$this->identification = new Auth('DB', $param_bdd, null, false);
			// NOTE : à cause d'un problème de PEAR Auth, nous devons corriger l'option db_fields
			$this->identification->storage->options['db_fields'] = trim($this->identification->storage->options['db_fields'], ' , ');
		}

		// Nous gérons la connexion ou déconnexion
		 if ((isset($_REQUEST['deconnexion']) || isset($_REQUEST['logout'])) && $this->verifierIdentite()) {
			$this->identification->logout();
		 }
		 if (isset($_REQUEST['connexion']) && isset($_POST['password']) && isset($_POST['username'])) {
			// NOTE : à cause d'un problème de PEAR Auth, nous devons lancer cette méthode
		 	$this->identification->storage->fetchData($_POST['username'], $_POST['password']);
		 }
		 $this->identification->start();
	}

	/*** Méthodes publiques ***/

	public function getIdentite()
	{
		return $this->identification->getAuth();
	}
	
	public function verifierIdentite()
	{
		return $this->identification->checkAuth();
	}
	
	public function getPrenomNom()
	{
		$nom = '';
		if (!defined('PAP_VERSION')) {
			$nom .= $this->identification->getAuthData('ep_prenom').' ';
			$nom .= $this->identification->getAuthData('ep_nom');
		} else {
			$nom .= $this->identification->getAuthData('a_prenom').' ';
			$nom .= $this->identification->getAuthData('a_nom');
		}
		return trim($nom);
	}
	
	public function getCourriel()
	{
		$courriel = '';
		if (!defined('PAP_VERSION')) {
			$courriel = $this->identification->getAuthData('ep_courriel_01');
		} else {
			$courriel = $this->identification->getAuthData('a_mail');
		}
		// Apparament, si le mail est défini comme UserName dans AUTH, il est impossible de le récupérer avec getAuthData()
		// Il faut alors utiliser getUsername()...
		if (empty($courriel) && preg_match('/@/', $this->identification->getUsername())) {
			$courriel = $this->identification->getUsername();
		}
		return $courriel;
	}
}

/* +--Fin du code ----------------------------------------------------------------------------------------+
*
* $Log: EfloreIdentification.class.php,v $
* Revision 1.2  2007-07-24 14:32:49  jp_milcent
* Correction permettant de gérer une identification Pear::Auth extérieure.
*
* Revision 1.1  2007-07-10 16:48:20  jp_milcent
* Ajout d'une classe gérant l'identification dans eFlore.
*
*
* +-- Fin du code ----------------------------------------------------------------------------------------+
*/
?>
