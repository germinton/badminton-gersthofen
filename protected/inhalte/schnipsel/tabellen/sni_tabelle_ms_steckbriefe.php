
<div class="<?php echo ((S_HERR == $Anrede)?('tableft'):('tabright')) ?>">
<table>
	<colgroup width="100px" span="1" />
	
	
	<thead>
		<tr class="even">
			<th style="height: 50px; font-size: 1.5em" colspan="2"><?php echo ((S_HERR == $Anrede)?('Herren'):('Damen')) ?></th>
		</tr>
	</thead>
	<tbody>
	<?php
	if(count($MitgliedArray))
	{
		foreach ($MitgliedArray as $i => $Mitglied)
		{
			$HRefString = 'index.php?section=ms_steckbriefe'.(($s = $data['fs_string'])?($s):('')).'&amp;athlet_id='.$Mitglied->getAthletID();
			?>
		<tr class="<?php echo (($i%2)?('even'):('odd')) ?>">
			<td style="height: 54px"><a href="<?php echo $HRefString ?>"><?php echo $Mitglied->getXHTMLforIMG(false, 50) ?></a></td>
			<td><a href="<?php echo $HRefString ?>"><?php echo $Mitglied->getNachnameVorname() ?></a></td>
		</tr>
		<?php
		}
	}
	?>
	</tbody>
</table>
</div>
