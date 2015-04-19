<?php
$xhtml = '<h1>CMannschaft</h1>'."\n";

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
$xhtml .= '<h2>Neue Instanz</h2>'."\n";
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

$theObj = new CMannschaft();
$xhtml .= '<p>'.$theObj.'</p>'."\n";

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
$xhtml .= '<h2>Datenprüfung</h2>'."\n";
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

$theObj->setSaisonID(0);
$theObj->setAKlaGruppe(4);
$theObj->setNr(-1);
$theObj->setPlatzierung1(21);
$theObj->setPlatzierung2(-2);
$theObj->setLigaKlasseID(-11);
$theObj->setVereinID(-3);
$Bildunterschrift = 'a'; for($i=0; $i<65535; $i++) {$Bildunterschrift .= 'a';}
//$Bildunterschrift = 'Hallo [hier] ist ein [Fehler} versteckt.';
$theObj->setBildunterschrift($Bildunterschrift);
$ErgDienst = 'a'; for($i=0; $i<256; $i++) {$ErgDienst .= 'a';}
$theObj->setErgDienst($ErgDienst);

$xhtml .= '<p>Objekt wird jetzt ...';
//$theObj->save();
$xhtml .= '... gespeichert. ID ist '.$theObj->getMannschaftID().', __toString(): '.$theObj.'</p>'."\n";

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
$xhtml .= '<h2>Setter</h2>'."\n";
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

$theObj->setMannschaftID(99887766);
$theObj->setSaisonID(7);
$theObj->setAKlaGruppe(S_AKTIVE);
$theObj->setNr(5);
$theObj->setPlatzierung1(2);
$theObj->setPlatzierung2(3);
$theObj->setLigaKlasseID(5);
$theObj->setVereinID(137);
$theObj->setBildunterschrift('Hans Hias Hummel');
$theObj->setErgDienst('http://www.tsv-gersthofen.de');

$xhtml .= '<pre><code>'."\n";
$xhtml .= print_r($theObj, true);
$xhtml .= '</code></pre>'."\n";

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
$xhtml .= '<h2>Getter</h2>'."\n";
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

$xhtml .= '<p>'."\n";
$xhtml .= 'getMannschaftID(): '.$theObj->getMannschaftID().'<br />'."\n";
$xhtml .= 'getSaisonID(): '.$theObj->getSaisonID().'<br />'."\n";
$xhtml .= 'getAKlaGruppe(): '.$theObj->getAKlaGruppe().'<br />'."\n";
$xhtml .= 'getAKlaGruppe(GET_C2SC): '.$theObj->getAKlaGruppe(GET_C2SC).'<br />'."\n";
$xhtml .= 'getNr(): '.$theObj->getNr().'<br />'."\n";
$xhtml .= 'getPlatzierung1(): '.$theObj->getPlatzierung1().'<br />'."\n";
$xhtml .= 'getPlatzierung2(): '.$theObj->getPlatzierung2().'<br />'."\n";
$xhtml .= 'getLigaKlasseID(): '.$theObj->getLigaKlasseID().'<br />'."\n";
$xhtml .= 'getVereinID(): '.$theObj->getVereinID().'<br />'."\n";
$xhtml .= 'getBildunterschrift(): '.$theObj->getBildunterschrift().'<br />'."\n";
$xhtml .= 'getErgDienst(): '.$theObj->getErgDienst().'<br />'."\n";
$xhtml .= '</p>'."\n";

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
$xhtml .= '<h2>Datensatz speichern</h2>'."\n";
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

$xhtml .= '<p>Objekt wird jetzt ...';
$theObj->save();
$xhtml .= '... gespeichert. ID ist '.$theObj->getMannschaftID().', __toString(): '.$theObj.'</p>'."\n";

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
$xhtml .= '<h2>Datensatz laden</h2>'."\n";
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

$theObj->load($theObj->getMannschaftID());
$xhtml .= '<p>'."\n";
$xhtml .= 'load('.$theObj->getMannschaftID().'): '.$theObj.'<br />'."\n";
$xhtml .= '</p>'."\n";

$xhtml .= '<pre><code>'."\n";
$xhtml .= print_r($theObj, true);
$xhtml .= '</code></pre>'."\n";

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
$xhtml .= '<h2>Datensatz ändern und speichern</h2>'."\n";
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

$theObj->setSaisonID(7);
$theObj->setAKlaGruppe(S_AKTIVE);
$theObj->setNr(6);
$theObj->setPlatzierung1(2);
$theObj->setPlatzierung2(9);
$theObj->setLigaKlasseID(5);
$theObj->setVereinID(null);
$theObj->setBildunterschrift('Karl Klammer');
$theObj->setErgDienst('http://www.alleturniere.de/sport/draw.aspx?id=9F2CF3D8-5AB7-44D9-911B-15A538A952B0&draw=36');

$xhtml .= '<p>Objekt wird jetzt ...';
$theObj->save();
$xhtml .= '... gespeichert. ID ist '.$theObj->getMannschaftID().', __toString(): '.$theObj.'</p>'."\n";

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
$xhtml .= '<h2>Vermischtes</h2>'."\n";
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

$xhtml .= '<p>'."\n";
$xhtml .= 'getLinkErgDienst(): '.$theObj->getLinkErgDienst().'<br />'."\n";
$xhtml .= '</p>'."\n";

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