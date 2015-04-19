<div class="<?php echo ((1 == $Part)?('tableft'):('tabright')) ?>">
<table>

	<thead>
		<tr class="even" style="height: 1.5em;">
			<th>&nbsp;</th>
			<th>Aufgaben</th>
		</tr>
	</thead>
	<tbody>
	<?php

	$Height = 80;

	if(count($MitgliedArray))
	{
		foreach ($MitgliedArray as $i => $Mitglied)
		{
			?>
		<tr class="<?php echo (($i%2)?('even'):('odd')) ?>">
			<td style="font-weight: bold"><?php echo $Mitglied.'<br />'; ?></td>
			<td rowspan="2"><?php if(count($aa = $Mitglied->getAufgabenstringArrayFormatted())) {
				foreach($aa as $AString) {echo $AString.'<br />';}
			} ?></td>
		</tr>
		<tr class="<?php echo (($i%2)?('even'):('odd')) ?>">
			<td style="height: 100px"><?php echo $Mitglied->getXHTMLforIMG(false, $Height) ?></td>
		</tr>
		<?php
		}
	}
	?>
	</tbody>
</table>
</div>
