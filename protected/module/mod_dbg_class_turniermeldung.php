<?php
$xhtml = '<h1>CTurniermeldung</h1>'."\n";

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
$xhtml .= '<h2>Neue Instanz</h2>'."\n";
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

$theObj = new CTurniermeldung();
$xhtml .= '<p>'.$theObj.'</p>'."\n";

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
$xhtml .= '<h2>Datenprüfung</h2>'."\n";
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

$theObj->setTurnierID(-1);
$theObj->setSpieltyp(S_DETYP);

$TurnierathletArray = array();
$TurnierathletArray[1] = new CTurnierathlet(); $TurnierathletArray[1]->setAthletID(14);
$TurnierathletArray[2] = new CTurnierathlet(); $TurnierathletArray[2]->setAthletID(53);
$theObj->setTurnierathletArray($TurnierathletArray);


$theObj->setSpielgruppe('SpielgrppeSpielgrppeS');
$theObj->setPlatzierung(300);

$xhtml .= '<p>Objekt wird jetzt ...';
//$theObj->save();
$xhtml .= '... gespeichert. ID ist '.$theObj->getTurniermeldungID().', __toString(): '.$theObj.'</p>'."\n";

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
$xhtml .= '<h2>Setter</h2>'."\n";
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

$theObj->setTurniermeldungID(99887766);
$theObj->setTurnierID(60);
$theObj->setSpieltyp(S_HDTYP);

$TurnierathletArray = array();
$TurnierathletArray[1] = new CTurnierathlet(); $TurnierathletArray[1]->setAthletID(14);
$TurnierathletArray[2] = new CTurnierathlet(); $TurnierathletArray[2]->setAthletID(53);
$theObj->setTurnierathletArray($TurnierathletArray);

$theObj->setSpielgruppe('Halodris');
$theObj->setPlatzierung(5);

$xhtml .= '<pre><code>'."\n";
$xhtml .= print_r($theObj, true);
$xhtml .= '</code></pre>'."\n";

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
$xhtml .= '<h2>Clone</h2>'."\n";
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

$theCloneObj = clone $theObj;

$theCloneObj->setTurniermeldungID(99887765);
$theCloneObj->setTurnierID(61);
$TurnierathletArray = $theCloneObj->getTurnierathletArray();
$TurnierathletArray[0]->setAthletID(1);
$TurnierathletArray[1]->setAthletID(37);
$theCloneObj->setSpielgruppe('KingKongs');
$theCloneObj->setPlatzierung(1);

$xhtml .= '<h3>$theObj</h3>'."\n";
$xhtml .= '<pre><code>'."\n";
$xhtml .= print_r($theObj, true);
$xhtml .= '</code></pre>'."\n";

$xhtml .= '<h3>$theCloneObj</h3>'."\n";
$xhtml .= '<pre><code>'."\n";
$xhtml .= print_r($theCloneObj, true);
$xhtml .= '</code></pre>'."\n";

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
$xhtml .= '<h2>Getter</h2>'."\n";
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

$xhtml .= '<p>'."\n";
$xhtml .= 'getTurniermeldungID(): '.$theObj->getTurniermeldungID().'<br />'."\n";
$xhtml .= 'getTurnierID(): '.$theObj->getTurnierID().'<br />'."\n";
$xhtml .= 'getSpieltyp(): '.$theObj->getSpieltyp().'<br />'."\n";
$xhtml .= 'getSpieltyp(GET_C2SC): '.$theObj->getSpieltyp(GET_C2SC).'<br />'."\n";
$xhtml .= 'getSpielgruppe(): '.$theObj->getSpielgruppe().'<br />'."\n";
$xhtml .= 'getPlatzierung(): '.$theObj->getPlatzierung().'<br />'."\n";
$xhtml .= 'getTurnierathletArray(): '.print_r($theObj->getTurnierathletArray(), true).'<br />'."\n";
$xhtml .= '</p>'."\n";

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
$xhtml .= '<h2>Datensatz speichern</h2>'."\n";
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

$xhtml .= '<p>Objekt wird jetzt ...';
$theObj->save();
$xhtml .= '... gespeichert. ID ist '.$theObj->getTurniermeldungID().', __toString(): '.$theObj.'</p>'."\n";

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
$xhtml .= '<h2>Datensatz laden</h2>'."\n";
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

$theObj->load($theObj->getTurniermeldungID());

$xhtml .= '<p>'."\n";
$xhtml .= 'load('.$theObj->getTurniermeldungID().'): '.$theObj.'<br />'."\n";
$xhtml .= '</p>'."\n";

$xhtml .= '<pre><code>'."\n";
$xhtml .= print_r($theObj, true);
$xhtml .= '</code></pre>'."\n";

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
$xhtml .= '<h2>Datensatz ändern und speichern</h2>'."\n";
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

$theObj->setTurnierID(62);
$theObj->setSpieltyp(S_MXTYP);
$Turnierathlet1 = new CTurnierathlet(); $Turnierathlet1->setAthletID(1);
$Turnierathlet2 = new CTurnierathlet(); $Turnierathlet2->setAthletID(14);
$theObj->setTurnierathletArray(array($Turnierathlet1, $Turnierathlet2));
$theObj->setSpielgruppe('Juhu');
$theObj->setPlatzierung(1);

$xhtml .= '<p>Objekt wird jetzt ...';
$theObj->save();
$xhtml .= '... gespeichert. ID ist '.$theObj->getTurniermeldungID().', __toString(): '.$theObj.'</p>'."\n";

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
$xhtml .= '<h2>Vermischtes</h2>'."\n";
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

$xhtml .= '<p>keine \'misc\'-funktionen deklariert</p>';

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