<table>
	<colgroup width="26" span="2" />
	
	
	<colgroup span="3" />
	
	
	<thead>
		<tr>
			<th colspan="2">&nbsp;</th>
			<th>Aufgabentyp</th>
			<th>Bezeichnung</th>
			<th>Sortierung</th>
		</tr>
	</thead>
	<tbody>
	<?php
	if(count($AufgabenArray))
	{
		foreach ($AufgabenArray as $i => $Aufgabe)
		{
			?>
		<tr class="<?php echo (($i%2)?('even'):('odd')) ?>">
			<td>
			<button type="submit" class="icon" name="edit" value="<?php echo $Aufgabe->getAufgabeID() ?>"><img
				src="bilder/buttons/b_edit.png" title="Bearbeiten" alt="Bearbeiten" width="16" height="16" /></button>
			</td>
			<td><?php if($Aufgabe->isDeletable()) { ?>
			<button type="submit" class="icon" name="drop" value="<?php echo $Aufgabe->getAufgabeID() ?>"
				onclick="return confirm('Die Aufgabe \'<?php echo $Aufgabe ?>\' wirklich löschen?')"><img
				src="bilder/buttons/b_drop.png" title="Löschen" alt="Löschen" width="16" height="16" /></button>
				<?php } else {echo '&nbsp;';} ?></td>
			<td><?php echo $Aufgabe->getAufgabentyp(GET_C2SC) ?></td>
			<td><?php echo $Aufgabe->getBezMaennlich().' / '.$Aufgabe->getBezWeiblich() ?></td>
			<td><?php echo $Aufgabe->getSortierung() ?></td>
		</tr>
		<?php
		}
	}
	?>
	</tbody>
</table>
