<table>
	<colgroup width="26" span="2" />
	
	
	<colgroup span="5" />
	
	
	<thead>
		<tr>
			<th colspan="2">&nbsp;</th>
			<th>Datum</th>
			<th>Titel</th>
			<th>Picasa ID</th>
		</tr>
	</thead>
	<tbody>
	<?php
	if(count($GalerieArray))
	{
		$currentYear = 3000;
		foreach ($GalerieArray as $i => $Galerieeintrag)
		{
			if($currentYear != substr($Galerieeintrag->getDatum(),0,4)) {
				$currentYear = substr($Galerieeintrag->getDatum(),0,4);
				echo '<tr><td>&nbsp;</td></tr><tr><td>'.$currentYear.'</td></tr>';
			}
			?>
		<tr class="<?php echo (($i%2)?('even'):('odd')) ?>">
			<td>
			<button type="submit" class="icon" name="edit" value="<?php echo $Galerieeintrag->getGalerieeintragID() ?>"><img
				src="bilder/buttons/b_edit.png" title="Bearbeiten" alt="Bearbeiten" width="16" height="16" /></button>
			</td>
			<td>
			<button type="submit" class="icon" name="drop" value="<?php echo $Galerieeintrag->getGalerieeintragID() ?>"
				onclick="return confirm('Den Galerieeintrag mit dem Titel \'<?php echo $Galerieeintrag ?>\' wirklich löschen?')"><img
				src="bilder/buttons/b_drop.png" title="Löschen" alt="Löschen" width="16" height="16" /></button>
			</td>
			<td><?php echo $Galerieeintrag->getDatum() ?></td>
			<td style="text-align: left"><?php echo $Galerieeintrag->getTitel(GET_CLIP) ?></td>
			<td style="text-align: left"><?php echo $Galerieeintrag->getPicasaAlbumID(GET_CLIP) ?></td>
		</tr>
		<?php
		}
	}
	?>
	</tbody>
</table>
