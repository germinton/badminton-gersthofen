<?php /*===========================================================================================================*/ ?>
<?php if(VIEW_LIST == $data['view']) { ?>
<?php /*===========================================================================================================*/ ?>

<form action="index.php" method="get" id="form_filter_sort" class="dokument">

<div class="control"><input type="hidden" name="section" value="verw_mannschaften" /></div>

<div class="control line"><label for="fltr1" class="left">Saison</label> <select name="fltr1" id="fltr1">
<?php
echo '<option value="0"'.((!$data['fltr1'])?' selected="selected"':'').'></option>'."\n";
foreach($data['fltr1_array'] as $Saison)
{
	echo '<option value="'.$Saison->getSaisonID().'"';
	echo (($Saison->getSaisonID() == $data['fltr1'])?' selected="selected"':'').'>'.$Saison.'</option>'."\n";
}
?>
</select></div>

<div class="control line"><label for="fltr2" class="left">Altersklasse</label> <select name="fltr2" id="fltr2">
<?php
echo '<option value="0"'.((0 == $data['fltr2'])?' selected="selected"':'').'></option>'."\n";
foreach($GLOBALS['Enum']['AKlaGruppe'] as $AKlaGruppe)
{
	echo '<option value="'.$AKlaGruppe.'"';
	echo (($AKlaGruppe == $data['fltr2'])?' selected="selected"':'').'>'.C2S_AKlaGruppe($AKlaGruppe).'</option>'."\n";
}
?>
</select></div>

<div class="control line"><label for="sort" class="left">Sortierung</label> <select name="sort" id="sort">
<?php
echo '<option value="0"';
echo ((0 == $data['sort'])?(' selected="selected"'):('')).'>Saison</option>'."\n";
echo '<option value="1"';
echo ((1 == $data['sort'])?(' selected="selected"'):('')).'>Altersklasse</option>'."\n";
echo '<option value="2"';
echo ((2 == $data['sort'])?(' selected="selected"'):('')).'>Nummer</option>'."\n";
?>
</select></div>

<div class="control">
<button type="submit" class="right">Anwenden</button>
</div>

</form>

<h1>Mannschaften</h1>

<form action="index.php?section=verw_mannschaften<?php echo $data['fs_string'] ?>" method="post" id="form_overview">

<div class="control">
<button type="submit" name="new" value="new">Neue Mannschaft erstellen</button>
</div>

<?php
$MannschaftArray = $data['mannschaft_array'];
include('protected/inhalte/schnipsel/tabellen/sni_tabelle_verw_mannschaften.php')
?></form>

<h2>Nicht löschbare Einträge</h2>
<p>Datensätze, bei denen das 'Löschen-Symbol' nicht angezeigt wird, sind nicht löschbar. Würde dieser Datensatz gelöscht
werden, so würden abhängige Datensätze in anderen Tabellen automatisch mit gelöscht. Beispelsweise würden alle
Spielergebnismeldungen dieser Mannschaft gelöscht werden.</p>

<?php /*===========================================================================================================*/ ?>
<?php } else if(VIEW_DETAIL == $data['view']) { ?>
<?php /*===========================================================================================================*/ ?>
<?php $Mannschaft = $data['mannschaft'] ?>

<form action="index.php?section=verw_mannschaften<?php echo $data['fs_string'] ?>" method="post"
	enctype="multipart/form-data" id="form_detail" class="dokument">

<h1>Mannschaft <?php echo ((MODE_NEW == $data['modus'])?('erstellen'):('bearbeiten')) ?></h1>

<fieldset>

<div class="control hidden"><input type="hidden" name="mannschaft_id"
	value="<?php echo $Mannschaft->getMannschaftID() ?>" /></div>

<div class="control"><label for="saison_id"><span class="mandatory">* </span>Saison</label> <?php
if($Mannschaft->isDeletable())
{
	echo '<select name="saison_id" id="saison_id">'."\n";
	foreach($data['saison_array'] as $Saison)
	{
		echo '<option value="'.($ID = $Saison->getSaisonID()).'"';
		if(MODE_NEW == $data['modus']) {echo (($data['saison_id'] == $ID)?(' selected="selected"'):(''));}
		else {echo (($Mannschaft->getSaisonID() == $ID)?(' selected="selected"'):(''));}
		echo '>'.$Saison.'</option>'."\n";
	}
	echo '</select>'."\n";
}
else
{
	echo '<input type="hidden" name="saison_id" id="saison_id" value="'.$Mannschaft->getSaisonID().'" />'."\n";
	echo $Mannschaft->getSaisonID(GET_OFID);
}
?></div>

<br />

<div class="control"><label for="aklagruppe"><span class="mandatory">* </span>Altersklasse</label> <?php
if($Mannschaft->isDeletable())
{
	echo '<select name="aklagruppe" id="aklagruppe">'."\n";
	foreach($GLOBALS['Enum']['AKlaGruppe'] as $AKlaGruppe) {
		echo '<option value="'.$AKlaGruppe.'"';
		echo (($Mannschaft->getAKlaGruppe() == $AKlaGruppe)?(' selected="selected"'):(''));
		echo '>'.C2S_AKlaGruppe($AKlaGruppe).'</option>'."\n";
	}
	echo '</select>'."\n";
}
else
{
	echo '<input type="hidden" name="aklagruppe" id="aklagruppe" value="'.$Mannschaft->getAKlaGruppe().'" />'."\n";
	echo $Mannschaft->getAKlaGruppe(GET_C2SC);
}
?></div>

<div class="control"><label for="nr"><span class="mandatory">* </span>Nummer</label> <?php
if($Mannschaft->isDeletable())
{
	echo '<select name="nr" id="nr" >'."\n";
	for($i=1; $i<=MAX_MANNSCHAFTEN; $i++) {
		echo '<option value="'.$i.'"';
		echo (($Mannschaft->getNr() == $i)?(' selected="selected"'):(''));
		echo '>'.$i.'</option>'."\n";
	}
	echo '</select>'."\n";
}
else
{
	echo '<input type="hidden" name="nr" id="nr" value="'.$Mannschaft->getNr().'" />'."\n";
	echo $Mannschaft->getNr();
}
?></div>

<br />

<div class="control"><label for="ligaklasse_id"><span class="mandatory">* </span>Liga/Klasse</label> <?php
if($Mannschaft->isDeletable())
{
	echo '<select name="ligaklasse_id" id="ligaklasse_id" >'."\n";
	foreach($data['ligaklasse_array'] as $LigaKlasse)
	{
		echo '<option value="'.($ID = $LigaKlasse->getLigaKlasseID()).'"';
		echo (($Mannschaft->getLigaKlasseID() == $ID)?(' selected="selected"'):(''));
		echo '>'.$LigaKlasse.'</option>'."\n";
	}
	echo '</select>'."\n";
}
else
{
	echo '<input type="hidden" name="ligaklasse_id" id="ligaklasse_id" value="'.$Mannschaft->getLigaKlasseID().'" />'."\n";
	echo $Mannschaft->getLigaKlasseID(GET_OFID);
}
?></div>

<br />

<div class="control"><label for="platzierung1">Tabellenplatz nach Hinrunde</label><select name="platzierung1"
	id="platzierung1">
	<?php
	echo '<option value="0"'.((0 == $p1 = $Mannschaft->getPlatzierung1())?' selected="selected"':'').'></option>'."\n";
	for($i=1; $i<=MAX_PLATZ_MANN; $i++) {
		echo '<option value="'.$i.'"'.(($p1 == $i)?' selected="selected"':'').'>'.$i.'</option>'."\n";
	} ?>
</select></div>

<div class="control"><label for="platzierung2">Tabellenplatz nach Rückrunde</label><select name="platzierung2"
	id="platzierung2">
	<?php
	echo '<option value="0"'.((0 == $p2 = $Mannschaft->getPlatzierung2())?' selected="selected"':'').'></option>'."\n";
	for($i=1; $i<=MAX_PLATZ_MANN; $i++) {
		echo '<option value="'.$i.'"'.(($p2 == $i)?' selected="selected"':'').'>'.$i.'</option>'."\n";
	} ?>
</select></div>

<br />

<div class="control"><label for="verein_id">Spielgemeinschaft mit Verein</label> <?php
if($Mannschaft->isDeletable())
{
	echo '<select name="verein_id" id="verein_id" >'."\n";
	echo '<option value="0" selected="selected"></option>'."\n";
	foreach($data['verein_array'] as $Verein) {
		echo '<option value="'.($ID = $Verein->getVereinID()).'"';
		echo (($Mannschaft->getVereinID() == $ID)?(' selected="selected"'):(''));
		echo '>'.$Verein.'</option>'."\n";
	}
	echo '</select>'."\n";
}
else
{
	echo '<input type="hidden" name="verein_id" id="verein_id" value="'.$Mannschaft->getVereinID().'" />'."\n";
	echo ((is_null($Mannschaft->getVereinID()))?('- Keine -'):($Mannschaft->getVereinID(GET_OFID)));
}
?></div>

<br />

<?php
$Obj = $Mannschaft;
$Height = 300;
include('protected/inhalte/schnipsel/allgemein/sni_control_bilder-upload.php');
?> <br />

<div class="control"><label for="bildunterschrift">Bildunterschrift <span class="hint">(<a
	href="#hinweis_textfelder_spe">XHTML erlaubt</a>)</span></label> <textarea name="bildunterschrift"
	id="bildunterschrift" cols="75" rows="12"><?php echo $Mannschaft->getBildunterschrift(GET_HSPC) ?></textarea></div>

<br />

<div class="control"><label for="ergdienst">Link auf Ergebnisdienst</label> <input type="text" name="ergdienst"
	id="ergdienst" value="<?php echo $Mannschaft->getErgDienst() ?>" maxlength="255" size="100" /></div>

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
<?php include('protected/inhalte/schnipsel/allgemein/sni_hinweis_bilder-upload.php') ?>

<?php /*===========================================================================================================*/ ?>
<?php } ?>
<?php /*===========================================================================================================*/ ?>