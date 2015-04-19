<?php
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Modus und Ansicht
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

$data['modus'] = CSiteManager::getMode();
$data['view'] = C2C_Modus($data['modus']);

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Das Objekt
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

$Aufgabe = new CAufgabe();

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Modus: speichern!
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

if(MODE_SAVE == $data['modus'])
{
	if($_POST['aufgabe_id']) {$Aufgabe->load($_POST['aufgabe_id']);}

	$Aufgabe->setBezMaennlich($_POST['bez_maennlich']);
	$Aufgabe->setBezWeiblich($_POST['bez_weiblich']);
	$Aufgabe->setAufgabentyp($_POST['aufgabentyp']);
	$Aufgabe->setSortierung($_POST['sortierung']);
	$Aufgabe->setFreitext($_POST['freitext']);

	$Aufgabe->save();
}

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Modus: löschen!
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

if(MODE_DROP == $data['modus'])
{
	$Aufgabe->load((int)$_POST['drop']);
	$Aufgabe->delete();
}

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Detailansicht
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

if(VIEW_DETAIL == $data['view'])
{
	if(MODE_EDIT == $data['modus']) {$Aufgabe->load((int)$_POST['edit']);}
	$data['aufgabe'] = $Aufgabe;
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
	$query = 'SELECT aufgabe_id FROM aufgaben';

	//--------------------------------------------------------------------------------------------------------------------
	// Filterung
	//--------------------------------------------------------------------------------------------------------------------
	$query_where = array();

	if($data['fltr1']) {$query_where[] = 'aufgabentyp'.((0==$data['fltr1'])?(' IS NULL'):('='.$data['fltr1']));}

	foreach($query_where as $i => $clause) {$query .= (($i)?(' AND '):(' WHERE ')).$clause;}

	//--------------------------------------------------------------------------------------------------------------------
	// Sortierung
	//--------------------------------------------------------------------------------------------------------------------
	switch($data['sort'])
	{
		case 1: $query .= ' ORDER BY sortierung DESC, aufgabentyp, bez_maennlich'; break;
		case 2: $query .= ' ORDER BY bez_maennlich, sortierung DESC, aufgabentyp'; break;
		default: $query .= ' ORDER BY aufgabentyp, sortierung DESC, bez_maennlich'; break;
	}

	//--------------------------------------------------------------------------------------------------------------------
	// Abfrage
	//--------------------------------------------------------------------------------------------------------------------
	$data['aufgaben_array'] = array();
	if(!$result = mysql_query($query)) {throw new Exception(mysql_error(CDBConnection::getDB()));}
	while($row = mysql_fetch_row($result)) {$data['aufgaben_array'][] = new CAufgabe($row[0]);}
}

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// RETURN
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

return new CTemplateData($data);
?>