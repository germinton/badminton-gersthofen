<?php
echo '<table>'.PHP_EOL;
echo '<colgroup width="90px" span="1" />'.PHP_EOL;
echo '<colgroup span="1" />'.PHP_EOL;
echo '<colgroup width="80px" span="1" />'.PHP_EOL;

foreach($TerminPSBArrayArray as $i => $TerminPSBArray)
{
	$Freitext = '';
	foreach($TerminPSBArray as $k => $TerminPSB) {
		if($k and strlen($TerminPSB->getFreitext())) {$Freitext .= '<br />'.PHP_EOL;}
		$Freitext .= $TerminPSB->getFreitext();
	}

	$rowspan = count($TerminPSBArray) + ((strlen($Freitext))?(1):(0));

	foreach($TerminPSBArray as $j => $TerminPSB)
	{
		$ClassString = (($TerminPSB->getDatum() < date('Y-m-d'))?(($i%2)?('special'):('special2')):((($i%2)?('even'):('odd'))));

		echo '<tr class="'.$ClassString.'">';

		if(!$j)
		{
			echo '<td rowspan="'.$rowspan.'">'.$TerminPSB->getDatum(GET_DTDE).'</td>'.PHP_EOL;

			$Austragungsort = $TerminPSB->getAustragungsortID(GET_OFID);
				
			echo '<td rowspan="'.$rowspan.'">';
			echo '<a href="index.php?section=hallen&amp;austragungsort_id='.$Austragungsort->getAustragungsortID().'">';
			echo $Austragungsort->getHallenname().'<br />in '.$Austragungsort->getOrt();
			echo '</a></td>'.PHP_EOL;

			if(strlen($Freitext))
			{
				echo '<td colspan="4">'.$Freitext.'</td>'.PHP_EOL;
				echo '</tr>'.PHP_EOL;
				echo '<tr class="'.$ClassString.'">'.PHP_EOL;
			}
		}

		echo '<td>'.$TerminPSB->getUhrzeit().' Uhr</td>'.PHP_EOL;
		echo '<td style="text-align: right">'.$TerminPSB->getHeimMannschaftString().'</td>'.PHP_EOL;
		echo '<td>-</td>'.PHP_EOL;
		echo '<td style="text-align: left">'.$TerminPSB->getGastMannschaftString().'</td>'.PHP_EOL;

		echo '</tr>'.PHP_EOL;

	}
}
echo '</table>'.PHP_EOL;
?>