<?php
/*vim: set expandtab tabstop=4 shiftwidth=4: */
// +------------------------------------------------------------------------------------------------------+
// | PHP version 4.3                                                                                      |
// +------------------------------------------------------------------------------------------------------+
// | Copyright (C) 2004 Tela Botanica (accueil@tela-botanica.org)                                         |
// +------------------------------------------------------------------------------------------------------+
// | This file is part of eFlore-consultation.                                                            |
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
// CVS : $Id: ef_langue_fr.inc.php,v 1.37 2007-08-02 22:13:41 jp_milcent Exp $
/**
* Fichier contenant les traductions de l'application.
*
* Contient des constantes permettant de traduire l'application eflore-consulation.
* Ici en : fr
*
*@package eFlore
*@subpackage Traductions
//Auteur original :
*@author        Linda ANGAMA <linda_angama@yahoo.fr>
//Autres auteurs :
*@author        Jean-Pascal MILCENT <jpm@tela-botanica.org>
*@copyright     Tela-Botanica 2000-2005
*@version       $Revision: 1.37 $ $Date: 2007-08-02 22:13:41 $
// +------------------------------------------------------------------------------------------------------+
*/

// +------------------------------------------------------------------------------------------------------+
// |                                            ENTETE du PROGRAMME                                       |
// +------------------------------------------------------------------------------------------------------+


// +------------------------------------------------------------------------------------------------------+
// |                                            CORPS du PROGRAMME                                        |
// +------------------------------------------------------------------------------------------------------+

// +------------------------------------------------------------------------------------------------------+
// TRANS MODULE
// +------------------------------------------------------------------------------------------------------+
// Traduction de textes g�n�rique
$GLOBALS['_EF_']['i18n']['_defaut_']['general']['titre_general'] = $GLOBALS['_EFLORE_']['titre'];
$GLOBALS['_EF_']['i18n']['_defaut_']['general']['symbole_obligatoire'] = '*';
$GLOBALS['_EF_']['i18n']['_defaut_']['general']['etc'] = '...';
$GLOBALS['_EF_']['i18n']['_defaut_']['general']['point'] = '.';
// +------------------------------------------------------------------------------------------------------+
// Le pied de page.
$GLOBALS['_EF_']['i18n']['_defaut_']['pied_page']['info'] = 'Si vous constatez des probl�mes en utilisant cette application, veuillez contacter : ';
$GLOBALS['_EF_']['i18n']['_defaut_']['pied_page']['mail'] = 'eflore_remarques@tela-botanica.org';

// +------------------------------------------------------------------------------------------------------+
// MODULE RECHERCHE
// +------------------------------------------------------------------------------------------------------+
// Page d'Accueil
$GLOBALS['_EF_']['i18n']['recherche']['accueil']['titre_nom'] = "Rechercher une plante par son nom";
$GLOBALS['_EF_']['i18n']['recherche']['accueil']['titre_taxon'] = "Consulter les plantes par genre/famille";

// +------------------------------------------------------------------------------------------------------+
// Formulaire de recherche Nomenclaturale
$GLOBALS['_EF_']['i18n']['recherche']['form_nom']['form_legende'] = 'Consultation nomenclaturale';
$GLOBALS['_EF_']['i18n']['recherche']['form_nom']['form_nom'] = 'Nom : ';
$GLOBALS['_EF_']['i18n']['recherche']['form_nom']['form_referentiel'] = 'R�f�rentiels';

// +------------------------------------------------------------------------------------------------------+
// Formulaire de recherche Taxonomique.
$GLOBALS['_EF_']['i18n']['recherche']['form_taxon']['form_titre'] = 'Consulter les plantes par genre/famille';
$GLOBALS['_EF_']['i18n']['recherche']['form_taxon']['form_titre_alphabet'] = 'Consultation par ordre alphab�tique';
$GLOBALS['_EF_']['i18n']['recherche']['form_taxon']['form_legende'] = 'Consultation taxonomique';
$GLOBALS['_EF_']['i18n']['recherche']['form_taxon']['form_referentiel'] = 'R�f�rentiel : ';
$GLOBALS['_EF_']['i18n']['recherche']['form_taxon']['form_rang'] = 'Rang :';
$GLOBALS['_EF_']['i18n']['recherche']['form_taxon']['form_projet'] = 'R�f�rentiels';
$GLOBALS['_EF_']['i18n']['recherche']['form_taxon']['form_valider'] = 'Rechercher';

// +------------------------------------------------------------------------------------------------------+
// Moteur de recherche Taxonomie.
$GLOBALS['_EF_']['i18n']['recherche']['recherche_taxon']['titre_info'] = 'Informations';
$GLOBALS['_EF_']['i18n']['recherche']['recherche_taxon']['titre_taxon_trouve'] = 'Taxons trouv�s : ';

// +------------------------------------------------------------------------------------------------------+
// Moteur de recherche Nom Latin.
$GLOBALS['_EF_']['i18n']['recherche']['recherche_nom_latin']['titre_nom_trouve'] = 'Noms trouv�s : ';
$GLOBALS['_EF_']['i18n']['recherche']['recherche_nom_latin']['titre_info'] = 'Informations';
$GLOBALS['_EF_']['i18n']['recherche']['recherche_nom_latin']['orthographe'] = 'Essayez avec cette orthographe : ';

// +------------------------------------------------------------------------------------------------------+
// Moteur de recherche Nom Venaculaire.
$GLOBALS['_EF_']['i18n']['recherche']['recherche_nom_verna']['titre_nom_trouve'] = 'Noms communs trouv�s : ';
$GLOBALS['_EF_']['i18n']['recherche']['recherche_nom_verna']['titre_info'] = 'Informations';
$GLOBALS['_EF_']['i18n']['recherche']['recherche_nom_verna']['orthographe'] = 'Essayez avec cette orthographe : ';
$GLOBALS['_EF_']['i18n']['recherche']['recherche_nom_verna']['table_resumer'] = 'Information sur les noms communs poss�dant une correspondance avec le radical';
$GLOBALS['_EF_']['i18n']['recherche']['recherche_nom_verna']['table_titre'] = 'Liste des noms communs correspondant au radical recherch�';
$GLOBALS['_EF_']['i18n']['recherche']['recherche_nom_verna']['numero'] = 'N�';
$GLOBALS['_EF_']['i18n']['recherche']['recherche_nom_verna']['langue'] = 'Langue';
$GLOBALS['_EF_']['i18n']['recherche']['recherche_nom_verna']['pays'] = 'Pays';
$GLOBALS['_EF_']['i18n']['recherche']['recherche_nom_verna']['nom_commun'] = 'Nom commun';
$GLOBALS['_EF_']['i18n']['recherche']['recherche_nom_verna']['nom_latin'] = 'Nom latin correspondant';

// +------------------------------------------------------------------------------------------------------+
// Onglets
$GLOBALS['_EF_']['i18n']['recherche']['onglet']['accueil'] = 'Recherche';
$GLOBALS['_EF_']['i18n']['recherche']['onglets']['accueil'] = $GLOBALS['_EF_']['i18n']['recherche']['onglet']['accueil'];
$GLOBALS['_EF_']['i18n']['recherche']['onglet']['info_projet'] = 'Source des donn�es';
$GLOBALS['_EF_']['i18n']['recherche']['onglets']['info_projet'] = $GLOBALS['_EF_']['i18n']['recherche']['onglet']['info_projet'];
$GLOBALS['_EF_']['i18n']['recherche']['onglet']['aide'] = 'Aide';
$GLOBALS['_EF_']['i18n']['recherche']['onglets']['aide'] = $GLOBALS['_EF_']['i18n']['recherche']['onglet']['aide'];

// +----------------------------------------------------------------------------------------------------+
// MODULE FICHE 
// +------------------------------------------------------------------------------------------------------+
// Fiche : g�n�ral
$GLOBALS['_EF_']['i18n']['fiche']['titre'] = '%taxon% - Taxon n�%nt% - %projet% v%version%';
$GLOBALS['_EF_']['i18n']['fiche']['titre_fichier'] = '%taxon%';

// Fiche : synthese
$GLOBALS['_EF_']['i18n']['fiche']['synthese']['titre_code'] = 'Codes nom s�lectionn�';
$GLOBALS['_EF_']['i18n']['fiche']['synthese']['titre_illustration'] = 'Illustration';
$GLOBALS['_EF_']['i18n']['fiche']['synthese']['titre_classification'] = 'Classification';
$GLOBALS['_EF_']['i18n']['fiche']['synthese']['titre_chorologie'] = 'R�partition';
$GLOBALS['_EF_']['i18n']['fiche']['synthese']['titre_nomenclature'] = 'Nomenclature';
$GLOBALS['_EF_']['i18n']['fiche']['synthese']['titre_nom_verna'] = 'Noms Communs';
$GLOBALS['_EF_']['i18n']['fiche']['synthese']['titre_xper'] = 'Outil de d�termination';
$GLOBALS['_EF_']['i18n']['fiche']['synthese']['titre_xper_lien'] = 'XPER�';
$GLOBALS['_EF_']['i18n']['fiche']['synthese']['xper_base_intitule'] = 'Base de connaissance XPER� : ';
$GLOBALS['_EF_']['i18n']['fiche']['synthese']['titre_correspondance'] = 'Correspondances';

// Fiche : synonymie
$GLOBALS['_EF_']['i18n']['fiche']['synonymie']['nom_selec'] = 'Nom s�lectionn�';
$GLOBALS['_EF_']['i18n']['fiche']['synonymie']['nom_retenu'] = 'Nom retenu';

$GLOBALS['_EF_']['i18n']['fiche']['synonymie']['basio'] = 'Ce nom est un basionyme';
$GLOBALS['_EF_']['i18n']['fiche']['synonymie']['auteur'] = 'Auteur(s)';
$GLOBALS['_EF_']['i18n']['fiche']['synonymie']['annee'] = 'Ann�e';
$GLOBALS['_EF_']['i18n']['fiche']['synonymie']['auteur_in_title'] = "Auteur, r�dacteur ou �diteur de l'ouvrage, souvent collectif, dans lequel le nom a �t� publi�.";
$GLOBALS['_EF_']['i18n']['fiche']['synonymie']['auteur_in'] = 'Auteur "in"';
$GLOBALS['_EF_']['i18n']['fiche']['synonymie']['ref_biblio'] = 'R�f�rence bibliographique';
$GLOBALS['_EF_']['i18n']['fiche']['synonymie']['comm_nom'] = 'Commentaires nomenclaturaux';
$GLOBALS['_EF_']['i18n']['fiche']['synonymie']['basio_nom_selec'] = 'Basionyme du nom s�lectionn�';

$GLOBALS['_EF_']['i18n']['fiche']['synonymie']['nn_acro_title'] = 'Num�ro nomenclatural : ';
$GLOBALS['_EF_']['i18n']['fiche']['synonymie']['nt_acro_title'] = 'Num�ro taxonomique : ';

$GLOBALS['_EF_']['i18n']['fiche']['synonymie']['st_nr'] = 'Statut non renseign�';
$GLOBALS['_EF_']['i18n']['fiche']['synonymie']['st_i'] = 'Statut inconnu';
$GLOBALS['_EF_']['i18n']['fiche']['synonymie']['st_p'] = 'Statut posant probl�me';
$GLOBALS['_EF_']['i18n']['fiche']['synonymie']['st'] = 'Synonymes taxonomiques';
$GLOBALS['_EF_']['i18n']['fiche']['synonymie']['sn'] = 'Synonymes nomenclaturaux';
$GLOBALS['_EF_']['i18n']['fiche']['synonymie']['si'] = 'Synonymes ind�termin�s';
$GLOBALS['_EF_']['i18n']['fiche']['synonymie']['sid'] = 'Synonymes "inclu dans"';
$GLOBALS['_EF_']['i18n']['fiche']['synonymie']['sasd'] = 'Synonymes "au sens de (sensu)"';
$GLOBALS['_EF_']['i18n']['fiche']['synonymie']['sp'] = 'Synonymes provisoire';

// Fiche : informations
$GLOBALS['_EF_']['i18n']['fiche']['information']['titre_nom'] = 'Nom s�lectionn� : ';
$GLOBALS['_EF_']['i18n']['fiche']['information']['titre_taxon'] = 'Taxon : ';
$GLOBALS['_EF_']['i18n']['fiche']['information']['titre_legende'] = 'L�gende : ';

$GLOBALS['_EF_']['i18n']['fiche']['information']['BDNBE']['sv'] = 'Strat�gie de vie';
$GLOBALS['_EF_']['i18n']['fiche']['information']['BDNBE']['catminat'] = 'Code Catminat';
$GLOBALS['_EF_']['i18n']['fiche']['information']['BDNBE']['syntaxon'] = 'Syntaxon';
$GLOBALS['_EF_']['i18n']['fiche']['information']['BDNBE']['idiotaxon'] = 'Idiotaxon';

$GLOBALS['_EF_']['i18n']['fiche']['information']['BDNFF']['typus'] = 'Typus';
$GLOBALS['_EF_']['i18n']['fiche']['information']['BDNFF']['num_parent_01'] = "Num�ro nomenclatural du parent n�1 de l'hybride";
$GLOBALS['_EF_']['i18n']['fiche']['information']['BDNFF']['nom_parent_01'] = "Nom du parent n�1 de l'hybride";
$GLOBALS['_EF_']['i18n']['fiche']['information']['BDNFF']['doute_parent_01'] = "Remarque sur le parent n�1 de l'hybride";
$GLOBALS['_EF_']['i18n']['fiche']['information']['BDNFF']['num_parent_02'] = "Num�ro nomenclatural du parent n�2 de l'hybride";
$GLOBALS['_EF_']['i18n']['fiche']['information']['BDNFF']['nom_parent_02'] = "Nom du parent n�2 de l'hybride";
$GLOBALS['_EF_']['i18n']['fiche']['information']['BDNFF']['doute_parent_02'] = 'Remarque sur le parent n�2 de l\'hybride';
$GLOBALS['_EF_']['i18n']['fiche']['information']['BDNFF']['classif'] = 'Classification';
$GLOBALS['_EF_']['i18n']['fiche']['information']['BDNFF']['legende']['classif'] = "LISTE;
1 = Pteridophytes; 2 = Gymnospermes; 3 = Monocotyl�dones; 4 = Dicotyl�dones";
$GLOBALS['_EF_']['i18n']['fiche']['information']['BDNFF']['corrections'] = 'Corrections';
$GLOBALS['_EF_']['i18n']['fiche']['information']['BDNFF']['2n'] = 'Nombre de chromosomes (2n)';
$GLOBALS['_EF_']['i18n']['fiche']['information']['BDNFF']['flores'] = 'Flores';
$GLOBALS['_EF_']['i18n']['fiche']['information']['BDNFF']['legende']['flores'] = "LISTE;
1 = BONNIER & LAYENS, 1894. Tables synoptiques des plantes vasculaires de la flore de France.; 
2 = COSTE, 1899-1906. Flore illustr�e France, (3 vol.).; 
3 = FOURNIER, 1934-1940. Quatre Flores de France.; 
3* = FOURNIER, additions dans l'�dition de 1961.; 
4 = TUTIN & al., 1964-1980. Flora Europaea, (5 vol.).;
4* = Flora Europaea, �dition 2 (Vol. 1), voir TUTIN & al. (1993), abr�g�e en FE2. L'indication est surtout 
donn�e quand la citation n'a pas �t� faite dans 4 (suppl�mentaire ou modifi�e).; 
5 = GUINOCHET & VILMORIN, 1973-1984. Flore de France, �d. C.N.R.S., (5 vol.).;
6 = KERGU�LEN, 1993. Liste synonymique de la flore de France.";
$GLOBALS['_EF_']['i18n']['fiche']['information']['BDNFF']['indic_geo'] = 'Indication g�ographique';
$GLOBALS['_EF_']['i18n']['fiche']['information']['BDNFF']['legende']['indic_geo'] = "LISTE;
Co = taxon pr�sent en Corse (Corsica); 
Ga = taxon pr�sent en France (Gallia).; 
GaA = taxons adventices; 
GaC ou C = taxons cultiv�s; 
GaD = taxons �teints ou disparus; 
GaE = taxons � exclure, absents de France; 
GaI = pr�sence incertaine ou douteuse; 
GaN = taxons naturalis�s; 
J = taxons pr�sents uniquement dans les jardins";
$GLOBALS['_EF_']['i18n']['fiche']['information']['BDNFF']['combinaison_importe'] = 'Combinaison de Kerguelen';
$GLOBALS['_EF_']['i18n']['fiche']['information']['BDNFF']['nom_officiel_importe'] = 'Nom retenu par Kerguelen';
$GLOBALS['_EF_']['i18n']['fiche']['information']['BDNFF']['maj_bb'] = 'Date de mise � jour (BB)';
$GLOBALS['_EF_']['i18n']['fiche']['information']['BDNFF']['maj_modif'] = 'Date de mise � jour';
$GLOBALS['_EF_']['i18n']['fiche']['information']['BDNFF']['maj_creation'] = 'Date de cr�ation';
$GLOBALS['_EF_']['i18n']['fiche']['information']['BDNFF']['num_flora_helvetica'] = 'Flora Helvetica - code';
$GLOBALS['_EF_']['i18n']['fiche']['information']['BDNFF']['rem_flora_helvetica'] = 'Flora Helvetica - remarques';
$GLOBALS['_EF_']['i18n']['fiche']['information']['BDNFF']['num_fournier'] = 'Flore de Fournier - code';
$GLOBALS['_EF_']['i18n']['fiche']['information']['BDNFF']['rem_fournier'] = 'Flore de Fournier - remarques';
$GLOBALS['_EF_']['i18n']['fiche']['information']['BDNFF']['num_cnrs'] = 'Flore du CNRS - code';
$GLOBALS['_EF_']['i18n']['fiche']['information']['BDNFF']['rem_cnrs'] = 'Flore du CNRS - remarques';
$GLOBALS['_EF_']['i18n']['fiche']['information']['BDNFF']['num_flora_europaea'] = 'Flora Europaea - code';
$GLOBALS['_EF_']['i18n']['fiche']['information']['BDNFF']['rem_flora_europaea'] = 'Flore Europaea - remarques';
$GLOBALS['_EF_']['i18n']['fiche']['information']['BDNFF']['num_bonnier'] = 'Flore de Bonnier - code';
$GLOBALS['_EF_']['i18n']['fiche']['information']['BDNFF']['rem_bonnier'] = 'Flore de Bonnier - remarques';
$GLOBALS['_EF_']['i18n']['fiche']['information']['BDNFF']['num_coste'] = 'Flore de Coste - code';
$GLOBALS['_EF_']['i18n']['fiche']['information']['BDNFF']['rem_coste'] = 'Flore de Coste - remarques';
$GLOBALS['_EF_']['i18n']['fiche']['information']['BDNFF']['nom_complet'] = 'Nom complet BDNFF';
$GLOBALS['_EF_']['i18n']['fiche']['information']['BDNFF']['formule_hybridation'] = 'Formule d\'hybridation';
$GLOBALS['_EF_']['i18n']['fiche']['information']['BDNFF']['num_meme_type'] = 'Num�ro du m�me type';
$GLOBALS['_EF_']['i18n']['fiche']['information']['BDNFF']['presence_france'] = 'Pr�sence en France';
$GLOBALS['_EF_']['i18n']['fiche']['information']['BDNFF']['legende']['presence_france'] = "LISTE;
0 = absent;
1 = pr�sence (indig�ne ou naturalis�); 
2 = adventice ou probable; 
3 = taxon (seulement) cultiv� en France (ex. : Ma�s); 
4 = Manque d'information";
$GLOBALS['_EF_']['i18n']['fiche']['information']['BDNFF']['taxon_reel'] = 'Taxon r�el';
$GLOBALS['_EF_']['i18n']['fiche']['information']['BDNFF']['legende']['taxon_reel'] = "LISTE;
0 = genre (exemple : Carex sp.); 
1 = taxon retenu sans rang inf�rieur; 
2 = taxon retenus dont il existe plusieurs rangs inf�rieurs existants; 
3 = taxon dont il existe un seul taxon de rang inf�rieur  
(exemple: Agrostemma githago vaut 3, Agrostemma githago subsp. githago vaut 1)";
$GLOBALS['_EF_']['i18n']['fiche']['information']['BDNFF']['page_flore_belge_ed5'] = 'Page Flore Belge ed. 5';

$GLOBALS['_EF_']['i18n']['fiche']['information']['BDNFM']['statut_nom'] = 'Statut du nom du taxon';
$GLOBALS['_EF_']['i18n']['fiche']['information']['BDNFM']['legende']['statut_nom'] = "LISTE ; 
DEFINITION = Symbole pr�cisant le statut de validit� du nom du taxon dans la base. Ce champ est r�serv� aux seuls noms valides ou consid�r�s provisoirement comme tels, � l'exclusion donc de tous les synonymes.En conformit� avec le standard international TDWG mais sur une base �largie, sept cas sont possibles :;
A = le taxon pr�sent � la R�union est rapport� avec certitude � un taxon reconnu. Le nom valide retenu est le 
'nom accept�' pour le taxon sur une base taxonomique et nomenclaturale fiable.;
T = le taxon pr�sent � la R�union est rapport� avec certitude � un taxon reconnu, mais dont le statut taxonomique 
et nomenclatural est en cours d'�volution ou a �t� remis en cause r�cemment. Le nom valide retenu est le 
'nom provisoirement accept�' pour le taxon. Ce cas implique donc une situation transitoire en attente d'informations 
taxonomiques et nomenclaturales concluantes.;
C = le taxon pr�sent � la R�union est rapport� avec incertitude [rapport en cf. (confer)] � un taxon reconnu.;
F = le taxon pr�sent � la R�union est rapproch� d'un taxon reconnu, sans toutefois pouvoir �tre assimil� � ce taxon 
sur la base des connaissances actuelles [cas des affinit�s taxonomiques : � aff. � (affinis)]. ;
N = le taxon n'a pu �tre rapport� ou rapproch� d'un taxon connu et repr�sente probablement une entit� taxonomique 
nouvelle restant � d�crire. ;
D = le taxon est douteux et par cons�quence le nom valide retenu pour le taxon est luim�me
douteux. Ce cas implique une mention provisoire en attente d'informations taxonomiques et nomenclaturales nouvelles. ;
0 = le statut du nom n'a pas �t� analys�.;
Remarque = Ce champ permet �galement d'identifier de mani�re positive les noms valides 
(ou, � d�faut, consid�r�s ou utilis�s provisoirement comme tels) des taxons de l'Index.";
$GLOBALS['_EF_']['i18n']['fiche']['information']['BDNFM']['ordre_revision'] = 'Ordre de r�vision';
$GLOBALS['_EF_']['i18n']['fiche']['information']['BDNFM']['legende']['ordre_revision'] = 
"Num�ro d'ordre chronologique de r�vision de la ligne nomenclaturale.
La num�rotation des r�visions a pris effet avec l'�dition de la premi�re version de l'Index
(30/06/2003). Les noms non r�vis�s de cette premi�re version ne poss�dent pas de cote de r�vision.
Les nouveaux noms introduits depuis la premi�re version sont cot�s '0'.";
$GLOBALS['_EF_']['i18n']['fiche']['information']['BDNFM']['date_revision'] = 'Date de r�vision';
$GLOBALS['_EF_']['i18n']['fiche']['information']['BDNFM']['legende']['date_revision'] =
"Date de la derni�re r�vision de la ligne nomenclaturale, correspondant au num�ro d'ordre
donn� par le champ � Ordre r�vision �.
Il n'y a pas d'archivage des donn�es (date, auteur) concernant les r�visions pr�c�dentes.
La date est donn�e sous format � huit chiffres sans s�parateur de type � ann�e/mois/jour �.
Exemple : 20031214 pour le 14 d�cembre 2003.";
$GLOBALS['_EF_']['i18n']['fiche']['information']['BDNFM']['auteur_revision'] = 'Auteur de la r�vision';
$GLOBALS['_EF_']['i18n']['fiche']['information']['BDNFM']['legende']['auteur_revision'] =
"LISTE;
DEFINITION = Auteur de la derni�re r�vision de la ligne nomenclaturale, correspondant au num�ro d'ordre
donn� par le champ � Ordre r�vision �.
Il n'y a pas d'archivage des donn�es (date, auteur) concernant les r�visions pr�c�dentes.
Les auteurs sont entr�s par code � deux lettres. Les codes actuellement disponibles sont les
suivants :;
VB = Vincent BOULLET";
$GLOBALS['_EF_']['i18n']['fiche']['information']['BDNFM']['ordre_general'] = 'Ordre g�n�ral';
$GLOBALS['_EF_']['i18n']['fiche']['information']['BDNFM']['legende']['ordre_general'] = "LISTE;
DEFINITION = Num�ro d' ordre des noms de taxon suivant le classement alphab�tique des noms valides,
avec pr�sentation hi�rarchique des synonymes sous les noms valides. Cette cl� de tri permet de
pr�senter les synonymes sous les noms valides auxquels ils se r�f�rent.
La hi�rarchisation de pr�sentation des synonymes est en principe la suivante : basionyme du
nom valide (s'il y a lieu), synonymes nomenclaturaux du nom valide par ordre chronologique,
synonymes taxonomiques par ordre chronologique (avec par ordre secondaire, le basionyme, puis les
synonymes nomenclaturaux).;
Remarque  = Ce num�ro d'ordination est variable. Il est remis � jour � chaque introduction nouvelle de
ligne nomenclaturale ou � chaque r�vision nomenclaturale.";
$GLOBALS['_EF_']['i18n']['fiche']['information']['BDNFM']['type_synonymie'] = 'Type de synonymie';
$GLOBALS['_EF_']['i18n']['fiche']['information']['BDNFM']['legende']['type_synonymie'] = "LISTE;
DEFINITION = Cl� de synonymie permettant � la fois de marquer les synonymes et de pr�ciser, selon le code
utilis�, le type de synonyme (cl� utilis�e uniquement pour les noms non valides).
Codification utilis�e :;
a = antonyme (synonyme exclu).;
b = basionyme (synonyme porteur du nom ou de l' �pith�te).;
i = isonyme (synonyme de m�me nom bas� sur le m�me type) [sauf exception, les isonymes ne sont pas pris en compte].;
n = synonyme nomenclatural (ou homotypique) sensu lato (nom bas� sur le m�me type).;
o = variant orthographique (variant orthographique incorrect d'un nom).;
p = pseudonyme (synonyme par m�susage du nom).;
s = synonyme nomenclatural ou taxonomique non diff�renci� (basionymes exclus).;
t = synonyme taxonomique (ou h�t�rotypique) (nom bas� sur un type diff�rent).;
? = synonyme de type ind�termin�.;
nn = synonyme nomenclatural de m�me rang (synonyme nomenclatural sensu stricto). ;
nr = synonyme nomenclatural de rang diff�rent.;
tb = basionyme du synonyme taxonomique. ;
tn = synonyme nomenclatural du synonyme taxonomique. ;
to = variant orthographique du synonyme taxonomique.;
Remarque = Les noms in�dits en cours de publication n'apparaissent pas dans les versions diffus�es.
Le code de synonymie � u � leur est attribu� dans la version m�re de l'index.";
$GLOBALS['_EF_']['i18n']['fiche']['information']['BDNFM']['famille_optionnelle'] = 'Famille optionnelle';
$GLOBALS['_EF_']['i18n']['fiche']['information']['BDNFM']['legende']['famille_optionnelle'] = 
"Autre famille � laquelle le taxon pourrait �tre rapport�. Il s'agit d'un second choix de traitement
syst�matique, la priorit� �tant donn�e par le choix princeps figurant dans le champ � Famille �. Cette
information est �galement donn�e aussi bien pour les noms valides que pour les synonymes.
Pour certains groupes, le traitement syst�matique est loin d' �tre stabilis� notamment � la
lumi�re d' �tudes phylog�n�tiques d' interpr�tation variable ou parfois contradictoires. Il en r�sulte des
opinions souvent variables quant aux concepts de famille sans qu' il soit toujours possible d' �tayer plus
fortement un choix qu' un autre. Dans ce cas, comme il est n�cessaire dans une base de donn�es de
donner une priorit�, le champ � Autre famille � permet de noter un autre traitement syst�matique
convenable pour la famille.
Remarque - Le nom de la famille est donn� sans autorit�.";
$GLOBALS['_EF_']['i18n']['fiche']['information']['BDNFM']['choro_distribution_generale'] = 'Distribution mondiale du taxon';
$GLOBALS['_EF_']['i18n']['fiche']['information']['BDNFM']['legende']['choro_distribution_generale'] = "LISTE;
DEFINITION = Distribution mondiale du taxon.
Lorsque une aire d'origine s'est ensuite �tendue, celleci est cit�e pr�alablement. La
codification de la pr�sentation et des contr�es g�ographiques est en cours d'�tablissement et la
pr�sente version n'a pas �t� homog�n�is�e de ces points de vue.
Certains codes ou abr�viations ont �t� syst�matiquement utilis�s : Af. (Afrique), Am.
(Am�rique), As. (Asie), Eur. (Europe), C (centre), E(est), N (nord), S (sud), W (ouest). Un � ? � indique
une hypoth�se ou un doute.
Les premi�res sources d' information ont �t� principalement la � Flore des Mascareignes [BOSSER & al. 1976(2005)] � 
et ses manuscrits pr�paratoires pour les volumes non parus, � The PlantBook (MABBERLEY 1997) �. 
Celles-ci ont cependant �t� enti�rement r�vis�es en fonction de l'�volution des traitements taxonomiques et 
syst�matiques de l'Index. De nombreuses sources sont alors utilis�es en fonction des cas, sans qu' il soit 
possible de les citer ici.
Les abr�viations suivantes sont utilis�es :;
adv. = adventice;
Af. = Afrique;
alim. = alimentaire;
Am. = Am�rique;
antarct. = antarctique;
appart. = appartement;
arct. = arctique;
arom. = aromatique;
artif. = artificielle;
As. = Asie;
Austr. = Australie;
C = Centre;
c�r�al. = c�r�alier;
Circumm�d. = r�gion circumm�diterran�enne;
condim. = condimentaire;
contin. = continental;
cosmop. = cosmopolite;
couv. = couverture;
cult. = culture;
cv. = cultivar;
E = Est;
essent. = essentiellement;
E.U. = �tatsUnis;
Eur. = Europe;
forest. = forestier;
fourr. = fourrage;
fruit. = fruitier;
h�misph. = h�misph�re;
Himal. = Himalaya;
hort. = horticole;
hum. = humide;
Ind. = Indien;
Indon. = Indon�sie;
indust. = industriel;
introd. = introduit;
larg. = largement;
l�gum. = l�gumier;
litt. = littoral;
Macaron. = Macaron�sie;
Madag. = Madagascar;
Mascar. = Mascareignes;
m�dic. = m�dicinal;
M�dit = M�diterran�e;
m�rid. = m�ridional;
mont. = montagne;
Mozamb. = Mozambique;
N = Nord;
nat. = naturalis�;
nbx = nombreux;
NE = NordEst;
n�otrop. = n�otropical;
Nouv.-Cal. = Nouvelle-Cal�donie;
Nouv.-Galles = Nouvelle-Galles;
Nouv.-Guin�e = Nouvelle-Guin�e;
Nouv.-H�b. = Nouvelles-H�brides;
Nouv.-Z�l. = NouvelleZ�lande;
NW = NordOuest;
Oc. (ou oc.) = oc�an;
orig. = origine ou;
orig. cult. = origine;
orn. = ornemental;
Pacif. = Pacifique;
pal�osubtrop. = pal�osubtropical;
pal�otrop. = pal�otropical;
pantrop. = pantropical;
Philipp. = Philippines;
Polyn. = Polyn�sie;
princip. = principalement;
prob. = probable;
r�g. = r�gion";
$GLOBALS['_EF_']['i18n']['fiche']['information']['BDNFM']['choro_diversite'] = 'Diversit�';
$GLOBALS['_EF_']['i18n']['fiche']['information']['BDNFM']['legende']['choro_diversite'] = 
"Indication du nombre de taxons de rang principal inf�rieur reconnu pour le taxon consid�r�.
Pour un genre, cas le plus fr�quent, il s'agit du nombre d'esp�ces du genre.
Compte tenu des incertitudes et des donn�es variables disponibles pour ces informations, une
notation, tenant compte de cette variabilit� et du poids plus ou moins important des donn�es selon
leur source, a �t� adopt�e.
D'une mani�re g�n�rale, pour beaucoup de genres tropicaux, la diversit� sp�cifique est
rarement connue avec pr�cision et le symbole � � � (= � plus ou moins �) a souvent �t� utilis� pour
exprimer ces approximations. Les valeurs extr�mes, lorsqu'elles sont pertinentes, figurent entre
parenth�ses et encadrent la (ou les) valeur(s) retenue(s) comme �tant la (ou les) plus probable(s) ;
exemple : (50)6580(100).
L'absence de variabilit� infrataxonomique connue est not�e  � 0 �.";
$GLOBALS['_EF_']['i18n']['fiche']['information']['BDNFM']['statut_general_reu'] = "Statut global d'indig�nat ou d'introduction";
$GLOBALS['_EF_']['i18n']['fiche']['information']['BDNFM']['legende']['statut_general_reu'] = "LISTE;
DEFINITION = Statut global d'indig�nat ou d'introduction du taxon � la R�union, int�grant � la fois les
populations spontan�es et les populations cultiv�es.
Le statut g�n�ral R�union est applicable � tous les taxons de l'Index. Il est aussi appliquable
La typologie de statut d' indig�nat ou d'introduction des taxons, adopt�e ici, s'appuie 
principalement � l'origine sur le syst�me de statuts et de traitement des plantes �trang�res
(x�nophytes) de E.J. CLEMENT et M.C. FOSTER (Aliens Plants of the British Isles, 1994) et le
syst�me de statuts des index de r�f�rences de la flore vasculaire du Nord/PasdeCalais,
de Picardie et de HauteNormandie (BOULLET 1998 et 1999) inspir� initialement de LAMBINON et al. (1993). Il a
�galement �t� tenu compte, notamment pour les notions d'indig�ne et d'�tranger, des mises au point
terminologiques r�centes d�velopp�es dans le contexte des plantes exotiques invasives
(RICHARDSON et al. 2000, PYS EK et al. 2004).;
I = indig�ne.;
K = cryptog�ne.;
Z = amphinaturalis� (ou assimil� indig�ne) [correspond grosso modo � la notion de � largement naturalis� �].;
N = st�nonaturalis� [correspond grosso modo � la notion de � localement naturalis� �].;
S = �tabli [correspond approximativement et en partie � la notion classique de subspontan�].;
R = persistant (ou r�manent).;
A = accidentel (ou casuel) (correspond approximativement � la notion classique d' adventice).;
Q = cultiv� (voir contenu, champ suivant).;
E = taxon cit� par erreur dans le territoire.;
? = indication compl�mentaire de statut douteux ou incertain se pla�ant soit seul (cas
des plantes � statut inconnu ou mal connu), soit apr�s le code de statut (I?, K?, Z?, N?, S?, A?, E?).;
?? = taxon dont la pr�sence est hypoth�tique dans le territoire (indication vague pour le
territoire, d�termination rapport�e en confert, ou encore pr�sence probable � confirmer en
absence de citation).";
$GLOBALS['_EF_']['i18n']['fiche']['information']['BDNFM']['statut_spontane_reu'] = 'Statut des populations spontan� � la R�union';
$GLOBALS['_EF_']['i18n']['fiche']['information']['BDNFM']['legende']['statut_spontane_reu'] = 
"Statut des populations spontan�es (statut spontan�) � la R�union, � l' exclusion du statut des
populations culturales (statut cultural).
Le statut spontan� R�union est applicable � tous les taxons de l'Index.
Par plante (ou population) spontan�e, on entend toute plante croissant en un lieu donn�
sans avoir �t� plant�e.
Pour les taxons poss�dant ou ayant poss�d� des populations spontan�es, les statuts et la
codification sont identiques au champ � Statut g�n�ral R�union �, le statut cultural en moins.
Pour les taxons uniquement connus � l'�tat cultural et les taxons cit�s par erreur, un code � 0 �
(= � nul �) est appliqu�.";
$GLOBALS['_EF_']['i18n']['fiche']['information']['BDNFM']['statut_cultural_reu'] = 'Statut des populations culturales � la R�union';
$GLOBALS['_EF_']['i18n']['fiche']['information']['BDNFM']['legende']['statut_cultural_reu'] = "LISTE;
DEFINITION = Statut des populations culturales (statut cultural) � la R�union, � l'exclusion du statut des
populations spontan�es (statut spontan�).
Le statut cultural R�union est applicable � tous les taxons de l'Index.
Le statut cultural s'appuie largement sur le syst�me de statuts des index de r�f�rences de la
flore vasculaire du Nord/PasdeCalais, de Picardie et de HauteNormandie (BOULLET 1998 et 2000).
Il comprend une subdivision du statut de cultiv� � Q � en quatre cat�gories dont les limites restent
parfois difficiles � appr�cier :;
G = cultiv� en grand (au moins localement) � des fins �conomiques de production agricole
[ex. : Saccharum officinale, Ananas comosum], sylvicole [ex. : Cryptomeria japonica] ou plus
rarement horticole (ex. : ?). Les situations actuelles et pass�es sont prises en compte dans la
cat�gorisation.;
H = cultiv� en grand (au moins localement) pour l'ornement [ex.: Agave veracruz,
Euphorbia pulcherrima], l'organisation des paysages [ex. : Grevillea robusta], la
cicatrisation paysag�re (�cran visuel...) ou encore la protection et la fixation des sols [ex.
: Khaya senegalensis], dans les espaces publics (notamment bords de routes) ou ruraux ; ces
plantes sont souvent aussi cultiv�es dans les jardins et les parcs.;
P = introduit (plant�, sem�) ponctuellement dans les espaces naturels et seminaturels.
Cette cat�gorie, pas toujours bien distincte des cat�gories H et C, est parfois d�licate �
appr�cier. Elle concerne des plantes ne faisant pas l'objet d'une plantation de masse mais
introduites de mani�re ponctuelle (sans d�veloppement spatial ou lin�aire cons�quent) � des
fins diverses (biodiversification, ornement, curiosit�, bornage, cyn�g�tique...). Elle concerne
aussi bien des taxons indig�nes [ex. : Ruizia cordata] que des x�nophytes. Dans le cas des
taxons indig�nes, de telles introductions sont souvent difficiles � d�tecter sur le terrain et
am�nent de nombreuses confusions. Un certain nombre de ces introductions de persistance
variable peuvent �ventuellement conduire � des naturalisations.;
C = cultiv� (culture courante � petite �chelle) dans les jardins, les parcs et les espaces
urbains, pour l'ornement [ex. : Pyrostegia venusta] ou le potager [ex. : Lablab purpureus].";
$GLOBALS['_EF_']['i18n']['fiche']['information']['BDNFM']['statut_endemicite'] = "Type d'end�micit� du taxon";
$GLOBALS['_EF_']['i18n']['fiche']['information']['BDNFM']['legende']['statut_endemicite'] = "LISTE;
DEFINITION = Type d'end�micit� du taxon dans l'ouest de l'oc�an Indien.
Cette information n'est prise en compte que si le taxon pr�sente � l'�tat indig�ne (ou
cryptog�ne), un caract�re end�mique reconnu dans la zone de l'oc�an Indien occidental.
L'�chelle d'end�micit� propos�e concerne prioritairement l' end�micit� stricte (R�union) et
l'end�micit� r�gionale (Mascareignes).
Une troisi�me �chelle d'end�micit� macror�gionale a �t� ajout�e en compl�ment des deux
pr�c�dentes. Elle concerne les taxons poss�dant une aire insulaire � Ouest Oc�an Indien � et est cod�e
� W �.;
0 = pas de caract�re end�mique reconnu dans la zone de l'oc�an Indien occidental (= � nul �). 
Doivent �tre �galement consid�r�s comme relevant de ce dernier cas, les taxons introduits dans l'ouest de 
l'oc�an Indien mais end�miques � l'�tat indig�ne d'une autre r�gion du monde.;
B = end�micit� stricte pour la R�union.;
M = end�micit� r�gionale (pr�sence au moins sur deux �les).; 
M3 = pr�sence sur les trois �les;
M2 = pr�sence sur deux �les; 
M2a = pr�sence R�union, Maurice;
M2b = pr�sence R�union, Rodrigues;
F = end�micit�s strictes et r�gionales pour Maurice;
R = end�micit�s strictes et r�gionales pour Rodrigues;
M2c = end�micit�s strictes et r�gionales pour Maurice et Rodrigues. Celles-ci
concernent certains taxons introduits � la R�union, ou bien de pr�sence
douteuse ou encore signal�s par erreur.
W2b = Madagascar et Mascareignes ;
W2d = Comores et Mascareignes ;
W2f = Seychelles et Mascareignes ;
W3a = Madagascar, Comores et Mascareignes ;
W3c = Madagascar, Seychelles et Mascareignes ;
W3d = Comores, Seychelles et Mascareignes ;
W4 = Madagascar, Comores, Seychelles et Mascareignes ;
C = Comores ;
G = Madagascar ;
S = Seychelles ";
$GLOBALS['_EF_']['i18n']['fiche']['information']['BDNFM']['combinaison_hybride'] = 'Combinaison hybride';
$GLOBALS['_EF_']['i18n']['fiche']['information']['BDNFM']['legende']['combinaison_hybride'] = 
"Indication des parents de l'hybride sous forme de combinaison hybride.
La pr�sentation se fait par ordre alphab�tique des parents, sauf en cas d'hybrides
unidirectionnels. Dans ce dernier cas, le parent m�le est donn� en premier. Les noms des parents
sont cit�s en entier avec leur autorit�. Ce champ concerne uniquement les hybrides.";
$GLOBALS['_EF_']['i18n']['fiche']['information']['BDNFM']['notes_generales'] = 'Notes g�n�rale';
$GLOBALS['_EF_']['i18n']['fiche']['information']['BDNFM']['legende']['notes_generales'] = 
"Champ d'expression libre pour toute note g�n�rale additionnelle utile, en compl�ment ou en
relation avec les th�matiques de la table (sauf les informations chromosomiques).
Elles peuvent concerner les taxons (notes taxonomiques) ou leurs noms (notes
nomenclaturales).
Les notes particuli�res � la R�union ne portant pas de caract�re g�n�ral pour le taxon ou le
nom concern� sont port�es dans une rubrique particuli�re intitul�e � Notes R�union �.";
$GLOBALS['_EF_']['i18n']['fiche']['information']['BDNFM']['notes_reu'] = 'Notes R�union';
$GLOBALS['_EF_']['i18n']['fiche']['information']['BDNFM']['legende']['notes_reu'] =
"Champ d' expression libre pour toute note additionnelle utile, concernant plus particuli�rement
la R�union, en compl�ment ou en relation avec les th�matiques de la table (sauf les informations
chromosomiques).
Les notes � caract�re g�n�ral sont � porter dans la rubrique intitul�e � Notes g�n�rales �.";
$GLOBALS['_EF_']['i18n']['fiche']['information']['BDNFM']['date_creation_nom'] = 'Date de cr�ation du nom';
$GLOBALS['_EF_']['i18n']['fiche']['information']['BDNFM']['legende']['date_creation_nom'] =
"Date de cr�ation de la ligne nomenclaturale.
La date est donn�e sous format � huit chiffres sans s�parateur de type � ann�e/mois/jour �.
Exemple : 20031214 pour le 14 d�cembre 2003.";
$GLOBALS['_EF_']['i18n']['fiche']['information']['BDNFM']['auteur_creation_nom'] = 'Auteur de la cr�ation du nom';
$GLOBALS['_EF_']['i18n']['fiche']['information']['BDNFM']['legende']['auteur_creation_nom'] =
"Cr�ateur de la ligne nomenclaturale.
Les auteurs sont entr�s par code � deux lettres. La codification est identique � celle du champ
� Auteur r�vision �.";
$GLOBALS['_EF_']['i18n']['fiche']['information']['BDNFM']['ancien_code_taxon'] = 'Ancien code du taxon';
$GLOBALS['_EF_']['i18n']['fiche']['information']['BDNFM']['legende']['ancien_code_taxon'] =
"Code taxon de la ligne taxonomique d�class�e.
Concerne uniquement des � taxons � pr�alablement identifi�s dans l'Index, mais trait�s
actuellement comme synonymes.";
$GLOBALS['_EF_']['i18n']['fiche']['information']['BDNFM']['date_suppression_nom'] = 'Date de suppression du nom';
$GLOBALS['_EF_']['i18n']['fiche']['information']['BDNFM']['legende']['date_suppression_nom'] =
"Date de suppression de la ligne nomenclaturale.
La date est donn�e sous format � huit chiffres sans s�parateur de type � ann�e/mois/jour �.
Exemple : 20031214 pour le 14 d�cembre 2003.";
$GLOBALS['_EF_']['i18n']['fiche']['information']['BDNFM']['auteur_suppression_nom'] = 'Auteur de la suppression du nom';
$GLOBALS['_EF_']['i18n']['fiche']['information']['BDNFM']['legende']['auteur_suppression_nom'] =
"Auteur de la suppression de la ligne nomenclaturale.
Les auteurs sont entr�s par code � deux lettres. La codification est identique � celle du champ
� Auteur r�vision �.";

// +------------------------------------------------------------------------------------------------------+
// Onglets
$GLOBALS['_EF_']['i18n']['fiche']['onglets']['synthese'] = 'Identit�';
$GLOBALS['_EF_']['i18n']['fiche']['onglets']['synonymie'] = 'Synonymie';
$GLOBALS['_EF_']['i18n']['fiche']['onglets']['vernaculaire'] = 'Noms communs';
$GLOBALS['_EF_']['i18n']['fiche']['onglets']['chorologie'] = 'R�partition';
$GLOBALS['_EF_']['i18n']['fiche']['onglets']['information'] = 'Informations';
$GLOBALS['_EF_']['i18n']['fiche']['onglets']['illustration'] = 'Illustrations';
$GLOBALS['_EF_']['i18n']['fiche']['onglets']['permalien'] = 'Permaliens';
$GLOBALS['_EF_']['i18n']['fiche']['onglets']['wiki'] = 'Vos donn�es';
$GLOBALS['_EF_']['i18n']['fiche']['onglets']['cel'] = 'Vos observations';

// +----------------------------------------------------------------------------------------------------+
// MODULE SAISIE
// +------------------------------------------------------------------------------------------------------+
// +------------------------------------------------------------------------------------------------------+
// Formulaire de saisie assit�e des noms
$GLOBALS['_EF_']['i18n']['saisie']['saisie_continue']['form_legende'] = 'Saisie de noms';
$GLOBALS['_EF_']['i18n']['saisie']['saisie_continue']['form_nom'] = 'Tapez votre nom : ';
$GLOBALS['_EF_']['i18n']['saisie']['saisie_continue']['form_referentiel'] = 'Choisissez un r�f�rentiel : ';

// +----------------------------------------------------------------------------------------------------+
// MODULE TRACKBACK
// +------------------------------------------------------------------------------------------------------+
$GLOBALS['_EF_']['i18n']['trackback']['url']['titre'] = 'Adresse pour le trackback';

// +----------------------------------------------------------------------------------------------------+
// MODULE OPENSEARCH
// +------------------------------------------------------------------------------------------------------+
$GLOBALS['_EF_']['i18n']['opensearch']['url']['titre'] = 'Moteur de recherche pour Firefox 2 et Internet Explorer 7';

// +----------------------------------------------------------------------------------------------------+
// MODULE RECUEIL DE DONNEES
// +------------------------------------------------------------------------------------------------------+
$GLOBALS['_EF_']['i18n']['recueildedonnees']['envoi_mail']['rcd_nom_latin'] = 'Nom latin';
$GLOBALS['_EF_']['i18n']['recueildedonnees']['envoi_mail']['rcd_date'] = 'Date';
$GLOBALS['_EF_']['i18n']['recueildedonnees']['envoi_mail']['rcd_commune'] = 'Commune';
$GLOBALS['_EF_']['i18n']['recueildedonnees']['envoi_mail']['rcd_lieudit'] = 'Lieu-dit';
$GLOBALS['_EF_']['i18n']['recueildedonnees']['envoi_mail']['rcd_commentaire'] = 'Localisation pr�cise, commentaires';
$GLOBALS['_EF_']['i18n']['recueildedonnees']['envoi_mail']['rcd_fuseau'] = 'Fuseau';
$GLOBALS['_EF_']['i18n']['recueildedonnees']['envoi_mail']['rcd_coord_x'] = 'Coordonn�e X';
$GLOBALS['_EF_']['i18n']['recueildedonnees']['envoi_mail']['rcd_coord_y'] = 'Coordonn�e Y';
$GLOBALS['_EF_']['i18n']['recueildedonnees']['envoi_mail']['rcd_courriel'] = 'Courriel';


/* +--Fin du code ----------------------------------------------------------------------------------------+
*
* $Log: ef_langue_fr.inc.php,v $
* Revision 1.37  2007-08-02 22:13:41  jp_milcent
* Compatibilit� nouveau module.
*
* Revision 1.36  2007-07-10 16:46:34  jp_milcent
* Ajout de traduction pour le RDD.
*
* Revision 1.35  2007-07-09 18:55:22  jp_milcent
* Ajout de valeur pour le module Recueil de donn�es.
*
* Revision 1.34  2007-06-01 13:23:05  jp_milcent
* Fusion avec livraison Moquin-Tandon : 01 juin 2007
*
* Revision 1.33  2007-04-10 09:13:38  ddelon
* Mise a jour libelle recherche
*
* Revision 1.32  2007/02/07 18:04:44  jp_milcent
* Fusion avec la livraison Moquin-Tandon.
*
* Revision 1.31  2007/01/24 16:33:55  jp_milcent
* Ajout titre opensearch.
*
* Revision 1.30.2.3  2007-05-23 10:39:16  ddelon
* libelle
*
* Revision 1.30.2.2  2007-05-13 14:20:30  ddelon
* Action carnet en ligne : maquette
*
* Revision 1.30.2.1  2007/04/10 09:05:32  ddelon
* Mise a jour libelle recherche
*
* Revision 1.30  2007/01/17 17:54:27  jp_milcent
* Fusion avec la livraison Passy avant nouvelle livraison.
*
* Revision 1.29  2007/01/12 14:40:19  jp_milcent
* Fin d'ajout des l�gendes pour la BDNFM.
*
* Revision 1.28  2007/01/11 19:01:44  jp_milcent
* D�but d'ajout des l�gendes pour la BDNFM.
*
* Revision 1.27  2007/01/05 18:21:01  jp_milcent
* Ajout de donn�es pour le module TrackBack.
*
* Revision 1.26  2006/12/27 14:09:21  jp_milcent
* Ajout de langue pour le module de saisie.
*
* Revision 1.25.2.1  2006/11/21 09:48:28  jp_milcent
* Correction faute de frappe.
*
* Revision 1.25  2006/11/17 14:46:37  jp_milcent
* Fusion n�2 avec la livraison Decaisne.
*
* Revision 1.21.2.4  2006/11/10 22:38:15  ddelon
* wiki eflore
*
* Revision 1.24  2006/11/15 18:32:32  jp_milcent
* Ajout des l�gendes de la BDNFF.
*
* Revision 1.23  2006/11/15 11:17:24  jp_milcent
* Ajout d'un titre pour les noms communs.
*
* Revision 1.22  2006/10/25 08:15:22  jp_milcent
* Fusion avec la livraison Decaisne.
*
* Revision 1.21.2.3  2006/09/04 14:22:07  jp_milcent
* Modification de quelques intitul�s pour les informations compl�mentaires de la BDNFF.
*
* Revision 1.21.2.2  2006/07/28 13:32:12  jp_milcent
* Correction probl�me du tableau langue pour st_nr.
*
* Revision 1.21.2.1  2006/07/27 14:11:31  jp_milcent
* R�cup�ration du titre depuis la variable globale.
*
* Revision 1.21  2006/07/24 13:42:44  jp_milcent
* Modification intitul� du nom de la base de connaissance.
*
* Revision 1.20  2006/07/24 13:27:48  jp_milcent
* Modification du titre sur les bases  de connaissances.
*
* Revision 1.19  2006/07/11 16:19:19  jp_milcent
* Int�gration de l'appllette Xper.
*
* Revision 1.18  2006/07/07 15:19:21  jp_milcent
* Correction de mise en page.
*
* Revision 1.17  2006/07/07 09:26:17  jp_milcent
* Modification selon les remarques de Daniel du 29 juin 2006.
* Changement de nom de classes abstraites.
*
* Revision 1.16  2006/07/05 15:12:00  jp_milcent
* Ajout de nouveaux labels.
*
* Revision 1.15  2006/05/11 10:28:26  jp_milcent
* D�but modification de l'interface d'eFlore pour la livraison Decaisne.
*
* Revision 1.14  2006/04/25 16:22:24  jp_milcent
* Ajout d'un onglet "informations" et modification de l'onglet "synonymie" pour afficher des donn�es txt li�es au nom s�lectionn�.
*
* Revision 1.13  2005/12/21 16:04:34  jp_milcent
* Utilisation d'un tableau pour les traductions � la place de constante.
* C'est plus souple et cela n'oblige pas � traduire un fichier complet.
*
* Revision 1.12  2005/12/01 15:45:58  ddelon
* orthographe
*
* Revision 1.11  2005/11/28 16:50:16  jp_milcent
* Ajout de constantes pour les urls de l'arbre des taxons.
*
* Revision 1.10  2005/11/23 18:07:23  jp_milcent
* D�but correction des bogues du module Fiche suite � mise en ligne eFlore Beta.
*
* Revision 1.9  2005/10/26 16:36:25  jp_milcent
* Am�lioration des pages Synth�ses, Synonymie et Illustrations.
*
* Revision 1.8  2005/09/28 16:29:31  jp_milcent
* D�but et fin de gestion des onglets.
* D�but gestion de la fiche Synonymie.
*
* Revision 1.7  2005/09/13 16:25:23  jp_milcent
* Fin de gestion des interfaces de recherche.
*
* Revision 1.6  2005/08/19 13:54:11  jp_milcent
* D�but de gestion de la navigation au sein de la classification.
*
* Revision 1.5  2005/08/11 10:15:49  jp_milcent
* Fin de gestion des noms verna avec requ�te rapide.
* D�but gestion choix aplhab�tique des taxons.
*
* Revision 1.4  2005/08/05 15:13:35  jp_milcent
* Gestion de l'affichage des r�sultats des recherches taxonomiques (en cours).
*
* Revision 1.3  2005/08/04 15:51:45  jp_milcent
* Impl�mentation de la gestion via DAO.
* Fin page d'accueil.
* Fin formulaire recherche taxonomique.
*
* Revision 1.2  2005/08/01 16:18:40  jp_milcent
* D�but gestion r�sultat de la recherche par nom.
*
* Revision 1.1  2005/07/26 16:27:29  jp_milcent
* D�but mise en place framework eFlore.
*
* Revision 1.1  2005/07/25 14:24:36  jp_milcent
* D�but appli de consultation simplifi�e.
*
*
* +-- Fin du code ----------------------------------------------------------------------------------------+
*/
?>