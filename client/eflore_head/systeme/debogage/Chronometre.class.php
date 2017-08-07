<?php
/*vim: set expandtab tabstop=4 shiftwidth=4: */ 
// +------------------------------------------------------------------------------------------------------+
// | PHP version 5.0.4                                                                                    |
// +------------------------------------------------------------------------------------------------------+
// | Copyright (C) 2005 Tela Botanica (accueil@tela-botanica.org)                                         |
// +------------------------------------------------------------------------------------------------------+
// | This file is part of eFlore-Debogage.                                                                |
// |                                                                                                      |
// | Foobar is free software; you can redistribute it and/or modify                                       |
// | it under the terms of the GNU General Public License as published by                                 |
// | the Free Software Foundation; either version 2 of the License, or                                    |
// | (at your option) any later version.                                                                  |
// |                                                                                                      |
// | Foobar is distributed in the hope that it will be useful,                                            |
// | but WITHOUT ANY WARRANTY; without even the implied warranty of                                       |
// | MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the                                        |
// | GNU General Public License for more details.                                                         |
// |                                                                                                      |
// | You should have received a copy of the GNU General Public License                                    |
// | along with Foobar; if not, write to the Free Software                                                |
// | Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA                            |
// +------------------------------------------------------------------------------------------------------+
// CVS : $Id: Chronometre.class.php,v 1.1 2005-11-15 17:33:49 jp_milcent Exp $
/**
* Classe permettant de mesurer le temps d'execution d'un script.
*
* Contient des m�thodes permettant d'�valuer la vitesse d'ex�cution d'un script.
*
*@package eFlore
*@subpackage Debogage
//Auteur original :
*@author        Jean-Pascal MILCENT <jpm@tela-botanica.org>
//Autres auteurs :
*@author        aucun
*@copyright     Tela-Botanica 2000-2005
*@version       $Revision: 1.1 $ $Date: 2005-11-15 17:33:49 $
// +------------------------------------------------------------------------------------------------------+
*/

// +------------------------------------------------------------------------------------------------------+
// |                                            ENTETE du PROGRAMME                                       |
// +------------------------------------------------------------------------------------------------------+


// +------------------------------------------------------------------------------------------------------+
// |                                            CORPS du PROGRAMME                                        |
// +------------------------------------------------------------------------------------------------------+
/**Classe Chronometre() - Permet de stocker et d'afficher les temps d'�x�cution de script.
*
* Cette classe permet de r�aliser un ensemble de mesure de temps prises �
* diff�rents endroits d'un script. Ces mesures peuvent ensuite �tre affich�es au
* sein d'un tableau XHTML.
* 
* @author	Jean-Pascal MILCENT <jpm@tela-botanica.org>
*/
class Chronometre
{
	/*** Attributs : ***/
	private $temps = array();
	
	/*** Constructeur : ***/
	public function __construct() {
		$this->setTemps(array('depart' => microtime()));
	}
	
	/*** Accesseurs : ***/
	
	public function getTemps($cle = NULL) {
		if (!is_null($cle)) {
			return $this->temps[$cle];
		} else {
			return $this->temps;
		}
	}
	
	public function setTemps($moment = array()) {
		array_push($this->temps, $moment);	
	}
	
	/*** M�thodes : ***/
	
	/**M�thode afficherChrono() - Permet d'afficher les temps d'�x�cution de diff�rentes parties d'un script.
	*
	* Cette fonction permet d'afficher un ensemble de mesure de temps prises � diff�rents endroits d'un script.
	* Ces mesures sont affich�es au sein d'un tableau XHTML dont on peut controler l'indentation des balises.
	* Pour un site en production, il suffit d'ajouter un style #chrono {display:none;} dans la css. De cette fa�on,
	* le tableau ne s'affichera pas. Le webmaster lui pourra rajouter sa propre feuille de style affichant le tableau.
	* Le d�veloppeur initial de cette fonction est Loic d'Anterroches. Elle a �t� modifi�e par Jean-Pascal Milcent.
	* Elle utilise une variable gobale : $_CHRONO_
	*
	* @author   Loic d'Anterroches
	* @author        Jean-Pascal MILCENT <jpm@tela-botanica.org>
	* @param    int     l'indentation de base pour le code html du tableau.
	* @param    int     le pas d'indentation pour le code html du tableau.
	* @return   string  la chaine XHTML de mesure des temps.
	*/
	function afficherChrono($indentation_origine = 8, $indentation = 4)	{
		// Cr�ation du chrono de fin
		$GLOBALS['_EFLORE_']['chrono']->setTemps(array('fin' => microtime()));

		// D�but cr�ation de l'affichage
		$sortie = str_repeat(' ', $indentation_origine).
		    		'<table id="chrono" lang="fr" summary="R�sultat du chronom�trage du programme affichant la page actuelle.">'."\n";
		$sortie .= str_repeat(' ', ($indentation_origine + ($indentation * 1))).
		        '<caption>Chronom�trage</caption>'."\n";
		$sortie .= str_repeat(' ', ($indentation_origine + ($indentation * 1))).
		        '<thead>'."\n";
		$sortie .= str_repeat(' ', ($indentation_origine + ($indentation * 2))).
		            '<tr><th>Action</th><th>Temps �coul� (en s.)</th><th>Cumul du temps �coul� (en s.)</th></tr>'."\n";
		$sortie .= str_repeat(' ', ($indentation_origine + ($indentation * 1))).
		        '</thead>'."\n";
		
		$tbody = str_repeat(' ', ($indentation_origine + ($indentation * 1))).
		        '<tbody>'."\n";
		        
		$total_tps_ecoule = 0;
		
		// R�cup�ration de la premi�re mesure
		$tab_depart =& $this->getTemps(0);
		list($usec, $sec) = explode(' ', $tab_depart['depart']);
		
		// Ce temps correspond � tps_fin
		$tps_debut = ((float)$usec + (float)$sec);
		
		foreach ($this->getTemps() as $tab_temps) {
			foreach ($tab_temps as $cle => $valeur) {
				list($usec, $sec) = explode(' ', $valeur);
				$tps_fin = ((float)$usec + (float)$sec);
				
				$tps_ecoule = abs($tps_fin - $tps_debut);
				$total_tps_ecoule += $tps_ecoule;
				
				$tbody .=   str_repeat(' ', ($indentation_origine + ($indentation * 2))).
				        '<tr>'.
				            '<th>'.$cle.'</th>'.
				            '<td>'.number_format($tps_ecoule, 3, ',', ' ').'</td>'.
				            '<td>'.number_format($total_tps_ecoule, 3, ',', ' ').'</td>'.
				        '</tr>'."\n";
				$tps_debut = $tps_fin;
			}
		}
		$tbody .= str_repeat(' ', ($indentation_origine + ($indentation * 1))).
		        '</tbody>'."\n";
		
		$sortie .= str_repeat(' ', ($indentation_origine + ($indentation * 1))).
		        '<tfoot>'."\n";
		$sortie .= str_repeat(' ', ($indentation_origine + ($indentation * 2))).
		            '<tr>'.
		                '<th>'.'Total du temps �coul� (en s.)'.'</th>'.
		                '<td colspan="2">'.number_format($total_tps_ecoule,3, ',', ' ').'</td>'.
		            '</tr>'."\n";
		$sortie .= str_repeat(' ', ($indentation_origine + ($indentation * 1))).
		        '</tfoot>'."\n";
		$sortie .= $tbody;
		$sortie .= str_repeat(' ', $indentation_origine).
		    '</table>'."\n";
		
		return $sortie;
	}

}

/* +--Fin du code ----------------------------------------------------------------------------------------+
*
* $Log: Chronometre.class.php,v $
* Revision 1.1  2005-11-15 17:33:49  jp_milcent
* Ajout de classe Syst�me pour le d�bogage.
* Ces classes sont � am�liorer!
*
* Revision 1.1  2005/08/04 15:51:45  jp_milcent
* Impl�mentation de la gestion via DAO.
* Fin page d'accueil.
* Fin formulaire recherche taxonomique.
*
* Revision 1.2  2005/08/03 15:52:31  jp_milcent
* Fin gestion des r�sultats recherche nomenclaturale.
* D�but gestion formulaire taxonomique.
*
* Revision 1.1  2005/08/02 16:19:33  jp_milcent
* Am�lioration des requetes de recherche de noms.
*
*
* +-- Fin du code ----------------------------------------------------------------------------------------+
*/
?>