<?php /*===========================================================================================================*/ ?>
<?php if(VIEW_LIST == $data['view']) { ?>
<?php /*===========================================================================================================*/ ?>

<form action="index.php" method="get" id="form_filter_sort" class="dokument">

<div class="control"><input type="hidden" name="section" value="verw_vereine" /></div>

<div class="control line"><input type="checkbox" name="fltr1" id="fltr1" value="1"
<?php echo (($data['fltr1'])?(' checked="checked"'):('')) ?> class="right" /> <label for="fltr1">Zeige auch Kürzel "SG"</label></div>

<div class="control line"><label for="sort" class="left">Sortierung</label> <select name="sort" id="sort">
<?php
echo '<option value="0"';
echo ((0 == $data['sort'])?(' selected="selected"'):('')).'>Name</option>'."\n";
echo '<option value="1"';
echo ((1 == $data['sort'])?(' selected="selected"'):('')).'>Kürzel</option>'."\n";
?>
</select></div>

<div class="control">
<button type="submit" class="right">Anwenden</button>
</div>

</form>



<h1>Vereine</h1>

<form action="index.php?section=verw_vereine<?php echo $data['fs_string'] ?>" method="post" id="form_overview">

<div class="control">
<button type="submit" name="new" value="new">Neuen Verein erstellen</button>
</div>

<?php
$VereinArray = $data['verein_array'];
include('protected/inhalte/schnipsel/tabellen/sni_tabelle_verw_vereine.php')
?></form>

<h2>Nicht löschbare Einträge</h2>
<p>Datensätze, bei denen das 'Löschen-Symbol' nicht angezeigt wird, sind nicht löschbar. Würde dieser Datensatz gelöscht
werden, so würden abhängige Datensätze in anderen Tabellen automatisch mit gelöscht. Beispelsweise würden alle
Spielergebnismeldungen, in denen Mannschaften dieses Vereins eingetragen sind, gelöscht werden.</p>

<?php /*===========================================================================================================*/ ?>
<?php } else if(VIEW_DETAIL == $data['view']) { ?>
<?php /*===========================================================================================================*/ ?>
<?php $Verein = $data['verein'] ?>

<form action="index.php?section=verw_vereine<?php echo $data['fs_string'] ?>" method="post"
	enctype="multipart/form-data" id="form_detail" class="dokument">

<h1>Verein <?php echo ((MODE_NEW == $data['modus'])?('erstellen'):('bearbeiten')) ?></h1>

<fieldset>

<div class="control hidden"><input type="hidden" name="verein_id" value="<?php echo $Verein->getVereinID() ?>" /></div>

<div class="control"><label for="kuerzel">Kürzel</label> <input type="text" name="kuerzel" id="kuerzel"
	value="<?php echo $Verein->getKuerzel() ?>" maxlength="5" size="5" /></div>

<div class="control"><label for="name"><span class="mandatory">* </span>Name</label> <input type="text" name="name"
	id="name" value="<?php echo $Verein->getName() ?>" maxlength="50" size="50" /></div>

<br />

<div class="control"><label for="homepage">Link zur Homepage</label> <input type="text" name="homepage" id="homepage"
	value="<?php echo $Verein->getHomepage() ?>" maxlength="255" size="100" /></div>
</fieldset>
<fieldset><?php
$Obj = $Verein;
include('protected/inhalte/schnipsel/allgemein/sni_control_bilder-upload.php');
?></fieldset>

<fieldset>

<p>Mit <span class="mandatory">* </span>markierte Eingabefelder müssen ausgefüllt werden.</p>

<p class="formularbuttons">
<button type="submit" name="save" value="save">Speichern</button>
<button type="submit" name="cancel" value="cancel">Abbrechen</button>
</p>

</fieldset>

</form>

<h2>Hinweise zum Ausfüllen</h2>
<?php include('protected/inhalte/schnipsel/allgemein/sni_hinweis_bilder-upload.php') ?>

<?php /*===========================================================================================================*/ ?>
<?php } ?>
<?php /*===========================================================================================================*/ ?>