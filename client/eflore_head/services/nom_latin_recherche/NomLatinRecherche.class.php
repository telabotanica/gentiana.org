<?php

class NomLatinRecherche extends aService {

	public function consulterElement()
	{
		if (isset($this->getArguments(0)) && isset($this->getArguments(1))) {
			$genre=$uid[0];
			$espece=$uid[1];
			if (strlen($espece) > 0 ) {
				$espece=ereg_replace('\*+','%',$espece);
				$DB=$this->connectDB($this->config);
			   	$query="SELECT DISTINCT en_nom_genre, en_epithete_espece, en_nom_supra_generique, en_epithete_infra_generique," .
			   			" en_epithete_espece, en_epithete_infra_specifique, enrg_abreviation_rang, en_id_nom FROM eflore_nom, eflore_nom_rang " .
			   			" WHERE en_id_version_projet_nom = '25' AND en_nom_genre LIKE '".$DB->escapeSimple($genre)."%' " .
			   			" AND en_ce_rang > 160 " .
			   			" AND en_epithete_espece like '".$DB->escapeSimple($espece)."%' AND en_ce_rang = enrg_id_rang " .
			   			" ORDER BY en_epithete_espece, en_nom_genre LIMIT 50";
			}
			else {
				print "[]";
				return;
			}
		} else {
			if (isset($this->getArguments(0))) {
				$genre = $this->getArguments(0);
				$genre = ereg_replace('\*+','%',$genre);
				if ((strlen($genre) > 1) && ($genre != '%')) {
					
					$DB=$this->connectDB($this->config);
					$query="SELECT DISTINCT en_nom_genre, en_id_nom FROM eflore_nom WHERE en_id_version_projet_nom = '25'" .
					"AND en_ce_rang = 160 " .
					"AND en_nom_genre LIKE '".$DB->escapeSimple($genre)."%' ORDER BY en_nom_genre LIMIT 50";
					
				} else {
					print "[]"; 
					return ;
				}
			} else {
				print "[]"; 
				return ;
			}
		}
		
				
		$res =& $DB->query($query);
			
			
		if (DB::isError($res)) {
			die($res->getMessage());
		}
		
		while ($row =& $res->fetchrow(DB_FETCHMODE_ASSOC)) {
			$value[]=array($this->formaterNom($row),$row['en_id_nom']);
		}
		
		
		$json = new Services_JSON();
		$output = $json->encode($value);
		print($output);
	}
}
?>