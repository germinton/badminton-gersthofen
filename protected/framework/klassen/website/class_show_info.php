<?php
include_once(dirname(__FILE__).'/class_show_exception.php');

/*******************************************************************************************************************//**
 * (Zweckentfremdete) Exception, die im Falle einer Benutzerinformation geworfen wird. Der Benutzer kann auf einen
 * Hyperlink klicken um auf die der Information folgenden Seite zu gelagen.
 **********************************************************************************************************************/
class CShowInfo extends CShowException
{

	private $mHRef; ///< Hyperlink für die nächste Seite

	/*****************************************************************************************************************//**
	 * @name Magics
	 **************************************************************************************************************//*@{*/

	public function __construct($Msg, $HRef)
	{
		parent::__construct($Msg);
		$this->mHRef = $HRef;
	}

	/*@}*/

	/*****************************************************************************************************************//**
	 * @name Getter
	 **************************************************************************************************************//*@{*/

	public function getHRef() {return $this->mHRef;}

	/*@}*/

	/*****************************************************************************************************************//**
	 * @name Verschiedenes
	 **************************************************************************************************************//*@{*/

	public function getTemplateData()
	{
		$data = parent::getDataArrayWithMsg();
		$data['href'] = $this->mHRef;
		return new CTemplateData($data);
	}

	/*@}*/
}
?>