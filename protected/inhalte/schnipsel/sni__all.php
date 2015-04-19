<?php
/*******************************************************************************************************************//**
 * @file
 * Funktionen zur XHTML-Rückgabe von "Schnipseln".
 **********************************************************************************************************************/

/*******************************************************************************************************************//**
 * Gibt das Standard-Profil für eine Mannschaft zurück.
 **********************************************************************************************************************/
function sni_ProfilMannschaft($MannschaftID)
{
	try {
		$f = dirname(__FILE__).'/profile/sni_profil_mannschaft.php';
		if(!is_file($f)) {throw new Exception('Schnipsel \''.$f.'\' nicht gefunden.');}
		$Mannschaft = new CMannschaft($MannschaftID);
		ob_start(); include $f; $c = ob_get_contents(); ob_end_clean();
	}
	catch(Exception $e) {$c=MSG_ERROR_START.$e->getMessage().MSG_ERROR_END;}
	return $c.PHP_EOL;
}

/*******************************************************************************************************************//**
 * Gibt das Archiv-Profil für eine Mannschaft zurück.
 **********************************************************************************************************************/
function sni_ProfilMannschaftArchiv($MannschaftID)
{
	try {
		$f = dirname(__FILE__).'/profile/sni_profil_mannschaft_archiv.php';
		if(!is_file($f)) {throw new Exception('Schnipsel \''.$f.'\' nicht gefunden.');}
		$Mannschaft = new CMannschaft($MannschaftID);
		ob_start(); include $f; $c = ob_get_contents(); ob_end_clean();
	}
	catch(Exception $e) {$c=MSG_ERROR_START.$e->getMessage().MSG_ERROR_END;}
	return $c.PHP_EOL;
}

/*******************************************************************************************************************//**
 * Gibt das Standard-Profil für einen Austragungsort zurück.
 **********************************************************************************************************************/
function sni_ProfilAustragungsort($AustragungsortID)
{
	try {
		$f = dirname(__FILE__).'/profile/sni_profil_austragungsort.php';
		if(!is_file($f)) {throw new Exception('Schnipsel \''.$f.'\' nicht gefunden.');}
		$Austragungsort = new CAustragungsort($AustragungsortID);
		ob_start(); include $f; $c = ob_get_contents(); ob_end_clean();
	}
	catch(Exception $e) {$c=MSG_ERROR_START.$e->getMessage().MSG_ERROR_END;}
	return $c.PHP_EOL;
}

/*******************************************************************************************************************//**
 * Gibt das private Profil für ein Mitglied zurück.
 **********************************************************************************************************************/
function sni_ProfilMitgliedPrivat($AthletID)
{
	try {
		$f = dirname(__FILE__).'/profile/sni_profil_mitglied_privat.php';
		if(!is_file($f)) {throw new Exception('Schnipsel \''.$f.'\' nicht gefunden.');}
		$Mitglied = new CMitglied($AthletID);
		ob_start(); include $f; $c = ob_get_contents(); ob_end_clean();
	}
	catch(Exception $e) {$c=MSG_ERROR_START.$e->getMessage().MSG_ERROR_END;}
	return $c.PHP_EOL;
}

/*******************************************************************************************************************//**
 * Gibt den Steckbrief für ein Mitglied zurück.
 **********************************************************************************************************************/
function sni_ProfilMitgliedSteckbrief($AthletID)
{
	try {
		$f = dirname(__FILE__).'/profile/sni_profil_mitglied_steckbrief.php';
		if(!is_file($f)) {throw new Exception('Schnipsel \''.$f.'\' nicht gefunden.');}
		$Mitglied = new CMitglied($AthletID);
		ob_start(); include $f; $c = ob_get_contents(); ob_end_clean();
	}
	catch(Exception $e) {$c=MSG_ERROR_START.$e->getMessage().MSG_ERROR_END;}
	return $c.PHP_EOL;
}

/*******************************************************************************************************************//**
 * Gibt die Visitenkarte für ein Mitglied zurück.
 **********************************************************************************************************************/
function sni_ProfilMitgliedVisitenkarte($AthletID)
{
	try {
		$f = dirname(__FILE__).'/profile/sni_profil_mitglied_visitenkarte.php';
		if(!is_file($f)) {throw new Exception('Schnipsel \''.$f.'\' nicht gefunden.');}
		$Mitglied = new CMitglied($AthletID);
		ob_start(); include $f; $c = ob_get_contents(); ob_end_clean();
	}
	catch(Exception $e) {$c=MSG_ERROR_START.$e->getMessage().MSG_ERROR_END;}
	return $c.PHP_EOL;
}
?>