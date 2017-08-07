<?php
// +----------------------------------------------------------------------------+
// |recu_pdf.php												                |
// +----------------------------------------------------------------------------+
// | Copyright (c) 2003 Tela Botanica								            |
// +----------------------------------------------------------------------------+
// | Ce fichier g�n�re un fichier PDF                                           |
// | contenant le recu pour une cotisation � Tela Botanica                      |
// | Il utilise la librairie FPDF                                               |
// | http://www.fpdf.org/                                                       |
// |                                                                            |
// | Recoie $cotisation_id en parametre                                         |
// +----------------------------------------------------------------------------+
// | Auteur : Alexandre Granier <alexandre@tela-botanica.org> 	            	|
// +----------------------------------------------------------------------------+
//
// $Id: voir_recu_pdf.php,v 1.1 2005/09/22 14:02:49 ddelon Exp $


// Inclusion des fichiers n�cessaire � une connection
include_once ("../../papyrus/configuration/pap_config.inc.php") ;
include_once 'DB.php' ;

$db = DB::connect (PAP_DSN) ;

include_once "../../api/fpdf/fpdf.php";

$envoie = 1 ;

include_once "recu_pdf_corps.php" ;


// buffer est une propri�t� de la classe FPDF qui contient les donn�es au format PDF.
// habituellement on ne l'utilise pas, on appelle $pdf->Output() qui envoie les
// entete HTTP du document g�n�r�

$pdf->Output() ;

?>