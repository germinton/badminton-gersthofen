<h1>Trainer</h1>
<p>Die Sparte Badminton gibt es im TSV Gersthofen seit Ende 1995 und erfreut sich seit dem Start einer zunehmenden
Beliebtheit. Grund hierfür sind nicht nur die Geselligkeit und die gute Organisation der Sparte, sondern vor allem die
hohe Qualität unseres Trainings. Möglich machen dies unsere gut ausgebildeten Trainer, die das Aktvien-, Jugend- und
Schülertraining durchführen. Alle Übungsleiter sind vom Bayerischen Badminton Verband ausgebildet und geprüft worden.</p>
<p>Nachfolgend findest Du ein Kurzportrait zu jedem unserer Trainer:</p>
<?php
$SortierungArray = array();
$MitgliedArray = array();

$AthletIDArray = CAufgabenzuordnung::getAthletIDArray(array(S_TRAINER, S_CHEFTRAINER));
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

if($Mitglied = reset($MitgliedArray))
{
	echo '<ul>'."\n";
	do {echo '<li><a href="#athlet_id:'.$Mitglied->getAthletID().'">'.$Mitglied.'</a></li>'."\n";}
	while($Mitglied = next($MitgliedArray));
	echo '</ul>'."\n";
	
	echo '<p>Ehemalige Trainer</p>'."\n";
	
	$MitgliedChristoph = new CMitglied(11);
	$MitgliedMaiLinh = new CMitglied(5);
	
	echo '<ul>'."\n";
	echo '<li><a href="#athlet_id:'.$MitgliedChristoph->getAthletID().'">'.$MitgliedChristoph.'</a></li>'."\n";
	echo '<li><a href="#athlet_id:'.$MitgliedMaiLinh->getAthletID().'">'.$MitgliedMaiLinh.'</a></li>'."\n";
	echo '</ul>'."\n";

	echo '<p>&nbsp;</p>'."\n";

	$Mitglied = reset($MitgliedArray);
	do
	{
		echo sni_ProfilMitgliedSteckbrief($Mitglied->getAthletID());
		echo STD_P_UPARROW.PHP_EOL;
	}
	while($Mitglied = next($MitgliedArray));
	
	echo '<p>&nbsp;</p>'."\n";
	echo '<h1>Ehemalige Trainer</h1>'."\n";
	
	echo sni_ProfilMitgliedSteckbrief($MitgliedChristoph->getAthletID());
	echo STD_P_UPARROW.PHP_EOL;
	echo sni_ProfilMitgliedSteckbrief($MitgliedMaiLinh->getAthletID());
	echo STD_P_UPARROW.PHP_EOL;
}
else {
	echo '<p>&nbsp;</p>'.PHP_EOL;
	echo '<p class="textbox schattiert">Es sind aktuell keine Trainer angelegt.</p>'.PHP_EOL;
}
?>