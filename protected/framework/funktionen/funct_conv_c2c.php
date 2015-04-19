<?php
/*******************************************************************************************************************//**
 * @file
 * Konversion von Konstanten in Konstanten.
 * Das Präfix 'C2C_' steht für 'constant to constant'.
 * @ingroup grp_converter
 **********************************************************************************************************************/
include_once(dirname(__FILE__).'/../konstanten/const__all.php');

/*******************************************************************************************************************//**
 * Konvertiert eine 'Altersklasse'-Konstante in eine 'Altersklassengruppe'-Konstante.
 **********************************************************************************************************************/
function C2C_Altersklasse($Altersklasse)
{
	switch($Altersklasse)
	{
		case C_U11:
		case C_U13:
		case C_U15: return S_SCHUELER; break;
		case C_U17:
		case C_U19: return S_JUGEND; break;
		default: break;
	}
	return S_AKTIVE;
}

/*******************************************************************************************************************//**
 * Konvertiert eine 'Spieltyp'-Konstante in eine 'Spielart'-Konstante.
 **********************************************************************************************************************/
function C2C_Spielart($Spieltyp)
{
	switch($Spieltyp)
	{
		case S_HDTYP:
		case S_DDTYP: return S_DOPPEL; break;
		case S_HETYP:
		case S_DETYP: return S_EINZEL; break;
		case S_MXTYP: return S_MIXED; break;
		default: break;
	}
	return null;
}

/*******************************************************************************************************************//**
 * Konvertiert eine 'SpErMlSpieltyp'-Konstante in eine 'Spieltyp'-Konstante.
 **********************************************************************************************************************/
function C2C_Spieltyp($SpErMlSpieltyp)
{
	switch($SpErMlSpieltyp)
	{
		case S_SPERMLHD1TYP:
		case S_SPERMLHD2TYP: return S_HDTYP; break;
		case S_SPERMLDDTYP: return S_DDTYP; break;
		case S_SPERMLDETYP: return S_DETYP; break;
		case S_SPERMLHE1TYP:
		case S_SPERMLHE2TYP:
		case S_SPERMLHE3TYP: return S_HETYP; break;
		case S_SPERMLMXTYP: return S_MXTYP; break;
		default: break;
	}
	return null;
}

/*******************************************************************************************************************//**
 * Konvertiert eine 'Modus'-Konstante in eine 'View'-Konstante.
 **********************************************************************************************************************/
function C2C_Modus($Modus)
{
	switch($Modus)
	{
		case MODE_OVERVIEW:
		case MODE_DROP:
		case MODE_SAVE:
		case MODE_CANCEL: return VIEW_LIST; break;
		case MODE_NEW:
		case MODE_EDIT: return VIEW_DETAIL; break;
		default: break;
	}
	return null;
}
?>