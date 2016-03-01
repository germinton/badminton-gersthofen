<?php
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Modus und Ansicht
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

$data['modus'] = CSiteManager::getMode();
$data['view'] = C2C_Modus($data['modus']);

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Das Objekt
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

$Neuigkeit = new CNeuigkeit();

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Modus: speichern!
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

if(MODE_SAVE == $data['modus'])
{
	if($_POST['neuigkeit_id']) {$Neuigkeit->load($_POST['neuigkeit_id']);}

	$Neuigkeit->setAthletID($_POST['athlet_id']);
	$Neuigkeit->setTitel($_POST['titel']);
	$Neuigkeit->setInhalt($_POST['inhalt']);
	if(!$_POST['neuigkeit_id'] or isset($_POST['eingestellt'])) {$Neuigkeit->setEingestellt(date('Y-m-d'));}
	$Neuigkeit->setGueltigBis(S2S_Datum_Deu2MySql(trim($_POST['gueltigbis'])));
	$Neuigkeit->setWichtig(isset($_POST['wichtig']));

	CUploadHandler::setProcessCmd(ATTACH_PIC, $_POST['pic']);
	CUploadHandler::setProcessCmd(ATTACH_FILE1, $_POST['file1']);
	CUploadHandler::setProcessCmd(ATTACH_FILE2, $_POST['file2']);
	CUploadHandler::setProcessCmd(ATTACH_FILE3, $_POST['file3']);

	$Neuigkeit->save();
}

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Modus: löschen!
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

if(MODE_DROP == $data['modus'])
{
	$Neuigkeit->load($_POST['drop']);
	$Neuigkeit->delete();
}

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Detailansicht
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

if(VIEW_DETAIL == $data['view'])
{
	$Mitglied = CSiteManager::getInstance()->getMitglied();
	$AthletIDArray = CSiteManager::getInstance()->getNavForSecRequest()->getAthletIDArray();
	foreach($AthletIDArray as $AthletID) { if(CMitglied::isValidID($AthletID)) { $MitgliedIDArray[] = $AthletID; } }

	if(MODE_EDIT == $data['modus'])
	{
		$Neuigkeit->load($_POST['edit']);
		$MitgliedIDArray = array_unique(array_merge($MitgliedIDArray, array($Neuigkeit->getAthletID())));
		$data['athlet_id'] = $Neuigkeit->getAthletID();
	}
	if(MODE_NEW == $data['modus'])
	{
		$data['athlet_id'] = $Mitglied->getAthletID();
	}
	if($Mitglied->hatAufgabe(S_DBENTWICKLER)) {
		$MitgliedIDArray = array_unique(array_merge($MitgliedIDArray, array($Mitglied->getAthletID())));
	}
	$data['heute'] = date('Y-m-d');
	$data['mitglied_array'] = array();
	foreach($MitgliedIDArray as $MitgliedID) {$data['mitglied_array'][] = new CMitglied((int)$MitgliedID);}
	$data['neuigkeit'] = $Neuigkeit;
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
	$query = 'SELECT neuigkeit_id '.
	         'FROM neuigkeiten';

	//--------------------------------------------------------------------------------------------------------------------
	// Filterung
	//--------------------------------------------------------------------------------------------------------------------
	$query_where = array();

	if(!$data['fltr1']) {$query_where[] = '(gueltigbis IS NULL) OR (gueltigbis >= CURDATE())';}

	foreach($query_where as $i => $clause) {$query .= (($i)?(' AND '):(' WHERE ')).$clause;}

	//--------------------------------------------------------------------------------------------------------------------
	// Sortierung
	//--------------------------------------------------------------------------------------------------------------------
	switch($data['sort'])
	{
		case 1: $query .= ' ORDER BY gueltigbis DESC'; break;
		default: $query .= ' ORDER BY eingestellt DESC'; break;
	}

	//--------------------------------------------------------------------------------------------------------------------
	// Abfrage
	//--------------------------------------------------------------------------------------------------------------------
	$data['neuigkeit_array'] = array();
	if(!$result = mysqli_query(CDBConnection::getDB(), $query)) {throw new Exception(mysqlil_error(CDBConnection::getDB()));}
	while($row = mysqli_fetch_row($result)) {$data['neuigkeit_array'][] = new CNeuigkeit($row[0]);}
}

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// RETURN
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

return new CTemplateData($data);
?>