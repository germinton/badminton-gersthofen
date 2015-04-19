<?php
include_once(dirname(__FILE__).'/../datenbank/class_drive_entity.php');
include_once(dirname(__FILE__).'/class_austragungsort.php');

/*******************************************************************************************************************//**
 * Repräsentation eines Turniers.
 * @ingroup grp_recordset
 **********************************************************************************************************************/
class CTurnier extends CDriveEntity
{
	/*****************************************************************************************************************//**
	 * @name Tabellenname
	 **************************************************************************************************************//*@{*/

	const mcTabName = 'turniere';

	/*@}*/

	/*****************************************************************************************************************//**
	 * @name Tabellenspalten
	 **************************************************************************************************************//*@{*/

	private $mDatumVon;
	private $mDatumBis;
	private $mBezeichnung;
	private $mAustragungsortID;
	private $mEbene;
	private $mHRichtung;
	private $mTurniertyp;

	/*@}*/

	/*****************************************************************************************************************//**
	 * @name Magics
	 **************************************************************************************************************//*@{*/

	public function __construct($TurnierID = 0) {
		parent::__construct(self::mcTabName, $TurnierID);
	}

	public function __toString()
	{
		if(!$this->getTurnierID()) {return 'Kein Turnier';}
		return $this->mBezeichnung;
	}

	/*@}*/

	/*****************************************************************************************************************//**
	 * @name Setter
	 **************************************************************************************************************//*@{*/

	public function setInitVals()
	{
		parent::setInitVals();
		$this->mDatumVon = '';
		$this->mDatumBis = null;
		$this->mBezeichnung = '';
		$this->mAustragungsortID = 0;
		$this->mEbene = null;
		$this->mTurniertyp = null;
	}

	final public function setTurnierID($TurnierID) {
		CDriveEntity::setID($TurnierID);
	}

	final public function setDatumVon($DatumVon) {
		$this->mDatumVon = trim((string)$DatumVon);
	}

	final public function setDatumBis($DatumBis) {
		$this->mDatumBis = (($s = trim((string)$DatumBis))?($s):(null));
	}

	final public function setBezeichnung($Bezeichnung) {
		$this->mBezeichnung = htmlspecialchars(trim((string)$Bezeichnung));
	}

	final public function setAustragungsortID($AustragungsortID) {
		$this->mAustragungsortID = (int)$AustragungsortID;
	}

	final public function setEbene($Ebene) {
		$this->mEbene = (($i = (int)$Ebene)?($i):(null));
	}

	final public function setHRichtung($HRichtung) {
		$this->mHRichtung = (($i = (int)$HRichtung)?($i):(null));
	}

	final public function setTurniertyp($Turniertyp) {
		$this->mTurniertyp = (($i = (int)$Turniertyp)?($i):(null));
	}

	/*@}*/

	/*****************************************************************************************************************//**
	 * @name Getter
	 **************************************************************************************************************//*@{*/

	final public function getTurnierID()
	{
		return CDriveEntity::getID();
	}

	final public function getDatumVon($FlagVariant = array())
	{
		$FlagArray = (array)$FlagVariant;
		return ((in_array(GET_DTDE, $FlagArray))?(S2S_Datum_MySql2Deu($this->mDatumVon)):($this->mDatumVon));
	}

	final public function getDatumBis($FlagVariant = array())
	{
		$FlagArray = (array)$FlagVariant;
		$Datum = ((in_array(GET_DTDE, $FlagArray))?(S2S_Datum_MySql2Deu($this->mDatumBis)):($this->mDatumBis));
		return ((is_null($v = $Datum) and in_array(GET_NBSP, $FlagArray))?('&nbsp;'):($v));
	}

	final public function getBezeichnung()
	{
		return $this->mBezeichnung;
	}

	final public function getAustragungsortID($FlagVariant = array())
	{
		$FlagArray = (array)$FlagVariant;
		return ((in_array(GET_OFID, $FlagArray))?(new CAustragungsort($this->mAustragungsortID)):($this->mAustragungsortID));
	}

	final public function getEbene($FlagVariant = array())
	{
		$FlagArray = (array)$FlagVariant;
		if(in_array(GET_C2SC, $FlagArray)) {$Ebene = C2S_Ebene($this->mEbene);}
		else {$Ebene = $this->mEbene;}
		return ((is_null($v = $Ebene) and in_array(GET_NBSP, $FlagArray))?('&nbsp;'):($v));
	}

	final public function getHRichtung($FlagVariant = array())
	{
		$FlagArray = (array)$FlagVariant;
		if(in_array(GET_C2SC, $FlagArray)) {$HRichtung = C2S_HRichtung($this->mHRichtung);}
		else {$HRichtung = $this->mHRichtung;}
		return ((is_null($v = $HRichtung) and in_array(GET_NBSP, $FlagArray))?('&nbsp;'):($v));
	}

	final public function getTurniertyp($FlagVariant = array())
	{
		$FlagArray = (array)$FlagVariant;
		if(in_array(GET_C2SC, $FlagArray)) {$Turniertyp = C2S_Turniertyp($this->mTurniertyp);}
		else {$Turniertyp = $this->mTurniertyp;}
		return ((is_null($v = $Turniertyp) and in_array(GET_NBSP, $FlagArray))?('&nbsp;'):($v));
	}

	/*@}*/

	/*****************************************************************************************************************//**
	 * @name Datenbank
	 **************************************************************************************************************//*@{*/

	public static function isValidID($TurnierID) {
		return CDriveEntity::genericIsValidID(self::mcTabName, $TurnierID);
	}

	public function load($TurnierID)
	{
		self::setInitVals();
		$this->setTurnierID($TurnierID);
		$format = 'SELECT datumvon, datumbis, bezeichnung, austragungsort_id, ebene, hrichtung, turniertyp '.
		          'FROM turniere WHERE turnier_id=%s';
		$query = sprintf($format, $this->getTurnierID());
		if(!$result = mysql_query($query)) {throw new Exception(mysql_error(CDriveEntity::getDB()));}
		$row = mysql_fetch_row($result);
		if(!$row) {throw new Exception('Turnier mit turnier_id='.$TurnierID.' nicht gefunden!');}
		$this->mDatumVon = lS($row[0]);
		$this->mDatumBis = lS($row[1]);
		$this->mBezeichnung = lS($row[2]);
		$this->mAustragungsortID = lD($row[3]);
		$this->mEbene = lD($row[4]);
		$this->mHRichtung = lD($row[5]);
		$this->mTurniertyp = lD($row[6]);
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
			$format = 'UPDATE turniere SET '.
			          'datumvon=%s, datumbis=%s, bezeichnung=%s, austragungsort_id=%s, ebene=%s, hrichtung=%s, '.
			          'turniertyp=%s '.
			          'WHERE turnier_id=%s';
			$query = sprintf($format, sS($this->mDatumVon), sS($this->mDatumBis), sS($this->mBezeichnung),
			sD($this->mAustragungsortID), sD($this->mEbene), sD($this->mHRichtung), sD($this->mTurniertyp), $this->getID());
		}
		else
		{
			$format = 'INSERT INTO turniere ('.
			          'datumvon, datumbis, bezeichnung, austragungsort_id, ebene, hrichtung, turniertyp '.
			          ') VALUES (%s, %s, %s, %s, %s, %s, %s)';
			$query = sprintf($format, sS($this->mDatumVon), sS($this->mDatumBis), sS($this->mBezeichnung),
			sD($this->mAustragungsortID), sD($this->mEbene), sD($this->mHRichtung), sD($this->mTurniertyp));
		}
		if(!$result = mysql_query($query)) {throw new Exception(mysql_error(CDriveEntity::getDB()));}

		// Basisklasse
		parent::store();
	}

	public function check()
	{
		// DatumVon
		if(!(preg_match(REGEX_DATE_SQ, $this->mDatumVon)
		and preg_match(REGEX_DATE_DE, $this->getDatumVon(GET_DTDE)))) {
			CDriveEntity::addCheckMsg('Das Turnierbeginn-Datum muss von der Form \'TT.MM.JJJJ\' sein.');
		}
		else if(!checkdate(
		substr($this->mDatumVon, 5, 2), substr($this->mDatumVon, 8, 2), substr($this->mDatumVon, 0, 4))) {
			CDriveEntity::addCheckMsg('Das Turnierbeginn-Datum is ungültig.');
		}

		// DatumBis
		if(!is_null($this->mDatumBis))
		{
			if(!(preg_match(REGEX_DATE_SQ, $this->mDatumBis)
			and preg_match(REGEX_DATE_DE, $this->getDatumBis(GET_DTDE)))) {
				CDriveEntity::addCheckMsg('Das Turnierende-Datum muss von der Form \'TT.MM.JJJJ\' sein.');
			}
			else if(!checkdate(
			substr($this->mDatumBis, 5, 2), substr($this->mDatumBis, 8, 2), substr($this->mDatumBis, 0, 4))) {
				CDriveEntity::addCheckMsg('Das Turnierende-Datum is ungültig.');
			}
		}

		// Bezeichnung
		if(!(strlen($this->mBezeichnung) >= 1 and strlen($this->mBezeichnung) <= 50)) {
			CDriveEntity::addCheckMsg('Die Turnierbezeichnung muss mind. 1 bis max. 50 Zeichen lang sein.');
		}

		// AustragungsortID
		if(!CAustragungsort::isValidID($this->mAustragungsortID)) {
			CDriveEntity::addCheckMsg('Die austragungsort_id ist ungültig.');
		}

		// Ebene
		if(!is_null($this->mEbene))
		{
			if(is_null(C2S_Ebene($this->mEbene))) {
				CDriveEntity::addCheckMsg('Die Turnierebene ist ungültig.');
			}
		}

		// HRichtung
		if(!is_null($this->mHRichtung))
		{
			if(is_null(C2S_HRichtung($this->mHRichtung))) {
				CDriveEntity::addCheckMsg('Die Himmelsrichtung ist ungültig.');
			}
		}

		// Turniertyp
		if(!is_null($this->mTurniertyp))
		{
			if(!(S_MEISTERSCHAFT == $this->mTurniertyp or S_RANGLISTE == $this->mTurniertyp)) {
				CDriveEntity::addCheckMsg('Der Turniertyp ist ungültig.');
			}
		}
	}

	/*@}*/
}
?>