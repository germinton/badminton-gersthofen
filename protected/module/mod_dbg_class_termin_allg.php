<?php
$xhtml = '<h1>CTerminAllg</h1>'."\n";

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
$xhtml .= '<h2>Neue Instanz</h2>'."\n";
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

$theObj = new CTerminAllg();
$xhtml .= '<p>'.$theObj.'</p>'."\n";

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
$xhtml .= '<h2>Datenprüfung</h2>'."\n";
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

$theObj->setDatum('2009-01-2');
//$Freitext = 'a'; for($i=0; $i<65535; $i++) $Freitext .= 'a';
$Freitext = 'Hallo [hier] ist ein [Fehler} versteckt.';
$theObj->setFreitext($Freitext);
$theObj->setTitel('MustermannMustermannMustermannMustermannMustermannMustermannMustermannMustermannMustermannMustermannM');
$theObj->setOrt('MustermannMustermannMustermannMustermannMustermannM');
$theObj->setAthletID(0);
$theObj->setEndedatum('2009-01-32');
$theObj->setFuerA('kann nicht geprüft werden'); // führt nicht zum Fehler, da jeder Parameter interpretiert wird
$theObj->setFuerJ('kann nicht geprüft werden'); // führt nicht zum Fehler, da jeder Parameter interpretiert wird
$theObj->setFuerS('kann nicht geprüft werden'); // führt nicht zum Fehler, da jeder Parameter interpretiert wird

$xhtml .= '<p>Objekt wird jetzt ...';
//$theObj->save();
$xhtml .= '... gespeichert. ID ist '.$theObj->getTerminID().', __toString(): '.$theObj.'</p>'."\n";

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
$xhtml .= '<h2>Setter</h2>'."\n";
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

$theObj->setTerminID(99887766);
$theObj->setDatum('2009-01-20');
$theObj->setFreitext('Hallo <em>Du</em>! Auf der {startseite} sind alle Infos zur Unternehmung.');
$theObj->setTitel('Neuer Termin');
$theObj->setOrt('New York');
$theObj->setAthletID(14);
$theObj->setEndedatum('2009-01-24');
$theObj->setFuerA(0);
$theObj->setFuerJ(1);
$theObj->setFuerS(0);

$xhtml .= '<pre><code>'."\n";
$xhtml .= print_r($theObj, true);
$xhtml .= '</code></pre>'."\n";

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
$xhtml .= '<h2>Getter</h2>'."\n";
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

$xhtml .= '<p>'."\n";
$xhtml .= 'getTerminID(): '.$theObj->getTerminID().'<br />'."\n";
$xhtml .= 'getDatum(): '.$theObj->getDatum().'<br />'."\n";
$xhtml .= 'getFreitext(): '.$theObj->getFreitext().'<br />'."\n";
$xhtml .= 'getTitel(): '.$theObj->getTitel().'<br />'."\n";
$xhtml .= 'getOrt(): '.$theObj->getOrt().'<br />'."\n";
$xhtml .= 'getAthletID(): '.$theObj->getAthletID().'<br />'."\n";
$xhtml .= 'getEndedatum(): '.$theObj->getEndedatum().'<br />'."\n";
$xhtml .= 'getFuerA(): '.$theObj->getFuerA().'<br />'."\n";
$xhtml .= 'getFuerA(GET_SPEC): '.$theObj->getFuerA(GET_SPEC).'<br />'."\n";
$xhtml .= 'getFuerJ(): '.$theObj->getFuerJ().'<br />'."\n";
$xhtml .= 'getFuerJ(GET_SPEC): '.$theObj->getFuerJ(GET_SPEC).'<br />'."\n";
$xhtml .= 'getFuerS(): '.$theObj->getFuerS().'<br />'."\n";
$xhtml .= 'getFuerS(GET_SPEC): '.$theObj->getFuerS(GET_SPEC).'<br />'."\n";
$xhtml .= '</p>'."\n";

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
$xhtml .= '<h2>Datensatz speichern</h2>'."\n";
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

$xhtml .= '<p>Objekt wird jetzt ...';
$theObj->save();
$xhtml .= '... gespeichert. ID ist '.$theObj->getTerminID().', __toString(): '.$theObj.'</p>'."\n";

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
$xhtml .= '<h2>Datensatz laden</h2>'."\n";
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

$theObj->load($theObj->getTerminID());

$xhtml .= '<p>'."\n";
$xhtml .= 'load('.$theObj->getTerminID().'): '.$theObj.'<br />'."\n";
$xhtml .= '</p>'."\n";

$xhtml .= '<pre><code>'."\n";
$xhtml .= print_r($theObj, true);
$xhtml .= '</code></pre>'."\n";

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
$xhtml .= '<h2>Datensatz ändern und speichern</h2>'."\n";
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

$theObj->setDatum('2009-02-20');
$theObj->setFreitext('Morgen ist Party Party Party.');
$theObj->setTitel('Nächster Termin');
$theObj->setOrt('New York');
$theObj->setAthletID(53);
$theObj->setEndedatum('2009-02-24');
$theObj->setFuerA(1);
$theObj->setFuerJ(1);
$theObj->setFuerS(1);

$xhtml .= '<p>Objekt wird jetzt ...';
$theObj->save();
$xhtml .= '... gespeichert. ID ist '.$theObj->getTerminID().', __toString(): '.$theObj.'</p>'."\n";

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
$xhtml .= '<h2>Vermischtes</h2>'."\n";
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

$xhtml .= $theObj->getXHTML();

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
$xhtml .= '<h2>Datensatz löschen</h2>'."\n";
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

$xhtml .= '<p>Objekt wird jetzt ...';
$theObj->delete();
$xhtml .= '... gelöscht: '.$theObj.'</p>'."\n";

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// RETURN
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

$data['xhtml'] = $xhtml;
return new CTemplateData($data, true);
?>