<div class="<?php echo ((1 == $Part)?('tableft'):('tabright')) ?>">
<table>

	<thead>
		<tr class="even" style="height: 1.5em;">
			<th>Verein</th>
			<th>&nbsp;</th>
		</tr>
	</thead>
	<tbody>
	<?php
	if(count($VereinArray))
	{
		foreach ($VereinArray as $i => $Verein)
		{
			$a_s = (($h = $Verein->getHomepage())?('<a href="'.$h.'">'):(''));
			$a_e = (($h)?('</a>'):(''));
			?>
		<tr class="<?php echo (($Verein->getKuerzel() == "SG")?('special'):((($i%2)?('even'):('odd')))) ?>"
			style="height: 44px">
			<td><?php echo $Verein->getHomepage(array(GET_SPEC, GET_CLIP)) ?></td>
			<td><?php echo (($Verein->hasAttachment(ATTACH_PIC))?($Verein->getXHTMLforIMG(false, 40)):('')) ?></td>
		</tr>
		<?php
		}
	}
	?>
	</tbody>
</table>
</div>
