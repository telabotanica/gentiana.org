<?php
/*
* License:	GNU Lesser General Public License (LGPL)
* Copyright (c) 2002, 2003 John C.Wildenauer.  All rights reserved.
* This file is part of the php.MVC Web applications framework
*/

/**
* Convenience base implementation of the <b>HttpResponse</b> interface, which
* can be used for the <code>Response</code> implementation required by most
* <code>Connectors</code> that deal with HTTP.  Only the connector-specific
* methods need to be implemented.
*
* @author John C. Wildenauer (php.MVC port)<br>
*  Credits:<br> 
*  Craig R. McClanahan (Tomcat/catalina class: see jakarta.apache.org)<br>
*  Remy Maucherat (Tomcat/catalina class: see jakarta.apache.org)
* @version $Revision: 1.1 $
* @public
*/
class HttpEnteteReponse {
	
	/*** Attributs : ***/
	private $accept_ranges;
	
	private $age;
	
	private $etag;
	
	private $location;
	
	private $proxy_authenticate;
	
	private $retry_after;
	
	private $server;
	
	private $vary;
	
	private $www_authenticate;
	
	private $keep_alive;
	
	/*** Constructeurs : ***/
	
	public function __construct($meta = null)
	{
		if (isset($meta['SERVER_SIGNATURE'])) {
			$this->setServer($meta['SERVER_SIGNATURE']);
		}
		if (isset($meta['SERVER_SIGNATURE'])) {
			$this->setServer($meta['SERVER_SIGNATURE']);
		}
		$this->setKeepAlive('timeout=15, max=100');
		
	}
	
	/*** Accesseurs : ***/
	
	// Accept Ranges
	public function setAcceptRanges( $ar )
	{
		$this->accept_ranges = $ar;
	}
	public function getAcceptRanges()
	{
		return $this->accept_ranges;
	}
	
	// Age
	public function setAge( $a )
	{
		$this->age = $a;
	}
	public function getAge()
	{
		return $this->age;
	}

	// ETag
	public function setEtag( $e )
	{
		$this->etag = $e;
	}
	public function getEtag()
	{
		return $this->etag;
	}

	// Location
	public function setLocation( $l )
	{
		$this->location = $l;
	}
	public function getLocation()
	{
		return $this->location;
	}
	
	// Proxy Authenticate
	public function setProxyAuthenticate( $pa )
	{
		$this->proxy_authenticate = $pa;
	}
	public function getProxyAuthenticate()
	{
		return $this->proxy_authenticate;
	}

	// Retry After
	public function setRetryAfter( $ra )
	{
		$this->retry_after = $ra;
	}
	public function getRetryAfter()
	{
		return $this->retry_after;
	}

	// Server
	public function setServer( $s )
	{
		$this->server = $s;
	}
	public function getServer()
	{
		return $this->server;
	}
	
	// Vary
	public function setVary( $v )
	{
		$this->vary = $v;
	}
	public function getVary()
	{
		return $this->vary;
	}

	// Www Authenticate
	public function setWwwAuthenticate( $wa )
	{
		$this->www_authenticate = $wa;
	}
	public function getWwwAuthenticate()
	{
		return $this->www_authenticate;
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
	
	public function genererEntete()
	{
		
	}
}
?>