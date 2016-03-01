<?php
include_once(dirname(__FILE__).'/../datenbank/class_drive_entity.php');
include_once(dirname(__FILE__).'/class_turnier.php');
include_once(dirname(__FILE__).'/class_turnierathlet.php');
include_once(dirname(__FILE__).'/class_athlet.php');

/*******************************************************************************************************************//**
 * Repräsentation einer Meldung für ein Turnier.
 * @ingroup grp_recordset
 **********************************************************************************************************************/
class CTurniermeldung extends CDriveEntity
{
	/*****************************************************************************************************************//**
	 * @name Tabellenname
	 **************************************************************************************************************//*@{*/

	const mcTabName = 'turniermeldungen';

	/*@}*/

	/*****************************************************************************************************************//**
	 * @name Tabellenspalten
	 **************************************************************************************************************//*@{*/

	private $mTurnierID;
	private $mSpieltyp;
	private $mSpielgruppe;
	private $mPlatzierung;

	/*@}*/

	/*****************************************************************************************************************//**
	 * @name Objekt-Arrays
	 **************************************************************************************************************//*@{*/

	private $mTurnierathletArray;

	/*@}*/

	/*****************************************************************************************************************//**
	 * @name Magics
	 **************************************************************************************************************//*@{*/

	public function __construct($TurniermeldungID = 0) {
		parent::__construct(self::mcTabName, $TurniermeldungID);
	}

	public function __toString()
	{
		if(!$this->getTurniermeldungID()) {return 'Keine Turniermeldung';}

		$retstr = $this->getSpieltyp(GET_C2SC).': ';

		switch($this->mSpieltyp)
		{
			case S_HDTYP:
			case S_DDTYP:
			case S_MXTYP:
				$retstr .= $this->mTurnierathletArray[0].' und '.$this->mTurnierathletArray[1];
				break;
			case S_HETYP:
			case S_DETYP:
				$retstr .= $this->mTurnierathletArray[0];
				break;
			case S_MFTYP:
				foreach($this->mTurnierathletArray as $Turnierathlet) {$retstr .= ' '.$Turnierathlet;}
				break;
			default:
				break;
		}

		return $retstr;
	}

	public function __clone() {
		foreach($this->mTurnierathletArray as &$Turnierathlet) {$Turnierathlet = clone $Turnierathlet;}
	}

	/*@}*/

	/*****************************************************************************************************************//**
	 * @name Setter
	 **************************************************************************************************************//*@{*/

	public function setInitVals()
	{
		parent::setInitVals();
		$this->mTurnierID = 0;
		$this->mSpieltyp = 0;
		$this->mSpielgruppe = null;
		$this->mPlatzierung = null;
		$this->mTurnierathletArray = array();
	}

	final public function setTurniermeldungID($TurniermeldungID) {
		CDriveEntity::setID($TurniermeldungID);
	}

	final public function setTurnierID($TurnierID) {
		$this->mTurnierID = (int)$TurnierID;
	}

	final public function setSpieltyp($Spieltyp) {
		$this->mSpieltyp = (int)$Spieltyp;
	}

	final public function setSpielgruppe($Spielgruppe) {
		$this->mSpielgruppe = (($s = htmlspecialchars(trim((string)$Spielgruppe)))?($s):(null));
	}

	final public function setPlatzierung($Platzierung) {
		$this->mPlatzierung = (($i = (int)$Platzierung)?($i):(null));
	}

	final public function setTurnierathletArray($TurnierathletArray) {
		$this->mTurnierathletArray = array();
		foreach($TurnierathletArray as $Turnierathlet) {
			$this->mTurnierathletArray[] = clone $Turnierathlet;
			current($this->mTurnierathletArray)->setTurniermeldungID($this->getTurniermeldungID());
		}
	}

	/*@}*/

	/*****************************************************************************************************************//**
	 * @name Getter
	 **************************************************************************************************************//*@{*/

	final public function getTurniermeldungID()
	{
		return CDriveEntity::getID();
	}

	final public function getTurnierID()
	{
		return $this->mTurnierID;
	}

	final public function getSpieltyp($FlagVariant = array())
	{
		$FlagArray = (array)$FlagVariant;
		return ((in_array(GET_C2SC, $FlagArray))?(C2S_Spieltyp($this->mSpieltyp)):($this->mSpieltyp));
	}

	final public function getSpielgruppe($FlagVariant = array())
	{
		$FlagArray = (array)$FlagVariant;
		return ((is_null($v = $this->mSpielgruppe) and in_array(GET_NBSP, $FlagArray))?('&nbsp;'):($v));
	}

	final public function getPlatzierung($FlagVariant = array())
	{
		$FlagArray = (array)$FlagVariant;
		return ((is_null($v = $this->mPlatzierung) and in_array(GET_NBSP, $FlagArray))?('&nbsp;'):($v));
	}

	final public function getTurnierathletArray()
	{
		return $this->mTurnierathletArray;
	}

	/*@}*/

	/*****************************************************************************************************************//**
	 * @name Datenbank
	 **************************************************************************************************************//*@{*/

	public static function isValidID($TurniermeldungID) {
		return CDriveEntity::genericIsValidID(self::mcTabName, $TurniermeldungID);
	}

	public function load($TurniermeldungID)
	{
		self::setInitVals();
		$this->setTurniermeldungID($TurniermeldungID);
		$format = 'SELECT turnier_id, spieltyp, spielgruppe, platzierung '.
		          'FROM turniermeldungen WHERE turniermeldung_id=%s';
		$query = sprintf($format, $this->getTurniermeldungID());
		if(!$result = mysqli_query(CDriveEntity::getDB(), $query)) {throw new Exception(mysqli_error(CDriveEntity::getDB()));}
		$row = mysqli_fetch_row($result);
		if(!$row) {throw new Exception('Turniermeldung mit turniermeldung_id='.$TurniermeldungID.' nicht gefunden!');}
		$this->mTurnierID = lD($row[0]);
		$this->mSpieltyp = lD($row[1]);
		$this->mSpielgruppe = lS($row[2]);
		$this->mPlatzierung = lD($row[3]);

		// TurnierathletArray
		$query = 'SELECT turnierathlet_id FROM turnierathleten WHERE turniermeldung_id='.$this->getTurniermeldungID();
		if(!$result = mysqli_query(CDriveEntity::getDB(), $query)) {throw new Exception(mysqli_error(CDriveEntity::getDB()));}
		while($row = mysqli_fetch_row($result)) {$this->mTurnierathletArray[] = new CTurnierathlet($row[0]);}
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
			$format = 'UPDATE turniermeldungen SET '.
			          'turnier_id=%s, spieltyp=%s, spielgruppe=%s, platzierung=%s '.
			          'WHERE turniermeldung_id=%s';
			$query = sprintf($format, sD($this->mTurnierID), sD($this->mSpieltyp), sS($this->mSpielgruppe),
			sD($this->mPlatzierung), $this->getID());
		}
		else
		{
			$format = 'INSERT INTO turniermeldungen ('.
			          'turnier_id, spieltyp, spielgruppe, platzierung'.
			          ') VALUES (%s, %s, %s, %s)';
			$query = sprintf($format, sD($this->mTurnierID), sD($this->mSpieltyp), sS($this->mSpielgruppe),
			sD($this->mPlatzierung));
		}
		if(!$result = mysqli_query(CDriveEntity::getDB(), $query)) {throw new Exception(mysqli_error(CDriveEntity::getDB()));}

		// Basisklasse
		parent::store();

		// TurnierathletArray
		foreach($this->mTurnierathletArray as $Turnierathlet)
		{
			// TODO wie CSpErMl oder CSpiel
			$Turnierathlet->setTurniermeldungID($this->getTurniermeldungID());
			$Turnierathlet->store();
		}
	}

	public function check()
	{
		// TurnierID
		if(!CTurnier::isValidID($this->mTurnierID)) {
			CDriveEntity::addCheckMsg('Die turnier_id ist ungültig.');
		}

		// Spieltyp
		if(is_null(C2S_Spieltyp($this->mSpieltyp))) {
			CDriveEntity::addCheckMsg('Der Spieltyp ist ungültig.');
		}

		// Spielgruppe
		if(!is_null($this->mSpielgruppe))
		{
			if(strlen($this->mSpielgruppe) > 20) {
				CDriveEntity::addCheckMsg('Die Spielgruppe darf nicht länger als 20 Zeichen sein.');
			}
		}

		// Platzierung
		if(!is_null($this->mPlatzierung))
		{
			if(!($this->mPlatzierung >= 1 and $this->mPlatzierung <= MAX_PLATZ_TURN)) {
				CDriveEntity::addCheckMsg('Die Platzierung muss zwischen 1 und '.MAX_PLATZ_TURN.' liegen.');
			}
		}

		// TurnierathletArray
		foreach($this->mTurnierathletArray as $i => $Turnierathlet)
		{
			$Turnierathlet->check(false);
			if(count($Turnierathlet->getCheckMsg()))
			{
				CDriveEntity::addCheckMsg('Turnierathlet Nr '.($i+1).' weist folgende Fehler auf ...');
				CDriveEntity::addCheckMsg($Turnierathlet->getCheckMsg());
			}
		}

		$styp = $this->getSpieltyp(GET_C2SC);
		$AthletArray = array();
		foreach($this->mTurnierathletArray as $TurnierAthlet) {
			$AthletArray[] = new CAthlet($TurnierAthlet->getAthletID());
		}

		switch($this->mSpieltyp)
		{
			case S_HDTYP:
				$msg = 'Für ein '.$styp.' werden genau zwei Herren benötigt.';
				$flag = (count($AthletArray) != 2);
				if(!$flag) {$flag = (!($AthletArray[0]->getAnrede() == S_HERR and $AthletArray[1]->getAnrede() == S_HERR));}
				break;
			case S_DDTYP:
				$msg = 'Für ein '.$styp.' werden genau zwei Damen benötigt.';
				$flag = (count($AthletArray) != 2);
				if(!$flag) {$flag = (!($AthletArray[0]->getAnrede() == S_DAME and $AthletArray[1]->getAnrede() == S_DAME));}
				break;
			case S_MXTYP:
				$msg = 'Für ein '.$styp.' wird genau eine Dame und ein Herr benötigt.';
				$flag = (count($AthletArray) != 2);
				if(!$flag)
				{
					$flag = (!(($AthletArray[0]->getAnrede() == S_DAME and $AthletArray[1]->getAnrede() == S_HERR)
					or ($AthletArray[0]->getAnrede() == S_HERR and $AthletArray[1]->getAnrede() == S_DAME)));
				}
				break;
			case S_HETYP:
				$msg = 'Für ein '.$styp.' wird genau ein Herr benötigt.';
				$flag = (count($AthletArray) != 1);
				if(!$flag) {$flag = ($AthletArray[0]->getAnrede() != S_HERR);}
				break;
			case S_DETYP:
				$msg = 'Für ein '.$styp.' wird genau eine Dame benötigt.';
				$flag = (count($AthletArray) != 1);
				if(!$flag) {$flag = ($AthletArray[0]->getAnrede() != S_DAME);}
				break;
			case S_MFTYP:
				$msg = 'Für einen '.$styp.' werden mindestens zwei Athleten benötigt.';
				$flag = (count($this->mTurnierathletArray) < 2);
				break;
			default:
				$flag = false;
				break;
		}
		if($flag) {CDriveEntity::addCheckMsg($msg);}
	}

	/*@}*/
}
?>