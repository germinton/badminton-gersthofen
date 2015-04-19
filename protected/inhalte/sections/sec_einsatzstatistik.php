<form action="index.php" method="get" id="form_filter_sort" class="dokument">

<div class="control hidden"><input type="hidden" name="section" value="einsatzstatistik" /></div>

<div class="control line"><label for="fltr1" class="left">Geschlecht</label> <select name="fltr1" id="fltr1">
<?php
echo '<option value="0"'.((0 == $data['fltr1'])?(' selected="selected"'):('')).'>Alle</option>'."\n";
echo '<option value="1"'.((1 == $data['fltr1'])?(' selected="selected"'):('')).'>Herren</option>'."\n";
echo '<option value="2"'.((2 == $data['fltr1'])?(' selected="selected"'):('')).'>Damen</option>'."\n";
?>
</select></div>

<div class="control">
<button type="submit" class="right">Anwenden</button>
</div>

</form>

<h1>Einsatzstatistik<br />
<span style="font-size: .8em">zum <?php echo S2S_Datum_MySql2Deu(CDBConnection::getInstance()->getRdDateMitgliederEinsaetze(GET_DTDE)) ?></span></h1>


<div id="einsatzstatistik">
<table>
	<tr>
		<th rowspan="2">Platz</th>
		<th rowspan="2">Name</th>
		<th rowspan="2">Gesamt</th>
		<th colspan="3">Aktivenmannschaft</th>
		<th colspan="2">Mannschaft</th>
		<th rowspan="2">Einzel</th>
		<th rowspan="2">Doppel</th>
		<th rowspan="2">Mixed</th>
	</tr>
	<tr>
		<th>I.</th>
		<th>II.</th>
		<th>III.</th>
		<th>J</th>
		<th>S</th>
	</tr>

	<?php

	function NoZeros($Value)
	{
		return (($Value)?($Value):('&nbsp;'));
	}

	if(count($data['MitgliederArray']))
	{
		foreach ($data['MitgliederArray'] as $i => $Mitglied)
		{
			echo '<tr class="'.(($i%2)?('even'):('odd')).' platz'.$i.'">'."\n";
			echo '<td>'.++$i.'</td>'."\n";
			echo '<td style="text-align: left;">&nbsp;'.$Mitglied->getVornameNachname().'</td>'."\n";
			echo '<td>'.$Mitglied->statEinsaetze().'</td>'."\n";
			echo '<td>'.NoZeros($Mitglied->statEinsaetze('A1')).'</td>'."\n";
			echo '<td>'.NoZeros($Mitglied->statEinsaetze('A2')).'</td>'."\n";
			echo '<td>'.NoZeros($Mitglied->statEinsaetze('A3')).'</td>'."\n";
			echo '<td>'.NoZeros($Mitglied->statEinsaetze('J')).'</td>'."\n";
			echo '<td>'.NoZeros($Mitglied->statEinsaetze('S')).'</td>'."\n";
			echo '<td>'.NoZeros($Mitglied->statEinsaetze('E')).'</td>'."\n";
			echo '<td>'.NoZeros($Mitglied->statEinsaetze('D')).'</td>'."\n";
			echo '<td>'.NoZeros($Mitglied->statEinsaetze('M')).'</td>'."\n";
			echo '</tr>'."\n";
		}
	}


	?>

</table>
</div>
