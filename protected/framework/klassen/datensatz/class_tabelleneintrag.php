<?php
include_once(dirname(__FILE__).'/../datenbank/class_drive_entity.php');

/*******************************************************************************************************************//**
 * Repräsentation eines Ergebnistabelleneintrags.
 * @ingroup grp_recordset
 **********************************************************************************************************************/
class CTabelleneintrag extends CDriveEntity
{
	/*****************************************************************************************************************//**
	 * @name Tabellenname
	 **************************************************************************************************************//*@{*/

	const mcTabName = 'tabelleneintraege';

	/*@}*/

	/*****************************************************************************************************************//**
	 * @name Tabellenspalten
	 **************************************************************************************************************//*@{*/

	private $mTabelleID;
	private $mPlatz;
	private $mMannschaft;
	private $mBemerkung;
	private $mAnzahlSpiele;
	private $mPunkte1;
	private $mPunkte3;
	private $mSpiele1;
	private $mSpiele3;
	private $mSaetze1;
	private $mSaetze3;

	/*@}*/

	/*****************************************************************************************************************//**
	 * @name Magics
	 **************************************************************************************************************//*@{*/

	public function __construct($TabelleneintragID = 0) {
		parent::__construct(self::mcTabName, $TabelleneintragID);
	}

	public function __toString()
	{
		if(!$this->getTabelleneintragID()) {return 'Kein Tabelleneintrag';}
		return $this->mPlatz.' - '.$this->mMannschaft;
	}

	/*@}*/

	/*****************************************************************************************************************//**
	 * @name Setter
	 **************************************************************************************************************//*@{*/

	public function setInitVals()
	{
		parent::setInitVals();
		$this->mTabelleID = 0;
		$this->mPlatz = 0;
		$this->mMannschaft = '';
		$this->mBemerkung = null;
		$this->mAnzahlSpiele = null;
		$this->mPunkte1 = null;
		$this->mPunkte3 = null;
		$this->mSpiele1 = null;
		$this->mSpiele3 = null;
		$this->mSaetze1 = null;
		$this->mSaetze3 = null;
	}

	final public function setTabelleneintragID($TabelleneintragID) {
		CDriveEntity::setID($TabelleneintragID);
	}

	final public function setTabelleID($TabelleID) {
		$this->mTabelleID = (int)$TabelleID;
	}

	final public function setPlatz($Platz) {
		$this->mPlatz = (int)$Platz;
	}

	final public function setMannschaft($Mannschaft) {
		$this->mMannschaft = htmlspecialchars(trim((string)$Mannschaft));
	}

	final public function setBemerkung($Bemerkung) {
		$this->mBemerkung = (($s = htmlspecialchars(trim((string)$Bemerkung)))?($s):(null));
	}

	final public function setAnzahlSpiele($AnzahlSpiele) {
		$this->mAnzahlSpiele = (($i = (int)$AnzahlSpiele)?($i):(null));
	}

	final public function setPunkte1($Punkte1) {
		$this->mPunkte1 = (($i = (int)$Punkte1)?($i):(null));
	}

	final public function setPunkte3($Punkte3) {
		$this->mPunkte3 = (($i = (int)$Punkte3)?($i):(null));
	}

	final public function setSpiele1($Spiele1) {
		$this->mSpiele1 = (($i = (int)$Spiele1)?($i):(null));
	}

	final public function setSpiele3($Spiele3) {
		$this->mSpiele3 = (($i = (int)$Spiele3)?($i):(null));
	}

	final public function setSaetze1($Saetze1) {
		$this->mSaetze1 = (($i = (int)$Saetze1)?($i):(null));
	}

	final public function setSaetze3($Saetze3) {
		$this->mSaetze3 = (($i = (int)$Saetze3)?($i):(null));
	}

	/*@}*/

	/*****************************************************************************************************************//**
	 * @name Getter
	 **************************************************************************************************************//*@{*/

	final public function getTabelleneintragID()
	{
		return CDriveEntity::getID();
	}

	final public function getTabelleID($FlagVariant = array())
	{
		$FlagArray = (array)$FlagVariant;
		return ((in_array(GET_OFID, $FlagArray))?(new CTabelle($this->mTabelleID)):($this->mTabelleID));
	}

	final public function getPlatz()
	{
		return $this->mPlatz;
	}

	final public function getMannschaft($FlagVariant = array())
	{
		$FlagArray = (array)$FlagVariant;
		if(in_array(GET_CLIP, $FlagArray) and (strlen($this->mMannschaft) > 25)) {return substr($this->mMannschaft, 0, 25).'...';}
		return $this->mMannschaft;
	}

	final public function getBemerkung($FlagVariant = array())
	{
		$FlagArray = (array)$FlagVariant;
		return ((is_null($v = $this->mBemerkung) and in_array(GET_NBSP, $FlagArray))?('&nbsp;'):($v));
	}

	final public function getAnzahlSpiele($FlagVariant = array())
	{
		$FlagArray = (array)$FlagVariant;
		return ((is_null($v = $this->mAnzahlSpiele) and in_array(GET_NBSP, $FlagArray))?('&nbsp;'):($v));
	}

	final public function getPunkte1($FlagVariant = array())
	{
		$FlagArray = (array)$FlagVariant;
		return ((is_null($v = $this->mPunkte1) and in_array(GET_NBSP, $FlagArray))?('&nbsp;'):($v));
	}

	final public function getPunkte3($FlagVariant = array())
	{
		$FlagArray = (array)$FlagVariant;
		return ((is_null($v = $this->mPunkte3) and in_array(GET_NBSP, $FlagArray))?('&nbsp;'):($v));
	}

	final public function getSpiele1($FlagVariant = array())
	{
		$FlagArray = (array)$FlagVariant;
		return ((is_null($v = $this->mSpiele1) and in_array(GET_NBSP, $FlagArray))?('&nbsp;'):($v));
	}

	final public function getSpiele3($FlagVariant = array())
	{
		$FlagArray = (array)$FlagVariant;
		return ((is_null($v = $this->mSpiele3) and in_array(GET_NBSP, $FlagArray))?('&nbsp;'):($v));
	}

	final public function getSaetze1($FlagVariant = array())
	{
		$FlagArray = (array)$FlagVariant;
		return ((is_null($v = $this->mSaetze1) and in_array(GET_NBSP, $FlagArray))?('&nbsp;'):($v));
	}

	final public function getSaetze3($FlagVariant = array())
	{
		$FlagArray = (array)$FlagVariant;
		return ((is_null($v = $this->mSaetze3) and in_array(GET_NBSP, $FlagArray))?('&nbsp;'):($v));
	}

	/*@}*/

	/*****************************************************************************************************************//**
	 * @name Datenbank
	 **************************************************************************************************************//*@{*/

	public static function isValidID($TabelleneintragID) {
		return CDriveEntity::genericIsValidID(self::mcTabName, $TabelleneintragID);
	}

	public function load($TabelleneintragID)
	{
		self::setInitVals();
		$this->setTabelleneintragID($TabelleneintragID);
		$format = 'SELECT tabelle_id, platz, mannschaft, bemerkung, anzahlspiele, punkte_1, punkte_3, spiele_1, spiele_3, '.
		          'saetze_1, saetze_3 '.
		          'FROM tabelleneintraege WHERE tabelleneintrag_id=%s';
		$query = sprintf($format, $this->getTabelleneintragID());
		if(!$result = mysqli_query(CDriveEntity::getDB(), $query)) {throw new Exception(mysqli_error(CDriveEntity::getDB()));}
		$row = mysqli_fetch_row($result);
		if(!$row) {throw new Exception('Tabelleneintrag mit tabelleneintrag_id='.$TabelleneintragID.' nicht gefunden!');}
		$this->mTabelleID= lD($row[0]);
		$this->mPlatz = lD($row[1]);
		$this->mMannschaft = lS($row[2]);
		$this->mBemerkung = lS($row[3]);
		$this->mAnzahlSpiele = lD($row[4]);
		$this->mPunkte1 = lD($row[5]);
		$this->mPunkte3 = lD($row[6]);
		$this->mSpiele1 = lD($row[7]);
		$this->mSpiele3 = lD($row[8]);
		$this->mSaetze1 = lD($row[9]);
		$this->mSaetze3 = lD($row[10]);
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
			$format = 'UPDATE tabelleneintraege SET '.
			          'tabelle_id=%s, platz=%s, mannschaft=%s, bemerkung=%s, anzahlspiele=%s, punkte_1=%s, punkte_3=%s, '.
			          'spiele_1=%s, spiele_3=%s, saetze_1=%s, saetze_3=%s '.
			          'WHERE tabelleneintrag_id=%s';
			$query = sprintf($format, sD($this->mTabelleID), sD($this->mPlatz), sS($this->mMannschaft), sS($this->mBemerkung),
			sD($this->mAnzahlSpiele), sD($this->mPunkte1), sD($this->mPunkte3), sD($this->mSpiele1), sD($this->mSpiele3),
			sD($this->mSaetze1), sD($this->mSaetze3), $this->getID());
		}
		else
		{
			$format = 'INSERT INTO tabelleneintraege ('.
			          'tabelle_id, platz, mannschaft, bemerkung, anzahlspiele, punkte_1, punkte_3, spiele_1, spiele_3,'.
			          'saetze_1, saetze_3'.
			          ') VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s)';
			$query = sprintf($format, sD($this->mTabelleID), sD($this->mPlatz), sS($this->mMannschaft), sS($this->mBemerkung),
			sD($this->mAnzahlSpiele), sD($this->mPunkte1), sD($this->mPunkte3), sD($this->mSpiele1), sD($this->mSpiele3),
			sD($this->mSaetze1), sD($this->mSaetze3));
		}
		if(!$result = mysqli_query(CDriveEntity::getDB(), $query)) {throw new Exception(mysqli_error(CDriveEntity::getDB()));}

		// Basisklasse
		parent::store();
	}

	public function check($CheckForeignKey = true)
	{
		// TabelleID
		if($CheckForeignKey and !CTabelle::isValidID($this->mTabelleID)) {
			CDriveEntity::addCheckMsg('Die tabelle_id ist ungültig.');
		}

		// Platz
		if(!($this->mPlatz >= 1 and $this->mPlatz <= MAX_ERG_TAB_PLAETZE)) {
			CDriveEntity::addCheckMsg('Der Tabellenplatz muss zwischen 1 und '.MAX_ERG_TAB_PLAETZE.' liegen.');
		}

		// Mannschaft
		if(!(strlen($this->mMannschaft) >= 1 and strlen($this->mMannschaft) <= 50)) {
			CDriveEntity::addCheckMsg('Die Mannschaft muss mind. 1 bis max. 100 Zeichen lang sein.');
		}

		// Bemerkung
		if(!is_null($this->mBemerkung))
		{
			if(strlen($this->mBemerkung) > 20) {
				CDriveEntity::addCheckMsg('Die Bemerkung darf nicht länger als 20 Zeichen sein.');
			}
		}

		// AnzahlSpiele
		if(!is_null($i = $this->mAnzahlSpiele) and !($i >= 1 and $i <= MAX_ERG_TAB_ANZ_SPIELE)) {
			CDriveEntity::addCheckMsg('Die Anzahl an Spielen muss zwischen 1 und '.MAX_ERG_TAB_ANZ_SPIELE.' liegen.');
		}

		// Punkte1
		if(!is_null($i = $this->mPunkte1) and !($i >= 1 and $i <= MAX_ERG_TAB_PUNKTE)) {
			CDriveEntity::addCheckMsg('Die gewonnenen Punkte müssen zwischen 1 und '.MAX_ERG_TAB_PUNKTE.' liegen.');
		}

		// Punkte3
		if(!is_null($i = $this->mPunkte3) and !($i >= 1 and $i <= MAX_ERG_TAB_PUNKTE)) {
			CDriveEntity::addCheckMsg('Die verlorenen Punkte müssen zwischen 1 und '.MAX_ERG_TAB_PUNKTE.' liegen.');
		}

		// Spiele1
		if(!is_null($i = $this->mSpiele1) and !($i >= 1 and $i <= MAX_ERG_TAB_SPIELE)) {
			CDriveEntity::addCheckMsg('Die gewonnenen Spiele müssen zwischen 1 und '.MAX_ERG_TAB_SPIELE.' liegen.');
		}

		// Spiele3
		if(!is_null($i = $this->mSpiele3) and !($i >= 1 and $i <= MAX_ERG_TAB_SPIELE)) {
			CDriveEntity::addCheckMsg('Die verlorenen Spiele müssen zwischen 1 und '.MAX_ERG_TAB_SPIELE.' liegen.');
		}

		// Saetze1
		if(!is_null($i = $this->mSaetze1) and !($i >= 1 and $i <= MAX_ERG_TAB_SAETZE)) {
			CDriveEntity::addCheckMsg('Die gewonnenen Sätze müssen zwischen 1 und '.MAX_ERG_TAB_SAETZE.' liegen.');
		}

		// Saetze3
		if(!is_null($i = $this->mSaetze3) and !($i >= 1 and $i <= MAX_ERG_TAB_SAETZE)) {
			CDriveEntity::addCheckMsg('Die verlorenen Sätze müssen zwischen 1 und '.MAX_ERG_TAB_SAETZE.' liegen.');
		}
	}

	/*@}*/
}
?>