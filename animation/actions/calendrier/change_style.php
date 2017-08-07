<?php
$repertoire = ".";
$handle = opendir($repertoire);
$tab_style = array();
// recherche des fichiers de style présents
while (false !== ($document = readdir($handle))){
	$ext=explode('.',$document);
	if($document != '.' && $document != '..' && $ext[1] == 'css')
		$tab_style[]=$ext[0];
}
// trie feuille de style
sort($tab_style);
reset($tab_style);
$nb_style = count($tab_style);
$pos_style_courant = 0;
$j=0;
while($j < $nb_style){
	if ($tab_style[$j] == $calendrierstyle)
		$pos_style_courant = $j;
	$j++;
}
$pos_style_courant++; 
if ($pos_style_courant >= $nb_style) $pos_style_courant = 0;
$calendrierstyle = $tab_style[$pos_style_courant];
setcookie ('calendrierstyle', $calendrierstyle, time()+31536000, '/', 'planete-couleurs.com', '0');
header("Location: $HTTP_REFERER");
?>
