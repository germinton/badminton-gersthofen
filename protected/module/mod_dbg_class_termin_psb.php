<?php
$xhtml = '<h1>CTerminPSB</h1>'."\n";

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
$xhtml .= '<h2>Neue Instanz</h2>'."\n";
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

$theObj = new CTerminPSB();
$xhtml .= '<p>'.$theObj.'</p>'."\n";

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
$xhtml .= '<h2>Datenprüfung</h2>'."\n";
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

$theObj->setDatum('2009-01-2');
//$Freitext = 'a'; for($i=0; $i<65535; $i++) $Freitext .= 'a';
$Freitext = 'Hallo [hier] ist ein [Fehler} versteckt.';
$theObj->setFreitext($Freitext);
$theObj->setMannschaftID(-1);
$theObj->setAustragungsortID(0);
//$theObj->setUhrzeit('12:5:49');
$theObj->setUhrzeit('12:61:49');
$theObj->setSeite(-1);
$theObj->setVereinID(0);
$theObj->setMannschaftNr(99);

$xhtml .= '<p>Objekt wird jetzt ...';
//$theObj->save();
$xhtml .= '... gespeichert. ID ist '.$theObj->getTerminID().', __toString(): '.$theObj.'</p>'."\n";

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
$xhtml .= '<h2>Setter</h2>'."\n";
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

$theObj->setTerminID(99887766);
$theObj->setDatum('2009-01-20');
$theObj->setFreitext('Wir treffen uns am <em>PKG</em>! Jonny, unser {trainer} fährt mit.');
$theObj->setMannschaftID(98);
$theObj->setAustragungsortID(264);
$theObj->setUhrzeit('12:00:00');
$theObj->setSeite(S_GAST);
$theObj->setVereinID(198);
$theObj->setMannschaftNr(2);

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
$xhtml .= 'getMannschaftID(GET_OFID): '.$theObj->getMannschaftID(GET_OFID).'<br />'."\n";
$xhtml .= 'getAustragungsortID(GET_OFID): '.$theObj->getAustragungsortID(GET_OFID).'<br />'."\n";
$xhtml .= 'getUhrzeit(): '.$theObj->getUhrzeit().'<br />'."\n";
$xhtml .= 'getSeite(): '.$theObj->getSeite().'<br />'."\n";
$xhtml .= 'getSeite(GET_C2SC): '.$theObj->getSeite(GET_C2SC).'<br />'."\n";
$xhtml .= 'getVereinID(GET_OFID): '.$theObj->getVereinID(GET_OFID).'<br />'."\n";
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

$theObj->setDatum('2010-03-20');
$theObj->setFreitext('Vergesst eure <em>Ausweise</em> nicht!');
$theObj->setMannschaftID(79);
$theObj->setAustragungsortID(241);
$theObj->setUhrzeit('11:30:00');
$theObj->setSeite(S_HEIM);
$theObj->setVereinID(200);
$theObj->setMannschaftNr(5);

$xhtml .= '<p>Objekt wird jetzt ...';
$theObj->save();
$xhtml .= '... gespeichert. ID ist '.$theObj->getTerminID().', __toString(): '.$theObj.'</p>'."\n";

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
$xhtml .= '<h2>Vermischtes</h2>'."\n";
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

//$xhtml .= $theObj->getXHTML();

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