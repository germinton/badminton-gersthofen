<?php
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Modus und Ansicht
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

if(CDBConnection::getInstance()->getAthLock()) {throw new CShowError(STR_ATH_LOCK);}
$data['modus'] = CSiteManager::getMode();
$data['view'] = C2C_Modus($data['modus']);

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Das Objekt
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

$Gegner = new CGegner();

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Modus: speichern!
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

if(MODE_SAVE == $data['modus'])
{
	if($_POST['athlet_id']) {$Gegner->load($_POST['athlet_id']);}

	$Gegner->setAnrede($_POST['anrede']);
	$Gegner->setNachname($_POST['nachname']);
	$Gegner->setVorname($_POST['vorname']);
	$Gegner->setVereinID($_POST['verein_id']);

	$Gegner->save();
}

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Modus: löschen!
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

if(MODE_DROP == $data['modus'])
{
	$Gegner->load((int)$_POST['drop']);
	$Gegner->delete();
}

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Detailansicht
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

if(VIEW_DETAIL == $data['view'])
{
	if(MODE_EDIT == $data['modus']) {$Gegner->load((int)$_POST['edit']);}
	$data['gegner'] = $Gegner;

	// VereinArray
	$data['verein_array'] = array();
	$query = 'SELECT v.verein_id FROM vereine v LEFT JOIN vereine_benutzerinformationen vb '.
	         'ON v.verein_id=vb.verein_id WHERE vb.verein_id IS NULL ORDER BY name, kuerzel';
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
	$query = 'SELECT a.athlet_id '.
	         'FROM (athleten_gegner ag LEFT JOIN vereine v ON ag.verein_id=v.verein_id) '.
	         'INNER JOIN athleten a ON a.athlet_id=ag.athlet_id';

	//--------------------------------------------------------------------------------------------------------------------
	// Filterung
	//--------------------------------------------------------------------------------------------------------------------
	$query_where = array();

	$data['fltr1_array'] = array();
	$fltr1_query = 'SELECT v.verein_id FROM vereine v LEFT JOIN vereine_benutzerinformationen vb '.
	               'ON v.verein_id=vb.verein_id WHERE vb.verein_id IS NULL ORDER BY name, kuerzel';
	if(!$result = mysql_query($fltr1_query)) {throw new Exception(mysql_error(CDBConnection::getDB()));}
	while($row = mysql_fetch_row($result)) {$data['fltr1_array'][] = new CVerein($row[0]);}
	if($data['fltr1']) {$query_where[] = 'v.verein_id'.((-1==$data['fltr1'])?(' IS NULL'):('='.$data['fltr1']));}

	foreach($query_where as $i => $clause) {$query .= (($i)?(' AND '):(' WHERE ')).$clause;}

	//--------------------------------------------------------------------------------------------------------------------
	// Sortierung
	//--------------------------------------------------------------------------------------------------------------------
	switch($data['sort'])
	{
		case 1: $query .= ' ORDER BY v.name, v.kuerzel, a.nachname, a.vorname'; break;
		default: $query .= ' ORDER BY a.nachname, a.vorname, v.name, v.kuerzel'; break;
	}

	//--------------------------------------------------------------------------------------------------------------------
	// Abfrage
	//--------------------------------------------------------------------------------------------------------------------
	$data['gegner_array_'.S_HERR] = array();
	$data['gegner_array_'.S_DAME] = array();
	if(!$result = mysql_query($query)) {throw new Exception(mysql_error(CDBConnection::getDB()));}
	while($row = mysql_fetch_row($result)) {
		$TmpGegner = new CGegner($row[0]);
		$data['gegner_array_'.$TmpGegner->getAnrede()][] = $TmpGegner;
	}
}

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// RETURN
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

return new CTemplateData($data);
?>