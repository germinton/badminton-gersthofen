<?php
include_once(dirname(__FILE__).'/class_show_exception.php');

/*******************************************************************************************************************//**
 * Exception, die im Falle einer fehlgeschlagenen Datenprüfung geworfen wird.
 **********************************************************************************************************************/
class CShowCheckMsg extends CShowException
{

	private $mCheckMsg; ///< Array mit Datenprüfungsmeldungen

	/*****************************************************************************************************************//**
	 * @name Magics
	 **************************************************************************************************************//*@{*/

	public function __construct($CheckMsg)
	{
		parent::__construct('Datenprüfung nicht bestanden');
		$this->mCheckMsg = $CheckMsg;
	}

	/*@}*/

	/*****************************************************************************************************************//**
	 * @name Getter
	 **************************************************************************************************************//*@{*/

	public function getCheckMsg() {return $this->mCheckMsg;}

	/*@}*/

	/*****************************************************************************************************************//**
	 * @name Verschiedenes
	 **************************************************************************************************************//*@{*/

	public function getTemplateData()
	{
		$data = parent::getDataArrayWithMsg();
		$data['checkmsg'] = $this->mCheckMsg;
		return new CTemplateData($data);
	}

	/*@}*/
}
?>