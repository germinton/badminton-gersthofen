<?php
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Modus und Ansicht
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

$data['modus'] = CSiteManager::getMode();
$data['view'] = C2C_Modus($data['modus']);

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Das Objekt
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

$TerminPSB = new CTerminPSB();

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Modus: speichern!
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

if(MODE_SAVE == $data['modus'])
{
	if($_POST['termin_id']) {$TerminPSB->load($_POST['termin_id']);}

	$TerminPSB->setDatum(S2S_Datum_Deu2MySql(trim($_POST['datum'])));
	$TerminPSB->setFreitext($_POST['freitext']);
	$TerminPSB->setMannschaftID($_POST['mannschaft_id']);
	$TerminPSB->setAustragungsortID($_POST['austragungsort_id']);
	$TerminPSB->setUhrzeit($_POST['uhrzeit_h'].':'.$_POST['uhrzeit_m'].':00');
	$TerminPSB->setSeite($_POST['seite']);
	$TerminPSB->setVereinID($_POST['verein_id']);
	$TerminPSB->setMannschaftNr($_POST['mannschaftnr']);

	$TerminPSB->save();
}

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Modus: löschen!
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

if(MODE_DROP == $data['modus'])
{
	$TerminPSB->load($_POST['drop']);
	$TerminPSB->delete();
}

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Detailansicht
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

if(VIEW_DETAIL == $data['view'])
{
	if(MODE_EDIT == $data['modus']) {$TerminPSB->load($_POST['edit']);}
	$data['heute'] = date('Y-m-d');

	$data['psb_termin'] = $TerminPSB;

	// MannschaftArray
	$data['mannschaft_array'] = array();
	$query = 'SELECT mannschaft_id FROM mannschaften WHERE saison_id='.CDBConnection::getInstance()->getSaisonID().' '.
	         'ORDER BY aklagruppe DESC, nr';
	if(!$result = mysql_query($query)) {throw new Exception(mysql_error(CDBConnection::getDB()));}
	while($row = mysql_fetch_row($result)) {$data['mannschaft_array'][] = new CMannschaft($row[0]);}

	// AustragungsortArray
	$data['austragungsort_array'] = array();
	$query = 'SELECT austragungsort_id FROM austragungsorte ORDER BY ort';
	if(!$result = mysql_query($query)) {throw new Exception(mysql_error(CDBConnection::getDB()));}
	while($row = mysql_fetch_row($result)) {$data['austragungsort_array'][] = new CAustragungsort($row[0]);}

	// VereinArray
	$data['verein_array'] = array();
	$query = 'SELECT verein_id FROM vereine ORDER BY name, kuerzel';
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
	$query = 'SELECT tp.termin_id '.
	         'FROM ((termine_pktspbeg tp INNER JOIN termine t ON tp.termin_id=t.termin_id) '.
	         'INNER JOIN mannschaften m ON tp.mannschaft_id=m.mannschaft_ID) '.
	         'INNER JOIN _parameter p ON m.saison_id=p.saison_id';

	//--------------------------------------------------------------------------------------------------------------------
	// Filterung
	//--------------------------------------------------------------------------------------------------------------------
	$query_where = array();

	$fltr1_query = 'SELECT m.mannschaft_id FROM mannschaften m '.
	               'INNER JOIN _parameter p ON m.saison_id=p.saison_id ORDER BY m.aklagruppe DESC, m.verein_id, m.nr';
	if(!$result = mysql_query($fltr1_query)) {throw new Exception(mysql_error(CDBConnection::getDB()));}
	while($row = mysql_fetch_row($result)) {$data['fltr1_array'][] = new CMannschaft($row[0]);}
	if($data['fltr1']) {$query_where[] = 'm.mannschaft_id='.$data['fltr1'];}

	foreach($query_where as $i => $clause) {$query .= (($i)?(' AND '):(' WHERE ')).$clause;}

	//--------------------------------------------------------------------------------------------------------------------
	// Sortierung
	//--------------------------------------------------------------------------------------------------------------------
	switch($data['sort'])
	{
		case 1: $query .= ' ORDER BY m.aklagruppe  DESC, m.nr, t.datum, tp.uhrzeit'; break;
		default: $query .= ' ORDER BY t.datum, tp.uhrzeit, m.aklagruppe  DESC, m.nr'; break;
	}

	//--------------------------------------------------------------------------------------------------------------------
	// Abfrage
	//--------------------------------------------------------------------------------------------------------------------
	$data['termin_psb_array'] = array();
	if(!$result = mysql_query($query)) {throw new Exception(mysql_error(CDBConnection::getDB()));}
	while($row = mysql_fetch_row($result)) {$data['termin_psb_array'][] = new CTerminPSB($row[0]);}
}

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// RETURN
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

return new CTemplateData($data);
?>