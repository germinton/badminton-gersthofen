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
	$Mitglied->setBenutzername($_POST['benutzername']);

	// Passwort alt
	if(md5(trim($_POST['passwort_alt'])) != $Mitglied->getPasswort()) {
		$Mitglied->addCheckMsg('Das alte Passwort ist falsch.');
	}
	// Passwort neu
	if(strlen(trim($_POST['passwort_neu1'])))
	{
		if(!(strlen(trim($_POST['passwort_neu1'])) >= 6 and strlen(trim($_POST['passwort_neu1'])) <= 20)) {
			$Mitglied->addCheckMsg('Ein Passwort zwischen 6 und 20 Zeichen ist erforderlich.');
		}
		else if(trim($_POST['passwort_neu1']) != trim($_POST['passwort_neu2'])) {
			$Mitglied->addCheckMsg('Das neue Passwort stimmt nicht mit dem wiederholten Passwort überein.');
		}
		else {
			$Mitglied->setPasswort(md5(trim($_POST['passwort_neu1'])));
		}
	}

	$Mitglied->save();

	// Cookie aktualisieren
	setcookie('Benutzername', $Mitglied->getBenutzername(), strtotime("+1 month"));
	setcookie('Passwort', $Mitglied->getPasswort(), strtotime("+1 month"));
	$_COOKIE['Benutzername'] = $Mitglied->getBenutzername(); // fake-cookie setzen
	$_COOKIE['Passwort'] = $Mitglied->getPasswort(); // fake-cookie setzen

	throw new CShowInfo('Deine Login-Daten wurden geändert!', 'index.php?section=profil');
}
else if (MODE_CANCEL == $data['modus'])
{
	throw new CShowInfo('Aktion abgebrochen!', 'index.php?section=profil');
}

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// RETURN
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

return new CTemplateData($data);
?>