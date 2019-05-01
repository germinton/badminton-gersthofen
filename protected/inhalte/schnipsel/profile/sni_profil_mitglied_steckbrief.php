<?php $Height = 200; $XHTMLforIMG = $Mitglied->getXHTMLforIMG(false, $Height) ?>

<div class="profil mitglied" id="athlet_id:<?php echo $Mitglied->getAthletID() ?>"
<?php echo (($XHTMLforIMG)?('style="min-height:'.($Height+5).'px"'):('')) ?>><?php echo $XHTMLforIMG ?>

<h2>Steckbrief von <?php echo $Mitglied ?></h2>

<dl>
	<dt>Vorname</dt>
	<dd><?php echo $Mitglied->getVorname(GET_NBSP) ?></dd>
	<dt>Nachname</dt>
	<dd><?php echo $Mitglied->getNachname() ?></dd>
	<?php if($s = $Mitglied->getSpitzname()) {echo '<dt>Spitzname</dt>'."\n".'<dd>'.$s.'</dd>'."\n";} ?>
	<?php if($s = $Mitglied->getBeruf()) {echo '<dt>Beruf</dt>'."\n".'<dd>'.$s.'</dd>'."\n";} ?>
	<!--<dt>E-Mail</dt>
	<dd><?php /*echo $Mitglied->getEMail(array(GET_NBSP, GET_SPEC))*/ ?></dd>-->
	<?php if(count($aa = $Mitglied->getAufgabenstringArray())) { ?>
	<dt>&nbsp;</dt>
	<dd>&nbsp;</dd>
	<dt>Aufgaben</dt>
	<dd><?php foreach($aa as $AString) {echo $AString.'<br />';} ?></dd>
	<?php } ?>
	<?php if($pe = $Mitglied->statEinsaetze()) { ?>
	<dt>&nbsp;</dt>
	<dd>&nbsp;</dd>
	<dt>Punktspieleinsätze<sup>1</sup></dt>
	<dd><?php echo $pe.' ('.$Mitglied->statEinsaetzePlatz().'. Platz gesamt und '.
	$Mitglied->statEinsaetzePlatz('AJS', true).'. Platz unter allen '.
	((S_HERR == $Mitglied->getAnrede())?('Herren'):('Damen')).')'; ?></dd>
	<?php } ?>
	<?php if(count($ma = $Mitglied->getMeisterstringArray())) { ?>
	<dt>&nbsp;</dt>
	<dd>&nbsp;</dd>
	<dt>Titel</dt>
	<dd><?php foreach($ma as $MString) {echo $MString.'<br />';} ?></dd>
	<?php } ?>
	<?php if(count($ra = $Mitglied->getRLErfolgstringArray())) { ?>
	<dt>&nbsp;</dt>
	<dd>&nbsp;</dd>
	<dt>Ranglistenerfolge<sup><?php echo (($pe)?('2'):('1')) ?></sup></dt>
	<dd><?php foreach($ra as $RLString) {echo $RLString.'<br />';} ?></dd>
	<?php } ?>
</dl>

<?php if($s = $Mitglied->getUeberSich(GET_SPEC)) {echo '<h3>Über '.$Mitglied.'</h3>'."\n".'<p>'.$s.'</p>'."\n";} ?> <?php if($pe or count($ra)) { ?>
<div class="profil_mitglied_fuss"><?php if($pe)
{
	echo '<sup>1</sup> gültig zum '.$Mitglied->statEinsaetzeDatum().'; ';
	echo 'ein „Einsatz“ entspricht einem Einzel, Doppel oder Mixed auf einem Spieltag'."\n";
	if(count($ra)) {echo '<br />'."\n";}
}

if(count($ra)) {echo '<sup>'.(($pe)?('2'):('1')).'</sup> nur Top-Ten-Platzierungen'."\n";} ?></div>
<?php } ?></div>
