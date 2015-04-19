<?php
/*******************************************************************************************************************//**
 * @file
 * Header-Datei für alle Klassen des Frameworks. Alle Dateien, die Klassen-Definitionen enthalten, sind in dieser Datei
 * mit der 'include_once'-Anweisung eingebunden.
 **********************************************************************************************************************/
include_once(dirname(__FILE__).'/datenbank/class_db_connection.php');
include_once(dirname(__FILE__).'/datenbank/class_drive_entity_with_attach.php');
include_once(dirname(__FILE__).'/datenbank/class_drive_entity.php');

include_once(dirname(__FILE__).'/datensatz/class_athlet.php');
include_once(dirname(__FILE__).'/datensatz/class_aufgabe.php');
include_once(dirname(__FILE__).'/datensatz/class_aufgabenzuordnung.php');
include_once(dirname(__FILE__).'/datensatz/class_austragungsort.php');
include_once(dirname(__FILE__).'/datensatz/class_ersatzspieler.php');
include_once(dirname(__FILE__).'/datensatz/class_galerieeintrag.php');
include_once(dirname(__FILE__).'/datensatz/class_gegner.php');
include_once(dirname(__FILE__).'/datensatz/class_kontrahent.php');
include_once(dirname(__FILE__).'/datensatz/class_ligaklasse.php');
include_once(dirname(__FILE__).'/datensatz/class_mannschaft.php');
include_once(dirname(__FILE__).'/datensatz/class_mitglied.php');
include_once(dirname(__FILE__).'/datensatz/class_neuigkeit.php');
include_once(dirname(__FILE__).'/datensatz/class_saison.php');
include_once(dirname(__FILE__).'/datensatz/class_satz.php');
include_once(dirname(__FILE__).'/datensatz/class_sperml_freundschaft.php');
include_once(dirname(__FILE__).'/datensatz/class_sperml_punktspiel_extern.php');
include_once(dirname(__FILE__).'/datensatz/class_sperml_punktspiel_intern.php');
include_once(dirname(__FILE__).'/datensatz/class_sperml.php');
include_once(dirname(__FILE__).'/datensatz/class_spiel_sperml.php');
include_once(dirname(__FILE__).'/datensatz/class_spiel.php');
include_once(dirname(__FILE__).'/datensatz/class_tabelle.php');
include_once(dirname(__FILE__).'/datensatz/class_tabelleneintrag.php');
include_once(dirname(__FILE__).'/datensatz/class_termin_allg.php');
include_once(dirname(__FILE__).'/datensatz/class_termin_psb.php');
include_once(dirname(__FILE__).'/datensatz/class_termin.php');
include_once(dirname(__FILE__).'/datensatz/class_turnier.php');
include_once(dirname(__FILE__).'/datensatz/class_turnierathlet.php');
include_once(dirname(__FILE__).'/datensatz/class_turniermeldung.php');
include_once(dirname(__FILE__).'/datensatz/class_verein.php');

include_once(dirname(__FILE__).'/website/class_myphpmailer.php');
include_once(dirname(__FILE__).'/website/class_nav_cont.php');
include_once(dirname(__FILE__).'/website/class_nav.php');
include_once(dirname(__FILE__).'/website/class_show_check_msg.php');
include_once(dirname(__FILE__).'/website/class_show_error.php');
include_once(dirname(__FILE__).'/website/class_show_exception.php');
include_once(dirname(__FILE__).'/website/class_show_info.php');
include_once(dirname(__FILE__).'/website/class_site_manager.php');
include_once(dirname(__FILE__).'/website/class_template_data.php');
include_once(dirname(__FILE__).'/website/class_upload_handler.php');
?>