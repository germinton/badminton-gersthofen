<?php
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Modus und Ansicht
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

$data['modus'] = CSiteManager::getMode();
$data['view'] = C2C_Modus($data['modus']);

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Das Objekt
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

$MyPHPMailer = new CMyPHPMailer();

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Detailansicht
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

if(VIEW_DETAIL == $data['view'])
{
	$data['empfaenger'] = '';

	$query = 'SELECT ';
	switch($_POST['format'])
	{
		case '1': $query .= 'CONCAT(IF(vorname IS NULL, \'\', CONCAT(vorname, \' \')), nachname, \' (\', email, \')\')'; break;
		case '2': $query .= 'CONCAT(IF(vorname IS NULL, \'\', CONCAT(vorname, \' \')), nachname, \' <\', email, \'>\')'; break;
		default: $query .= 'email'; break;
	}
	$query .= ' FROM _v3_mitglieder_daten';

	$query_where = array();

	//--------------------------------------------------------------------------------------------------------------------
	// Anzeigestatus
	//--------------------------------------------------------------------------------------------------------------------
	$query_where[] = 'ausblenden=0';

	//--------------------------------------------------------------------------------------------------------------------
	// E-Mail-Feld
	//--------------------------------------------------------------------------------------------------------------------
	$query_where[] = 'NOT email IS NULL';

	//--------------------------------------------------------------------------------------------------------------------
	// Newsletter-Flag
	//--------------------------------------------------------------------------------------------------------------------
	switch($_POST['nflag'])
	{
		case '1': break;
		case '2': $query_where[] = 'newsletter=0'; break;
		default: $query_where[] = 'newsletter=1'; break;
	}

	//--------------------------------------------------------------------------------------------------------------------
	// Anrede
	//--------------------------------------------------------------------------------------------------------------------
	$query_where_or = array();
	foreach($GLOBALS['Enum']['Anrede'] as $Anrede) {
		if(isset($_POST['geschlecht:'.$Anrede])) {$query_where_or[] = 'anrede=\''.C2S_Anrede($Anrede).'\'';}
	}
	foreach($query_where_or as $i => $clause) {
		if($i == 0) {$tmp = '(';}
		$tmp .= (($i)?(' OR '):('')).$clause;
		if($i == (count($query_where_or)-1)) {$query_where[] = $tmp.')';}
	}

	//--------------------------------------------------------------------------------------------------------------------
	// AKlaGruppe
	//--------------------------------------------------------------------------------------------------------------------
	$query_where_or = array();
	foreach($GLOBALS['Enum']['AKlaGruppe'] as $AKlaGruppe) {
		if(isset($_POST['aklagruppe:'.$AKlaGruppe])) {$query_where_or[] = 'aklagruppe=\''.C2S_AKlaGruppe($AKlaGruppe).'\'';}
	}
	foreach($query_where_or as $i => $clause) {
		if($i == 0) {$tmp = '(';}
		$tmp .= (($i)?(' OR '):('')).$clause;
		if($i == (count($query_where_or)-1)) {$query_where[] = $tmp.')';}
	}

	//--------------------------------------------------------------------------------------------------------------------
	// Verteilerliste
	//--------------------------------------------------------------------------------------------------------------------
	$ArrayNr = 1;

	$AthletIDArray[$ArrayNr][] = 67; //manni
	$AthletIDArray[$ArrayNr][] = 65; //jonny
	$AthletIDArray[$ArrayNr][] = 37; // sandro
	$AthletIDArray[$ArrayNr][] = 1457; // stefan b.
	$AthletIDArray[$ArrayNr][] = 1; //michi
	$AthletIDArray[$ArrayNr][] = 52; //nicki
	$AthletIDArray[$ArrayNr][] = 23; //jule

	$ArrayNr = 2;
	$AthletIDArray[$ArrayNr][] = 292; // andy
	$AthletIDArray[$ArrayNr][] = 11; // christof
	$AthletIDArray[$ArrayNr][] = 45; // robert
	$AthletIDArray[$ArrayNr][] = 53; // uli
	$AthletIDArray[$ArrayNr][] = 14; // tommi
	$AthletIDArray[$ArrayNr][] = 5; // mai-linh
	$AthletIDArray[$ArrayNr][] = 8; // romy

	$ArrayNr = 3;
	$AthletIDArray[$ArrayNr][] = 50; // marius
	$AthletIDArray[$ArrayNr][] = 19; // daniel
	$AthletIDArray[$ArrayNr][] = 60; // christian
	$AthletIDArray[$ArrayNr][] = 55; // klaus
	$AthletIDArray[$ArrayNr][] = 27; // julia k.
	$AthletIDArray[$ArrayNr][] = 1342; // claudia

	$query_where_or = array();
	for($i = 1; $i <= 3; $i++) {
		if(isset($_POST['verteilerliste:'.$i])) {
			foreach($AthletIDArray[$i] as $AthletID) {$query_where_or[] = 'athlet_id='.$AthletID;}
		}
	}
	foreach($query_where_or as $i => $clause) {
		if($i == 0) {$tmp = '(';}
		$tmp .= (($i)?(' OR '):('')).$clause;
		if($i == (count($query_where_or)-1)) {$query_where[] = $tmp.')';}
	}


	foreach($query_where as $i => $clause) {$query .= (($i)?(' AND '):(' WHERE ')).$clause;}

	$query .= ' ORDER BY nachname, vorname';

	if(!$result = mysql_query($query)) {throw new Exception(mysql_error(CDBConnection::getDB()));}

	$i = 0;

	$delim = '';
	switch($_POST['delim'])
	{
		case '1': $delim = '; '; break;
		case '2': $delim = PHP_EOL; break;
		default: $delim = ', '; break;
	}

	while($row = mysql_fetch_row($result)) {$data['empfaenger'] .= (($i++)?($delim):('')).$row[0];}
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

/*
 $mail = new CMyPHPMailer();

 $to = "ulrich@schmid-post.de";
 $mail->AddAddress($to);

 $mail->Subject  = "First PHPMailer Message";

 $mail->AltBody    = "To view the message, please use an HTML compatible email viewer!"; // optional, comment out and test
 $mail->WordWrap   = 80; // set word wrap

 $mail->Body = "Hello World!";
 $mail->AddAttachment('bilder/netzboy.gif');      // attachment

 //$mail->Send();
 //$xhtml .= "PHPMailer: Die E-Mail wurde versendet.";


 ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
 // RETURN
 ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

 $data['xhtml'] = $xhtml;
 return new CTemplateData($data, true);
 */
?>