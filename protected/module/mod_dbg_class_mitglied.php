<?php
$xhtml = '<h1>CMitglied</h1>'."\n";

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
$xhtml .= '<h2>Neue Instanz</h2>'."\n";
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

$theObj = new CMitglied();
$xhtml .= '<p>'.$theObj.'</p>'."\n";

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
$xhtml .= '<h2>Datenprüfung</h2>'."\n";
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

$theObj->setAnrede(3);
$theObj->setNachname('');
$theObj->setVorname('MustermannMustermannMustermannM');
$theObj->setGeburtstag('192d2-09-02');
$theObj->setStrasse('MustermannMustermannMustermannMustermannMustermannM');
$theObj->setPLZ('8896');
$theObj->setOrt('MustermannMustermannMustermannMustermannMustermannM');
$theObj->setTelPriv('+49 821 555 MustermannMustermann');
$theObj->setTelPriv2('+49 821 666 MustermannMustermann');
$theObj->setTelGesch('+49 821 777 MustermannMustermann');
$theObj->setFax('+49 821 888 MustermannMustermann');
$theObj->setTelMobil('+49 821 999 MustermannMustermann');
$theObj->setEMail('josel@jimmicom');
$theObj->setWebsite('MustermannMustermannMustermannMustermannMustermannM');
$theObj->setAusblenden('kann nicht geprüft werden'); // führt nicht zum Fehler, da jeder Parameter interpretiert wird
$theObj->setSpitzname('MustermannMustermannM');
$theObj->setBenutzername('Hallo_§3');
$theObj->setPasswort('');
$theObj->setUeberSich('');
$theObj->setNewsletter('kann nicht geprüft werden'); // führt nicht zum Fehler, da jeder Parameter interpretiert wird
$theObj->setLastUpdate('192d2-09-02 22:44:99');
$theObj->setPwAendern('kann nicht geprüft werden'); // führt nicht zum Fehler, da jeder Parameter interpretiert wird
$theObj->setFreigabeWSite('kann nicht geprüft werden'); // führt nicht zum Fehler, da jeder Parameter interpretiert wird
$theObj->setFreigabeFBook('kann nicht geprüft werden'); // führt nicht zum Fehler, da jeder Parameter interpretiert wird
$theObj->setErzBerVorname('Mia MustermannMustermannMustermannMustermannMustermannMustermann');
$theObj->setErzBerNachname('Mutter MustermannMustermannMustermannMustermann');
$theObj->setErzBerTelMobil('+49 821 666 MusterMutterMustermannMustermannMustermannMustermann');
$theObj->setErzBerEMail('mia@muttercom');

$xhtml .= '<p>Objekt wird jetzt ...';
//$theObj->save();
$xhtml .= '... gespeichert. ID ist '.$theObj->getAthletID().', __toString(): '.$theObj.'</p>'."\n";

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
$xhtml .= '<h2>Setter</h2>'."\n";
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

$theObj->setAthletID(99887766);
$theObj->setAnrede(S_DAME);
$theObj->setNachname('Magdalena');
$theObj->setVorname('Musterfrau');
$theObj->setGeburtstag('1982-09-02');
$theObj->setStrasse('Gutdünkenstraße');
$theObj->setPLZ('88965');
$theObj->setOrt('Entenhausen');
$theObj->setTelPriv('+49 821 555');
$theObj->setTelPriv2('+49 821 666');
$theObj->setTelGesch('+49 821 777');
$theObj->setFax('+49 821 888');
$theObj->setTelMobil('+49 821 999');
$theObj->setEMail('maggie@simpsons.com');
$theObj->setWebsite('www.maggie.com');
$theObj->setAusblenden('ja');
$theObj->setSpitzname('Maggie');
$theObj->setBenutzername('musterfrau');
$theObj->setPasswort(md5('jippi'));
$theObj->setUeberSich('Toll Toll Toll');
$theObj->setBeruf('Handwerker');
$theObj->setNewsletter('nein');
$theObj->setLastUpdate('1982-09-02 21:44:01');
$theObj->setPwAendern('ja');
$theObj->setFreigabeWSite('ja');
$theObj->setFreigabeFBook('ja');
$theObj->setErzBerVorname('Mia');
$theObj->setErzBerNachname('Mutter');
$theObj->setErzBerTelMobil('+49 821 666');
$theObj->setErzBerEMail('mia@mutter.com');

$xhtml .= '<pre><code>'."\n";
$xhtml .= print_r($theObj, true);
$xhtml .= '</code></pre>'."\n";

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
$xhtml .= '<h2>Getter</h2>'."\n";
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

$xhtml .= '<p>'."\n";
$xhtml .= 'getAthletID(): '.$theObj->getAthletID().'<br />'."\n";
$xhtml .= 'getAnrede(): '.$theObj->getAnrede().'<br />'."\n";
$xhtml .= 'getAnrede(GET_C2SC): '.$theObj->getAnrede(GET_C2SC).'<br />'."\n";
$xhtml .= 'getNachname(): '.$theObj->getNachname().'<br />'."\n";
$xhtml .= 'getVorname(): '.$theObj->getVorname().'<br />'."\n";
$xhtml .= 'getGeburtstag(): '.$theObj->getGeburtstag().'<br />'."\n";
$xhtml .= 'getStrasse(): '.$theObj->getStrasse().'<br />'."\n";
$xhtml .= 'getPLZ(): '.$theObj->getPLZ().'<br />'."\n";
$xhtml .= 'getOrt(): '.$theObj->getOrt().'<br />'."\n";
$xhtml .= 'getTelPriv(): '.$theObj->getTelPriv().'<br />'."\n";
$xhtml .= 'getTelPriv2(): '.$theObj->getTelPriv2().'<br />'."\n";
$xhtml .= 'getTelGesch(): '.$theObj->getTelGesch().'<br />'."\n";
$xhtml .= 'getFax(): '.$theObj->getFax().'<br />'."\n";
$xhtml .= 'getTelMobil(): '.$theObj->getTelMobil().'<br />'."\n";
$xhtml .= 'getEMail(): '.$theObj->getEMail().'<br />'."\n";
$xhtml .= 'getWebsite(): '.$theObj->getWebsite().'<br />'."\n";
$xhtml .= 'getAusblenden(): '.$theObj->getAusblenden().'<br />'."\n";
$xhtml .= 'getAusblenden(GET_SPEC): '.$theObj->getAusblenden(GET_SPEC).'<br />'."\n";
$xhtml .= 'getSpitzname(): '.$theObj->getSpitzname().'<br />'."\n";
$xhtml .= 'getBenutzername(): '.$theObj->getBenutzername().'<br />'."\n";
$xhtml .= 'getPasswort(): '.$theObj->getPasswort().'<br />'."\n";
$xhtml .= 'getUeberSich(): '.$theObj->getUeberSich().'<br />'."\n";
$xhtml .= 'getBeruf(): '.$theObj->getBeruf().'<br />'."\n";
$xhtml .= 'getNewsletter(GET_SPEC): '.$theObj->getNewsletter(GET_SPEC).'<br />'."\n";
$xhtml .= 'getLastLogin(): '.$theObj->getLastLogin().'<br />'."\n";
$xhtml .= 'getLastUpdate(): '.$theObj->getLastUpdate().'<br />'."\n";
$xhtml .= 'getPwAendern(): '.$theObj->getPwAendern().'<br />'."\n";
$xhtml .= 'getPwAendern(GET_SPEC): '.$theObj->getPwAendern(GET_SPEC).'<br />'."\n";
$xhtml .= 'getFreigabeWSite(): '.$theObj->getFreigabeWSite().'<br />'."\n";
$xhtml .= 'getFreigabeFBook(): '.$theObj->getFreigabeFBook().'<br />'."\n";
$xhtml .= 'getErzBerVorname(): '.$theObj->getErzBerVorname().'<br />'."\n";
$xhtml .= 'getErzBerNachname(): '.$theObj->getErzBerNachname().'<br />'."\n";
$xhtml .= 'getErzBerTelMobil(): '.$theObj->getErzBerTelMobil().'<br />'."\n";
$xhtml .= 'getErzBerEMail(): '.$theObj->getErzBerEMail().'<br />'."\n";
$xhtml .= '</p>'."\n";

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
$xhtml .= '<h2>Datensatz speichern</h2>'."\n";
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

$xhtml .= '<p>Objekt wird jetzt ...';
$theObj->save();
$xhtml .= '... gespeichert. ID ist '.$theObj->getAthletID().', __toString(): '.$theObj.'</p>'."\n";

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
$xhtml .= '<h2>Datensatz laden</h2>'."\n";
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

$theObj->load($theObj->getAthletID());

$xhtml .= '<p>'."\n";
$xhtml .= 'load('.$theObj->getAthletID().'): '.$theObj.'<br />'."\n";
$xhtml .= '</p>'."\n";

$xhtml .= '<pre><code>'."\n";
$xhtml .= print_r($theObj, true);
$xhtml .= '</code></pre>'."\n";

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
$xhtml .= '<h2>Datensatz ändern und speichern</h2>'."\n";
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

$theObj->setAnrede(S_HERR);
$theObj->setVorname('Joseph');
$theObj->setNachname('Schmitz');
$theObj->setGeburtstag('1982-09-02');
$theObj->setStrasse('Gutdünkenstraße');
$theObj->setPLZ('88965');
$theObj->setOrt('Musterstadt');
$theObj->setTelPriv('+49 821 555');
$theObj->setTelPriv2('+49 821 666');
$theObj->setTelGesch('+49 821 777');
$theObj->setFax('+49 821 888');
$theObj->setTelMobil('+49 821 999');
$theObj->setEMail('josel@jimmi.com');
$theObj->setWebsite('www.josel.com');
$theObj->setAusblenden(0);
$theObj->setSpitzname('Joe');
$theObj->setBenutzername('joselus');
$theObj->setPasswort(md5('jippippi'));
$theObj->setUeberSich(md5('Schön Schön Schön'));
$theObj->setBeruf('Schluckspecht');
$theObj->setAusblenden(1);
$theObj->setLastUpdate('1982-09-02 21:44:01');
$theObj->setPwAendern(0);
$theObj->setFreigabeWSite(1);
$theObj->setFreigabeFBook(0);
$theObj->setErzBerVorname('Viktor');
$theObj->setErzBerNachname('Vater');
$theObj->setErzBerTelMobil('+49 821 999');
$theObj->setErzBerEMail('viktor@vater.com');

$xhtml .= '<p>Objekt wird jetzt ...';
$theObj->save();
$xhtml .= '... gespeichert. ID ist '.$theObj->getAthletID().', __toString(): '.$theObj.'</p>'."\n";

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
$xhtml .= '<h2>Vermischtes</h2>'."\n";
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

$xhtml .= '<p>'."\n";
$xhtml .= 'getAltersklasse(): '.$theObj->getAltersklasse().'<br />'."\n";
$xhtml .= 'getAltersklasse(GET_C2SC): '.$theObj->getAltersklasse(GET_C2SC).'<br />'."\n";
$xhtml .= 'getAKlaGruppe(): '.$theObj->getAKlaGruppe().'<br />'."\n";
$xhtml .= 'getAKlaGruppe(GET_C2SC): '.$theObj->getAKlaGruppe(GET_C2SC).'<br />'."\n";
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