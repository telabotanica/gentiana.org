<?php

abstract class aDaoSqlEflore extends aDaoSql {
	/*** Attributes : ***/
		
	/*** Accesseurs : ***/
	
	/*** Constructeurs : ***/
	
	public function __construct($connexion, $table_nom, $table_prefixe, $table_champs)
    {
    	return parent::__construct($connexion, $table_nom, $table_prefixe, $table_champs);
	}
	
	/*** Méthodes : ***/
	public function getBddPrincipale()
	{
		return $this->getStockagePrincipal();
	}
	public function setBddPrincipale($bdd)
	{
		$this->setStockagePrincipal($bdd);
	}
	
	public function getBddHistorique()
	{
		return $this->getStockageHistorique();
	}
	public function setBddHistorique($bdd)
	{
		$this->setStockageHistorique($bdd);
	}
	
	public function getClesPrimaires($numero = null)
	{
		if (is_null($numero)) {
			return $this->table_cle;
		} else {
			return $this->table_cle[($numero-1)];
		}
	}
	
	/**
	* Retourne le type de clés primaires : simple, double, quadruple...
	*
	* @return int le nombre de clés primaires
	* @access public
	*/
	public function getClesPrimairesNbre()
	{
		$nbre_cles = 0;
		foreach ($this->getClesPrimaires() as $cle_primaire) {
			$nbre_cles += count($cle_primaire);
		}
		return $nbre_cles;
	}
}
?>