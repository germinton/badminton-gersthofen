<h1>Erwachsenen-Training</h1>

<img src="bilder/training_erwachsene.jpg" alt="Erwachsenen-Training" />

<p>Das <strong>Erwachsenen-Training</strong> steht allen <strong>über 18 jährigen Sportlern</strong> offen. Dabei sind Anfänger
genauso willkommen wie erfahrende Spieler, die bereits über Kenntnisse in Schlag- und 
Lauftechnik verfügen. Auch wer nur vorübergehend in der Region Augsburg und Umland ist 
(z.B. Studenten), findet im TSV Gersthofen sein Badminton-Zuhause auf Zeit.
</p>

<p>Das Aufwärmen erfolgt dabei gemeinsam mit einem Spiel oder Lauf- und Dehnungsübungen.
Im angeleiteten Training wird die Sportlergruppe nach Vorkenntnissen getrennt. Ziel ist es 
allen Athleten Lauf- und Schlagtechniken zu vermitteln. Taktische Strategien und die 
Umsetzung des Erlernten in die Praxis erfolgt im freien Spiel.</p>

<p>&nbsp;</p>
<p>Ablauf des Trainings:</p>
<ul>
	<li>45min: gemeinsames Aufwärmen</li>
	<li>45min: angeleitetes Training</li>
	<li>90min: freies Spiel zum Ausprobieren des Erlernten</li>
</ul>

<p>&nbsp;</p>
<p>Trainingszeiten:</p>
<table class="schattiert">
			<tr>
				<th>Freitag</th>
				<td>
				<p>19-22Uhr<br />
				<a href="#austragungsort_id:3">PKG-Halle</a></p></td>
			</tr>
			<tr>
				<th>Sonntag</th>
				<td>
				<p>19:30-22Uhr<br />
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

$AthletIDArray = CAufgabenzuordnung::getAthletIDArray(array(S_ERWACHSENENTRAINER));
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