<?php
include_once(dirname(__FILE__).'/../datensatz/class_aufgabenzuordnung.php');

/*******************************************************************************************************************//**
 * Repräsentation eines Navigationspunktes.
 **********************************************************************************************************************/
class CNav
{

	private $mStage; ///< Stufe des Navigationspunktes
	private $mSecString; ///< Zeichenkette, die den Navigationspunkt eindeutig identifiziert ('index.php?section='-Wert)
	private $mNavText; ///< Text für die Beschriftung des Navigationspunkts in der Navigationsleiste
	private $mHasScript; ///< Dieser Navigationspunkt besitzt [kein] PHP-Modul zur Datenverarbeitung
	private $mAufgabeIDArray; ///< Navigationspunkt ist zugänglich für Athleten mit diesen Aufgaben
	private $mAthletIDArray; ///< Navigationspunkt ist (außerdem) zugänglich für diese Athleten

	private $mUpFlag = false; ///< Navigationspunkt liegt [nicht] auf einer höheren Stufe als sein Vorgänger
	private $mNbrOfDowns = 0; ///< Stufen, die dieser Navigationspunkt tiefer liegt als sein Vorgänger

	/*****************************************************************************************************************//**
	 * @name Magics
	 **************************************************************************************************************//*@{*/

	public function __construct($Stage, $SecString, $NavText,
	$HasScript = false, $AufgabeIDArray = array(), $AthletIDArray = array())
	{
		$this->mStage = $Stage;
		$this->mSecString = $SecString;
		$this->mNavText = $NavText;
		$this->mHasScript = $HasScript;
		$this->mAufgabeIDArray = $AufgabeIDArray;
		$this->mAthletIDArray = $AthletIDArray;

		$Aufgabenzuordnung = new CAufgabenzuordnung();
		$AthletIDArray = CAufgabenzuordnung::getAthletIDArray($this->mAufgabeIDArray);
		$this->mAthletIDArray = array_unique(array_merge($this->mAthletIDArray, $AthletIDArray));
	}

	/*@}*/

	/*****************************************************************************************************************//**
	 * @name Setter
	 **************************************************************************************************************//*@{*/

	public function resetStageFlags() {$this->mUpFlag = false; $this->mNbrOfDowns = 0;}
	public function setStageUp() {$this->mUpFlag = true;}
	public function setStagesDown($NbrOfDowns) {$this->mNbrOfDowns = $NbrOfDowns;}
	public function setAufgabeIDArray($AufgabeIDArray) {$this->mAufgabeIDArray = $AufgabeIDArray;}
	public function setAthletIDArray($AthletIDArray) {$this->mAthletIDArray = $AthletIDArray;}

	/*@}*/

	/*****************************************************************************************************************//**
	 * @name Getter
	 **************************************************************************************************************//*@{*/

	public function getStage() {return $this->mStage;}
	public function getSecString() {return $this->mSecString;}
	public function getNavText() {return $this->mNavText;}
	public function getHasScript() {return $this->mHasScript;}
	public function getAufgabeIDArray() {return $this->mAufgabeIDArray;}
	public function getAthletIDArray() {return $this->mAthletIDArray;}

	/*@}*/

	/*****************************************************************************************************************//**
	 * @name Verschiedenes
	 **************************************************************************************************************//*@{*/

	public function getStageUp() {return $this->mUpFlag;}
	public function getStagesDown() {return $this->mNbrOfDowns;}

	public function getXHTMLForLink()
	{
		if($this->mSecString == $_GET['section']) {
			return '<strong title="Hier befindest Du Dich gerade.">'.self::getNavText().'</strong>';
		}
		$HRefString = self::getHRefString();
		$OnClickEvent = (('http://'  == substr($HRefString, 0, 7))?(' '.STD_NEW_WINDOW):(''));
		return '<a href="'.$HRefString.'"'.$OnClickEvent.'>'.self::getNavText().'</a>';
	}

	public function getHRefString()
	{
		if('http://'  == substr($this->mSecString, 0, 7)) {return $this->mSecString;}
		if('startseite' == $this->mSecString) {return 'index.php';}
		return 'index.php?section='.$this->mSecString;
	}

	/*@}*/
}
?>