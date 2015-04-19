<?php
/*******************************************************************************************************************//**
 * Klasse für den Datentransport vom Modul zum Inhalt.
 **********************************************************************************************************************/
class CTemplateData
{

	private $mData; ///< Array mit Daten
	private $mSimpleEcho; ///< Das Array enthält ein String-Element mit Index 'xhtml', das einfach ausgegeben werden soll

	/*****************************************************************************************************************//**
	 * @name Magics
	 **************************************************************************************************************//*@{*/

	public function __construct($Data = null, $SimpleEcho = false)
	{
		$this->mData = $Data;
		$this->mSimpleEcho = $SimpleEcho;
	}

	/*@}*/

	/*****************************************************************************************************************//**
	 * @name Verschiedenes
	 **************************************************************************************************************//*@{*/

	public function getData() {return $this->mData;}
	public function justSimpleEcho() {return $this->mSimpleEcho;}

	/*@}*/
}
?>