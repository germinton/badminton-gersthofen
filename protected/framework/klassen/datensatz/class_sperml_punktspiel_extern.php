<?php
include_once(dirname(__FILE__).'/class_sperml.php');

/*******************************************************************************************************************//**
 * Repräsentation einer externen Punktspielergebnismeldung.
 * @ingroup grp_recordset
 **********************************************************************************************************************/
class CSpErMlPunktspielExtern extends CSpErMl
{
	/*****************************************************************************************************************//**
	 * @name Tabellenspalten
	 **************************************************************************************************************//*@{*/

	private $mMannschaftID;
	private $mBegegnungNr;
	private $mSeite;
	private $mVereinID;
	private $mMannschaftNr;

	/*@}*/

	/*****************************************************************************************************************//**
	 * @name Magics
	 **************************************************************************************************************//*@{*/

	public function __construct($SpermlID = 0) {
		parent::__construct($SpermlID);
	}

	public function __toString()
	{
		if(!$this->getSpErMlID()) {return 'Keine externe Punktspielergebnismeldung';}
		return $this->getHeimMannschaftString().' - '.$this->getGastMannschaftString();
	}

	/*@}*/

	/*****************************************************************************************************************//**
	 * @name Setter
	 **************************************************************************************************************//*@{*/

	public function setInitVals()
	{
		parent::setInitVals();
		$this->mMannschaftID = 0;
		$this->mBegegnungNr = 0;
		$this->mSeite = 0;
		$this->mVereinID = 0;
		$this->mMannschaftNr = null;
	}

	final public function setMannschaftID($MannschaftID) {
		$this->mMannschaftID = (int)$MannschaftID;
	}

	final public function setBegegnungNr($BegegnungNr) {
		$this->mBegegnungNr = (int)$BegegnungNr;
	}

	final public function setSeite($Seite) {
		$this->mSeite = (int)$Seite;
	}

	final public function setVereinID($VereinID) {
		$this->mVereinID = (int)$VereinID;
	}

	final public function setMannschaftNr($MannschaftNr) {
		$this->mMannschaftNr = (($i = (int)$MannschaftNr)?($i):(null));
	}

	/*@}*/

	/*****************************************************************************************************************//**
	 * @name Getter
	 **************************************************************************************************************//*@{*/

	final public function getMannschaftID($FlagVariant = array())
	{
		$FlagArray = (array)$FlagVariant;
		return ((in_array(GET_OFID, $FlagArray))?(new CMannschaft($this->mMannschaftID)):($this->mMannschaftID));
	}

	final public function getBegegnungNr()
	{
		return $this->mBegegnungNr;
	}

	final public function getSeite()
	{
		return $this->mSeite;
	}

	final public function getVereinID($FlagVariant = array())
	{
		$FlagArray = (array)$FlagVariant;
		return ((in_array(GET_OFID, $FlagArray))?(new CVerein($this->mVereinID)):($this->mVereinID));
	}

	final public function getMannschaftNr($FlagVariant = array())
	{
		$FlagArray = (array)$FlagVariant;
		return ((is_null($v = $this->mMannschaftNr) and in_array(GET_NBSP, $FlagArray))?('&nbsp;'):($v));
	}

	/*@}*/

	/*****************************************************************************************************************//**
	 * @name Datenbank
	 **************************************************************************************************************//*@{*/

	public static function isValidID($SpErMlID) {
		return CDriveEntity::genericIsValidID('sperml_punktspiel_extern', $SpErMlID);
	}

	public function load($SpErMlID)
	{
		self::setInitVals();
		CSpErMl::load($SpErMlID);
		$format = 'SELECT mannschaft_id, begegnungnr, seite, verein_id, mannschaftnr '.
		          'FROM sperml_punktspiel_extern WHERE sperml_id=%s';
		$query = sprintf($format, $this->getSpErMlID());
		if(!$result = mysqli_query(CDriveEntity::getDB(), $query)) {throw new Exception(mysqli_error(CDriveEntity::getDB()));}
		$row = mysqli_fetch_row($result);
		if(!$row) {throw new Exception('Externe Punktspielergebnismeldung mit sperml_id='.$SpErMlID.' nicht gefunden!');}
		$this->mMannschaftID = lD($row[0]);
		$this->mBegegnungNr = lD($row[1]);
		$this->mSeite = lD($row[2]);
		$this->mVereinID = lD($row[3]);
		$this->mMannschaftNr = lD($row[4]);
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
			          'mannschaft_id=%s, begegnungnr=%s, seite=%s, verein_id=%s, mannschaftnr=%s '.
			          'WHERE sperml_id=%s';
			$query = sprintf($format, sD($this->mMannschaftID), sD($this->mBegegnungNr), sD($this->mSeite),
			sD($this->mVereinID), sD($this->mMannschaftNr), $this->getID());
		}
		else
		{
			$format = 'INSERT INTO sperml_punktspiel_extern ('.
			          'mannschaft_id, begegnungnr, seite, verein_id, mannschaftnr'.
			          ') VALUES (%s, %s, %s, %s, %s)';
			$query = sprintf($format, sD($this->mMannschaftID), sD($this->mBegegnungNr), sD($this->mSeite),
			sD($this->mVereinID), sD($this->mMannschaftNr));
		}
		if(!$result = mysqli_query(CDriveEntity::getDB(), $query)) {throw new Exception(mysqli_error(CDriveEntity::getDB()));}
	}

	public function check($CheckForeignKey = true)
	{
		// Basisklasse
		parent::check();

		// MannschaftID
		if(!CMannschaft::isValidID($this->mMannschaftID)) {
			CDriveEntity::addCheckMsg('Die mannschaft_id ist ungültig.');
		}

		// BegegnungNr
		if($this->mBegegnungNr < 1 or $this->mBegegnungNr > MAX_BEGEGNUNGNR) {
			CDriveEntity::addCheckMsg('Die Begegnungsnummer liegt nicht zwischen 1 und '.MAX_BEGEGNUNGNR.'.');
		}

		// Seite
		if(is_null(C2S_Seite($this->mSeite))) {
			CDriveEntity::addCheckMsg('Die Seite ist ungültig.');
		}

		// VereinID
		if(!CVerein::isValidID($this->mVereinID)) {
			CDriveEntity::addCheckMsg('Die verein_id ist ungültig.');
		}

		// MannschaftNr
		if($this->mMannschaftNr < 1 or $this->mMannschaftNr > MAX_MANNSCHAFTEN) {
			CDriveEntity::addCheckMsg('Die Mannschaftsnummer liegt nicht zwischen 1 und '.MAX_MANNSCHAFTEN.'.');
		}
	}

	/*@}*/

	/*****************************************************************************************************************//**
	 * @name Verschiedenes
	 **************************************************************************************************************//*@{*/

	public function getGegnerMannschaftString()
	{
		$Gegner = $this->getVereinID(GET_OFID);
		if($MNr = $this->mMannschaftNr) {
			$AKlaGruppe = $this->getMannschaftID(GET_OFID)->getAKlaGruppe();
			$Gegner .= '&nbsp;'.((S_AKTIVE != $AKlaGruppe)?(substr(C2S_AKlaGruppe($AKlaGruppe), 0, 1)):('')).$MNr;
		}
		return $Gegner;
	}

	public function getHeimMannschaftString()
	{
		if(S_HEIM == $this->mSeite) {return (string)$this->getMannschaftID(GET_OFID);}
		else if(S_GAST == $this->mSeite) {return $this->getGegnerMannschaftString();}
	}

	public function getGastMannschaftString()
	{
		if(S_GAST == $this->mSeite) {return (string)$this->getMannschaftID(GET_OFID);}
		else if(S_HEIM == $this->mSeite) {return $this->getGegnerMannschaftString();}
	}

	public function getXHTML()
	{
		$filename = dirname(__FILE__).'/../../../inhalte/schnipsel/allgemein/sni_sperml.php';
		$Mannschaft = $this->getMannschaftID(GET_OFID);
		$Saison = (string)$Mannschaft->getSaisonID(GET_OFID);
		$Bezirk = 'Schwaben';
		$Spielklasse = (string)$Mannschaft->getLigaKlasseID(GET_OFID);
		$HVerein = $this->getHeimMannschaftString();
		$GVerein = $this->getGastMannschaftString();
		$SpErMl = $this;
		if(is_file($filename)) {
			ob_start();
			include $filename;
			$contents = ob_get_contents();
			ob_end_clean();
			return $contents;
		}
	}

	/*@}*/
}
?>