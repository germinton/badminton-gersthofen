<h1>Schüler-Training</h1>

<img src="bilder/training_schueler.jpg" alt="Schüler-Training" />

<p>Das Schüler-Training wendet sich an alle Kinder im <strong>Alter von 8-12 Jahren</strong>, die den Badminton 
Sport erlernen möchten. Spielerisch werden den Kids Lauf- und Schlagtechniken vermittelt. 
Die Schülermannschaften führen die leistungsstarken Kids an den Punktspielbetrieb heran 
und lehren Team- sowie Kampfgeist. Im Training ist ausreichend Raum und Zeit vorhanden, 
um dem Bedürfnis nach Bewegung und Spiel in diesem Alter Gerecht zu werden.</p>

<p>&nbsp;</p>
<p>Ablauf des Trainings:</p>
<ul>
	<li>30min: gemeinsames Aufwärmen</li>
	<li>30min: angeleitetes Training</li>
	<li>30min: freies Spiel zum Ausprobieren des Erlernten</li>
</ul>

<p>&nbsp;</p>
<p>Trainingszeiten:</p>
<table class="schattiert">
			<tr>
				<th>Freitag</th>
				<td>
				<p>16-17:30Uhr<br />
				<a href="#austragungsort_id:3">PKG-Halle</a></p></td>
			</tr>
			<tr>
				<th>Sonntag</th>
				<td>
				<p>18-19:30Uhr<br />
				<a href="#austragungsort_id:278">Mittelschulhalle (neu)</a></p></td>
			</tr>
		</table>
<ul>
	<li>Ein Einstieg ist jederzeit möglich!</li>
	<li>Änderungen von Trainingszeiten werden stets auf der <a href="index.php">Startseite</a> kommuniziert!</li>
</ul>

<p>&nbsp;</p>
<p>Trainer:<br>
Folgende Trainer betreuen die Schüler-Gruppe:
<?php
$SortierungArray = array();
$MitgliedArray = array();

$AthletIDArray = CAufgabenzuordnung::getAthletIDArray(array(S_SCHUELERTRAINER));
$SortedAthletIDArray = CAufgabenzuordnung::getSortedAthletIDArray($AthletIDArray);

foreach($SortedAthletIDArray as $AthletID)
{
	$TempMitglied = new CMitglied($AthletID);
	
	if($TempMitglied->getAnrede() == S_DAME)
	{
		array_unshift($MitgliedArray, $TempMitglied);
	}
	else
	{
		$MitgliedArray[] = $TempMitglied;
	}
}

if($Mitglied = reset($MitgliedArray)){
	do
	{
		echo sni_ProfilMitgliedSteckbrief($Mitglied->getAthletID());
		echo STD_P_UPARROW.PHP_EOL;
	}
	while($Mitglied = next($MitgliedArray));
} else {
	echo '<p>&nbsp;</p>'.PHP_EOL;
	echo '<p class="textbox schattiert">Es sind aktuell keine Trainer angelegt.</p>'.PHP_EOL;
}


?>
</p>

<p>&nbsp;</p>
<p>Kosten:</p>
<ul>
	<li>Unter <a href="index.php?section=gebuehren">Gebühren</a> ist eine Übersicht der Kosten zu finden.</li>
</ul>

<p>&nbsp;</p>
<p>Zusätzlich:<br>
	Sind noch Fragen offen? Häufige Fragen und Antworten sind unter <a href="index.php?section=faq">FAQ</a> zu finden!</p>