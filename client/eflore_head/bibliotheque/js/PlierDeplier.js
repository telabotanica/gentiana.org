// These scripts were originally found on cooltype.com.
// Modified 01/01/1999 by Tobias Ratschiller for linuxapps.com
// Modified 7th June 2000 by Brian Birtles for Mozilla 5.0
// compatibility for phpMyAdmin
// Rewritten and put in a libray 2nd May 2001 by Lo?c Chapeaux
// Traduit en fran?ais et utilis? dans Tela-Botanica fin octobre 2000
// par Alexandre Granier et Jean-Pascal Milcent.
// Test r?ussi avec : (Test passed with:)
// - Mozilla 0.8.1, 0.9.0, 0.9.1, 0.9.2 for Windows (js enabled & disabled)
// - IE5, 5.01, 5.5 for Windows
// - Netscape 4.75 for Windows
// - Opera 8
// - Konqueror 3.3.2
// Test ?chou? avec : ((crappy DOM implementations) with:)
// - Opera 5.02 for windows: 'getElementsByTagName' is unsupported
// - Opera 5.10 to 5.12 for windows, Opera 5+ for Linux: 'style.display' can't be changed
// - Konqueror 2+: 'style.display' can't be changed

// inclusion intempestive
/**
 * Variables et test normalement pr?sente dans le fichier html dans le head entre 
 * des balises <script></script>
 */
var isDOM   = (typeof(document.getElementsByTagName) != 'undefined') ? 1 : 0;
var capable = (isDOM) ? 1 : 0;

var fontFamily = 'arial, geneva, sans-serif';
var isServer   = true;
var isExpanded = false;
var imgOpened  = new Image(9,9);
imgOpened.src  = 'http://www.tela-botanica.org/client/eflore_ancien/presentations/images/fermer.png';
imgOpened.alt  = '-';
imgOpened.title  = 'Cacher les informations compl?mentaires';
var imgClosed  = new Image(9,9);
imgClosed.src  = 'http://www.tela-botanica.org/client/eflore_ancien/presentations/images/ouvrir.png';
imgClosed.alt  = '+';
imgClosed.title  = 'Voir les informations compl&eacute;mentaires';

/**
 * Pliage des donn?es au d?marrage.
 * (Collapses databases at startup)
 * 
 * @access  public
 */
function toutPlier()
{
  if (!capable || !isServer) {
    return;
  }
  if (isDOM) {
    var tempColl    = document.getElementsByTagName('span');
    var tempCollCnt = tempColl.length;
    for (var i = 0; i < tempCollCnt; i++) {
      if (tempColl[i].id == expandedDb)
        tempColl[i].style.display = 'inline';
      else if (tempColl[i].className == 'child')
        tempColl[i].style.display = 'none';
    }
  }
}

/**
 * D?pliage de toutes les donn?es.
 * 
 * @access  public
 */
function toutDeplier()
{
  if (!capable || !isServer) {
    return;
  }
  if (isDOM) {
    var tempColl    = document.getElementsByTagName('span');
    var tempCollCnt = tempColl.length;
    for (var i = 0; i < tempCollCnt; i++) {
      if (tempColl[i].id == expandedDb)
        tempColl[i].style.display = 'inline';
      else if (tempColl[i].className == 'child')
        tempColl[i].style.display = 'inline';
    }
    // Fin du cas DOM (end of the DOM case)
  }
}

/**
 * Plier/D?plier les donn?es quand l'utilisateur le demande.
 * (Collapses/expands a database when the user require this to be done)
 *
 * @param  string  le nom de l'?l?ment ? activer (the  name of the room to act on)
 * @param  boolean si oui ou non le contenu des donn?es doit ?tre affich? (whether to expand or to collapse the database content)
 *
 * @access  public
 */
function expandBase(el, unexpand)
{
  if (!capable)
    return;
  
  if (isDOM) {
    var whichEl = document.getElementById(el + 'Child');
    var whichIm = document.getElementById(el + 'Img');
    if (whichEl.style.display == 'none' && whichIm) {
      whichEl.style.display  = 'inline';
      whichIm.src            = imgOpened.src;
      whichIm.alt            = imgOpened.alt;
      whichIm.title          = imgOpened.title;
    } else if (unexpand) {
      whichEl.style.display  = 'none';
      whichIm.src            = imgClosed.src;
      whichIm.alt            = imgClosed.alt;
      whichIm.title          = imgClosed.title;

    }
  }
} // fin de la fonction 'expandBase()' (end of the 'expandBase()' function)

/**
 * Affiche l'image permettant le Plier/D?plier
 *
 * @access  public
 */
function afficherImage(numero)
{
  with (document) {
    if (isDOM) {
      var image = '<img name="imEx" '+
                  'id="el'+numero+'Img" '+
                  'src="'+imgClosed.src+'" '+
                  'alt="'+imgClosed.alt+'" '+
                  'title="'+imgClosed.title+'" '+
                  'height="'+imgClosed.height+'" '+
                  'width="'+imgClosed.width+'" '+
                  'onclick="expandBase(\'el'+numero+'\',true); return false;" />';
      write(image);
    }
  }
} // fin de la fonction 'afficherImage()'

/**
 * Affiche une aide sur le Plier/D?plier
 *
 * @access  public
 */
function afficherAide()
{
  with (document) {
    if (isDOM) {
      var aide = 	'<p>Cliquer sur le symbole <img src="'+imgClosed.src+'"/> pour afficher les <strong>informations bibliographiques</strong>.<br />'+
					'<a href="#" onclick="toutPlier(); return false;">Tout plier</a> | <a href="#" onclick="toutDeplier(); return false;">Tout d&eacute;plier</a>'+
					'</p>';
      write(aide);
    }
  }
}

/**
 * Ajout des styles permettant le positionnement des calques.
 * Le style display est important pour afficher ou masquer les calques.
 * Les styles child et parent doivent ?tre utilis? pour les div du fichier html.
 * (Add styles for positioned layers)
 */
if (capable) {
  with (document) {
    // Brian Birtles : This is not the ideal method of doing this
    // but under the 7th June '00 Mozilla build (and many before
    // it) Mozilla did not treat text between <style> tags as
    // style information unless it was written with the one call
    // to write().
    if (isDOM) {
      var lstyle = '<style type="text/css">.child {display: none}<\/style>';
      write(lstyle);
    }
  }
} // Fin de l'ajout des styles (end of adding styles)

onload = toutPlier;
expandedDb = '';