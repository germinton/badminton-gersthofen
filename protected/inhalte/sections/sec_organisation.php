<h1>Organisation</h1>

<p>
  Die Abteilung Badminton lebt vom ehrenamtlichen Engagement ihrer Mitglieder. Die anfallenden Tätigkeiten sind bewusst auf viele Schultern verteilt. Die Zusammenarbeit innerhalb der Abteilung regeln im Rahmen der Satzung des Vereins die Abteilungsordnung oder weitere einschlägige Ordnungen des Vereins (z.B. wenn in unserer Abteilungsordnung keine Regelung getroffen ist oder auf diese verwiesen wird):
</p>

<ul>
	<li><a href="downloads/Abteilungsordnung_Badminton.pdf">Abteilungsordnung</a></li>
	<li><a href="http://www.tsv-gersthofen.de/gesch%C3%A4ftsstelle/satzung-und-ordnungen.html"<?php echo STD_NEW_WINDOW ?>>Satzung und Ordnungen des Vereins</a></li>
</ul>

<p>
  Der <strong>Abteilungsvorstand</strong> wird auf der jährlichen Mitgliederversammlung der Abteilung für 2 Jahre gewählt. Er erledigt die laufenden Geschäfte der Abteilung. Zu seinen Aufgaben gehört insbesondere die Verwaltung des Etats der Abteilung.
</p>

<p>
  Eine Vielzahl von <strong>Fachwarten</strong> unterstützt den Vorstand durch die Übernahme von Tätigkeiten in abgegrenzten Themengebieten.
</p>

<p>
  In den <strong>Ausschüssen</strong> findet der Austausch zwischen den Fachwarten zu sich überschneidenden Themen statt. Jeder Ausschuss wird von einem federführenden Fachwart geleitet.
</p>
<ul>
	<li><a
  	href="index.php?section=aufgabenverteilung">Überblick aller Fachwarte der Abteilung</a></li>
	<li><a href="downloads/Abteilungsorganisation.pdf">Aufgabenbeschreibung der Fachwarte und Zusammensetzung der Ausschüsse</a></li>
  <li>Abteilungsvorstand:
    <?php
    $SortierungArray = array();
    $MitgliedArray = array();

    $AthletIDArray = CAufgabenzuordnung::getAthletIDArray(array(S_ABTEILUNGSLEITER, S_ABTEILUNGSSCHATZMEISTER, S_ABTEILUNGSJUGENDLEITER, S_CHEFTRAINER, S_SPORTWARTWETTKAMPF));
    $SortedAthletIDArray = CAufgabenzuordnung::getSortedAthletIDArray($AthletIDArray);

    foreach ($SortedAthletIDArray as $AthletID) {
        $TempMitglied = new CMitglied($AthletID);

        if ($TempMitglied->getAnrede() == S_DAME) {
            array_unshift($MitgliedArray, $TempMitglied);
        } else {
            $MitgliedArray[] = $TempMitglied;
        }
    }

    if ($Mitglied = reset($MitgliedArray)) {
        do {
            echo sni_ProfilMitgliedVorstand($Mitglied->getAthletID());
            echo STD_P_UPARROW.PHP_EOL;
        } while ($Mitglied = next($MitgliedArray));
    } else {
        echo '<p>&nbsp;</p>'.PHP_EOL;
        echo '<p class="textbox schattiert">Es ist aktuell kein Vorstand angelegt.</p>'.PHP_EOL;
    }
    ?>
  </li>
  <li>Stellvertreter:
    <?php
    $SortierungArray = array();
    $MitgliedArray = array();

    $AthletIDArray = CAufgabenzuordnung::getAthletIDArray(array(S_ABTEILUNGSLEITER2, S_ABTEILUNGSSCHATZMEISTER2, S_ABTEILUNGSJUGENDLEITER2));
    $SortedAthletIDArray = CAufgabenzuordnung::getSortedAthletIDArray($AthletIDArray);

    foreach ($SortedAthletIDArray as $AthletID) {
        $TempMitglied = new CMitglied($AthletID);

        if ($TempMitglied->getAnrede() == S_DAME) {
            array_unshift($MitgliedArray, $TempMitglied);
        } else {
            $MitgliedArray[] = $TempMitglied;
        }
    }

    if ($Mitglied = reset($MitgliedArray)) {
        do {
            echo sni_ProfilMitgliedVorstand($Mitglied->getAthletID());
            echo STD_P_UPARROW.PHP_EOL;
        } while ($Mitglied = next($MitgliedArray));
    } else {
        echo '<p>&nbsp;</p>'.PHP_EOL;
        echo '<p class="textbox schattiert">Es ist aktuell kein Vorstand angelegt.</p>'.PHP_EOL;
    }
    ?>
  </li>
</ul>
