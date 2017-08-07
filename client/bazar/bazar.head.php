<?php
include_once 'configuration/baz_config.inc.php'; //fichier de configuration de Bazar

$requete = 'SELECT bn_id_nature, bn_label_nature FROM bazar_nature' ;
$resultat = $GLOBALS['_BAZAR_']['db']->query ($requete) ;
if (DB::isError($resultat)) {
	die ("Echec de la requete<br />".$resultat->getMessage()."<br />".$resultat->getDebugInfo()) ;
}
echo '<link rel="alternate" type="application/rss+xml" title="'.BAZ_TOUTES_LES_ANNONCES.'" href="http://'.$_SERVER['HTTP_HOST'].'/bazar/bazarRSS.php" />'."\n"; 
while ($ligne = $resultat->fetchRow(DB_FETCHMODE_ASSOC)) {
	echo '<link rel="alternate" type="application/rss+xml" title="'.$ligne['bn_label_nature'].'" href="http://'.$_SERVER['HTTP_HOST'].'/bazar/bazarRSS.php?annonce='.$ligne['bn_label_nature'].'" />'."\n";
}

?>
