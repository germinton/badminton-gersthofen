<?php

/***********************************************************************************************************************
 * @file
 * Definition der Navigationsleisten.
 * Definiert die 'golbale' Navigationsleiste oben links sowie die Hauptnavigation in der linken Spalte, die wiederum
 * in eine öffentliche ('public') und eine interne ('internal') Navigation unterteilt ist.
 **********************************************************************************************************************/

/***********************************************************************************************************************
 * Navigation ohne Untergruppen, die oben links erscheint und jedem Besucher zugänglich ist.
 **********************************************************************************************************************/
$NavContGlb = new CNavCont('nav_glb');
$NavContGlb->add(new CNav(1, 'startseite', 'Startseite'));
$NavContGlb->add(new CNav(1, 'kontakt', 'Kontakt'));
$NavContGlb->add(new CNav(2, 'login_vergessen', 'Login Vergessen', true));

/***********************************************************************************************************************
 * Navigation mit Untergruppen, die am linken Rand erscheint und jedem Besucher zugänglich ist.
 **********************************************************************************************************************/
$NavContPub = new CNavCont('nav_pub');
$NavContPub->add(new CNav(1, 'dieabteilung', 'Die Abteilung'));
$NavContPub->add(new CNav(2, 'organisation', 'Organisation'));
$NavContPub->add(new CNav(2, 'aufgabenverteilung', 'Aufgabenverteilung', true));
$NavContPub->add(new CNav(2, 'gebuehren', 'Gebühren'));
$NavContPub->add(new CNav(2, 'termine_allg', 'Termine'));
$NavContPub->add(new CNav(2, 'galerie', 'Bildergalerie', true));
$NavContPub->add(new CNav(2, 'faq', 'FAQ'));
$NavContPub->add(new CNav(1, 'training', 'Training'));
$NavContPub->add(new CNav(2, 'training_schueler', 'Schüler-Training'));
$NavContPub->add(new CNav(2, 'training_jugend', 'Jugend-Training'));
$NavContPub->add(new CNav(2, 'training_erwachsene', 'Erwachsenen-Training'));
$NavContPub->add(new CNav(2, 'sportstaetten', 'Sportstätten'));
$NavContPub->add(new CNav(2, 'trainer', 'Unsere Trainer'));
$NavContPub->add(new CNav(2, 'rangliste', 'Rangliste'));
$NavContPub->add(new CNav(1, 'spielbetrieb', 'Spielbetrieb'));
$NavContPub->add(new CNav(2, 'mannschaften', 'Mannschaften &amp; Ergebnisse', true));
$NavContPub->add(new CNav(2, 'termine_psb', 'Punktspieltermine', true));
$NavContPub->add(new CNav(2, 'einsatzstatistik', 'Einsatzstatistik', true));
$NavContPub->add(new CNav(2, 'archiv', 'Archiv', true));
$NavContPub->add(new CNav(3, 'sperml_punkt', 'Punktspiele', true));
$NavContPub->add(new CNav(3, 'sperml_freund', 'Freundschaftsspiele', true));
$NavContPub->add(new CNav(1, 'service', 'Service'));
$NavContPub->add(new CNav(2, 'links', 'Links'));
$NavContPub->add(new CNav(2, 'downloads', 'Downloads'));
$NavContPub->add(new CNav(2, 'hallen', 'Sporthallen', true));
$NavContPub->add(new CNav(2, 'vereine', 'Vereine', true));
$NavContPub->add(new CNav(1, 'kontakt', 'Kontakt'));

/***********************************************************************************************************************
 * Navigation mit Untergruppen, die nur eingeloggten, berechtigten Mitgliedern zugänglich ist.
 **********************************************************************************************************************/
/*
 * Navigationselemente mit Berechtigungseinschränkung
 * ==================================================
 *
 * Ein Objekt der 'CNav'-Klasse wird wie folgt konstruiert:
 *
 * new CNav([Navigationsebene],  Aufwärts sind keine Sprünge (z. B. von 1 nach 3) erlaubt!
 *          ['section'-String],  Die Zeichenkette in der URL: index.php?section=...
 *          [Beschriftung],      Der für den Besucher sichtbare Text in der Navigationsleiste
 *          [hat Modul?],        Wenn ja, wird nach einem PHP-Skript mit namen mod_['section'-String] gesucht
 *          [zugänglich für Mitglieder die diese Aufgaben haben],
 *          [zugänglich für Mitglieder mit dieser 'athlet_id'])
 *
 * - Aufgbenbezogene Berechtigungen werden gleich nach der Konstruktion in 'athlet_id's umgewandelt.
 * - Berechtigungen werden vererbt.
 * - Ist das 'athlet_id'-Array leer, so ist das Navigationselement für jedes eingeloggte Mitglied zuänglich, sofern
 *   keine Berechtigungen von übergeordneten Ebenen vererbt wurden.
 *
 */
$NavContInt = new CNavCont('nav_int');

$NavContInt->add(new CNav(1, 'profil', 'Mein Profil'));
$NavContInt->add(new CNav(2, 'prof_aendernlogin', 'Benutzername/Passwort', true));
$NavContInt->add(new CNav(2, 'prof_aendernperson', 'Persönliche Daten', true));

$NavContInt->add(new CNav(1, 'meineabteilung', 'Meine Abteilung'));
$NavContInt->add(new CNav(2, 'ms_steckbriefe', 'Steckbriefe', true));
$NavContInt->add(new CNav(2, 'ms_shuttlekids', 'Shuttle-Kids'));
$NavContInt->add(new CNav(2, 'ms_adressenliste', 'Adressenliste', true,
array(
  S_ABTEILUNGSLEITER,
  S_KOMMUNIKATIONSWART,
  S_SPIELLEITENDESTELLE,
  S_SCHUELERTRAINER,
  S_JUGENDTRAINER,
  S_ERWACHSENENTRAINER,
  S_SCHIEDSRICHTER,
  S_SCHIEDSRICHTEROBMANN,
  S_STAFFELLEITER,
  S_MANNSCHAFTSFUEHRER,
  S_MANNSCHAFTSFUEHRER_M,
  S_JUGENWART,
  S_WEBMASTER,
  S_EVENTWART,
  S_ABTEILUNGSSCHATZMEISTER,
  S_SPORTWARTWETTKAMPF,
  S_SPORTWARTTRAINING,
  S_CHEFTRAINER,
)));

$NavContInt->add(new CNav(1, 'verw_website', 'Website-Verwaltung', false,
array(S_ABTEILUNGSLEITER, S_WEBMASTER), array(14)));
$NavContInt->add(new CNav(2, 'verw_neuigkeiten', 'Neuigkeiten', true,
array(
  S_KOMMUNIKATIONSWART,
  S_SPIELLEITENDESTELLE,
  S_JUGENDTRAINER,
  S_ERWACHSENENTRAINER,
  S_SCHIEDSRICHTER,
  S_SCHIEDSRICHTER,
  S_SCHIEDSRICHTEROBMANN,
  S_STAFFELLEITER,
  S_MANNSCHAFTSFUEHRER,
  S_MANNSCHAFTSFUEHRER_M,
  S_JUGENWART,
  S_EVENTWART,
  S_EVENTWART_SCHUELERJUGEND,
  S_ABTEILUNGSSCHATZMEISTER,
  S_SPORTWARTWETTKAMPF,
  S_SPORTWARTTRAINING,
  S_CHEFTRAINER,
)));

$NavContInt->add(new CNav(2, 'verw_termine_allg', 'Termine (allg.)', true,
array(
  S_KOMMUNIKATIONSWART,
  S_JUGENDTRAINER,
  S_ERWACHSENENTRAINER,
  S_SCHIEDSRICHTER,
  S_SCHIEDSRICHTER,
  S_SCHIEDSRICHTEROBMANN,
  S_JUGENWART,
  S_SPORTWARTWETTKAMPF,
  S_SPORTWARTTRAINING,
  S_EVENTWART,
  S_EVENTWART_SCHUELERJUGEND,
  S_CHEFTRAINER,
)));

$NavContInt->add(new CNav(2, 'verw_termine_psb', 'Punktspieltermine', true,
array(
  S_SPIELLEITENDESTELLE,
  S_STAFFELLEITER,
  S_MANNSCHAFTSFUEHRER,
  S_MANNSCHAFTSFUEHRER_M,
  S_SPORTWARTWETTKAMPF,
)));

$NavContInt->add(new CNav(2, 'verw_galerie', 'Bildergalerie', true,
array(
  S_KOMMUNIKATIONSWART,
  S_EVENTWART,
  S_EVENTWART_SCHUELERJUGEND,
  S_JUGENWART,
)));

$NavContInt->add(new CNav(1, 'dienste', 'Dienste'));
$NavContInt->add(new CNav(2, 'dienste_trainingsorga', 'Trainingsorganisation'));
$NavContInt->add(new CNav(2, 'dienste_aktivitaeten', 'Aktivitätenprotokoll', true,
array(S_ABTEILUNGSLEITER, S_WEBMASTER)));

$NavContInt->add(new CNav(2, 'dienste_rundmail', 'Rundmail', true, S_DBENTWICKLER));

$NavContInt->add(new CNav(1, 'verw_stammdaten', 'Stammdaten-Verwaltung', false, S_DBENTWICKLER));
$NavContInt->add(new CNav(2, 'verw_mitglieder', 'Mitglieder', true,
array(
  S_ABTEILUNGSLEITER,
  S_WEBMASTER,
  S_CHEFTRAINER,
  S_JUGENDTRAINER,
  S_ERWACHSENENTRAINER,
  S_SCHIEDSRICHTER,
  S_JUGENWART,
)));
$NavContInt->add(new CNav(2, 'verw_aufgaben', 'Aufgaben', true));
$NavContInt->add(new CNav(2, 'verw_aufgabenzuordnungen', 'Aufgabenzuordnungen', true,
array(S_ABTEILUNGSLEITER, S_WEBMASTER), array(14)));
$NavContInt->add(new CNav(2, 'verw_gegner', 'Gegner', true));
$NavContInt->add(new CNav(2, 'verw_mannschaften', 'Mannschaften', true,
array(S_ABTEILUNGSLEITER, S_WEBMASTER), array(14)));
$NavContInt->add(new CNav(2, 'verw_austragungsorte', 'Austragungsorte', true,
array(S_ABTEILUNGSLEITER, S_WEBMASTER), array(14)));
$NavContInt->add(new CNav(2, 'verw_vereine', 'Vereine', true,
array(S_ABTEILUNGSLEITER, S_WEBMASTER), array(14)));
$NavContInt->add(new CNav(2, 'verw_ligenklassen', 'LigenKlassen', true,
array(S_ABTEILUNGSLEITER, S_WEBMASTER), array(14)));
$NavContInt->add(new CNav(2, 'verw_saisons', 'Saisons', true));

$NavContInt->add(new CNav(1, 'db_verwaltung', 'Datenbank-Verwaltung', false, S_DBENTWICKLER));
$NavContInt->add(new CNav(2, 'db_werkzeuge', 'Werkzeuge', true,
array(S_ABTEILUNGSLEITER, S_WEBMASTER, S_JUGENWART), array(14)));

$NavContInt->add(new CNav(1, 'wartung', 'Wartung', true, S_DBENTWICKLER));
$NavContInt->add(new CNav(2, 'chk_datenbank', 'Datenbank prüfen', true, array(S_WEBMASTER)));
$NavContInt->add(new CNav(2, 'chk_attachments', 'Attachments prüfen', true, array(S_WEBMASTER)));
$NavContInt->add(new CNav(2, 'chk_quick_script', 'Start QuickScript!', true));

$NavContInt->add(new CNav(1, 'debug', 'Klassen-Debugging', false, S_DBENTWICKLER));
$NavContInt->add(new CNav(2, 'dbg_datenbank', 'Datenbank-Objekte'));
$NavContInt->add(new CNav(3, 'dbg_class_db_connection', 'Debug CDBConnection', true));
$NavContInt->add(new CNav(2, 'dbg_datensatz', 'Datensatz-Objekte'));
$NavContInt->add(new CNav(3, 'dbg_class_athlet', 'Debug CAthlet', true));
$NavContInt->add(new CNav(3, 'dbg_class_aufgabe', 'Debug CAufgabe', true));
$NavContInt->add(new CNav(3, 'dbg_class_aufgabenzuordnung', 'Debug CAufgabenzuordnung', true));
$NavContInt->add(new CNav(3, 'dbg_class_austragungsort', 'Debug CAustragungsort', true));
$NavContInt->add(new CNav(3, 'dbg_class_ersatzspieler', 'Debug CErsatzspieler', true));
$NavContInt->add(new CNav(3, 'dbg_class_gegner', 'Debug CGegner', true));
$NavContInt->add(new CNav(3, 'dbg_class_kontrahent', 'Debug CKontrahent', true));
$NavContInt->add(new CNav(3, 'dbg_class_ligaklasse', 'Debug CLigaKlasse', true));
$NavContInt->add(new CNav(3, 'dbg_class_mannschaft', 'Debug CMannschaft', true));
$NavContInt->add(new CNav(3, 'dbg_class_mitglied', 'Debug CMitglied', true));
$NavContInt->add(new CNav(3, 'dbg_class_neuigkeit', 'Debug CNeuigkeit', true));
$NavContInt->add(new CNav(3, 'dbg_class_saison', 'Debug CSaison', true));
$NavContInt->add(new CNav(3, 'dbg_class_satz', 'Debug CSatz', true));
$NavContInt->add(new CNav(3, 'dbg_class_sperml', 'Debug CSpErMl', true));
$NavContInt->add(new CNav(3, 'dbg_class_spiel_sperml', 'Debug CSpielSpErMl', true));
$NavContInt->add(new CNav(3, 'dbg_class_spiel', 'Debug CSpiel', true));
$NavContInt->add(new CNav(3, 'dbg_class_tabelle', 'Debug CTabelle', true));
$NavContInt->add(new CNav(3, 'dbg_class_tabelleneintrag', 'Debug CTabelleneintrag', true));
$NavContInt->add(new CNav(3, 'dbg_class_termin_allg', 'Debug CTerminAllg', true));
$NavContInt->add(new CNav(3, 'dbg_class_termin_psb', 'Debug CTerminPSB', true));
$NavContInt->add(new CNav(3, 'dbg_class_termin', 'Debug CTermin', true));
$NavContInt->add(new CNav(3, 'dbg_class_turnier', 'Debug CTurnier', true));
$NavContInt->add(new CNav(3, 'dbg_class_turnierathlet', 'Debug CTurnierathlet', true));
$NavContInt->add(new CNav(3, 'dbg_class_turniermeldung', 'Debug CTurniermeldung', true));
$NavContInt->add(new CNav(3, 'dbg_class_verein', 'Debug CVerein', true));
$NavContInt->add(new CNav(2, 'dbg_website', 'Website-Objekte'));
$NavContInt->add(new CNav(3, 'dbg_class_nav', 'Debug CNav', true));

$NavContInt->add(new CNav(1, 'lorem_ipsum', 'Lorem ipsum', false, S_WEBMASTER, array(14)));
$NavContInt->add(new CNav(2, 'bildergalerie', 'Bildergalerie (alt)'));
