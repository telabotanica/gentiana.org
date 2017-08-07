<?php

class ModuleChorologieXmlDao extends aDaoXml {

	/*** Attributs: ***/
	
	/*** Accesseurs : ***/
	
	/*** Constructeurs : ***/
	
	/**
	* Constructeur du type de données issu d'un fichier XML.
	*
	* @return object
	* @access public
	*/
	public function __construct($fichier_xml)
	{
		if (!file_exists($fichier_xml)) {
			if (!$handle = fopen($fichier_xml, 'w')) {
				echo "Impossible d'ouvrir le fichier ($fichier_xml)\n";
				exit();
			}
			$xml = '<?xml version="1.0" encoding="utf-8"?>'."\n";
			$xml .= '<eflore>'."\n";
			$xml .= "\t".'<chorologie>'."\n";
			$xml .= "\t\t".'<entete>'."\n";
			$xml .= "\t\t".'</entete>'."\n";
			$xml .= "\t\t".'<corps>'."\n";
			$xml .= "\t\t".'</corps>'."\n";
			$xml .= "\t".'</chorologie>'."\n";
			$xml .= '</eflore>'."\n";
			if (fwrite($handle, $xml) === FALSE) {
				echo "Impossible d'écrire dans le fichier ($fichier_xml)";
				exit();
			}
			fclose($handle);
		}
		parent::__construct($fichier_xml);
	}
	
	/*** Destructeurs : ***/
	/**
	* Destructeurs du type de données issu d'un fichier XML.
	*
	* @return object
	* @access public
	*/
	public function __destruct()
	{
		if (!$handle = fopen($this->getFichierXml(), 'w')) {
			echo "Impossible d'ouvrir le fichier ($this->getFichierXml())\n";
			exit();
		}
		foreach (parent::getDomXml($this->getFichierXml()) as $dom) {
			if (fwrite($handle, $dom->saveXML()) === FALSE) {
				echo "Impossible d'écrire dans le fichier ($this->getFichierXml())";
				exit();
			}
		}
		
		fclose($handle);
		
	}
	
}
?>