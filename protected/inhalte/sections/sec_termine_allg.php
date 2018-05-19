<h1>Kalender</h1>

<div style="float: right; margin-left: 40px;">
	<a href="kalender/kalender.html?title=Abteilungskalender&calendars=Punktspielkalender,Hallenkalender,Events" target="_blank">
	<img src="bilder/kalender-logo.jpg" style="
		width: 110px;
		display: block;
		margin: 0 auto;
	">
	</a>
</div>

<p>
Wir sind nicht nur in der Halle eine aktive Abteilung, sondern unternehmen auch sonst viel miteinander. Hier ist eine Übersicht aller anstehenden Ausflüge und Turniere in den kommenden 13 Monaten. Die Punktspieltermine sind unter Punktspieltermine zu finden, die normalen Trainingstermine unter <?php EchoLink('training') ?>. Mit einem Klick auf das Kalender-Logo öffnet sich der <a href="kalender/kalender.html?title=Abteilungskalender&calendars=Punktspielkalender,Hallenkalender,Events" target="_blank">Badminton-Kalender der Abteilung</a> mit allen Terminen im Überblick.
</p>

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