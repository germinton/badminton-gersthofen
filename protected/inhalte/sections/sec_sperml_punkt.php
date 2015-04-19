<?php /*===========================================================================================================*/ ?>
<?php if(VIEW_LIST == $data['view']) { ?>
<?php /*===========================================================================================================*/ ?>

<form action="index.php" method="get" id="form_filter_sort" class="dokument">

<div class="control"><input type="hidden" name="section" value="sperml_punkt" /></div>

<div class="control line"><label for="fltr1" class="left">Saison</label> <select name="fltr1" id="fltr1">
<?php
foreach($data['fltr1_array'] as $Saison)
{
	echo '<option value="'.$Saison->getSaisonID().'"';
	echo (($Saison->getSaisonID() == $data['fltr1'])?' selected="selected"':'').'>'.$Saison.'</option>'."\n";
}
?>
</select></div>

<div class="control line"><label for="fltr2" class="left">Mannschaft</label> <select name="fltr2" id="fltr2">
<?php
echo '<option value="0"'.((!$data['fltr2'])?' selected="selected"':'').'>Alle Mannschaften</option>'."\n";
foreach($data['fltr2_array_2'] as $i => $Mannschaft)
{
	echo '<option value="'.$data['fltr2_array_1'][$i].'"';
	echo ((!strcmp($data['fltr2_array_1'][$i], $data['fltr2']))?' selected="selected"':'').'>'.$Mannschaft.'</option>'."\n";
}
?>
</select></div>

<div class="control line"><label for="sort" class="left">Sortierung</label> <select name="sort" id="sort">
<?php
echo '<option value="0"'.((0 == $data['sort'])?(' selected="selected"'):('')).'>Datum</option>'."\n";
echo '<option value="1"'.((1 == $data['sort'])?(' selected="selected"'):('')).'>Mannschaft</option>'."\n";
?>
</select></div>

<div class="control">
<button type="submit" class="right">Anwenden</button>
</div>

</form>

<h1>Punktspiel-<br />
ergebnismeldungen</h1>

<?php
$SpErMl_X_Array = $data['sperml_x_array'];
include('protected/inhalte/schnipsel/tabellen/sni_tabelle_sperml_punkt.php');
?>

<?php /*===========================================================================================================*/ ?>
<?php } else if(VIEW_DETAIL == $data['view']) { ?>
<?php /*===========================================================================================================*/ ?>
<?php $SpErMl_X = $data['sperml_x'] ?>

<div class="textbox"><a href="javascript:history.back(-1)">Zurückblättern</a> oder <a
	href="index.php?section=sperml_punkt<?php echo (($s = $data['fs_string'])?($s):('')) ?>">zur Übersicht</a><br />
&nbsp;</div>

<?php echo $SpErMl_X->getXHTML() ?>

<?php /*===========================================================================================================*/ ?>
<?php } ?>
<?php /*===========================================================================================================*/ ?>