<?php /*===========================================================================================================*/ ?>
<?php if(VIEW_LIST == $data['view']) { ?>
<?php /*===========================================================================================================*/ ?>

<form action="index.php" method="get" id="form_filter_sort" class="dokument">

<div class="control hidden"><input type="hidden" name="section" value="verw_termine_allg" /></div>

<div class="control line"><input type="checkbox" name="fltr1" id="fltr1" value="1"
<?php echo (($data['fltr1'])?(' checked="checked"'):('')) ?> class="right" /> <label for="fltr1">Vergangene einblenden</label></div>



<div class="control line"><label for="sort" class="left">Sortierung</label> <select name="sort" id="sort">
<?php
echo '<option value="0"'.((0 == $data['sort'])?(' selected="selected"'):('')).'>Datum</option>'."\n";
?>
</select></div>

<div class="control">
<button type="submit" class="right">Anwenden</button>
</div>

</form>



<h1>Allgemeine Termine</h1>

<form action="index.php?section=verw_termine_allg<?php echo $data['fs_string'] ?>" method="post" id="form_overview">

<div class="control">
<button type="submit" name="new" value="new">Neuen Termin erstellen</button>
</div>

<?php
$TerminAllgArray = $data['allg_termin_array'];
include('protected/inhalte/schnipsel/tabellen/sni_tabelle_verw_termine_allg.php')
?></form>

<h2>Hinweise</h2>
<h3>Anzeige von Terminen</h3>
<p>Auf der <a href="index.php?section=termine_allg">Terminseite</a> werden nur Termine angezeigt, die in den nächsten 13
Monaten ab Heute anstehen.</p>

<?php /*===========================================================================================================*/ ?>
<?php } else if(VIEW_DETAIL == $data['view']) { ?>
<?php /*===========================================================================================================*/ ?>
<?php $TerminAllg = $data['allg_termin'] ?>

<form action="index.php?section=verw_termine_allg<?php echo $data['fs_string'] ?>" method="post"
	enctype="multipart/form-data" id="form_detail" class="dokument">

<h1>Allgemeinen Termin <?php echo ((MODE_NEW == $data['modus'])?('erstellen'):('bearbeiten')) ?></h1>

<fieldset>

<div class="control hidden"><input type="hidden" name="termin_id" value="<?php echo $TerminAllg->getTerminID() ?>" /></div>

<div class="control"><label for="titel">Titel</label> <input type="text" name="titel" id="titel"
	value="<?php echo $TerminAllg->getTitel() ?>" maxlength="100" size="100" /></div>

<br />

<div class="control"><label for="datum">Start am</label> <input type="text" id="datum"
	class="w8em format-d-m-y divider-dot range-low-<?php echo $data['heute'] ?> highlight-days-67 no-transparency"
	name="datum" value="<?php echo $TerminAllg->getDatum(GET_DTDE) ?>" size="8" maxlength="10" /></div>

<div class="control"><label for="endedatum"><span class="optional">* </span>Dauer bis</label> <input type="text"
	id="endedatum"
	class="w8em format-d-m-y divider-dot range-low-<?php echo $data['heute'] ?> highlight-days-67 no-transparency"
	name="endedatum" value="<?php echo $TerminAllg->getEndedatum(GET_DTDE) ?>" size="8" maxlength="10" /></div>

<div class="control"><label for="ort"><span class="optional">* </span>Ort</label> <input type="text" name="ort" id="ort"
	value="<?php echo $TerminAllg->getOrt() ?>" maxlength="50" size="50" /></div>

<br />

<div class="control"><label for="athlet_id">Ansprechpartner</label> <select name="athlet_id" id="athlet_id">
<?php
foreach($data['mitglied_array'] as $Mitglied)
{
	echo '<option value="'.$Mitglied->getAthletID().'"';
	if($data['athlet_id'] == $Mitglied->getAthletID()) {echo ' selected="selected"';}
	echo '>'.$Mitglied.'</option>'."\n";
}
?>
</select></div>

<div class="control"><span class="input_heading">Zielgruppe</span>
<ul class="sidebyside">
	<li><input type="checkbox" name="fuer_a" id="fuer_a" value="a"
	<?php if($TerminAllg->getFuerA()) {echo ' checked="checked"';} ?> /> <label for="fuer_a">Aktive</label></li>
	<li><input type="checkbox" name="fuer_j" id="fuer_j" value="j"
	<?php if($TerminAllg->getFuerJ()) {echo ' checked="checked"';} ?> /> <label for="fuer_j">Jugend</label></li>
	<li><input type="checkbox" name="fuer_s" id="fuer_s" value="s"
	<?php if($TerminAllg->getFuerS()) {echo ' checked="checked"';} ?> /> <label for="fuer_s">Schüler</label></li>
</ul>
</div>

<br />

<div class="control"><label for="freitext">Freitext <span class="hint">(<a href="#hinweis_textfelder_spe">XHTML erlaubt</a>)</span></label>
<textarea name="freitext" id="freitext" cols="75" rows="12"><?php echo $TerminAllg->getFreitext(GET_HSPC) ?></textarea>
</div>

<br />

	<?php
	$Obj = $TerminAllg;
	include('protected/inhalte/schnipsel/allgemein/sni_control_bilder-upload.php');
	?></fieldset>

<fieldset><?php
$Obj = $TerminAllg;
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
<?php include('protected/inhalte/schnipsel/allgemein/sni_hinweis_dateien-upload.php') ?>

<?php /*===========================================================================================================*/ ?>
<?php } ?>
<?php /*===========================================================================================================*/ ?>