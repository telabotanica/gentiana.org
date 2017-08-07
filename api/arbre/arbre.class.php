<?php

/* 	*****************************  classe arbre  ***********************************
*	classe permettant la creation d'un arbre, elle est fonctionnelle en tant que module
*	de gsite (www.gsite.org). 
*	L'arbre peut servir de representation graphique de donnees statistiques.
*	Copyright 2001 Tela Botanica 
*	Auteurs : Daniel Mathieu, Nicolas Touillaud, Alexandre Granier
*	Cette bibliothèque est libre, vous pouvez la redistribuer et/ou la modifier
*	selon les termes de la Licence Publique Générale GNU publiée par la
*	Free Software Foundation.
*	Cette bibliothèque est distribuée car potentiellement utile, mais SANS
*	AUCUNE GARANTIE, ni explicite ni implicite, y compris les garanties de
*	commercialisation ou d'adaptation dans un but spécifique.
*	
*	Derniere mise a jour : 10 decembre 2001
************************************************************************************/
error_reporting (E_ALL) ;
//l'ecran
//$xres=698; //doit etre divisible par 2 sinon bug d'alignement
$innerTableWidth = 600;
$xres=$innerTableWidth-10;
$yres=600;

//les images
$yfait= 50; //la hauteur du "sommet"
$xfait= 1;
$xtronc= 36; //doit etre divisible par 2 sinon bug d'alignement
$ytronc= 559;
$xbranche= 200;
$ybranche= 64;
$xracine= 191;
$yracine= 61;
$xfeuille= 50;
$yfeuille= 45;
$xtextedroite=10;
$ytextedroite=15;
$xtextegauche=10;
$ytextegauche=10;
$yposnom=12;
$xpuce=10;
$ypuce=10;
$taille_mini=60;
$nhi_xsommet=191;
$nhi_ysommet=61;
include 'tailles.php3' ;

define ("ARBRE_CHEMIN_IMAGES", 'api/arbre/images/') ;


function calc_xref_branche($xres_,$xfeuille_, $xtronc_)
 //calcule la taille de reference des branches
 {
  //global $xres, $xfeuille, $xtronc;
  $toto=round(($xres_-$xtronc_-(2*$xfeuille_))/2);
  return $toto;
 }



 //******************************************************
 // calcule l'espace vertical entre 2 branche d'un meme coté: si il n'y a pas la place -> 12 pixels
 function calc_esver()
 {
global $nbdroite ;
  if ($nbdroite != 1):
  {
   global $yres, $yfait, $yracine, $ybranche, $nbdroite;
   $toto=($yres-$yfait-$yracine-($nbdroite*$ybranche))/($nbdroite-1);
   if($toto<0):{$toto=12;} //on ne se place plus sur 1 ecran mais sur plus
   endif;
   return $toto;
  }
  else:{return 0;}
  endif;
 }
 //******************************************************

 $esver=calc_esver();

 //******************************************************
 //calcul la position en x de la branche
 function calcul_x_branche($adroite,$xreel)
 {
  global $xres, $xtronc, $xref_branche;
  $tempx=($xres+$xtronc)/2-2; //pour un bug
  if($adroite != 1):
  {
   $tempx=$tempx+2-$xtronc-($xreel);
  }
  endif;
  return round($tempx);
 }
 //******************************************************

 //Il est impératif d'afficher 1 branche d'un coté, puis de l'autre etc..

 //******************************************************
 //retourne la position y de la branche (et de la feuille) et met à jour la hauteur de la prochaine branche
 function calcul_y_branche()
 {
  global $esver, $hauteur, $ybranche;
  $toto=$hauteur;
  $hauteur=$hauteur+(($ybranche+$esver)/2);
  return $toto;
 }
 //******************************************************

 //******************************************************
 //retourne la position x du tronc
 function x_tronc()
 {
  global $xtronc, $xres;
  return ($xres-$xtronc)/2;
 }
 //******************************************************

 //******************************************************
 //retourne la position y du tronc
 function y_tronc()
 {
  global $yfait;
  return ($yfait);
 }
 //******************************************************

 //******************************************************
 // retourne la position x de la racine
 function x_racine()
 {
  global $xracine, $xres;
  return ($xres-$xracine)/2;
 }
 //******************************************************

 //******************************************************
 //retourne la taille du tronc en pixels
 function taille_tronc()
 {
  global $nbdroite, $esver, $ybranche;
  $toto=($nbdroite-1)*$esver+($nbdroite*$ybranche);
  return $toto;
 }
 //******************************************************

 //******************************************************
 //retourne la position x de la feuille en fonction des param de la branche
 function calcul_x_feuille($adroite, $pos_branche, $xreel_brch)  //xreel en %
 {
  global $xref_branche, $xfeuille;
  if($adroite !=1):
  {
   $toto=$pos_branche-$xfeuille;
  }
  else:
  {
   $toto=$pos_branche+($xreel_brch);
  }
  endif;
  return $toto;
 }
 //******************************************************

 //******************************************************
 // retourne la position y de la racine
 function y_racine()
 {
  global $yfait;
  $toto=$yfait+taille_tronc();
  return $toto;
 }
 //******************************************************


 //******************************************************
 //met 1 à 0 et inversement
 function dg($dte)
 {
  if($dte==1):{return 0;}
  else:{return 1;}
  endif;
 }
 //******************************************************

 //******************************************************
 //une fonction qui prend le % de vert *100 et qui sort la chaine html du vert correspondant
 function couleur_f($prc)
 {
  if ($prc==0) return ("#279C27");
  if (($prc>0) && ($prc<=16)) return ("#279C27");
  if (($prc>16) && ($prc<=32)) return ("#CCCC00");
  if (($prc>32) && ($prc<=48)) return ("#FFCC00");
  if (($prc>48) && ($prc<=64)) return ("#DD8D22");
  if (($prc>64) && ($prc<=80)) { 
  			return "#FF6600" ;
			} else { 
			return "#CC3300" ;
			}
}
//*****************************************************

//une fonction qui détermine si un entier est pair ou non
function est_pair($un_entier)
{
 return(($un_entier %2)==0);
}


class arbre {

	var $nbre_branche ;
	var $branche ;
	var $blanc_cime ;
	
/********************************************************************************
*	constructeur arbre(chaine $nom, chaine $lien_nom, entier $intensite,  chaine $lien_intensite,
*						chaine $lien_feuille)
*	crees une instance d'arbre, les parametres sont les informations du sommet de l'arbre
*	$nom : le texte du haut de l'arbre
*	$lien_nom : le lein associe
*	$intensite : le nombre a cote du nom
*	$lien_intensite : le lien sur l'intensite
*	$lien_feuille : le lien, lorsqu'on clique sur la feuille du haut de l'arbre
*********************************************************************************/

	function arbre() {}

	function cime($nom, $lien_nom, $intensite, $lien_intensite, $lien_feuille) {
	//global $nhi_xsommet, $nhi_ysommet,$ybranche,$yfeuille, $yres, $innerTableWidth ;
	
	//l'ecran
//$xres=698; //doit etre divisible par 2 sinon bug d'alignement
$innerTableWidth = 600;
$xres=$innerTableWidth-10;
$yres=600;

//les images
$yfait= 50; //la hauteur du "sommet"
$xfait= 1;
$xtronc= 36; //doit etre divisible par 2 sinon bug d'alignement
$ytronc= 559;
$xbranche= 200;
$ybranche= 64;
$xracine= 191;
$yracine= 61;
$xfeuille= 50;
$yfeuille= 45;
$xtextedroite=10;
$ytextedroite=15;
$xtextegauche=10;
$ytextegauche=10;
$yposnom=12;
$xpuce=10;
$ypuce=10;
$taille_mini=60;
$nhi_xsommet=191;
$nhi_ysommet=61;
	// tailles.php3 contient les variables de tailles des fichiers graphiques associes
	// a l'arbre
    include 'tailles.php3' ;
	
	// Le blanc devant la cime de l'arbre
	$this->blanc_cime = round(($xres-$nhi_xsommet)/2);
	
	$res = '<tr>
  <td align="center"><a href="'.$lien_nom.'"><b><i>'.$nom.'</i></b></a> <a href="'.$lien_intensite.'"><b><i>('.$intensite.')</i></b></a></td>
 </tr>
 <tr>
  <td align="center"><table width="'.$xres.'" border="0" cellspacing="0" cellpadding="0" summary="">';
	// haut de l'arbre
	$res .= '<tr>
			 <td align="center"><table border="0" cellspacing="0" cellpadding="0" summary="">
				 <tr>
					<td><img alt="" width="'.$this->blanc_cime.'" height="1" src="'.ARBRE_CHEMIN_IMAGES.'vide.gif" /></td>
					<td width="'.$nhi_xsommet.'" height="'.$nhi_ysommet.'" align="center"><a href="'.$lien_feuille.'" target="_blank" class="image_lien">
                    <img alt="" width="'.$nhi_xsommet.'" height="'.$nhi_ysommet.'" border="0" src="'.ARBRE_CHEMIN_IMAGES.'haut.gif" /></a></td>
					<td><img alt="" width="'.$this->blanc_cime.'" height="1" src="'.ARBRE_CHEMIN_IMAGES.'vide.gif" /></td>
				 </tr>
				</table>
			 </td>
			</tr>';
	return $res ;
	}


/**************************  fonction addBranche  ******************************************
*	ajoute une branche a l'arbre
*
*	$nom : le label d'une branche
*	$lien_nom : le lien associe au label
*	$intensite : le nombre a droite du label
*	$lien_intensite : le lien sur le nombre
*	$lien feuille : le lien quand on clique sur la feuille
*	$intensite_feuille : un nombre compris entre 1 et 100, qui sera transforme en couleur
*	$longueur_branche : un nombre entre 1 et 100, pour la longueur de la branche*
********************************************************************************************/
	function addBranche($nom, $lien_nom, $intensite, $lien_intensite, $lien_feuille, $intensite_feuille, $longueur_branche) {
		
		$this->nbre_branche++ ;
		
		$this->branche["nom"][$this->nbre_branche] = $nom ;
		$this->branche["lien_nom"][$this->nbre_branche] = $lien_nom ;
		$this->branche["intensite"][$this->nbre_branche] = $intensite ;
		$this->branche["lien_intensite"][$this->nbre_branche] = $lien_intensite ;
		$this->branche["lien_feuille"][$this->nbre_branche] = $lien_feuille ;
		$this->branche["intensite_feuille"][$this->nbre_branche] = $intensite_feuille ;
		$this->branche["longueur_branche"][$this->nbre_branche] = $longueur_branche ;
		
	}
/************  fonction affBranche()   ajoute le code HTML des branches  ********************
*	ne renvoie rien
*********************************************************************************************/
	function affBranche() {
		//l'ecran
//$xres=698; //doit etre divisible par 2 sinon bug d'alignement
$innerTableWidth = 600;
$xres=$innerTableWidth-10;
$yres=600;

//les images
$yfait= 50; //la hauteur du "sommet"
$xfait= 1;
$xtronc= 36; //doit etre divisible par 2 sinon bug d'alignement
$ytronc= 559;
$xbranche= 200;
$ybranche= 64;
$xracine= 191;
$yracine= 61;
$xfeuille= 50;
$yfeuille= 45;
$xtextedroite=10;
$ytextedroite=15;
$xtextegauche=10;
$ytextegauche=10;
$yposnom=12;
$xpuce=10;
$ypuce=10;
$taille_mini=60;
$nhi_xsommet=191;
$nhi_ysommet=61;
		$tb = "" ; $tb2 = "" ;
		//global $nhi_xsommet, $nhi_ysommet,$ybranche,$yfeuille, $xref_branche, $taille_mini;
		//global $xtronc, $espace_a_gauche, $xfeuille , $les_slashes, $xres, $innerTableWidth;
		include 'tailles.php3' ;
		$xref_branche = calc_xref_branche($xres,$xfeuille,$xtronc);

		$res = "<!-- xref_branche=$xref_branche -->";

		$yinv=$ybranche-$yfeuille; //Hauteur de la case vide sous la feuille

		//le tableau des branches

        //ici, la boucle
        //ajustement de la boucle: le nombre de tables doit être pair dans la boucle
        $la_limite_de_la_boucle = $this->nbre_branche;

        if(true != est_pair($la_limite_de_la_boucle)): //ajustement de la boucle
        {
        $la_limite_de_la_boucle-=1;
        }endif;

        $coul_ = '' ;
        for($i=0; $i < $la_limite_de_la_boucle ; $i += 2) {
            
            // informations concernant la branche gauche
            
            $coul_=couleur_f($this->branche["intensite_feuille"][$i+1]);
            $xrel=$this->branche["longueur_branche"][$i+2]/100;
            $tbr = round($xrel * $xref_branche);
            if($tbr < $taille_mini) $tbr = $taille_mini + $tbr ; //taille mini de la branche

            if(isset ($les_slashes) && $les_slashes == 1) {
                $this->branche["lien_nom"][$i+1] = stripslashes($this->branche["nom_lien"][$i+1]);
                $this->branche["lien_feuille"][$i+1] = stripslashes($this->branche["lien_feuille"][$i+1]);
                //$lien_puce2=stripslashes($lien_puce2);
            }

            // informations concernant la branche droite
            $coul_2=couleur_f($this->branche["intensite_feuille"][$i+2]);
            $xrel2 = $this->branche["longueur_branche"][$i+1]/100.0;
             $tbr2 = round($xrel2*$xref_branche);
             if($tbr2 < $taille_mini) $tbr2 = $taille_mini+$tbr2 ; //taille mini de la branche

            //pour des parametress de javascript, le addslash provient de appli_dessin_date
            if(isset ($les_slashes) && $les_slashes == 1) {
                $this->branche["lien_nom"][$i+2] = stripslashes($this->branche["lien_nom"][$i+2]);
                $this->branche["lien_feuille"][$i+2] = stripslashes($this->branche["lien_feuille"][$i+2]);
                //$lien_puce2=stripslashes($lien_puce2);
            }

            //espace à gauche
             $espace_a_gauche=round((($xres-$xtronc)/2)-$tbr2-$xfeuille);

            //espace à droite
             $espace_a_droite=round($xres-$xtronc-$tbr-$tbr2-2*$xfeuille-$espace_a_gauche);

             $res .= "<!-- Les noms des listes -->
    <tr>
		 <td>
		  <table border=\"0\" cellspacing=\"0\" cellpadding=\"0\" summary=\"\">
			 <tr>
			  <td colspan=\"3\" align=\"right\"><a href=\"";
			  $res .= $this->branche["lien_nom"][$i+1];
			  $res .= '" class="lien_nom">';
			  $res .= $this->branche["nom"][$i+1];
			  $res .= "</a>";
              if($this->branche["intensite"][$i+1] != 0) {
			  	$res .= " <a href=\"" ;
				$res .= $this->branche["lien_intensite"][$i+1];
				$res .= '" class="lien_nom">(';
				$res .= $this->branche["intensite"][$i+1];
				$res .= ")</a>";
				}
			$res .= "&nbsp;&nbsp;&nbsp;&nbsp;</td>
<!-- Le tronc -->
        <td bgcolor=\"#663333\"><img alt=\"\" width=\"$xtronc\" height=\"20\" src=\"".ARBRE_CHEMIN_IMAGES."vide.gif\" /></td>
			  <td colspan=\"3\" align=\"left\">&nbsp;&nbsp;&nbsp;&nbsp;<a href=\"";
			  $res .= $this->branche["lien_nom"][$i+2];
			  $res .= '" class="lien_nom">';
			  $res .= $this->branche["nom"][$i+2];
			  $res .= "</a>";
              if($this->branche["intensite"][$i+2] != 0) {
			  	$res .= " <a href=\"";
				$res .= $this->branche["lien_intensite"][$i+2];
				$res .= '" class="lien_nom">(';
				$res .= $this->branche["intensite"][$i+2];
				$res .= ")</a>";
				}
			$res .= "</td>
			 </tr>
 
<!-- Bloc de 2 branches -->
			 <tr>
<!-- Espace gauche -->
        <td rowspan=\"2\"><img alt=\"\" width=\"$espace_a_gauche\" height=\"1\" src=\"".ARBRE_CHEMIN_IMAGES."vide.gif\" /></td>
        <!-- Feuille gauche -->
				<td class=\"chiffre\" align=\"center\" bgcolor=\"$coul_2\" width=\"$xfeuille\" height=\"$yfeuille\">";
                if($this->branche["lien_feuille"][$i+1]!="") {
                $res .= '<a target="_blank" href="';
                $res .= $this->branche["lien_feuille"][$i+1] ;
                $res .= '" class="image_lien">';
                }
                $res .= "<img alt=\"\" width=\"$xfeuille\" height=\"$yfeuille\" border=\"0\" src=\"".ARBRE_CHEMIN_IMAGES."feuille_gauche.gif\" />";
                if($this->branche["lien_feuille"][$i+1]!=""):{$res .= "</a>";}endif;$res .= "</td>
<!-- Branche gauche: taille $tb2 % = $tbr2 pixels -->
				<td rowspan=\"2\"><img alt=\"\" width=\"$tbr2\" height=\"$ybranche\" src=\"".ARBRE_CHEMIN_IMAGES."branche_gauche.gif\" /></td>
                <!-- Le tronc -->
				<td rowspan=\"2\" bgcolor=\"#663333\"><img alt=\"\" width=\"$xtronc\" src=\"".ARBRE_CHEMIN_IMAGES."vide.gif\" /></td>
														    
<!-- Branche droite: taille $tb % = $tbr pixels -->
				<td rowspan=\"2\"><img alt=\"\" width=\"$tbr\" height=\"$ybranche\" src=\"".ARBRE_CHEMIN_IMAGES."branche_droite.gif\" /></td>
<!-- Feuille droite -->
				<td class=\"chiffre\" align=\"center\" bgcolor=\"$coul_\" width=\"$xfeuille\" height=\"$yfeuille\">";
               if($this->branche["lien_feuille"][$i+2] != "") {
                    $res .= '<a target="_blank" href="';
                    $res .= $this->branche["lien_feuille"][$i+2];
                    $res .= '" class="image_lien">';
                    }
                $res .= "<img alt=\"\" width=\"$xfeuille\" height=\"$yfeuille\" border=\"0\" src=\"".ARBRE_CHEMIN_IMAGES."feuille_droite.gif\" />";
               if($this->branche["lien_feuille"][$i+2] !="") {
                    $res .= "</a>";
                    }
                $res .= '</td>
<!-- Espace droit -->
    <td rowspan="2"><img alt="" width="'.$espace_a_droite.'" height="1" src="'.ARBRE_CHEMIN_IMAGES.'vide.gif" /></td>
			 </tr>
<!-- Les cases vides sous les feuilles -->
            <tr>
			  <td height="'.$yinv.'"><img alt="" width="1" height="'.$yinv.'" src="'.ARBRE_CHEMIN_IMAGES.'vide.gif" /></td>
			  <td height="'.$yinv.'"><img alt="" width="1" height="'.$yinv.'" src="'.ARBRE_CHEMIN_IMAGES.'vide.gif" /></td>
			 </tr>
			</table>
		 </td>
		</tr>
<!-- Fin du bloc de 2 branches -->';

 				}
				if(!est_pair($this->nbre_branche))	{
				$coul_2=couleur_f($this->branche["intensite_feuille"][$this->nbre_branche]);
				$xrel2 = $this->branche["longueur_branche"][$this->nbre_branche]/100.0;
  				 $tbr2 = round($xrel2*$xref_branche);
  				 if($tbr2 < $taille_mini) $tbr2 = $taille_mini+$tbr2 ; //taille mini de la branche

				//pour des parametress de javascript, le addslash provient de appli_dessin_date
				if(isset ($les_slashes) && $les_slashes==1) {
					$this->branche["lien_nom"][$this->nbre_branche] = stripslashes($this->branche["lien_nom"][$this->nbre_branche]);
					$this->branche["lien_feuille"][$this->nbre_branche] = stripslashes($this->branche["lien_feuille"][$this->nbre_branche]);
					//$lien_puce2=stripslashes($lien_puce2);
					}
				
				 //espace à gauche
		          $espace_a_gauche=round((($xres-$xtronc)/2)-$tbr2-$xfeuille);

				 $res .= '<!-- Le nom de la liste -->
    <tr>
		 <td>
		  <table border="0" cellspacing="0" cellpadding="0" align="left">
			 <tr>
			  <td colspan="3" align="right"><a href="';
			  $res .= $this->branche["lien_nom"][$this->nbre_branche] ;
			  $res .= '" class="lien_nom">';
			  $res .= $this->branche["nom"][$this->nbre_branche];
			  $res .= "</a>";
              if($this->branche["intensite"][$this->nbre_branche] != 0 ) {
			  $res .= ' <a href="';
			  $res .= $this->branche["lien_intensite"][$this->nbre_branche] ;
			  $res .= '" class="lien_nom">(';
			  $res .= $this->branche["intensite"][$this->nbre_branche];
			  $res .= ')</a>';
			  }
			  $res .= '&nbsp;&nbsp;&nbsp;&nbsp;</td>
<!-- Le tronc -->
        <td bgcolor="#663333"><img alt="" width="'.$xtronc.'" height="20" src="'.ARBRE_CHEMIN_IMAGES.'vide.gif" /></td>
			  <td colspan="3" rowspan="3" align="left">&nbsp;</td>
			 </tr>
 
<!-- Bloc de 1 branche -->
			 <tr>
<!-- Espace gauche -->
        <td rowspan="2"><img alt="" width="'.$espace_a_gauche.'" height="1" src="'.ARBRE_CHEMIN_IMAGES.'vide.gif" /></td>
<!-- Feuille gauche -->
				<td class="chiffre" align="center" bgcolor="'.$coul_.'" width="'.$xfeuille.'" height="'.$yfeuille.'" >';
             if($this->branche["lien_feuille"][$this->nbre_branche] != "") {
                $res .= "<a target=\"_blank\" href=\"";
                $res .= $this->branche["lien_feuille"][$this->nbre_branche];
                $res .= '">';
                }
                $res .= "<img alt=\"\" width=\"$xfeuille\" height=\"$yfeuille\" border=\"0\" src=\"".ARBRE_CHEMIN_IMAGES."feuille_gauche.gif\" />";
             if($this->branche["lien_feuille"][$this->nbre_branche]!=""):{$res .= "</a>";}endif;$res .= "</td>
<!-- Branche gauche: taille $tb2 % = $tbr2 pixels -->
				<td rowspan=\"2\"><img alt=\"\" width=\"$tbr2\" height=\"$ybranche\" src=\"".ARBRE_CHEMIN_IMAGES."branche_gauche.gif\" /></td>

<!-- Le tronc -->
				<td rowspan=\"2\" bgcolor=\"#663333\"><img alt=\"\" width=\"$xtronc\" src=\"".ARBRE_CHEMIN_IMAGES."vide.gif\" /></td>
                           </tr>
<!-- La case vide sous la feuille -->
                      <tr>
			  <td height=\"$yinv\"><img alt=\"\" width=\"1\" height=\"$yinv\" src=\"".ARBRE_CHEMIN_IMAGES."vide.gif\" /></td>
                      </tr>
	              </table>
		      </td>
		     </tr>
";

				}
	return $res ;
	}
/********************  fonction affRacine()  ****************************************
*	affiche	la racine, ne renvoie rien 
*************************************************************************************/
	function affRacine() {
    
	$xracine = 191 ; $yracine = 61;
    $this->blanc_cime -= 4 ;

	$res = '<!-- la racine -->
          <tr>
           <td align="left"><img width="'.$this->blanc_cime.'" height="1" border="0" src="'.ARBRE_CHEMIN_IMAGES.'vide.gif" alt="vide" />
		   		<img src="'.ARBRE_CHEMIN_IMAGES.'racine.gif" width="'.$xracine.'" height="'.$yracine.'" border="0" alt="racine" />
           </td>
          </tr>
         </table>
        </td>
       </tr>';
	return $res ;
	}
}

?>
