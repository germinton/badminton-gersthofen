<?php /*===========================================================================================================*/ ?>
<?php if(VIEW_LIST == $data['view']) { ?>
<?php /*===========================================================================================================*/ ?>

<form action="index.php" method="get" id="form_filter_sort" class="dokument">

<div class="control"><input type="hidden" name="section" value="verw_ligenklassen" /></div>

<div class="control line"><label for="sort" class="left">Sortierung</label> <select name="sort" id="sort">
<?php
echo '<option value="0"';
echo ((0 == $data['sort'])?(' selected="selected"'):('')).'>AKlaGruppe</option>'."\n";
echo '<option value="1"';
echo ((1 == $data['sort'])?(' selected="selected"'):('')).'>Bezeichnung</option>'."\n";
?>
</select></div>

<div class="control">
<button type="submit" class="right">Anwenden</button>
</div>

</form>



<h1>LigenKlassen</h1>

<form action="index.php?section=verw_ligenklassen<?php echo $data['fs_string'] ?>" method="post" id="form_overview">

<div class="control">
<button type="submit" name="new" value="new">Neue LigaKlasse erstellen</button>
</div>

<?php
$LigaKlasseArray = $data['ligaklasse_array'];
include('protected/inhalte/schnipsel/tabellen/sni_tabelle_verw_ligenklassen.php')
?></form>

<h2>Nicht löschbare Einträge</h2>
<p>Datensätze, bei denen das 'Löschen-Symbol' nicht angezeigt wird, sind nicht löschbar. Würde dieser Datensatz gelöscht
werden, so würden abhängige Datensätze in anderen Tabellen automatisch mit gelöscht. Beispelsweise würden alle
Mannschaften, die der betreffenden LigaKlasse zugeordnet sind, gelöscht werden.</p>

<?php /*===========================================================================================================*/ ?>
<?php } else if(VIEW_DETAIL == $data['view']) { ?>
<?php /*===========================================================================================================*/ ?>
<?php $LigaKlasse = $data['ligaklasse'] ?>

<form action="index.php?section=verw_ligenklassen<?php echo $data['fs_string'] ?>" method="post"
	enctype="multipart/form-data" id="form_detail" class="dokument">

<h1>LigaKlasse <?php echo ((MODE_NEW == $data['modus'])?('erstellen'):('bearbeiten')) ?></h1>

<fieldset>

<div class="control hidden"><input type="hidden" name="ligaklasse_id" value="<?php echo $LigaKlasse->getLigaKlasseID() ?>" /></div>

<div class="control"><label for="bezeichnung"><span class="mandatory">* </span>Bezeichnung</label> </label> <input type="text" name="bezeichnung" id="bezeichnung"
	value="<?php echo $LigaKlasse->getBezeichnung() ?>" maxlength="50" size="50" /></div>
	
<div class="control"><label for="aklagruppe"><span class="mandatory">* </span>AKlaGruppe</label> <select name="aklagruppe" id="aklagruppe">
<?php
foreach($GLOBALS['Enum']['AKlaGruppe'] as $AKlaGruppe)
{
	echo '<option value="'.$AKlaGruppe.'"';
	echo (($AKlaGruppe == $LigaKlasse->getAKlaGruppe())?' selected="selected"':'').'>'.C2S_AKlaGruppe($AKlaGruppe).'</option>'."\n";
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

<?php /*===========================================================================================================*/ ?>
<?php } ?>
<?php /*===========================================================================================================*/ ?>