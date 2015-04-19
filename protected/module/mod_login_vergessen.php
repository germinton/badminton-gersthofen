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

	$Msg = 'Die (Kombination aus) E-Mail-Adresse (und Vorname) ist unbekannt oder uneindeutig. '.
	       'Wenn Du Dir sicher bist, dass Deine Angaben keine Schreibfehler enthalten, wende Dich bitte an den '.
	       '<a href="index.php?section=kontakt#webmaster">Webmaster</a>.';

	$EMail = trim($_POST['email']);

	if(!strlen($EMail)) {
		throw new CShowCheckMsg(array('Keine E-Mail Adresse angegeben.'));
	}
	else if(!preg_match(REGEX_EMAIL, $EMail)) {
		throw new CShowCheckMsg(array('Die E-Mail-Adresse ist von ungültiger Form.'));
	}

	$AthletIDArray = array();
	$query = 'SELECT athlet_id FROM athleten_mitglieder WHERE STRCMP(LOWER(TRIM(email)), \''.strtolower($EMail).'\')=0';
	if(!$result = mysql_query($query)) {throw new Exception(mysql_error(CDBConnection::getDB()));}
	while($row = mysql_fetch_row($result)) {$AthletIDArray[] = (int)$row[0];}

	if(!count($AthletIDArray)) {
		throw new CShowCheckMsg(array($Msg));
	}
	else if(count($AthletIDArray) > 1)
	{
		$Vorname = trim($_POST['vorname']);

		if(!strlen($Vorname)) {throw new CShowCheckMsg(array($Msg));}

		$query = 'SELECT a.athlet_id FROM athleten_mitglieder am INNER JOIN athleten a ON am.athlet_id=a.athlet_id '.
		         'WHERE STRCMP(LOWER(TRIM(email)), \''.strtolower($EMail).'\')=0 '.
		           'AND STRCMP(LOWER(TRIM(vorname)), \''.strtolower($Vorname).'\')=0';
		if(!$result = mysql_query($query)) {throw new Exception(mysql_error(CDBConnection::getDB()));}

		if(!$row = mysql_fetch_row($result)) {
			throw new CShowCheckMsg(array($Msg));
		}
		$Mitglied->load($row[0]);
	}
	else {
		$Mitglied->load(reset($AthletIDArray));
	}

	$NeuesPasswort = '';

	mt_srand(crc32(microtime()));

	//Welche Buchstaben benutzt werden sollen (Charset)
	$Buchstaben = 'abcdefghijkmnpqrstuvwxyz123456789';

	$str_lng = strlen($Buchstaben)-1;

	for($i=0; $i<10; $i++) {
		$NeuesPasswort .= $Buchstaben{mt_rand(0, $str_lng)};
	}

	$Mitglied->setPasswort(md5($NeuesPasswort));
	$Mitglied->setPwAendern(true); // muss nach 'setPasswort()' aufgerufen werden!
	$Mitglied->save();

	$mail = new CMyPHPMailer();

	$mail->AddAddress($Mitglied->getEMail());

	$mail->Subject  = 'Login-Daten für www.badminton-gersthofen.de';

	$mail->WordWrap   = 80; // set word wrap

	$mail->Body = 'Hallo '.$Mitglied->getVorname().','."\n";
	$mail->Body .= "\n";
	$mail->Body .= 'Du hast Deine Login-Daten für www.badminton-gersthofen.de angefordert.'."\n";
	$mail->Body .= "\n";
	$mail->Body .= 'Dein Benutzername lautet:        '.$Mitglied->getBenutzername()."\n";
	$mail->Body .= 'Dein neues Passwort lautet:      '.$NeuesPasswort."\n";
	$mail->Body .= "\n";
	$mail->Body .= 'Das Passwort solltest Du so bald wie möglich in ein leichter zu merkendes Passwort ändern.'."\n";
	$mail->Body .= "\n";
	$mail->Body .= 'Viele Grüße'."\n";
	$mail->Body .= "\n";
	$mail->Body .= 'Website des TSV Gersthofen Badminton'."\n";
	$mail->Body .= 'www.badminton-gersthofen.de';

	$mail->Send();

	throw new CShowInfo('Eine E-Mail mit Deinem Benutzernamen und einem neuen Passwort wurde soeben an die Adresse '.
	                    '\''.$Mitglied->getEMail().'\' verschickt!', 'index.php?section=startseite');

}
else if (MODE_CANCEL == $data['modus'])
{
	throw new CShowInfo('Aktion abgebrochen!', 'index.php');
}

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// RETURN
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

return new CTemplateData($data);
?>