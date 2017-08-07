<?
/* 	*****************************  classe arbre  ***********************************
*	class permettant la creation d'un arbre, elle est fonctionnelle en tant que module
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
************************************************************************************/

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

?>