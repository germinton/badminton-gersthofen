<?php /*===========================================================================================================*/ ?>
<?php if(VIEW_LIST == $data['view']) { ?>
<?php /*===========================================================================================================*/ ?>

<form action="index.php" method="get" id="form_filter_sort" class="dokument">

<div class="control"><input type="hidden" name="section" value="verw_saisons" /></div>

<div class="control line"><label for="fltr1" class="left">Spielregel</label> <select name="fltr1" id="fltr1">
<?php
echo '<option value="0"'.((0 == $data['fltr1'])?' selected="selected"':'').'>Alle Spielregeln</option>'."\n";
foreach($GLOBALS['Enum']['Spielregel'] as $Spielregel)
{
	echo '<option value="'.$Spielregel.'"';
	echo (($Spielregel == $data['fltr1'])?' selected="selected"':'').'>'.C2S_Spielregel($Spielregel).'</option>'."\n";
}
?>
</select></div>

<div class="control line"><label for="sort" class="left">Sortierung</label> <select name="sort" id="sort">
<?php
echo '<option value="0"';
echo ((0 == $data['sort'])?(' selected="selected"'):('')).'>Beginn</option>'."\n";
echo '<option value="1"';
echo ((1 == $data['sort'])?(' selected="selected"'):('')).'>Spielregel</option>'."\n";
?>
</select></div>

<div class="control">
<button type="submit" class="right">Anwenden</button>
</div>

</form>



<h1>Saisons</h1>

<form action="index.php?section=verw_saisons<?php echo $data['fs_string'] ?>" method="post" id="form_overview">

<div class="control">
<button type="submit" name="new" value="new">Neue Saison erstellen</button>
</div>

<?php
$SaisonArray = $data['saison_array'];
include('protected/inhalte/schnipsel/tabellen/sni_tabelle_verw_saisons.php')
?></form>

<h2>Nicht löschbare Einträge</h2>
<p>Datensätze, bei denen das 'Löschen-Symbol' nicht angezeigt wird, sind nicht löschbar. Würde dieser Datensatz gelöscht
werden, so würden abhängige Datensätze in anderen Tabellen automatisch mit gelöscht. Beispelsweise würden alle
Mannschaften dieser Saison gelöscht werden.</p>

<?php /*===========================================================================================================*/ ?>
<?php } else if(VIEW_DETAIL == $data['view']) { ?>
<?php /*===========================================================================================================*/ ?>
<?php $Saison = $data['saison'] ?>

<form action="index.php?section=verw_saisons<?php echo $data['fs_string'] ?>" method="post" id="form_detail"
	class="dokument">

<h1>Saison <?php echo ((MODE_NEW == $data['modus'])?('erstellen'):('bearbeiten')) ?></h1>

<fieldset>

<div class="control hidden"><input type="hidden" name="saison_id" value="<?php echo $Saison->getSaisonID() ?>" /></div>

<div class="control"><label for="beginn">Beginn</label> <?php
if($Saison->isDeletable())
{
	echo '<input type="text" id="beginn" ';
	echo 'class="w8em format-d-m-y divider-dot highlight-days-67 no-transparency" ';
	echo 'name="beginn" value="'.$Saison->getBeginn(GET_DTDE).'" size="8" maxlength="10" />'.PHP_EOL;
}
else
{
	echo '<input type="hidden" name="beginn" id="beginn" value="'.$Saison->getBeginn(GET_DTDE).'" />'.PHP_EOL;
	echo $Saison->getBeginn(GET_DTDE);
}
?></div>

<div class="control"><label for="ende">Ende</label> <?php
if($Saison->isDeletable())
{
	echo '<input type="text" id="ende" ';
	echo 'class="w8em format-d-m-y divider-dot highlight-days-67 no-transparency" ';
	echo 'name="ende" value="'.$Saison->getEnde(GET_DTDE).'" size="8" maxlength="10" />'.PHP_EOL;
}
else
{
	echo '<input type="hidden" name="ende" id="ende" value="'.$Saison->getEnde(GET_DTDE).'" />'.PHP_EOL;
	echo $Saison->getEnde(GET_DTDE);
}
?></div>

<div class="control"><label for="aklagruppe">Spielregel</label> <?php
if($Saison->isDeletable())
{
	echo '<select name="spielregel" id="spielregel" >'."\n";
	foreach($GLOBALS['Enum']['Spielregel'] as $Spielregel) {echo '<option value="'.$Spielregel.'">'.C2S_Spielregel($Spielregel).'</option>'."\n";}
	echo '</select>'."\n";
}
else
{
	echo '<input type="hidden" name="spielregel" id="spielregel" value="'.$Saison->getSpielregel().'" />'."\n";
	echo $Saison->getSpielregel(GET_C2SC);
}
?></div>

</fieldset>
<fieldset>

<p>Mit <span class="optional">* </span>markierte Eingabefelder sind optional.</p>

<p class="formularbuttons">
<button type="submit" name="save" value="save">Speichern</button>
<button type="submit" name="cancel" value="cancel">Abbrechen</button>
</p>

</fieldset>

</form>

<?php /*===========================================================================================================*/ ?>
<?php } ?>
<?php /*===========================================================================================================*/ ?>