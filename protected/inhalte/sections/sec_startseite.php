<?php

/*
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
*/
?>

<!-- Ballon-Cup -->
<div style="float: right; margin-bottom: 10px; margin-left: 40px; margin-top: 1.3em;">
	<div class="koerper">
		<a href="/balloncup" target="_blank">
			<img src="/bilder/vorabinfo_bc3.jpg" style="max-height:110px" />
		</a>
	</div>
</div>
<!-- -->


<!--
<div style="float: right; width:200px;height:140px; margin-bottom: 10px; margin-left: 40px;">
	<div class="koerper" style="">
		<a href="index.php?section=galerie&galerieeintrag_id=388">
			<img src="wordpress/wp-content/uploads/2017/11/0.jpg" style="max-height:201px;" />
		</a>
	</div>	
</div>
-->

<h2>Du interessierst Dich für Badminton – wie können wir Dir helfen?</h2>
<p>Das Trainingsangebot <a href="index.php?section=dieabteilung">der Abteilung Badminton</a> im
TSV 1909 Gersthofen e. V. richtet sich sowohl an erfahrene Spieler, als auch an
Freizeitspieler. Egal wie alt oder jung Du bist, wir haben das richtige
Trainingsangebot für Dich.<br>
<br>
<strong>Was können wir für Dich tun?</strong></p>

<p>&nbsp;</p>
<div class="training_type_container">
	<a href="index.php?section=training_schueler"><div class="training_type_box waves-effect waves-light btn"><div>Unser Kind möchte Badminton spielen lernen!</div></div></a>
	<a href="index.php?section=training_jugend"><div class="training_type_box"><div>Ich bin Jugendlicher und möchte gerne Badminton spielen!</div></div></a>
	<a href="index.php?section=training_erwachsene"><div class="training_type_box"><div>Noch Freizeitspieler oder schon Profi? Herzlich Willkommen in der Aktiven-Gruppe!</div></div></a>
	<a href="kalender/kalender.html?title=Trainingskalender&calendars=Hallenkalender" target="_blank"><div class="training_type_box" style="background-color: #5D5D5D;"><div>Kommende Trainingstermine</div></div></a>
</div>

<p>&nbsp;</p>

<h2>Neuigkeiten</h2>
<?php
if(count($NeuigkeitArray = CNeuigkeit::getRecentNeuigkeitArray())) {
	foreach ($NeuigkeitArray as $Neuigkeit) {echo $Neuigkeit->getXHTML();}
}
else {
	echo '<p class="textbox schattiert">Es gibt aktuell keine Neuigkeiten.</p>';
}
?>
