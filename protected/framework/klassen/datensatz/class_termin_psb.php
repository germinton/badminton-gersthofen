<?php
include_once(dirname(__FILE__).'/class_termin.php');

/*******************************************************************************************************************//**
 * Repräsentation eines Termins für eine Punktspielbegegnung.
 * @ingroup grp_recordset
 **********************************************************************************************************************/
class CTerminPSB extends CTermin
{
	/*****************************************************************************************************************//**
	 * @name Tabellenspalten
	 **************************************************************************************************************//*@{*/

	private $mMannschaftID;
	private $mAustragungsortID;
	private $mUhrzeit;
	private $mSeite;
	private $mVereinID;
	private $mMannschaftNr;

	/*@}*/

	/*****************************************************************************************************************//**
	 * @name Magics
	 **************************************************************************************************************//*@{*/

	public function __construct($TerminID = 0) {
		parent::__construct($TerminID);
	}

	public function __toString()
	{
		if(!$this->getTerminID()) {return 'Kein Punktspieltermin';}
		return $this->getDatum(GET_DTDE).' '.$this->getUhrzeit();
	}

	/*@}*/

	/*****************************************************************************************************************//**
	 * @name Setter
	 **************************************************************************************************************//*@{*/

	public function setInitVals()
	{
		parent::setInitVals();
		$this->mMannschaftID = 0;
		$this->mAustragungsortID = 0;
		$this->mUhrzeit = '';
		$this->mSeite = 0;
		$this->mVereinID = 0;
		$this->mMannschaftNr = 0;
	}

	final public function setMannschaftID($MannschaftID) {
		$this->mMannschaftID = (int)$MannschaftID;
	}

	final public function setAustragungsortID($AustragungsortID) {
		$this->mAustragungsortID = (int)$AustragungsortID;
	}

	final public function setUhrzeit($Uhrzeit) {
		$this->mUhrzeit = trim($Uhrzeit);
	}

	final public function setSeite($Seite) {
		$this->mSeite = (int)$Seite;
	}

	final public function setVereinID($VereinID) {
		$this->mVereinID = (int)$VereinID;
	}

	final public function setMannschaftNr($MannschaftNr) {
		$this->mMannschaftNr = (int)$MannschaftNr;
	}

	/*@}*/

	/*****************************************************************************************************************//**
	 * @name Getter
	 **************************************************************************************************************//*@{*/

	final public function getMannschaftID($FlagVariant = array())
	{
		$FlagArray = (array)$FlagVariant;
		return ((in_array(GET_OFID, $FlagArray))?(new CMannschaft($this->mMannschaftID)):($this->mMannschaftID));
	}

	final public function getAustragungsortID($FlagVariant = array())
	{
		$FlagArray = (array)$FlagVariant;
		return ((in_array(GET_OFID, $FlagArray))?(new CAustragungsort($this->mAustragungsortID)):($this->mAustragungsortID));
	}

	final public function getUhrzeit($FlagVariant = array())
	{
		$FlagArray = (array)$FlagVariant;
		return ((in_array(GET_SPEC, $FlagArray) and (strlen($this->mUhrzeit) == 8))?
		(substr($this->mUhrzeit, 0, 2).':'.substr($this->mUhrzeit, 3, 2)):substr($this->mUhrzeit, 0, 5));
	}

	final public function getSeite($FlagVariant = array())
	{
		$FlagArray = (array)$FlagVariant;
		return ((in_array(GET_C2SC, $FlagArray))?(C2S_Seite($this->mSeite)):($this->mSeite));
	}

	final public function getVereinID($FlagVariant = array())
	{
		$FlagArray = (array)$FlagVariant;
		return ((in_array(GET_OFID, $FlagArray))?(new CVerein($this->mVereinID)):($this->mVereinID));
	}

	final public function getMannschaftNr()
	{
		return $this->mMannschaftNr;
	}

	/*@}*/

	/*****************************************************************************************************************//**
	 * @name Datenbank
	 **************************************************************************************************************//*@{*/

	public static function isValidID($TerminID) {
		return CDriveEntity::genericIsValidID('termine_pktspbeg', $TerminID);
	}

	public function load($TerminID)
	{
		self::setInitVals();
		CTermin::load($TerminID);
		$format = 'SELECT mannschaft_id, austragungsort_id, uhrzeit, seite, verein_id, mannschaftnr '.
		          'FROM termine_pktspbeg WHERE termin_id=%s';
		$query = sprintf($format, $this->getTerminID());
		if(!$result = mysql_query($query)) {throw new Exception(mysql_error(CDriveEntity::getDB()));}
		$row = mysql_fetch_row($result);
		if(!$row) {throw new Exception('TerminPSB mit termin_id='.$TerminID.' nicht gefunden!');}
		$this->mMannschaftID = lD($row[0]);
		$this->mAustragungsortID = lD($row[1]);
		$this->mUhrzeit = lS($row[2]);
		$this->mSeite = lD($row[3]);
		$this->mVereinID = lD($row[4]);
		$this->mMannschaftNr = lD($row[5]);
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
			$format = 'UPDATE termine_pktspbeg SET '.
			          'mannschaft_id=%s, austragungsort_id=%s, uhrzeit=%s, seite=%s, verein_id=%s, mannschaftnr=%s '.
			          'WHERE termin_id=%s';
			$query = sprintf($format, sD($this->mMannschaftID), sD($this->mAustragungsortID), sS($this->mUhrzeit),
			sD($this->mSeite), sD($this->mVereinID), sD($this->mMannschaftNr), $this->getID());
		}
		else
		{
			$format = 'INSERT INTO termine_pktspbeg ('.
			          'termin_id, mannschaft_id, austragungsort_id, uhrzeit, seite, verein_id, mannschaftnr'.
			          ') VALUES (%s, %s, %s, %s, %s, %s, %s)';
			$query = sprintf($format, $this->getID(), sD($this->mMannschaftID), sD($this->mAustragungsortID),
			sS($this->mUhrzeit), sD($this->mSeite), sD($this->mVereinID), sD($this->mMannschaftNr));
		}
		if(!$result = mysql_query($query)) {throw new Exception(mysql_error(CDriveEntity::getDB()));}
	}

	public function check()
	{
		// Basisklasse
		parent::check();

		// MannschaftID
		if(!CMannschaft::isValidID($this->mMannschaftID)) {
			CDriveEntity::addCheckMsg('Die mannschaft_id ist ungültig.');
		}

		// AustragungsortID
		if(!CAustragungsort::isValidID($this->mAustragungsortID)) {
			CDriveEntity::addCheckMsg('Die austragungsort_id ist ungültig.');
		}

		// Uhrzeit
		if(!(preg_match(REGEX_TIME, $this->mUhrzeit))) {
			CDriveEntity::addCheckMsg('Die Uhrzeit muss von der Form \'HH:MM:SS\' sein.');
		}
		else
		{
			$H = substr($this->mUhrzeit, 0, 2);
			$M = substr($this->mUhrzeit, 3, 2);
			$S = substr($this->mUhrzeit, 6, 2);
			if(!($H >= 0 and $H <= 23) or !($M >= 0 and $M <= 59) or !($S >= 0 and $S <= 59)) {
				CDriveEntity::addCheckMsg('Die Uhrzeit enthält ungültige Werte.');
			}
		}

		// Seite
		if(is_null(C2S_Seite($this->mSeite))) {
			CDriveEntity::addCheckMsg('Die Seite ist ungültig.');
		}

		// VereinID
		if(!CVerein::isValidID($this->mVereinID)) {
			CDriveEntity::addCheckMsg('Die verein_id ist ungültig.');
		}

		// MannschaftNr
		if(!($this->mMannschaftNr >= 1 and $this->mMannschaftNr <= MAX_MANNSCHAFTEN)) {
			CDriveEntity::addCheckMsg('Die Mannschaftsnummer muss zwischen 1 und '.MAX_MANNSCHAFTEN.' liegen.');
		}
	}

	/*@}*/

	//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	// Miscellaneous
	//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	/*
	 public function getDatumVonBis()
	 {
		$Beginn = $this->getDatum(GET_DTDE);
		if(!($Ende = $this->getEndedatum(GET_DTDE))) {return $Beginn;}
		if(substr($Beginn, 6, 4) == substr($Ende, 6, 4))
		{
		if(substr($Beginn, 3, 2) == substr($Ende, 3, 2)) {return substr($Beginn, 0, 3).'-'.$Ende;}
		return substr($Beginn, 0, 6).'-'.$Ende;
		}
		return $Beginn.'-'.$Ende;
		}

		public function getZielgruppe()
		{
		if($this->getFuerA() or $this->getFuerJ() or $this->getFuerS())
		{
		if($this->getFuerA() and $this->getFuerJ() and $this->getFuerS()) {return 'Alle';}
		$a = (($this->getFuerA())?('Aktive'):(''));
		$j = (($this->getFuerJ())?('Jugend'):(''));
		$s = (($this->getFuerS())?('Schüler'):(''));
		$returnstring = $a;
		if($j) {$returnstring .= (($returnstring)?(', '):('')).$j;}
		if($s) {$returnstring .= (($returnstring)?(', '):('')).$s;}
		return $returnstring;
		}
		return 'Nicht spezifiziert';
		}
		*/

	public function equals($AnotherTerminPSB)
	{
		return ($this->getDatum() == $AnotherTerminPSB->getDatum() && $this->getMannschaftID() ==
		$AnotherTerminPSB->getMannschaftID() && $this->getAustragungsortID() == $AnotherTerminPSB->getAustragungsortID());
	}

	public function getXHTML($AdditionalTerminID = 0)
	{
		($ortID = $this->getAustragungsortID(GET_SPEC))?($ort = new CAustragungsort($ortID)):($ort = new CAustragungsort());
		$mannschaft = new CMannschaft($this->getMannschaftID());

		$xhtml = '<div class="psb_termin">'."\n";
		$xhtml .= '<div class="kopf">'."\n";
		$xhtml .= '<h3>Ort: '.$ort->getOrt().'</h3>'."\n";
		$xhtml .= '<h2>'.S2S_Datum_MySql2Deu($this->getDatum()).' '.$this->getUhrzeit().' </h2><h1>TSV Gersthofen '.$mannschaft->getNr().'</h1>'."\n";
		$xhtml .= '</div>'."\n";
		$xhtml .= '<div class="koerper">'."\n";
		/*$xhtml .= '<p'.(($img = $this->getXHTMLforIMG())?(' class="floatpic"'):('')).'>'."\n";
		 $xhtml .= (($img)?($img."\n"):(''));*/
		$gegner = new CVerein($this->getVereinID());
		$xhtml .= '<p>'."\n".'Gegner: <em>';
		$xhtml .= (($gegnerK = $gegner->getKuerzel(GET_NBSP))?(' '):(' '));
		$xhtml .= (($gegnerHP = $gegner->getHomepage())?('<a href="'.$gegnerHP.'">'.$gegnerK.' '.$gegner->getName().'</a> '):
		($gegnerK.' '.$gegner->getName())).' '.$this->getMannschaftNr().'</em><br />'."\n";
		if($AdditionalTerminID != NULL){
			$gegner = new CVerein($AdditionalTerminID->getVereinID());
			$xhtml .= '<p>'."\n".'Gegner: <em>';
			$xhtml .= (($gegnerK = $gegner->getKuerzel(GET_NBSP))?(' '):(' '));
			$xhtml .= (($gegnerHP = $gegner->getHomepage())?('<a href="'.$gegnerHP.'">'.$gegnerK.' '.$gegner->getName().'</a> '):
			($gegnerK.' '.$gegner->getName())).' '.$AdditionalTerminID->getMannschaftNr().'</em><br />'."\n";
			$xhtml .= (($txt = $AdditionalTerminID->getFreitext(GET_SPEC))?('<br />'."\n".$txt."\n"):(''));
		}

		//$Mitglied = $this->getAthletID(GET_SPEC);
		//$xhtml .= 'Ansprechpartner: '.$Mitglied->getMailToEMail((string)$Mitglied)."\n";
		$xhtml .= (($txt = $this->getFreitext(GET_SPEC))?('<br />'."\n".$txt."\n"):(''));
		$xhtml .= '</p>'."\n";
		$xhtml .= '</div>'."\n";
		$xhtml .= '</div>'."\n";
		return $xhtml;
	}

	public static function getRecentTerminPSBArrayArray($MannschaftID = 0)
	{
		$Monat = date('n');
		$Jahr = date('Y');
		for($i=0; $i<12; $i++)
		{
			$TerminPSBArrayArray[$MonatString = C2S_Monat($Monat).' '.$Jahr] = array();
			$query = (($MannschaftID!= 0)?('SELECT tp.termin_id FROM termine_pktspbeg tp INNER JOIN termine t ON tp.termin_id=t.termin_id '.
		'WHERE datum >= CURDATE() AND MONTH(datum)='.$Monat.' AND YEAR(datum) ='.$Jahr.' AND mannschaft_id ='.$MannschaftID.' ORDER BY datum, uhrzeit')
			:('SELECT tp.termin_id FROM termine_pktspbeg tp INNER JOIN termine t ON tp.termin_id=t.termin_id '.
		'WHERE datum >= CURDATE() AND MONTH(datum)='.$Monat.' AND YEAR(datum) ='.$Jahr.' ORDER BY datum, mannschaft_id, uhrzeit'));
			if(!$result = mysql_query($query, CDriveEntity::getDB())) {throw new Exception(mysql_error(CDriveEntity::getDB()));}
			while($row = mysql_fetch_row($result)) {$TerminPSBArrayArray[$MonatString][] = new CTerminPsB($row[0]);}
			if(++$Monat > 12) {$Monat = 1; $Jahr++;}
		}
		return $TerminPSBArrayArray;
	}

	public function getGegnerMannschaftString()
	{
		$Gegner = $this->getVereinID(GET_OFID);
		if($MNr = $this->mMannschaftNr) {
			$AKlaGruppe = $this->getMannschaftID(GET_OFID)->getAKlaGruppe();
			$Gegner .= '&nbsp;'.((S_AKTIVE != $AKlaGruppe)?(substr(C2S_AKlaGruppe($AKlaGruppe), 0, 1)):('')).$MNr;
		}
		return $Gegner;
	}

	public function getHeimMannschaftString()
	{
		if(S_HEIM == $this->mSeite) {return (string)$this->getMannschaftID(GET_OFID);}
		else if(S_GAST == $this->mSeite) {return $this->getGegnerMannschaftString();}
	}

	public function getGastMannschaftString()
	{
		if(S_GAST == $this->mSeite) {return (string)$this->getMannschaftID(GET_OFID);}
		else if(S_HEIM == $this->mSeite) {return $this->getGegnerMannschaftString();}
	}

	public function getVersusString()
	{
		return $this->getHeimMannschaftString().' - '.$this->getGastMannschaftString();
	}

}
?>