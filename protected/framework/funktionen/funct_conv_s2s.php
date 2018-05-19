<?php
/*******************************************************************************************************************//**
 * @file
 * Konversion von Zeichenketten in Zeichenketten.
 * Das Präfix 'S2S_' steht für 'string to string'.
 * @ingroup grp_converter
 **********************************************************************************************************************/

/*******************************************************************************************************************//**
 * Konvertiert einen Datum-String vom Typ 'TT.MM.JJJJ' in den Typ 'JJJJ-MM-TT'.
 **********************************************************************************************************************/
function S2S_Datum_Deu2MySql($DeuDatum)
{
	if(strlen($DeuDatum)) {
		return substr($DeuDatum, 6, 4).'-'.substr($DeuDatum, 3, 2).'-'.substr($DeuDatum, 0, 2);
	}
	return null;
}

/*******************************************************************************************************************//**
 * Konvertiert einen Datum-String vom Typ 'JJJJ-MM-TT' in den Typ 'TT.MM.JJJJ'.
 **********************************************************************************************************************/
function S2S_Datum_MySql2Deu($MySqlDatum)
{
	if(strlen($MySqlDatum)) {
		return substr($MySqlDatum, 8, 2).'.'.substr($MySqlDatum, 5, 2).'.'.substr($MySqlDatum, 0, 4);
	}
	return null;
}

/*******************************************************************************************************************//**
 * Konvertiert einen DatumZeit-String vom Typ 'TT.MM.JJJJ HH:MM:SS' in den Typ 'JJJJ-MM-TT HH:MM:SS'.
 **********************************************************************************************************************/
function S2S_DatumZeit_Deu2MySql($DeuDatumZeit)
{
	if(strlen($DeuDatumZeit)) {
		return S2S_Datum_Deu2MySql(substr($DeuDatumZeit, 0, 10)).' '.substr($DeuDatumZeit, 11, 8);
	}
	return null;
}

/*******************************************************************************************************************//**
 * Konvertiert einen DatumZeit-String vom Typ 'JJJJ-MM-TT HH:MM:SS' in den Typ 'TT.MM.JJJJ HH:MM:SS'.
 **********************************************************************************************************************/
function S2S_DatumZeit_MySql2Deu($MySqlDatumZeit)
{
	if(strlen($MySqlDatumZeit)) {
		return S2S_Datum_MySql2Deu(substr($MySqlDatumZeit, 0, 10)).' '.substr($MySqlDatumZeit, 11, 8);
	}
	return null;
}

/*******************************************************************************************************************//**
 * Konvertiert einen Tabellenname-String in den zugehörigen ID-Name-String.
 **********************************************************************************************************************/
function S2S_TabName_IDName($TabName)
{
	switch($TabName)
	{
		case 'athleten': return 'athlet_id'; break;
		case 'athleten_gegner': return 'athlet_id'; break;
		case 'athleten_mitglieder': return 'athlet_id'; break;
		case 'aufgaben': return 'aufgabe_id'; break;
		case 'aufgabenzuordnungen': return 'aufgabenzuordnung_id'; break;
		case 'aufstellungen': return 'aufstellung_id'; break;
		case 'austragungsorte': return 'austragungsort_id'; break;
		case 'beitraege': return 'beitrag_id'; break;
		case 'ersatzspieler': return 'ersatzspieler_id'; break;
		case 'galerieeintraege': return 'galerieeintrag_id'; break;
		case 'kontrahenten': return 'kontrahent_id'; break;
		case 'ligenklassen': return 'ligaklasse_id'; break;
		case 'mannschaften': return 'mannschaft_id'; break;
		case 'mannschaftsspieler': return 'mannschaftsspieler_id'; break;
		case 'neuigkeiten': return 'neuigkeit_id'; break;
		case 'saetze': return 'satz_id'; break;
		case 'saisons': return 'saison_id'; break;
		case 'sperml': return 'sperml_id'; break;
		case 'sperml_freundschaft': return 'sperml_id'; break;
		case 'sperml_punktspiel_extern': return 'sperml_id'; break;
		case 'sperml_punktspiel_intern': return 'sperml_id'; break;
		case 'spiele': return 'spiel_id'; break;
		case 'spiele_sperml': return 'spiel_id'; break;
		case 'spiele_training': return 'spiel_id'; break;
		case 'tabellen': return 'tabelle_id'; break;
		case 'tabelleneintraege': return 'tabelleneintrag_id'; break;
		case 'termine': return 'termin_id'; break;
		case 'termine_allgemein': return 'termin_id'; break;
		case 'termine_pktspbeg': return 'termin_id'; break;
		case 'training': return 'training_id'; break;
		case 'turnierathleten': return 'turnierathlet_id'; break;
		case 'turniere': return 'turnier_id'; break;
		case 'turniermeldungen': return 'turniermeldung_id'; break;
		case 'vereine': return 'verein_id'; break;
		case 'vereine_benutzerinformationen': return 'verein_id'; break;
	}
	return null;
}
?>