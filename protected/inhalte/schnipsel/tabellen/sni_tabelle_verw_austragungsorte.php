<table>
	<colgroup width="26" span="2" />
	
	
	<thead>
		<tr>
			<th colspan="2">&nbsp;</th>
			<th>Ort</th>
			<th>Hallenname</th>
			<th>Verein</th>
			<th>Bild</th>
			<th>Karte</th>
		</tr>
	</thead>
	<tbody>
	<?php
	if(count($AustragungsortArray))
	{
		foreach ($AustragungsortArray as $i => $Austragungsort)
		{
			?>
		<tr class="<?php echo (($i%2)?('even'):('odd')) ?>">
			<td>
			<button type="submit" class="icon" name="edit" value="<?php echo $Austragungsort->getAustragungsortID() ?>"><img
				src="bilder/buttons/b_edit.png" title="Bearbeiten" alt="Bearbeiten" width="16" height="16" /></button>
			</td>
			<td><?php if($Austragungsort->isDeletable()) { ?>
			<button type="submit" class="icon" name="drop" value="<?php echo $Austragungsort->getAustragungsortID() ?>"
				onclick="return confirm('Den Austragungsort \'<?php echo $Austragungsort ?>\' wirklich löschen?')"><img
				src="bilder/buttons/b_drop.png" title="Löschen" alt="Löschen" width="16" height="16" /></button>
				<?php } else {echo '&nbsp;';} ?></td>
			<td style="text-align: left"><?php echo $Austragungsort->getOrt() ?></td>
			<td style="text-align: left"><?php echo $Austragungsort->getHallenname() ?></td>
			<td style="text-align: left"><?php echo $Austragungsort->getVereinID(array(GET_OFID, GET_NBSP)) ?></td>
			<td><?php echo $Austragungsort->hasAttachment(ATTACH_PIC, GET_SPEC) ?></td>
			<td><?php echo $Austragungsort->hasGMapCoord(GET_SPEC) ?></td>
		</tr>
		<?php
		}
	}
	?>
	</tbody>
</table>
