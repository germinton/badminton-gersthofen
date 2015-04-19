<?php $Mitglied = $SiteManager->getMitglied() ?>

<form action="index.php?section=prof_aendernlogin" method="post" id="form_detail" class="dokument">

<h1>Benutzername/Passwort</h1>

<fieldset><legend>Login-Daten</legend>

<div class="control"><label for="benutzername" class="input_heading">Benutzername</label> <input type="text"
	name="benutzername" id="benutzername" value="<?php echo $Mitglied->getBenutzername() ?>" maxlength="20" size="20" /></div>

<br />

<div class="control"><label for="passwort_neu1">Neues Passwort <span class="hint">(Lass das Feld leer, wenn Du Dein
altes Passwort behalten möchtest)</span></label> <input type="password" name="passwort_neu1" id="passwort_neu1" value=""
	maxlength="20" size="20" /></div>

<br />

<div class="control"><label for="passwort_neu1">Passwort wiederholen <span class="hint">(sofert Du oben ein neues
Passwort eingegeben hast)</span></label> <input type="password" name="passwort_neu2" id="passwort_neu2" value=""
	maxlength="20" size="20" /></div>

</fieldset>

<fieldset><legend>Bitte bestätige die Änderung mit Deinem alten Passwort</legend>

<div class="control"><label for="passwort_alt" class="input_heading">Altes Passwort</label> <input type="password"
	name="passwort_alt" id="passwort_alt" value="" maxlength="20" size="20" /></div>

</fieldset>

<fieldset>

<p class="formularbuttons">
<button type="submit" name="save" value="save">Speichern</button>
<button type="submit" name="cancel" value="cancel">Abbrechen</button>
</p>

</fieldset>

</form>
