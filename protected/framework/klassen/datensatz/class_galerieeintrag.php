<?php
include_once(dirname(__FILE__).'/../datenbank/class_drive_entity_with_attach.php');

/*******************************************************************************************************************//**
 * Repräsentation eines Galerieeintrags in seiner allgemeinsten Form.
 * @ingroup grp_recordset
 **********************************************************************************************************************/
class CGalerieeintrag extends CDriveEntityWithAttachment
{
	/*****************************************************************************************************************//**
	 * @name Tabellenname
	 **************************************************************************************************************//*@{*/

	const mcTabName = 'galerieeintraege';

	/*@}*/

	/*****************************************************************************************************************//**
	 * @name Tabellenspalten
	 **************************************************************************************************************//*@{*/

	private $mTitel;
	private $mDatum;
	private $mFreitext;
	private $mPicasaAlbumID;
	private $mPicasaAuthkey;


	/*@}*/

	/*****************************************************************************************************************//**
	 * @name Magics
	 **************************************************************************************************************//*@{*/

	public function __construct($GalerieeintragID = 0) {
		parent::__construct(self::mcTabName, $GalerieeintragID);
	}

	public function __toString()
	{
		if(!$this->getGalerieeintragID()) {return 'Kein Eintrag vorhanden';}
		return $this->mTitel;
	}

	/*@}*/

	/*****************************************************************************************************************//**
	 * @name Setter
	 **************************************************************************************************************//*@{*/

	public function setInitVals()
	{
		parent::setInitVals();
		$this->mTitel = '';
		$this->mDatum = '';
		$this->mFreitext = null;
		$this->mPicasaAlbumID = '';
		$this->mPicasaAuthkey = null;
	}

	final public function setGalerieeintragID($GalerieeintragID) {
		CDriveEntity::setID($GalerieeintragID);
	}

	final public function setTitel($Titel) {
		$this->mTitel = trim((string)$Titel);
	}
	
	final public function setDatum($Datum) {
		$this->mDatum = trim((string)$Datum);
	}

	final public function setFreitext($Freitext) {
		$this->mFreitext = (($s = trim((string)$Freitext))?($s):(null));
	}
	
	final public function setPicasaAlbumID($PicasaAlbumID) {
		$this->mPicasaAlbumID = trim((string)$PicasaAlbumID);
	}
	
	final public function setPicasaAuthkey($PicasaAuthkey) {
		$this->mPicasaAuthkey = trim((string)$PicasaAuthkey);
	}
	
	/*@}*/

	/*****************************************************************************************************************//**
	 * @name Getter
	 **************************************************************************************************************//*@{*/

	final public function getGalerieeintragID()
	{
		return CDriveEntity::getID();
	}
	
	final public function getTitel()
	{
		return $this->mTitel;
	}

	final public function getDatum($FlagVariant = array())
	{
		$FlagArray = (array)$FlagVariant;
		return ((in_array(GET_DTDE, $FlagArray))?(S2S_Datum_MySql2Deu($this->mDatum)):($this->mDatum));
	}

	final public function getFreitext($FlagVariant = array())
	{
		$FlagArray = (array)$FlagVariant;
		if(is_null($v = $this->mFreitext) and in_array(GET_NBSP, $FlagArray)) {return '&nbsp;';}
		$Freitext = ((in_array(GET_SPEC, $FlagArray))?(FormatXHTMLPermittedString($this->mFreitext)):($this->mFreitext));
		$Freitext = ((in_array(GET_CLIP, $FlagArray) and (strlen($Freitext) > 20))?(substr($Freitext, 0, 20).'...'):($Freitext));
		$Freitext = ((in_array(GET_HSPC, $FlagArray))?(htmlspecialchars($Freitext)):($Freitext));
		return $Freitext;
	}
	
	final public function getPicasaAlbumID()
	{
		return $this->mPicasaAlbumID;
	}
	
	final public function getPicasaAuthkey()
	{
		return $this->mPicasaAuthkey;
	}
	
	final public function getRSSLink()
	{
		if(is_null($this->mPicasaAuthkey)) {return 'https://';}
		return 'https://picasaweb.google.com/data/feed/base/user/'.PICASA_USER.'/albumid/'.$this->mPicasaAlbumID.'?alt=rss&kind=photo&authkey='.$this->mPicasaAuthkey.'&hl=de';
	}

	/*@}*/

	/*****************************************************************************************************************//**
	 * @name Datenbank
	 **************************************************************************************************************//*@{*/

	public static function isValidID($GalerieeintragID) {
		return CDriveEntity::genericIsValidID(self::mcTabName, $GalerieeintragID);
	}

	public function load($GalerieeintragID)
	{
		self::setInitVals();
		$this->setGalerieeintragID($GalerieeintragID);
		$format = 'SELECT titel, datum, freitext, picasa_albumid, picasa_authkey '.
		          'FROM galerieeintraege WHERE galerieeintrag_id=%s';
		$query = sprintf($format, $this->getGalerieeintragID());
		if(!$result = mysql_query($query)) {throw new Exception(mysql_error(CDriveEntity::getDB()));}
		$row = mysql_fetch_row($result);
		if(!$row) {throw new Exception('Album mit galerieeintrag_id='.$GalerieeintragID.' nicht gefunden!');}
		$this->mTitel = lS($row[0]);
		$this->mDatum = lS($row[1]);
		$this->mFreitext = lS($row[2]);
		$this->mPicasaAlbumID = lS($row[3]);
		$this->mPicasaAuthkey = lS($row[4]);
		
	}
	
	public function loadLatest()
	{
		self::setInitVals();
		$format = 'SELECT titel, datum, freitext, picasa_albumid, picasa_authkey, galerieeintrag_id '.
		          'FROM galerieeintraege ORDER BY datum DESC LIMIT 1';
		$query = sprintf($format);
		if(!$result = mysql_query($query)) {throw new Exception(mysql_error(CDriveEntity::getDB()));}
		$row = mysql_fetch_row($result);
		if(!$row) {throw new Exception('Kein Album gefunden.');}
		$this->mTitel = lS($row[0]);
		$this->mDatum = lS($row[1]);
		$this->mFreitext = lS($row[2]);
		$this->mPicasaAlbumID = lS($row[3]);
		$this->mPicasaAuthkey = lS($row[4]);
		$this->setGalerieeintragID($row[5]);
	}

	public function save()
	{
		self::check();
		CDriveEntity::evlCheckMsg();
		self::store();
	}

	public function store()
	{
		if(self::isValidID($this->getID()))
		{
			$format = 'UPDATE galerieeintraege SET '.
			          'titel=%s, datum=%s, freitext=%s, picasa_albumid=%s, picasa_authkey=%s '.
			          'WHERE galerieeintrag_id=%s';
			$query = sprintf($format, sS($this->mTitel), sS($this->mDatum), sS($this->mFreitext), 
				sS($this->mPicasaAlbumID), sS($this->mPicasaAuthkey), $this->getID());
		}
		else
		{
			$format = 'INSERT INTO galerieeintraege ('.
			          'titel, datum, freitext, picasa_albumid, picasa_authkey'.
			          ') VALUES (%s, %s, %s, %s, %s)';
			$query = sprintf($format, sS($this->mTitel), sS($this->mDatum), sS($this->mFreitext), 
				sS($this->mPicasaAlbumID), sS($this->mPicasaAuthkey));
		}
		if(!$result = mysql_query($query)) {throw new Exception(mysql_error(CDriveEntity::getDB()));}

		// Basisklasse
		parent::store();
	}

	public function check()
	{
		// Titel
		if(!(strlen($this->mTitel) >= 1 and strlen($this->mTitel) <= 100)) {
			CDriveEntity::addCheckMsg('Der Titel muss mind. 1 bis max. 100 Zeichen lang sein.');
		}
		else if(substr_count($this->mTitel, '{') != substr_count($this->mTitel, '}')) {
			CDriveEntity::addCheckMsg('Die Anzahl an sich öffnenden und sich schließenden geschw. Klammern ist ungleich.');
		}
		
		// Datum
		if(!(preg_match(REGEX_DATE_SQ, $this->mDatum)
		and preg_match(REGEX_DATE_DE, $this->getDatum(GET_DTDE)))) {
			CDriveEntity::addCheckMsg('Das Datum muss von der Form \'TT.MM.JJJJ\' sein.');
		}
		else if(!checkdate(
		substr($this->mDatum, 5, 2), substr($this->mDatum, 8, 2), substr($this->mDatum, 0, 4))) {
			CDriveEntity::addCheckMsg('Das Datum is ungültig.');
		}

		// Freitext
		if(!is_null($this->mFreitext))
		{
			if(!(strlen($this->mFreitext) >= 1 and strlen($this->mFreitext) <= 65535)) {
				CDriveEntity::addCheckMsg('Der Freitext muss mind. 1 bis max. 65535 Zeichen lang sein.');
			}
			else if(substr_count($this->mFreitext, '{') != substr_count($this->mFreitext, '}')) {
				CDriveEntity::addCheckMsg('Die Anzahl an sich öffnenden und sich schließenden geschw. Klammern ist ungleich.');
			}
		}

		// Picasa Album ID
		if(is_null($this->mPicasaAlbumID)){
			CDriveEntity::addCheckMsg('keine AlbumID angegeben');
		}
		
		// Bild
		CDriveEntityWithAttachment::check();
	}
	
	public function getXHTML()
	{
		$xhtml = "<br />\n<br />\n<h1>".$this->getTitel()."</h1>\n";
		
	  if($this->getPicasaAlbumID() != 0){
		
		$xhtml .= '<div id="galleria">'."\n";
			
						

		// die XML version auslesen
		$session = curl_init($this->getRSSLink());
		curl_setopt($session, CURLOPT_HEADER, false);
		curl_setopt($session, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($session, CURLOPT_SSL_VERIFYPEER, 0);
		curl_setopt($session, CURLOPT_SSL_VERIFYHOST, 0);
		$response = curl_exec($session);
		curl_close($session);
		$xml = simplexml_load_string($response);
		
		
		$items = $xml->channel;	
		//$xhtml .= '<div>'."\n";
		$e = 0;
		foreach ($items->item as $item){
			$title = $item->title;
			$content = $item->description;
	
			// Pull the images from the *description* section
			//
			$quotes = array('"', "'", "\n"); 
			$imgContents = str_replace($quotes, '', $content);    # Strip " and ' as well as \n from input string 
			$imgContents = stristr($imgContents, 'src=');            # Drop everything before the 'src' 
			$endTagPosition = stripos($imgContents, 'alt');        # Position of the end tag '>' 
			$img288 = substr($imgContents, 4, $endTagPosition - 4);    # Get everything from src to end tag --> 'src="path" something>' 
	
			// Swap out the s288 from the small image to make the thumbnail and larger images
			//
			$img144 = str_replace('/s288', '/s144', $img288);
			//$img400 = str_replace('/s288', '/s400', $img288);
			$img800 = str_replace('/s288', '/s800', $img288);
			$imgfull = str_replace('/s288','', $img288);

			$xhtml .= '<img src="'.$img800.'"'.((strncmp(strrev($title),"gpj.",4) && strncmp(strrev($title),"GPJ.",4))?('alt="'.$title.'"'):('alt=""')).' />'."\n";
			
			
		}
		
		
		
		
		$xhtml .= '</div>'."\n";
		
		$xhtml .= '<script type="text/javascript">
    
    			// Load theme
			    Galleria.loadTheme(\'javascript/galleria/src/themes/classic/galleria.classic.js\');
    
   			 // run galleria and add some options
  			  $(\'#galleria\').galleria({
  			      image_crop: false,
   			     transition: \'fade\',
   			     height: 500,
   			 });
   			 </script>'."\n";

	  }
		
		$xhtml .= "\n".'<div class="galerie text"><p>'.$this->getFreitext(GET_SPEC)."</p></div>\n";
		
		if($this->hasAttachment(array(ATTACH_FILE1, ATTACH_FILE2, ATTACH_FILE3)))
		{
			$xhtml .= '<br /><br />'."\n".'<div class="galerie text"><p>'."\n";
			$countAttachments = $this->countAttachments(array(ATTACH_FILE1, ATTACH_FILE2, ATTACH_FILE3));
			$xhtml .= (($countAttachments > 1)?('Anhänge'):('Anhang')).':<br />'."\n";
			if($this->hasAttachment(ATTACH_FILE1)) {
				$xhtml .= $this->getAttachmentLink(ATTACH_FILE1);
			}
			if($this->hasAttachment(ATTACH_FILE2)) {
				if($this->hasAttachment(ATTACH_FILE1)) {$xhtml .= ', '."\n";}
				$xhtml .= $this->getAttachmentLink(ATTACH_FILE2);
			}
			if($this->hasAttachment(ATTACH_FILE3)) {
				if($this->hasAttachment(array(ATTACH_FILE1, ATTACH_FILE2))) {$xhtml .= ', ';}
				$xhtml .= $this->getAttachmentLink(ATTACH_FILE3);
			}
			$xhtml .= "\n".'</p></div>'."\n";
		}
		
		//$xhtml .= '</div>'."\n";
		
		return $xhtml;
	}	
	
	public function getXHTMLlightbox()
	{
		$xhtml = '';
		$xhtml .= '<div id="thumbcontainer">
			<p id="thumb_beschriftung">&nbsp;</p>
			<ul id="thumbs"></ul>
			<br />
			<a href="javascript:pgup();"><img border="0" src="nav/transparent.gif" id="pgup" alt="Seite zur&uuml;ck" title="Seite zur&uuml;ck"></a>
			<a href="javascript:zurueck();"><img border="0" src="nav/transparent.gif" id="zurueck" alt="zur&uuml;ck" title="zur&uuml;ck"></a>

			<a href="javascript:weiter();"><img border="0" src="nav/transparent.gif" id="weiter" alt="weiter" title="weiter"></a>
			<a href="javascript:pgdown();"><img border="0" src="nav/transparent.gif" id="pgdown" alt="n&auml;chste Seite" title="n&auml;chste Seite"></a>
		</div>

		<script language="JavaScript1.5" type="text/javascript">
		<!-- // fuer Browser ohne JavaScript auskommentieren
			/* JavaScript-Bereich fuer die Bilder-Galerie
			 * Copyright (C) 2005 Alexander Mueller
			 * Autor: Alexander Mueller
			 * Web:   http://www.EvoComp.de/
			 * The copyright notice must stay intact for use!
			 * You can obtain this and other scripts at http://www.EvoComp.de/scripts/skripte.html
			 *
			 * This program is distributed in the hope that it will be useful,
			 * but without any warranty, expressed or implied.
			 */

			// Maximalwert aus x und y Ausdehnung aller Thumbnails (in Pixel)
			// Wird zur Formatierung der Thumbnails und Navigationsbilder benoetigt um ein
			// "Verrutschen" von Navigation und Thumbnails zu verhindern.
			var thumb_groesse = 100; // x und y Ausdehnung der Thumbnails (zum Ausrichten)
			// Anzahl der Thumbnails, die erzeugt werden sollen
			var anzahl_thumbnails = 5;
			// Zeichenkette, mit der die Thumbnails beschriftet werden sollen (bei Leerstring wird nichts angezeigt)
			// Dabei werden folgende Bestandteile durch entsprechende Werte ersetzt:
			//   %index_erster%   - Index des Bildes, welches als erster Thumbnail angezeigt wird
			//   %index_letzter%  - Index des letzten angezeigten Thumbnails
			//   %anzahl_bilder%  - Anzahl der Bilder in der Galerie
			var thumbnail_string = "Bilder %index_erster% bis %index_letzter% von %anzahl_bilder%";
			// Zeichenkette, mit der das gewaehlte Detailbild beschriftet werden soll
			// Hier werden folgende Bestandteile durch Werte ersetzt:
			//   %index_gross%   - Index des Detailbildes, welches angezeigt wird
			//   %anzahl_bilder% - Anzahl der Bilder in der Galerie
			//   %beschreibung%  - Beschreibung zum angezeigten Detailbild
			var bild_beschriftung = "Bild %index_gross% / %anzahl_bilder%: %beschreibung%";
			// Hier kann der absolute Pfad zu den Navigationsbuttons und dem
			// Platzhalter (transparent.gif) angegeben werden, falls diese
			// nicht im selben Verzeichnis liegen, wie die HTML-Datei, welche
			// die Galerie enthaelt.
			var pfad_zu_navbildern = "./javascript/galerie/nav";

			// Bilder zur Galerie hinzufuegen
			// 1. Parameter: URL zum Thumbnail
			// 2. Parameter: URL zum Detailbild
			// 3. Parameter: Kurzbeschreibung, wenn die Maus ueber dem Bild ist
			// 4. Parameter: Beschriftung des Detailbildes';
			
						

		// die XML version auslesen
		$session = curl_init($this->getRSSLink());
		curl_setopt($session, CURLOPT_HEADER, false);
		curl_setopt($session, CURLOPT_RETURNTRANSFER, true);		
		curl_setopt($session, CURLOPT_SSL_VERIFYPEER, 0);
		curl_setopt($session, CURLOPT_SSL_VERIFYHOST, 0);
		$response = curl_exec($session);
		curl_close($session);
		$xml = simplexml_load_string($response);
		
		
		$items = $xml->channel;	
		$xhtml .= '<div>'."\n";
		$e = 0;
		foreach ($items->item as $item){
			$title = $item->title;
			$content = $item->description;
	
			// Pull the images from the *description* section
			//
			$quotes = array('"', "'", "\n"); 
			$imgContents = str_replace($quotes, '', $content);    # Strip " and ' as well as \n from input string 
			$imgContents = stristr($imgContents, 'src=');            # Drop everything before the 'src' 
			$endTagPosition = stripos($imgContents, 'alt');        # Position of the end tag '>' 
			$img288 = substr($imgContents, 4, $endTagPosition - 4);    # Get everything from src to end tag --> 'src="path" something>' 
	
			// Swap out the s288 from the small image to make the thumbnail and larger images
			//
			$img144 = str_replace('/s288', '/s144', $img288);
			//$img400 = str_replace('/s288', '/s400', $img288);
			$img800 = str_replace('/s288', '/s800', $img288);
			$imgfull = str_replace('/s288','', $img288);

			$xhtml .= 'addPhoto ("'.$img144.'", "'.$img800.'", "'.$title.'","");'."\n";
			/*if(strncmp(strrev($title),"gpj.",4) && strncmp(strrev($title),"GPJ.",4))
				$xhtml .= '<div class="highslide-caption">'.$title.'</div>'."\n";*/
		}
		
		
		
		
		$xhtml .= '
			// intern genutzte Variablen (keine Anpassung noetig)
			var index_erstes_bild = 0; // erstes Bild in der Liste (zur Initialisierung)
			var index_grosses_bild = 0; // Bildindex fuer anzuzeigendes grosses Bild
			var anzahl_bilder = Photos.length; // Anzahl der Bilder insgesamt

			// Anzahl der Thumbnails darf hoechstens so gross sein, wie die Gesamtzahl der Bilder
			if (anzahl_thumbnails > anzahl_bilder)
				anzahl_thumbnails = anzahl_bilder;

			// Thumbnails erzeugen
			erzeuge_thumbnails ();
			// den ersten Satz Thumbnails nach der Initialisierung anzeigen
			thumbnails_auffrischen ();
			// zyklisch Thumbnails positionieren
			window.setInterval ("ausrichten ()", 5);
		// -->
		</script>
		<noscript>
			Hinweis: Die Galerie funktioniert mit deaktiviertem JavaScript nicht! (JavaScript ab Version 1.5 wird benötigt)<br>
			Weitere Informationen und das Script zum Herunterladen finden Sie unter <a href="http://www.evocomp.de/scripts/java-script-download/java-script-galerie/javascript-galerie.html" title="Free JavaScript Fotoalbum Download">JavaScript Homepage Fotogalerie</a> und eine Demonstration des Scripts finden Sie unter <a href="http://www.evocomp.de/javascript-demos/java-script-galerie/javascript-galerie.html" title="JavaScript Album Beispiel">JavaScript Online-Galerie Demo</a>.
		</noscript>';

		$xhtml .= "\n<br />\n".'<div class="galerie text"><p>'.$this->getFreitext(GET_SPEC)."</p></div>\n";
		
		if($this->hasAttachment(array(ATTACH_FILE1, ATTACH_FILE2, ATTACH_FILE3)))
		{
			$xhtml .= '<br /><br />'."\n".'<div class="galerie text"><p>'."\n";
			$countAttachments = $this->countAttachments(array(ATTACH_FILE1, ATTACH_FILE2, ATTACH_FILE3));
			$xhtml .= (($countAttachments > 1)?('Anhänge'):('Anhang')).':<br />'."\n";
			if($this->hasAttachment(ATTACH_FILE1)) {
				$xhtml .= $this->getAttachmentLink(ATTACH_FILE1);
			}
			if($this->hasAttachment(ATTACH_FILE2)) {
				if($this->hasAttachment(ATTACH_FILE1)) {$xhtml .= ', '."\n";}
				$xhtml .= $this->getAttachmentLink(ATTACH_FILE2);
			}
			if($this->hasAttachment(ATTACH_FILE3)) {
				if($this->hasAttachment(array(ATTACH_FILE1, ATTACH_FILE2))) {$xhtml .= ', ';}
				$xhtml .= $this->getAttachmentLink(ATTACH_FILE3);
			}
			$xhtml .= "\n".'</p></div>'."\n";
		}
		
		$xhtml .= '</div>'."\n";
		
		return $xhtml;
	}	
	
	public function getXHTMLold()
	{
		$count = intval(strlen($this->getFreitext(GET_SPEC))/600)+1;
		$xhtml = '';

		// die XML version auslesen
		$session = curl_init($this->getRSSLink());
		curl_setopt($session, CURLOPT_HEADER, false);
		curl_setopt($session, CURLOPT_RETURNTRANSFER, true);		
		curl_setopt($session, CURLOPT_SSL_VERIFYPEER, 0);
		curl_setopt($session, CURLOPT_SSL_VERIFYHOST, 0);
		$response = curl_exec($session);
		curl_close($session);
		$xml = simplexml_load_string($response);
		
		
		$items = $xml->channel;	
		$xhtml .= '<div>'."\n";
		$e = 0;
		foreach ($items->item as $item){
			$title = $item->title;
			$content = $item->description;
	
			// Pull the images from the *description* section
			//
			$quotes = array('"', "'", "\n"); 
			$imgContents = str_replace($quotes, '', $content);    # Strip " and ' as well as \n from input string 
			$imgContents = stristr($imgContents, 'src=');            # Drop everything before the 'src' 
			$endTagPosition = stripos($imgContents, 'alt');        # Position of the end tag '>' 
			$img288 = substr($imgContents, 4, $endTagPosition - 4);    # Get everything from src to end tag --> 'src="path" something>' 
	
			// Swap out the s288 from the small image to make the thumbnail and larger images
			//
			$img144 = str_replace('/s288', '/s144', $img288);
			//$img400 = str_replace('/s288', '/s400', $img288);
			$img800 = str_replace('/s288', '/s800', $img288);
			$imgfull = str_replace('/s288','', $img288);

			$info = getimagesize($img144);
			if($info[0] < $info[1]) $vertical = true; else $vertical = false;
			//if ($count == 0) {$e++; }
			$margin = (($count-- <= 0)?(0):(33)) + (($vertical)?(288-$info[0]):(0));
			$xhtml .= '<div class="galerie"><a href="'.$img800.'" class="highslide" onclick="return hs.expand(this)">
<img style="float:'.(($e%2 == 0)?('right'):('left')).'; margin-'.(($e++%2 == 0)?('left'):('right')).':'.$margin.'px" src="'.$img144.'" alt="Highslide JS" title="Click to enlarge" /></a>'."\n";
			if(strncmp(strrev($title),"gpj.",4) && strncmp(strrev($title),"GPJ.",4))
				$xhtml .= '<div class="highslide-caption">'.$title.'</div>'."\n";
			$xhtml .= '</div>'."\n";
		}
		/*$xhtml .= '<a href="'.$imgfull.'" class="highslide" onclick="return hs.expand(this)">
	<img src="'.$img288.'" alt="Highslide JS"
		title="Click to enlarge" /></a>'."\n";*/
		$xhtml .= "\n<br />\n".'<div class="galerie text"><p>'.$this->getFreitext(GET_SPEC)."</p></div>\n";
		
		if($this->hasAttachment(array(ATTACH_FILE1, ATTACH_FILE2, ATTACH_FILE3)))
		{
			$xhtml .= '<br /><br />'."\n".'<div class="galerie text"><p>'."\n";
			$countAttachments = $this->countAttachments(array(ATTACH_FILE1, ATTACH_FILE2, ATTACH_FILE3));
			$xhtml .= (($countAttachments > 1)?('Anhänge'):('Anhang')).':<br />'."\n";
			if($this->hasAttachment(ATTACH_FILE1)) {
				$xhtml .= $this->getAttachmentLink(ATTACH_FILE1);
			}
			if($this->hasAttachment(ATTACH_FILE2)) {
				if($this->hasAttachment(ATTACH_FILE1)) {$xhtml .= ', '."\n";}
				$xhtml .= $this->getAttachmentLink(ATTACH_FILE2);
			}
			if($this->hasAttachment(ATTACH_FILE3)) {
				if($this->hasAttachment(array(ATTACH_FILE1, ATTACH_FILE2))) {$xhtml .= ', ';}
				$xhtml .= $this->getAttachmentLink(ATTACH_FILE3);
			}
			$xhtml .= "\n".'</p></div>'."\n";
		}
		
		$xhtml .= '</div>'."\n";

		return $xhtml;
	}

	public static function getGalerieeintraegeArray($chosenYear = 0)
	{
		$query = 'SELECT galerieeintrag_id FROM galerieeintraege'.((isset($chosenYear))?(' WHERE YEAR(datum) = '.$chosenYear.' '):' ').
		         'ORDER BY datum DESC';
		if(!$result = mysql_query($query, CDriveEntity::getDB())) {throw new Exception(mysql_error(CDriveEntity::getDB()));}
		while($row = mysql_fetch_row($result)) {$GalerieeintraegeArray[] = new CGalerieeintrag($row[0]);}
		return ((isset($GalerieeintraegeArray))?($GalerieeintraegeArray):(array()));
	}
	
	/*@}*/
}
?>