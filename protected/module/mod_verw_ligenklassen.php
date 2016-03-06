<?php
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Modus und Ansicht
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

$data['modus'] = CSiteManager::getMode();
$data['view'] = C2C_Modus($data['modus']);

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Das Objekt
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

$LigaKlasse = new CLigaKlasse();

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Modus: speichern!
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

if(MODE_SAVE == $data['modus'])
{
	if($_POST['ligaklasse_id']) {$LigaKlasse->load($_POST['ligaklasse_id']);}

	$LigaKlasse->setBezeichnung($_POST['bezeichnung']);
	$LigaKlasse->setAKlaGruppe($_POST['aklagruppe']);

	$LigaKlasse->save();
}

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Modus: löschen!
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

if(MODE_DROP == $data['modus'])
{
	$LigaKlasse->load($_POST['drop']);
	$LigaKlasse->delete();
}

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Detailansicht
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

if(VIEW_DETAIL == $data['view'])
{
	if(MODE_EDIT == $data['modus']) {$LigaKlasse->load((int)$_POST['edit']);}
	$data['ligaklasse'] = $LigaKlasse;
}

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Filterung/Sortierung
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

$data['fltr1'] = ((isset($_GET['fltr1']))?(1):(0));
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
	$query = 'SELECT ligaklasse_id '.
	         'FROM ligenklassen';

	//--------------------------------------------------------------------------------------------------------------------
	// Filterung
	//--------------------------------------------------------------------------------------------------------------------

	$query_where = array();

	foreach($query_where as $i => $clause) {$query .= (($i)?(' AND '):(' WHERE ')).$clause;}

	//--------------------------------------------------------------------------------------------------------------------
	// Sortierung
	//--------------------------------------------------------------------------------------------------------------------
	switch($data['sort'])
	{
		case 1: $query .= ' ORDER BY bezeichnung, aklagruppe'; break;
		default: $query .= ' ORDER BY aklagruppe, bezeichnung'; break;
	}

	//--------------------------------------------------------------------------------------------------------------------
	// Abfrage
	//--------------------------------------------------------------------------------------------------------------------

	$data['ligaklasse_array'] = array();
	if(!$result = mysqli_query(CDBConnection::getDB(), $query)) {throw new Exception(mysqlil_error(CDBConnection::getDB()));}
	while($row = mysqli_fetch_row($result)) {$data['ligaklasse_array'][] = new CLigaKlasse($row[0]);}
}

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// RETURN
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

return new CTemplateData($data);
?>