<?php
include_once(dirname(__FILE__).'/../../konstanten/const__all.php');

/*******************************************************************************************************************//**
 * 'Ein-Instanz'-Klasse für das Bilddatei-Upload-Handling.
 **********************************************************************************************************************/
class CUploadHandler
{

	private static $mInstance; ///< Die eine, einzige Instanz der Klasse
	private static $mProcCmd = array( ///< Das Verarbeitungskommando
	ATTACH_PIC => PROC_NIL,
	ATTACH_FILE1 => PROC_NIL,
	ATTACH_FILE2 => PROC_NIL,
	ATTACH_FILE3 => PROC_NIL);

	/*****************************************************************************************************************//**
	 * @name Magics
	 **************************************************************************************************************//*@{*/

	private function __construct() {;}

	public static function getInstance()
	{
		if(!isset(self::$mInstance)) {self::$mInstance = new CUploadHandler();}
		return self::$mInstance;
	}

	public function __clone() {trigger_error('\'clone\' ist nicht erlaubt.', E_USER_ERROR);}

	/*@}*/

	/*****************************************************************************************************************//**
	 * @name Datenbank
	 **************************************************************************************************************//*@{*/

	public static function store($AttachType, $PathAndBasePartOfFilename)
	{
		$PathAndFullFilename = '';
		if(ATTACH_PIC == $AttachType)
		{
			$PathAndFullFilename = $PathAndBasePartOfFilename.'.jpg';
		}
		else
		{
			$orig_filename = $_FILES['userfile']['name'][$AttachType];
			$basename = NormalizeString(substr($orig_filename, 0, strrpos($orig_filename, '.')));
			if(strlen($basename) > 28) {$basename = substr($basename, 0, 28);}
			$extension = strtolower(substr($orig_filename, strrpos($orig_filename, '.') + 1));
			$PathAndFullFilename = $PathAndBasePartOfFilename.'_'.$basename.'.'.$extension;
		}
		move_uploaded_file($_FILES['userfile']['tmp_name'][$AttachType], $PathAndFullFilename);
	}

	/*@}*/

	/*****************************************************************************************************************//**
	 * @name Verschiedenes
	 **************************************************************************************************************//*@{*/

	public static function ProcNIL($AttachType) {return (PROC_NIL == self::$mProcCmd[$AttachType]);}
	public static function ProcUPL($AttachType) {return (PROC_UPL == self::$mProcCmd[$AttachType]);}
	public static function ProcDEL($AttachType) {return (PROC_DEL == self::$mProcCmd[$AttachType]);}

	public static function setProcessCmd($AttachType, $ProcCmd) {self::$mProcCmd[$AttachType] = $ProcCmd;}

	public static function getAttachTypeForFilename($Filename)
	{
		$FNameWoutExt = substr($Filename, 0, strrpos($Filename, '.'));
		if(strlen($FNameWoutExt) < 10) {return null;};
		$Filename10 = substr($Filename, 0, 10);
		if(!preg_match('~\A\d{10}\z~', $Filename10)) {return null;}
		if(10 == strlen($FNameWoutExt)) {return ATTACH_PIC;};
		if(strlen($FNameWoutExt) < 12) {return null;};
		$Suffix = substr($Filename, 10, 2);
		if(CDriveEntityWithAttachment::getSuffix(ATTACH_FILE1) == $Suffix) {return ATTACH_FILE1;}
		if(CDriveEntityWithAttachment::getSuffix(ATTACH_FILE2) == $Suffix) {return ATTACH_FILE2;}
		if(CDriveEntityWithAttachment::getSuffix(ATTACH_FILE3) == $Suffix) {return ATTACH_FILE3;}
		return null;
	}

	private static function getErrMsgSubstringForAttachType($AttachType)
	{
		switch($AttachType)
		{
			case ATTACH_PIC: return 'Bilderupload'; break;
			case ATTACH_FILE1: return 'Upload des Anhangs 1'; break;
			case ATTACH_FILE2: return 'Upload des Anhangs 2'; break;
			case ATTACH_FILE3: return 'Upload des Anhangs 3'; break;
			default; break;
		}
		return '';
	}

	private static function getMaxFileSizeForAttachType($AttachType)
	{
		switch($AttachType)
		{
			case ATTACH_PIC: return MAX_FILE_SIZE_ATTACH_PIC; break;
			case ATTACH_FILE1: return MAX_FILE_SIZE_ATTACH_FILE; break;
			case ATTACH_FILE2: return MAX_FILE_SIZE_ATTACH_FILE; break;
			case ATTACH_FILE3: return MAX_FILE_SIZE_ATTACH_FILE; break;
			default; break;
		}
		return 0;
	}

	public static function check($AttachType)
	{
		$ErrMsgSubstring = self::getErrMsgSubstringForAttachType($AttachType);

		if(UPLOAD_ERR_NO_FILE == $_FILES['userfile']['error'][$AttachType]) {
			return 'Es wurde keine Datei für den '.$ErrMsgSubstring.' angegeben.';
		}

		if(UPLOAD_ERR_FORM_SIZE == $_FILES['userfile']['error'][$AttachType]) {
			$MaxFileSize = self::getMaxFileSizeForAttachType($AttachType);
			return 'Für den '.$ErrMsgSubstring.' wurde eine Datei angegeben, die größer als die zulässigen '.
			round($MaxFileSize/(1024*1024), 2).'&#x202F;MB ist.';
		}

		if(UPLOAD_ERR_INI_SIZE == $_FILES['userfile']['error'][$AttachType]) {
			return 'Für den '.$ErrMsgSubstring.' wurde eine Datei angegeben, die größer als die vom Webserver zugelassenen '.
			round(return_bytes(ini_get('upload_max_filesize'))/(1024*1024), 2).'&#x202F;MB ist.';
		}

		if(ATTACH_PIC == $AttachType)
		{
			list($width, $height, $type) = getimagesize($_FILES['userfile']['tmp_name'][ATTACH_PIC]);

			if(IMAGETYPE_JPEG != $type) {return 'Die Bilddatei ist keine JPEG-Datei.';}

			$ratio = $width / $height;

			if($width > MAX_IMG_DIM or $height > MAX_IMG_DIM) {
				ShrinkJpegImage($_FILES['userfile']['tmp_name'][ATTACH_PIC]);
			}

			if($ratio > (MAX_IMG_RATIO_BIGPART / MAX_IMG_RATIO_SMLPART)) {
				return 'Die Bilddatei überschreitet das maximal zulässige Seitenverhältnis von '.
				MAX_IMG_RATIO_BIGPART.':'.MAX_IMG_RATIO_SMLPART.' (Breite:Höhe).' ;
			}

			if($ratio < (MAX_IMG_RATIO_SMLPART / MAX_IMG_RATIO_BIGPART)) {
				return 'Die Bilddatei unterschreitet das min. zulässige Seitenverhältnis von '.
				MAX_IMG_RATIO_SMLPART.':'.MAX_IMG_RATIO_BIGPART.' (Breite:Höhe).' ;
			}
		}
		else
		{
			$orig_filename = $_FILES['userfile']['name'][$AttachType];
			$ext = substr($orig_filename, strrpos($orig_filename, '.') + 1); // strtolower() unnecessary; strcasecmp() used
			$ext_OK = false;
			foreach($GLOBALS['Enum']['ValidAttachExt'] as $valid_ext) {
				if(!strcasecmp($ext, $valid_ext)) {$ext_OK = true; break;}
			}
			if(!$ext_OK) {return 'Dateityp \''.$ext.'\' ist unzulässig für den '.$ErrMsgSubstring.'.';}
		}

		if (UPLOAD_ERR_OK != $_FILES['userfile']['error'][$AttachType]) {
			return 'Unbehandelter PHP-Dateiupload-Fehler. Fehlercode '.$_FILES['userfile']['error'][$AttachType];
		}
	}

	/*@}*/
}
?>