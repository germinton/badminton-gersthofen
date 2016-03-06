<?php
include_once(dirname(__FILE__).'/class_spiel.php');

/*******************************************************************************************************************//**
 * Repräsentation eines Spielergebnismeldungsspiels.
 * @ingroup grp_recordset
 **********************************************************************************************************************/
class CSpielSpErMl extends CSpiel
{
	/*****************************************************************************************************************//**
	 * @name Tabellenspalten
	 **************************************************************************************************************//*@{*/

	private $mSpErMlSpieltyp;
	private $mSpErMlID;

	/*@}*/

	/*****************************************************************************************************************//**
	 * @name Magics
	 **************************************************************************************************************//*@{*/

	public function __construct($SpielID = 0) {
		parent::__construct($SpielID);
	}

	public function __toString()
	{
		if(!$this->getSpielID()) {return 'Kein Spielergebnismeldungsspiel';}
		$retstr = $this->getSpErMlSpieltyp(GET_C2SC).':';
		foreach($this->getSatzArray() as $Satz) {$retstr .= ' '.$Satz;}
		return $retstr;
	}

	/*@}*/

	/*****************************************************************************************************************//**
	 * @name Setter
	 **************************************************************************************************************//*@{*/

	public function setInitVals()
	{
		parent::setInitVals();
		$this->mSpErMlSpieltyp = 0;
		$this->mSpErMlID = 0;
	}

	final public function setSpErMlSpieltyp($SpErMlSpieltyp) {
		$this->mSpErMlSpieltyp = (int)$SpErMlSpieltyp;
		CSpiel::setSpieltyp(C2C_Spieltyp($this->mSpErMlSpieltyp));
	}

	final public function setSpieltyp($Spieltyp) {
		throw new Exception('setSpieltyp() nicht erlaubt für CSpielSpErMl!');
	}

	final public function setSpErMlID($SpErMlID) {
		$this->mSpErMlID = (int)$SpErMlID;
	}

	/*@}*/

	/*****************************************************************************************************************//**
	 * @name Getter
	 **************************************************************************************************************//*@{*/

	final public function getSpErMlSpieltyp($FlagVariant = array())
	{
		$FlagArray = (array)$FlagVariant;
		if(in_array(GET_C2SC, $FlagArray)) {return C2S_SpErMlSpieltyp($this->mSpErMlSpieltyp);}
		return $this->mSpErMlSpieltyp;
	}

	final public function getSpErMlID($FlagVariant = array())
	{
		$FlagArray = (array)$FlagVariant;
		return ((in_array(GET_OFID, $FlagArray))?(new CSpErMl($this->mSpErMlID)):($this->mSpErMlID));
	}

	/*@}*/

	/*****************************************************************************************************************//**
	 * @name Datenbank
	 **************************************************************************************************************//*@{*/

	public static function isValidID($SpielID) {
		return CDriveEntity::genericIsValidID('spiele_sperml', $SpielID);
	}

	public function load($SpielID)
	{
		self::setInitVals();
		CSpiel::load($SpielID);
		$format = 'SELECT spermlspieltyp, sperml_id '.
		          'FROM spiele_sperml WHERE spiel_id=%s';
		$query = sprintf($format, $this->getSpielID());
		if(!$result = mysqli_query(CDriveEntity::getDB(), $query)) {throw new Exception(mysql_error(CDriveEntity::getDB()));}
		$row = mysqli_fetch_row($result);
		if(!$row) {throw new Exception('Spielergebnsimeldungsspiel mit spiel_id='.$SpielID.' nicht gefunden!');}
		$this->mSpErMlSpieltyp = lD($row[0]);
		$this->mSpErMlID = lD($row[1]);
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
			$format = 'UPDATE spiele_sperml SET '.
			          'spermlspieltyp=%s, sperml_id=%s '.
			          'WHERE spiel_id=%s';
			$query = sprintf($format, sD($this->mSpErMlSpieltyp), sD($this->mSpErMlID), $this->getID());
		}
		else
		{
			$format = 'INSERT INTO spiele_sperml ('.
			          'spiel_id, spermlspieltyp, sperml_id'.
			          ') VALUES (%s, %s, %s)';
			$query = sprintf($format, $this->getID(), sD($this->mSpErMlSpieltyp), sD($this->mSpErMlID));
		}
		if(!$result = mysqli_query(CDriveEntity::getDB(), $query)) {throw new Exception(mysql_error(CDriveEntity::getDB()));}
	}

	public function check($CheckForeignKey = true)
	{
		// Basisklasse
		parent::check();

		// SpErMlSpieltyp
		if(is_null(C2S_SpErMlSpieltyp($this->mSpErMlSpieltyp))) {
			CDriveEntity::addCheckMsg('Der Spielergebnismeldungsspieltyp ist ungültig.');
		}

		// SpErMlID
		if($CheckForeignKey and !CSpErMl::isValidID($this->mSpErMlID)) {
			CDriveEntity::addCheckMsg('Die sperml_id ist ungültig.');
		}
	}

	/*@}*/

	/*****************************************************************************************************************//**
	 * @name Verschiedenes
	 **************************************************************************************************************//*@{*/

	/*@}*/
}
?>