<?php
// TODO - EVERYTHING
$MyTab = array(array());

if(count($MannschaftArray))
{
	foreach ($MannschaftArray as $i => $Mannschaft)
	{
		if(!$i) {$MyTab[0][] = (string)$Mannschaft->getSaisonID(GET_OFID);}
		elseif(end($MyTab[0]) != ($s = (string)$Mannschaft->getSaisonID(GET_OFID))) {$MyTab[0][] = $s;}
	}
}
?>
<table>


	<thead>
		<tr class="even" style="height: 2.5em; font-size: 1.3em">
			<th>Saison</th>
		</tr>
	</thead>
	<tbody>
	<?php
	if(count($MyTab[0]))
	{
		foreach ($MyTab[0] as $i => $MyTab)
		{
			?>
		<tr class="<?php echo (($i%2)?('even'):('odd')) ?>">
			<td><?php echo $MyTab ?></td>
		</tr>
		<?php
		}
	}
	?>
	</tbody>
</table>
