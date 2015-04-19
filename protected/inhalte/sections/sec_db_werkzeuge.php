<form action="index.php?section=db_werkzeuge" method="post" id="form_detail" class="dokument">

<h1>Datenbank-Werkzeuge</h1>

<fieldset>

<div class="control"><span class="input_heading">Datenbankstatus</span>
<ul>
	<li>Aktuelle Saison ist <?php echo new CSaison($data['saison_id']) ?>.</li>
	<li>Mitgliederbearbeitung ist <?php echo (($data['ath_lock'])?('nicht erlaubt'):('möglich')) ?>.</li>
	<li>Einsatzstatistik ist vom <?php echo S2S_Datum_MySql2Deu($data['dat_estatistik']) ?></li>
</ul>
</div>

</fieldset>

<fieldset>

<div class="control"><span class="input_heading">Aktionen ausführen</span>
<ul class="onebelowtheother">
	<li><input type="checkbox" name="ath_lock" id="ath_lock" value="1"
	<?php if($data['ath_lock']) {echo 'checked="checked" ';} ?> /> <label for="ath_lock">Mitgliederbearbeitung sperren</label></li>
	<li><input type="checkbox" name="upd_estatistik" id="upd_estatistik" value="1" /> <label for="upd_estatistik">Einsatzstatistik
	aktualisieren (Geduld!)</label></li>
	<li><select name="saison_id" id="saison_id">
	<?php
	foreach($data['saison_array'] as $Saison)
	{
		echo '<option value="'.$Saison->getSaisonID().'"';
		if($data['saison_id'] == $Saison->getSaisonID()) {echo ' selected="selected"';}
		echo '>'.$Saison.'</option>'."\n";
	}
	?>
	</select><label for="saison_id"> zur aktuelle Saison machen</label></li>
</ul>
</div>

</fieldset>

<fieldset>

<p class="formularbuttons">
<button type="submit" name="save" value="save">Anwenden</button>
<button type="submit" name="cancel" value="cancel">Abbrechen</button>
</p>

</fieldset>

</form>
