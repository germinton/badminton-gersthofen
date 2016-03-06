<?php
include_once(dirname(__FILE__).'/../datenbank/class_drive_entity_with_attach.php');
include_once(dirname(__FILE__).'/class_athlet.php');
include_once(dirname(__FILE__).'/../website/class_site_manager.php');

/*******************************************************************************************************************//**
 * Repräsentation einer Neuigkeit.
 * @ingroup grp_recordset
 **********************************************************************************************************************/
class CNeuigkeit extends CDriveEntityWithAttachment
{
	/*****************************************************************************************************************//**
	 * @name Tabellenname
	 **************************************************************************************************************//*@{*/

	const mcTabName = 'neuigkeiten';

	/*@}*/

	/*****************************************************************************************************************//**
	 * @name Tabellenspalten
	 **************************************************************************************************************//*@{*/

	private $mAthletID;
	private $mTitel;
	private $mInhalt;
	private $mEingestellt;
	private $mGueltigBis;
	private $mWichtig;

	/*@}*/

	/*****************************************************************************************************************//**
	 * @name Magics
	 **************************************************************************************************************//*@{*/

	public function __construct($NeuigkeitID = 0) {
		parent::__construct(self::mcTabName, $NeuigkeitID);
	}

	public function __toString()
	{
		if(!$this->getNeuigkeitID()) {return 'Keine Neuigkeit';}
		return $this->mTitel;
	}

	/*@}*/

	/*****************************************************************************************************************//**
	 * @name Setter
	 **************************************************************************************************************//*@{*/

	public function setInitVals()
	{
		parent::setInitVals();
		$this->mAthletID = 0;
		$this->mTitel = '';
		$this->mInhalt = '';
		$this->mEingestellt = '';
		$this->mGueltigBis = null;
		$this->mWichtig = false;
	}

	final public function setNeuigkeitID($NeuigkeitID) {
		CDriveEntity::setID($NeuigkeitID);
	}

	final public function setAthletID($AthletID) {
		$this->mAthletID = (int)$AthletID;
	}
	final public function setTitel($Titel) {
		$this->mTitel = htmlspecialchars(trim((string)$Titel));
	}
	final public function setInhalt($Inhalt) {
		$this->mInhalt = trim((string)$Inhalt);
	}
	final public function setEingestellt($Eingestellt) {
		$this->mEingestellt = trim((string)$Eingestellt);
	}
	final public function setGueltigBis($GueltigBis) {
		$this->mGueltigBis = (($s = trim((string)$GueltigBis))?($s):(null));
	}
	final public function setWichtig($Wichtig) {
		$this->mWichtig = (($Wichtig)?(1):(0));
	}

	/*@}*/

	/*****************************************************************************************************************//**
	 * @name Getter
	 **************************************************************************************************************//*@{*/

	final public function getNeuigkeitID()
	{
		return CDriveEntity::getID();
	}

	final public function getAthletID($FlagVariant = array())
	{
		$FlagArray = (array)$FlagVariant;
		if(in_array(GET_SPEC, $FlagArray)) {return new CMitglied($this->mAthletID);}
		return ((in_array(GET_OFID, $FlagArray))?(new CAthlet($this->mAthletID)):($this->mAthletID));
	}

	final public function getTitel($FlagVariant = array())
	{
		$FlagArray = (array)$FlagVariant;
		if(in_array(GET_CLIP, $FlagArray) and (strlen($this->mTitel) > 10)) {return substr($this->mTitel, 0, 10).'...';}
		return $this->mTitel;
	}

	final public function getInhalt($FlagVariant = array())
	{
		$FlagArray = (array)$FlagVariant;
		$Inhalt = ((in_array(GET_SPEC, $FlagArray))?(FormatXHTMLPermittedString($this->mInhalt)):($this->mInhalt));
		$Inhalt = ((in_array(GET_CLIP, $FlagArray) and (strlen($Inhalt) > 20))?(substr($Inhalt, 0, 20).'...'):($Inhalt));
		$Inhalt = ((in_array(GET_HSPC, $FlagArray))?(htmlspecialchars($Inhalt)):($Inhalt));
		return $Inhalt;
	}

	final public function getEingestellt($FlagVariant = array())
	{
		$FlagArray = (array)$FlagVariant;
		return ((in_array(GET_DTDE, $FlagArray))?(S2S_Datum_MySql2Deu($this->mEingestellt)):($this->mEingestellt));
	}

	final public function getGueltigBis($FlagVariant = array())
	{
		$FlagArray = (array)$FlagVariant;
		$Datum = ((in_array(GET_DTDE, $FlagArray))?(S2S_Datum_MySql2Deu($this->mGueltigBis)):($this->mGueltigBis));
		return ((is_null($v = $Datum) and in_array(GET_NBSP, $FlagArray))?('&nbsp;'):($v));
	}

	final public function getWichtig($FlagVariant = array())
	{
		$FlagArray = (array)$FlagVariant;
		return ((in_array(GET_SPEC, $FlagArray))?(($this->mWichtig)?('ja'):('nein')):(($this->mWichtig)?(1):(0)));
	}

	/*@}*/

	/*****************************************************************************************************************//**
	 * @name Datenbank
	 **************************************************************************************************************//*@{*/

	public static function isValidID($NeuigkeitID) {
		return CDriveEntity::genericIsValidID(self::mcTabName, $NeuigkeitID);
	}

	public function load($NeuigkeitID)
	{
		self::setInitVals();
		$this->setNeuigkeitID($NeuigkeitID);
		$format = 'SELECT athlet_id, titel, inhalt, eingestellt, gueltigbis, wichtig '.
		          'FROM neuigkeiten WHERE neuigkeit_id=%s';
		$query = sprintf($format, $this->getNeuigkeitID());
		if(!$result = mysqli_query(CDriveEntity::getDB(), $query)) {throw new Exception(mysqli_error(CDriveEntity::getDB()));}
		$row = mysqli_fetch_row($result);
		if(!$row) {throw new Exception('Neuigkeit mit neuigkeit_id='.$NeuigkeitID.' nicht gefunden!');}
		$this->mAthletID = lD($row[0]);
		$this->mTitel = lS($row[1]);
		$this->mInhalt = lS($row[2]);
		$this->mEingestellt = lS($row[3]);
		$this->mGueltigBis = lS($row[4]);
		$this->mWichtig = lB($row[5]);
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
			$format = 'UPDATE neuigkeiten SET '.
			          'athlet_id=%s, titel=%s, inhalt=%s, eingestellt=%s, gueltigbis=%s, wichtig=%s '.
			          'WHERE neuigkeit_id=%s';
			$query = sprintf($format, sD($this->mAthletID), sS($this->mTitel), sS($this->mInhalt), sS($this->mEingestellt),
			sS($this->mGueltigBis), sB($this->mWichtig), $this->getID());
		}
		else
		{
			$format = 'INSERT INTO neuigkeiten ('.
			          'athlet_id, titel, inhalt, eingestellt, gueltigbis, wichtig'.
			          ') VALUES (%s, %s, %s, %s, %s, %s)';
			$query = sprintf($format, sD($this->mAthletID), sS($this->mTitel), sS($this->mInhalt), sS($this->mEingestellt),
			sS($this->mGueltigBis), sB($this->mWichtig));
		}
		if(!$result = mysqli_query(CDriveEntity::getDB(), $query)) {throw new Exception(mysqli_error(CDriveEntity::getDB()));}

		// Basisklasse
		parent::store();
	}

	public function check()
	{
		// AthletID
		if(!CAthlet::isValidID($this->mAthletID)) {
			CDriveEntity::addCheckMsg('Die athlet_id ist ungültig.');
		}

		// Titel
		if(!(strlen($this->mTitel) >= 1 and strlen($this->mTitel) <= 100)) {
			CDriveEntity::addCheckMsg('Der Titel muss mind. 1 bis max. 100 Zeichen lang sein.');
		}

		// Inhalt
		if(!(strlen($this->mInhalt) >= 1 and strlen($this->mInhalt) <= 65535)) {
			CDriveEntity::addCheckMsg('Der Inhalt muss mind. 1 bis max. 65535 Zeichen lang sein.');
		}
		else if(substr_count($this->mInhalt, '{') != substr_count($this->mInhalt, '}')) {
			CDriveEntity::addCheckMsg('Die Anzahl an sich öffnenden und sich schließenden geschw. Klammern ist ungleich.');
		}

		// Eingestellt
		if(!(preg_match(REGEX_DATE_SQ, $this->mEingestellt)
		and preg_match(REGEX_DATE_DE, $this->getEingestellt(GET_DTDE)))) {
			CDriveEntity::addCheckMsg('Das Einstelldatum muss von der Form \'TT.MM.JJJJ\' sein.');
		}
		else if(!checkdate(
		substr($this->mEingestellt, 5, 2), substr($this->mEingestellt, 8, 2), substr($this->mEingestellt, 0, 4))) {
			CDriveEntity::addCheckMsg('Das Einstelldatum is ungültig.');
		}

		// GueltigBis
		if(!is_null($this->mGueltigBis))
		{
			if(!(preg_match(REGEX_DATE_SQ, $this->mGueltigBis)
			and preg_match(REGEX_DATE_DE, $this->getGueltigBis(GET_DTDE)))) {
				CDriveEntity::addCheckMsg('Das Gültigkeitsdatum muss von der Form \'TT.MM.JJJJ\' sein.');
			}
			else if(!checkdate(
			substr($this->mGueltigBis, 5, 2), substr($this->mGueltigBis, 8, 2), substr($this->mGueltigBis, 0, 4))) {
				CDriveEntity::addCheckMsg('Das Gültigkeitsdatum is ungültig.');
			}
		}

		// Bild
		CDriveEntityWithAttachment::check();
	}

	/*@}*/

	/*****************************************************************************************************************//**
	 * @name Verschiedenes
	 **************************************************************************************************************//*@{*/

	public function getXHTML()
	{
		$xhtml = '<div class="neuigkeit">'."\n";
		if($this->getWichtig()){ $xhtml .= '<div class="highlight">'."\n"; }
		$xhtml .= '<div class="kopf">'."\n";
		$xhtml .= '<h3>'.$this->getAthletID(GET_SPEC).', '.$this->getEingestellt(GET_DTDE).'</h3>';
		$xhtml .= '<h2>'.$this->getTitel().'</h2>'."\n";
		$xhtml .= '</div>'."\n";
		$xhtml .= '<div class="koerper'.(($img = $this->getXHTMLforIMG())?(' floatpic'):('')).'" >'."\n";
		$xhtml .= (($img)?($img."\n"):(''));
		$xhtml .= $this->getInhalt(GET_SPEC)."\n";

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
		if($this->getWichtig()) { $xhtml .= '</div>'."\n"; }

		return $xhtml;
	}

	public static function getRecentNeuigkeitArray()
	{
		$query = 'SELECT neuigkeit_id FROM neuigkeiten WHERE gueltigbis IS NULL OR gueltigbis >= CURDATE() '.
		         'ORDER BY wichtig DESC, eingestellt DESC, neuigkeit_id';
		if(!$result = mysqli_query(CDriveEntity::getDB(), $query)) {throw new Exception(mysql_error(CDriveEntity::getDB()));}
		while($row = mysqli_fetch_row($result)) {$NeuigkeitArray[] = new CNeuigkeit($row[0]);}
		return ((isset($NeuigkeitArray))?($NeuigkeitArray):(array()));
	}

	/*@}*/
}
?>