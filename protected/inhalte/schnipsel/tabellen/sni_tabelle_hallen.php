<table>

	<colgroup span="3" />
	
	
	<thead>
		<tr class="even" style="height: 2.5em; font-size: 1.3em">
			<th>Ort</th>
			<th>Hallenname</th>
			<th>Verein</th>
			<th>Foto</th>
		</tr>
	</thead>
	<tbody>
	<?php
	if(count($AustragungsortArray))
	{
		foreach ($AustragungsortArray as $i => $Austragungsort)
		{
			$HRefString = 'index.php?section=hallen'.(($s = $data['fs_string'])?($s):('')).'&amp;austragungsort_id='.$Austragungsort->getAustragungsortID();
			?>
		<tr class="<?php echo (($i%2)?('even'):('odd')) ?>" style="height: 44px">
			<td><?php echo $Austragungsort->getOrt() ?></td>
			<td><a href="<?php echo $HRefString ?>"><?php echo $Austragungsort->getHallenname() ?></a></td>
			<td><?php echo ((($obj = $Austragungsort->getVereinID(array(GET_OFID, GET_NBSP))) instanceof CVerein)?($obj->getHomepage(GET_SPEC)):($obj)) ?></td>
			<td><?php if($Austragungsort->hasAttachment(ATTACH_PIC)) { ?> <a href="<?php echo $HRefString ?>"><?php echo $Austragungsort->getXHTMLforIMG(false, 40) ?></a>
			<?php } else {echo '&nbsp;';} ?></td>
		</tr>
		<?php
		}
	}
	?>
	</tbody>
</table>
