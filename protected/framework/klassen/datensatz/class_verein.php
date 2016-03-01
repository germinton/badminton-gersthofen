<?php
include_once(dirname(__FILE__).'/../datenbank/class_drive_entity.php');

/*******************************************************************************************************************//**
 * Repräsentation eines Vereins.
 * @ingroup grp_recordset
 **********************************************************************************************************************/
class CVerein extends CDriveEntityWithAttachment
{
	/*****************************************************************************************************************//**
	 * @name Tabellenname
	 **************************************************************************************************************//*@{*/

	const mcTabName = 'vereine';

	/*@}*/

	/*****************************************************************************************************************//**
	 * @name Tabellenspalten
	 **************************************************************************************************************//*@{*/

	private $mKuerzel;
	private $mName;
	private $mHomepage;

	/*@}*/

	/*****************************************************************************************************************//**
	 * @name Magics
	 **************************************************************************************************************//*@{*/

	public function __construct($VereinID = 0) {
		parent::__construct(self::mcTabName, $VereinID);
	}

	public function __toString()
	{
		if(!$this->getVereinID()) {return 'Kein Verein';}
		return ((is_string($this->mKuerzel))?($this->mKuerzel.'&nbsp;'):('')).$this->mName;
	}

	/*@}*/

	/*****************************************************************************************************************//**
	 * @name Setter
	 **************************************************************************************************************//*@{*/

	public function setInitVals()
	{
		parent::setInitVals();
		$this->mKuerzel = null;
		$this->mName = '';
		$this->mHomepage = null;
	}

	final public function setVereinID($VereinID) {
		CDriveEntity::setID($VereinID);
	}

	final public function setKuerzel($Kuerzel) {
		$this->mKuerzel = (($s = htmlspecialchars(trim((string)$Kuerzel)))?($s):(null));
	}
	final public function setName($Name) {
		$this->mName = htmlspecialchars(trim((string)$Name));
	}
	final public function setHomepage($Homepage) {
		$this->mHomepage = (($s = htmlspecialchars(trim((string)$Homepage)))?($s):(null));
	}

	/*@}*/

	/*****************************************************************************************************************//**
	 * @name Getter
	 **************************************************************************************************************//*@{*/

	final public function getVereinID()
	{
		return CDriveEntity::getID();
	}

	final public function getKuerzel($FlagVariant = array())
	{
		$FlagArray = (array)$FlagVariant;
		return ((is_null($v = $this->mKuerzel) and in_array(GET_NBSP, $FlagArray))?('&nbsp;'):($v));
	}

	final public function getName()
	{
		return $this->mName;
	}

	final public function getHomepage($FlagVariant = array())
	{
		$FlagArray = (array)$FlagVariant;
		$l = $this->mHomepage; $lc = ((strlen($l) > 32)?(substr($l, 0, 32).'...'):($l));
		$v = (string)$this; $vc = ((strlen($v) > 32)?(substr($v, 0, 32).'...'):($v));
		$a = '<a href="'.$l.'" '.STD_NEW_WINDOW.'>'.$v.'</a>';
		$ac = '<a href="'.$l.'" '.STD_NEW_WINDOW.'>'.$vc.'</a>';
		if(is_null($l) and !in_array(GET_SPEC, $FlagArray) and in_array(GET_NBSP, $FlagArray)) {return '&nbsp;';}
		if(is_null($l) and in_array(GET_SPEC, $FlagArray)) {return ((in_array(GET_CLIP, $FlagArray))?($vc):($v));}
		if(!is_null($l) and in_array(GET_SPEC, $FlagArray)) {return ((in_array(GET_CLIP, $FlagArray))?($ac):($a));}
		return ((!is_null($l))?((in_array(GET_CLIP, $FlagArray))?($lc):($l)):($l));
	}

	/*@}*/

	/*****************************************************************************************************************//**
	 * @name Datenbank
	 **************************************************************************************************************//*@{*/

	public static function isValidID($VereinID) {
		return CDriveEntity::genericIsValidID(self::mcTabName, $VereinID);
	}

	public function load($VereinID)
	{
		self::setInitVals();
		$this->setVereinID($VereinID);
		$format = 'SELECT kuerzel, name, homepage '.
		          'FROM vereine WHERE verein_id=%s';
		$query = sprintf($format, $this->getVereinID());
		if(!$result = mysqli_query(CDriveEntity::getDB(), $query)) {throw new Exception(mysqli_error(CDriveEntity::getDB()));}
		$row = mysqli_fetch_row($result);
		if(!$row) {throw new Exception('Verein mit verein_id='.$VereinID.' nicht gefunden!');}
		$this->mKuerzel = lS($row[0]);
		$this->mName = lS($row[1]);
		$this->mHomepage = lS($row[2]);
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
			$format = 'UPDATE vereine SET '.
			          'kuerzel=%s, name=%s, homepage=%s '.
			          'WHERE verein_id=%s';
			$query = sprintf($format, sS($this->mKuerzel), sS($this->mName), sS($this->mHomepage), $this->getID());
		}
		else
		{
			$format = 'INSERT INTO vereine ('.
			          'kuerzel, name, homepage'.
			          ') VALUES (%s, %s, %s)';
			$query = sprintf($format, sS($this->mKuerzel), sS($this->mName), sS($this->mHomepage));
		}
		if(!$result = mysqli_query(CDriveEntity::getDB(), $query)) {throw new Exception(mysqli_error(CDriveEntity::getDB()));}

		// Basisklasse
		parent::store();
	}

	public function check()
	{
		// Kuerzel
		if(!is_null($this->mKuerzel))
		{
			if(strlen($this->mKuerzel) > 5) {
				CDriveEntity::addCheckMsg('Das Kürzel darf nicht länger als 5 Zeichen sein.');
			}
		}

		// Name
		if(!(strlen($this->mName) >= 1 and strlen($this->mName) <= 50)) {
			CDriveEntity::addCheckMsg('Der Name muss mind. 1 bis max. 50 Zeichen lang sein.');
		}

		// Homepage
		if(!is_null($this->mHomepage))
		{
			if(strlen($this->mHomepage) > 255) {
				CDriveEntity::addCheckMsg('Die Homepage-Adresse darf nicht länger als 255 Zeichen sein.');
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
		 * In welchen Tabellen wird eine verein_id eingetragen und wie kritisch ist diese Tabelle?
		 *
		 * sperml_freundschaft...............kritisch (SpErMl wird gelöscht!)
		 * sperml_punktspiel_extern..........kritisch (SpErMl wird gelöscht!)
		 * termine_pktspbeg..................unkritisch (keine weiteren Abhängigkeiten)
		 * vereine_benutzerinformationen.....kritisch (ohnehin nur ein Verein betroffen)
		 * athleten_gegner...................unkritisch (wird NULL gesetzt, Athlet bleibt erhalten)
		 *
		 */

		$Zaehler = 0;

		$query = 'SELECT COUNT(*) FROM sperml_freundschaft WHERE verein_id='.$this->getVereinID();
		if(!$result = mysqli_query(CDriveEntity::getDB(), $query)) {
			throw new Exception(mysql_error(CDriveEntity::getDB()));
		}
		$row = mysqli_fetch_row($result);
		$Zaehler += (int)$row[0];

		$query = 'SELECT COUNT(*) FROM sperml_punktspiel_extern WHERE verein_id='.$this->getVereinID();
		if(!$result = mysqli_query(CDriveEntity::getDB(), $query)) {
			throw new Exception(mysql_error(CDriveEntity::getDB()));
		}
		$row = mysqli_fetch_row($result);
		$Zaehler += (int)$row[0];

		$query = 'SELECT COUNT(*) FROM vereine_benutzerinformationen WHERE verein_id='.$this->getVereinID();
		if(!$result = mysqli_query(CDriveEntity::getDB(), $query)) {
			throw new Exception(mysql_error(CDriveEntity::getDB()));
		}
		$row = mysqli_fetch_row($result);
		$Zaehler += (int)$row[0];

		return (($Zaehler)?(false):(true));
	}

	/*@}*/
}
?>