<?php /*===========================================================================================================*/ ?>
<?php if(VIEW_LIST == $data['view']) { ?>
<?php /*===========================================================================================================*/ ?>

<form action="index.php" method="get" id="form_filter_sort" class="dokument">

<div class="control"><input type="hidden" name="section" value="verw_austragungsorte" /></div>

<div class="control line"><label for="fltr1" class="left">Verein</label> <select name="fltr1" id="fltr1">
<?php
echo '<option value="0"'.((!$data['fltr1'])?' selected="selected"':'').'>Alle Vereine</option>'."\n";
foreach($data['fltr1_array'] as $Verein)
{
	echo '<option value="'.$Verein->getVereinID().'"';
	echo (($Verein->getVereinID() == $data['fltr1'])?' selected="selected"':'').'>'.$Verein.'</option>'."\n";
}
?>
</select></div>

<div class="control line"><label for="sort" class="left">Sortierung</label> <select name="sort" id="sort">
<?php
echo '<option value="0"';
echo ((0 == $data['sort'])?(' selected="selected"'):('')).'>Ort</option>'."\n";
echo '<option value="1"';
echo ((1 == $data['sort'])?(' selected="selected"'):('')).'>Verein</option>'."\n";
echo '<option value="2"';
echo ((2 == $data['sort'])?(' selected="selected"'):('')).'>Hallenname</option>'."\n";
?>
</select></div>

<div class="control">
<button type="submit" class="right">Anwenden</button>
</div>

</form>



<h1>Austragungsorte</h1>

<form action="index.php?section=verw_austragungsorte<?php echo $data['fs_string'] ?>" method="post" id="form_overview">

<div class="control">
<button type="submit" name="new" value="new">Neuen Austragungsort erstellen</button>
</div>

<?php
$AustragungsortArray = $data['austragungsort_array'];
include('protected/inhalte/schnipsel/tabellen/sni_tabelle_verw_austragungsorte.php')
?></form>

<h2>Nicht löschbare Einträge</h2>
<p>Datensätze, bei denen das 'Löschen-Symbol' nicht angezeigt wird, sind nicht löschbar. Würde dieser Datensatz gelöscht
werden, so würden abhängige Datensätze in anderen Tabellen automatisch mit gelöscht. Beispelsweise würden alle
Spielergebnismeldungen, die diesen Austragungsort angegeben haben, gelöscht werden.</p>

<?php /*===========================================================================================================*/ ?>
<?php } else if(VIEW_DETAIL == $data['view']) { ?>
<?php /*===========================================================================================================*/ ?>
<?php $Austragungsort = $data['austragungsort'] ?>

<form action="index.php?section=verw_austragungsorte<?php echo $data['fs_string'] ?>" method="post"
	enctype="multipart/form-data" id="form_detail" class="dokument">

<h1>Austragungsort <?php echo ((MODE_NEW == $data['modus'])?('erstellen'):('bearbeiten')) ?></h1>

<fieldset>

<div class="control hidden"><input type="hidden" name="austragungsort_id"
	value="<?php echo $Austragungsort->getAustragungsortID() ?>" /></div>

<div class="control"><label for="hallenname"><span class="mandatory">* </span>Hallenname</label> <input type="text"
	name="hallenname" id="hallenname" value="<?php echo $Austragungsort->getHallenname() ?>" maxlength="50" size="50" /></div>

<div class="control"><label for="verein_id">Verein</label> <?php
echo '<select name="verein_id" id="verein_id" >'."\n";
echo '<option value="0"'.((0 == $ID = $Austragungsort->getVereinID())?' selected="selected"':'').'></option>'."\n";
foreach($data['verein_array'] as $Verein)
{
	echo '<option value="'.$Verein->getVereinID().'"';
	echo (($Verein->getVereinID() == $ID)?(' selected="selected"'):(''));
	echo '>'.$Verein.'</option>'."\n";
}
echo '</select>'."\n";
?></div>

<div class="control"><label for="felder">Felder</label><select name="felder" id="felder">
<?php
echo '<option value="0"'.((0 == $felder = $Austragungsort->getFelder())?' selected="selected"':'').'></option>'."\n";
for($i=1; $i<=MAX_FELDER; $i++) {
	echo '<option value="'.$i.'"'.(($felder == $i)?' selected="selected"':'').'>'.$i.'</option>'."\n";
} ?>
</select></div>

</fieldset>

<fieldset><legend>Anschrift</legend>

<div class="control"><label for="strasse">Straße</label> <input type="text" name="strasse" id="strasse"
	value="<?php echo $Austragungsort->getStrasse() ?>" maxlength="50" size="50" /></div>

<br />

<div class="control"><label for="plz">PLZ</label> <input type="text" name="plz" id="plz"
	value="<?php echo $Austragungsort->getPLZ() ?>" maxlength="5" size="5" /></div>

<div class="control"><label for="ort"><span class="mandatory">* </span>Ort</label> <input type="text" name="ort"
	id="ort" value="<?php echo $Austragungsort->getOrt() ?>" maxlength="50" size="50" /></div>

<br />

<div class="control"><label for="gmap_lat">Breitengrad</label> <input type="text" name="gmap_lat" id="gmap_lat"
	value="<?php echo $Austragungsort->getGMapLat(GET_SPEC) ?>" maxlength="12" size="12" /></div>

<div class="control"><label for="gmap_lon">Längengrad</label> <input type="text" name="gmap_lon" id="gmap_lon"
	value="<?php echo $Austragungsort->getGMapLon(GET_SPEC) ?>" maxlength="12" size="12" /></div>

</fieldset>

<fieldset><?php
$Obj = $Austragungsort;
$Height = 300;
include('protected/inhalte/schnipsel/allgemein/sni_control_bilder-upload.php');
?> <br />

<div class="control"><label for="info">Info <span class="hint">(<a href="#hinweis_textfelder_spe">XHTML erlaubt</a>)</span></label>
<textarea name="info" id="info" cols="75" rows="12"><?php echo $Austragungsort->getInfo(GET_HSPC) ?></textarea></div>

</fieldset>

<fieldset>

<p>Mit <span class="mandatory">* </span>markierte Eingabefelder müssen ausgefüllt werden.</p>

<p class="formularbuttons">
<button type="submit" name="save" value="save">Speichern</button>
<button type="submit" name="cancel" value="cancel">Abbrechen</button>
</p>

</fieldset>

</form>

<h2>Hinweise zum Ausfüllen</h2>
<?php include('protected/inhalte/schnipsel/allgemein/sni_hinweis_textfelder_spe.php') ?>
<?php include('protected/inhalte/schnipsel/allgemein/sni_hinweis_bilder-upload.php') ?>

<?php /*===========================================================================================================*/ ?>
<?php } ?>
<?php /*===========================================================================================================*/ ?>