<?php
include_once(dirname(__FILE__).'/class_sperml.php');

/*******************************************************************************************************************//**
 * Repräsentation einer internen Punktspielergebnismeldung.
 * @ingroup grp_recordset
 **********************************************************************************************************************/
class CSpErMlPunktspielIntern extends CSpErMl
{
	/*****************************************************************************************************************//**
	 * @name Tabellenspalten
	 **************************************************************************************************************//*@{*/

	private $mHeimMannschaftID;
	private $mHeimBegegnungNr;
	private $mGastMannschaftID;
	private $mGastBegegnungNr;

	/*@}*/

	/*****************************************************************************************************************//**
	 * @name Magics
	 **************************************************************************************************************//*@{*/

	public function __construct($SpermlID = 0) {
		parent::__construct($SpermlID);
	}

	public function __toString()
	{
		if(!$this->getSpErMlID()) {return 'Keine interne Punktspielergebnismeldung';}
		return $this->getHeimMannschaftID(GET_OFID).' - '.$this->getGastMannschaftID(GET_OFID);
	}

	/*@}*/

	/*****************************************************************************************************************//**
	 * @name Setter
	 **************************************************************************************************************//*@{*/

	public function setInitVals()
	{
		parent::setInitVals();
		$this->mHeimMannschaftID = 0;
		$this->mHeimBegegnungNr = 0;
		$this->mGastMannschaftID = 0;
		$this->mGastBegegnungNr = 0;
	}

	final public function setHeimMannschaftID($MannschaftID) {
		$this->mHeimMannschaftID = (int)$MannschaftID;
	}

	final public function setHeimBegegnungNr($BegegnungNr) {
		$this->mHeimBegegnungNr = (int)$BegegnungNr;
	}

	final public function setGastMannschaftID($MannschaftID) {
		$this->mGastMannschaftID = (int)$MannschaftID;
	}

	final public function setGastBegegnungNr($BegegnungNr) {
		$this->mGastBegegnungNr = (int)$BegegnungNr;
	}

	/*@}*/

	/*****************************************************************************************************************//**
	 * @name Getter
	 **************************************************************************************************************//*@{*/

	final public function getHeimMannschaftID($FlagVariant = array())
	{
		$FlagArray = (array)$FlagVariant;
		return ((in_array(GET_OFID, $FlagArray))?(new CMannschaft($this->mHeimMannschaftID)):($this->mHeimMannschaftID));
	}


	final public function getHeimBegegnungNr()
	{
		return $this->mHeimBegegnungNr;
	}

	final public function getGastMannschaftID($FlagVariant = array())
	{
		$FlagArray = (array)$FlagVariant;
		return ((in_array(GET_OFID, $FlagArray))?(new CMannschaft($this->mGastMannschaftID)):($this->mGastMannschaftID));
	}

	final public function getGastBegegnungNr()
	{
		return $this->mGastBegegnungNr;
	}

	/*@}*/

	/*****************************************************************************************************************//**
	 * @name Datenbank
	 **************************************************************************************************************//*@{*/

	public static function isValidID($SpErMlID) {
		return CDriveEntity::genericIsValidID('sperml_punktspiel_intern', $SpErMlID);
	}

	public function load($SpErMlID)
	{
		self::setInitVals();
		CSpErMl::load($SpErMlID);
		$format = 'SELECT heim_mannschaft_id, heim_begegnungnr, gast_mannschaft_id, gast_begegnungnr '.
		          'FROM sperml_punktspiel_intern WHERE sperml_id=%s';
		$query = sprintf($format, $this->getSpErMlID());
		if(!$result = mysqli_query(CDriveEntity::getDB(), $query)) {throw new Exception(mysqli_error(CDriveEntity::getDB()));}
		$row = mysqli_fetch_row($result);
		if(!$row) {throw new Exception('Interne Punktspielergebnismeldung mit sperml_id='.$SpErMlID.' nicht gefunden!');}
		$this->mHeimMannschaftID = lD($row[0]);
		$this->mHeimBegegnungNr = lD($row[1]);
		$this->mGastMannschaftID = lD($row[2]);
		$this->mGastBegegnungNr = lD($row[3]);
	}

	public function save()
	{
		self::check();
		CDriveEntity::evlCheckMsg();
		self::store();
	}

	public function store()
	{
		// Basisklasse
		parent::store();

		if(self::isValidID($this->getID()))
		{
			$format = 'UPDATE sperml_punktspiel_extern SET '.
			          'heim_mannschaft_id=%s, heim_begegnungnr=%s, gast_mannschaft_id=%s, gast_begegnungnr=%s '.
			          'WHERE sperml_id=%s';
			$query = sprintf($format, sD($this->mHeimMannschaftID), sD($this->mHeimBegegnungNr), sD($this->mGastMannschaftID),
			sD($this->mGastBegegnungNr), $this->getID());
		}
		else
		{
			$format = 'INSERT INTO sperml_punktspiel_extern ('.
			          'heim_mannschaft_id, heim_begegnungnr, gast_mannschaft_id, gast_begegnungnr'.
			          ') VALUES (%s, %s, %s, %s)';
			$query = sprintf($format, sD($this->mHeimMannschaftID), sD($this->mHeimBegegnungNr), sD($this->mGastMannschaftID),
			sD($this->mGastBegegnungNr));
		}
		if(!$result = mysqli_query(CDriveEntity::getDB(), $query)) {throw new Exception(mysqli_error(CDriveEntity::getDB()));}
	}

	public function check($CheckForeignKey = true)
	{
		// Basisklasse
		parent::check();

		// HeimMannschaftID
		if(!CMannschaft::isValidID($this->mHeimMannschaftID)) {
			CDriveEntity::addCheckMsg('Die heim_mannschaft_id ist ungültig.');
		}

		// HeimBegegnungNr
		if($this->mHeimBegegnungNr < 1 or $this->mHeimBegegnungNr > MAX_BEGEGNUNGNR) {
			CDriveEntity::addCheckMsg('Die Heim-Begegnungsnummer liegt nicht zwischen 1 und '.MAX_BEGEGNUNGNR.'.');
		}

		// GastMannschaftID
		if(!CMannschaft::isValidID($this->mGastMannschaftID)) {
			CDriveEntity::addCheckMsg('Die gast_mannschaft_id ist ungültig.');
		}

		// GastBegegnungNr
		if($this->mGastBegegnungNr < 1 or $this->mGastBegegnungNr > MAX_BEGEGNUNGNR) {
			CDriveEntity::addCheckMsg('Die Gast-Begegnungsnummer liegt nicht zwischen 1 und '.MAX_BEGEGNUNGNR.'.');
		}
	}

	/*@}*/

	/*****************************************************************************************************************//**
	 * @name Verschiedenes
	 **************************************************************************************************************//*@{*/

	public function getXHTML()
	{
		$filename = dirname(__FILE__).'/../../../inhalte/schnipsel/allgemein/sni_sperml.php';
		$Mannschaft = $this->getHeimMannschaftID(GET_OFID);
		$Saison = (string)$Mannschaft->getSaisonID(GET_OFID);
		$Bezirk = 'Schwaben';
		$Spielklasse = (string)$Mannschaft->getLigaKlasseID(GET_OFID);
		$HVerein = (string)$this->getHeimMannschaftID(GET_OFID);
		$GVerein = (string)$this->getGastMannschaftID(GET_OFID);
		$SpErMl = $this;
		if(is_file($filename)) {
			ob_start();
			include $filename;
			$contents = ob_get_contents();
			ob_end_clean();
			return $contents;
		}
	}

	public function getHeimMannschaftString()
	{
		return (string)$this->getHeimMannschaftID(GET_OFID);
	}

	public function getGastMannschaftString()
	{
		return (string)$this->getGastMannschaftID(GET_OFID);
	}

	/*@}*/
}
?>