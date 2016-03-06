<?php
$xhtml = '';
$StrOK = '<span style="color:green">OK</span>';
$StrERR = '<span style="color:red">ERROR</span>';

function CheckIDs($TabnameRgt, $TabnameLftArray)
{
	$IDName = S2S_TabName_IDName($TabnameRgt);
	$StrOK = '<span style="color:green">OK</span>';
	$StrERR = '<span style="color:red">ERROR</span>';
	$xhtml = '';
	foreach($TabnameLftArray as $TabnameLft)
	{
		$xhtml .= $TabnameLft[0].' mit ausschließlich gültigen '.$IDName.'s ... ';
		$query = 'SELECT * FROM '.$TabnameLft[1].' lft LEFT JOIN '.$TabnameRgt.' rgt ON lft.'.$IDName.'=rgt.'.$IDName.' '.
		         'WHERE lft.'.$IDName.' IS NOT NULL AND rgt.'.$IDName.' IS NULL;';
		if(!$result = mysqli_query(CDBConnection::getDB(), $query)) {throw new Exception(mysqlil_error(CDBConnection::getDB()));}
		$row = mysqli_fetch_row($result);
		$xhtml .= (($row[0])?($StrERR):($StrOK)).'<br />'."\n";
	}
	return $xhtml;
}

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
$xhtml .= '<h2>Athleten</h2>'."\n";
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

$xhtml .= 'Nicht zugeordnete Athleten ... ';

$query = 'SELECT * FROM (athleten a LEFT JOIN athleten_mitglieder am ON a.athlet_id=am.athlet_id) '.
         'LEFT JOIN athleten_gegner ag ON a.athlet_id=ag.athlet_id '.
         'WHERE (am.athlet_id IS NULL) AND (ag.athlet_id IS NULL)';

if(!$result = mysqli_query(CDBConnection::getDB(), $query)) {throw new Exception(mysqlil_error(CDBConnection::getDB()));}
$row = mysqli_fetch_row($result);
$xhtml .= (($row[0])?($StrERR):($StrOK)).'<br />'."\n";

$xhtml .= 'Uneindeutige Athleten ... ';

$query = 'SELECT * FROM athleten_mitglieder am, athleten_gegner ag WHERE am.athlet_id=ag.athlet_id';
if(!$result = mysqli_query(CDBConnection::getDB(), $query)) {throw new Exception(mysqlil_error(CDBConnection::getDB()));}
$row = mysqli_fetch_row($result);
$xhtml .= (($row[0])?($StrERR):($StrOK)).'<br />'."\n";

$xhtml .= 'Mitglieder ohne Masterdatensatz ... ';

$query = 'SELECT * FROM athleten_mitglieder am '.
         'LEFT JOIN athleten a ON am.athlet_id=a.athlet_id WHERE a.athlet_id IS NULL';
if(!$result = mysqli_query(CDBConnection::getDB(), $query)) {throw new Exception(mysqlil_error(CDBConnection::getDB()));}
$row = mysqli_fetch_row($result);
$xhtml .= (($row[0])?($StrERR):($StrOK)).'<br />'."\n";

$xhtml .= 'Gegner ohne Masterdatensatz ... ';

$query = 'SELECT * FROM athleten_gegner ag '.
         'LEFT JOIN athleten a ON ag.athlet_id=a.athlet_id WHERE a.athlet_id IS NULL';
if(!$result = mysqli_query(CDBConnection::getDB(), $query)) {throw new Exception(mysqlil_error(CDBConnection::getDB()));}
$row = mysqli_fetch_row($result);
$xhtml .= (($row[0])?($StrERR):($StrOK)).'<br />'."\n";

$TabnameLftArray = array();
$TabnameLftArray[] = array('Aufgabenzuordnungen', 'aufgabenzuordnungen');
$TabnameLftArray[] = array('Aufstellungen', 'aufstellungen');
$TabnameLftArray[] = array('Ersatzspieler', 'ersatzspieler');
$TabnameLftArray[] = array('Kontrahenten', 'kontrahenten');
$TabnameLftArray[] = array('Mannschaftsspieler', 'mannschaftsspieler');
$TabnameLftArray[] = array('Neuigkeiten', 'neuigkeiten');
$TabnameLftArray[] = array('Tabellen', 'tabellen');
$TabnameLftArray[] = array('Allgemeine Termine', 'termine_allgemein');
$TabnameLftArray[] = array('Turnierathleten', 'turnierathleten');

$xhtml .= CheckIDs('athleten', $TabnameLftArray);

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
$xhtml .= '<h2>Aufgaben</h2>'."\n";
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

$TabnameLftArray = array();
$TabnameLftArray[] = array('Aufgabenzuordnungen', 'aufgabenzuordnungen');

$xhtml .= CheckIDs('aufgaben', $TabnameLftArray);

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
$xhtml .= '<h2>Aufstellungen</h2>'."\n";
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

$TabnameLftArray = array();
$TabnameLftArray[] = array('Mannschaftsspieler', 'mannschaftsspieler');

$xhtml .= CheckIDs('aufstellungen', $TabnameLftArray);

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
$xhtml .= '<h2>Austragungsorte</h2>'."\n";
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

$TabnameLftArray = array();
$TabnameLftArray[] = array('Spielergebnismeldungen', 'sperml');
$TabnameLftArray[] = array('Punktspielbegegnungstermine', 'termine_pktspbeg');
$TabnameLftArray[] = array('Turniere', 'turniere');

$xhtml .= CheckIDs('austragungsorte', $TabnameLftArray);

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
$xhtml .= '<h2>LigenKlassen</h2>'."\n";
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

$TabnameLftArray = array();
$TabnameLftArray[] = array('Mannschaften', 'mannschaften');
$TabnameLftArray[] = array('Tabellen', 'tabellen');

$xhtml .= CheckIDs('ligenklassen', $TabnameLftArray);

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
$xhtml .= '<h2>Mannschaften</h2>'."\n";
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

$TabnameLftArray = array();
$TabnameLftArray[] = array('Aufstellungen', 'aufstellungen');
$TabnameLftArray[] = array('Externe Punktspielergebnismeldungen', 'sperml_punktspiel_extern');

$xhtml .= CheckIDs('mannschaften', $TabnameLftArray);

$xhtml .= 'Interne Punktspielergebnismeldungen mit ausschließlich gültigen heim_mannschaft_ids ... ';
$query = 'SELECT * FROM sperml_punktspiel_intern lft LEFT JOIN mannschaften rgt ON lft.heim_mannschaft_id=rgt.mannschaft_id '.
	         'WHERE lft.heim_mannschaft_id IS NOT NULL AND rgt.mannschaft_id IS NULL;';
if(!$result = mysqli_query(CDBConnection::getDB(), $query)) {throw new Exception(mysqlil_error(CDBConnection::getDB()));}
$row = mysqli_fetch_row($result);
$xhtml .= (($row[0])?($StrERR):($StrOK)).'<br />'."\n";

$xhtml .= 'Interne Punktspielergebnismeldungen mit ausschließlich gültigen gast_mannschaft_ids ... ';
$query = 'SELECT * FROM sperml_punktspiel_intern lft LEFT JOIN mannschaften rgt ON lft.gast_mannschaft_id=rgt.mannschaft_id '.
	       'WHERE lft.gast_mannschaft_id IS NOT NULL AND rgt.mannschaft_id IS NULL;';
if(!$result = mysqli_query(CDBConnection::getDB(), $query)) {throw new Exception(mysqlil_error(CDBConnection::getDB()));}
$row = mysqli_fetch_row($result);
$xhtml .= (($row[0])?($StrERR):($StrOK)).'<br />'."\n";

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
$xhtml .= '<h2>Sätze</h2>'."\n";
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

$xhtml .= 'Kein Satz ohne Gewinner ... ';

$query = 'SELECT * FROM saetze WHERE heimp=gastp';
if(!$result = mysqli_query(CDBConnection::getDB(), $query)) {throw new Exception(mysqlil_error(CDBConnection::getDB()));}
$row = mysqli_fetch_row($result);
$xhtml .= (($row[0])?($StrERR):($StrOK)).'<br />'."\n";

$xhtml .= 'Kein Satz mit Heim- oder Gastpunkten über 30 ... ';

$query = 'SELECT * FROM saetze WHERE heimp>30 OR gastp>30';
if(!$result = mysqli_query(CDBConnection::getDB(), $query)) {throw new Exception(mysqlil_error(CDBConnection::getDB()));}
$row = mysqli_fetch_row($result);
$xhtml .= (($row[0])?($StrERR):($StrOK)).'<br />'."\n";

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
$xhtml .= '<h2>Saisons</h2>'."\n";
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

$TabnameLftArray = array();
$TabnameLftArray[] = array('Mannschaften', 'mannschaften');
$TabnameLftArray[] = array('Tabellen', 'tabellen');

$xhtml .= CheckIDs('saisons', $TabnameLftArray);

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
$xhtml .= '<h2>Spielergebnismeldungen</h2>'."\n";
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

$xhtml .= 'Nicht zugeordnete Spielergebnismeldungen ... ';

$query = 'SELECT * FROM ((sperml s LEFT JOIN sperml_freundschaft sf ON s.sperml_id=sf.sperml_id) '.
         'LEFT JOIN sperml_punktspiel_extern se ON s.sperml_id=se.sperml_id) '.
         'LEFT JOIN sperml_punktspiel_intern si ON s.sperml_id=si.sperml_id '.
         'WHERE (sf.sperml_id IS NULL) AND (se.sperml_id IS NULL) AND (si.sperml_id IS NULL)';
if(!$result = mysqli_query(CDBConnection::getDB(), $query)) {throw new Exception(mysqlil_error(CDBConnection::getDB()));}
$row = mysqli_fetch_row($result);
$xhtml .= (($row[0])?($StrERR):($StrOK)).'<br />'."\n";

$xhtml .= 'Uneindeutige Spielergebnismeldungen ... ';

$query = 'SELECT * FROM sperml_freundschaft sf, sperml_punktspiel_extern se, sperml_punktspiel_intern si '.
         'WHERE sf.sperml_id=se.sperml_id OR sf.sperml_id=si.sperml_id OR se.sperml_id=si.sperml_id';
if(!$result = mysqli_query(CDBConnection::getDB(), $query)) {throw new Exception(mysqlil_error(CDBConnection::getDB()));}
$row = mysqli_fetch_row($result);
$xhtml .= (($row[0])?($StrERR):($StrOK)).'<br />'."\n";

$xhtml .= 'Freundschaftsspielergebnismeldungen ohne Masterdatensatz ... ';

$query = 'SELECT * FROM sperml_freundschaft sf LEFT JOIN sperml s ON sf.sperml_id=s.sperml_id '.
         'WHERE s.sperml_id IS NULL';
if(!$result = mysqli_query(CDBConnection::getDB(), $query)) {throw new Exception(mysqlil_error(CDBConnection::getDB()));}
$row = mysqli_fetch_row($result);
$xhtml .= (($row[0])?($StrERR):($StrOK)).'<br />'."\n";

$xhtml .= 'Externe Punktspielergebnismeldungen ohne Masterdatensatz ... ';

$query = 'SELECT * FROM sperml_punktspiel_extern se LEFT JOIN sperml s ON se.sperml_id=s.sperml_id '.
         'WHERE s.sperml_id IS NULL';
if(!$result = mysqli_query(CDBConnection::getDB(), $query)) {throw new Exception(mysqlil_error(CDBConnection::getDB()));}
$row = mysqli_fetch_row($result);
$xhtml .= (($row[0])?($StrERR):($StrOK)).'<br />'."\n";

$xhtml .= 'Interne Punktspielergebnismeldungen ohne Masterdatensatz ... ';

$query = 'SELECT * FROM sperml_punktspiel_intern si LEFT JOIN sperml s ON si.sperml_id=s.sperml_id '.
         'WHERE s.sperml_id IS NULL';
if(!$result = mysqli_query(CDBConnection::getDB(), $query)) {throw new Exception(mysqlil_error(CDBConnection::getDB()));}
$row = mysqli_fetch_row($result);
$xhtml .= (($row[0])?($StrERR):($StrOK)).'<br />'."\n";

$xhtml .= 'Niemals mehr als 8 Spielergebnismeldungsspiele pro Spielergebnismeldung ... ';

$query = 'SELECT count(*) FROM spiele_sperml GROUP BY sperml_id HAVING count(*) > 8';
if(!$result = mysqli_query(CDBConnection::getDB(), $query)) {throw new Exception(mysqlil_error(CDBConnection::getDB()));}
$row = mysqli_fetch_row($result);
$xhtml .= (($row[0])?($StrERR):($StrOK)).'<br />'."\n";

$TabnameLftArray = array();
$TabnameLftArray[] = array('Ersatzspieler', 'ersatzspieler');
$TabnameLftArray[] = array('Spielergebnismeldungsspiele', 'spiele_sperml');

$xhtml .= CheckIDs('sperml', $TabnameLftArray);

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
$xhtml .= '<h2>Spiele</h2>'."\n";
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

$TabnameLftArray = array();
$TabnameLftArray[] = array('Sätze', 'saetze');
$TabnameLftArray[] = array('Kontrahenten', 'kontrahenten');

$xhtml .= CheckIDs('spiele', $TabnameLftArray);

$xhtml .= 'Nicht zugeordnete Spiele ... ';

$query = 'SELECT * FROM (spiele s LEFT JOIN spiele_sperml ss ON s.spiel_id=ss.spiel_id) '.
         'LEFT JOIN spiele_training st ON s.spiel_id=st.spiel_id '.
         'WHERE (ss.spiel_id IS NULL) AND (st.spiel_id IS NULL)';
if(!$result = mysqli_query(CDBConnection::getDB(), $query)) {throw new Exception(mysqlil_error(CDBConnection::getDB()));}
$row = mysqli_fetch_row($result);
$xhtml .= (($row[0])?($StrERR):($StrOK)).'<br />'."\n";

$xhtml .= 'Uneindeutige Spiele ... ';

$query = 'SELECT * FROM spiele_sperml ss, spiele_training st WHERE ss.spiel_id=st.spiel_id';
if(!$result = mysqli_query(CDBConnection::getDB(), $query)) {throw new Exception(mysqlil_error(CDBConnection::getDB()));}
$row = mysqli_fetch_row($result);
$xhtml .= (($row[0])?($StrERR):($StrOK)).'<br />'."\n";

$xhtml .= 'Spielergebnismeldungsspiele ohne Masterdatensatz ... ';

$query = 'SELECT * FROM spiele_sperml ss LEFT JOIN spiele s ON ss.spiel_id=s.spiel_id WHERE s.spiel_id IS NULL';
if(!$result = mysqli_query(CDBConnection::getDB(), $query)) {throw new Exception(mysqlil_error(CDBConnection::getDB()));}
$row = mysqli_fetch_row($result);
$xhtml .= (($row[0])?($StrERR):($StrOK)).'<br />'."\n";

$xhtml .= 'Trainingsspiele ohne Masterdatensatz ... ';

$query = 'SELECT * FROM spiele_training st '.
         'LEFT JOIN spiele s ON st.spiel_id=s.spiel_id WHERE s.spiel_id IS NULL';
if(!$result = mysqli_query(CDBConnection::getDB(), $query)) {throw new Exception(mysqlil_error(CDBConnection::getDB()));}
$row = mysqli_fetch_row($result);
$xhtml .= (($row[0])?($StrERR):($StrOK)).'<br />'."\n";

$xhtml .= 'Kein Spiel mit nicht genau einem (Einzel mit nicht angetr. Gegner), '.
          'zwei (Einzel oder Doppel mit nicht angetr. Gegner) oder vier (Doppel) Kontrahenten ... ';
$query = 'SELECT count(*) FROM kontrahenten GROUP BY spiel_id HAVING count(*)<>1 AND count(*)<>2 AND count(*)<>4';
if(!$result = mysqli_query(CDBConnection::getDB(), $query)) {throw new Exception(mysqlil_error(CDBConnection::getDB()));}
$row = mysqli_fetch_row($result);
$xhtml .= (($row[0])?($StrERR):($StrOK)).'<br />'."\n";

$xhtml .= 'Kein Spiel ohne Kontrahenten ... ';

$query = 'SELECT * FROM spiele s LEFT JOIN kontrahenten k on s.spiel_id=k.spiel_id WHERE k.spiel_id IS NULL';
if(!$result = mysqli_query(CDBConnection::getDB(), $query)) {throw new Exception(mysqlil_error(CDBConnection::getDB()));}
$row = mysqli_fetch_row($result);
$xhtml .= (($row[0])?($StrERR):($StrOK)).'<br />'."\n";

$xhtml .= 'Kein Spiel mit identischen Satznummern ... ';

$query = 'SELECT * FROM saetze s1 INNER JOIN saetze s2 ON s1.spiel_id=s2.spiel_id '.
         'WHERE s1.nr=s2.nr AND NOT s1.satz_id=s2.satz_id';
if(!$result = mysqli_query(CDBConnection::getDB(), $query)) {throw new Exception(mysqlil_error(CDBConnection::getDB()));}
$row = mysqli_fetch_row($result);
$xhtml .= (($row[0])?($StrERR):($StrOK)).'<br />'."\n";

$xhtml .= 'Kein Spiel mit fehlenden Satznummern ... ';

$query = 'SELECT count(*)-max(nr) as diff FROM saetze GROUP BY spiel_id HAVING NOT diff=0';
if(!$result = mysqli_query(CDBConnection::getDB(), $query)) {throw new Exception(mysqlil_error(CDBConnection::getDB()));}
$row = mysqli_fetch_row($result);
$xhtml .= (($row[0])?($StrERR):($StrOK)).'<br />'."\n";

$xhtml .= 'Kein Spiel mit weniger als 1 oder mehr als '.MAX_SAETZE.' Sätzen ... ';

$query = 'SELECT count(*) FROM saetze sa INNER JOIN spiele sp ON sa.spiel_id=sp.spiel_id '.
         'GROUP BY sp.spiel_id HAVING count(*)<1 OR count(*)>'.MAX_SAETZE;
if(!$result = mysqli_query(CDBConnection::getDB(), $query)) {throw new Exception(mysqlil_error(CDBConnection::getDB()));}
$row = mysqli_fetch_row($result);
$xhtml .= (($row[0])?($StrERR):($StrOK)).'<br />'."\n";

$xhtml .= 'Kein Spielergebnismeldungsspiel mit weniger als 2 oder mehr als 3 Sätzen ... ';

$query = 'SELECT count(*) FROM saetze s INNER JOIN spiele_sperml ss ON s.spiel_id=ss.spiel_id '.
         'GROUP BY ss.spiel_id HAVING count(*)<2 OR count(*)>3';
if(!$result = mysqli_query(CDBConnection::getDB(), $query)) {throw new Exception(mysqlil_error(CDBConnection::getDB()));}
$row = mysqli_fetch_row($result);
$xhtml .= (($row[0])?($StrERR):($StrOK)).'<br />'."\n";

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
$xhtml .= '<h2>Tabellen</h2>'."\n";
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

$TabnameLftArray = array();
$TabnameLftArray[] = array('Tabelleneinträge', 'tabelleneintraege');

$xhtml .= CheckIDs('tabellen', $TabnameLftArray);

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
$xhtml .= '<h2>Termine</h2>'."\n";
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

$xhtml .= 'Nicht zugeordnete Termine ... ';

$query = 'SELECT * FROM (termine t LEFT JOIN termine_allgemein ta ON t.termin_id=ta.termin_id) '.
         'LEFT JOIN termine_pktspbeg tp ON t.termin_id=tp.termin_id '.
         'WHERE (ta.termin_id IS NULL) AND (tp.termin_id IS NULL)';
if(!$result = mysqli_query(CDBConnection::getDB(), $query)) {throw new Exception(mysqlil_error(CDBConnection::getDB()));}
$row = mysqli_fetch_row($result);
$xhtml .= (($row[0])?($StrERR):($StrOK)).'<br />'."\n";

$xhtml .= 'Uneindeutige Termine ... ';

$query = 'SELECT * FROM termine_allgemein ta, termine_pktspbeg tp WHERE ta.termin_id=tp.termin_id';
if(!$result = mysqli_query(CDBConnection::getDB(), $query)) {throw new Exception(mysqlil_error(CDBConnection::getDB()));}
$row = mysqli_fetch_row($result);
$xhtml .= (($row[0])?($StrERR):($StrOK)).'<br />'."\n";

$xhtml .= 'Allgemeine Termine ohne Masterdatensatz ... ';

$query = 'SELECT * FROM termine_allgemein ta LEFT JOIN termine t ON ta.termin_id=t.termin_id WHERE t.termin_id IS NULL';
if(!$result = mysqli_query(CDBConnection::getDB(), $query)) {throw new Exception(mysqlil_error(CDBConnection::getDB()));}
$row = mysqli_fetch_row($result);
$xhtml .= (($row[0])?($StrERR):($StrOK)).'<br />'."\n";

$xhtml .= 'Punktspielbegegnungstermine ohne Masterdatensatz ... ';

$query = 'SELECT * FROM termine_pktspbeg tp '.
         'LEFT JOIN termine t ON tp.termin_id=t.termin_id WHERE t.termin_id IS NULL';
if(!$result = mysqli_query(CDBConnection::getDB(), $query)) {throw new Exception(mysqlil_error(CDBConnection::getDB()));}
$row = mysqli_fetch_row($result);
$xhtml .= (($row[0])?($StrERR):($StrOK)).'<br />'."\n";

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
$xhtml .= '<h2>Training</h2>'."\n";
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

$TabnameLftArray = array();
$TabnameLftArray[] = array('Trainingsspiele', 'spiele_training');

$xhtml .= CheckIDs('training', $TabnameLftArray);

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
$xhtml .= '<h2>Turniere</h2>'."\n";
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

$TabnameLftArray = array();
$TabnameLftArray[] = array('Turniermeldungen', 'turniermeldungen');

$xhtml .= CheckIDs('turniere', $TabnameLftArray);

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
$xhtml .= '<h2>Turniermeldungen</h2>'."\n";
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

$TabnameLftArray = array();
$TabnameLftArray[] = array('Turnierathleten', 'turnierathleten');

$xhtml .= CheckIDs('turniermeldungen', $TabnameLftArray);

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
$xhtml .= '<h2>Vereine</h2>'."\n";
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

$TabnameLftArray = array();
$TabnameLftArray[] = array('Gegner', 'athleten_gegner');
$TabnameLftArray[] = array('Mannschaften', 'mannschaften');
$TabnameLftArray[] = array('Freundschaftsspielergebnismeldungen', 'sperml_freundschaft');
$TabnameLftArray[] = array('Externe Punktspielergebnismeldungen', 'sperml_punktspiel_extern');
$TabnameLftArray[] = array('Punktspielbegegnungstermine', 'termine_pktspbeg');

$xhtml .= CheckIDs('vereine', $TabnameLftArray);

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Auswertung
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

$heading = '<h1>Selbsttest der Datenbank</h1>'.PHP_EOL;
$xhtml = $heading.'<p class="textbox schattiert"><em>Status '.
((strpos($xhtml, 'color:red'))?($StrERR):($StrOK)).'</em></p>'.PHP_EOL.$xhtml;

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// RETURN
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

$data['xhtml'] = $xhtml;
return new CTemplateData($data, true);
?>