<?php
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Modus und Ansicht
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

$data['modus'] = CSiteManager::getMode();
$data['view'] = C2C_Modus($data['modus']);

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Das Objekt
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

$Mannschaft = new CMannschaft();

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Modus: speichern!
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

if(MODE_SAVE == $data['modus'])
{
	if($_POST['mannschaft_id']) {$Mannschaft->load($_POST['mannschaft_id']);}

	$Mannschaft->setSaisonID($_POST['saison_id']);
	$Mannschaft->setAKlaGruppe($_POST['aklagruppe']);
	$Mannschaft->setNr($_POST['nr']);
	$Mannschaft->setPlatzierung1($_POST['platzierung1']);
	$Mannschaft->setPlatzierung2($_POST['platzierung2']);
	$Mannschaft->setLigaKlasseID($_POST['ligaklasse_id']);
	$Mannschaft->setVereinID($_POST['verein_id']);
	$Mannschaft->setBildunterschrift($_POST['bildunterschrift']);
	$Mannschaft->setErgDienst($_POST['ergdienst']);

	CUploadHandler::setProcessCmd(ATTACH_PIC, $_POST['pic']);

	$Mannschaft->save();
}

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Modus: löschen!
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

if(MODE_DROP == $data['modus'])
{
	$Mannschaft->load($_POST['drop']);
	$Mannschaft->delete();
}

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Detailansicht
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

if(VIEW_DETAIL == $data['view'])
{
	if(MODE_EDIT == $data['modus']) {$Mannschaft->load((int)$_POST['edit']);}
	$data['mannschaft'] = $Mannschaft;

	// SaisonArray
	$data['saison_array'] = array();
	$query = 'SELECT saison_id FROM saisons ORDER BY beginn DESC';
	if(!$result = mysqli_query(CDBConnection::getDB(), $query)) {throw new Exception(mysqlil_error(CDBConnection::getDB()));}
	while($row = mysqli_fetch_row($result)) {$data['saison_array'][] = new CSaison($row[0]);}

	$data['saison_id'] = CDBConnection::getInstance()->getSaisonID();

	// LigaKlasseArray
	$data['ligaklasse_array'] = array();
	$query = 'SELECT ligaklasse_id FROM ligenklassen ORDER BY aklagruppe DESC, bezeichnung';
	if(!$result = mysqli_query(CDBConnection::getDB(), $query)) {throw new Exception(mysqlil_error(CDBConnection::getDB()));}
	while($row = mysqli_fetch_row($result)) {$data['ligaklasse_array'][] = new CLigaKlasse($row[0]);}

	// VereinArray
	$data['verein_array'] = array();
	$query = 'SELECT v.verein_id FROM vereine v, vereine_benutzerinformationen vb WHERE NOT v.verein_id=vb.verein_id '.
	         'ORDER BY v.name, v.kuerzel';
	if(!$result = mysqli_query(CDBConnection::getDB(), $query)) {throw new Exception(mysqlil_error(CDBConnection::getDB()));}
	while($row = mysqli_fetch_row($result)) {$data['verein_array'][] = new CVerein($row[0]);}
}

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Filterung/Sortierung
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

$data['fltr1'] = ((isset($_GET['fltr1']))?((int)$_GET['fltr1']):(0));
$data['fltr2'] = ((isset($_GET['fltr2']))?((int)$_GET['fltr2']):(0));
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
	$query = 'SELECT mannschaft_id '.
	         'FROM (mannschaften m INNER JOIN saisons s ON m.saison_id=s.saison_id)';

	//--------------------------------------------------------------------------------------------------------------------
	// Filterung
	//--------------------------------------------------------------------------------------------------------------------

	$query_where = array();

	$fltr1_query = 'SELECT saison_id FROM saisons ORDER BY beginn DESC';
	if(!$result = mysqli_query(CDBConnection::getDB(), $fltr1_query)) {throw new Exception(mysqli_error(CDBConnection::getDB()));}
	while($row = mysqli_fetch_row($result)) {$data['fltr1_array'][] = new CSaison($row[0]);}
	if($data['fltr1']) {$query_where[] = 's.saison_id='.$data['fltr1'];}

	if($data['fltr2']) {$query_where[] = 'm.aklagruppe='.$data['fltr2'];}

	foreach($query_where as $i => $clause) {$query .= (($i)?(' AND '):(' WHERE ')).$clause;}

	//--------------------------------------------------------------------------------------------------------------------
	// Sortierung
	//--------------------------------------------------------------------------------------------------------------------
	switch($data['sort'])
	{
		case 1: $query .= ' ORDER BY aklagruppe DESC, nr, s.beginn DESC'; break;
		case 2: $query .= ' ORDER BY nr, aklagruppe DESC, s.beginn DESC'; break;
		default: $query .= ' ORDER BY s.beginn DESC, aklagruppe DESC, nr'; break;
	}
	//--------------------------------------------------------------------------------------------------------------------
	// Abfrage
	//--------------------------------------------------------------------------------------------------------------------

	$data['mannschaft_array'] = array();
	if(!$result = mysqli_query(CDBConnection::getDB(), $query)) {throw new Exception(mysqlil_error(CDBConnection::getDB()));}
	while($row = mysqli_fetch_row($result)) {$data['mannschaft_array'][] = new CMannschaft($row[0]);}
}

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// RETURN
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

return new CTemplateData($data);
?>