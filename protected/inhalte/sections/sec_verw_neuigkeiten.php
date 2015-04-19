<?php /*===========================================================================================================*/ ?>
<?php if(VIEW_LIST == $data['view']) { ?>
<?php /*===========================================================================================================*/ ?>

<form action="index.php" method="get" id="form_filter_sort" class="dokument">

<div class="control hidden"><input type="hidden" name="section" value="verw_neuigkeiten" /></div>

<div class="control line"><input type="checkbox" name="fltr1" id="fltr1" value="1"
<?php echo (($data['fltr1'])?(' checked="checked"'):('')) ?> class="right" /> <label for="fltr1">Abgelaufene einblenden</label></div>



<div class="control line"><label for="sort" class="left">Sortierung</label> <select name="sort" id="sort">
<?php
echo '<option value="0"'.((0 == $data['sort'])?(' selected="selected"'):('')).'>Einstelldatum</option>'."\n";
echo '<option value="1"'.((1 == $data['sort'])?(' selected="selected"'):('')).'>Gültigkeitsdatum</option>'."\n";
?>
</select></div>

<div class="control">
<button type="submit" class="right">Anwenden</button>
</div>

</form>



<h1>Neuigkeiten</h1>

<form action="index.php?section=verw_neuigkeiten<?php echo $data['fs_string'] ?>" method="post" id="form_overview">

<div class="control">
<button type="submit" name="new" value="new">Neue Neuigkeit erstellen</button>
</div>

<?php
$NeuigkeitArray = $data['neuigkeit_array'];
include('protected/inhalte/schnipsel/tabellen/sni_tabelle_verw_neuigkeiten.php')
?></form>

<?php /*===========================================================================================================*/ ?>
<?php } else if(VIEW_DETAIL == $data['view']) { ?>
<?php /*===========================================================================================================*/ ?>
<?php $Neuigkeit = $data['neuigkeit'] ?>

<form action="index.php?section=verw_neuigkeiten<?php echo $data['fs_string'] ?>" method="post"
	enctype="multipart/form-data" id="form_detail" class="dokument">

<h1>Neuigkeit <?php echo ((MODE_NEW == $data['modus'])?('erstellen'):('bearbeiten')) ?></h1>

<fieldset>

<div class="control hidden"><input type="hidden" name="neuigkeit_id" value="<?php echo $Neuigkeit->getNeuigkeitID() ?>" /></div>

<div class="control"><label for="athlet_id">Von</label> <select name="athlet_id" id="athlet_id">
<?php
foreach($data['mitglied_array'] as $Mitglied)
{
	echo '<option value="'.$Mitglied->getAthletID().'"';
	if($data['athlet_id'] == $Mitglied->getAthletID()) {echo ' selected="selected"';}
	echo '>'.$Mitglied.'</option>'."\n";
}
?>
</select></div>

<div class="control"><span class="input_heading">Hervorheben auf Startseite?</span>
<ul class="sidebyside">
	<li><input type="checkbox" name="wichtig" id="wichtig" value="0"
	<?php if($Neuigkeit->getWichtig()) {echo ' checked="checked"';} ?> /> <label for="ausblenden">Ja, ist wichtig.</label></li>
</ul>
</div>

	<?php
	if($Neuigkeit->getNeuigkeitID())
	{
		echo '<div class="control"><span class="input_heading">Einstelldatum aktualisieren</span>'."\n";
		echo '<ul class="sidebyside">'."\n";
		echo '<li><input type="checkbox" name="eingestellt" id="eingestellt" value="1" /> ';
		echo '<label for="eingestellt">Als "Heute eingestellt" speichern</label></li>'."\n";
		echo '</ul>'."\n";
		echo '</div>'."\n";
	}
	?> <br />

<div class="control"><label for="titel">Titel</label> <input type="text" name="titel" id="titel"
	value="<?php echo $Neuigkeit->getTitel() ?>" maxlength="100" size="100" /></div>

<br />

<div class="control"><label for="inhalt">Inhalt <span class="hint">(<a href="#hinweis_textfelder_spe">XHTML erlaubt</a>)</span></label>
<textarea name="inhalt" id="inhalt" cols="75" rows="12"><?php echo $Neuigkeit->getInhalt(GET_HSPC) ?></textarea></div>

<br />

<div class="control"><label for="gueltigbis"><span class="optional">* </span>Gültig bis</label> <input type="text"
	id="gueltigbis"
	class="w8em format-d-m-y divider-dot range-low-<?php echo $data['heute'] ?> highlight-days-67 no-transparency"
	name="gueltigbis" value="<?php echo $Neuigkeit->getGueltigBis(GET_DTDE) ?>" size="8" maxlength="10" /> (Ohne
Gültigkeitsdatum bleibt die Neuigkeit immer sichtbar.)</div>

<br />

	<?php
	$Obj = $Neuigkeit;
	include('protected/inhalte/schnipsel/allgemein/sni_control_bilder-upload.php');
	?></fieldset>

<fieldset><?php
$Obj = $Neuigkeit;
$AttachType = ATTACH_FILE1;
include('protected/inhalte/schnipsel/allgemein/sni_control_dateien-upload.php');
$AttachType = ATTACH_FILE2;
include('protected/inhalte/schnipsel/allgemein/sni_control_dateien-upload.php');
$AttachType = ATTACH_FILE3;
include('protected/inhalte/schnipsel/allgemein/sni_control_dateien-upload.php');
?></fieldset>

<fieldset>

<p>Mit <span class="optional">* </span>markierte Eingabefelder sind optional.</p>

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