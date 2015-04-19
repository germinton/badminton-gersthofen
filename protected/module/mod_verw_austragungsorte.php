<?php
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Modus und Ansicht
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

$data['modus'] = CSiteManager::getMode();
$data['view'] = C2C_Modus($data['modus']);

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Das Objekt
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

$Austragungsort = new CAustragungsort();

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Modus: speichern!
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

if(MODE_SAVE == $data['modus'])
{
	if($_POST['austragungsort_id']) {$Austragungsort->load($_POST['austragungsort_id']);}

	$Austragungsort->setHallenname($_POST['hallenname']);
	$Austragungsort->setVereinID($_POST['verein_id']);
	$Austragungsort->setStrasse($_POST['strasse']);
	$Austragungsort->setPLZ($_POST['plz']);
	$Austragungsort->setOrt($_POST['ort']);
	$Austragungsort->setFelder($_POST['felder']);
	$Austragungsort->setInfo($_POST['info']);

	if(strlen($s = $_POST['gmap_lat'])) {
		if(!(preg_match(REGEX_FLOAT, $s))) {$Austragungsort->addCheckMsg('Der Breitengrad hat ein falsches Format.');}
		else {$Austragungsort->setGMapLat(MyFloatstring2Int($s));}
	}
	else {$Austragungsort->setGMapLat(null);}

	if(strlen($s = $_POST['gmap_lon'])) {
		if(!(preg_match(REGEX_FLOAT, $s))) {$Austragungsort->addCheckMsg('Der Längengrad hat ein falsches Format.');}
		else {$Austragungsort->setGMapLon(MyFloatstring2Int($s));}
	}
	else {$Austragungsort->setGMapLon(null);}

	CUploadHandler::setProcessCmd(ATTACH_PIC, $_POST['pic']);

	$Austragungsort->save();
}

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Modus: löschen!
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

if(MODE_DROP == $data['modus'])
{
	$Austragungsort->load($_POST['drop']);
	$Austragungsort->delete();
}

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Detailansicht
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

if(VIEW_DETAIL == $data['view'])
{
	if(MODE_EDIT == $data['modus']) {$Austragungsort->load((int)$_POST['edit']);}
	$data['austragungsort'] = $Austragungsort;

	// VereinArray
	$data['verein_array'] = array();
	$query = 'SELECT v.verein_id FROM vereine v ORDER BY v.name, v.kuerzel';
	if(!$result = mysql_query($query)) {throw new Exception(mysql_error(CDBConnection::getDB()));}
	while($row = mysql_fetch_row($result)) {$data['verein_array'][] = new CVerein($row[0]);}
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
	$query = 'SELECT a.austragungsort_id '.
	         'FROM austragungsorte a LEFT JOIN vereine v ON a.verein_id=v.verein_id';

	//--------------------------------------------------------------------------------------------------------------------
	// Filterung
	//--------------------------------------------------------------------------------------------------------------------

	$query_where = array();

	$fltr1_query = 'SELECT verein_id FROM vereine ORDER BY name, kuerzel';
	if(!$result = mysql_query($fltr1_query)) {throw new Exception(mysql_error(CDBConnection::getDB()));}
	while($row = mysql_fetch_row($result)) {$data['fltr1_array'][] = new CVerein($row[0]);}
	if($data['fltr1']) {$query_where[] = 'v.verein_id='.$data['fltr1'];}

	foreach($query_where as $i => $clause) {$query .= (($i)?(' AND '):(' WHERE ')).$clause;}

	//--------------------------------------------------------------------------------------------------------------------
	// Sortierung
	//--------------------------------------------------------------------------------------------------------------------
	switch($data['sort'])
	{
		case 1: $query .= ' ORDER BY v.name, a.ort, a.hallenname'; break;
		case 2: $query .= ' ORDER BY a.hallenname, a.ort, v.name'; break;
		default: $query .= ' ORDER BY a.ort, a.hallenname'; break;
	}
	//--------------------------------------------------------------------------------------------------------------------
	// Abfrage
	//--------------------------------------------------------------------------------------------------------------------

	$data['austragungsort_array'] = array();
	if(!$result = mysql_query($query)) {throw new Exception(mysql_error(CDBConnection::getDB()));}
	while($row = mysql_fetch_row($result)) {$data['austragungsort_array'][] = new CAustragungsort($row[0]);}
}

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// RETURN
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

return new CTemplateData($data);
?>