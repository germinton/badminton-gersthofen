<?php
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Modus und Ansicht
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

$data['modus'] = CSiteManager::getMode();
$data['view'] = C2C_Modus($data['modus']);

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Das Objekt
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

$TerminAllg = new CTerminAllg();

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Modus: speichern!
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

if(MODE_SAVE == $data['modus'])
{
	if($_POST['termin_id']) {$TerminAllg->load($_POST['termin_id']);}

	$TerminAllg->setDatum(S2S_Datum_Deu2MySql(trim($_POST['datum'])));
	$TerminAllg->setFreitext($_POST['freitext']);
	$TerminAllg->setTitel($_POST['titel']);
	$TerminAllg->setOrt($_POST['ort']);
	$TerminAllg->setAthletID($_POST['athlet_id']);
	$TerminAllg->setEndedatum(S2S_Datum_Deu2MySql(trim($_POST['endedatum'])));
	$TerminAllg->setFuerA(isset($_POST['fuer_a']));
	$TerminAllg->setFuerJ(isset($_POST['fuer_j']));
	$TerminAllg->setFuerS(isset($_POST['fuer_s']));

	CUploadHandler::setProcessCmd(ATTACH_PIC, $_POST['pic']);
	CUploadHandler::setProcessCmd(ATTACH_FILE1, $_POST['file1']);
	CUploadHandler::setProcessCmd(ATTACH_FILE2, $_POST['file2']);
	CUploadHandler::setProcessCmd(ATTACH_FILE3, $_POST['file3']);

	$TerminAllg->save();
}

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Modus: löschen!
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

if(MODE_DROP == $data['modus'])
{
	$TerminAllg->load($_POST['drop']);
	$TerminAllg->delete();
}

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Detailansicht
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

if(VIEW_DETAIL == $data['view'])
{
	$Mitglied = CSiteManager::getInstance()->getMitglied();
	$AthletIDArray = CSiteManager::getInstance()->getNavForSecRequest()->getAthletIDArray();

	if(MODE_EDIT == $data['modus'])
	{
		$TerminAllg->load($_POST['edit']);
		$AthletIDArray = array_unique(array_merge($AthletIDArray, array($TerminAllg->getAthletID())));
		$data['athlet_id'] = $TerminAllg->getAthletID();
	}
	if(MODE_NEW == $data['modus'])
	{
		$data['athlet_id'] = $Mitglied->getAthletID();
	}
	if($Mitglied->hatAufgabe(S_DBENTWICKLER)) {
		$AthletIDArray = array_unique(array_merge($AthletIDArray, array($Mitglied->getAthletID())));
	}
	$data['heute'] = date('Y-m-d');
	$data['mitglied_array'] = array();
	foreach($AthletIDArray as $AthletID) {$data['mitglied_array'][] = new CMitglied((int)$AthletID);}
	$data['allg_termin'] = $TerminAllg;
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
	$query = 'SELECT ta.termin_id '.
	         'FROM termine_allgemein ta INNER JOIN termine t ON ta.termin_id=t.termin_id';

	//--------------------------------------------------------------------------------------------------------------------
	// Filterung
	//--------------------------------------------------------------------------------------------------------------------
	$query_where = array();

	if(!$data['fltr1']) {$query_where[] = 'IFNULL(ta.endedatum, t.datum) >= CURDATE()';}

	foreach($query_where as $i => $clause) {$query .= (($i)?(' AND '):(' WHERE ')).$clause;}

	//--------------------------------------------------------------------------------------------------------------------
	// Sortierung
	//--------------------------------------------------------------------------------------------------------------------
	switch($data['sort'])
	{
		default: $query .= ' ORDER BY datum'; break;
	}

	//--------------------------------------------------------------------------------------------------------------------
	// Abfrage
	//--------------------------------------------------------------------------------------------------------------------
	$data['allg_termin_array'] = array();
	if(!$result = mysql_query($query)) {throw new Exception(mysql_error(CDBConnection::getDB()));}
	while($row = mysql_fetch_row($result)) {$data['allg_termin_array'][] = new CTerminAllg($row[0]);}
}

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// RETURN
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

return new CTemplateData($data);
?>