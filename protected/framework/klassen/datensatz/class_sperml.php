<?php
include_once(dirname(__FILE__).'/../datenbank/class_drive_entity.php');

/*******************************************************************************************************************//**
 * Repräsentation einer Spielergebnismeldung.
 * @ingroup grp_recordset
 **********************************************************************************************************************/
class CSpErMl extends CDriveEntity
{
	/*****************************************************************************************************************//**
	 * @name Tabellenname
	 **************************************************************************************************************//*@{*/

	const mcTabName = 'sperml';

	/*@}*/

	/*****************************************************************************************************************//**
	 * @name Tabellenspalten
	 **************************************************************************************************************//*@{*/

	private $mDatum;
	private $mAustragungsortID;
	private $mBemerkungen;

	/*@}*/

	/*****************************************************************************************************************//**
	 * @name Objekt-Arrays
	 **************************************************************************************************************//*@{*/

	private $mSpielSpErMlArray;
	private $mErsatzspielerArray;

	/*@}*/

	/*****************************************************************************************************************//**
	 * @name Magics
	 **************************************************************************************************************//*@{*/

	public function __construct($SpermlID = 0) {
		parent::__construct(self::mcTabName, $SpermlID);
	}

	public function __toString()
	{
		if(!$this->getSpErMlID()) {return 'Keine Spielergebnismeldung';}
		return $this->getDatum(GET_DTDE).', '.$this->getAustragungsortID(GET_OFID);
	}

	/*@}*/

	/*****************************************************************************************************************//**
	 * @name Setter
	 **************************************************************************************************************//*@{*/

	public function setInitVals()
	{
		parent::setInitVals();
		$this->mDatum = '';
		$this->mAustragungsortID = 0;
		$this->mBemerkungen = null;
		$this->mSpielSpErMlArray = array();
		$this->mErsatzspielerArray = array();
	}

	final public function setSpErMlID($SpErMlID) {
		CDriveEntity::setID($SpErMlID);
	}

	final public function setDatum($Datum) {
		$this->mDatum = trim((string)$Datum);
	}

	final public function setAustragungsortID($AustragungsortID) {
		$this->mAustragungsortID = (int)$AustragungsortID;
	}

	final public function setBemerkungen($Bemerkungen) {
		$this->mBemerkungen = (($s = htmlspecialchars(trim((string)$Bemerkungen)))?($s):(null));
	}

	final public function setSpielSpErMlArray($SpielSpErMlArray)
	{
		CSpErMl::checkSpielSpErMlArray($SpielSpErMlArray);
		$this->mSpielSpErMlArray = array();
		foreach($GLOBALS['Enum']['SpErMlSpieltyp'] as $SpErMlSpieltyp)
		{
			if(isset($SpielSpErMlArray[$SpErMlSpieltyp])) {
				$this->mSpielSpErMlArray[$SpErMlSpieltyp] = clone $SpielSpErMlArray[$SpErMlSpieltyp];
				$this->mSpielSpErMlArray[$SpErMlSpieltyp]->setSpErMlID($this->getSpErMlID());
				$this->mSpielSpErMlArray[$SpErMlSpieltyp]->setSpErMlSpieltyp($SpErMlSpieltyp);
			}
		}
	}

	public static function checkSpielSpErMlArray($SpielSpErMlArray)
	{
		if(!is_array($SpielSpErMlArray)) {throw new Exception('$SpielSpErMlArray: Kein Array!');}
		if(count($SpielSpErMlArray) > 8) {throw new  Exception('$SpielSpErMlArray: Ungültige Anzahl!');}
		foreach($GLOBALS['Enum']['SpErMlSpieltyp'] as $SpErMlSpieltyp)
		{
			$String = '$SpErMlSpieltyp['.C2S_SpErMlSpieltyp($SpErMlSpieltyp).']';
			if(isset($SpielSpErMlArray[$SpErMlSpieltyp]) and !($SpielSpErMlArray[$SpErMlSpieltyp] instanceof CSpielSpErMl)) {
				throw new Exception($String.': Ungülitger Datentyp!');
			}
		}
	}

	final public function setErsatzspielerArray($ErsatzspielerArray)
	{
		CSpErMl::checkErsatzspielerArray($ErsatzspielerArray);
		$this->mErsatzspielerArray = array();
		foreach($ErsatzspielerArray as $Ersatzspieler) {
			$this->mErsatzspielerArray[] = clone $Ersatzspieler;
			current($this->mErsatzspielerArray)->setSpErMlID($this->getSpErMlID());
		}
	}

	public static function checkErsatzspielerArray($ErsatzspielerArray)
	{
		if(!is_array($ErsatzspielerArray)) {throw new Exception('$ErsatzspielerArray: Kein Array!');}
		if(count($ErsatzspielerArray) > MAX_ERSATZSPIELER) {throw new Exception('$ErsatzspielerArray: Ungültige Anzahl!');}
		foreach($ErsatzspielerArray as $Ersatzspieler)
		{
			if(!($Ersatzspieler instanceof CErsatzspieler)) {
				throw new Exception('$ErsatzspielerArray: Ungülitger Datentyp!');
			}
		}
	}

	/*@}*/

	/*****************************************************************************************************************//**
	 * @name Getter
	 **************************************************************************************************************//*@{*/

	final public function getSpErMlID()
	{
		return CDriveEntity::getID();
	}

	final public function getDatum($FlagVariant = array())
	{
		$FlagArray = (array)$FlagVariant;
		return ((in_array(GET_DTDE, $FlagArray))?(S2S_Datum_MySql2Deu($this->mDatum)):($this->mDatum));
	}

	final public function getAustragungsortID($FlagVariant = array())
	{
		$FlagArray = (array)$FlagVariant;
		return ((in_array(GET_OFID, $FlagArray))?(new CAustragungsort($this->mAustragungsortID)):($this->mAustragungsortID));
	}

	final public function getBemerkungen($FlagVariant = array())
	{
		$FlagArray = (array)$FlagVariant;
		return ((is_null($v = $this->mBemerkungen) and in_array(GET_NBSP, $FlagArray))?('&nbsp;'):($v));
	}

	final public function getSpielSpErMlArray()
	{
		return $this->mSpielSpErMlArray;
	}

	final public function getErsatzspielerArray()
	{
		return $this->mErsatzspielerArray;
	}

	/*@}*/

	/*****************************************************************************************************************//**
	 * @name Datenbank
	 **************************************************************************************************************//*@{*/

	public static function isValidID($SpErMlID) {
		return CDriveEntity::genericIsValidID(self::mcTabName, $SpErMlID);
	}

	public function load($SpErMlID)
	{
		self::setInitVals();
		$this->setSpErMlID($SpErMlID);
		$format = 'SELECT datum, austragungsort_id, bemerkungen '.
		          'FROM sperml WHERE sperml_id=%s';
		$query = sprintf($format, $this->getSpErMlID());
		if(!$result = mysql_query($query)) {throw new Exception(mysql_error(CDriveEntity::getDB()));}
		$row = mysql_fetch_row($result);
		if(!$row) {throw new Exception('Spielergebnismeldung mit sperml_id='.$SpErMlID.' nicht gefunden!');}
		$this->mDatum = lS($row[0]);
		$this->mAustragungsortID = lD($row[1]);
		$this->mBemerkungen = lS($row[2]);

		// SpielSpErMlArray
		$query = 'SELECT spiel_id, spermlspieltyp FROM spiele_sperml WHERE sperml_id='.$this->getSpErMlID();
		if(!$result = mysql_query($query)) {throw new Exception(mysql_error(CDriveEntity::getDB()));}
		$this->mSpielSpErMlArray = array();
		while($row = mysql_fetch_row($result)) {$this->mSpielSpErMlArray[lD($row[1])] = new CSpielSpErMl(lD($row[0]));}

		// ErsatzspielerArray
		$query = 'SELECT ersatzspieler_id FROM ersatzspieler e INNER JOIN athleten a ON e.athlet_id=a.athlet_id '.
		'WHERE sperml_id='.$this->getSpErMlID().' ORDER BY nachname, vorname';
		if(!$result = mysql_query($query)) {throw new Exception(mysql_error(CDriveEntity::getDB()));}
		$this->mErsatzspielerArray = array();
		while($row = mysql_fetch_row($result)) {$this->mErsatzspielerArray[] = new CErsatzspieler(lD($row[0]));}

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
			$format = 'UPDATE sperml SET '.
			          'datum=%s, austragungsort_id=%s, bemerkungen=%s '.
			          'WHERE sperml_id=%s';
			$query = sprintf($format, sS($this->mDatum), sD($this->mAustragungsortID), sS($this->mBemerkungen),
			$this->getID());
		}
		else
		{
			$format = 'INSERT INTO sperml ('.
			          'datum, austragungsort_id, bemerkungen'.
			          ') VALUES (%s, %s, %s)';
			$query = sprintf($format, sS($this->mDatum), sD($this->mAustragungsortID), sS($this->mBemerkungen));
		}
		if(!$result = mysql_query($query)) {throw new Exception(mysql_error(CDriveEntity::getDB()));}

		// Basisklasse
		parent::store();

		// SpielSpErMlArray
		foreach($GLOBALS['Enum']['SpErMlSpieltyp'] as $SpErMlSpieltyp)
		{
			$query = 'SELECT spiel_id FROM spiele_sperml '.
			         'WHERE sperml_id='.$this->getSpErMlID().' AND spermlspieltyp='.$SpErMlSpieltyp;
			if(!$result = mysql_query($query)) {throw new Exception(mysql_error(CDriveEntity::getDB()));}
			if($row = mysql_fetch_row($result))
			{
				if(isset($this->mSpielSpErMlArray[$SpErMlSpieltyp])) {
					$this->mSpielSpErMlArray[$SpErMlSpieltyp]->setSpielID($row[0]);
				}
				else {$SpielSpErMl = new CSpielSpErMl($row[0]); $SpielSpErMl->delete();}
			}
			else if(isset($this->mSpielSpErMlArray[$SpErMlSpieltyp])) {
				$this->mSpielSpErMlArray[$SpErMlSpieltyp]->setSpErMlID($this->getSpErMlID());
			}
		}
		foreach($this->mSpielSpErMlArray as $SpielSpErMl) {$SpielSpErMl->store();}

		// ErsatzspielerArray
		$query = 'DELETE FROM ersatzspieler WHERE sperml_id='.$this->getSpErMlID();
		if(count($this->mErsatzspielerArray))
		{
			$query .= ' AND NOT (athlet_id='.reset($this->mErsatzspielerArray)->getAthletID();
			while($ErSp = next($this->mErsatzspielerArray)) {$query .= ' OR athlet_id='. $ErSp->getAthletID();}
			$query .= ')';
		}
		if(!$result = mysql_query($query)) {throw new Exception(mysql_error(CDriveEntity::getDB()));}

		foreach($this->mErsatzspielerArray as $ErSpNew)
		{
			$query = 'SELECT ersatzspieler_id FROM ersatzspieler '.
			         'WHERE sperml_id='.$this->getSpErMlID(). ' AND athlet_id='. $ErSpNew->getAthletID();
			if(!$result = mysql_query($query)) {throw new Exception(mysql_error(CDriveEntity::getDB()));}
			if(!($row = mysql_fetch_row($result))) {$ErSpNew->setSpErMlID($this->getSpErMlID()); $ErSpNew->store();}
		}
	}

	public function check($CheckForeignKey = true)
	{
		// Datum
		if(!(preg_match(REGEX_DATE_SQ, $this->mDatum)
		and preg_match(REGEX_DATE_DE, $this->getDatum(GET_DTDE)))) {
			CDriveEntity::addCheckMsg('Das Datum muss von der Form \'TT.MM.JJJJ\' sein.');
		}
		else if(!checkdate(
		substr($this->mDatum, 5, 2), substr($this->mDatum, 8, 2), substr($this->mDatum, 0, 4))) {
			CDriveEntity::addCheckMsg('Das Datum is ungültig.');
		}

		// AustragungsortID
		if(!CAustragungsort::isValidID($this->mAustragungsortID)) {
			CDriveEntity::addCheckMsg('Die austragungsort_id ist ungültig.');
		}

		// Bemerkungen
		if(!is_null($this->mBemerkungen))
		{
			if(strlen($this->mBemerkungen) > 255) {
				CDriveEntity::addCheckMsg('Die Bemerkung darf nicht länger als 255 Zeichen sein.');
			}
		}

		// SpielSpErMlArray
		foreach($this->mSpielSpErMlArray as $SpielSpErMl)
		{
			$SpielSpErMl->check(false);
			if(count($SpielSpErMl->getCheckMsg()))
			{
				CDriveEntity::addCheckMsg($SpielSpErMl->getSpErMlSpieltyp(GET_C2SC).' weist folgende Fehler auf ...');
				CDriveEntity::addCheckMsg($SpielSpErMl->getCheckMsg());
			}
		}

		// ErsatzspielerArray
		foreach($this->mErsatzspielerArray as $i => $Ersatzspieler)
		{
			$Ersatzspieler->check(false);
			if(count($Ersatzspieler->getCheckMsg()))
			{
				CDriveEntity::addCheckMsg('Ersatzspieler Nr '.($i+1).' weist folgende Fehler auf ...');
				CDriveEntity::addCheckMsg($Ersatzspieler->getCheckMsg());
			}
		}
	}

	/*@}*/

	/*****************************************************************************************************************//**
	 * @name Verschiedenes
	 **************************************************************************************************************//*@{*/

	public function getErgSaetze()
	{
		$gewHeim = 0; $gewGast = 0;
		foreach($GLOBALS['Enum']['SpErMlSpieltyp'] as $SpErMlSpieltyp)
		{
			if(isset($this->mSpielSpErMlArray[$SpErMlSpieltyp]))
			{
				$Anz = $this->mSpielSpErMlArray[$SpErMlSpieltyp]->getAnzSaetze();
				$Satz = $this->mSpielSpErMlArray[$SpErMlSpieltyp]->getSatzArray();
				for($Nr=1; $Nr<=$Anz; $Nr++)
				{
					$Ergebnis = $Satz[$Nr]->getErgebnis();
					if     (C_HEIMGEW == $Ergebnis) {$gewHeim++;}
					else if(C_GASTGEW == $Ergebnis) {$gewGast++;}
				}
			}
		}
		return $gewHeim.':'.$gewGast;
	}

	public function getErsatzspielerArrayForSeite($Seite)
	{
		$AthletIDArray = array();
		$query = 'SELECT k.athlet_id '.
		'FROM (kontrahenten k INNER JOIN spiele_sperml ss ON k.spiel_id=ss.spiel_id) '.
		'INNER JOIN _v1_punktspiele p ON ss.sperml_id=p.sperml_id '.
		'WHERE k.seite='.$Seite.' AND p.sperml_id='.$this->getSpErMlID().' '.
		'GROUP BY k.athlet_id';
		if(!$result = mysql_query($query)) {throw new Exception(mysql_error(CDriveEntity::getDB()));}
		while($row = mysql_fetch_row($result)) {$AthletIDArray[] = (int)$row[0];}

		$ErsatzspielerArray = $this->getErsatzspielerArray();

		$ReturnArray = array();
		foreach($ErsatzspielerArray as $Ersatzspieler) {
			foreach($AthletIDArray as $AthletID) {
				if($Ersatzspieler->getAthletID() == $AthletID) {$ReturnArray[] = clone $Ersatzspieler;}
			}
		}
		return $ReturnArray;
	}

	public function getErgSpiele()
	{
		$gewHeim = 0; $gewGast = 0;
		foreach($GLOBALS['Enum']['SpErMlSpieltyp'] as $SpErMlSpieltyp)
		{
			if(isset($this->mSpielSpErMlArray[$SpErMlSpieltyp]))
			{
				$Ergebnis = $this->mSpielSpErMlArray[$SpErMlSpieltyp]->getErgebnis();
				if     (C_HEIMGEW == $Ergebnis) {$gewHeim++;}
				else if(C_GASTGEW == $Ergebnis) {$gewGast++;}
			}
		}
		return $gewHeim.':'.$gewGast;
	}

	public function getXHTML()
	{
		$filename = dirname(__FILE__).'/../../../inhalte/schnipsel/allgemein/sni_sperml.php';
		$SpErMl = $this;
		if(is_file($filename)) {
			ob_start();
			include $filename;
			$contents = ob_get_contents();
			ob_end_clean();
			return $contents;
		}
	}

	public function getErgebnis($FlagVariant = array())
	{
		$FlagArray = (array)$FlagVariant;
		$SpielPunkte = explode(':', $this->getErgSpiele());
		$Ergebnis = C_UNENTSCH;
		if     ($SpielPunkte[0] > $SpielPunkte[1]) {$Ergebnis = C_HEIMGEW;}
		else if($SpielPunkte[0] < $SpielPunkte[1]) {$Ergebnis = C_GASTGEW;}
		return ((in_array(GET_C2SC, $FlagArray))?(C2S_Ergebnis($Ergebnis)):($Ergebnis));
	}

	/*@}*/
}
?>