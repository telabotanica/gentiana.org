<?php

class Vignette extends aService {
	
	public function consulterElement()
	{
		$projet_photo_code = $this->getArguments(0);
		$projet_taxon_code = $this->getArguments(1);
		if (!preg_match('/(?:nt|nn)/', $this->getArguments(2))) {
			$projet_taxon_version = $this->getArguments(2);
			$i = 3;
		} else {
			$projet_taxon_version = null;
			$i = 2;
		}
		$type = $this->getArguments($i++);
		$id = $this->getArguments($i++);
		$img_taille = $this->getArguments($i++);
		
		$Illustrations = new EfloreIllustration($projet_photo_code, $projet_taxon_code, $projet_taxon_version, $type, $id);
		$aso_illustrations = $Illustrations->chercherIllustrations();
		if (count($aso_illustrations) > 0) {
			$illustration_01 = array_shift($aso_illustrations);
			header('Content-type: '.$illustration_01['dc:format']);
			echo file_get_contents($illustration_01['url_'.$img_taille]);
			return true;
		} else {
			return false;
		}
	}
	
}
?>