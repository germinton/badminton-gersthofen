<table>
	<colgroup width="26" span="2" />
	
	
	<colgroup span="4" />
	
	
	<thead>
		<tr>
			<th colspan="2">&nbsp;</th>
			<th>Datum</th>
			<th>Uhrzeit</th>
			<th>Mannschaft</th>
			<th>Gegner</th>
		</tr>
	</thead>
	<tbody>
	<?php
	if(count($TerminPSBArray))
	{
		foreach ($TerminPSBArray as $i => $TerminPSB)
		{
			?>
		<tr class="<?php echo (($TerminPSB->getDatum() < date('Y-m-d'))?(($i%2)?('special'):('special2')):((($i%2)?('even'):('odd')))) ?>">
			<td>
			<button type="submit" class="icon" name="edit" value="<?php echo $TerminPSB->getTerminID() ?>"><img
				src="bilder/buttons/b_edit.png" title="Bearbeiten" alt="Bearbeiten" width="16" height="16" /></button>
			</td>
			<td>
			<button type="submit" class="icon" name="drop" value="<?php echo $TerminPSB->getTerminID() ?>"
				onclick="return confirm('Die Termin mit dem Titel \'<?php echo $TerminPSB ?>\' wirklich löschen?')"><img
				src="bilder/buttons/b_drop.png" title="Löschen" alt="Löschen" width="16" height="16" /></button>
			</td>
			<td><?php echo $TerminPSB->getDatum(GET_DTDE) ?></td>
			<td><?php echo $TerminPSB->getUhrzeit(GET_SPEC) ?></td>
			<td><?php echo $TerminPSB->getMannschaftID(GET_OFID) ?></td>
			<td><?php echo $TerminPSB->getVereinID(GET_OFID).'&nbsp;'.$TerminPSB->getMannschaftNr() ?></td>
		</tr>
		<?php
		}
	}
	?>
	</tbody>
</table>
