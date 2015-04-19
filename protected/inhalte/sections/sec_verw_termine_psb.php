<?php /*===========================================================================================================*/ ?>
<?php if(VIEW_LIST == $data['view']) { ?>
<?php /*===========================================================================================================*/ ?>

<form action="index.php" method="get" id="form_filter_sort" class="dokument">

<div class="control hidden"><input type="hidden" name="section" value="verw_termine_psb" /></div>

<div class="control line"><label for="fltr1" class="left">Mannschaft</label> <select name="fltr1" id="fltr1">
<?php
echo '<option value="0"'.((!$data['fltr1'])?' selected="selected"':'').'>Alle Mannschaften</option>'."\n";
foreach($data['fltr1_array'] as $Mannschaft)
{
	echo '<option value="'.$Mannschaft->getMannschaftID().'"';
	echo (($Mannschaft->getMannschaftID() == $data['fltr1'])?' selected="selected"':'').'>'.$Mannschaft.'</option>'."\n";
}
?>
</select></div>

<div class="control line"><label for="sort" class="left">Sortierung</label> <select name="sort" id="sort">
<?php
echo '<option value="0"'.((0 == $data['sort'])?(' selected="selected"'):('')).'>Tag und Zeit</option>'."\n";
echo '<option value="1"'.((1 == $data['sort'])?(' selected="selected"'):('')).'>Mannschaft</option>'."\n";
?>
</select></div>

<div class="control">
<button type="submit" class="right">Anwenden</button>
</div>

</form>



<h1>Punktspieltermine <?php echo new CSaison(CDBConnection::getInstance()->getSaisonID()) ?></h1>

<form action="index.php?section=verw_termine_psb<?php echo $data['fs_string'] ?>" method="post" id="form_overview">

<div class="control">
<button type="submit" name="new" value="new">Neuen Termin erstellen</button>
</div>

<?php
$TerminPSBArray = $data['termin_psb_array'];
include('protected/inhalte/schnipsel/tabellen/sni_tabelle_verw_termine_psb.php')
?></form>

<h2>Hinweise</h2>
<h3>Anzeige von Terminen</h3>
<p>Auf der <a href="index.php?section=termine_psb">Punktspielterminseite</a> werden nur Termine für Punktspielbegegungen
angezeigt, die in die Saison <?php echo new CSaison(CDBConnection::getInstance()->getSaisonID()) ?> fallen.</p>

<h3>Automatische Löschung</h3>
<p>Termine für Punktspielbegegungen, die länger als <?php echo MAX_WOCHEN_TERMINEPSB ?> Wochen zurückliegen, werden
automatisch gelöscht.</p>

<?php /*===========================================================================================================*/ ?>
<?php } else if(VIEW_DETAIL == $data['view']) { ?>
<?php /*===========================================================================================================*/ ?>
<?php $TerminPSB = $data['psb_termin'] ?>

<form action="index.php?section=verw_termine_psb<?php echo (($s = $data['fs_string'])?($s):('')) ?>" method="post"
	id="form_detail" class="dokument">

<h1>Punktspieltermin <?php echo ((MODE_NEW == $data['modus'])?('erstellen'):('bearbeiten')) ?></h1>

<fieldset>

<div class="control hidden"><input type="hidden" name="termin_id" value="<?php echo $TerminPSB->getTerminID() ?>" /></div>

<div class="control"><label for="datum">Datum</label> <input type="text" id="datum"
	class="w8em format-d-m-y divider-dot range-low-<?php echo $data['heute'] ?> highlight-days-67 no-transparency"
	name="datum" value="<?php echo $TerminPSB->getDatum(GET_DTDE) ?>" size="8" maxlength="10" /></div>

<div class="control"><span class="input_heading">Uhrzeit</span> <select name="uhrzeit_h" id="uhrzeit_h">
<?php
$Select = ((MODE_EDIT == $data['modus'])?(substr($TerminPSB->getUhrzeit(), 0, 2)):('14'));
for($i=0; $i < 24; $i++)
{
	$Stunde = (($i<10)?('0'.$i):($i));
	echo '<option value="'.$Stunde.'"';
	if($Stunde == $Select) {echo ' selected="selected"';}
	echo '>'.$Stunde.'</option>'."\n";
}
?>
</select> <select name="uhrzeit_m" id="uhrzeit_m">
<?php
$Select = ((MODE_EDIT == $data['modus'])?(substr($TerminPSB->getUhrzeit(), 3, 2)):('00'));
for($i=0; $i < 60; $i++)
{
	$Minute = (($i<10)?('0'.$i):($i));
	echo '<option value="'.$Minute.'"';
	if($Minute == $Select) {echo ' selected="selected"';}
	echo '>'.$Minute.'</option>'."\n";
}
?>
</select></div>

<div class="control"><label for="austragungsort_id">Austragungsort</label> <select name="austragungsort_id"
	id="austragungsort_id">
	<?php
	foreach($data['austragungsort_array'] as $Austragungsort)
	{
		echo '<option value="'.($ID = $Austragungsort->getAustragungsortID()).'"';
		echo (($ID == $TerminPSB->getAustragungsortID())?(' selected="selected"'):('')).'>'.$Austragungsort.'</option>'."\n";
	}
	?>
</select></div>

<br />

<div class="control"><label for="seite">Seite</label> <select name="seite" id="seite">
<?php
foreach($GLOBALS['Enum']['Seite'] as $Seite)
{
	echo '<option value="'.$Seite.'"';
	echo (($Seite == $TerminPSB->getSeite())?(' selected="selected"'):('')).'>'.C2S_Seite($Seite).'</option>'."\n";
}
?>
</select></div>

<div class="control"><label for="mannschaft_id">Mannschaft</label> <select name="mannschaft_id" id="mannschaft_id">
<?php
foreach($data['mannschaft_array'] as $Mannschaft)
{
	echo '<option value="'.($ID = $Mannschaft->getMannschaftID()).'"';
	echo (($ID == $TerminPSB->getMannschaftID())?(' selected="selected"'):('')).'>'.$Mannschaft.'</option>'."\n";
}
?>
</select></div>

<div class="control"><span class="input_heading">Gegner</span> <select name="verein_id" id="verein_id">
<?php
foreach($data['verein_array'] as $Verein)
{
	echo '<option value="'.($ID = $Verein->getVereinID()).'"';
	echo (($ID == $TerminPSB->getVereinID())?(' selected="selected"'):('')).'>'.$Verein.'</option>'."\n";
}
?>
</select><select name="mannschaftnr" id="mannschaftnr">
<?php
for($i=1; $i <= MAX_MANNSCHAFTEN; $i++) {
	echo '<option value="'.$i.'"'.(($i == $TerminPSB->getMannschaftNr())?(' selected="selected"'):('')).'>'.$i.'</option>'."\n";
}
?>
</select></div>

<div class="control"><label for="freitext">Zusatzinfos (z.B. Treffpunkt)</label> <input type="text" name="freitext" id="freitext"
	value="<?php echo $TerminPSB->getFreitext() ?>" maxlength="100" size="100" /></div>

</fieldset>

<fieldset>

<p>Mit <span class="optional">* </span>markierte Eingabefelder sind optional.</p>

<p class="formularbuttons">
<button type="submit" name="save" value="save">Speichern</button>
<button type="submit" name="cancel" value="cancel">Abbrechen</button>
</p>

</fieldset>

</form>

<?php include('protected/inhalte/schnipsel/allgemein/sni_hinweis_textfelder_gew.php') ?>

<?php /*===========================================================================================================*/ ?>
<?php } ?>
<?php /*===========================================================================================================*/ ?>