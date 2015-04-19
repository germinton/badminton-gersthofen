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

$Mitglied = CSiteManager::getInstance()->getMitglied();

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Modus: speichern!
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

if(MODE_SAVE == $data['modus'])
{
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
	$Mitglied->setErzBerVorname($_POST['erzber_vorname']);
	$Mitglied->setErzBerNachname($_POST['erzber_nachname']);
	$Mitglied->setErzBerTelMobil($_POST['erzber_tel_mobil']);
	$Mitglied->setErzBerEMail($_POST['erzber_email']);

	CUploadHandler::setProcessCmd(ATTACH_PIC, $_POST['pic']);

	$Mitglied->save();

	throw new CShowInfo('Deine Persönlichen Daten wurden geändert!', 'index.php?section=profil');
}
else if(MODE_CANCEL == $data['modus'])
{
	throw new CShowInfo('Änderungen wurden verworfen!', 'index.php?section=profil');
}

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// RETURN
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

return new CTemplateData($data);
?>