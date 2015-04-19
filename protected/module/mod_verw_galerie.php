<?php
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Modus und Ansicht
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

$data['modus'] = CSiteManager::getMode();
$data['view'] = C2C_Modus($data['modus']);

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Das Objekt
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

$Galerieeintrag = new CGalerieeintrag();

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Modus: speichern!
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

if(MODE_SAVE == $data['modus'])
{
	if($_POST['galerieeintrag_id']) {$Galerieeintrag->load($_POST['galerieeintrag_id']);}

	$Galerieeintrag->setDatum(S2S_Datum_Deu2MySql(trim($_POST['datum'])));
	$Galerieeintrag->setFreitext($_POST['freitext']);
	$Galerieeintrag->setTitel($_POST['titel']);
	$Galerieeintrag->setPicasaAlbumID($_POST['picasa_albumid']);
	$Galerieeintrag->setPicasaAuthkey($_POST['picasa_authkey']);

	CUploadHandler::setProcessCmd(ATTACH_FILE1, $_POST['file1']);
	CUploadHandler::setProcessCmd(ATTACH_FILE2, $_POST['file2']);
	CUploadHandler::setProcessCmd(ATTACH_FILE3, $_POST['file3']);

	$Galerieeintrag->save();
}

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Modus: löschen!
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

if(MODE_DROP == $data['modus'])
{
	$Galerieeintrag->load($_POST['drop']);
	$Galerieeintrag->delete();
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
		$Galerieeintrag->load($_POST['edit']);
		//$AthletIDArray = array_unique(array_merge($AthletIDArray, array($Galerieeintrag->getAthletID())));
		//$data['athlet_id'] = $Galerieeintrag->getAthletID();
	}
	if(MODE_NEW == $data['modus'])
	{
		//$data['athlet_id'] = $Mitglied->getAthletID();
	}
	if($Mitglied->hatAufgabe(S_DBENTWICKLER)) {
		//$AthletIDArray = array_unique(array_merge($AthletIDArray, array($Mitglied->getAthletID())));
	}
	$data['heute'] = date('Y-m-d');
	$data['mitglied_array'] = array();
	foreach($AthletIDArray as $AthletID) {$data['mitglied_array'][] = new CMitglied((int)$AthletID);}
	$data['galerieeintrag'] = $Galerieeintrag;
}


////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Übersicht
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

if(VIEW_LIST == $data['view'])
{
	//--------------------------------------------------------------------------------------------------------------------
	// Auswahl
	//--------------------------------------------------------------------------------------------------------------------
	$query = 'SELECT galerieeintrag_id '.
	         'FROM galerieeintraege '.
			 'ORDER BY datum DESC';


	//--------------------------------------------------------------------------------------------------------------------
	// Abfrage
	//--------------------------------------------------------------------------------------------------------------------
	$data['galerie_array'] = array();
	if(!$result = mysql_query($query)) {throw new Exception(mysql_error(CDBConnection::getDB()));}
	while($row = mysql_fetch_row($result)) {$data['galerie_array'][] = new CGalerieeintrag($row[0]);}
}

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// RETURN
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

return new CTemplateData($data);
?>