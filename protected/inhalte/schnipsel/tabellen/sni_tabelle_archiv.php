<table>


	<thead>
		<tr class="even" style="height: 2.5em; font-size: 1.3em">
			<th>Saison</th>
			<th>Mannschaft</th>
			<th>Foto</th>
		</tr>
	</thead>
	<tbody>
	<?php
	if(count($MannschaftArray))
	{
		foreach ($MannschaftArray as $i => $Mannschaft)
		{
			$HRefString = 'index.php?section=archiv'.(($s = $data['fs_string'])?($s):('')).'&amp;mannschaft_id='.$Mannschaft->getMannschaftID();
			?>
		<tr class="<?php echo (($i%2)?('even'):('odd')) ?>" style="height: 104px">
			<td><?php echo $Mannschaft->getSaisonID(GET_OFID) ?></td>
			<td><a href="<?php echo $HRefString ?>"><?php echo $Mannschaft ?></a></td>
			<td><a href="<?php echo $HRefString ?>"><?php echo $Mannschaft->getXHTMLforIMG(true, 100) ?></a></td>
		</tr>
		<?php
		}
	}
	?>
	</tbody>
</table>
