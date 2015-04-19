<?php
include_once(dirname(__FILE__).'/class_drive_entity.php');
include_once(dirname(__FILE__).'/../website/class_upload_handler.php');

/*******************************************************************************************************************//**
 * Abstrakte Klasse für eine Datensatzrepräsentation mit Bild. Dient als Basisklasse für konkrete Datensatz-Klassen wie
 * z. B. CNeuigkeit. Die Klasse enthält Funktionalitäten zur Bild-Upload-Handling sowie Methoden zur Abfrage und zur
 * Ausgabe von Bildern.
 **********************************************************************************************************************/
abstract class CDriveEntityWithAttachment extends CDriveEntity
{

	private $mAttachDir; ///< Pfad für alle Attachments der der Datensatzrepräsentation zugrundeliegenden Tabelle

	/*****************************************************************************************************************//**
	 * @name Magics
	 **************************************************************************************************************//*@{*/

	protected function __construct($TabName, $IDName, $ID = 0)
	{
		parent::__construct($TabName, $IDName, $ID);
		$this->mAttachDir = DIR_ATTACHMENTS.'/'.CDriveEntity::getTabName().'/';
	}

	/*@}*/

	/*****************************************************************************************************************//**
	 * @name Datenbank
	 **************************************************************************************************************//*@{*/

	public function delete()
	{
		foreach($GLOBALS['Enum']['AttachType'] as $AttachType) {
			if($this->hasAttachment($AttachType)) {unlink($this->getAttachmentPath($AttachType));}
		}
		parent::delete();
	}

	protected function store()
	{
		parent::store();
		foreach($GLOBALS['Enum']['AttachType'] as $AttachType) {
			if(CUploadHandler::ProcUPL($AttachType)) {
				if($this->hasAttachment($AttachType)) {unlink($this->getAttachmentPath($AttachType));}
				CUploadHandler::store($AttachType, $this->getPathAndBasePartOfFilename($AttachType));
			}
			else if(CUploadHandler::ProcDEL($AttachType)) {unlink($this->getAttachmentPath($AttachType));}
		}
	}

	public function check() {
		foreach($GLOBALS['Enum']['AttachType'] as $AttachType) {
			if(CUploadHandler::ProcUPL($AttachType) and ($s = CUploadHandler::check($AttachType))) {
				CDriveEntity::addCheckMsg($s);
			}
		}
	}

	/*@}*/

	/*****************************************************************************************************************//**
	 * @name Verschiedenes
	 **************************************************************************************************************//*@{*/

	public function getXHTMLforIMG($DummyPic = false, $Height = 100)
	{
		if($this->hasAttachment(ATTACH_PIC)) {
			return '<img src="'.$this->getAttachmentPath(ATTACH_PIC).'" alt="'.$this.'" height="'.$Height.'" />';
		}
		if($DummyPic) {return '<img src="'.FILE_NOPIC.'" alt="Kein Bild" height="'.$Height.'" />';}
	}

	public function getXHTMLforFILE($AttachType, $DummyPic = false, $Height = 100)
	{
		if($this->hasAttachment($AttachType)) {
			$src = '';
			switch($this->getAttachmentExtension($AttachType))
			{
				case 'gif':
				case 'png':
				case 'jpg':
				case 'jpeg': $src = FILE_ICON_PIC; break;
				case 'doc':
				case 'docx': $src = FILE_ICON_DOC; break;
				case 'xls':
				case 'xlsx': $src = FILE_ICON_XLS; break;
				case 'pdf': $src = FILE_ICON_PDF; break;
				default: $src = FILE_ICON_GEN; break;
			}
			return '<img src="'.$src.'" alt="'.$this->getAttachmentFilename($AttachType).
			       '" height="'.$Height.'" style="border-style: none" />';
		}
		if($DummyPic) {
			return '<img src="'.FILE_NOATTACH.'" alt="Kein Anhang" height="'.$Height.'" style="border-style: none" />';
		}
	}

	public function hasAttachment($AttachTypeVariant, $FlagVariant = array())
	{
		$AttachTypeArray = (array)$AttachTypeVariant;
		$FlagArray = (array)$FlagVariant;
		foreach($AttachTypeArray as $AttachType)
		{
			$HasAttach = ((file_exists($this->getAttachmentPath($AttachType)))?(true):(false));
			if($HasAttach) {break;}
		}
		return ((in_array(GET_SPEC, $FlagArray))?(($HasAttach)?('ja'):('nein')):(($HasAttach)?(true):(false)));
	}

	public function countAttachments($AttachTypeVariant)
	{
		$AttachTypeArray = (array)$AttachTypeVariant;
		$Count = 0;
		foreach($AttachTypeArray as $AttachType){if(file_exists($this->getAttachmentPath($AttachType))) {$Count++;}}
		return $Count;
	}

	public function getAttachmentLink($AttachType, $NewTab = true)
	{
		if(!$this->hasAttachment($AttachType)) {return '';}
		$Path = $this->getAttachmentPath($AttachType);
		$ShortFilename = $this->getAttachmentShortFilename($AttachType);
		return '<a href="'.$Path.'"'.(($NewTab)?(' '.STD_NEW_WINDOW):('')).'>'.$ShortFilename.'</a>';
	}

	public function getAttachmentShortFilename($AttachType)
	{
		$LongFileName = $this->getAttachmentFilename($AttachType);
		return substr($LongFileName, 10 + strlen(self::getSuffix($AttachType)) + 1);
	}

	public function getAttachmentFilename($AttachType)
	{
		$FullFileName = $this->getAttachmentPath($AttachType);
		return substr($FullFileName, strrpos($FullFileName, '/') + 1);
	}

	public function getAttachmentExtension($AttachType)
	{
		$FullFileName = $this->getAttachmentPath($AttachType);
		return substr($FullFileName, strrpos($FullFileName, '.') + 1);
	}

	public function getAttachmentPath($AttachType)
	{
		$PathAndBasePartOfFilename = $this->getPathAndBasePartOfFilename($AttachType);
		$Pattern = $PathAndBasePartOfFilename.((ATTACH_PIC == $AttachType)?('.jpg'):('*.*'));
		foreach(glob($Pattern) as $filename) {return $filename; break;}
		return '';
	}

	public function getPathAndBasePartOfFilename($AttachType)
	{
		return $this->mAttachDir.$this->getBasePartOfFilename($AttachType);
	}

	public function getBasePartOfFilename($AttachType)
	{
		$id_string = str_pad(CDriveEntity::getID(), 10, "0", STR_PAD_LEFT);
		$suffix = self::getSuffix($AttachType);
		return $id_string.$suffix;
	}

	public static function getSuffix($AttachType)
	{
		switch($AttachType)
		{
			case ATTACH_FILE1: return '_1'; break;
			case ATTACH_FILE2: return '_2'; break;
			case ATTACH_FILE3: return '_3'; break;
			default: break;
		}
		return '';
	}

	/*@}*/
}
?>