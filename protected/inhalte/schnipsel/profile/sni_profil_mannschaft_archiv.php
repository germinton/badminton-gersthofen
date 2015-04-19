<div class="profil mannschaft" id="mannschaft_id:<?php echo $Mannschaft->getMannschaftID() ?>"><?php 
$LigaKLasse = (string)$Mannschaft->getLigaKlasseID(GET_OFID);
if(!is_null($Mannschaft->getErgDienst())) {$LigaKLasse = $Mannschaft->getLinkErgDienst($LigaKLasse);}
$SpErMl_X_Array = $Mannschaft->getSpermlXArray();
$SpErMl_X_Array_BegegnungNr_Array = $Mannschaft->getSpermlXBegegnungNrArray();
$SpErMl_X_Array_Seite_Array = $Mannschaft->getSpermlXSeiteArray();
?>

<h2><?php echo 'Saison '.$Mannschaft->getSaisonID(GET_OFID).'<br />'.$Mannschaft.'<br />'.$LigaKLasse ?></h2>
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

$TabelleneintragArray = array();

if($TabelleID = $Mannschaft->getTabelleID())
{
	$Tabelle = new CTabelle($Mannschaft->getTabelleID());
	$TabelleneintragArray = $Tabelle->getTabelleneintragArray();
}

if(count($TabelleneintragArray))
{
	echo '<h3>Abschlusstabelle</h3>'.PHP_EOL;
	echo '<table>'.PHP_EOL;
	echo '<colgroup span="3" />'.PHP_EOL;
	echo '<colgroup width="35px" span="1" />'.PHP_EOL;
	echo '<colgroup width="5px" span="1" />'.PHP_EOL;
	echo '<colgroup width="35px" span="1" />'.PHP_EOL;
	echo '<colgroup width="40px" span="1" />'.PHP_EOL;
	echo '<colgroup width="5px" span="1" />'.PHP_EOL;
	echo '<colgroup width="40px" span="1" />'.PHP_EOL;
	echo '<colgroup width="45px" span="1" />'.PHP_EOL;
	echo '<colgroup width="5px" span="1" />'.PHP_EOL;
	echo '<colgroup width="45px" span="1" />'.PHP_EOL;


	echo '<thead>'.PHP_EOL;
	echo '<tr>'.PHP_EOL;
	echo '<th colspan="2">Mannschaft</th>'.PHP_EOL;
	echo '<th>Anz. Spiele</th>'.PHP_EOL;
	echo '<th colspan="3">Punkte</th>'.PHP_EOL;
	echo '<th colspan="3">Spiele</th>'.PHP_EOL;
	echo '<th colspan="3">Sätze</th>'.PHP_EOL;
	echo '</tr>'.PHP_EOL;
	echo '</thead>'.PHP_EOL;
	echo '<tbody>'.PHP_EOL;

	foreach($TabelleneintragArray as $i => $Tabelleneintrag)
	{
		$hl = (false !== strpos($Tabelleneintrag->getMannschaft(), 'TSV Ger'));
		echo '<tr class="'.(($hl)?('highlight'):(($i%2)?('even'):('odd'))).'">'.PHP_EOL;
		echo '<td>'.$Tabelleneintrag->getPlatz().'</td>'.PHP_EOL;
		echo '<td style="text-align:left">'.$Tabelleneintrag->getMannschaft().'</td>'.PHP_EOL;
		echo '<td>'.$Tabelleneintrag->getAnzahlSpiele().'</td>'.PHP_EOL;
		echo '<td style="text-align:right">'.$Tabelleneintrag->getPunkte1().'</td>'.PHP_EOL;
		echo '<td>:</td>'.PHP_EOL;
		echo '<td style="text-align:left">'.$Tabelleneintrag->getPunkte3().'</td>'.PHP_EOL;
		echo '<td style="text-align:right">'.$Tabelleneintrag->getSpiele1().'</td>'.PHP_EOL;
		echo '<td>:</td>'.PHP_EOL;
		echo '<td style="text-align:left">'.$Tabelleneintrag->getSpiele3().'</td>'.PHP_EOL;
		echo '<td style="text-align:right">'.$Tabelleneintrag->getSaetze1().'</td>'.PHP_EOL;
		echo '<td>:</td>'.PHP_EOL;
		echo '<td style="text-align:left">'.$Tabelleneintrag->getSaetze3().'</td>'.PHP_EOL;
		echo '</tr>'.PHP_EOL;
	}

	echo '</tbody>'.PHP_EOL;
	echo '</table>'.PHP_EOL;
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
?></div>
