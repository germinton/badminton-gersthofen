<table>
	<colgroup width="26" span="2" />
	
	
	<thead>
		<tr>
			<th colspan="2">&nbsp;</th>
			<th>Bezeichnung</th>
			<th>AKlaGruppe</th>
		</tr>
	</thead>
	<tbody>
	<?php
	if(count($LigaKlasseArray))
	{
		foreach ($LigaKlasseArray as $i => $LigaKlasse)
		{
			?>
		<tr class="<?php echo (($i%2)?('even'):('odd')) ?>">
			<td>
			<button type="submit" class="icon" name="edit" value="<?php echo $LigaKlasse->getLigaKlasseID() ?>"><img
				src="bilder/buttons/b_edit.png" title="Bearbeiten" alt="Bearbeiten" width="16" height="16" /></button>
			</td>
			<td><?php if($LigaKlasse->isDeletable()) { ?>
			<button type="submit" class="icon" name="drop" value="<?php echo $LigaKlasse->getLigaKlasseID() ?>"
				onclick="return confirm('Die LigaKlasse \'<?php echo $LigaKlasse ?>\' wirklich löschen?')"><img
				src="bilder/buttons/b_drop.png" title="Löschen" alt="Löschen" width="16" height="16" /></button>
				<?php } else {echo '&nbsp;';} ?></td>
			<td><?php echo $LigaKlasse->getBezeichnung() ?></td>
			<td><?php echo C2S_AKlaGruppe($LigaKlasse->getAKlaGruppe()) ?></td>
		</tr>
		<?php
		}
	}
	?>
	</tbody>
</table>
