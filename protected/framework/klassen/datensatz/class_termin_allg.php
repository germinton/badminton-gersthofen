<?php
include_once(dirname(__FILE__).'/class_termin.php');

/*******************************************************************************************************************//**
 * Repräsentation eines allgemeinen Termins.
 * @ingroup grp_recordset
 **********************************************************************************************************************/
class CTerminAllg extends CTermin
{
	/*****************************************************************************************************************//**
	 * @name Tabellenspalten
	 **************************************************************************************************************//*@{*/

	private $mTitel;
	private $mOrt;
	private $mAthletID;
	private $mEndedatum;
	private $mFuerA;
	private $mFuerJ;
	private $mFuerS;

	/*@}*/

	/*****************************************************************************************************************//**
	 * @name Magics
	 **************************************************************************************************************//*@{*/

	public function __construct($TerminID = 0) {
		parent::__construct($TerminID);
	}

	public function __toString()
	{
		if(!$this->getTerminID()) {return 'Kein allgemeiner Termin';}
		return $this->getDatum(GET_DTDE).': '.$this->getTitel();
	}

	/*@}*/

	/*****************************************************************************************************************//**
	 * @name Setter
	 **************************************************************************************************************//*@{*/

	public function setInitVals()
	{
		parent::setInitVals();
		$this->mTitel = '';
		$this->mOrt = null;
		$this->mAthletID = 0;
		$this->mEndedatum = null;
		$this->mFuerA = 0;
		$this->mFuerJ = 0;
		$this->mFuerS = 0;
	}

	final public function setTitel($Titel) {
		$this->mTitel = htmlspecialchars(trim((string)$Titel));
	}

	final public function setOrt($Ort) {
		$this->mOrt = (($s = htmlspecialchars(trim((string)$Ort)))?($s):(null));
	}

	final public function setAthletID($AthletID) {
		$this->mAthletID = (int)$AthletID;
	}

	final public function setEndedatum($Endedatum) {
		$this->mEndedatum = (($s = trim((string)$Endedatum))?($s):(null));
	}

	final public function setFuerA($FuerA) {
		$this->mFuerA = (($FuerA)?(1):(0));
	}

	final public function setFuerJ($FuerJ) {
		$this->mFuerJ = (($FuerJ)?(1):(0));
	}

	final public function setFuerS($FuerS) {
		$this->mFuerS = (($FuerS)?(1):(0));
	}

	/*@}*/

	/*****************************************************************************************************************//**
	 * @name Getter
	 **************************************************************************************************************//*@{*/

	final public function getTitel($FlagVariant = array())
	{
		$FlagArray = (array)$FlagVariant;
		if(in_array(GET_CLIP, $FlagArray) and (strlen($this->mTitel) > 25)) {return substr($this->mTitel, 0, 25).'...';}
		return $this->mTitel;
	}

	final public function getOrt($FlagVariant = array())
	{
		$FlagArray = (array)$FlagVariant;
		if(in_array(GET_CLIP, $FlagArray) and (strlen($this->mOrt) > 15)) {return substr($this->mOrt, 0, 15).'...';}
		return $this->mOrt;
	}

	final public function getAthletID($FlagVariant = array())
	{
		$FlagArray = (array)$FlagVariant;
		if(in_array(GET_SPEC, $FlagArray)) {return new CMitglied($this->mAthletID);}
		return ((in_array(GET_OFID, $FlagArray))?(new CAthlet($this->mAthletID)):($this->mAthletID));
	}

	final public function getEndedatum($FlagVariant = array())
	{
		$FlagArray = (array)$FlagVariant;
		$Datum = ((in_array(GET_DTDE, $FlagArray))?(S2S_Datum_MySql2Deu($this->mEndedatum)):($this->mEndedatum));
		return ((is_null($v = $Datum) and in_array(GET_NBSP, $FlagArray))?('&nbsp;'):($v));
	}

	final public function getFuerA($FlagVariant = array())
	{
		$FlagArray = (array)$FlagVariant;
		return ((in_array(GET_SPEC, $FlagArray))?(($this->mFuerA)?('ja'):('nein')):(($this->mFuerA)?(1):(0)));
	}

	final public function getFuerJ($FlagVariant = array())
	{
		$FlagArray = (array)$FlagVariant;
		return ((in_array(GET_SPEC, $FlagArray))?(($this->mFuerJ)?('ja'):('nein')):(($this->mFuerJ)?(1):(0)));
	}

	final public function getFuerS($FlagVariant = array())
	{
		$FlagArray = (array)$FlagVariant;
		return ((in_array(GET_SPEC, $FlagArray))?(($this->mFuerS)?('ja'):('nein')):(($this->mFuerS)?(1):(0)));
	}

	/*@}*/

	/*****************************************************************************************************************//**
	 * @name Datenbank
	 **************************************************************************************************************//*@{*/

	public static function isValidID($TerminID) {
		return CDriveEntity::genericIsValidID('termine_allgemein', $TerminID);
	}

	public function load($TerminID)
	{
		self::setInitVals();
		CTermin::load($TerminID);
		$format = 'SELECT titel, ort, athlet_id, endedatum, fuer_a, fuer_j, fuer_s '.
		          'FROM termine_allgemein WHERE termin_id=%s';
		$query = sprintf($format, $this->getTerminID());
		if(!$result = mysqli_query(CDriveEntity::getDB(), $query)) {throw new Exception(mysqli_error(CDriveEntity::getDB()));}
		$row = mysqli_fetch_row($result);
		if(!$row) {throw new Exception('TerminAllg mit termin_id='.$TerminID.' nicht gefunden!');}
		$this->mTitel = lS($row[0]);
		$this->mOrt = lS($row[1]);
		$this->mAthletID = lD($row[2]);
		$this->mEndedatum = lS($row[3]);
		$this->mFuerA = lD($row[4]);
		$this->mFuerJ = lD($row[5]);
		$this->mFuerS = lD($row[6]);
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
			$format = 'UPDATE termine_allgemein SET '.
			          'titel=%s, ort=%s, athlet_id=%s, endedatum=%s, fuer_a=%s, fuer_j=%s, fuer_s=%s '.
			          'WHERE termin_id=%s';
			$query = sprintf($format, sS($this->mTitel), sS($this->mOrt), sD($this->mAthletID), sS($this->mEndedatum),
			sB($this->mFuerA), sB($this->mFuerJ), sB($this->mFuerS), $this->getID());
		}
		else
		{
			$format = 'INSERT INTO termine_allgemein ('.
			          'termin_id, titel, ort, athlet_id, endedatum, fuer_a, fuer_j, fuer_s'.
			          ') VALUES (%s, %s, %s, %s, %s, %s, %s, %s)';
			$query = sprintf($format, $this->getID(), sS($this->mTitel), sS($this->mOrt), sD($this->mAthletID),
			sS($this->mEndedatum), sB($this->mFuerA), sB($this->mFuerJ), sB($this->mFuerS));
		}
		if(!$result = mysqli_query(CDriveEntity::getDB(), $query)) {throw new Exception(mysqli_error(CDriveEntity::getDB()));}
	}

	public function check()
	{
		// Basisklasse
		parent::check();

		// Titel
		if(!(strlen($this->mTitel) >= 1 and strlen($this->mTitel) <= 100)) {
			CDriveEntity::addCheckMsg('Der Titel muss mind. 1 bis max. 100 Zeichen lang sein.');
		}

		// Ort
		if(!is_null($this->mOrt))
		{
			if(strlen($this->mOrt) > 50) {
				CDriveEntity::addCheckMsg('Die Ortsangabe darf nicht länger als 50 Zeichen sein.');
			}
		}

		// AthletID
		if(!CAthlet::isValidID($this->mAthletID)) {
			CDriveEntity::addCheckMsg('Die athlet_id ist ungültig.');
		}

		// Endedatum
		if(!is_null($this->mEndedatum))
		{
			if(!(preg_match(REGEX_DATE_SQ, $this->mEndedatum)
			and preg_match(REGEX_DATE_DE, $this->getEndedatum(GET_DTDE)))) {
				CDriveEntity::addCheckMsg('Das Terminende-Datum muss von der Form \'TT.MM.JJJJ\' sein.');
			}
			else if(!checkdate(
			substr($this->mEndedatum, 5, 2), substr($this->mEndedatum, 8, 2), substr($this->mEndedatum, 0, 4))) {
				CDriveEntity::addCheckMsg('Das Terminende-Datum is ungültig.');
			}
			else if($this->mEndedatum < $this->getDatum()) {
				CDriveEntity::addCheckMsg('Das Terminende-Datum liegt zeitlich vor dem Terminanfang-Datum.');
			}
		}
	}

	/*@}*/

	/*****************************************************************************************************************//**
	 * @name Verschiedenes
	 **************************************************************************************************************//*@{*/

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

	public function getXHTML()
	{
		$xhtml = '<div class="allg_termin" id="termin_id:'.$this->getTerminID().'">'."\n";
		$xhtml .= '<div class="kopf">'."\n";
		$xhtml .= '<h3>Zielgruppe: '.$this->getZielgruppe().'</h3>'."\n";
		$xhtml .= '<h2>'.$this->getDatumVonBis().': '.$this->getTitel().'</h2>'."\n";
		$xhtml .= '</div>'."\n";
		$xhtml .= '<div class="koerper'.(($img = $this->getXHTMLforIMG())?(' floatpic'):('')).'" >'."\n";
		$xhtml .= (($img)?($img."\n"):(''));
		$xhtml .= (($ort = $this->getOrt(GET_SPEC))?('Ort: '.$ort.'<br />'."\n"):(''));
		$Mitglied = $this->getAthletID(GET_SPEC);
		$xhtml .= 'Ansprechpartner: '.$Mitglied->getMailToEMail((string)$Mitglied)."\n";
		$xhtml .= (($txt = $this->getFreitext(GET_SPEC))?('<br /><br />'."\n".$txt."\n"):(''));

		if($this->hasAttachment(array(ATTACH_FILE1, ATTACH_FILE2, ATTACH_FILE3)))
		{
			$xhtml .= '<br /><br />'."\n";
			$countAttachments = $this->countAttachments(array(ATTACH_FILE1, ATTACH_FILE2, ATTACH_FILE3));
			$xhtml .= (($countAttachments > 1)?('Anhänge'):('Anhang')).':<br />'."\n";
			if($this->hasAttachment(ATTACH_FILE1)) {
				$xhtml .= $this->getAttachmentLink(ATTACH_FILE1);
			}
			if($this->hasAttachment(ATTACH_FILE2)) {
				if($this->hasAttachment(ATTACH_FILE1)) {$xhtml .= ', '."\n";}
				$xhtml .= $this->getAttachmentLink(ATTACH_FILE2);
			}
			if($this->hasAttachment(ATTACH_FILE3)) {
				if($this->hasAttachment(array(ATTACH_FILE1, ATTACH_FILE2))) {$xhtml .= ', ';}
				$xhtml .= $this->getAttachmentLink(ATTACH_FILE3);
			}
			$xhtml .= "\n";
		}
		$xhtml .= '</div>'."\n";
		$xhtml .= '</div>'."\n";
		return $xhtml;
	}

	public static function getRecentTerminAllgArrayArray()
	{
		$Monat = date('n');
		$Jahr = date('Y');
		for($i=0; $i<40; $i++)
		{
			$TerminAllgArrayArray[$MonatString = C2S_Monat($Monat).' '.$Jahr] = array();
			$query = 'SELECT ta.termin_id FROM termine_allgemein ta INNER JOIN termine t ON ta.termin_id=t.termin_id '.
			         'WHERE IFNULL(endedatum, datum) >= CURDATE() AND MONTH(IFNULL(endedatum, datum))='.$Monat.' '.
			         'AND YEAR(IFNULL(endedatum, datum)) ='.$Jahr.' ORDER BY datum';
			if(!$result = mysqli_query(CDriveEntity::getDB(), $query)) {throw new Exception(mysqli_error(CDriveEntity::getDB()));}
			while($row = mysqli_fetch_row($result)) {$TerminAllgArrayArray[$MonatString][] = new CTerminAllg($row[0]);}
			if(++$Monat > 13) {$Monat = 1; $Jahr++;}
		}
		return $TerminAllgArrayArray;
	}

	public static function getNumberOfTermine($Month)
	{
		$query = 'SELECT count(*) FROM termine_allgemein ta INNER JOIN termine t ON ta.termin_id=t.termin_id '.
		         'WHERE IFNULL(endedatum, datum) BETWEEN CURDATE() '.
		         'AND DATE_ADD(CURDATE(), INTERVAL '.$Month.' MONTH)';
		if(!$result = mysqli_query(CDriveEntity::getDB(), $query)) {throw new Exception(mysqli_error(CDriveEntity::getDB()));}
		$row = mysqli_fetch_row($result);
		return (int)$row[0];
	}

	/*@}*/
}
?>