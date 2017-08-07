<?php
//vim: set expandtab tabstop=4 shiftwidth=4:

// Copyright (C) 1999-2004 Tela Botanica (accueil@tela-botanica.org)
//
// Ce logiciel est un programme informatique servant � g�rer du contenu et des
// applications web.
                                                                                                      
// Ce logiciel est r�gi par la licence CeCILL soumise au droit fran�ais et
// respectant les principes de diffusion des logiciels libres. Vous pouvez
// utiliser, modifier et/ou redistribuer ce programme sous les conditions
// de la licence CeCILL telle que diffus�e par le CEA, le CNRS et l'INRIA 
// sur le site "http://www.cecill.info".

// En contrepartie de l'accessibilit� au code source et des droits de copie,
// de modification et de redistribution accord�s par cette licence, il n'est
// offert aux utilisateurs qu'une garantie limit�e.  Pour les m�mes raisons,
// seule une responsabilit� restreinte p�se sur l'auteur du programme,  le
// titulaire des droits patrimoniaux et les conc�dants successifs.

// A cet �gard  l'attention de l'utilisateur est attir�e sur les risques
// associ�s au chargement,  � l'utilisation,  � la modification et/ou au
// d�veloppement et � la reproduction du logiciel par l'utilisateur �tant 
// donn� sa sp�cificit� de logiciel libre, qui peut le rendre complexe � 
// manipuler et qui le r�serve donc � des d�veloppeurs et des professionnels
// avertis poss�dant  des  connaissances  informatiques approfondies.  Les
// utilisateurs sont donc invit�s � charger  et  tester  l'ad�quation  du
// logiciel � leurs besoins dans des conditions permettant d'assurer la
// s�curit� de leurs syst�mes et ou de leurs donn�es et, plus g�n�ralement, 
// � l'utiliser et l'exploiter dans les m�mes conditions de s�curit�. 

// Le fait que vous puissiez acc�der � cet en-t�te signifie que vous avez 
// pris connaissance de la licence CeCILL, et que vous en avez accept� les
// termes.
// ----
// CVS : $Id: bazar.admin.config.php,v 1.1 2007-02-02 14:01:20 alexandre_tb Exp $

/**
* Papyrus : Programme d'administration du bazar
*
* Fichier de configuration
*@package Bazar
//Auteur original :
*@author            Alexandre Granier <alexandre@tela-botanica.org>
*@copyright         Tela-Botanica 2000-2007
*@version           $Revision: 1.1 $
// +------------------------------------------------------------------------------------------------------+
*/
// +------------------------------------------------------------------------------------------------------+
// |                                            ENT�TE du PROGRAMME                                       |
// +------------------------------------------------------------------------------------------------------+

// BAZ_CHEMIN_APPLI : chemin vers l'application bazar METTRE UN SLASH (/) A LA FIN!!!!
define('BAZ_CHEMIN_APPLI', PAP_CHEMIN_RACINE.'client/bazar/');


// Variable action
define ('BAZ_VARIABLE_ACTION', 'action');

// +------------------------------------------------------------------------------------------------------+
// |                                            CONSTANTES D ACTION                                       |
// +------------------------------------------------------------------------------------------------------+

define ('BAZ_ACTION_VOIR_TEMPLATE', 1);


/* +--Fin du code ---------------------------------------------------------------------------------------+
* $Log: bazar.admin.config.php,v $
* Revision 1.1  2007-02-02 14:01:20  alexandre_tb
* version initiale beaucoup reste � faire
*
* +--Fin du code ----------------------------------------------------------------------------------------+
*/
?>