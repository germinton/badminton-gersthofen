<?php
/*******************************************************************************************************************//**
 * @file
 * Konstanten, die nichts mit der Datenbank zu tun haben. Die unterschiedlichen Präfixe gruppieren die Konstanten.
 **********************************************************************************************************************/

/*******************************************************************************************************************//**
 * @name 'Verzeichnispfad'-Konstanten relativ zum htdocs-root-Verzeichnis und ohne abschließenden Backslash
 ****************************************************************************************************************//*@{*/
define('DIR_ATTACHMENTS', 'attachments');
/*@{*/

/*******************************************************************************************************************//**
 * @name 'Dateipfad'-Konstanten relativ zum htdocs-root-Verzeichnis
 ****************************************************************************************************************//*@{*/
define('FILE_NOPIC', 'bilder/nopic.gif');
define('FILE_NOATTACH', 'bilder/icons/icon_nofile_100x100.png');
define('FILE_ICON_GEN', 'bilder/icons/icon_gen_100x100.png');
define('FILE_ICON_PIC', 'bilder/icons/icon_pic_100x100.png');
define('FILE_ICON_PDF', 'bilder/icons/icon_pdf_100x100.png');
define('FILE_ICON_DOC', 'bilder/icons/icon_doc_100x100.png');
define('FILE_ICON_XLS', 'bilder/icons/icon_xls_100x100.png');
/*@{*/

/*******************************************************************************************************************//**
 * @name Picasa Nutzername zur Verwaltung der Bildergalerie
 ****************************************************************************************************************//*@{*/
define('PICASA_USER', 'germinton');
/*@{*/

/*******************************************************************************************************************//**
 * @name Start- und Ende der XHTML-Zeichenkette für die Standard-Fehlermeldung.
 ****************************************************************************************************************//*@{*/
define('MSG_ERROR_START', '<div class="error papier"><p>Fehler</p><p>');
define('MSG_ERROR_END', '</p></div>');
/*@{*/

/*******************************************************************************************************************//**
 * @name 'Maximum'-Konstanten
 ****************************************************************************************************************//*@{*/
define('MAX_SAETZE', 3);
define('MAX_BEGEGNUNGNR', 10);
define('MAX_ERSATZSPIELER', 20);
define('MAX_PUNKTE', 30);
define('MAX_SORT', 255);
define('MAX_MANNSCHAFTEN', 19);
define('MAX_ERG_TAB_PLAETZE', 50);
define('MAX_ERG_TAB_ANZ_SPIELE', 100);
define('MAX_ERG_TAB_PUNKTE', 200);
define('MAX_ERG_TAB_SPIELE', 1600);
define('MAX_ERG_TAB_SAETZE', 4800);
define('MAX_PLATZ_MANN', 20);
define('MAX_PLATZ_TURN', 255);
define('MAX_FELDER', 20);
define('MAX_IMG_DIM', 800);
define('MAX_IMG_RATIO_BIGPART', 16);
define('MAX_IMG_RATIO_SMLPART', 9);
define('MAX_WOCHEN_NEUIGKEITEN', 2);
define('MAX_WOCHEN_TERMINEALLG', 2);
define('MAX_WOCHEN_TERMINEPSB', 2);
define('MAX_FILE_SIZE_ATTACH_PIC', 2097152); // 2 MiB = 2 * 1048576 B
define('MAX_FILE_SIZE_ATTACH_FILE', 4194304); // 4 MiB = 3 * 1048576 B
/*@{*/

/*******************************************************************************************************************//**
 * @name 'Mode'-Formularaktion-Konstanten
 ****************************************************************************************************************//*@{*/
define('MODE_OVERVIEW', 1);
define('MODE_DROP', 2);
define('MODE_SAVE', 3);
define('MODE_NEW', 4);
define('MODE_EDIT', 5);
define('MODE_CANCEL', 6);
/*@{*/

/*******************************************************************************************************************//**
 * @name 'View'-Formularansicht-Konstanten
 ****************************************************************************************************************//*@{*/
define('VIEW_LIST', 1);
define('VIEW_DETAIL', 2);
/*@{*/

/*******************************************************************************************************************//**
 * @name 'Attachment-Type'-Konstanten
 ****************************************************************************************************************//*@{*/
define('ATTACH_PIC', 1);
define('ATTACH_FILE1', 2);
define('ATTACH_FILE2', 3);
define('ATTACH_FILE3', 4);
/*@{*/

/*******************************************************************************************************************//**
 * @name 'Attachment-Process'-Konstanten
 ****************************************************************************************************************//*@{*/
define('PROC_NIL', 1);
define('PROC_UPL', 2);
define('PROC_NEW', 3);
define('PROC_DEL', 4);
/*@{*/

/*******************************************************************************************************************//**
 * @name 'RegEx'-Zeichenketten
 ****************************************************************************************************************//*@{*/
define('REGEX_PLZ', '~\A\d{5}\z~');
define('REGEX_DATE_SQ', '~\A\d{4}-\d{2}-\d{2}\z~');
define('REGEX_DATE_DE', '~\A\d{2}.\d{2}.\d{4}\z~');
define('REGEX_EMAIL', '/^([a-z0-9])(([-a-z0-9._])*([a-z0-9]))*\@([a-z0-9])(([a-z0-9-])*([a-z0-9]))+(\.([a-z0-9])([-a-z0-9_-])?([a-z0-9])+)+$/i');
define('REGEX_STDCHR', '~\A\w*\z~');
define('REGEX_TIME', '~\A\d{2}:\d{2}:\d{2}\z~');
define('REGEX_DATETIME_SQ', '~\A\d{4}-\d{2}-\d{2} \d{2}:\d{2}:\d{2}\z~');
define('REGEX_DATETIME_DE', '~\A\d{2}.\d{2}.\d{4} \d{2}:\d{2}:\d{2}\z~');
define('REGEX_FLOAT', '~\A[-+]{0,1}([0-9]{0,3}\.[0-9]+|[0-9]+)\z~');
/*@{*/

/*******************************************************************************************************************//**
 * @name Flags für 'Getter'-Memberfunktionen
 ****************************************************************************************************************//*@{*/
define('GET_NBSP', 1); // non-breaking space
define('GET_CLIP', 2); // clipped
define('GET_DTDE', 3); // date 'deutsch'
define('GET_C2SC', 4); // C2S(constant to string)-converter
define('GET_HSPC', 5); // htmlspecialchars()
define('GET_SPEC', 6); // special
define('GET_OFID', 7); // 'object for ID'
/*@{*/

/*******************************************************************************************************************//**
 * @name 'Monat'-Konstanten
 ****************************************************************************************************************//*@{*/
define('M_JAN', 1);
define('M_FEB', 2);
define('M_MAE', 3);
define('M_APR', 4);
define('M_MAI', 5);
define('M_JUN', 6);
define('M_JUL', 7);
define('M_AUG', 8);
define('M_SEP', 9);
define('M_OKT', 10);
define('M_NOV', 11);
define('M_DEZ', 12);
/*@{*/

/*******************************************************************************************************************//**
 * @name allgemeine Zeichenketten
 ****************************************************************************************************************//*@{*/
define('STR_ATH_LOCK', 'Die Athletdaten können momentan nicht verändert werden, da die Datenbank gerade aktualisiert wird. Bitte probiere es später nochmal.');
define('STD_META_DESC', 'Informationen zum Training, Spielbetrieb und den Freizeitaktivitäten der Badmintonsparte des TSV Gersthofen. Gersthofen ist eine Stadt am nördlichen Stadtrand von Augsburg.');
define('STD_NEW_WINDOW', 'onclick="void(window.open(this.href, \'\', \'\')); return false;"');
define('STD_P_UPARROW', '<p class="uparrow"><a href="#head">up&nbsp;&uarr;</a></p>');
define('GMAP_API_KEY', 'ABQIAAAAyMOau66JonYn2P6Mrcj-1xQHpc12iIBOnIzylQ12pkg4M3qA4xTrz1bylkp5Ii-4YOsTbdJJMwET2g');
/*@{*/
?>