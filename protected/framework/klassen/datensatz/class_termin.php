<?php
include_once(dirname(__FILE__).'/../datenbank/class_drive_entity_with_attach.php');

/*******************************************************************************************************************//**
 * Repräsentation eines Termins in seiner allgemeinsten Form.
 * @ingroup grp_recordset
 **********************************************************************************************************************/
class CTermin extends CDriveEntityWithAttachment
{
	/*****************************************************************************************************************//**
	 * @name Tabellenname
	 **************************************************************************************************************//*@{*/

	const mcTabName = 'termine';

	/*@}*/

	/*****************************************************************************************************************//**
	 * @name Tabellenspalten
	 **************************************************************************************************************//*@{*/

	private $mDatum;
	private $mFreitext;

	/*@}*/

	/*****************************************************************************************************************//**
	 * @name Magics
	 **************************************************************************************************************//*@{*/

	public function __construct($TerminID = 0) {
		parent::__construct(self::mcTabName, $TerminID);
	}

	public function __toString()
	{
		if(!$this->getTerminID()) {return 'Kein Termin';}
		return $this->mDatum;
	}

	/*@}*/

	/*****************************************************************************************************************//**
	 * @name Setter
	 **************************************************************************************************************//*@{*/

	public function setInitVals()
	{
		parent::setInitVals();
		$this->mDatum = '';
		$this->mFreitext = null;
	}

	final public function setTerminID($TerminID) {
		CDriveEntity::setID($TerminID);
	}

	final public function setDatum($Datum) {
		$this->mDatum = trim((string)$Datum);
	}

	final public function setFreitext($Freitext) {
		$this->mFreitext = (($s = trim((string)$Freitext))?($s):(null));
	}

	/*@}*/

	/*****************************************************************************************************************//**
	 * @name Getter
	 **************************************************************************************************************//*@{*/

	final public function getTerminID()
	{
		return CDriveEntity::getID();
	}

	final public function getDatum($FlagVariant = array())
	{
		$FlagArray = (array)$FlagVariant;
		return ((in_array(GET_DTDE, $FlagArray))?(S2S_Datum_MySql2Deu($this->mDatum)):($this->mDatum));
	}

	final public function getFreitext($FlagVariant = array())
	{
		$FlagArray = (array)$FlagVariant;
		if(is_null($v = $this->mFreitext) and in_array(GET_NBSP, $FlagArray)) {return '&nbsp;';}
		$Freitext = ((in_array(GET_SPEC, $FlagArray))?(FormatXHTMLPermittedString($this->mFreitext)):($this->mFreitext));
		$Freitext = ((in_array(GET_CLIP, $FlagArray) and (strlen($Freitext) > 20))?(substr($Freitext, 0, 20).'...'):($Freitext));
		$Freitext = ((in_array(GET_HSPC, $FlagArray))?(htmlspecialchars($Freitext)):($Freitext));
		return $Freitext;
	}

	/*@}*/

	/*****************************************************************************************************************//**
	 * @name Datenbank
	 **************************************************************************************************************//*@{*/

	public static function isValidID($TerminID) {
		return CDriveEntity::genericIsValidID(self::mcTabName, $TerminID);
	}

	public function load($TerminID)
	{
		self::setInitVals();
		$this->setTerminID($TerminID);
		$format = 'SELECT datum, freitext '.
		          'FROM termine WHERE termin_id=%s';
		$query = sprintf($format, $this->getTerminID());
		if(!$result = mysqli_query(CDriveEntity::getDB(), $query)) {throw new Exception(mysqli_error(CDriveEntity::getDB()));}
		$row = mysqli_fetch_row($result);
		if(!$row) {throw new Exception('Termin mit termin_id='.$TerminID.' nicht gefunden!');}
		$this->mDatum = lS($row[0]);
		$this->mFreitext = lS($row[1]);
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
			$format = 'UPDATE termine SET '.
			          'datum=%s, freitext=%s '.
			          'WHERE termin_id=%s';
			$query = sprintf($format, sS($this->mDatum), sS($this->mFreitext), $this->getID());
		}
		else
		{
			$format = 'INSERT INTO termine ('.
			          'datum, freitext'.
			          ') VALUES (%s, %s)';
			$query = sprintf($format, sS($this->mDatum), sS($this->mFreitext));
		}
		if(!$result = mysqli_query(CDriveEntity::getDB(), $query)) {throw new Exception(mysqli_error(CDriveEntity::getDB()));}

		// Basisklasse
		parent::store();
	}

	public function check()
	{
		// Datum
		if(!(preg_match(REGEX_DATE_SQ, $this->mDatum)
		and preg_match(REGEX_DATE_DE, $this->getDatum(GET_DTDE)))) {
			CDriveEntity::addCheckMsg('Das Datum bzw. der Terminbeginn muss von der Form \'TT.MM.JJJJ\' sein.');
		}
		else if(!checkdate(
		substr($this->mDatum, 5, 2), substr($this->mDatum, 8, 2), substr($this->mDatum, 0, 4))) {
			CDriveEntity::addCheckMsg('Das Termin(start)datum is ungültig.');
		}

		// Freitext
		if(!is_null($this->mFreitext))
		{
			if(!(strlen($this->mFreitext) >= 1 and strlen($this->mFreitext) <= 65535)) {
				CDriveEntity::addCheckMsg('Der Freitext muss mind. 1 bis max. 65535 Zeichen lang sein.');
			}
			else if(substr_count($this->mFreitext, '{') != substr_count($this->mFreitext, '}')) {
				CDriveEntity::addCheckMsg('Die Anzahl an sich öffnenden und sich schließenden geschw. Klammern ist ungleich.');
			}
		}

		// Bild
		CDriveEntityWithAttachment::check();
	}

	/*@}*/
}
?>