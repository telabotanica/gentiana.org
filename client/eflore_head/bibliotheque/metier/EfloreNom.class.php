<?php
/*vim: set expandtab tabstop=4 shiftwidth=4: */
// +------------------------------------------------------------------------------------------------------+
// | PHP version 5.1                                                                                      |
// +------------------------------------------------------------------------------------------------------+
// | Copyright (C) 1999-2006 Tela Botanica (accueil@tela-botanica.org)                                    |
// +------------------------------------------------------------------------------------------------------+
// | This file is part of eflore_bp.                                                                      |
// |                                                                                                      |
// | eflore_bp is free software; you can redistribute it and/or modify                                    |
// | it under the terms of the GNU General Public License as published by                                 |
// | the Free Software Foundation; either version 2 of the License, or                                    |
// | (at your option) any later version.                                                                  |
// |                                                                                                      |
// | eflore_bp is distributed in the hope that it will be useful,                                         |
// | but WITHOUT ANY WARRANTY; without even the implied warranty of                                       |
// | MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the                                        |
// | GNU General Public License for more details.                                                         |
// |                                                                                                      |
// | You should have received a copy of the GNU General Public License                                    |
// | along with Foobar; if not, write to the Free Software                                                |
// | Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA                            |
// +------------------------------------------------------------------------------------------------------+
// CVS : $Id: EfloreNom.class.php,v 1.12 2007-08-23 08:01:17 jp_milcent Exp $
/**
* eflore_bp - EfloreNom.php
*
* Description :
*
*@package eflore_bp
//Auteur original :
*@author        Jean-Pascal MILCENT <jpm@tela-botanica.org>
//Autres auteurs :
*@author        Aucun
*@copyright     Tela-Botanica 1999-2007
*@version       $Revision: 1.12 $ $Date: 2007-08-23 08:01:17 $
// +------------------------------------------------------------------------------------------------------+
*/

// +------------------------------------------------------------------------------------------------------+
// |                                            ENTÊTE du PROGRAMME                                       |
// +------------------------------------------------------------------------------------------------------+


// +------------------------------------------------------------------------------------------------------+
// |                                            CORPS du PROGRAMME                                        |
// +------------------------------------------------------------------------------------------------------+
class EfloreNom extends aEfloreModule {
	
	/*** Constantes : ***/
	/** Constante définissant le type de format contenant seulement le nom latin de l'espèce'.*/
	const FORMAT_ULTRA_SIMPLE = 0;
	/** Constante définissant le type de format de nom par défaut.*/
	const FORMAT_SIMPLE = 1;
	/** Constante définissant le type de format de nom complet (avec la référence biblio).*/
	const FORMAT_COMPLET = 2;
	/** Constante définissant le type de format de nom complet (avec la référence biblio et les codes nn et nt).*/
	const FORMAT_COMPLET_CODE = 3;
	
	/** Constante définissant l'id du rang de famille.*/
	const RANG_FAMILLE = 120;
	/** Constante définissant l'id du rang de genre.*/
	const RANG_GENRE = 160;
	/** Constante définissant l'id du rang de cultivar.*/
	const RANG_CULTIVAR = 460;
	/** Constante définissant l'id du rang de cultivar.*/
	const RANG_CULTIVAR_HYBRIDE = 470;
	
	/** Constante définissant l'id de la categorie : autonyme.*/
	const CATEG_AUTONYME = 10;
	/** Constante définissant l'id de la valeur : autonyme.*/
	const AUTONYME = 3;
	
	public function consulterNom($projet_id, $nom_id)
	{
		$sql = 	'SELECT eflore_nom.*, '.
				'	auteur_bex.enaia_intitule_abrege AS en_auteur_basio_ex, '.
				'	auteur_b.enaia_intitule_abrege AS en_auteur_basio, '.
				'	auteur_mex.enaia_intitule_abrege AS en_auteur_modif_ex, '.
				'	auteur_m.enaia_intitule_abrege AS en_auteur_modif, '.
				'	enci_ce_auteur_in, '.
				'	auteur_in.enaia_intitule_abrege AS en_auteur_in, '.
				'	enci_intitule_citation_origine, '.
				'	enci_annee_citation, '.
				'	enic_intitule_cn_origine, '.
				'	enic_intitule_cn_complet, '.
				'	enrg_id_rang, '.
				'	enrg_abreviation_rang, '.
				'	enrg_intitule_rang '.
            	'FROM %s.eflore_nom, '.
				'	%s.eflore_nom_rang, '.
				'	%s.eflore_naturaliste_intitule_abreviation AS auteur_bex, '.
				'	%s.eflore_naturaliste_intitule_abreviation AS auteur_b, '.
				'	%s.eflore_naturaliste_intitule_abreviation AS auteur_mex, '.
				'	%s.eflore_naturaliste_intitule_abreviation AS auteur_m, '.
				'	%s.eflore_naturaliste_intitule_abreviation AS auteur_in, '.
				'	%s.eflore_nom_intitule_commentaire, '.
				'	%s.eflore_nom_citation '.
				"WHERE en_id_nom IN ($nom_id) ".
				"AND en_id_version_projet_nom = $projet_id ".
				'AND en_ce_auteur_basio_ex = auteur_bex.enaia_id_intitule_naturaliste_abrege '.
				'AND en_ce_auteur_basio = auteur_b.enaia_id_intitule_naturaliste_abrege '.
				'AND en_ce_auteur_modif_ex = auteur_mex.enaia_id_intitule_naturaliste_abrege '.
				'AND en_ce_auteur_modif = auteur_m.enaia_id_intitule_naturaliste_abrege '.
				'AND en_ce_intitule_cn = enic_id_intitule_cn '.
				'AND en_ce_citation_initiale = enci_id_citation '.
				'AND enci_ce_auteur_in = auteur_in.enaia_id_intitule_naturaliste_abrege '.
				'AND en_ce_rang = enrg_id_rang ';
		$this->setDebogage(true);
		$resultat = $this->executerSql($sql);
		return $resultat;
	}
	
	/** Méthode consulterRang() - Retourne les infos sur les rangs
	* 
	* Retourne les informations sur les rangs.
	* 
	* @param string un ou plusieurs id de rang sépararés par des virgules.
	* @return array
	* @access public
	*/
	public function consulterRang($rang_id = null)
	{
		$sql = 	'SELECT DISTINCT * '.
           		'FROM eflore_nom_rang '.
				((!is_null($rang_id)) ? 'WHERE enrg_id_rang = '.$rang_id.' ' : '');
		//$this->setDebogage(true);
		$resultat = $this->executerSql($sql);
		return $resultat;
	}
	
	public function consulterNbreNomParRang($version_id, $historique = false)
	{
		$bdd = ($historique) ?	EF_BDD_NOM_HISTORIQUE : EF_BDD_NOM_PRINCIPALE;
		$sql = 	'SELECT en_ce_rang, enrg_intitule_rang, COUNT(en_id_nom) AS en_nombre '.
       			"FROM $bdd.eflore_nom, $bdd.eflore_nom_rang ".
				'WHERE en_id_version_projet_nom = '.$version_id.' '.
				'AND en_ce_rang = enrg_id_rang '.
				'GROUP BY en_ce_rang';
		//$this->setDebogage(true);
		$resultat = $this->executerSql($sql);
		return $resultat;
	}
	
	public function consulterNbreNomParAnnee($version_id, $historique = false)
	{
		$bdd = ($historique) ?	EF_BDD_NOM_HISTORIQUE : EF_BDD_NOM_PRINCIPALE;
		$sql = 	'SELECT enci_annee_citation, COUNT(en_id_nom) AS en_nombre '.
	       		"FROM $bdd.eflore_nom, $bdd.eflore_nom_citation ".
				'WHERE en_id_version_projet_nom = '.$version_id.' '.
				'AND en_ce_citation_initiale = enci_id_citation '.
				'AND en_ce_citation_initiale != 0 '.
				'GROUP BY enci_annee_citation '.
				'ORDER BY enci_annee_citation ASC';
		//$this->setDebogage(true);
		$resultat = $this->executerSql($sql);
		return $resultat;
	}
	
	public function consulterCompletionNomGenre($projet_id, $genre, $historique = false)
	{
		$bdd = ($historique) ?	EF_BDD_NOM_HISTORIQUE : EF_BDD_NOM_PRINCIPALE;
		$sql = 	'SELECT DISTINCT en_id_nom, en_nom_genre '.
            	"FROM $bdd.eflore_nom ".
				"WHERE en_id_version_projet_nom = $projet_id ".
				"AND en_nom_genre LIKE '$genre' ".
				'AND en_ce_rang = '.EfloreNom::RANG_GENRE.' '.
				'AND en_epithete_espece = "" '.
				'ORDER BY en_nom_genre ' ;
		//$this->setDebogage(true);
		$resultat = $this->executerSql($sql);
		return $resultat;
	}
	
	public function consulterCompletionNomSp($projet_id, $genre, $sp, $historique = false)
	{
		$bdd = ($historique) ?	EF_BDD_NOM_HISTORIQUE : EF_BDD_NOM_PRINCIPALE;
		$sql = 	'SELECT DISTINCT en_id_nom, en_nom_supra_generique, en_nom_genre, en_epithete_espece, '.
				'	en_epithete_infra_generique, en_epithete_espece, en_epithete_infra_specifique, '.
				'	en_ce_rang, enrg_abreviation_rang '.
            	"FROM $bdd.eflore_nom, $bdd.eflore_nom_rang ".
				"WHERE en_id_version_projet_nom = $projet_id ".
				"AND en_nom_genre = '$genre' ".
				"AND en_epithete_espece LIKE '$sp' ".
				'AND en_ce_rang > 160 '.				
				'AND en_ce_rang = enrg_id_rang '.
				'ORDER BY en_epithete_espece, en_nom_genre ';
		//$this->setDebogage(true);
		$resultat = $this->executerSql($sql);
		return $resultat;
	}
	
	/** Méthode consulterNomApproche() - Recherche les noms les plus proche d'un radical
	* 
	* Retourne les informations sur les noms ressemblant le plus à la chaine recherchée.
	* 
	* @param string le radical à rechecher.
	* @return array
	* @access public
	*/
	public function consulterNomApproche($radical, $projet_id = null, $version_id = null, $union = false, $historique = false)
	{
		$radical = $this->echapperQuote($radical);
		$sql = 	'SELECT DISTINCT eflore_nom.*, '.
				'	auteur_bex.enaia_intitule_abrege AS en_auteur_basio_ex, '.
				'	auteur_b.enaia_intitule_abrege AS en_auteur_basio, '.
				'	auteur_mex.enaia_intitule_abrege AS en_auteur_modif_ex, '.
				'	auteur_m.enaia_intitule_abrege AS en_auteur_modif, '.
				'	enci_ce_auteur_in, '.
				'	auteur_in.enaia_intitule_abrege AS en_auteur_in, '.
				'	enci_intitule_citation_origine, '.
				'	enci_annee_citation, '.
				'	enic_intitule_cn_origine, '.
				'	enic_intitule_cn_complet, '.
				((!is_null($version_id)) ? 'esn_ce_statut, ' : '').
				'	enrg_id_rang, '.
				'	enrg_abreviation_rang, '.
				'	enrg_intitule_rang '.
				'FROM %s.eflore_nom, '.
				'%s.eflore_nom_rang, '.
				'%s.eflore_naturaliste_intitule_abreviation AS auteur_bex, '.
				'%s.eflore_naturaliste_intitule_abreviation AS auteur_b, '.
				'%s.eflore_naturaliste_intitule_abreviation AS auteur_mex, '.
				'%s.eflore_naturaliste_intitule_abreviation AS auteur_m, '.
				'%s.eflore_naturaliste_intitule_abreviation AS auteur_in, '.
				'%s.eflore_nom_intitule_commentaire, '.
				((!is_null($version_id)) ? '%s.eflore_selection_nom, ' : '').
				'%s.eflore_nom_citation '.
				'WHERE en_ce_auteur_basio_ex = auteur_bex.enaia_id_intitule_naturaliste_abrege '.
				'AND en_ce_auteur_basio = auteur_b.enaia_id_intitule_naturaliste_abrege '.
				'AND en_ce_auteur_modif_ex = auteur_mex.enaia_id_intitule_naturaliste_abrege '.
				'AND en_ce_auteur_modif = auteur_m.enaia_id_intitule_naturaliste_abrege '.
				'AND en_ce_intitule_cn = enic_id_intitule_cn '.
				'AND en_ce_citation_initiale = enci_id_citation '.
				'AND enci_ce_auteur_in = auteur_in.enaia_id_intitule_naturaliste_abrege '.
				'AND en_ce_rang = enrg_id_rang ' .
				((!is_null($version_id)) ? 'AND en_id_nom = esn_id_nom ' : '').
                ((!is_null($version_id)) ? 'AND en_id_version_projet_nom = esn_id_version_projet_nom ' : '').
                ((!is_null($version_id)) ? "AND esn_id_version_projet_taxon IN ($version_id) " : '').
                ((!is_null($projet_id)) ? 'AND en_id_version_projet_nom = eprv_id_version ' : '').
                ((!is_null($projet_id)) ? "AND eprv_ce_projet IN ($projet_id) " : '').
				'AND ('.
				"	SOUNDEX(en_nom_genre) = SOUNDEX('$radical') ".
				"	OR SOUNDEX(en_nom_supra_generique) = SOUNDEX('$radical') ".
				"	OR SOUNDEX(en_epithete_infra_generique) = SOUNDEX('$radical') ".
				"	OR SOUNDEX(en_epithete_espece) = SOUNDEX('$radical') ".
				"	OR SOUNDEX(en_epithete_infra_specifique) = SOUNDEX('$radical') ".
				"	OR SOUNDEX(REVERSE(en_nom_genre)) = SOUNDEX(REVERSE('$radical')) ".
				"	OR SOUNDEX(REVERSE(en_nom_supra_generique)) = SOUNDEX(REVERSE('$radical')) ".
				"	OR SOUNDEX(REVERSE(en_epithete_infra_generique)) = SOUNDEX(REVERSE('$radical')) ".
				"	OR SOUNDEX(REVERSE(en_epithete_espece)) = SOUNDEX(REVERSE('$radical')) ".
				"	OR SOUNDEX(REVERSE(en_epithete_infra_specifique)) = SOUNDEX(REVERSE('$radical')) ".
                ') ';
		if ($union) {
			$sql = str_replace('%s', EF_BDD_NOM_PRINCIPALE, $sql).' UNION '.str_replace('%s', EF_BDD_NOM_HISTORIQUE, $sql);
		} else {
			$bdd = ($historique) ?	EF_BDD_NOM_HISTORIQUE : EF_BDD_NOM_PRINCIPALE;
			$sql = str_replace('%s', $bdd, $sql);
		}
		
		$this->setDebogage(true);
		$resultat = $this->executerSql($sql);
		return $resultat;
	}
	
	/** Méthode consulterNomInitule() - Recherche un radical dans les intitulés des noms
	* 
	* Retourne les informations sur les noms correspondant à la chaine recherchée dans les intitulés des  
	* noms latins.
	* 
	* @param string le radical à rechecher.
	* @return array
	* @access public
	*/
	public function consulterNomIntitule($radical, $projet_id = null, $version_id = null, $union = false, $historique = false)
	{
		$radical = $this->echapperQuote($radical);
		$sql = 	'SELECT DISTINCT eflore_nom.*, '.
				'	auteur_bex.enaia_intitule_abrege AS en_auteur_basio_ex, '.
				'	auteur_b.enaia_intitule_abrege AS en_auteur_basio, '.
				'	auteur_mex.enaia_intitule_abrege AS en_auteur_modif_ex, '.
				'	auteur_m.enaia_intitule_abrege AS en_auteur_modif, '.
				'	enci_ce_auteur_in, '.
				'	auteur_in.enaia_intitule_abrege AS en_auteur_in, '.
				'	enci_intitule_citation_origine, '.
				'	enci_annee_citation, '.
				'	enic_intitule_cn_origine, '.
				'	enic_intitule_cn_complet, '.
				((!is_null($version_id)) ? 'esn_ce_statut, ' : '').				
				'	enrg_id_rang, '.
				'	enrg_abreviation_rang, '.
				'	enrg_intitule_rang '.
				'FROM %s.eflore_nom, '.
				'	%s.eflore_nom_rang, '.
				'	%s.eflore_naturaliste_intitule_abreviation AS auteur_bex, '.
				'	%s.eflore_naturaliste_intitule_abreviation AS auteur_b, '.
				'	%s.eflore_naturaliste_intitule_abreviation AS auteur_mex, '.
				'	%s.eflore_naturaliste_intitule_abreviation AS auteur_m, '.
				'	%s.eflore_naturaliste_intitule_abreviation AS auteur_in, '.
				'	%s.eflore_nom_intitule_commentaire, '.
				((!is_null($version_id)) ? '%s.eflore_selection_nom, ' : '').
				'	%s.eflore_nom_citation, '.
				'	%s.eflore_nom_intitule '. 
				'WHERE en_ce_auteur_basio_ex = auteur_bex.enaia_id_intitule_naturaliste_abrege '.
				'AND en_ce_auteur_basio = auteur_b.enaia_id_intitule_naturaliste_abrege '.
				'AND en_ce_auteur_modif_ex = auteur_mex.enaia_id_intitule_naturaliste_abrege '.
				'AND en_ce_auteur_modif = auteur_m.enaia_id_intitule_naturaliste_abrege '.
				'AND en_ce_intitule_cn = enic_id_intitule_cn '.
				'AND en_ce_citation_initiale = enci_id_citation '.
				'AND enci_ce_auteur_in = auteur_in.enaia_id_intitule_naturaliste_abrege '.
				'AND en_ce_rang = enrg_id_rang ' .
				((!is_null($version_id)) ? 'AND en_id_nom = esn_id_nom ' : '').
                ((!is_null($version_id)) ? 'AND en_id_version_projet_nom = esn_id_version_projet_nom ' : '').
                ((!is_null($version_id)) ? "AND esn_id_version_projet_taxon IN ($version_id) " : '').
                ((!is_null($projet_id)) ? 'AND en_id_version_projet_nom = eprv_id_version ' : '').
                ((!is_null($projet_id)) ? "AND eprv_ce_projet IN ($projet_id) " : '').
				'AND eni_id_categorie_format = 3 '.
				'AND eni_id_valeur_format = 3 '.
				'AND en_id_nom = eni_id_nom '.	
				"AND eni_intitule_nom LIKE '$radical' ";
		if ($union) {
			$sql = str_replace('%s', EF_BDD_NOM_PRINCIPALE, $sql).' UNION '.str_replace('%s', EF_BDD_NOM_HISTORIQUE, $sql);
		} else {
			$bdd = ($historique) ?	EF_BDD_NOM_HISTORIQUE : EF_BDD_NOM_PRINCIPALE;
			$sql = str_replace('%s', $bdd, $sql);
		}
		
		$this->setDebogage(true);
		$this->getWrapperSql()->setMode(EfloreAdaptateurSql::RESULTAT_TABLEAU_MULTIPLE);
		$resultat = $this->executerSql($sql);
		return $resultat;
	}
	
	/** Méthode consulterNomRadical() - Retourne les infos sur les noms correspondants
	* 
	* Retourne les informations sur les noms correspondant à la chaine recherchée dans les différents champs contenant 
	* un morceau du nom latin.
	* 
	* @param string le radical à rechecher.
	* @return array
	* @access public
	*/
	public function consulterNomRadical($radical, $projet_id = null, $version_id = null, $union = false, $historique = false)
	{
		$radical = $this->echapperQuote($radical);
		$sql = 	'SELECT DISTINCT eflore_nom.*, '.
				'	auteur_bex.enaia_intitule_abrege AS en_auteur_basio_ex, '.
				'	auteur_b.enaia_intitule_abrege AS en_auteur_basio, '.
				'	auteur_mex.enaia_intitule_abrege AS en_auteur_modif_ex, '.
				'	auteur_m.enaia_intitule_abrege AS en_auteur_modif, '.
				'	enci_ce_auteur_in, '.
				'	auteur_in.enaia_intitule_abrege AS en_auteur_in, '.
				'	enci_intitule_citation_origine, '.
				'	enci_annee_citation, '.
				'	enic_intitule_cn_origine, '.
				'	enic_intitule_cn_complet, '.
				((!is_null($version_id)) ? 'esn_ce_statut, ' : '').
				'	enrg_id_rang, '.
				'	enrg_abreviation_rang, '.
				'	enrg_intitule_rang '.
				'FROM %s.eflore_nom, '.
				'%s.eflore_nom_rang, '.
				'%s.eflore_naturaliste_intitule_abreviation AS auteur_bex, '.
				'%s.eflore_naturaliste_intitule_abreviation AS auteur_b, '.
				'%s.eflore_naturaliste_intitule_abreviation AS auteur_mex, '.
				'%s.eflore_naturaliste_intitule_abreviation AS auteur_m, '.
				'%s.eflore_naturaliste_intitule_abreviation AS auteur_in, '.
				'%s.eflore_nom_intitule_commentaire, '.
				((!is_null($version_id)) ? '%s.eflore_selection_nom, ' : '').
				'%s.eflore_nom_citation '.
				'WHERE en_ce_auteur_basio_ex = auteur_bex.enaia_id_intitule_naturaliste_abrege '.
				'AND en_ce_auteur_basio = auteur_b.enaia_id_intitule_naturaliste_abrege '.
				'AND en_ce_auteur_modif_ex = auteur_mex.enaia_id_intitule_naturaliste_abrege '.
				'AND en_ce_auteur_modif = auteur_m.enaia_id_intitule_naturaliste_abrege '.
				'AND en_ce_intitule_cn = enic_id_intitule_cn '.
				'AND en_ce_citation_initiale = enci_id_citation '.
				'AND enci_ce_auteur_in = auteur_in.enaia_id_intitule_naturaliste_abrege '.
				'AND en_ce_rang = enrg_id_rang ' .
				((!is_null($version_id)) ? 'AND en_id_nom = esn_id_nom ' : '').
                ((!is_null($version_id)) ? 'AND en_id_version_projet_nom = esn_id_version_projet_nom ' : '').
                ((!is_null($version_id)) ? "AND esn_id_version_projet_taxon IN ($version_id) " : '').
                ((!is_null($projet_id)) ? 'AND en_id_version_projet_nom = eprv_id_version ' : '').
                ((!is_null($projet_id)) ? "AND eprv_ce_projet IN ($projet_id) " : '').
				'AND ('.
				"	en_nom_genre LIKE '$radical' ".
				"	OR en_nom_supra_generique LIKE '$radical' ".
				"	OR en_epithete_infra_generique LIKE '$radical' ".
				"	OR en_epithete_espece LIKE '$radical' ".
				"	OR en_epithete_infra_specifique LIKE '$radical' ".
	    		') ';
		if ($union) {
			$sql = str_replace('%s', EF_BDD_NOM_PRINCIPALE, $sql).' UNION '.str_replace('%s', EF_BDD_NOM_HISTORIQUE, $sql);
		} else {
			$bdd = ($historique) ?	EF_BDD_NOM_HISTORIQUE : EF_BDD_NOM_PRINCIPALE;
			$sql = str_replace('%s', $bdd, $sql);
		}
		
		$this->setDebogage(true);
		$this->getWrapperSql()->setMode(EfloreAdaptateurSql::RESULTAT_TABLEAU_MULTIPLE);
		$resultat = $this->executerSql($sql);
		return $resultat;
	}
	
	public function consulterNomGenre($genre, $projet_id = null, $version_id = null, $union = false, $historique = false)
	{
		$genre = $this->echapperQuote($genre);
		$sql = 	'SELECT DISTINCT eflore_nom.*, '.
				'	auteur_bex.enaia_intitule_abrege AS en_auteur_basio_ex, '.
				'	auteur_b.enaia_intitule_abrege AS en_auteur_basio, '.
				'	auteur_mex.enaia_intitule_abrege AS en_auteur_modif_ex, '.
				'	auteur_m.enaia_intitule_abrege AS en_auteur_modif, '.
				'	enci_ce_auteur_in, '.
				'	auteur_in.enaia_intitule_abrege AS en_auteur_in, '.
				'	enci_intitule_citation_origine, '.
				'	enci_annee_citation, '.
				'	enic_intitule_cn_origine, '.
				'	enic_intitule_cn_complet, '.
				((!is_null($version_id)) ? 'esn_ce_statut, ' : '').
				'	enrg_id_rang, '.
				'	enrg_abreviation_rang, '.
				'	enrg_intitule_rang '.
				'FROM %s.eflore_nom, '.
				'	%s.eflore_nom_rang, '.
				'	%s.eflore_naturaliste_intitule_abreviation AS auteur_bex, '.
				'	%s.eflore_naturaliste_intitule_abreviation AS auteur_b, '.
				'	%s.eflore_naturaliste_intitule_abreviation AS auteur_mex, '.
				'	%s.eflore_naturaliste_intitule_abreviation AS auteur_m, '.
				'	%s.eflore_naturaliste_intitule_abreviation AS auteur_in, '.
				'	%s.eflore_nom_intitule_commentaire, '.
				((!is_null($version_id)) ? '%s.eflore_selection_nom, ' : '').
				'	%s.eflore_nom_citation '.
				'WHERE en_ce_auteur_basio_ex = auteur_bex.enaia_id_intitule_naturaliste_abrege '.
				'AND en_ce_auteur_basio = auteur_b.enaia_id_intitule_naturaliste_abrege '.
				'AND en_ce_auteur_modif_ex = auteur_mex.enaia_id_intitule_naturaliste_abrege '.
				'AND en_ce_auteur_modif = auteur_m.enaia_id_intitule_naturaliste_abrege '.
				'AND en_ce_intitule_cn = enic_id_intitule_cn '.
				'AND en_ce_citation_initiale = enci_id_citation '.
				'AND enci_ce_auteur_in = auteur_in.enaia_id_intitule_naturaliste_abrege '.
				'AND en_ce_rang = enrg_id_rang '.
				((!is_null($version_id)) ? 'AND en_id_nom = esn_id_nom ' : '').
                ((!is_null($version_id)) ? 'AND en_id_version_projet_nom = esn_id_version_projet_nom ' : '').
                ((!is_null($version_id)) ? "AND esn_id_version_projet_taxon IN ($version_id) " : '').
                ((!is_null($projet_id)) ? 'AND en_id_version_projet_nom = eprv_id_version ' : '').
                ((!is_null($projet_id)) ? "AND eprv_ce_projet IN ($projet_id) " : '').
				"AND en_nom_genre LIKE '$genre' ".
				'AND en_ce_rang = '.EfloreNom::RANG_GENRE.' '.
				'AND en_epithete_espece = "" '.
				'ORDER BY en_nom_genre ';
		if ($union) {
			$sql = str_replace('%s', EF_BDD_NOM_PRINCIPALE, $sql).' UNION '.str_replace('%s', EF_BDD_NOM_HISTORIQUE, $sql);
		} else {
			$bdd = ($historique) ?	EF_BDD_NOM_HISTORIQUE : EF_BDD_NOM_PRINCIPALE;
			$sql = str_replace('%s', $bdd, $sql);
		}
		$this->setDebogage(true);
		$this->getWrapperSql()->setMode(EfloreAdaptateurSql::RESULTAT_TABLEAU_MULTIPLE);
		$resultat = $this->executerSql($sql);
		return $resultat;
	}
	
	public function consulterNomSp($genre, $sp, $projet_id = null, $version_id = null, $union = false, $historique = false)
	{
		$genre = $this->echapperQuote($genre);
		$sp = $this->echapperQuote($sp);
		$sql = 	'SELECT DISTINCT eflore_nom.*, '.
				'	auteur_bex.enaia_intitule_abrege AS en_auteur_basio_ex, '.
				'	auteur_b.enaia_intitule_abrege AS en_auteur_basio, '.
				'	auteur_mex.enaia_intitule_abrege AS en_auteur_modif_ex, '.
				'	auteur_m.enaia_intitule_abrege AS en_auteur_modif, '.
				'	enci_ce_auteur_in, '.
				'	auteur_in.enaia_intitule_abrege AS en_auteur_in, '.
				'	enci_intitule_citation_origine, '.
				'	enci_annee_citation, '.
				'	enic_intitule_cn_origine, '.
				'	enic_intitule_cn_complet, '.
				((!is_null($version_id)) ? 'esn_ce_statut, ' : '').
				'	enrg_id_rang, '.
				'	enrg_abreviation_rang, '.
				'	enrg_intitule_rang '.
				'FROM %s.eflore_nom, '.
				'	%s.eflore_nom_rang, '.
				'	%s.eflore_naturaliste_intitule_abreviation AS auteur_bex, '.
				'	%s.eflore_naturaliste_intitule_abreviation AS auteur_b, '.
				'	%s.eflore_naturaliste_intitule_abreviation AS auteur_mex, '.
				'	%s.eflore_naturaliste_intitule_abreviation AS auteur_m, '.
				'	%s.eflore_naturaliste_intitule_abreviation AS auteur_in, '.
				'	%s.eflore_nom_intitule_commentaire, '.
				((!is_null($version_id)) ? '%s.eflore_selection_nom, ' : '').
				'	%s.eflore_nom_citation '.
				'WHERE en_ce_auteur_basio_ex = auteur_bex.enaia_id_intitule_naturaliste_abrege '.
				'AND en_ce_auteur_basio = auteur_b.enaia_id_intitule_naturaliste_abrege '.
				'AND en_ce_auteur_modif_ex = auteur_mex.enaia_id_intitule_naturaliste_abrege '.
				'AND en_ce_auteur_modif = auteur_m.enaia_id_intitule_naturaliste_abrege '.
				'AND en_ce_intitule_cn = enic_id_intitule_cn '.
				'AND en_ce_citation_initiale = enci_id_citation '.
				'AND enci_ce_auteur_in = auteur_in.enaia_id_intitule_naturaliste_abrege '.
				'AND en_ce_rang = enrg_id_rang ' .
				'AND en_ce_rang = enrg_id_rang '.				
				'AND en_ce_rang > 160 '.
				((!is_null($version_id)) ? 'AND en_id_nom = esn_id_nom ' : '').
                ((!is_null($version_id)) ? 'AND en_id_version_projet_nom = esn_id_version_projet_nom ' : '').
                ((!is_null($version_id)) ? "AND esn_id_version_projet_taxon IN ($version_id) " : '').
				((!is_null($projet_id)) ? 'AND en_id_version_projet_nom = eprv_id_version ' : '').
                ((!is_null($projet_id)) ? "AND eprv_ce_projet IN ($projet_id) " : '').
				"AND en_nom_genre LIKE '$genre' ".
				"AND en_epithete_espece LIKE '$sp' ".
				'ORDER BY en_epithete_espece, en_nom_genre ';
		if ($union) {
			$sql = str_replace('%s', EF_BDD_NOM_PRINCIPALE, $sql).' UNION '.str_replace('%s', EF_BDD_NOM_HISTORIQUE, $sql);
		} else {
			$bdd = ($historique) ?	EF_BDD_NOM_HISTORIQUE : EF_BDD_NOM_PRINCIPALE;
			$sql = str_replace('%s', $bdd, $sql);
		}
		$this->setDebogage(true);
		$this->getWrapperSql()->setMode(EfloreAdaptateurSql::RESULTAT_TABLEAU_MULTIPLE);
		$resultat = $this->executerSql($sql);
		return $resultat;
	}
	
	public function consulterNomInfraSp($genre, $sp, $infra_sp, $projet_id = null, $version_id = null, $union = false, $historique = false)
	{
		$genre = $this->echapperQuote($genre);
		$sp = $this->echapperQuote($sp);
		$sql = 	'SELECT DISTINCT eflore_nom.*, '.
				'	auteur_bex.enaia_intitule_abrege AS en_auteur_basio_ex, '.
				'	auteur_b.enaia_intitule_abrege AS en_auteur_basio, '.
				'	auteur_mex.enaia_intitule_abrege AS en_auteur_modif_ex, '.
				'	auteur_m.enaia_intitule_abrege AS en_auteur_modif, '.
				'	enci_ce_auteur_in, '.
				'	auteur_in.enaia_intitule_abrege AS en_auteur_in, '.
				'	enci_intitule_citation_origine, '.
				'	enci_annee_citation, '.
				'	enic_intitule_cn_origine, '.
				'	enic_intitule_cn_complet, '.
				((!is_null($version_id)) ? 'esn_ce_statut, ' : '').
				'	enrg_id_rang, '.
				'	enrg_abreviation_rang, '.
				'	enrg_intitule_rang '.
				'FROM %s.eflore_nom, '.
				'	%s.eflore_nom_rang, '.
				'	%s.eflore_naturaliste_intitule_abreviation AS auteur_bex, '.
				'	%s.eflore_naturaliste_intitule_abreviation AS auteur_b, '.
				'	%s.eflore_naturaliste_intitule_abreviation AS auteur_mex, '.
				'	%s.eflore_naturaliste_intitule_abreviation AS auteur_m, '.
				'	%s.eflore_naturaliste_intitule_abreviation AS auteur_in, '.
				'	%s.eflore_nom_intitule_commentaire, '.
				((!is_null($version_id)) ? '%s.eflore_selection_nom, ' : '').
				'	%s.eflore_nom_citation '.
				'WHERE en_ce_auteur_basio_ex = auteur_bex.enaia_id_intitule_naturaliste_abrege '.
				'AND en_ce_auteur_basio = auteur_b.enaia_id_intitule_naturaliste_abrege '.
				'AND en_ce_auteur_modif_ex = auteur_mex.enaia_id_intitule_naturaliste_abrege '.
				'AND en_ce_auteur_modif = auteur_m.enaia_id_intitule_naturaliste_abrege '.
				'AND en_ce_intitule_cn = enic_id_intitule_cn '.
				'AND en_ce_citation_initiale = enci_id_citation '.
				'AND enci_ce_auteur_in = auteur_in.enaia_id_intitule_naturaliste_abrege '.
				'AND en_ce_rang = enrg_id_rang '.
				'AND en_ce_rang >= 280 '.
                ((!is_null($version_id)) ? 'AND en_id_nom = esn_id_nom ' : '').
                ((!is_null($version_id)) ? 'AND en_id_version_projet_nom = esn_id_version_projet_nom ' : '').
                ((!is_null($version_id)) ? "AND esn_id_version_projet_taxon IN ($version_id) " : '').
                ((!is_null($projet_id)) ? 'AND en_id_version_projet_nom = eprv_id_version ' : '').
                ((!is_null($projet_id)) ? "AND eprv_ce_projet IN ($projet_id) " : '').
				"AND en_nom_genre LIKE '$genre' ".
				"AND en_epithete_espece LIKE '$sp' ".
				"AND en_epithete_infra_specifique LIKE '$infra_sp' ".
				'ORDER BY en_epithete_infra_specifique, en_epithete_espece, en_nom_genre ';
		if ($union) {
			$sql = str_replace('%s', EF_BDD_NOM_PRINCIPALE, $sql).' UNION '.str_replace('%s', EF_BDD_NOM_HISTORIQUE, $sql);
		} else {
			$bdd = ($historique) ?	EF_BDD_NOM_HISTORIQUE : EF_BDD_NOM_PRINCIPALE;
			$sql = str_replace('%s', $bdd, $sql);
		}
		$this->setDebogage(true);
		$this->getWrapperSql()->setMode(EfloreAdaptateurSql::RESULTAT_TABLEAU_MULTIPLE);
		$resultat = $this->executerSql($sql);
		return $resultat;
	}
				
	/** Méthode formaterNom() - Retourne un nom formater suivant le type demandé
	* 
	* Retourne une chaine correspondant au nom formaté.
	* 
	* @param array un tableau associatif généré par EfloreNom contenant les infos sur le nom.
	* @param int le type de format.
	* @return array
	* @access public
	*/
	public function formaterNom($aso_nom, $type = EfloreNom::FORMAT_SIMPLE)
	{
		// Constitution du nom:
		$nom = '';
		
		if (isset($aso_nom['en']['nom_supra_generique']) && $aso_nom['en']['nom_supra_generique'] != '') {
		    $nom .= $aso_nom['en']['nom_supra_generique'];
		} else if (isset($aso_nom['en']['epithete_infra_generique']) && $aso_nom['en']['epithete_infra_generique'] != '') {
		    $nom .= $aso_nom['en']['epithete_infra_generique'];
		} else {
			if (isset($aso_nom['en']['nom_genre']) && $aso_nom['en']['nom_genre'] != '') {
			    $nom .= $aso_nom['en']['nom_genre'];
			}
			if (isset($aso_nom['en']['epithete_espece']) && $aso_nom['en']['epithete_espece'] != '') {
			    $nom .= ' '.$aso_nom['en']['epithete_espece'];
			}
			if (isset($aso_nom['en']['epithete_infra_specifique']) && $aso_nom['en']['epithete_infra_specifique'] != '') {
				if (!empty($aso_nom['enrg']['abreviation_rang'])) {
					$nom .= ' '.$aso_nom['enrg']['abreviation_rang'].'';
				}
				if (isset($aso_nom['en']['ce']['rang']) && ($aso_nom['en']['ce']['rang'] == self::RANG_CULTIVAR || $aso_nom['en']['ce']['rang'] == self::RANG_CULTIVAR_HYBRIDE)) {
					$nom .= ' \''.$aso_nom['en']['epithete_infra_specifique'].'\'';
				} else {
					$nom .= ' '.$aso_nom['en']['epithete_infra_specifique'];
				}
			}
		}
		
		// Gestion des noms d'ateurs
		$auteurs = $this->retournerAuteur($aso_nom);
		
		// Complément en fonction du type de nom
		switch ($type) {
			case EfloreNom::FORMAT_ULTRA_SIMPLE :
				break;
			case EfloreNom::FORMAT_SIMPLE :
				// Ajout de l'auteur au nom
				$nom .= $auteurs;
				// Gestion de la citation biblio
				if ($annee = $this->retournerAnnee($aso_nom)) {
					$nom .= ', '.$annee;
				}
				break;
			case EfloreNom::FORMAT_COMPLET :
				// Ajout de l'auteur au nom
				$nom .= $auteurs;
				
				// Gestion de l'auteur "in"
				if ($auteur_in = $this->retournerAuteurIn($aso_nom)) {
					$nom .= ' in '.$auteur_in;
				}

				// Gestion de la citation biblio
				if ($biblio = $this->retournerBiblioAnnee($aso_nom)) {
					$nom .= ' ['.$biblio.']';
				}
				
				// Gestion du commentaire "nomenclatural"
				// A FAIRE : régler le problème des enic_intitule_cn_complet différent du enic_intitule_cn_origine 
				if ($commentaire = $this->retournerCommentaireNomenclatural($aso_nom)) {
					$nom .= ' '.$commentaire;
				}
				break;
			default:
				trigger_error('Type de format de nom indisponible : '.$type, E_USER_WARNING);
		}
		return $nom;
	}
	
	public function retournerNomId($aso_nom)
	{
		if (isset($aso_nom['en']['id']['nom'])) {
			return $aso_nom['en']['id']['nom'];
		} else {
			return false;
		}
	}
	
	public function retournerAuteur($aso_nom)
	{
		$auteurs = '';
		$auteur_basio = '';
		$auteur_modif = '';
		if (!empty($aso_nom['en']['auteur_basio_ex']) && $aso_nom['en']['ce']['auteur_basio_ex'] != 0) {
		    $auteur_basio .= $aso_nom['en']['auteur_basio_ex'];
		    if (!empty($aso_nom['en']['auteur_basio'])) {
		        $auteur_basio .= ' ex '.$aso_nom['en']['auteur_basio'];
		    }
		} else if (!empty($aso_nom['en']['auteur_basio']) && $aso_nom['en']['ce']['auteur_basio'] != 0) {
		    $auteur_basio .= $aso_nom['en']['auteur_basio'];
		}
		
		if (!empty($aso_nom['en']['auteur_modif_ex']) && $aso_nom['en']['ce']['auteur_modif_ex'] != 0) {
		    $auteur_modif .= $aso_nom['en']['auteur_modif_ex'];
		    if (!empty($aso_nom['en']['auteur_modif'])) {
		        $auteur_modif .= ' ex '.$aso_nom['en']['auteur_modif'];
		    }
		} else if (!empty($aso_nom['en']['auteur_modif']) && $aso_nom['en']['ce']['auteur_modif'] != 0) {
		    $auteur_modif .= $aso_nom['en']['auteur_modif'];
		}
		
		if (!empty($auteur_modif)) {
		    $auteurs = ' ('.$auteur_basio.') '.$auteur_modif;
		} elseif (!empty($auteur_basio)) {
		    $auteurs = ' '.$auteur_basio;
		}
		
		return $auteurs ;
	}	
	
	public function retournerAuteurPrincipal($aso_nom)
	{
		if (!empty($aso_nom['en']['auteur_modif']) && $aso_nom['en']['ce']['auteur_modif'] != 0) {
		    return $aso_nom['en']['auteur_modif'];
		} else {
			if (!empty($aso_nom['en']['auteur_basio']) && $aso_nom['en']['ce']['auteur_basio'] != 0) {
				return $aso_nom['en']['auteur_basio'];
			} else {
				return false;
			}
		}
	}
	
	public function retournerAuteurIn($aso_nom)
	{
		if (!empty($aso_nom['enci']['ce']['auteur_in'])) {
			switch ($aso_nom['en']['auteur_in']) {
				case 0 :
				case 1 :
				case 2 :
					return false;
				default :
					return $aso_nom['en']['auteur_in'];
			}
		} else {
			return false;
		}
	}
	
	public function retournerAnnee($aso_nom)
	{
		if (!empty($aso_nom['enci']['annee_citation'])) {
			return $aso_nom['enci']['annee_citation'];
		} else {
			return false;
		}
	}
	
	public function retournerBiblio($aso_nom)
	{
		if (!empty($aso_nom['enci']['intitule_citation_origine'])) {
			return $aso_nom['enci']['intitule_citation_origine'];
		} else {
			return false;
		}
	}
	
	public function retournerBiblioAnnee($aso_nom)
	{
		if (!empty($aso_nom['enci']['annee_citation']) || !empty($aso_nom['enci']['intitule_citation_origine'])) {
			$biblio = '';	
			if (!empty($aso_nom['enci']['annee_citation']) && !empty($aso_nom['enci']['intitule_citation_origine'])) {
				$biblio .= $aso_nom['enci']['annee_citation'].', '.$aso_nom['enci']['intitule_citation_origine'];
			} else {
				if (!empty($aso_nom['enci']['annee_citation'])) {
					$biblio .= $aso_nom['enci']['annee_citation'];
				}
				if (!empty($aso_nom['enci']['intitule_citation_origine'])) {
					$biblio .= $aso_nom['enci']['intitule_citation_origine'];
				}
			}
			return $biblio;
		} else {
			return false;
		}
	}	
	
	public function retournerCommentaireNomenclatural($aso_nom)
	{
		if (!empty($aso_nom['enic']['intitule_cn_origine'])) {
			return $aso_nom['enic']['intitule_cn_origine'];
		}
	}
	
	public function retournerTabloNomStructure($aso_nom)
	{
		$nom_structure = array();
		if (isset($aso_nom['en']['nom_supra_generique']) && $aso_nom['en']['nom_supra_generique'] != '') {
			$nom_structure[] = array('class' => 'nl_supra_generique', 'contenu' => $aso_nom['en']['nom_supra_generique']);
		} elseif (isset($aso_nom['en']['epithete_infra_generique']) && $aso_nom['en']['epithete_infra_generique'] != '') {
			$nom_structure[] = array('class' => 'nl_infra_generique', 'contenu' => $aso_nom['en']['epithete_infra_generique']);
		} else {
			if (isset($aso_nom['en']['nom_genre']) && $aso_nom['en']['nom_genre'] != '') {
				$nom_structure[] = array('class' => 'nl_g', 'contenu' => $aso_nom['en']['nom_genre']);
			}
			if (isset($aso_nom['en']['epithete_espece']) && $aso_nom['en']['epithete_espece'] != '') {
				$nom_structure[] = array('class' => 'nl_sp', 'contenu' => ' '.$aso_nom['en']['epithete_espece']);
			}
			if (isset($aso_nom['en']['epithete_infra_specifique']) && $aso_nom['en']['epithete_infra_specifique'] != '') {
				if (!empty($aso_nom['enrg']['abreviation_rang']) ) {
					$nom_structure[] = array('class' => 'nl_abbr_rg', 'contenu' => ' '.$aso_nom['enrg']['abreviation_rang']);
				}
				$nom_structure[] = array('class' => 'nl_infra_sp', 'contenu' => ' '.$aso_nom['en']['epithete_infra_specifique']);
			}
		}
		if ($this->retournerAuteur($aso_nom) != '') {
			$nom_structure[] = array('class' => 'nl_auteur', 'contenu' => ' '.$this->retournerAuteur($aso_nom));
		}
		
		// Dans le cas, où les infos sur les noms sont vides
		if (empty($nom_structure)) {
			$nom_structure[] = array('class' => 'nl_inconnu', 'contenu' => ' ? ');
		}

		return $nom_structure;
	}
	
	public function retournerTabloNomComplement($aso_nom, $type = EfloreNom::FORMAT_SIMPLE)
	{
		$nom_complement = array();
		switch ($type) {
			case EfloreNom::FORMAT_SIMPLE :
				if ($this->retournerAuteur($aso_nom) != '') {
					if ($this->retournerAnnee($aso_nom) != '') {
						$nom_complement[] = array('class' => 'nl_annee', 'contenu' => ', '.$this->retournerAnnee($aso_nom));
					}
				} else {
					if ($this->retournerAnnee($aso_nom) != '') {
						$nom_complement[] = array('class' => 'nl_annee', 'contenu' => ' '.$this->retournerAnnee($aso_nom));
					}
				}
				break;
			case EfloreNom::FORMAT_COMPLET :
			case EfloreNom::FORMAT_COMPLET_CODE :
				if ($this->retournerAuteurIn($aso_nom) != '') {
					$nom_complement[] = array('class' => 'nl_auteur_in', 'contenu' => ' in '.$this->retournerAuteurIn($aso_nom));
				}
				if ($this->retournerBiblioAnnee($aso_nom) != '') {
					$nom_complement[] = array('class' => 'nl_biblio_annee', 'contenu' => ' ['.$this->retournerBiblioAnnee($aso_nom).']');
				}
				if ($this->retournerCommentaireNomenclatural($aso_nom) != '') {
					$nom_complement[] = array(	'class' => 'nl_commentaire_nomenclatural', 
												'contenu' => ' '.$this->retournerCommentaireNomenclatural($aso_nom));
				}
				/*if ($nom['nn'] != '') {
					$nom_complement[] = array('class' => 'ef_nn', 'contenu' => ' [nn'.$Nom->retournerNomId($aso_nom).'] ');
				}*/
				break;			
		}
		return $nom_complement;
	}
	
}

/* +--Fin du code ----------------------------------------------------------------------------------------+
*
* $Log: EfloreNom.class.php,v $
* Revision 1.12  2007-08-23 08:01:17  jp_milcent
* Standardisation des noms des méthodes.
*
* Revision 1.11  2007-08-20 15:00:12  jp_milcent
* Ajout de méthode de découpage du nom en tableaux pour le formatage.
*
* Revision 1.10  2007-08-05 22:37:38  jp_milcent
* Ajout de constante pour les infos sur les autonymes.
*
* Revision 1.9  2007-08-05 12:28:47  jp_milcent
* Ajout d'un test au formatage des noms.
* Ajout des requetes pour la recherche de noms latins via les services web.
*
* Revision 1.8  2007-08-05 10:52:54  jp_milcent
* Ajout des requêtes pour la complétion des noms latins.
*
* Revision 1.7  2007-08-04 21:51:21  jp_milcent
* Ajout de requêtes pour les stats des projets.
*
* Revision 1.6  2007-08-02 22:13:22  jp_milcent
* Ajout des requêtes pour le module Recherche.
*
* Revision 1.5  2007-07-05 19:07:52  jp_milcent
* Amélioration et ajout de requêtes.
*
* Revision 1.4  2007-06-29 16:23:31  jp_milcent
* Ajout de la gestion du wrapper SQL. Mise en classe abstraite de EfloreModule.
*
* Revision 1.3  2007-06-25 16:37:06  jp_milcent
* Suppression du saut de ligne en fin de fichier.
*
* Revision 1.2  2007-06-21 17:42:49  jp_milcent
* Ajout de méthodes mais nécessite de les uniformiser...
*
* Revision 1.1  2007-06-19 10:32:57  jp_milcent
* Début utilisation de classes par module utilisant l'API 1.1.1.
* Renomage des anciennes classes en "Deprecie".
*
*
* +-- Fin du code ----------------------------------------------------------------------------------------+
*/
?>