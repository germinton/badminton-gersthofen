<?php /*===========================================================================================================*/ ?>
<?php if(VIEW_LIST == $data['view']) { ?>
<?php /*===========================================================================================================*/ ?>

<form action="index.php" method="get" id="form_filter_sort" class="dokument">

<div class="control"><input type="hidden" name="section" value="verw_gegner" /></div>

<div class="control line"><label for="fltr1" class="left">Verein</label> <select name="fltr1" id="fltr1">
<?php
echo '<option value="0"'.((0 == $data['fltr1'])?' selected="selected"':'').'></option>'."\n";
echo '<option value="-1"'.((-1 == $data['fltr1'])?' selected="selected"':'').'>Kein Verein</option>'."\n";
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
echo ((0 == $data['sort'])?(' selected="selected"'):('')).'>Name</option>'."\n";
echo '<option value="1"';
echo ((1 == $data['sort'])?(' selected="selected"'):('')).'>Verein</option>'."\n";
?>
</select></div>

<div class="control">
<button type="submit" class="right">Anwenden</button>
</div>

</form>

<h1>Gegner</h1>

<form action="index.php?section=verw_gegner<?php echo (($s = $data['fs_string'])?($s):('')) ?>" method="post"
	id="form_overview">

<div class="control">
<button type="submit" name="new" value="new">Neuen Gegner erstellen</button>
</div>

<div class="divided_tabs"><?php
$Anrede = S_HERR;
$GegnerArray = $data['gegner_array_'.$Anrede];
include('protected/inhalte/schnipsel/tabellen/sni_tabelle_verw_gegner.php');
$Anrede = S_DAME;
$GegnerArray = $data['gegner_array_'.$Anrede];
include('protected/inhalte/schnipsel/tabellen/sni_tabelle_verw_gegner.php');
?></div>

</form>

<h2>Nicht löschbare Einträge</h2>
<p>Datensätze, bei denen das 'Löschen-Symbol' nicht angezeigt wird, sind nicht löschbar. Würde dieser Datensatz gelöscht
werden, so würden abhängige Datensätze in anderen Tabellen automatisch mit gelöscht. Beispelsweise würden alle Spiele,
in denen dieser Athlet mitgespielt hat, gelöscht werden. Spielergebnismeldungen würden dadurch ungültig.</p>

<?php /*===========================================================================================================*/ ?>
<?php } else if(VIEW_DETAIL == $data['view']) { ?>
<?php /*===========================================================================================================*/ ?>
<?php $Gegner = $data['gegner'] ?>

<form action="index.php?section=verw_gegner<?php echo (($s = $data['fs_string'])?($s):('')) ?>" method="post"
	id="form_detail" class="dokument">

<h1>Gegner <?php echo ((MODE_NEW == $data['modus'])?('erstellen'):('bearbeiten')) ?></h1>





<fieldset><legend>Grunddaten</legend>

<div class="control hidden"><input type="hidden" name="athlet_id" value="<?php echo $Gegner->getAthletID() ?>" /></div>

<div class="control"><label for="anrede">Anrede <?php
if(MODE_NEW != $data['modus']) {
	echo ' <span class="hint">(Die Anrede kann nachträglich nicht geändert werden.)</span>';
}
?> </label> <?php
if(MODE_NEW == $data['modus'])
{
	echo '<select name="anrede" id="anrede" >'."\n";
	echo '<option value="'.S_HERR.'"'.((S_HERR == $Gegner->getAnrede())?(' selected="selected"'):('')).'>Herr</option>'."\n";
	echo '<option value="'.S_DAME.'"'.((S_DAME == $Gegner->getAnrede())?(' selected="selected"'):('')).'>Frau</option>'."\n";
	echo '</select>'."\n";
}
else
{
	echo '<input type="hidden" name="anrede" id="anrede" value="'.$Gegner->getAnrede().'" />'."\n";
	echo $Gegner->getAnrede(GET_C2SC);
}
?></div>

<br />

<div class="control"><label for="vorname">Vorname</label> <input type="text" name="vorname" id="vorname"
	value="<?php echo $Gegner->getVorname() ?>" maxlength="30" size="30" /></div>

<div class="control"><label for="nachname"><span class="mandatory">* </span>Nachname</label> <input type="text"
	name="nachname" id="nachname" value="<?php echo $Gegner->getNachname() ?>" maxlength="30" size="30" /></div>

<br />

<div class="control"><span class="input_heading">Verein</span> <select name="verein_id" id="verein_id">
<?php
foreach($data['verein_array'] as $Verein)
{
	echo '<option value="'.($ID = $Verein->getVereinID()).'"';
	echo (($ID == $Gegner->getVereinID())?(' selected="selected"'):('')).'>'.$Verein.'</option>'."\n";
}
?>
</select></div>

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
<?php include('protected/inhalte/schnipsel/allgemein/sni_hinweis_textfelder_gew.php') ?>
<?php include('protected/inhalte/schnipsel/allgemein/sni_hinweis_textfelder_spe.php') ?>
<?php include('protected/inhalte/schnipsel/allgemein/sni_hinweis_bilder-upload.php') ?>

<?php /*===========================================================================================================*/ ?>
<?php } ?>
<?php /*===========================================================================================================*/ ?>