<h1>Mannschaften <?php echo $data['saison'] ?></h1>
<p>Der TSV Gersthofen hat in dieser Saison <?php echo count($data['mannschaft_array']) ?> Mannschaften im Spielbetrieb:</p>

<?php
if($Mannschaft = reset($data['mannschaft_array']))
{
	echo '<ul>'."\n";
	do {echo '<li><a href="#mannschaft_id:'.$Mannschaft->getMannschaftID().'">'.$Mannschaft.' ('.$Mannschaft->getLigaKlasseID(GET_OFID).')'.'</a></li>'."\n";}
	while($Mannschaft = next($data['mannschaft_array']));
	echo '</ul>'."\n";

	echo '<p>&nbsp;</p>'."\n";

	$Mannschaft = reset($data['mannschaft_array']);
	do
	{
		echo sni_ProfilMannschaft($Mannschaft->getMannschaftID()).PHP_EOL;
		echo STD_P_UPARROW.PHP_EOL;
	}
	while($Mannschaft = next($data['mannschaft_array']));
}
else {
	echo '<p>&nbsp;</p>'.PHP_EOL;
	echo '<p class="textbox schattiert">Es sind aktuell keine Mannschaften angelegt.</p>'.PHP_EOL;
}
?>