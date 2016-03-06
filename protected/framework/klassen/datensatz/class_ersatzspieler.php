<?php
include_once(dirname(__FILE__).'/../datenbank/class_drive_entity.php');

/*******************************************************************************************************************//**
 * Repräsentation eines Ersatzspielers.
 * @ingroup grp_recordset
 **********************************************************************************************************************/
class CErsatzspieler extends CDriveEntity
{
	/*****************************************************************************************************************//**
	 * @name Tabellenname
	 **************************************************************************************************************//*@{*/

	const mcTabName = 'ersatzspieler';

	/*@}*/

	/*****************************************************************************************************************//**
	 * @name Tabellenspalten
	 **************************************************************************************************************//*@{*/

	private $mErsatzspielerID;
	private $mSpErMlID;
	private $mAthletID;

	/*@}*/

	/*****************************************************************************************************************//**
	 * @name Magics
	 **************************************************************************************************************//*@{*/

	public function __construct($ErsatzspielerID = 0) {
		parent::__construct(self::mcTabName, $ErsatzspielerID);
	}

	public function __toString()
	{
		if(!$this->getErsatzspielerID()) {return 'Kein Ersatzspieler';}
		return $this->mSpErMlID.' '.$this->getAthletID(GET_OFID);
	}

	/*@}*/

	/*****************************************************************************************************************//**
	 * @name Setter
	 **************************************************************************************************************//*@{*/

	public function setInitVals()
	{
		parent::setInitVals();
		$this->mErsatzspielerID = 0;
		$this->mSpErMlID = 0;
		$this->mAthletID = 0;
	}

	final public function setErsatzspielerID($ErsatzspielerID) {
		CDriveEntity::setID($ErsatzspielerID);
	}

	final public function setSpErMlID($SpErMlID) {
		$this->mSpErMlID = (int)$SpErMlID;
	}
	final public function setAthletID($AthletID) {
		$this->mAthletID = (int)$AthletID;
	}

	/*@}*/

	/*****************************************************************************************************************//**
	 * @name Getter
	 **************************************************************************************************************//*@{*/

	final public function getErsatzspielerID()
	{
		return CDriveEntity::getID();
	}

	final public function getSpErMlID()
	{
		return $this->mSpErMlID;
	}

	final public function getAthletID($FlagVariant = array())
	{
		$FlagArray = (array)$FlagVariant;
		if(in_array(GET_SPEC, $FlagArray)) {return new CMitglied($this->mAthletID);}
		return ((in_array(GET_OFID, $FlagArray))?(new CAthlet($this->mAthletID)):($this->mAthletID));
	}

	/*@}*/

	/*****************************************************************************************************************//**
	 * @name Datenbank
	 **************************************************************************************************************//*@{*/

	public static function isValidID($ErsatzspielerID) {
		return CDriveEntity::genericIsValidID(self::mcTabName, $ErsatzspielerID);
	}

	public function load($ErsatzspielerID)
	{
		self::setInitVals();
		$this->setErsatzspielerID($ErsatzspielerID);
		$format = 'SELECT sperml_id, athlet_id '.
		          'FROM ersatzspieler WHERE ersatzspieler_id=%s';
		$query = sprintf($format, $this->getErsatzspielerID());
		if(!$result = mysqli_query(CDriveEntity::getDB(), $query)) {throw new Exception(mysqli_error(CDriveEntity::getDB()));}
		$row = mysqli_fetch_row($result);
		if(!$row) {throw new Exception('Ersatzspieler mit ersatzspieler_id='.$ErsatzspielerID.' nicht gefunden!');}
		$this->mSpErMlID = lD($row[0]);
		$this->mAthletID = lD($row[1]);
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
			$format = 'UPDATE ersatzspieler SET '.
			          'sperml_id=%s, athlet_id=%s '.
			          'WHERE ersatzspieler_id=%s';
			$query = sprintf($format, sD($this->mSpErMlID), sD($this->mAthletID), $this->getID());
		}
		else
		{
			$format = 'INSERT INTO ersatzspieler ('.
			          'sperml_id, athlet_id'.
			          ') VALUES (%s, %s)';
			$query = sprintf($format, sD($this->mSpErMlID), sD($this->mAthletID));
		}
		if(!$result = mysqli_query(CDriveEntity::getDB(), $query)) {throw new Exception(mysqli_error(CDriveEntity::getDB()));}

		// Basisklasse
		parent::store();
	}

	public function check($CheckForeignKey = true)
	{
		// SpErMlID
		if($CheckForeignKey and !CSpErMl::isValidID($this->mSpErMlID)) {
			CDriveEntity::addCheckMsg('Die sperml_id ist ungültig.');
		}

		// AthletID
		if(!CAthlet::isValidID($this->mAthletID)) {
			CDriveEntity::addCheckMsg('Die athlet_id ist ungültig.');
		}
	}

	/*@}*/

	/*****************************************************************************************************************//**
	 * @name Verschiedenes
	 **************************************************************************************************************//*@{*/



	/*@}*/
}
?>