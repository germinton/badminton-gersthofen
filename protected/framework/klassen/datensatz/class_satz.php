<?php
include_once(dirname(__FILE__).'/../datenbank/class_drive_entity.php');
include_once(dirname(__FILE__).'/class_spiel.php');

/*******************************************************************************************************************//**
 * Repräsentation eines Satzes.
 * @ingroup grp_recordset
 **********************************************************************************************************************/
class CSatz extends CDriveEntity
{
	/*****************************************************************************************************************//**
	 * @name Tabellenname
	 **************************************************************************************************************//*@{*/

	const mcTabName = 'saetze';

	/*@}*/

	/*****************************************************************************************************************//**
	 * @name Tabellenspalten
	 **************************************************************************************************************//*@{*/

	private $mSpielID;
	private $mNr;
	private $mHeimP;
	private $mGastP;

	/*@}*/

	/*****************************************************************************************************************//**
	 * @name Magics
	 **************************************************************************************************************//*@{*/

	public function __construct($SatzID = 0) {
		parent::__construct(self::mcTabName, $SatzID);
	}

	public function __toString()
	{
		if(!$this->getSatzID()) {return 'Kein Satz';}
		return $this->mNr.'. Satz: '.$this->getPunkteString();
	}

	/*@}*/

	/*****************************************************************************************************************//**
	 * @name Setter
	 **************************************************************************************************************//*@{*/

	public function setInitVals()
	{
		parent::setInitVals();
		$this->mSpielID = 0;
		$this->mNr = 0;
		$this->mHeimP = 0;
		$this->mGastP = 0;
	}

	final public function setSatzID($SatzID) {
		CDriveEntity::setID($SatzID);
	}

	final public function setSpielID($SpielID) {
		$this->mSpielID = (int)$SpielID;
	}
	final public function setNr($Nr) {
		$this->mNr = (int)$Nr;
	}
	final public function setHeimP($HeimP) {
		$this->mHeimP = (int)$HeimP;
	}
	final public function setGastP($GastP) {
		$this->mGastP = (int)$GastP;
	}

	/*@}*/

	/*****************************************************************************************************************//**
	 * @name Getter
	 **************************************************************************************************************//*@{*/

	final public function getSatzID()
	{
		return CDriveEntity::getID();
	}

	final public function getSpielID()
	{
		return $this->mSpielID;
	}

	final public function getNr()
	{
		return $this->mNr;
	}

	final public function getHeimP()
	{
		return $this->mHeimP;
	}

	final public function getGastP()
	{
		return $this->mGastP;
	}

	/*@}*/

	/*****************************************************************************************************************//**
	 * @name Datenbank
	 **************************************************************************************************************//*@{*/

	public static function isValidID($SatzID) {
		return CDriveEntity::genericIsValidID(self::mcTabName, $SatzID);
	}

	public function load($SatzID)
	{
		self::setInitVals();
		$this->setSatzID($SatzID);
		$format = 'SELECT spiel_id, nr, heimp, gastp '.
		          'FROM saetze WHERE satz_id=%s';
		$query = sprintf($format, $this->getSatzID());
		if(!$result = mysql_query($query)) {throw new Exception(mysql_error(CDriveEntity::getDB()));}
		$row = mysql_fetch_row($result);
		if(!$row) {throw new Exception('Satz mit satz_id='.$SatzID.' nicht gefunden!');}
		$this->mSpielID = lD($row[0]);
		$this->mNr = lD($row[1]);
		$this->mHeimP = lD($row[2]);
		$this->mGastP = lD($row[3]);
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
			$format = 'UPDATE saetze SET '.
			          'spiel_id=%s, nr=%s, heimp=%s, gastp=%s '.
			          'WHERE satz_id=%s';
			$query = sprintf($format, sD($this->mSpielID), sD($this->mNr), sD($this->mHeimP), sD($this->mGastP),
			$this->getID());
		}
		else
		{
			$format = 'INSERT INTO saetze ('.
			          'spiel_id, nr, heimp, gastp'.
			          ') VALUES (%s, %s, %s, %s)';
			$query = sprintf($format, sD($this->mSpielID), sD($this->mNr), sD($this->mHeimP), sD($this->mGastP));
		}
		if(!$result = mysql_query($query)) {throw new Exception(mysql_error(CDriveEntity::getDB()));}

		// Basisklasse
		parent::store();
	}

	public function check($CheckForeignKey = true)
	{
		// SpielID
		if($CheckForeignKey and !CSpiel::isValidID($this->mSpielID)) {
			CDriveEntity::addCheckMsg('Die spiel_id ist ungültig.');
		}

		// Nr
		if(!($this->mNr >= 1 and $this->mNr <= MAX_SAETZE)) {
			CDriveEntity::addCheckMsg('Die Satznummer muss zwischen 1 und '.MAX_SAETZE.' liegen.');
		}

		// HeimP
		if(!($this->mHeimP >= 0 and $this->mHeimP <= MAX_PUNKTE)) {
			CDriveEntity::addCheckMsg('Die Punkte des Heim-Athleten müssen zwischen 0 und '.MAX_PUNKTE.' liegen.');
		}

		// GastP
		if(!($this->mGastP >= 0 and $this->mGastP <= MAX_PUNKTE)) {
			CDriveEntity::addCheckMsg('Die Punkte des Gast-Athleten müssen zwischen 0 und '.MAX_PUNKTE.' liegen.');
		}
	}

	/*@}*/

	/*****************************************************************************************************************//**
	 * @name Verschiedenes
	 **************************************************************************************************************//*@{*/

	public function setPunkte($HeimP, $GastP)
	{
		$this->setHeimP($HeimP);
		$this->setGastP($GastP);
	}

	public function swapPunkte()
	{
		$tmp = $this->getHeimP();
		$this->setHeimP($this->getGastP());
		$this->setGastP($tmp);
	}

	public function getErgebnis($FlagVariant = array())
	{
		$FlagArray = (array)$FlagVariant;
		$Ergebnis = C_UNENTSCH;
		if     ($this->mHeimP > $this->mGastP) {$Ergebnis = C_HEIMGEW;}
		else if($this->mHeimP < $this->mGastP) {$Ergebnis = C_GASTGEW;}
		return ((in_array(GET_C2SC, $FlagArray))?(C2S_Ergebnis($Ergebnis)):($Ergebnis));
	}

	public function getPunkteString()
	{
		return $this->mHeimP.':'.$this->mGastP;
	}

	/*@}*/
}
?>