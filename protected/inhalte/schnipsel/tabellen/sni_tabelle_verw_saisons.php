<table>
	<colgroup width="26" span="2" />
	
	
	<thead>
		<tr>
			<th colspan="2">&nbsp;</th>
			<th>Beginn</th>
			<th>Ende</th>
			<th>Spielregel</th>
		</tr>
	</thead>
	<tbody>
	<?php
	if(count($SaisonArray))
	{
		foreach ($SaisonArray as $i => $Saison)
		{
			?>
		<tr class="<?php echo (($i%2)?('even'):('odd')) ?>">
			<td>
			<button type="submit" class="icon" name="edit" value="<?php echo $Saison->getSaisonID() ?>"><img
				src="bilder/buttons/b_edit.png" title="Bearbeiten" alt="Bearbeiten" width="16" height="16" /></button>
			</td>
			<td><?php if($Saison->isDeletable()) { ?>
			<button type="submit" class="icon" name="drop" value="<?php echo $Saison->getSaisonID() ?>"
				onclick="return confirm('Die Saison \'<?php echo $Saison ?>\' wirklich löschen?')"><img
				src="bilder/buttons/b_drop.png" title="Löschen" alt="Löschen" width="16" height="16" /></button>
				<?php } else {echo '&nbsp;';} ?></td>
			<td><?php echo $Saison->getBeginn(GET_DTDE) ?></td>
			<td><?php echo $Saison->getEnde(GET_DTDE) ?></td>
			<td><?php echo $Saison->getSpielregel(GET_C2SC) ?></td>
		</tr>
		<?php
		}
	}
	?>
	</tbody>
</table>
