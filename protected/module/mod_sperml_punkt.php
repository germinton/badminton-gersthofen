<?php
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Ansicht
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

$data['view'] = ((isset($_GET['sperml_id']))?(VIEW_DETAIL):(VIEW_LIST));

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Detailansicht
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

if(VIEW_DETAIL == $data['view'])
{
	$query = 'SELECT spermltyp FROM _v1_punktspiele WHERE sperml_id='.$_GET['sperml_id'];
	if(!$result = mysqli_query(CDriveEntity::getDB(), $query)) {throw new Exception(mysqli_error(CDriveEntity::getDB()));}
	$row = mysqli_fetch_row($result);

	switch($row[0])
	{
		case S_PKTSPEXT: $SpErMl_X = new CSpErMlPunktspielExtern($_GET['sperml_id']); break;
		case S_PKTSPINT: $SpErMl_X = new CSpErMlPunktspielIntern($_GET['sperml_id']); break;
		default: break;
	}

	$data['sperml_x'] = $SpErMl_X;
}

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Filterung/Sortierung
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

$data['fltr1'] = ((isset($_GET['fltr1']))?((int)$_GET['fltr1']):(CDBConnection::getSaisonID()));
$data['fltr2'] = ((isset($_GET['fltr2']))?((string)$_GET['fltr2']):(0));
$data['sort'] = ((isset($_GET['sort']))?((int)$_GET['sort']):(0));

$data['fs_string'] = '';
$data['fs_string'] .= (($s = $data['fltr1'])?('&amp;fltr1='.$s):(''));
$data['fs_string'] .= (($s = $data['fltr2'])?('&amp;fltr2='.$s):(''));
$data['fs_string'] .= (($s = $data['sort'])?('&amp;sort='.$s):(''));

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Übersicht
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

if(VIEW_LIST == $data['view'])
{
	//--------------------------------------------------------------------------------------------------------------------
	// Auswahl
	//--------------------------------------------------------------------------------------------------------------------
	$query = 'SELECT ps.sperml_id, ps.spermltyp '.
	         'FROM _v1_punktspiele ps INNER JOIN mannschaften m ON ps.mannschaft_id=m.mannschaft_id';

	//--------------------------------------------------------------------------------------------------------------------
	// Filterung
	//--------------------------------------------------------------------------------------------------------------------
	$query_where = array();

	$fltr1_query = 'SELECT saison_id FROM saisons ORDER BY beginn DESC';
	if(!$result = mysqli_query(CDBConnection::getDB(), $fltr1_query)) {throw new Exception(mysqli_error(CDBConnection::getDB()));}
	while($row = mysqli_fetch_row($result)) {$data['fltr1_array'][] = new CSaison($row[0]);}
	if($data['fltr1']) {$query_where[] = 'm.saison_id='.$data['fltr1'];}

	$fltr2_query = 'SELECT CONCAT(m.aklagruppe, \'-\', IFNULL(m.verein_id, 0), \'-\', m.nr), m.mannschaft_id FROM mannschaften m '.
	               'GROUP BY m.aklagruppe, m.verein_id, m.nr ORDER BY m.aklagruppe DESC, m.verein_id, m.nr';
	if(!$result = mysqli_query(CDBConnection::getDB(), $fltr2_query)) {throw new Exception(mysqli_error(CDBConnection::getDB()));}
	while($row = mysqli_fetch_row($result)) {
		$data['fltr2_array_1'][] = $row[0];
		$data['fltr2_array_2'][] = new CMannschaft($row[1]);
	}
	if($data['fltr2']) {
		$fltr2 = explode('-', $_GET['fltr2']);
		$query_where[] = '(m.aklagruppe='.$fltr2[0].' AND m.verein_id'.(($fltr2[1])?('='.$fltr2[1]):(' IS NULL')).' AND m.nr='.$fltr2[2].')';
	}

	foreach($query_where as $i => $clause) {$query .= (($i)?(' AND '):(' WHERE ')).$clause;}

	//--------------------------------------------------------------------------------------------------------------------
	// Sortierung
	//--------------------------------------------------------------------------------------------------------------------
	switch($data['sort'])
	{
		case 1: $query .= ' ORDER BY m.aklagruppe DESC, m.verein_id, m.nr, ps.datum'; break;
		default: $query .= ' ORDER BY ps.datum DESC, m.aklagruppe DESC, m.verein_id, m.nr'; break;
	}

	//--------------------------------------------------------------------------------------------------------------------
	// Abfrage
	//--------------------------------------------------------------------------------------------------------------------
	$data['sperml_x_array'] = array();
	if(!$result = mysqli_query(CDBConnection::getDB(), $query)) {throw new Exception(mysqlil_error(CDBConnection::getDB()));}
	while($row = mysqli_fetch_row($result)) {
		switch($row[1])
		{
			case S_PKTSPEXT: $data['sperml_x_array'][] = new CSpErMlPunktspielExtern($row[0]); break;
			case S_PKTSPINT: $data['sperml_x_array'][] = new CSpErMlPunktspielIntern($row[0]); break;
			default: break;
		}
	}
}

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// RETURN
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

return new CTemplateData($data);
?>