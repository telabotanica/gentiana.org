<?php
/*vim: set expandtab tabstop=4 shiftwidth=4: */ 
// +------------------------------------------------------------------------------------------------------+
// | PHP version 5.1                                                                                      |
// +------------------------------------------------------------------------------------------------------+
// | Copyright (C) 2006 Tela Botanica (accueil@tela-botanica.org)                                         |
// +------------------------------------------------------------------------------------------------------+
// | Ce logiciel est un programme informatique servant ï¿½ gï¿½rer du contenu et des applications web.        |                                                                           |
// |                                                                                                      |
// | Ce logiciel est rï¿½gi par la licence CeCILL soumise au droit franï¿½ais et respectant les principes de  | 
// | diffusion des logiciels libres. Vous pouvez utiliser, modifier et/ou redistribuer ce programme sous  |
// | les conditions de la licence CeCILL telle que diffusï¿½e par le CEA, le CNRS et l'INRIA sur le site    |
// | "http://www.cecill.info".                                                                            |
// |                                                                                                      |
// | En contrepartie de l'accessibilitï¿½ au code source et des droits de copie, de modification et de      |
// | redistribution accordï¿½s par cette licence, il n'est offert aux utilisateurs qu'une garantie limitï¿½e. |
// | Pour les mï¿½mes raisons, seule une responsabilitï¿½ restreinte pï¿½se sur l'auteur du programme, le       |
// | titulaire des droits patrimoniaux et les concï¿½dants successifs.                                      |
// |                                                                                                      |
// | A cet ï¿½gard l'attention de l'utilisateur est attirï¿½e sur les risques associï¿½s au chargement, ï¿½       |
// | l'utilisation,  ï¿½ la modification et/ou au dï¿½veloppement et ï¿½ la reproduction du logiciel par        |
// | l'utilisateur ï¿½tant donnï¿½ sa spï¿½cificitï¿½ de logiciel libre, qui peut le rendre complexe ï¿½ manipuler  |
// | et qui le rï¿½serve donc ï¿½ des dï¿½veloppeurs et des professionnels avertis possï¿½dant des connaissances  |
// | informatiques approfondies. Les utilisateurs sont donc invitï¿½s ï¿½ charger  et  tester  l'adï¿½quation   |
// | du logiciel ï¿½ leurs besoins dans des conditions permettant d'assurer la sï¿½curitï¿½ de leurs systï¿½mes   | 
// | et ou de leurs donnï¿½es et, plus gï¿½nï¿½ralement, ï¿½ l'utiliser et l'exploiter dans les mï¿½mes conditions  |
// | de sï¿½curitï¿½.                                                                                         |
// |                                                                                                      |
// | Le fait que vous puissiez accï¿½der ï¿½ cet en-tï¿½te signifie que vous avez pris connaissance de la       |
// | licence CeCILL, et que vous en avez acceptï¿½ les termes.                                              |
// +------------------------------------------------------------------------------------------------------+
// CVS : $Id $

// +------------------------------------------------------------------------------------------------------+
// |                                            ENTÊTE du PROGRAMME                                       |
// +------------------------------------------------------------------------------------------------------+
$GLOBALS['_GEN_commun']['info_applette_nom_fonction'] = 'afficherAttributsBody';
$GLOBALS['_GEN_commun']['info_applette_balise'] = '<!-- '.$GLOBALS['_GEN_commun']['balise_prefixe'].'BODY_ATTRIBUTS -->';


function afficherAttributsBody()
{
	global $_GEN_commun;

	$html = "";
	if(!isset($_GEN_commun['attributs_body']))
		return;
	foreach($_GEN_commun['attributs_body'] as $attribut => $valeur)
	{
		$html .= " ".$attribut.'="'.$valeur .'"';	 
	}
	return($html); 
}


?>