<?php
class NomFormatageAction extends aAction {
	
	private $Nom;
	private $type;
	
	public function __construct(NomDeprecie $Nom, $type)
	{
		$this->Nom = $Nom;
		$this->type = $type;
	}
	
	public function executer()
	{
		// Constitution du nom:
		$nom = array();
		$nom = $this->Nom->retournerTabloNomLatin();
		$nom['code'] = rand();//'nn'.$this->Nom->getId('nom').'prv'.$this->Nom->getId('version_projet_nom');
		$nom['nn'] = $this->Nom->getId('nom');
		$nom['type'] = $this->type;
		$nom['auteurs'] = $this->Nom->retournerAuteur();
		$nom['annee'] = $this->Nom->retournerAnnee();
		$nom['auteur_in'] = $this->Nom->retournerAuteurIn();
		$nom['biblio_annee'] = $this->Nom->retournerBiblioAnnee();
		$nom['commentaire_nomenclatural'] = $this->Nom->retournerCommentaireNomenclatural();
		
		return $nom;
	}
}
?>