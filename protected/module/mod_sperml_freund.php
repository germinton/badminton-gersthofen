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
	$SpErMl_X = new CSpErMlFreundschaft($_GET['sperml_id']);
	$data['sperml_x'] = $SpErMl_X;
}

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Filterung/Sortierung
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

$data['fltr1'] = ((isset($_GET['fltr1']))?((int)$_GET['fltr1']):(0));
$data['sort'] = ((isset($_GET['sort']))?((int)$_GET['sort']):(0));

$data['fs_string'] = '';
$data['fs_string'] .= (($s = $data['fltr1'])?('&amp;fltr1='.$s):(''));
$data['fs_string'] .= (($s = $data['sort'])?('&amp;sort='.$s):(''));

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Übersicht
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

if(VIEW_LIST == $data['view'])
{
	//--------------------------------------------------------------------------------------------------------------------
	// Auswahl
	//--------------------------------------------------------------------------------------------------------------------
	$query = 'SELECT s.sperml_id '.
	         'FROM sperml s INNER JOIN sperml_freundschaft sf ON s.sperml_id=sf.sperml_id';

	//--------------------------------------------------------------------------------------------------------------------
	// Filterung
	//--------------------------------------------------------------------------------------------------------------------
	$query_where = array();

	$fltr1_query = 'SELECT s.saison_id '.
	               'FROM saisons s, sperml sp INNER JOIN sperml_freundschaft sf ON sp.sperml_id=sf.sperml_id '.
	               'WHERE sp.datum BETWEEN s.beginn AND s.ende GROUP BY s.saison_id ORDER BY s.beginn DESC';
	if(!$result = mysqli_query(CDBConnection::getDB(), $fltr1_query)) {throw new Exception(mysqli_error(CDBConnection::getDB()));}
	while($row = mysqli_fetch_row($result)) {$data['fltr1_array'][] = new CSaison($row[0]);}
	if($data['fltr1']) {
		$Saison = new CSaison($data['fltr1']);
		$query_where[] = 's.datum BETWEEN \''.$Saison->getBeginn().'\' AND \''.$Saison->getEnde().'\'';
	}

	foreach($query_where as $i => $clause) {$query .= (($i)?(' AND '):(' WHERE ')).$clause;}

	//--------------------------------------------------------------------------------------------------------------------
	// Sortierung
	//--------------------------------------------------------------------------------------------------------------------
	switch($data['sort'])
	{
		case 1: $query .= ' ORDER BY s.datum DESC'; break;
		default: $query .= ' ORDER BY s.datum'; break;
	}

	//--------------------------------------------------------------------------------------------------------------------
	// Abfrage
	//--------------------------------------------------------------------------------------------------------------------
	$data['sperml_x_array'] = array();
	if(!$result = mysqli_query(CDBConnection::getDB(), $query)) {throw new Exception(mysqlil_error(CDBConnection::getDB()));}
	while($row = mysqli_fetch_row($result)) {$data['sperml_x_array'][] = new CSpErMlFreundschaft($row[0]);}
}

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// RETURN
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

return new CTemplateData($data);
?>