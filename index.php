<?php header('Content-Type: text/html; charset=utf-8') ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="de" lang="de">
<?php
/*******************************************************************************************************************//**
 * @file
 * Hauptseite der Badminton-Homepage.
 * Dies ist die (einzige) Seite, mit der der Besucher interagiert.
 **********************************************************************************************************************/

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// PHP-Einstellungen
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

error_reporting(E_ALL);
ini_set('display_errors', 1);
setlocale(LC_ALL, 'de_DE');
date_default_timezone_set('Europe/Berlin');

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Includes
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

include('protected/framework/framework.php');
include('protected/inhalte/schnipsel/sni__all.php');
include('protected/navigation.php');

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Variablen zum Management des Templatesystems
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

/*******************************************************************************************************************//**
 * Das SiteManager-Objekt wickelt den Seitenaufbau ab. Von der CSiteManager-Klasse kann jeweils nur eine Instanz erzeugt
 * werden. Diese Instanz kontrolliert bei jedem Seitenaufbau den Login-Status, startet bei bedarf ein Modul zur
 * Verarbeitung von übergebenen Daten (des letzten Seitenaufrufs) und läd schließlich den eigentlichen Inhalt in die
 * Seite.
 **********************************************************************************************************************/
$SiteManager = CSiteManager::getInstance($NavContGlb, $NavContPub, $NavContInt);

/*******************************************************************************************************************//**
 * Das Objekt der CTemplateData-Klasse transportiert Daten vom Modul in die Inhalts-Datei.
 **********************************************************************************************************************/
$ActTplData = null;

/*******************************************************************************************************************//**
 * Die $IncludeFile-Variable spezifiziert den Pfad des zu ladenden Inhalts.
 **********************************************************************************************************************/
$IncludeFile = 'protected/inhalte/';
if(!isset($_GET['section'])) {$_GET['section'] = 'startseite';}
?>

<head>

<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="alternate" hreflang="de" href="https://www.badminton-gersthofen.de/" />

<?php
echo '<title>';
if($_GET['section'] != 'startseite' && ($NavForSecRequest = $SiteManager->getNavForSecRequest()) instanceof CNav) {
	echo $NavForSecRequest->getNavText().' - Badminton TSV Gersthofen';
}
else {
	echo 'Website der Abteilung Badminton des TSV Gersthofen';
}
echo '</title>';
?>
<meta name="author-personal" content="Badmintonabteilung TSV Gersthofen" />
<meta name="author-mail" content="mailto:webmaster@badminton-gersthofen.de" />
<?php
echo '<meta name="description" content="';
if(file_exists($desc_file = 'protected/inhalte/metadesc/desc_'.$_GET['section'].'.php')) {include $desc_file;}
else {echo STD_META_DESC;}
echo '" />'."\n";
?>
<meta name="keywords" content="Badminton, Federball, Verein, Sport, Sportverein, Gersthofen, Augsburg" />
<meta name="language" content="de" />
<meta name="robots" content="index, follow" />

<link rel="shortcut icon" href="bilder/favicon.ico" type="image/vnd.microsoft.icon" />
<link rel="icon" href="bilder/favicon.ico" type="image/vnd.microsoft.icon" />

<link rel="stylesheet" href="css/farben_gelb.css" type="text/css" media="screen, projection" />
<link rel="stylesheet" href="css/default.css" type="text/css" media="screen, projection" />
<link rel="stylesheet" href="css/loginbox.css" type="text/css" media="screen, projection" />

<script type="text/javascript" src="javascript/date_picker/js/datepicker.js"></script>
<script type="text/javascript" src="javascript/gmap/my_gmap.js"></script>
<script type="text/javascript"
	src="https://maps.google.com/maps?file=api&amp;v=2&amp;sensor=false&amp;key=<?php echo GMAP_API_KEY ?>"></script>

<link rel="stylesheet" href="javascript/date_picker/css/datepicker.css" type="text/css" />

<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js"></script>
<script type="text/javascript" src="javascript/galleria/src/galleria.js"></script>
<script type="text/javascript" src="javascript/galleria/src/themes/classic/galleria.classic.js"></script>
<style type="text/css">
	#galleria{width:668px;margin:20px auto}
</style>


</head>

<body onload="MyGMapLoad();" onunload="GUnload();">


<div id="wrappershadow">
<div id="wrapper">

<a href="http://tsv-gersthofen.de/"><img src="bilder/heading-tsv-gersthofen.png" /></a>

<div id="head"><?php 

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Template-Datei (=anzuzeigender Inhalt) laden
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

try
{
	// 1. Allgemeine Funktionen ausführen, die zu jedem Seiten-Refresh aufgerufen werden sollen
	$SiteManager->runOnEveryPageRefresh();

	// 2. Login-Status überprüfen ($NavContInt evtl. filtern)
	$SiteManager->processLogin();

	// 3. Daten für die angeforderte Seite zusammenstellen
	$ActTplData = $SiteManager->getTemplateDataForSecRequest();

	if(is_null($ActTplData)) {
		throw new CShowError('Im Modul wurde die return Anweisung vergessen.');
	}
	if(!($ActTplData instanceof CTemplateData)) {
		throw new CShowError('Das Modul hat einen ungültigen Wert zurückgegeben.');
	}
	if(!$ActTplData->justSimpleEcho() and !file_exists($IncludeFile.'sections/sec_'.$_GET['section'].'.php')) {
		throw new CShowError('Für diese Funktionalität ist keine Ausgabe vorhanden.');
	}

	$IncludeFile .= 'sections/sec_'.$_GET['section'].'.php';
}
catch(CShowInfo $si)     {$ActTplData = $si->getTemplateData(); $IncludeFile .= 'meldungen/msg_info.php';}
catch(CShowError $se)    {$ActTplData = $se->getTemplateData(); $IncludeFile .= 'meldungen/msg_error.php';}
catch(CShowCheckMsg $sc) {$ActTplData = $sc->getTemplateData(); $IncludeFile .= 'meldungen/msg_check_msg.php';}
catch(Exception $e)
{
	$ShowError = new CShowError('Unbehandelter Fehler: '.$e->getMessage());
	$ActTplData = $ShowError->getTemplateData();
	$IncludeFile .= 'meldungen/msg_error.php';
}

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// XHTML für Navigationen und Login-Box
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
echo "\n";
echo "\n";
echo '<!-- globale Navigation -->'."\n";
echo $SiteManager->getXHTMLForNavGlb()."\n";
echo '<!-- Login-Box -->'."\n";
if($SiteManager->getMitglied() instanceof CMitglied) {include 'protected/inhalte/loginout/log_mitgliederlogout.php';}
else {include 'protected/inhalte/loginout/log_mitgliederlogin.php';}
echo "\n";
echo '<!-- Überschrift/Logo -->'."\n";
echo '<h1 id="logo"><img src="bilder/ueberschrift.png" width="310" height="80" alt="Badminton" /></h1>'."\n";
echo "\n";
echo '</div>'."\n";
echo "\n";
echo '<div id="main">'."\n";
echo '<div id="sidebar">'."\n";
echo "\n";
echo '<!-- Hauptnavigation -->'."\n";
echo '<div id="sidebarnav">'."\n";
echo $SiteManager->getXHTMLForNavPub();
echo $SiteManager->getXHTMLForNavInt();
echo '</div>'."\n";
echo '</div>'."\n";
echo "\n";
echo '<div id="contentnav" class="grundiert">'."\n";
$CntNav = $SiteManager->getXHTMLForNavCnt();
echo ((strlen($CntNav))?($CntNav):('&nbsp;'))."\n";
echo '</div>'."\n";

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// INHALT-START
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
echo "\n";
echo '<!-- INHALT -->'."\n";
echo '<div id="content">'."\n";
echo "\n";

if($SiteManager->getMitglied() instanceof CMitglied)
{
	if($SiteManager->getMitglied()->getPwAendern() and $_GET['section']!='prof_aendernlogin')
	{
		echo '<div class="info papier">'."\n";
		echo '<p>Bitte ändere Dein Passwort!</p>'."\n";
		echo '<p>Du hast ein zufällig generiertes Passwort per E-Mail zugeschickt bekommen. ';
		echo 'Diese Meldung wird so lange angezeigt, bis Du ein ';
		echo '<a href="index.php?section=prof_aendernlogin">neues Passwort vergeben</a> hast.</p>'."\n";
		echo '</div>'."\n";
	}
}

$data = $ActTplData->getData();
if($ActTplData->justSimpleEcho()) {echo $data['xhtml'];}
else {include $IncludeFile;}

if(count($SubNavArray = $SiteManager->getSubNavArrayForSecRequest())) {
	echo '<h2>Unterrubriken</h2>'."\n";
	foreach($SubNavArray as $Nav)
	{
		echo '<h3>'.$Nav->getNavText().'</h3>'."\n";
		if(file_exists($src = 'protected/inhalte/erklaerungen/epl_'.$Nav->getSecString().'.php')) {include_once($src);}
		else {echo 'Weitere Funktionalitäten findest Du unter '.$Nav->getXHTMLForLink()."\n";}
	}
}
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// INHALT-ENDE
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

echo '</div>'."\n";
?> <!-- Fußzeile -->
<div id="footer"><img style="float: right" src="bilder/vcss-blue.gif" alt="Valid CSS!" height="31" width="88" /><img
	style="float: right" src="bilder/valid-xhtml10-blue.png" alt="Valid XHTML 1.0 Strict" height="31" width="88" />
<p>Badminton ist eine Abteilung im <a href="http://www.tsv-gersthofen.de/gesch%C3%A4ftsstelle/impressum.html?view=impressum&id=0"
<?php echo STD_NEW_WINDOW ?>>TSV Gersthofen (Impressum)</a><br />
© 2009-2016 - Abteilung Badminton</p>
</div>

</div>
</div>
</div>

<div id="wrapperbottom">&nbsp;</div>


</body>

</html>
