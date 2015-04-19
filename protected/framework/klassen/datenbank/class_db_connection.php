<?php
include_once(dirname(__FILE__).'/../../konstanten/const__all.php');
include_once(dirname(__FILE__).'/../datensatz/class_mitglied.php');

/*******************************************************************************************************************//**
 * 'Ein-Instanz'-Klasse, die die Verbindung zur MySQL-Datenbank repräsentiert.
 **********************************************************************************************************************/
class CDBConnection
{

	private static $mInstance; ///< Die eine, einzige Instanz der Klasse
	private static $mDB; ///< Der MySQL-Identifier
	
	const mcHost = 'localhost'; ///< Host-Bezeichner
	const mcUser = 'root'; ///< DB-Benutzername
	const mcPwd = 'root'; ///< DB-Passwort
	const mcDBName = 'drive_nt'; ///< Name der Datenbank
	
	/*****************************************************************************************************************//**
	 * @name Magics
	 **************************************************************************************************************//*@{*/

	private function __construct()
	{
		if(!self::$mDB = @mysql_connect(self::mcHost, self::mcUser, self::mcPwd)) {throw new Exception(mysql_error());}
		if(!mysql_select_db(self::mcDBName)) {throw new Exception(mysql_error(self::$mDB));}
		if(!$result = mysql_query('SET CHARACTER SET utf8', self::$mDB)) {throw new Exception(mysql_error(self::$mDB));}
		$this->setStichtag();
	}

	public function __clone() {trigger_error('\'clone\' ist nicht erlaubt.', E_USER_ERROR);}

	/*@}*/

	/*****************************************************************************************************************//**
	 * @name Getter
	 **************************************************************************************************************//*@{*/

	public static function getInstance()
	{
		if(!isset(self::$mInstance)) {self::$mInstance = new CDBConnection();}
		return self::$mInstance;
	}

	public static function getDB()
	{
		if(!isset(self::$mInstance)) {self::$mInstance = new CDBConnection();}
		return self::$mDB;
	}

	/*@}*/

	/*****************************************************************************************************************//**
	 * @name Setter 'ausgelagerter' Member
	 **************************************************************************************************************//*@{*/

	public function setStichtag($Stichtag = null)
	{
		if(!($Stichtag instanceof DateTime)) {$Stichtag = new DateTime();}
		$query = 'UPDATE _parameter SET stichtag=\''.$Stichtag->format('Y-m-d').'\'';
		if(!$result = mysql_query($query, self::$mDB)) {throw new Exception(mysql_error(self::$mDB));}
	}

	public function setSaisonID($SaisonID)
	{
		$query = 'UPDATE _parameter SET saison_id='.$SaisonID;
		if(!$result = mysql_query($query, self::$mDB)) {throw new Exception(mysql_error(self::$mDB));}
	}

	public function setSaisonIDByDate($Datum = null)
	{
		$query = 'UPDATE _parameter SET saison_id='.$this->getSaisonIDForDatum($Datum);
		if(!$result = mysql_query($query, self::$mDB)) {throw new Exception(mysql_error(self::$mDB));}
	}

	public function setRdDateMitgliederEinsaetze($Datum = null)
	{
		if(!($Datum instanceof DateTime)) {$Datum = new DateTime();}
		$query = 'UPDATE _parameter SET rddate_mitglieder_einsaetze=\''.$Datum->format('Y-m-d').'\'';
		if(!$result = mysql_query($query, self::$mDB)) {throw new Exception(mysql_error(self::$mDB));}
	}

	public function setAthLock($AthLock = false)
	{
		$query = 'UPDATE _parameter SET ath_lock='.(($AthLock)?(1):(0));
		if(!$result = mysql_query($query, self::$mDB)) {throw new Exception(mysql_error(self::$mDB));}
	}

	/*@}*/

	/*****************************************************************************************************************//**
	 * @name Getter 'ausgelagerter' Member
	 **************************************************************************************************************//*@{*/

	public function getStichtag()
	{
		$query = 'SELECT stichtag FROM _parameter';
		if(!$result = mysql_query($query, self::$mDB)) {throw new Exception(mysql_error(self::$mDB));}
		return (($row = mysql_fetch_row($result))?($row[0]):(null));
	}

	public function getSaisonID($FlagVariant = array())
	{
		$FlagArray = (array)$FlagVariant;
		$query = 'SELECT saison_id FROM _parameter';
		if(!$result = mysql_query($query, self::$mDB)) {throw new Exception(mysql_error(self::$mDB));}
		$row = mysql_fetch_row($result);
		return ((in_array(GET_OFID, $FlagArray))?(new CSaison($row[0])):((int)$row[0]));
	}

	public function getRdDateMitgliederEinsaetze()
	{
		$query = 'SELECT rddate_mitglieder_einsaetze FROM _parameter';
		if(!$result = mysql_query($query, self::$mDB)) {throw new Exception(mysql_error(self::$mDB));}
		return (($row = mysql_fetch_row($result))?($row[0]):(null));
	}

	public function getAthLock()
	{
		$query = 'SELECT ath_lock FROM _parameter';
		if(!$result = mysql_query($query, self::$mDB)) {throw new Exception(mysql_error(self::$mDB));}
		return (($row = mysql_fetch_row($result))?(($row[0])?(true):(false)):(null));
	}

	/*@}*/

	/*****************************************************************************************************************//**
	 * @name Verschiedenes
	 **************************************************************************************************************//*@{*/

	public function getSaisonIDForDatum($Datum = null)
	{
		if(!($Datum instanceof DateTime)) {$Datum = new DateTime();}
		$query = 'SELECT saison_id FROM saisons WHERE \''.$Datum->format('Y-m-d').'\' BETWEEN beginn AND ende';
		if(!$result = mysql_query($query, self::$mDB)) {throw new Exception(mysql_error(self::$mDB));}
		return (($row = mysql_fetch_row($result))?((int)$row[0]):(0));
	}

	public function getTableComment($Tabellenname)
	{
		$query = 'SHOW CREATE TABLE `'.$Tabellenname.'`';
		if($result = mysql_query($query, self::$mDB))
		{
			$row = mysql_fetch_row($result);
			$pos = strpos($row[1], 'COMMENT=');
			if($pos)
			{
				$Kommentar = substr($row[1], $pos + 8);
				$Kommentar = substr($Kommentar, 1, strlen($Kommentar)-2);
				return $Kommentar;
			}
			return 'Tabellenkommentar nicht gefunden';
		}
		return 'Tabelle nicht gefunden';
	}

	public function updateRdTabEinsatzstatistik()
	{
		mysql_query('DELETE FROM _rd_mitglieder_einsaetze', self::$mDB);

		$AthletID = 0; $Einsaetze = 0; $AKlaGruppe = 0; $Nr = 0; $Spielart = 0;

		$query = 'SELECT athlet_id, einsaetze, aklagruppe, nr, spielart FROM _v2_mitglieder_einsaetze';

		if(!$result = mysql_query($query, self::$mDB)) {throw new Exception(mysql_error(self::$mDB));}

		while($row = mysql_fetch_row($result))
		{
			$AthletID = (int)$row[0];
			$Einsaetze = (int)$row[1];
			$AKlaGruppe = (int)$row[2];
			$Nr = (int)$row[3];
			$Spielart = (int)$row[4];

			mysql_query('INSERT INTO _rd_mitglieder_einsaetze (athlet_id, einsaetze, aklagruppe, nr, spielart) '.
		              'VALUES ('.$AthletID.','.$Einsaetze.','.$AKlaGruppe.','.$Nr.','.$Spielart.')');
		}

		$this->setRdDateMitgliederEinsaetze();

		return 'Tabelle \'_rd_mitglieder_einsaetze\' wurde gelöscht und neu erzeugt.';
	}

	/*@}*/

	/*****************************************************************************************************************//**
	 * @name PHP-gespeicherte Views
	 **************************************************************************************************************//*@{*/

	public static function getViewAufgabenzuordnungenUnionMF()
	{
		$view_aufgabenzuordnungen_union_mf =
			'SELECT aufst.athlet_id, '.S_MANNSCHAFTSFUEHRER.' AS aufgabe_id, auf.sortierung, aufst.mannschaft_id '.
			'FROM (mannschaften m INNER JOIN aufstellungen aufst ON m.mannschaft_id=aufst.mannschaft_id), '.
				'aufgaben auf, _parameter p '.
			'WHERE m.saison_id=p.saison_id AND auf.aufgabe_id='.S_MANNSCHAFTSFUEHRER.' GROUP BY athlet_id';
		return $view_aufgabenzuordnungen_union_mf;
	}

	public static function getViewAufgabenzuordnungen()
	{
		$view_aufgabenzuordnungen =
			'SELECT az.athlet_id, az.aufgabe_id, auf.sortierung '.
				'FROM aufgabenzuordnungen az INNER JOIN aufgaben auf ON az.aufgabe_id=auf.aufgabe_id '.
		'UNION ALL '.
			'SELECT aufst.athlet_id, '.S_MANNSCHAFTSFUEHRER.' AS aufgabe_id, auf.sortierung '.
				'FROM (mannschaften m INNER JOIN aufstellungen aufst '.
					'ON m.mannschaft_id=aufst.mannschaft_id), aufgaben auf, _parameter p '.
				'WHERE m.saison_id=p.saison_id AND auf.aufgabe_id='.S_MANNSCHAFTSFUEHRER.' GROUP BY athlet_id '.
		'UNION ALL '.
			'SELECT t.athlet_id, '.S_STAFFELLEITER.' AS aufgabe_id, auf.sortierung '.
				'FROM tabellen t, aufgaben auf, _parameter p '.
				'WHERE t.athlet_id IS NOT NULL AND t.saison_id=p.saison_id AND auf.aufgabe_id='.S_STAFFELLEITER.' '.
		'ORDER BY sortierung DESC';
		return $view_aufgabenzuordnungen;
	}

	/*@}*/

	/*****************************************************************************************************************//**
	 * @name Aufräumer
	 **************************************************************************************************************//*@{*/

	public function cleanupMitglieder()
	{
		$query = 'SELECT athlet_id FROM athleten_mitglieder';
		if(!$result = mysql_query($query, self::$mDB)) {throw new Exception(mysql_error(self::$mDB));}
		$Mitglied = new CMitglied();
		while($row = mysql_fetch_row($result))
		{
			$Mitglied->load((int)$row[0]);
			if(!strlen(trim($Mitglied->getStrasse()))) {$Mitglied->setStrasse(null);}
			if(!strlen(trim($Mitglied->getPLZ()))) {$Mitglied->setPLZ(null);}
			if(!strlen(trim($Mitglied->getOrt()))) {$Mitglied->setOrt(null);}
			if(!strlen(trim($Mitglied->getTelPriv()))) {$Mitglied->setTelPriv(null);}
			if(!strlen(trim($Mitglied->getTelPriv2()))) {$Mitglied->setTelPriv2(null);}
			if(!strlen(trim($Mitglied->getTelGesch()))) {$Mitglied->setTelGesch(null);}
			if(!strlen(trim($Mitglied->getFax()))) {$Mitglied->setFax(null);}
			if(!strlen(trim($Mitglied->getTelMobil()))) {$Mitglied->setTelMobil(null);}
			if(!strlen(trim($Mitglied->getEMail()))) {$Mitglied->setEMail(null);}
			if(!strlen(trim($Mitglied->getWebsite()))) {$Mitglied->setWebsite(null);}
			if(!strlen(trim($Mitglied->getSpitzname()))) {$Mitglied->setSpitzname(null);}
			$Mitglied->save();
		}
		return 'Leere Zeichenketten in der Tabelle \'athleten_mitglieder\' wurden durch NULL-Werte ersetzt.';
	}

	public function deleteElapsedNeuigkeiten($Wochen = MAX_WOCHEN_NEUIGKEITEN)
	{
		$query = 'SELECT neuigkeit_id FROM neuigkeiten WHERE gueltigbis < DATE_SUB(NOW(), INTERVAL '.$Wochen.' WEEK)';
		if(!$result = mysql_query($query, self::$mDB)) {throw new Exception(mysql_error(self::$mDB));}
		while($row = mysql_fetch_row($result)) {
			$Neuigkeit = new CNeuigkeit($row[0]);
			$Neuigkeit->delete();
		}
		return 'Neuigkeiten älter als '.$Wochen.' Wochen wurden gelöscht.';
	}

	public function deleteElapsedTermineAllg($Wochen = MAX_WOCHEN_TERMINEALLG)
	{
		$query = 'SELECT t.termin_id FROM termine t INNER JOIN termine_allgemein ta ON t.termin_id=ta.termin_id '.
		         'WHERE t.datum < DATE_SUB(NOW(), INTERVAL '.$Wochen.' WEEK)';
		if(!$result = mysql_query($query, self::$mDB)) {throw new Exception(mysql_error(self::$mDB));}
		while($row = mysql_fetch_row($result)) {
			$TerminAllg = new CTerminAllg($row[0]);
			$TerminAllg->delete();
		}
		return 'Allgemeine Termine älter als '.$Wochen.' Wochen wurden gelöscht.';
	}

	public function deleteElapsedTerminePSB($Wochen = MAX_WOCHEN_TERMINEPSB)
	{
		$query = 'SELECT t.termin_id FROM termine t INNER JOIN termine_pktspbeg tp ON t.termin_id=tp.termin_id '.
		         'WHERE t.datum < DATE_SUB(NOW(), INTERVAL '.$Wochen.' WEEK)';
		if(!$result = mysql_query($query, self::$mDB)) {throw new Exception(mysql_error(self::$mDB));}
		while($row = mysql_fetch_row($result)) {
			$TerminPSB = new CTerminPSB($row[0]);
			$TerminPSB->delete();
		}
		return 'Termine für Punktspielbegegnungen älter als '.$Wochen.' Wochen wurden gelöscht.';
	}

	/*@}*/
}
?>