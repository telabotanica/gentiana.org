<?php

class HttpEnteteGenerale {
	/*** Attributs : ***/
	
	/** Indique les directives auxquelles doivent se soumettre tous les mécanismes
	* de cache le long de la chaine requête/réponse.
	* @private
	* @type string
	*/
	private $cache_control;
	
	/** Indique les options spécifiques qui sont désirées lors de cette connexion.
	* @private
	* @type string
	*/
	private $connection;
	
	/** Indique la date d'émission du message HTTP.
	* @private
	* @type string
	*/
	private $date;
	
	/** Indique des comportements optionnels du point de vue du protocole.
	* @private
	* @type string
	*/
	private $pragma;
	
	/** Indique que l'ensemble indiqué de champs d'en-tête est présent dans 
	* le bas de page d'un message codé avec un certain encodage de transfert.
	* @private
	* @type string
	*/
	private $trailer;
	
	/** Indique les types de transformations appliquées au corps du message.
	* @private
	* @type string
	*/
	private $transfer_encoding;
	
	/** Indique au serveur quels protocoles de communications additionnels 
	* le client supporte.
	* @private
	* @type string
	*/
	private $upgrade;
	
	/** Contient les informations qui doivent être utilisées par les proxy pour
	* indiquer les protocoles intermediaires et les destinataires situés entre 
	* le client et le serveur. 
	* @private
	* @type string
	*/
	private $via;
	
	/** Indique le statut de la transformation appliquée au corps du message.
	* @private
	* @type string
	*/
	private $warning;
	
	/*** Constructeurs : ***/
	  
  public function __construct($meta = null)
  {
		if (is_array($meta)) {
			foreach ($meta as $cle => $val) {
				switch($cle) {
					case 'HTTP_CACHE_CONTROL' :
						$this->setCacheControl($val);
						break;
					case 'HTTP_CONNECTION' :
						$this->setConnection($val);
						break;
					case 'HTTP_DATE' :
						$this->setDate($val);
						break;
					case 'HTTP_PRAGMA' :
						$this->setPragma($val);
						break;
					case 'HTTP_TRAILER' :
						$this->setTrailer($val);
						break;
					case 'HTTP_TRANSFER_ENCODING' :
						$this->setTransferEncoding($val);
						break;
					case 'HTTP_UPGRADE' :
						$this->setUpgrade($val);
						break;
					case 'HTTP_VIA' :
						$this->setVia($val);
						break;
					case 'HTTP_WARNING' :
						$this->setWarning($val);
						break;
				}
			}
		}
  }
	
	
	/*** Accesseurs : ***/
	
	// Cache control
	public function setCacheControl( $cc )
	{
		$this->cache_control = $cc;
	}
  public function getCacheControl()
  {
  	return $this->cache_control;
  }

	// Connection
  public function setConnection( $c )
  {
  	$this->connection = $c;
  }
  public function getConnection()
  {
  	return $this->connection;
  }

	// Date
  public function setDate( $d )
  {
  	$this->date = $d;
  }
  public function getDate()
  {
  	return $this->date;
  }
  
	// Pragma
  public function setPragma( $p )
  {
  	$this->pragma = $p;
  }
  public function getPragma()
  {
  	return $this->pragma;
  }
  
	// Trailer
	public function setTrailer( $t )
	{
		$this->trailer = $t;
	}
	public function getTrailer()
	{
		return $this->trailer;
	}

	// Transfer-Encoding
	public function setTransferEncoding( $te )
	{
		$this->transfer_encoding = $te;
	}
	public function getTransferEncoding()
	{
		return $this->transfer_encoding;
	}
	
	// Upgrade
	public function setUpgrade( $u )
	{
		$this->upgrade = $u;
	}
	public function getUpgrade()
	{
		return $this->upgrade;
	}
	
	// Via
	public function setVia( $v )
	{
		$this->via = $v;
	}
	public function getVia()
	{
		return $this->via;
	}
	
	// Warning
	public function setWarning( $w )
	{
		$this->warning = $w;
	}
	public function getWarning()
	{
		return $this->warning;
	}
	
	/*** Méthodes : ***/
	
	public function genererEntete()
	{
		if (!empty($this->getCacheControl) ) {
			header('Cache-control:'.$this->getCacheControl());
		}
	}
  
}
?>