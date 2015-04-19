<?php
/*******************************************************************************************************************//**
 * @file
 * Allgemeine Funktionen.
 **********************************************************************************************************************/

/*******************************************************************************************************************//**
 * Gibt für den angegebenen String entwededer den String in single-quotes zurück oder den String NULL (ohne quotes)
 **********************************************************************************************************************/
function sS($String)
{
	return ((is_null($String))?('NULL'):('\''.$String.'\''));
}

/*******************************************************************************************************************//**
 * Gibt für die angegebene Zahl entwededer die Zahl zurück oder String NULL
 **********************************************************************************************************************/
function sD($Digit)
{
	return ((is_null($Digit))?('NULL'):($Digit));
}

/*******************************************************************************************************************//**
 * Gibt für den angegebenen Ja/Nein-Wert entwededer 1 bzw. 0 zurück oder String NULL
 **********************************************************************************************************************/
function sB($Boolean)
{
	return ((is_null($Boolean))?('NULL'):((($Boolean))?(1):(0)));
}

/*******************************************************************************************************************//**
 * Gibt für den angegebenen String entwededer einen String oder 'PHP-null' zurück
 **********************************************************************************************************************/
function lS($StringOrNull)
{
	/*
	 * mysql_fetch_row()
	 * http://www.php.net/manual/en/function.mysql-fetch-row.php
	 * ...
	 * Note: This function sets NULL fields to the PHP NULL value.
	 *
	 */
	return ((is_null($StringOrNull)?(null):($StringOrNull)));;
}

/*******************************************************************************************************************//**
 * Gibt für den angegebenen String entwededer eine Zahl oder 'PHP-null' zurück
 **********************************************************************************************************************/
function lD($StringOrNull)
{
	/*
	 * mysql_fetch_row()
	 * http://www.php.net/manual/en/function.mysql-fetch-row.php
	 * ...
	 * Note: This function sets NULL fields to the PHP NULL value.
	 *
	 */
	// if(is_integer($StringOrNull)) {die('is_integer!');}
	return ((is_null($StringOrNull)?(null):((int)$StringOrNull)));
}

/*******************************************************************************************************************//**
 * Gibt für den angegebenen String entwededer einen Boolean oder 'PHP-null' zurück
 **********************************************************************************************************************/
function lB($StringOrNull)
{
	/*
	 * mysql_fetch_row()
	 * http://www.php.net/manual/en/function.mysql-fetch-row.php
	 * ...
	 * Note: This function sets NULL fields to the PHP NULL value.
	 *
	 */
	// if(is_bool($StringOrNull)) {die('is_bool!');}
	return ((is_null($StringOrNull)?(null):(((int)$StringOrNull)?(true):(false))));
}

/*******************************************************************************************************************//**
 * Gibt für den angegebenen 'Section-String' das XHTML-'a'-Element (Anker-Element) aus.
 **********************************************************************************************************************/
function EchoLink($SecString = null)
{
	if(is_null($SecString)) {$SecString = $_GET['section'];}
	$Nav = CSiteManager::getInstance()->getNavForSecString($SecString);
	if($Nav instanceof CNav) {echo CSiteManager::getInstance()->getNavForSecString($SecString)->getXHTMLForLink();}
	else {echo '<span style="color: red">FEHLER! Section-String \''.$SecString.'\' unbekannt!</span>';}
}


/*******************************************************************************************************************//**
 * Formatiert einen String der durch ein XHTML-erlaubtes-Texteingabefeld entstanden ist.
 **********************************************************************************************************************/
function FormatXHTMLPermittedString($String)
{
	include_once(dirname(__FILE__).'/../klassen/website/class_nav.php');
	include_once(dirname(__FILE__).'/../klassen/website/class_nav_cont.php');
	include(dirname(__FILE__).'/../../navigation.php');

	$String = nl2br($String);
	$String = str_replace("\n", '', $String);

	preg_match_all("/(<([\w]+)[^>]*>)(.*)(<\/\\2>)/U", $String, $Tags, PREG_SET_ORDER);

	foreach ($Tags as $val)
	{
		if(!strcmp($val[2], 'ul') or
		!strcmp($val[2], 'ol') or
		!strcmp($val[2], 'dl') or
		!strcmp($val[2], 'a') or
		!strcmp($val[2], 'table'))
		{
			$Replacement = str_replace('<br />', '', $val[0]);
			$String = str_replace($val[0], $Replacement, $String);
		}
	}

	preg_match_all('~{.*}~U', $String, $SecStringArrayWihtCurlyBraces);
	foreach($SecStringArrayWihtCurlyBraces[0] as $SecStringWihtCurlyBraces)
	{
		$SecString = substr($SecStringWihtCurlyBraces, 1, strlen($SecStringWihtCurlyBraces)-2);
		$Nav = $NavContGlb->getNavForSecString($SecString);
		if(!$Nav) {$Nav = $NavContPub->getNavForSecString($SecString);}
		if(!$Nav) {$Nav = $NavContInt->getNavForSecString($SecString);}
		$Replacement = (($Nav)?($Nav->getXHTMLForLink()):('[ungültiger Link]'));
		$String = str_replace($SecStringWihtCurlyBraces, $Replacement, $String);
	}
	return $String;
}

/*******************************************************************************************************************//**
 * Verkleinert ein JPEG-Bild auf die zulässigen Maximalwerte.
 **********************************************************************************************************************/
function ShrinkJpegImage($filename)
{
	list($width, $height, $type) = getimagesize($filename);
	if(IMAGETYPE_JPEG != $type) {throw new Exception('Die Bilddatei ist keine JPEG-Datei.');}

	$newWidth = 0;
	$newHeight = 0;

	if($height > $width)
	{
		$newHeight = MAX_IMG_DIM;
		$newWidth = (int)(($width / $height) * $newHeight);
	}
	else
	{
		$newWidth = MAX_IMG_DIM;
		$newHeight = (int)(($height / $width) * $newWidth);
	}

	$src = imagecreatefromjpeg($filename);
	$tmp = imagecreatetruecolor($newWidth, $newHeight);
	imagecopyresampled($tmp, $src, 0, 0, 0, 0, $newWidth, $newHeight, $width, $height);
	imagejpeg($tmp, $filename, 85);
}

/*******************************************************************************************************************//**
 * Entfernt aus einer Zeichenkette Sonderzeichen u.Ä., die zu Problemen auf dem Webserver führen könnten
 **********************************************************************************************************************/
function NormalizeString($String)
{
	$table = array(
        'Š'=>'S', 'š'=>'s', 'Đ'=>'Dj', 'đ'=>'dj', 'Ž'=>'Z', 'ž'=>'z', 'Č'=>'C', 'č'=>'c', 'Ć'=>'C', 'ć'=>'c',
        'À'=>'A', 'Á'=>'A', 'Â'=>'A', 'Ã'=>'A', 'Ä'=>'Ae', 'Å'=>'A', 'Æ'=>'A', 'Ç'=>'C', 'È'=>'E', 'É'=>'E',
        'Ê'=>'E', 'Ë'=>'E', 'Ì'=>'I', 'Í'=>'I', 'Î'=>'I', 'Ï'=>'I', 'Ñ'=>'N', 'Ò'=>'O', 'Ó'=>'O', 'Ô'=>'O',
        'Õ'=>'O', 'Ö'=>'Oe', 'Ø'=>'O', 'Ù'=>'U', 'Ú'=>'U', 'Û'=>'U', 'Ü'=>'U', 'Ý'=>'Y', 'Þ'=>'B', 'ß'=>'ss',
        'à'=>'a', 'á'=>'a', 'â'=>'a', 'ã'=>'a', 'ä'=>'ae', 'å'=>'a', 'æ'=>'a', 'ç'=>'c', 'è'=>'e', 'é'=>'e',
        'ê'=>'e', 'ë'=>'e', 'ì'=>'i', 'í'=>'i', 'î'=>'i', 'ï'=>'i', 'ð'=>'o', 'ñ'=>'n', 'ò'=>'o', 'ó'=>'o',
        'ô'=>'o', 'õ'=>'o', 'ö'=>'oe', 'ø'=>'o', 'ù'=>'u', 'ú'=>'u', 'û'=>'u', 'ý'=>'y', 'ý'=>'y', 'þ'=>'b',
        'ÿ'=>'y', 'Ŕ'=>'R', 'ŕ'=>'r', ' '=>'_', 'ü'=>'ue', 'Ü'=>'Ue',
	);
	return strtr($String, $table);
}

/*******************************************************************************************************************//**
 * Konvertiert eine Ganzzahl in eine als Zeichenkette zurückgegebene Fließkommazahl 'nach Art des Hauses'
 **********************************************************************************************************************/
function MyInt2Floatstring($i)
{
	$s = (string)((($i<0)?(-1):(1))*$i);
	$j = 9-strlen($s);
	while($j--) {$s = '0'.$s;}
	return (($i<0)?('-'):('')).((int)substr($s, 0, strlen($s)-6)).'.'.substr($s, strlen($s)-6, 6);
}

/*******************************************************************************************************************//**
 * Konvertiert eine als Zeichenkette übergebene Fließkommazahl in eine Ganzzahl 'nach Art des Hauses'
 **********************************************************************************************************************/
function MyFloatstring2Int($f)
{
	if(''===$f) {return null;}
	if(false===strpos($f, '.')) {$f .= '.';}
	if(0===strpos($f, '.')) {$f = '0'.$f;}
	$pieces = explode('.', $f);
	if(strlen($pieces[1]) > 6) {$pieces[1] = substr($pieces[1], 0, 6);}
	return $pieces[0].str_pad($pieces[1], 6, '0');
}

/*******************************************************************************************************************//**
 * Many ini memory size values, such as upload_max_filesize, are stored in the php.ini file in shorthand notation.
 * ini_get() will return the exact string stored in the php.ini file and NOT its integer equivalent.
 * Attempting normal arithmetic functions on these values will not have otherwise expected results.
 * return_bytes() shows one way to convert shorthand notation into bytes, much like how the PHP source does it.
 **********************************************************************************************************************/
function return_bytes($val) {
	$val = trim($val);
	$last = strtolower($val[strlen($val)-1]);
	switch($last) {
		// The 'G' modifier is available since PHP 5.1.0
		case 'g':
			$val *= 1024;
		case 'm':
			$val *= 1024;
		case 'k':
			$val *= 1024;
	}
	return $val;
}
?>