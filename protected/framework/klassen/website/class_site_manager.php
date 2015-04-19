<?php
include_once(dirname(__FILE__).'/../datensatz/class_mitglied.php');

/*******************************************************************************************************************//**
 * 'Ein-Instanz'-Klasse zur Ablaufsteuerung des Seitenaufbaus.
 **********************************************************************************************************************/
class CSiteManager
{

	private static $mInstance; ///< Die eine, einzige Instanz der Klasse

	const mcNavGlbUntilStage = 1; ///< Die (teilweise redundante) Nebennavigation wird ab dieser Stufe angezeigt
	const mcNavPubUntilStage = 2; ///< Die (teilweise redundante) Nebennavigation wird ab dieser Stufe angezeigt
	const mcNavIntUntilStage = 2; ///< Die (teilweise redundante) Nebennavigation wird ab dieser Stufe angezeigt

	const mcSecondaryNavFirstStage = 1; ///< Die (teilweise redundante) Nebennavigation wird ab dieser Stufe angezeigt

	private $mNavContGlb; ///< Objekt der Klasse CNavCont für die 'globale' Navigaitionsleiste
	private $mNavContPub; ///< Objekt der Klasse CNavCont für die 'öffentliche' Navigaitionsleiste
	private $mNavContInt; ///< Objekt der Klasse CNavCont für die 'interne' Navigaitionsleiste

	private $mMitglied; ///< Objekt der Klasse CMitglied für das akutell eingeloggte Mitglied

	/*****************************************************************************************************************//**
	 * @name Magics
	 **************************************************************************************************************//*@{*/

	private function __construct($NavContGlb, $NavContPub, $NavContInt)
	{
		$this->mNavContGlb = $NavContGlb;
		$this->mNavContPub = $NavContPub;
		$this->mNavContInt = $NavContInt;
		$this->mMitglied = null;
	}

	public function __clone() {trigger_error('\'clone\' ist nicht erlaubt.', E_USER_ERROR);}

	/*@}*/

	/*****************************************************************************************************************//**
	 * @name Getter
	 **************************************************************************************************************//*@{*/

	public static function getInstance($NavContGlb = null, $NavContPub = null, $NavContInt = null)
	{
		if(!isset(self::$mInstance))
		{
			if(is_null($NavContGlb) or is_null($NavContPub) or is_null($NavContInt)) {
				throw new Exception('!isset(self::$mInstance) and is_null($NavContXXX)');
			}
			self::$mInstance = new CSiteManager($NavContGlb, $NavContPub, $NavContInt);
		}
		return self::$mInstance;
	}

	public function getMitglied() {return $this->mMitglied;}
	public function getNavContGlb() {return $this->mNavContGlb;}
	public function getNavContPub() {return $this->mNavContPub;}
	public function getNavContInt() {return $this->mNavContInt;}

	/*@}*/

	/*****************************************************************************************************************//**
	 * @name Verschiedenes
	 **************************************************************************************************************//*@{*/

	public static function getMode()
	{
		if('POST' == $_SERVER['REQUEST_METHOD'])
		{
			if     (isset($_POST['new']))    {return MODE_NEW;}
			else if(isset($_POST['edit']))   {return MODE_EDIT;}
			else if(isset($_POST['drop']))   {return MODE_DROP;}
			else if(isset($_POST['save']))   {return MODE_SAVE;}
			else if(isset($_POST['cancel'])) {return MODE_CANCEL;}
		}
		return MODE_OVERVIEW;
	}

	public static function runOnEveryPageRefresh()
	{
		//CDBConnection::getInstance()->deleteElapsedNeuigkeiten();
		//CDBConnection::getInstance()->deleteElapsedTermineAllg();
		CDBConnection::getInstance()->deleteElapsedTerminePSB();
	}

	/*@}*/

	/*****************************************************************************************************************//**
	 * @name Login/Logout-Handler
	 **************************************************************************************************************//*@{*/

	public function processLogin()
	{
		try
		{
			if('POST' == $_SERVER['REQUEST_METHOD'] and isset($_POST['login'])) {
				self::loginMitglied(true);
			}
			else if('POST' == $_SERVER['REQUEST_METHOD'] and isset($_POST['logout'])) {
				self::logoutMitglied();
			}
			else
			{
				try {
					self::loginMitglied();
				}
				catch(CShowError $se)
				{
					if('Fehlende Cookie-Information(en)!' != $se->getMessage()) {
						throw $se;
					}
				}
			}
		}
		catch(Exception $e)
		{
			$this->mNavContInt->filter($this->mMitglied);
			throw $e;
		}
		$this->mNavContInt->filter($this->mMitglied);
	}

	private function loginMitglied($loginByForm = false)
	{
		if($loginByForm)
		{
			if(!isset($_POST['benutzername'], $_POST['passwort'], $_POST['login'])) {
				throw new CShowError('Bitte benutze nur das Login-Formular auf der Homepage.');
			}
			if(('' == $benutzername = trim($_POST['benutzername'])) or ('' == $passwort = trim($_POST['passwort']))) {
				throw new CShowError('Bitte fülle das Formular vollständig aus.');
			}
		}
		else // 'loginByCookie'
		{
			if(!isset($_COOKIE['Benutzername'], $_COOKIE['Passwort'])) {
				throw new CShowError('Fehlende Cookie-Information(en)!');
			}
			if(('' == $benutzername = trim($_COOKIE['Benutzername'])) or ('' == $passwort = trim($_COOKIE['Passwort']))) {
				throw new CShowError('Leere Cookie-Information(en)!');
			}
		}

		try
		{
			$this->mMitglied = new CMitglied(CMitglied::Bn2Id($benutzername));
		}
		catch(Exception $e)
		{
			$this->mMitglied = null;
			if($e->getMessage() == 'Mitglied mit Benutzername \''.$benutzername.'\' nicht gefunden!') {
				throw new CShowError('Benutzername oder Passwort falsch!');
			}
			throw new Exception($e->getMessage());
		}

		if($loginByForm) {$passwort = md5($passwort);}

		if($this->mMitglied->getPasswort() != $passwort)
		{
			$this->mMitglied = null;
			throw new CShowError('Benutzername oder Passwort falsch!');
		}

		$this->mMitglied->updateLastLogin();

		if($loginByForm)
		{
			setcookie('Benutzername', $this->mMitglied->getBenutzername(), strtotime("+1 month"));
			setcookie('Passwort', $this->mMitglied->getPasswort(), strtotime("+1 month"));
			$_COOKIE['Benutzername'] = $this->mMitglied->getBenutzername(); // fake-cookie setzen
			$_COOKIE['Passwort'] = $this->mMitglied->getPasswort(); // fake-cookie setzen
		}
	}

	private function logoutMitglied()
	{
		setcookie('Benutzername', '', strtotime('-1 day'));
		setcookie('Passwort', '', strtotime('-1 day'));
		unset($_COOKIE['Benutzername']);
		unset($_COOKIE['Passwort']);
		$this->mMitglied = null;
		throw new CShowInfo('Du hast Dich erfolgreich ausgeloggt!', 'index.php');
	}

	/*@}*/

	/*****************************************************************************************************************//**
	 * @name 'Nav'-Getter
	 **************************************************************************************************************//*@{*/

	public function getTemplateDataForSecRequest()
	{
		if(!($NavCont = self::getNavContForSecRequest())) {
			throw new CShowError("Ungültige Seite oder Zugriff verweigert!");
		}
		$Nav = $NavCont->getNavForSecString($_GET['section']);
		if(!$Nav->getHasScript()) {
			return new CTemplateData();
		}
		$Filename = 'protected/module/mod_'.$Nav->getSecString().'.php';
		if(!file_exists($Filename)) {
			throw new CShowError('Diese Funktionalität ist noch nicht implementiert.');
		}
		return include $Filename;
	}

	public function getNavContForSecString($SecString)
	{
		if($this->mNavContGlb->getNavForSecString($SecString)) {return $this->mNavContGlb;}
		if($this->mNavContPub->getNavForSecString($SecString)) {return $this->mNavContPub;}
		if($this->mNavContInt->getNavForSecString($SecString)) {return $this->mNavContInt;}
	}

	public function getNavForSecString($SecString)
	{
		$NavCont = self::getNavContForSecString($SecString);
		if(!($NavCont instanceof CNavCont)) {return null;}
		return $NavCont->getNavForSecString($SecString);
	}

	public function getNavContForSecRequest() {return self::getNavContForSecString($_GET['section']);}

	public function getNavForSecRequest() {return self::getNavForSecString($_GET['section']);}

	public function getSubNavArrayForSecRequest()
	{
		$NavCont = self::getNavContForSecRequest();
		if(!($NavCont instanceof CNavCont)) {return array();}
		return $NavCont->getSubNavArrayForSecString($_GET['section']);
	}

	/*@}*/

	/*****************************************************************************************************************//**
	 * @name 'XHTML'-Getter
	 **************************************************************************************************************//*@{*/

	public function getXHTMLForNavGlb()
	{
		return $this->mNavContGlb->getXHTMLForPrimaryNav(self::mcNavGlbUntilStage);
	}

	public function getXHTMLForNavPub()
	{
		return $this->mNavContPub->getXHTMLForPrimaryNav(self::mcNavPubUntilStage);
	}

	public function getXHTMLForNavInt()
	{
		if($this->mNavContInt->getCount()) {
			return $this->mNavContInt->getXHTMLForPrimaryNav(self::mcNavIntUntilStage);
		}
	}

	public function getXHTMLForNavCnt()
	{
		if($NavCont = self::getNavContForSecRequest())
		{
			if($NavCont->getNavForSecString($_GET['section'])->getStage() >= self::mcSecondaryNavFirstStage) {
				return self::getNavContForSecRequest()->getXHTMLForSecondaryNav($_GET['section']);
			}
		}
	}

	/*@}*/
}
?>