<?php
include_once(dirname(__FILE__).'/../datenbank/class_drive_entity_with_attach.php');
include_once(dirname(__FILE__).'/class_verein.php');
include_once(dirname(__FILE__).'/class_saison.php');
include_once(dirname(__FILE__).'/class_ligaklasse.php');

/*******************************************************************************************************************//**
 * Repräsentation einer Mannschaft.
 * @ingroup grp_recordset
 **********************************************************************************************************************/
class CMannschaft extends CDriveEntityWithAttachment
{
	/*****************************************************************************************************************//**
	 * @name Tabellenname
	 **************************************************************************************************************//*@{*/

	const mcTabName = 'mannschaften';

	/*@}*/

	/*****************************************************************************************************************//**
	 * @name Tabellenspalten
	 **************************************************************************************************************//*@{*/

	private $mSaisonID;
	private $mAKlaGruppe;
	private $mNr;
	private $mPlatzierung1;
	private $mPlatzierung2;
	private $mLigaKlasseID;
	private $mVereinID;
	private $mBildunterschrift;
	private $mErgDienst;

	/*@}*/

	/*****************************************************************************************************************//**
	 * @name Magics
	 **************************************************************************************************************//*@{*/

	public function __construct($MannschaftID = 0) {
		parent::__construct(self::mcTabName, $MannschaftID);
	}

	public function __toString()
	{
		if(!$this->getMannschaftID()) {return 'Keine Mannschaft';}
		$returnstring = '';
		// Eigener Verein
		$query = 'SELECT verein_id FROM vereine_benutzerinformationen';
		if(!$result = mysqli_query(CDriveEntity::getDB(), $query)) {throw new Exception(mysqli_error(CDriveEntity::getDB()));}
		$row = mysqli_fetch_row($result);
		$EigenerVerein = (string)(new CVerein($row[0]));
		// Partnerverein
		if(!$this->mVereinID)
		{
			$returnstring = $EigenerVerein;
		}
		else
		{
			$PartnerVerein = (string)$this->getVereinID(GET_OFID);
			$returnstring = 'SG&nbsp;'.substr($EigenerVerein, 0, 12).'/'.substr($PartnerVerein, 0, 12);
		}
		$returnstring .= '&nbsp;';
		// Altersklassengruppe
		switch($this->mAKlaGruppe)
		{
			case S_SCHUELER: $returnstring .= 'S'; break;
			case S_JUGEND: $returnstring .= 'J'; break;
			default: break;
		}
		// Mannschaftsnummer
		return $returnstring .= $this->mNr;
	}

	/*@}*/

	/*****************************************************************************************************************//**
	 * @name Setter
	 **************************************************************************************************************//*@{*/

	public function setInitVals()
	{
		parent::setInitVals();
		$this->mSaisonID = 0;
		$this->mAKlaGruppe = 0;
		$this->mNr = 0;
		$this->mPlatzierung1 = null;
		$this->mPlatzierung2 = null;
		$this->mLigaKlasseID = 0;
		$this->mVereinID = null;
		$this->mBildunterschrift = null;
		$this->mErgDienst = null;
	}

	final public function setMannschaftID($MannschaftID) {
		CDriveEntity::setID($MannschaftID);
	}

	final public function setSaisonID($SaisonID) {
		$this->mSaisonID = (int)$SaisonID;
	}

	final public function setAKlaGruppe($AKlaGruppe) {
		$this->mAKlaGruppe = (int)$AKlaGruppe;
	}

	final public function setNr($Nr) {
		$this->mNr = (int)$Nr;
	}

	final public function setPlatzierung1($Platzierung1) {
		$this->mPlatzierung1 = (($i = (int)$Platzierung1)?($i):(null));
	}

	final public function setPlatzierung2($Platzierung2) {
		$this->mPlatzierung2 = (($i = (int)$Platzierung2)?($i):(null));
	}

	final public function setLigaKlasseID($LigaKlasseID) {
		$this->mLigaKlasseID = (int)$LigaKlasseID;
	}

	final public function setVereinID($VereinID) {
		$this->mVereinID = (($i = (int)$VereinID)?($i):(null));
	}

	final public function setBildunterschrift($Bildunterschrift) {
		$this->mBildunterschrift = (($s = trim((string)$Bildunterschrift))?($s):(null));
	}

	final public function setErgDienst($ErgDienst) {
		$this->mErgDienst = (($s = htmlspecialchars(trim((string)$ErgDienst)))?($s):(null));
	}

	/*@}*/

	/*****************************************************************************************************************//**
	 * @name Getter
	 **************************************************************************************************************//*@{*/

	final public function getMannschaftID()
	{
		return CDriveEntity::getID();
	}

	final public function getSaisonID($FlagVariant = array())
	{
		$FlagArray = (array)$FlagVariant;
		return ((in_array(GET_OFID, $FlagArray))?(new CSaison($this->mSaisonID)):($this->mSaisonID));
	}

	final public function getAKlaGruppe($FlagVariant = array())
	{
		$FlagArray = (array)$FlagVariant;
		return ((in_array(GET_C2SC, $FlagArray))?(C2S_AKlaGruppe($this->mAKlaGruppe)):($this->mAKlaGruppe));
	}

	final public function getNr()
	{
		return $this->mNr;
	}

	final public function getPlatzierung1($FlagVariant = array())
	{
		$FlagArray = (array)$FlagVariant;
		return ((is_null($v = $this->mPlatzierung1) and in_array(GET_NBSP, $FlagArray))?('&nbsp;'):($v));
	}

	final public function getPlatzierung2($FlagVariant = array())
	{
		$FlagArray = (array)$FlagVariant;
		return ((is_null($v = $this->mPlatzierung2) and in_array(GET_NBSP, $FlagArray))?('&nbsp;'):($v));
	}

	final public function getLigaKlasseID($FlagVariant = array())
	{
		$FlagArray = (array)$FlagVariant;
		return ((in_array(GET_OFID, $FlagArray))?(new CLigaKlasse($this->mLigaKlasseID)):($this->mLigaKlasseID));
	}

	final public function getVereinID($FlagVariant = array())
	{
		$FlagArray = (array)$FlagVariant;
		if(is_null($ID = $this->mVereinID) and in_array(GET_NBSP, $FlagArray)) {return '&nbsp;';}
		return ((!is_null($ID) and in_array(GET_OFID, $FlagArray))?(new CVerein($ID)):($ID));
	}

	final public function getBildunterschrift($FlagVariant = array())
	{
		$FlagArray = (array)$FlagVariant;
		if(is_null($v = $this->mBildunterschrift) and in_array(GET_NBSP, $FlagArray)) {return '&nbsp;';}
		$Bildunterschrift = ((in_array(GET_SPEC, $FlagArray))?(FormatXHTMLPermittedString($this->mBildunterschrift)):($this->mBildunterschrift));
		$Bildunterschrift = ((in_array(GET_CLIP, $FlagArray) and (strlen($Bildunterschrift) > 20))?(substr($Bildunterschrift, 0, 20).'...'):($Bildunterschrift));
		$Bildunterschrift = ((in_array(GET_HSPC, $FlagArray))?(htmlspecialchars($Bildunterschrift)):($Bildunterschrift));
		return $Bildunterschrift;
	}

	final public function getErgDienst($FlagVariant = array())
	{
		$FlagArray = (array)$FlagVariant;
		return ((is_null($v = $this->mErgDienst) and in_array(GET_NBSP, $FlagArray))?('&nbsp;'):($v));
	}

	/*@}*/

	/*****************************************************************************************************************//**
	 * @name Datenbank
	 **************************************************************************************************************//*@{*/

	public static function isValidID($MannschaftID) {
		return CDriveEntity::genericIsValidID(self::mcTabName, $MannschaftID);
	}

	public function load($MannschaftID)
	{
		self::setInitVals();
		$this->setMannschaftID($MannschaftID);
		$format = 'SELECT saison_id, aklagruppe, nr, platzierung_1, platzierung_2, ligaklasse_id, verein_id, '.
		          'bildunterschrift, ergdienst '.
		          'FROM mannschaften WHERE mannschaft_id=%s';
		$query = sprintf($format, $this->getMannschaftID());
		if(!$result = mysqli_query(CDriveEntity::getDB(), $query)) {throw new Exception(mysqli_error(CDriveEntity::getDB()));}
		$row = mysqli_fetch_row($result);
		if(!$row) {throw new Exception('Mannschaft mit mannschaft_id='.$MannschaftID.' nicht gefunden!');}
		$this->mSaisonID = lD($row[0]);
		$this->mAKlaGruppe = lD($row[1]);
		$this->mNr = lD($row[2]);
		$this->mPlatzierung1 = lD($row[3]);
		$this->mPlatzierung2 = lD($row[4]);
		$this->mLigaKlasseID = lD($row[5]);
		$this->mVereinID = lD($row[6]);
		$this->mBildunterschrift = lS($row[7]);
		$this->mErgDienst = lS($row[8]);
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
			$format = 'UPDATE mannschaften SET '.
			          'saison_id=%s, aklagruppe=%s, nr=%s, platzierung_1=%s, platzierung_2=%s, ligaklasse_id=%s, '.
			          'verein_id=%s, bildunterschrift=%s, ergdienst=%s '.
			          'WHERE mannschaft_id=%s';
			$query = sprintf($format, sD($this->mSaisonID), sD($this->mAKlaGruppe), sD($this->mNr), sD($this->mPlatzierung1),
			sD($this->mPlatzierung2), sD($this->mLigaKlasseID), sD($this->mVereinID), sS($this->mBildunterschrift),
			sS($this->mErgDienst), $this->getID());
		}
		else
		{
			$format = 'INSERT INTO mannschaften ('.
			          'saison_id, aklagruppe, nr, platzierung_1, platzierung_2, ligaklasse_id, verein_id, bildunterschrift, '.
			          'ergdienst'.
			          ') VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s)';
			$query = sprintf($format, sD($this->mSaisonID), sD($this->mAKlaGruppe), sD($this->mNr), sD($this->mPlatzierung1),
			sD($this->mPlatzierung2), sD($this->mLigaKlasseID), sD($this->mVereinID), sS($this->mBildunterschrift),
			sS($this->mErgDienst));
		}
		if(!$result = mysqli_query(CDriveEntity::getDB(), $query)) {throw new Exception(mysqli_error(CDriveEntity::getDB()));}

		// Basisklasse
		parent::store();
	}

	public function check()
	{
		// SaisonID
		if(!CSaison::isValidID($this->mSaisonID)) {
			CDriveEntity::addCheckMsg('Die saison_id ist ungültig.');
		}

		// AKlaGruppe
		if(is_null(C2S_AKlaGruppe($this->mAKlaGruppe))) {
			CDriveEntity::addCheckMsg('Die Altersklassengruppe ist ungültig.');
		}

		// Nr
		if(!($this->mNr >= 1 and $this->mNr <= MAX_MANNSCHAFTEN)) {
			CDriveEntity::addCheckMsg('Die Mannschaftsnummer muss zwischen 1 und '.MAX_MANNSCHAFTEN.' liegen.');
		}

		// Platzierung1
		if(!is_null($this->mPlatzierung1))
		{
			if(!($this->mPlatzierung1 >= 1 and $this->mPlatzierung1 <= MAX_PLATZ_MANN)) {
				CDriveEntity::addCheckMsg('Die Vorrunden-Platzierung muss zwischen 1 und '.MAX_PLATZ_MANN.' liegen.');
			}
		}

		// Platzierung2
		if(!is_null($this->mPlatzierung2))
		{
			if(!($this->mPlatzierung2 >= 1 and $this->mPlatzierung2 <= MAX_PLATZ_MANN)) {
				CDriveEntity::addCheckMsg('Die Rückrunden-Platzierung muss zwischen 1 und '.MAX_PLATZ_MANN.' liegen.');
			}
		}

		// LigaKlasseID
		if(!CLigaKlasse::isValidID($this->mLigaKlasseID)) {
			CDriveEntity::addCheckMsg('Die ligaklasse_id ist ungültig.');
		}

		// VereinID
		if(!is_null($this->mVereinID))
		{
			if(!CVerein::isValidID($this->mVereinID)) {
				CDriveEntity::addCheckMsg('Die verein_id ist ungültig.');
			}
		}

		// Bildunterschrift
		if(!is_null($this->mBildunterschrift))
		{
			if(!(strlen($this->mBildunterschrift) >= 1 and strlen($this->mBildunterschrift) <= 65535)) {
				CDriveEntity::addCheckMsg('Die Bildunterschrift muss mind. 1 bis max. 65535 Zeichen lang sein.');
			}
			else if(substr_count($this->mBildunterschrift, '{') != substr_count($this->mBildunterschrift, '}')) {
				CDriveEntity::addCheckMsg('Die Anzahl an sich öffnenden und sich schließenden geschw. Klammern ist ungleich.');
			}
		}

		// ErgDienst
		if(!is_null($this->mErgDienst))
		{
			if(strlen($this->mErgDienst) > 255) {
				CDriveEntity::addCheckMsg('Der Link auf den Ergebnisdienst darf nicht länger als 255 Zeichen sein.');
			}
		}

		// LigaKlasse und AKlaGruppe
		if(CLigaKlasse::isValidID($this->mLigaKlasseID) and !is_null(C2S_AKlaGruppe($this->mAKlaGruppe)))
		{
			if($this->getLigaKlasseID(GET_OFID)->getAKlaGruppe() != $this->mAKlaGruppe) {
				CDriveEntity::addCheckMsg('Die Altersklasse der Mannschaft entspricht nicht der Altersklasse der Liga/Klasse.');
			}
		}

		// Doppelt angelegte Mannschaften
		if(CSaison::isValidID($this->mSaisonID) and
		!is_null(C2S_AKlaGruppe($this->mAKlaGruppe)) and
		($this->mNr >= 1 and $this->mNr <= MAX_MANNSCHAFTEN))
		{
			$query = 'SELECT mannschaft_id FROM mannschaften '.
			         'WHERE saison_id='.$this->mSaisonID.
			         ' AND aklagruppe='.$this->mAKlaGruppe.
			         ' AND nr='.$this->mNr.
			         ' AND verein_id'.((is_null($this->mVereinID))?(' IS NULL'):('='.$this->mVereinID)).
			         ' AND mannschaft_id<>'.$this->getMannschaftID();
			if(!$result = mysqli_query(CDriveEntity::getDB(), $query)) {
				throw new Exception(mysqli_error(CDriveEntity::getDB()));
			}
			if($row = mysqli_fetch_row($result)) {
				$Meldung = 'Eine ';
				$Meldung .= C2S_AKlaGruppe($this->mAKlaGruppe);
				if(S_AKTIVE == $this->mAKlaGruppe) {$Meldung .= 'n';};
				$Meldung .= 'mannschaft';
				if(!is_null($this->mVereinID)) {$Meldung .= ' mit dieser Partnermannschaft und';}
				$Meldung .= ' dieser Nummer wurde für diese Saison bereits angelegt.';
				CDriveEntity::addCheckMsg($Meldung);
			}
		}

		// Bild
		CDriveEntityWithAttachment::check();
	}

	/*@}*/

	/*****************************************************************************************************************//**
	 * @name Verschiedenes
	 **************************************************************************************************************//*@{*/

	public function isDeletable()
	{
		/*
		 * In welchen Tabellen wird eine mannschaft_id eingetragen und wie kritisch ist diese Tabelle?
		 *
		 * aufstellungen...............unkritisch (keine weiteren Abhängigkeiten)
		 * sperml_punktspiel_extern....kritisch (SpErMl wird gelöscht!)
		 * sperml_punktspiel_intern....kritisch (SpErMl wird gelöscht!)
		 * termine_pktspbeg............unkritisch (keine weiteren Abhängigkeiten)
		 *
		 */

		$Zaehler = 0;

		$query = 'SELECT COUNT(*) FROM sperml_punktspiel_extern WHERE mannschaft_id='.$this->getMannschaftID();
		if(!$result = mysqli_query(CDriveEntity::getDB(), $query)) {
			throw new Exception(mysqli_error(CDriveEntity::getDB()));
		}
		$row = mysqli_fetch_row($result);
		$Zaehler += (int)$row[0];

		foreach($GLOBALS['Enum']['Seite'] as $Seite)
		{
			$query = 'SELECT COUNT(*) FROM sperml_punktspiel_intern '.
			         'WHERE '.strtolower(C2S_Seite($Seite)).'_mannschaft_id='.$this->getMannschaftID();
			if(!$result = mysqli_query(CDriveEntity::getDB(), $query)) {
				throw new Exception(mysqli_error(CDriveEntity::getDB()));
			}
			$row = mysqli_fetch_row($result);
			$Zaehler += (int)$row[0];
		}

		return (($Zaehler)?(false):(true));
	}

	public function getLinkErgDienst($NameOfLink = 'Ergebnisdienst', $NewWindow = true)
	{
		if(is_null($ErgDienst = $this->getErgDienst())) {return null;}
		return '<a href="'.$ErgDienst.'"'.(($NewWindow)?(' '.STD_NEW_WINDOW):('')).'>'.$NameOfLink.'</a>';
	}

	public function getTerminPSBArray($RecentOnly = true)
	{
		$TerminPSBArray = array();
		$query = 'SELECT tp.termin_id '.
		         'FROM ((termine_pktspbeg tp INNER JOIN termine t ON tp.termin_id=t.termin_id) '.
		         'INNER JOIN mannschaften m ON tp.mannschaft_id=m.mannschaft_ID) '.
		         'INNER JOIN _parameter p ON m.saison_id=p.saison_id '.
		         'WHERE tp.mannschaft_id='.$this->getMannschaftID().(($RecentOnly)?(' AND t.datum >= CURDATE()'):(' ')).
		         'ORDER BY t.datum, tp.uhrzeit';
		if(!$result = mysqli_query(CDriveEntity::getDB(), $query)) {throw new Exception(mysqli_error(CDriveEntity::getDB()));}
		while($row = mysqli_fetch_row($result)) {$TerminPSBArray[] = new CTerminPSB($row[0]);}
		return $TerminPSBArray;
	}

	public function getTerminPSBArrayArray($RecentOnly = true)
	{
		$TerminPSBArray = $this->getTerminPSBArray($RecentOnly);

		$i = 0;
		$j = 0;
		$TerminPSB = reset($TerminPSBArray);
		$TerminPSBArrayArray[$i][$j] = $TerminPSB;

		while($TerminPSB = next($TerminPSBArray))
		{
			$PreviousTerminPSB = $TerminPSBArrayArray[$i][$j];
			if(($PreviousTerminPSB->getDatum() == $TerminPSB->getDatum()) and
			($PreviousTerminPSB->getAustragungsortID() == $TerminPSB->getAustragungsortID())) {
				$TerminPSBArrayArray[$i][++$j] = $TerminPSB;
			}
			else {
				$j = 0;
				$TerminPSBArrayArray[++$i][$j] = $TerminPSB;
			}
		}

		return $TerminPSBArrayArray;
	}

	public function getTabelleID()
	{
		$query = 'SELECT tabelle_id FROM tabellen '.
		         'WHERE saison_id='.$this->getSaisonID().' and ligaklasse_id='.$this->getLigaKlasseID();
		if(!$result = mysqli_query(CDBConnection::getDB(), $query)) {throw new Exception(mysqlil_error(CDBConnection::getDB()));}
		return (($row = mysqli_fetch_row($result))?((int)$row[0]):(null));
	}

	public function getSpermlXArray()
	{
		$query = 'SELECT sperml_id, spermltyp FROM _v1_punktspiele '.
		         'WHERE mannschaft_id='.$this->getMannschaftID().' ORDER BY datum, begegnungnr';

		$SpermlXArray = array();

		if(!$result = mysqli_query(CDBConnection::getDB(), $query)) {throw new Exception(mysqlil_error(CDBConnection::getDB()));}

		while($row = mysqli_fetch_row($result)) {
			switch($row[1])
			{
				case S_PKTSPEXT: $SpermlXArray[] = new CSpErMlPunktspielExtern($row[0]); break;
				case S_PKTSPINT: $SpermlXArray[] = new CSpErMlPunktspielIntern($row[0]); break;
				default: break;
			}
		}
		return $SpermlXArray;
	}

	public function getSpermlXBegegnungNrArray()
	{
		$query = 'SELECT begegnungnr FROM _v1_punktspiele '.
		         'WHERE mannschaft_id='.$this->getMannschaftID().' ORDER BY datum, begegnungnr';
		$SpermlXBegegnungNrArray = array();
		if(!$result = mysqli_query(CDBConnection::getDB(), $query)) {throw new Exception(mysqlil_error(CDBConnection::getDB()));}
		while($row = mysqli_fetch_row($result)) {$SpermlXBegegnungNrArray[] = (int)$row[0];}
		return $SpermlXBegegnungNrArray;
	}

	public function getSpermlXSeiteArray()
	{
		$query = 'SELECT seite FROM _v1_punktspiele '.
		         'WHERE mannschaft_id='.$this->getMannschaftID().' ORDER BY datum, begegnungnr';
		$SpermlXSeiteArray = array();
		if(!$result = mysqli_query(CDBConnection::getDB(), $query)) {throw new Exception(mysqlil_error(CDBConnection::getDB()));}
		while($row = mysqli_fetch_row($result)) {$SpermlXSeiteArray[] = (int)$row[0];}
		return $SpermlXSeiteArray;
	}

	/*@}*/
}
?>