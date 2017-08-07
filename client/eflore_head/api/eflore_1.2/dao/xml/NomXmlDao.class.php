<?php

class NomXmlDao extends aDaoXml {

	/*** Attributs: ***/
	
	/*** Constructeurs : ***/

	/*** Destructeurs : ***/

	/*** Accesseurs : ***/

	/*** M�thodes : ***/
	
	/**
	* Retourne un objet Nom.
	* 
	* @param integer l'identifiant de la commande de consultation � ex�cuter.
	* @param array le tableau de param�tres � passer � l'ex�cutant de la commande.
	* @return mixed un objet Nom ou un tableau de ce type d'objet.
	*/
	public function consulter( $cmd, $parametres = array() )
	{
		switch($cmd) {
			case Nom::CONSULTER :
				$xpath = '//eflore/nomenclature/nom';
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
	* Ajoute un Nom.
	* 
	* @param Nom l'objet contenant les valeurs du Nom � ajouter.
	* @return mixed l'identifiant du Nom ajout� ou false en cas d'erreur.
	*/
	public function ajouter( ChorologieDonnee $cd )
	{
		
		
	}
	
	/**
	* Supprime un Nom.
	* 
	* @param integer l'identifiant du Nom � supprimer.
	* @return boolean true si le Nom est bien supprim�, sinon false.
	*/
	public function supprimer( $id )
	{
		
	}
	
	/**
	* Modifie un Nom.
	* 
	* @param Nom l'objet contenant les valeurs du Nom � modifier.
	* @return boolean true si le Nom est bien modifi�, sinon false.
	*/
	public function modifier( Nom $nom )
	{
		
	}
	
	/**
	* Ajoute les valeurs des champs aux bons attributs.
	* 
	* @return Nom un objet de type nom instanci� avec les valeurs d'une requete.
	* @access public
	*/
	public function instancierObjetModele( &$donnees )
	{
		$obj_nom = Nom::CLASSE_NOM;
		$un_objet = new $obj_nom;
		
		$un_objet->setId($donnees->getAttribute('rang'), 'rang');
		
		$nom_supra_generique = $donnees->getElementsByTagName('nom_supra_generique')->item(0)->nodeValue;
		if (!is_null($nom_supra_generique)) {			
			$un_objet->setNomSupraGenerique($nom_supra_generique);
		}
		
		$nom_genre = $donnees->getElementsByTagName('nom_genre')->item(0)->nodeValue;
		if (!is_null($nom_genre)) {			
			$un_objet->setNomGenre($nom_genre);
		}
		
		return $un_objet;
	}
}
?>