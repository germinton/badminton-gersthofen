<?php /*===========================================================================================================*/ ?>
<?php if(VIEW_LIST == $data['view']) { ?>
<?php /*===========================================================================================================*/ ?>

<form action="index.php" method="get" id="form_filter_sort" class="dokument">

<div class="control"><input type="hidden" name="section" value="archiv" /></div>

<div class="control line"><label for="fltr1" class="left">Saison</label> <select name="fltr1" id="fltr1">
<?php
echo '<option value="0"'.((!$data['fltr1'])?' selected="selected"':'').'>Alle Saisons</option>'."\n";
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
echo '<option value="0"';
echo ((0 == $data['sort'])?(' selected="selected"'):('')).'>Saison</option>'."\n";
echo '<option value="1"';
echo ((1 == $data['sort'])?(' selected="selected"'):('')).'>Altersklasse</option>'."\n";
?>
</select></div>

<div class="control">
<button type="submit" class="right">Anwenden</button>
</div>

</form>

<h1>Punktspielarchiv</h1>

<?php
/*
$MannschaftArray = $data['mannschaft_array'];
include('protected/inhalte/schnipsel/tabellen/sni_tabelle_archiv_fancy.php');
*/
?>

<?php
$MannschaftArray = $data['mannschaft_array'];
include('protected/inhalte/schnipsel/tabellen/sni_tabelle_archiv.php');
?>

<?php /*===========================================================================================================*/ ?>
<?php } else if(VIEW_DETAIL == $data['view']) { ?>
<?php /*===========================================================================================================*/ ?>
<?php $Mannschaft = $data['mannschaft'] ?>

<div class="textbox"><a href="javascript:history.back(-1)">Zurückblättern</a> oder <a
	href="index.php?section=archiv<?php echo (($s = $data['fs_string'])?($s):('')) ?>">zur Übersicht</a><br />
&nbsp;</div>

<?php echo sni_ProfilMannschaftArchiv($Mannschaft->getMannschaftID()) ?>

<?php /*===========================================================================================================*/ ?>
<?php } ?>
<?php /*===========================================================================================================*/ ?>
