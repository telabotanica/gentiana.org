// xPliage, Copyright 2007 Jean-Pascal MILCENT

function xPliage(btnClassParent, btnClassEnfant, idAutoOpen) // object prototype
{
  // Constructor

  btns = xGetElementsByClassName(btnClassEnfant);
  for (i = 0; i < btns.length; ++i) {
    btns[i].onclick = btn_onClick;
	btns[i].xClpsTgt = span;
    set_display(btns[i], 0);
  }
  if (idAutoOpen) {
    var e = xGetElementById(idAutoOpen);
    while (e && e != mnu) {
      if (e.xClpsTgt) set_display(e, 1);
      while (e && e != mnu && e.nodeName != 'LI') e = e.parentNode;
      e = e.parentNode; // UL
      while (e && !e.xClpsTgt) e = xPrevSib(e);
    }
  }

  // Private
  
  function btn_onClick()
  {
    var thisLi, fc, pUl;
    if (this.xClpsTgt.style.display == 'none') {
      set_display(this, 1);
      // get this label's parent LI
      var li = this.parentNode;
      thisLi = li;
      pUl = li.parentNode; // get this LI's parent UL
      li = xFirstChild(pUl); // get the UL's first LI child
      // close all labels' ULs on this level except for thisLI's label
      while (li) {
        if (li != thisLi) {
          fc = xFirstChild(li);
          if (fc && fc.xClpsTgt) {
            set_display(fc, 0);
          }
        }
        li = xNextSib(li);
      }
    }  
    else {
      set_display(this, 0);
    }
  }

  function set_display(ele, bBlock)
  {
    if (bBlock) {
      ele.xClpsTgt.style.display = 'block';
      ele.innerHTML = '-';
    }
    else {
      ele.xClpsTgt.style.display = 'none';
      ele.innerHTML = '+';
    }
  }

  // Public

  this.onUnload = function()
  {
    for (i = 0; i < btns.length; ++i) {
      btns[i].xClpsTgt = null;
      btns[i].onclick = null;
    }
  }
} // end xPliage prototype

// xMenu5, Copyright 2004-2006 Michael Foster (Cross-Browser.com)
// Part of X, a Cross-Browser Javascript Library, Distributed under the terms of the GNU LGPL

function xMenu5(idUL, btnClass, idAutoOpen) // object prototype
{
  // Constructor

  var i, ul, btns, mnu = xGetElementById(idUL);
  btns = xGetElementsByClassName(btnClass, mnu, 'DIV');
  for (i = 0; i < btns.length; ++i) {
    ul = xNextSib(btns[i], 'UL');
    btns[i].xClpsTgt = ul;
    btns[i].onclick = btn_onClick;
    set_display(btns[i], 0);
  }
  if (idAutoOpen) {
    var e = xGetElementById(idAutoOpen);
    while (e && e != mnu) {
      if (e.xClpsTgt) set_display(e, 1);
      while (e && e != mnu && e.nodeName != 'LI') e = e.parentNode;
      e = e.parentNode; // UL
      while (e && !e.xClpsTgt) e = xPrevSib(e);
    }
  }

  // Private
  
  function btn_onClick()
  {
    var thisLi, fc, pUl;
    if (this.xClpsTgt.style.display == 'none') {
      set_display(this, 1);
      // get this label's parent LI
      var li = this.parentNode;
      thisLi = li;
      pUl = li.parentNode; // get this LI's parent UL
      li = xFirstChild(pUl); // get the UL's first LI child
      // close all labels' ULs on this level except for thisLI's label
      while (li) {
        if (li != thisLi) {
          fc = xFirstChild(li);
          if (fc && fc.xClpsTgt) {
            set_display(fc, 0);
          }
        }
        li = xNextSib(li);
      }
    }  
    else {
      set_display(this, 0);
    }
  }

  function set_display(ele, bBlock)
  {
    if (bBlock) {
      ele.xClpsTgt.style.display = 'block';
      ele.innerHTML = '-';
    }
    else {
      ele.xClpsTgt.style.display = 'none';
      ele.innerHTML = '+';
    }
  }

  // Public

  this.onUnload = function()
  {
    for (i = 0; i < btns.length; ++i) {
      btns[i].xClpsTgt = null;
      btns[i].onclick = null;
    }
  }
} // end xMenu5 prototype

// xCollapsible, Copyright 2004-2006 Michael Foster (Cross-Browser.com)
// Part of X, a Cross-Browser Javascript Library, Distributed under the terms of the GNU LGPL

function xCollapsible(outerEle, bShow) // object prototype
{
  // Constructor

  var container = xGetElementById(outerEle);
  if (!container) {return null;}
  var isUL = container.nodeName.toUpperCase() == 'UL';
  var i, trg, aTgt = xGetElementsByTagName(isUL ? 'UL':'DIV', container);
  for (i = 0; i < aTgt.length; ++i) {
    trg = xPrevSib(aTgt[i]);
    if (trg && (isUL || trg.nodeName.charAt(0).toUpperCase() == 'H')) {
      aTgt[i].xTrgPtr = trg;
      aTgt[i].style.display = bShow ? 'block' : 'none';
      trg.style.cursor = 'pointer';
      trg.xTgtPtr = aTgt[i];
      trg.onclick = trg_onClick;
    }  
  }
  
  // Private

  function trg_onClick()
  {
    var tgt = this.xTgtPtr.style;
    tgt.display = (tgt.display == 'none') ? "block" : "none";
  }

  // Public

  this.displayAll = function(bShow)
  {
    for (var i = 0; i < aTgt.length; ++i) {
      if (aTgt[i].xTrgPtr) {
        aTgt[i].style.display = bShow ? "block" : "none";
      }
    }
  };

  // The unload listener is for IE's circular reference memory leak bug.
  this.onUnload = function()
  {
    if (!container || !aTgt) {return;}
    for (i = 0; i < aTgt.length; ++i) {
      trg = aTgt[i].xTrgPtr;
      if (trg) {
        if (trg.xTgtPtr) {
          trg.xTgtPtr.TrgPtr = null;
          trg.xTgtPtr = null;
        }
        trg.onclick = null;
      }
    }
  };
}

// xGetElementById, Copyright 2001-2006 Michael Foster (Cross-Browser.com)
// Part of X, a Cross-Browser Javascript Library, Distributed under the terms of the GNU LGPL

function xGetElementById(e)
{
  if(typeof(e)=='string') {
    if(document.getElementById) e=document.getElementById(e);
    else if(document.all) e=document.all[e];
    else e=null;
  }
  return e;
}

// xGetElementsByTagName, Copyright 2002-2006 Michael Foster (Cross-Browser.com)
// Part of X, a Cross-Browser Javascript Library, Distributed under the terms of the GNU LGPL

function xGetElementsByTagName(t,p)
{
  var list = null;
  t = t || '*';
  p = p || document;
  if (typeof p.getElementsByTagName != 'undefined') { // DOM1
    list = p.getElementsByTagName(t);
    if (t=='*' && (!list || !list.length)) list = p.all; // IE5 '*' bug
  }
  else { // IE4 object model
    if (t=='*') list = p.all;
    else if (p.all && p.all.tags) list = p.all.tags(t);
  }
  return list || new Array();
}

// xPrevSib, Copyright 2005-2006 Michael Foster (Cross-Browser.com)
// Part of X, a Cross-Browser Javascript Library, Distributed under the terms of the GNU LGPL

function xPrevSib(e,t)
{
  e = xGetElementById(e);
  var s = e ? e.previousSibling : null;
  while (s) {
    if (s.nodeType == 1 && (!t || s.nodeName.toLowerCase() == t.toLowerCase())){break;}
    s = s.previousSibling;
  }
  return s;
}

// xGetElementsByClassName, Copyright 2002-2006 Michael Foster (Cross-Browser.com)
// Part of X, a Cross-Browser Javascript Library, Distributed under the terms of the GNU LGPL

function xGetElementsByClassName(c,p,t,f)
{
  var r = new Array();
  var re = new RegExp("(^|\\s)"+c+"(\\s|$)");
//  var e = p.getElementsByTagName(t);
  var e = xGetElementsByTagName(t,p); // See xml comments.
  for (var i = 0; i < e.length; ++i) {
    if (re.test(e[i].className)) {
      r[r.length] = e[i];
      if (f) f(e[i]);
    }
  }
  return r;
}

// xNextSib, Copyright 2005-2006 Michael Foster (Cross-Browser.com)
// Part of X, a Cross-Browser Javascript Library, Distributed under the terms of the GNU LGPL

function xNextSib(e,t)
{
  e = xGetElementById(e);
  var s = e ? e.nextSibling : null;
  while (s) {
    if (s.nodeType == 1 && (!t || s.nodeName.toLowerCase() == t.toLowerCase())){break;}
    s = s.nextSibling;
  }
  return s;
}

// xPrevSib, Copyright 2005-2006 Michael Foster (Cross-Browser.com)
// Part of X, a Cross-Browser Javascript Library, Distributed under the terms of the GNU LGPL

function xPrevSib(e,t)
{
  e = xGetElementById(e);
  var s = e ? e.previousSibling : null;
  while (s) {
    if (s.nodeType == 1 && (!t || s.nodeName.toLowerCase() == t.toLowerCase())){break;}
    s = s.previousSibling;
  }
  return s;
}

// xFirstChild, Copyright 2004-2006 Michael Foster (Cross-Browser.com)
// Part of X, a Cross-Browser Javascript Library, Distributed under the terms of the GNU LGPL

function xFirstChild(e,t)
{
  e = xGetElementById(e);
  var c = e ? e.firstChild : null;
  while (c) {
    if (c.nodeType == 1 && (!t || c.nodeName.toLowerCase() == t.toLowerCase())){break;}
    c = c.nextSibling;
  }
  return c;
}