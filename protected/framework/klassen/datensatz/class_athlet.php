<?php
include_once(dirname(__FILE__).'/../datenbank/class_drive_entity_with_attach.php');
include_once(dirname(__FILE__).'/class_turnierathlet.php');

/*******************************************************************************************************************//**
 * Repräsentation einer/eines Athletin/Athleten in der allgemeinsten Form.
 * Ein Athlet hat ein Geschlecht (definiert über seine Anrede) sowie einen Vor- und Nachnamen. Die Angabe eines
 * Vornamens ist optional.
 * @ingroup grp_recordset
 **********************************************************************************************************************/
class CAthlet extends CDriveEntityWithAttachment
{
	/*****************************************************************************************************************//**
	 * @name Tabellenname
	 **************************************************************************************************************//*@{*/

	const mcTabName = 'athleten';

	/*@}*/

	/*****************************************************************************************************************//**
	 * @name Tabellenspalten
	 **************************************************************************************************************//*@{*/

	private $mAnrede;
	private $mNachname;
	private $mVorname;

	/*@}*/

	/*****************************************************************************************************************//**
	 * @name Magics
	 **************************************************************************************************************//*@{*/

	public function __construct($AthletID = 0) {
		parent::__construct(self::mcTabName, $AthletID);
	}

	public function __toString()
	{
		if(!$this->getAthletID()) {return 'Kein Athlet';}
		return $this->getVornameNachname();
	}

	/*@}*/

	/*****************************************************************************************************************//**
	 * @name Setter
	 **************************************************************************************************************//*@{*/

	public function setInitVals()
	{
		parent::setInitVals();
		$this->mAnrede = 0;
		$this->mNachname = '';
		$this->mVorname = null;
	}

	final public function setAthletID($AthletID) {
		CDriveEntity::setID($AthletID);
	}

	final public function setAnrede($Anrede) {
		$this->mAnrede = (int)$Anrede;
	}

	final public function setNachname($Nachname) {
		$this->mNachname = htmlspecialchars(trim((string)$Nachname));
	}

	final public function setVorname($Vorname) {
		$this->mVorname = (($s = htmlspecialchars(trim((string)$Vorname)))?($s):(null));
	}

	/*@}*/

	/*****************************************************************************************************************//**
	 * @name Getter
	 **************************************************************************************************************//*@{*/

	final public function getAthletID() {
		return CDriveEntity::getID();
	}

	final public function getAnrede($FlagVariant = array())
	{
		$FlagArray = (array)$FlagVariant;
		if(in_array(GET_C2SC, $FlagArray)) {return C2S_Anrede($this->mAnrede);}
		if(in_array(GET_SPEC, $FlagArray)) {return C2S_Geschlecht($this->mAnrede);}
		return $this->mAnrede;
	}

	final public function getNachname()
	{
		return $this->mNachname;
	}

	final public function getVorname($FlagVariant = array())
	{
		$FlagArray = (array)$FlagVariant;
		return ((is_null($v = $this->mVorname) and in_array(GET_NBSP, $FlagArray))?('&nbsp;'):($v));
	}

	/*@}*/

	/*****************************************************************************************************************//**
	 * @name Datenbank
	 **************************************************************************************************************//*@{*/

	public static function isValidID($AthletID) {
		return CDriveEntity::genericIsValidID(self::mcTabName, $AthletID);
	}

	public function load($AthletID)
	{
		self::setInitVals();
		$this->setAthletID($AthletID);
		$format = 'SELECT anrede, nachname, vorname '.
		          'FROM athleten WHERE athlet_id=%s';
		$query = sprintf($format, $this->getAthletID());
		if(!$result = mysql_query($query)) {throw new Exception(mysql_error(CDriveEntity::getDB()));}
		$row = mysql_fetch_row($result);
		if(!$row) {throw new Exception('Athlet mit athlet_id='.$AthletID.' nicht gefunden!');}
		$this->mAnrede = lD($row[0]);
		$this->mNachname = lS($row[1]);
		$this->mVorname = lS($row[2]);
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
			$format = 'UPDATE athleten SET '.
			          'anrede=%s, vorname=%s, nachname=%s '.
			          'WHERE athlet_id=%s';
			$query = sprintf($format, sD($this->mAnrede), sS($this->mVorname), sS($this->mNachname), $this->getID());
		}
		else
		{
			$format = 'INSERT INTO athleten ('.
			          'anrede, vorname, nachname'.
			          ') VALUES (%s, %s, %s)';
			$query = sprintf($format, sD($this->mAnrede), sS($this->mVorname), sS($this->mNachname));
		}
		if(!$result = mysql_query($query)) {throw new Exception(mysql_error(CDriveEntity::getDB()));}

		// Basisklasse
		parent::store();
	}

	public function check()
	{
		// Anrede
		if(!((S_HERR == $this->mAnrede) or (S_DAME == $this->mAnrede))) {
			CDriveEntity::addCheckMsg('Die Anrede muss entweder \'Herr\' oder \'Dame\' lauten.');
		}

		// Nachname
		if(!(strlen($this->mNachname) >= 1 and strlen($this->mNachname) <= 30)) {
			CDriveEntity::addCheckMsg('Der Nachname muss mind. 1 bis max. 30 Zeichen lang sein.');
		}

		// Vorname
		if(!is_null($this->mVorname))
		{
			if(strlen($this->mVorname) > 30) {
				CDriveEntity::addCheckMsg('Der Vorname darf nicht länger als 30 Zeichen sein.');
			}
		}

		// Bild
		CDriveEntityWithAttachment::check();
	}

	/*@}*/

	/*****************************************************************************************************************//**
	 * @name Verschiedenes
	 **************************************************************************************************************//*@{*/

	public function getVornameNachname() {
		return (($this->mVorname)?($this->mVorname.' '):('')).$this->mNachname;
	}

	public function getNachnameVorname() {
		return $this->mNachname.(($this->mVorname)?(', '.$this->mVorname):(''));
	}

	public function hatAufgabe($AufgabeIDVariant) {
		return ((in_array($this->getAthletID(), CAufgabenzuordnung::getAthletIDArray($AufgabeIDVariant)))?(true):(false));
	}

	public function getMeisterstringArray()
	{
		$query = 'SELECT ta.turnierathlet_id '.
		'FROM (turniere t INNER JOIN turniermeldungen tm ON t.turnier_id=tm.turnier_id) '.
		'INNER JOIN turnierathleten ta ON tm.turniermeldung_id=ta.turniermeldung_id '.
		'WHERE (ta.athlet_id='.$this->getAthletID().') AND (t.ebene IS NOT NULL) AND '.
		'(t.turniertyp='.S_MEISTERSCHAFT.') AND (tm.platzierung=1 OR tm.platzierung=2) '.
		'ORDER BY t.ebene DESC, tm.platzierung, t.datumvon DESC, tm.spieltyp';
		if(!$result = mysql_query($query, CDriveEntity::getDB())) {throw new Exception(mysql_error(CDriveEntity::getDB()));}

		$Turnierathlet = new CTurnierathlet();
		while($row = mysql_fetch_row($result))
		{
			$Turnierathlet->load($row[0]);
			$MeisterstringArray[] = $Turnierathlet->getMeisterstring();
		}

		return ((isset($MeisterstringArray))?($MeisterstringArray):(array()));
	}

	public function getRLErfolgstringArray()
	{
		$query = 'SELECT ta.turnierathlet_id '.
		'FROM (turniere t INNER JOIN turniermeldungen tm ON t.turnier_id=tm.turnier_id) '.
		'INNER JOIN turnierathleten ta ON tm.turniermeldung_id=ta.turniermeldung_id '.
		'WHERE (ta.athlet_id='.$this->getAthletID().') AND (t.ebene IS NOT NULL) AND '.
		'(t.turniertyp='.S_RANGLISTE.') AND (tm.platzierung BETWEEN 1 AND 10) '.
		'ORDER BY t.ebene DESC, tm.platzierung, t.datumvon DESC, tm.spieltyp';
		if(!$result = mysql_query($query, CDriveEntity::getDB())) {throw new Exception(mysql_error(CDriveEntity::getDB()));}

		$Turnierathlet = new CTurnierathlet();
		while($row = mysql_fetch_row($result))
		{
			$Turnierathlet->load($row[0]);
			$RLErfolgArray[] = $Turnierathlet->getRLErfolgstring();
		}

		return ((isset($RLErfolgArray))?($RLErfolgArray):(array()));
	}

	public function getMannschaftID()
	{
		/*
		 * Prüft ob der Athlet in der aktuellen Saison einer Mannschaft zugeordnet ist und gibt die ID zurück.
		 */
		$query = 'SELECT ms.mannschaft_id '.
		'FROM (aufstellungen a INNER JOIN mannschaften ms ON ms.mannschaft_id=a.mannschaft_id) '.
		'INNER JOIN mannschaftsspieler mss ON mss.aufstellung_id=a.aufstellung_id ' .
		'WHERE (mss.athlet_id='.$this->getAthletID().') AND (ms.saison_id='.CDBConnection::getInstance()->getSaisonID().') '.
		'ORDER BY ms.mannschaft_id DESC';
		if(!$result = mysql_query($query, CDriveEntity::getDB())) {throw new Exception(mysql_error(CDriveEntity::getDB()));}
		$row = mysql_fetch_row($result);
		return (int)$row[0];
	}

	public function isDeletable()
	{
		/*
		 * In welchen Tabellen wird eine athlet_id eingetragen und wie kritisch ist diese Tabelle?
		 *
		 * athleten_gegner.............unkritisch (1:1 Beziehung => lediglich Zusatzinfos)
		 * athleten_mitglieder.........unkritisch (1:1 Beziehung => lediglich Zusatzinfos)
		 * aufgabenzuordnungen.........unkritisch (keine weiteren Abhängigkeiten)
		 * aufstellungen...............kritisch (Mannschaftsführer!)
		 * ersatzspieler...............kritisch (SpErMl wird ungültig!)
		 * kontrahenten................kritisch (Spiel muss gelöscht werden => SpErMl wird ungültig!)
		 * mannschaftsspieler..........unkritisch (nicht genutzt bzw. keine weiteren Abhängigkeiten)
		 * neuigkeiten.................unkritisch (keine weiteren Abhängigkeiten)
		 * termine.....................unkritisch (keine weiteren Abhängigkeiten)
		 * turnierathleten.............kritisch (Turniermeldung muss gelöscht werden!)
		 * tabellen....................unkritisch (athlet_id optional)
		 *
		 */

		$Zaehler = 0;

		$TabNameArray[] = 'aufstellungen';
		$TabNameArray[] = 'kontrahenten';
		$TabNameArray[] = 'ersatzspieler';
		$TabNameArray[] = 'turnierathleten';

		foreach($TabNameArray as $TabName) {
			$query = 'SELECT COUNT(*) FROM '.$TabName.' WHERE athlet_id='.$this->getAthletID();
			if(!$result = mysql_query($query, CDriveEntity::getDB())) {
				throw new Exception(mysql_error(CDriveEntity::getDB()));
			}
			$row = mysql_fetch_row($result);
			$Zaehler += (int)$row[0];
		}

		return (($Zaehler)?(false):(true));
	}

	/*@}*/
}
?>