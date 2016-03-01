<h1>Badminton – Dein Sport!</h1>

<?php
if($Nbr= CTerminAllg::getNumberOfTermine(3))
{
	echo '<div style="float: right; width:320px; margin-bottom: 10px; margin-left: 40px">'."\n";
	echo '<div class="grundiert" style="text-align: center; padding: 3px" >'."\n";
	echo '<em>Termin-Erinnerung</em>'."\n";
	echo '</div>'."\n";
	echo '<div class="schattiert" style="text-align: center; height:50px; padding:8px" >'."\n";
	echo '<img src="bilder/kalender.jpg" alt="Kalender" height="50" style="float:left; margin-right: 15px" />'."\n";
	echo 'In den nächsten 3 Monaten steh'.((1==$Nbr)?('t'):('en')).' '.$Nbr.' Termin'.((1==$Nbr)?(''):('e')).' an.'."\n";
	echo 'Wirf einen Blick in die <a href="index.php?section=termine_allg">Termin-Übersicht</a>.'."\n";
	echo '</div>'."\n";
	echo '</div>'."\n";
}
?>

<h2>Du interessierst Dich für Badminton – wie können wir Dir helfen?</h2>
<p><a href="index.php?section=dieabteilung">Die Abteilung Badminton</a> im 
TSV 1909 Gersthofen e. V. heißt alle Federball-Interessierten in Augsburg und 
Umgebung herzlich willkommen. Unser Trainingsangebot richtet sich sowohl an 
erfahrende Spieler, als auch an Freizeitspieler. Egal wie alt oder jung Du bist, 
wir haben das richtige Trainingsangebot für Dich. 
<strong>Was können wir für Dich tun?</strong></p>

<div class="training_type_container">
	<a href="index.php?section=training_schueler"><div class="training_type_box"><div>Unser Kind möchte Badminton spielen lernen!</div></div></a>
	<a href="index.php?section=training_jugend"><div class="training_type_box"><div>Ich bin Jugendlicher und möchte gerne Badminton spielen!</div></div></a>
	<a href="index.php?section=training_erwachsene"><div class="training_type_box"><div>Freizeitspieler war ich lange genug, jetzt will ich Profi werden!</div></div></a>
	<a href="index.php?section=training_erwachsene"><div class="training_type_box"><div>Erfahrener Badmintonspieler sucht neuen Verein!</div></div></a>
</div>

<h2>Neuigkeiten</h2>
<?php
if(count($NeuigkeitArray = CNeuigkeit::getRecentNeuigkeitArray())) {
	foreach ($NeuigkeitArray as $Neuigkeit) {echo $Neuigkeit->getXHTML();}
}
else {
	echo '<p class="textbox schattiert">Es gibt aktuell keine Neuigkeiten.</p>';
}
?>