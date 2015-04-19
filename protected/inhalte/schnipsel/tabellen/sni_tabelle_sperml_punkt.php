<table>

	<colgroup span="3" />
	
	
	<thead>
		<tr class="even" style="height: 2.5em; font-size: 1.3em">
			<th>Datum</th>
			<th>Ort</th>
			<th>Begegnung</th>
		</tr>
	</thead>
	<tbody>
	<?php
	if(count($SpErMl_X_Array))
	{
		foreach ($SpErMl_X_Array as $i => $SpErMl_X)
		{
			$HRefString = 'index.php?section=sperml_punkt'.(($s = $data['fs_string'])?($s):('')).'&amp;sperml_id='.$SpErMl_X->getSpErMlID();
			?>
		<tr class="<?php echo (($i%2)?('even'):('odd')) ?>">
			<td><a href="<?php echo $HRefString ?>"><?php echo $SpErMl_X->getDatum(GET_DTDE) ?></a></td>
			<td><a href="<?php echo $HRefString ?>"><?php echo 


			((strlen($s = $SpErMl_X->getAustragungsortID(GET_OFID)->getOrt()) > 18)?(substr($s, 0, 18).'...'):($s))

			?></a></td>
			<td><a href="<?php echo $HRefString ?>"><?php echo $SpErMl_X ?></a></td>
		</tr>
		<?php
		}
	}
	?>
	</tbody>
</table>
