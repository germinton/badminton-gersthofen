<?php
include_once(dirname(__FILE__).'/../datenbank/class_drive_entity.php');
include_once(dirname(__FILE__).'/class_turniermeldung.php');
include_once(dirname(__FILE__).'/class_athlet.php');

/*******************************************************************************************************************//**
 * Repräsentation einers an einem Turnier teilgenommenen Athleten.
 * @ingroup grp_recordset
 **********************************************************************************************************************/
class CTurnierathlet extends CDriveEntity
{
	/*****************************************************************************************************************//**
	 * @name Tabellenname
	 **************************************************************************************************************//*@{*/

	const mcTabName = 'turnierathleten';

	/*@}*/

	/*****************************************************************************************************************//**
	 * @name Tabellenspalten
	 **************************************************************************************************************//*@{*/

	private $mTurniermeldungID;
	private $mAthletID;

	/*@}*/

	/*****************************************************************************************************************//**
	 * @name Magics
	 **************************************************************************************************************//*@{*/

	public function __construct($TurnierathletID = 0) {
		parent::__construct(self::mcTabName, $TurnierathletID);
	}

	public function __toString()
	{
		if(!$this->getTurnierathletID()) {return 'Kein Turnierathlet';}
		return (string)$this->getAthletID(GET_OFID);
	}

	/*@}*/

	/*****************************************************************************************************************//**
	 * @name Setter
	 **************************************************************************************************************//*@{*/

	public function setInitVals()
	{
		parent::setInitVals();
		$this->mTurniermeldungID = 0;
		$this->mAthletID = 0;
	}

	final public function setTurnierathletID($TurnierathletID) {
		CDriveEntity::setID($TurnierathletID);
	}

	final public function setTurniermeldungID($TurniermeldungID) {
		$this->mTurniermeldungID = (int)$TurniermeldungID;
	}

	final public function setAthletID($AthletID) {
		$this->mAthletID = (int)$AthletID;
	}

	/*@}*/

	/*****************************************************************************************************************//**
	 * @name Getter
	 **************************************************************************************************************//*@{*/

	final public function getTurnierathletID()
	{
		return CDriveEntity::getID();
	}

	final public function getTurniermeldungID()
	{
		return $this->mTurniermeldungID;
	}

	final public function getAthletID($FlagVariant = array())
	{
		$FlagArray = (array)$FlagVariant;
		return ((in_array(GET_OFID, $FlagArray))?(new CAthlet($this->mAthletID)):($this->mAthletID));
	}

	/*@}*/

	/*****************************************************************************************************************//**
	 * @name Datenbank
	 **************************************************************************************************************//*@{*/

	public static function isValidID($TurnierathletID) {
		return CDriveEntity::genericIsValidID(self::mcTabName, $TurnierathletID);
	}

	public function load($TurnierathletID)
	{
		self::setInitVals();
		$this->setTurnierathletID($TurnierathletID);
		$format = 'SELECT turniermeldung_id, athlet_id '.
		          'FROM turnierathleten WHERE turnierathlet_id=%s';
		$query = sprintf($format, $this->getTurnierathletID());
		if(!$result = mysqli_query(CDriveEntity::getDB(), $query)) {throw new Exception(mysqli_error(CDriveEntity::getDB()));}
		$row = mysqli_fetch_row($result);
		if(!$row) {throw new Exception('Turnierathlet mit turnierathlet_id='.$TurnierathletID.' nicht gefunden!');}
		$this->mTurniermeldungID = lD($row[0]);
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
			$format = 'UPDATE turnierathleten SET '.
			          'turniermeldung_id=%s, athlet_id=%s '.
			          'WHERE turnierathlet_id=%s';
			$query = sprintf($format, sD($this->mTurniermeldungID), sD($this->mAthletID), $this->getID());
		}
		else
		{
			$format = 'INSERT INTO turnierathleten ('.
			          'turniermeldung_id, athlet_id'.
			          ') VALUES (%s, %s)';
			$query = sprintf($format, sD($this->mTurniermeldungID), sD($this->mAthletID));
		}
		if(!$result = mysqli_query(CDriveEntity::getDB(), $query)) {throw new Exception(mysqli_error(CDriveEntity::getDB()));}

		// Basisklasse
		parent::store();
	}

	public function check($CheckForeignKey = true)
	{
		// TurniermeldungID
		if($CheckForeignKey and !CTurniermeldung::isValidID($this->mTurniermeldungID)) {
			CDriveEntity::addCheckMsg('Die turniermeldung_id ist ungültig.');
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

	public function getMeisterstring()
	{
		$Athlet = new CAthlet($this->getAthletID());
		$Turniermeldung = new CTurniermeldung($this->mTurniermeldungID);
		$Turnier = new CTurnier($Turniermeldung->getTurnierID());
		$Spielart = C2C_Spielart($Turniermeldung->getSpieltyp());

		$Platz = $Turniermeldung->getPlatzierung();
		$Ebene = $Turnier->getEbene();
		$Anrede = $Athlet->getAnrede();
		$Jahr = substr($Turnier->getDatumVon(), 0, 4);

		$Meistertitel = self::composeMeistertitel($Platz, $Ebene, $Anrede, $Jahr);

		$Spieltyp = $Turniermeldung->getSpieltyp();
		$Spielgruppe = $Turniermeldung->getSpielgruppe();
		$Partner = null;
		if(S_DOPPEL == $Spielart or S_MIXED == $Spielart)
		{
			$TurnierathletArray = $Turniermeldung->getTurnierathletArray();
			$AthletID1 = $TurnierathletArray[0]->getAthletID();
			$AthletID2 = $TurnierathletArray[1]->getAthletID();
			$Partner = new CAthlet(($AthletID1 != $this->getAthletID())?($AthletID1):($AthletID2));
		}

		$Zusatzinfos = self::composeZusatzinfos($Spieltyp, $Spielgruppe, $Partner);

		return $Meistertitel.' '.$Zusatzinfos;
	}

	private static function composeMeistertitel($Platz, $Ebene, $Anrede, $Jahr)
	{
		if(!(1 == $Platz or 2 == $Platz)) {return 'Kein Meistertitel';}
		if(S_EBENE_BEZIRK == $Ebene) {
			$Meistertitel = 'Schwäbische'.((S_HERR == $Anrede)?('r'):('')).' '.(($Platz == 1)?('M'):('Vizem')).'eister';
		}
		else
		{
			$Meistertitel = C2S_Meister($Ebene);
			if(2 == $Platz) {$Meistertitel = 'Vize'.strtolower($Meistertitel);}
		}
		return $Meistertitel.((S_HERR == $Anrede)?(''):('in')).' '.$Jahr;
	}

	public function getRLErfolgstring()
	{
		$Athlet = new CAthlet($this->getAthletID());
		$Turniermeldung = new CTurniermeldung($this->mTurniermeldungID);
		$Turnier = new CTurnier($Turniermeldung->getTurnierID());
		$Spielart = C2C_Spielart($Turniermeldung->getSpieltyp());

		$Platz = $Turniermeldung->getPlatzierung();
		$HRichtung = $Turnier->getHRichtung();
		$Ebene = $Turnier->getEbene();
		$Jahr = substr($Turnier->getDatumVon(), 0, 4);

		$RLErfolg = self::composeRLErfolg($Platz, $HRichtung, $Ebene, $Jahr);

		$Spieltyp = $Turniermeldung->getSpieltyp();
		$Spielgruppe = $Turniermeldung->getSpielgruppe();
		$Partner = null;
		if(S_DOPPEL == $Spielart or S_MIXED == $Spielart)
		{
			$TurnierathletArray = $Turniermeldung->getTurnierathletArray();
			$AthletID1 = $TurnierathletArray[0]->getAthletID();
			$AthletID2 = $TurnierathletArray[1]->getAthletID();
			$Partner = new CAthlet(($AthletID1 != $this->getAthletID())?($AthletID1):($AthletID2));
		}

		$Zusatzinfos = self::composeZusatzinfos($Spieltyp, $Spielgruppe, $Partner);

		return $RLErfolg.' '.$Zusatzinfos;
	}

	private static function composeRLErfolg($Platz, $HRichtung, $Ebene, $Jahr)
	{
		$RLErfolg = '';
		if(is_null($Platz)) {$RLErfolg .= 'Teilname';}
		else {$RLErfolg .= $Platz.'. Platz';}
		$RLErfolg .= ', ';
		if($HRichtung) {$RLErfolg .= C2S_HRichtung($HRichtung).'-';}
		switch($Ebene)
		{
			case S_EBENE_INTERN: $RLErfolg .= 'Vereins-'; break;
			case S_EBENE_STADT: $RLErfolg .= 'Städtische '; break;
			case S_EBENE_LANDKREIS: $RLErfolg .= 'Landkreis-'; break;
			case S_EBENE_BEZIRK: $RLErfolg .= 'Schwäbische '; break;
			case S_EBENE_BUNDESLAND: $RLErfolg .= 'Bayerische '; break;
			case S_EBENE_REGION: $RLErfolg .= 'Regional-'; break;
			case S_EBENE_NATIONAL: $RLErfolg .= 'Deutsche '; break;
			case S_EBENE_EUROPA: $RLErfolg .= 'Europäische '; break;
			case S_EBENE_WELT: $RLErfolg .= 'Welt-'; break;
			default: break;
		}
		return $RLErfolg.'Rangliste '.$Jahr;
	}

	private static function composeZusatzinfos($Spieltyp, $Spielgruppe = null, $Partner = null)
	{
		$Zusatzinfo = '('.C2S_SpieltypKurz($Spieltyp);
		if(strlen($Spielgruppe)) {$Zusatzinfo .= ' '.$Spielgruppe;}
		if($Partner instanceof CAthlet) {$Zusatzinfo .= ' mit '.$Partner;}
		return $Zusatzinfo.')';
	}

	/*@}*/
}
?>