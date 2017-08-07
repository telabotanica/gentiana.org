<?php
/*vim: set expandtab tabstop=4 shiftwidth=4: */
// +------------------------------------------------------------------------------------------------------+
// | PHP version 5.1                                                                                      |
// +------------------------------------------------------------------------------------------------------+
// | Copyright (C) 1999-2006 Tela Botanica (accueil@tela-botanica.org)                                    |
// +------------------------------------------------------------------------------------------------------+
// | This file is part of eflore_bp.                                                                         |
// |                                                                                                      |
// | eflore_bp is free software; you can redistribute it and/or modify                                       |
// | it under the terms of the GNU General Public License as published by                                 |
// | the Free Software Foundation; either version 2 of the License, or                                    |
// | (at your option) any later version.                                                                  |
// |                                                                                                      |
// | eflore_bp is distributed in the hope that it will be useful,                                            |
// | but WITHOUT ANY WARRANTY; without even the implied warranty of                                       |
// | MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the                                        |
// | GNU General Public License for more details.                                                         |
// |                                                                                                      |
// | You should have received a copy of the GNU General Public License                                    |
// | along with Foobar; if not, write to the Free Software                                                |
// | Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA                            |
// +------------------------------------------------------------------------------------------------------+
// CVS : $Id: EfloreTriage.class.php,v 1.3 2007-08-05 22:53:30 jp_milcent Exp $
/**
* eflore_bp - EfloreTriage.php
*
* Description : 
* 
*@package eflore_bp
//Auteur original :
*@author        Jean-Pascal MILCENT <jpm@tela-botanica.org>
//Autres auteurs :
*@author        Aucun
*@copyright     Tela-Botanica 1999-2007
*@version       $Revision: 1.3 $ $Date: 2007-08-05 22:53:30 $
// +------------------------------------------------------------------------------------------------------+
*/

// +------------------------------------------------------------------------------------------------------+
// |                                            ENTÊTE du PROGRAMME                                       |
// +------------------------------------------------------------------------------------------------------+


// +------------------------------------------------------------------------------------------------------+
// |                                            CORPS du PROGRAMME                                        |
// +------------------------------------------------------------------------------------------------------+
class EfloreTriage {
	
	private static $tri_multi_dimension = array();
	private static $tri_type = '';

	/**
	* Méthode réalisant un tri naturel, voir fonction php natsort, d'un tableau multidimension.
	* A utiliser de cette façon:
	* EfloreTriage::triNaturel( $tableau_multidimension, array('ma_cle1', 'ma_cle1_ordre_tri', 'ma_cle2', 'ma_cle2_ordre_tri'));
	* Utiliser 'desc' ou 'asc' pour l'odre de tri.
	* 
	* @param array le tableau à trier
	* @param array le talbeau des colonnes à trier constituer d'un suite de nom de clé de tableau et d'ordre de tri.
	* 
	* @return array le tableau trié.
	*/
	public static function triNaturel(&$tableau, $cols) {
	    self::$tri_multi_dimension = $cols;
	    self::$tri_type = 'nat';
	    uasort($tableau, array('EfloreTriage', 'comparer'));
	    return $tableau;
	}
	
	/**
	* Méthode réalisant un tri d'un tableau multidimension.
	* A utiliser de cette façon:
	* EfloreTriage::trieMultiple( $tableau_multidimension, array('ma_cle1', 'ma_cle1_ordre_tri', 'ma_cle2', 'ma_cle2_ordre_tri'), $type_de_tri);
	* Utiliser 'desc' ou 'asc' pour l'odre de tri.
	* Pour le type de tri : utiliser 'nat' pour un trie naturel, 'cs' pour tri sensible à la casse ou 'ci' pour insensible.
	* 
	* @param array le tableau à trier
	* @param array le talbeau des colonnes à trier constituer d'un suite de nom de clé de tableau et d'ordre de tri.
	* 
	* @return array le tableau trié.
	*/
	public static function trieMultiple(&$tableau, $cols, $type = 'ci') 
	{ 
		self::$tri_multi_dimension = $cols;
		self::$tri_type = $type;
	    usort($tableau, array('EfloreTriage', 'comparer'));
	    return $tableau;
	}
	
	private static function comparer($a, $b) {
	    $cols = self::$tri_multi_dimension;
	    $i = 0;
	    $resultat = 0;
	    $colonne_nbre = count($cols);
	    while ($resultat == 0 && $i < $colonne_nbre) {
	        $mot_01 = EfloreEncodage::enleverAccents($b[$cols[$i]]);
	        $mot_02 = EfloreEncodage::enleverAccents($a[$cols[$i]]);
	        switch (self::$tri_type) {
	        	case 'nat' :
	        		$resultat = ($cols[$i + 1] == 'desc') ? strnatcmp($mot_01, $mot_02) : strnatcmp($mot_02, $mot_01);
	        		break;
	        	case 'cs' :
	        		$resultat = ($cols[$i + 1] == 'desc') ? strcmp($mot_01, $mot_02) : strcmp($mot_02, $mot_01);
	        		break;
	        	case 'ci' :
	        		$resultat = ($cols[$i + 1] == 'desc') ? strcasecmp($mot_01, $mot_02) : strcasecmp($mot_02, $mot_01);
	        		break;
	        	default:
	        		trigger_error('Veuillez définir un type de tri', E_USER_WARNING);
	        }
	        $i += 2;
	    }
	    return $resultat;
	}
}

/* +--Fin du code ----------------------------------------------------------------------------------------+
*
* $Log: EfloreTriage.class.php,v $
* Revision 1.3  2007-08-05 22:53:30  jp_milcent
* Amélioration de la syntaxe.
*
* Revision 1.2  2007-08-05 22:39:12  jp_milcent
* Ajout d'une fonction de tri multidimensionnel classique.
* Ajout du type de tri.
*
* Revision 1.1  2007-07-12 16:17:02  jp_milcent
* Ajout d'une classe effectuent des ties de tableaux de données.
*
*
* +-- Fin du code ----------------------------------------------------------------------------------------+
*/
?>
