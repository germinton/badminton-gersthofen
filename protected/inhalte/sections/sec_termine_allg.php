<h1>Allgemeine Termine</h1>

<p>Hier eine Übersicht unserer Termine der nächsten 13 Monate. Typischerweise sind hier Infos zu anstehenden Ausflügen
oder Turnieren notiert. Die Punktspieltermine findet ihr unter <?php EchoLink('termine_psb') ?>.</p>

<?php

$TerminAllgArrayArray = CTerminAllg::getRecentTerminAllgArrayArray();

echo '<ul>'."\n";
foreach($TerminAllgArrayArray as $MonatString => $TerminAllgArray)
{
	if(count($TerminAllgArray))
	{
		$TerminAll = reset($TerminAllgArray);
		do {echo '<li><a href="#termin_id:'.$TerminAll->getTerminID().'">'.$TerminAll.'</a></li>'."\n";}
		while($TerminAll = next($TerminAllgArray));
	}
}
echo '</ul>'."\n";




$IsFirstMonth = true;
foreach($TerminAllgArrayArray as $MonatString => $TerminAllgArray)
{
	if(count($TerminAllgArray))
	{
		echo '<h2>'.$MonatString.'</h2>'."\n";
		foreach ($TerminAllgArray as $TerminAllg) {
			echo $TerminAllg->getXHTML();
			echo STD_P_UPARROW.PHP_EOL;
		}
	}
	else
	{
		if($IsFirstMonth) {
			echo '<h2>'.$MonatString.'</h2>'."\n";
			echo '<p class="textbox schattiert">Keine Termine im '.substr($MonatString, 0, strlen($MonatString)-5).'.</p>';
		}
	}
	$IsFirstMonth = false;
}
?>