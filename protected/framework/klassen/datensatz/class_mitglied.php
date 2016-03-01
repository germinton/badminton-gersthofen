<?php
include_once(dirname(__FILE__).'/class_athlet.php');
include_once(dirname(__FILE__).'/class_mannschaft.php');

/*******************************************************************************************************************//**
 * Repräsentation eines Mitglieds.
 * @ingroup grp_recordset
 **********************************************************************************************************************/
class CMitglied extends CAthlet
{
	/*****************************************************************************************************************//**
	 * @name Tabellenspalten
	 **************************************************************************************************************//*@{*/

	private $mGeburtstag;
	private $mStrasse;
	private $mPLZ;
	private $mOrt;
	private $mTelPriv;
	private $mTelPriv2;
	private $mTelGesch;
	private $mFax;
	private $mTelMobil;
	private $mEMail;
	private $mWebsite;
	private $mAusblenden;
	private $mSpitzname;
	private $mBenutzername;
	private $mPasswort;
	private $mUeberSich;
	private $mBeruf;
	private $mNewsletter;
	private $mLastLogin;
	private $mLastUpdate;
	private $mPwAendern;
	private $mFreigabeWSite;
	private $mFreigabeFBook;
	private $mErzBerVorname;
	private $mErzBerNachame;
	private $mErzBerTelMobil;
	private $mErzBerEMail;

	/*@}*/

	/*****************************************************************************************************************//**
	 * @name Magics
	 **************************************************************************************************************//*@{*/

	public function __construct($AthletID = 0) {
		parent::__construct($AthletID);
	}

	public function __toString()
	{
		if(!$this->getAthletID()) {return 'Kein Mitglied';}
		if(is_string($this->mSpitzname)) {return $this->mSpitzname;}
		if(is_string(CAthlet::getVorname())) {return CAthlet::getVorname();}
		return CAthlet::getNachname();
	}

	/*@}*/

	/*****************************************************************************************************************//**
	 * @name Setter
	 **************************************************************************************************************//*@{*/

	public function setInitVals()
	{
		parent::setInitVals();
		$this->mGeburtstag = null;
		$this->mStrasse = null;
		$this->mPLZ = null;
		$this->mOrt = null;
		$this->mTelPriv = null;
		$this->mTelPriv2 = null;
		$this->mTelGesch = null;
		$this->mFax = null;
		$this->mTelMobil = null;
		$this->mEMail = null;
		$this->mWebsite = null;
		$this->mAusblenden = false;
		$this->mSpitzname = null;
		$this->mBenutzername = '';
		$this->mPasswort = '';
		$this->mUeberSich = null;
		$this->mBeruf = null;
		$this->mNewsletter = true;
		$this->mLastLogin = '';
		$this->mLastUpdate = '';
		$this->mPwAendern = false;
		$this->mFreigabeWSite = false;
		$this->mFreigabeFBook = false;
		$this->mErzBerVorname = null;
		$this->mErzBerNachname = null;
		$this->mErzBerTelMobil = null;
		$this->mErzBerEMail = null;
	}

	final public function setGeburtstag($Geburtstag) {
		$this->mGeburtstag = (($s = trim((string)$Geburtstag))?($s):(null));
	}

	final public function setStrasse($Strasse) {
		$this->mStrasse = (($s = htmlspecialchars(trim((string)$Strasse)))?($s):(null));
	}

	final public function setPLZ($PLZ) {
		$this->mPLZ = (($s = htmlspecialchars(trim((string)$PLZ)))?($s):(null));
	}

	final public function setOrt($Ort) {
		$this->mOrt = (($s = htmlspecialchars(trim((string)$Ort)))?($s):(null));
	}

	final public function setTelPriv($TelPriv) {
		$this->mTelPriv = (($s = htmlspecialchars(trim((string)$TelPriv)))?($s):(null));
	}

	final public function setTelPriv2($TelPriv2) {
		$this->mTelPriv2 = (($s = htmlspecialchars(trim((string)$TelPriv2)))?($s):(null));
	}

	final public function setTelGesch($TelGesch) {
		$this->mTelGesch = (($s = htmlspecialchars(trim((string)$TelGesch)))?($s):(null));
	}

	final public function setFax($Fax) {
		$this->mFax = (($s = htmlspecialchars(trim((string)$Fax)))?($s):(null));
	}

	final public function setTelMobil($TelMobil) {
		$this->mTelMobil = (($s = htmlspecialchars(trim((string)$TelMobil)))?($s):(null));
	}

	final public function setEMail($EMail) {
		$this->mEMail = (($s = htmlspecialchars(trim((string)$EMail)))?($s):(null));
	}

	final public function setWebsite($Website) {
		$this->mWebsite = (($s = htmlspecialchars(trim((string)$Website)))?($s):(null));
	}

	final public function setAusblenden($Ausblenden) {
		$this->mAusblenden = (($Ausblenden)?(1):(0));
	}

	final public function setSpitzname($Spitzname) {
		$this->mSpitzname = (($s = htmlspecialchars(trim((string)$Spitzname)))?($s):(null));
	}

	final public function setBenutzername($Benutzername) {
		$this->mBenutzername = htmlspecialchars(trim((string)$Benutzername));
	}

	final public function setPasswort($Passwort) {
		$this->mPasswort = (string)$Passwort;
		if($this->getPwAendern()) {$this->setPwAendern(false);}
	}

	final public function setUeberSich($UeberSich) {
		$this->mUeberSich = (($s = trim((string)$UeberSich))?($s):(null));
	}

	final public function setBeruf($Beruf) {
		$this->mBeruf = (($s = htmlspecialchars(trim((string)$Beruf)))?($s):(null));
	}

	final public function setNewsletter($Newsletter) {
		$this->mNewsletter = (($Newsletter)?(1):(0));
	}

	final public function setLastLogin($LastLogin) {
		$this->mLastLogin = (($s = trim((string)$LastLogin))?($s):(null));
	}

	final public function setLastUpdate($LastUpdate) {
		$this->mLastUpdate = (($s = trim((string)$LastUpdate))?($s):(null));
	}

	final public function setPwAendern($PwAendern) {
		$this->mPwAendern = (($PwAendern)?(1):(0));
	}

	final public function setFreigabeWSite($FreigabeWSite) {
		$this->mFreigabeWSite = (($FreigabeWSite)?(1):(0));
	}

	final public function setFreigabeFBook($FreigabeFBook) {
		$this->mFreigabeFBook = (($FreigabeFBook)?(1):(0));
	}

	final public function setErzBerVorname($ErzBerVorname) {
		$this->mErzBerVorname = (($s = htmlspecialchars(trim((string)$ErzBerVorname)))?($s):(null));
	}

	final public function setErzBerNachname($ErzBerNachname) {
		$this->mErzBerNachname = (($s = htmlspecialchars(trim((string)$ErzBerNachname)))?($s):(null));
	}

	final public function setErzBerTelMobil($ErzBerTelMobil) {
		$this->mErzBerTelMobil = (($s = htmlspecialchars(trim((string)$ErzBerTelMobil)))?($s):(null));
	}

	final public function setErzBerEMail($ErzBerEMail) {
		$this->mErzBerEMail = (($s = htmlspecialchars(trim((string)$ErzBerEMail)))?($s):(null));
	}

	/*@}*/

	/*****************************************************************************************************************//**
	 * @name Getter
	 **************************************************************************************************************//*@{*/

	final public function getGeburtstag($FlagVariant = array())
	{
		$FlagArray = (array)$FlagVariant;
		$Datum = ((in_array(GET_DTDE, $FlagArray))?(S2S_Datum_MySql2Deu($this->mGeburtstag)):($this->mGeburtstag));
		return ((is_null($v = $Datum) and in_array(GET_NBSP, $FlagArray))?('&nbsp;'):($v));
	}

	final public function getStrasse($FlagVariant = array())
	{
		$FlagArray = (array)$FlagVariant;
		return ((is_null($v = $this->mStrasse) and in_array(GET_NBSP, $FlagArray))?('&nbsp;'):($v));
	}

	final public function getPLZ($FlagVariant = array())
	{
		$FlagArray = (array)$FlagVariant;
		return ((is_null($v = $this->mPLZ) and in_array(GET_NBSP, $FlagArray))?('&nbsp;'):($v));
	}

	final public function getOrt($FlagVariant = array())
	{
		$FlagArray = (array)$FlagVariant;
		return ((is_null($v = $this->mOrt) and in_array(GET_NBSP, $FlagArray))?('&nbsp;'):($v));
	}

	final public function getTelPriv($FlagVariant = array())
	{
		$FlagArray = (array)$FlagVariant;
		return ((is_null($v = $this->mTelPriv) and in_array(GET_NBSP, $FlagArray))?('&nbsp;'):($v));
	}

	final public function getTelPriv2($FlagVariant = array())
	{
		$FlagArray = (array)$FlagVariant;
		return ((is_null($v = $this->mTelPriv2) and in_array(GET_NBSP, $FlagArray))?('&nbsp;'):($v));
	}

	final public function getTelGesch($FlagVariant = array())
	{
		$FlagArray = (array)$FlagVariant;
		return ((is_null($v = $this->mTelGesch) and in_array(GET_NBSP, $FlagArray))?('&nbsp;'):($v));
	}

	final public function getFax($FlagVariant = array())
	{
		$FlagArray = (array)$FlagVariant;
		return ((is_null($v = $this->mFax) and in_array(GET_NBSP, $FlagArray))?('&nbsp;'):($v));
	}

	final public function getTelMobil($FlagVariant = array())
	{
		$FlagArray = (array)$FlagVariant;
		return ((is_null($v = $this->mTelMobil) and in_array(GET_NBSP, $FlagArray))?('&nbsp;'):($v));
	}

	final public function getEMail($FlagVariant = array())
	{
		$FlagArray = (array)$FlagVariant;
		if(is_null($v = $this->mEMail) and in_array(GET_NBSP, $FlagArray)) {return '&nbsp;';}
		return ((in_array(GET_SPEC, $FlagArray))?($this->getMailToEMail($v)):($v));
	}

	final public function getWebsite($FlagVariant = array())
	{
		$FlagArray = (array)$FlagVariant;
		return ((is_null($v = $this->mWebsite) and in_array(GET_NBSP, $FlagArray))?('&nbsp;'):($v));
	}

	final public function getAusblenden($FlagVariant = array())
	{
		$FlagArray = (array)$FlagVariant;
		return ((in_array(GET_SPEC, $FlagArray))?(($this->mAusblenden)?('ja'):('nein')):(($this->mAusblenden)?(1):(0)));
	}

	final public function getSpitzname($FlagVariant = array())
	{
		$FlagArray = (array)$FlagVariant;
		return ((is_null($v = $this->mSpitzname) and in_array(GET_NBSP, $FlagArray))?('&nbsp;'):($v));
	}

	final public function getBenutzername()
	{
		return $this->mBenutzername;
	}

	final public function getPasswort()
	{
		return $this->mPasswort;
	}

	final public function getUeberSich($FlagVariant = array())
	{
		$FlagArray = (array)$FlagVariant;
		$UeberSich = ((in_array(GET_SPEC, $FlagArray))?(FormatXHTMLPermittedString($this->mUeberSich)):($this->mUeberSich));
		$UeberSich = ((in_array(GET_HSPC, $FlagArray))?(htmlspecialchars($UeberSich)):($UeberSich));
		return ((is_null($v = $UeberSich) and in_array(GET_NBSP, $FlagArray))?('&nbsp;'):($v));
	}

	final public function getBeruf($FlagVariant = array())
	{
		$FlagArray = (array)$FlagVariant;
		return ((is_null($v = $this->mBeruf) and in_array(GET_NBSP, $FlagArray))?('&nbsp;'):($v));
	}

	final public function getNewsletter($FlagVariant = array())
	{
		$FlagArray = (array)$FlagVariant;
		return ((in_array(GET_SPEC, $FlagArray))?(($this->mNewsletter)?('ja'):('nein')):(($this->mNewsletter)?(1):(0)));
	}

	final public function getLastLogin($FlagVariant = array())
	{
		$FlagArray = (array)$FlagVariant;
		$DatumZeit = ((in_array(GET_DTDE, $FlagArray))?(S2S_DatumZeit_MySql2Deu($this->mLastLogin)):($this->mLastLogin));
		return ((is_null($v = $DatumZeit) and in_array(GET_NBSP, $FlagArray))?('&nbsp;'):($v));
	}

	final public function getLastUpdate($FlagVariant = array())
	{
		$FlagArray = (array)$FlagVariant;
		$DatumZeit = ((in_array(GET_DTDE, $FlagArray))?(S2S_DatumZeit_MySql2Deu($this->mLastUpdate)):($this->mLastUpdate));
		return ((is_null($v = $DatumZeit) and in_array(GET_NBSP, $FlagArray))?('&nbsp;'):($v));
	}

	final public function getPwAendern($FlagVariant = array())
	{
		$FlagArray = (array)$FlagVariant;
		return ((in_array(GET_SPEC, $FlagArray))?(($this->mPwAendern)?('ja'):('nein')):(($this->mPwAendern)?(1):(0)));
	}

	final public function getFreigabeWSite($FlagVariant = array())
	{
		$FlagArray = (array)$FlagVariant;
		return ((in_array(GET_SPEC, $FlagArray))?(($this->mFreigabeWSite)?('ja'):('nein')):(($this->mFreigabeWSite)?(1):(0)));
	}

	final public function getFreigabeFBook($FlagVariant = array())
	{
		$FlagArray = (array)$FlagVariant;
		return ((in_array(GET_SPEC, $FlagArray))?(($this->mFreigabeFBook)?('ja'):('nein')):(($this->mFreigabeFBook)?(1):(0)));
	}

	final public function getErzBerVorname($FlagVariant = array())
	{
		$FlagArray = (array)$FlagVariant;
		return ((is_null($v = $this->mErzBerVorname) and in_array(GET_NBSP, $FlagArray))?('&nbsp;'):($v));
	}

	final public function getErzBerNachname($FlagVariant = array())
	{
		$FlagArray = (array)$FlagVariant;
		return ((is_null($v = $this->mErzBerNachname) and in_array(GET_NBSP, $FlagArray))?('&nbsp;'):($v));
	}

	final public function getErzBerTelMobil($FlagVariant = array())
	{
		$FlagArray = (array)$FlagVariant;
		return ((is_null($v = $this->mErzBerTelMobil) and in_array(GET_NBSP, $FlagArray))?('&nbsp;'):($v));
	}

	final public function getErzBerEMail($FlagVariant = array())
	{
		$FlagArray = (array)$FlagVariant;
		return ((is_null($v = $this->mErzBerEMail) and in_array(GET_NBSP, $FlagArray))?('&nbsp;'):($v));
	}

	/*@}*/

	/*****************************************************************************************************************//**
	 * @name Datenbank
	 **************************************************************************************************************//*@{*/

	public static function isValidID($AthletID) {
		return CDriveEntity::genericIsValidID('athleten_mitglieder', $AthletID);
	}

	public function load($AthletID)
	{
		self::setInitVals();
		CAthlet::load($AthletID);
		$format = 'SELECT geburtstag, strasse, plz, ort, tel_priv, tel_priv2, tel_gesch, fax, tel_mobil, email, website, '.
		                 'ausblenden, spitzname, benutzername, passwort, ueber_sich, beruf, newsletter, lastlogin, '.
		                 'lastupdate, pwaendern, freigabe_wsite, freigabe_fbook, erzber_vorname, erzber_nachname, '.
		                 'erzber_tel_mobil, erzber_email '.
		          'FROM athleten_mitglieder WHERE athlet_id=%s';
		$query = sprintf($format, $this->getAthletID());
		if(!$result = mysqli_query(CDriveEntity::getDB(), $query)) {throw new Exception(mysql_error(CDriveEntity::getDB()));}
		$row = mysqli_fetch_row($result);
		if(!$row) {throw new Exception('Mitglied mit athlet_id='.$AthletID.' nicht gefunden!');}
		$this->mGeburtstag = lS($row[0]);
		$this->mStrasse = lS($row[1]);
		$this->mPLZ = lS($row[2]);
		$this->mOrt = lS($row[3]);
		$this->mTelPriv = lS($row[4]);
		$this->mTelPriv2 = lS($row[5]);
		$this->mTelGesch = lS($row[6]);
		$this->mFax = lS($row[7]);
		$this->mTelMobil = lS($row[8]);
		$this->mEMail = lS($row[9]);
		$this->mWebsite = lS($row[10]);
		$this->mAusblenden = lB($row[11]);
		$this->mSpitzname = lS($row[12]);
		$this->mBenutzername = lS($row[13]);
		$this->mPasswort = lS($row[14]);
		$this->mUeberSich = lS($row[15]);
		$this->mBeruf = lS($row[16]);
		$this->mNewsletter = lB($row[17]);
		$this->mLastLogin = lS($row[18]);
		$this->mLastUpdate = lS($row[19]);
		$this->mPwAendern = lB($row[20]);
		$this->mFreigabeWSite = lB($row[21]);
		$this->mFreigabeFBook = lB($row[22]);
		$this->mErzBerVorname = lS($row[23]);
		$this->mErzBerNachname = lS($row[24]);
		$this->mErzBerTelMobil = lS($row[25]);
		$this->mErzBerEMail = lS($row[26]);
	}

	public function save()
	{
		$this->setLastUpdate(date('Y-m-d H:i:s'));
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
			$format = 'UPDATE athleten_mitglieder SET '.
			          'geburtstag=%s, strasse=%s, plz=%s, ort=%s, tel_priv=%s, tel_priv2=%s, tel_gesch=%s, fax=%s, '.
			          'tel_mobil=%s, email=%s, website=%s, ausblenden=%s, spitzname=%s, benutzername=%s, passwort=%s, '.
			          'ueber_sich=%s, beruf=%s, newsletter=%s, lastupdate=%s, pwaendern=%s, '.
					  'freigabe_wsite=%s, freigabe_fbook=%s, erzber_vorname=%s, erzber_nachname=%s, '.
			          'erzber_tel_mobil=%s, erzber_email=%s '.
			          'WHERE athlet_id=%s';
			$query = sprintf($format, sS($this->mGeburtstag), sS($this->mStrasse), sS($this->mPLZ), sS($this->mOrt),
			sS($this->mTelPriv), sS($this->mTelPriv2), sS($this->mTelGesch), sS($this->mFax), sS($this->mTelMobil),
			sS($this->mEMail), sS($this->mWebsite), sB($this->mAusblenden), sS($this->mSpitzname), sS($this->mBenutzername),
			sS($this->mPasswort), sS($this->mUeberSich), sS($this->mBeruf), sB($this->mNewsletter), sS($this->mLastUpdate),
			sB($this->mPwAendern), sB($this->mFreigabeWSite), sB($this->mFreigabeFBook),
			sS($this->mErzBerVorname), sS($this->mErzBerNachname), sS($this->mErzBerTelMobil),
			sS($this->mErzBerEMail), $this->getID());
		}
		else
		{
			$format = 'INSERT INTO athleten_mitglieder ('.
			          'athlet_id, geburtstag, strasse, plz, ort, tel_priv, tel_priv2, tel_gesch, fax, tel_mobil, email, '.
			          'website, ausblenden, spitzname, benutzername, passwort, ueber_sich, beruf, newsletter, lastupdate, '.
			          'pwaendern, freigabe_wsite, freigabe_fbook, erzber_vorname, erzber_nachname, erzber_tel_mobil, '.
			          'erzber_email) '.
					  'VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s)';
			$query = sprintf($format, $this->getID(), sS($this->mGeburtstag), sS($this->mStrasse), sS($this->mPLZ),
			sS($this->mOrt), sS($this->mTelPriv), sS($this->mTelPriv2), sS($this->mTelGesch), sS($this->mFax),
			sS($this->mTelMobil), sS($this->mEMail), sS($this->mWebsite), sB($this->mAusblenden), sS($this->mSpitzname),
			sS($this->mBenutzername), sS($this->mPasswort), sS($this->mUeberSich), sS($this->mBeruf), sB($this->mNewsletter),
			sS($this->mLastUpdate), sB($this->mPwAendern), sB($this->mFreigabeWSite), sB($this->mFreigabeFBook),
			sS($this->mErzBerVorname),sS($this->mErzBerNachname), sS($this->mErzBerTelMobil), sS($this->mErzBerEMail));
		}
		if(!$result = mysqli_query(CDriveEntity::getDB(), $query)) {throw new Exception(mysql_error(CDriveEntity::getDB()));}
	}

	public function check()
	{
		// Basisklasse
		parent::check();

		// Geburtstag
		if(!is_null($this->mGeburtstag))
		{
			if(!(preg_match(REGEX_DATE_SQ, $this->mGeburtstag)
			and preg_match(REGEX_DATE_DE, $this->getGeburtstag(GET_DTDE)))) {
				CDriveEntity::addCheckMsg('Das Geburtsdatum muss von der Form \'TT.MM.JJJJ\' sein.');
			}
			else if(!checkdate(
			substr($this->mGeburtstag, 5, 2), substr($this->mGeburtstag, 8, 2), substr($this->mGeburtstag, 0, 4))) {
				CDriveEntity::addCheckMsg('Das Geburtsdatum ist ungültig.');
			}
		}

		// Strasse
		if(!is_null($this->mStrasse))
		{
			if(strlen($this->mStrasse) > 50) {
				CDriveEntity::addCheckMsg('Der Straßenname darf nicht länger als 50 Zeichen sein.');
			}
		}

		// PLZ
		if(!is_null($this->mPLZ))
		{
			if(!preg_match(REGEX_PLZ, $this->mPLZ)) {
				CDriveEntity::addCheckMsg('Die Postleitzahl muss eine fünfstellige Zahl sein.');
			}
		}

		// Ort
		if(!is_null($this->mOrt))
		{
			if(strlen($this->mOrt) > 50) {
				CDriveEntity::addCheckMsg('Der Ortsname darf nicht länger als 50 Zeichen sein.');
			}
		}

		// Spitzname
		if(!is_null($this->mSpitzname))
		{
			if(strlen($this->mSpitzname) > 20) {
				CDriveEntity::addCheckMsg('Der Spitzname darf nicht länger als 20 Zeichen sein.');
			}
		}

		// Beruf
		if(!is_null($this->mBeruf))
		{
			if(strlen($this->mBeruf) > 30) {
				CDriveEntity::addCheckMsg('Der Beruf darf nicht länger als 30 Zeichen sein.');
			}
		}

		// TelPriv
		if(!is_null($this->mTelPriv))
		{
			if(strlen($this->mTelPriv) > 30) {
				CDriveEntity::addCheckMsg('Die Nummer für \'Telefon privat\' darf nicht länger als 30 Zeichen sein.');
			}
		}

		// TelPriv2
		if(!is_null($this->mTelPriv2))
		{
			if(strlen($this->mTelPriv2) > 30) {
				CDriveEntity::addCheckMsg('Die Nummer für \'Telefon privat 2\' darf nicht länger als 30 Zeichen sein.');
			}
		}

		// TelGesch
		if(!is_null($this->mTelGesch))
		{
			if(strlen($this->mTelGesch) > 30) {
				CDriveEntity::addCheckMsg('Die Nummer für \'Telefon geschäftl.\' darf nicht länger als 30 Zeichen sein.');
			}
		}

		// Fax
		if(!is_null($this->mFax))
		{
			if(strlen($this->mFax) > 30) {
				CDriveEntity::addCheckMsg('Die Faxnummer darf nicht länger als 30 Zeichen sein.');
			}
		}

		// TelMobil
		if(!is_null($this->mTelMobil)) {
			if(strlen($this->mTelMobil) > 30) {
				CDriveEntity::addCheckMsg('Die Mobiltelefonnummer darf nicht länger als 30 Zeichen sein.');
			}
		}

		// EMail
		if(!is_null($this->mEMail))
		{
			if(strlen($this->mEMail) > 50) {
				CDriveEntity::addCheckMsg('Die E-Mail-Adresse darf nicht länger als 50 Zeichen sein.');
			}
			else if(!preg_match(REGEX_EMAIL, $this->mEMail)) {
				CDriveEntity::addCheckMsg('Die E-Mail-Adresse ist von ungültiger Form.');
			}
		}

		// Website
		if(!is_null($this->mWebsite))
		{
			if(strlen($this->mWebsite) > 50) {
				CDriveEntity::addCheckMsg('Die Website-URL darf nicht länger als 50 Zeichen sein.');
			}
		}

		// UeberSich
		if(!is_null($this->mUeberSich))
		{
			if(!(strlen($this->mUeberSich) >= 1 and strlen($this->mUeberSich) <= 65535)) {
				CDriveEntity::addCheckMsg('Der "Über Dich"-Text muss mind. 1 bis max. 65535 Zeichen lang sein.');
			}
			else if(substr_count($this->mUeberSich, '{') != substr_count($this->mUeberSich, '}')) {
				CDriveEntity::addCheckMsg('Die Anzahl an sich öffnenden und sich schließenden geschw. Klammern ist ungleich.');
			}
		}

		// Benutzername
		if(!(strlen($this->mBenutzername) >= 3 and strlen($this->mBenutzername) <= 20)) {
			CDriveEntity::addCheckMsg('Der Benutzername muss mind. 3 bis max. 20 Zeichen lang sein.');
		}
		else if(!preg_match(REGEX_STDCHR, $this->mBenutzername)) {
			CDriveEntity::addCheckMsg('Der Benutzername enthält nicht unterstützte Zeichen.');
		}
		else
		{
			$query = 'SELECT athlet_id FROM athleten_mitglieder '.
			         'WHERE benutzername=\''.$this->mBenutzername.'\' AND athlet_id<>'.$this->getAthletID();
			if(!$result = mysqli_query(CDriveEntity::getDB(), $query)) {
				throw new Exception(mysql_error(CDriveEntity::getDB()));
			}
			if($row = mysqli_fetch_row($result)) {
				CDriveEntity::addCheckMsg('Dieser Benutzername wird bereits von einem anderen Mitglied verwendet.');
			}
		}

		// Passwort
		if(strlen($this->mPasswort) != 32) {
			CDriveEntity::addCheckMsg('Ein Passwort ist erforderlich.');
		}

		// LastUpdate
		if(!is_null($this->mLastUpdate))
		{
			if(!(preg_match(REGEX_DATETIME_SQ, $this->mLastUpdate)
			and preg_match(REGEX_DATETIME_DE, $this->getLastUpdate(GET_DTDE)))) {
				CDriveEntity::addCheckMsg('Das Datum des letzten Updates muss von der Form \'TT.MM.JJJJ HH:MM:SS\' sein.');
			}
			else if(!checkdate(
			substr($this->mLastUpdate, 5, 2), substr($this->mLastUpdate, 8, 2), substr($this->mLastUpdate, 0, 4))) {
				CDriveEntity::addCheckMsg('Das Datum des letzten Updates ist ungültig.');
			}
		}

		// ErzBerVorname
		if(!is_null($this->mErzBerVorname))
		{
			if(strlen($this->mErzBerVorname) > 30) {
				CDriveEntity::addCheckMsg('Der Vorname des Erziehungsberechtigten darf nicht länger als 30 Zeichen sein.');
			}
		}

		// ErzBerNachname
		if(!is_null($this->mErzBerNachname))
		{
			if(strlen($this->mErzBerNachname) > 30) {
				CDriveEntity::addCheckMsg('Der Nachname des Erziehungsberechtigten darf nicht länger als 30 Zeichen sein.');
			}
		}

		// ErzBerTelMobil
		if(!is_null($this->mErzBerTelMobil)) {
			if(strlen($this->mErzBerTelMobil) > 30) {
				CDriveEntity::addCheckMsg('Die Mobiltelefonnummer (Erziehungsberechtigter) darf nicht länger als 30 Zeichen sein.');
			}
		}

		// ErzBerEMail
		if(!is_null($this->mErzBerEMail))
		{
			if(strlen($this->mErzBerEMail) > 50) {
				CDriveEntity::addCheckMsg('Die E-Mail-Adresse (Erziehungsberechtigter) darf nicht länger als 50 Zeichen sein.');
			}
			else if(!preg_match(REGEX_EMAIL, $this->mErzBerEMail)) {
				CDriveEntity::addCheckMsg('Die E-Mail-Adresse (Erziehungsberechtigter) ist von ungültiger Form.');
			}
		}
	}

	/*@}*/

	/*****************************************************************************************************************//**
	 * @name Verschiedenes
	 **************************************************************************************************************//*@{*/

	public function updateLastLogin()
	{
		if(self::isValidID($this->getID()))
		{
			$this->setLastLogin(date('Y-m-d H:i:s'));
			$format = 'UPDATE athleten_mitglieder SET lastlogin=%s WHERE athlet_id=%s';
			$query = sprintf($format, sS($this->mLastLogin), $this->getID());
		}
		else {throw new Exeption('updateLastLogin() nicht möglich da athlet_id ungültig!');}
		if(!$result = mysqli_query(CDriveEntity::getDB(), $query)) {throw new Exception(mysql_error(CDriveEntity::getDB()));}
	}

	public function getMailToEMail($Name)
	{
		if(is_null($v = $this->mEMail)) {return $Name;}
		return '<a href="mailto:'.$v.'">'.$Name.'</a>';
	}

	public function getAlter($FlagVariant = array(), $Stichtag = null)
	{
		$FlagArray = (array)$FlagVariant;
		$query = 'SELECT (YEAR(p.stichtag)-YEAR(am.geburtstag)) - (RIGHT(p.stichtag,5)<RIGHT(am.geburtstag,5)) '.
		         'FROM athleten_mitglieder am, _parameter p WHERE am.athlet_id='.$this->getAthletID();
		if(!$result = mysqli_query(CDriveEntity::getDB(), $query)) {throw new Exception(mysql_error(CDriveEntity::getDB()));}
		$row = mysqli_fetch_row($result);
		if(!$row) {throw new Exception('Mitglied mit athlet_id='.$this->getAthletID().' nicht gefunden!');}
		return (($row[0])?((int)$row[0]):((in_array(GET_NBSP, $FlagArray))?('&nbsp;'):(null)));
	}

	public function getAltersklasse($FlagVariant = array(), $Stichtag = null)
	{
		$FlagArray = (array)$FlagVariant;
		$AKlasse = null;
		if($Alter = $this->getAlter())
		{
			$query = 'SELECT altersklasse '.
			         'FROM _lkup_altersklassen WHERE '.$Alter.' BETWEEN vonalter AND bisalter';
			if(!$result = mysqli_query(CDriveEntity::getDB(), $query)) {
				throw new Exception(mysql_error(CDriveEntity::getDB()));
			}
			$row = mysqli_fetch_row($result);
			$AKlasse = (int)$row[0];
		}
		if($AKlasse and in_array(GET_C2SC, $FlagArray)) {$AKlasse = C2S_Altersklasse($AKlasse);}
		return (($AKlasse)?($AKlasse):((in_array(GET_NBSP, $FlagArray))?('&nbsp;'):(null)));
	}

	public function getAKlaGruppe($FlagVariant = array(), $Stichtag = null)
	{
		$FlagArray = (array)$FlagVariant;
		$AKlaGruppe = null;
		if($AKlasse = $this->getAltersklasse())
		{
			$query = 'SELECT aklagruppe '.
			         'FROM _lkup_aklagruppen WHERE '.$AKlasse.' BETWEEN vonaklasse AND bisaklasse';
			if(!$result = mysqli_query(CDriveEntity::getDB(), $query)) {
				throw new Exception(mysql_error(CDriveEntity::getDB()));
			}
			$row = mysqli_fetch_row($result);
			$AKlaGruppe = (int)$row[0];
		}
		if($AKlaGruppe and in_array(GET_C2SC, $FlagArray)) {$AKlaGruppe = C2S_AKlaGruppe($AKlaGruppe);}
		return (($AKlaGruppe)?($AKlaGruppe):((in_array(GET_NBSP, $FlagArray))?('&nbsp;'):(null)));
	}

	public function getAufgabenstringArray()
	{
		$Aufgabenzuordnung = new CAufgabenzuordnung();
		$Aufgabe = new CAufgabe();
		$Mannschaft = new CMannschaft();
		$AufgabeIDArray = CAufgabenzuordnung::getAufgabeIDArray($this->getAthletID());
		foreach($AufgabeIDArray as $AufgabeID)
		{
			switch($AufgabeID)
			{
				case S_STAFFELLEITER:
					$Aufgabe->load(S_STAFFELLEITER);
					if     (S_HERR == CAthlet::getAnrede()) {$Aufgabenstring = $Aufgabe->getBezMaennlich();}
					else if(S_DAME == CAthlet::getAnrede()) {$Aufgabenstring = $Aufgabe->getBezWeiblich();}
					break;
				case S_MANNSCHAFTSFUEHRER:
					$Aufgabe->load(S_MANNSCHAFTSFUEHRER);
					$view = CDBConnection::getViewAufgabenzuordnungenUnionMF();
					$query = 'SELECT view.mannschaft_id FROM ('.$view.') view WHERE view.athlet_id='.$this->getAthletID();
					if(!$result = mysqli_query(CDriveEntity::getDB(), $query)) {
						throw new Exception(mysql_error(CDriveEntity::getDB()));
					}
					$row = mysqli_fetch_row($result);
					$Mannschaft->load($row[0]);
					if     (S_HERR == CAthlet::getAnrede()) {$Aufgabenstring = $Aufgabe->getBezMaennlich().' ('.$Mannschaft.')';}
					else if(S_DAME == CAthlet::getAnrede()) {$Aufgabenstring = $Aufgabe->getBezWeiblich().' ('.$Mannschaft.')';}
					break;
				default:
					$query = 'SELECT aufgabenzuordnung_id FROM aufgabenzuordnungen '.
					'WHERE athlet_id='.$this->getAthletID().' AND aufgabe_id='.$AufgabeID;
					if(!$result = mysqli_query(CDriveEntity::getDB(), $query)) {
						throw new Exception(mysql_error(CDriveEntity::getDB()));
					}
					$row = mysqli_fetch_row($result);
					$Aufgabenzuordnung->load($row[0]);
					$Aufgabenstring = $Aufgabenzuordnung->getAufgabenstring();
					break;
			}
			$AufgabenstringArray[] = $Aufgabenstring;
		}
		return ((isset($AufgabenstringArray))?($AufgabenstringArray):(array()));
	}

	public function getAufgabenstringArrayFormatted()
	{
		$Aufgabenzuordnung = new CAufgabenzuordnung();
		$Aufgabe = new CAufgabe();
		$Mannschaft = new CMannschaft();
		$AufgabeIDArray = CAufgabenzuordnung::getAufgabeIDArray($this->getAthletID());
		foreach($AufgabeIDArray as $AufgabeID)
		{
			switch($AufgabeID)
			{
				case S_STAFFELLEITER:
					$Aufgabe->load(S_STAFFELLEITER);
					if     (S_HERR == CAthlet::getAnrede()) {$Aufgabenstring = '<span style="font-weight: bold">'.$Aufgabe->getBezMaennlich().'</span>';}
					else if(S_DAME == CAthlet::getAnrede()) {$Aufgabenstring = '<span style="font-weight: bold">'.$Aufgabe->getBezWeiblich().'</span>';}
					break;
				case S_MANNSCHAFTSFUEHRER:
					$Aufgabe->load(S_MANNSCHAFTSFUEHRER);
					$view = CDBConnection::getViewAufgabenzuordnungenUnionMF();
					$query = 'SELECT view.mannschaft_id FROM ('.$view.') view WHERE view.athlet_id='.$this->getAthletID();
					if(!$result = mysqli_query(CDriveEntity::getDB(), $query)) {
						throw new Exception(mysql_error(CDriveEntity::getDB()));
					}
					$row = mysqli_fetch_row($result);
					$Mannschaft->load($row[0]);
					if     (S_HERR == CAthlet::getAnrede()) {$Aufgabenstring = '<span style="font-weight: bold">'.$Aufgabe->getBezMaennlich().'</span><br />('.$Mannschaft.')';}
					else if(S_DAME == CAthlet::getAnrede()) {$Aufgabenstring = '<span style="font-weight: bold">'.$Aufgabe->getBezWeiblich().'</span><br />('.$Mannschaft.')';}
					break;
				default:
					$query = 'SELECT aufgabenzuordnung_id FROM aufgabenzuordnungen '.
					'WHERE athlet_id='.$this->getAthletID().' AND aufgabe_id='.$AufgabeID;
					if(!$result = mysqli_query(CDriveEntity::getDB(), $query)) {
						throw new Exception(mysql_error(CDriveEntity::getDB()));
					}
					$row = mysqli_fetch_row($result);
					$Aufgabenzuordnung->load($row[0]);
					$Aufgabenstring = $Aufgabenzuordnung->getAufgabenstringFormatted();
					break;
			}
			$AufgabenstringArray[] = $Aufgabenstring;
		}
		return ((isset($AufgabenstringArray))?($AufgabenstringArray):(array()));
	}

	public static function Bn2Id($Benutzername)
	{
		$query = 'SELECT athlet_id FROM athleten_mitglieder WHERE benutzername=\''.$Benutzername.'\'';
		if(!$result = mysqli_query(CDriveEntity::getDB(), $query)) {throw new Exception(mysql_error(CDriveEntity::getDB()));}
		if(!$row = mysqli_fetch_row($result)) {
			throw new Exception('Mitglied mit Benutzername \''.$Benutzername.'\' nicht gefunden!');
		}
		return (int)$row[0];
	}

	public static function Id2Bn($AthletID)
	{
		$query = 'SELECT benutzername FROM athleten_mitglieder WHERE athlet_id='.$AthletID;
		if(!$result = mysqli_query(CDriveEntity::getDB(), $query)) {throw new Exception(mysql_error(CDriveEntity::getDB()));}
		if(!$row = mysqli_fetch_row($result)) {
			throw new Exception('Mitglied mit athlet_id='.$AthletID.' nicht gefunden!');
		}
		return (string)$row[0];
	}

	// Methoden 'statistic'

	public function statEinsaetze($String = 'AJS')
	{
		$query  = 'SELECT SUM(einsaetze) AS einsaetze FROM _rd_mitglieder_einsaetze ';
		$query_where = $this->statEinsaetzeQueryWhereString($String);
		$query .= 'WHERE athlet_id='.$this->getAthletID().((strlen($query_where))?(' AND '.$query_where):(''));
		if(!$result = mysqli_query(CDriveEntity::getDB(), $query)) {throw new Exception(mysql_error(CDriveEntity::getDB()));}
		if(!$row = mysqli_fetch_row($result)) {/* Abfragen mit Gruppierfunktionen liefern IMMER eine Ergebniszeile */;}
		return ((is_null($v = $row[0]))?(0):((int)$v));
	}

	public function statEinsaetzeDatum()
	{
		return S2S_Datum_MySql2Deu(CDBConnection::getInstance()->getRdDateMitgliederEinsaetze());
	}

	public function statEinsaetzePlatz($String = 'AJS', $BeachteGeschlecht = false)
	{
		$query  = 'SELECT me.athlet_id FROM _rd_mitglieder_einsaetze me';
		if($BeachteGeschlecht) {$query .= ' INNER JOIN athleten a ON me.athlet_id=a.athlet_id ';}
		$query_where = $this->statEinsaetzeQueryWhereString($String);
		if(strlen($query_where)) {$query .= ' WHERE '.$query_where;}
		if($BeachteGeschlecht) {$query .= (strlen($query_where)?(' AND '):(' WHERE ')).' a.anrede='.CAthlet::getAnrede();}
		$query .= ' GROUP BY athlet_id ORDER BY SUM(einsaetze) DESC';
		if(!$result = mysqli_query(CDriveEntity::getDB(), $query)) {throw new Exception(mysql_error(CDriveEntity::getDB()));}
		$Platz = 0;
		while($row = mysqli_fetch_row($result)) {$Platz++; if((int)$row[0] == $this->getAthletID()) {break;}}
		return $Platz;
	}

	private function statEinsaetzeQueryWhereString($String)
	{
		$String = ' '.$String;

		// Zuläsige Zeichen
		// A ... als Aktive(r)
		// J ... als Jugendliche(r)
		// S ... als Schüle(r)
		// E ... im Einzel
		// D ... im Doppel
		// M ... im Mixed
		// [1..9] ... in Mannnschaft [1..9]

		$query_where = array();

		// AKlaGruppe
		$query_where[0] = '';
		$query_where_or_parts = array();
		if(strpos($String, 'A')) {$query_where_or_parts[] = 'aklagruppe='.S_AKTIVE;}
		if(strpos($String, 'J')) {$query_where_or_parts[] = 'aklagruppe='.S_JUGEND;}
		if(strpos($String, 'S')) {$query_where_or_parts[] = 'aklagruppe='.S_SCHUELER;}
		foreach($query_where_or_parts as $i => $clause) {$query_where[0] .= ($i?' OR ':'').$clause;}
		if(strlen($query_where[0])) {$query_where[0] = '('.$query_where[0].')';}

		// Spielart
		$query_where[1] = '';
		$query_where_or_parts = array();
		if(strpos($String, 'E')) {$query_where_or_parts[] = 'spielart='.S_EINZEL;}
		if(strpos($String, 'D')) {$query_where_or_parts[] = 'spielart='.S_DOPPEL;}
		if(strpos($String, 'M')) {$query_where_or_parts[] = 'spielart='.S_MIXED;}
		foreach($query_where_or_parts as $i => $clause) {$query_where[1] .= ($i?' OR ':'').$clause;}
		if(strlen($query_where[1])) {$query_where[1] = '('.$query_where[1].')';}

		// Mannschaft
		$query_where[2] = '';
		$query_where_or_parts = array();
		for($i=1; $i<10; $i++) {if(strpos($String, (string)$i)) {$query_where_or_parts[] = 'nr='.$i;}}
		foreach($query_where_or_parts as $i => $clause) {$query_where[2] .= (($i)?(' OR '):('')).$clause;}
		if(strlen($query_where[2])) {$query_where[2] = '('.$query_where[2].')';}

		$returnstring = '';
		foreach($query_where as $clause) {
			if($clause) {$returnstring .= ((strlen($returnstring))?(' AND '):('')).$clause;}
		}
		return $returnstring;
	}

	/*@}*/
}
?>