<?php
/*
 * Created on 22 août 2005
 *
 * To change the template for this generated file go to
 * Window - Preferences - PHPeclipse - PHP - Code Templates
 */
 
class HttpEnteteEntite {
	
	/*** Attributs : ***/
	
	private $allow;
	
	/**
	* Indique l'encodage des données envoyées avec la requête.
	* @private
	* @type string
	*/
	private $content_encoding;

	private $content_language;
	
	/**
	* Indique la taille, sous la forme d'un nombre d'octets exprimé en décimal, 
	* des données envoyées avec la requête.
	* @private
	* @type int
	*/
	private $content_length = -1;
	
	private $content_location;
	
	private $content_md5;
	
	private $content_range;
	
	/**
	* Indique le type de média envoyé au récepteur dans le corps d'entité, 
	* ou, si la méthode invoquée est HEAD, le type de média du corps d'entité 
	* qui aurait été envoyé si la ressource avait fait l'objet d'une requête 
	* de type GET.
	* @private
	* @type string
	*/
	private $content_type;

	private $expires;
	
	private $last_modified;
	
	private $extension_header;
    
	/*** Constructeurs : ***/

	function __construct($meta = null)
	{
		if (isset($meta['CONTENT_LENGTH'])) {
			$this->setContentLength($meta['CONTENT_LENGTH']);
		}
		if (isset($meta['CONTENT_TYPE'])) {
			$this->setContentType($meta['CONTENT_TYPE']);
		} else {
			$this->setContentType('text/html; charset=ISO-8859-1');
		}
	}
  
	/*** Accesseurs : ***/

	// Allow
	public function setAllow( $a )
	{
		$this->allow = $a;
	}
	public function getAllow( )
	{
		return $this->allow;
	}

	// Content Encoding
	public function setContentEncoding( $ce )
	{
		$this->content_encoding = $ce;
	}
	public function getContentEncoding( )
	{
		return $this->content_encoding;
	}
	
	// Content Language
	public function setContentLanguage( $cl )
	{
		$this->content_language = $cl;
	}
	public function getContentLanguage( )
	{
		return $this->content_language;
	}

	// Content Length
	public function setContentLength( $cl )
	{
		if (!empty($this->content_length)) {
			$this->content_length += $cl;
		} else {
			$this->content_length = $cl;
		}
	}
	public function getContentLength( )
	{
		return $this->content_length;
	}

	// Content Location
	public function setContentLocation( $clo )
	{
		$this->content_location = $clo;
	}
	public function getContentLocation( )
	{
		return $this->content_location;
	}
	
	// Content Md5
	public function setContentMd5( $cm )
	{
		$this->content_md5 = $cm;
	}
	public function getContentMd5( )
	{
		return $this->content_md5;
	}

	// Content Range
	public function setContentRange( $cr )
	{
		$this->content_range = $cr;
	}
	public function getContentRange( )
	{
		return $this->content_range;
	}

	// Content Type
	public function setContentType( $ct )
	{
		$this->content_type = $ct;
	}
	public function getContentType( )
	{
		return $this->content_type;
	}
	
	// Expires
	public function setExpires( $e )
	{
		$this->expires = $e;
	}
	public function getExpires( )
	{
		return $this->expires;
	}

	// Last Modified
	public function setLastModified( $lm )
	{
		$this->last_modified = $lm;
	}
	public function getLastModified( )
	{
		return $this->last_modified;
	}
	
	// Extension Header
	public function setExtensionHeader( $eh )
	{
		$this->extension_header = $eh;
	}
	public function getExtensionHeader( )
	{
		return $this->extension_header;
	}

	/*** Méthodes : ***/
	
	public function genererEntete()
	{
		if ( $this->getContentLength() != null ) {
			header('Content-Length: '.$this->getContentLength());
		}
		if ( $this->getContentType() != null) {
			header('Content-type: '.$this->getContentType());
		}
		if ( $this->getContentLocation() != null) {
			header('Location: '.$this->getContentLocation());
		}
		if ( $this->getAllow() != null) {
			header('Allow: '.$this->getAllow());
		}
	}
}
?>