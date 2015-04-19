<table>
	<colgroup width="26" span="2" />
	
	
	<colgroup span="3" />
	
	
	<thead>
		<tr>
			<th colspan="2">&nbsp;</th>
			<th>Aufgabe</th>
			<th>Athlet</th>
			<th>Zusatzinfos</th>
		</tr>
	</thead>
	<tbody>
	<?php
	if(count($AufgabenzuordnungenArray))
	{
		foreach ($AufgabenzuordnungenArray as $i => $Aufgabenzuordnung)
		{
			?>
		<tr class="<?php echo (($i%2)?('even'):('odd')) ?>">
			<td>
			<button type="submit" class="icon" name="edit" value="<?php echo $Aufgabenzuordnung->getAufgabenzuordnungID() ?>"><img
				src="bilder/buttons/b_edit.png" title="Bearbeiten" alt="Bearbeiten" width="16" height="16" /></button>
			</td>
			<td>
			<button type="submit" class="icon" name="drop" value="<?php echo $Aufgabenzuordnung->getAufgabenzuordnungID() ?>"
				onclick="return confirm('Die Aufgabenzuordnung \'<?php echo $Aufgabenzuordnung ?>\' wirklich löschen?')"><img
				src="bilder/buttons/b_drop.png" title="Löschen" alt="Löschen" width="16" height="16" /></button>
			</td>

			<td><?php echo $Aufgabenzuordnung->getAufgabeID(GET_OFID) ?></td>
			<td><?php echo $Aufgabenzuordnung->getAthletID(GET_OFID)->getNachnameVorname() ?></td>
			<td><?php echo $Aufgabenzuordnung->getZusatzinfo() ?></td>
		</tr>
		<?php
		}
	}
	?>
	</tbody>
</table>
