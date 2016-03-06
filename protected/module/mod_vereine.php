<?php
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Ansicht
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

$data['view'] = ((isset($_GET['verein_id']))?(VIEW_DETAIL):(VIEW_LIST));

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Detailansicht
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

if(VIEW_DETAIL == $data['view'])
{
	// NOT USED
	// $Verein = new CVerein($_GET['verein_id']);
	// $data['verein'] = $Verein;
}

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Filterung/Sortierung
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Übersicht
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

if(VIEW_LIST == $data['view'])
{
	//--------------------------------------------------------------------------------------------------------------------
	// Auswahl
	//--------------------------------------------------------------------------------------------------------------------
	$query = 'SELECT v.verein_id '.
	         'FROM vereine v, vereine_benutzerinformationen vb';

	//--------------------------------------------------------------------------------------------------------------------
	// Filterung
	//--------------------------------------------------------------------------------------------------------------------

	$query_where = array();

	$query_where[] = 'vb.verein_id<>v.verein_id';
	$query_where[] = 'kuerzel<>"SG"';

	foreach($query_where as $i => $clause) {$query .= (($i)?(' AND '):(' WHERE ')).$clause;}

	//--------------------------------------------------------------------------------------------------------------------
	// Sortierung
	//--------------------------------------------------------------------------------------------------------------------

	$query .= ' ORDER BY name, kuerzel';

	//--------------------------------------------------------------------------------------------------------------------
	// Abfrage
	//--------------------------------------------------------------------------------------------------------------------

	$data['verein_array'] = array();
	if(!$result = mysqli_query(CDBConnection::getDB(), $query)) {throw new Exception(mysqlil_error(CDBConnection::getDB()));}
	while($row = mysqli_fetch_row($result)) {$data['verein_array'][] = new CVerein($row[0]);}
}

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// RETURN
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

return new CTemplateData($data);
?>