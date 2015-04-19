<?php $Mitglied = $SiteManager->getMitglied() ?>

<form action="index.php?section=prof_aendernperson" method="post" enctype="multipart/form-data" id="form_detail"
	class="dokument">

<h1>Persönliche Daten</h1>

<?php include('protected/inhalte/schnipsel/speziell/sni_verw_mitglieder_formularteil.php') ?>

<fieldset>

<p>Mit <span class="mandatory">* </span>markierte Eingabefelder müssen ausgefüllt werden.</p>

<p class="formularbuttons">
<button type="submit" name="save" value="save">Speichern</button>
<button type="submit" name="cancel" value="cancel">Abbrechen</button>
</p>

</fieldset>

</form>

<h2>Hinweise zum Ausfüllen</h2>
<?php include('protected/inhalte/schnipsel/allgemein/sni_hinweis_textfelder_gew.php') ?>
<?php include('protected/inhalte/schnipsel/allgemein/sni_hinweis_textfelder_spe.php') ?>
<?php include('protected/inhalte/schnipsel/allgemein/sni_hinweis_bilder-upload.php') ?>