<?php
include_once(dirname(__FILE__).'/../../konstanten/const__all.php');
include_once(dirname(__FILE__).'/../../funktionen/funct__all.php');
include_once(dirname(__FILE__).'/class_db_connection.php');
include_once(dirname(__FILE__).'/../website/class_show_check_msg.php');

/*******************************************************************************************************************//**
 * Abstrakte Klasse für eine Datensatzrepräsentation der Datenbank. Dient als Basisklasse für die konkreten
 * Datensatz-Klassen wie z. B. CSatz.
 **********************************************************************************************************************/
abstract class CDriveEntity
{

	private static $mDB; ///< Alle Datensatzrepräsentationen verwenden diese MySQL-Verbindung

	/*****************************************************************************************************************//**
	 * @name Datensatzbezogene Attribute
	 **************************************************************************************************************//*@{*/

	private $mCheckMsg = array(); ///< String-Array für Einzelmeldungen der Datenprüfung

	private $mTabName; ///< Name der zugrundeliegenden Tabelle des aktuellen Datensatz-Objekts
	private $mIDName; ///< Name der ID-Spalte der zugrundeliegenden Tabelle des aktuellen Datensatz-Objekts

	private $mID; ///< ID-Wert des aktuellen Datensatz-Objekts in der Tabelle

	/*@}*/

	/*****************************************************************************************************************//**
	 * @name Magics
	 **************************************************************************************************************//*@{*/

	protected function __construct($TabName, $ID = 0)
	{
		$this->mTabName = $TabName;
		$this->mIDName =  S2S_TabName_IDName($TabName);
		$this->mID = $ID;
		self::$mDB = CDBConnection::getDB();
		(($this->mID)?($this->load($this->mID)):($this->setInitVals()));
	}

	/*@}*/

	/*****************************************************************************************************************//**
	 * @name Setter
	 **************************************************************************************************************//*@{*/

	protected function setInitVals() {$this->mID = 0;}

	final protected function setID($ID) {$this->mID = (int)$ID;}

	/*@}*/

	/*****************************************************************************************************************//**
	 * @name Getter
	 **************************************************************************************************************//*@{*/

	protected static function getDB() {return self::$mDB;}

	final public function getCheckMsg() {return $this->mCheckMsg;}

	final protected function getTabName() {return $this->mTabName;}
	final protected function getIDName() {return $this->mIDName;}

	final protected function getID() {return $this->mID;}

	/*@}*/

	/*****************************************************************************************************************//**
	 * @name Verschiedenes
	 **************************************************************************************************************//*@{*/

	public function addCheckMsg($MsgVariant) {$this->mCheckMsg = array_merge($this->mCheckMsg, (array)$MsgVariant);}

	protected function evlCheckMsg() {if(count($this->mCheckMsg)) {throw new CShowCheckMsg($this->mCheckMsg);}}

	/*@}*/

	/*****************************************************************************************************************//**
	 * @name Abstrakt
	 **************************************************************************************************************//*@{*/

	abstract public function load($ID);
	abstract public function save();
	abstract public function check();

	/*@}*/

	/*****************************************************************************************************************//**
	 * @name Datenbank
	 **************************************************************************************************************//*@{*/

	public function delete()
	{
		self::genericDelete($this->mTabName, $this->mID);
		$this->setInitVals();
	}

	protected function store()
	{
		if(!self::genericIsValidID($this->mTabName, $this->mID)) 
		{
			$res = mysqli_query(self::$mDB, "SELECT LAST_INSERT_ID() as LID");
			$r = mysqli_fetch_assoc($res);
			$this->mID = $r['LID'];
			/*
			[PHP-BUG] Bug #53152 [NEW]: mysql_insert_id return 0
			http://www.mail-archive.com/php-bugs@lists.php.net/msg140923.html
			
			$this->mID = mysql_insert_id(self::$mDB);
			*/
		}
	}

	/*@}*/

	/*****************************************************************************************************************//**
	 * @name Allgemein
	 **************************************************************************************************************//*@{*/

	private static function genericDelete($TabName, $ID)
	{
		$IDName = S2S_TabName_IDName($TabName);
		if(!self::genericIsValidID($TabName, $ID)) {throw new Exception('Ungültige '.$IDName);}
		$query = 'DELETE FROM '.$TabName.' WHERE '.$IDName.'='.$ID;
		if(!$result = mysqli_query(self::$mDB, $query)) {throw new Exception(mysqli_error(self::$mDB));}

		/* -----------------------------------------------------------------------------------------------------------------
		 * Erinnerung:
		 *      Für die referentielle Integrität müssen keine Klassen, die nicht direkt von CDriveEntity abgeleitet sind,
		 *      berücksichtigt werden. Beispiel: CMitglied bedarf keines $RefInt['athleten_mitglieder']-Eintrags, weil
		 *      das Elternobjekt mit dem Tabellenname 'athleten' bereits eine einfache 'DELETE'-Operation auf die 1:1
		 *      Tabellen 'athleten_mitglieder' und 'athleten_gegner' ausführt.
		 * -----------------------------------------------------------------------------------------------------------------
		 */

		$RefInt['athleten']['DELETE'][] = 'athleten_gegner';
		$RefInt['athleten']['DELETE'][] = 'athleten_mitglieder';
		$RefInt['athleten']['DELOBJ'][] = 'aufgabenzuordnungen';
		//$RefInt['athleten']['DELOBJ'][] = 'aufstellungen';
		$RefInt['athleten']['DELOBJ'][] = 'ersatzspieler';
		$RefInt['athleten']['DELOBJ'][] = 'kontrahenten';
		$RefInt['athleten']['DELOBJ'][] = 'mannschaftsspieler';
		$RefInt['athleten']['DELOBJ'][] = 'neuigkeiten';
		$RefInt['athleten']['SETNIL'][] = 'tabellen';
		$RefInt['athleten']['DELOBJ'][] = 'termine_allgemein';
		$RefInt['athleten']['DELOBJ'][] = 'turnierathleten';

		$RefInt['aufgaben']['DELOBJ'][] = 'aufgabenzuordnungen';

		$RefInt['aufstellungen']['DELOBJ'][] = 'mannschaftsspieler';

		$RefInt['austragungsorte']['DELOBJ'][] = 'sperml';
		$RefInt['austragungsorte']['DELOBJ'][] = 'termine_pktspbeg';
		$RefInt['austragungsorte']['DELOBJ'][] = 'turniere';

		$RefInt['ligenklassen']['DELOBJ'][] = 'mannschaften';
		$RefInt['ligenklassen']['DELOBJ'][] = 'tabellen';

		//$RefInt['mannschaften']['DELOBJ'][] = 'aufstellungen';
		$RefInt['mannschaften']['DELOBJ'][] = 'sperml_punktspiel_extern';
		$RefInt['mannschaften']['DELOBJ'][] = 'sperml_punktspiel_intern';
		$RefInt['mannschaften']['DELOBJ'][] = 'termine_pktspbeg';

		$RefInt['saisons']['DELOBJ'][] = 'mannschaften';
		$RefInt['saisons']['DELOBJ'][] = 'tabellen';

		$RefInt['sperml']['DELOBJ'][] = 'ersatzspieler';
		$RefInt['sperml']['DELETE'][] = 'sperml_freundschaft';
		$RefInt['sperml']['DELETE'][] = 'sperml_punktspiel_extern';
		$RefInt['sperml']['DELETE'][] = 'sperml_punktspiel_intern';
		$RefInt['sperml']['DELOBJ'][] = 'spiele_sperml';

		$RefInt['spiele']['DELETE'][] = 'spiele_sperml';
		$RefInt['spiele']['DELETE'][] = 'spiele_training';
		$RefInt['spiele']['DELOBJ'][] = 'saetze';
		$RefInt['spiele']['DELOBJ'][] = 'kontrahenten';

		$RefInt['tabellen']['DELOBJ'][] = 'tabelleneintraege';

		$RefInt['termine']['DELETE'][] = 'termine_allgemein';
		$RefInt['termine']['DELETE'][] = 'termine_pktspbeg';

		$RefInt['training']['DELOBJ'][] = 'spiele_training';

		$RefInt['turniere']['DELOBJ'][] = 'turniermeldungen';

		$RefInt['turniermeldungen']['DELOBJ'][] = 'turnierathleten';

		$RefInt['vereine']['SETNIL'][] = 'athleten_gegner';
		$RefInt['vereine']['DELOBJ'][] = 'mannschaften';
		$RefInt['vereine']['DELOBJ'][] = 'sperml_freundschaft';
		$RefInt['vereine']['DELOBJ'][] = 'sperml_punktspiel_extern';
		$RefInt['vereine']['DELOBJ'][] = 'termine_pktspbeg';
		//$RefInt['vereine']['DELETE'][] = 'vereine_benutzerinformationen';

		$Object = null;
		if(isset($RefInt[$TabName]))
		{
			if(isset($RefInt[$TabName]['DELETE']))
			{
				foreach($RefInt[$TabName]['DELETE'] as $TabNameDelete)
				{
					$query = 'DELETE FROM '.$TabNameDelete.' WHERE '.$IDName.'='.$ID;
					if(!$result = mysqli_query(self::$mDB, $query)) {throw new Exception(mysqli_error(self::$mDB));}
				}
			}

			if(isset($RefInt[$TabName]['DELOBJ']))
			{
				foreach($RefInt[$TabName]['DELOBJ'] as $TabNameDelObj)
				{
					$Object = CDriveEntity::getObjectForTabName($TabNameDelObj);
					$query = 'SELECT '.S2S_TabName_IDName($TabNameDelObj).' FROM '.$TabNameDelObj.' WHERE ';
					if('mannschaften' == $TabName and 'sperml_punktspiel_intern' == $TabNameDelObj) {
						$query .= 'heim_'.$IDName.'='.$ID.' OR gast_'.$IDName.'='.$ID;
					}
					else {
						$query .= $IDName.'='.$ID;
					}
					if(!$result = mysqli_query(self::$mDB, $query)) {throw new Exception(mysqli_error(self::$mDB));}
					while($row = mysqli_fetch_row($result)) {$Object->load($row[0]); $Object->delete();}
				}
			}

			if(isset($RefInt[$TabName]['SETNIL']))
			{
				foreach($RefInt[$TabName]['SETNIL'] as $TabNameSetNull)
				{
					$query = 'UPDATE '.$TabNameSetNull.' SET '.$IDName.'=NULL WHERE '.$IDName.'='.$ID;
					if(!$result = mysqli_query(self::$mDB, $query)) {throw new Exception(mysqli_error(self::$mDB));}
				}
			}
		}

	}

	public static function getObjectForTabName($TabName, $ID = 0)
	{
		$Object = null;
		switch($TabName)
		{
			case 'athleten': $Object = new CAthlet($ID); break;
			case 'athleten_gegner': $Object = new CGegner($ID); break;
			case 'athleten_mitglieder': $Object = new CMitglied($ID); break;
			case 'aufgaben': $Object = new CAufgabe($ID); break;
			case 'aufgabenzuordnungen': $Object = new CAufgabenzuordnung($ID); break;
			//case 'aufstellungen': $Object = new CAufstellung($ID); break;
			case 'austragungsorte': $Object = new CAustragungsort($ID); break;
			case 'ersatzspieler': $Object = new CErsatzspieler($ID); break;
			case 'kontrahenten': $Object = new CKontrahent($ID); break;
			case 'ligenklassen': $Object = new CLigaKlasse($ID); break;
			case 'mannschaften': $Object = new CMannschaft($ID); break;
			//case 'mannschaftsspieler': $Object = new CMannschaftsspieler($ID); break;
			case 'neuigkeiten': $Object = new CNeuigkeit($ID); break;
			case 'saetze': $Object = new CSatz($ID); break;
			case 'saisons': $Object = new CSaison($ID); break;
			case 'sperml': $Object = new CSpErMl($ID); break;
			case 'sperml_freundschaft': $Object = new CSpErMlFreundschaft($ID); break;
			case 'sperml_punktspiel_extern': $Object = new CSpErMlPunktspielExtern($ID); break;
			case 'sperml_punktspiel_intern': $Object = new CSpErMlPunktspielIntern($ID); break;
			case 'spiele': $Object = new CSpiel($ID); break;
			case 'spiele_sperml': $Object = new CSpielSpErMl($ID); break;
			//case 'spiele_training': $Object = new CTraining($ID); break;
			case 'tabellen': $Object = new CTabelle($ID); break;
			case 'tabelleneintraege': $Object = new CTabelleneintrag($ID); break;
			case 'termine': $Object = new CTermin($ID); break;
			case 'termine_allgemein': $Object = new CTerminAllg($ID); break;
			case 'termine_pktspbeg': $Object = new CTerminPSB($ID); break;
			//case 'training': $Object = new CTraining($ID); break;
			case 'turnierathleten': $Object = new CTurnierathlet($ID); break;
			case 'turniere': $Object = new CTurnier($ID); break;
			case 'turniermeldungen': $Object = new CTurniermeldung($ID); break;
			case 'vereine': $Object = new CVerein($ID); break;
			//case 'vereine_benutzerinformationen': $Object = new CVereinBenutzerinformation($ID); break;
			default: throw new Exception('Für den Tabellenname \''.$TabName.'\' wurde noch keine Klasse erstellt.'); break;
		}
		return $Object;
	}

	protected static function genericIsValidID($TabName, $ID)
	{
		$IDName = S2S_TabName_IDName($TabName);
		$query = 'SELECT '.$IDName.' FROM '.$TabName.' WHERE '.$IDName.'='.$ID;
		if(!$result = mysqli_query(self::$mDB, $query)) {throw new Exception(mysqli_error(self::$mDB));}
		return ((mysqli_fetch_row($result))?(true):(false));
	}

	/*@}*/
}
?>