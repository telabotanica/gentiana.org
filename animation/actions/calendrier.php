<?php
/*---------------------------------------------------------------
calendrier.php : action pour moteur wikini 0.4.1
developpé par Christian Goubier
Versin 0.6.0
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
$duree = $this->GetParameter("duree");
// lecture du style depuis le cookie
$calendrierstyle = $this->GetCookie("calendrierstyle");
$repertoire = $this->GetConfigValue("action_path").'/calendrier';
//
if (!class_exists('Calendrier')){
	include($this->GetConfigValue('action_path').'/calendrier/Calendrier.class.php');
	$_SESSION["premier_passage_calendrier"]=0;
}
//gestion de la feuille de style
$fich_style = $repertoire.'/'.$calendrierstyle.'.css';
if ($calendrierstyle && file_exists($fich_style))
	echo '<link href="'.$fich_style.'" rel="stylesheet" type="text/css" />';
else
	echo '<link href="'.$this->GetConfigValue("action_path").'/calendrier/calendrier.css" rel="stylesheet" type="text/css" />';
//
$calendrier = new Calendrier($this);

if (preg_match('#complet#',$duree)){
	echo $this->Format($calendrier->run_complet($duree,$_SESSION["premier_passage_calendrier"]), "wakka");
	$_SESSION["premier_passage_calendrier"]++;
}
if (preg_match('#navigation#',$duree)){
	echo $this->Format($calendrier->run_barre_nav($_SESSION["premier_passage_calendrier"]), "wakka");
	$_SESSION["premier_passage_calendrier"]++;
}
else if (preg_match('#mois#',$duree))
	echo $this->Format($calendrier->run_mois($duree), "wakka");
else if (preg_match('#jour#',$duree))
	echo $this->Format($calendrier->run_jour($duree), "wakka");
else if (preg_match('#offset#',$duree)){ 
	echo $this->Format($calendrier->run_offset($duree,$_SESSION["premier_passage_calendrier"]), "wakka");
	$_SESSION["premier_passage_calendrier"]++;
}
unset($calendrier);
?>
