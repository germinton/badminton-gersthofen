<table>
	<colgroup width="26" span="2" />
	
	
	<colgroup span="6" />
	
	
	<thead>
		<tr>
			<th colspan="2">&nbsp;</th>
			<th>Von</th>
			<th>Titel</th>
			<th>Inhalt</th>
			<th>Eingestellt</th>
			<th>Gültig bis</th>
			<th>Bild</th>
			<th>Wichtig</th>
		</tr>
	</thead>
	<tbody>
	<?php
	if(count($NeuigkeitArray))
	{
		foreach ($NeuigkeitArray as $i => $Neuigkeit)
		{
			?>
		<tr
			class="<?php echo ((($Neuigkeit->getGueltigBis() <> null) and ($Neuigkeit->getGueltigBis() < date('Y-m-d')))?('special'):((($i%2)?('even'):('odd')))) ?>">
			<td>
			<button type="submit" class="icon" name="edit" value="<?php echo $Neuigkeit->getNeuigkeitID() ?>"><img
				src="bilder/buttons/b_edit.png" title="Bearbeiten" alt="Bearbeiten" width="16" height="16" /></button>
			</td>
			<td>
			<button type="submit" class="icon" name="drop" value="<?php echo $Neuigkeit->getNeuigkeitID() ?>"
				onclick="return confirm('Die Neuigkeit mit dem Titel \'<?php echo $Neuigkeit ?>\' von <?php echo $Neuigkeit->getAthletID(GET_SPEC) ?> wirklich löschen?')"><img
				src="bilder/buttons/b_drop.png" title="Löschen" alt="Löschen" width="16" height="16" /></button>
			</td>
			<td><?php echo $Neuigkeit->getAthletID(GET_SPEC) ?></td>
			<td style="text-align: left"><?php echo $Neuigkeit->getTitel(GET_CLIP) ?></td>
			<td style="text-align: left"><?php echo $Neuigkeit->getInhalt(array(GET_CLIP, GET_HSPC)) ?></td>
			<td><?php echo $Neuigkeit->getEingestellt(GET_DTDE) ?></td>
			<td><?php echo $Neuigkeit->getGueltigBis(array(GET_DTDE, GET_NBSP)) ?></td>
			<td><?php echo $Neuigkeit->hasAttachment(ATTACH_PIC, GET_SPEC) ?></td>
			<td><?php echo $Neuigkeit->getWichtig(GET_SPEC) ?></td>
		</tr>
		<?php
		}
	}
	?>
	</tbody>
</table>
