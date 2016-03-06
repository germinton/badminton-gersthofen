<?php
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Modus und Ansicht
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

$data['modus'] = CSiteManager::getMode();
$data['view'] = C2C_Modus($data['modus']);

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Das Objekt
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

$Mitglied = new CMitglied();

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Detailansicht
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

$data['feldnamen_array'][] = 'athlet_id';
$data['feldnamen_array'][] = 'anrede';
$data['feldnamen_array'][] = 'nachname';
$data['feldnamen_array'][] = 'vorname';
$data['feldnamen_array'][] = 'spitzname';
$data['feldnamen_array'][] = 'beruf';
$data['feldnamen_array'][] = 'geburtstag';
$data['feldnamen_array'][] = 'strasse';
$data['feldnamen_array'][] = 'plz';
$data['feldnamen_array'][] = 'ort';
$data['feldnamen_array'][] = 'tel_priv';
$data['feldnamen_array'][] = 'tel_priv2';
$data['feldnamen_array'][] = 'tel_gesch';
$data['feldnamen_array'][] = 'fax';
$data['feldnamen_array'][] = 'tel_mobil';
$data['feldnamen_array'][] = 'email';
$data['feldnamen_array'][] = 'newsletter';
$data['feldnamen_array'][] = 'aklasse';
$data['feldnamen_array'][] = 'aklagruppe';
$data['feldnamen_array'][] = 'lastlogin';
$data['feldnamen_array'][] = 'lastupdate';
$data['feldnamen_array'][] = 'ausblenden';
$data['feldnamen_array'][] = 'freigabe_wsite';
$data['feldnamen_array'][] = 'freigabe_fbook';
$data['feldnamen_array'][] = 'erzber_vorname';
$data['feldnamen_array'][] = 'erzber_nachname';
$data['feldnamen_array'][] = 'erzber_tel_mobil';
$data['feldnamen_array'][] = 'erzber_email';

if(VIEW_DETAIL == $data['view'])
{
	$data['export'] = '';

	$query = 'SELECT ';
	$Flag = false;
	foreach($data['feldnamen_array'] as $Feldname) {
		if(isset($_POST[$Feldname])) {$query .= (($Flag)?(', '):('')).$Feldname; $Flag = true;}
	}
	if(!$Flag) {throw new Exception('Mindestens ein Feldname muss ausgewählt werden!');}
	$query .= ' FROM _v3_mitglieder_daten ORDER BY nachname, vorname';

	if(!$result = mysqli_query(CDBConnection::getDB(), $query)) {throw new Exception(mysqlil_error(CDBConnection::getDB()));}

	for($i=0; $i<mysql_num_fields($result); $i++) {$data['export'] .= mysql_field_name($result, $i).',';}
	$data['export'] = substr($data['export'], 0, strlen($data['export'])-1)."\n";

	while($row = mysqli_fetch_row($result)) {
		foreach($row as $cell) {$data['export'] .= $cell.',';}
		$data['export'] = substr($data['export'], 0, strlen($data['export'])-1)."\n";
	}
}

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Übersicht
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

if(VIEW_LIST == $data['view'])
{

}

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// RETURN
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

return new CTemplateData($data);
?>