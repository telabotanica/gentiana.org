<?php
/*
* License:	GNU Lesser General Public License (LGPL)
* Copyright (c) 2002, 2003 John C.Wildenauer.  All rights reserved.
* This file is part of the php.MVC Web applications framework
*/

/**
* Classe implémentant une entête de <b>requête HTTP</b> 
*
* @author Jean-Pascal MILCENT (portage pour eRibo)<br>
* Auteur original : John C. Wildenauer (php.MVC port)<br>
* Credits:<br> 
* Craig R. McClanahan (Tomcat/catalina class: see jakarta.apache.org)
* @version $Revision: 1.1 $
* @public
*/
class HttpEnteteRequete {

	/*** Attributs : ***/
	
	private $accept;
	
	private $accept_charset;
	
	private $accept_encoding;
	
	private $accept_language;
	
	/**
	* Les données d'identification envoyées avec la requête.
	* @private
	* @type string
	*/
	private $authorization = NULL;

	private $expect;
	
	/**
	* Indique la source des requête grâce à un e-mail par exemple.
	* Ce champ est utilisé à des fins de statistiques. Les robots doivent 
	* le renseigner.
	* @private
	* @type string
	*/
	private $from;
	
	private $host;
	
	private $if_match;
	
	private $if_modified_since;
	
	private $if_none_match;
	
	private $if_range;
	
	private $if_unmodified_since;
	
	private $max_forwards;
	
	private $proxy_authorization;
	
	private $range;
	
	private $referer;
	
	private $te;
	
	private $user_agent;
	
	private $keep_alive;
	
	/*** Constructeurs : ***/
	
	public function __construct()
	{
		foreach ($_SERVER as $cle => $val) {
			switch($cle) {
				case 'HTTP_ACCEPT' :
					$this->setAccept($val);
					break;
				case 'HTTP_ACCEPT_CHARSET' :
					$this->setAcceptCharset($val);
					break;
				case 'HTTP_ACCEPT_ENCODING' :
					$this->setAcceptEncoding($val);
					break;
				case 'HTTP_ACCEPT_LANGUAGE' :
					$this->setAcceptLanguage($val);
					break;
				case 'HTTP_AUTHORIZATION' :
					$this->setAuthorization($val);
					break;
				case 'HTTP_EXPECT' :
					$this->setExpect($val);
					break;
				case 'HTTP_FROM' :
					$this->setFrom($val);
					break;
				case 'HTTP_HOST' :
					$this->setHost($val);
					break;
				case 'HTTP_IF_MATCH' :
					$this->setIfMatch($val);
					break;
				case 'HTTP_IF_MODIFIED_SINCE' :
					$this->setIfModifiedSince($val);
					break;
				case 'HTTP_IF_NONE_MATCH' :
					$this->setIfNoneMatch($val);
					break;
				case 'HTTP_IF_RANGE' :
					$this->setIfRange($val);
					break;
				case 'HTTP_IF_UNMODIFIED_SINCE' :
					$this->setIfUnmodifiedSince($val);
					break;
				case 'HTTP_MAX_FORWARDS' :
					$this->setMaxForwards($val);
					break;
				case 'HTTP_PROXY_AUTHORIZATION' :
					$this->setProxyAuthorization($val);
					break;
				case 'HTTP_RANGE' :
					$this->setRange($val);
					break;
				case 'HTTP_REFERER' :
					$this->setReferer($val);
					break;
				case 'HTTP_TE' :
					$this->setTe($val);
					break;
				case 'HTTP_USER_AGENT' :
					$this->setUserAgent($val);
					break;
				case 'HTTP_KEEP_ALIVE' :
					$this->setKeepAlive($val);
					break;
			}
		}
	}
	
	/*** Accesseurs : ***/
	
	// Accept
  public function setAccept( $a )
  {
  	$this->accept = $a;
  }
  public function getAccept()
  {
  	return $this->accept;
  }
	
	// Accept Charset
  public function setAcceptCharset( $ac )
  {
  	$this->accept_charset = $ac;
  }
  public function getAcceptCharset()
  {
  	return $this->accept_charset;
  }
	
	// Accept Encoding
  public function setAcceptEncoding( $ac )
  {
  	$this->accept_encoding = $ac;
  }
  public function getAcceptEncoding()
  {
  	return $this->accept_encoding;
  }
	
	// Accept Language
  public function setAcceptLanguage( $al )
  {
  	$this->accept_language = $al;
  }
  public function getAcceptLanguage()
  {
  	return $this->accept_language;
  }

	// Authorization
  public function setAuthorization( $au )
  {
  	$this->authorization = $au;
  }
  public function getAuthorization()
  {
  	return $this->authorization;
  }

	// Expect
  public function setExpect( $e )
  {
  	$this->expect = $e;
  }
  public function getExpect()
  {
  	return $this->expect;
  }

	// From
  public function setFrom( $f )
  {
  	$this->from = $f;
  }
  public function getFrom()
  {
  	return $this->from;
  }
  
  // Host
  public function setHost( $h )
  {
  	$this->host = $h;
  }
  public function getHost()
  {
  	return $this->host;
  }
  
  // If Match
  public function setIfMatch( $im )
  {
  	$this->if_match = $im;
  }
  public function getIfMatch()
  {
  	return $this->if_match;
  }
  
  // If Modified Since
  public function setIfModifiedSince( $ims )
  {
  	$this->if_modified_since = $ims;
  }
  public function getIfModifiedSince()
  {
  	return $this->if_modified_since;
  }

  // If None Match
  public function setIfNoneMatch( $inm )
  {
  	$this->if_none_match = $inm;
  }
  public function getIfNoneMatch()
  {
  	return $this->if_none_match;
  }
  
  // If Range
  public function setIfRange( $ir )
  {
  	$this->if_range = $ir;
  }
  public function getIfRange()
  {
  	return $this->if_range;
  }

  // If Unmodified Since
  public function setIfUnmodifiedSince( $ius )
  {
  	$this->if_unmodified_since = $ius;
  }
  public function getIfUnmodifiedSince()
  {
  	return $this->if_unmodified_since;
  }
  
  // Max Forwards
  public function setMaxForwards( $mf )
  {
  	$this->max_forwards = $mf;
  }
  public function getMaxForwards()
  {
  	return $this->max_forwards;
  }
  
  // Proxy Authorization
  public function setProxyAuthorization( $pa )
  {
  	$this->proxy_authorization = $pa;
  }
  public function getProxyAuthorization()
  {
  	return $this->proxy_authorization;
  }
  
  // Range
  public function setRange( $r )
  {
  	$this->range = $r;
  }
  public function getRange()
  {
  	return $this->range;
  }
  
  // Referer
  public function setReferer( $re )
  {
  	$this->referer = $re;
  }
  public function getReferer()
  {
  	return $this->referer;
  }

  // TE
  public function setTe( $te )
  {
  	$this->te = $te;
  }
  public function getTe()
  {
  	return $this->te;
  }

  // User Agent
  public function setUserAgent( $ua )
  {
  	$this->user_agent = $ua;
  }
  public function getUserAgent()
  {
  	return $this->te;
  }

	// Keep Alive
	public function setKeepAlive( $ka )
	{
		$this->keep_alive = $ka;
	}
	public function getKeepAlive()
	{
		return $this->keep_alive;
	}
	
  /*** Méthodes : ***/
  
	public function parserAccept($defaut = array('text/xml' => 1))
	{
		if ( $this->getAccept() != null) {
			foreach (explode(',', $this->getAccept()) as $media_range) {
				$media_range = array_map('trim', explode(';', $media_range));
                if (isset($media_range[1])) {
                    $mr = strtolower($media_range[0]);
                    $q = (float) str_replace('q=', '', $media_range[1]);
                } else {
                    $mr = strtolower($media_range[0]);
                    $q = null;
                }
                $matches[$mr] = isset($q) ? $q : 1000 - count($matches);
            }
			if (count($matches)) {
				arsort($matches, SORT_NUMERIC);
				return $matches;
			}
        }
        return $defaut;
	}
	
	public function parserAcceptCharset($defaut = array('ISO-8859-15' => 1))
	{
		if ($this->getAcceptCharset() != null) {
			foreach (explode(',', $this->getAcceptCharset()) as $charset) {
				$charset = array_map('trim', explode(';', $charset));
                if (isset($charset[1])) {
                    $c = strtolower($charset[0]);
                    $q = (float) str_replace('q=', '', $charset[1]);
                } else {
                    $c = strtolower($charset[0]);
                    $q = null;
                }
                $matches[$c] = isset($q) ? $q : 1000 - count($matches);
            }
			if (count($matches)) {
				arsort($matches, SORT_NUMERIC);
				return $matches;
			}
        }
        return $defaut;
	}
}
?>