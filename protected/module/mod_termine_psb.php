<?php
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Filterung/Sortierung
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

$data['fltr1'] = ((isset($_GET['fltr1']))?((int)$_GET['fltr1']):(0));
$data['group'] = ((isset($_GET['group']))?((int)$_GET['group']):(0));

$data['fs_string'] = '';
$data['fs_string'] .= (($s = $data['fltr1'])?('&amp;fltr1='.$s):(''));
$data['fs_string'] .= (($s = $data['group'])?('&amp;group='.$s):(''));

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Übersicht
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

//----------------------------------------------------------------------------------------------------------------------
// Auswahl
//----------------------------------------------------------------------------------------------------------------------
$query_select = 'SELECT tp.termin_id '.
                'FROM ((termine_pktspbeg tp INNER JOIN termine t ON tp.termin_id=t.termin_id) '.
                'INNER JOIN mannschaften m ON tp.mannschaft_id=m.mannschaft_ID) '.
                'INNER JOIN _parameter p ON m.saison_id=p.saison_id';

//----------------------------------------------------------------------------------------------------------------------
// Filterung
//----------------------------------------------------------------------------------------------------------------------
$query_where = array();

$query_where[] = 't.datum >= CURDATE()';

$fltr1_query = 'SELECT m.mannschaft_id FROM mannschaften m '.
               'INNER JOIN _parameter p ON m.saison_id=p.saison_id ORDER BY m.aklagruppe DESC, m.verein_id, m.nr';
if(!$result = mysql_query($fltr1_query)) {throw new Exception(mysql_error(CDBConnection::getDB()));}
while($row = mysql_fetch_row($result)) {$data['fltr1_array'][] = new CMannschaft($row[0]);}

if($data['fltr1']) {$query_where[] = 'm.mannschaft_id='.$data['fltr1'];}

//----------------------------------------------------------------------------------------------------------------------
// Gruppierung
//----------------------------------------------------------------------------------------------------------------------

if(0 == $data['group']) // Mannschaft
{
	foreach($data['fltr1_array'] as $Mannschaft)
	{
		$MannschaftID = $Mannschaft->getMannschaftID();

		if((!$data['fltr1']) or ($MannschaftID == $data['fltr1']))
		{
			$TerminPSBArray = array();
			$query = $query_select;

			//------------------------------------------------------------------------------------------------------------------
			// Gruppierungsfilter
			//------------------------------------------------------------------------------------------------------------------
			$query_where['group'] = '';
			$query_where['group'] = 'm.mannschaft_id='.$Mannschaft->getMannschaftID();

			foreach($query_where as $i => $clause) {$query .= (($i)?(' AND '):(' WHERE ')).$clause;}

			//------------------------------------------------------------------------------------------------------------------
			// Sortierung
			//------------------------------------------------------------------------------------------------------------------
			$query .= ' ORDER BY t.datum, tp.uhrzeit';

			//------------------------------------------------------------------------------------------------------------------
			// Abfrage
			//------------------------------------------------------------------------------------------------------------------
			if(!$result = mysql_query($query)) {throw new Exception(mysql_error(CDBConnection::getDB()));}
			while($row = mysql_fetch_row($result)) {$TerminPSBArray[] = new CTerminPSB($row[0]);}

			//------------------------------------------------------------------------------------------------------------------
			// PostProcessing
			//------------------------------------------------------------------------------------------------------------------
			$i = 0;
			$j = 0;
			$TerminPSB = reset($TerminPSBArray);
			if($TerminPSB instanceof CTerminPSB)
			{
				$data['termin_psb_array_array_array'][$MannschaftID][$i][$j] = $TerminPSB;
				while($TerminPSB = next($TerminPSBArray))
				{
					$PreviousTerminPSB = $data['termin_psb_array_array_array'][$MannschaftID][$i][$j];
					if(($PreviousTerminPSB->getDatum() == $TerminPSB->getDatum()) and
					($PreviousTerminPSB->getAustragungsortID() == $TerminPSB->getAustragungsortID())) {
						$data['termin_psb_array_array_array'][$MannschaftID][$i][++$j] = $TerminPSB;
					}
					else {
						$j = 0;
						$data['termin_psb_array_array_array'][$MannschaftID][++$i][$j] = $TerminPSB;
					}
				}
			}
			else
			{
				$data['termin_psb_array_array_array'][$MannschaftID][$i][$j] = array();
			}
		}
	}
}
else // Monat
{
	$Monat = (int)substr(CDBConnection::getInstance()->getSaisonID(GET_OFID)->getBeginn(), 5, 2);

	for($m=0; $m<12; $m++)
	{
		$TerminPSBArray = array();
		$query = $query_select;

		//------------------------------------------------------------------------------------------------------------------
		// Gruppierungsfilter
		//------------------------------------------------------------------------------------------------------------------
		$query_where['group'] = '';
		$query_where['group'] = 'MONTH(t.datum)='.$Monat;

		foreach($query_where as $i => $clause) {$query .= (($i)?(' AND '):(' WHERE ')).$clause;}

		//------------------------------------------------------------------------------------------------------------------
		// Sortierung
		//------------------------------------------------------------------------------------------------------------------
		$query .= ' ORDER BY t.datum, m.aklagruppe DESC, m.nr, tp.uhrzeit';

		//------------------------------------------------------------------------------------------------------------------
		// Abfrage
		//------------------------------------------------------------------------------------------------------------------
		if(!$result = mysql_query($query)) {throw new Exception(mysql_error(CDBConnection::getDB()));}
		while($row = mysql_fetch_row($result)) {$TerminPSBArray[] = new CTerminPSB($row[0]);}

		//------------------------------------------------------------------------------------------------------------------
		// PostProcessing
		//------------------------------------------------------------------------------------------------------------------
		$h = 0;
		$i = 0;
		$j = 0;
		$TerminPSB = reset($TerminPSBArray);
		if($TerminPSB instanceof CTerminPSB)
		{
			$data['termin_psb_array_array_array_array'][$Monat][$h][$i][$j] = $TerminPSB;
			while($TerminPSB = next($TerminPSBArray))
			{
				$PreviousTerminPSB = $data['termin_psb_array_array_array_array'][$Monat][$h][$i][$j];

				if($PreviousTerminPSB->getDatum() == $TerminPSB->getDatum())
				{
					if(($PreviousTerminPSB->getMannschaftID() == $TerminPSB->getMannschaftID()) and
					($PreviousTerminPSB->getAustragungsortID() == $TerminPSB->getAustragungsortID())) {
						$data['termin_psb_array_array_array_array'][$Monat][$h][$i][++$j] = $TerminPSB;
					}
					else {
						$j = 0;
						$data['termin_psb_array_array_array_array'][$Monat][$h][++$i][$j] = $TerminPSB;
					}
				}
				else
				{
					$i = 0;
					$j = 0;
					$data['termin_psb_array_array_array_array'][$Monat][++$h][$i][$j] = $TerminPSB;
				}
			}
		}
		else
		{
			$data['termin_psb_array_array_array_array'][$Monat][$h][$i][$j] = array();
		}

		if(++$Monat > 12) {$Monat = 1;}
	}
}

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// RETURN
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

return new CTemplateData($data);
?>