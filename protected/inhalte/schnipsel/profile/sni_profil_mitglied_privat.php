<?php $Height = 200; $XHTMLforIMG = $Mitglied->getXHTMLforIMG(true, $Height) ?>

<div class="profil mitglied" id="athlet_id:<?php echo $Mitglied->getAthletID() ?>"
<?php echo ($XHTMLforIMG) ? ('style="min-height:'.($Height + 5).'px"') : ('') ?>><?php echo $XHTMLforIMG ?>

<h2>Persönliche Daten von <?php echo $Mitglied ?></h2>

<dl>
	<dt>Vorname</dt>
	<dd><?php echo $Mitglied->getVorname(GET_NBSP) ?></dd>
	<dt>Nachname</dt>
	<dd><?php echo $Mitglied->getNachname() ?></dd>
	<dt>Geschlecht</dt>
	<dd><?php echo $Mitglied->getAnrede(GET_SPEC) ?></dd>
	<dt>Spitzname</dt>
	<dd><?php echo $Mitglied->getSpitzname(GET_NBSP) ?></dd>
	<dt>Beruf</dt>
	<dd><?php echo $Mitglied->getBeruf(GET_NBSP) ?></dd>
	<dt>Geburtstag</dt>
	<dd><?php echo $Mitglied->getGeburtstag(array(GET_DTDE, GET_NBSP)) ?></dd>
	<dt>Altersklasse<sup>1</sup></dt>
	<dd><?php echo $Mitglied->getAltersklasse(array(GET_NBSP, GET_C2SC), date('Y').'12-31') ?></dd>
	<dt>&nbsp;</dt>
	<dd>&nbsp;</dd>
	<dt>Straße</dt>
	<dd><?php echo $Mitglied->getStrasse(GET_NBSP) ?></dd>
	<dt>PLZ</dt>
	<dd><?php echo $Mitglied->getPLZ(GET_NBSP) ?></dd>
	<dt>Ort</dt>
	<dd><?php echo $Mitglied->getOrt(GET_NBSP) ?></dd>
	<dt>&nbsp;</dt>
	<dd>&nbsp;</dd>
	<dt>Privat</dt>
	<dd><?php echo $Mitglied->getTelPriv(GET_NBSP) ?></dd>
	<dt>Mobil</dt>
	<dd><?php echo $Mitglied->getTelMobil(GET_NBSP) ?></dd>
	<dt>Privat-2</dt>
	<dd><?php echo $Mitglied->getTelPriv2(GET_NBSP) ?></dd>
	<dt>Geschäftlich</dt>
	<dd><?php echo $Mitglied->getTelGesch(GET_NBSP) ?></dd>
	<dt>Fax</dt>
	<dd><?php echo $Mitglied->getFax(GET_NBSP) ?></dd>
	<dt>&nbsp;</dt>
	<dd>&nbsp;</dd>
	<dt>E-Mail</dt>
	<dd><?php echo $Mitglied->getEMail(GET_NBSP) ?></dd>
	<dt>Website</dt>
	<dd><?php echo $Mitglied->getWebsite(GET_NBSP) ?></dd>
	<?php if (count($aa = $Mitglied->getAufgabenstringArray())) {
    ?>
	<dt>&nbsp;</dt>
	<dd>&nbsp;</dd>
	<dt>Aufgaben</dt>
	<dd><?php foreach ($aa as $AString) {
    echo $AString.'<br />';
} ?></dd>
	<?php

} ?>
	<?php if ($pe = $Mitglied->statEinsaetze()) {
    ?>
	<dt>&nbsp;</dt>
	<dd>&nbsp;</dd>
	<dt>Punktspieleinsätze<sup>2</sup></dt>
	<dd><?php echo $pe.' ('.$Mitglied->statEinsaetzePlatz().'. Platz gesamt und '.
    $Mitglied->statEinsaetzePlatz('AJS', true).'. Platz unter allen '.
    ((S_HERR == $Mitglied->getAnrede()) ? ('Herren') : ('Damen')).')'; ?></dd>
	<?php

} ?>
	<?php if (count($ma = $Mitglied->getMeisterstringArray())) {
    ?>
	<dt>&nbsp;</dt>
	<dd>&nbsp;</dd>
	<dt>Titel</dt>
	<dd><?php foreach ($ma as $MString) {
    echo $MString.'<br />';
} ?></dd>
	<?php

} ?>
	<?php if (count($ra = $Mitglied->getRLErfolgstringArray())) {
    ?>
	<dt>&nbsp;</dt>
	<dd>&nbsp;</dd>
	<dt>Ranglistenerfolge<sup><?php echo ($pe) ? ('3') : ('2') ?></sup></dt>
	<dd><?php foreach ($ra as $RLString) {
    echo $RLString.'<br />';
} ?></dd>
	<?php

} ?>
</dl>
	<?php if ($s = $Mitglied->getUeberSich(GET_SPEC)) {
    echo '<h3>Über '.$Mitglied.'</h3>'."\n".'<p>'.$s.'</p>'."\n";
} ?> <?php if ($Mitglied->getAKlaGruppe() != S_AKTIVE) {
    ?>
<dt>&nbsp;</dt>
<dd>&nbsp;</dd>
<dt>Medienfreigabe &#133;</dt>
<dd>Die Medienfreigabe ist von besonderer Bedeutung bei Minderjährigen und kann mittels <a
	href="downloads/Medienfreigabe.pdf">Formular (pdf)</a> geändert werden. Erfasst sind aktuell die untenstehenden
Einverständnisse:</dd>
<dt>&#133; Website</dt>
<dd><?php echo $Mitglied->getFreigabeWSite(GET_SPEC) ?></dd>
<dt>&#133; Facebook</dt>
<dd><?php echo $Mitglied->getFreigabeFBook(GET_SPEC) ?></dd>
<?php

} ?>
<dt>&nbsp;</dt>
<dd>&nbsp;</dd>
<dt>Abteilungsbeitrag</dt>
<dd>
<?php
if ($Mitglied->getBeitrag()) {
    $beitrag = new CBeitrag($Mitglied->getBeitrag());
    echo $beitrag->getBeitrag().' €';
} else {
    echo 'Nicht gesetzt';
} ?>
</dd>


<div class="profil_mitglied_fuss"><sup>1</sup> Stichtag zum <?php echo '31.12.'.date('Y') ?> <?php if ($pe) {
    echo '<br />'."\n";
    echo '<sup>2</sup> gültig zum '.$Mitglied->statEinsaetzeDatum().'; ';
    echo 'ein „Einsatz“ entspricht einem Einzel, Doppel oder Mixed auf einem Spieltag'."\n";
}
if (count($ra)) {
    echo '<br />'."\n";
    echo '<sup>'.(($pe) ? ('3') : ('2')).'</sup> nur Top-Ten-Platzierungen'."\n";
} ?></div>
</div>
