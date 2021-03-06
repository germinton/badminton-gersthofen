<?php
$xhtml = '<h1>CAustragungsort</h1>'."\n";

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
$xhtml .= '<h2>Neue Instanz</h2>'."\n";
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

$theObj = new CAustragungsort();
$xhtml .= '<p>'.$theObj.'</p>'."\n";

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
$xhtml .= '<h2>Datenprüfung</h2>'."\n";
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

$theObj->setHallenname('MusterhallMusterhallMusterhallMusterhallMusterhallM');
$theObj->setVereinID(0);
$theObj->setStrasse('MusterstraMusterstraMusterstraMusterstraMusterstraM');
$theObj->setPLZ('999');
$theObj->setOrt('a');
$theObj->setFelder(256);
$Info = 'a'; for($i=0; $i<65535; $i++) {$Info .= 'a';}
//$Info = 'Hallo [hier] ist ein [Fehler} versteckt.';
$theObj->setInfo($Info);
$theObj->setGMapLat(90100000);
$theObj->setGMapLon(-180100000);

$xhtml .= '<p>Objekt wird jetzt ...';
//$theObj->save();
$xhtml .= '... gespeichert. ID ist '.$theObj->getAustragungsortID().', __toString(): '.$theObj.'</p>'."\n";

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
$xhtml .= '<h2>Setter</h2>'."\n";
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

$theObj->setAustragungsortID(99887766);
$theObj->setHallenname('Musterhalle');
$theObj->setVereinID(1);
$theObj->setStrasse('Musterstraße');
$theObj->setPLZ('99999');
$theObj->setOrt('Gersthofen');
$theObj->setFelder(255);
$theObj->setInfo('guckuck');
$theObj->setGMapLat(6000000);
$theObj->setGMapLon(-70000000);

$xhtml .= '<pre><code>'."\n";
$xhtml .= print_r($theObj, true);
$xhtml .= '</code></pre>'."\n";

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
$xhtml .= '<h2>Getter</h2>'."\n";
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

$xhtml .= '<p>'."\n";
$xhtml .= 'getAustragungsortID(): '.$theObj->getAustragungsortID().'<br />'."\n";
$xhtml .= 'getHallenname(): '.$theObj->getHallenname().'<br />'."\n";
$xhtml .= 'getVereinID(): '.$theObj->getVereinID().'<br />'."\n";
$xhtml .= 'getStrasse(): '.$theObj->getStrasse().'<br />'."\n";
$xhtml .= 'getPLZ(): '.$theObj->getPLZ().'<br />'."\n";
$xhtml .= 'getOrt(): '.$theObj->getOrt().'<br />'."\n";
$xhtml .= 'getFelder(): '.$theObj->getFelder().'<br />'."\n";
$xhtml .= 'getInfo(): '.$theObj->getInfo().'<br />'."\n";
$xhtml .= 'getGMapLat(): '.$theObj->getGMapLat().'<br />'."\n";
$xhtml .= 'getGMapLat(GET_SPEC): '.$theObj->getGMapLat(GET_SPEC).'<br />'."\n";
$xhtml .= 'getGMapLon(): '.$theObj->getGMapLon().'<br />'."\n";
$xhtml .= 'getGMapLon(GET_SPEC): '.$theObj->getGMapLon(GET_SPEC).'<br />'."\n";
$xhtml .= '</p>'."\n";

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
$xhtml .= '<h2>Datensatz speichern</h2>'."\n";
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

$xhtml .= '<p>Objekt wird jetzt ...';
$theObj->save();
$xhtml .= '... gespeichert. ID ist '.$theObj->getAustragungsortID().', __toString(): '.$theObj.'</p>'."\n";

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
$xhtml .= '<h2>Datensatz laden</h2>'."\n";
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

$theObj->load($theObj->getAustragungsortID());
$xhtml .= '<p>'."\n";
$xhtml .= 'load('.$theObj->getAustragungsortID().'): '.$theObj.'<br />'."\n";
$xhtml .= '</p>'."\n";

$xhtml .= '<pre><code>'."\n";
$xhtml .= print_r($theObj, true);
$xhtml .= '</code></pre>'."\n";

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
$xhtml .= '<h2>Datensatz ändern und speichern</h2>'."\n";
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

$theObj->setHallenname('Hallemuster');
$theObj->setVereinID(2);
$theObj->setStrasse('Straßemuster');
$theObj->setPLZ('11111');
$theObj->setOrt('Entenhausen');
$theObj->setFelder(8);
$theObj->setInfo('heiho');
$theObj->setGMapLat(-19000000);
$theObj->setGMapLon(-30000000);

$xhtml .= '<p>Objekt wird jetzt ...';
$theObj->save();
$xhtml .= '... gespeichert. ID ist '.$theObj->getAustragungsortID().', __toString(): '.$theObj.'</p>'."\n";

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