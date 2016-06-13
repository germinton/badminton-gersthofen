<?php
include_once(dirname(__FILE__).'/../datenbank/class_drive_entity.php');

/*******************************************************************************************************************//**
 * Repräsentation einer Saison.
 * @ingroup grp_recordset
 **********************************************************************************************************************/
class CSaison extends CDriveEntity
{
	/*****************************************************************************************************************//**
	 * @name Tabellenname
	 **************************************************************************************************************//*@{*/

	const mcTabName = 'saisons';

	/*@}*/

	/*****************************************************************************************************************//**
	 * @name Tabellenspalten
	 **************************************************************************************************************//*@{*/

	private $mSpielregel;
	private $mBeginn;
	private $mEnde;

	/*@}*/

	/*****************************************************************************************************************//**
	 * @name Magics
	 **************************************************************************************************************//*@{*/

	public function __construct($SaisonID = 0) {
		parent::__construct(self::mcTabName, $SaisonID);
	}

	public function __toString()
	{
		if(!$this->getSaisonID()) {return 'Keine Saison';}
		return substr($this->mBeginn, 0, 4).'/'.substr($this->mEnde, 0, 4);
	}

	/*@}*/

	/*****************************************************************************************************************//**
	 * @name Setter
	 **************************************************************************************************************//*@{*/

	public function setInitVals()
	{
		parent::setInitVals();
		$this->mSpielregel = 0;
		$this->mBeginn = '';
		$this->mEnde = '';
	}

	final public function setSaisonID($SaisonID) {
		CDriveEntity::setID($SaisonID);
	}

	final public function setSpielregel($Spielregel) {
		$this->mSpielregel = (int)$Spielregel;
	}
	final public function setBeginn($Beginn) {
		$this->mBeginn = trim((string)$Beginn);
	}
	final public function setEnde($Ende) {
		$this->mEnde = trim((string)$Ende);
	}

	/*@}*/

	/*****************************************************************************************************************//**
	 * @name Getter
	 **************************************************************************************************************//*@{*/

	final public function getSaisonID()
	{
		return CDriveEntity::getID();
	}

	final public function getSpielregel($FlagVariant = array())
	{
		$FlagArray = (array)$FlagVariant;
		return ((in_array(GET_C2SC, $FlagArray))?(C2S_Spielregel($this->mSpielregel)):($this->mSpielregel));
	}

	final public function getBeginn($FlagVariant = array())
	{
		$FlagArray = (array)$FlagVariant;
		return ((in_array(GET_DTDE, $FlagArray))?(S2S_Datum_MySql2Deu($this->mBeginn)):($this->mBeginn));
	}

	final public function getEnde($FlagVariant = array())
	{
		$FlagArray = (array)$FlagVariant;
		return ((in_array(GET_DTDE, $FlagArray))?(S2S_Datum_MySql2Deu($this->mEnde)):($this->mEnde));
	}

	/*@}*/

	/*****************************************************************************************************************//**
	 * @name Datenbank
	 **************************************************************************************************************//*@{*/

	public static function isValidID($SaisonID) {
		return CDriveEntity::genericIsValidID(self::mcTabName, $SaisonID);
	}

	public function load($SaisonID)
	{
		self::setInitVals();
		$this->setSaisonID($SaisonID);
		$format = 'SELECT spielregel, beginn, ende '.
		          'FROM saisons WHERE saison_id=%s';
		$query = sprintf($format, $this->getSaisonID());
		if(!$result = mysqli_query(CDriveEntity::getDB(), $query)) {throw new Exception(mysqli_error(CDriveEntity::getDB()));}
		$row = mysqli_fetch_row($result);
		if(!$row) {throw new Exception('Saison mit saison_id='.$SaisonID.' nicht gefunden!');}
		$this->mSpielregel = lD($row[0]);
		$this->mBeginn = lS($row[1]);
		$this->mEnde = lS($row[2]);
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
			$format = 'UPDATE saisons SET '.
			          'spielregel=%s, beginn=%s, ende=%s '.
			          'WHERE saison_id=%s';
			$query = sprintf($format, sD($this->mSpielregel), sS($this->mBeginn), sS($this->mEnde), $this->getID());
		}
		else
		{
			$format = 'INSERT INTO saisons ('.
			          'spielregel, beginn, ende'.
			          ') VALUES (%s, %s, %s)';
			$query = sprintf($format, sD($this->mSpielregel), sS($this->mBeginn), sS($this->mEnde));
		}
		if(!$result = mysqli_query(CDriveEntity::getDB(), $query)) {throw new Exception(mysqli_error(CDriveEntity::getDB()));}

		// Basisklasse
		parent::store();
	}

	public function check()
	{
		// Spielregel
		if(is_null(C2S_Spielregel($this->mSpielregel))) {
			CDriveEntity::addCheckMsg('Die Spielregel ist ungültig.');
		}

		// Beginn
		if(!(preg_match(REGEX_DATE_SQ, $this->mBeginn)
		and preg_match(REGEX_DATE_DE, $this->getBeginn(GET_DTDE)))) {
			CDriveEntity::addCheckMsg('Das Saisonbeginndatum muss von der Form \'TT.MM.JJJJ\' sein.');
		}
		else if(!checkdate(
		substr($this->mBeginn, 5, 2), substr($this->mBeginn, 8, 2), substr($this->mBeginn, 0, 4))) {
			CDriveEntity::addCheckMsg('Das Saisonbeginndatum is ungültig.');
		}

		// Ende
		if(!(preg_match(REGEX_DATE_SQ, $this->mEnde)
		and preg_match(REGEX_DATE_DE, $this->getEnde(GET_DTDE)))) {
			CDriveEntity::addCheckMsg('Das Saisonendedatum muss von der Form \'TT.MM.JJJJ\' sein.');
		}
		else if(!checkdate(
		substr($this->mEnde, 5, 2), substr($this->mEnde, 8, 2), substr($this->mEnde, 0, 4))) {
			CDriveEntity::addCheckMsg('Das Saisonendedatum is ungültig.');
		}

		// Beginn und Ende
		if($this->mEnde < $this->mBeginn) {
			CDriveEntity::addCheckMsg('Das Saisonende muss zeitlich nach dem Saisonbeginn liegen.');
		}
	}

	/*@}*/

	/*****************************************************************************************************************//**
	 * @name Verschiedenes
	 **************************************************************************************************************//*@{*/

	public function isDeletable()
	{
		/*
		 * In welchen Tabellen wird eine saison_id eingetragen und wie kritisch ist diese Tabelle?
		 *
		 * mannschaften....kritisch (weitere Abhängigkeiten, wie z.B. die Spielergebnismeldungen.)
		 * tabellen........kritisch (alle Informationen, z. B für Archivzwecke, wären verloren.)
		 */

		$Zaehler = 0;

		$query = 'SELECT COUNT(*) FROM mannschaften WHERE saison_id='.$this->getSaisonID();
		if(!$result = mysqli_query(CDriveEntity::getDB(), $query)) {
			throw new Exception(mysqli_error(CDriveEntity::getDB()));
		}
		$row = mysqli_fetch_row($result);
		$Zaehler += (int)$row[0];

		$query = 'SELECT COUNT(*) FROM tabellen WHERE saison_id='.$this->getSaisonID();
		if(!$result = mysqli_query(CDriveEntity::getDB(), $query)) {
			throw new Exception(mysqli_error(CDriveEntity::getDB()));
		}
		$row = mysqli_fetch_row($result);
		$Zaehler += (int)$row[0];

		return (($Zaehler)?(false):(true));
	}

	/*@}*/
}
?>