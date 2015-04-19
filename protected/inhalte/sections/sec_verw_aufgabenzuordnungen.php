<?php /*===========================================================================================================*/ ?>
<?php if(VIEW_LIST == $data['view']) { ?>
<?php /*===========================================================================================================*/ ?>

<form action="index.php" method="get" id="form_filter_sort" class="dokument">

<div class="control"><input type="hidden" name="section" value="verw_aufgabenzuordnungen" /></div>

<div class="control line"><label for="fltr1" class="left">Mitglied</label> <select name="fltr1" id="fltr1">
<?php
echo '<option value="0"'.((0 == $data['fltr1'])?' selected="selected"':'').'></option>'."\n";
foreach($data['fltr1_array'] as $Mitglied)
{
	echo '<option value="'.$Mitglied->getAthletID().'"';
	echo (($Mitglied->getAthletID() == $data['fltr1'])?' selected="selected"':'').'>'.$Mitglied->getNachnameVorname().'</option>'."\n";
}
?>
</select></div>

<div class="control line"><label for="fltr2" class="left">Aufgabe</label> <select name="fltr2" id="fltr2">
<?php
echo '<option value="0"'.((0 == $data['fltr2'])?' selected="selected"':'').'></option>'."\n";
foreach($data['fltr2_array'] as $Aufgabe)
{
	echo '<option value="'.$Aufgabe->getAufgabeID().'"';
	echo (($Aufgabe->getAufgabeID() == $data['fltr2'])?' selected="selected"':'').'>'.$Aufgabe->getBezMaennlich().'</option>'."\n";
}
?>
</select></div>

<div class="control line"><label for="sort" class="left">Sortierung</label> <select name="sort" id="sort">
<?php
echo '<option value="0"';
echo ((0 == $data['sort'])?(' selected="selected"'):('')).'>Aufgabe (Wichtigkeit)</option>'."\n";
echo '<option value="1"';
echo ((1 == $data['sort'])?(' selected="selected"'):('')).'>Aufgabe (Bezeichnung)</option>'."\n";
echo '<option value="2"';
echo ((2 == $data['sort'])?(' selected="selected"'):('')).'>Mitglied</option>'."\n";
?>
</select></div>

<div class="control">
<button type="submit" class="right">Anwenden</button>
</div>

</form>

<h1>Aufgabenzuordnungen</h1>

<form action="index.php?section=verw_aufgabenzuordnungen<?php echo (($s = $data['fs_string'])?($s):('')) ?>"
	method="post" id="form_overview">

<div class="control">
<button type="submit" name="new" value="new">Neue Aufgabenzuordnung erstellen</button>
</div>

<?php
$AufgabenzuordnungenArray = $data['aufgabenzuordnungen_array'];
include('protected/inhalte/schnipsel/tabellen/sni_tabelle_verw_aufgabenzuordnungen.php')
?></form>

<?php /*===========================================================================================================*/ ?>
<?php } else if(VIEW_DETAIL == $data['view']) { ?>
<?php /*===========================================================================================================*/ ?>
<?php $Aufgabenzuordnung = $data['aufgabenzuordnung'] ?>

<form action="index.php?section=verw_aufgabenzuordnungen<?php echo (($s = $data['fs_string'])?($s):('')) ?>"
	method="post" id="form_detail" class="dokument">

<h1>Aufgabenzuordnung <?php echo ((MODE_NEW == $data['modus'])?('erstellen'):('bearbeiten')) ?></h1>

<fieldset>

<div class="control hidden"><input type="hidden" name="aufgabenzuordnung_id"
	value="<?php echo $Aufgabenzuordnung->getAufgabenzuordnungID() ?>" /></div>

<div class="control"><label for="aufgabe_id">Aufgabe</label> <select name="aufgabe_id" id="aufgabe_id">
<?php
foreach($data['aufgaben_array'] as $Aufgabe)
{
	echo '<option value="'.($ID = $Aufgabe->getAufgabeID()).'"';
	echo (($ID == $Aufgabenzuordnung->getAufgabeID())?(' selected="selected"'):('')).'>'.$Aufgabe.'</option>'."\n";
}
?>
</select></div>

<div class="control"><label for="athlet_id">Mitglied</label> <select name="athlet_id" id="athlet_id">
<?php
foreach($data['mitglieder_array'] as $Mitglied)
{
	echo '<option value="'.($ID = $Mitglied->getAthletID()).'"';
	echo (($ID == $Aufgabenzuordnung->getAthletID())?(' selected="selected"'):('')).'>'.$Mitglied->getNachnameVorname().'</option>'."\n";
}
?>
</select></div>

<div class="control"><label for="zusatzinfo">Zusatzinfo</label> <input type="text" name="zusatzinfo" id="zusatzinfo"
	value="<?php echo $Aufgabenzuordnung->getZusatzinfo() ?>" maxlength="50" size="50" /></div>

</fieldset>

<fieldset>

<p>Mit <span class="mandatory">* </span>markierte Eingabefelder müssen ausgefüllt werden.</p>

<p class="formularbuttons">
<button type="submit" name="save" value="save">Speichern</button>
<button type="submit" name="cancel" value="cancel">Abbrechen</button>
</p>

</fieldset>

</form>

<?php /*===========================================================================================================*/ ?>
<?php } ?>
<?php /*===========================================================================================================*/ ?>