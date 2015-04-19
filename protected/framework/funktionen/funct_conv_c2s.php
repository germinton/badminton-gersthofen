<?php
/*******************************************************************************************************************//**
 * @file
 * Konversion von Konstanten in Zeichenketten.
 * Das Präfix 'C2S_' steht für 'constant to string'. Diese Funktionen werden unter anderem in den 'get'-Memberfunktionen
 * der 'Datensatz'-Klassen genutzt, sofern diese eine 'GET_C2SC'-Konstante übergeben bekommen, die anzeigt, dass der
 * Rückgabewert gleich konvertiert werden soll.
 * @ingroup grp_converter
 **********************************************************************************************************************/
include_once(dirname(__FILE__).'/../konstanten/const__all.php');

/*******************************************************************************************************************//**
 * @brief Konvertiert eine 'Seite'-Konstante in eine Zeichenketten
 **********************************************************************************************************************/
function C2S_Seite($Seite)
{
	switch($Seite)
	{
		case S_HEIM: return 'Heim'; break;
		case S_GAST: return 'Gast'; break;
		default: break;
	}
	return null;
}

/*******************************************************************************************************************//**
 * @brief Konvertiert eine 'AttachType'-Konstante in eine Zeichenketten
 **********************************************************************************************************************/
function C2S_AttachType($AttachType)
{
	switch($AttachType)
	{
		case ATTACH_PIC: return 'PIC'; break;
		case ATTACH_FILE1: return 'FILE1'; break;
		case ATTACH_FILE2: return 'FILE2'; break;
		case ATTACH_FILE3: return 'FILE3'; break;
		default: break;
	}
	return null;
}

/*******************************************************************************************************************//**
 * @brief Konvertiert eine '(Spiel)Ebene'-Konstante in eine Zeichenketten
 **********************************************************************************************************************/
function C2S_Ebene($Ebene)
{
	switch($Ebene)
	{
		case S_EBENE_INTERN: return 'Verein'; break;
		case S_EBENE_STADT: return 'Stadt'; break;
		case S_EBENE_LANDKREIS: return 'Landkreis'; break;
		case S_EBENE_BEZIRK: return 'Bezirk'; break;
		case S_EBENE_BUNDESLAND: return 'Bundesland'; break;
		case S_EBENE_REGION: return 'Regional'; break;
		case S_EBENE_NATIONAL: return 'National'; break;
		case S_EBENE_EUROPA: return 'Europa'; break;
		case S_EBENE_WELT: return 'Welt'; break;
		default: break;
	}
	return null;
}

/*******************************************************************************************************************//**
 * @brief Konvertiert eine 'Himmelsrichtung'-Konstante in eine Zeichenketten
 **********************************************************************************************************************/
function C2S_HRichtung($HRichtung)
{
	switch($HRichtung)
	{
		case S_NORD: return 'Nord'; break;
		case S_NORDOST: return 'Nordost'; break;
		case S_OST: return 'Ost'; break;
		case S_SUEDOST: return 'Südost'; break;
		case S_SUED: return 'Süd'; break;
		case S_SUEDWEST: return 'Südwest'; break;
		case S_WEST: return 'West'; break;
		case S_NORDWEST: return 'Nordwest'; break;
		default: break;
	}
	return null;
}

/*******************************************************************************************************************//**
 * @brief Konvertiert eine '(Spiel)Ebene'-Konstante in eine Zeichenketten (Alternative zu Funktion 'C2S_Ebene()')
 **********************************************************************************************************************/
function C2S_Meister($Ebene)
{
	switch($Ebene)
	{
		case S_EBENE_INTERN: return 'Vereinsmeister'; break;
		case S_EBENE_STADT: return 'Stadtmeister'; break;
		case S_EBENE_LANDKREIS: return 'Landkreismeister'; break;
		case S_EBENE_BEZIRK: return 'Bezirksmeister'; break;
		case S_EBENE_BUNDESLAND: return 'Landesmeister'; break;
		case S_EBENE_REGION: return 'Regionalmeister'; break;
		default: break;
	}
	return null;
}

/*******************************************************************************************************************//**
 * @brief Konvertiert eine 'Anrede'-Konstante in eine Zeichenketten
 **********************************************************************************************************************/
function C2S_Anrede($Anrede)
{
	switch($Anrede)
	{
		case S_HERR: return 'Herr'; break;
		case S_DAME: return 'Frau'; break;
		case S_GEMISCHT: return 'gemischt'; break;
		default: break;
	}
	return null;
}

/*******************************************************************************************************************//**
 * @brief Konvertiert eine 'Anrede'-Konstante in eine Zeichenketten (Alternative zu Funktion 'C2S_Anrede()')
 **********************************************************************************************************************/
function C2S_Geschlecht($Anrede)
{
	switch($Anrede)
	{
		case S_HERR: return 'männlich'; break;
		case S_DAME: return 'weiblich'; break;
		case S_GEMISCHT: return 'gemischt'; break;
		default: break;
	}
	return null;
}

/*******************************************************************************************************************//**
 * @brief Konvertiert eine 'Ergebnis'-Konstante in eine Zeichenketten
 **********************************************************************************************************************/
function C2S_Ergebnis($Ergebnis)
{
	switch($Ergebnis)
	{
		case C_HEIMGEW: return 'Heim gewinnt'; break;
		case C_GASTGEW: return 'Gast gewinnt'; break;
		case C_UNENTSCH: return 'unentschieden'; break;
		default: break;
	}
	return null;
}

/*******************************************************************************************************************//**
 * @brief Konvertiert eine 'Altersklassengruppe'-Konstante in eine Zeichenketten
 **********************************************************************************************************************/
function C2S_AKlaGruppe($AKlaGruppe)
{
	switch($AKlaGruppe)
	{
		case S_SCHUELER: return 'Schüler'; break;
		case S_JUGEND: return 'Jugend'; break;
		case S_AKTIVE: return 'Aktive'; break;
		default: break;
	}
	return null;
}

/*******************************************************************************************************************//**
 * @brief Konvertiert eine 'Altersklasse'-Konstante in eine Zeichenketten
 **********************************************************************************************************************/
function C2S_Altersklasse($Altersklasse)
{
	switch($Altersklasse)
	{
		case C_U11: return 'U11'; break;
		case C_U13: return 'U13'; break;
		case C_U15: return 'U15'; break;
		case C_U17: return 'U17'; break;
		case C_U19: return 'U19'; break;
		case C_U22: return 'U22'; break;
		case C_O22: return 'O22'; break;
		case C_O30: return 'O30'; break;
		case C_O35: return 'O35'; break;
		case C_O40: return 'O40'; break;
		case C_O45: return 'O45'; break;
		case C_O50: return 'O50'; break;
		case C_O55: return 'O55'; break;
		case C_O60: return 'O60'; break;
		case C_O65: return 'O65'; break;
		default: break;
	}
	return null;
}

/*******************************************************************************************************************//**
 * @brief Konvertiert eine 'Monat'-Konstante in eine Zeichenketten
 **********************************************************************************************************************/
function C2S_Monat($Monat)
{
	switch($Monat)
	{
		case M_JAN: return 'Januar'; break;
		case M_FEB: return 'Februar'; break;
		case M_MAE: return 'März'; break;
		case M_APR: return 'April'; break;
		case M_MAI: return 'Mai'; break;
		case M_JUN: return 'Juni'; break;
		case M_JUL: return 'Juli'; break;
		case M_AUG: return 'August'; break;
		case M_SEP: return 'September'; break;
		case M_OKT: return 'Oktober'; break;
		case M_NOV: return 'November'; break;
		case M_DEZ: return 'Dezember'; break;
		default: break;
	}
	return null;
}

/*******************************************************************************************************************//**
 * @brief Konvertiert eine 'Spieltyp'-Konstante in eine Zeichenketten
 **********************************************************************************************************************/
function C2S_Spieltyp($Spieltyp)
{
	switch($Spieltyp)
	{
		case S_HDTYP: return 'Herrendoppel'; break;
		case S_DDTYP: return 'Damendoppel'; break;
		case S_HETYP: return 'Herreneinzel'; break;
		case S_DETYP: return 'Dameneinzel'; break;
		case S_MXTYP: return 'Mixed'; break;
		case S_MFTYP: return 'Mannschaftskampf'; break;
		default: break;
	}
	return null;
}

/*******************************************************************************************************************//**
 * @brief Konvertiert eine 'Spieltyp'-Konstante in eine Zeichenketten (Alternative zu Funktion 'C2S_Spieltyp()')
 **********************************************************************************************************************/
function C2S_SpieltypKurz($Spieltyp)
{
	switch($Spieltyp)
	{
		case S_HDTYP: return 'HD'; break;
		case S_DDTYP: return 'DD'; break;
		case S_HETYP: return 'HE'; break;
		case S_DETYP: return 'DE'; break;
		case S_MXTYP: return 'MX'; break;
		case S_MFTYP: return 'MFK'; break;
		default: break;
	}
	return null;
}

/*******************************************************************************************************************//**
 * @brief Konvertiert eine 'SpErMlSpieltyp'-Konstante in eine Zeichenketten
 **********************************************************************************************************************/
function C2S_SpErMlSpieltyp($SpErMlSpieltyp)
{
	switch($SpErMlSpieltyp)
	{
		case S_SPERMLHD1TYP: return '1. Herrendoppel'; break;
		case S_SPERMLHD2TYP: return '2. Herrendoppel'; break;
		case S_SPERMLDDTYP: return 'Damendoppel'; break;
		case S_SPERMLHE1TYP: return '1. Herreneinzel'; break;
		case S_SPERMLHE2TYP: return '2. Herreneinzel'; break;
		case S_SPERMLDETYP: return 'Dameneinzel'; break;
		case S_SPERMLHE3TYP: return '3. Herreneinzel'; break;
		case S_SPERMLMXTYP: return 'Mixed'; break;
		default: break;
	}
	return null;
}

/*******************************************************************************************************************//**
 * @brief Konvertiert eine 'SpErMlSpieltyp'-Konstante in eine Zeichenketten  (Alter. zu Funktion 'C2S_SpErMlSpieltyp()')
 **********************************************************************************************************************/
function C2S_SpErMlSpieltypKurz($SpErMlSpieltyp)
{
	switch($SpErMlSpieltyp)
	{
		case S_SPERMLHD1TYP: return '1. HD'; break;
		case S_SPERMLHD2TYP: return '2. HD'; break;
		case S_SPERMLDDTYP: return 'DD'; break;
		case S_SPERMLHE1TYP: return '1. HE'; break;
		case S_SPERMLHE2TYP: return '2. HE'; break;
		case S_SPERMLDETYP: return 'DE'; break;
		case S_SPERMLHE3TYP: return '3. HE'; break;
		case S_SPERMLMXTYP: return 'Mixed'; break;
		default: break;
	}
	return null;
}

/*******************************************************************************************************************//**
 * @brief Konvertiert eine 'Aufgabentyp'-Konstante in eine Zeichenketten
 **********************************************************************************************************************/
function C2S_Aufgabentyp($Aufgabentyp)
{
	switch($Aufgabentyp)
	{
		case S_VERWALTUNG: return 'Verwaltung'; break;
		case S_TRABETRIEB: return 'Trainingsbetrieb'; break;
		case S_SPIBETRIEB: return 'Spielbetrieb'; break;
		default: break;
	}
	return null;
}

/*******************************************************************************************************************//**
 * @brief Konvertiert eine 'Spielregel'-Konstante in eine Zeichenketten
 **********************************************************************************************************************/
function C2S_Spielregel($Spielregel)
{
	switch($Spielregel)
	{
		case S_SpR_2xVerl: return '2xVerlängerung'; break;
		case S_SpR_1xVerlNurDEKurz: return '1xVerlNurDEKurz'; break;
		case S_SpR_1xVerlDameKurz: return '1xVerlDamenspieleKurz'; break;
		case S_SpR_RallyPoint: return 'RallyPoint'; break;
		default: break;
	}
	return null;
}

/*******************************************************************************************************************//**
 * @brief Konvertiert eine 'Turniertyp'-Konstante in eine Zeichenketten
 **********************************************************************************************************************/
function C2S_Turniertyp($Turniertyp)
{
	switch($Turniertyp)
	{
		case S_MEISTERSCHAFT: return 'Meisterschaft'; break;
		case S_RANGLISTE: return 'Rangliste'; break;
		default: break;
	}
	return null;
}
?>