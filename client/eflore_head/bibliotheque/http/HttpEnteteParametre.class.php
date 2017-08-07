<?php
/*
 * Created on 23 août 2005
 *
 * To change the template for this generated file go to
 * Window - Preferences - PHPeclipse - PHP - Code Templates
 */
 
class HttpEnteteParametre {
		
	/*** Attributs : ***/
	
	/** Indique le scheme du protocole utilisé. C'est normalement HTTP.
	* @private
	* @type string
	*/
	private $protocol = 'HTTP';
	
	/** La version complète du protocole avec le numéro de version majeure séparé du
	* numéro de version mineure par un point.
	* @private
	* @type string
	*/
	private $version;
	
	/** Le numéro de version majeure du protocole.
	* @private
	* @type integer
	*/
	private $version_major;
	
	/** Le numéro de version mineure du protocole.
	* @private
	* @type integer
	*/
	private $version_minor;
		
	/*** Constructeurs : ***/
	
	public function __construct($meta = null)
	{
		// Dans tous les cas:
		if (isset($meta['SERVER_PROTOCOL'])) {
			// Découpage de la chaine contenant le protocole et la version
			$pv = $meta['SERVER_PROTOCOL'];
			$pos_slash = strpos($pv, '/');
			$p = substr($pv, 0, $pos_slash);
			$v = substr($pv, ($pos_slash + 1));
			$pos_pt = strpos($v, '.');
			$vma = substr($v, 0, $pos_pt);
			$vmi = substr($v, ($pos_pt + 1));
			// Attribution des valeurs aux propriétés de l'objet.
			$this->setProtocol( $p );
			$this->setVersion( $v );
			$this->setVersionMajor( $vma );
			$this->setVersionMinor( $vmi );
		} else {
			trigger_error('eRibo à besoin d\'accéder à la variable suivante pour fonctionner : SERVER_PROTOCOL.', E_USER_ERROR);
		}
	}
		
	/*** Accesseurs : ***/

	// Protocol
	public function setProtocol( $protocole )
	{
		$this->protocol = $protocole;
	}
	public function getProtocol()
	{
		return $this->protocol;
	}

	// Version
	public function setVersion( $version )
	{
		$this->version = $version;
	}
	public function getVersion()
	{
		return $this->version;
	}

	// Version Major
	public function setVersionMajor( $version_major )
	{
		$this->version_major = $version_major;
	}
	public function getVersionMajor()
	{
		return $this->version_major;
	}
	
	// Version Minor
	public function setVersionMinor( $version_minor )
	{
		$this->version_minor = $version_minor;
	}
	public function getVersionMinor()
	{
		return $this->version_minor;
	}
	
	/*** Méthodes : ***/	

}
?>