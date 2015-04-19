<table>
	<colgroup width="26" span="2" />
	
	
	<colgroup span="5" />
	
	
	<thead>
		<tr>
			<th colspan="2">&nbsp;</th>
			<th>Datum</th>
			<th>Titel</th>
			<th>Ort</th>
			<th>Verantw.</th>
			<th>Bild</th>
		</tr>
	</thead>
	<tbody>
	<?php
	if(count($TerminAllgArray))
	{
		foreach ($TerminAllgArray as $i => $TerminAllg)
		{
			?>
		<tr class="<?php echo (((($edat = $TerminAllg->getEndedatum())?($edat):($TerminAllg->getDatum())) < date('Y-m-d'))?('special'):((($i%2)?('even'):('odd')))) ?>">
			<td>
			<button type="submit" class="icon" name="edit" value="<?php echo $TerminAllg->getTerminID() ?>"><img
				src="bilder/buttons/b_edit.png" title="Bearbeiten" alt="Bearbeiten" width="16" height="16" /></button>
			</td>
			<td>
			<button type="submit" class="icon" name="drop" value="<?php echo $TerminAllg->getTerminID() ?>"
				onclick="return confirm('Die Termin mit dem Titel \'<?php echo $TerminAllg ?>\' wirklich löschen?')"><img
				src="bilder/buttons/b_drop.png" title="Löschen" alt="Löschen" width="16" height="16" /></button>
			</td>
			<td><?php echo $TerminAllg->getDatumVonBis() ?></td>
			<td style="text-align: left"><?php echo $TerminAllg->getTitel(GET_CLIP) ?></td>
			<td style="text-align: left"><?php echo $TerminAllg->getOrt(GET_CLIP) ?></td>
			<td><?php echo $TerminAllg->getAthletID(GET_SPEC) ?></td>
			<td><?php echo $TerminAllg->hasAttachment(ATTACH_PIC, GET_SPEC) ?></td>
		</tr>
		<?php
		}
	}
	?>
	</tbody>
</table>
