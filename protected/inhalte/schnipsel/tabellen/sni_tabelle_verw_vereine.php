<table>
	<colgroup width="26" span="2" />
	
	
	<thead>
		<tr>
			<th colspan="2">&nbsp;</th>
			<th>Kürzel</th>
			<th>Name</th>
			<th>Homepage</th>
			<th>Bild</th>
		</tr>
	</thead>
	<tbody>
	<?php
	if(count($VereinArray))
	{
		foreach ($VereinArray as $i => $Verein)
		{
			?>
		<tr class="<?php echo (($Verein->getKuerzel() == "SG")?('special'):((($i%2)?('even'):('odd')))) ?>">
			<td>
			<button type="submit" class="icon" name="edit" value="<?php echo $Verein->getVereinID() ?>"><img
				src="bilder/buttons/b_edit.png" title="Bearbeiten" alt="Bearbeiten" width="16" height="16" /></button>
			</td>
			<td><?php if($Verein->isDeletable()) { ?>
			<button type="submit" class="icon" name="drop" value="<?php echo $Verein->getVereinID() ?>"
				onclick="return confirm('Den Verein \'<?php echo $Verein ?>\' wirklich löschen?')"><img
				src="bilder/buttons/b_drop.png" title="Löschen" alt="Löschen" width="16" height="16" /></button>
				<?php } else {echo '&nbsp;';} ?></td>
			<td><?php echo $Verein->getKuerzel() ?></td>
			<td><?php echo $Verein->getName() ?></td>
			<td style="text-align: left"><?php echo $Verein->getHomepage(array(GET_CLIP, GET_NBSP)) ?></td>
			<td><?php echo $Verein->hasAttachment(ATTACH_PIC, GET_SPEC) ?></td>
		</tr>
		<?php
		}
	}
	?>
	</tbody>
</table>
