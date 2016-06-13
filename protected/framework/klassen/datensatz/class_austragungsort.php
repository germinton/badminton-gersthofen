<?php
include_once(dirname(__FILE__).'/../datenbank/class_drive_entity_with_attach.php');

/*******************************************************************************************************************//**
 * Repräsentation eines Austragungsorts.
 * @ingroup grp_recordset
 **********************************************************************************************************************/
class CAustragungsort extends CDriveEntityWithAttachment
{
	/*****************************************************************************************************************//**
	 * @name Tabellenname
	 **************************************************************************************************************//*@{*/

	const mcTabName = 'austragungsorte';

	/*@}*/

	/*****************************************************************************************************************//**
	 * @name Tabellenspalten
	 **************************************************************************************************************//*@{*/

	private $mHallenname;
	private $mVereinID;
	private $mStrasse;
	private $mPLZ;
	private $mOrt;
	private $mFelder;
	private $mInfo;
	private $mGMapLat;
	private $mGMapLon;

	/*@}*/

	/*****************************************************************************************************************//**
	 * @name Magics
	 **************************************************************************************************************//*@{*/

	public function __construct($AustragungsortID = 0) {
		parent::__construct(self::mcTabName, $AustragungsortID);
	}

	public function __toString()
	{
		if(!$this->getAustragungsortID()) {return 'Kein Austragungsort';}
		return $this->mOrt.', '.$this->mHallenname;
	}

	/*@}*/

	/*****************************************************************************************************************//**
	 * @name Setter
	 **************************************************************************************************************//*@{*/

	public function setInitVals()
	{
		parent::setInitVals();
		$this->mHallenname = '';
		$this->mVereinID = null;
		$this->mStrasse = null;
		$this->mPLZ = null;
		$this->mOrt = '';
		$this->mFelder = null;
		$this->mInfo = null;
		$this->mGMapLat = null;
		$this->mGMapLon = null;
	}

	final public function setAustragungsortID($AustragungsortID) {
		CDriveEntity::setID($AustragungsortID);
	}

	final public function setHallenname($Hallenname) {
		$this->mHallenname = htmlspecialchars(trim((string)$Hallenname));
	}

	final public function setVereinID($VereinID) {
		$this->mVereinID = (($i = (int)$VereinID)?($i):(null));
	}

	final public function setStrasse($Strasse) {
		$this->mStrasse = (($s = htmlspecialchars(trim((string)$Strasse)))?($s):(null));
	}

	final public function setPLZ($PLZ) {
		$this->mPLZ = (($s = htmlspecialchars(trim((string)$PLZ)))?($s):(null));
	}

	final public function setOrt($Ort) {
		$this->mOrt = htmlspecialchars(trim((string)$Ort));
	}

	final public function setFelder($Felder) {
		$this->mFelder = (($i = (int)$Felder)?($i):(null));
	}

	final public function setInfo($Info) {
		$this->mInfo = (($s = trim((string)$Info))?($s):(null));
	}

	final public function setGMapLat($GMapLat) {
		$this->mGMapLat = ((!is_null($GMapLat))?((int)$GMapLat):(null));
	}

	final public function setGMapLon($GMapLon) {
		$this->mGMapLon = ((!is_null($GMapLon))?((int)$GMapLon):(null));
	}

	/*@}*/

	/*****************************************************************************************************************//**
	 * @name Getter
	 **************************************************************************************************************//*@{*/

	final public function getAustragungsortID()
	{
		return CDriveEntity::getID();
	}

	final public function getHallenname()
	{
		return $this->mHallenname;
	}

	final public function getVereinID($FlagVariant = array())
	{
		$FlagArray = (array)$FlagVariant;
		if(is_null($ID = $this->mVereinID) and in_array(GET_NBSP, $FlagArray)) {return '&nbsp;';}
		return ((!is_null($ID) and in_array(GET_OFID, $FlagArray))?(new CVerein($ID)):($ID));
	}

	final public function getStrasse($FlagVariant = array())
	{
		$FlagArray = (array)$FlagVariant;
		return ((is_null($v = $this->mStrasse) and in_array(GET_NBSP, $FlagArray))?('&nbsp;'):($v));
	}

	final public function getPLZ($FlagVariant = array())
	{
		$FlagArray = (array)$FlagVariant;
		return ((is_null($v = $this->mPLZ) and in_array(GET_NBSP, $FlagArray))?('&nbsp;'):($v));
	}

	final public function getOrt()
	{
		return $this->mOrt;
	}

	final public function getFelder($FlagVariant = array())
	{
		$FlagArray = (array)$FlagVariant;
		return ((is_null($v = $this->mFelder) and in_array(GET_NBSP, $FlagArray))?('&nbsp;'):($v));
	}

	final public function getInfo($FlagVariant = array())
	{
		$FlagArray = (array)$FlagVariant;
		if(is_null($v = $this->mInfo) and in_array(GET_NBSP, $FlagArray)) {return '&nbsp;';}
		$Info = ((in_array(GET_SPEC, $FlagArray))?(FormatXHTMLPermittedString($this->mInfo)):($this->mInfo));
		$Info = ((in_array(GET_CLIP, $FlagArray) and (strlen($Info) > 20))?(substr($Info, 0, 20).'...'):($Info));
		$Info = ((in_array(GET_HSPC, $FlagArray))?(htmlspecialchars($Info)):($Info));
		return $Info;
	}

	final public function getGMapLat($FlagVariant = array())
	{
		$FlagArray = (array)$FlagVariant;
		$i = $this->mGMapLat;
		if(is_null($i) and in_array(GET_NBSP, $FlagArray)) {return '&nbsp;';}
		if(!is_null($i) and in_array(GET_SPEC, $FlagArray)) {return MyInt2Floatstring($i);}
		return $i;
	}

	final public function getGMapLon($FlagVariant = array())
	{
		$FlagArray = (array)$FlagVariant;
		$i = $this->mGMapLon;
		if(is_null($i) and in_array(GET_NBSP, $FlagArray)) {return '&nbsp;';}
		if(!is_null($i) and in_array(GET_SPEC, $FlagArray)) {return MyInt2Floatstring($i);}
		return $i;
	}
	
	final public function getRoutePlannerLink()
	{
		
		$strasse = (($s = $this->mStrasse)?(str_replace('_', '+', NormalizeString($s))):(''));
		$plz = (($s = $this->mPLZ)?($s):(''));
		$ort = str_replace('_', '+', NormalizeString($this->mOrt));
			
		$strstart = '<a href="http://maps.google.com/maps?daddr=';
		$strmid = (($s = $strasse)?($s.',+'):('')).(($s = $plz)?($s.'+'):('')).$ort;
		$strend = '" '.STD_NEW_WINDOW.'>Google Routenplaner</a>';
		
		return $strstart.$strmid.$strend;
	}

	/*@}*/

	/*****************************************************************************************************************//**
	 * @name Datenbank
	 **************************************************************************************************************//*@{*/

	public static function isValidID($AustragungsortID) {
		return CDriveEntity::genericIsValidID(self::mcTabName, $AustragungsortID);
	}

	public function load($AustragungsortID)
	{
		self::setInitVals();
		$this->setAustragungsortID($AustragungsortID);
		$format = 'SELECT hallenname, verein_id, strasse, plz, ort, felder, info, gmap_lat, gmap_lon '.
		          'FROM austragungsorte WHERE austragungsort_id=%s';
		$query = sprintf($format, $this->getAustragungsortID());
		if(!$result = mysqli_query(CDriveEntity::getDB(), $query)) {throw new Exception(mysqli_error(CDriveEntity::getDB()));}
		$row = mysqli_fetch_row($result);
		if(!$row) {throw new Exception('Austragungsort mit austragungsort_id='.$AustragungsortID.' nicht gefunden!');}
		$this->mHallenname = lS($row[0]);
		$this->mVereinID = lD($row[1]);
		$this->mStrasse = lS($row[2]);
		$this->mPLZ = lS($row[3]);
		$this->mOrt = lS($row[4]);
		$this->mFelder = lD($row[5]);
		$this->mInfo = lS($row[6]);
		$this->mGMapLat = lD($row[7]);
		$this->mGMapLon = lD($row[8]);
	}

	public function save()
	{
		self::check();
		CDriveEntity::evlCheckMsg();
		self::store();
	}

	public function store()
	{
		if(self::isValidID($this->getID()))
		{
			$format = 'UPDATE austragungsorte SET '.
			          'hallenname=%s, verein_id=%s, strasse=%s, plz=%s, ort=%s, felder=%s, info=%s, gmap_lat=%s, gmap_lon=%s '.
			          'WHERE austragungsort_id=%s';
			$query = sprintf($format, sS($this->mHallenname), sD($this->mVereinID), sS($this->mStrasse), sS($this->mPLZ),
			sS($this->mOrt), sD($this->mFelder), sS($this->mInfo), sD($this->mGMapLat), sD($this->mGMapLon), $this->getID());
		}
		else
		{
			$format = 'INSERT INTO austragungsorte ('.
			          'hallenname, verein_id, strasse, plz, ort, felder, info, gmap_lat, gmap_lon'.
			          ') VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s)';
			$query = sprintf($format, sS($this->mHallenname), sD($this->mVereinID), sS($this->mStrasse), sS($this->mPLZ),
			sS($this->mOrt), sD($this->mFelder), sS($this->mInfo), sD($this->mGMapLat), sD($this->mGMapLon));
		}
		if(!$result = mysqli_query(CDriveEntity::getDB(), $query)) {throw new Exception(mysqli_error(CDriveEntity::getDB()));}

		// Basisklasse
		parent::store();
	}

	public function check()
	{
		// Hallenname
		if(!(strlen($this->mHallenname) >= 2 and strlen($this->mHallenname) <= 50)) {
			CDriveEntity::addCheckMsg('Der Hallenname muss mind. 2 bis max. 50 Zeichen lang sein.');
		}

		// VereinID
		if(!is_null($this->mVereinID))
		{
			if(!CVerein::isValidID($this->mVereinID)) {
				CDriveEntity::addCheckMsg('Die verein_id ist ungültig.');
			}
		}

		// Strasse
		if(!is_null($this->mStrasse))
		{
			if(strlen($this->mStrasse) > 50) {
				CDriveEntity::addCheckMsg('Der Straßenname darf nicht länger als 50 Zeichen sein.');
			}
		}

		// PLZ
		if(!is_null($this->mPLZ))
		{
			if(!preg_match(REGEX_PLZ, $this->mPLZ)) {
				CDriveEntity::addCheckMsg('Die Postleitzahl muss eine fünfstellige Zahl sein.');
			}
		}

		// Ort
		if(!(strlen($this->mOrt) >= 2 and strlen($this->mOrt) <= 50)) {
			CDriveEntity::addCheckMsg('Der Ortsname muss mind. 2 bis max. 50 Zeichen lang sein.');
		}

		// Felder
		if(!is_null($this->mFelder))
		{
			if(!($this->mFelder >= 1 and $this->mFelder <= 255)) {
				CDriveEntity::addCheckMsg('Die Felderanzahl muss zwischen 1 und 255 liegen.');
			}
		}

		// Info
		if(!is_null($this->mInfo))
		{
			if(!(strlen($this->mInfo) >= 1 and strlen($this->mInfo) <= 65535)) {
				CDriveEntity::addCheckMsg('Die Info muss mind. 1 bis max. 65535 Zeichen lang sein.');
			}
			else if(substr_count($this->mInfo, '{') != substr_count($this->mInfo, '}')) {
				CDriveEntity::addCheckMsg('Die Anzahl an sich öffnenden und sich schließenden geschw. Klammern ist ungleich.');
			}
		}

		// GMapLat
		if(!is_null($this->mGMapLat))
		{
			if(!($this->mGMapLat > -90000000 and $this->mGMapLat < 90000000)) {
				CDriveEntity::addCheckMsg('Die Breitengrad muss zwischen -90° und +90° liegen.');
			}
		}

		// GMapLon
		if(!is_null($this->mGMapLon))
		{
			if(!($this->mGMapLon > -180000000 and $this->mGMapLon < 180000000)) {
				CDriveEntity::addCheckMsg('Der Längengrad muss zwischen -180° und +180° liegen.');
			}
		}

		// Bild
		CDriveEntityWithAttachment::check();
	}

	/*@}*/

	/*****************************************************************************************************************//**
	 * @name Verschiedenes
	 **************************************************************************************************************//*@{*/

	public function isDeletable()
	{
		/*
		 * In welchen Tabellen wird eine austragungsort_id eingetragen und wie kritisch ist diese Tabelle?
		 *
		 * sperml...............kritisch (SpErMl wird gelöscht!)
		 * turniere.............kritisch (Turnier wird gelöscht!)
		 * termine_pktspbeg.....unkritisch
		 * mannschaften.........kritisch (Spielgemeinschaft!)
		 *
		 */

		$Zaehler = 0;

		$query = 'SELECT COUNT(*) FROM sperml WHERE austragungsort_id='.$this->getAustragungsortID();
		if(!$result = mysqli_query(CDriveEntity::getDB(), $query)) {
			throw new Exception(mysqli_error(CDriveEntity::getDB()));
		}
		$row = mysqli_fetch_row($result);
		$Zaehler += (int)$row[0];

		$query = 'SELECT COUNT(*) FROM turniere WHERE austragungsort_id='.$this->getAustragungsortID();
		if(!$result = mysqli_query(CDriveEntity::getDB(), $query)) {
			throw new Exception(mysqli_error(CDriveEntity::getDB()));
		}
		$row = mysqli_fetch_row($result);
		$Zaehler += (int)$row[0];

		return (($Zaehler)?(false):(true));
	}

	public function hasGMapCoord($FlagVariant = array())
	{
		$FlagArray = (array)$FlagVariant;
		$HasGMapCoord = (!is_null($this->mGMapLat) and !is_null($this->mGMapLon));
		return ((in_array(GET_SPEC, $FlagArray))?(($HasGMapCoord)?('ja'):('nein')):(($HasGMapCoord)?(true):(false)));
	}

	/*@}*/
}
?>