<?php
include_once(dirname(__FILE__).'/../datenbank/class_drive_entity.php');

/*******************************************************************************************************************//**
 * Repräsentation einer Aufgabe.
 * Eine Aufgabe bezitzt je eine Bezeichnung für Männer und Frauen. Des weiteren kann sie einem Typ zugeordnet werden.
 * Ein 'Sortierungs'-Wert spiegelt wieder, dass unterschiedliche Aufgaben unterschiedlich wichtig sind.
 * @ingroup grp_recordset
 **********************************************************************************************************************/
class CAufgabe extends CDriveEntity
{
	/*****************************************************************************************************************//**
	 * @name Tabellenname
	 **************************************************************************************************************//*@{*/

	const mcTabName = 'aufgaben';

	/*@}*/

	/*****************************************************************************************************************//**
	 * @name Tabellenspalten
	 **************************************************************************************************************//*@{*/

	private $mBezMaennlich;
	private $mBezWeiblich;
	private $mAufgabentyp;
	private $mSortierung;
	private $mFreitext;

	/*@}*/

	/*****************************************************************************************************************//**
	 * @name Magics
	 **************************************************************************************************************//*@{*/

	public function __construct($AufgabeID = 0) {
		parent::__construct(self::mcTabName, $AufgabeID);
	}

	public function __toString()
	{
		if(!$this->getAufgabeID()) {return 'Keine Aufgabe';}
		return $this->mBezMaennlich;
	}

	/*@}*/

	/*****************************************************************************************************************//**
	 * @name Setter
	 **************************************************************************************************************//*@{*/

	public function setInitVals()
	{
		parent::setInitVals();
		$this->mBezMaennlich = '';
		$this->mBezWeiblich = '';
		$this->mAufgabentyp = 0;
		$this->mSortierung = 0;
		$this->mFreitext = null;
	}

	final public function setAufgabeID($AufgabeID) {
		CDriveEntity::setID($AufgabeID);
	}

	final public function setBezMaennlich($BezMaennlich) {
		$this->mBezMaennlich = htmlspecialchars(trim((string)$BezMaennlich));
	}

	final public function setBezWeiblich($BezWeiblich) {
		$this->mBezWeiblich = htmlspecialchars(trim((string)$BezWeiblich));
	}

	final public function setAufgabentyp($Aufgabentyp) {
		$this->mAufgabentyp = (int)$Aufgabentyp;
	}

	final public function setSortierung($Sortierung) {
		$this->mSortierung = (int)$Sortierung;
	}

	final public function setFreitext($Freitext) {
		$this->mFreitext = (($s = trim((string)$Freitext))?($s):(null));
	}

	/*@}*/

	/*****************************************************************************************************************//**
	 * @name Getter
	 **************************************************************************************************************//*@{*/

	final public function getAufgabeID()
	{
		return CDriveEntity::getID();
	}

	final public function getBezMaennlich()
	{
		return $this->mBezMaennlich;
	}

	final public function getBezWeiblich()
	{
		return $this->mBezWeiblich;
	}

	final public function getAufgabentyp($FlagVariant = array())
	{
		$FlagArray = (array)$FlagVariant;
		return ((in_array(GET_C2SC, $FlagArray))?(C2S_Aufgabentyp($this->mAufgabentyp)):($this->mAufgabentyp));
	}

	final public function getSortierung()
	{
		return $this->mSortierung;
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

	public static function isValidID($AufgabeID) {
		return CDriveEntity::genericIsValidID(self::mcTabName, $AufgabeID);
	}

	public function load($AufgabeID)
	{
		self::setInitVals();
		$this->setAufgabeID($AufgabeID);
		$format = 'SELECT bez_maennlich, bez_weiblich, aufgabentyp, sortierung, freitext '.
		          'FROM aufgaben WHERE aufgabe_id=%s';
		$query = sprintf($format, $this->getAufgabeID());
		if(!$result = mysql_query($query)) {throw new Exception(mysql_error(CDriveEntity::getDB()));}
		$row = mysql_fetch_row($result);
		if(!$row) {throw new Exception('Aufgabe mit aufgabe_id='.$AufgabeID.' nicht gefunden!');}
		$this->mBezMaennlich = lS($row[0]);
		$this->mBezWeiblich = lS($row[1]);
		$this->mAufgabentyp = lD($row[2]);
		$this->mSortierung = lD($row[3]);
		$this->mFreitext = lS($row[4]);
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
			$format = 'UPDATE aufgaben SET '.
			          'bez_maennlich=%s, bez_weiblich=%s, aufgabentyp=%s, sortierung=%s, freitext=%s '.
			          'WHERE aufgabe_id=%s';
			$query = sprintf($format, sS($this->mBezMaennlich), sS($this->mBezWeiblich), sD($this->mAufgabentyp),
			sD($this->mSortierung), sS($this->mFreitext), $this->getID());
		}
		else
		{
			$format = 'INSERT INTO aufgaben ('.
			          'bez_maennlich, bez_weiblich, aufgabentyp, sortierung, freitext'.
			          ') VALUES (%s, %s, %s, %s, %s)';
			$query = sprintf($format, sS($this->mBezMaennlich), sS($this->mBezWeiblich), sD($this->mAufgabentyp),
			sD($this->mSortierung), sS($this->mFreitext));
		}
		if(!$result = mysql_query($query)) {throw new Exception(mysql_error(CDriveEntity::getDB()));}

		// Basisklasse
		parent::store();
	}

	public function check()
	{
		// BezMaennlich
		if(!(strlen($this->mBezMaennlich) >= 1 and strlen($this->mBezMaennlich) <= 30)) {
			CDriveEntity::addCheckMsg('Die männl. Bezeichnung muss mind. 1 bis max. 30 Zeichen lang sein.');
		}

		// BezWeiblich
		if(!(strlen($this->mBezWeiblich) >= 1 and strlen($this->mBezWeiblich) <= 30)) {
			CDriveEntity::addCheckMsg('Die weibl. Bezeichnung muss mind. 1 bis max. 30 Zeichen lang sein.');
		}

		// Aufgabentyp
		if(!(S_VERWALTUNG == $this->mAufgabentyp
		or S_TRABETRIEB == $this->mAufgabentyp
		or S_SPIBETRIEB == $this->mAufgabentyp)) {
			CDriveEntity::addCheckMsg('Der Aufgabentyp ist ungültig.');
		}

		// Sortierung
		if(!($this->mSortierung >= 0 and $this->mSortierung <= MAX_SORT)) {
			CDriveEntity::addCheckMsg('Der Sortierungswert muss zwischen 0 und '.MAX_SORT.' liegen.');
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
	}

	/*@}*/

	/*****************************************************************************************************************//**
	 * @name Verschiedenes
	 **************************************************************************************************************//*@{*/

	public function isDeletable()
	{
		$Flag = true;
		foreach($GLOBALS['Enum']['Aufgabe'] as $Aufgabe) {
			if($this->getAufgabeID() == $Aufgabe) {$Flag = false; break;}
		}
		return $Flag;
	}

	/*@}*/
}
?>