<?
/*---------------------------------------------------------------
class pour l'action calendrier.php 
developpé par Christian Goubier
Version 0.7.1
Copyright  2004  
---------------------------------------------------------------
All rights reserved.
Redistribution and use in source and binary forms, with or without
modification, are permitted provided that the following conditions
are met:
1. Redistributions of source code must retain the above copyright
notice, this list of conditions and the following disclaimer.
2. Redistributions in binary form must reproduce the above copyright
notice, this list of conditions and the following disclaimer in the
documentation and/or other materials provided with the distribution.
3. The name of the author may not be used to endorse or promote products
derived from this software without specific prior written permission.

THIS SOFTWARE IS PROVIDED BY THE AUTHOR ``AS IS'' AND ANY EXPRESS OR
IMPLIED WARRANTIES, INCLUDING, BUT NOT LIMITED TO, THE IMPLIED WARRANTIES
OF MERCHANTABILITY AND FITNESS FOR A PARTICULAR PURPOSE ARE DISCLAIMED.
IN NO EVENT SHALL THE AUTHOR BE LIABLE FOR ANY DIRECT, INDIRECT,
INCIDENTAL, SPECIAL, EXEMPLARY, OR CONSEQUENTIAL DAMAGES (INCLUDING, BUT
NOT LIMITED TO, PROCUREMENT OF SUBSTITUTE GOODS OR SERVICES; LOSS OF USE,
DATA, OR PROFITS; OR BUSINESS INTERRUPTION) HOWEVER CAUSED AND ON ANY
THEORY OF LIABILITY, WHETHER IN CONTRACT, STRICT LIABILITY, OR TORT
(INCLUDING NEGLIGENCE OR OTHERWISE) ARISING IN ANY WAY OUT OF THE USE OF
THIS SOFTWARE, EVEN IF ADVISED OF THE POSSIBILITY OF SUCH DAMAGE.
*******************************************************************************/
class Calendrier
{
	var $wiki = ''; //objet wiki courant
   /**
   * Constructeur. 
   */
	function Calendrier($wiki){
   		$this->wiki = $wiki;
	}
	function liste_mois(){ return array("Janvier", "Février", "Mars", "Avril", "Mai", "Juin", "Juillet", "Août", "Septembre", "Octobre", "Novembre", "Décembre");}
	function liste_jours(){return array("Dimanche", "Lundi", "Mardi", "Mercredi", "Jeudi", "Vendredi", "Samedi");}
	
	function forMonth($mois, $annee) {
		global $proprio;
		$nowdate = getdate();
		$tab_mois = $this->liste_mois();
		$result = '""<div class="cal_cont_mois">';
		$result .= '<div class="cal_ligne_titre">""';
		$result .= '[['.$proprio.'Jour_Mois'.strftime("%Y%m", mktime(0,0,0, $mois, 1, $annee))." ".$tab_mois[$mois-1]."]]";
		$result .= '""</div>';
		$firstday = getdate(mktime (0,0,0,$mois,1,$annee));
		$lastday  = getdate(mktime (0,0,0,$mois+1,0,$annee));
		
		$wday = $firstday['wday']-1;
		if ($wday < 0) { 
			$wday=6; 
		}
		$last = $lastday['mday'];
		
		$result .= '<div class="cal_ligne_jours_sem">
					<div class="cal_j">Lun</div>
					<div class="cal_j">Mar</div>
					<div class="cal_j">Mer</div>
					<div class="cal_j">Jeu</div>
					<div class="cal_j">Ven</div>
					<div class="cal_j">Sam</div>
					<div class="cal_j">Dim</div></div>';

		
		// padding au début
		$result .= '<div class="cal_ligne_jours">';
		for ($i=0; $i<$wday; $i++) {
			$result .= '<div class="cal_j">&nbsp;</div>';
		}
		
		
		// pour chacun des jours du mois 
		for ($jour=1; $jour<=$last; $jour++) {
			// préparation pour le jour courant
			if ($mois==$nowdate['mon'] && $annee==$nowdate['year'] && $jour==$nowdate['mday']) {
				$jourcourant = true;
			} else {
				$jourcourant = false;
			}
			
			// affiche le jour courant
			if ($jourcourant) $result .= '<div class="cal_jj">';
			else $result .= '<div class="cal_j">';
			$result .= '""[['.$proprio.'Jour'.strftime("%Y%m%d", mktime(0,0,0, $mois, $jour, $annee)).' '.$jour.']]""';
			$result .= '</div>';
			
			// update pour le jour suivant
			$wday++;
			if ( $wday >6 ) {
				$wday = 0;
				$result .= '</div>';
				if ($jour < $last) {
					$result .= '<div class="cal_ligne_jours">';
				}
			}
		}
		$result .= '</div>';
		$result .= '</div>""';
		return $result;
	}
	
	function getTime($param) {
		if (isset($_SESSION["date_consultation"]))
			$dateConsultation = $_SESSION["date_consultation"];
		else
			$dateConsultation = strtotime("now");
		//-------------------------------
		if (preg_match ('#offset#',$param)){
			$data =explode(',',$param);
			$offset = $data[1];
			// si l'offset est égal à zéro on centre le calendrier sur le jour courant
			if ($offset == 0){
				$_SESSION["date_consultation"] = strtotime("now");
			}else{
				// si l'offset est supérieur à 27 on considere que c'est un mois
				if (abs($offset) > 27){
					if ($offset > 0)
						$offset = '+1 month';
					else
						$offset = '-1 month';
				}else{
					if ($offset > 0)
						$offset = '+'.abs($offset).' day';
					else
						$offset = '-'.abs($offset).' day';
				}
				$_SESSION["date_consultation"] = strtotime($offset, $dateConsultation);
			}
		}else{
			// passe du français à l'anglais
			if (preg_match('#maintenant#',$param))
				$param = 'now';
			$time = strtotime($param);
			//-------------------------------
			
			$time = strtotime($param, $dateConsultation);
			return $time;
		}
	}
	
	function forDay($time,$jour_courant) {
		global $proprio,$flag_jours_existants;
		$nowdate = getdate();
		
		$tab_mois = $this->liste_mois();
		
		$tab_jours = $this->liste_jours(); 
		
		$when = getdate($time);
		$jour = $when['mday'];
		$mois = $when['mon'];
		$annee = $when['year'];
		$result='';
		$nom_page=$proprio.'Jour'.strftime("%Y%m%d", mktime(0,0,0, $mois, $jour, $annee));
		if (!$flag_jours_existants || $jour_courant || $this->wiki->LoadPage($nom_page)){
			if ($jour_courant) $result .='""<div class="jour_courant">""';
			$result .= '[['.$proprio.'Jour'.strftime("%Y%m%d", mktime(0,0,0, $mois, $jour, $annee)).
					  ' '.$tab_jours[$when['wday']].' '.$jour.' '.$tab_mois[$mois-1].' '.$annee.']]---';
			$result .= '[[|'.$this->wiki->GetConfigValue("url_site").' '.$nom_page.']]';
			if ($jour_courant) $result .='""</div>""';
			else $result .= '----';
		}
		return $result;
	}
	
	function DeltaJour($premier, $second) {
		$delta = $second - $premier;
		$delta = $delta / (24*3600);
		return $delta;
	}
	
	function run_offset($param,$flag_premier_passage) {
		// mise à jour de l'offset sur la date centrage calendrier
		global $decalage;
		// attention la mise à jour ne doit etre faite qu'une seule fois
		if (isset($decalage) && $flag_premier_passage == 0)
			$this->getTime($decalage);
		$data = explode(",",$param);
		$name = htmlentities(trim($data[1]));
		$offset = 'offset,'.$data[2];

		$result  = "\"\"";
		$result .= "<a href=\"".$this->wiki->Href()."&decalage=$offset\">$name</a>";
		$result .= "\"\"";
		return $result;
	}
	// gestion affichage du mois
	function run_mois($param) {
		$time = $this->getTime(str_replace('mois','month',$param));
		$when = getdate($time);
		
		$mois = $when['mon'];
		$annee = $when['year'];
		return $this->forMonth($mois, $annee);
	}
	// gestion affichage du jour
	function run_jour($param, $jour_courant = false) {
		setlocale(LC_TIME, "fr");
		return $this->forDay($this->getTime(str_replace('jour','day',$param)),$jour_courant);
	}
	// gestion de la barre de navigation du calendrier
	function run_barre_nav($flag_premier_passage=1) {
		// mise à jour de l'offset sur la date centrage calendrier
		global $decalage;
		// attention la mise à jour ne doit etre faite qu'une seule fois
		if (isset($decalage) && $flag_premier_passage == 0)
			$this->getTime($decalage);
		$result ='""<div class="cal_cont_bar_nav">
					<a class="cal_bt_style" href="'.$this->wiki->config["url_site"].'/'.
					$this->wiki->GetConfigValue("action_path").'/calendrier/change_style.php">
					<span>Cliquer pour changer de style</span></a>
					<a class="cal_bt_aujourdhui" href="'.$this->wiki->Href().'&decalage=offset,0"></a>
					<a class="cal_bt" id="a" href="'.$this->wiki->Href().'&decalage=offset,-1"></a>
					<a class="cal_bt" id="b" href="'.$this->wiki->Href().'&decalage=offset,+1"></a>
					<a class="cal_bt" id="c" href="'.$this->wiki->Href().'&decalage=offset,-7"></a>
					<a class="cal_bt" id="d" href="'.$this->wiki->Href().'&decalage=offset,+7"></a>
					<a class="cal_bt" id="e" href="'.$this->wiki->Href().'&decalage=offset,-30"></a>
					<a class="cal_bt" id="f" href="'.$this->wiki->Href().'&decalage=offset,+30"></a>
				</div>""';
		return $result;		
	}

	// gestion d'un calendrier complet
	function run_complet($param,$flag_premier_passage) {
		// mise à jour de l'offset sur la date centrage calendrier
		global $decalage,$proprio,$flag_jours_existants;
		// attention la mise à jour ne doit etre faite qu'une seule fois
		if (isset($decalage) && $flag_premier_passage == 0)
			$this->getTime($decalage);
		// on recupere les paramètres mois et jours
		$data = explode(",",$param);
		$nb_mois_avant = $data[1];
		$nb_mois_apres = $data[2];
		$nb_jour_avant = $data[3];
		$nb_jour_apres = $data[4];
		if (isset($data[5]))
			$orde_des_jours = $data[5]; // gestion de l'ordre d'affichage des jours
		else
			$orde_des_jours = 0;
		//
		if (isset($data[6]))
			$proprio = $data[6]; // gestion de la personnalisation du calendrier
		else
			$proprio = "";
		//
		if (isset($data[7]))
			$flag_jours_existants = $data[7]; // affiche seulement les jours existant dans l'agenda
		else
			$flag_jours_existants = 0;
		//
		$result ='""<table width="100%"  border="0"><tr><td align="center" valign="top" width="50px">';// tableau sur 2 colonnes conteneur global du calendrier
		$result .='<div class="cal_cont_des_mois">""';// conteneur des mois
		// -------------------------------------------------
		// affichage des mois précédents si necessaire
		$j=$nb_mois_avant;
		While ( $j >= 1){
			$parametre = '-'.$j.' mois';
			$result .=$this->run_mois($parametre);
			$j--;
		}
		// affichage du mois courant
		$parametre = 'mois maintenant';
		$result .=$this->run_mois($parametre);
		// affichage des mois suivants si necessaire
		$j=1;
		While ( $j <= $nb_mois_apres){
			$parametre = '+'.$j.' mois';
			$result .=$this->run_mois($parametre);
			$j++;
		}
		//
		// -------------------------------------------------
		$result .='""</td><td align="left" valign="top">""'; // chg de col tableau
		// affichage de la barre de navigation
		$result .=$this->run_barre_nav();
		// -------------------------------------------------
		$result .='""<div class="cal_cont_journee">""';// conteneur journée
		if ($proprio !=""){
			$result .='==Calendrier personnel de '.$proprio.'==----';
		}
		if ($orde_des_jours == -1){// ordre inverse mode "blog"
			// affichage des jours suivants
			$j = 1;
			$i = $j;
			// on limite la recherche à 2 mois maxi
			While ( $j <= $nb_jour_apres && $i<60){
				$parametre = '+'.$i.' jour';
				$result1 =$this->run_jour($parametre);
				if (strlen($result1)>0){
					$tableau[$j]=$result1;
					$j++;
				}
				$i++;
			}
			While ( $j > 1){
				$result .=$tableau[$j-1];
				$j--;
			}
			// affichage du jour courant
			$parametre = 'jour maintenant';
			$result .=$this->run_jour($parametre,-1);// on indique avec -1 que c'est le jour courant
			// affichage des jours précédents 
			$j=1;
			$i = $j;
			While ( $j <= $nb_jour_avant && $i<$nb_jour_avant+60){
				$parametre = '-'.$i.' jour';
				$result1 =$this->run_jour($parametre);
				if (strlen($result1)>0){
					$result .=$result1;
					$j++;
				}
				$i++;
			}
		}else{
			// affichage des jours précédents si necessaire
			$j = 1;
			$i = $j;
			While ( $j <= $nb_jour_avant && $i<60){
				$parametre = '-'.$i.' jour';
				$result1 =$this->run_jour($parametre);
				if (strlen($result1)>0){
					$tableau[$j]=$result1;
					$j++;
				}
				$i++;
			}
			While ( $j > 1){
				$result .=$tableau[$j-1];
				$j--;
			}
			// affichage du jour courant
			$parametre = 'jour maintenant';
			$result .=$this->run_jour($parametre,-1);// on indique avec -1 que c'est le jour courant
			// affichage des jours suivants si necessaire
			$j=1;
			$i=$j;
			While ( $j <= $nb_jour_apres && $i<60){
				$parametre = '+'.$i.' jour';
				$result1 =$this->run_jour($parametre);
				if (strlen($result1)>0){
					$result .=$result1;
					$j++;
				}
				$i++;
			}
		}
		$result .='""</div>';// fermeture conteneur journée 
		// -------------------------------------------------
		$result .='</td></tr></table>""'; // fermeture tableau
		return str_replace('""""','',$result);
	}
}

?>