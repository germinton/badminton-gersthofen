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

$Mitglied = new CMitglied();

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Modus: speichern!
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

if(MODE_SAVE == $data['modus'])
{
	if($_POST['athlet_id']) {$Mitglied->load($_POST['athlet_id']);}

	$Mitglied->setAnrede($_POST['anrede']);
	$Mitglied->setNachname($_POST['nachname']);
	$Mitglied->setVorname($_POST['vorname']);
	$Mitglied->setGeburtstag(S2S_Datum_Deu2MySql(trim($_POST['geburtstag'])));
	$Mitglied->setStrasse($_POST['strasse']);
	$Mitglied->setPLZ($_POST['plz']);
	$Mitglied->setOrt($_POST['ort']);
	$Mitglied->setBeruf($_POST['beruf']);
	$Mitglied->setTelPriv($_POST['tel_priv']);
	$Mitglied->setTelPriv2($_POST['tel_priv2']);
	$Mitglied->setTelGesch($_POST['tel_gesch']);
	$Mitglied->setFax($_POST['fax']);
	$Mitglied->setTelMobil($_POST['tel_mobil']);
	$Mitglied->setEMail($_POST['email']);
	$Mitglied->setNewsletter(isset($_POST['newsletter']));
	$Mitglied->setWebsite($_POST['website']);
	$Mitglied->setSpitzname($_POST['spitzname']);
	$Mitglied->setUeberSich($_POST['ueber_sich']);
	$Mitglied->setAusblenden(isset($_POST['ausblenden']));
	$Mitglied->setBenutzername($_POST['benutzername']);
	$Mitglied->setFreigabeWSite(isset($_POST['freigabe_wsite']));
	$Mitglied->setFreigabeFBook(isset($_POST['freigabe_fbook']));
	$Mitglied->setErzBerVorname($_POST['erzber_vorname']);
	$Mitglied->setErzBerNachname($_POST['erzber_nachname']);
	$Mitglied->setErzBerTelMobil($_POST['erzber_tel_mobil']);
	$Mitglied->setErzBerEMail($_POST['erzber_email']);

	// Passwort
	$s = trim($_POST['passwort']);
	if(!$_POST['athlet_id'] or strlen($s))
	{
		if(!(strlen($s) >= 6 and strlen($s) <= 20)) {
			$Mitglied->addCheckMsg('Das Passwort muss zwischen 6 und 20 Zeichen lang sein.');
			$Mitglied->setPasswort(md5('dummy')); // Dummy-Passwort um Fehlermeldung 'Ein Passwort ist erforderlich' zu unterd.
		}
		else {
			$Mitglied->setPasswort(md5(trim($_POST['passwort'])));
		}
	}

	CUploadHandler::setProcessCmd(ATTACH_PIC, $_POST['pic']);

	$Mitglied->save();
}

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Modus: löschen!
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

if(MODE_DROP == $data['modus'])
{
	$Mitglied->load((int)$_POST['drop']);
	$Mitglied->delete();
}

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Detailansicht
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

if(VIEW_DETAIL == $data['view'])
{
	if(MODE_EDIT == $data['modus']) {$Mitglied->load((int)$_POST['edit']);}
	$data['mitglied'] = $Mitglied;
}

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Filterung/Sortierung
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

$data['fltr1'] = ((isset($_GET['fltr1']))?(1):(0));
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
	$query = 'SELECT a.athlet_id '.
	         'FROM ((athleten a INNER JOIN _v2_mitglieder_aklagruppe makl ON a.athlet_id=makl.athlet_id) '.
	         'INNER JOIN athleten_mitglieder am ON a.athlet_id=am.athlet_id) '.
	         'INNER JOIN _v0_mitglieder_alter malt ON a.athlet_id=malt.athlet_id ';

	//--------------------------------------------------------------------------------------------------------------------
	// Filterung
	//--------------------------------------------------------------------------------------------------------------------
	$query_where = array();

	if(!$data['fltr1']) {$query_where[] = 'am.ausblenden=0';}
	if($data['fltr2']) {$query_where[] = 'makl.aklagruppe'.((4==$data['fltr2'])?(' IS NULL'):('='.$data['fltr2']));}

	foreach($query_where as $i => $clause) {$query .= (($i)?(' AND '):(' WHERE ')).$clause;}

	//--------------------------------------------------------------------------------------------------------------------
	// Sortierung
	//--------------------------------------------------------------------------------------------------------------------
	switch($data['sort'])
	{
		case 1: $query .= ' ORDER BY malt.alter, a.nachname, a.vorname'; break;
		default: $query .= ' ORDER BY a.nachname, a.vorname'; break;
	}

	//--------------------------------------------------------------------------------------------------------------------
	// Abfrage
	//--------------------------------------------------------------------------------------------------------------------
	$data['stichtag'] = S2S_Datum_MySql2Deu(CDBConnection::getInstance()->getStichtag());

	$data['mitglied_array_'.S_HERR] = array();
	$data['mitglied_array_'.S_DAME] = array();
	if(!$result = mysqli_query(CDBConnection::getDB(), $query)) {throw new Exception(mysqlil_error(CDBConnection::getDB()));}
	while($row = mysqli_fetch_row($result)) {
		$TmpMitglied = new CMitglied($row[0]);
		$data['mitglied_array_'.$TmpMitglied->getAnrede()][] = $TmpMitglied;
	}
}

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// RETURN
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

return new CTemplateData($data);
?>