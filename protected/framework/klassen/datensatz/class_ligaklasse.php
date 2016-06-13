<?php
include_once(dirname(__FILE__).'/../datenbank/class_drive_entity.php');

/*******************************************************************************************************************//**
 * Repräsentation einer Liga oder Klasse.
 * @ingroup grp_recordset
 **********************************************************************************************************************/
class CLigaKlasse extends CDriveEntity
{
	/*****************************************************************************************************************//**
	 * @name Tabellenname
	 **************************************************************************************************************//*@{*/

	const mcTabName = 'ligenklassen';

	/*@}*/

	/*****************************************************************************************************************//**
	 * @name Tabellenspalten
	 **************************************************************************************************************//*@{*/

	private $mBezeichnung;
	private $mAKlaGruppe;

	/*@}*/

	/*****************************************************************************************************************//**
	 * @name Magics
	 **************************************************************************************************************//*@{*/

	public function __construct($LigaKlasseID = 0) {
		parent::__construct(self::mcTabName, $LigaKlasseID);
	}

	public function __toString()
	{
		if(!$this->getLigaKlasseID()) {return 'Keine LigaKlasse';}
		return $this->mBezeichnung;
	}

	/*@}*/

	/*****************************************************************************************************************//**
	 * @name Setter
	 **************************************************************************************************************//*@{*/

	public function setInitVals()
	{
		parent::setInitVals();
		$this->mBezeichnung = '';
		$this->mAKlaGruppe = 0;
	}

	final public function setLigaKlasseID($LigaKlasseID) {
		CDriveEntity::setID($LigaKlasseID);
	}

	final public function setBezeichnung($Bezeichnung) {
		$this->mBezeichnung = htmlspecialchars(trim((string)$Bezeichnung));
	}
	final public function setAKlaGruppe($AKlaGruppe) {
		$this->mAKlaGruppe = (int)$AKlaGruppe;
	}

	/*@}*/

	/*****************************************************************************************************************//**
	 * @name Getter
	 **************************************************************************************************************//*@{*/

	final public function getLigaKlasseID()
	{
		return CDriveEntity::getID();
	}

	final public function getBezeichnung()
	{
		return $this->mBezeichnung;
	}

	final public function getAKlaGruppe($FlagVariant = array())
	{
		$FlagArray = (array)$FlagVariant;
		return ((in_array(GET_C2SC, $FlagArray))?(C2S_AKlaGruppe($this->mAKlaGruppe)):($this->mAKlaGruppe));
	}

	/*@}*/

	/*****************************************************************************************************************//**
	 * @name Datenbank
	 **************************************************************************************************************//*@{*/

	public static function isValidID($LigaKlasseID) {
		return CDriveEntity::genericIsValidID(self::mcTabName, $LigaKlasseID);
	}

	public function load($LigaKlasseID)
	{
		self::setInitVals();
		$this->setLigaKlasseID($LigaKlasseID);
		$format = 'SELECT bezeichnung, aklagruppe '.
		          'FROM ligenklassen WHERE ligaklasse_id=%s';
		$query = sprintf($format, $this->getLigaKlasseID());
		if(!$result = mysqli_query(CDriveEntity::getDB(), $query)) {throw new Exception(mysqli_error(CDriveEntity::getDB()));}
		$row = mysqli_fetch_row($result);
		if(!$row) {throw new Exception('LigaKlasse mit ligaklasse_id='.$LigaKlasseID.' nicht gefunden!');}
		$this->mBezeichnung = lS($row[0]);
		$this->mAKlaGruppe = lD($row[1]);
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
			$format = 'UPDATE ligenklassen SET '.
			          'bezeichnung=%s, aklagruppe=%s '.
			          'WHERE ligaklasse_id=%s';
			$query = sprintf($format, sS($this->mBezeichnung), sD($this->mAKlaGruppe), $this->getID());
		}
		else
		{
			$format = 'INSERT INTO ligenklassen ('.
			          'bezeichnung, aklagruppe'.
			          ') VALUES (%s, %s)';
			$query = sprintf($format, sS($this->mBezeichnung), sD($this->mAKlaGruppe));
		}
		if(!$result = mysqli_query(CDriveEntity::getDB(), $query)) {throw new Exception(mysqli_error(CDriveEntity::getDB()));}

		// Basisklasse
		parent::store();
	}

	public function check()
	{
		// Bezeichnung
		if(!(strlen($this->mBezeichnung) >= 1 and strlen($this->mBezeichnung) <= 50)) {
			CDriveEntity::addCheckMsg('Der Inhalt muss mind. 1 bis max. 50 Zeichen lang sein.');
		}
		// AKlaGruppe
		if(!((S_SCHUELER == $this->mAKlaGruppe)
		or (S_JUGEND == $this->mAKlaGruppe)
		or (S_AKTIVE == $this->mAKlaGruppe))) {
			CDriveEntity::addCheckMsg('Die Altersklassengruppe ist ungültig.');
		}
	}

	/*@}*/
	
	/*****************************************************************************************************************//**
	 * @name Verschiedenes
	 **************************************************************************************************************//*@{*/

	public function isDeletable()
	{
		/*
		 * In welchen Tabellen wird eine ligaklasse_id eingetragen und wie kritisch ist diese Tabelle?
		 *
		 * mannschaften......................kritisch (Mannschaft wird gelöscht!)
		 * tabellen..........................kritisch (Tabelle wird gelöscht!)
		 *
		 */

		$Zaehler = 0;

		$query = 'SELECT COUNT(*) FROM mannschaften WHERE ligaklasse_id='.$this->getLigaKlasseID();
		if(!$result = mysqli_query(CDriveEntity::getDB(), $query)) {
			throw new Exception(mysqli_error(CDriveEntity::getDB()));
		}
		$row = mysqli_fetch_row($result);
		$Zaehler += (int)$row[0];

		$query = 'SELECT COUNT(*) FROM tabellen WHERE ligaklasse_id='.$this->getLigaKlasseID();
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