<?php

$ACbuttonsBar = "
  <div id=\"toolbar\"> 
    <img class=\"buttons\" onmouseover=\"mouseover(this);\" onmouseout=\"mouseout(this);\" onmousedown=\"mousedown(this);\" onmouseup=\"mouseup(this);\" onclick=\"wrapSelection(thisForm.body,'**','**');\" src=\"client/integrateur_wikini/bibliotheque/ACeditor/ACEdImages/bold.gif\" title=\"Passe le texte sélectionné en gras  ( Ctrl-Maj-b )\">
    <img class=\"buttons\" onmouseover=\"mouseover(this);\" onmouseout=\"mouseout(this);\" onmousedown=\"mousedown(this);\" onmouseup=\"mouseup(this);\" onclick=\"wrapSelection(thisForm.body,'//','//');\" src=\"client/integrateur_wikini/bibliotheque/ACeditor/ACEdImages/italic.gif\" title=\"Passe le texte sélectionné en italique ( Ctrl-Maj-t )\">
    <img class=\"buttons\" onmouseover=\"mouseover(this);\" onmouseout=\"mouseout(this);\" onmousedown=\"mousedown(this);\" onmouseup=\"mouseup(this);\" onclick=\"wrapSelection(thisForm.body,'__','__');\" src=\"client/integrateur_wikini/bibliotheque/ACeditor/ACEdImages/underline.gif\" title=\"Souligne le texte sélectionné ( Ctrl-Maj-u )\">
    <img class=\"buttons\" onmouseover=\"mouseover(this);\" onmouseout=\"mouseout(this);\" onmousedown=\"mousedown(this);\" onmouseup=\"mouseup(this);\" onclick=\"wrapSelection(thisForm.body,'@@','@@');\" src=\"client/integrateur_wikini/bibliotheque/ACeditor/ACEdImages/strike.gif\" title=\"Barre le texte sélectionné\">
    
    <img class=\"buttons\"  src=\"client/integrateur_wikini/bibliotheque/ACeditor/ACEdImages/separator.gif\" >
    
    <img class=\"buttons\" onmouseover=\"mouseover(this);\" onmouseout=\"mouseout(this);\" onmousedown=\"mousedown(this);\" onmouseup=\"mouseup(this);\" onclick=\"wrapSelection(thisForm.body,'======','======\\n');\" src=\"client/integrateur_wikini/bibliotheque/ACeditor/ACEdImages/t1.gif\" title=\" En-tête énorme\">    
    <img class=\"buttons\" onmouseover=\"mouseover(this);\" onmouseout=\"mouseout(this);\" onmousedown=\"mousedown(this);\" onmouseup=\"mouseup(this);\" onclick=\"wrapSelection(thisForm.body,'=====','=====\\n');\" src=\"client/integrateur_wikini/bibliotheque/ACeditor/ACEdImages/t2.gif\" title=\"  En-tête très gros\">    
    <img class=\"buttons\" onmouseover=\"mouseover(this);\" onmouseout=\"mouseout(this);\" onmousedown=\"mousedown(this);\" onmouseup=\"mouseup(this);\" onclick=\"wrapSelection(thisForm.body,'====','====\\n');\" src=\"client/integrateur_wikini/bibliotheque/ACeditor/ACEdImages/t3.gif\" title=\"  En-tête gros\">    
    <img class=\"buttons\" onmouseover=\"mouseover(this);\" onmouseout=\"mouseout(this);\" onmousedown=\"mousedown(this);\" onmouseup=\"mouseup(this);\" onclick=\"wrapSelection(thisForm.body,'===','===\\n');\" src=\"client/integrateur_wikini/bibliotheque/ACeditor/ACEdImages/t4.gif\" title=\"  En-tête normal\">    
    <img class=\"buttons\" onmouseover=\"mouseover(this);\" onmouseout=\"mouseout(this);\" onmousedown=\"mousedown(this);\" onmouseup=\"mouseup(this);\" onclick=\"wrapSelection(thisForm.body,'==','==');\" src=\"client/integrateur_wikini/bibliotheque/ACeditor/ACEdImages/t5.gif\" title=\"  Petit en-tête\">        
    <img class=\"buttons\"  src=\"client/integrateur_wikini/bibliotheque/ACeditor/ACEdImages/separator.gif\" >
    <img class=\"buttons\" onmouseover=\"mouseover(this);\" onmouseout=\"mouseout(this);\" onmousedown=\"mousedown(this);\" onmouseup=\"mouseup(this);\" onclick=\"wrapSelectionWithLink(thisForm.body);\" src=\"client/integrateur_wikini/bibliotheque/ACeditor/ACEdImages/link.gif\" title=\"Ajoute un lien au texte sélectionné\">
    <img class=\"buttons\" onmouseover=\"mouseover(this);\" onmouseout=\"mouseout(this);\" onmousedown=\"mousedown(this);\" onmouseup=\"mouseup(this);\" onclick=\"wrapSelection(thisForm.body,'\\t-&nbsp;','');\" src=\"client/integrateur_wikini/bibliotheque/ACeditor/ACEdImages/listepuce.gif\" title=\"Liste\">
    <img class=\"buttons\" onmouseover=\"mouseover(this);\" onmouseout=\"mouseout(this);\" onmousedown=\"mousedown(this);\" onmouseup=\"mouseup(this);\" onclick=\"wrapSelection(thisForm.body,'\\t1)&nbsp;','');\" src=\"client/integrateur_wikini/bibliotheque/ACeditor/ACEdImages/listenum.gif\" title=\"Liste numérique\">
    <img class=\"buttons\" onmouseover=\"mouseover(this);\" onmouseout=\"mouseout(this);\" onmousedown=\"mousedown(this);\" onmouseup=\"mouseup(this);\" onclick=\"wrapSelection(thisForm.body,'\\ta)&nbsp;','');\" src=\"client/integrateur_wikini/bibliotheque/ACeditor/ACEdImages/listealpha.gif\" title=\"Liste alphabéthique\">
    <img class=\"buttons\" onmouseover=\"mouseover(this);\" onmouseout=\"mouseout(this);\" onmousedown=\"mousedown(this);\" onmouseup=\"mouseup(this);\" onclick=\"wrapSelectionBis(thisForm.body,'\\n---','');\" src=\"client/integrateur_wikini/bibliotheque/ACeditor/ACEdImages/crlf.gif\" title=\"Insère un retour chariot\">
    <img class=\"buttons\" onmouseover=\"mouseover(this);\" onmouseout=\"mouseout(this);\" onmousedown=\"mousedown(this);\" onmouseup=\"mouseup(this);\" onclick=\"wrapSelectionBis(thisForm.body,'\\n------','');\" src=\"client/integrateur_wikini/bibliotheque/ACeditor/ACEdImages/hr.gif\" title=\"Insère une ligne horizontale\">    


    <img class=\"buttons\"  src=\"client/integrateur_wikini/bibliotheque/ACeditor/ACEdImages/separator.gif\" >
      
    <img class=\"buttons\" onmouseover=\"mouseover(this);\" onmouseout=\"mouseout(this);\" onmousedown=\"mousedown(this);\" onmouseup=\"mouseup(this);\" onclick=\"wrapSelection(thisForm.body,'%%','%%');\" src=\"client/integrateur_wikini/bibliotheque/ACeditor/ACEdImages/code.gif\" title=\"Code\">
    <img class=\"buttons\" onmouseover=\"mouseover(this);\" onmouseout=\"mouseout(this);\" onmousedown=\"mousedown(this);\" onmouseup=\"mouseup(this);\" onclick=\"wrapSelection(thisForm.body,'%%(php)','%%');\" src=\"client/integrateur_wikini/bibliotheque/ACeditor/ACEdImages/php.gif\" title=\"Code PHP\">
  </div>
  <div id=\"toolbar\">   
   
    <img class=\"buttons\" onmouseover=\"mouseover(this);\" onmouseout=\"mouseout(this);\" onmousedown=\"mousedown(this);\" onmouseup=\"mouseup(this);\" onclick=\"wrapSelectionWithImage(thisForm.body);\" src=\"client/integrateur_wikini/bibliotheque/ACeditor/ACEdImages/image.gif\"    title=\"insère un tag image \">  

    <span class=\"texteChampsImage\">
    &nbsp;&nbsp;Fichier&nbsp;<input type=\"text\" name=\"filename\" class=\"ACsearchbox\" size=\"10\">&nbsp;&nbsp;Description&nbsp;<input type=\"text\" name=\"description\" class=\"ACsearchbox\" size=\"10\">
    &nbsp;&nbsp;Alignement&nbsp;<select id=\"alignment\" class=\"ACsearchbox\">
      <option value=\"left\">Gauche</option>
      <option value=\"center\">Centré</option>
      <option value=\"right\">Droite</option>
    </select>
    </span>
  </div>";
?>
