<?php
include_once(dirname(__FILE__).'/../datenbank/class_drive_entity.php');

/*******************************************************************************************************************//**
 * Repräsentation eines Spiels.
 * @ingroup grp_recordset
 **********************************************************************************************************************/
class CSpiel extends CDriveEntity
{
	/*****************************************************************************************************************//**
	 * @name Tabellenname
	 **************************************************************************************************************//*@{*/

	const mcTabName = 'spiele';

	/*@}*/

	/*****************************************************************************************************************//**
	 * @name Tabellenspalten
	 **************************************************************************************************************//*@{*/

	private $mSpieltyp;

	/*@}*/

	/*****************************************************************************************************************//**
	 * @name Objekt-Arrays
	 **************************************************************************************************************//*@{*/

	private $mKontrahentArray;
	private $mSatzArray;

	/*@}*/


	/*****************************************************************************************************************//**
	 * @name Magics
	 **************************************************************************************************************//*@{*/

	public function __construct($SpielID = 0) {
		parent::__construct(self::mcTabName, $SpielID);
	}

	public function __toString()
	{
		if(!$this->getSpielID()) {return 'Kein Spiel';}
		$retstr = $this->getSpieltyp(GET_C2SC).':';
		foreach($this->mSatzArray as $Satz) {$retstr .= ' '.$Satz;}
		return $retstr;
	}

	public function __clone() {
		foreach($GLOBALS['Enum']['Seite'] as $Seite) {
			foreach($this->mKontrahentArray[$Seite] as &$Kontrahent) {$Kontrahent = clone $Kontrahent;}
		}
		foreach($this->mSatzArray as &$Satz) {$Satz = clone $Satz;}
	}

	/*@}*/

	/*****************************************************************************************************************//**
	 * @name Setter
	 **************************************************************************************************************//*@{*/

	public function setInitVals()
	{
		parent::setInitVals();
		$this->mSpieltyp = 0;
		foreach($GLOBALS['Enum']['Seite'] as $Seite) {$this->mKontrahentArray[$Seite] = array();}
		$this->mSatzArray = array();
	}

	final public function setSpielID($SpielID) {
		CDriveEntity::setID($SpielID);
	}

	public function setSpieltyp($Spieltyp) {
		$this->mSpieltyp = (int)$Spieltyp;
	}

	final public function setKontrahentArray($KontrahentArray)
	{
		CSpiel::checkKontrahentArray($KontrahentArray);

		$this->mKontrahentArray = array();
		foreach($GLOBALS['Enum']['Seite'] as $Seite)
		{
			$this->mKontrahentArray[$Seite] = array();
			$Position = 1;
			foreach($KontrahentArray[$Seite] as $Kontrahent)
			{
				$this->mKontrahentArray[$Seite][$Position] = clone $Kontrahent;
				$this->mKontrahentArray[$Seite][$Position]->setSpielID($this->getSpielID());
				$this->mKontrahentArray[$Seite][$Position]->setSeite($Seite);
				$this->mKontrahentArray[$Seite][$Position]->setPosition($Position);
				$Position++;
			}
		}
	}

	public static function checkKontrahentArray(&$KontrahentArray)
	{
		if(!is_array($KontrahentArray)) {throw new Exception('$KontrahentArray: Kein Array!');}
		foreach($GLOBALS['Enum']['Seite'] as $Seite)
		{
			$String = '$KontrahentArray['.C2S_Seite($Seite).']';
			if(!isset($KontrahentArray[$Seite])) {$KontrahentArray[$Seite] = array();}
			if(!is_array($KontrahentArray[$Seite])) {throw new Exception($String.': Kein Array!');}
			if(count($KontrahentArray[$Seite]) > 2) {throw new  Exception($String.': Ungültige Anzahl!');}
			$Position = 1;
			foreach($KontrahentArray[$Seite] as $Idx => $Kontrahent)
			{
				if($Position++ != $Idx) {throw new Exception($String.': Index nicht fortlaufend bzw. mit 1 beginnend!');}
				if(!($Kontrahent instanceof CKontrahent)) {
					throw new Exception($String.': Ungülitger Datentyp!');
				}
			}
		}
	}

	final public function setSatzArray($SatzArray)
	{
		CSpiel::checkSatzArray($SatzArray);
		$this->mSatzArray = array();

		for($Nr = 1; $Nr <= count($SatzArray); $Nr++)
		{
			$this->mSatzArray[$Nr] = clone $SatzArray[$Nr];
			$this->mSatzArray[$Nr]->setSpielID($this->getSpielID());
			$this->mSatzArray[$Nr]->setNr($Nr);
		}
	}

	public static function checkSatzArray(&$SatzArray)
	{
		if(!is_array($SatzArray)) {throw new Exception('$SatzArray: Kein Array!');}
		if(count($SatzArray) > MAX_SAETZE) {throw new Exception('$SatzArray: Ungültige Anzahl!');}
		$Nr = 1;
		foreach($SatzArray as $Idx => $Satz)
		{
			if($Nr++ != $Idx) {throw new Exception('$SatzArray: Index nicht fortlaufend bzw. mit 1 beginnend!');}
			if(!($Satz instanceof CSatz)) {throw new Exception('$SatzArray: Ungülitger Datentyp!');}
		}
	}

	/*@}*/

	/*****************************************************************************************************************//**
	 * @name Getter
	 **************************************************************************************************************//*@{*/

	final public function getSpielID()
	{
		return CDriveEntity::getID();
	}

	final public function getSpieltyp($FlagVariant = array())
	{
		$FlagArray = (array)$FlagVariant;
		if(in_array(GET_C2SC, $FlagArray)) {return C2S_Spieltyp($this->mSpieltyp);}
		return $this->mSpieltyp;
	}

	final public function getSatzArray()
	{
		return $this->mSatzArray;
	}

	final public function getSatz($Nr, $FlagVariant = array())
	{
		$FlagArray = (array)$FlagVariant;
		if(!isset($this->mSatzArray[$Nr])) {
			return (in_array(GET_NBSP, $FlagArray))?('&nbsp;'):(null);
		}
		if(!($this->mSatzArray[$Nr] instanceof CSatz)) {
			return (in_array(GET_NBSP, $FlagArray))?('&nbsp;'):(null);
		}
		$Satz = $this->mSatzArray[$Nr];
		return ((in_array(GET_SPEC, $FlagArray))?($Satz->getPunkteString()):($Satz));
	}

	final public function getKontrahentArray()
	{
		return $this->mKontrahentArray;
	}

	final public function getKontrahent($Seite, $Position, $FlagVariant = array())
	{
		$FlagArray = (array)$FlagVariant;
		if(!isset($this->mKontrahentArray[$Seite][$Position])) {
			return (in_array(GET_NBSP, $FlagArray))?('&nbsp;'):(null);
		}
		if(!($this->mKontrahentArray[$Seite][$Position] instanceof CKontrahent)) {
			return (in_array(GET_NBSP, $FlagArray))?('&nbsp;'):(null);
		}
		$Kontrahent = $this->mKontrahentArray[$Seite][$Position];
		return ((in_array(GET_SPEC, $FlagArray))?($Kontrahent->getAthletID(GET_OFID)->getNachnameVorname()):($Kontrahent));
	}

	/*@}*/

	/*****************************************************************************************************************//**
	 * @name Datenbank
	 **************************************************************************************************************//*@{*/

	public static function isValidID($SpielID) {
		return CDriveEntity::genericIsValidID(self::mcTabName, $SpielID);
	}

	public function load($SpielID)
	{
		self::setInitVals();
		$this->setSpielID($SpielID);
		$format = 'SELECT spieltyp '.
		          'FROM spiele WHERE spiel_id=%s';
		$query = sprintf($format, $this->getSpielID());
		if(!$result = mysqli_query(CDriveEntity::getDB(), $query)) {throw new Exception(mysqli_error(CDriveEntity::getDB()));}
		$row = mysqli_fetch_row($result);
		if(!$row) {throw new Exception('Spiel mit spiel_id='.$SpielID.' nicht gefunden!');}
		$this->mSpieltyp = lD($row[0]);

		// KontrahentArray
		foreach($GLOBALS['Enum']['Seite'] as $Seite)
		{
			$query = 'SELECT kontrahent_id, position FROM kontrahenten '.
			         'WHERE spiel_id='.$this->getSpielID().' AND seite='.$Seite.' ORDER BY position';
			if(!$result = mysqli_query(CDriveEntity::getDB(), $query)) {throw new Exception(mysqli_error(CDriveEntity::getDB()));}
			while($row = mysqli_fetch_row($result)) {$this->mKontrahentArray[$Seite][$row[1]] = new CKontrahent($row[0]);}
		}

		// SatzArray
		$query = 'SELECT satz_id, nr FROM saetze WHERE spiel_id='.$this->getSpielID().' ORDER BY nr';
		if(!$result = mysqli_query(CDriveEntity::getDB(), $query)) {throw new Exception(mysqli_error(CDriveEntity::getDB()));}
		while($row = mysqli_fetch_row($result)) {$this->mSatzArray[$row[1]] = new CSatz($row[0]);}
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
			$format = 'UPDATE spiele SET '.
			          'spieltyp=%s '.
			          'WHERE spiel_id=%s';
			$query = sprintf($format, sD($this->mSpieltyp), $this->getID());
		}
		else
		{
			$format = 'INSERT INTO spiele ('.
			          'spieltyp'.
			          ') VALUES (%s)';
			$query = sprintf($format, sD($this->mSpieltyp));
		}
		if(!$result = mysqli_query(CDriveEntity::getDB(), $query)) {throw new Exception(mysqli_error(CDriveEntity::getDB()));}

		// Basisklasse
		parent::store();

		// KontrahentArray
		foreach($GLOBALS['Enum']['Seite'] as $Seite)
		{
			for($Position = 1; $Position <=2; $Position++)
			{
				$query = 'SELECT kontrahent_id FROM kontrahenten '.
				         'WHERE spiel_id='.$this->getSpielID().' AND seite='.$Seite.' AND position='.$Position;
				if(!$result = mysqli_query(CDriveEntity::getDB(), $query)) {throw new Exception(mysqli_error(CDriveEntity::getDB()));}
				if($row = mysqli_fetch_row($result))
				{
					if(isset($this->mKontrahentArray[$Seite][$Position])) {
						$this->mKontrahentArray[$Seite][$Position]->setKontrahentID($row[0]);
					}
					else {$Kontrahent = new CKontrahent($row[0]); $Kontrahent->delete();}
				}
				else if(isset($this->mKontrahentArray[$Seite][$Position])) {
					$this->mKontrahentArray[$Seite][$Position]->setSpielID($this->getSpielID());
				}
			}
			foreach($this->mKontrahentArray[$Seite] as $Kontrahent) {$Kontrahent->store();}
		}

		// SatzArray
		for($Nr = 1; $Nr <=MAX_SAETZE; $Nr++)
		{
			$query = 'SELECT satz_id FROM saetze WHERE spiel_id='.$this->getSpielID().' AND nr='.$Nr;
			if(!$result = mysqli_query(CDriveEntity::getDB(), $query)) {throw new Exception(mysqli_error(CDriveEntity::getDB()));}
			if($row = mysqli_fetch_row($result))
			{
				if(isset($this->mSatzArray[$Nr])) {
					$this->mSatzArray[$Nr]->setSatzID($row[0]);
				}
				else {$Satz = new CSatz($row[0]); $Satz->delete();}
			}
			else if(isset($this->mSatzArray[$Nr])) {
				$this->mSatzArray[$Nr]->setSpielID($this->getSpielID());
			}
		}
		foreach($this->mSatzArray as $Satz) {$Satz->store();}
	}

	public function check()
	{
		// Spieltyp
		if(is_null(C2S_Spieltyp($this->mSpieltyp)) or S_MFTYP == $this->mSpieltyp) {
			CDriveEntity::addCheckMsg('Der Spieltyp ist ungültig.');
		}
		else
		{
			if(!count($this->mKontrahentArray[S_HEIM]) and !count($this->mKontrahentArray[S_GAST])) {
				CDriveEntity::addCheckMsg('Kontrahenten fehlen.');
			}
			else
			{
				$AthProSeite = ((S_EINZEL == C2C_Spielart($this->mSpieltyp))?(1):(2));
				foreach($GLOBALS['Enum']['Seite'] as $Seite)
				{
					if(count($this->mKontrahentArray[$Seite]) and count($this->mKontrahentArray[$Seite]) != $AthProSeite) {
						CDriveEntity::addCheckMsg('Falsche Anzahl an Kontrahenten auf '.C2S_Seite($Seite).'-Seite.');
					}
				}
			}
		}
		if(!count($this->mSatzArray)) {
			CDriveEntity::addCheckMsg('Mindestens ein Satz ist erforderlich.');
		}

		// KontrahentArray
		foreach($GLOBALS['Enum']['Seite'] as $Seite)
		{
			foreach($this->mKontrahentArray[$Seite] as $Kontrahent)
			{
				$Kontrahent->check(false);
				if(count($Kontrahent->getCheckMsg()))
				{
					CDriveEntity::addCheckMsg('Kontrahent '.$Kontrahent->getPosition().' auf '.$Kontrahent->getSeite(GET_C2SC).
					                          '-Seite weist folgende Fehler auf ...');
					CDriveEntity::addCheckMsg($Kontrahent->getCheckMsg());
				}
			}
		}

		// SatzArray
		foreach($this->mSatzArray as $Satz)
		{
			$Satz->check(false);
			if(count($Satz->getCheckMsg()))
			{
				CDriveEntity::addCheckMsg('Satz Nr '.$Satz->getNr().' weist folgende Fehler auf ...');
				CDriveEntity::addCheckMsg($Satz->getCheckMsg());
			}
		}
	}

	/*@}*/

	/*****************************************************************************************************************//**
	 * @name Verschiedenes
	 **************************************************************************************************************//*@{*/

	public function getAnzSaetze() {return count($this->mSatzArray);}

	public function swapPunkteInSaetze()
	{
		foreach($this->mSatzArray as $Satz) {$Satz->swapPunkte();}
	}


	public function getErgebnis($FlagVariant = array())
	{
		$FlagArray = (array)$FlagVariant;
		$gewHeim = 0; $gewGast = 0;
		foreach($this->mSatzArray as $Satz)
		{
			if     ($Satz->getErgebnis() == C_HEIMGEW) $gewHeim++;
			else if($Satz->getErgebnis() == C_GASTGEW) $gewGast++;
		}
		$Ergebnis = C_UNENTSCH;
		if($gewHeim > $gewGast) {$Ergebnis = C_HEIMGEW;}
		if($gewHeim < $gewGast) {$Ergebnis = C_GASTGEW;}
		return ((in_array(GET_C2SC, $FlagArray))?(C2S_Ergebnis($Ergebnis)):($Ergebnis));
	}

	public function getErgSaetze()
	{
		$gewHeim = 0; $gewGast = 0;
		foreach($this->mSatzArray as $Satz)
		{
			if     ($Satz->getErgebnis() == C_HEIMGEW) $gewHeim++;
			else if($Satz->getErgebnis() == C_GASTGEW) $gewGast++;
		}
		return $gewHeim.':'.$gewGast;
	}

	public function getErgSpiel()
	{
		$gewHeim = 0; $gewGast = 0;
		foreach($this->mSatzArray as $Satz)
		{
			if     ($Satz->getErgebnis() == C_HEIMGEW) $gewHeim++;
			else if($Satz->getErgebnis() == C_GASTGEW) $gewGast++;
		}
		$Ergebnis = '0:0';
		if($gewHeim > $gewGast) {$Ergebnis = '1:0';}
		if($gewHeim < $gewGast) {$Ergebnis = '0:1';}
		return $Ergebnis;
	}

	/*@}*/
}
?>