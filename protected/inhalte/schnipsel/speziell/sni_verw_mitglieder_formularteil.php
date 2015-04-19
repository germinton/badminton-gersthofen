<fieldset><legend>Grunddaten</legend>

<div class="control hidden"><input type="hidden" name="athlet_id" value="<?php echo $Mitglied->getAthletID() ?>" /></div>

<div class="control"><label for="anrede">Anrede <?php
if(MODE_NEW != $data['modus']) {
	echo ' <span class="hint">(Die Anrede kann nachträglich nicht geändert werden.)</span>';
}
?> </label> <?php
if(MODE_NEW == $data['modus'])
{
	echo '<select name="anrede" id="anrede" >'."\n";
	echo '<option value="'.S_HERR.'"'.((S_HERR == $Mitglied->getAnrede())?(' selected="selected"'):('')).'>Herr</option>'."\n";
	echo '<option value="'.S_DAME.'"'.((S_DAME == $Mitglied->getAnrede())?(' selected="selected"'):('')).'>Frau</option>'."\n";
	echo '</select>'."\n";
}
else
{
	echo '<input type="hidden" name="anrede" id="anrede" value="'.$Mitglied->getAnrede().'" />'."\n";
	echo $Mitglied->getAnrede(GET_C2SC);
}
?></div>

<br />

<div class="control"><label for="vorname">Vorname</label> <input type="text" name="vorname" id="vorname"
	value="<?php echo $Mitglied->getVorname() ?>" maxlength="30" size="30" /></div>

<div class="control"><label for="nachname"><span class="mandatory">* </span>Nachname</label> <input type="text"
	name="nachname" id="nachname" value="<?php echo $Mitglied->getNachname() ?>" maxlength="30" size="30" /></div>

<div class="control"><label for="spitzname">Spitzname</label> <input type="text" name="spitzname" id="spitzname"
	value="<?php echo $Mitglied->getSpitzname() ?>" maxlength="20" size="20" /></div>

<br />

<div class="control"><label for="geburtstag">Geburtstag</label> <input type="text" name="geburtstag" id="geburtstag"
	value="<?php echo $Mitglied->getGeburtstag(GET_DTDE) ?>" maxlength="10" size="10"
	class="w8em format-d-m-y divider-dot highlight-days-67 no-transparency" /></div>

<div class="control"><label for="beruf">Beruf</label> <input type="text" name="beruf" id="beruf"
	value="<?php echo $Mitglied->getBeruf() ?>" maxlength="30" size="30" /></div>

<br />

<?php
$Obj = $Mitglied;
include('protected/inhalte/schnipsel/allgemein/sni_control_bilder-upload.php');
?></fieldset>

<fieldset><legend>Anschrift</legend>

<div class="control"><label for="strasse">Straße</label> <input type="text" name="strasse" id="strasse"
	value="<?php echo $Mitglied->getStrasse() ?>" maxlength="50" size="50" /></div>

<br />

<div class="control"><label for="plz">PLZ</label> <input type="text" name="plz" id="plz"
	value="<?php echo $Mitglied->getPLZ() ?>" maxlength="5" size="5" /></div>

<div class="control"><label for="ort">Ort</label> <input type="text" name="ort" id="ort"
	value="<?php echo $Mitglied->getOrt() ?>" maxlength="50" size="50" /></div>

</fieldset>

<fieldset><legend>Telefon &amp; E-Mail</legend>

<div class="control"><label for="tel_priv">Telefon privat</label> <input type="text" name="tel_priv" id="tel_priv"
	value="<?php echo $Mitglied->getTelPriv() ?>" maxlength="30" size="24" /></div>

<div class="control"><label for="tel_gesch">Telefon geschäftlich</label> <input type="text" name="tel_gesch"
	id="tel_gesch" value="<?php echo $Mitglied->getTelGesch() ?>" maxlength="30" size="24" /></div>

<div class="control"><label for="tel_priv2">Telefon privat 2</label> <input type="text" name="tel_priv2" id="tel_priv2"
	value="<?php echo $Mitglied->getTelPriv2() ?>" maxlength="30" size="24" /></div>

<br />

<div class="control"><label for="fax">Fax</label> <input type="text" name="fax" id="fax"
	value="<?php echo $Mitglied->getFax() ?>" maxlength="30" size="24" /></div>

<div class="control"><label for="tel_mobil">Mobiltelefon</label> <input type="text" name="tel_mobil" id="tel_mobil"
	value="<?php echo $Mitglied->getTelMobil() ?>" maxlength="30" size="24" /></div>

<br />

<div class="control"><label for="email">E-Mail Adresse</label> <input type="text" name="email" id="email"
	value="<?php echo $Mitglied->getEMail() ?>" maxlength="50" size="50" /></div>

<br />

</fieldset>

<fieldset style="background: #C0FFC0"><legend>Daten des Erziehungsberechtigten (nur bei Minderjährigen auszufüllen)</legend>

<div class="control"><label for="erzber_vorname">Vorname</label> <input type="text" name="erzber_vorname"
	id="erzber_vorname" value="<?php echo $Mitglied->getErzBerVorname() ?>" maxlength="30" size="30" /></div>

<div class="control"><label for="erzber_nachname">Nachname</label> <input type="text" name="erzber_nachname"
	id="erzber_nachname" value="<?php echo $Mitglied->getErzBerNachname() ?>" maxlength="30" size="30" /></div>

<br />

<div class="control"><label for="erzber_tel_mobil">Mobiltelefon</label> <input type="text" name="erzber_tel_mobil"
	id="erzber_tel_mobil" value="<?php echo $Mitglied->getErzBerTelMobil() ?>" maxlength="30" size="24" /></div>

<div class="control"><label for="erzber_email">E-Mail Adresse</label> <input type="text" name="erzber_email"
	id="erzber_email" value="<?php echo $Mitglied->getErzBerEMail() ?>" maxlength="50" size="50" /></div>

<br />

</fieldset>

<fieldset><legend>Internet</legend>

<div class="control"><span class="input_heading">Newsletter</span>
<ul class="sidebyside">
	<li><input type="checkbox" name="newsletter" id="newsletter" value="1"
	<?php if($Mitglied->getNewsletter() or MODE_NEW == $data['modus']) {echo ' checked="checked"';} ?> /> <label
		for="newsletter">Ja, ich möchte den Newsletter der Sparte Badminton erhalten um immer über Trainingsausfälle oder
	geplante Unternehmungen auf dem Laufenden zu sein.</label></li>
</ul>
</div>

<br />

<div class="control"><label for="website">Eigene Website</label> <input type="text" name="website" id="website"
	value="<?php echo $Mitglied->getWebsite() ?>" maxlength="50" size="50" /></div>

</fieldset>

<fieldset><legend>"Über Dich"-Text</legend>

<div class="control"><label for="ueber_sich">"Über Dich"-Text <span class="hint">(<a href="#hinweis_textfelder_spe">XHTML
erlaubt</a>)</span></label> <textarea name="ueber_sich" id="ueber_sich" cols="75" rows="12"><?php echo $Mitglied->getUeberSich(GET_HSPC) ?></textarea>
</div>

</fieldset>
