<?php
abstract class aFabriqueDao {

	/*** Attributs : ***/
	// Liste des type de DAO supportés par la fabrique
	const SQL = 'sql';
	const XML = 'xml';
	const TXT = 'txt';

	public static function getDAOFabrique ( $type_fabrique, $connecteur = null)
	{
		switch ($type_fabrique) {
			case self::SQL : 
          		return new FabriqueDaoSql($connecteur);
			case self::XML : 
				return new FabriqueDaoXml($connecteur);
			case self::TXT : 
				return new FabriqueDaoTxt($connecteur);
			default : 
				return null;
		}
	}

	// There will be a method for each DAO that can be 
	// created. The concrete factories will have to 
	// implement these methods.
	abstract public function getChorologieDonneeDao();
	abstract public function getChorologieInformationDao();
	abstract public function getChorologieNotionDao();
	abstract public function getInfoTxtDao();
	abstract public function getLangueDao();
	abstract public function getLangueValeurDao();
	abstract public function getNaturalisteIntituleAbreviationDao();
	abstract public function getNomATxtDao();
	abstract public function getNomCitationDao();
	abstract public function getNomDao();
	abstract public function getNomIntituleCommentaireDao();
	abstract public function getNomIntituleDao();
	abstract public function getNomRelationDao();
	abstract public function getNomRangDao();
	abstract public function getProjetVersionDao();
	abstract public function getProtectionStatutDao();
	abstract public function getProtectionTexteDao();
	abstract public function getProtectionDao();
	abstract public function getSelectionNomDao();
	abstract public function getTaxonDao();
	abstract public function getTaxonATxtDao();
	abstract public function getTaxonAProtectionDao();
	abstract public function getTaxonRelationDao();
	abstract public function getVernaculaireDao();
	abstract public function getVernaculaireAttributionDao();
	abstract public function getVernaculaireConseilEmploiDao();
	abstract public function getZgDao();
	abstract public function getZgRelationDao();
	
}
?>