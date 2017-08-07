<?php

class ChorologieDonneeXmlDao extends ModuleChorologieXmlDao {
	
	/*** Attributs: ***/
	
	/*** Constructeurs : ***/

	/*** Destructeurs : ***/

	/*** Accesseurs : ***/

	/*** Méthodes : ***/
	
	/**
	* Retourne un objet ChorologieDonnee.
	* 
	* @param integer l'identifiant de la commande de consultation à exécuter.
	* @param array le tableau de paramêtres à passer à l'exécutant de la commande.
	* @return mixed un objet ChorologieDonnee ou un tableau de ce type d'objet.
	*/
	public function consulter( $cmd, $parametres = array() )
	{
		switch($cmd) {
			case ChorologieDonnee::CONSULTER :
				$xpath = '//eflore/chorologie/corps/localisation';
				$this->setResultatUnique(false);
				break;
			default :
				$message = 'Commande '.$cmd.' inconnue!';
				$e = GestionnaireErreur::formaterMessageErreur($message);
    			trigger_error($e, E_USER_ERROR);
		}
		$this->setRequete($xpath);
		return parent::consulter($parametres);
	}
	
	/**
	* Ajoute une information ChorologieDonnee.
	* 
	* @param ChorologieDonnee l'objet contenant les valeurs ChorologieDonnee à ajouter.
	* @return mixed l'identifiant du nom ajouté ou false en cas d'erreur.
	*/
	public function ajouter( ChorologieDonnee $cd )
	{
		
		$dom =& parent::getDomXml($this->getFichierXml());
		$xpath = new domXPath($dom);
		
		$requete = 	'//eflore/chorologie/corps/localisation[@id_localisation = '.$cd->getId('donnee_choro').
						' and @id_version_projet_localisation = '.$cd->getId('version_projet_donnee_choro').']';
		$localisation = $xpath->query($requete)->item(0);
		if (!is_null($localisation)) {
			echo 'Erreur : le fichier xml contient déjà la donnée chorologique suivante, elle ne sera pas ajoutée :'."\n";
			echo "\t".'id : '.$cd->getId('donnee_choro')."\n";
			echo "\t".'id_version_projet : '.$cd->getId('version_projet_donnee_choro')."\n";
			return false;
		}
		$corps = $xpath->query('//eflore/chorologie/corps')->item(0);
		$localisation = $dom->createElement('localisation');
		$localisation = $corps->appendChild($localisation);	

		// Ajout d'un id
		$id = $cd->getCe('taxon').'-'.$cd->getCe('version_projet_taxon').'-'.$cd->getCe('zone_geo').'-'.$cd->getCe('version_projet_zg');
		$localisation->setAttribute('id', $id);
		
		if (!is_null($cd->getId('donnee_choro'))) {
			$localisation->setAttribute('id_localisation', $cd->getId('donnee_choro'));
		} else {
			echo 'Erreur : l\identifiant de la donnée chorologique n\'est pas renseigné !'."\n";
			return false;
		}
		if (!is_null($cd->getId('version_projet_donnee_choro'))) {
			$localisation->setAttribute('id_version_projet_localisation', $cd->getId('version_projet_donnee_choro'));
		} else {
			echo 'Erreur : l\identifiant de la version du projet de la donnée chorologique n\'est pas renseigné !'."\n";
			return false;
		}
		
		
		if (!is_null($cd->getDateDerniereModif())) {
			$localisation->setAttribute('date_derniere_modif', $cd->getDateDerniereModif());
		} else {
			$localisation->setAttribute('date_derniere_modif', date('Y-m-d H:i:s'));
		}
		if (!is_null($cd->getCeModifierPar())) {
			$localisation->setAttribute('ce_modifier_par', $cd->getCeModifierPar());
		} else {
			$localisation->setAttribute('ce_modifier_par', PersonneContributeur::EFLORE_ROBOT);
		}
		if (!is_null($cd->getCeEtat())) {
			$localisation->setAttribute('ce_etat', $cd->getCeEtat());
		} else {
			$localisation->setAttribute('ce_etat', AdministrationEtat::AJOUTER);
		}
		
		$taxon = $dom->createElement('taxon');
		$taxon->setAttribute('ce_taxon', $cd->getCe('taxon'));
		$taxon->setAttribute('ce_version_projet_taxon', $cd->getCe('version_projet_taxon'));
		$localisation->appendChild($taxon);
		
		$zg = $dom->createElement('zone_geo');
		$zg->setAttribute('ce_zg', $cd->getCe('zone_geo'));
		$zg->setAttribute('ce_version_projet_zg', $cd->getCe('version_projet_zg'));
		$localisation->appendChild($zg);
		
		if (!is_null($cd->getNotes())) {
			$notes = $dom->createElement('notes', $cd->getNotes());
			$localisation->appendChild($notes);
		}
		
		$this->setDomXml($dom);
	}
	
	public function ajouterSansDom( ChorologieDonnee $cd )
	{
		
		$localisation = new DOMElement('localisation');

		// Ajout d'un id
		$id = $cd->getCe('taxon').'-'.$cd->getCe('version_projet_taxon').'-'.$cd->getCe('zone_geo').'-'.$cd->getCe('version_projet_zg');
		$localisation->setAttribute('id', $id);
		
		if (!is_null($cd->getId('donnee_choro'))) {
			$localisation->setAttribute('id_localisation', $cd->getId('donnee_choro'));
		} else {
			echo 'Erreur : l\identifiant de la donnée chorologique n\'est pas renseigné !'."\n";
			return false;
		}
		if (!is_null($cd->getId('version_projet_donnee_choro'))) {
			$localisation->setAttribute('id_version_projet_localisation', $cd->getId('version_projet_donnee_choro'));
		} else {
			echo 'Erreur : l\identifiant de la version du projet de la donnée chorologique n\'est pas renseigné !'."\n";
			return false;
		}
		
		
		if (!is_null($cd->getDateDerniereModif())) {
			$localisation->setAttribute('date_derniere_modif', $cd->getDateDerniereModif());
		} else {
			$localisation->setAttribute('date_derniere_modif', date('Y-m-d H:i:s'));
		}
		if (!is_null($cd->getCeModifierPar())) {
			$localisation->setAttribute('ce_modifier_par', $cd->getCeModifierPar());
		} else {
			$localisation->setAttribute('ce_modifier_par', PersonneContributeur::EFLORE_ROBOT);
		}
		if (!is_null($cd->getCeEtat())) {
			$localisation->setAttribute('ce_etat', $cd->getCeEtat());
		} else {
			$localisation->setAttribute('ce_etat', AdministrationEtat::AJOUTER);
		}
		
		$taxon = new DOMElement('taxon');
		$taxon->setAttribute('ce_taxon', $cd->getCe('taxon'));
		$taxon->setAttribute('ce_version_projet_taxon', $cd->getCe('version_projet_taxon'));
		$localisation->appendChild($taxon);
		
		$zg = new DOMElement('zone_geo');
		$zg->setAttribute('ce_zg', $cd->getCe('zone_geo'));
		$zg->setAttribute('ce_version_projet_zg', $cd->getCe('version_projet_zg'));
		$localisation->appendChild($zg);
		
		if (!is_null($cd->getNotes())) {
			$notes = new DOMElement('notes', $cd->getNotes());
			$localisation->appendChild($notes);
		}
		
		$this->setDomXml($dom);
	}
	
	/**
	* Supprime une information ChorologieDonnee.
	* 
	* @param integer l'identifiant ChorologieDonnee à supprimer.
	* @return boolean true si le nom est bien supprimé, sinon false.
	*/
	public function supprimer( $id )
	{
		
	}
	
	/**
	* Modifie une information ChorologieDonnee.
	* 
	* @param Nom l'objet contenant les valeurs ChorologieDonnee à modifier.
	* @return boolean true si le nom est bien modifié, sinon false.
	*/
	public function modifier( Nom $nom )
	{
		
	}
	
	/**
	* Ajoute les valeurs des champs aux bons attributs.
	* 
	* @return ChorologieDonnee un objet de type nom instancié avec les valeurs d'une requete.
	* @access public
	*/
	public function instancierObjetModele( &$donnees )
	{
		$obj_nom = ChorologieDonnee::CLASSE_NOM;
		$un_objet = new $obj_nom;
		
		$un_objet->setId($donnees->getAttribute('id_localisation'), 'donnee_choro');
		$un_objet->setId($donnees->getAttribute('id_version_projet_localisation'), 'version_projet_donnee_choro');
		$un_objet->setDateDerniereModif($donnees->getAttribute('date_derniere_modif'));
		$un_objet->setCeModifierPar($donnees->getAttribute('ce_modifier_par'));
		$un_objet->setCeEtat($donnees->getAttribute('ce_etat'));
		
		$taxon = $donnees->getElementsByTagName('taxon')->item(0);
		if (!is_null($taxon)) {			
			$un_objet->setCe($taxon->getAttribute('ce_taxon'), 'taxon');
			$un_objet->setCe($taxon->getAttribute('ce_version_projet_taxon'), 'version_projet_taxon');
		}
		
		$zg = $donnees->getElementsByTagName('zone_geo')->item(0);
		if (!is_null($zg)) {			
			$un_objet->setCe($zg->getAttribute('ce_zg'), 'zone_geo');
			$un_objet->setCe($zg->getAttribute('ce_version_projet_zg'), 'version_projet_zg');
		}
		
		return $un_objet;
	}
}
?>