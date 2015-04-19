<h1>Willkommen auf unserer Website</h1>

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

<h2>Bist Du ein Interessent?</h2>
<p>Bei uns sind Neugierige aller Alters- und Leistungsklassen herzlich willkommen. Auf diesen Seiten findest Du
Informationen über unsere <a href="index.php?section=training">Trainingszeiten und -gruppen</a> sowie eine <a
	href="index.php?section=diesparte">Vorstellung unserer Sparte</a>.</p>

<h2>Neuigkeiten</h2>
<?php
if(count($NeuigkeitArray = CNeuigkeit::getRecentNeuigkeitArray())) {
	foreach ($NeuigkeitArray as $Neuigkeit) {echo $Neuigkeit->getXHTML();}
}
else {
	echo '<p class="textbox schattiert">Es gibt aktuell keine Neuigkeiten.</p>';
}
?>