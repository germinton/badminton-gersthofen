<?php
include_once(dirname(__FILE__).'/phpmailer/class.phpmailer.php');

/*******************************************************************************************************************//**
 * Den eigenen bedürfnissen abgepasste PHPMailer-Klasse.
 **********************************************************************************************************************/
class CMyPHPMailer extends PHPMailer
{

	public function __construct()
	{
		parent::__construct(true);
		$this->IsMail(); // use php-mail()-function
		$this->CharSet = 'utf-8';
		$this->From = 'webmaster@badminton-gersthofen.de';
		$this->FromName = 'Webmaster www.badminton-gersthofen.de';
		$this->Sender = 'webmaster@badminton-gersthofen.de';
		//$this->AddReplyTo('info@badminton-gersthofen.de', 'Badminton TSV Gersthofen');
	}

}
?>