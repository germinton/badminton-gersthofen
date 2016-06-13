<?php
include_once(dirname(__FILE__).'/../datenbank/class_drive_entity.php');

/*******************************************************************************************************************//**
 * Repräsentation einer Ergebnistabelle.
 * @ingroup grp_recordset
 **********************************************************************************************************************/
class CTabelle extends CDriveEntity
{
	/*****************************************************************************************************************//**
	 * @name Tabellenname
	 **************************************************************************************************************//*@{*/

	const mcTabName = 'tabellen';

	/*@}*/

	/*****************************************************************************************************************//**
	 * @name Tabellenspalten
	 **************************************************************************************************************//*@{*/

	private $mSaisonID;
	private $mLigaKlasseID;
	private $mAthletID;

	/*@}*/

	/*****************************************************************************************************************//**
	 * @name Objekt-Arrays
	 **************************************************************************************************************//*@{*/

	private $mTabelleneintragArray;

	/*@}*/

	/*****************************************************************************************************************//**
	 * @name Magics
	 **************************************************************************************************************//*@{*/

	public function __construct($TabelleID = 0) {
		parent::__construct(self::mcTabName, $TabelleID);
	}

	public function __toString()
	{
		if(!$this->getTabelleID()) {return 'Keine Tabelle';}
		return $this->getSaisonID(GET_OFID).' - '.$this->getLigaKlasseID(GET_OFID);
	}

	/*@}*/

	/*****************************************************************************************************************//**
	 * @name Setter
	 **************************************************************************************************************//*@{*/

	public function setInitVals()
	{
		parent::setInitVals();
		$this->mSaisonID = 0;
		$this->mLigaKlasseID = 0;
		$this->mAthletID = null;
		$this->mTabelleneintragArray = array();
	}

	final public function setTabelleID($TabelleID) {
		CDriveEntity::setID($TabelleID);
	}

	final public function setSaisonID($SaisonID) {
		$this->mSaisonID = (int)$SaisonID;
	}

	final public function setLigaKlasseID($LigaKlasseID) {
		$this->mLigaKlasseID = (int)$LigaKlasseID;
	}

	final public function setAthletID($AthletID) {
		$this->mAthletID = (($i = (int)$AthletID)?($i):(null));
	}

	final public function setTabelleneintragArray($TabelleneintragArray) {
		$this->mTabelleneintragArray = array();
		foreach($TabelleneintragArray as $Tabelleneintrag) {
			$this->mTabelleneintragArray[] = clone $Tabelleneintrag;
			current($this->mTabelleneintragArray)->setTabelleID($this->getTabelleID());
		}
	}

	/*@}*/

	/*****************************************************************************************************************//**
	 * @name Getter
	 **************************************************************************************************************//*@{*/

	final public function getTabelleID()
	{
		return CDriveEntity::getID();
	}

	final public function getSaisonID($FlagVariant = array())
	{
		$FlagArray = (array)$FlagVariant;
		return ((in_array(GET_OFID, $FlagArray))?(new CSaison($this->mSaisonID)):($this->mSaisonID));
	}

	final public function getLigaKlasseID($FlagVariant = array())
	{
		$FlagArray = (array)$FlagVariant;
		return ((in_array(GET_OFID, $FlagArray))?(new CLigaKlasse($this->mLigaKlasseID)):($this->mLigaKlasseID));
	}

	final public function getAthletID($FlagVariant = array())
	{
		$FlagArray = (array)$FlagVariant;
		if(is_null($ID = $this->mAthletID) and in_array(GET_NBSP, $FlagArray)) {return '&nbsp;';}
		return ((!is_null($ID) and in_array(GET_OFID, $FlagArray))?(new CAthlet($ID)):($ID));
	}

	final public function getTabelleneintragArray()
	{
		return $this->mTabelleneintragArray;
	}

	/*@}*/

	/*****************************************************************************************************************//**
	 * @name Datenbank
	 **************************************************************************************************************//*@{*/

	public static function isValidID($TabelleID) {
		return CDriveEntity::genericIsValidID(self::mcTabName, $TabelleID);
	}

	public function load($TabelleID)
	{
		self::setInitVals();
		$this->setTabelleID($TabelleID);
		$format = 'SELECT saison_id, ligaklasse_id, athlet_id '.
		          'FROM tabellen WHERE tabelle_id=%s';
		$query = sprintf($format, $this->getTabelleID());
		if(!$result = mysqli_query(CDriveEntity::getDB(), $query)) {throw new Exception(mysqli_error(CDriveEntity::getDB()));}
		$row = mysqli_fetch_row($result);
		if(!$row) {throw new Exception('Tabelle mit tabelle_id='.$TabelleID.' nicht gefunden!');}
		$this->mSaisonID= lD($row[0]);
		$this->mLigaKlasseID = lD($row[1]);
		$this->mAthletID = lD($row[2]);

		// TabelleneintragArray
		$query = 'SELECT tabelleneintrag_id FROM tabelleneintraege '.
		         'WHERE tabelle_id='.$this->getTabelleID().' ORDER BY platz';
		if(!$result = mysqli_query(CDriveEntity::getDB(), $query)) {throw new Exception(mysqli_error(CDriveEntity::getDB()));}
		while($row = mysqli_fetch_row($result)) {$this->mTabelleneintragArray[] = new CTabelleneintrag($row[0]);}
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
			$format = 'UPDATE tabellen SET '.
			          'saison_id=%s, ligaklasse_id=%s, athlet_id=%s '.
			          'WHERE tabelle_id=%s';
			$query = sprintf($format, sD($this->mSaisonID), sD($this->mLigaKlasseID), sD($this->mAthletID), $this->getID());
		}
		else
		{
			$format = 'INSERT INTO tabellen ('.
			          'saison_id, ligaklasse_id, athlet_id'.
			          ') VALUES (%s, %s, %s)';
			$query = sprintf($format, sD($this->mSaisonID), sD($this->mLigaKlasseID), sD($this->mAthletID));
		}
		if(!$result = mysqli_query(CDriveEntity::getDB(), $query)) {throw new Exception(mysqli_error(CDriveEntity::getDB()));}

		// Basisklasse
		parent::store();

		// TabelleneintragArray
		foreach($this->mTabelleneintragArray as $Tabelleneintrag)
		{
			// TODO wie CSpErMl oder CSpiel
			$Tabelleneintrag->setTabelleID($this->getTabelleID());
			$Tabelleneintrag->store();
		}
	}

	public function check($CheckForeignKey = true)
	{
		// SaisonID
		if($CheckForeignKey and !CSaison::isValidID($this->mSaisonID)) {
			CDriveEntity::addCheckMsg('Die saison_id ist ungültig.');
		}

		// LigaKlasseID
		if($CheckForeignKey and !CLigaKlasse::isValidID($this->mLigaKlasseID)) {
			CDriveEntity::addCheckMsg('Die ligaklasse_id ist ungültig.');
		}

		// AthletID
		if(!is_null($this->mAthletID))
		{
			if(!CAthlet::isValidID($this->mAthletID)) {
				CDriveEntity::addCheckMsg('Die athlet_id ist ungültig.');
			}
		}

		// TabelleneintragArray
		foreach($this->mTabelleneintragArray as $i => $Tabelleneintrag)
		{
			$Tabelleneintrag->check(false);
			if(count($Tabelleneintrag->getCheckMsg()))
			{
				CDriveEntity::addCheckMsg('Tabelleneintrag Nr '.($i+1).' weist folgende Fehler auf ...');
				CDriveEntity::addCheckMsg($Tabelleneintrag->getCheckMsg());
			}
		}
	}

	/*@}*/

	/*****************************************************************************************************************//**
	 * @name Verschiedenes
	 **************************************************************************************************************//*@{*/

	public function isDeletable()
	{
		/*
		 * In welchen Tabellen wird eine tabelle_id eingetragen und wie kritisch ist diese Tabelle?
		 *
		 * tabelleneintraege....kritisch (alle Informationen, z. B für Archivzwecke, wären verloren.)
		 *
		 */

		$Zaehler = 0;

		$query = 'SELECT COUNT(*) FROM tabelleneintraege WHERE tabelle_id='.$this->getTabelleID();
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