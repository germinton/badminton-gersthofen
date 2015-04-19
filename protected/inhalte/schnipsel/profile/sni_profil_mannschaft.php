<div class="profil mannschaft" id="mannschaft_id:<?php echo $Mannschaft->getMannschaftID() ?>"><?php 
$LigaKLasse = (string)$Mannschaft->getLigaKlasseID(GET_OFID);
if(!is_null($Mannschaft->getErgDienst())) {$LigaKLasse = $Mannschaft->getLinkErgDienst($LigaKLasse);}
$SpErMl_X_Array = $Mannschaft->getSpermlXArray();
$SpErMl_X_Array_BegegnungNr_Array = $Mannschaft->getSpermlXBegegnungNrArray();
$SpErMl_X_Array_Seite_Array = $Mannschaft->getSpermlXSeiteArray();
?>

<h2><?php echo $Mannschaft.' - '.$LigaKLasse ?></h2>

<?php
if(1) // if(S_AKTIVE == $Mannschaft->getAKlaGruppe())
{
	echo $Mannschaft->getXHTMLforIMG(true, 400).PHP_EOL;
	echo '<p style="text-align: center">'.$Mannschaft->getBildunterschrift(GET_SPEC).'</p>'.PHP_EOL;
}
else
{
	echo '<p>&nbsp;</p>'.PHP_EOL;
	echo '<p class="info">Aus Sicherheitsgründen wird kein Bild veröffentlicht</p>'.PHP_EOL;
	echo '<p>&nbsp;</p>'.PHP_EOL;
}

$TerminPSBArray = $Mannschaft->getTerminPSBArray();
if(count($TerminPSBArray))
{
	echo '<h3>Punktspieltermine</h3>';
	$TerminPSBArrayArray = $Mannschaft->getTerminPSBArrayArray();
	include('protected/inhalte/schnipsel/speziell/sni_mannschaft_doppelspieltagsansicht.php');
}



if(count($SpErMl_X_Array))
{
	echo '<h3>Spielergebnisse</h3>'.PHP_EOL;
	echo '<table>'.PHP_EOL;
	foreach($SpErMl_X_Array as $i => $SpErMl_X)
	{
		$BegegnungNr = $SpErMl_X_Array_BegegnungNr_Array[$i];
		$Seite = $SpErMl_X_Array_Seite_Array[$i];
		$HRefString = 'index.php?section=sperml_punkt&amp;sperml_id='.$SpErMl_X->getSpErMlID();

		$HeimMannschaft = $SpErMl_X->getHeimMannschaftString();
		$GastMannschaft = $SpErMl_X->getGastMannschaftString();

		switch($Erg = $SpErMl_X->getErgebnis())
		{
			case C_HEIMGEW:
				$HeimMannschaft = '<em>'.$HeimMannschaft.'</em>';
				$Gew = (S_HEIM == $Seite);
				break;
			case C_GASTGEW:
				$GastMannschaft = '<em>'.$GastMannschaft.'</em>';
				$Gew = (S_GAST == $Seite);
				break;
			default:
				break;
		}

		echo '<tr class="'.(($i%2)?('even'):('odd')).'">'.PHP_EOL;
		
		echo '<td><a href="'.$HRefString.'">'.$SpErMl_X->getDatum(GET_DTDE).'/'.$BegegnungNr.'</a></td>'.PHP_EOL;
		echo '<td style="text-align: right">'.$HeimMannschaft.'</td>'.PHP_EOL;
		echo '<td>-</td>'.PHP_EOL;
		echo '<td style="text-align: left">'.$GastMannschaft.'</td>'.PHP_EOL;
		echo '<td style="font-weight: bold; background:';
		echo ((C_UNENTSCH == $Erg)?('#6699cc'):(($Gew)?('#66cc66'):('#ff9933')));
		echo '"><a href="'.$HRefString.'">'.$SpErMl_X->getErgSpiele().'</a></td>';

		echo '</tr>'.PHP_EOL;;
	}
	echo '</table>'.PHP_EOL;
}



if(!is_null($Mannschaft->getErgDienst())) {
	echo '<h3>Tabelle</h3>'.PHP_EOL;
	echo '<p>Tabelle der '.$LigaKLasse.'</p>'.PHP_EOL;
}
?></div>
