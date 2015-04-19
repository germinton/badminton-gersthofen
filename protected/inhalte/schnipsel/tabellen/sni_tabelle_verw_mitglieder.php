<div class="<?php echo ((S_HERR == $Anrede)?('tableft'):('tabright')) ?>">
<table>
	<colgroup width="26" span="2" />
	
	
	<colgroup span="3" />
	
	
	<thead>
		<tr>
			<th colspan="5"><?php echo ((S_HERR == $Anrede)?('Herren'):('Damen')) ?></th>
		</tr>
		<tr>
			<th colspan="2">&nbsp;</th>
			<th>Name</th>
			<th>Alter<sup>1</sup></th>
			<th>A.-Kl.<sup>1</sup></th>
		</tr>
	</thead>
	<tbody>
	<?php
	if(count($MitgliedArray))
	{
		foreach ($MitgliedArray as $i => $Mitglied)
		{
			?>
		<tr class="<?php echo (($Mitglied->getAusblenden())?('special'):((($i%2)?('even'):('odd')))) ?>">
			<td>
			<button type="submit" class="icon" name="edit" value="<?php echo $Mitglied->getAthletID() ?>"><img
				src="bilder/buttons/b_edit.png" title="Bearbeiten" alt="Bearbeiten" width="16" height="16" /></button>
			</td>
			<td><?php if($Mitglied->isDeletable()) { ?>
			<button type="submit" class="icon" name="drop" value="<?php echo $Mitglied->getAthletID() ?>"
				onclick="return confirm('Das Mitglied mit dem Namen \'<?php echo $Mitglied->getVornameNachname() ?>\' wirklich löschen?')"><img
				src="bilder/buttons/b_drop.png" title="Löschen" alt="Löschen" width="16" height="16" /></button>
				<?php } else {echo '&nbsp;';} ?></td>
			<td style="text-align: left"><?php echo $Mitglied->getNachnameVorname() ?></td>
			<td><?php echo $Mitglied->getAlter(GET_NBSP) ?></td>
			<td><?php echo $Mitglied->getAltersklasse(array(GET_NBSP, GET_C2SC)) ?></td>
		</tr>
		<?php
		}
	}
	?>
	</tbody>
</table>
</div>
