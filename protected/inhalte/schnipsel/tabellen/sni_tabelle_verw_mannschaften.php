<table>
	<colgroup width="26" span="2" />
	
	
	<colgroup span="4" />
	
	
	<thead>
		<tr>
			<th colspan="2">&nbsp;</th>
			<th>Saison</th>
			<th>Mannschaft</th>
			<th>Liga/Klasse</th>
			<th>Bild</th>
		</tr>
	</thead>
	<tbody>
	<?php
	if(count($MannschaftArray))
	{
		foreach ($MannschaftArray as $i => $Mannschaft)
		{
			?>
		<tr class="<?php echo (($i%2)?('even'):('odd')) ?>">
			<td>
			<button type="submit" class="icon" name="edit" value="<?php echo $Mannschaft->getMannschaftID() ?>"><img
				src="bilder/buttons/b_edit.png" title="Bearbeiten" alt="Bearbeiten" width="16" height="16" /></button>
			</td>
			<td><?php if($Mannschaft->isDeletable()) { ?>
			<button type="submit" class="icon" name="drop" value="<?php echo $Mannschaft->getMannschaftID() ?>"
				onclick="return confirm('Die Mannschaft \'<?php echo $Mannschaft.' (Saison '.$Mannschaft->getSaisonID(GET_OFID).')' ?>\' wirklich löschen?')"><img
				src="bilder/buttons/b_drop.png" title="Löschen" alt="Löschen" width="16" height="16" /></button>
				<?php } else {echo '&nbsp;';} ?></td>
			<td><?php echo $Mannschaft->getSaisonID(GET_OFID) ?></td>
			<td><?php echo $Mannschaft ?></td>
			<td><?php echo $Mannschaft->getLigaKlasseID(GET_OFID) ?></td>
			<td><?php echo $Mannschaft->hasAttachment(ATTACH_PIC, GET_SPEC) ?></td>
		</tr>
		<?php
		}
	}
	?>
	</tbody>
</table>
