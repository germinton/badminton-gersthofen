<?php
include_once(dirname(__FILE__).'/class_athlet.php');
include_once(dirname(__FILE__).'/class_mannschaft.php');

/*******************************************************************************************************************//**
 * Repräsentation eines Gegners.
 * @ingroup grp_recordset
 **********************************************************************************************************************/
class CGegner extends CAthlet
{
	/*****************************************************************************************************************//**
	 * @name Tabellenspalten
	 **************************************************************************************************************//*@{*/

	private $mVereinID;

	/*@}*/

	/*****************************************************************************************************************//**
	 * @name Magics
	 **************************************************************************************************************//*@{*/

	public function __construct($AthletID = 0) {
		parent::__construct($AthletID);
	}

	public function __toString()
	{
		if(!$this->getAthletID()) {return 'Kein Gegner';}
		if(!is_null($this->mVereinID))
		{
			if(CVerein::isValidID($this->mVereinID))
			{
				$Verein = new CVerein($this->mVereinID);
				return CAthlet::getVornameNachname().' ('.$Verein.')';
			}
		}
		return CAthlet::getVornameNachname();
	}

	/*@}*/

	/*****************************************************************************************************************//**
	 * @name Setter
	 **************************************************************************************************************//*@{*/

	public function setInitVals()
	{
		parent::setInitVals();
		$this->mVereinID = null;
	}

	final public function setVereinID($VereinID) {
		$this->mVereinID = (($i = (int)$VereinID)?($i):(null));
	}

	/*@}*/

	/*****************************************************************************************************************//**
	 * @name Getter
	 **************************************************************************************************************//*@{*/

	final public function getVereinID($FlagVariant = array())
	{
		$FlagArray = (array)$FlagVariant;
		if(is_null($ID = $this->mVereinID) and in_array(GET_NBSP, $FlagArray)) {return '&nbsp;';}
		return ((!is_null($ID) and in_array(GET_OFID, $FlagArray))?(new CVerein($ID)):($ID));
	}

	/*@}*/

	/*****************************************************************************************************************//**
	 * @name Datenbank
	 **************************************************************************************************************//*@{*/

	public static function isValidID($AthletID) {
		return CDriveEntity::genericIsValidID('athleten_gegner', $AthletID);
	}

	public function load($AthletID)
	{
		self::setInitVals();
		CAthlet::load($AthletID);
		$format = 'SELECT verein_id '.
		          'FROM athleten_gegner WHERE athlet_id=%s';
		$query = sprintf($format, $this->getAthletID());
		if(!$result = mysql_query($query, CDriveEntity::getDB())) {throw new Exception(mysql_error(CDriveEntity::getDB()));}
		$row = mysql_fetch_row($result);
		if(!$row) {throw new Exception('Gegner mit athlet_id='.$AthletID.' nicht gefunden!');}
		$this->mVereinID = lD($row[0]);
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
			$format = 'UPDATE athleten_gegner SET '.
			          'verein_id=%s '.
			          'WHERE athlet_id=%s';
			$query = sprintf($format, sD($this->mVereinID), $this->getID());
		}
		else
		{
			$format = 'INSERT INTO athleten_gegner ('.
			          'athlet_id, verein_id'.
			          ') VALUES (%s, %s)';
			$query = sprintf($format, $this->getID(), sS($this->mVereinID));
		}
		if(!$result = mysql_query($query, CDriveEntity::getDB())) {throw new Exception(mysql_error(CDriveEntity::getDB()));}
	}

	public function check()
	{
		// Basisklasse
		parent::check();

		// VereinID
		if(!is_null($this->mVereinID))
		{
			if(!CVerein::isValidID($this->mVereinID)) {
				CDriveEntity::addCheckMsg('Die verein_id ist ungültig.');
			}
		}
	}

	/*@}*/

	/*****************************************************************************************************************//**
	 * @name Verschiedenes
	 **************************************************************************************************************//*@{*/


	/*@}*/
}
?>