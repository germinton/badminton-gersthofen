<?php
include_once(dirname(__FILE__).'/../datenbank/class_drive_entity.php');

/*******************************************************************************************************************//**
 * Repräsentation eines Kontrahenten.
 * @ingroup grp_recordset
 **********************************************************************************************************************/
class CKontrahent extends CDriveEntity
{
	/*****************************************************************************************************************//**
	 * @name Tabellenname
	 **************************************************************************************************************//*@{*/

	const mcTabName = 'kontrahenten';

	/*@}*/

	/*****************************************************************************************************************//**
	 * @name Tabellenspalten
	 **************************************************************************************************************//*@{*/

	private $mAthletID;
	private $mSpielID;
	private $mSeite;
	private $mPosition;

	/*@}*/

	/*****************************************************************************************************************//**
	 * @name Magics
	 **************************************************************************************************************//*@{*/

	public function __construct($KontrahentID = 0) {
		parent::__construct(self::mcTabName, $KontrahentID);
	}

	public function __toString()
	{
		if(!$this->getKontrahentID()) {return 'Kein Kontrahent';}
		return $this->getAthletID(GET_OFID).'; '.$this->mSpielID.'; '.$this->getSeite(GET_C2SC).'; '.$this->mPosition.'; ';
	}

	/*@}*/

	/*****************************************************************************************************************//**
	 * @name Setter
	 **************************************************************************************************************//*@{*/

	public function setInitVals()
	{
		parent::setInitVals();
		$this->mAthletID = 0;
		$this->mSpielID = 0;
		$this->mSeite = 0;
		$this->mPosition = 0;
	}

	final public function setKontrahentID($KontrahentID) {
		CDriveEntity::setID($KontrahentID);
	}

	final public function setAthletID($AthletID) {
		$this->mAthletID = (int)$AthletID;
	}
	final public function setSpielID($SpielID) {
		$this->mSpielID = (int)$SpielID;
	}
	final public function setSeite($Seite) {
		$this->mSeite = (int)$Seite;
	}
	final public function setPosition($Position) {
		$this->mPosition = (int)$Position;
	}

	/*@}*/

	/*****************************************************************************************************************//**
	 * @name Getter
	 **************************************************************************************************************//*@{*/

	final public function getKontrahentID()
	{
		return CDriveEntity::getID();
	}

	final public function getSpielID()
	{
		return $this->mSpielID;
	}

	final public function getAthletID($FlagVariant = array())
	{
		$FlagArray = (array)$FlagVariant;
		if(in_array(GET_SPEC, $FlagArray)) {return new CMitglied($this->mAthletID);}
		return ((in_array(GET_OFID, $FlagArray))?(new CAthlet($this->mAthletID)):($this->mAthletID));
	}

	final public function getSeite($FlagVariant = array())
	{
		$FlagArray = (array)$FlagVariant;
		if(in_array(GET_C2SC, $FlagArray)) {return C2S_Seite($this->mSeite);}
		return $this->mAnrede;
	}

	final public function getPosition()
	{
		return $this->mPosition;
	}

	/*@}*/

	/*****************************************************************************************************************//**
	 * @name Datenbank
	 **************************************************************************************************************//*@{*/

	public static function isValidID($KontrahentID) {
		return CDriveEntity::genericIsValidID(self::mcTabName, $KontrahentID);
	}

	public function load($KontrahentID)
	{
		self::setInitVals();
		$this->setKontrahentID($KontrahentID);
		$format = 'SELECT athlet_id, spiel_id, seite, position '.
		          'FROM kontrahenten WHERE kontrahent_id=%s';
		$query = sprintf($format, $this->getKontrahentID());
		if(!$result = mysql_query($query)) {throw new Exception(mysql_error(CDriveEntity::getDB()));}
		$row = mysql_fetch_row($result);
		if(!$row) {throw new Exception('Kontrahent mit kontrahent_id='.$KontrahentID.' nicht gefunden!');}
		$this->mAthletID = lD($row[0]);
		$this->mSpielID = lD($row[1]);
		$this->mSeite = lD($row[2]);
		$this->mPosition = lD($row[3]);
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
			$format = 'UPDATE kontrahenten SET '.
			          'athlet_id=%s, spiel_id=%s, seite=%s, position=%s '.
			          'WHERE kontrahent_id=%s';
			$query = sprintf($format, sD($this->mAthletID), sD($this->mSpielID), sD($this->mSeite), sD($this->mPosition),
			$this->getID());
		}
		else
		{
			$format = 'INSERT INTO kontrahenten ('.
			          'athlet_id, spiel_id, seite, position'.
			          ') VALUES (%s, %s, %s, %s)';
			$query = sprintf($format, sD($this->mAthletID), sD($this->mSpielID), sD($this->mSeite), sD($this->mPosition));
		}
		if(!$result = mysql_query($query)) {throw new Exception(mysql_error(CDriveEntity::getDB()));}

		// Basisklasse
		parent::store();
	}

	public function check($CheckForeignKey = true)
	{
		// AthletID
		if(!CAthlet::isValidID($this->mAthletID)) {
			CDriveEntity::addCheckMsg('Die athlet_id ist ungültig.');
		}

		// SpielID
		if($CheckForeignKey and !CSpiel::isValidID($this->mSpielID)) {
			CDriveEntity::addCheckMsg('Die spiel_id ist ungültig.');
		}

		// Seite
		if(is_null(C2S_Seite($this->mSeite))) {
			CDriveEntity::addCheckMsg('Die Seite muss entweder \'1\' für \'Heim\' oder \'2\' für \'Gast\' lauten.');
		}

		// Position
		if(!((1 == $this->mPosition) or (2 == $this->mPosition))) {
			CDriveEntity::addCheckMsg('Die Position muss entweder \'1\' oder \'2\' lauten.');
		}
	}

	/*@}*/

	/*****************************************************************************************************************//**
	 * @name Verschiedenes
	 **************************************************************************************************************//*@{*/

	/*@}*/
}
?>