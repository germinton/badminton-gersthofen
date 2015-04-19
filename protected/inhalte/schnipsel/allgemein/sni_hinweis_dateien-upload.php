<div id="hinweis_dateien-upload">
<h3>Upload von Anhängen</h3>
<p>Die maximal erlaubte Dateigröße beträgt <?php echo round(MAX_FILE_SIZE_ATTACH_FILE/(1024*1024), 2).'&#x202F;MB' ?>.</p>
<p>Es können in einem Formular maximal <?php echo round(return_bytes(ini_get('post_max_size'))/(1024*1024), 2).'&#x202F;MB ' ?>
"in einem Rutsch" hochgeladen werden. Wird diese Grenze überschritten, so bricht der Absende-Vorgang <span
	style="color: red; font-weight: bold">ohne Fehlermeldung</span> ab und man landet wieder auf der Einstiegsseite! Alle
übermittelten Daten werden in so einem Fall vom Server verworfen!</p>
</div>
