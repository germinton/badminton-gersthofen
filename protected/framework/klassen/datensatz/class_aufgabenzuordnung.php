<?php
include_once(dirname(__FILE__).'/../datenbank/class_drive_entity.php');
include_once(dirname(__FILE__).'/class_athlet.php');
include_once(dirname(__FILE__).'/class_aufgabe.php');

/*******************************************************************************************************************//**
 * Repräsentation einer Aufgabenzuordnung.
 * @ingroup grp_recordset
 **********************************************************************************************************************/
class CAufgabenzuordnung extends CDriveEntity
{
	/*****************************************************************************************************************//**
	 * @name Tabellenname
	 **************************************************************************************************************//*@{*/

	const mcTabName = 'aufgabenzuordnungen';

	/*@}*/

	/*****************************************************************************************************************//**
	 * @name Tabellenspalten
	 **************************************************************************************************************//*@{*/

	private $mAthletID;
	private $mAufgabeID;
	private $mZusatzinfo;

	/*@}*/

	/*****************************************************************************************************************//**
	 * @name Magics
	 **************************************************************************************************************//*@{*/

	public function __construct($AufgabenzuordnungID = 0) {
		parent::__construct(self::mcTabName, $AufgabenzuordnungID);
	}

	public function __toString()
	{
		if(!$this->getAufgabenzuordnungID()) {return 'Keine Aufgabenzuordnung';}
		return $this->getAthletID(GET_OFID).' ist '.$this->getAufgabenstring();
	}

	/*@}*/

	/*****************************************************************************************************************//**
	 * @name Setter
	 **************************************************************************************************************//*@{*/

	public function setInitVals()
	{
		parent::setInitVals();
		$this->mAthletID = 0;
		$this->mAufgabeID = 0;
		$this->mZusatzinfo = null;
	}

	final public function setAufgabenzuordnungID($AufgabenzuordnungID) {
		CDriveEntity::setID($AufgabenzuordnungID);
	}

	final public function setAthletID($AthletID) {
		$this->mAthletID = (int)$AthletID;
	}

	final public function setAufgabeID($AufgabeID) {
		$this->mAufgabeID = (int)$AufgabeID;
	}

	final public function setZusatzinfo($Zusatzinfo) {
		$this->mZusatzinfo = (($s = htmlspecialchars(trim((string)$Zusatzinfo)))?($s):(null));
	}

	/*@}*/

	/*****************************************************************************************************************//**
	 * @name Getter
	 **************************************************************************************************************//*@{*/

	final public function getAufgabenzuordnungID()
	{
		return CDriveEntity::getID();
	}

	final public function getAthletID($FlagVariant = array())
	{
		$FlagArray = (array)$FlagVariant;
		return ((in_array(GET_OFID, $FlagArray))?(new CAthlet($this->mAthletID)):($this->mAthletID));
	}

	final public function getAufgabeID($FlagVariant = array())
	{
		$FlagArray = (array)$FlagVariant;
		return ((in_array(GET_OFID, $FlagArray))?(new CAufgabe($this->mAufgabeID)):($this->mAufgabeID));
	}

	final public function getZusatzinfo()
	{
		return $this->mZusatzinfo;
	}

	/*@}*/

	/*****************************************************************************************************************//**
	 * @name Datenbank
	 **************************************************************************************************************//*@{*/

	public static function isValidID($AufgabenzuordnungID) {
		return CDriveEntity::genericIsValidID(self::mcTabName, $AufgabenzuordnungID);
	}

	public function load($AufgabenzuordnungID)
	{
		self::setInitVals();
		$this->setAufgabenzuordnungID($AufgabenzuordnungID);
		$format = 'SELECT athlet_id, aufgabe_id, zusatzinfo '.
		          'FROM aufgabenzuordnungen WHERE aufgabenzuordnung_id=%s';
		$query = sprintf($format, $this->getAufgabenzuordnungID());
		if(!$result = mysqli_query(CDriveEntity::getDB(), $query)) {throw new Exception(mysqli_error(CDriveEntity::getDB()));}
		$row = mysqli_fetch_row($result);
		if(!$row) {throw new Exception('Aufgabenzuordnung mit aufgabenzuordnung_id='.$AufgabenzuordnungID.' nicht gefunden!');}
		$this->mAthletID = lD($row[0]);
		$this->mAufgabeID = lD($row[1]);
		$this->mZusatzinfo = lS($row[2]);
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
			$format = 'UPDATE aufgabenzuordnungen SET '.
			          'athlet_id=%s, aufgabe_id=%s, zusatzinfo=%s '.
			          'WHERE aufgabenzuordnung_id=%s';
			$query = sprintf($format, sD($this->mAthletID), sD($this->mAufgabeID), sS($this->mZusatzinfo), $this->getID());
		}
		else
		{
			$format = 'INSERT INTO aufgabenzuordnungen ('.
			          'athlet_id, aufgabe_id, zusatzinfo'.
			          ') VALUES (%s, %s, %s)';
			$query = sprintf($format, sD($this->mAthletID), sD($this->mAufgabeID), sS($this->mZusatzinfo));
		}
		if(!$result = mysqli_query(CDriveEntity::getDB(), $query)) {throw new Exception(mysqli_error(CDriveEntity::getDB()));}

		// Basisklasse
		parent::store();
	}

	public function check()
	{
		// AthletID
		if(!CAthlet::isValidID($this->mAthletID)) {
			CDriveEntity::addCheckMsg('Die athlet_id ist ungültig.');
		}

		// AufgabeID
		if(!CAufgabe::isValidID($this->mAufgabeID)) {
			CDriveEntity::addCheckMsg('Die aufgabe_id ist ungültig.');
		}

		// Zusatzinfo
		if(!is_null($this->mZusatzinfo))
		{
			if(strlen($this->mZusatzinfo) > 50) {
				CDriveEntity::addCheckMsg('Die Zusatzinfo darf nicht länger als 50 Zeichen sein.');
			}
		}
	}

	/*@}*/

	/*****************************************************************************************************************//**
	 * @name Verschiedenes
	 **************************************************************************************************************//*@{*/

	public static function getAthletIDArray($AufgabeIDVariant)
	{
		if(!count($AufgabeIDArray = (array)$AufgabeIDVariant)) {return array();}
		$view = CDBConnection::getViewAufgabenzuordnungen();
		$query = 'SELECT view.athlet_id FROM ('.$view.') view WHERE view.aufgabe_id='.reset($AufgabeIDArray);
		while($AufgabeID = next($AufgabeIDArray)) {$query .= ' OR view.aufgabe_id='.$AufgabeID;}
		if(!$result = mysqli_query(CDriveEntity::getDB(), $query)) {throw new Exception(mysqli_error(CDriveEntity::getDB()));}
		while($row = mysqli_fetch_row($result)) {$AthletIDArray[] = (int)$row[0];}
		return ((isset($AthletIDArray))?($AthletIDArray):(array()));
	}

	public static function getAufgabeIDArray($AthletIDVariant)
	{
		if(!count($AthletIDArray = (array)$AthletIDVariant)) {return array();}
		$view = CDBConnection::getViewAufgabenzuordnungen();
		$query = 'SELECT view.aufgabe_id FROM ('.$view.') view WHERE view.athlet_id='.reset($AthletIDArray);
		while($AthletID = next($AthletIDArray)) {$query .= ' OR view.athlet_id='.$AthletID;}
		if(!$result = mysqli_query(CDriveEntity::getDB(), $query)) {throw new Exception(mysqli_error(CDriveEntity::getDB()));}
		while($row = mysqli_fetch_row($result)) {$AufgabeIDArray[] = (int)$row[0];}
		return ((isset($AufgabeIDArray))?($AufgabeIDArray):(array()));
	}

	public static function getSortedAthletIDArray($AthletIDVariant)
	{
		if(!count($AthletIDArray = (array)$AthletIDVariant)) {return array();}
		$view = CDBConnection::getViewAufgabenzuordnungen();
		$query = 'SELECT view.athlet_id FROM ('.$view.') view WHERE view.athlet_id='.reset($AthletIDArray);
		while($AthletID = next($AthletIDArray)) {$query .= ' OR view.athlet_id='.$AthletID;}
		$query .= ' GROUP BY view.athlet_id ORDER BY SUM(sortierung) DESC';
		if(!$result = mysqli_query(CDriveEntity::getDB(), $query)) {throw new Exception(mysqli_error(CDriveEntity::getDB()));}
		while($row = mysqli_fetch_row($result)) {$SortedAthletIDArray[] = (int)$row[0];}
		return ((isset($SortedAthletIDArray))?($SortedAthletIDArray):(array()));
	}

	public function getAufgabenstring()
	{
		$Athlet = new CAthlet($this->mAthletID);
		$Aufgabe = new CAufgabe($this->mAufgabeID);
		if     (S_HERR == $Athlet->getAnrede()) $Bezeichnung = $Aufgabe->getBezMaennlich();
		else if(S_DAME == $Athlet->getAnrede()) $Bezeichnung = $Aufgabe->getBezWeiblich();
		return $Bezeichnung.((is_string($this->mZusatzinfo))?(' ('.$this->mZusatzinfo.')'):(''));
	}
	
    public function getAufgabenstringFormatted()
	{
		$Athlet = new CAthlet($this->mAthletID);
		$Aufgabe = new CAufgabe($this->mAufgabeID);
		if     (S_HERR == $Athlet->getAnrede()) $Bezeichnung = $Aufgabe->getBezMaennlich();
		else if(S_DAME == $Athlet->getAnrede()) $Bezeichnung = $Aufgabe->getBezWeiblich();
		$Bezeichnung = '<span style="font-weight: bold">'.$Bezeichnung.'</span>';
		return $Bezeichnung.((is_string($this->mZusatzinfo))?('<br />('.$this->mZusatzinfo.')'):(''));
	}

	/*@}*/
}
?>