<?php
if(!isset($Saison)) {$Saison = 'Saison';}
if(!isset($Bezirk)) {$Bezirk = 'Bezirk';}
if(!isset($Spielklasse)) {$Spielklasse = 'Spielklasse';}
if(!isset($HVerein)) {$HVerein = 'Heimverein';}
if(!isset($GVerein)) {$GVerein = 'Gastverein';}
$Austragungsort = $SpErMl->getAustragungsortID(GET_OFID);
$Sp = $SpErMl->getSpielSpErMlArray();
$Gewinner = 'Unentschieden';
$Ergebnis = $SpErMl->getErgebnis();
if(C_HEIMGEW == $Ergebnis) {$Gewinner = $HVerein;}
else if(C_GASTGEW == $Ergebnis) {$Gewinner = $GVerein;}
?>
<div class="dokument" style="margin-bottom: 0.5em">
<table style="text-align: left">
	<colgroup width="150px" span="1" />
	
	
	<tr>
		<th>Saison</th>
		<td><?php echo $Saison ?></td>
	</tr>
	<tr>
		<th>Bezirk</th>
		<td><?php echo $Bezirk ?></td>
	</tr>
	<tr>
		<th>Spielklasse</th>
		<td><?php echo $Spielklasse ?></td>
	</tr>
	<tr>
		<th>Ort/Datum</th>
		<td><?php echo $Austragungsort->getOrt().', den '.$SpErMl->getDatum(GET_DTDE) ?></td>
	</tr>
	<tr>
		<th>Austragungsort</th>
		<td><?php
			echo '<a href="index.php?section=hallen&amp;austragungsort_id='.$Austragungsort->getAustragungsortID().'">';
			echo $Austragungsort->getHallenname().'</a>';
		?></td>
	</tr>
</table>
</div>

<div class="dokument" style="margin-bottom: 0.5em">
<table>
	<colgroup width="45px" span="1" />
	
	
	<colgroup span="2" />
	
	
	<colgroup width="46px" span="3" />
	
	
	<colgroup width="50px" span="2" />
	
	
	<tr>
		<th>&nbsp;</th>
		<th><?php echo $HVerein ?></th>
		<th><?php echo $GVerein ?></th>
		<th>1.<br />
		Satz</th>
		<th>2.<br />
		Satz</th>
		<th>3.<br />
		Satz</th>
		<th>Sätze</th>
		<th>Spiele</th>
	</tr>

	<?php
	foreach($GLOBALS['Enum']['SpErMlSpieltyp'] as $i => $Tp)
	{
		echo '<tr class="'.(($i%2)?('even'):('odd')).'">'.PHP_EOL;

		echo '<td>'.C2S_SpErMlSpieltypKurz($Tp).'</td>'.PHP_EOL;
		foreach($GLOBALS['Enum']['Seite'] as $Seite) {
			echo '<td>';
			$AthProSeite = ((S_EINZEL == C2C_Spielart(C2C_Spieltyp($Tp)))?(1):(2));
			if(isset($Sp[$Tp])) {
				for($i=1; $i<=$AthProSeite; $i++) {
					echo (($i-1)?('<br />'.PHP_EOL):('')).$Sp[$Tp]->getKontrahent($Seite, $i, array(GET_SPEC, GET_NBSP));
				}
			}
			else {echo '&nbsp;';}
			echo '</td>'.PHP_EOL;
		}
		for($i=1; $i<=3; $i++) {
			echo '<td>'.((isset($Sp[$Tp]))?($Sp[$Tp]->getSatz($i, array(GET_SPEC, GET_NBSP))):('&nbsp;')).'</td>'.PHP_EOL;
		}
		echo '<td>'.((isset($Sp[$Tp]))?($Sp[$Tp]->getErgSaetze()):('&nbsp;')).'</td>'.PHP_EOL;
		echo '<td>'.((isset($Sp[$Tp]))?($Sp[$Tp]->getErgSpiel()):('&nbsp;')).'</td>'.PHP_EOL;

		echo '</tr>'.PHP_EOL;
	}
	?>
	<tr style="height: 2.2em; font-size: 1.2em">
		<th colspan="6">&nbsp;</th>
		<th><?php echo $SpErMl->getErgSaetze() ?></th>
		<th><?php echo $SpErMl->getErgSpiele() ?></th>
	</tr>
</table>
</div>

<div class="dokument">
<table style="text-align: left">
	<colgroup width="150px" span="1" />
	
	
	<tr>
		<th>Gewinner</th>
		<td><?php echo $Gewinner ?></td>
	</tr>
	<tr>
		<th>Bemerkungen</th>
		<td><?php echo $SpErMl->getBemerkungen(GET_NBSP) ?></td>
	</tr>
	<tr>
		<th>Ersatzsp. Heim</th>
		<td><?php
		$ErsaztspielerArray = $SpErMl->getErsatzspielerArrayForSeite(S_HEIM);
		if(count($ErsaztspielerArray)) {
			foreach($ErsaztspielerArray as $i => $Ersatzspieler) {
				echo (($i)?(' / '):('')).$Ersatzspieler->getAthletID(GET_OFID)->getNachnameVorname();
			}
		}
		else {echo '&nbsp;';}
		?></td>
	</tr>
	<tr>
		<th>Ersatzsp. Gast</th>
		<td><?php
		$ErsaztspielerArray = $SpErMl->getErsatzspielerArrayForSeite(S_GAST);
		if(count($ErsaztspielerArray)) {
			foreach($ErsaztspielerArray as $i => $Ersatzspieler) {
				echo (($i)?(' / '):('')).$Ersatzspieler->getAthletID(GET_OFID)->getNachnameVorname();
			}
		}
		else {echo '&nbsp;';}
		?></td>
	</tr>
</table>
</div>
