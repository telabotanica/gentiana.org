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
// CVS : $Id$
/**
* project_name
*
* 
*
*@package project_name
*@subpackage 
//Auteur original :
*@author        Jean-Pascal MILCENT <jpm@tela-botanica.org>
//Autres auteurs :
*@author        aucun
*@copyright     Tela-Botanica 2000-2005
*@version       $Revision$ $Date$
// +------------------------------------------------------------------------------------------------------+
*/

// +------------------------------------------------------------------------------------------------------+
// |                                            ENTETE du PROGRAMME                                       |
// +------------------------------------------------------------------------------------------------------+


// +------------------------------------------------------------------------------------------------------+
// |                                            CORPS du PROGRAMME                                        |
// +------------------------------------------------------------------------------------------------------+

class ChorologieInformationXmlDao extends ModuleChorologieXmlDao {
	
	/*** Attributs: ***/
	
	/*** Constructeurs : ***/
	
	/*** Destructeurs : ***/

	/*** Accesseurs : ***/
	
	/*** Méthodes : ***/
	
	/**
	* Retourne un objet ChorologieInformation.
	* 
	* @param integer l'identifiant de la commande de consultation à exécuter.
	* @param array le tableau de paramêtres à passer à l'exécutant de la commande.
	* @return mixed un objet ChorologieInformation ou un tableau de ce type d'objet.
	*/
	public function consulter( $cmd, $parametres )
	{
		switch($cmd) {
			case ChorologieInformation::CONSULTER :
				$xpath = '//eflore/chorologie/corps/localisation';
				$this->setResultatUnique(false);
				break;
			default :
				$message = 'Commande '.$cmd.' inconnue!';
				$e = GestionnaireErreur::formaterMessageErreur($message);
    			trigger_error($e, E_USER_ERROR);
		}
		return parent::consulter($parametres);
	}
	
	/**
	* Ajoute une information ChorologieInformation.
	* 
	* @param ChorologieInformation l'objet contenant les valeurs ChorologieInformation à ajouter.
	* @return interger l'identifiant du nom ajouté.
	*/
	public function ajouter( ChorologieInformation $ci )
	{
		
		$dom =& parent::getDomXml($this->getFichierXml());
		$xpath = new domXPath($dom);
		$requete_localisation = '//eflore/chorologie/corps/localisation[@id_localisation = '.$ci->getCe('donnee_choro').
										' and @id_version_projet_localisation = '.$ci->getCe('version_projet_donnee_choro').']';
		$localisation = $xpath->query($requete_localisation)->item(0);
		
		if (!is_null($localisation)) {
			$requete_notion = $requete_localisation.
									'/notion[@ce_notion = '.$ci->getCe('notion_choro').
									' and @ce_version_projet_notion = '.$ci->getCe('version_projet_notion_choro').']';
			$notion = $xpath->query($requete_notion)->item(0);
			if (!is_null($notion)) {
				echo 'Erreur : la localisation contient déjà la notion suivante, elle ne sera pas ajoutée :'."\n";
				echo "\t".'id : '.$ci->getCe('notion_choro')."\n";
				echo "\t".'id_version_projet : '.$ci->getCe('version_projet_notion_choro')."\n";
				return false;
			}
			// Recherche des id et ordre max
			$requete_notion_info_max_id = '//eflore/chorologie/corps/localisation[position() = last()]/notion[position() = last()]';
			$notion_max = $xpath->query($requete_notion_info_max_id)->item(0);
			$id_max_info = 1;
			$ordre_max_notion = 1;
			if (!is_null($notion_max)) {
				$id_max_info = $notion_max->getAttribute('id_info')+1;
				$ordre_max_notion = $notion_max->getAttribute('ordre')+1;;
			}
			// Création de la notion
			$notion = $dom->createElement('notion');
			if (!is_null($ci->getId('info_choro'))) {
				$notion->setAttribute('id_info', $ci->getId('info_choro'));
			} else {
				$notion->setAttribute('id_info', $id_max_info);
			}
			if (!is_null($ci->getId('version_projet_notion_choro'))) {
				$notion->setAttribute('id_version_projet_info', $ci->getId('version_projet_info_choro'));
			} else {
				// Utilisation de la version du projet de donnée chorologique
				$notion->setAttribute('id_version_projet_info', $ci->getCe('version_projet_donnee_choro'));
			}
			if (!is_null($ci->getCe('notion_choro'))) {
				$notion->setAttribute('ce_notion', $ci->getCe('notion_choro'));
			} else {
				$notion->setAttribute('ce_notion', ChorologieNotion::NULLE);
			}
			if (!is_null($ci->getCe('version_projet_notion_choro'))) {
				$notion->setAttribute('ce_version_projet_notion', $ci->getCe('version_projet_notion_choro'));
			} else {
				$notion->setAttribute('ce_version_projet_notion', Projet::NULLE);
			}
			if (!is_null($ci->getOrdre())) {
				$notion->setAttribute('ordre', $ci->getOrdre());
			} else {
				$notion->setAttribute('ordre', $ordre_max_notion);
			}
			if (!is_null($ci->getDateDerniereModif())) {
				$notion->setAttribute('date_derniere_modif', $ci->getDateDerniereModif());
			} else {
				$notion->setAttribute('date_derniere_modif', date('Y-m-d H:i:s'));
			}
			if (!is_null($ci->getCeModifierPar())) {
				$notion->setAttribute('ce_modifier_par', $ci->getCeModifierPar());
			} else {
				$notion->setAttribute('ce_modifier_par', PersonneContributeur::EFLORE_ROBOT);
			}
			if (!is_null($ci->getCeEtat())) {
				$notion->setAttribute('ce_etat', $ci->getCeEtat());
			} else {
				$notion->setAttribute('ce_etat', AdministrationEtat::AJOUTER);
			}
			$notion = $localisation->appendChild($notion);
			
			if (!is_null($ci->getNotes())) {
				$notes = $dom->createElement('notes', $ci->getNotes());
				$notion->appendChild($notes);
			}
			$this->setDomXml($dom);
		} else {
			echo 'Erreur : le fichier xml ne contient pas la donnée chorologique suivante, la notion ne peut donc pas être ajoutée :'."\n";
			echo "\t".'id : '.$ci->getCe('donnee_choro')."\n";
			echo "\t".'id_version_projet : '.$ci->getCe('version_projet_donnee_choro')."\n";
			return false;
		}
	}
	
	/**
	* Supprime une information ChorologieInformation.
	* 
	* @param integer l'identifiant ChorologieInformation à supprimer.
	* @return boolean true si le nom est bien supprimé, sinon false.
	*/
	public function supprimer( $id )
	{
		
	}
	
	/**
	* Modifie une information ChorologieInformation.
	* 
	* @param Nom l'objet contenant les valeurs ChorologieInformation à modifier.
	* @return boolean true si le nom est bien modifié, sinon false.
	*/
	public function modifier( Nom $nom )
	{
		
	}
	
	/**
	* Ajoute les champs aux bons attributs. 
	* @return array
	* @access public
	*/
	public function attribuerChamps( $donnees )
	{
		$obj_nom = ChorologieInformation::CLASSE_NOM;
		$un_objet = new $obj_nom;
		
		$un_objet->setId($donnees->getAttribute('id_info'), 'info_choro');
		$un_objet->setId($donnees->getAttribute('id_version_projet_info'), 'version_projet_info_choro');
		// A FAIRE : gérer les clés des données choro
		$un_objet->setCe($donnees->getAttribute('ce_notion'), 'notion_choro');
		$un_objet->setCe($donnees->getAttribute('ce_version_projet_notion'), 'version_projet_notion_choro');
		$un_objet->setOrdre($donnees->getAttribute('ordre'));
		$un_objet->setDateDerniereModif($donnees->getAttribute('date_derniere_modif'));
		$un_objet->setCeModifierPar($donnees->getAttribute('ce_modifier_par'));
		$un_objet->setCeEtat($donnees->getAttribute('ce_etat'));

		// Ajout de la note éventuelle
		$notes = $donnees->getElementsByTagName('notes')->item(0);
		if (!is_null($notes)) {			
			$un_objet->setNotes($taxon->getAttribute('ce_taxon'));
		}
		
		// A FAIRE : Ajouter les sources...
				
		return $un_objet;
	}
}

/* +--Fin du code ----------------------------------------------------------------------------------------+
*
* $Log$
* Revision 1.1  2006-04-04 13:59:02  jp_milcent
* Gestion dans des dossier séparés des différentes version de l'API.
*
* Revision 1.2  2005/11/15 17:30:01  jp_milcent
* Fin test du DAO XML.
*
* Revision 1.1  2005/11/10 17:17:20  jp_milcent
* Gestion du DAO XML en cours...
*
*
* +-- Fin du code ----------------------------------------------------------------------------------------+
*/
?>