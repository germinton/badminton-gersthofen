<?php
echo '<table>'.PHP_EOL;
echo '<colgroup width="30px" span="1" />'.PHP_EOL;


foreach($TerminPSBArrayArrayArray as $n => $TerminPSBArrayArray)
{
	$Tmp = reset($TerminPSBArrayArray);
	$ClassString = ((reset($Tmp)->getDatum() < date('Y-m-d'))?(($n%2)?('special'):('special2')):((($n%2)?('even'):('odd'))));

	echo '<tr class="'.$ClassString.'">';

	$rowspan1 = 0;
	foreach($TerminPSBArrayArray as $TerminPSBArray) {
		$Freitext = false;
		foreach($TerminPSBArray as $TerminPSB) {if($TerminPSB->getFreitext()) {$Freitext = true; break;}}
		$rowspan1 += count($TerminPSBArray) + (($Freitext)?(1):(0));
	}
	
	echo '<td rowspan="'.$rowspan1.'">'.substr(reset($Tmp)->getDatum(GET_DTDE), 0, 3).'</td>'.PHP_EOL;

	foreach($TerminPSBArrayArray as $i => $TerminPSBArray)
	{
		if($i) {echo '<tr class="'.$ClassString.'">';}

		$Freitext = '';
		foreach($TerminPSBArray as $j => $TerminPSB) {
			if($j and strlen($TerminPSB->getFreitext())) {$Freitext .= '<br />'.PHP_EOL;}
			$Freitext .= $TerminPSB->getFreitext();
		}

		$rowspan2 = count($TerminPSBArray) + ((strlen($Freitext))?(1):(0));
		echo '<td rowspan="'.$rowspan2.'">'.reset($TerminPSBArray)->getMannschaftID(GET_OFID).'</td>'.PHP_EOL;

		$Austragungsort = reset($TerminPSBArray)->getAustragungsortID(GET_OFID);

		echo '<td rowspan="'.$rowspan2.'">';
		echo '<a href="index.php?section=hallen&amp;austragungsort_id='.$Austragungsort->getAustragungsortID().'">';
		echo $Austragungsort->getHallenname().'<br />in '.$Austragungsort->getOrt();
		echo '</a></td>'.PHP_EOL;

		foreach($TerminPSBArray as $j => $TerminPSB)
		{
			if($j) {echo '<tr class="'.$ClassString.'">';}

			if(!$j)
			{
				if(strlen($Freitext))
				{
					echo '<td colspan="4">'.$Freitext.'</td>'.PHP_EOL;
					echo '</tr>'.PHP_EOL;
					echo '<tr class="'.$ClassString.'">'.PHP_EOL;
				}
			}

			echo '<td style="text-align: right">'.$TerminPSB->getHeimMannschaftString().'</td>'.PHP_EOL;
			echo '<td>-</td>'.PHP_EOL;
			echo '<td style="text-align: left">'.$TerminPSB->getGastMannschaftString().'</td>'.PHP_EOL;
			echo '</tr>'.PHP_EOL;
		}

	}

}
echo '</table>'.PHP_EOL;
?>