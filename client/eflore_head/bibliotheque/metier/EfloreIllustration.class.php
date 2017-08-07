<?php

class EfloreIllustration {
	private $chemin = EF_CHEMIN_IMG_STOCKAGE;
	private $chemin_specifique;
	private $liste_illustrations = array();
	
	private $projet_illustration_code;
	private $projet_taxon_code;
	private $projet_taxon_version;
	private $type;
	private $nt;
	
	private $rdf_dc_identifier;
	private $rdf_dc_title;
	private $rdf_dc_creator;
	private $rdf_dc_type;
	private $rdf_dcterms_created;
	
	public function __construct($pic, $ptc, $ptv = null, $type, $id)
	{
		$this->projet_illustration_code = $pic;
		$this->projet_taxon_code = $ptc;
		$this->projet_taxon_version = $ptv;
		$this->type = $type;
		$this->nt = $id;
		$this->ajouterDossierChemin($pic);
		$this->ajouterDossierChemin($ptc);
		$this->ajouterDossierChemin($ptv);
		$this->ajouterDossierChemin($type);
		$this->ajouterDossierChemin($id);
	}
	
	public function getChemin()
	{
		return $this->chemin;
	}
	public function getCheminSpecifique()
	{
		return $this->chemin_specifique;
	}
	
	public function getListeIllustrations()
	{
		return $this->liste_illustrations;
	}
	
	public function getProjetIllustrationCode()
	{
		return $this->projet_illustration_code;
	}
	
	private function getProjetTaxonCode()
	{
		return $this->projet_taxon_code;
	}
	
	public function getProjetTaxonVersion()
	{
		return $this->projet_taxon_version;
	}
	
	public function getType()
	{
		return $this->type;
	}
	
	public function getNt()
	{
		return $this->nt;
	}

	private function ajouterDossierChemin($d)
	{
		if (!is_null($d)) {
			$this->chemin .= strtolower($d).DIRECTORY_SEPARATOR;
			$this->chemin_specifique .= strtolower($d).DIRECTORY_SEPARATOR;
		}
	}
	
	public function chercherIllustrations()
	{
		if (is_dir($this->getChemin())) {
			foreach (scandir($this->getChemin()) as $fichier_img_normale) {
				if (preg_match('/^(\d+?)\.(jpg|jpeg)$/', $fichier_img_normale, $morceaux)) {
					$id = $morceaux[1];
					$dc_identifier = round($id);
					$ext = $morceaux[2];

					// Récupération des informations sur la photo
					$chemin_rdf = $this->getChemin().$id.'.rdf';
					$aso_img = array();
					if (file_exists($chemin_rdf)) {
						$aso_img = $this->analyserFichierRdf($chemin_rdf);
						
					} else {
						trigger_error("Le fichier RDF est inexistant à : $chemin_rdf", E_USER_WARNING);
					}
					// Création de la miniature et récupération d'info supplémentaires
					$chemin_img_normale = $this->getChemin().$fichier_img_normale;
					$fichier_img_miniature = $id.'_miniature.'.$ext;
					$fichier_img_moyenne = $id.'_moyenne.'.$ext;
					$chemin_img_miniature = $this->getChemin().$fichier_img_miniature;
					$aso_img[$dc_identifier]['url_normale'] = sprintf(EF_URL_IMG, $this->getCheminSpecifique().$fichier_img_normale);
					list($aso_img[$dc_identifier]['largeur'], $aso_img[$dc_identifier]['hauteur'], $type, $attr) = getimagesize($chemin_img_normale);
					if (!file_exists($chemin_img_miniature)) {
						$cmde = EF_PROG_CONVERT.' -size 150x150 '.$chemin_img_normale.' -resize 192x144 -quality 25 '.$chemin_img_miniature;
						$retour = null;
						system($cmde, $retour);
						if ($retour != 0) {
							trigger_error("Échec de la commande : $cmde", E_USER_WARNING);
						}
					}
					$aso_img[$dc_identifier]['url_miniature'] = sprintf(EF_URL_IMG, $this->getCheminSpecifique().$fichier_img_miniature);
					$aso_img[$dc_identifier]['url_moyenne'] = sprintf(EF_URL_IMG, $this->getCheminSpecifique().$fichier_img_moyenne);
					$aso_img[$dc_identifier]['nom'] = $id;
					$this->liste_illustrations[$dc_identifier] = $aso_img[$dc_identifier];
				}
			}
		} else {
			trigger_error('Le chemin suivant n\'est pas un dossier :'.$this->getChemin(), E_USER_WARNING);
		}
		return $this->liste_illustrations;
	}
	
	public function chercherIllustrationsServiceXml($url)
	{
		$this->liste_illustrations = $this->analyserFichierRdf($url);
		return $this->liste_illustrations;
	}
	
	public function analyserFichierRdf($chemin)
	{
		$aso_info = array();
		$dom = new DOMDocument();
		$dom->validateOnParse = true;
		if (preg_match('/^http:\/\//', $chemin)) {
			$dom->loadXML(file_get_contents($chemin));
		} else {
			$dom->load($chemin);
		}
		
		$tab_infos = array();
		foreach ($dom->getElementsByTagNameNS('http://www.w3.org/1999/02/22-rdf-syntax-ns#', 'Description') as $rdf_description) {
			$aso_info['about'] = $rdf_description->getAttribute('about');
			$aso_info['dc:identifier'] = $rdf_description->getAttribute('dc:identifier');
			$aso_info['dc:title'] = utf8_decode($rdf_description->getAttribute('dc:title'));
			$aso_info['dc:creator'] = utf8_decode($rdf_description->getAttribute('dc:creator'));
			$aso_info['dc:contributor'] = utf8_decode($rdf_description->getAttribute('dc:contributor'));
			$aso_info['dc:publisher'] = utf8_decode($rdf_description->getAttribute('dc:publisher'));
			$aso_info['dc:type'] = utf8_decode($rdf_description->getAttribute('dc:type'));
			$aso_info['dc:format'] = utf8_decode($rdf_description->getAttribute('dc:format'));
			if (function_exists('date_default_timezone_set')) {
				date_default_timezone_set('Europe/Paris');
			}
			if (preg_match('/^\d{4}-\d{2}-\d{2} \d{2}:\d{2}:\d{2}$/', $rdf_description->getAttribute('dcterms:created'))) {
				$aso_info['dcterms:created'] = date('j-m-Y à H:i:s', strtotime($rdf_description->getAttribute('dcterms:created')));				
			} else {
				$aso_info['dcterms:created'] = utf8_decode($rdf_description->getAttribute('dcterms:created'));
			}
			$aso_info['dcterms:dateSubmitted'] = utf8_decode($rdf_description->getAttribute('dcterms:dateSubmitted'));
			$aso_info['dcterms:spatial'] = utf8_decode($rdf_description->getAttribute('dcterms:spatial'));
			$aso_info['dcterms:licence'] = utf8_decode($rdf_description->getAttribute('dcterms:licence'));
			$tab_infos[$rdf_description->getAttribute('dc:identifier')] = $aso_info; 
		}
		//echo '<pre>'.$chemin.print_r($tab_infos, true).'</pre>';
		return $tab_infos;
	}
}
?>