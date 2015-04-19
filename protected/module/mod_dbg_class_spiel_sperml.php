<?php
$xhtml = '<h1>CSpielSpErMl</h1>'."\n";

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
$xhtml .= '<h2>Neue Instanz</h2>'."\n";
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

$theObj = new CSpielSpErMl();
$xhtml .= '<p>'.$theObj.'</p>'."\n";

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
$xhtml .= '<h2>Datenprüfung</h2>'."\n";
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

$theObj->setSpErMlSpieltyp(11);
//$theObj->setSpieltyp(-1);
$theObj->setSpErMlID(-1);

$KontrahentArray = array();
$KontrahentArray[S_HEIM][1] = new CKontrahent(); $KontrahentArray[S_HEIM][1]->setAthletID(-1);
$KontrahentArray[S_GAST][1] = new CKontrahent(); $KontrahentArray[S_GAST][1]->setAthletID(-5);
$theObj->setKontrahentArray($KontrahentArray);

$SatzArray = array();
$SatzArray[1] = new CSatz(); $SatzArray[1]->setPunkte(77, 78);
$SatzArray[2] = new CSatz(); $SatzArray[2]->setPunkte(66, 67);
$SatzArray[3] = new CSatz(); $SatzArray[3]->setPunkte(55, 56);
$theObj->setSatzArray($SatzArray);

$xhtml .= '<p>Objekt wird jetzt ...';
//$theObj->save();
$xhtml .= '... gespeichert. ID ist '.$theObj->getSpielID().', __toString(): '.$theObj.'</p>'."\n";

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
$xhtml .= '<h2>Setter</h2>'."\n";
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

$theObj->setSpielID(99887766);
$theObj->setSpErMlSpieltyp(S_SPERMLDETYP);
$theObj->setSpErMlID(1);

$KontrahentArray = array();
$KontrahentArray[S_HEIM][1] = new CKontrahent(); $KontrahentArray[S_HEIM][1]->setAthletID(8);
$KontrahentArray[S_GAST][1] = new CKontrahent(); $KontrahentArray[S_GAST][1]->setAthletID(9);
$theObj->setKontrahentArray($KontrahentArray);

$SatzArray = array();
$SatzArray[1] = new CSatz(); $SatzArray[1]->setPunkte(1, 2);
$SatzArray[2] = new CSatz(); $SatzArray[2]->setPunkte(3, 4);
$SatzArray[3] = new CSatz(); $SatzArray[3]->setPunkte(5, 6);
$theObj->setSatzArray($SatzArray);

$xhtml .= '<pre><code>'."\n";
$xhtml .= print_r($theObj, true);
$xhtml .= '</code></pre>'."\n";

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
$xhtml .= '<h2>Getter</h2>'."\n";
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

$xhtml .= '<p>'."\n";
$xhtml .= 'getSpielID(): '.$theObj->getSpielID().'<br />'."\n";
$xhtml .= 'getSpieltyp(GET_C2SC): '.$theObj->getSpieltyp(GET_C2SC).'<br />'."\n";
$xhtml .= 'getSpErMlSpieltyp(GET_C2SC): '.$theObj->getSpErMlSpieltyp(GET_C2SC).'<br />'."\n";
$xhtml .= 'getSpErMlID(): '.$theObj->getSpErMlID().'<br />'."\n";
$xhtml .= 'getKontrahentArray(): '.print_r($theObj->getKontrahentArray(), true).'<br />'."\n";
$xhtml .= 'getSatzArray(): '.print_r($theObj->getSatzArray(), true).'<br />'."\n";
$xhtml .= '</p>'."\n";

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
$xhtml .= '<h2>Datensatz speichern</h2>'."\n";
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

$xhtml .= '<p>Objekt wird jetzt ...';
$theObj->save();
$xhtml .= '... gespeichert. ID ist '.$theObj->getSpielID().', __toString(): '.$theObj.'</p>'."\n";

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
$xhtml .= '<h2>Datensatz laden</h2>'."\n";
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

$theObj->load($theObj->getSpielID());

$xhtml .= '<p>'."\n";
$xhtml .= 'load('.$theObj->getSpielID().'): '.$theObj.'<br />'."\n";
$xhtml .= '</p>'."\n";

$xhtml .= '<pre><code>'."\n";
$xhtml .= print_r($theObj, true);
$xhtml .= '</code></pre>'."\n";

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
$xhtml .= '<h2>Datensatz ändern und speichern</h2>'."\n";
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

$theObj->setSpErMlSpieltyp(S_SPERMLHE3TYP);
$theObj->setSpErMlID(3);

$KontrahentArray = array();
$KontrahentArray[S_HEIM][1] = new CKontrahent(); $KontrahentArray[S_HEIM][1]->setAthletID(14);
$KontrahentArray[S_GAST][1] = new CKontrahent(); $KontrahentArray[S_GAST][1]->setAthletID(37);
$theObj->setKontrahentArray($KontrahentArray);

$SatzArray = array();
$SatzArray[1] = new CSatz(); $SatzArray[1]->setPunkte(16, 17);
$SatzArray[2] = new CSatz(); $SatzArray[2]->setPunkte(18, 19);
$theObj->setSatzArray($SatzArray);

$xhtml .= '<p>Objekt wird jetzt ...';
$theObj->save();
$xhtml .= '... gespeichert. ID ist '.$theObj->getSpielID().', __toString(): '.$theObj.'</p>'."\n";

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