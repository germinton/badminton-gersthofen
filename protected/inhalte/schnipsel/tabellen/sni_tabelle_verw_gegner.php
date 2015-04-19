<div class="<?php echo ((S_HERR == $Anrede)?('tableft'):('tabright')) ?>">
<table>
	<colgroup width="26" span="2" />
	
	
	<colgroup span="1" />
	
	
	<thead>
		<tr>
			<th colspan="3"><?php echo ((S_HERR == $Anrede)?('Herren'):('Damen')) ?></th>
		</tr>
		<tr>
			<th colspan="2">&nbsp;</th>
			<th>Name</th>
		</tr>
	</thead>
	<tbody>
	<?php
	if(count($GegnerArray))
	{
		foreach ($GegnerArray as $i => $Gegner)
		{
			?>
		<tr class="<?php echo (($i%2)?('even'):('odd')) ?>">
			<td>
			<button type="submit" class="icon" name="edit" value="<?php echo $Gegner->getAthletID() ?>"><img
				src="bilder/buttons/b_edit.png" title="Bearbeiten" alt="Bearbeiten" width="16" height="16" /></button>
			</td>
			<td><?php if($Gegner->isDeletable()) { ?>
			<button type="submit" class="icon" name="drop" value="<?php echo $Gegner->getAthletID() ?>"
				onclick="return confirm('Den Gegner mit dem Namen \'<?php echo $Gegner->getVornameNachname() ?>\' wirklich löschen?')"><img
				src="bilder/buttons/b_drop.png" title="Löschen" alt="Löschen" width="16" height="16" /></button>
				<?php } else {echo '&nbsp;';} ?></td>
			<td style="text-align: left"><?php echo $Gegner->getNachnameVorname() ?></td>
		</tr>
		<?php
		}
	}
	?>
	</tbody>
</table>
</div>
