<?php
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Modus und Ansicht
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

$data['modus'] = CSiteManager::getMode();
$data['view'] = C2C_Modus($data['modus']);

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Das Objekt
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

$Aufgabenzuordnung = new CAufgabenzuordnung();

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Modus: speichern!
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

if(MODE_SAVE == $data['modus'])
{
	if($_POST['aufgabenzuordnung_id']) {$Aufgabenzuordnung->load($_POST['aufgabenzuordnung_id']);}

	$Aufgabenzuordnung->setAufgabeID($_POST['aufgabe_id']);
	$Aufgabenzuordnung->setAthletID($_POST['athlet_id']);
	$Aufgabenzuordnung->setZusatzinfo($_POST['zusatzinfo']);

	$Aufgabenzuordnung->save();
}

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Modus: löschen!
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

if(MODE_DROP == $data['modus'])
{
	$Aufgabenzuordnung->load((int)$_POST['drop']);
	$Aufgabenzuordnung->delete();
}

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Detailansicht
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

if(VIEW_DETAIL == $data['view'])
{
	if(MODE_EDIT == $data['modus']) {$Aufgabenzuordnung->load((int)$_POST['edit']);}
	$data['aufgabenzuordnung'] = $Aufgabenzuordnung;

	//MitgliederArray
	$data['mitglieder_array'] = array();
	$query = 'SELECT a.athlet_id FROM athleten a INNER JOIN athleten_mitglieder am ON a.athlet_id=am.athlet_id '.
	         'ORDER BY a.nachname, a.vorname';
	if(!$result = mysqli_query(CDBConnection::getDB(), $query)) {throw new Exception(mysqlil_error(CDBConnection::getDB()));}
	while($row = mysqli_fetch_row($result)) {$data['mitglieder_array'][] = new CMitglied($row[0]);}

	//AufgabenArray
	$data['aufgaben_array'] = array();
	$query = 'SELECT aufgabe_id FROM aufgaben '.
	         'WHERE NOT (aufgabe_id='.S_STAFFELLEITER.' OR aufgabe_id='.S_MANNSCHAFTSFUEHRER.') ORDER BY bez_maennlich';
	if(!$result = mysqli_query(CDBConnection::getDB(), $query)) {throw new Exception(mysqlil_error(CDBConnection::getDB()));}
	while($row = mysqli_fetch_row($result)) {$data['aufgaben_array'][] = new CAufgabe($row[0]);}
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
	$query = 'SELECT az.aufgabenzuordnung_id '.
	         'FROM (aufgabenzuordnungen az INNER JOIN aufgaben af ON af.aufgabe_id=az.aufgabe_id) '.
	         'INNER JOIN athleten a ON a.athlet_id=az.athlet_id';

	//--------------------------------------------------------------------------------------------------------------------
	// Filterung
	//--------------------------------------------------------------------------------------------------------------------
	$query_where = array();

	$data['fltr1_array'] = array();
	$fltr1_query = 'SELECT a.athlet_id '.
	               'FROM athleten a INNER JOIN aufgabenzuordnungen az ON a.athlet_id=az.athlet_id '.
	               'GROUP BY a.athlet_id ORDER BY a.nachname, a.vorname';
	if(!$result = mysqli_query(CDBConnection::getDB(), $fltr1_query)) {throw new Exception(mysqli_error(CDBConnection::getDB()));}
	while($row = mysqli_fetch_row($result)) {$data['fltr1_array'][] = new CMitglied($row[0]);}
	if($data['fltr1']) {$query_where[] = 'az.athlet_id='.$data['fltr1'];}

	$data['fltr2_array'] = array();
	$fltr2_query = 'SELECT af.aufgabe_id '.
	               'FROM aufgaben af INNER JOIN aufgabenzuordnungen az ON af.aufgabe_id=az.aufgabe_id '.
	               'GROUP BY af.aufgabe_id ORDER BY bez_maennlich, sortierung DESC';
	if(!$result = mysqli_query(CDBConnection::getDB(), $fltr2_query)) {throw new Exception(mysqli_error(CDBConnection::getDB()));}
	while($row = mysqli_fetch_row($result)) {$data['fltr2_array'][] = new CAufgabe($row[0]);}
	if($data['fltr2']) {$query_where[] = 'az.aufgabe_id='.$data['fltr2'];}

	foreach($query_where as $i => $clause) {$query .= (($i)?(' AND '):(' WHERE ')).$clause;}

	//--------------------------------------------------------------------------------------------------------------------
	// Sortierung
	//--------------------------------------------------------------------------------------------------------------------
	switch($data['sort'])
	{
		case 1: $query .= ' ORDER BY af.bez_maennlich, a.nachname'; break;
		case 2: $query .= ' ORDER BY a.nachname, af.bez_maennlich'; break;
		default: $query .= ' ORDER BY af.sortierung DESC, a.nachname'; break;
	}

	//--------------------------------------------------------------------------------------------------------------------
	// Abfrage
	//--------------------------------------------------------------------------------------------------------------------
	$data['aufgabenzuordnungen_array'] = array();
	if(!$result = mysqli_query(CDBConnection::getDB(), $query)) {throw new Exception(mysqlil_error(CDBConnection::getDB()));}
	while($row = mysqli_fetch_row($result)) {$data['aufgabenzuordnungen_array'][] = new CAufgabenzuordnung($row[0]);}
}

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// RETURN
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

return new CTemplateData($data);
?>