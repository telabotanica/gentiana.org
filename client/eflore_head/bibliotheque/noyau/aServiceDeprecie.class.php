<?php
/*vim: set expandtab tabstop=4 shiftwidth=4: */ 
// +------------------------------------------------------------------------------------------------------+
// | PHP version 5.0.4                                                                                    |
// +------------------------------------------------------------------------------------------------------+
// | Copyright (C) 2005 Tela Botanica (accueil@tela-botanica.org)                                         |
// +------------------------------------------------------------------------------------------------------+
// | This file is part of project_name.                                                                |
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
// CVS : $Id: aServiceDeprecie.class.php,v 1.1 2007-07-17 07:48:33 jp_milcent Exp $
/**
* Classe Service
*
* 
*
*@package Noyau
*@subpackage 
//Auteur original :
*@author        Jean-Pascal MILCENT <jpm@tela-botanica.org>
//Autres auteurs :
*@author        aucun
*@copyright     Tela-Botanica 2000-2005
*@version       $Revision: 1.1 $ $Date: 2007-07-17 07:48:33 $
// +------------------------------------------------------------------------------------------------------+
*/

// +------------------------------------------------------------------------------------------------------+
// |                                            ENTETE du PROGRAMME                                       |
// +------------------------------------------------------------------------------------------------------+


// +------------------------------------------------------------------------------------------------------+
// |                                            CORPS du PROGRAMME                                        |
// +------------------------------------------------------------------------------------------------------+

abstract class aServiceDeprecie {
	
	/*** Attributs : ***/
	private $nom;
	private $registre;
	private $format;
	
	/*** Constructeur : ***/

	public function __construct($Registre)
	{
		if (is_null($Registre)) {
			$Registre = Registre::getInstance();
		}
		$Registre->set('module_nom', $this->getNom());
		$this->setRegistre($Registre);
	}
	
	/*** Accesseurs : ***/
	// Nom
	public function setNom( $n )
	{
		$this->nom = $n;
	}
	public function getNom()
	{
		return $this->nom;
	}
	// Registre 
	/**
	* @return object le registre du module.
	*/
	public function getRegistre()
	{
		return $this->registre;
	}
	/**
	* @param Registre le registre du module.
	*/
	public function setRegistre($r)
	{
		$this->registre = $r;
	}
	// Format
	public function setFormat( $f )
	{
		$this->format = $f;
	}
	public function getFormat()
	{
		return $this->format;
	}
	
	/*** Méthodes : ***/
	
	public function executer($action)
	{
		// +-----------------------------------------------------------------------------------------------------------+
		// Initialisation des variables
		$classe_nom = str_replace(' ', '', ucwords(str_replace('_', ' ', $action)));
		$retour = '';
		
		// +-----------------------------------------------------------------------------------------------------------+
		// Mesure du temps d'éxecution : début
		$GLOBALS['_EFLORE_']['chrono']->setTemps(array('debut_recherche_'.$action => microtime()));

		// +-----------------------------------------------------------------------------------------------------------+
		// Gestion de l'appel des actions
		$class_action_nom = $classe_nom.'Action';
		$chemin_fichier_action = EF_CHEMIN_COMMUN_ACTION.$class_action_nom.'.class.php';
		$chemin_fichier_squelette = EF_CHEMIN_COMMUN_SQUELETTE.$action.'.tpl.'.$this->getFormat();
		if (file_exists($chemin_fichier_action)) {
			include_once $chemin_fichier_action;
			if (class_exists($class_action_nom)) {
				$this->getRegistre()->set('module_nom', $this->getNom());
				if (isset($GLOBALS['_EF_']['i18n'][$this->getNom()])) {
					$this->getRegistre()->set('module_i18n', $GLOBALS['_EF_']['i18n'][$this->getNom()]);
				}
				$une_action = new $class_action_nom($this->getRegistre());
				if (method_exists($une_action,'executer')) {
					$tab_donnees = $une_action->executer();
					// +-----------------------------------------------------------------------------------------------+
					// Gestion de la vue
					$class_vue_nom = $classe_nom.'Vue';
					$chemin_fichier_vue = EF_CHEMIN_COMMUN_VUE.$class_vue_nom.'.class.php';
					if (file_exists($chemin_fichier_vue)) {
						include_once $chemin_fichier_vue;
						if (class_exists($class_vue_nom)) {
							// Construction de la vue
							// Ajout d'information au registre pour la vue
							$this->getRegistre()->set('vue_donnees', $tab_donnees);
							$this->getRegistre()->set('vue_format', $this->getFormat());
							$this->getRegistre()->set('vue_chemin_squelette', EF_CHEMIN_COMMUN_SQUELETTE);
							$une_vue = new $class_vue_nom($this->getRegistre());
							// Envoie du rendu
							$une_vue->chargerSquelette();
							$une_vue->preparer();
							$retour = $une_vue->retournerRendu();
						} else {
							trigger_error("Impossible de trouver la classe de vue: $class_vue_nom.", E_USER_ERROR);
						}
					} else {
						trigger_error("Impossible de trouver le fichier de vue: $chemin_fichier_vue.", E_USER_ERROR);
					}
				} else {
					trigger_error("Impossible de trouver la méthode d'action: executer().", E_USER_ERROR);
				}
			} else {
				trigger_error("Impossible de trouver la classe d'action: $class_action_nom.", E_USER_ERROR);
			}
		} else {
			// L'action n'est pas une "action commune", nous utilisons l'action du module. 
			return false;
		}
		
		// +-----------------------------------------------------------------------------------------------------------+
		// Mesure du temps d'éxecution : fin
		$GLOBALS['_EFLORE_']['chrono']->setTemps(array('fin_recherche_'.$action => microtime()));
		
		return $retour;
	}	 
}


/* +--Fin du code ----------------------------------------------------------------------------------------+
*
* $Log: aServiceDeprecie.class.php,v $
* Revision 1.1  2007-07-17 07:48:33  jp_milcent
* Ajout et modification des fichiers nécessaires aux services web.
*
* Revision 1.2  2006-07-11 16:33:10  jp_milcent
* Intégration de l'appllette Xper.
*
* Revision 1.1  2006/07/07 09:26:17  jp_milcent
* Modification selon les remarques de Daniel du 29 juin 2006.
* Changement de nom de classes abstraites.
*
* Revision 1.4  2006/05/11 10:28:27  jp_milcent
* Début modification de l'interface d'eFlore pour la livraison Decaisne.
*
* Revision 1.3  2006/05/02 10:01:40  jp_milcent
* Corrections diverses de l'interface graphique conformément aux demandes de Daniel.
* Ajout du moteur de recherche en haut de la page synthèse.
*
* Revision 1.2  2005/08/19 08:34:36  jp_milcent
* Gestion de la recherche par taxon en cours...
*
* Revision 1.1  2005/08/17 15:37:50  jp_milcent
* Gestion de la rechercher par taxon en cours...
*
*
* +-- Fin du code ----------------------------------------------------------------------------------------+
*/
?>