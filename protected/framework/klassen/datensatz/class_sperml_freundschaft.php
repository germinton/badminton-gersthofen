<?php
include_once(dirname(__FILE__).'/class_sperml.php');

/*******************************************************************************************************************//**
 * Repräsentation einer Freundschaftsspielergebnismeldung.
 * @ingroup grp_recordset
 **********************************************************************************************************************/
class CSpErMlFreundschaft extends CSpErMl
{
	/*****************************************************************************************************************//**
	 * @name Tabellenspalten
	 **************************************************************************************************************//*@{*/

	private $mAKlaGruppe;
	private $mSeite;
	private $mEigeneMannschaftNr;
	private $mBegegnungNr;
	private $mVereinID;
	private $mGegnerMannschaftNr;

	/*@}*/

	/*****************************************************************************************************************//**
	 * @name Magics
	 **************************************************************************************************************//*@{*/

	public function __construct($SpermlID = 0) {
		parent::__construct($SpermlID);
	}

	public function __toString()
	{
		if(!$this->getSpErMlID()) {return 'Keine Freundschaftsspielergebnismeldung';}
		return $this->getHeimMannschaftString().' - '.$this->getGastMannschaftString();
	}

	/*@}*/

	/*****************************************************************************************************************//**
	 * @name Setter
	 **************************************************************************************************************//*@{*/

	public function setInitVals()
	{
		parent::setInitVals();
		$this->mAKlaGruppe = 0;
		$this->mSeite = 0;
		$this->mEigeneMannschaftNr = null;
		$this->mBegegnungNr = 0;
		$this->mVereinID = 0;
		$this->mGegnerMannschaftNr = null;
	}

	final public function setAKlaGruppe($AKlaGruppe) {
		$this->mAKlaGruppe = (int)$AKlaGruppe;
	}

	final public function setSeite($Seite) {
		$this->mSeite = (int)$Seite;
	}

	final public function setEigeneMannschaftNr($MannschaftNr) {
		$this->mEigeneMannschaftNr = (($i = (int)$MannschaftNr)?($i):(null));
	}

	final public function setBegegnungNr($BegegnungNr) {
		$this->mBegegnungNr = (int)$BegegnungNr;
	}

	final public function setVereinID($VereinID) {
		$this->mVereinID = (int)$VereinID;
	}

	final public function setGegnerMannschaftNr($MannschaftNr) {
		$this->mGegnerMannschaftNr = (($i = (int)$MannschaftNr)?($i):(null));
	}

	/*@}*/

	/*****************************************************************************************************************//**
	 * @name Getter
	 **************************************************************************************************************//*@{*/

	final public function getAKlaGruppe()
	{
		return $this->mAKlaGruppe;
	}

	final public function getSeite()
	{
		return $this->mSeite;
	}

	final public function getEigeneMannschaftNr()
	{
		return $this->mEigeneMannschaftNr;
	}

	final public function getBegegnungNr()
	{
		return $this->mBegegnungNr;
	}

	final public function getVereinID($FlagVariant = array())
	{
		$FlagArray = (array)$FlagVariant;
		return ((in_array(GET_OFID, $FlagArray))?(new CVerein($this->mVereinID)):($this->mVereinID));
	}

	final public function getGegnerMannschaftNr()
	{
		return $this->mGegnerMannschaftNr;
	}

	/*@}*/

	/*****************************************************************************************************************//**
	 * @name Datenbank
	 **************************************************************************************************************//*@{*/

	public static function isValidID($SpErMlID) {
		return CDriveEntity::genericIsValidID('sperml_freundschaft', $SpErMlID);
	}

	public function load($SpErMlID)
	{
		self::setInitVals();
		CSpErMl::load($SpErMlID);
		$format = 'SELECT aklagruppe, seite, eigene_mannschaftnr, begegnungnr, verein_id, gegner_mannschaftnr '.
		          'FROM sperml_freundschaft WHERE sperml_id=%s';
		$query = sprintf($format, $this->getSpErMlID());
		if(!$result = mysql_query($query)) {throw new Exception(mysql_error(CDriveEntity::getDB()));}
		$row = mysql_fetch_row($result);
		if(!$row) {throw new Exception('Freundschaftsspielergebnismeldung mit sperml_id='.$SpErMlID.' nicht gefunden!');}
		$this->mAKlaGruppe = lD($row[0]);
		$this->mSeite = lD($row[1]);
		$this->mEigeneMannschaftNr = lD($row[2]);
		$this->mBegegnungNr = lD($row[3]);
		$this->mVereinID = lD($row[4]);
		$this->mGegnerMannschaftNr = lD($row[5]);
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
			$format = 'UPDATE sperml_punktspiel_extern SET '.
			          'aklagruppe=%s, seite=%s, eigene_mannschaftnr=%s, begegnungnr=%s, verein_id=%s, gegner_mannschaftnr=%s '.
			          'WHERE sperml_id=%s';
			$query = sprintf($format, sD($this->mAKlaGruppe), sD($this->mSeite), sD($this->mEigeneMannschaftNr),
			sD($this->mBegegnungNr), sD($this->mVereinID), sD($this->mGegnerMannschaftNr), $this->getID());
		}
		else
		{
			$format = 'INSERT INTO sperml_punktspiel_extern ('.
			          'aklagruppe, seite, eigene_mannschaftnr, begegnungnr, verein_id, gegner_mannschaftnr'.
			          ') VALUES (%s, %s, %s, %s, %s, %s)';
			$query = sprintf($format, sD($this->mAKlaGruppe), sD($this->mSeite), sD($this->mEigeneMannschaftNr),
			sD($this->mBegegnungNr), sD($this->mVereinID), sD($this->mGegnerMannschaftNr));
		}
		if(!$result = mysql_query($query)) {throw new Exception(mysql_error(CDriveEntity::getDB()));}
	}

	public function check($CheckForeignKey = true)
	{
		// Basisklasse
		parent::check();

		// AKlaGruppe
		if(is_null(C2S_AKlaGruppe($this->mAKlaGruppe))) {
			CDriveEntity::addCheckMsg('Die Altersklassengruppe ist ungültig.');
		}

		// Seite
		if(is_null(C2S_Seite($this->mSeite))) {
			CDriveEntity::addCheckMsg('Die Seite ist ungültig.');
		}

		// EigeneMannschaftNr
		if($this->mEigeneMannschaftNr < 1 or $this->mEigeneMannschaftNr > MAX_MANNSCHAFTEN) {
			CDriveEntity::addCheckMsg('Die eigene Mannschaftsnummer liegt nicht zwischen 1 und '.MAX_MANNSCHAFTEN.'.');
		}

		// BegegnungNr
		if($this->mBegegnungNr < 1 or $this->mBegegnungNr > MAX_BEGEGNUNGNR) {
			CDriveEntity::addCheckMsg('Die Begegnungsnummer liegt nicht zwischen 1 und '.MAX_BEGEGNUNGNR.'.');
		}

		// VereinID
		if(!CVerein::isValidID($this->mVereinID)) {
			CDriveEntity::addCheckMsg('Die verein_id ist ungültig.');
		}

		// GegnerMannschaftNr
		if($this->mGegnerMannschaftNr < 1 or $this->mGegnerMannschaftNr > MAX_MANNSCHAFTEN) {
			CDriveEntity::addCheckMsg('Die gegnerische Mannschaftsnummer liegt nicht zwischen 1 und '.MAX_MANNSCHAFTEN.'.');
		}
	}

	/*@}*/

	/*****************************************************************************************************************//**
	 * @name Verschiedenes
	 **************************************************************************************************************//*@{*/

	public function getHeimMannschaftString()
	{
		if(S_HEIM == $this->mSeite) {
			return 'TSV&nbsp;Gersthofen'.(($this->mEigeneMannschaftNr)?('&nbsp;'.$this->mEigeneMannschaftNr):(''));
		}
		else if(S_GAST == $this->mSeite) {
			return $this->getVereinID(GET_OFID).(($this->mGegnerMannschaftNr)?('&nbsp;'.$this->mGegnerMannschaftNr):(''));
		}
	}

	public function getGastMannschaftString()
	{

		if(S_GAST == $this->mSeite) {
			return 'TSV&nbsp;Gersthofen'.(($this->mEigeneMannschaftNr)?('&nbsp;'.$this->mEigeneMannschaftNr):(''));
		}
		else if(S_HEIM == $this->mSeite) {
			return $this->getVereinID(GET_OFID).(($this->mGegnerMannschaftNr)?('&nbsp;'.$this->mGegnerMannschaftNr):(''));
		}
	}

	public function getXHTML()
	{
		$filename = dirname(__FILE__).'/../../../inhalte/schnipsel/allgemein/sni_sperml.php';
		$Saison = 'Freundschaftsspiel';
		$Bezirk = 'Freundschaftsspiel';
		$Spielklasse = 'Freundschaftsspiel';
		$HVerein = $this->getHeimMannschaftString();
		$GVerein = $this->getGastMannschaftString();
		$SpErMl = $this;
		if(is_file($filename)) {
			ob_start();
			include $filename;
			$contents = ob_get_contents();
			ob_end_clean();
			return $contents;
		}
	}

	/*@}*/
}
?>